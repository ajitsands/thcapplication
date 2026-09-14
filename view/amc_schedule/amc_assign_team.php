<style>
    .password_disable { pointer-events: none; opacity: 0.4; }
    input[type='file'] { width: 95px; }
</style>

<div class="card">
    <div class="card-body" style="overflow:auto;">
        
        <h6 class="font-weight-semibold text-primary mb-1 mt-1"><i class="icon-list2 mr-2"></i>1. List of Scheduled Visits</h6>
        <div class="table-responsive mb-4">
            <table class="table datatable-selection-single" id="list_of_amc_schedules">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>WO.Ref.No.</th>
                        <th>Date</th>
                        <th>Slot</th>
                        <th>Asset Code</th>
                        <th>Category</th>
                        <th>Type</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>

        <h6 class="font-weight-semibold text-primary mb-2 mt-2"><i class="icon-wrench3 mr-2"></i>2. Configure Assignment</h6>
        <div class="p-3 bg-light border rounded mb-4">
            <div class="row">
                <div class="col-md-3 mb-3" id="div_from_date">
                    <label class="font-weight-semibold text-muted mb-1">Visit Date</label>
                    <input class="form-control form-control-sm" type="date" name="date" id="txt_visit_date_asg" value="<?php date_default_timezone_set('Asia/Bahrain'); echo date("Y-m-d"); ?>">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="font-weight-semibold text-muted mb-1">Select Slots</label>
                    <select class="form-control form-control-sm select-search" id="select_slots_asg" name="select_slots_asg">
                        <optgroup label="Slots">
                            <option value="1" selected>Slot 1</option><option value="2">Slot 2</option><option value="3">Slot 3</option><option value="4">Slot 4</option><option value="5">Slot 5</option><option value="6">Slot 6</option><option value="7">Slot 7</option><option value="8">Slot 8</option><option value="9">Slot 9</option><option value="10">Slot 10</option><option value="11">Slot 11</option><option value="12">Slot 12</option><option value="13">Slot 13</option><option value="14">Slot 14</option><option value="15">Slot 15</option><option value="16">Slot 16</option><option value="17">Slot 17</option><option value="18">Slot 18</option><option value="19">Slot 19</option><option value="20">Slot 20</option><option value="21">Slot 21</option><option value="22">Slot 22</option><option value="23">Slot 23</option><option value="24">Slot 24</option>
                        </optgroup>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="font-weight-semibold text-muted mb-1">Additional Slots</label>
                    <select class="form-control form-control-sm select-search" name="duration_asg" id="duration_asg"><option value="0" selected>0</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option></select>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="font-weight-semibold text-muted mb-1">Technician Type</label>
                    <select class="form-control form-control-sm select-search" id="select_tech_type_asg" name="select_tech_type_asg">
                        <optgroup label="Type">
                            <option value="1" selected>Floating</option><option value="2">Resident/Stationed</option>
                        </optgroup>
                    </select>
                </div>
            </div>
        </div>

        <h6 class="font-weight-semibold text-primary mb-2"><i class="icon-users4 mr-2"></i>3. Select Available Technicians</h6>
        <div class="row">  
            <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                <div class="border rounded p-2 bg-white h-100">
                    <h6 class="font-weight-semibold text-muted mb-2">Available Technicians</h6>
                    <div class="table-responsive">
                        <table class="table datatable-selection-single" id="list_of_techs_avail_agn">
                            <thead class="bg-light">
                                <tr>
                                    <th>#</th>
                                    <th>Technician</th>
                                    <th>Leader</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row mt-2"> 
            <div class="col-12 text-right">
                <button type="button" class="btn btn-primary btn-sm" id="btn_amc_assign">
                    <i class="icon-checkmark4 mr-2"></i>Assign Technician
                </button>		
            </div>
        </div>
        
    </div>
</div>
<script>
$(document).ready(function() {
    $('.select-search').select2({
        minimumResultsForSearch: 0
    });
});
</script>