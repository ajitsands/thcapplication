/**
 * THC Facility Management - Quotation Module
 * Client-Side Application Script
 */

(function () {
    "use strict";

    // Helper utilities
    const $ = s => document.querySelector(s);
    const $$ = s => document.querySelectorAll(s);
    const H = s => String(s ?? "").replace(/[&<>"]/g, c => ({ "&": "&amp;", "<": "&lt;", ">": "&gt;", '"': "&quot;" }[c]));
    const M = (a, f) => (a || []).map(f).join("");
    const f3 = x => (+x || 0).toLocaleString("en", { minimumFractionDigits: 3, maximumFractionDigits: 3 });

    // Ladda Progress Button Helper
    function createLadda(btn) {
        if (!btn) return null;
        if (typeof Ladda !== "undefined") {
            try {
                return Ladda.create(btn);
            } catch (e) {
                console.warn("Ladda create error:", e);
            }
        }
        return null;
    }

    // Standard system date helper: "12-11-2026" (or "12-11-2026 14:30")
    function dmy(s, withTime = false) {
        if (!s) return "—";
        const str = String(s).trim();
        if (!str || str === "0000-00-00") return "—";
        const clean = str.replace("T", " ");
        const parts = clean.split(" ");
        const datePart = parts[0];
        const timePart = parts[1] || "";
        const dp = datePart.split("-");
        if (dp.length === 3 && dp[0].length === 4) {
            const dmyDate = `${dp[2]}-${dp[1]}-${dp[0]}`;
            if (withTime && timePart) {
                const tp = timePart.split(":");
                return `${dmyDate} ${tp[0]}:${tp[1]}`;
            }
            return dmyDate;
        }
        const dpSlash = datePart.split("/");
        if (dpSlash.length === 3 && dpSlash[0].length === 4) {
            const dmyDate = `${dpSlash[2]}-${dpSlash[1]}-${dpSlash[0]}`;
            if (withTime && timePart) {
                const tp = timePart.split(":");
                return `${dmyDate} ${tp[0]}:${tp[1]}`;
            }
            return dmyDate;
        }
        return str;
    }

    // Date formatting helper for formal quotation sheet: "27th October 2026"
    function fd(s) {
        if (!s) return "—";
        const clean = String(s).trim().replace("T", " ").split(" ")[0];
        const parts = clean.split("-");
        if (parts.length < 3) return s;
        const d = new Date(+parts[0], +parts[1] - 1, +parts[2]);
        if (isNaN(d.getTime())) return s;
        const n = d.getDate();
        const o = (n % 100 > 10 && n % 100 < 14) || n % 10 > 3 ? "th" : ["th", "st", "nd", "rd"][n % 10] || "th";
        const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        return n + o + " " + months[d.getMonth()] + " " + d.getFullYear();
    }

    // Amount calculation helpers
    const itemTotal = it => (+it.quantity || +it[1] || 0) * (+it.unit_price || +it[3] || 0);
    const amt = q => {
        if (q && q.merge_items && +q.merged_lump_sum_price > 0) {
            return +q.merged_lump_sum_price;
        }
        return (q && q.items ? q.items : []).reduce((t, r) => t + itemTotal(r), 0);
    };
    const discAmount = q => {
        const sub = amt(q);
        const dVal = q.discount_value !== undefined ? +q.discount_value : (q.discount !== undefined ? +q.discount : 0);
        const dType = q.discount_type || "amount";
        if (dVal > 0) {
            if (dType === "percent") {
                return Math.min(sub, (sub * dVal) / 100);
            }
            return Math.min(sub, dVal);
        }
        if (q.discount_amount !== undefined && +q.discount_amount > 0) {
            return Math.min(sub, +q.discount_amount);
        }
        return 0;
    };
    const netAmt = q => Math.max(0, amt(q) - discAmount(q));
    const tot = q => {
        const net = netAmt(q);
        const rate = q.vat_rate !== undefined ? +q.vat_rate : (q.vat !== undefined ? +q.vat : 10);
        return net * (1 + rate / 100);
    };
    const SENT = ["Pending", "Approved", "Not approved", "Completed", "Expired"];
    const sm = (a, f) => a.reduce((t, x) => t + f(x), 0);

    // Expired helper: Pending > validity_days (default 30 days)
    const exp = q => {
        const st = q.status || q.st;
        if (st === "Expired") return true;
        if (st !== "Pending") return false;
        const qDate = new Date(q.quotation_date || q.date);
        const diffDays = (new Date() - qDate) / (1000 * 60 * 60 * 24);
        const maxDays = q.validity_days !== undefined ? +q.validity_days : 30;
        return diffDays > maxDays;
    };

    // Status tag renderer
    const tg = q => {
        const status = q.status || q.st || "Draft";
        const cleanClass = status.replace(/\s+/g, "");
        if (status === "Completed") {
            return `<span class="tag tag-completed" style="background:#d1fae5;color:#065f46;border:1px solid #a7f3d0;font-weight:600;"><i class="icon-checkmark3 mr-1"></i> Completed</span>`;
        }
        if (status === "Expired") {
            return `<span class="tag tag-expired" style="background:#ffedd5;color:#9a3412;border:1px solid #fed7aa;font-weight:600;"><i class="icon-hour-glass2 mr-1"></i> Expired</span>`;
        }
        const isExp = exp(q);
        return `<span class="tag ${cleanClass}">${H(status)}${isExp ? " · expired" : ""}</span>`;
    };

    // Label helper: "Original", "R1", "V1", "V1/R1"
    const lab = q => {
        const vn = q.variation_no !== undefined ? q.variation_no : (q.vn || 0);
        const rev = q.rev_no !== undefined ? q.rev_no : (q.rev || 0);
        return (vn ? "V" + vn : "") + (rev ? (vn ? "/" : "") + "R" + rev : "") || "Original";
    };

    // Administrator permission checker (strictly checks the authenticated session user)
    const isSessionAdmin = () => {
        if (!currentUserObj) return false;
        if (currentUserObj.is_admin || currentUserObj.isAdmin) return true;
        const t = (currentUserObj.title || "").toLowerCase();
        const n = (currentUserObj.name || "").toLowerCase();
        const c = (currentUserObj.code || "").toUpperCase();
        return t === "administrator" || t === "admin" || n === "administrator" || n === "admin" || n === "adminstrator" || c === "ADM" || (currentUserObj.user || "").toUpperCase() === "CGTHCFM";
    };

    // Manager permission checker (strictly checks the authenticated session user)
    const isSessionManager = () => {
        if (isSessionAdmin()) return true;
        if (!currentUserObj) return false;
        if (currentUserObj.is_manager || currentUserObj.isManager) return true;
        const t = (currentUserObj.title || "").toLowerCase();
        return /manager|director|head/i.test(t);
    };

    const mgr = u => {
        return isSessionManager();
    };

    // Formatted PDF filename
    const fnm = q => {
        const u = q.user_code || q.user || "THC";
        const seq = q.seq_no || q.seq || "DRAFT";
        const vn = q.variation_no !== undefined ? q.variation_no : (q.vn || 0);
        const rev = q.rev_no !== undefined ? q.rev_no : (q.rev || 0);
        return `${u}-QTN-${seq}${vn ? "-V" + vn : ""}${rev ? "-R" + rev : ""}`;
    };

    // State Variables with default seed data
    let USERS = {
        "ADM": ["Administrator", "Administrator"],
        "MA": ["Mohammed Ali", "Operations Manager"],
        "RM": ["Reghilal Munambeth", "Operation Coordinator"],
        "SKP": ["Satish Kumar Palanimuthu", "Operation Coordinator"]
    };
    let AMC = [
        { code: "C0179", name: "Zayani Motors", address: "P.O. Box 2399, Manama, Kingdom of Bahrain", contact: "+973 3944 1015" },
        { code: "C0178", name: "Black Fortune", address: "Bldg 12, Road 3815, Seef, Kingdom of Bahrain", contact: "+973 3728 3293" },
        { code: "C0175", name: "AK Venture", address: "Office 21, Bldg 5, Road 1702, Diplomatic Area, Manama", contact: "17212130" },
        { code: "C0173", name: "UAE Embassy", address: "Block 321, Road 2108, Juffair, Kingdom of Bahrain", contact: "17748333" },
        { code: "C0172", name: "Seef Entertainment W.L.L", address: "Block 428, Seef District, Kingdom of Bahrain", contact: "17000000" }
    ];
    let NON_AMC = [];
    let T0 = [
        "Payment to be made in advance. (Cash/Cheque)",
        "Validity for the quotation 15 Days.",
        "Prices are valid for the above item/quantity. If there is any change in item/quantity, we reserve the right to revise prices.",
        "Items cannot be returned once purchased.",
        "Completion: 2-4 days from date of confirmed order.",
        "On opening the system further, unforeseen concerns may arise for which we may need to quote separately.",
        "Scaffolding excluded. If required an additional quote will be provided."
    ];
    let LIB = [
        "Payment terms: 50% advance, balance on completion.",
        "Warranty: 12 months on workmanship from date of completion.",
        "Works to be carried out after normal working hours; night-work charges apply.",
        "Materials priced as of quotation date; subject to supplier price changes.",
        "Client to provide access, power and water at the work location.",
        "Prices exclude permits, approvals and authority fees."
    ];
    let REASONS = [
        "Price too high",
        "Budget not approved",
        "Scope changed",
        "Went with another vendor",
        "No response / expired",
        "Other"
    ];
    let UNITS = [
        "Lumpsum",
        "No.",
        "Nos",
        "Set",
        "Lot",
        "Job",
        "Pcs",
        "Trip",
        "Visit",
        "Hr",
        "Day",
        "Month",
        "m",
        "m²",
        "m³",
        "Kg",
        "Ltr",
        "Box",
        "Roll",
        "Pack",
        "Pair"
    ];
    let unitMasterList = UNITS.map((u, i) => ({ id: i + 1, name: u }));
    let Q = [];
    let CU = "MA";
    let ED = null;
    let F = { q: "", client: "", st: "", type: "", user: "", sup: false };
    let TODAY = new Date().toISOString().slice(0, 10);
    let currentUserObj = { code: "MA", name: "Mohammed Ali", title: "Operations Manager" };

    const DEFAULT_FOOTER_CONFIG = {
        phone: "+973 17 100 190",
        email: "info@thc.com.bh",
        website: "www.thc.com.bh",
        cr_no: "88982-1",
        address_line1: "Level 14, Office 1403/1404, Bldg 155, Road 1703, Block 317",
        address_line2: "YBA Kanoo Tower, Diplomatic Area, Kingdom of Bahrain",
        bg_color: "#1e2560",
        show_badges: 1,
        badges_image: "global_assets/images/a.png",
        show_page_no: 1,
        show_ref_no: 1,
        doc_number: "CINQO/THC/QTN/01/2020/REV3"
    };
    let FOOTER_CONFIG = Object.assign({}, DEFAULT_FOOTER_CONFIG);

    const DEFAULT_STAMP_SIGN_CONFIG = {
        show_stamp: 1,
        show_signature: 1,
        show_user_phone: 1,
        company_stamp_url: "uploads/quotation_signatures/default_thc_stamp.png",
        default_signature_url: "uploads/quotation_signatures/default_signature.png",
        user_signatures: {},
        user_phones: {}
    };
    let STAMP_SIGN_CONFIG = Object.assign({}, DEFAULT_STAMP_SIGN_CONFIG);

    // Toast notification
    function toast(m) {
        const t = $("#toast");
        if (!t) return;
        t.textContent = m;
        t.style.display = "block";
        clearTimeout(t.timer);
        t.timer = setTimeout(() => {
            t.style.display = "none";
        }, 2800);
    }

    function renderFormattedInline(str) {
        if (!str) return "";
        let s = H(str);
        s = s.replace(/&lt;b&gt;/gi, "<b>")
             .replace(/&lt;\/b&gt;/gi, "</b>")
             .replace(/&lt;strong&gt;/gi, "<b>")
             .replace(/&lt;\/strong&gt;/gi, "</b>")
             .replace(/&lt;u&gt;/gi, "<u>")
             .replace(/&lt;\/u&gt;/gi, "</u>")
             .replace(/&lt;i&gt;/gi, "<i>")
             .replace(/&lt;\/i&gt;/gi, "</i>");
        s = s.replace(/\*\*([^*]+)\*\*/g, "<b>$1</b>");
        s = s.replace(/__([^_]+)__/g, "<u>$1</u>");
        return s;
    }

    function formatDescHtml(desc) {
        if (!desc) return "";
        const lines = String(desc).split(/\r?\n/);
        return lines.map(line => {
            const trimmed = line.trim();
            if (/^[\u2022\-\*]\s*/.test(trimmed)) {
                const clean = trimmed.replace(/^[\u2022\-\*]\s*/, "");
                return `<div style="padding-left:14px;text-indent:-10px;margin:2px 0;">&bull;&nbsp;${renderFormattedInline(clean)}</div>`;
            }
            return `<div>${renderFormattedInline(line)}</div>`;
        }).join("");
    }

    // Official THC Facility Management Letterhead Preview Sheet
    function sheet(q) {
        const sub = amt(q);
        const discAmt = discAmount(q);
        const discVal = q.discount_value !== undefined ? +q.discount_value : (q.discount !== undefined ? +q.discount : (discAmt > 0 ? discAmt : 0));
        const discType = q.discount_type || "amount";
        const netSub = netAmt(q);
        const vatRate = q.vat_rate !== undefined ? q.vat_rate : (q.vat !== undefined ? q.vat : 10);
        const vatVal = (netSub * vatRate) / 100;
        const grandTot = netSub + vatVal;

        const uCode = q.user_code || q.user || CU;
        const uInfo = USERS[uCode] || [q.user_name || "Authorized Signatory", q.user_designation || "THC Facility Management"];
        let uName = q.user_name || (Array.isArray(uInfo) ? uInfo[0] : (uInfo.name || "Authorized Signatory"));
        if (uName === "Adminstrator") uName = "Administrator";
        const uTitle = q.user_designation || (Array.isArray(uInfo) ? uInfo[1] : (uInfo.title || "THC Facility Management"));

        const showPhone = q.include_user_phone !== undefined 
            ? (!!q.include_user_phone && !!(q.user_phone || (uInfo && (uInfo.phone || uInfo[2]))))
            : !!(q.user_phone);
        const uPhone = q.user_phone || (uInfo ? (uInfo.phone || uInfo[2] || "") : "");

        const qNo = q.quotation_no || q.no;
        const qVn = q.variation_no !== undefined ? q.variation_no : (q.vn || 0);
        const qRev = q.rev_no !== undefined ? q.rev_no : (q.rev || 0);
        const qDate = q.quotation_date || q.date || TODAY;
        const clientName = q.client_name || q.client || "—";
        const clientAddr = q.client_address || q.addr || "";
        const clientCode = q.client_code || q.code || "";
        const attn = q.attention || q.attn || "";
        const subj = q.subject || q.subj || "—";
        const terms = q.terms || T0;
        const items = q.items || [];

        const isMerged = !!(q.merge_items);
        const mergeQty = !!(q.merge_qty);
        const isBullet = !!(q.bullet_items);
        let lumpSumTot = +(q.merged_lump_sum_price || 0);
        if (lumpSumTot <= 0) lumpSumTot = sub;

        const uSigRel = (STAMP_SIGN_CONFIG.user_signatures && STAMP_SIGN_CONFIG.user_signatures[uCode]) || STAMP_SIGN_CONFIG.default_signature_url;
        const stampRel = STAMP_SIGN_CONFIG.company_stamp_url || "uploads/quotation_signatures/default_thc_stamp.png";
        const showSig = (STAMP_SIGN_CONFIG.show_signature !== 0 && STAMP_SIGN_CONFIG.show_signature !== false);
        const showStamp = (STAMP_SIGN_CONFIG.show_stamp !== 0 && STAMP_SIGN_CONFIG.show_stamp !== false);

        let formattedNo = qNo ? H(qNo) : "(assigned on issue)";
        if (qNo) {
            if (qVn > 0 && !formattedNo.includes("/V")) {
                formattedNo += "/V" + qVn;
            }
            if (qRev > 0 && !formattedNo.includes("/R")) {
                formattedNo += "/R" + qRev;
            }
        }

        return `
        <div class="sheet">
            <div class="lh" style="margin-bottom:16px;">
                <img src="global_assets/images/logo_print.png" 
                     onerror="if(!this.dataset.fb){this.dataset.fb=1;this.src='../view/global_assets/images/logo_print.png';}else if(this.dataset.fb==1){this.dataset.fb=2;this.src='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAPwAAABWCAYAAADrLPvvAAAACXBIWXMAAAsTAAALEwEAmpwYAAAVOElEQVR4nO2de5QU1Z3HP93TMxnGkTOLyCKHEIKe8f1YHYkHHyEJyyoadQ1o4gNUllV8xGjWNaub5RgkRA3xFVdd4yvqbkSXGKOussY1HsPhIIcgPlaRsKxLUDmEEByHmZ6e7v3je4uuqa5bXf2aYabv55w+PdNVdetW1f3d3/397u/+KpHL5XA4HPVBcrAr4HA4Bg4n8A5HHeEE3uGoI5zAOxx1hBN4h6OOcALvcNQRTuAdjjrCCbzDUUc4gXc46ggn8A5HHeEE3uGoI1JhPx555PUDXY8gBwAzgTnAGOAnwHWDWiOHY4jwxhvft24LFfhBohn4MnARMANo8W0bOSg1cjiGGXuCwB8AnA1cABxk2SczcNVxOIYvgyXwSeAEYD5wOv21ucPhqBGDIfDnI3v8sEE4t8NR1wyGwE8CRgGPAe8B+wHnAm2DUBeHo64YDIH/AXAL0O377efAi7hpQoejplRDwJqBiSWUlaa/sAO8BKytQl0cDkcE1RD4xcCbVD4kX1OFujgcjggqFfg2YDbVMQ22VqEMh8MRQaUCfxZywHVVoS5/qkIZDocjgkoEvgm4uloVodCudzgcVaYSgf861Z1LT1exLIfDEUK5At8CfLeaFcGFzzocNadcgf8HFANfTbJVLs/hcAQoR+CnA9+pdkUcDkftKVXg24HHqU2EntPwDkeNKUXgRwFPAqNrVBeHw1Fj4mrq8UjYj6hhXYYLKZSlZyzQav7vBnYAHwHbB69qtKHFSy6qsU6JI/AdaBjfXmS/zsqrUxVa0WikGQUEbaX2U35tyLdxCjAZmGDq4SeDhP1d4FfAMuCtGtcryIXAEmBfBrfjcQwSxQT+CmARxVNMtQIPYQ+eSSLBu4HaTL+NRFlzzkCjkNHo2tLAFmClqd8rVT5vG/BNYC4S8ig8zT8GOAndi6fN94Yq18tGM3oWTQN0Pscehk3gp6EkFdNiltOE1rRHsRVYQPUF/m/QNOEkS73azWc2cC+6rp1VOO/pwK30H/lk0aq/d9D1plBH0IHMomDdzgamAlcCS6tQp2JkA9+OOsMm8LVYm15tQR8P3A+cXMIxlwJHAadS/pA2hQT9W4HfHwTuJtw+bgMuRisLg9p1DPAE6rB+UGadHI5Y2AT+VNQw/ZqgCTXosSH7dwKXYNecSbNPtWzpDvJCUirHAfcBs8o4tgX4N6TdPTpRpt2nIo7bAfwI+RTuseyz2Ox3bxn1cjhiYRP4Fyy/LyZc4NOowQ9EPPxU4N+RY87Dc4hlkTZtLlLGTDQysF1nGE0UCnsG5c5fFrOMe4HLsa9BuA1YAawroV61oAUlNYHwkd525BvxaEWmywdEO28noOSl40wZK5H542cUamMbUHtqM/tvxO4j8s6/EbWBoIM5G7iOblPPMcB6S7nNKJo0eK1DmlKG7Z7Dx0bQK10LpgK/IC/sy5HD7HDgQPM5GAlhMaFZQGnXfw/9hR1gIfGF3eP5iG3NwI0lllcLOoA3gLdRcpPgZ0Fg/xvNvksiylwI/A54BK2yvMMccx/9Fc9sc24vdPss83/ULNFxZp8jzHFvFPn8EnUiv0HO3DDuBl43+w0b9oS89HHoRI3wF8gjvwo5314J2XcnsAkJ4iOowYRxHJpCWxnj/Bebj5+3KM/m/m2R7dOQhvuojLKrRRK1je8B/xWy3a/xRiEh7UQrKG8AtgX2/yfgH4HbUaewFSmI2WhUsxO4NnBurzNOUbydese0oI7+eN+2b6CZlDlIm4NGDmvQiHURmnZ+1nfMVPS8bwJWFzn3kGKoCPxJ6AGMBO5Ewl5s/bxnW3dgnzI7heICPw456YLcTHkmzMYi21vRcHowBd7z3bxO8alMLwnKPOAB4DTgYd/2CWhE8DD98ydsRx3AocDfoXsclvWolBmFJGoX/md6lPleSV7gPX4InAfchfIqdiPT7QGz78ISzj0kGCpZYqcge2sBcBXxk2XsRJ58Gx0xylhIf38BSBifiVmHIBuQcy6KPSUZSBxhm4tGXD9Fmn9OYPtZqJ3dbTn+OuArVCdrUhjerEiYXyeNOqqJKOYE8z0JTZUOuxwNQ0XDZ4BvI+1eKsux99QT0T2wTRm2oxdnBFlG+XP521FO/iss299C0Xh7AmdQGD+wnfyMRDsyjeahe/gz4Bp0XzeZfY5FgmMLLtoOvFytCpfBCtSuFqF7vwi9vHT5INapZgwVgf8Z5Qk7qOHtJDxacDQaQts07kWER6X9R5l18bgO2ZvnB8pfa865p2j481FwkJ93UIeXRdp8GxIQkH3+LTQL8kPzWwvS3nuytrwBvcD0l8BmpFyGJUNF4CuJ+95pjg8T+FbsAp8Czgz5PU3lGrgLDYWXIMdhK5rSWs6eI+yg2IqnA79lyU9zzTR/32r+90zEWeQFficSeltbSyJzbQeDd+2daBT4iPmuRiTmHslQEfhKfA1p7A+wCft04iGETwVto3oOtXconIcuSh8JABrIVakaVjqxz6ufgO7PCuRjgXxocYf5rEaOv9lm3zCP90w0NfYFBn4xkZ/Nge9hyVBx2lVCFrtDyJvKCWMK4fdnW0R5NWdXIkVLLsPeuV56a//4ohTC1cirfiKaBjve/P1VdN/mmv2WoU732pAyksi82UahBz1Ire95KvA9LBnWF+cjyn603YMjLb93MQiLT3LAp4lGOjIfc/2uVXQlUnxzry/RSSNN1a9OsZ5kLDJ37qTwXmxBWv/ryBbegobJC9FoYTHqKMagqc2jkXPQe0bBc3v/f5l89J/HTjRDEOdail1T3P2GNPUi8FELd2z3wBanPyjCniXBhT3vcFn3G4zI9dJAjgVdK7mu5UT6SFR7eJ9BHZvtvp2M7O3HLdsfQXPbJyC/xE1AI/D3KJ6iE42stqGRgH+KM03/TrWb8DUISWQiHOs7Jqy+Udv8FLvmYYETeHuPPsby+4DfsywJ9sr1cn7Pf9NMhl0JVWF67yY2d+/NkhFHMyKXMZZ9VViNAmJsr/96HoUwb7JsfxAJut93sgCF0U5GcQ1enoKgw/Rh1AF40XzLgFct5/FGBStNfcN8K4+Z+haLh38tooxhQ70IfKk0Y3fmjSR67r5mdCca6MvlxfrTRCOze97mzdQ+vNg4kb1yvVU7FXZhhuLvAcxYjt9Codc/yE76dxRRjkOPqPoGyyunjGHDsLZXKiAqK8wo7I6+ASVLgmwiwaXd62jL9dDnHqejCK6FlM4o9qAVVD00cGDfH5mVXr97qO9w2HACH04Gu2c/BRw0gHUpSneigXN63mNCdudATNU5hjBOJYSTJtpu/BLFbdEBo5ck47KdnNPzHreOOJbGXMVRrBNQko4daIotjCkoOcVbKErQTxOaRttB+GrEKcgX8jKFHet4tK79VQqfQStaObkFBfjYGIumBY9B3v7XUfx/0CHXjtbP23rJLWgZbZupc8bUOcx/45W1GS3RTaJZitaI8lebOnnHrqJwaXELWq67GvkipvnK80c9er+liUjs4gTeTlQ47wwUSFKr+HAv/nw3fSTIRvjhdyVSnNr7PzzxmQP5OLEXjfRVcv4zUYKKNPB5Cj3cY9E6+Sa0quzHge0zgJ+ba/gchY34LjT//j0Kk2mcjFY4Hk5h5N2F5thNaJYgLBR3Jlre2oJCoFMo0m8hmgL0JyyZi6YKbSwFzkGd33Pmt69QuNgniaYoO1DHMot8hqQo8++vkeKYh5YIvwT8Ff2nfseZc5+DZhKeJO9f8nck3jHbURryUNz4z86miG0HoFViteAElJVlt9nQR5K2XJqRubRV6DMk+fNsFzPT79OTaKi0Dl7jaULCG2QG+UYXFpcwFzW8FuzrEUBJMY4ObPO0Z1i5F6HnMhFp+iDTkEC8AuyPOo2DUae1FqVGC0svdozZZ//A58pAXbJI8IIchYQ9S38lkEIdQFjZ+5Nfkedd8zQKE614JNFoYH/gs+bj1e9rvt8Otxy/uxBHOG8W2T6vRue9DnUou4ezmUSCeT1vMjrbtTuOPoxdiQZOT//O2PIVCb2XdHQFcEHI9guQUO2gsA2NRx3Cd5FGupJCmtFQfyPS5nHaYQfqHOYjE+KikDovQR3CLPqbGZtMnbtQBhw/WRTWu8nUx/8JTj++gBJ8BKdsv2HOt4H+sztJ1PGFlb2R/CiuCY2iXjbXEJY3MmnqusX38ern/y0yjsAJvJ1ir2M6i/Ky5kYxBTWoFZhFHJ8mGjmx9/fMSG8s6oXPkGRMtouz0u/Tk6j40SZRZuDj6D8sHWd+e8RynLeC7mE0rD+CQq2aQtd3ORJim1bzcwFq4C+gQJrTkG3tcYA510OEm1qbkXa8LWRb3FV6z6El1f7U6N6qwaeRcKcC2+JEZnr7XYKEf1HM+njniv1iESfwdtYRHWDSgrRYNVlsvp8DOeP2zXZxTfcaEkCuv3YPlf5diQa+1rOBSdk/ka5My7cgLd5J/2H5aea3VwkPTpqH8sN1kc8TF9SqIKfdcpTr4DbskY3evrNR1ByoI2pFgubhrWz0O/P8LyJpN//775vn8Lob+SyCn2Dyj3dRZ+zP6nMUMjEeRSMXv4B3IdMjrOxrAmU3oxHCtagDjPsSmJJwAm9nB8UzscymMJNtuVyGGkcGeDoH9CYauLJ7Le19f/Ts8kmo9/8NMjleR+Gqu/0JfSTZJ9fFrJ719Fau5TcjoZ3v+20O+VDV4Ak60LLiO8z/65GABBN94Dv2KvPtpcAK04inI23uxdO/gobJc337eJ2P37N/ALpHvzWf99Cow8M71xR074OfYIfWjUY208mnPTsPdQSrKUyjlUHD87Cy/yLkOlPAP6PR5f3onlU1orNaXnr/tMBw4lE0vWMjiQRuNZXlLp9MPlHma8A7XYlGTu7dxBnpDXQmGkEmxP0U5tfrIP+6rVtAHvsZxmP/YWIvGstf75NE92A20mIZJBy2FN+eX8Of4PMgU+cOwqf4tqJVdfchh2VYGOx55ttLKZ1FI4IJSKg3+I7z35+NwBfJD5mX0D+hacr8/gXiLb9tRnH+DyENvBQ9l5+a7cF7MhI57S6JUbZXn26z/+soe9CDMY+NRbWEtIniL38YirxE8ew2Y5FnOCiIcZmMtI4XrntHhiT7ZndxRfdacokEOQnZ4xHnSCIhuwyk5ffNdvGXvR+Qrsxj34w6oE7kiDvZ/P0ahc97JGr8q5A5tN58lqJGfB52foI6zXsoHNpPQPPQL6NnsR4J+FPouj1zw1tPf6Lv2G40xF9jvlsJH0HEbbtNyE5/BTkG21FH+KRl/yzlKdXVKGPQItRRVk3LlyLwUdFnLUTbYCDBOJqh9ebSNMp3VowpaF56cgllJ5Fm/k/yTrGXgKd7Eg3M7nmbSX076KGhGc09x2mUN2Pszj6STM58SBN9lSyc9TTOM0jrzDd/d1PYkGcgh9bVSNPPNZ/5yAQ4F/uCpCxyyrUjbe9v4Oeia78gUO4cJMRz0b3cgDqiiwlPSz4VPZ8wTR43pZUnLw+Y8m5GGYtsmXqSlB+rsQB5/qNMnZIppffJEH1jjsLu2U6RD9Q4tIy6VDoSiTq+WNnLkAc2bD7ZzxHAr9HrpB7A3ghGouHg1WgI65EGru0lyWezn3Ba726v/GQK56pttCKn2r2ZRJL9sp+yd7aXTxOpUtfLB5NB3I38BqBpQ2+b35S7Etn8YQkpHkXafyby3gedZyDtvYC849I7x+XIuRdmMj2E/AXeC0WuQs/g16asdeSj/r6NOgV/x+nV/0bgEwrbwgfIURi8H8+je3ImMqU8muiv0LLIv/KdkLIx17Ua3YugIuxCneWLIcf56+//Lkqpw42oOb452O2NxciWm499CiRqBVql5kLUDYmz8u0qJJyji+zXjOyuK5C2WQP8HnWWbehVWCcQroEWAWt7Eg18Mb2ZMdldnu0e9YqlMA4FJc0YkcvQSB85Gs0vsdmBGrunnVaRD5H11qZ7S2C3oY5mHLKRw4afryKBPhEJ/CbCZ0BuRy8HmYiUizfteZ+lns+ijvMkU781KBLuLvpPG25D3u+N9J9Z+dBc56WEt5GVSOC76P/evO3IVJlO/+QdG8l3TFmk/dvJd5JBtiKB/xh1RkEtvhyZO9MJD/XeaeoVO/1XqQK/DrumOwk9mIWop0+i+dcbUKrj9eSdG2HsE7EtLONsKUSZEcVMEdBNPQ+96ipO55NCQ76pMfYFTU3d5Anp9N7/JZNvf6U+o90HVpAQ4zHUoL2GlEHOL8h3AttQ5+L9fzj29QfbkVfau5YzLPt1o3UKzebcTaiTtDXojaYOfmFdhZxw7ejZdqG259Xtq7597yT6bb2eAK6lMJT3El89PU71HZNGYbJRysa7d7egtwuHDf/nIaUUtu158m/MiUWpjelF9J4wG39LXrhbkFb3znEV0T3RIRHbbK+KikMT0fHMB8csZzly1DxBddfDP4VGR9meRIpjMh9zaN8f/OGxxZI7BnkPJOzdiQYyJEmUbsVnKNTUYQ3O/zzjJKkI+zuIP+lo2nJeWx38eE7DqHqEXWexOkX9FryuuIJY7Dpt1xi3/rsp1TZeiT3dkEcbsqkOIy/sNxH9auaxyM6yERatFZcZREfEnUb8+/As0k7BxSDl8i8oKCUNWiBzfGYLzbmMX0RXYn9rS5A05u20qVyWjxMtfJJsIln7dNaOIUKpAu+F/5WS9+v7REekHYKcOlHTWs1o4UPYgokoOsgHgdg4DM1vxzUbXkK2aCWvIvoIxYJfgq+HbiTLgX3bg/HyXcR/E8qPMJ1DiizrUvvSQ0M1c905hjjlzBG+ixwrDxDtPV6PBH1p4PfxqKGPRpp7csx6tCPv6yrkDPkIeJ+8ozCJTIr90CjjCNRBxOnULkaOkRXIXv8/FPFkGy69i+yz85F3Ou503EfIPr6DwAsPsiRoyvWxd643bEXcM+Y8S7D7I27HeIwbyPGH5Aieb/x8MOjGu8/DMUjKEYNyI+3WohcPnE1+vXAr8hq+i7TxUsKn8cYD15u/S00NnESCfLT5eyV5gU8hofCWlWaQXRm37FHk33T6AfKOFjv2MeBfkef9FDSimEg+0WUXEvK3gF+hUUFkAsiIwfePUWd3OZr3H4Wuby3qfHd7iz+T6+PFxs+xvuHPgoktP0DPp5i97RimJHI5Z985HPWCG9o5HHWEE3iHo45wAu9w1BFO4B2OOsIJvMNRRziBdzjqCCfwDkcd4QTe4agjnMA7HHWEE3iHo45wAu9w1BFO4B2OOsIJvMNRRziBdzjqiP8HyeYrN4mdQqMAAAAASUVORK5CYII=';}" 
                     alt="THC Facility Management" 
                     style="max-height:65px;height:auto;display:block;">
            </div>
            
            <p>
                <b>No: ${formattedNo}<br>
                Date: ${fd(qDate)}</b>
            </p>
            
            <p>
                <b>To,<br>${H(clientName)}<br>${H(clientAddr).replace(/\n/g, "<br>")}</b>
                ${clientCode ? `<br><span style="font-size:11px;color:#555;">Client code: ${H(clientCode)}</span>` : ""}
            </p>
            
            ${attn ? `<p><b>Kind Attn: ${H(attn)}</b></p>` : ""}
            
            <p>
                <b><u>Sub: ${H(subj)}</u></b><br>
                With reference to subject job we are pleased to submit our offer as under: -
            </p>
            
            <table>
                <thead>
                    <tr>
                        <th style="width:48px;text-align:center;">${isBullet ? '&bull;' : 'Sl. No.'}</th>
                        <th style="text-align:center;">Description</th>
                        <th style="width:${isMerged && mergeQty ? '120px' : '110px'};text-align:center;">Units</th>
                        <th style="width:120px;text-align:center;">Amount (BD)</th>
                    </tr>
                </thead>
                <tbody>
                    ${isMerged && items.length > 0 ? (
                        items.map((r, i) => {
                            const desc = r.description || r[0] || "";
                            const qty = r.quantity !== undefined ? r.quantity : (r[1] !== undefined ? r[1] : 1);
                            const unit = r.unit || r[2] || "Lumpsum";
                            const qtyStr = `${qty} ${H(unit)}`;
                            return `
                            <tr>
                                <td class="c" style="text-align:center;">${isBullet ? '&bull;' : (i + 1) + '.'}</td>
                                <td style="text-align:left;">${formatDescHtml(desc)}</td>
                                ${mergeQty ? (i === 0 ? `<td class="c" rowspan="${items.length}" style="vertical-align:middle;text-align:center;font-weight:600;">1 Lumpsum</td>` : '') : `<td class="c" style="text-align:center;">${qtyStr}</td>`}
                                ${i === 0 ? `<td class="c" rowspan="${items.length}" style="vertical-align:middle;text-align:center;font-weight:600;">${f3(lumpSumTot)}</td>` : ''}
                            </tr>`;
                        }).join("")
                    ) : (
                        items.map((r, i) => {
                            const desc = r.description || r[0] || "";
                            const qty = r.quantity !== undefined ? r.quantity : (r[1] !== undefined ? r[1] : 1);
                            const unit = r.unit || r[2] || "Lumpsum";
                            const lineTot = itemTotal(r);
                            const qtyStr = `${qty} ${H(unit)}`;
                            return `
                            <tr>
                                <td class="c" style="text-align:center;">${isBullet ? '&bull;' : (i + 1) + '.'}</td>
                                <td style="text-align:left;">${formatDescHtml(desc)}</td>
                                <td class="c" style="text-align:center;">${qtyStr}</td>
                                <td class="c" style="text-align:center;">${f3(lineTot)}</td>
                            </tr>`;
                        }).join("")
                    )}
                </tbody>
                <tfoot>
                    ${discAmt > 0 ? `
                        <tr>
                            <td colspan="3" class="c" style="text-align:center;"><b>Gross Amount Excluding VAT</b></td>
                            <td class="c" style="text-align:center;"><b>${f3(sub)}</b></td>
                        </tr>
                        <tr>
                            <td colspan="3" class="c" style="text-align:center;color:#b91c1c;"><b>Discount ${discType === "percent" ? `(${discVal}%)` : ""}</b></td>
                            <td class="c" style="text-align:center;color:#b91c1c;"><b>-${f3(discAmt)}</b></td>
                        </tr>
                        <tr>
                            <td colspan="3" class="c" style="text-align:center;"><b>Net Amount Excluding VAT</b></td>
                            <td class="c" style="text-align:center;"><b>${f3(netSub)}</b></td>
                        </tr>
                    ` : `
                        <tr>
                            <td colspan="3" class="c" style="text-align:center;"><b>Amount Excluding VAT</b></td>
                            <td class="c" style="text-align:center;"><b>${f3(sub)}</b></td>
                        </tr>
                    `}
                    <tr>
                        <td colspan="3" class="c" style="text-align:center;"><b>VAT ${vatRate}%</b></td>
                        <td class="c" style="text-align:center;"><b>${f3(vatVal)}</b></td>
                    </tr>
                    <tr>
                        <td colspan="3" class="c" style="text-align:center;"><b>Total Amount (BD)</b></td>
                        <td class="c" style="text-align:center;"><b>${f3(grandTot)}</b></td>
                    </tr>
                </tfoot>
            </table>
            
            <p><b><u>Terms and Condition:</u></b></p>
            <ol>
                ${M(terms, t => `<li>${H(t)}</li>`)}
            </ol>
            
            <p>We hope you will find our offer quite competitive and in line with your requirements and look forward to receiving your valued order confirmation at the earliest.</p>
            
            <div class="sg">
                <div>
                    <b>Thanking you,<br><br>
                    Yours sincerely,<br>
                    THC Facility Management W.L.L</b><br>
                    ${(showSig || showStamp) ? `
                        <div style="display:flex;align-items:center;gap:14px;margin:8px 0;min-height:52px;">
                            ${showSig && uSigRel ? `<img src="${H(uSigRel)}" onerror="this.src='../view/${H(uSigRel)}';" alt="Signature" style="height:42px;max-width:140px;object-fit:contain;display:inline-block;vertical-align:middle;">` : ""}
                            ${showStamp && stampRel ? `<img src="${H(stampRel)}" onerror="this.src='../view/${H(stampRel)}';" alt="Stamp" style="height:48px;max-width:140px;object-fit:contain;display:inline-block;vertical-align:middle;">` : ""}
                        </div>
                    ` : `<br><br>`}
                    <b>${H(uName)}<br>
                    <span style="font-weight:400;color:#444;">${H(uTitle)}</span></b>
                    ${showPhone && uPhone ? `<br><span style="font-weight:500;color:#1e293b;font-size:11px;">Mob: ${H(uPhone)}</span>` : ""}
                </div>
                <div class="ap">
                    ${(q.status === 'Approved' || q.st === 'Approved') && (q.approval_by || (q.appr && q.appr.by)) ? `
                        <b>Approved By:</b><br><br>
                        <b>Name:</b> ${H(q.approval_by || q.appr.by)}<br><br>
                        <b>Date:</b> ${fd(q.approval_date || (q.appr && q.appr.on) || qDate)}
                        ${(q.client_po_ref || (q.appr && q.appr.po)) ? `<br><br><b>PO / LPO Ref:</b> ${H(q.client_po_ref || q.appr.po)}` : ""}
                    ` : `
                        <b>Approved By:</b><br><br>
                        Name:<br><br>
                        Date:
                    `}
                </div>
            </div>
            
            <div class="sheet-footer-container" style="margin-top:24px;">
                <div style="display:flex;justify-content:space-between;align-items:center;font-size:11px;color:#475569;margin-bottom:4px;padding:0 2px;">
                    <div>${FOOTER_CONFIG.show_page_no ? "Page 1 of 1" : ""}</div>
                    <div>${H(FOOTER_CONFIG.doc_number || "CINQO/THC/QTN/01/2020/REV3")}</div>
                </div>
                <div style="background:${H(FOOTER_CONFIG.bg_color || '#1e2560')};border-radius:4px;padding:10px 14px;color:#ffffff;display:flex;align-items:center;justify-content:space-between;gap:12px;">
                    <div style="font-size:10px;line-height:1.5;color:#ffffff;">
                        <div>Tel: <b>${H(FOOTER_CONFIG.phone || '+973 17 100 190')}</b> | ${H(FOOTER_CONFIG.email || 'info@thc.com.bh')} | ${H(FOOTER_CONFIG.website || 'www.thc.com.bh')}</div>
                        <div>CR : <b>${H(FOOTER_CONFIG.cr_no || '88982-1')}</b> | ${H(FOOTER_CONFIG.address_line1 || 'Level 14, Office 1403/1404, Bldg 155, Road 1703, Block 317')}</div>
                        <div><b>${H(FOOTER_CONFIG.address_line2 || 'YBA Kanoo Tower, Diplomatic Area, Kingdom of Bahrain')}</b></div>
                    </div>
                    ${FOOTER_CONFIG.show_badges ? `
                        <div style="flex-shrink:0;">
                            <img src="global_assets/images/a.png" 
                                 onerror="if(!this.dataset.fb){this.dataset.fb=1;this.src='../view/global_assets/images/a.png';}" 
                                 alt="Bureau Veritas" style="max-height:36px;display:block;">
                        </div>
                    ` : ""}
                </div>
            </div>
        </div>`;
    }

    // Direct High-Resolution PDF Download (Direct download without print dialog)
    function pdf(q) {
        if (!q) return;
        const qId = q.id;
        const fn = fnm(q) + ".pdf";

        if (qId) {
            const url = `print/print_quotation_module.php?id=${encodeURIComponent(qId)}&download=1`;
            const a = document.createElement("a");
            a.href = url;
            a.setAttribute("download", fn);
            a.style.display = "none";
            document.body.appendChild(a);
            a.click();
            setTimeout(() => {
                try { document.body.removeChild(a); } catch (e) {}
            }, 1500);
            toast("Downloading " + fn + "...");
            return;
        }

        if (q.quotation_no || q.no) {
            const refNo = q.quotation_no || q.no;
            const url = `print/print_quotation_module.php?ref_no=${encodeURIComponent(refNo)}&download=1`;
            const a = document.createElement("a");
            a.href = url;
            a.setAttribute("download", fn);
            a.style.display = "none";
            document.body.appendChild(a);
            a.click();
            setTimeout(() => {
                try { document.body.removeChild(a); } catch (e) {}
            }, 1500);
            toast("Downloading " + fn + "...");
            return;
        }

        toast("Please save or issue the quotation before downloading the PDF.");
    }

    // Main Router
    function go(v) {
        if (window.jQuery && typeof window.jQuery.fn.select2 === "function") {
            ['#cl', '#cl_non_amc', '#fc', '#fu'].forEach(selId => {
                const $s = window.jQuery(selId);
                if ($s.length && $s.data('select2')) {
                    $s.select2('destroy');
                }
            });
            window.jQuery('.select2-container--open').remove();
        }
        $$("aside a[data-v], .thc-subnav-btn[data-v]").forEach(a => a.classList.toggle("on", a.dataset.v === v));
        ED = null;
        if (v === "log") vlog();
        else if (v === "perf") vperf();
        else if (v === "rules") vrules();
        else if (v === "A" || v === "N") {
            const isAmc = v === "A";
            const curUserPhone = (USERS[CU] && (USERS[CU].phone || USERS[CU][2])) 
                || (STAMP_SIGN_CONFIG.user_phones && STAMP_SIGN_CONFIG.user_phones[CU]) 
                || (currentUserObj && currentUserObj.phone) 
                || "";
            const defaultShowPhone = (STAMP_SIGN_CONFIG.show_user_phone !== 0 && STAMP_SIGN_CONFIG.show_user_phone !== false);

            ED = {
                id: null,
                seq_no: null,
                rev_no: 0,
                variation_no: 0,
                quotation_no: "",
                client_name: "",
                client_code: "",
                is_amc: isAmc ? 1 : 0,
                client_address: "",
                contact_no: "",
                attention: "",
                subject: "",
                quotation_date: TODAY,
                user_code: CU,
                user_name: USERS[CU] ? (Array.isArray(USERS[CU]) ? USERS[CU][0] : USERS[CU].name) : currentUserObj.name,
                user_designation: USERS[CU] ? (Array.isArray(USERS[CU]) ? USERS[CU][1] : USERS[CU].title) : currentUserObj.title,
                user_phone: curUserPhone,
                include_user_phone: defaultShowPhone ? 1 : 0,
                items: [{ description: "", quantity: 1, unit: "Lumpsum", unit_price: 0, total_price: 0 }],
                vat_rate: 10,
                discount_type: "amount",
                discount_value: 0,
                terms: T0.slice(),
                status: "Draft",
                remark: "",
                internal_notes: "",
                merge_items: 0,
                merge_qty: 0,
                merged_lump_sum_price: 0,
                bullet_items: 0
            };
            edit();
        }
    }

    // ==========================================
    // VIEW 1: QUOTATION LOG
    // ==========================================
    function vlog() {
        const a = $('aside a[data-v="log"]');
        if (a) a.classList.add("on");

        const sel = (id, label, options) => `
            <select id="${id}">
                <option value="">${label}</option>
                ${M(options, x => `<option value="${H(x[0])}" ${F[{ fc: "client", fs: "st", ft: "type", fu: "user" }[id]] == x[0] ? "selected" : ""}>${H(x[1])}</option>`)}
            </select>`;

        const uniqueClients = [...new Set([
            ...Q.map(x => x.client_name || x.client).filter(Boolean),
            ...AMC.map(c => c.name).filter(Boolean),
            ...NON_AMC.map(c => c.name).filter(Boolean)
        ])].sort((a, b) => a.localeCompare(b));
        const userList = Object.keys(USERS).map(u => [u, Array.isArray(USERS[u]) ? USERS[u][0] : USERS[u].name]);

        $("#v").innerHTML = `
            <div class="top">
                <h1>Quotation log</h1>
                <div style="display:flex;gap:8px;align-items:center;flex-wrap:wrap;">
                    <button class="p" id="nA">+ New quote · AMC client</button>
                    <button id="nN">+ New quote · Non-AMC client</button>
                    <button type="button" id="btn_export_excel" style="background:linear-gradient(135deg, #15803d 0%, #16a34a 100%);color:#ffffff;border:none;box-shadow:0 4px 12px rgba(22,163,74,0.25);font-weight:600;display:inline-flex;align-items:center;gap:6px;padding:8px 15px;border-radius:10px;cursor:pointer;" title="Export filtered quotation log to Excel">
                        <i class="icon-file-excel mr-1"></i> Export to Excel
                    </button>
                </div>
            </div>
            <div class="card bar filter-toolbar">
                <!-- Anti-autofill trap fields for browser credential autofill -->
                <input type="text" name="fake_username_trap" style="display:none !important;" aria-hidden="true" autocomplete="username" tabindex="-1">
                <input type="password" name="fake_password_trap" style="display:none !important;" aria-hidden="true" autocomplete="current-password" tabindex="-1">

                <div class="search-input-wrapper">
                    <i class="icon-search4" style="position:absolute;left:11px;top:50%;transform:translateY(-50%);font-size:13px;color:#94a3b8;pointer-events:none;z-index:2;"></i>
                    <input type="search" id="fq" name="quote_search_query_nocred" placeholder="Search number, client or subject…" value="${H(F.q)}" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" readonly onfocus="this.removeAttribute('readonly');" onclick="this.removeAttribute('readonly');" data-lpignore="true">
                    <button type="button" id="btn_clear_search" title="Clear search" style="display:${F.q ? 'flex' : 'none'};">
                        <i class="icon-cross2" style="font-size:11px;"></i>
                    </button>
                </div>
                ${sel("fc", "All clients", uniqueClients.map(c => [c, c]))}
                ${sel("fs", "All statuses", ["Draft", "Pending", "Approved", "Not approved", "Completed", "Expired"].map(c => [c, c]))}
                ${sel("ft", "AMC & non-AMC", [["AMC", "AMC clients"], ["Non-AMC", "Non-AMC clients"]])}
                ${sel("fu", "All users", userList)}
                <label>
                    <input type="checkbox" id="fx" ${F.sup ? "checked" : ""}> Show superseded / void
                </label>
            </div>
            <div id="res"></div>`;

        $("#nA").onclick = () => go("A");
        $("#nN").onclick = () => go("N");
        const btnExp = $("#btn_export_excel");
        if (btnExp) {
            btnExp.onclick = () => exportQuotationLogToExcel();
        }

        const elFq = $("#fq");
        const btnClear = $("#btn_clear_search");

        const updateClearButton = () => {
            if (!elFq || !btnClear) return;
            const hasVal = !!(elFq.value && elFq.value.trim().length > 0);
            btnClear.style.display = hasVal ? "flex" : "none";
        };

        const purgeAutofill = () => {
            if (!elFq) return;
            const val = elFq.value || "";
            if (!F.q) {
                if (val.length > 0) {
                    elFq.value = "";
                }
            } else if (val === "CGTHCFM" || val === (currentUserObj.name || "") || val === (currentUserObj.code || "")) {
                elFq.value = "";
                F.q = "";
            }
            updateClearButton();
        };

        if (elFq) {
            purgeAutofill();

            elFq.oninput = e => {
                F.q = e.target.value;
                updateClearButton();
                res();
            };
            elFq.onchange = e => {
                F.q = e.target.value;
                updateClearButton();
                res();
            };
            elFq.onkeydown = e => {
                if (e.key === "Escape") {
                    elFq.value = "";
                    F.q = "";
                    updateClearButton();
                    res();
                }
            };

            // Watchdog against late browser autofills that inject credentials on refresh
            [30, 80, 150, 300, 600, 1200].forEach(delay => {
                setTimeout(purgeAutofill, delay);
            });
        }

        if (btnClear && elFq) {
            btnClear.onclick = e => {
                e.preventDefault();
                e.stopPropagation();
                elFq.value = "";
                F.q = "";
                updateClearButton();
                elFq.focus();
                res();
            };
        }

        [["fs", "st"], ["ft", "type"]].forEach(([i, k]) => {
            const el = $("#" + i);
            if (el) {
                el.oninput = e => { F[k] = e.target.value; res(); };
                el.onchange = e => { F[k] = e.target.value; res(); };
            }
        });

        const setupToolbarSelect2 = function (selId, filterKey, placeholderText) {
            const el = $("#" + selId);
            if (!el) return;

            el.onchange = e => {
                F[filterKey] = e.target.value;
                res();
            };

            if (window.jQuery && typeof window.jQuery.fn.select2 === "function") {
                const $el = window.jQuery(el);
                if ($el.data('select2')) {
                    $el.select2('destroy');
                }
                $el.select2({
                    width: 'style',
                    placeholder: placeholderText,
                    allowClear: true
                }).on('change', function () {
                    F[filterKey] = this.value;
                    res();
                });
            }
        };

        setupToolbarSelect2("fc", "client", "All clients");
        setupToolbarSelect2("fu", "user", "All users");

        const fx = $("#fx");
        if (fx) fx.onchange = e => { F.sup = e.target.checked; res(); };

        res();
    }

    function getFilteredQuotations() {
        return Q.filter(x => {
            const status = x.status || x.st;
            const client = x.client_name || x.client || "";
            const isAmc = x.is_amc !== undefined ? !!x.is_amc : !!x.amc;
            const user = x.user_code || x.user;
            const qNo = x.quotation_no || x.no || "";
            const subj = x.subject || x.subj || "";

            if (!F.sup && (status === "Superseded" || status === "Void")) return false;
            if (F.st && status !== F.st) return false;
            if (F.client && client !== F.client) return false;
            if (F.type && (F.type === "AMC") !== isAmc) return false;
            if (F.user && user !== F.user) return false;
            if (F.q) {
                const term = F.q.toLowerCase();
                const hay = (qNo + " " + client + " " + subj).toLowerCase();
                if (!hay.includes(term)) return false;
            }
            return true;
        });
    }

    function res() {
        const L = getFilteredQuotations();
        const expBtn = $("#btn_export_excel");
        if (expBtn) {
            expBtn.innerHTML = `<i class="icon-file-excel mr-1"></i> Export to Excel (${L.length})`;
            expBtn.disabled = (L.length === 0);
            expBtn.style.opacity = (L.length === 0) ? "0.6" : "1";
        }

        const S = L.filter(x => SENT.includes(x.status || x.st));
        const A = L.filter(x => ["Approved", "Completed"].includes(x.status || x.st));

        $("#res").innerHTML = `
            <div class="kpis">
                ${M([
                    ["Quotes sent", S.length],
                    ["Value sent · excl. VAT", f3(sm(S, netAmt))],
                    ["Value sent · incl. VAT", f3(sm(S, tot))],
                    ["Approved quotes", A.length],
                    ["Approved · excl. VAT", f3(sm(A, netAmt))],
                    ["Approved · incl. VAT", f3(sm(A, tot))]
                ], k => `
                    <div class="card kpi">
                        <span>${k[0]}</span>
                        <strong>${k[1]}</strong>
                    </div>`
                )}
            </div>
            
            <div class="card tw">
                <table class="lg">
                    <thead>
                        <tr>
                            <th>Quote no.</th>
                            <th>Client</th>
                            <th>Subject</th>
                            <th>Date</th>
                            <th>By</th>
                            <th>Excl. VAT</th>
                            <th>Incl. VAT</th>
                            <th>Internal Notes</th>
                            <th>Status</th>
                            <th style="width:60px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        ${M(L, x => {
                            const qNo = x.quotation_no || x.no;
                            const client = x.client_name || x.client || "—";
                            const code = x.client_code || x.code || "—";
                            const isAmc = x.is_amc !== undefined ? !!x.is_amc : !!x.amc;
                            const subj = x.subject || x.subj || "—";
                            const date = dmy(x.quotation_date || x.date);
                            const userCode = x.user_code || x.user || "—";
                            let userName = x.user_name || (USERS[userCode] ? (Array.isArray(USERS[userCode]) ? USERS[userCode][0] : USERS[userCode].name) : "") || userCode;
                            if (userName === "Adminstrator") userName = "Administrator";
                            const remark = x.remark || "";
                            return `
                            <tr data-id="${x.id}">
                                <td>
                                    <b>${qNo ? H(qNo) : "Draft"}</b>
                                    ${lab(x) !== "Original" ? ` <span class="tag">${lab(x)}</span>` : ""}
                                </td>
                                <td>
                                    ${H(client)}<br>
                                    <small>${H(code)} · ${isAmc ? "AMC" : "Non-AMC"}</small>
                                </td>
                                <td class="w">${H(subj)}</td>
                                <td>${date}</td>
                                <td>${H(userName)}</td>
                                <td>
                                    ${discAmount(x) > 0 ? `
                                        <b>${f3(netAmt(x))}</b><br>
                                        <small style="color:#b91c1c;font-weight:600;">(-${f3(discAmount(x))} disc)</small>
                                    ` : f3(netAmt(x))}
                                </td>
                                <td><b>${f3(tot(x))}</b></td>
                                <td style="max-width:160px;font-size:11.5px;">
                                    ${x.internal_notes ? `
                                        <div style="background:#fffbeb;border:1px solid #fef3c7;color:#92400e;padding:4px 7px;border-radius:5px;line-height:1.3;display:inline-block;max-width:100%;white-space:normal;word-break:break-word;" title="${H(x.internal_notes)}">
                                            <i class="icon-file-text2 mr-1" style="font-size:10px;"></i>${H(x.internal_notes.length > 38 ? x.internal_notes.slice(0, 36) + '…' : x.internal_notes)}
                                        </div>
                                    ` : '<span style="color:#cbd5e1;">—</span>'}
                                </td>
                                <td class="w">
                                    ${tg(x)}
                                    ${remark ? `<br><small>${H(remark)}</small>` : ""}
                                </td>
                                <td>
                                    <button data-pdf="${x.id}" title="Download PDF">PDF</button>
                                </td>
                            </tr>`;
                        })}
                    </tbody>
                </table>
                ${L.length ? "" : '<p style="padding:28px;text-align:center;color:var(--mut);">No quotations match these filters.</p>'}
            </div>
            <p style="color:var(--mut);font-size:12px;margin-top:8px;">Totals follow the filters above. Drafts, superseded revisions and void quotes are never counted.</p>`;

        $("#res").onclick = e => {
            const pdfBtn = e.target.closest("[data-pdf]");
            const row = e.target.closest("tr[data-id]");
            if (pdfBtn) {
                const target = Q.find(x => x.id == pdfBtn.dataset.pdf);
                if (target) pdf(target);
            } else if (row) {
                vq(+row.dataset.id);
            }
        };
    }

    // Export Quotation Log to Excel
    function exportQuotationLogToExcel() {
        const list = getFilteredQuotations();
        if (!list || !list.length) {
            toast("No quotations found matching current filters to export.");
            return;
        }

        toast("Generating Excel export for " + list.length + " quotations…");

        let totalGross = 0;
        let totalDiscount = 0;
        let totalNet = 0;
        let totalVat = 0;
        let grandTotal = 0;

        let rowsHtml = "";
        list.forEach((x, idx) => {
            const qNo = x.quotation_no || x.no || "Draft";
            const version = lab(x);
            const date = dmy(x.quotation_date || x.date);
            const clientName = x.client_name || x.client || "";
            const clientCode = x.client_code || x.code || "";
            const isAmc = x.is_amc !== undefined ? (x.is_amc ? "AMC" : "Non-AMC") : (x.amc ? "AMC" : "Non-AMC");
            const contactNo = x.contact_no || x.contact || "";
            const attention = x.attention || x.attn || "";
            const subject = x.subject || x.subj || "";
            const userCode = x.user_code || x.user || "";
            let userName = x.user_name || (USERS[userCode] ? (Array.isArray(USERS[userCode]) ? USERS[userCode][0] : USERS[userCode].name) : "") || userCode;
            if (userName === "Adminstrator") userName = "Administrator";
            const userTitle = x.user_designation || (USERS[userCode] ? (Array.isArray(USERS[userCode]) ? USERS[userCode][1] : USERS[userCode].title) : "") || "";

            const grossAmt = amt(x);
            const discAmt = discAmount(x);
            const net = netAmt(x);
            const vatRate = (x.vat_rate !== undefined ? +x.vat_rate : (x.vat !== undefined ? +x.vat : 10));
            const vatVal = (net * vatRate) / 100;
            const totalVal = tot(x);

            const status = x.status || x.st || "Draft";
            let decisionInfo = "";
            if (status === "Completed") {
                decisionInfo = `Completed on ${dmy(x.completion_date)}${x.completion_by ? ' by ' + x.completion_by : ''}${x.completion_notes ? ' (' + x.completion_notes + ')' : ''}`;
            } else if (status === "Expired") {
                decisionInfo = `Expired (Validity: ${x.validity_days || 30} days)${x.remark ? ' - ' + x.remark : ''}`;
            } else if (status === "Approved") {
                const apprBy = x.approval_by || (x.appr && x.appr.by) || "";
                const apprDate = dmy(x.approval_date || (x.appr && x.appr.on));
                const poRef = x.client_po_ref || (x.appr && x.appr.po) || "";
                decisionInfo = `Approved by ${apprBy}${apprDate && apprDate !== '—' ? ' on ' + apprDate : ''}${poRef ? ' (PO: ' + poRef + ')' : ''}`;
            } else if (status === "Not approved") {
                const reason = x.rejection_reason || x.remark || "";
                decisionInfo = `Rejected: ${reason}`;
            } else if (x.remark) {
                decisionInfo = x.remark;
            }

            const internalNotes = x.internal_notes || "";
            const isMerged = x.merge_items ? "Yes" : "No";

            const items = x.items || [];
            const itemsSummary = items.map((it, i) => {
                const d = (it.description || it[0] || "").replace(/<[^>]+>/g, "").replace(/\*\*/g, "").replace(/__/g, "");
                const q = it.quantity !== undefined ? it.quantity : (it[1] !== undefined ? it[1] : 1);
                const u = it.unit || it[2] || "Lumpsum";
                const p = it.unit_price !== undefined ? it.unit_price : (it[3] !== undefined ? it[3] : 0);
                return `${i + 1}. ${d} (${q} ${u} @ ${Number(p).toFixed(3)})`;
            }).join(" | ");

            totalGross += grossAmt;
            totalDiscount += discAmt;
            totalNet += net;
            totalVat += vatVal;
            grandTotal += totalVal;

            rowsHtml += `
            <tr>
                <td style="text-align:center;">${idx + 1}</td>
                <td style="font-weight:bold;mso-number-format:'\\@';">${H(qNo)}</td>
                <td style="text-align:center;">${H(version)}</td>
                <td style="text-align:center;mso-number-format:'yyyy-mm-dd';">${H(date)}</td>
                <td>${H(clientName)}</td>
                <td style="text-align:center;mso-number-format:'\\@';">${H(clientCode)}</td>
                <td style="text-align:center;">${H(isAmc)}</td>
                <td style="mso-number-format:'\\@';">${H(contactNo)}</td>
                <td>${H(attention)}</td>
                <td>${H(subject)}</td>
                <td>${H(userName)}</td>
                <td>${H(userTitle)}</td>
                <td style="text-align:right;mso-number-format:'#,##0.000';">${grossAmt.toFixed(3)}</td>
                <td style="text-align:right;mso-number-format:'#,##0.000';color:#b91c1c;">${discAmt > 0 ? (-discAmt).toFixed(3) : "0.000"}</td>
                <td style="text-align:right;font-weight:bold;mso-number-format:'#,##0.000';">${net.toFixed(3)}</td>
                <td style="text-align:center;">${vatRate}%</td>
                <td style="text-align:right;mso-number-format:'#,##0.000';">${vatVal.toFixed(3)}</td>
                <td style="text-align:right;font-weight:bold;color:#0A4174;mso-number-format:'#,##0.000';">${totalVal.toFixed(3)}</td>
                <td style="text-align:center;">${isMerged}</td>
                <td style="text-align:center;font-weight:bold;">${H(status)}</td>
                <td>${H(decisionInfo)}</td>
                <td style="background:#fffbeb;color:#92400e;">${H(internalNotes)}</td>
                <td style="font-size:10pt;color:#475569;">${H(itemsSummary)}</td>
            </tr>`;
        });

        const footerHtml = `
            <tr style="background:#f1f5f9;font-weight:bold;border-top:2px solid #0A4174;">
                <td colspan="12" style="text-align:right;padding:8px 12px;font-size:11pt;color:#001D39;">TOTALS (${list.length} Quotes):</td>
                <td style="text-align:right;mso-number-format:'#,##0.000';">${totalGross.toFixed(3)}</td>
                <td style="text-align:right;mso-number-format:'#,##0.000';color:#b91c1c;">${(-totalDiscount).toFixed(3)}</td>
                <td style="text-align:right;mso-number-format:'#,##0.000';">${totalNet.toFixed(3)}</td>
                <td style="text-align:center;">—</td>
                <td style="text-align:right;mso-number-format:'#,##0.000';">${totalVat.toFixed(3)}</td>
                <td style="text-align:right;font-weight:bold;color:#0A4174;mso-number-format:'#,##0.000';">${grandTotal.toFixed(3)}</td>
                <td colspan="5"></td>
            </tr>`;

        const filterSummaryParts = [];
        if (F.q) filterSummaryParts.push(`Search: "${F.q}"`);
        if (F.client) filterSummaryParts.push(`Client: "${F.client}"`);
        if (F.st) filterSummaryParts.push(`Status: "${F.st}"`);
        if (F.type) filterSummaryParts.push(`Type: "${F.type}"`);
        if (F.user) filterSummaryParts.push(`User: "${F.user}"`);
        if (F.sup) filterSummaryParts.push(`Including Superseded/Void`);
        const filterStr = filterSummaryParts.length ? filterSummaryParts.join(" | ") : "All Quotations (No filters)";

        const template = `
        <html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
            <!--[if gte mso 9]>
            <xml>
                <x:ExcelWorkbook>
                    <x:ExcelWorksheets>
                        <x:ExcelWorksheet>
                            <x:Name>Quotation Log</x:Name>
                            <x:WorksheetOptions>
                                <x:DisplayGridlines/>
                            </x:WorksheetOptions>
                        </x:ExcelWorksheet>
                    </x:ExcelWorksheets>
                </x:ExcelWorkbook>
            </xml>
            <![endif]-->
            <style>
                body { font-family: Calibri, Arial, sans-serif; font-size: 11pt; color: #1e293b; }
                table { border-collapse: collapse; width: 100%; }
                th { background-color: #0A4174; color: #ffffff; font-weight: bold; border: 1px solid #7BBDE8; padding: 8px 10px; font-size: 11pt; }
                td { border: 1px solid #cbd5e1; padding: 6px 10px; font-size: 10.5pt; vertical-align: middle; }
            </style>
        </head>
        <body>
            <table>
                <tr>
                    <th colspan="23" style="background:#001D39;color:#ffffff;font-size:15pt;padding:12px;text-align:left;">
                        THC FACILITY MANAGEMENT — QUOTATION LOG EXPORT
                    </th>
                </tr>
                <tr>
                    <td colspan="23" style="background:#f8fafc;color:#475569;font-size:10pt;padding:6px 10px;border-bottom:1.5px solid #0A4174;">
                        <b>Export Date:</b> ${new Date().toLocaleString()} &nbsp;|&nbsp; <b>Total Records:</b> ${list.length} &nbsp;|&nbsp; <b>Filters:</b> ${H(filterStr)}
                    </td>
                </tr>
                <tr style="height:12px;"><td colspan="23" style="border:none;"></td></tr>
                <thead>
                    <tr>
                        <th style="width:45px;">Sl.</th>
                        <th style="width:180px;">Quote No.</th>
                        <th style="width:80px;">Version</th>
                        <th style="width:95px;">Date</th>
                        <th style="width:190px;">Client Name</th>
                        <th style="width:85px;">Client Code</th>
                        <th style="width:85px;">Type</th>
                        <th style="width:110px;">Contact No.</th>
                        <th style="width:140px;">Attention</th>
                        <th style="width:230px;">Subject</th>
                        <th style="width:150px;">Prepared By</th>
                        <th style="width:140px;">Designation</th>
                        <th style="width:115px;text-align:right;">Gross Excl. VAT (BHD)</th>
                        <th style="width:105px;text-align:right;">Discount (BHD)</th>
                        <th style="width:115px;text-align:right;">Net Excl. VAT (BHD)</th>
                        <th style="width:75px;text-align:center;">VAT %</th>
                        <th style="width:105px;text-align:right;">VAT Amount (BHD)</th>
                        <th style="width:125px;text-align:right;">Total Incl. VAT (BHD)</th>
                        <th style="width:70px;text-align:center;">Merged?</th>
                        <th style="width:95px;text-align:center;">Status</th>
                        <th style="width:200px;">Decision / Remark</th>
                        <th style="width:220px;">Internal Notes (Office Ref)</th>
                        <th style="width:300px;">Scope of Works Summary</th>
                    </tr>
                </thead>
                <tbody>
                    ${rowsHtml}
                </tbody>
                <tfoot>
                    ${footerHtml}
                </tfoot>
            </table>
        </body>
        </html>`;

        const blob = new Blob(["\ufeff", template], { type: "application/vnd.ms-excel;charset=utf-8" });
        const fileName = `THC_Quotation_Log_${new Date().toISOString().slice(0, 10)}.xls`;
        const url = URL.createObjectURL(blob);
        const a = document.createElement("a");
        a.href = url;
        a.download = fileName;
        document.body.appendChild(a);
        a.click();
        setTimeout(() => {
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
        }, 1500);

        toast(`Exported ${list.length} quotations to ${fileName}`);
    }

    // ==========================================
    // VIEW 2: QUOTATION DETAIL (vq)
    // ==========================================
    function vq(id) {
        const q = Q.find(x => x.id == id);
        if (!q) {
            toast("Quotation not found");
            go("log");
            return;
        }

        const seq = q.seq_no !== undefined ? q.seq_no : q.seq;
        const h = seq ? Q.filter(x => (x.seq_no !== undefined ? x.seq_no : x.seq) == seq).sort((a, b) => {
            const va = a.variation_no !== undefined ? a.variation_no : (a.vn || 0);
            const vb = b.variation_no !== undefined ? b.variation_no : (b.vn || 0);
            const ra = a.rev_no !== undefined ? a.rev_no : (a.rev || 0);
            const rb = b.rev_no !== undefined ? b.rev_no : (b.rev || 0);
            return (va - vb) || (ra - rb);
        }) : [q];

        const qVn = q.variation_no !== undefined ? q.variation_no : (q.vn || 0);
        const grp = h.filter(x => (x.variation_no !== undefined ? x.variation_no : (x.vn || 0)) == qVn);
        const apGrp = grp.find(x => (x.status || x.st) === "Approved");
        const nextRev = Math.max(...grp.map(x => (x.rev_no !== undefined ? x.rev_no : (x.rev || 0))), 0) + 1;

        const st = q.status || q.st;
        const adminUser = isSessionAdmin();
        const can = {
            ed: st === "Draft",
            del: st === "Draft" && adminUser,
            rev: ["Pending", "Not approved"].includes(st) && adminUser && !apGrp,
            ap: (["Pending", "Not approved"].includes(st) || (st === "Superseded" && !apGrp)) && adminUser,
            no: ["Pending", "Not approved"].includes(st) && adminUser,
            vr: st === "Approved",
            ro: st === "Approved" && adminUser,
            cm: st === "Approved",
            rvv: st === "Expired"
        };

        const qNo = q.quotation_no || q.no;
        const uCode = q.user_code || q.user;
        const uInfo = USERS[uCode] || [q.user_name || "Authorized User", q.user_designation || "THC"];
        let uName = q.user_name || (Array.isArray(uInfo) ? uInfo[0] : (uInfo.name || "Authorized User"));
        if (uName === "Adminstrator") uName = "Administrator";
        const uTitle = q.user_designation || (Array.isArray(uInfo) ? uInfo[1] : (uInfo.title || "THC"));

        const clientName = q.client_name || q.client;
        const clientCode = q.client_code || q.code;
        const isAmc = q.is_amc !== undefined ? !!xIsAmc(q) : !!q.amc;
        const remark = q.remark;

        $("#v").innerHTML = `
            <div class="top">
                <h1>${qNo ? H(qNo) + (lab(q) !== "Original" ? " / " + lab(q) : "") : "Draft quotation"} ${tg(q)}</h1>
                <div>
                    <button id="bk">← Log</button>
                    ${can.ed ? '<button id="ed">Edit draft</button>' : ""}
                    ${can.del ? '<button class="d" id="del">Delete draft</button>' : ""}
                    ${can.rev ? `<button id="rv">Revise (R${nextRev})</button>` : ""}
                    ${can.cm ? '<button id="btn_mark_completed" class="p" style="background:linear-gradient(135deg, #059669 0%, #047857 100%);border-color:#059669;color:#fff;"><i class="icon-checkmark4 mr-1"></i> Completed</button>' : ""}
                    ${can.rvv ? '<button id="btn_revive_quote" class="p" style="background:linear-gradient(135deg, #ea580c 0%, #c2410c 100%);border-color:#ea580c;color:#fff;"><i class="icon-history mr-1"></i> Revive Quote</button>' : ""}
                    ${can.vr ? '<button id="vr">Create variation</button>' : ""}
                    <button id="dp">Duplicate</button>
                    <button class="p" id="dl">⬇ Download PDF</button>
                </div>
            </div>
            
            ${st === "Approved" ? '<div class="lock">🔒 Approved quotes are locked. They cannot be edited or revised. Use a variation for any change after approval, or request Admin approval to reopen.</div>' : ""}
            ${st === "Completed" ? '<div class="lock" style="background:#ecfdf5;border-color:#6ee7b7;color:#065f46;">✅ Work for this quotation has been marked as <b>Completed</b>.</div>' : ""}
            ${st === "Expired" ? '<div class="lock" style="background:#fff7ed;border-color:#fdba74;color:#9a3412;">⚠️ This quotation has <b>Expired</b> based on its validity period. Click "Revive Quote" to refresh the quotation date and restore it to Pending.</div>' : ""}

            <div class="two">
                <div>
                    <div class="card pad">
                        <h2>Details</h2>
                        <div class="kv">
                            <span>Client</span>
                            <b>${H(clientName)}</b>
                            
                            <span>Client code</span>
                            <div>${H(clientCode) || "—"} (${isAmc ? "active AMC client" : "non-AMC"})</div>
                            
                            <span>Prepared by</span>
                            <div>${H(uName)}, ${H(uTitle)}</div>
                            
                            <span>Amount</span>
                            <div>
                                ${discAmount(q) > 0 ? `<span style="text-decoration:line-through;color:var(--mut);margin-right:4px;">${f3(amt(q))}</span> <span style="color:#b91c1c;font-weight:600;margin-right:4px;">(-${f3(discAmount(q))} disc)</span>` : ""}
                                ${f3(netAmt(q))} excl. · <b>${f3(tot(q))}</b> incl. VAT
                            </div>
                            
                            <span>PDF file name</span>
                            <div>${fnm(q)}.pdf</div>

                            ${(q.approval_by || (q.appr && q.appr.by)) ? `
                                <span>Approved by</span>
                                <div>${H(q.approval_by || q.appr.by)} on ${dmy(q.approval_date || (q.appr && q.appr.on))}${(q.client_po_ref || (q.appr && q.appr.po)) ? ' · ' + H(q.client_po_ref || q.appr.po) : ''}</div>
                            ` : ''}

                            ${(q.completion_date || st === "Completed") ? `
                                <span>Completion Status</span>
                                <div style="background:#f0fdf4;border:1.5px solid #86efac;border-radius:8px;padding:8px 12px;color:#065f46;font-size:12.5px;line-height:1.45;">
                                    <div style="font-weight:700;color:#047857;display:flex;align-items:center;gap:6px;margin-bottom:4px;">
                                        <i class="icon-checkmark-circle2" style="font-size:15px;color:#059669;"></i> Work Completed
                                    </div>
                                    <div><b>Completed Date:</b> ${dmy(q.completion_date || TODAY)}</div>
                                    ${q.completion_by ? `<div><b>Recorded By:</b> ${H(q.completion_by)}</div>` : ''}
                                    ${q.completion_notes ? `<div style="margin-top:4px;background:#ffffff;padding:4px 8px;border-radius:4px;border:1px solid #bbf7d0;"><b>Notes:</b> ${H(q.completion_notes)}</div>` : ''}
                                    ${q.completion_attachment ? `
                                        <div style="margin-top:6px;">
                                            <a href="../${H(q.completion_attachment)}" target="_blank" class="btn btn-sm font-weight-semibold" style="background:#059669;color:#ffffff;padding:4px 10px;font-size:11.5px;border-radius:6px;text-decoration:none;display:inline-flex;align-items:center;gap:5px;box-shadow:0 1px 3px rgba(5,150,105,0.25);">
                                                <i class="icon-attachment mr-1"></i> View Attachment (${H(q.completion_attachment.split('/').pop())})
                                            </a>
                                        </div>
                                    ` : ''}
                                </div>
                            ` : ''}

                            ${(q.validity_days || q.quotation_date) ? `
                                <span>Validity</span>
                                <div>${q.validity_days || 30} days ${st === "Expired" ? '<span style="color:#ea580c;font-weight:600;">(Expired)</span>' : ''}</div>
                            ` : ''}

                            ${q.merge_items ? `
                                <span>Line items</span>
                                <div style="color:#0284c7;font-weight:600;"><i class="icon-stack mr-1"></i> Merged line items (Lump sum: ${f3(q.merged_lump_sum_price || amt(q))} BD)</div>
                            ` : ''}

                            ${q.internal_notes ? `
                                <span>Internal note</span>
                                <div style="background:#fffbeb;border:1px solid #fef3c7;border-radius:6px;padding:6px 10px;color:#92400e;font-size:12px;line-height:1.4;">
                                    <i class="icon-file-text2 mr-1"></i> <b>Internal Reference (Not on quote):</b><br>
                                    ${H(q.internal_notes).replace(/\n/g, "<br>")}
                                </div>
                            ` : ''}
                            
                            ${remark ? `<span>Remark</span><div>${H(remark)}</div>` : ""}
                        </div>
                    </div>
                    
                    ${h.length > 1 ? `
                    <div class="card pad">
                        <h2>Revisions &amp; variations</h2>
                        ${M(h, x => {
                            const xDate = dmy(x.quotation_date || x.date);
                            return `
                            <div style="margin-top:8px;">
                                <a href="#" data-r="${x.id}" style="${x.id == q.id ? 'font-weight:700;' : ''}">${lab(x)}</a>
                                · ${xDate} · ${f3(tot(x))} incl. VAT ${tg(x)}
                            </div>`;
                        })}
                    </div>` : ""}
                    
                    ${can.ap || can.no || can.ro ? `
                    <div class="card pad">
                        <h2>Client decision</h2>
                        <div style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:8px;">
                            ${can.ap ? `<button class="p" id="ya">${st === "Superseded" ? "Client approved this older revision" : "Mark approved"}</button>` : ""}
                            ${can.no ? '<button class="d" id="no">Mark not approved</button>' : ""}
                            ${can.ro ? '<button id="ro">Reopen approval (Admin only)</button>' : ""}
                        </div>
                        <div id="apb" hidden style="margin-top:12px;border-top:1px solid var(--line);padding-top:12px;">
                            <label style="display:block;margin-bottom:4px;font-weight:600;">Approved By (Client Contact Name) <span style="color:var(--bad);">*</span></label>
                            <input id="pa" placeholder="Approved by (client name) *" style="width:100%;margin-bottom:8px;">
                            <label style="display:block;margin-bottom:4px;font-weight:600;">Approval Date</label>
                            <input type="date" id="pd" value="${TODAY}" style="width:100%;margin-bottom:8px;">
                            <label style="display:block;margin-bottom:4px;font-weight:600;">Client PO / LPO Reference (optional)</label>
                            <input id="pp" placeholder="Client PO / LPO reference (optional)" style="width:100%;margin-bottom:8px;">
                            <button class="p btn ladda-button" id="ca" data-style="expand-right" data-spinner-color="#ffffff"><span class="ladda-label">Confirm approval</span></button>
                        </div>
                        <div id="nab" hidden style="margin-top:12px;border-top:1px solid var(--line);padding-top:12px;">
                            <label style="display:block;margin-bottom:4px;font-weight:600;">Reason for rejection <span style="color:var(--bad);">*</span></label>
                            <select id="rs" style="width:100%;margin-bottom:8px;">
                                <option value="">Select reason (required)</option>
                                ${M(REASONS, r => `<option value="${H(r)}">${H(r)}</option>`)}
                            </select>
                            <textarea id="rt" rows="2" placeholder="Additional remark (optional)" style="width:100%;margin-bottom:8px;" spellcheck="true" autocorrect="on" autocapitalize="sentences"></textarea>
                            <button class="d btn ladda-button" id="cf" data-style="expand-right" data-spinner-color="#ffffff"><span class="ladda-label">Confirm not approved</span></button>
                        </div>
                        <div id="rob" hidden style="margin-top:12px;border-top:1px solid var(--line);padding-top:12px;">
                            <label style="display:block;margin-bottom:4px;font-weight:600;">Reason for reopening (Admin approval) <span style="color:var(--bad);">*</span></label>
                            <textarea id="rr" rows="2" placeholder="Reason for reopening (required, logged)" style="width:100%;margin-bottom:8px;" spellcheck="true" autocorrect="on" autocapitalize="sentences"></textarea>
                            <button class="d btn ladda-button" id="cro" data-style="expand-right" data-spinner-color="#ffffff"><span class="ladda-label">Confirm reopen</span></button>
                        </div>
                    </div>` : ""}

                    ${((q.activity && q.activity.length) || (q.log && q.log.length)) ? `
                    <div class="card pad">
                        <h2>Activity</h2>
                        ${M((q.activity || q.log), l => `
                            <div style="margin-top:6px;border-bottom:1px solid var(--line);padding-bottom:6px;">
                                <small style="color:var(--mut);">${H(dmy(l.d || l.at, true))} · ${H(l.u || l.user_id || "")}</small><br>
                                <span>${H(l.t || l.note || "")}</span>
                            </div>`
                        )}
                    </div>` : ""}
                </div>
                
                <div id="pv">${sheet(q)}</div>
            </div>`;

        const showBox = i => {
            ["apb", "nab", "rob"].forEach(x => {
                const el = $("#" + x);
                if (el) el.hidden = (x !== i);
            });
        };

        $("#bk").onclick = () => go("log");
        $("#dl").onclick = () => pdf(q);

        $$("[data-r]").forEach(l => {
            l.onclick = e => {
                e.preventDefault();
                vq(+l.dataset.r);
            };
        });

        if ($("#ed")) {
            $("#ed").onclick = () => {
                ED = JSON.parse(JSON.stringify(q));
                edit();
            };
        }

        if ($("#del")) {
            $("#del").onclick = () => {
                confirmSwal("Delete Draft?", "Are you sure you want to delete this draft quotation?", () => {
                    deleteDraft(q.id);
                });
            };
        }

        if ($("#rv")) {
            $("#rv").onclick = () => {
                ED = JSON.parse(JSON.stringify(q));
                ED.id = null;
                ED.rev_no = nextRev;
                ED.rev = nextRev;
                ED.variation_no = qVn;
                ED.vn = qVn;
                ED.status = "Draft";
                ED.st = "Draft";
                ED.remark = "";
                ED.approval_by = null;
                ED.approval_date = null;
                ED.client_po_ref = null;
                ED.appr = null;
                ED.log = [];
                ED.activity = [];
                ED.quotation_date = TODAY;
                ED.date = TODAY;
                ED.user_code = CU;
                ED.user = CU;
                edit();
                toast("Revision R" + nextRev + " started from " + (qNo || "quote"));
            };
        }

        if ($("#btn_mark_completed")) {
            $("#btn_mark_completed").onclick = () => {
                if ($("#comp_quote_id")) $("#comp_quote_id").value = q.id;
                if ($("#comp_quote_summary")) $("#comp_quote_summary").innerHTML = `<b>${H(qNo || "Draft")}</b> · ${H(clientName)} · Total: <b>${f3(tot(q))} BD</b>`;
                if ($("#comp_date")) $("#comp_date").value = TODAY;
                if ($("#comp_notes")) $("#comp_notes").value = q.completion_notes || "";
                if ($("#comp_attachment")) $("#comp_attachment").value = "";
                showModal("#modal_quote_completion");
            };
        }

        if ($("#btn_revive_quote")) {
            $("#btn_revive_quote").onclick = () => {
                if ($("#revive_quote_id")) $("#revive_quote_id").value = q.id;
                if ($("#revive_quote_summary")) $("#revive_quote_summary").innerHTML = `<b>${H(qNo || "Draft")}</b> · ${H(clientName)} · Expired Quotation`;
                if ($("#revive_today_label")) $("#revive_today_label").textContent = dmy(TODAY);
                showModal("#modal_revive_quote");
            };
        }

        if ($("#vr")) {
            $("#vr").onclick = () => {
                const nextVn = Math.max(...h.map(x => (x.variation_no !== undefined ? x.variation_no : (x.vn || 0))), 0) + 1;
                ED = JSON.parse(JSON.stringify(q));
                ED.id = null;
                ED.variation_no = nextVn;
                ED.vn = nextVn;
                ED.rev_no = 0;
                ED.rev = 0;
                ED.status = "Draft";
                ED.st = "Draft";
                ED.remark = "";
                ED.approval_by = null;
                ED.approval_date = null;
                ED.client_po_ref = null;
                ED.appr = null;
                ED.log = [];
                ED.activity = [];
                ED.quotation_date = TODAY;
                ED.date = TODAY;
                ED.user_code = CU;
                ED.user = CU;
                ED.subject = "Variation: " + (q.subject || q.subj || "");
                ED.subj = ED.subject;
                edit();
                toast("Variation V" + nextVn + " linked to " + (qNo || "quote") + ". The approved quote is untouched.");
            };
        }

        $("#dp").onclick = () => {
            ED = JSON.parse(JSON.stringify(q));
            ED.id = null;
            ED.seq_no = null;
            ED.seq = null;
            ED.quotation_no = "";
            ED.no = "";
            ED.rev_no = 0;
            ED.rev = 0;
            ED.variation_no = 0;
            ED.vn = 0;
            ED.approval_by = null;
            ED.approval_date = null;
            ED.client_po_ref = null;
            ED.appr = null;
            ED.log = [];
            ED.activity = [];
            ED.status = "Draft";
            ED.st = "Draft";
            ED.remark = "";
            ED.quotation_date = TODAY;
            ED.date = TODAY;
            ED.user_code = CU;
            ED.user = CU;
            if (!xIsAmc(ED)) {
                ED.client_code = "";
                ED.code = "";
            }
            edit();
            toast("Copied as a new draft");
        };

        if ($("#ya")) $("#ya").onclick = () => showBox("apb");
        if ($("#no")) $("#no").onclick = () => showBox("nab");
        if ($("#ro")) $("#ro").onclick = () => showBox("rob");

        if ($("#ca")) {
            $("#ca").onclick = () => {
                const by = $("#pa").value.trim();
                if (!by) return toast("Enter the client name who approved");
                const on = $("#pd").value || TODAY;
                const po = $("#pp").value.trim();
                updateStatus(q.id, "Approved", "", "", { approved_by: by, approved_on: on, client_po: po }, $("#ca"));
            };
        }

        if ($("#cf")) {
            $("#cf").onclick = () => {
                const rsVal = $("#rs").value;
                if (!rsVal) return toast("A reason is required for not approved quotes");
                const rtVal = $("#rt").value.trim();
                updateStatus(q.id, "Not approved", rsVal, rtVal, {}, $("#cf"));
            };
        }

        if ($("#cro")) {
            $("#cro").onclick = () => {
                const r = $("#rr").value.trim();
                if (!r) return toast("A reason is required to reopen");
                updateStatus(q.id, "Pending", r, r, { action: "reopen" }, $("#cro"));
            };
        }
    }

    function xIsAmc(obj) {
        return obj.is_amc !== undefined ? !!obj.is_amc : !!obj.amc;
    }

    // ==========================================
    // VIEW 3: QUOTATION EDITOR (edit)
    // ==========================================
    function edit() {
        const e = ED;
        const isAmc = xIsAmc(e);
        const seq = e.seq_no !== undefined ? e.seq_no : e.seq;
        const uCode = e.user_code || e.user || CU;
        const uInfo = USERS[uCode] || [currentUserObj.name, currentUserObj.title];
        const uName = Array.isArray(uInfo) ? uInfo[0] : (uInfo.name || currentUserObj.name);
        const uTitle = Array.isArray(uInfo) ? uInfo[1] : (uInfo.title || currentUserObj.title);

        const defaultPhone = (uInfo && (uInfo.phone || uInfo[2])) 
            || (STAMP_SIGN_CONFIG.user_phones && STAMP_SIGN_CONFIG.user_phones[uCode]) 
            || (currentUserObj && currentUserObj.phone) 
            || "";
        const userPhone = e.user_phone !== undefined ? e.user_phone : defaultPhone;
        const includePhone = e.include_user_phone !== undefined 
            ? !!e.include_user_phone 
            : (e.user_phone !== undefined ? !!e.user_phone : (STAMP_SIGN_CONFIG.show_user_phone !== 0 && STAMP_SIGN_CONFIG.show_user_phone !== false));

        ED.include_user_phone = includePhone ? 1 : 0;
        ED.user_phone = userPhone;

        const clientName = e.client_name || e.client || "";
        const clientCode = e.client_code || e.code || "";
        const clientAddr = e.client_address || e.addr || "";
        const contact = e.contact_no || e.contact || "";
        const attn = e.attention || e.attn || "";
        const date = e.quotation_date || e.date || TODAY;
        const subj = e.subject || e.subj || "";
        const vat = e.vat_rate !== undefined ? e.vat_rate : (e.vat !== undefined ? e.vat : 10);
        const discVal = (e.discount_value !== undefined && +e.discount_value > 0) ? e.discount_value : ((e.discount !== undefined && +e.discount > 0) ? e.discount : "");
        const discType = e.discount_type || "amount";

        const nonAmcSelected = NON_AMC.find(c => (clientCode && c.code === clientCode) || (clientName && c.name.toLowerCase() === clientName.toLowerCase()));
        const activeNonAmcCode = nonAmcSelected ? nonAmcSelected.code : clientCode;
        const hasCustCode = !!((isAmc ? AMC : NON_AMC).some(c => c.code === (isAmc ? clientCode : activeNonAmcCode)));

        $("#v").innerHTML = `
            <div class="top">
                <h1>${(e.variation_no || e.vn) && !(e.rev_no || e.rev) ? "New variation" : (seq ? "Revise quotation" : "New quotation")} <span class="tag">${isAmc ? "AMC client" : "Non-AMC client"}</span></h1>
                <div style="display:flex;gap:6px;align-items:center;flex-wrap:wrap;">
                    <button id="cn">Cancel</button>
                    <button type="button" id="btn_check_grammar_top" style="background:#eef6fc;border:1.5px solid #7BBDE8;color:#0A4174;font-weight:600;display:inline-flex;align-items:center;gap:6px;cursor:pointer;padding:6px 12px;border-radius:6px;">
                        <i class="icon-spell-check" style="font-size:13px;color:#0A4174;"></i> Check Grammar
                    </button>
                    <button type="button" id="sd" class="btn ladda-button" data-style="expand-right" data-spinner-color="#0A4174">
                        <span class="ladda-label"><i class="icon-floppy-disk mr-1"></i> Save draft</span>
                    </button>
                    <button type="button" class="p btn ladda-button" id="is" data-style="expand-right" data-spinner-color="#ffffff">
                        <span class="ladda-label"><i class="icon-paperplane mr-1"></i> Issue quote</span>
                    </button>
                </div>
            </div>
            
            <div class="two">
                <div>
                    <!-- Client Card -->
                    <div class="card pad">
                        <div class="d-flex align-items-center justify-content-between mb-2 pb-1" style="border-bottom:2px solid var(--q-blue-ice);">
                            <h2 style="margin:0;border:none;padding:0;">Client</h2>
                            <div style="display:flex;gap:6px;align-items:center;">
                                <button type="button" id="btn_add_new_customer" class="btn btn-sm" style="font-size:12px;padding:4px 11px;border-radius:7px;background:#eef6fc;border:1.5px solid #7BBDE8;color:#0A4174;font-weight:600;display:inline-flex;align-items:center;gap:6px;cursor:pointer;">
                                    <i class="icon-user-plus" style="font-size:13px;color:#0A4174;"></i> + Add Customer
                                </button>
                                <button type="button" id="btn_edit_current_customer" class="btn btn-sm" style="font-size:12px;padding:4px 11px;border-radius:7px;background:#f0f7fc;border:1.5px solid #c2daeb;color:var(--q-navy-main);font-weight:600;display:${hasCustCode ? 'inline-flex' : 'none'};align-items:center;gap:6px;cursor:pointer;">
                                    <i class="icon-pencil5" style="font-size:13px;color:#0A4174;"></i> Edit Customer
                                </button>
                            </div>
                        </div>
                        ${isAmc ? `
                            <div style="margin-bottom:8px;">
                                <label style="display:block;font-size:11.5px;font-weight:600;color:var(--mut);margin-bottom:3px;">Select AMC Customer</label>
                                <select id="cl" class="form-control select-search" data-placeholder="Select active AMC client…">
                                    <option value="">Select active AMC client…</option>
                                    ${M(AMC, c => `
                                        <option value="${H(c.code)}" ${clientCode == c.code ? "selected" : ""} 
                                            data-id="${H(c.id || '')}"
                                            data-name="${H(c.name || '')}"
                                            data-contact="${H(c.contact || '')}" 
                                            data-address="${H(c.address || '')}"
                                            data-person="${H(c.contact_person || '')}">
                                            ${H(c.code)} · ${H(c.name)}
                                        </option>`
                                    )}
                                </select>
                            </div>
                        ` : `
                            <div style="margin-bottom:8px;">
                                <label style="display:block;font-size:11.5px;font-weight:600;color:var(--mut);margin-bottom:3px;">Select Non-AMC Customer (or type custom details below)</label>
                                <select id="cl_non_amc" class="form-control select-search" data-placeholder="Search or select Non-AMC client…">
                                    <option value="">Search or select Non-AMC client…</option>
                                    ${M(NON_AMC, c => `
                                        <option value="${H(c.code)}" ${activeNonAmcCode == c.code ? "selected" : ""} 
                                            data-id="${H(c.id || '')}"
                                            data-name="${H(c.name || '')}"
                                            data-contact="${H(c.contact || '')}" 
                                            data-address="${H(c.address || '')}"
                                            data-person="${H(c.contact_person || '')}">
                                            ${H(c.code)} · ${H(c.name)} ${c.contact ? `(${H(c.contact)})` : ''}
                                        </option>`
                                    )}
                                </select>
                            </div>
                            <div class="g2" style="margin-bottom:8px;">
                                <div>
                                    <label style="display:block;font-size:11.5px;font-weight:600;color:var(--mut);margin-bottom:3px;">Client Name *</label>
                                    <input type="text" id="inp_client_name" data-k="client_name" placeholder="Client name" value="${H(clientName)}" spellcheck="true" lang="en" autocomplete="off" autocorrect="on" autocapitalize="words">
                                </div>
                                <div>
                                    <label style="display:block;font-size:11.5px;font-weight:600;color:var(--mut);margin-bottom:3px;">Contact Number</label>
                                    <input type="text" id="inp_contact_no" data-k="contact_no" placeholder="Contact number" value="${H(contact)}">
                                </div>
                            </div>
                        `}
                        
                        <div style="margin-bottom:8px;">
                            <label style="display:block;font-size:11.5px;font-weight:600;color:var(--mut);margin-bottom:3px;">Client Address</label>
                            <textarea id="ad" data-k="client_address" rows="2" ${isAmc ? "readonly" : ""} placeholder="${isAmc ? "Address is pulled from the AMC client record" : "Client address"}" spellcheck="true" lang="en" autocomplete="off" autocorrect="on" autocapitalize="sentences">${H(clientAddr)}</textarea>
                        </div>
                        
                        <div class="g2" style="margin-bottom:8px;">
                            <div>
                                <label style="display:block;font-size:11.5px;font-weight:600;color:var(--mut);margin-bottom:3px;">Kind Attention</label>
                                <input type="text" data-k="attention" placeholder="Kind attention" value="${H(attn)}" spellcheck="true" lang="en" autocomplete="off" autocorrect="on" autocapitalize="words">
                            </div>
                            <div>
                                <label style="display:block;font-size:11.5px;font-weight:600;color:var(--mut);margin-bottom:3px;">Quotation Date</label>
                                <input type="date" data-k="quotation_date" value="${date}">
                            </div>
                        </div>
                        
                        <div style="margin-bottom:8px;">
                            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:3px;">
                                <label style="display:block;font-size:11.5px;font-weight:600;color:var(--mut);margin:0;">Subject *</label>
                                <button type="button" id="btn_check_subject" class="btn btn-sm" style="font-size:11px;padding:2px 9px;border-radius:6px;background:#eef6fc;border:1.2px solid #7BBDE8;color:#0A4174;font-weight:600;display:inline-flex;align-items:center;gap:4px;cursor:pointer;" title="Spell & grammar check quotation subject">
                                    <i class="icon-spell-check" style="font-size:12px;color:#0A4174;"></i> Check Subject
                                </button>
                            </div>
                            <input type="text" data-k="subject" placeholder="Subject" value="${H(subj)}" spellcheck="true" lang="en" autocomplete="off" autocorrect="on" autocapitalize="sentences" style="margin-top:0 !important;width:100%;">
                        </div>

                        <div style="margin-bottom:8px;">
                            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:3px;">
                                <label style="display:block;font-size:11.5px;font-weight:600;color:var(--mut);margin:0;">
                                    Internal Notes <small style="color:#b45309;font-weight:600;">(Private reference only — will NOT appear on the quote or PDF)</small>
                                </label>
                            </div>
                            <textarea id="inp_internal_notes" data-k="internal_notes" rows="2" placeholder="e.g. Approved discount by GM, site visit reference, supplier quotation ref, etc." style="width:100%;font-size:12.5px;background:#fffdfa;border-color:#fde68a;" spellcheck="true" lang="en" autocomplete="off" autocorrect="on" autocapitalize="sentences">${H(e.internal_notes || "")}</textarea>
                        </div>
                        
                        <p style="color:var(--mut);margin:12px 0 0;font-size:12px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:6px;">
                            <span>Signed as <b>${H(uName)}</b>, ${H(uTitle)} (from the logged-in profile)</span>
                            <a href="#" id="btn_quick_stamp_sign" style="color:#0A4174;font-weight:600;display:inline-flex;align-items:center;gap:4px;text-decoration:underline;">
                                <i class="icon-stamp" style="font-size:12px;"></i> Stamp & Sign
                            </a>
                        </p>
                        
                        <!-- Sender Mobile Number Option -->
                        <div style="margin-top:10px;padding:9px 12px;background:#f0f7fc;border:1.5px solid #c2daeb;border-radius:8px;">
                            <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px;">
                                <label style="display:inline-flex;align-items:center;gap:8px;font-size:12px;font-weight:600;color:#0A4174;cursor:pointer;margin:0;">
                                    <input type="checkbox" id="chk_include_user_phone" ${includePhone ? "checked" : ""} style="cursor:pointer;width:16px;height:16px;">
                                    <span>Include sender mobile number under name</span>
                                </label>
                                <div id="wrap_user_phone" style="display:${includePhone ? 'inline-flex' : 'none'};align-items:center;gap:6px;">
                                    <label style="font-size:11.5px;font-weight:600;color:#0A4174;margin:0;">Mob / Tel:</label>
                                    <input type="text" id="inp_user_phone" data-k="user_phone" placeholder="e.g. +973 3944 1015" value="${H(userPhone)}" style="width:160px;height:32px;font-size:12px;margin:0;padding:4px 8px;font-weight:600;color:#0A4174;">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Scope of Works Card -->
                    <div class="card pad">
                        <div class="d-flex align-items-center justify-content-between mb-2 pb-1" style="border-bottom:2px solid var(--q-blue-ice);">
                            <h2 style="margin:0;border:none;padding:0;">Scope of works</h2>
                            <div style="display:flex;gap:6px;align-items:center;">
                                <button type="button" id="btn_check_grammar_items" class="btn btn-sm" style="font-size:12px;padding:4px 11px;border-radius:7px;background:#eef6fc;border:1.5px solid #7BBDE8;color:#0A4174;font-weight:600;display:inline-flex;align-items:center;gap:6px;cursor:pointer;">
                                    <i class="icon-spell-check" style="font-size:13px;color:#0A4174;"></i> Spell & Grammar Check
                                </button>
                                <button type="button" id="btn_manage_units" class="btn btn-sm" style="font-size:12px;padding:4px 11px;border-radius:7px;background:#f0f7fc;border:1.5px solid #c2daeb;color:var(--q-navy-main);font-weight:600;display:inline-flex;align-items:center;gap:6px;cursor:pointer;">
                                    <i class="icon-stack2" style="font-size:13px;color:#0A4174;"></i> Manage Units
                                </button>
                            </div>
                        </div>

                        <!-- Merge Line Items Option Box -->
                        <div style="background:#f0f7fc;border:1.5px solid #c2daeb;border-radius:8px;padding:10px 14px;margin-bottom:12px;">
                            <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px;">
                                <label style="display:inline-flex;align-items:center;gap:8px;font-size:12.5px;font-weight:600;color:#0A4174;cursor:pointer;margin:0;">
                                    <input type="checkbox" id="chk_merge_items" ${e.merge_items ? "checked" : ""} style="cursor:pointer;width:16px;height:16px;">
                                    <span>Merge line items with single lump sum total rate</span>
                                </label>
                                <div id="merge_qty_wrap" style="display:${e.merge_items ? 'inline-flex' : 'none'};align-items:center;gap:6px;">
                                    <label style="display:inline-flex;align-items:center;gap:6px;font-size:12px;font-weight:500;color:#475569;cursor:pointer;margin:0;">
                                        <input type="checkbox" id="chk_merge_qty" ${e.merge_qty ? "checked" : ""} style="cursor:pointer;width:15px;height:15px;">
                                        <span>Merge Qty into '1 Lumpsum'</span>
                                    </label>
                                </div>
                            </div>
                            <div id="merged_price_wrap" style="display:${e.merge_items ? 'flex' : 'none'};align-items:center;gap:10px;margin-top:8px;padding-top:8px;border-top:1px dashed #cbd5e1;">
                                <label style="font-size:12px;font-weight:600;color:#0A4174;margin:0;white-space:nowrap;">Lump Sum Total Price (BD) * :</label>
                                <input type="number" step="0.001" min="0" id="inp_merged_price" data-k="merged_lump_sum_price" placeholder="0.000" value="${e.merged_lump_sum_price !== undefined && +e.merged_lump_sum_price > 0 ? e.merged_lump_sum_price : ''}" style="width:140px;height:34px;margin:0;font-weight:700;color:#0A4174;">
                                <small style="color:#64748b;font-size:11.5px;">(If 0 or blank, sum of line item totals is used)</small>
                            </div>
                        </div>
                        <div class="it h">
                            <span style="text-align:center;">Qty</span>
                            <span style="text-align:center;">Unit</span>
                            <span style="text-align:center;">Unit price (BD)</span>
                            <span style="text-align:center;">Total (BD)</span>
                            <span></span>
                        </div>
                        <div id="its"></div>
                        <div style="display:flex;justify-content:flex-start;align-items:center;margin-top:10px;">
                            <button id="ai">+ Add item</button>
                        </div>

                        <!-- VAT & Discount (Positioned at bottom after all line items) -->
                        <div style="margin-top:18px;padding-top:16px;border-top:2px solid var(--q-blue-ice);">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h3 style="margin:0;font-size:13.5px;font-weight:700;color:var(--q-navy-dark);font-family:'Outfit',sans-serif;">
                                    <i class="icon-calculator4 mr-1" style="color:#0A4174;"></i> Pricing, Discount & VAT
                                </h3>
                            </div>
                            <div class="g2" style="margin-top:6px;margin-bottom:14px;">
                                <div>
                                    <label style="display:block;font-size:11.5px;font-weight:600;color:var(--mut);margin-bottom:3px;">Discount (Optional)</label>
                                    <div style="display:flex;gap:4px;">
                                        <input type="number" min="0" step="0.001" data-k="discount_value" placeholder="0.000" value="${discVal}" style="flex:1;height:38px;margin:0;">
                                        <select data-k="discount_type" style="width:75px;height:38px;padding:0 6px;margin:0;">
                                            <option value="amount" ${discType === "amount" ? "selected" : ""}>BD</option>
                                            <option value="percent" ${discType === "percent" ? "selected" : ""}>%</option>
                                        </select>
                                    </div>
                                </div>
                                <div>
                                    <label style="display:block;font-size:11.5px;font-weight:600;color:var(--mut);margin-bottom:3px;">VAT Rate</label>
                                    <select data-k="vat_rate" style="width:100%;height:38px;margin:0;">
                                        ${M([10, 5, 0], v => `<option value="${v}" ${vat == v ? "selected" : ""}>VAT ${v}%</option>`)}
                                    </select>
                                </div>
                            </div>

                            <!-- Real-time calculation summary -->
                            <div id="quote_editor_calc_box" style="background:#f8fafc;border:1.5px solid #e2e8f0;border-radius:10px;padding:12px 16px;">
                                <div id="quote_editor_calc_summary"></div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Terms and Conditions Card -->
                    <div class="card pad">
                        <div class="d-flex align-items-center justify-content-between mb-2 pb-1" style="border-bottom:2px solid var(--q-blue-ice);">
                            <h2 style="margin:0;border:none;padding:0;">Terms and conditions <small style="color:var(--mut);font-weight:400;">edit freely for this quote</small></h2>
                            <button type="button" id="btn_check_grammar_terms" class="btn btn-sm" style="font-size:12px;padding:4px 11px;border-radius:7px;background:#eef6fc;border:1.5px solid #7BBDE8;color:#0A4174;font-weight:600;display:inline-flex;align-items:center;gap:6px;cursor:pointer;">
                                <i class="icon-spell-check" style="font-size:13px;color:#0A4174;"></i> Check Terms
                            </button>
                        </div>
                        <div id="tm"></div>
                        <div class="g2">
                            <select id="lib">
                                <option value="">Add from library…</option>
                                ${M(LIB, t => `<option value="${H(t)}">${H(t)}</option>`)}
                            </select>
                            <button id="at" style="margin-top:8px;">+ Blank term</button>
                        </div>
                        <button id="rs" style="margin-top:8px;">Reset to default terms</button>
                    </div>
                </div>
                
                <div id="pv"></div>
            </div>`;

        renderItems();
        renderTerms();
        renderLivePreview();

        // Reactive input and change handler
        const handleFormInput = ev => {
            const t = ev.target;
            const k = t.dataset.k;
            if (k) {
                if (k === "vat_rate") {
                    ED.vat_rate = +t.value;
                    ED.vat = +t.value;
                } else if (k === "discount_value") {
                    ED.discount_value = +t.value || 0;
                    ED.discount = ED.discount_value;
                } else if (k === "discount_type") {
                    ED.discount_type = t.value;
                } else {
                    ED[k] = t.value;
                }
                if (k === "client_name") {
                    ED.client = t.value;
                    const curCode = ED.client_code || ED.code;
                    const currentObj = (NON_AMC.concat(AMC)).find(c => c.code === curCode);
                    if (currentObj && currentObj.name.toLowerCase() !== t.value.trim().toLowerCase()) {
                        const another = (NON_AMC.concat(AMC)).find(c => c.name.toLowerCase() === t.value.trim().toLowerCase());
                        if (another) {
                            ED.client_code = another.code;
                            ED.code = another.code;
                        }
                    }
                    updateEditCustomerButtonVisibility();
                }
                if (k === "contact_no") ED.contact = t.value;
                if (k === "client_address") ED.addr = t.value;
                if (k === "attention") ED.attn = t.value;
                if (k === "quotation_date") ED.date = t.value;
                if (k === "subject") ED.subj = t.value;
                if (k === "internal_notes") ED.internal_notes = t.value;
                if (k === "user_phone") ED.user_phone = t.value;
                if (k === "merged_lump_sum_price") ED.merged_lump_sum_price = +t.value || 0;
            } else if (t.dataset.f !== undefined) {
                const idx = +t.dataset.i;
                const field = t.dataset.f;
                const item = ED.items[idx];
                if (field === "desc") item.description = t.value;
                else if (field === "qty") item.quantity = +t.value || 0;
                else if (field === "unit") item.unit = t.value;
                else if (field === "price") item.unit_price = +t.value || 0;

                const lineTot = itemTotal(item);
                const elTot = $("#rt" + idx);
                if (elTot) elTot.textContent = f3(lineTot);
            } else if (t.dataset.t !== undefined) {
                ED.terms[+t.dataset.t] = t.value;
            } else {
                return;
            }
            renderLivePreview();
        };

        $("#v").oninput = handleFormInput;
        $("#v").onchange = handleFormInput;

        const chkMerge = $("#chk_merge_items");
        const chkQty = $("#chk_merge_qty");
        const inpMerged = $("#inp_merged_price");
        const wrapQty = $("#merge_qty_wrap");
        const wrapPrice = $("#merged_price_wrap");

        if (chkMerge) {
            chkMerge.onchange = e => {
                ED.merge_items = e.target.checked ? 1 : 0;
                if (wrapQty) wrapQty.style.display = ED.merge_items ? "inline-flex" : "none";
                if (wrapPrice) wrapPrice.style.display = ED.merge_items ? "flex" : "none";
                renderLivePreview();
            };
        }
        if (chkQty) {
            chkQty.onchange = e => {
                ED.merge_qty = e.target.checked ? 1 : 0;
                renderLivePreview();
            };
        }
        if (inpMerged) {
            inpMerged.oninput = e => {
                ED.merged_lump_sum_price = +e.target.value || 0;
                renderLivePreview();
            };
        }

        const chkSenderPhone = $("#chk_include_user_phone");
        const wrapSenderPhone = $("#wrap_user_phone");
        const inpSenderPhone = $("#inp_user_phone");
        if (chkSenderPhone) {
            chkSenderPhone.onchange = ev => {
                ED.include_user_phone = ev.target.checked ? 1 : 0;
                if (wrapSenderPhone) wrapSenderPhone.style.display = ev.target.checked ? "inline-flex" : "none";
                if (ev.target.checked && inpSenderPhone && !inpSenderPhone.value.trim() && defaultPhone) {
                    inpSenderPhone.value = defaultPhone;
                    ED.user_phone = defaultPhone;
                }
                renderLivePreview();
            };
        }
        if (inpSenderPhone) {
            inpSenderPhone.oninput = ev => {
                ED.user_phone = ev.target.value;
                renderLivePreview();
            };
        }

        const btnQuickSign = $("#btn_quick_stamp_sign");
        if (btnQuickSign) {
            btnQuickSign.onclick = ev => {
                ev.preventDefault();
                openStampSignModal();
            };
        }

        const updateEditCustomerButtonVisibility = function () {
            const btnEdit = $("#btn_edit_current_customer");
            if (!btnEdit) return;
            const curCode = ED.client_code || ED.code;
            const exists = (AMC.concat(NON_AMC)).some(c => c.code === curCode);
            btnEdit.style.display = (exists && curCode) ? "inline-flex" : "none";
        };

        const handleClientSelection = function (selCode) {
            const found = AMC.find(x => x.code === selCode);
            ED.client_code = found ? found.code : "";
            ED.code = ED.client_code;
            ED.client_name = found ? found.name : "";
            ED.client = ED.client_name;
            ED.client_address = found ? found.address : "";
            ED.addr = ED.client_address;
            ED.contact_no = found ? found.contact : "";
            ED.contact = ED.contact_no;
            if (found && found.contact_person && (!ED.attention || ED.attention === "")) {
                ED.attention = found.contact_person;
                ED.attn = ED.attention;
                const attnField = $('[data-k="attention"]');
                if (attnField) attnField.value = ED.attention;
            }
            const adField = $("#ad");
            if (adField) adField.value = ED.client_address;
            updateEditCustomerButtonVisibility();
            renderLivePreview();
        };

        const handleNonAmcSelection = function (selCode) {
            const found = NON_AMC.find(x => x.code === selCode);
            ED.client_code = found ? found.code : "";
            ED.code = ED.client_code;
            ED.client_name = found ? found.name : "";
            ED.client = ED.client_name;
            ED.client_address = found ? found.address : "";
            ED.addr = ED.client_address;
            ED.contact_no = found ? found.contact : "";
            ED.contact = ED.contact_no;
            if (found && found.contact_person && (!ED.attention || ED.attention === "")) {
                ED.attention = found.contact_person;
                ED.attn = ED.attention;
                const attnField = $('[data-k="attention"]');
                if (attnField) attnField.value = ED.attention;
            }

            const inpName = $("#inp_client_name");
            if (inpName) inpName.value = ED.client_name;
            const inpContact = $("#inp_contact_no");
            if (inpContact) inpContact.value = ED.contact_no;
            const adField = $("#ad");
            if (adField) adField.value = ED.client_address;

            updateEditCustomerButtonVisibility();
            renderLivePreview();
        };

        const clEl = $("#cl");
        if (clEl) {
            clEl.onchange = ev => handleClientSelection(ev.target.value);

            if (window.jQuery && typeof window.jQuery.fn.select2 === "function") {
                const $cl = window.jQuery(clEl);
                if ($cl.data('select2')) {
                    $cl.select2('destroy');
                }
                $cl.select2({
                    width: '100%',
                    placeholder: 'Select active AMC client…',
                    allowClear: true,
                    matcher: function (params, data) {
                        if (!params.term || window.jQuery.trim(params.term) === '') {
                            return data;
                        }
                        if (typeof data.text === 'undefined') {
                            return null;
                        }
                        const term = params.term.toLowerCase();
                        const text = data.text.toLowerCase();
                        const contact = (data.element && data.element.dataset.contact) ? data.element.dataset.contact.toLowerCase() : '';
                        const address = (data.element && data.element.dataset.address) ? data.element.dataset.address.toLowerCase() : '';
                        if (text.indexOf(term) > -1 || contact.indexOf(term) > -1 || address.indexOf(term) > -1) {
                            return data;
                        }
                        return null;
                    }
                }).on('change', function () {
                    handleClientSelection(this.value);
                });
            }
        }

        const clNonAmcEl = $("#cl_non_amc");
        if (clNonAmcEl) {
            clNonAmcEl.onchange = ev => handleNonAmcSelection(ev.target.value);

            if (window.jQuery && typeof window.jQuery.fn.select2 === "function") {
                const $clNa = window.jQuery(clNonAmcEl);
                if ($clNa.data('select2')) {
                    $clNa.select2('destroy');
                }
                $clNa.select2({
                    width: '100%',
                    placeholder: 'Search or select Non-AMC client…',
                    allowClear: true,
                    matcher: function (params, data) {
                        if (!params.term || window.jQuery.trim(params.term) === '') {
                            return data;
                        }
                        if (typeof data.text === 'undefined') {
                            return null;
                        }
                        const term = params.term.toLowerCase();
                        const text = data.text.toLowerCase();
                        const contact = (data.element && data.element.dataset.contact) ? data.element.dataset.contact.toLowerCase() : '';
                        const address = (data.element && data.element.dataset.address) ? data.element.dataset.address.toLowerCase() : '';
                        const person = (data.element && data.element.dataset.person) ? data.element.dataset.person.toLowerCase() : '';
                        if (text.indexOf(term) > -1 || contact.indexOf(term) > -1 || address.indexOf(term) > -1 || person.indexOf(term) > -1) {
                            return data;
                        }
                        return null;
                    }
                }).on('change', function () {
                    handleNonAmcSelection(this.value);
                });
            }
        }

        updateEditCustomerButtonVisibility();

        const btnAddCust = $("#btn_add_new_customer");
        if (btnAddCust) {
            btnAddCust.onclick = () => openCustomerMasterModal(null);
        }

        const btnEditCust = $("#btn_edit_current_customer");
        if (btnEditCust) {
            btnEditCust.onclick = () => {
                const curCode = ED.client_code || ED.code;
                const cust = (AMC.concat(NON_AMC)).find(c => c.code === curCode);
                if (cust) {
                    openCustomerMasterModal(cust);
                } else {
                    notifySwal("Notice", "Please select a customer to edit.", "info");
                }
            };
        }

        $("#lib").onchange = ev => {
            if (ev.target.value) {
                ED.terms.push(ev.target.value);
                ev.target.value = "";
                renderTerms();
                renderLivePreview();
            }
        };

        $("#at").onclick = () => {
            ED.terms.push("");
            renderTerms();
            renderLivePreview();
        };

        $("#rs").onclick = () => {
            ED.terms = T0.slice();
            renderTerms();
            renderLivePreview();
        };

        $("#ai").onclick = () => {
            ED.items.push({ description: "", quantity: 1, unit: "Lumpsum", unit_price: 0, total_price: 0 });
            renderItems();
            renderLivePreview();
        };

        const btnManageUnits = $("#btn_manage_units");
        if (btnManageUnits) {
            btnManageUnits.onclick = () => openUnitMasterModal();
        }

        const btnCheckTop = $("#btn_check_grammar_top");
        if (btnCheckTop) {
            btnCheckTop.onclick = () => runQuotationGrammarCheck("all");
        }

        const btnCheckSubject = $("#btn_check_subject");
        if (btnCheckSubject) {
            btnCheckSubject.onclick = () => runQuotationGrammarCheck("subject");
        }

        const btnCheckItems = $("#btn_check_grammar_items");
        if (btnCheckItems) {
            btnCheckItems.onclick = () => runQuotationGrammarCheck("items");
        }

        const btnCheckTerms = $("#btn_check_grammar_terms");
        if (btnCheckTerms) {
            btnCheckTerms.onclick = () => runQuotationGrammarCheck("terms");
        }

        $("#its").onclick = ev => {
            const btn = ev.target.closest("[data-rm]");
            if (btn && ED.items.length > 1) {
                ED.items.splice(+btn.dataset.rm, 1);
                renderItems();
                renderLivePreview();
                return;
            }
            const btnBullet = ev.target.closest(".btn-toggle-bullet");
            if (btnBullet) {
                ev.preventDefault();
                toggleBulletInItem(+btnBullet.dataset.bulletIdx);
                return;
            }
            const btnBold = ev.target.closest(".btn-toggle-bold");
            if (btnBold) {
                ev.preventDefault();
                formatItemText(+btnBold.dataset.boldIdx, "bold");
                return;
            }
            const btnUnderline = ev.target.closest(".btn-toggle-underline");
            if (btnUnderline) {
                ev.preventDefault();
                formatItemText(+btnUnderline.dataset.underlineIdx, "underline");
                return;
            }
        };

        $("#its").onkeydown = ev => {
            handleItemDescKeydown(ev);
        };

        $("#tm").onclick = ev => {
            const btn = ev.target.closest("[data-x]");
            if (btn) {
                ED.terms.splice(+btn.dataset.x, 1);
                renderTerms();
                renderLivePreview();
            }
        };

        $("#cn").onclick = () => {
            if (ED.id) vq(ED.id);
            else go("log");
        };

        $("#sd").onclick = (ev) => {
            if (ev) ev.preventDefault();
            saveQuotationApi(false);
        };

        $("#is").onclick = (ev) => {
            if (ev) ev.preventDefault();
            const e = ED;
            const cName = e.client_name || e.client;
            const cCode = e.client_code || e.code;
            const isAmc = xIsAmc(e);
            const subj = e.subject || e.subj || "";

            if (!cName || (isAmc && !cCode)) {
                return toast(isAmc ? "Select an AMC client" : "Enter the client name");
            }
            if (!subj.trim()) {
                return toast("Subject is required");
            }
            if (e.items.some(r => {
                const desc = r.description !== undefined ? r.description : r[0];
                const qty = r.quantity !== undefined ? r.quantity : r[1];
                return !desc.trim() || !(qty > 0);
            })) {
                return toast("Every item needs a description and quantity");
            }

            saveQuotationApi(true);
        };
    }

    function renderLivePreview() {
        const pv = $("#pv");
        if (pv && ED) {
            pv.innerHTML = sheet(ED);
        }
        const sumEl = $("#quote_editor_calc_summary");
        if (sumEl && ED) {
            const sSub = amt(ED);
            const sDiscAmt = discAmount(ED);
            const sNet = netAmt(ED);
            const sTot = tot(ED);
            const sVat = (ED.vat_rate !== undefined ? ED.vat_rate : (ED.vat || 10));
            const sVatVal = (sNet * sVat) / 100;

            if (sDiscAmt > 0) {
                sumEl.innerHTML = `
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:4px;font-size:12.5px;color:#475569;">
                        <span>Gross Subtotal:</span>
                        <b style="color:#1e293b;">${f3(sSub)} BD</b>
                    </div>
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:4px;font-size:12.5px;color:#b91c1c;">
                        <span>Less Discount:</span>
                        <b>-${f3(sDiscAmt)} BD</b>
                    </div>
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:4px;font-size:12.5px;color:#475569;">
                        <span>Net Amount (Excl. VAT):</span>
                        <b style="color:#1e293b;">${f3(sNet)} BD</b>
                    </div>
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:6px;font-size:12.5px;color:#475569;">
                        <span>VAT (${sVat}%):</span>
                        <b style="color:#1e293b;">${f3(sVatVal)} BD</b>
                    </div>
                    <div style="display:flex;justify-content:space-between;align-items:center;padding-top:6px;border-top:1.5px dashed #cbd5e1;font-size:13.5px;color:#001D39;">
                        <span style="font-weight:700;">Total Amount (Incl. VAT):</span>
                        <b style="color:#0A4174;font-size:15px;font-weight:700;">${f3(sTot)} BD</b>
                    </div>`;
            } else {
                sumEl.innerHTML = `
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:4px;font-size:12.5px;color:#475569;">
                        <span>Amount (Excl. VAT):</span>
                        <b style="color:#1e293b;">${f3(sSub)} BD</b>
                    </div>
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:6px;font-size:12.5px;color:#475569;">
                        <span>VAT (${sVat}%):</span>
                        <b style="color:#1e293b;">${f3(sVatVal)} BD</b>
                    </div>
                    <div style="display:flex;justify-content:space-between;align-items:center;padding-top:6px;border-top:1.5px dashed #cbd5e1;font-size:13.5px;color:#001D39;">
                        <span style="font-weight:700;">Total Amount (Incl. VAT):</span>
                        <b style="color:#0A4174;font-size:15px;font-weight:700;">${f3(sTot)} BD</b>
                    </div>`;
            }
        }
    }

    function toggleBulletInItem(idx) {
        if (!ED || !ED.items || !ED.items[idx]) return;
        const ta = $(`textarea[data-i="${idx}"][data-f="desc"]`);
        if (!ta) return;

        const val = ta.value || "";
        const selStart = ta.selectionStart !== undefined ? ta.selectionStart : val.length;
        const selEnd = ta.selectionEnd !== undefined ? ta.selectionEnd : val.length;

        if (!val.trim()) {
            ta.value = "• ";
            ta.focus();
            ta.setSelectionRange(2, 2);
            ED.items[idx].description = ta.value;
            renderLivePreview();
            return;
        }

        const lineStart = val.lastIndexOf("\n", selStart - 1) + 1;
        let lineEnd = val.indexOf("\n", selEnd);
        if (lineEnd === -1) lineEnd = val.length;

        const targetBlock = val.substring(lineStart, lineEnd);
        const lines = targetBlock.split("\n");

        const nonBlankLines = lines.filter(l => l.trim().length > 0);
        const allBulleted = nonBlankLines.length > 0 && nonBlankLines.every(l => /^[\u2022\-\*]\s*/.test(l.trim()));

        const newLines = lines.map(l => {
            const trimmed = l.trim();
            if (!trimmed) return l;
            if (allBulleted) {
                return l.replace(/^(\s*)[\u2022\-\*]\s*/, "$1");
            } else {
                if (/^[\u2022\-\*]\s*/.test(trimmed)) return l;
                return "• " + l.replace(/^\s*/, "");
            }
        });

        const newBlock = newLines.join("\n");
        ta.value = val.substring(0, lineStart) + newBlock + val.substring(lineEnd);
        ta.focus();
        ta.setSelectionRange(lineStart, lineStart + newBlock.length);
        ED.items[idx].description = ta.value;
        renderLivePreview();
    }

    function formatItemText(idx, formatType) {
        if (!ED || !ED.items || !ED.items[idx]) return;
        const ta = $(`textarea[data-i="${idx}"][data-f="desc"]`);
        if (!ta) return;

        const val = ta.value || "";
        const selStart = ta.selectionStart;
        const selEnd = ta.selectionEnd;

        const tagOpen = formatType === "bold" ? "<b>" : "<u>";
        const tagClose = formatType === "bold" ? "</b>" : "</u>";
        const tagLen = tagOpen.length;
        const closeLen = tagClose.length;

        // Case 1: User has selected text
        if (selStart !== undefined && selEnd !== undefined && selStart !== selEnd) {
            const beforeSel = val.substring(0, selStart);
            const selected = val.substring(selStart, selEnd);
            const afterSel = val.substring(selEnd);

            if (selected.startsWith(tagOpen) && selected.endsWith(tagClose) && selected.length >= tagLen + closeLen) {
                const unwrapped = selected.substring(tagLen, selected.length - closeLen);
                ta.value = beforeSel + unwrapped + afterSel;
                ta.focus();
                ta.setSelectionRange(selStart, selStart + unwrapped.length);
            } else if (beforeSel.endsWith(tagOpen) && afterSel.startsWith(tagClose)) {
                const newBefore = beforeSel.substring(0, beforeSel.length - tagLen);
                const newAfter = afterSel.substring(closeLen);
                ta.value = newBefore + selected + newAfter;
                ta.focus();
                ta.setSelectionRange(selStart - tagLen, selEnd - tagLen);
            } else {
                const wrapped = tagOpen + selected + tagClose;
                ta.value = beforeSel + wrapped + afterSel;
                ta.focus();
                ta.setSelectionRange(selStart, selStart + wrapped.length);
            }
        } 
        // Case 2: No text selected (cursor is at a position)
        else {
            const pos = selStart !== undefined ? selStart : val.length;
            const lineStart = val.lastIndexOf("\n", pos - 1) + 1;
            let lineEnd = val.indexOf("\n", pos);
            if (lineEnd === -1) lineEnd = val.length;

            const currentLine = val.substring(lineStart, lineEnd);
            const trimmedLine = currentLine.trim();

            if (!trimmedLine) {
                const ins = tagOpen + tagClose;
                ta.value = val.substring(0, pos) + ins + val.substring(pos);
                ta.focus();
                ta.setSelectionRange(pos + tagLen, pos + tagLen);
            } else if (trimmedLine.startsWith(tagOpen) && trimmedLine.endsWith(tagClose) && trimmedLine.length >= tagLen + closeLen) {
                const leadingSpace = currentLine.match(/^\s*/)[0];
                const trailingSpace = currentLine.match(/\s*$/)[0];
                const unwrapped = leadingSpace + trimmedLine.substring(tagLen, trimmedLine.length - closeLen) + trailingSpace;
                ta.value = val.substring(0, lineStart) + unwrapped + val.substring(lineEnd);
                ta.focus();
                ta.setSelectionRange(lineStart + leadingSpace.length, lineStart + unwrapped.length - trailingSpace.length);
            } else {
                const bulletMatch = currentLine.match(/^(\s*[\u2022\-\*]\s*)(.*)$/);
                let newLine = "";
                if (bulletMatch) {
                    newLine = bulletMatch[1] + tagOpen + bulletMatch[2] + tagClose;
                } else {
                    newLine = tagOpen + currentLine + tagClose;
                }
                ta.value = val.substring(0, lineStart) + newLine + val.substring(lineEnd);
                ta.focus();
                ta.setSelectionRange(lineStart, lineStart + newLine.length);
            }
        }

        ED.items[idx].description = ta.value;
        renderLivePreview();
    }

    function handleItemDescKeydown(ev) {
        const ta = ev.target;
        if (!ta || ta.dataset.f !== "desc") return;

        // Ctrl+B (Bold) or Ctrl+U (Underline)
        if (ev.ctrlKey || ev.metaKey) {
            const k = (ev.key || "").toLowerCase();
            if (k === "b") {
                ev.preventDefault();
                formatItemText(+ta.dataset.i, "bold");
                return;
            }
            if (k === "u") {
                ev.preventDefault();
                formatItemText(+ta.dataset.i, "underline");
                return;
            }
        }

        // Enter key bullet continuation
        if (ev.key === "Enter" && !ev.shiftKey && !ev.ctrlKey && !ev.altKey) {
            const val = ta.value;
            const pos = ta.selectionStart;
            const lineStart = val.lastIndexOf("\n", pos - 1) + 1;
            const currentLine = val.substring(lineStart, pos);

            const bulletMatch = currentLine.match(/^(\s*)([\u2022\-\*]\s*)/);
            if (bulletMatch) {
                ev.preventDefault();
                const indent = bulletMatch[1];
                const contentAfterBullet = currentLine.substring(bulletMatch[0].length).trim();

                if (!contentAfterBullet) {
                    ta.value = val.substring(0, lineStart) + val.substring(pos);
                    ta.setSelectionRange(lineStart, lineStart);
                } else {
                    const insertText = "\n" + indent + "• ";
                    ta.value = val.substring(0, pos) + insertText + val.substring(pos);
                    const newPos = pos + insertText.length;
                    ta.setSelectionRange(newPos, newPos);
                }
                const idx = +ta.dataset.i;
                if (ED && ED.items && ED.items[idx]) {
                    ED.items[idx].description = ta.value;
                }
                renderLivePreview();
            }
        }
    }

    function renderItems() {
        const el = $("#its");
        if (!el || !ED) return;
        el.innerHTML = M(ED.items, (r, i) => {
            const desc = r.description !== undefined ? r.description : (r[0] || "");
            const qty = r.quantity !== undefined ? r.quantity : (r[1] !== undefined ? r[1] : 1);
            const unit = r.unit !== undefined ? r.unit : (r[2] || "Lumpsum");
            const price = r.unit_price !== undefined ? r.unit_price : (r[3] || 0);
            const lineTot = itemTotal(r);

            const unitOptions = [...UNITS];
            if (unit && !unitOptions.includes(unit)) {
                unitOptions.unshift(unit);
            }

            const itemLabel = `Item #${i + 1}`;

            return `
            <div class="it">
                <div style="grid-column:1/-1;margin-bottom:6px;">
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:6px;">
                        <span style="font-size:11.5px;font-weight:700;color:#0A4174;text-transform:uppercase;letter-spacing:0.3px;">
                            ${itemLabel}
                        </span>
                        <div style="display:inline-flex;align-items:center;gap:4px;">
                            <button type="button" class="btn-toggle-bold" data-bold-idx="${i}" title="Bold selected text (Ctrl+B)" style="padding:2px 8px;font-size:11.5px;background:#f8fafc;border:1px solid #cbd5e1;border-radius:4px;color:#0A4174;font-weight:700;cursor:pointer;display:inline-flex;align-items:center;">
                                <b>B</b>
                            </button>
                            <button type="button" class="btn-toggle-underline" data-underline-idx="${i}" title="Underline selected text (Ctrl+U)" style="padding:2px 8px;font-size:11.5px;background:#f8fafc;border:1px solid #cbd5e1;border-radius:4px;color:#0A4174;font-weight:600;text-decoration:underline;cursor:pointer;display:inline-flex;align-items:center;">
                                <u>U</u>
                            </button>
                            <button type="button" class="btn-toggle-bullet" data-bullet-idx="${i}" title="Insert bullet point (•) or toggle bulleted list in description" style="padding:2px 8px;font-size:11px;background:#eef6fc;border:1px solid #7BBDE8;border-radius:4px;color:#0A4174;font-weight:600;cursor:pointer;display:inline-flex;align-items:center;gap:4px;">
                                <span style="font-size:13px;line-height:1;">&bull;</span> Bullet
                            </button>
                        </div>
                    </div>
                    <textarea data-i="${i}" data-f="desc" rows="2" placeholder="Description of work (select text to Bold / Underline)..." spellcheck="true" lang="en" autocomplete="off" autocorrect="on" autocapitalize="sentences">${H(desc)}</textarea>
                </div>
                <input type="number" min="0" data-i="${i}" data-f="qty" value="${qty}" style="text-align:center;">
                <select data-i="${i}" data-f="unit" style="text-align:center;text-align-last:center;">
                    ${M(unitOptions, u => `<option value="${H(u)}"${u === unit ? " selected" : ""}>${H(u)}</option>`)}
                </select>
                <input type="number" min="0" step="0.001" data-i="${i}" data-f="price" value="${price}" style="text-align:center;">
                <b id="rt${i}" style="text-align:center;">${f3(lineTot)}</b>
                <button data-rm="${i}" title="Remove item" style="background:#fee2e2;border:1px solid #fca5a5;color:#b91c1c;border-radius:6px;width:34px;height:34px;cursor:pointer;display:inline-flex;align-items:center;justify-content:center;font-weight:bold;">✕</button>
            </div>`;
        });
    }

    function renderTerms() {
        const el = $("#tm");
        if (!el || !ED) return;
        el.innerHTML = M(ED.terms, (t, i) => `
            <div class="tr">
                <textarea rows="2" data-t="${i}" spellcheck="true" lang="en" autocomplete="off" autocorrect="on" autocapitalize="sentences">${H(t)}</textarea>
                <button data-x="${i}" title="Remove">✕</button>
            </div>`
        );
    }

    // ==========================================
    // VIEW 4: PERFORMANCE (vperf)
    // ==========================================
    function vperf() {
        const R = Object.keys(USERS).map(u => {
            const uInfo = USERS[u];
            const uName = Array.isArray(uInfo) ? uInfo[0] : uInfo.name;
            const uTitle = Array.isArray(uInfo) ? uInfo[1] : uInfo.title;

            const S = Q.filter(x => (x.user_code || x.user) === u && SENT.includes(x.status || x.st));
            const A = S.filter(x => (x.status || x.st) === "Approved");
            const NA = S.filter(x => (x.status || x.st) === "Not approved");
            const P = S.filter(x => (x.status || x.st) === "Pending");

            return {
                u,
                name: uName,
                title: uTitle,
                n: S.length,
                a: A.length,
                r: NA.length,
                p: P.length,
                ve: sm(S, netAmt),
                vi: sm(S, tot),
                av: sm(A, tot)
            };
        });

        const activeUser = R.find(r => r.u === CU) || R[0] || { n: 0, a: 0, r: 0, p: 0, av: 0 };
        const appRate = activeUser.n ? Math.round((activeUser.a / activeUser.n) * 100) + "%" : "—";

        $("#v").innerHTML = `
            <div class="top">
                <h1>My performance · ${H(activeUser.name || currentUserObj.name)}</h1>
            </div>
            
            <div class="kpis">
                ${M([
                    ["Quotes sent", activeUser.n],
                    ["Approved", activeUser.a],
                    ["Not approved", activeUser.r],
                    ["Pending", activeUser.p],
                    ["Approval rate", appRate],
                    ["Approved value · incl. VAT", f3(activeUser.av)]
                ], k => `
                    <div class="card kpi">
                        <span>${k[0]}</span>
                        <strong>${k[1]}</strong>
                    </div>`
                )}
            </div>
            
            <h2 style="margin-top:22px;margin-bottom:8px;">Team</h2>
            <div class="card tw">
                <table class="lg">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Sent</th>
                            <th>Approved</th>
                            <th>Not approved</th>
                            <th>Pending</th>
                            <th>Sent · excl. VAT</th>
                            <th>Sent · incl. VAT</th>
                            <th>Approved · incl. VAT</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${M(R, r => `
                            <tr class="${r.u === CU ? "me" : ""}">
                                <td>
                                    <b>${H(r.name)}</b><br>
                                    <small>${H(r.title)}</small>
                                </td>
                                <td>${r.n}</td>
                                <td>${r.a}</td>
                                <td>${r.r}</td>
                                <td>${r.p}</td>
                                <td>${f3(r.ve)}</td>
                                <td>${f3(r.vi)}</td>
                                <td><b>${f3(r.av)}</b></td>
                            </tr>`
                        )}
                    </tbody>
                </table>
            </div>`;
    }

    // ==========================================
    // BACKEND API INTEGRATION
    // ==========================================
    const API_URL = "../controller/quotation/quotation_module_controller.php";

    function apiCall(action, data = {}, method = "POST") {
        let url = `${API_URL}?action=${encodeURIComponent(action)}`;
        let options = { method: method };

        if (method === "POST") {
            options.headers = { "Content-Type": "application/json" };
            options.body = JSON.stringify(data);
        } else if (method === "GET") {
            const params = new URLSearchParams(data).toString();
            if (params) url += "&" + params;
        }

        return fetch(url, options)
            .then(res => {
                if (!res.ok) throw new Error("HTTP error " + res.status);
                return res.json();
            })
            .catch(err => {
                console.warn("Backend API warning (using local state fallback):", err);
                return null;
            });
    }

    // ==========================================
    // SWEETALERT & MODAL HELPERS
    // ==========================================
    function confirmSwal(title, text, confirmCallback) {
        if (typeof window.swal === "function") {
            window.swal({
                title: title,
                text: text,
                icon: "warning",
                buttons: {
                    cancel: {
                        text: "Cancel",
                        value: null,
                        visible: true,
                        className: "btn btn-light",
                        closeModal: true
                    },
                    confirm: {
                        text: "Yes, Delete",
                        value: true,
                        visible: true,
                        className: "btn btn-danger",
                        closeModal: true
                    }
                },
                dangerMode: true,
                showCancelButton: true
            }).then(willConfirm => {
                if (willConfirm) {
                    confirmCallback();
                }
            });
        } else if (window.Swal && typeof window.Swal.fire === "function") {
            window.Swal.fire({
                title: title,
                text: text,
                type: "warning",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#ef4444",
                cancelButtonColor: "#64748b",
                confirmButtonText: "Yes, Delete"
            }).then(result => {
                if (result && (result.value === true || result.isConfirmed === true)) {
                    confirmCallback();
                }
            });
        } else {
            if (confirm(text ? `${title}\n${text}` : title)) {
                confirmCallback();
            }
        }
    }

    function notifySwal(title, text, type = "success") {
        if (typeof window.swal === "function") {
            window.swal(title, text, type);
        } else if (window.Swal && typeof window.Swal.fire === "function") {
            window.Swal.fire(title, text, type);
        } else {
            toast(text || title);
        }
    }

    // ==========================================
    // UNIT MASTER MODAL & MANAGEMENT
    // ==========================================
    function showModal(selector) {
        const modalEl = $(selector);
        if (!modalEl) return;
        if (window.jQuery && typeof window.jQuery.fn.modal === "function") {
            window.jQuery(selector).modal("show");
        } else {
            modalEl.classList.add("show");
            modalEl.style.display = "block";
            let bd = $(".modal-backdrop-custom");
            if (!bd) {
                bd = document.createElement("div");
                bd.className = "modal-backdrop fade show modal-backdrop-custom";
                document.body.appendChild(bd);
            }
        }
    }

    function hideModal(selector) {
        const modalEl = $(selector);
        if (!modalEl) return;
        if (window.jQuery && typeof window.jQuery.fn.modal === "function") {
            window.jQuery(selector).modal("hide");
        } else {
            modalEl.classList.remove("show");
            modalEl.style.display = "none";
            const bd = $(".modal-backdrop-custom");
            if (bd) bd.remove();
        }
    }

    function openUnitMasterModal() {
        const inp = $("#input_new_unit");
        if (inp) inp.value = "";
        const filterInp = $("#filter_unit_list");
        if (filterInp) filterInp.value = "";

        // Fetch fresh units from server
        apiCall("get_units", {}, "GET").then(res => {
            if (res && res.status === "success" && Array.isArray(res.units)) {
                unitMasterList = res.units;
                UNITS = res.units.map(u => typeof u === "string" ? u : (u.name || ""));
            }
            renderUnitMasterList();
            showModal("#modal_unit_master");
            setTimeout(() => {
                const addInput = $("#input_new_unit");
                if (addInput) addInput.focus();
            }, 250);
        });
    }

    function renderUnitMasterList(filterQuery = "") {
        const c = $("#unit_master_list_container");
        if (!c) return;

        const q = (filterQuery || "").trim().toLowerCase();
        const list = unitMasterList.filter(u => {
            const name = typeof u === "string" ? u : (u.name || "");
            return !q || name.toLowerCase().includes(q);
        });

        const badge = $("#unit_count_badge");
        if (badge) badge.textContent = unitMasterList.length;

        if (list.length === 0) {
            c.innerHTML = `<div class="p-3 text-center text-muted font-size-sm">No units found${q ? ' matching "' + H(q) + '"' : ''}</div>`;
            return;
        }

        c.innerHTML = `
        <table class="table table-sm table-hover mb-0" style="font-size:13px;">
            <thead class="bg-light text-muted font-size-xs text-uppercase font-weight-bold" style="position:sticky;top:0;z-index:2;background:#f8fafc;">
                <tr>
                    <th style="width:40px;text-align:center;">#</th>
                    <th>Unit Name</th>
                    <th style="width:70px;text-align:center;">Action</th>
                </tr>
            </thead>
            <tbody>
                ${M(list, (u, idx) => {
                    const uName = typeof u === "string" ? u : (u.name || "");
                    const uId = typeof u === "object" && u.id ? u.id : "";
                    return `
                    <tr style="border-bottom:1px solid #f1f5f9;">
                        <td class="text-center text-muted" style="vertical-align:middle;font-size:11.5px;">${idx + 1}</td>
                        <td style="vertical-align:middle;">
                            <span class="badge" style="background:#e0f2fe;color:#0369a1;font-size:12.5px;padding:4px 9px;border-radius:6px;font-weight:600;letter-spacing:0.3px;">
                                ${H(uName)}
                            </span>
                        </td>
                        <td class="text-center" style="vertical-align:middle;">
                            <button type="button" class="btn btn-sm btn-del-unit" data-id="${uId}" data-name="${H(uName)}" title="Delete unit" style="background:transparent;border:none;color:#ef4444;padding:4px 8px;border-radius:4px;cursor:pointer;">
                                <i class="icon-trash" style="font-size:13px;"></i>
                            </button>
                        </td>
                    </tr>`;
                })}
            </tbody>
        </table>`;
    }

    function setupUnitMasterEvents() {
        // Subnav button
        const subnavBtn = $("#btn_open_unit_master");
        if (subnavBtn) {
            subnavBtn.onclick = ev => {
                ev.preventDefault();
                openUnitMasterModal();
            };
        }

        // Add Unit button & Enter key
        const addBtn = $("#btn_save_unit");
        const addInp = $("#input_new_unit");
        const handleAddUnit = () => {
            if (!addInp) return;
            const val = addInp.value.trim();
            if (!val) {
                toast("Please enter a unit name");
                addInp.focus();
                return;
            }
            if (val.length > 50) {
                toast("Unit name cannot exceed 50 characters");
                return;
            }

            apiCall("add_unit", { unit_name: val }, "POST").then(res => {
                if (res && res.status === "success") {
                    toast(res.message || "Unit added successfully");
                    addInp.value = "";
                    if (res.units && Array.isArray(res.units)) {
                        unitMasterList = res.units;
                        UNITS = res.units.map(u => typeof u === "string" ? u : (u.name || ""));
                    } else if (res.unit) {
                        unitMasterList.push(res.unit);
                        UNITS.push(res.unit.name);
                    }
                    renderUnitMasterList($("#filter_unit_list") ? $("#filter_unit_list").value : "");
                    if (ED) {
                        renderItems();
                    }
                    addInp.focus();
                } else {
                    toast(res && res.message ? res.message : "Failed to add unit");
                }
            });
        };

        if (addBtn) addBtn.onclick = handleAddUnit;
        if (addInp) {
            addInp.onkeydown = ev => {
                if (ev.key === "Enter") {
                    ev.preventDefault();
                    handleAddUnit();
                }
            };
        }

        // Live filter
        const filterInp = $("#filter_unit_list");
        if (filterInp) {
            filterInp.oninput = () => {
                renderUnitMasterList(filterInp.value);
            };
        }

        // Delete Unit delegation
        const listContainer = $("#unit_master_list_container");
        if (listContainer) {
            listContainer.onclick = ev => {
                const btn = ev.target.closest(".btn-del-unit");
                if (!btn) return;
                const uId = btn.dataset.id;
                const uName = btn.dataset.name;
                if (!uName) return;

                confirmSwal(
                    "Delete Unit?",
                    `Are you sure you want to delete "${uName}" from Unit Master?`,
                    () => {
                        apiCall("delete_unit", { id: uId, unit_name: uName }, "POST").then(res => {
                            if (res && res.status === "success") {
                                notifySwal("Deleted!", res.message || `Unit "${uName}" deleted successfully.`, "success");
                                if (res.units && Array.isArray(res.units)) {
                                    unitMasterList = res.units;
                                    UNITS = res.units.map(u => typeof u === "string" ? u : (u.name || ""));
                                } else {
                                    unitMasterList = unitMasterList.filter(x => (typeof x === "string" ? x : x.name) !== uName);
                                    UNITS = UNITS.filter(x => x !== uName);
                                }
                                renderUnitMasterList($("#filter_unit_list") ? $("#filter_unit_list").value : "");
                                if (ED) {
                                    renderItems();
                                }
                            } else {
                                const msg = res && res.message ? res.message : "Failed to delete unit";
                                notifySwal("Error", msg, "error");
                            }
                        });
                    }
                );
            };
        }

        // Close buttons inside modal
        $$("#modal_unit_master [data-dismiss='modal']").forEach(btn => {
            btn.onclick = () => hideModal("#modal_unit_master");
        });
    }

    // ==========================================
    // CUSTOMER MASTER MODAL (Add / Edit Customers)
    // ==========================================
    function openCustomerMasterModal(cust) {
        const titleEl = $("#modal_customer_title");
        const idInp = $("#cust_modal_id");
        const typeSel = $("#cust_modal_type");
        const codeInp = $("#cust_modal_code");
        const nameInp = $("#cust_modal_name");
        const contactInp = $("#cust_modal_contact");
        const emailInp = $("#cust_modal_email");
        const altContactInp = $("#cust_modal_alt_contact");
        const personInp = $("#cust_modal_person");
        const personNoInp = $("#cust_modal_person_no");
        const cprInp = $("#cust_modal_cpr");
        const vatInp = $("#cust_modal_vat");
        const addrInp = $("#cust_modal_address");
        const descInp = $("#cust_modal_description");

        const isCurrentlyAmc = ED && !!(+ED.is_amc);

        if (cust) {
            // Edit existing customer
            if (titleEl) titleEl.textContent = `Edit Customer (${cust.code || ''})`;
            if (idInp) idInp.value = cust.id || 0;
            if (codeInp) codeInp.value = cust.code || "";
            if (typeSel) typeSel.value = cust.customer_type || (cust.is_amc ? "AMC" : "Non AMC");
            if (nameInp) nameInp.value = cust.name || "";
            if (contactInp) contactInp.value = cust.contact || "";
            if (emailInp) emailInp.value = cust.email || "";
            if (altContactInp) altContactInp.value = cust.alternate_contact || "";
            if (personInp) personInp.value = cust.contact_person || "";
            if (personNoInp) personNoInp.value = cust.contact_person_no || "";
            if (cprInp) cprInp.value = cust.cpr_cr || "";
            if (vatInp) vatInp.value = cust.vat_no || "";
            if (addrInp) addrInp.value = cust.address || "";
            if (descInp) descInp.value = cust.description || "";
        } else {
            // Add new customer
            if (titleEl) titleEl.textContent = "Add New Customer";
            if (idInp) idInp.value = 0;
            if (codeInp) codeInp.value = "";
            if (typeSel) typeSel.value = isCurrentlyAmc ? "AMC" : "Non AMC";

            const curName = (ED && ED.client_name) ? ED.client_name : ($("#inp_client_name") ? $("#inp_client_name").value : "");
            const curContact = (ED && ED.contact_no) ? ED.contact_no : ($("#inp_contact_no") ? $("#inp_contact_no").value : "");
            const curAddr = (ED && ED.client_address) ? ED.client_address : ($("#ad") ? $("#ad").value : "");
            const curAttn = (ED && ED.attention) ? ED.attention : ($('[data-k="attention"]') ? $('[data-k="attention"]').value : "");

            if (nameInp) nameInp.value = curName || "";
            if (contactInp) contactInp.value = curContact || "";
            if (emailInp) emailInp.value = "";
            if (altContactInp) altContactInp.value = "";
            if (personInp) personInp.value = curAttn || "";
            if (personNoInp) personNoInp.value = "";
            if (cprInp) cprInp.value = "";
            if (vatInp) vatInp.value = "";
            if (addrInp) addrInp.value = curAddr || "";
            if (descInp) descInp.value = "";
        }

        showModal("#modal_customer_master");
        setTimeout(() => {
            if (nameInp) nameInp.focus();
        }, 200);
    }

    function refreshClientDropdown(selector, list, selectedCode) {
        const el = $(selector);
        if (!el) return;
        const placeholder = el.dataset.placeholder || "Select client…";
        let html = `<option value="">${placeholder}</option>`;
        list.forEach(c => {
            const isSel = (c.code === selectedCode) ? "selected" : "";
            html += `<option value="${H(c.code)}" ${isSel}
                data-id="${H(c.id || '')}"
                data-name="${H(c.name || '')}"
                data-contact="${H(c.contact || '')}"
                data-address="${H(c.address || '')}"
                data-person="${H(c.contact_person || '')}">
                ${H(c.code)} · ${H(c.name)} ${c.contact ? `(${H(c.contact)})` : ''}
            </option>`;
        });
        el.innerHTML = html;
        if (window.jQuery && typeof window.jQuery.fn.select2 === "function") {
            const $el = window.jQuery(el);
            $el.val(selectedCode).trigger('change.select2');
        }
    }

    function setupCustomerMasterEvents() {
        const btnSave = $("#btn_save_customer_master");
        if (btnSave) {
            btnSave.onclick = () => {
                const idVal = parseInt($("#cust_modal_id") ? $("#cust_modal_id").value : 0) || 0;
                const typeVal = $("#cust_modal_type") ? $("#cust_modal_type").value : "Non AMC";
                const isAmcVal = (typeVal === "AMC") ? 1 : 0;
                const nameVal = $("#cust_modal_name") ? $("#cust_modal_name").value.trim() : "";
                const contactVal = $("#cust_modal_contact") ? $("#cust_modal_contact").value.trim() : "";
                const emailVal = $("#cust_modal_email") ? $("#cust_modal_email").value.trim() : "";
                const altContactVal = $("#cust_modal_alt_contact") ? $("#cust_modal_alt_contact").value.trim() : "";
                const personVal = $("#cust_modal_person") ? $("#cust_modal_person").value.trim() : "";
                const personNoVal = $("#cust_modal_person_no") ? $("#cust_modal_person_no").value.trim() : "";
                const cprVal = $("#cust_modal_cpr") ? $("#cust_modal_cpr").value.trim() : "";
                const vatVal = $("#cust_modal_vat") ? $("#cust_modal_vat").value.trim() : "";
                const addrVal = $("#cust_modal_address") ? $("#cust_modal_address").value.trim() : "";
                const descVal = $("#cust_modal_description") ? $("#cust_modal_description").value.trim() : "";

                if (!nameVal) {
                    notifySwal("Required", "Please enter customer / company name.", "warning");
                    if ($("#cust_modal_name")) $("#cust_modal_name").focus();
                    return;
                }
                if (!contactVal) {
                    notifySwal("Required", "Please enter contact number.", "warning");
                    if ($("#cust_modal_contact")) $("#cust_modal_contact").focus();
                    return;
                }

                btnSave.disabled = true;
                const origHtml = btnSave.innerHTML;
                btnSave.innerHTML = `<i class="icon-spinner2 spinner mr-1"></i> Saving…`;

                const payload = {
                    action: "save_customer_master",
                    customer_id: idVal,
                    customer_type: typeVal,
                    is_amc: isAmcVal,
                    customer_name: nameVal,
                    customer_contact_no: contactVal,
                    customer_email_id: emailVal,
                    alternate_contact_no: altContactVal,
                    contact_person: personVal,
                    contact_person_number: personNoVal,
                    cpr_cr_number: cprVal,
                    vat_number: vatVal,
                    customer_address: addrVal,
                    customer_description: descVal
                };

                apiCall("save_customer_master", payload, "POST").then(res => {
                    btnSave.disabled = false;
                    btnSave.innerHTML = origHtml;

                    if (res && res.status === "success") {
                        if (res.amc_clients) AMC = res.amc_clients;
                        if (res.non_amc_clients) NON_AMC = res.non_amc_clients;

                        hideModal("#modal_customer_master");
                        notifySwal("Success", res.message || "Customer saved successfully", "success");

                        const savedCust = res.customer;
                        if (savedCust && ED) {
                            ED.client_code = savedCust.code;
                            ED.code = savedCust.code;
                            ED.client_name = savedCust.name;
                            ED.client = savedCust.name;
                            ED.client_address = savedCust.address;
                            ED.addr = savedCust.address;
                            ED.contact_no = savedCust.contact;
                            ED.contact = savedCust.contact;
                            if (savedCust.contact_person) {
                                ED.attention = savedCust.contact_person;
                                ED.attn = savedCust.contact_person;
                                const attnField = $('[data-k="attention"]');
                                if (attnField) attnField.value = ED.attention;
                            }

                            const inpName = $("#inp_client_name");
                            if (inpName) inpName.value = ED.client_name;
                            const inpContact = $("#inp_contact_no");
                            if (inpContact) inpContact.value = ED.contact_no;
                            const adField = $("#ad");
                            if (adField) adField.value = ED.client_address;

                            const isQuoteAmc = !!(+ED.is_amc);
                            if (isQuoteAmc) {
                                refreshClientDropdown("#cl", AMC, savedCust.code);
                            } else {
                                refreshClientDropdown("#cl_non_amc", NON_AMC, savedCust.code);
                            }

                            const btnEdit = $("#btn_edit_current_customer");
                            if (btnEdit) btnEdit.style.display = "inline-flex";

                            renderLivePreview();
                        }
                    } else {
                        const errMsg = (res && res.message) ? res.message : "Failed to save customer.";
                        notifySwal("Error", errMsg, "error");
                    }
                }).catch(err => {
                    btnSave.disabled = false;
                    btnSave.innerHTML = origHtml;
                    notifySwal("Error", "Server error while saving customer.", "error");
                });
            };
        }

        $$("#modal_customer_master [data-dismiss='modal']").forEach(btn => {
            btn.onclick = () => hideModal("#modal_customer_master");
        });
    }

    // ==========================================
    // FOOTER SETTINGS CONTROLLER & PREVIEW
    // ==========================================
    function setupFooterSettingsModalEvents() {
        const btnOpen = $("#btn_open_footer_settings");
        if (btnOpen) {
            btnOpen.onclick = ev => {
                ev.preventDefault();
                openFooterSettingsModal();
            };
        }

        const btnSave = $("#btn_save_footer_cfg");
        if (btnSave) {
            btnSave.onclick = () => saveFooterSettings();
        }

        const btnReset = $("#btn_reset_footer_cfg");
        if (btnReset) {
            btnReset.onclick = () => {
                populateFooterSettingsForm(DEFAULT_FOOTER_CONFIG);
                updateFooterLivePreview();
                toast("Reset to default corporate footer values (click Save to apply).");
            };
        }

        // Color sync
        const colorInput = $("#cfg_footer_color");
        const colorHex = $("#cfg_footer_color_hex");
        if (colorInput && colorHex) {
            colorInput.oninput = e => {
                colorHex.value = e.target.value;
                updateFooterLivePreview();
            };
            colorHex.oninput = e => {
                const val = e.target.value.trim();
                if (/^#[0-9A-Fa-f]{6}$/.test(val)) {
                    colorInput.value = val;
                }
                updateFooterLivePreview();
            };
        }

        // Live preview listeners on all inputs
        [
            "#cfg_footer_phone", "#cfg_footer_email", "#cfg_footer_website",
            "#cfg_footer_cr", "#cfg_footer_addr1", "#cfg_footer_addr2",
            "#cfg_footer_badges", "#cfg_footer_page_no", "#cfg_footer_ref_no"
        ].forEach(sel => {
            const el = $(sel);
            if (el) {
                el.addEventListener("input", updateFooterLivePreview);
                el.addEventListener("change", updateFooterLivePreview);
            }
        });

        $$("#modal_footer_settings [data-dismiss='modal']").forEach(btn => {
            btn.onclick = () => hideModal("#modal_footer_settings");
        });
    }

    function openFooterSettingsModal() {
        populateFooterSettingsForm(FOOTER_CONFIG);
        updateFooterLivePreview();
        showModal("#modal_footer_settings");
    }

    function populateFooterSettingsForm(cfg) {
        if ($("#cfg_footer_phone")) $("#cfg_footer_phone").value = cfg.phone || "";
        if ($("#cfg_footer_email")) $("#cfg_footer_email").value = cfg.email || "";
        if ($("#cfg_footer_website")) $("#cfg_footer_website").value = cfg.website || "";
        if ($("#cfg_footer_cr")) $("#cfg_footer_cr").value = cfg.cr_no || "";
        if ($("#cfg_footer_addr1")) $("#cfg_footer_addr1").value = cfg.address_line1 || "";
        if ($("#cfg_footer_addr2")) $("#cfg_footer_addr2").value = cfg.address_line2 || "";
        if ($("#cfg_footer_color")) $("#cfg_footer_color").value = cfg.bg_color || "#1e2560";
        if ($("#cfg_footer_color_hex")) $("#cfg_footer_color_hex").value = cfg.bg_color || "#1e2560";
        if ($("#cfg_footer_badges")) $("#cfg_footer_badges").checked = (cfg.show_badges !== 0 && cfg.show_badges !== false);
        if ($("#cfg_footer_page_no")) $("#cfg_footer_page_no").checked = (cfg.show_page_no !== 0 && cfg.show_page_no !== false);
        if ($("#cfg_footer_ref_no")) $("#cfg_footer_ref_no").checked = (cfg.show_ref_no !== 0 && cfg.show_ref_no !== false);
        if ($("#cfg_footer_doc_number")) $("#cfg_footer_doc_number").value = cfg.doc_number || "CINQO/THC/QTN/01/2020/REV3";
    }

    function updateFooterLivePreview() {
        const phone = ($("#cfg_footer_phone") ? $("#cfg_footer_phone").value.trim() : "") || "+973 17 100 190";
        const email = ($("#cfg_footer_email") ? $("#cfg_footer_email").value.trim() : "") || "info@thc.com.bh";
        const website = ($("#cfg_footer_website") ? $("#cfg_footer_website").value.trim() : "") || "www.thc.com.bh";
        const cr = ($("#cfg_footer_cr") ? $("#cfg_footer_cr").value.trim() : "") || "88982-1";
        const addr1 = ($("#cfg_footer_addr1") ? $("#cfg_footer_addr1").value.trim() : "") || "Level 14, Office 1403/1404, Bldg 155, Road 1703, Block 317";
        const addr2 = ($("#cfg_footer_addr2") ? $("#cfg_footer_addr2").value.trim() : "") || "YBA Kanoo Tower, Diplomatic Area, Kingdom of Bahrain";
        const color = ($("#cfg_footer_color_hex") ? $("#cfg_footer_color_hex").value.trim() : "") || "#1e2560";
        const showBadges = $("#cfg_footer_badges") ? $("#cfg_footer_badges").checked : true;
        const showPageNo = $("#cfg_footer_page_no") ? $("#cfg_footer_page_no").checked : true;
        const showRefNo = $("#cfg_footer_ref_no") ? $("#cfg_footer_ref_no").checked : true;
        const docNumber = ($("#cfg_footer_doc_number") ? $("#cfg_footer_doc_number").value.trim() : "") || "CINQO/THC/QTN/01/2020/REV3";

        if ($("#fp_phone")) $("#fp_phone").textContent = phone;
        if ($("#fp_email")) $("#fp_email").textContent = email;
        if ($("#fp_website")) $("#fp_website").textContent = website;
        if ($("#fp_cr")) $("#fp_cr").textContent = cr;
        if ($("#fp_addr1")) $("#fp_addr1").textContent = addr1;
        if ($("#fp_addr2")) $("#fp_addr2").textContent = addr2;
        if ($("#footer_preview_bar")) $("#footer_preview_bar").style.background = color;
        if ($("#footer_preview_badges")) $("#footer_preview_badges").style.display = showBadges ? "block" : "none";
        if ($("#footer_preview_page")) $("#footer_preview_page").style.visibility = showPageNo ? "visible" : "hidden";
        if ($("#footer_preview_ref")) {
            $("#footer_preview_ref").textContent = docNumber;
            $("#footer_preview_ref").style.visibility = showRefNo ? "visible" : "hidden";
        }
    }

    function saveFooterSettings() {
        const payload = {
            phone: $("#cfg_footer_phone") ? $("#cfg_footer_phone").value.trim() : "",
            email: $("#cfg_footer_email") ? $("#cfg_footer_email").value.trim() : "",
            website: $("#cfg_footer_website") ? $("#cfg_footer_website").value.trim() : "",
            cr_no: $("#cfg_footer_cr") ? $("#cfg_footer_cr").value.trim() : "",
            address_line1: $("#cfg_footer_addr1") ? $("#cfg_footer_addr1").value.trim() : "",
            address_line2: $("#cfg_footer_addr2") ? $("#cfg_footer_addr2").value.trim() : "",
            bg_color: ($("#cfg_footer_color_hex") ? $("#cfg_footer_color_hex").value.trim() : "") || "#1e2560",
            show_badges: $("#cfg_footer_badges") && $("#cfg_footer_badges").checked ? 1 : 0,
            show_page_no: $("#cfg_footer_page_no") && $("#cfg_footer_page_no").checked ? 1 : 0,
            show_ref_no: $("#cfg_footer_ref_no") && $("#cfg_footer_ref_no").checked ? 1 : 0,
            doc_number: ($("#cfg_footer_doc_number") ? $("#cfg_footer_doc_number").value.trim() : "") || "CINQO/THC/QTN/01/2020/REV3"
        };

        const btnSave = $("#btn_save_footer_cfg");
        if (btnSave) {
            btnSave.disabled = true;
            btnSave.innerHTML = '<i class="icon-spinner2 spinner mr-1"></i> Saving…';
        }

        apiCall("save_footer_config", payload, "POST").then(res => {
            if (btnSave) {
                btnSave.disabled = false;
                btnSave.innerHTML = '<i class="icon-floppy-disk mr-1"></i> Save Footer Settings';
            }
            if (res && res.status === "success") {
                FOOTER_CONFIG = Object.assign({}, FOOTER_CONFIG, res.footer_config || payload);
                toast(res.message || "Footer settings saved successfully.");
                hideModal("#modal_footer_settings");

                // Refresh any live sheet preview on screen
                if (ED) renderLivePreview();
                const curOn = document.querySelector("aside a.on");
                if (curOn && curOn.dataset.v === "vq" && curOn.dataset.id) {
                    vq(+curOn.dataset.id);
                }
            } else {
                toast((res && res.message) || "Failed to save footer settings.");
            }
        }).catch(err => {
            if (btnSave) {
                btnSave.disabled = false;
                btnSave.innerHTML = '<i class="icon-floppy-disk mr-1"></i> Save Footer Settings';
            }
            toast("Error while saving footer settings.");
        });
    }

    // ==========================================
    // STAMP & SIGNATURE CONTROLLER & PREVIEW
    // ==========================================
    function setupStampSignModalEvents() {
        const btnOpen = $("#btn_open_stamp_sign");
        if (btnOpen) {
            btnOpen.onclick = ev => {
                ev.preventDefault();
                openStampSignModal();
            };
        }

        const btnSave = $("#btn_save_stamp_sign_cfg");
        if (btnSave) {
            btnSave.onclick = () => saveStampSignConfig();
        }

        // Toggles in modal
        const chkStamp = $("#cfg_show_stamp");
        if (chkStamp) {
            chkStamp.onchange = e => {
                const prev = $("#live_prev_stamp");
                if (prev) prev.style.display = e.target.checked ? "block" : "none";
            };
        }

        const chkSig = $("#cfg_show_signature");
        if (chkSig) {
            chkSig.onchange = e => {
                const prev = $("#live_prev_sig");
                if (prev) prev.style.display = e.target.checked ? "block" : "none";
            };
        }

        const chkPhone = $("#cfg_show_user_phone");
        if (chkPhone) {
            chkPhone.onchange = e => {
                const prev = $("#live_prev_user_phone");
                const inp = $("#cfg_user_phone");
                if (prev) prev.style.display = (e.target.checked && inp && inp.value.trim()) ? "block" : "none";
            };
        }

        const inpPhone = $("#cfg_user_phone");
        if (inpPhone) {
            inpPhone.oninput = e => {
                const prev = $("#live_prev_user_phone");
                if (prev) {
                    prev.textContent = e.target.value.trim() ? ("Mob: " + e.target.value.trim()) : "";
                    prev.style.display = (chkPhone && chkPhone.checked && e.target.value.trim()) ? "block" : "none";
                }
            };
        }

        // File uploaders
        const uplStamp = $("#upload_stamp_input");
        if (uplStamp) {
            uplStamp.onchange = e => {
                if (e.target.files && e.target.files[0]) {
                    uploadStampSignFile("stamp", e.target.files[0]);
                }
            };
        }

        const uplSig = $("#upload_sig_input");
        if (uplSig) {
            uplSig.onchange = e => {
                if (e.target.files && e.target.files[0]) {
                    uploadStampSignFile("signature", e.target.files[0]);
                }
            };
        }

        $$("#modal_stamp_sign_settings [data-dismiss='modal']").forEach(btn => {
            btn.onclick = () => hideModal("#modal_stamp_sign_settings");
        });
    }

    function openStampSignModal() {
        const chkStamp = $("#cfg_show_stamp");
        if (chkStamp) chkStamp.checked = (STAMP_SIGN_CONFIG.show_stamp !== 0 && STAMP_SIGN_CONFIG.show_stamp !== false);

        const chkSig = $("#cfg_show_signature");
        if (chkSig) chkSig.checked = (STAMP_SIGN_CONFIG.show_signature !== 0 && STAMP_SIGN_CONFIG.show_signature !== false);

        const uCode = CU;
        const uSig = (STAMP_SIGN_CONFIG.user_signatures && STAMP_SIGN_CONFIG.user_signatures[uCode]) || STAMP_SIGN_CONFIG.default_signature_url || "uploads/quotation_signatures/default_signature.png";
        const stampUrl = STAMP_SIGN_CONFIG.company_stamp_url || "uploads/quotation_signatures/default_thc_stamp.png";

        const stampImg = $("#stamp_preview_img");
        if (stampImg) stampImg.src = stampUrl + "?t=" + Date.now();

        const sigImg = $("#sig_preview_img");
        if (sigImg) sigImg.src = uSig + "?t=" + Date.now();

        const liveSig = $("#live_prev_sig");
        if (liveSig) {
            liveSig.src = uSig + "?t=" + Date.now();
            liveSig.style.display = (chkSig && chkSig.checked) ? "block" : "none";
        }

        const liveStamp = $("#live_prev_stamp");
        if (liveStamp) {
            liveStamp.src = stampUrl + "?t=" + Date.now();
            liveStamp.style.display = (chkStamp && chkStamp.checked) ? "block" : "none";
        }

        const cur = USERS[uCode];
        const cName = cur ? (Array.isArray(cur) ? cur[0] : cur.name) : currentUserObj.name;
        const cTitle = cur ? (Array.isArray(cur) ? cur[1] : cur.title) : currentUserObj.title;
        const cPhone = (cur && (cur.phone || cur[2])) || (STAMP_SIGN_CONFIG.user_phones && STAMP_SIGN_CONFIG.user_phones[uCode]) || currentUserObj.phone || "";

        if ($("#live_prev_user_name")) $("#live_prev_user_name").textContent = cName;
        if ($("#live_prev_user_title")) $("#live_prev_user_title").textContent = cTitle;
        if ($("#cfg_user_phone")) $("#cfg_user_phone").value = cPhone;
        const chkUserPhone = $("#cfg_show_user_phone");
        if (chkUserPhone) chkUserPhone.checked = (STAMP_SIGN_CONFIG.show_user_phone !== 0 && STAMP_SIGN_CONFIG.show_user_phone !== false);
        const livePhone = $("#live_prev_user_phone");
        if (livePhone) {
            livePhone.textContent = cPhone ? ("Mob: " + cPhone) : "";
            livePhone.style.display = (chkUserPhone && chkUserPhone.checked && cPhone) ? "block" : "none";
        }

        showModal("#modal_stamp_sign_settings");
    }

    function uploadStampSignFile(type, file) {
        if (!file) return;
        const formData = new FormData();
        formData.append("action", "upload_stamp_sign");
        formData.append("user_code", CU);
        formData.append("show_stamp", $("#cfg_show_stamp") && $("#cfg_show_stamp").checked ? 1 : 0);
        formData.append("show_signature", $("#cfg_show_signature") && $("#cfg_show_signature").checked ? 1 : 0);
        if (type === "stamp") {
            formData.append("stamp_file", file);
        } else {
            formData.append("signature_file", file);
        }

        toast("Uploading " + (type === "stamp" ? "stamp" : "signature") + "…");

        fetch(`${API_URL}?action=upload_stamp_sign`, {
            method: "POST",
            body: formData
        })
        .then(res => res.json())
        .then(res => {
            if (res && res.status === "success") {
                if (res.stamp_sign_config) {
                    STAMP_SIGN_CONFIG = Object.assign({}, DEFAULT_STAMP_SIGN_CONFIG, res.stamp_sign_config);
                }
                toast(res.message || "Uploaded successfully.");
                openStampSignModal();
                if (ED) renderLivePreview();
            } else {
                toast((res && res.message) || "Failed to upload image.");
            }
        })
        .catch(err => {
            console.error("Upload error:", err);
            toast("Error uploading image file.");
        });
    }

    function saveStampSignConfig() {
        const payload = {
            show_stamp: $("#cfg_show_stamp") && $("#cfg_show_stamp").checked ? 1 : 0,
            show_signature: $("#cfg_show_signature") && $("#cfg_show_signature").checked ? 1 : 0,
            show_user_phone: $("#cfg_show_user_phone") && $("#cfg_show_user_phone").checked ? 1 : 0,
            company_stamp_url: STAMP_SIGN_CONFIG.company_stamp_url || "uploads/quotation_signatures/default_thc_stamp.png",
            default_signature_url: STAMP_SIGN_CONFIG.default_signature_url || "uploads/quotation_signatures/default_signature.png",
            user_signatures: STAMP_SIGN_CONFIG.user_signatures || {},
            user_phones: STAMP_SIGN_CONFIG.user_phones || {}
        };
        if ($("#cfg_user_phone")) {
            payload.user_phones[CU] = $("#cfg_user_phone").value.trim();
        }

        const btnSave = $("#btn_save_stamp_sign_cfg");
        if (btnSave) {
            btnSave.disabled = true;
            btnSave.innerHTML = '<i class="icon-spinner2 spinner mr-1"></i> Saving…';
        }

        apiCall("save_stamp_sign_config", payload, "POST").then(res => {
            if (btnSave) {
                btnSave.disabled = false;
                btnSave.innerHTML = '<i class="icon-floppy-disk mr-1"></i> Save & Apply';
            }
            if (res && res.status === "success") {
                STAMP_SIGN_CONFIG = Object.assign({}, STAMP_SIGN_CONFIG, res.stamp_sign_config || payload);
                toast(res.message || "Stamp & signature settings saved successfully.");
                hideModal("#modal_stamp_sign_settings");

                if (ED) renderLivePreview();
                const curOn = document.querySelector("aside a.on");
                if (curOn && curOn.dataset.v === "vq" && curOn.dataset.id) {
                    vq(+curOn.dataset.id);
                }
            } else {
                toast((res && res.message) || "Failed to save stamp & signature settings.");
            }
        }).catch(err => {
            if (btnSave) {
                btnSave.disabled = false;
                btnSave.innerHTML = '<i class="icon-floppy-disk mr-1"></i> Save & Apply';
            }
            toast("Error while saving stamp & signature settings.");
        });
    }

    // ==========================================
    // SPELLING & GRAMMAR CHECK ENGINE (LanguageTool)
    // ==========================================
    let currentGrammarIssues = [];

    function checkGrammarAPI(text) {
        if (!text || !text.trim()) {
            return Promise.resolve({ status: "success", matches: [] });
        }
        const trimmed = text.trim();
        const postBody = new URLSearchParams({ text: trimmed, language: "en-US" });

        // First attempt direct browser fetch to LanguageTool API
        return fetch("https://api.languagetool.org/v2/check", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: postBody.toString()
        })
        .then(res => {
            if (!res.ok) throw new Error("Direct LanguageTool status " + res.status);
            return res.json();
        })
        .then(data => ({
            status: "success",
            matches: Array.isArray(data.matches) ? data.matches : []
        }))
        .catch(err => {
            // Fallback to backend proxy controller if direct fetch is blocked
            return apiCall("check_grammar", { text: trimmed, language: "en-US" }, "POST")
                .then(res => {
                    if (res && res.matches && Array.isArray(res.matches)) return res;
                    return { status: "success", matches: [] };
                })
                .catch(() => ({ status: "success", matches: [] }));
        });
    }

    function replaceTextAt(str, offset, length, replacement) {
        if (typeof str !== "string") str = String(str || "");
        return str.substring(0, offset) + replacement + str.substring(offset + length);
    }

    function runQuotationGrammarCheck(scope = "all") {
        if (!ED) return;

        // Collect fields to check
        const tasks = [];

        // Subject - checked in 'all', 'subject', and 'items'
        if (scope === "all" || scope === "subject" || scope === "items") {
            const subj = ED.subject || ED.subj || "";
            if (subj && subj.trim()) {
                tasks.push({
                    section: "subject",
                    index: 0,
                    fieldLabel: "Quotation Subject",
                    text: subj.trim()
                });
            } else if (scope === "subject") {
                toast("Please enter a quotation subject first.");
                return;
            }
        }

        // Scope of works items
        if (scope === "all" || scope === "items") {
            if (Array.isArray(ED.items)) {
                ED.items.forEach((item, idx) => {
                    const desc = item.description !== undefined ? item.description : (item[0] || "");
                    if (desc && desc.trim()) {
                        tasks.push({
                            section: "item",
                            index: idx,
                            fieldLabel: `Scope of Works — Item #${idx + 1}`,
                            text: desc
                        });
                    }
                });
            }
        }

        // Terms and conditions
        if (scope === "all" || scope === "terms") {
            if (Array.isArray(ED.terms)) {
                ED.terms.forEach((term, idx) => {
                    if (term && term.trim()) {
                        tasks.push({
                            section: "term",
                            index: idx,
                            fieldLabel: `Terms & Conditions — Line #${idx + 1}`,
                            text: term
                        });
                    }
                });
            }
        }

        if (tasks.length === 0) {
            toast("No text entered to check yet.");
            return;
        }

        toast("Checking spelling & grammar…");

        // Execute checks concurrently
        Promise.all(tasks.map(t => checkGrammarAPI(t.text).then(res => ({ task: t, matches: res.matches || [] }))))
            .then(results => {
                const issues = [];
                let issueId = 1;

                results.forEach(r => {
                    r.matches.forEach(m => {
                        // Skip if no suggestion replacement
                        if (!m.replacements || m.replacements.length === 0) return;

                        issues.push({
                            id: issueId++,
                            section: r.task.section,
                            index: r.task.index,
                            fieldLabel: r.task.fieldLabel,
                            fullText: r.task.text,
                            offset: m.offset,
                            length: m.length,
                            message: m.message || "Grammar/spelling suggestion",
                            shortMessage: m.shortMessage || "",
                            issueType: (m.rule && m.rule.issueType) || (m.category && m.category.id) || "spelling",
                            ruleId: (m.rule && m.rule.id) || "",
                            context: m.context || { text: r.task.text, offset: m.offset, length: m.length },
                            replacements: m.replacements.slice(0, 4),
                            fixed: false,
                            appliedVal: ""
                        });
                    });
                });

                if (issues.length === 0) {
                    const clearMsg = scope === "subject" 
                        ? "Quotation subject is all clear! No spelling or grammatical issues found."
                        : "No spelling or grammatical issues were detected in this quotation.";
                    if (typeof window.swal === "function") {
                        window.swal({
                            title: "All Clear! ✓",
                            text: clearMsg,
                            type: "success",
                            confirmButtonColor: "#0A4174"
                        });
                    } else {
                        toast("All Clear! ✓ No spelling or grammar issues found.");
                    }
                    return;
                }

                currentGrammarIssues = issues;
                renderGrammarIssuesModal();
                showModal("#modal_grammar_check");
            })
            .catch(err => {
                console.error("Grammar check error:", err);
                toast("Could not complete grammar check. Please try again.");
            });
    }

    function renderGrammarIssuesModal() {
        const badge = $("#grammar_issue_badge");
        const list = $("#grammar_issues_list");
        if (!list) return;

        const remaining = currentGrammarIssues.filter(x => !x.fixed);
        if (badge) {
            if (remaining.length === 0) {
                badge.className = "badge badge-success mr-3";
                badge.style.background = "#28a745";
                badge.style.color = "#ffffff";
                badge.textContent = "All Issues Resolved ✓";
            } else {
                badge.className = "badge badge-warning mr-3";
                badge.style.background = "#ffc107";
                badge.style.color = "#212529";
                badge.textContent = `${remaining.length} ${remaining.length === 1 ? "Issue" : "Issues"} Remaining`;
            }
        }

        if (currentGrammarIssues.length === 0) {
            list.innerHTML = `<div class="text-center p-4 text-muted">No issues found.</div>`;
            return;
        }

        list.innerHTML = M(currentGrammarIssues, issue => {
            const isMisspelling = issue.issueType === "misspelling" || (issue.ruleId && issue.ruleId.indexOf("MORFOLOGIK") > -1);
            const badgeClass = isMisspelling ? "badge-danger" : "badge-warning";
            const badgeBg = isMisspelling ? "#ef4444" : "#f59e0b";
            const badgeLabel = isMisspelling ? "Spelling Typo" : "Grammar / Phrasing";
            const borderCol = issue.fixed ? "#86efac" : (isMisspelling ? "#fca5a5" : "#fcd34d");
            const cardBg = issue.fixed ? "#f0fdf4" : "#ffffff";

            let snippetHtml = "";
            if (issue.context && issue.context.text) {
                const cText = issue.context.text;
                const cOff = Math.max(0, issue.context.offset || 0);
                const cLen = Math.max(1, issue.context.length || 1);
                const before = H(cText.substring(0, cOff));
                const word = H(cText.substring(cOff, cOff + cLen));
                const after = H(cText.substring(cOff + cLen));
                if (issue.fixed) {
                    snippetHtml = `${before}<span style="background:#bbf7d0;color:#166534;padding:1px 5px;border-radius:4px;font-weight:700;">${H(issue.appliedVal)}</span>${after}`;
                } else if (isMisspelling) {
                    snippetHtml = `${before}<mark style="background:#fee2e2;color:#b91c1c;padding:1px 5px;border-radius:4px;font-weight:700;border-bottom:2px solid #ef4444;">${word}</mark>${after}`;
                } else {
                    snippetHtml = `${before}<mark style="background:#fef3c7;color:#92400e;padding:1px 5px;border-radius:4px;font-weight:700;border-bottom:2px solid #f59e0b;">${word}</mark>${after}`;
                }
            } else {
                snippetHtml = H(issue.fullText);
            }

            return `
            <div class="grammar-card mb-3 p-3" id="grammar_card_${issue.id}" style="background:${cardBg};border-radius:10px;border:1.5px solid ${borderCol};box-shadow:0 2px 6px rgba(0,29,57,0.04);transition:all 0.2s;">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="font-weight-bold text-dark" style="font-size:13px;">
                        <i class="icon-file-text2 mr-1" style="color:#0A4174;"></i> ${H(issue.fieldLabel)}
                    </span>
                    <span class="badge ${badgeClass}" style="font-size:11px;padding:4px 8px;border-radius:5px;background:${badgeBg};color:#fff;font-weight:600;">
                        ${badgeLabel}
                    </span>
                </div>
                <div class="p-2 mb-2" style="background:#f8fafc;border-left:3.5px solid ${isMisspelling ? '#ef4444' : '#f59e0b'};border-radius:5px;font-size:13px;line-height:1.5;color:#222;">
                    ${snippetHtml}
                </div>
                <div class="d-flex align-items-center justify-content-between flex-wrap" style="gap:8px;">
                    <div style="font-size:12px;color:#555;max-width:340px;">
                        <i class="icon-info22 mr-1 text-muted"></i> ${H(issue.message)}
                    </div>
                    <div class="d-flex align-items-center flex-wrap" style="gap:6px;">
                        ${issue.fixed ? `
                            <span class="badge badge-success" style="font-size:12px;padding:5px 10px;background:#28a745;color:#fff;border-radius:6px;">
                                <i class="icon-checkmark2 mr-1"></i> Fixed: <b>${H(issue.appliedVal)}</b>
                            </span>
                        ` : `
                            <span class="text-muted" style="font-size:11.5px;font-weight:600;">Apply:</span>
                            ${M(issue.replacements, rep => `
                                <button type="button" class="btn btn-xs btn-outline-primary btn-apply-grammar" data-issue-id="${issue.id}" data-val="${H(rep.value)}" style="font-size:12px;font-weight:600;padding:3px 9px;border-radius:6px;border:1.5px solid #0A4174;color:#0A4174;background:#ffffff;cursor:pointer;">
                                    ${H(rep.value)}
                                </button>
                            `)}
                        `}
                    </div>
                </div>
            </div>`;
        });
    }

    function applySingleGrammarFix(issueId, replacementVal) {
        const issue = currentGrammarIssues.find(x => x.id === issueId);
        if (!issue || issue.fixed) return;

        applyReplacementToField(issue.section, issue.index, issue.offset, issue.length, replacementVal);
        issue.fixed = true;
        issue.appliedVal = replacementVal;
        renderGrammarIssuesModal();
        toast(`Applied: "${replacementVal}"`);
    }

    function applyAllGrammarFixes() {
        const unfixed = currentGrammarIssues.filter(x => !x.fixed && x.replacements && x.replacements.length > 0);
        if (unfixed.length === 0) {
            toast("No pending suggestions to apply.");
            return;
        }

        // Group by field & index
        const groups = {};
        unfixed.forEach(issue => {
            const key = issue.section + "_" + issue.index;
            if (!groups[key]) groups[key] = [];
            groups[key].push(issue);
        });

        // Apply replacements from right to left (offset descending)
        Object.keys(groups).forEach(key => {
            const items = groups[key];
            items.sort((a, b) => b.offset - a.offset);

            items.forEach(issue => {
                const repVal = issue.replacements[0].value;
                applyReplacementToField(issue.section, issue.index, issue.offset, issue.length, repVal);
                issue.fixed = true;
                issue.appliedVal = repVal;
            });
        });

        renderGrammarIssuesModal();
        toast("All spelling & grammar suggestions applied!");
    }

    function applyReplacementToField(section, index, offset, length, replacement) {
        if (!ED) return;

        if (section === "subject") {
            const cur = ED.subject || ED.subj || "";
            const updated = replaceTextAt(cur, offset, length, replacement);
            ED.subject = updated;
            ED.subj = updated;
            const inp = $('input[data-k="subject"]');
            if (inp) inp.value = updated;
        } else if (section === "item") {
            if (Array.isArray(ED.items) && ED.items[index]) {
                const r = ED.items[index];
                const cur = r.description !== undefined ? r.description : (r[0] || "");
                const updated = replaceTextAt(cur, offset, length, replacement);
                if (r.description !== undefined) r.description = updated;
                if (r[0] !== undefined) r[0] = updated;
                const inp = $(`[data-i="${index}"][data-f="desc"]`);
                if (inp) inp.value = updated;
            }
        } else if (section === "term") {
            if (Array.isArray(ED.terms) && ED.terms[index] !== undefined) {
                const cur = ED.terms[index] || "";
                const updated = replaceTextAt(cur, offset, length, replacement);
                ED.terms[index] = updated;
                const inp = $(`textarea[data-t="${index}"]`);
                if (inp) inp.value = updated;
            }
        }

        renderLivePreview();
    }

    function initGrammarCheckModalListeners() {
        const acceptAllBtn = $("#btn_grammar_accept_all");
        if (acceptAllBtn) {
            acceptAllBtn.onclick = () => applyAllGrammarFixes();
        }

        const issuesList = $("#grammar_issues_list");
        if (issuesList) {
            issuesList.onclick = ev => {
                const btn = ev.target.closest(".btn-apply-grammar");
                if (!btn) return;
                const issueId = +btn.dataset.issueId;
                const val = btn.dataset.val;
                if (issueId && val) {
                    applySingleGrammarFix(issueId, val);
                }
            };
        }

        $$("#modal_grammar_check [data-dismiss='modal']").forEach(btn => {
            btn.onclick = () => hideModal("#modal_grammar_check");
        });
    }

    function loadInitialData() {
        apiCall("get_initial_data", {}, "GET").then(res => {
            if (res && res.status === "success") {
                if (res.current_user) {
                    currentUserObj = res.current_user;
                    CU = currentUserObj.code;
                }
                if (res.users) USERS = res.users;
                if (res.amc_clients) AMC = res.amc_clients;
                if (res.non_amc_clients) NON_AMC = res.non_amc_clients;
                if (res.default_terms) T0 = res.default_terms;
                if (res.library_terms) LIB = res.library_terms;
                if (res.rejection_reasons) REASONS = res.rejection_reasons;
                if (res.quotations) Q = res.quotations;
                if (res.units && Array.isArray(res.units) && res.units.length) {
                    unitMasterList = res.units;
                    UNITS = res.units.map(u => typeof u === "string" ? u : (u.name || ""));
                }
                if (res.footer_config && typeof res.footer_config === "object") {
                    FOOTER_CONFIG = Object.assign({}, DEFAULT_FOOTER_CONFIG, res.footer_config);
                }
                if (res.stamp_sign_config && typeof res.stamp_sign_config === "object") {
                    STAMP_SIGN_CONFIG = Object.assign({}, DEFAULT_STAMP_SIGN_CONFIG, res.stamp_sign_config);
                }
            }

            initAppUi();
        });
    }

    function initAppUi() {
        setupUnitMasterEvents();
        setupCustomerMasterEvents();
        setupFooterSettingsModalEvents();
        setupStampSignModalEvents();
        initGrammarCheckModalListeners();
        setupCompletionAndReviveModalEvents();
        // Build user switcher options
        const us = $("#us");
        if (us) {
            const userKeys = Object.keys(USERS);
            us.innerHTML = M(userKeys, u => {
                const uInfo = USERS[u];
                const name = Array.isArray(uInfo) ? uInfo[0] : uInfo.name;
                return `<option value="${H(u)}" ${u === CU ? "selected" : ""}>${H(name)}</option>`;
            });

            us.onchange = e => {
                CU = e.target.value;
                const on = document.querySelector("aside a.on");
                if (on && ["log", "perf"].includes(on.dataset.v)) {
                    go(on.dataset.v);
                }
                const cur = USERS[CU];
                const cName = Array.isArray(cur) ? cur[0] : cur.name;
                const cTitle = Array.isArray(cur) ? cur[1] : cur.title;
                toast("Signing as " + cName + ", " + cTitle);
            };
        }

        // Attach aside and subnav click listeners
        $$("aside a[data-v], .thc-subnav-btn[data-v]").forEach(a => {
            a.onclick = (e) => {
                e.preventDefault();
                go(a.dataset.v);
            };
        });

        // Initialize view based on URL query parameter ?v= (log, A, N, perf, rules)
        const urlParams = new URLSearchParams(window.location.search);
        const initialView = urlParams.get("v");
        if (initialView && ["log", "A", "N", "perf", "rules"].includes(initialView)) {
            go(initialView);
        } else {
            go("log");
        }
    }

    function setupCompletionAndReviveModalEvents() {
        $$("#modal_quote_completion [data-dismiss='modal']").forEach(btn => {
            btn.onclick = () => hideModal("#modal_quote_completion");
        });

        $$("#modal_revive_quote [data-dismiss='modal']").forEach(btn => {
            btn.onclick = () => hideModal("#modal_revive_quote");
        });

        const btnComp = $("#btn_confirm_completion");
        if (btnComp) {
            btnComp.onclick = () => {
                const quoteId = parseInt($("#comp_quote_id") ? $("#comp_quote_id").value : 0) || 0;
                if (!quoteId) return toast("Invalid quotation selected");
                const cDate = ($("#comp_date") ? $("#comp_date").value : "") || TODAY;
                const cNotes = ($("#comp_notes") ? $("#comp_notes").value : "").trim();
                const fileInput = $("#comp_attachment");

                const formData = new FormData();
                formData.append("action", "mark_completed");
                formData.append("id", quoteId);
                formData.append("completion_date", cDate);
                formData.append("completion_notes", cNotes);
                if (fileInput && fileInput.files && fileInput.files[0]) {
                    formData.append("completion_attachment", fileInput.files[0]);
                }

                btnComp.disabled = true;
                btnComp.innerHTML = `<i class="icon-spinner2 spinner mr-1"></i> Saving...`;

                fetch(API_URL, {
                    method: "POST",
                    body: formData
                })
                .then(r => r.json())
                .then(res => {
                    btnComp.disabled = false;
                    btnComp.innerHTML = `<i class="icon-checkmark4 mr-1"></i> Confirm Completed`;
                    hideModal("#modal_quote_completion");

                    if (res && res.status === "success") {
                        toast(res.message || "Quotation marked as Completed!");
                        apiCall("get_quotation", { id: quoteId }, "GET").then(fresh => {
                            if (fresh && fresh.quotation) {
                                const idx = Q.findIndex(x => x.id == quoteId);
                                if (idx !== -1) Q[idx] = fresh.quotation;
                                vq(quoteId);
                            } else {
                                go("log");
                            }
                        }).catch(() => go("log"));
                    } else {
                        toast((res && res.message) || "Failed to mark as completed");
                    }
                })
                .catch(err => {
                    btnComp.disabled = false;
                    btnComp.innerHTML = `<i class="icon-checkmark4 mr-1"></i> Confirm Completed`;
                    toast("Network error while recording completion.");
                });
            };
        }

        const btnRevive = $("#btn_confirm_revive");
        if (btnRevive) {
            btnRevive.onclick = () => {
                const quoteId = parseInt($("#revive_quote_id") ? $("#revive_quote_id").value : 0) || 0;
                if (!quoteId) return toast("Invalid quotation selected");
                const valDays = parseInt($("#revive_validity_days") ? $("#revive_validity_days").value : 30) || 30;
                const resetDate = ($("#revive_reset_date") && $("#revive_reset_date").checked) ? 1 : 0;

                btnRevive.disabled = true;
                btnRevive.innerHTML = `<i class="icon-spinner2 spinner mr-1"></i> Reviving...`;

                apiCall("revive_quotation", {
                    id: quoteId,
                    validity_days: valDays,
                    reset_date: resetDate
                }, "POST")
                .then(res => {
                    btnRevive.disabled = false;
                    btnRevive.innerHTML = `<i class="icon-history mr-1"></i> Confirm Revive`;
                    hideModal("#modal_revive_quote");

                    if (res && res.status === "success") {
                        toast(res.message || "Quotation revived successfully!");
                        apiCall("get_quotation", { id: quoteId }, "GET").then(fresh => {
                            if (fresh && fresh.quotation) {
                                const idx = Q.findIndex(x => x.id == quoteId);
                                if (idx !== -1) Q[idx] = fresh.quotation;
                                vq(quoteId);
                            } else {
                                go("log");
                            }
                        }).catch(() => go("log"));
                    } else {
                        toast((res && res.message) || "Failed to revive quotation");
                    }
                })
                .catch(err => {
                    btnRevive.disabled = false;
                    btnRevive.innerHTML = `<i class="icon-history mr-1"></i> Confirm Revive`;
                    toast("Network error while reviving quotation.");
                });
            };
        }
    }

    function saveQuotationApi(isIssue) {
        if (!ED) return;

        const activeBtn = isIssue ? $("#is") : $("#sd");
        const otherBtn = isIssue ? $("#sd") : $("#is");
        const laddaInst = createLadda(activeBtn);
        if (laddaInst) laddaInst.start();
        if (activeBtn) activeBtn.disabled = true;
        if (otherBtn) otherBtn.disabled = true;

        const stopLoading = () => {
            if (laddaInst) {
                try { laddaInst.stop(); } catch (e) {}
            }
            if (activeBtn) activeBtn.disabled = false;
            if (otherBtn) otherBtn.disabled = false;
        };

        // Ensure latest values from input fields are synced
        const discValEl = $('[data-k="discount_value"]');
        if (discValEl) {
            ED.discount_value = +discValEl.value || 0;
            ED.discount = ED.discount_value;
        }
        const discTypeEl = $('[data-k="discount_type"]');
        if (discTypeEl) {
            ED.discount_type = discTypeEl.value || "amount";
        }
        const vatEl = $('[data-k="vat_rate"]');
        if (vatEl) {
            ED.vat_rate = +vatEl.value || 10;
            ED.vat = ED.vat_rate;
        }

        const notesEl = $('#inp_internal_notes');
        if (notesEl) {
            ED.internal_notes = notesEl.value;
        }
        const chkMergeEl = $('#chk_merge_items');
        if (chkMergeEl) {
            ED.merge_items = chkMergeEl.checked ? 1 : 0;
        }
        const chkQtyEl = $('#chk_merge_qty');
        if (chkQtyEl) {
            ED.merge_qty = chkQtyEl.checked ? 1 : 0;
        }
        const mergedPriceEl = $('#inp_merged_price');
        if (mergedPriceEl) {
            ED.merged_lump_sum_price = +mergedPriceEl.value || 0;
        }
        const chkPhoneEl = $('#chk_include_user_phone');
        if (chkPhoneEl) {
            ED.include_user_phone = chkPhoneEl.checked ? 1 : 0;
        }
        const phoneEl = $('#inp_user_phone');
        if (phoneEl) {
            ED.user_phone = phoneEl.value.trim();
        }

        const payload = {
            id: ED.id || null,
            is_issue: isIssue,
            seq_no: ED.seq_no !== undefined ? ED.seq_no : ED.seq,
            rev_no: ED.rev_no !== undefined ? ED.rev_no : (ED.rev || 0),
            variation_no: ED.variation_no !== undefined ? ED.variation_no : (ED.vn || 0),
            is_amc: xIsAmc(ED) ? 1 : 0,
            client_name: ED.client_name || ED.client,
            client_code: ED.client_code || ED.code,
            client_address: ED.client_address || ED.addr,
            contact_no: ED.contact_no || ED.contact,
            attention: ED.attention || ED.attn,
            subject: ED.subject || ED.subj,
            quotation_date: ED.quotation_date || ED.date || TODAY,
            user_code: CU,
            user_name: USERS[CU] ? (Array.isArray(USERS[CU]) ? USERS[CU][0] : USERS[CU].name) : currentUserObj.name,
            user_designation: USERS[CU] ? (Array.isArray(USERS[CU]) ? USERS[CU][1] : USERS[CU].title) : currentUserObj.title,
            user_phone: ED.user_phone || "",
            include_user_phone: ED.include_user_phone ? 1 : 0,
            vat_rate: ED.vat_rate !== undefined ? ED.vat_rate : (ED.vat || 10),
            discount_type: ED.discount_type || "amount",
            discount_value: ED.discount_value !== undefined ? +ED.discount_value : (ED.discount !== undefined ? +ED.discount : 0),
            discount_amount: discAmount(ED),
            internal_notes: ED.internal_notes || "",
            merge_items: ED.merge_items ? 1 : 0,
            merge_qty: ED.merge_qty ? 1 : 0,
            merged_lump_sum_price: ED.merged_lump_sum_price !== undefined ? +ED.merged_lump_sum_price : 0,
            bullet_items: ED.bullet_items ? 1 : 0,
            terms: ED.terms || T0,
            items: ED.items || []
        };

        apiCall("save_quotation", payload, "POST").then(res => {
            if (res && res.status === "success") {
                toast(res.message);
                // Reload quotations
                apiCall("get_quotations", {}, "GET").then(qRes => {
                    stopLoading();
                    if (qRes && qRes.status === "success" && qRes.quotations) {
                        Q = qRes.quotations;
                    }
                    if (isIssue) {
                        vq(res.id);
                    } else {
                        go("log");
                    }
                }).catch(() => {
                    stopLoading();
                    if (isIssue) {
                        vq(res.id);
                    } else {
                        go("log");
                    }
                });
            } else {
                stopLoading();
                toast((res && res.message) || "Failed to save quotation");
            }
        }).catch(err => {
            stopLoading();
            toast("An error occurred while saving the quotation.");
        });
    }

    function updateStatus(id, newStatus, reason, remark, extra = {}, btnEl = null) {
        let laddaInst = createLadda(btnEl);
        if (laddaInst) laddaInst.start();
        if (btnEl) btnEl.disabled = true;

        const payload = Object.assign({ id, status: newStatus, reason, remark }, extra);
        apiCall("update_status", payload, "POST").then(res => {
            if (res && res.status === "success") {
                toast(res.message);
                apiCall("get_quotations", {}, "GET").then(qRes => {
                    if (laddaInst) { try { laddaInst.stop(); } catch (e) {} }
                    if (btnEl) btnEl.disabled = false;
                    if (qRes && qRes.status === "success" && qRes.quotations) {
                        Q = qRes.quotations;
                    }
                    vq(id);
                }).catch(() => {
                    if (laddaInst) { try { laddaInst.stop(); } catch (e) {} }
                    if (btnEl) btnEl.disabled = false;
                    vq(id);
                });
            } else {
                if (laddaInst) { try { laddaInst.stop(); } catch (e) {} }
                if (btnEl) btnEl.disabled = false;
                toast((res && res.message) || "Failed to update status");
            }
        }).catch(err => {
            if (laddaInst) { try { laddaInst.stop(); } catch (e) {} }
            if (btnEl) btnEl.disabled = false;
            toast("Error updating quotation status");
        });
    }

    function deleteDraft(id) {
        apiCall("delete_draft", { id }, "POST").then(res => {
            if (res && res.status === "success") {
                toast("Draft deleted");
                Q = Q.filter(x => x.id != id);
                go("log");
            } else {
                toast("Failed to delete draft");
            }
        });
    }

    // ==========================================
    // VIEW 5: BUSINESS RULES DEV HANDOFF (vrules)
    // ==========================================
    function vrules() {
        $$("aside a[data-v], .thc-subnav-btn[data-v]").forEach(a => a.classList.toggle("on", a.dataset.v === "rules"));
        const Y = '<span class="y">✓</span>', N = '<span class="n">✗</span>';
        const R = [
            ["Draft", Y, N, N, N, N, N, Y, "No"],
            ["Pending", N, Y, Y, Y, N, N, Y, "Sent"],
            ["Approved", N, N, "—", N, Y, '<span class="m">Admin only</span>', Y, "Sent + approved"],
            ["Not approved", N, Y, Y, "—", N, N, Y, "Sent"],
            ["Superseded", N, N, "Only if no revision in its group is approved", N, N, N, Y, "No"],
            ["Void", N, N, N, N, N, N, Y, "No"]
        ];

        $("#v").innerHTML = `
            <div class="top">
                <h1>Business rules · developer handoff</h1>
            </div>
            <p style="color:var(--mut);margin-top:-6px;font-size:13px;">Rules enforced by the system. Every rule is checked on the server, not only hidden in the UI.</p>
            
            <div class="card pad">
                <h2>Status × allowed action</h2>
                <div class="tw">
                    <table class="rl">
                        <thead>
                            <tr>
                                <th>Status</th>
                                <th>Edit</th>
                                <th>Revise</th>
                                <th>Mark approved</th>
                                <th>Mark not approved</th>
                                <th>Create variation</th>
                                <th>Reopen</th>
                                <th>PDF</th>
                                <th>Counted in totals</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${M(R, r => `
                                <tr>
                                    <td><b>${r[0]}</b></td>
                                    ${M(r.slice(1), c => `<td>${c}</td>`)}
                                </tr>`
                            )}
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card pad">
                <h2>Rules</h2>
                <ul class="r">
                    <li><b>1. Issued quotes are immutable.</b> Edit exists only for Draft. Any change to an issued quote is a new revision (R1, R2…) under the same quote number.</li>
                    <li><b>2. Approved is final.</b> Edit and Revise are blocked in the UI and rejected by the API. Approval is never lost by creating another revision.</li>
                    <li><b>3. Superseded</b> means an older revision replaced by a newer issued one in the same group (quote number + variation). An Approved revision can never become Superseded.</li>
                    <li><b>4. One approved revision per group.</b> Approving a revision voids any other open (Draft or Pending) revision in that group. If the client approves an older Superseded revision (when no other revision in its group is approved), allow it and void the newer open ones.</li>
                    <li><b>5. Variations.</b> Changes after approval are issued from the approved quote as V1, V2… with their own revision chain and their own approval. Number: <code>CG/THC/MA/QTN/7074/1126/V1/R1</code>. PDF: <code>MA-QTN-7074-V1-R1.pdf</code>.</li>
                    <li><b>6. Reopen.</b> Administrator permission and a reason are required. Status returns to Draft, the approval details are cleared from the record but kept in the activity log. Intended for approving the wrong quote by mistake or unlocking it for authorized editing.</li>
                    <li><b>7. Mandatory fields.</b> Approval: client approver name and date (PO/LPO ref optional). Not approved: reason. Void: automatic system reason.</li>
                    <li><b>8. Totals.</b> Sent = Pending + Approved + Not approved. Approved = Approved only. Draft, Superseded and Void are excluded. An approved variation counts as its own approved quote.</li>
                    <li><b>9. Activity log.</b> Every status change records user, time, action and reason.</li>
                    <li><b>10. Permissions to add</b> in Role Management: <code>quotation.approve</code>, <code>quotation.reopen</code>, <code>quotation.variation</code>.</li>
                </ul>
            </div>

            <div class="card pad">
                <h2>Suggested data model</h2>
                <pre class="data-model">quotation {
  id, quote_no            // CG/THC/{initials}/QTN/{seq}/{MMYY}
  variation_no (0=original), revision_no (0=original)
  status: draft | pending | approved | not_approved | superseded | void
  client_type: amc | non_amc, client_code, client_name, client_address
  attention, subject, quote_date, vat_percent
  items[{description, qty, unit, unit_price}], terms[]
  created_by_user_id      // signer name + designation come from users table
  approval {approved_by, approved_on, client_po_ref}
  remark                  // not-approved or void reason
  activity[{at, user_id, action, from_status, to_status, note}]
}</pre>
            </div>

            <div class="card pad">
                <h2>Acceptance checks</h2>
                <ul class="r">
                    <li>✓ Approve a quote, then try Revise and Edit from the UI and the API: both are blocked.</li>
                    <li>✓ Approved totals stay the same after a variation is created.</li>
                    <li>✓ Revise a Pending quote: the older revision becomes Superseded and leaves the totals.</li>
                    <li>✓ Approve an older Superseded revision while a newer one is Pending: the newer one becomes Void.</li>
                    <li>✓ Reopen without administrator permission, or without a reason: denied.</li>
                    <li>✓ Variation of an approved quote gets a V1 number and needs its own approval.</li>
                    <li>✓ Draft, Superseded and Void never appear in sent or approved totals.</li>
                </ul>
            </div>
        `;
    }

    // ==========================================
    // RIGHT-CLICK SPELL CHECK & CORRECTION ENGINE
    // ==========================================
    const COMMON_TYPOS = {
        "repaire": ["repair", "repairs", "repaired"],
        "repaires": ["repairs", "repair"],
        "plubming": ["plumbing"],
        "pluming": ["plumbing"],
        "maintanence": ["maintenance"],
        "maintanance": ["maintenance"],
        "maintenence": ["maintenance"],
        "maintenace": ["maintenance"],
        "subect": ["subject"],
        "subjet": ["subject"],
        "subjt": ["subject"],
        "suject": ["subject"],
        "electircal": ["electrical"],
        "electical": ["electrical"],
        "electic": ["electric"],
        "conditoning": ["conditioning"],
        "conditoner": ["conditioner"],
        "instalation": ["installation"],
        "instaling": ["installing"],
        "instal": ["install"],
        "replaceing": ["replacing"],
        "replacment": ["replacement"],
        "servicing": ["servicing"],
        "servic": ["service"],
        "serivce": ["service"],
        "clening": ["cleaning"],
        "cleanning": ["cleaning"],
        "washig": ["washing"],
        "paintng": ["painting"],
        "leake": ["leak"],
        "leakge": ["leakage"],
        "piping": ["piping"],
        "materil": ["material"],
        "meterial": ["material"],
        "quntity": ["quantity"],
        "quanty": ["quantity"],
        "lumpsum": ["Lumpsum"],
        "lumsum": ["Lumpsum"],
        "lumpum": ["Lumpsum"],
        "quoattaion": ["quotation"],
        "quotaton": ["quotation"],
        "quotatn": ["quotation"],
        "teh": ["the"],
        "recieve": ["receive"],
        "recieved": ["received"],
        "recieving": ["receiving"],
        "seperate": ["separate"],
        "seperated": ["separated"],
        "untill": ["until"],
        "definately": ["definitely"],
        "completly": ["completely"],
        "necessery": ["necessary"],
        "requirment": ["requirement"],
        "requirments": ["requirements"],
        "requierd": ["required"],
        "agreemnt": ["agreement"],
        "waranty": ["warranty"],
        "warenty": ["warranty"],
        "guarenty": ["guarantee"],
        "validty": ["validity"],
        "scafolding": ["scaffolding"],
        "additonal": ["additional"],
        "aprove": ["approve"],
        "aproval": ["approval"],
        "attension": ["attention"],
        "atention": ["attention"]
    };

    let activeContextMenu = null;
    let spellDebounceTimer = null;
    let fieldSpellIssues = [];

    function removeSpellContextMenu() {
        if (activeContextMenu && activeContextMenu.parentNode) {
            activeContextMenu.parentNode.removeChild(activeContextMenu);
        }
        activeContextMenu = null;
    }

    document.addEventListener("click", removeSpellContextMenu);
    document.addEventListener("scroll", removeSpellContextMenu, true);
    document.addEventListener("keydown", function(e) {
        if (e.key === "Escape") removeSpellContextMenu();
    });

    function getWordAtEvent(ev, el) {
        if (!el) return null;
        const text = el.value || "";
        if (!text.trim()) return null;

        let start = 0;
        let end = 0;
        let word = "";

        if (typeof el.selectionStart === "number" && typeof el.selectionEnd === "number" && el.selectionEnd > el.selectionStart) {
            start = el.selectionStart;
            end = el.selectionEnd;
            word = text.substring(start, end).trim();
        } else {
            let pos = (typeof el.selectionStart === "number") ? el.selectionStart : 0;
            if (pos > text.length) pos = text.length;

            if (pos > 0 && /\s/.test(text[pos]) && !/\s/.test(text[pos - 1])) {
                pos--;
            }

            start = pos;
            while (start > 0 && /[^\s,;:!?"'()\[\]{}]/.test(text[start - 1])) {
                start--;
            }
            end = pos;
            while (end < text.length && /[^\s,;:!?"'()\[\]{}]/.test(text[end])) {
                end++;
            }
            word = text.substring(start, end).trim();
        }

        if (!word || word.length < 2) return null;
        return { word: word, start: start, end: end, fullText: text };
    }

    function applyWordCorrection(el, start, end, replacement) {
        const oldText = el.value || "";
        const newText = oldText.substring(0, start) + replacement + oldText.substring(end);
        el.value = newText;

        const newPos = start + replacement.length;
        try {
            el.setSelectionRange(newPos, newPos);
        } catch (e) {}

        // Dispatch input and change events so the quotation reactive engine and preview update
        el.dispatchEvent(new Event("input", { bubbles: true }));
        el.dispatchEvent(new Event("change", { bubbles: true }));

        toast(`Corrected to "${replacement}" ✓`);
    }

    function renderSpellMenuSuggestions(menu, el, wordInfo, cleanWord, suggestions) {
        const isCapitalized = /^[A-Z][a-z]/.test(cleanWord);
        const isAllUpper = /^[A-Z0-9]+$/.test(cleanWord) && cleanWord.length > 2;

        const formattedSuggestions = suggestions.map(s => {
            if (isAllUpper) return s.toUpperCase();
            if (isCapitalized) return s.charAt(0).toUpperCase() + s.slice(1);
            return s;
        });

        // Deduplicate suggestions
        const uniqueSuggestions = [...new Set(formattedSuggestions)].filter(s => s.toLowerCase() !== cleanWord.toLowerCase()).slice(0, 5);

        if (uniqueSuggestions.length === 0) {
            renderSpellMenuClean(menu, cleanWord);
            return;
        }

        let html = `
            <div class="spell-context-header">
                <span><i class="icon-spell-check mr-1" style="color:#0A4174;"></i> Spelling Suggestion</span>
                <span class="spell-context-target" title="${H(cleanWord)}">${H(cleanWord)}</span>
            </div>
            <div style="padding:4px 0;">
        `;

        uniqueSuggestions.forEach(sug => {
            html += `
                <div class="spell-context-item suggest-item" data-rep="${H(sug)}">
                    <i class="icon-checkmark3 text-success" style="font-size:13px;"></i>
                    <span>${H(sug)}</span>
                </div>
            `;
        });

        html += `
            </div>
            <div class="spell-context-divider"></div>
            <div class="spell-context-item" id="spell_menu_full_check" style="font-size:12.5px;color:#475569;font-weight:500;">
                <i class="icon-file-text2 text-muted" style="font-size:13px;"></i> Full Quotation Review…
            </div>
            <div class="spell-context-item" id="spell_menu_browser" style="font-size:12px;color:#94a3b8;font-weight:400;">
                <i class="icon-menu7 text-muted" style="font-size:12px;"></i> Shift+Right-Click for browser menu
            </div>
        `;

        menu.innerHTML = html;

        const items = menu.querySelectorAll(".suggest-item");
        items.forEach(it => {
            it.onclick = function(e) {
                e.stopPropagation();
                const rep = this.getAttribute("data-rep");
                if (rep) {
                    applyWordCorrection(el, wordInfo.start, wordInfo.end, rep);
                }
                removeSpellContextMenu();
            };
        });

        const fullCheckBtn = menu.querySelector("#spell_menu_full_check");
        if (fullCheckBtn) {
            fullCheckBtn.onclick = function(e) {
                e.stopPropagation();
                removeSpellContextMenu();
                runQuotationGrammarCheck("all");
            };
        }

        const browserBtn = menu.querySelector("#spell_menu_browser");
        if (browserBtn) {
            browserBtn.onclick = function(e) {
                e.stopPropagation();
                removeSpellContextMenu();
                toast("Tip: Hold Shift and Right-Click to open standard browser menu anytime");
            };
        }
    }

    function renderSpellMenuClean(menu, cleanWord) {
        menu.innerHTML = `
            <div class="spell-context-header">
                <span><i class="icon-spell-check mr-1" style="color:#0A4174;"></i> Spelling Check</span>
                <span class="spell-context-target">${H(cleanWord)}</span>
            </div>
            <div class="spell-context-badge">
                <i class="icon-checkmark-circle text-success" style="font-size:14px;"></i>
                <span><b>"${H(cleanWord)}"</b> looks correctly spelled</span>
            </div>
            <div class="spell-context-divider"></div>
            <div class="spell-context-item" id="spell_menu_full_check" style="font-size:12.5px;color:#475569;font-weight:500;">
                <i class="icon-file-text2 text-muted" style="font-size:13px;"></i> Full Quotation Review…
            </div>
            <div class="spell-context-item" id="spell_menu_browser" style="font-size:12px;color:#94a3b8;font-weight:400;">
                <i class="icon-menu7 text-muted" style="font-size:12px;"></i> Shift+Right-Click for browser menu
            </div>
        `;

        const fullCheckBtn = menu.querySelector("#spell_menu_full_check");
        if (fullCheckBtn) {
            fullCheckBtn.onclick = function(e) {
                e.stopPropagation();
                removeSpellContextMenu();
                runQuotationGrammarCheck("all");
            };
        }

        const browserBtn = menu.querySelector("#spell_menu_browser");
        if (browserBtn) {
            browserBtn.onclick = function(e) {
                e.stopPropagation();
                removeSpellContextMenu();
                toast("Tip: Hold Shift and Right-Click to open standard browser menu anytime");
            };
        }
    }

    // Right-Click Context Menu Listener for all editable text fields
    document.addEventListener("contextmenu", function(e) {
        if (e.shiftKey) return; // User holds Shift: allow native browser context menu

        const el = e.target;
        if (!el) return;

        const tag = el.tagName;
        const isTextInput = (tag === "TEXTAREA") || (tag === "INPUT" && (!el.type || el.type === "text" || el.type === "search"));
        if (!isTextInput || el.readOnly || el.disabled) return;

        // Check if inside quotation module
        const inQuotation = el.closest("#v") || el.closest("#app");
        if (!inQuotation) return;

        el.focus();

        const wordInfo = getWordAtEvent(e, el);
        if (!wordInfo || !wordInfo.word) return;

        const word = wordInfo.word;
        const cleanWord = word.replace(/^[^\w]+|[^\w]+$/g, "");
        if (!cleanWord || cleanWord.length < 2 || /^\d+$/.test(cleanWord)) return;

        e.preventDefault();
        removeSpellContextMenu();

        const menu = document.createElement("div");
        menu.className = "spell-context-menu";
        menu.id = "spell_context_menu";

        let posX = e.clientX;
        let posY = e.clientY;
        menu.style.left = posX + "px";
        menu.style.top = posY + "px";
        document.body.appendChild(menu);

        const rect = menu.getBoundingClientRect();
        if (posX + rect.width > window.innerWidth - 10) {
            posX = Math.max(10, window.innerWidth - rect.width - 10);
            menu.style.left = posX + "px";
        }
        if (posY + rect.height > window.innerHeight - 10) {
            posY = Math.max(10, window.innerHeight - rect.height - 10);
            menu.style.top = posY + "px";
        }

        activeContextMenu = menu;

        const lower = cleanWord.toLowerCase();
        let suggestions = [];

        // 1. Offline common typo dictionary
        if (COMMON_TYPOS[lower]) {
            suggestions = COMMON_TYPOS[lower];
        }

        // 2. Pre-cached issues from background check
        if (suggestions.length === 0 && Array.isArray(fieldSpellIssues)) {
            const found = fieldSpellIssues.find(iss => {
                const w = iss.word ? iss.word.toLowerCase() : "";
                return w === lower || (iss.offset <= wordInfo.start && (iss.offset + iss.length) >= wordInfo.end);
            });
            if (found && found.replacements && found.replacements.length > 0) {
                suggestions = found.replacements.map(r => typeof r === "string" ? r : r.value);
            }
        }

        if (suggestions.length > 0) {
            renderSpellMenuSuggestions(menu, el, wordInfo, cleanWord, suggestions);
            return;
        }

        // 3. Query LanguageTool API
        menu.innerHTML = `
            <div class="spell-context-header">
                <span><i class="icon-spell-check mr-1" style="color:#0A4174;"></i> Spelling Check</span>
                <span class="spell-context-target">${H(cleanWord)}</span>
            </div>
            <div class="spell-context-loading">
                <i class="icon-spinner2 spinner text-primary"></i> Checking suggestions…
            </div>
            <div class="spell-context-divider"></div>
            <div class="spell-context-item" id="spell_menu_full_check" style="font-size:12.5px;color:#475569;font-weight:500;">
                <i class="icon-file-text2 text-muted" style="font-size:13px;"></i> Full Quotation Review…
            </div>
        `;

        const fullCheckInitial = menu.querySelector("#spell_menu_full_check");
        if (fullCheckInitial) {
            fullCheckInitial.onclick = function() {
                removeSpellContextMenu();
                runQuotationGrammarCheck("all");
            };
        }

        checkGrammarAPI(wordInfo.fullText).then(res => {
            if (!activeContextMenu || activeContextMenu !== menu) return;
            const matches = res.matches || [];

            let matchCovering = matches.find(m => {
                const mStart = m.offset;
                const mEnd = m.offset + m.length;
                return (mStart <= wordInfo.start && mEnd >= wordInfo.end) || 
                       (Math.abs(mStart - wordInfo.start) <= 2 && Math.abs(mEnd - wordInfo.end) <= 2);
            });

            if (!matchCovering) {
                matchCovering = matches.find(m => {
                    const ctxText = (m.context && m.context.text) ? m.context.text.substr(m.context.offset, m.context.length) : "";
                    return ctxText.toLowerCase() === lower;
                });
            }

            if (matchCovering && matchCovering.replacements && matchCovering.replacements.length > 0) {
                const fetched = matchCovering.replacements.slice(0, 5).map(r => typeof r === "string" ? r : r.value);
                renderSpellMenuSuggestions(menu, el, wordInfo, cleanWord, fetched);
            } else {
                renderSpellMenuClean(menu, cleanWord);
            }
        }).catch(() => {
            if (!activeContextMenu || activeContextMenu !== menu) return;
            renderSpellMenuClean(menu, cleanWord);
        });
    });

    // Background pre-caching when typing stops in editable fields
    document.addEventListener("input", function(e) {
        const el = e.target;
        if (!el) return;
        const tag = el.tagName;
        const isTextInput = (tag === "TEXTAREA") || (tag === "INPUT" && (!el.type || el.type === "text" || el.type === "search"));
        if (!isTextInput) return;

        clearTimeout(spellDebounceTimer);
        spellDebounceTimer = setTimeout(() => {
            const val = el.value || "";
            if (!val.trim() || val.length < 3) {
                fieldSpellIssues = [];
                return;
            }
            checkGrammarAPI(val).then(res => {
                if (res && res.matches && Array.isArray(res.matches)) {
                    fieldSpellIssues = res.matches.map(m => {
                        const word = (m.context && m.context.text) ? m.context.text.substr(m.context.offset, m.context.length) : "";
                        return {
                            word: word,
                            offset: m.offset,
                            length: m.length,
                            replacements: m.replacements || [],
                            message: m.message
                        };
                    });
                }
            }).catch(() => {});
        }, 750);
    });

    // Global spellcheck enforcer for all user input areas and textareas
    document.addEventListener("focusin", function(e) {
        const el = e.target;
        if (!el) return;
        const tag = el.tagName;
        if (tag === "TEXTAREA" || (tag === "INPUT" && !["number", "date", "checkbox", "radio", "submit", "button", "hidden", "file", "password"].includes(el.type))) {
            el.spellcheck = true;
            if (el.getAttribute("spellcheck") !== "true") {
                el.setAttribute("spellcheck", "true");
            }
            if (!el.hasAttribute("lang")) {
                el.setAttribute("lang", "en");
            }
            if (!el.hasAttribute("autocomplete")) {
                el.setAttribute("autocomplete", "off");
            }
            if (!el.hasAttribute("autocorrect")) {
                el.setAttribute("autocorrect", "on");
            }
            if (!el.hasAttribute("autocapitalize")) {
                el.setAttribute("autocapitalize", "sentences");
            }
        }
    });

    // Start on DOM ready
    if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", loadInitialData);
    } else {
        loadInitialData();
    }
})();

