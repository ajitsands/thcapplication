<div id="dropdownContent" style="text-align: center;">
    <!-- Content of your dropdown -->
</div>

<div class="container">
    <div class="row mb-2">
        <div class="col-12" style="padding-top: 20px;">
            <?php if($_GET['value']=="developer") { ?>
            <a type="button" class="btn-sm btn-warning" data-toggle="modal" data-target="#modal_add_permissions" style="float: right;"><i class="icon-add"></i></a>
            <?php } ?>
        </div>
    </div>
    <div class="card" style="max-width:100%;">
        <div class="card-body">
            <div class="row" style="padding-top: 20px;">
                <!--<div class="col-12">
        <div class="row">
            <div class="col-6">
                <label for="" class="form-label">Enter Control / Module Name <span style="color:red">*</span></label>
                <input type="text" id="moduleOrControlName" class="form-control" id="exampleFormControlInput1" placeholder="Enter Control / Module Name">
            </div>
             <div class="col-6">
                 <label for="" class="form-label">Create a Permission</label><br>
                <button class="addNewEventstoJS">Add Actions</button>
            </div>
        </div>
    </div>-->
                <div class="col-6 fixed-height-div" >
                    <div class="row">
                        <div class="col-12">
                            <h6 class="card-title font-weight-bold text-center">LIST OF ROLES</h6>
                            <table id="tlb_listOfRolls" class="display table-hover table table-bordered" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>List of Roles/Groups</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <div class="col-12" style="padding-top: 20px;">
                            <div class="row" style="padding: 20px;">
                                <!--<label for="" class="form-label">Rolls/Groups</label>-->
                                <input type="text" class="form-control" placeholder="Rolls/Groups" id="txt_addRolesOrGroups" />
                                <p style="padding-top: 10px;" />
                                <button type="button" class="btn btn-primary" id="btn_addRolesOrGroups" style="width: 100%;">Add Roles/Groups</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 fixed-height-div" style="padding-top: 20px;">
                     <div class="row">
                        <div class="col-12">
                            <h6 class="card-title font-weight-bold text-center">AVAILABLE MODULES</h6>
                            <table id="tlb_listOfAvlModules" class="display table-hover table table-bordered" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Module Name</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                       
                    </div>
                     
                 </div>
                <div class="col-4 fixed-height-div" style="padding-top: 20px;">
                    <h6 class="card-title font-weight-bold text-center">LIST OF MODULES</h6>
                    <table id="tbl_listOfModules" class="display table table-bordered table-hover" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th></th>
                                <th>Module name</th>
                                 <th>Module View ID</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div class="col-4 fixed-height-div" style="padding-top: 20px;">
                    <h6 class="card-title font-weight-bold text-center">LIST OF CONTROLS</h6>
                    <button class="btn btn-info btn-sm rounded-pill" id="btn_selectall_submodules">Select All</button>
                    <table id="tlb_listOfControlsAndModules" class="display table table-bordered table-hover responsive" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th></th>
                                <th>Controls</th>
                                <th>Class Name</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>

                <div class="col-4 fixed-height-div" style="padding-top: 20px;">
                    <table id="tlb_addedListOfControlsAndModules" class="display table table-bordered table-hover" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Privilage for Selected Role</th>
                                <th>Class Name</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

            <div class="row" style="padding-top: 20px;">
                <div class="col-12">
                    <button type="button" class="btn btn-primary" id="btn_confim_privilages" style="float: right;">Confirm Privilages</button>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row" style="padding-top: 20px;">
                <div class="col-4 fixed-height-div" style="padding-top: 20px;">
                    <h6 class="card-title font-weight-bold text-center">LIST OF EMPLOYEES</h6>
                    <table id="tlb_listOfUsers" class="display table table-bordered table-hover" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>User Name</th>
                                <th>Employee Name</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div class="col-4 fixed-height-div" style="padding-top: 20px;">
                    <h6 class="card-title font-weight-bold text-center">LIST OF ROLES / GROUPS</h6>
                    <table id="tlb_listOfRollsForUsers" class="display table table-bordered table-hover" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>List of Roles/Groups</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div class="col-3 fixed-height-div" style="padding-top: 20px;">
                    <table id="tlb_listOfSelectedUserRolls" class="display" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>List of Available Roles/Groups</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

            <div class="row" style="padding-top: 10px; padding-bottom: 10px;">
                <div class="col-12">
                    <button type="button" class="btn btn-primary" id="btn_change_user_roll" style="float: right;">Change User Role</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- User Permission Script -->
<script type="text/javascript" src="user_permission/js/jsfunctions.js?timestamp=<?php echo time(); ?>"></script>

<!-- Large modal -->
<div id="modal_add_permissions" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Permissions</h5>
                <span id="modal_close_permissions" style="cursor: pointer;" data-bs-dismiss="modal">X</span>
            </div>

            <div class="modal-body">
                <div class="container" style="padding-top: 20px;">
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-8">
                                    <label for="" class="form-label">Enter Control / Module Name <span style="color: red;">*</span></label>
                                    <input type="text" id="moduleOrControlName" class="form-control moduleOrControlName" id="exampleFormControlInput1" placeholder="Enter Control / Module Name" />
                                </div>
                                <div class="col-4">
                                    <label></label><br />
                                    <button class="btn btn-primary addNewEventstoJS">Add</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-12" style="padding-top: 20px;">
                            <p class="text-danger text-right">Double Tap for remove a Module/Control *</p>
                            <table id="dataTable" class="display table table-bordered table-hover" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Module / Control Name</th>
                                        <th>Class</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /large modal -->
