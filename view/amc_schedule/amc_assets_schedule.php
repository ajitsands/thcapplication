<style>
    .password_disable {
		pointer-events: none;
		opacity: 0.4;
    }
    input[type='file'] {
        width: 95px;
    }
    .select2-selection--multiple {
        border: 1px solid #ccc !important;
        border-radius: 4px !important;
        min-height: 38px !important;
    }
</style>

<h6 class="font-weight-semibold text-primary mb-1 mt-1"><i class="icon-list2 mr-2"></i>1. Select AMC Assets</h6>
<div class="table-responsive mb-2">
    <table class="table datatable-selection-multiple" id="list_of_amc_assets">
        <thead>
            <tr>
                <th width="10%">SL. No.</th>
                <th width="30%">Asset Code</th>
                <th width="30%">Category</th>
                <th width="30%">Asset Type</th>	
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
<script src="global_assets/js/plugins/forms/selects/bootstrap_multiselect.js"></script>
<script>
$(document).ready(function() {
    // Re-initialize Select2 for time slots
    $('#select_slots_multiple_extended, #duration_multiple').select2({
        minimumResultsForSearch: 0
    });
    
    // Initialize bootstrap-multiselect for frequency to allow separate search box inside dropdown
    $('#select_visit_frequency').multiselect({
        enableFiltering: true,
        enableCaseInsensitiveFiltering: true,
        buttonClass: 'btn btn-light',
        buttonWidth: '100%',
        maxHeight: 300
    });
});
</script>

<h6 class="font-weight-semibold text-primary mb-2"><i class="icon-calendar3 mr-2"></i>2. Configure Schedule</h6>
<div class="p-3 bg-light border rounded mb-3">
    <div class="row form-group mb-2">
        <div class="col-lg-4 col-md-6 mb-3">
            <label class="font-weight-semibold text-muted mb-1">Frequency of Visit <small class="text-info ml-1"><i>(For Specific Date option the Start Date will consider)</i></small></label>
            <select class="form-control multiselect border" multiple="multiple" data-fouc id="select_visit_frequency" name="select_visit_frequency">
                <optgroup label="Every Day">
                    <option value="ED-All">Every Day</option>
                </optgroup>
                <optgroup label="Every Week">
                    <option value="EW-Sunday">Every Week Sunday</option>
                    <option value="EW-Monday">Every Week Monday</option>
                    <option value="EW-Tuesday">Every Week Tuesday </option>
                    <option value="EW-Wednesday">Every Week Wednesday </option>
                    <option value="EW-Thursday">Every Week Thursday </option>
                    <option value="EW-Friday">Every Week Friday </option>
                    <option value="EW-Saturday">Every Week Saturday </option>
                </optgroup>
                <optgroup label="Every Month First Week">
                    <option value="FW-Sunday">First Week Sunday</option>
                    <option value="FW-Monday">First Week Monday</option>
                    <option value="FW-Tuesday">First Week Tuesday </option>
                    <option value="FW-Wednesday">First Week Wednesday </option>
                    <option value="FW-Thursday">First Week Thursday </option>
                    <option value="FW-Friday">First Week Friday </option>
                    <option value="FW-Saturday">First Week Saturday </option>
                </optgroup>
                <optgroup label="Every Month Second Week">
                    <option value="SW-Sunday">Second Week Sunday</option>
                    <option value="SW-Monday">Second Week Monday</option>
                    <option value="SW-Tuesday">Second Week Tuesday </option>
                    <option value="SW-Wednesday">Second Week Wednesday </option>
                    <option value="SW-Thursday">Second Week Thursday </option>
                    <option value="SW-Friday">Second Week Friday </option>
                    <option value="SW-Saturday">Second Week Saturday </option>
                </optgroup>
                <optgroup label="Every Month Third Week">
                    <option value="TW-Sunday">Third Week Sunday</option>
                    <option value="TW-Monday">Third Week Monday</option>
                    <option value="TW-Tuesday">Third Week Tuesday </option>
                    <option value="TW-Wednesday">Third Week Wednesday </option>
                    <option value="TW-Thursday">Third Week Thursday </option>
                    <option value="TW-Friday">Third Week Friday </option>
                    <option value="TW-Saturday">Third Week Saturday </option>
                </optgroup>
                <optgroup label="Every Month Fourth Week">
                    <option value="FRW-Sunday">Fourth Week Sunday</option>
                    <option value="FRW-Monday">Fourth Week Monday</option>
                    <option value="FRW-Tuesday">Fourth Week Tuesday </option>
                    <option value="FRW-Wednesday">Fourth Week Wednesday </option>
                    <option value="FRW-Thursday">Fourth Week Thursday </option>
                    <option value="FRW-Friday">Fourth Week Friday </option>
                    <option value="FRW-Saturday">Fourth Week Saturday </option>
                </optgroup>
                <optgroup label="Specific Date">
                    <option value="YSD">Specific Date</option>
                </optgroup>
            </select>
        </div>
        
        <div class="col-lg-2 col-md-3 mb-3" id="div_from_date">
            <label class="font-weight-semibold text-muted mb-1">Start Date</label>
            <input class="form-control" type="hidden" name="txt_hiddem_amc_st_date" id="txt_hiddem_amc_st_date">
            <input class="form-control" type="date" name="txt_from_date" id="txt_from_date">
        </div>
        
        <div class="col-lg-2 col-md-3 mb-3" id="div_to_date">
            <label class="font-weight-semibold text-muted mb-1">End Date</label>
            <input class="form-control" type="hidden" name="txt_hiddem_amc_ed_date" id="txt_hiddem_amc_ed_date">
            <input class="form-control" type="date" name="txt_to_date" id="txt_to_date">
        </div>

        <div class="col-lg-2 col-md-3 mb-3">
            <label class="font-weight-semibold text-muted mb-1">Select Time Slots</label>
            <select class="form-control select border" id="select_slots_multiple_extended" name="select_slots_multiple_extended">
                <optgroup label="Slots">
                    <option value="1" selected>Slot 1</option><option value="2">Slot 2</option><option value="3">Slot 3</option><option value="4">Slot 4</option><option value="5">Slot 5</option><option value="6">Slot 6</option><option value="7">Slot 7</option><option value="8">Slot 8</option><option value="9">Slot 9</option><option value="10">Slot 10</option><option value="11">Slot 11</option><option value="12">Slot 12</option><option value="13">Slot 13</option><option value="14">Slot 14</option><option value="15">Slot 15</option><option value="16">Slot 16</option><option value="17">Slot 17</option><option value="18">Slot 18</option><option value="19">Slot 19</option><option value="20">Slot 20</option><option value="21">Slot 21</option><option value="22">Slot 22</option><option value="23">Slot 23</option><option value="24">Slot 24</option>
                </optgroup>
            </select>
        </div>
        
        <div class="col-lg-2 col-md-3 mb-3">
            <label class="font-weight-semibold text-muted mb-1">Additional Slots</label>
            <select class="form-control select border" name="duration_multiple" id="duration_multiple">
                <option value="0" selected>0</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option>
            </select>
        </div>

        <div class="col-lg-2 col-md-3 mb-3" style="display:none">
            <label class="font-weight-semibold text-muted mb-1">Start Time</label>
            <input class="form-control" type="time" name="time" value="00:00" id="txt_time_multiple">
        </div>
    </div>
    
    <div class="row">
        <div class="col-12 text-right">
            <button type="button" class="btn btn-primary btn-sm mt-2" id="btn_generate_schedule">
                <i class="icon-calendar3 mr-2"></i>Generate Schedule
            </button>		
        </div>
    </div>
</div>