<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.fancytree/2.27.0/skin-win8/ui.fancytree.css">
<link rel="stylesheet" href="css/loader.css">
  <style id="INLINE_PEN_STYLESHEET_ID">
    .fancytree-container {
  outline: none;
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

$("#selected_user").css("overflow-y", "auto");

  </style>
  
  <?php



// Create connection
$conn = new mysqli("localhost","sianlab_thc_user","s@nds1@b","sianlab_db_thc");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Your SQL query
$sql = "select * from  roles order by name asc";

// Execute the query
$result = $conn->query($sql);

?>

<div class="loadingWrapper" id="loadingWrapper">
    <div class="loadingIndicator"></div>
    <div class="loadingBackdrop"></div>
    
</div>
<div class="container" style="padding-top:20px;">
    <div class="row">
        <div class="col-4">
            <div class="btn-group" style="padding-bottom:10px;">
              <button class="btn btn-secondary btn-sm dropdown-toggle" style="--bs-btn-padding-y: .15rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .80rem;" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                Select Role
              </button>
              <ul class="dropdown-menu container_menu" style="height:300px;overflow-y: scroll;">
                 <?php while ($row = $result->fetch_assoc()) {?>
                <li><a class="dropdown-item role_dropdown" href="#" data="<?php echo $row['id'];?>"><?php echo $row['name'];?></a></li>
                <?php }?>
              </ul>
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
            <div class="col-4">
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
                        $result = $conn->query($sql);
                    
                     while ($row = $result->fetch_assoc()) {?>
                    <li><a class="dropdown-item user_dropdown" href="#" data-user="<?php echo $row['id'];?>"><?php echo $row['username'];?></a></li>
                    <?php }?>
                     <li><hr class="dropdown-divider"></li>
                     <li><a class="dropdown-item list-selected-user-items add-selected-all" href="#">Add All </a></li>
                  </ul>
                </div>
                <!--<div id="selected_user" style="padding-bottom:10px;"></div>-->
                <div id="selected_user" class="container_menu" style="padding:5px;margin-bottom:20px;border-width:1px;border-style:solid;border-color:#CECECE;height:100px;overflow-y: scroll;"></div>
                     
                
                <!--User Roles-->
                
                
                    <div class="btn-group" style="padding-bottom:10px;">
                      <button class="btn btn-secondary btn-sm dropdown-toggle" style="--bs-btn-padding-y: .15rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .80rem;" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Select Roles
                      </button>
                      <ul class="dropdown-menu  container_menu" style="height:300px;overflow-y: scroll;">
                       
                        <li><a class="dropdown-item clear-all-items add-all" href="#">Clear All </a></li>
                         <li><hr class="dropdown-divider"></li>
                         <?php 
                           // Your SQL query
                            $sql = "select * from  roles order by name asc";
                            // Execute the query
                            $result = $conn->query($sql);
                        
                         while ($row = $result->fetch_assoc()) {?>
                        <li><a class="dropdown-item list-of-items user_role_dropdown" href="#" data-user-role="<?php echo $row['id'];?>"><?php echo $row['name'];?></a></li>
                        <?php }?>
                         <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item list-of-items add-all" href="#">Add All </a></li>
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
<?php $conn->close();?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
<script src="//code.jquery.com/ui/1.13.0/jquery-ui.min.js"></script>
<script src="js/jquery.fancytree.js"></script>
<script src="js/jquery.fancytree-all-deps.js"></script>
<script src="js/jquery.fancytree.wide.js"></script>


<script>

var dataValueOfRole,dataSelectedUser;

	function logEvent(event, data, msg){
//        var args = Array.isArray(args) ? args.join(", ") :
		msg = msg ? ": " + msg : "";
		$.ui.fancytree.info("Event('" + event.type + "', node=" + data.node + ")" + msg);
	}
	
	
	
var treeInitialized = false; 	
displayRoleTree('generate_main_module_json.php');

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
                		$("#statusLine").text(
                		  //event.type + ": " + data.node.isSelected() + " " + data.node
                		);
                	  },
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
                				var s = data.tree.getSelectedNodes().join(", ");
                				$("#echoSelected").text(s);
                			}
                			
                	  
                	  
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



// Role Tree 


// Role Tree End




// Sample button
// Define a function to get all checked child nodes with parent id and additional data
function getAllCheckedChildNodesWithParentIdAndData() {
    var tree = $("#tree").fancytree("getTree");
    var checkedChildNodes = [];
	var selectedCount =0;
    tree.visit(function(node) {
        // Check if the node is checked and is a child node
        if (node.isSelected() && !node.isTopLevel()) {
            var parentNode = node.getParent();
            var parentNodeID = parentNode.data.newids; // Get the parent node's title
            var parentNodeTitle = parentNode.title; // Get the parent node's title
            
            var subModuleIDs = node.data.subModuleID;
            var subModuleName = node.title;// Get the quantity value
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
		
    });
	console.log(selectedCount);
    return checkedChildNodes;
}

// Example usage:
$("#button").click(function() {
    $('#loadingWrapper').show();
    var checkedChildNodes = getAllCheckedChildNodesWithParentIdAndData();
    if(checkedChildNodes.length ===0 )
    {
        alert('Please Check any one of Module');
        $('#loadingWrapper').hide();
        return false;
    }
    // Print the parent id, child id, qty, and price of all checked child nodes
    console.log("Checked child nodes with parent ids and data:", JSON.stringify(checkedChildNodes));
    $.post('insert_role_permission.php',{permission_data: JSON.stringify(checkedChildNodes),mainRoleID:dataValueOfRole},function(res){
        alert(res);
        $('#loadingWrapper').hide();
    });
});


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
    displayRoleTree('generate_user_privilages.php?roleID='+dataValueOfRole);
    
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
     
        $.post('display_user_roles.php',{userID: dataSelectedUser},function(res){
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
        alert('Please select user');
         $('#loadingWrapper').hide();
        return false;
    }
    if(permissionLoad==0)
    {
        alert('Without Group/Role you cannot save ...!');
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
    console.log(jsonString);
    $.post('insert_user_roles.php',{user_role_data: jsonString},function(res){
         $('#loadingWrapper').hide();
        alert(res);
    });
});

 
 
</script>
