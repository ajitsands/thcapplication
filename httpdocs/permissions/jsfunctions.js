   $(document).ready(function() {
        
        let rowwId='' ;
        var listOfRolls = $('#tlb_listOfRolls').DataTable({
                "paging": false,
                "info": false,
                "language": { search: '', searchPlaceholder: "Search..." },
                "ajax": {
                    'type': 'POST',
                    'url': 'permission_class/class_permission.php',
                    'data': {
                        action: 'listOfRolls'
                    }
                },
                "columns": [
                   
                    { "data": "id","visible": false},
                    { "data": "name"},
                   
                ]
                
        }); 
        
        var listOfRollsForUsers = $('#tlb_listOfRollsForUsers').DataTable({
                "paging": false,
                "info": false,
                "language": { search: '', searchPlaceholder: "Search..." },
                "ajax": {
                    'type': 'POST',
                    'url': 'permission_class/class_permission.php',
                    'data': {
                        action: 'listOfRolls'
                    }
                },
                "columns": [
                   
                    { "data": "id","visible": false},
                    { "data": "name"},
                   
                ]
                
        }); 
        
        
        
        var listOfControlsAndModules = $('#tlb_listOfControlsAndModules').DataTable({
                "paging": false,
                "info": false,
                language: { search: '', searchPlaceholder: "Search..." },
                "ajax": {
                    'type': 'POST',
                    'url': 'permission_class/class_permission.php',
                    'data': {
                        action: 'listData'
                    }
                },
                "columns": [
                   
                    { "data": "id","visible": false},
                    { "data": "name"},
                    { "data": "class_name","visible": false}
                ]
                
        });     
        
       
         var addedListOfControlsAndModules = $('#tlb_addedListOfControlsAndModules').DataTable({
                "paging": false,
                "info": false,
                language: { search: '', searchPlaceholder: "Search..." },
                "columns": [
                   
                    { "data": "id","visible": false},
                    { "data": "name"},
                    { "data": "class_name","visible": false}
                ]
        });   
        
        // Function to check if DataTable is empty
        function isDataTableEmpty(tableId) {
            // Check if DataTable is initialized
            if ($.fn.DataTable.isDataTable(tableId)) {
                // DataTable is initialized
                var table = $(tableId).DataTable();
                
                // Check if DataTable contains any rows
                return table.rows().count() === 0;
            } else {
                // DataTable is not initialized or not found
                return true; // Treat as empty
            }
        }
        
           // Event delegation for click events on table rows
        $('#tlb_listOfRolls').on('click', 'tbody tr', function() {
           
            // Remove 'selected' class from all rows
            $('#tlb_listOfRolls tbody tr').removeClass('activeTableRowColor');
            // Add 'selected' class to the clicked row
            $(this).addClass('activeTableRowColor');
            
            // Log row data to console for debugging
            var rowData = listOfRolls.row(this).data();
            console.log("Clicked row data:", rowData['id']);
            rowwId = rowData['id'];
           
            if ($.fn.DataTable.isDataTable('#tlb_addedListOfControlsAndModules')) {
                addedListOfControlsAndModules.destroy();
            }
            addedListOfControlsAndModules = $('#tlb_addedListOfControlsAndModules').DataTable({
                    "paging": false,
                    "info": false,
                    language: { search: '', searchPlaceholder: "Search..." },
                    "ajax": {
                        'type': 'POST',
                        'url': 'permission_class/class_permission.php',
                        'data': {
                            action: 'listOfPermissionBasedOnRolls',
                            rollId : rowData['id']
                        }
                        
                    },
                    "columns": [
                       
                        { "data": "id","visible": false},
                        { "data": "name"},
                        { "data": "class_name","visible": false}
                       
                    ],
                    // New Added
                    "initComplete": function(settings, json) {
                        
                        if (isDataTableEmpty('#tlb_addedListOfControlsAndModules')) {
                                // DataTable is empty
                                console.log('DataTable is empty.');
                                listOfControlsAndModules.ajax.reload();
                        } 
                        
                        
                       // Reload the first DataTable and strike out corresponding items after reload completion
                        listOfControlsAndModules.ajax.reload(function() {
                            // Get array of IDs present in the second DataTable
                            var secondTableIds = addedListOfControlsAndModules.rows().data().pluck('id').toArray();
                            
                            // Iterate through rows of the first DataTable
                            listOfControlsAndModules.rows().every(function(rowIdx, tableLoop, rowLoop) {
                                var rowData = this.data(); // Get row data
                                var id = rowData.id; // Assuming the ID is present in rowData
                                
                                // Check if the ID is present in the array of IDs from the second DataTable
                                var isIdInSecondTable = secondTableIds.includes(id);
                                
                                // If the ID is present in the array, strike out the corresponding item in the first DataTable
                                if (isIdInSecondTable) {
                                    $(this.node()).addClass('strikethrough'); // Add CSS class for strikethrough style
                                    
                                }
                            });
                            
                            // Redraw the first DataTable to reflect changes
                            listOfControlsAndModules.draw();
                        });


                        
                    }
                    
                    //New added ends Here
                
            }); 
            
           // New Added

    
           //New added ends Here
            
            
        });
        
         $('#tlb_listOfControlsAndModules').on('click', 'tbody tr', function() {
            
            if (listOfControlsAndModules.rows().count() === 0) {
                console.log("First table has no data.");
                return; // Exit the function if there are no rows
            }
            
            var isStrikethrough = $(this).hasClass('strikethrough');
        
            // Output whether the item is strikethrough or not
            if (isStrikethrough) {
                console.log('Control/Module already add to permission');
                return false;
            } 
            
                
            // Remove 'selected' class from all rows
            $('#tlb_listOfControlsAndModules tbody tr').removeClass('activeTableRowColor');
            // Add 'selected' class to the clicked row
            $(this).addClass('activeTableRowColor');
            
            // Log row data to console for debugging
            var rowData = listOfControlsAndModules.row(this).data();
            console.log("Clicked row data:", rowData);
            addedListOfControlsAndModules.row.add(rowData).draw();
            //listOfControlsAndModules.row($(this)).remove().draw();
            $(this).toggleClass('strikethrough');
          
        });
        
        
        $('#tlb_addedListOfControlsAndModules').on('click', 'tbody tr', function() {
           
            if (addedListOfControlsAndModules.rows().count() === 0) {
                console.log("First table has no data.");
                return; // Exit the function if there are no rows
            }
            // Remove 'selected' class from all rows
            $('#tlb_addedListOfControlsAndModules tbody tr').removeClass('activeTableRowColor');
            // Add 'selected' class to the clicked row
            $(this).addClass('activeTableRowColor');
            
            // Log row data to console for debugging
            // var rowData = addedListOfControlsAndModules.row(this).data();
            // console.log("Clicked row data:", rowData);
            // listOfControlsAndModules.row.add(rowData).draw();
           
             
             var rowData = addedListOfControlsAndModules.row(this).data();
            if (rowData) {
                // Get the ID of the clicked row
                var id = rowData.id; // Assuming the ID is present in rowData
                
                // Iterate through rows of the first DataTable
                listOfControlsAndModules.rows().every(function(rowIdx, tableLoop, rowLoop) {
                    var rowData = this.data(); // Get row data
                    var rowId = rowData.id; // Assuming the ID is present in rowData
                    
                    // If the ID of the clicked row matches the ID of the row in the first DataTable, remove the strikethrough style
                    if (rowId === id) {
                        $(this.node()).removeClass('strikethrough'); // Remove CSS class for strikethrough style
                    }
                });
            }
             
            addedListOfControlsAndModules.row($(this)).remove().draw();
             
        });
        
        
        
        $('#btn_confim_privilages').on('click', function() {
            
            if(rowwId==='')
            {
                alert('Please Select Roll');
                return false;
            }
            var firstColumnData = [];
            
            // Iterate over each row in the DataTable
                addedListOfControlsAndModules.rows().every(function(rowIdx, tableLoop, rowLoop) {
                var rowData = this.data(); // Get data for the current row
                var firstColumnValue = rowData['id']; // Get data from the first column (index 0)
                firstColumnData.push(firstColumnValue); // Add the first column data to the array
            });
    
            // Now you have an array containing the data from the first column of all rows
            console.log(firstColumnData);
            $.post('permission_class/class_permission.php',{action:'save_privilages',privilage_data:firstColumnData, rollId : rowwId}, function(ret){
                Swal.fire({
                  title: "User Privilages",
                  text: ret,
                  icon: "success"
                });
            });
              
        });
        
        
        
        // User List and functions
        
        var listOfUsers = $('#tlb_listOfUsers').DataTable({
                "paging": false,
                "info": false,
                "language": { search: '', searchPlaceholder: "Search..." },
                "ajax": {
                    'type': 'POST',
                    'url': 'permission_class/class_permission.php',
                    'data': {
                        action: 'listOfUsers'
                    }
                },
                "columns": [
                   
                    { "data": "id","visible": false},
                    { "data": "username"},
                    { "data": "role_name"},
                   
                ]
                
        }); 
        var data,user_id;
        $('#tlb_listOfUsers').on('click', 'tbody tr', function() {
           
            if (listOfUsers.rows().count() === 0) {
                console.log("First table has no data.");
                return; // Exit the function if there are no rows
            }
            // Remove 'selected' class from all rows
            $('#tlb_listOfUsers tbody tr').removeClass('activeTableRowColor');
            // Add 'selected' class to the clicked row
            $(this).addClass('activeTableRowColor');

            var rowData = listOfUsers.row(this).data();
            user_id = rowData['id'];
        });
        
        
        $('#tlb_listOfRollsForUsers').on('click', 'tbody tr', function() {
           
            if (listOfUsers.rows().count() === 0) {
                console.log("First table has no data.");
                return; // Exit the function if there are no rows
            }
            // Remove 'selected' class from all rows
            //$('#tlb_listOfRollsForUsers tbody tr').removeClass('activeTableRowColor');
            // Add 'selected' class to the clicked row
            $(this).addClass('activeTableRowColor');
            
            var rowData = listOfRollsForUsers.row(this).data();
            console.log("Clicked row data:", rowData['id']);
            data = rowData['id'];
           
        });
        
        $('#btn_change_user_roll').on('click', function() {
            
            
            if(data==='')
            {
                Swal.fire({
                  title: "Role/Groups",
                  text: "Please Select Roll/Groups",
                  icon: "question"
                });
                return false;
            }
            
            
            
            var columnIndex = 1; // Specify the index of the column you want to retrieve data from
            var selectedColumnData = [];
            
            // Iterate over each row in the table
            listOfRollsForUsers.rows().every(function() {
                // Check if the row has the class 'activeTableRowColor', indicating it's selected
                if ($(this.node()).hasClass('activeTableRowColor')) {
                    // Get the data from the specified column for the selected row
                    var rowData = this.data();
                    selectedColumnData.push(rowData.id);
                }
            });
    
            console.log(selectedColumnData);
            
          
            // Now you have an array containing the data from the first column of all rows
            $.post('permission_class/class_permission.php',{action:'updateUserPrivilageByUserID',privilage_id:selectedColumnData,userId:user_id}, function(ret){
                Swal.fire({
                  title: "User Privilages",
                  text: ret,
                  icon: "success"
                });
            });
              
        });
        
        $('#btn_addRolesOrGroups').on('click', function() {
           var addRolesOrGroups = $('#txt_addRolesOrGroups').val();
             $.post('permission_class/class_permission.php',{action:'addRolesOrGroups',add_RolesOrGroups:addRolesOrGroups}, function(ret){
                listOfRolls.ajax.reload();
                Swal.fire({
                  title: "Something went Wrong..!",
                  text: ret,
                  icon: "error"
                });
                
            });
        });
        
        
        //$('.dataTables_filter input').css({'width':'0', 'padding':'0', 'margin':'0', 'border':'none', 'outline':'none'});
        
       
    });