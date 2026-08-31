<!-- Leave Calendar Modal -->
<div id="modal_leave_calendar" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-full">
        <div class="modal-content">
            <div class="modal-header bg-indigo-400">
                <h6 class="modal-title">Employee Leave Calendar</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <!-- Color Code Legend -->
                <div class="d-flex flex-wrap align-items-center mb-3 pb-2" style="gap: 8px; border-bottom: 1px solid #eee;">
                    <span class="font-weight-semibold text-muted mr-1" style="font-size: 12px;"><i class="icon-color-sampler mr-1"></i> Color Code:</span>
                    <span class="badge badge-pill text-white px-2 py-1" style="background-color: #ef5350; font-size: 11px; font-weight: 500;"><i class="icon-primitive-dot mr-1"></i> Sick Leave</span>
                    <span class="badge badge-pill text-white px-2 py-1" style="background-color: #42a5f5; font-size: 11px; font-weight: 500;"><i class="icon-primitive-dot mr-1"></i> Casual Leave</span>
                    <span class="badge badge-pill text-white px-2 py-1" style="background-color: #66bb6a; font-size: 11px; font-weight: 500;"><i class="icon-primitive-dot mr-1"></i> Annual Leave</span>
                    <span class="badge badge-pill text-white px-2 py-1" style="background-color: #ffa726; font-size: 11px; font-weight: 500;"><i class="icon-primitive-dot mr-1"></i> Emergency Leave</span>
                    <span class="badge badge-pill text-white px-2 py-1" style="background-color: #ab47bc; font-size: 11px; font-weight: 500;"><i class="icon-primitive-dot mr-1"></i> Privilege Leave</span>
                </div>
                <div id="leave_calendar_view"></div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- /Leave Calendar Modal -->
