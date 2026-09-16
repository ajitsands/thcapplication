
  
  <?php
  include_once(__DIR__ . '/../model/db_connection/connection.php');
  $DBConn = new DBConnection();
  $permmison_conn = $DBConn->ConnectToMYSQL();

  // Check connection
  if (!$permmison_conn || $permmison_conn->connect_error) {
      die("Connection failed: " . ($permmison_conn ? $permmison_conn->connect_error : mysqli_connect_error()));
  }

  // Your SQL query
  $sql = "select * from  roles order by name asc";

  // Execute the query
  $result = $permmison_conn->query($sql);
  ?>
<div id="dropdownContent" style="text-align: center;">
    <!-- Content of your dropdown -->
</div>

<div class="loadingWrapper" id="loadingWrapper">
    <div class="loadingIndicator"></div>
    <div class="loadingBackdrop"></div>
</div>

<div id="popupWindow" class="popupWindow" style="display: none; z-index: 999;">
  <div class="speechBubble">
    <button class="closeButton" id="closeButton">X</button>
    <div class="speechIcon"></div>
    <div class="textbox-container">
      <input
        type="text"
        class="sandsTextBox"
        id="txt_newusertype"
        placeholder="User type..."
      />
      <button id="myButtons" class="sandsButton">Save</button>
    </div>
  </div>
</div>

<div class="container" style="padding-top:20px;">
    <div class="row mb-2">
        <div class="col-12" style="padding-top: 20px;">
            <?php if(isset($_GET['value']) && $_GET['value']=="developer") { ?>
            <a type="button" class="btn-sm btn-warning" data-toggle="modal" data-target="#modal_add_permissions" style="float: right;"><i class="icon-add"></i></a>
            <?php } ?>
        </div>
    </div>
    <div class="row">
        <div class="col-5">
            <div class="" style="padding-bottom:10px;">
              <button class="btn btn-secondary btn-sm dropdown-toggle" style="--bs-btn-padding-y: .15rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .80rem;" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                Select User Type
              </button>
              <ul class="dropdown-menu container_menu" style="height:300px;overflow-y: scroll;">
                 <?php while ($row = $result->fetch_assoc()) { ?>
                <li><a class="dropdown-item role_dropdown" href="#" data="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></a></li>
                <?php } ?>
                 <!--<li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item add_new_role" href="#" data="0">Add New Role</a></li>-->
              </ul>
              
              <button  id="btn_popup_new_role"  class="btn btn-primary rounded-button" type="button" style="--bs-btn-padding-y: .15rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .80rem;">
                <i class="bi bi-plus"></i>Add New User Type
              </button>
            </div>
            
              <div id="selected_item" style="padding-bottom:10px;"></div>
                <p>
                
                <button type="button" id="btnSelectAll" class="btn btn-danger"
                        style="--bs-btn-padding-y: .15rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .80rem;">
                  <i class="bi bi-check2-all"></i> Select All
                </button>
                <button type="button" id="btnDeselectAll" class="btn btn-warning"
                        style="--bs-btn-padding-y: .15rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .80rem;">
                  <i class="bi bi-x"></i> Deselect All
                </button>
                
                
                </p>
                <span style="font-size:12px; pading-left: 10px;">Selected/Non Selected/Total</span>
                <div id="tree" class="box"></div>
                <div style="padding-top:20px;">
                    <button type="button" id="button" class="btn btn-success"
                        style="--bs-btn-padding-y: .15rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .80rem;">
                  <i class="bi bi-floppy"></i> Assign Modules to Role
                </button>
                    
                </div>
                <div id="statusLine"></div>
            </div>
            <div class="col-5">
                <div class="btn-group" style="padding-bottom:10px;">
                  <button class="btn btn-secondary btn-sm dropdown-toggle" style="--bs-btn-padding-y: .15rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .80rem;" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Select Users
                  </button>
                  <ul class="dropdown-menu container_menu" style="height:300px;overflow-y: scroll;">
                     <li><a class="dropdown-item clear-all-user-items clear-user-all" href="#">Clear All </a></li>
                     <li><hr class="dropdown-divider"></li>
                     <?php
                     // Your SQL query
                     $sql = "select * from  users order by username asc";
                     // Execute the query
                     $result = $permmison_conn->query($sql);

                     while ($row = $result->fetch_assoc()) { ?>
                    <li><a class="dropdown-item user_dropdown" href="#" data-user="<?php echo $row['id']; ?>"><?php echo $row['username']; ?></a></li>
                    <?php }
                     ?>
                     <li><hr class="dropdown-divider"></li>
                     <li><a class="dropdown-item list-selected-user-items add-selected-all" href="#">Add All </a></li>
                  </ul>
                </div>
                <!--<div id="selected_user" style="padding-bottom:10px;"></div>-->
                <div id="selected_user" class="container_menu" style="padding:5px;margin-bottom:20px;border-width:1px;border-style:solid;border-color:#CECECE;height:100px;overflow-y: scroll;"></div>
                     
                
                <!--User Roles-->
                
                
                    <div class="btn-group" style="padding-bottom:10px;">
                      <button class="btn btn-secondary btn-sm dropdown-toggle" style="--bs-btn-padding-y: .15rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .80rem;" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Select User Types
                      </button>
                      <ul class="dropdown-menu  container_menu" style="height:300px;overflow-y: scroll;">
                       
                        <li><a class="dropdown-item clear-all-items add-all" href="#">Clear All </a></li>
                         <li><hr class="dropdown-divider"></li>
                         <?php
                         // Your SQL query
                         $sql = "select * from  roles order by name asc";
                         // Execute the query
                         $result = $permmison_conn->query($sql);

                         while ($row = $result->fetch_assoc()) { ?>
                        <li><a class="dropdown-item list-of-items user_role_dropdown" href="#" data-user-role="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></a></li>
                        <?php }
                         ?>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item list-of-items add-all" href="#">Add All</a></li>
                      </ul>
                    </div>
                        
                <!--User Roles End -->
                Select Roles to add to the Selected User
                <div id="div_list_user_roles" class="container_menu" style="padding:5px;margin-bottom:20px;border-width:1px;border-style:solid;border-color:#CECECE;"></div>
                <button type="button" id="button_save_user_role" class="btn btn-success"
                        style="--bs-btn-padding-y: .15rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .80rem;">
                  <i class="bi bi-floppy"></i> Save User Roles
                </button>
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
                <span id="ModalClosePermission" style="cursor: pointer;">X</span>
            </div>

            <div class="modal-body">
                <div class="container" style="padding-top: 20px;">
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-5">
                                    <?php 
                                      $resultRoles = $permmison_conn->query("SELECT * FROM tbl_app_modules WHERE status='Active'");
                                    ?>
                                    <label for="" class="form-label">Choose Module<span style="color: red;">*</span></label>
                                    <select class="form-control" id="selectModuleId">
                                           <option value="" selected>Select</option>
                                       <?php while ($rowRoles = $resultRoles->fetch_assoc()) { ?>
                                            <option value="<?php echo $rowRoles['ids']; ?>"><?php echo $rowRoles['module_name']; ?></option>
                                       <?php } ?>
                                    </select>    
                                </div>
                                <div class="col-5">
                                    <label for="" class="form-label">Enter Control / Module Name <span style="color: red;">*</span></label>
                                    <input type="text" id="moduleOrControlName" class="form-control moduleOrControlName" id="exampleFormControlInput1" placeholder="Enter Control / Module Name" />
                                </div>
                                <div class="col-2">
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


<?php $permmison_conn->close(); ?>

