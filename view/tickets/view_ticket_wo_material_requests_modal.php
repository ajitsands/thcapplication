<!-- Material Requests for Work Order Modal - Master-Detail Layout -->
<div id="modal_view_material_requests_wo" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-xl" style="max-width: 90%; width: 90%;">
        <div class="modal-content">
            <div class="modal-header bg-slate">
                <h5 class="modal-title"><i class="icon-cube mr-2"></i> Material Requests &mdash; <span id="mat_req_wo_label" class="font-weight-semibold"></span></h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body p-0">
                <div class="row m-0" style="min-height: 500px;">
                    
                    <!-- LEFT COLUMN: Requests List -->
                    <div class="col-md-4 p-0 border-right bg-light" style="max-height: 600px; overflow-y: auto;">
                        <div class="p-2 border-bottom bg-white font-weight-bold text-muted">
                            <i class="icon-list-unordered mr-1"></i> Requests
                        </div>
                        <div id="mat_req_list_container">
                            <div class="text-center py-4"><i class="icon-spinner2 spinner mr-2"></i> Loading...</div>
                        </div>
                    </div>

                    <!-- RIGHT COLUMN: Line Items -->
                    <div class="col-md-8 p-0" style="max-height: 600px; overflow-y: auto; background: #fff;">
                        <div class="p-2 border-bottom bg-white font-weight-bold text-muted d-flex justify-content-between align-items-center">
                            <span><i class="icon-list mr-1"></i> Line Items <span id="mat_req_selected_id" class="text-primary ml-1"></span></span>
                            <span id="mat_req_items_count" class="badge badge-light text-dark"></span>
                        </div>
                        <div id="mat_req_items_container" class="p-3">
                            <div class="text-center text-muted py-5 mt-5">
                                <i class="icon-arrow-left16 icon-2x mb-3 text-light"></i><br>
                                <h5>Select a request from the list</h5>
                                <span>Click on any material request on the left to view its line items here.</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer bg-light border-top-0">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"><i class="icon-cross2 mr-1"></i>Close</button>
            </div>
        </div>
    </div>
</div>

<style>
    /* ── Master List (Left Column) ── */
    .mat-req-list-item {
        padding: 12px 15px;
        border-bottom: 1px solid #e9ecef;
        cursor: pointer;
        transition: all 0.2s;
        background: #fff;
    }
    .mat-req-list-item:hover {
        background: #f8f9fa;
    }
    .mat-req-list-item.active {
        background: #eef4ff;
        border-left: 4px solid #4a90e2;
    }
    .mat-req-list-item .req-title {
        font-weight: 600;
        color: #333;
        font-size: 13px;
        margin-bottom: 4px;
    }
    .mat-req-list-item .req-date {
        font-size: 11px;
        color: #888;
    }
    
    /* ── Detail View (Right Column) ── */
    .mat-req-items-table {
        width: 100%;
        border-collapse: collapse;
    }
    .mat-req-items-table thead th {
        font-size: 11px;
        font-weight: 600;
        color: #6c757d;
        padding: 8px 10px;
        border-bottom: 2px solid #dee2e6;
        background-color: #fcfcfc;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .mat-req-items-table tbody tr {
        transition: background 0.15s;
    }
    .mat-req-items-table tbody tr:nth-child(even) {
        background-color: #fdfdfd;
    }
    .mat-req-items-table tbody tr:hover {
        background-color: #f1f3f5;
    }
    .mat-req-items-table td {
        padding: 8px 10px;
        font-size: 12px;
        color: #444;
        border-bottom: 1px solid #f1f3f5;
        vertical-align: middle;
    }
    .qty-badge {
        display: inline-block;
        min-width: 28px;
        text-align: center;
        padding: 2px 6px;
        border-radius: 4px;
        font-weight: 600;
        font-size: 11px;
    }
    .qty-full   { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
    .qty-partial { background: #cce5ff; color: #004085; border: 1px solid #b8daff; }
    .qty-none   { background: #f8f9fa; color: #6c757d; border: 1px solid #dee2e6; }
</style>
