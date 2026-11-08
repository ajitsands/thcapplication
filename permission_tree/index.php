
  
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

<div class="card">
    <div class="card-header bg-white header-elements-inline">
        <h6 class="card-title font-weight-bold"><i class="icon-key mr-2"></i> Role Management</h6>
        <div class="header-elements">
            <?php if(isset($_GET['value']) && $_GET['value']=="developer") { ?>
            <a type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal_add_permissions"><i class="icon-add mr-1"></i> Add Permissions</a>
            <?php } ?>
        </div>
    </div>
    
    <div class="card-body">
        <div class="row">
            <div class="col-md-6 border-right">
                <div class="mb-3 d-flex align-items-center">
                  <div class="dropdown mr-2">
                      <button class="btn bg-teal-400 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Select User Type
                      </button>
                      <ul class="dropdown-menu container_menu" style="height:300px;overflow-y: scroll;">
                        <li class="px-2 pb-2"><input type="text" class="form-control form-control-sm dropdown-search" placeholder="Search..."></li>
                         <?php while ($row = $result->fetch_assoc()) { ?>
                        <li><a class="dropdown-item role_dropdown" href="#" data="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></a></li>
                        <?php } ?>
                      </ul>
                  </div>
                  
                  <button id="btn_popup_new_role" class="btn btn-primary rounded-button" type="button">
                    <i class="bi bi-plus mr-1"></i> Add New User Type
                  </button>
                </div>
                
                <div id="selected_item" class="mb-2 font-weight-semibold text-primary"></div>
                
                <div class="mb-2">
                    <button type="button" id="btnSelectAll" class="btn btn-danger btn-sm">
                      <i class="bi bi-check2-all mr-1"></i> Select All
                    </button>
                    <button type="button" id="btnDeselectAll" class="btn btn-warning btn-sm">
                      <i class="bi bi-x mr-1"></i> Deselect All
                    </button>
                </div>
                
                <span class="text-muted d-block mb-2" style="font-size:12px;">Selected / Non Selected / Total</span>
                <div id="tree" class="box border rounded p-2" style="width: 100%; min-height: 400px; overflow-y: auto;"></div>
                
                <div class="mt-3">
                    <button type="button" id="button" class="btn btn-success">
                      <i class="bi bi-floppy mr-1"></i> Assign Modules to Role
                    </button>
                </div>
                <div id="statusLine"></div>
            </div>
            
            <div class="col-md-6 pl-md-4">
                <div class="dropdown mb-3">
                  <button class="btn bg-teal-400 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Select Users
                  </button>
                  <ul class="dropdown-menu container_menu" style="height:300px;overflow-y: scroll;min-width:320px;">
                    <li class="px-2 pb-2"><input type="text" class="form-control form-control-sm dropdown-search" placeholder="Search..."></li>
                     <li><a class="dropdown-item clear-all-user-items clear-user-all" href="#">Clear All </a></li>
                     <li><hr class="dropdown-divider"></li>
                     <?php
                     // SQL query to join users with tbl_employees to get employee name
                     $sql = "SELECT users.id, users.username, tbl_employees.employee_name 
                             FROM users 
                             LEFT JOIN tbl_employees ON (LOWER(TRIM(tbl_employees.employee_code)) = LOWER(TRIM(users.username))) 
                             ORDER BY users.username ASC";
                     // Execute the query
                     $result = $permmison_conn->query($sql);

                     while ($row = $result->fetch_assoc()) { 
                         $displayName = $row['username'];
                         if (!empty($row['employee_name']) && $row['employee_name'] !== 'NA') {
                             $displayName .= ' - ' . $row['employee_name'];
                         }
                     ?>
                    <li><a class="dropdown-item user_dropdown" href="#" data-user="<?php echo $row['id']; ?>"><?php echo htmlspecialchars($displayName); ?></a></li>
                    <?php }
                     ?>
                     <li><hr class="dropdown-divider"></li>
                     <li><a class="dropdown-item list-selected-user-items add-selected-all" href="#">Add All </a></li>
                  </ul>
                </div>
                
                <div id="selected_user" class="container_menu border rounded bg-light" style="padding:10px;margin-bottom:20px;border-color:#ddd;height:120px;overflow-y: scroll;"></div>
                     
                <div class="dropdown mb-3">
                  <button class="btn bg-teal-400 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Select User Types
                  </button>
                  <ul class="dropdown-menu container_menu" style="height:300px;overflow-y: scroll;">
                    <li class="px-2 pb-2"><input type="text" class="form-control form-control-sm dropdown-search" placeholder="Search..."></li>
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
                        
                <span class="text-muted d-block mb-2 font-weight-semibold" style="font-size:12px;">Select Roles to add to the Selected User</span>
                <div id="div_list_user_roles" class="container_menu border rounded bg-light" style="padding:10px;margin-bottom:20px;border-color:#ddd;height:120px;overflow-y: auto;"></div>
                
                <button type="button" id="button_save_user_role" class="btn btn-success">
                  <i class="bi bi-floppy mr-1"></i> Save User Roles
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Dropdown search functionality
        $('.dropdown-search').on('keyup', function() {
            var value = $(this).val().toLowerCase();
            // Get the parent ul
            var dropdownMenu = $(this).closest('.dropdown-menu');
            // Filter all li elements except the first one (which contains the search box itself) and dividers
            dropdownMenu.find('li:not(:first-child):not(:has(hr))').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
        });
        
        // Prevent dropdown from closing when clicking inside the search box
        $('.dropdown-menu').on('click', function(e) {
            if ($(e.target).hasClass('dropdown-search')) {
                e.stopPropagation();
            }
        });
    });
</script>


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

