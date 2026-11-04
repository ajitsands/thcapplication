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

    // State Variables
    let USERS = {};
    let AMC = [];
    let T0 = [];
    let LIB = [];
    let REASONS = [];
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
        const uName = Array.isArray(uInfo) ? uInfo[0] : (uInfo.name || "Authorized Signatory");
        const uTitle = Array.isArray(uInfo) ? uInfo[1] : (uInfo.title || "THC Facility Management");

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
            <div class="lh">
                <b class="logo">thc.</b>
                <span>FACILITY<br>MANAGEMENT</span>
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

        const uniqueClients = [...new Set(Q.map(x => x.client_name || x.client).filter(Boolean))].sort();
        const userList = Object.keys(USERS).map(u => [u, Array.isArray(USERS[u]) ? USERS[u][0] : USERS[u].name]);

        $("#v").innerHTML = `
            <div class="top">
                <h1>Quotation log</h1>
                <div>
                    <button class="p" id="nA">+ New quote · AMC client</button>
                    <button id="nN">+ New quote · Non-AMC client</button>
                </div>
            </div>
            <div class="card bar">
                <input id="fq" placeholder="Search number, client or subject" value="${H(F.q)}">
                ${sel("fc", "All clients", uniqueClients.map(c => [c, c]))}
                ${sel("fs", "All statuses", ["Draft", "Pending", "Approved", "Not approved"].map(c => [c, c]))}
                ${sel("ft", "AMC & non-AMC", [["AMC", "AMC clients"], ["Non-AMC", "Non-AMC clients"]])}
                ${sel("fu", "All users", userList)}
                <label style="display:inline-flex;align-items:center;gap:5px;cursor:pointer;">
                    <input type="checkbox" id="fx" ${F.sup ? "checked" : ""}> Show superseded
                </label>
            </div>
            <div id="res"></div>`;

        $("#nA").onclick = () => go("A");
        $("#nN").onclick = () => go("N");

        [["fq", "q"], ["fc", "client"], ["fs", "st"], ["ft", "type"], ["fu", "user"]].forEach(([i, k]) => {
            const el = $("#" + i);
            if (el) el.oninput = e => { F[k] = e.target.value; res(); };
        });

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
                            const user = x.user_code || x.user || "—";
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
                                <td>${H(user)}</td>
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
        const uName = Array.isArray(uInfo) ? uInfo[0] : (uInfo.name || "Authorized User");
        const uTitle = Array.isArray(uInfo) ? uInfo[1] : (uInfo.title || "THC");

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
                            <select id="cl">
                                <option value="">Select active AMC client…</option>
                                ${M(AMC, c => `
                                    <option value="${H(c.code)}" ${clientCode == c.code ? "selected" : ""}>
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

        if ($("#cl")) {
            $("#cl").onchange = ev => {
                const selCode = ev.target.value;
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

        // Initialize at quotation log
        go("log");
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
