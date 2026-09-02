<div class="card">
    <?PHP
        include('template/card_head_control.inc');
    ?>

    <div class="card-body">

        <!-- Summary Counter Cards -->
        <div class="row mb-3">
            <div class="col-xl-3 col-sm-6 mb-2">
                <div class="stat-card" style="background: linear-gradient(135deg, #1e293b, #334155); border-left: 4px solid #38bdf8;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stat-number" id="stat_total_docs">0</div>
                            <div class="stat-label">Total Expiring Docs</div>
                        </div>
                        <i class="icon-file-text2 icon-2x opacity-75"></i>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6 mb-2">
                <div class="stat-card" style="background: linear-gradient(135deg, #7f1d1d, #991b1b); border-left: 4px solid #f87171;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stat-number" id="stat_expired_docs">0</div>
                            <div class="stat-label">Already Expired</div>
                        </div>
                        <i class="icon-alert icon-2x opacity-75"></i>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6 mb-2">
                <div class="stat-card" style="background: linear-gradient(135deg, #78350f, #92400e); border-left: 4px solid #fbbf24;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stat-number" id="stat_soon_docs">0</div>
                            <div class="stat-label">Expiring in 30 Days</div>
                        </div>
                        <i class="icon-alarm icon-2x opacity-75"></i>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6 mb-2">
                <div class="stat-card" style="background: linear-gradient(135deg, #14532d, #166534); border-left: 4px solid #4ade80;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stat-number" id="stat_valid_docs">0</div>
                            <div class="stat-label">Valid (> 30 Days)</div>
                        </div>
                        <i class="icon-checkmark4 icon-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Box -->
        <div class="card border mb-3" style="background-color: #f8fafc;">
            <div class="card-header header-elements-inline py-2 bg-light">
                <h6 class="card-title font-weight-semibold text-primary m-0">
                    <i class="icon-filter3 mr-2"></i> Filter &amp; Search Criteria
                </h6>
            </div>
            <div class="card-body py-3">
                <div class="row">
                    <!-- Date Range: From Date -->
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-2">
                        <label class="form-text text-muted font-weight-bold mb-1" style="font-size: 12px; color: #333;">
                            From Expiry Date
                        </label>
                        <input type="date" class="form-control" id="txt_from_date">
                    </div>

                    <!-- Date Range: To Date -->
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-2">
                        <label class="form-text text-muted font-weight-bold mb-1" style="font-size: 12px; color: #333;">
                            To Expiry Date
                        </label>
                        <input type="date" class="form-control" id="txt_to_date">
                    </div>

                    <!-- No. of Days Filter -->
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-2">
                        <label class="form-text text-muted font-weight-bold mb-1" style="font-size: 12px; color: #333;">
                            Expiry Duration (No. of Days)
                        </label>
                        <select id="select_days_filter" class="form-control form-control-select2" data-fouc>
                            <option value="all">All Documents with Expiry</option>
                            <option value="expired">Already Expired (<= 0 Days)</option>
                            <option value="7">Expiring within 7 Days</option>
                            <option value="15">Expiring within 15 Days</option>
                            <option value="30">Expiring within 30 Days (1 Month)</option>
                            <option value="60">Expiring within 60 Days (2 Months)</option>
                            <option value="90">Expiring within 90 Days (3 Months)</option>
                            <option value="180">Expiring within 180 Days (6 Months)</option>
                            <option value="custom">Custom Number of Days...</option>
                        </select>
                    </div>

                    <!-- Custom Days Input (Initially Hidden) -->
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-2" id="div_custom_days" style="display: none;">
                        <label class="form-text text-muted font-weight-bold mb-1" style="font-size: 12px; color: #333;">
                            Enter Number of Days (<= N days)
                        </label>
                        <input type="number" class="form-control" id="txt_custom_days" placeholder="e.g. 45" min="1" max="3650">
                    </div>

                    <!-- Document Type Filter -->
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-2">
                        <label class="form-text text-muted font-weight-bold mb-1" style="font-size: 12px; color: #333;">
                            Document Type
                        </label>
                        <select id="select_doc_type" class="form-control form-control-select2" data-fouc>
                            <option value="all">All Document Types</option>
                        </select>
                    </div>

                    <!-- Employee Type Filter -->
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-2">
                        <label class="form-text text-muted font-weight-bold mb-1" style="font-size: 12px; color: #333;">
                            Employee Type / Designation
                        </label>
                        <select id="select_emp_type" class="form-control form-control-select2" data-fouc>
                            <option value="all">All Employee Types</option>
                        </select>
                    </div>

                    <!-- Employee Status Filter -->
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-2">
                        <label class="form-text text-muted font-weight-bold mb-1" style="font-size: 12px; color: #333;">
                            Employee Status
                        </label>
                        <select id="select_emp_status" class="form-control form-control-select2" data-fouc>
                            <option value="Active" selected>Active Employees Only</option>
                            <option value="Inactive">Inactive Employees Only</option>
                            <option value="all">All Employees (Active &amp; Inactive)</option>
                        </select>
                    </div>

                    <!-- Action Buttons -->
                    <div class="col-lg-3 col-md-6 col-sm-12 mb-2 d-flex align-items-end" style="gap: 8px;">
                        <button type="button" id="btn_doc_search" class="btn btn-primary font-weight-semibold" style="height: 38px;">
                            <i class="icon-search4 mr-1"></i> Search
                        </button>
                        <button type="button" id="btn_doc_reset" class="btn btn-light border font-weight-semibold" style="height: 38px;">
                            <i class="icon-reset mr-1"></i> Reset
                        </button>
                        <button type="button" id="btn_doc_export_pdf" class="btn btn-warning font-weight-semibold classExportToPDF" style="height: 38px;">
                            <i class="icon-printer mr-1"></i> Print / Export
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Expiry Table Container -->
        <div class="card" style="overflow: auto;">
            <div class="card-header header-elements-inline bg-white">
                <h5 class="card-title font-weight-semibold">
                    <i class="icon-list3 mr-2 text-primary"></i> Employee Document Expiry List
                </h5>
                <div class="header-elements">
                    <span class="badge badge-light badge-striped badge-striped-left border-left-primary" id="badge_record_count">
                        0 Records Found
                    </span>
                </div>
            </div>

            <table class="table table-bordered table-striped table-hover datatable-selection-single" id="tbl_document_expiries" style="width: 100%;">
                <thead>
                    <tr class="bg-slate-800 text-white">
                        <th style="width: 40px; text-align: center;">Sl.</th>
                        <th style="width: 60px; text-align: center;">Photo</th>
                        <th style="width: 110px;">Emp. Code</th>
                        <th style="min-width: 180px;">Emp. Name</th>
                        <th style="min-width: 140px;">Emp. Type</th>
                        <th style="min-width: 160px;">Document Name</th>
                        <th style="width: 120px; text-align: center;">Expiry Date</th>
                        <th style="width: 150px; text-align: center;">Days to Expire</th>
                        <th style="width: 120px; text-align: center;">Expiry Status</th>
                        <th style="min-width: 160px;">Remarks / Notes</th>
                        <th style="width: 110px; text-align: center;">Attachment</th>
                        <th style="width: 90px; text-align: center;">Emp. Status</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Loaded dynamically via AJAX -->
                </tbody>
                <tfoot>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>

    </div>
</div>
