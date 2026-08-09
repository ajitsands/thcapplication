<?PHP
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if($_SESSION["loggedin"] ==true)
	{
include('template/includes/en_de_header.inc');
$OBJ = new URLEncription();
$OBJ->URLEncode('head=dashboard');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	
		<title>THC-FMS</title>

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="global_assets/css/icons/icomoon/styles.min.css" rel="stylesheet" type="text/css">
	
	<link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
     
    
	<link href="assets/css/bootstrap_limitless.min.css" rel="stylesheet" type="text/css">
	<link href="assets/css/layout.min.css" rel="stylesheet" type="text/css">
	<link href="assets/css/components.min.css" rel="stylesheet" type="text/css">
	<!-- Permission CSS-->
	
	<link href="permission/css/datagrid.css" rel="stylesheet" type="text/css">
	<link href="permission/css/dropdown.css" rel="stylesheet" type="text/css">
	
	<link href="assets/css/colors.min.css" rel="stylesheet" type="text/css">
	
	<!-- /global stylesheets -->

	<!-- Core JS files-->
	<script src="global_assets/js/main/jquery.min.js"></script> 
	<script src="global_assets/js/main/bootstrap.bundle.min.js"></script>
	<script src="global_assets/js/plugins/loaders/blockui.min.js"></script>
	<script src="global_assets/js/plugins/ui/ripple.min.js"></script>
	
	<!-- /core JS files -->

	<!-- Theme JS files -->
	
	<script src="global_assets/js/plugins/ui/prism.min.js"></script>
	<script src="assets/js/app.js"></script>
	
	<!-- /theme JS files -->
	
	
	<script src="global_assets/js/demo_pages/form_checkboxes_radios.js"></script>
	<script src="global_assets/js/demo_pages/form_input_groups.js"></script>
	
	<?php include_once('user_permission/permission_class/class_permission.php'); ?>

	
	
	<?PHP 
		//include_once('template/head.inc');
	?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.fancytree/2.27.0/skin-win8/ui.fancytree.css">
    <link rel="stylesheet" href="../permission_tree/css/loader.css">
      <style id="INLINE_PEN_STYLESHEET_ID">
        .fancytree-container {
      outline: none;
    }

	 
	<style>
	
	span.fancytree-checkbox {
       background-image: none !important;
    }
   
	
	
	.box {
    width: 400px; /* Set the width of the div */
    height: auto; /* Set the height of the div */
    /*border: 1px solid #ccc;  Add a border */
    /*border-radius: 10px;  Add rounded corners 
    box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);  Add a shadow */
}
ul.fancytree-container {
    font-family: tahoma, arial, helvetica;
    /*font-size: 11pt;*/
    white-space: nowrap;
    padding: 3px;
    margin: 0;
    background-color: white;
    border: 0px dotted gray;
    min-height: 0%;
    position: relative;
    background-color: #eeeded;
}



/* For webkit-based browsers */
.container_menu::-webkit-scrollbar {
    width: 5px; /* Set the width of the scrollbar */
}

/* Track */
.container_menu::-webkit-scrollbar-track {
    background: #f1f1f1; /* Color of the scrollbar track */
}

/* Handle */
.container_menu::-webkit-scrollbar-thumb {
    background: #888; /* Color of the scrollbar handle */
}

/* Handle on hover */
.container_menu::-webkit-scrollbar-thumb:hover {
    background: #555; /* Color of the scrollbar handle on hover */
}


.fancytree-ext-childcounter span.fancytree-childcounter, .fancytree-ext-filter span.fancytree-childcounter {
    color: #fff;
    background: #777;
    border: 1px solid gray;
    position: absolute;
    top: -6px;
    right: -6px;
    min-width: 22px;
    height: 22px;
    line-height: 1;
    vertical-align: baseline;
    border-radius: 10px;
    padding: 2px;
    text-align: center;
    font-size: 12px;
}

    span.fancytree-empty, span.fancytree-vline, span.fancytree-expander, span.fancytree-icon, span.fancytree-checkbox, span.fancytree-drag-helper-img, #fancytree-drop-marker {
    width: 16px;
    height: 16px;
    display: inline-block;
    vertical-align: top;
    background-repeat: no-repeat;
    background-position: left;
    background-image: url(../skin-win8/icons.gif);
    background-position: 0px 0px;
}

.fancytree-checkbox {
    width: 1.25rem;
    height: 1.25rem;
    border: 0.025rem solid #455a64;
    display: inline-block;
    text-align: center;
    position: relative;
    cursor: pointer;
    border-radius: 0.125rem;
}

.fancytree-plain.fancytree-container.fancytree-treefocus span.fancytree-active span.fancytree-title,
.fancytree-plain.fancytree-container.fancytree-treefocus span.fancytree-selected span.fancytree-title {
  background-color: #E8E8E8;
  border-color: #B6B6B6;
  color: #3F3F3F;
}

.btn{
    padding: 0.2rem 1rem;
    border-radius : 0.7rem;
    font-size: 0.6rem;
}

.fancytree-partsel .fancytree-checkbox:after, .fancytree-radio .fancytree-selected .fancytree-checkbox:after {
    content: "";
    top: 2px;
    left: 2px;
    border: 0.3125rem solid;
    border-color: inherit;
    width: 0;
    height: 0;
}


$("#selected_user").css("overflow-y", "auto");



	    	td.details-control {
            background: url('../httpdocs/images/plus.png') no-repeat center center;
            cursor: pointer;
        }
        tr.shown td.details-control {
            background: url('../httpdocs/images/minus.png') no-repeat center center;
        }
        
        
        
        
        .loadingWrapper {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: none; /* Initially hidden */
            justify-content: center;
            align-items: center;
            z-index:999;
        }

        .loadingBackdrop {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent black */
        }

        .loadingIndicator {
			position: absolute; /* Position relative to its parent (.loadingWrapper) */
			top: 50%; /* Position at vertical center */
			left: 50%; /* Position at horizontal center */
			transform: translate(-50%, -50%); /* Center the indicator */
			width: 50px;
			height: 50px;
			border: 4px solid #fff; /* Light gray border */
			border-top: 4px solid #3498db; /* Blue border for animation */
			border-radius: 50%;
			animation: spin 2s linear infinite; /* Apply rotation animation */
		}


        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        #btn_selectall_submodules {
            border-radius: 20px; /* Adjust the value as needed */
            padding: 5px 10px; /* Adjust the padding as needed */
            font-size: 12px; /* Adjust the font size as needed */
        }
        
       
        
	</style>

	<script src="global_assets/js/plugins/forms/selects/select2.min.js"></script>
	<script src="global_assets/js/plugins/forms/styling/uniform.min.js"></script>
	<script src="global_assets/js/demo_pages/form_layouts.js"></script>
	<!-- Data Table -->
	<script src="global_assets/js/plugins/tables/datatables/datatables.min.js"></script>
	
	<script src="global_assets/js/plugins/forms/selects/select2.min.js"></script>

    <script src="global_assets/js/plugins/uploaders/dropzone.min.js"></script>
	<!--<script src="global_assets/js/demo_pages/datatables_api.js"></script>-->
	

	
	
	<!-- Ladda -->
	<script src="assets/js/ladda/spin.min.js" type="text/javascript"></script>
	<script src="assets/js/ladda/ladda.min.js" type="text/javascript"></script>
	<script src="assets/js/ladda/ladda.jquery.min.js" type="text/javascript"></script>
	<!-- sweet alert -->
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
	<!--<script src="global_assets/js/moment.min.js"></script>-->
   	<script src="global_assets/js/fileupload_ns.js"></script>
    <script src="../httpdocs/user_js/login.js"></script>
	<link href="assets/css/thc_topnav.css" rel="stylesheet" type="text/css">
</head>
    <?PHP 
		include_once('template/date_time.inc');
	?>
<body class="navbar-top">
<div class="loadingWrapper" id="loadingWrapper">
    <div class="loadingIndicator"></div>
    <div class="loadingBackdrop"></div>
    
</div>
	


	


			<!-- ===== THC Horizontal Top Navigation ===== -->
	<?PHP include_once('template/top_menu_new.inc'); ?>
	<!-- ===== /THC Horizontal Top Navigation ===== -->

	<!-- Main content -->
	<div class="content-wrapper" style="margin-left:0;padding:20px 24px 0;">

			<!-- Page header -->
			<?PHP 
				//include_once('template/header_bellow_title.inc');
			?>
			
			<!-- /page header -->


			<!-- Content area -->
			<div class="content pt-0">

				<!-- Large navbar -->
				
				<?PHP 
					//include_once('user_permission/roll_and_permissions.php');
					include_once('../permission_tree/index.php');
				?>
				
				
				<!-- /large navbar -->


			</div>
			<!-- /content area -->
            <?PHP 
				include_once('template/reset_password_modal.php');
			?>

			<!-- Footer -->
			
			<?PHP 
					include_once('template/footer.inc');
			?>
			<!-- /footer -->

		</div>
		<!-- /main content -->

	

</body>

<script src="//code.jquery.com/ui/1.13.0/jquery-ui.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="../permission_tree/js/jquery.fancytree.js"></script>
<script src="../permission_tree/js/jquery.fancytree-all-deps.js"></script>
<script src="../permission_tree/js/jquery.fancytree.wide.js"></script>
<script src="user_permission/js/messagedropdown.js"></script>
<script>


var dataValueOfRole,dataSelectedUser;

	function logEvent(event, data, msg){
//        var args = Array.isArray(args) ? args.join(", ") :
		msg = msg ? ": " + msg : "";
		$.ui.fancytree.info("Event('" + event.type + "', node=" + data.node + ")" + msg);
	}
	


var treeInitialized = false; 	
displayRoleTree('../permission_tree/generate_main_module_json.php');





function displayRoleTree(fileName)
{
 $('#loadingWrapper').show(); 
    if (treeInitialized) {
        // If the tree has already been initialized, reload it with new data
        $("#tree").fancytree("getTree").reload({ url: fileName });
    } else {
        
        
                $("#tree").fancytree({
                  checkbox: true,
                  keyboard: true,
                  icon: false,
                  selectMode: 3,
                  source: {
                    url:
                      ""+fileName
                  },
                	
                	  extensions: ["childcounter"],
                	  activate: function(event, data) {
                		//$("#statusLine").text(event.type + ": " + data.node);
                	  },
                	  select: function(event, data) {
                	        
                	  },
                // 	  click: function(event, data) {
                // 	      console.log("master clicked");
                //         logEvent(event, data, ",master targetType=" + data.targetType);
                //       },
                	  loadChildren: function(event, data) {
                			// update node and parent counters after lazy loading
                			data.node.updateCounters();
                	  },
                			init: function(event, data, flag) {
                				logEvent(event, data, "flag=" + flag);
                				$('#loadingWrapper').hide();  
                			},
                			
                			click: function(event, data) {
                				logEvent(event, data, ", targetType=" + data.targetType);
                				// return false to prevent default behavior (i.e. activation, ...)
                				//return false;
                			},
                			
                			dblclick: function(event, data) {
                				logEvent(event, data);
                //				data.node.toggleSelect();
                			},
                			
                			select: function(event, data) {
                				logEvent(event, data, "current state=" + data.node.isSelected());
                				console.log('Select Event');
                        		var selectedNode = data.node;
                                var getParent = selectedNode.getParent();
                                
                                
                                 
                                 
                                  parentNodeID = selectedNode.data.newids;
                                  parentNodeTitle = selectedNode.title;
                                  console.log('Get Parent : '+parentNodeTitle+'----'+parentNodeID);
                                  
                                    var main_string = parentNodeTitle.split('-')[0];
                                    var formatted_string = main_string.replace('&', 'And').replace(/\s+/g, '');
                                    formatted_string +='Module';
                                    console.log(formatted_string);
                                  
                                  if(dataValueOfRole===undefined)
                                  {
                                      swal("Select User Type","Please select a user type","warning");
                                      return false;
                                  }
                                  
                        
                                //getParent.title
                                if( !data.node.isFolder() ){
                                    updateParentTitle(selectedNode.getParent(),parentNodeTitle,parentNodeID);
                                }
                				
                				
                			},
                			
                }).on("fancytreeactivate", function(event, data){
                				// alternative way to bind to 'activate' event
                	//		    logEvent(event, data);
                			}).on("mouseenter mouseleave", ".fancytree-title", function(event){
                				// Add a hover handler to all node titles (using event delegation)
                				//var node = $.ui.fancytree.getNode(event);
                				//node.info(event.type);
                			});
        treeInitialized = true;
    }//close of Else 
}



function updateParentTitle(parentNode,parentTitleFromSelect,parentIdFromSelect) {
    
    var node = $.ui.fancytree.getNode(event);
    
    if (parentNode) {
        var selectedCount = 0;
        var nonSelectedCount = 0;
        var totalCount = 0;

        // Iterate over the children of the parent node
        parentNode.visit(function(childNode) {
            if (childNode.isSelected()) {
                selectedCount++;
            } else {
                nonSelectedCount++;
            }
            totalCount++;
        });

        // Extract the existing title without the appended information
        var existingTitle = parentNode.title;
        var titleParts = existingTitle.split(' - ');
        var parentTitle = titleParts[0];

        // Construct the new title with updated counts
        var newTitle = parentTitle + " - " + selectedCount + "/" + (totalCount - selectedCount) +  "/" + totalCount;
        
        parentNode.setTitle(newTitle);
        //parentTitleFromSelect,parentIdFromSelect
            // Split the string at the hyphen and take the first part
            var main_string = parentTitleFromSelect.split('-')[0];
            
            // Replace '&' with 'And' and remove white spaces
            var formatted_string = main_string.replace('&', 'And').replace(/\s+/g, '');
            formatted_string +='Module';
            console.log(formatted_string); // Output the result to console
 
        
        // Update the parent node's title
        
    }
}



// Sample button
// Define a function to get all checked child nodes with parent id and additional data
function getAllCheckedChildNodesWithParentIdAndData() {
    var tree = $("#tree").fancytree("getTree");
    var checkedChildNodes = [];
	var selectedCount =0;
	
	var parentNode ='';
    var parentNodeID = 0; // Get the parent node's title
    var parentNodeTitle = ''; // Get the parent node's title
    
    var subModuleIDs = 0;
    var subModuleName ='';// Get the quantity
	
	
    tree.visit(function(node) {
        // Check if the node is checked and is a child node
        if (node.isSelected() && !node.isTopLevel()) {
             parentNode = node.getParent();
             parentNodeID = parentNode.data.newids; // Get the parent node's title
             parentNodeTitle = parentNode.title; // Get the parent node's title
            
             subModuleIDs = node.data.subModuleID;
             subModuleName = node.title;// Get the quantity value
            //var price = node.data.price; // Get the price value
            console.log('Parent Node Title : '+parentNodeTitle);
            checkedChildNodes.push({
				rollID : dataValueOfRole, // Value from Drop down of Roles
                moduleId: parentNodeID, // Add parent title
                subModuleID: subModuleIDs,
                subModuleName: subModuleName,
                parentTitle : parentNodeTitle
            });
			selectedCount = selectedCount+1;
        }
        if(node.isTopLevel())
        {
            var main_string = parentNodeTitle.split('-')[0];
            
            // Replace '&' with 'And' and remove white spaces
            var formatted_string = main_string.replace('&', 'And').replace(/\s+/g, '');
            formatted_string +='Module';
            console.log(formatted_string);
            if(formatted_string!='Module')
            {
                if (!isDuplicate(checkedChildNodes, dataValueOfRole, parseInt(parentNodeID + 1000))) {
                    checkedChildNodes.push({
                        rollID: dataValueOfRole, // Value from Drop down of Roles
                        moduleId: parentNodeID, // Add parent title
                        subModuleID: parseInt(parentNodeID + 1000),
                        subModuleName: formatted_string,
                        parentTitle: 'Yes'
                    });
                } 
    
            }
        }
    });
	console.log(selectedCount);
    return checkedChildNodes;
}

function isDuplicate(checkedChildNodes, dataValueOfRole, parentNodeID) {
    return checkedChildNodes.some(node => 
        node.rollID === dataValueOfRole && 
        node.subModuleID === parentNodeID
    );
}

// Example usage:
$("#button").click(function() {
    if(dataValueOfRole==null)
    {
        setupDropdown('dropdownContent','error','Please select a Role !','click');
        $('#loadingWrapper').hide();
        return false; 
    }
    $('#loadingWrapper').show();
     var checkedChildNodes = getAllCheckedChildNodesWithParentIdAndData();
    // if(checkedChildNodes.length ===0 )
    // {
    //     //alert('Please Check any one of Module !');
    //     setupDropdown('dropdownContent','error','Please Check any one of Module !','click');
    //     $('#loadingWrapper').hide();
    //     return false;
    // }
    // Print the parent id, child id, qty, and price of all checked child nodes
    console.log("Checked child nodes with parent ids and data:", JSON.stringify(checkedChildNodes));
    // $.post('../permission_tree/insert_role_permission.php',{permission_data: JSON.stringify(checkedChildNodes),mainRoleID:dataValueOfRole},function(res){
    //     //alert(res);
    //     setupDropdown('dropdownContent','success',res,'click');
    //     $('#loadingWrapper').hide();
    // });
   
    var postData = {
      permission_data: JSON.stringify(checkedChildNodes),
      mainRoleID: dataValueOfRole
    };

    sandsAjaxPost('../permission_tree/insert_role_permission.php', postData, function(res) {
      // Success callback
      setupDropdown('dropdownContent', 'success', res, 'click');
      $('#loadingWrapper').hide();
    }, function(jqXHR, textStatus, errorThrown) {
      // Error callback
      if (errorThrown === 'net::ERR_HTTP2_PROTOCOL_ERROR') {
        // Handle HTTP/2 protocol error
        console.log('HTTP/2 protocol error occurred');
         setupDropdown('dropdownContent', 'error', 'Network error, please try again..!', 'click');
        // You can attempt to retry the request here or display an appropriate message to the user
      } else {
        // Handle other errors
        console.error('Error:', textStatus, errorThrown);
         setupDropdown('dropdownContent', 'error', res, 'click');
      }
      $('#loadingWrapper').hide(); // Hide loading indicator in case of error
    });
    
    
    
});


function sandsAjaxPost(url, postData, successCallback, errorCallback) {
  $.ajax({
    url: url,
    type: 'POST',
    data: postData,
    success: function(response) {
      if (typeof successCallback === 'function') {
        successCallback(response);
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      if (typeof errorCallback === 'function') {
        errorCallback(jqXHR, textStatus, errorThrown);
      }
    }
  });
}

 $("#btnDeselectAll").click(function(){
      $.ui.fancytree.getTree("#tree").selectAll(false);
      return false;
});
$("#btnSelectAll").click(function(){
  $.ui.fancytree.getTree("#tree").selectAll();
  return false;
});


$('.role_dropdown').click(function(e){
    dataValueOfRole = $(this).attr('data');
    var textval = $(this).html();
    $('#selected_item').html(textval+' | '+dataValueOfRole);
    displayRoleTree('../permission_tree/generate_user_privilages.php?roleID='+dataValueOfRole);
    
});
var permissionLoad=0;
var userAlreadyExists = false;
$('.user_dropdown').click(function(e){
  $('#loadingWrapper').show();
    dataSelectedUser = $(this).attr('data-user');
    var textval = $(this).html();
    
    $("#selected_user [data_selected_users]").each(function() {
    if ($(this).attr('data_selected_users') === dataSelectedUser) {
        userAlreadyExists = true;
        return false; // exit the loop early if a match is found
    }
    });
    if (!userAlreadyExists) {
        // Your original append code goes here
        $("#selected_user").append("<div data_selected_users='" + dataSelectedUser + "' style='background-color: #4A91D5; border-radius: 5px; color: white; font-size: 12px; padding: 5px; padding-left: 10px; margin-bottom: 5px;margin-left:5px; display: inline-block;' data-selected-user='" + dataSelectedUser + "'>" + textval + "&nbsp;&nbsp;<a class='user_selected_button' style='color: white; border-radius: 5px; padding: 4px; cursor: pointer;'><i class='bi bi-x-square'></i></a></div>");

    }
        $("#div_list_user_roles").empty();
     
        $.post('../permission_tree/display_user_roles.php',{userID: dataSelectedUser},function(res){
            console.log(res);
            if($.trim(res)==='')
            {
                $("#div_list_user_roles").append('<div id="nodata">No Role/Group Found..!</div>');
                $('#loadingWrapper').hide();
            }
            else
            {
                $("#div_list_user_roles").append(res);
                permissionLoad=1;
                $('#loadingWrapper').hide();
            }
                
        });
        
    userAlreadyExists = false;
    
   
});

$(".clear-all-user-items").click(function() {
      // Empty the div_list_user_roles div
      $("#selected_user").empty();
});
 

$("#div_list_user_roles").on("click", ".user_role_button", function() {
    // Remove the parent div of the clicked button
    $(this).closest('div').remove();
});

$("#selected_user").on("click", ".user_selected_button", function() {
    // Remove the parent div of the clicked button
    $(this).closest('div').remove();
});



$(".add-selected-all").click(function() {
   
          // Clear existing content in the selected_user div
      var dataSelectedUser;
      $("#selected_user").empty();
    
      // Iterate over each user dropdown item and get its data attribute
      $(".user_dropdown").each(function() {
        dataSelectedUser = $(this).data("user");
        var username = $(this).text();
    
        // Append the user details to the selected_user div
        $("#selected_user").append("<div data_selected_users='" + dataSelectedUser + "' style='background-color: #4A91D5; border-radius: 5px; color: white; font-size: 12px; padding: 5px; padding-left: 10px; margin-bottom: 5px;margin-left:5px; display: inline-block;' data-selected-user='" + dataSelectedUser + "'>" + username + "&nbsp;&nbsp;<a class='user_selected_button' style='color: white; border-radius: 5px; padding: 4px; cursor: pointer;'><i class='bi bi-x-square'></i></a></div>");
         
      });
      
      
      
});



$(".clear-all-items").click(function() {
      // Empty the div_list_user_roles div
      $("#div_list_user_roles").empty();
});
 
 var alreadyExists = false;
$('.user_role_dropdown').click(function(e){
    dataSelectedUserRole = $(this).attr('data-user-role');
    var textval = $(this).html();
    $("#nodata").remove();
    
    
    $("#div_list_user_roles [added_data_user_role]").each(function() {
    if ($(this).attr('added_data_user_role') === dataSelectedUserRole) {
        alreadyExists = true;
        return false; // exit the loop early if a match is found
    }
    });
    
    // If the value does not already exist, append the new content
    if (!alreadyExists) {
        // Your original append code goes here
        $("#div_list_user_roles").append("<div added_data_user_role='" + dataSelectedUserRole + "' style='background-color: #4A91D5; border-radius: 5px; color: white; font-size: 12px; padding: 5px; padding-left: 10px; margin-bottom: 5px;margin-left:5px; display: inline-block;' data-user-role='" + dataSelectedUserRole + "'>" + textval + "&nbsp;&nbsp;<a class='user_role_button' style='color: white; border-radius: 5px; padding: 4px; cursor: pointer;'><i class='bi bi-x-square'></i></a></div>");
        permissionLoad = 1;
        
    }
    
    var alreadyExists = false;
    
    
    
    //$("#div_list_user_roles").append("<div added_data_user_role='"+dataSelectedUserRole+"'style='background-color: #4A91D5; border-radius: 5px; color: white; font-size: 12px; padding: 5px; padding-left: 10px; margin-bottom: 5px;margin-left:5px; display: inline-block;' data-user-role='"+dataSelectedUserRole+"'>"+textval+"&nbsp;&nbsp;<a class='user_role_button' style='color: white; border-radius: 5px; padding: 4px; cursor: pointer;'><i class='bi bi-x-square'></i></a></div>");
});


 $(".list-of-items.add-all").click(function() {
      // Empty the div_list_user_roles div
      $("#div_list_user_roles").empty();

      // Iterate over each dropdown item and get its text
      $(".list-of-items:not(.add-all,.clear-all-items)").each(function() {
        var text = $(this).text();
        var userRollID = $(this).attr('data-user-role');
        // Append the HTML content to the parent div
        $("#div_list_user_roles").append("<div added_data_user_role='"+userRollID+"'style='background-color: #4A91D5; border-radius: 5px; color: white; font-size: 12px; padding: 5px; padding-left: 10px; margin-bottom: 5px;margin-left:5px; display: inline-block;' >"+text+"&nbsp;&nbsp;<a class='user_role_button' style='color: white; border-radius: 5px; padding: 4px; cursor: pointer;'><i class='bi bi-x-square'></i></a></div>");
      });
});


$(document).on("click", "#button_save_user_role", function() {
     $('#loadingWrapper').show();
    // Check if dataSelectedUser is undefined
    var itemCount = $("#selected_user > div").length;
    
    if(itemCount==0)
    {
        //alert('Please select user !');
        setupDropdown('dropdownContent','error','Please select user !','click');
        $('#loadingWrapper').hide();
        return false;
    }
    if(permissionLoad==0)
    {
        //alert('Without Group/Role you cannot save ...!');
        setupDropdown('dropdownContent','error','Without Group/Role you cannot save !','click');
        $('#loadingWrapper').hide();
        return false;
    }

    // Array to store the attribute values
    var addedDataUserRoleValues = [];
    
    
    
    // Iterate over each dynamically added div with added_data_user_role attribute
$("#selected_user [data_selected_users]").each(function() {
    var dataSelectedUser = $(this).attr('data_selected_users');
    $("#div_list_user_roles [added_data_user_role]").each(function() {
        // Retrieve the value of added_data_user_role attribute
        var addedDataUserRoleValue = $(this).attr('added_data_user_role');
        
        // Create an object with userID and roleID
        var obj = {
            userID: dataSelectedUser,
            roleID: parseInt(addedDataUserRoleValue)
        };
        
        // Push the object to the array
        addedDataUserRoleValues.push(obj);
    });
});

if(addedDataUserRoleValues.length===0)
{
    $("#selected_user [data_selected_users]").each(function() {
        var dataSelectedUser = $(this).attr('data_selected_users');
            var obj = {
                userID: dataSelectedUser,
                roleID: 0
            };
            
            // Push the object to the array
            addedDataUserRoleValues.push(obj);
        
    });
}
    // Convert the array to a JSON string
    var jsonString = JSON.stringify(addedDataUserRoleValues);

    // Output the resulting JSON string
    // console.log(jsonString);
    // $.post('../permission_tree/insert_user_roles.php',{user_role_data: jsonString},function(res){
    //      $('#loadingWrapper').hide();
    //     //alert(res);
    //     setupDropdown('dropdownContent','success',res,'click');
    // });
   
    var postData = {
      user_role_data: jsonString
    };

    sandsAjaxPost('../permission_tree/insert_user_roles.php', postData, function(res) {
      // Success callback
      setupDropdown('dropdownContent', 'success', res, 'click');
      $('#loadingWrapper').hide();
    }, function(jqXHR, textStatus, errorThrown) {
      // Error callback
      if (errorThrown === 'net::ERR_HTTP2_PROTOCOL_ERROR') {
        // Handle HTTP/2 protocol error
        console.log('HTTP/2 protocol error occurred');
         setupDropdown('dropdownContent', 'error', 'Network error, please try again..!', 'click');
        // You can attempt to retry the request here or display an appropriate message to the user
      } else {
        // Handle other errors
        console.error('Error:', textStatus, errorThrown);
         setupDropdown('dropdownContent', 'error', res, 'click');
      }
      $('#loadingWrapper').hide(); // Hide loading indicator in case of error
    });
    
    
});

 
 
</script>

</html>
<?PHP }
	
	else{
		?>
		<script>

	window.location="login.php"
</script>
<?PHP
	}
	?>