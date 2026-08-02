<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.fancytree/2.27.0/skin-win8/ui.fancytree.css">

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
<div class="container" style="padding-top:20px;">
    <div class="row">
        <div class="col-6">
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
            <div class="col-6">
                <div class="btn-group" style="padding-bottom:10px;">
                  <button class="btn btn-secondary btn-sm dropdown-toggle" style="--bs-btn-padding-y: .15rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .80rem;" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Select Users
                  </button>
                  <ul class="dropdown-menu container_menu" style="height:300px;overflow-y: scroll;">
                     <?php 
                       // Your SQL query
                        $sql = "select * from  users order by username asc";
                        // Execute the query
                        $result = $conn->query($sql);
                    
                     while ($row = $result->fetch_assoc()) {?>
                    <li><a class="dropdown-item user_dropdown" href="#" data-user="<?php echo $row['id'];?>"><?php echo $row['username'];?></a></li>
                    <?php }?>
                  </ul>
                </div>
                <div id="selected_user" style="padding-bottom:10px;"></div>
                <div id="role_tree" class="box"></div>
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
	
	
	
	
displayRoleTree('generate_main_module_json.php');
    var treeInitialized = false; 
function displayRoleTree(fileName)
{

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
    var checkedChildNodes = getAllCheckedChildNodesWithParentIdAndData();
    if(checkedChildNodes.length ===0 )
    {
        alert('Please Check any one of Module');
        return false;
    }
    // Print the parent id, child id, qty, and price of all checked child nodes
    console.log("Checked child nodes with parent ids and data:", JSON.stringify(checkedChildNodes));
    $.post('insert_role_permission.php',{permission_data: JSON.stringify(checkedChildNodes),mainRoleID:dataValueOfRole},function(res){
        alert(res);
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
$('.user_dropdown').click(function(e){
    dataSelectedUser = $(this).attr('data-user');
    var textval = $(this).html();
 
    $('#selected_user').html(textval+' | '+dataSelectedUser);
})
 
 
 
 
</script>
