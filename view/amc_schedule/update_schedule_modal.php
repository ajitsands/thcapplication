<div id="modal_update_schedule" class="modal fade" data-backdrop="false" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header bg-primary text-white py-2">
                <h6 class="modal-title font-weight-semibold" id="amc_no_view_head_update_visit">Update Schedule</h6>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body p-4">
                <input class="form-control" type="hidden" id="txt_amc_visit_id_hidden"> 
                <input class="form-control" type="hidden" id="txt_amc_refno_update_hidden"> 
                
                <div class="row bg-light p-3 border rounded">
                    <div class="col-md-4 mb-3" id="div_from_date">
                        <label class="font-weight-semibold text-muted mb-1">Visit Date</label>
                        <input class="form-control form-control-sm" type="date" name="date" id="txt_visit_date_update">
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label class="font-weight-semibold text-muted mb-1">Select Slots</label>
                        <select class="form-control form-control-sm select-modal" id="select_slots_updated" name="select_slots_updated">
                            <optgroup label="Slots">
                                <option value="1" selected>Slot 1</option><option value="2">Slot 2</option><option value="3">Slot 3</option><option value="4">Slot 4</option><option value="5">Slot 5</option><option value="6">Slot 6</option><option value="7">Slot 7</option><option value="8">Slot 8</option><option value="9">Slot 9</option><option value="10">Slot 10</option><option value="11">Slot 11</option><option value="12">Slot 12</option><option value="13">Slot 13</option><option value="14">Slot 14</option><option value="15">Slot 15</option><option value="16">Slot 16</option><option value="17">Slot 17</option><option value="18">Slot 18</option><option value="19">Slot 19</option><option value="20">Slot 20</option><option value="21">Slot 21</option><option value="22">Slot 22</option><option value="23">Slot 23</option><option value="24">Slot 24</option>
                            </optgroup>
                        </select>
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label class="font-weight-semibold text-muted mb-1">Additional Slots</label>
                        <select class="form-control form-control-sm select-modal" name="duration_update" id="duration_update">
                            <option value="0" selected>0</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option>
                        </select>
                    </div>
                    
                    <div class="col-md-4 mb-3" style="display:none">
                        <label class="font-weight-semibold text-muted mb-1">Start Time</label>
                        <input class="form-control form-control-sm" type="time" name="time" value="00:00" id="txt_time_update">
                    </div>
                </div>
            </div>
            
            <div class="modal-footer bg-light py-2">
                <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal" id="btn_change_schedule"><i class="icon-checkmark4 mr-2"></i>Change Schedule</button>
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    // Wait for modal to be shown before initializing select2 to ensure correct dropdownParent binding
    $('#modal_update_schedule').on('shown.bs.modal', function () {
        $('.select-modal').select2({
            dropdownParent: $('#modal_update_schedule'),
            minimumResultsForSearch: 0
        });
    });
});
</script>