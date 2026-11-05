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

    // Date formatting helper: "27th October 2026"
    function fd(s) {
        if (!s) return "—";
        const parts = s.split("-");
        if (parts.length < 3) return s;
        const d = new Date(parts[0], parts[1] - 1, parts[2]);
        const n = d.getDate();
        const o = (n % 100 > 10 && n % 100 < 14) || n % 10 > 3 ? "th" : ["th", "st", "nd", "rd"][n % 10] || "th";
        const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        return n + o + " " + months[d.getMonth()] + " " + d.getFullYear();
    }

    // Amount calculation helpers
    const itemTotal = it => (+it.quantity || +it[1] || 0) * (+it.unit_price || +it[3] || 0);
    const amt = q => (q.items || []).reduce((t, r) => t + itemTotal(r), 0);
    const tot = q => amt(q) * (1 + (q.vat_rate || q.vat || 10) / 100);
    const SENT = ["Pending", "Approved", "Not approved"];
    const sm = (a, f) => a.reduce((t, x) => t + f(x), 0);

    // Expired helper: Pending > 15 days
    const exp = q => {
        if (q.status !== "Pending" && q.st !== "Pending") return false;
        const qDate = new Date(q.quotation_date || q.date);
        const diffDays = (new Date() - qDate) / (1000 * 60 * 60 * 24);
        return diffDays > 15;
    };

    // Status tag renderer
    const tg = q => {
        const status = q.status || q.st || "Draft";
        const cleanClass = status.replace(/\s+/g, "");
        const isExp = exp(q);
        return `<span class="tag ${cleanClass}">${H(status)}${isExp ? " · expired" : ""}</span>`;
    };

    // Formatted PDF filename
    const fnm = q => {
        const u = q.user_code || q.user || "THC";
        const seq = q.seq_no || q.seq || "DRAFT";
        const rev = q.rev_no !== undefined ? q.rev_no : (q.rev || 0);
        return `${u}-QTN-${seq}${rev ? "-R" + rev : ""}`;
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
    let Q = [];
    let CU = "MA";
    let ED = null;
    let F = { q: "", client: "", st: "", type: "", user: "", sup: false };
    let TODAY = new Date().toISOString().slice(0, 10);
    let currentUserObj = { code: "MA", name: "Mohammed Ali", title: "Operations Manager" };

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

    // Official THC Facility Management Letterhead Preview Sheet
    function sheet(q) {
        const sub = amt(q);
        const vatRate = q.vat_rate !== undefined ? q.vat_rate : (q.vat !== undefined ? q.vat : 10);
        const vatVal = (sub * vatRate) / 100;
        const grandTot = sub + vatVal;

        const uCode = q.user_code || q.user || CU;
        const uInfo = USERS[uCode] || [q.user_name || "Authorized Signatory", q.user_designation || "THC Facility Management"];
        let uName = q.user_name || (Array.isArray(uInfo) ? uInfo[0] : (uInfo.name || "Authorized Signatory"));
        if (uName === "Adminstrator") uName = "Administrator";
        const uTitle = q.user_designation || (Array.isArray(uInfo) ? uInfo[1] : (uInfo.title || "THC Facility Management"));

        const qNo = q.quotation_no || q.no;
        const qRev = q.rev_no !== undefined ? q.rev_no : (q.rev || 0);
        const qDate = q.quotation_date || q.date || TODAY;
        const clientName = q.client_name || q.client || "—";
        const clientAddr = q.client_address || q.addr || "";
        const clientCode = q.client_code || q.code || "";
        const attn = q.attention || q.attn || "";
        const subj = q.subject || q.subj || "—";
        const terms = q.terms || T0;
        const items = q.items || [];

        return `
        <div class="sheet">
            <div class="lh" style="margin-bottom:16px;">
                <img src="global_assets/images/logo_print.png" 
                     onerror="if(!this.dataset.fb){this.dataset.fb=1;this.src='../view/global_assets/images/logo_print.png';}else if(this.dataset.fb==1){this.dataset.fb=2;this.src='data:image/png;base64,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';}" 
                     alt="THC Facility Management" 
                     style="max-height:65px;height:auto;display:block;">
            </div>
            
            <p>
                <b>No: ${qNo ? H(qNo) + (qRev ? "/R" + qRev : "") : "(assigned on issue)"}<br>
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
                        <th style="width:38px;text-align:center;">Sl.</th>
                        <th>Description</th>
                        <th style="width:65px;text-align:center;">Qty</th>
                        <th style="width:80px;text-align:center;">Unit</th>
                        <th style="width:95px;text-align:right;">Total (BD)</th>
                    </tr>
                </thead>
                <tbody>
                    ${M(items, (r, i) => {
                        const desc = r.description || r[0] || "";
                        const qty = r.quantity !== undefined ? r.quantity : (r[1] !== undefined ? r[1] : 1);
                        const unit = r.unit || r[2] || "Lumpsum";
                        const lineTot = itemTotal(r);
                        return `
                        <tr>
                            <td class="c">${i + 1}.</td>
                            <td>${H(desc)}</td>
                            <td class="c">${qty}</td>
                            <td class="c">${H(unit)}</td>
                            <td class="r">${f3(lineTot)}</td>
                        </tr>`;
                    })}
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="c"><b>Amount Excluding VAT</b></td>
                        <td class="r"><b>${f3(sub)}</b></td>
                    </tr>
                    <tr>
                        <td colspan="4" class="c"><b>VAT ${vatRate}%</b></td>
                        <td class="r"><b>${f3(vatVal)}</b></td>
                    </tr>
                    <tr>
                        <td colspan="4" class="c"><b>Total Amount (BD)</b></td>
                        <td class="r"><b>${f3(grandTot)}</b></td>
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
                    THC Facility Management W.L.L<br><br>
                    ${H(uName)}<br>
                    <span style="font-weight:400;color:#444;">${H(uTitle)}</span></b>
                </div>
                <div class="ap">
                    <b>Approved By:</b><br><br>
                    Name:<br><br>
                    Date:
                </div>
            </div>
            
            <div class="ft">
                Tel: +973 17 100 190 | info@thc.com.bh | www.thc.com.bh · CR 88982-1 · YBA Kanoo Tower, Diplomatic Area, Kingdom of Bahrain
            </div>
        </div>`;
    }

    // Direct High-Resolution Print / PDF Generation
    function pdf(q) {
        if (q && q.id) {
            const url = `print/print_quotation_module.php?id=${encodeURIComponent(q.id)}&autoprint=1`;
            const win = window.open(url, "_blank");
            if (win) {
                win.focus();
                return;
            }
        }

        const fn = fnm(q);
        const ph = $("#ph");
        if (ph) {
            ph.innerHTML = sheet(q);
        }
        const oldTitle = document.title;
        document.title = fn;
        toast("File name: " + fn + ".pdf (choose Save as PDF in the print window)");
        try {
            window.print();
        } catch (e) {
            console.error(e);
        }
        document.title = oldTitle;
    }

    // Main Router
    function go(v) {
        if (window.jQuery && typeof window.jQuery.fn.select2 === "function") {
            ['#cl', '#fc', '#fu'].forEach(selId => {
                const $s = window.jQuery(selId);
                if ($s.length && $s.data('select2')) {
                    $s.select2('destroy');
                }
            });
            window.jQuery('.select2-container--open').remove();
        }
        $$("aside a[data-v]").forEach(a => a.classList.toggle("on", a.dataset.v === v));
        ED = null;
        if (v === "log") vlog();
        else if (v === "perf") vperf();
        else if (v === "A" || v === "N") {
            const isAmc = v === "A";
            ED = {
                id: null,
                seq_no: null,
                rev_no: 0,
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
                items: [{ description: "", quantity: 1, unit: "Lumpsum", unit_price: 0, total_price: 0 }],
                vat_rate: 10,
                terms: T0.slice(),
                status: "Draft",
                remark: ""
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
            ...AMC.map(c => c.name).filter(Boolean)
        ])].sort((a, b) => a.localeCompare(b));
        const userList = Object.keys(USERS).map(u => [u, Array.isArray(USERS[u]) ? USERS[u][0] : USERS[u].name]);

        $("#v").innerHTML = `
            <div class="top">
                <h1>Quotation log</h1>
                <div>
                    <button class="p" id="nA">+ New quote · AMC client</button>
                    <button id="nN">+ New quote · Non-AMC client</button>
                </div>
            </div>
            <div class="card bar filter-toolbar">
                <input id="fq" placeholder="Search number, client or subject" value="${H(F.q)}">
                ${sel("fc", "All clients", uniqueClients.map(c => [c, c]))}
                ${sel("fs", "All statuses", ["Draft", "Pending", "Approved", "Not approved"].map(c => [c, c]))}
                ${sel("ft", "AMC & non-AMC", [["AMC", "AMC clients"], ["Non-AMC", "Non-AMC clients"]])}
                ${sel("fu", "All users", userList)}
                <label>
                    <input type="checkbox" id="fx" ${F.sup ? "checked" : ""}> Show superseded
                </label>
            </div>
            <div id="res"></div>`;

        $("#nA").onclick = () => go("A");
        $("#nN").onclick = () => go("N");

        [["fq", "q"], ["fs", "st"], ["ft", "type"]].forEach(([i, k]) => {
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

    function res() {
        const L = Q.filter(x => {
            const status = x.status || x.st;
            const client = x.client_name || x.client || "";
            const isAmc = x.is_amc !== undefined ? !!x.is_amc : !!x.amc;
            const user = x.user_code || x.user;
            const qNo = x.quotation_no || x.no || "";
            const subj = x.subject || x.subj || "";

            if (!F.sup && status === "Superseded") return false;
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

        const S = L.filter(x => SENT.includes(x.status || x.st));
        const A = L.filter(x => (x.status || x.st) === "Approved");

        $("#res").innerHTML = `
            <div class="kpis">
                ${M([
                    ["Quotes sent", S.length],
                    ["Value sent · excl. VAT", f3(sm(S, amt))],
                    ["Value sent · incl. VAT", f3(sm(S, tot))],
                    ["Approved quotes", A.length],
                    ["Approved · excl. VAT", f3(sm(A, amt))],
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
                            <th>Status</th>
                            <th style="width:60px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        ${M(L, x => {
                            const qNo = x.quotation_no || x.no;
                            const rev = x.rev_no !== undefined ? x.rev_no : (x.rev || 0);
                            const client = x.client_name || x.client || "—";
                            const code = x.client_code || x.code || "—";
                            const isAmc = x.is_amc !== undefined ? !!x.is_amc : !!x.amc;
                            const subj = x.subject || x.subj || "—";
                            const date = x.quotation_date || x.date || "—";
                            const userCode = x.user_code || x.user || "—";
                            let userName = x.user_name || (USERS[userCode] ? (Array.isArray(USERS[userCode]) ? USERS[userCode][0] : USERS[userCode].name) : "") || userCode;
                            if (userName === "Adminstrator") userName = "Administrator";
                            const remark = x.remark || "";
                            return `
                            <tr data-id="${x.id}">
                                <td>
                                    <b>${qNo ? H(qNo) : "Draft"}</b>
                                    ${rev ? ` <span class="tag">R${rev}</span>` : ""}
                                </td>
                                <td>
                                    ${H(client)}<br>
                                    <small>${H(code)} · ${isAmc ? "AMC" : "Non-AMC"}</small>
                                </td>
                                <td class="w">${H(subj)}</td>
                                <td>${date}</td>
                                <td>${H(userName)}</td>
                                <td>${f3(amt(x))}</td>
                                <td><b>${f3(tot(x))}</b></td>
                                <td class="w">
                                    ${tg(x)}
                                    ${remark ? `<br><small>${H(remark)}</small>` : ""}
                                </td>
                                <td>
                                    <button data-pdf="${x.id}" title="Print / PDF">PDF</button>
                                </td>
                            </tr>`;
                        })}
                    </tbody>
                </table>
                ${L.length ? "" : '<p style="padding:28px;text-align:center;color:var(--mut);">No quotations match these filters.</p>'}
            </div>
            <p style="color:var(--mut);font-size:12px;margin-top:8px;">Totals follow the filters above. Drafts and superseded revisions are never counted.</p>`;

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
            const ra = a.rev_no !== undefined ? a.rev_no : (a.rev || 0);
            const rb = b.rev_no !== undefined ? b.rev_no : (b.rev || 0);
            return ra - rb;
        }) : [q];

        const status = q.status || q.st;
        const pend = status === "Pending";
        const qNo = q.quotation_no || q.no;
        const rev = q.rev_no !== undefined ? q.rev_no : (q.rev || 0);
        const nextRev = Math.max(...h.map(x => (x.rev_no !== undefined ? x.rev_no : (x.rev || 0)))) + 1;

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
                <h1>${qNo ? H(qNo) + (rev ? " / R" + rev : "") : "Draft quotation"} ${tg(q)}</h1>
                <div>
                    <button id="bk">← Log</button>
                    ${status === "Draft" ? '<button id="ed">Edit draft</button> <button class="d" id="del">Delete draft</button>' : ""}
                    ${SENT.includes(status) ? `<button id="rv">Revise (R${nextRev})</button>` : ""}
                    <button id="dp">Duplicate</button>
                    <button class="p" id="dl">⬇ Download PDF</button>
                </div>
            </div>
            
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
                            <div>${f3(amt(q))} excl. · <b>${f3(tot(q))}</b> incl. VAT</div>
                            
                            <span>PDF file name</span>
                            <div>${fnm(q)}.pdf</div>
                            
                            ${remark ? `<span>Remark</span><div>${H(remark)}</div>` : ""}
                        </div>
                    </div>
                    
                    ${h.length > 1 ? `
                    <div class="card pad">
                        <h2>Revision history</h2>
                        ${M(h, x => {
                            const xRev = x.rev_no !== undefined ? x.rev_no : (x.rev || 0);
                            const xDate = x.quotation_date || x.date;
                            return `
                            <div style="margin-top:8px;">
                                <a href="#" data-r="${x.id}" style="${x.id == q.id ? 'font-weight:700;' : ''}">${xRev ? "R" + xRev : "Original"}</a>
                                · ${xDate} · ${f3(tot(x))} incl. VAT ${tg(x)}
                            </div>`;
                        })}
                    </div>` : ""}
                    
                    ${pend ? `
                    <div class="card pad">
                        <h2>Client decision</h2>
                        <div style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:8px;">
                            <button class="p" id="ya">Mark approved</button>
                            <button class="d" id="no">Mark not approved</button>
                        </div>
                        <div id="nab" hidden style="margin-top:12px;border-top:1px solid var(--line);padding-top:12px;">
                            <label style="display:block;margin-bottom:4px;font-weight:600;">Reason for rejection <span style="color:var(--bad);">*</span></label>
                            <select id="rs" style="width:100%;margin-bottom:8px;">
                                <option value="">Select reason (required)</option>
                                ${M(REASONS, r => `<option>${H(r)}</option>`)}
                            </select>
                            <textarea id="rt" rows="2" placeholder="Additional remark (optional)" style="width:100%;margin-bottom:8px;"></textarea>
                            <button class="d" id="cf">Confirm not approved</button>
                        </div>
                    </div>` : ""}
                </div>
                
                <div id="pv">${sheet(q)}</div>
            </div>`;

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
                if (confirm("Are you sure you want to delete this draft?")) {
                    deleteDraft(q.id);
                }
            };
        }

        if ($("#rv")) {
            $("#rv").onclick = () => {
                ED = JSON.parse(JSON.stringify(q));
                ED.id = null;
                ED.rev_no = nextRev;
                ED.rev = nextRev;
                ED.status = "Draft";
                ED.st = "Draft";
                ED.remark = "";
                ED.quotation_date = TODAY;
                ED.date = TODAY;
                ED.user_code = CU;
                ED.user = CU;
                edit();
                toast("Revision R" + nextRev + " started from " + (qNo || "quote"));
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

        if (pend) {
            $("#ya").onclick = () => {
                updateStatus(q.id, "Approved", "", "");
            };
            $("#no").onclick = () => {
                $("#nab").hidden = false;
            };
            $("#cf").onclick = () => {
                const rsVal = $("#rs").value;
                if (!rsVal) return toast("A reason is required for not approved quotes");
                const rtVal = $("#rt").value.trim();
                updateStatus(q.id, "Not approved", rsVal, rtVal);
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

        const clientName = e.client_name || e.client || "";
        const clientCode = e.client_code || e.code || "";
        const clientAddr = e.client_address || e.addr || "";
        const contact = e.contact_no || e.contact || "";
        const attn = e.attention || e.attn || "";
        const date = e.quotation_date || e.date || TODAY;
        const subj = e.subject || e.subj || "";
        const vat = e.vat_rate !== undefined ? e.vat_rate : (e.vat !== undefined ? e.vat : 10);

        $("#v").innerHTML = `
            <div class="top">
                <h1>${seq ? "Revise quotation" : "New quotation"} <span class="tag">${isAmc ? "AMC client" : "Non-AMC client"}</span></h1>
                <div>
                    <button id="cn">Cancel</button>
                    <button id="sd">Save draft</button>
                    <button class="p" id="is">Issue quote</button>
                </div>
            </div>
            
            <div class="two">
                <div>
                    <!-- Client Card -->
                    <div class="card pad">
                        <h2>Client</h2>
                        ${isAmc ? `
                            <select id="cl" class="form-control select-search" data-placeholder="Select active AMC client…">
                                <option value="">Select active AMC client…</option>
                                ${M(AMC, c => `
                                    <option value="${H(c.code)}" ${clientCode == c.code ? "selected" : ""} data-contact="${H(c.contact || '')}" data-address="${H(c.address || '')}">
                                        ${H(c.code)} · ${H(c.name)}
                                    </option>`
                                )}
                            </select>
                        ` : `
                            <div class="g2">
                                <input data-k="client_name" placeholder="Client name" value="${H(clientName)}">
                                <input data-k="contact_no" placeholder="Contact number" value="${H(contact)}">
                            </div>
                        `}
                        
                        <textarea id="ad" data-k="client_address" rows="2" ${isAmc ? "readonly" : ""} placeholder="${isAmc ? "Address is pulled from the AMC client record" : "Client address"}">${H(clientAddr)}</textarea>
                        
                        <div class="g2">
                            <input data-k="attention" placeholder="Kind attention" value="${H(attn)}">
                            <input type="date" data-k="quotation_date" value="${date}">
                        </div>
                        
                        <input data-k="subject" placeholder="Subject" value="${H(subj)}">
                        
                        <select data-k="vat_rate">
                            ${M([10, 5, 0], v => `<option value="${v}" ${vat == v ? "selected" : ""}>VAT ${v}%</option>`)}
                        </select>
                        
                        <p style="color:var(--mut);margin:8px 0 0;font-size:12px;">
                            Signed as <b>${H(uName)}</b>, ${H(uTitle)} (from the logged-in profile)
                        </p>
                    </div>
                    
                    <!-- Scope of Works Card -->
                    <div class="card pad">
                        <h2>Scope of works</h2>
                        <div class="it h">
                            <span>Qty</span>
                            <span>Unit (editable)</span>
                            <span>Unit price (BD)</span>
                            <span>Total (BD)</span>
                            <span></span>
                        </div>
                        <div id="its"></div>
                        <button id="ai">+ Add item</button>
                    </div>
                    
                    <!-- Terms and Conditions Card -->
                    <div class="card pad">
                        <h2>Terms and conditions <small style="color:var(--mut);font-weight:400;">edit freely for this quote</small></h2>
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

        // Reactive input handler
        $("#v").oninput = ev => {
            const t = ev.target;
            const k = t.dataset.k;
            if (k) {
                ED[k] = k === "vat_rate" ? +t.value : t.value;
                if (k === "client_name") ED.client = t.value;
                if (k === "contact_no") ED.contact = t.value;
                if (k === "client_address") ED.addr = t.value;
                if (k === "attention") ED.attn = t.value;
                if (k === "quotation_date") ED.date = t.value;
                if (k === "subject") ED.subj = t.value;
                if (k === "vat_rate") ED.vat = +t.value;
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
            const adField = $("#ad");
            if (adField) adField.value = ED.client_address;
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

        $("#its").onclick = ev => {
            const btn = ev.target.closest("[data-rm]");
            if (btn && ED.items.length > 1) {
                ED.items.splice(+btn.dataset.rm, 1);
                renderItems();
                renderLivePreview();
            }
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

        $("#sd").onclick = () => {
            saveQuotationApi(false);
        };

        $("#is").onclick = () => {
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

            return `
            <div class="it">
                <input data-i="${i}" data-f="desc" placeholder="Description of work" value="${H(desc)}" style="grid-column:1/-1;">
                <input type="number" min="0" data-i="${i}" data-f="qty" value="${qty}">
                <input list="uom" data-i="${i}" data-f="unit" value="${H(unit)}">
                <input type="number" min="0" step="0.001" data-i="${i}" data-f="price" value="${price}">
                <b id="rt${i}">${f3(lineTot)}</b>
                <button data-rm="${i}" title="Remove">✕</button>
            </div>`;
        });
    }

    function renderTerms() {
        const el = $("#tm");
        if (!el || !ED) return;
        el.innerHTML = M(ED.terms, (t, i) => `
            <div class="tr">
                <textarea rows="2" data-t="${i}">${H(t)}</textarea>
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
                ve: sm(S, amt),
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

    function loadInitialData() {
        apiCall("get_initial_data", {}, "GET").then(res => {
            if (res && res.status === "success") {
                if (res.current_user) {
                    currentUserObj = res.current_user;
                    CU = currentUserObj.code;
                }
                if (res.users) USERS = res.users;
                if (res.amc_clients) AMC = res.amc_clients;
                if (res.default_terms) T0 = res.default_terms;
                if (res.library_terms) LIB = res.library_terms;
                if (res.rejection_reasons) REASONS = res.rejection_reasons;
                if (res.quotations) Q = res.quotations;
            }

            initAppUi();
        });
    }

    function initAppUi() {
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

        // Attach aside click listeners
        $$("aside a[data-v]").forEach(a => {
            a.onclick = () => go(a.dataset.v);
        });

        // Initialize view based on URL query parameter ?v= (log, A, N, perf)
        const urlParams = new URLSearchParams(window.location.search);
        const initialView = urlParams.get("v");
        if (initialView && ["log", "A", "N", "perf"].includes(initialView)) {
            go(initialView);
        } else {
            go("log");
        }
    }

    function saveQuotationApi(isIssue) {
        const payload = {
            id: ED.id || null,
            is_issue: isIssue,
            seq_no: ED.seq_no !== undefined ? ED.seq_no : ED.seq,
            rev_no: ED.rev_no !== undefined ? ED.rev_no : (ED.rev || 0),
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
            vat_rate: ED.vat_rate !== undefined ? ED.vat_rate : (ED.vat || 10),
            terms: ED.terms || T0,
            items: ED.items || []
        };

        apiCall("save_quotation", payload, "POST").then(res => {
            if (res && res.status === "success") {
                toast(res.message);
                // Reload quotations
                apiCall("get_quotations", {}, "GET").then(qRes => {
                    if (qRes && qRes.status === "success" && qRes.quotations) {
                        Q = qRes.quotations;
                    }
                    if (isIssue) {
                        vq(res.id);
                    } else {
                        go("log");
                    }
                });
            } else {
                toast((res && res.message) || "Failed to save quotation");
            }
        });
    }

    function updateStatus(id, newStatus, reason, remark) {
        apiCall("update_status", { id, status: newStatus, reason, remark }, "POST").then(res => {
            if (res && res.status === "success") {
                toast(res.message);
                const q = Q.find(x => x.id == id);
                if (q) {
                    q.status = newStatus;
                    q.st = newStatus;
                    q.rejection_reason = reason;
                    q.remark = res.remark;
                }
                vq(id);
            } else {
                toast((res && res.message) || "Failed to update status");
            }
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

    // Start on DOM ready
    if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", loadInitialData);
    } else {
        loadInitialData();
    }
})();

