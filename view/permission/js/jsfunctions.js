   $(document).ready(function() {
     
        let rowwId='sample' ;
  
        let UrlPostclassPath = PermissionClassNamespace.varUrlPostclassPath;
        var listOfRolls = $('#tlb_listOfRolls').DataTable({
                "paging": false,
                "info": false,
                "language": { search: '', searchPlaceholder: "Search..." },
                "ajax": {
                    'type': 'POST',
                    'url': UrlPostclassPath,
                    'data': {
                        action: 'listOfRolls'
                    }
                },
                "columns": [
                   
                    { "data": "id","visible": false },
                    { "data": "name","width": "10%" },
                   
                ]
                
        }); 
        
        var listOfRollsForUsers = $('#tlb_listOfRollsForUsers').DataTable({
                "paging": false,
                "info": false,
                "language": { search: '', searchPlaceholder: "Search..." },
                "ajax": {
                    'type': 'POST',
                    'url': UrlPostclassPath,
                    'data': {
                        action: 'listOfRolls'
                    }
                },
                "columns": [
                   
                    { "data": "id","visible": false},
                    { "data": "name"},
                   
                ]
                
        }); 
        
        var listOfControlsAndModules = $('#tlb_listOfControlsAndModules').DataTable({searching: false, paging: false, info: false,"ordering": false});
        
        function load_listOfControlsAndModules(action, moduleId){
             
             listOfControlsAndModules.destroy();
             
             listOfControlsAndModules = $('#tlb_listOfControlsAndModules').DataTable({
                "paging": false,
                "info": false,
                language: { search: '', searchPlaceholder: "Search..." },
                "ajax": {
                    'type': 'POST',
                    'url': UrlPostclassPath,
                    'data': {
                        //action: 'listData',
                        action: action,
                        moduleId:moduleId
                    }
                },
                "language": {
                     "zeroRecords": "No records available",
                     "infoEmpty": "No records available",
                },
                "columns": [
                   
                    { "data": "id","visible": false},
                    { "data": "id", "width": "1%",
                        render: function ( data, type, rows, meta )
						 {
						     return '<input type="checkbox" class="form-control" id="checkbox_'+data+'"  style="width:12px;height:12px;" />';
						 }
                    },
                    { "data": "name"},
                    { "data": "class_name","visible": false}
                ],
                "initComplete": function(settings, json) {
                    addedListOfControlsAndModules.rows().every(function () {
                            var data = this.data();
                            var currentRowID = data.id;
                            var checkboxId = '#checkbox_' + currentRowID;
                            $(checkboxId).prop('checked', true);
                        });
                }

                
            });     
        }
        
        
    //     var listOfControlsAndModules = $('#tlb_listOfControlsAndModules').DataTable({
    //             "paging": false,
    //             "info": false,
    //             language: { search: '', searchPlaceholder: "Search..." },
    //             "ajax": {
    //                 'type': 'POST',
    //                 'url': UrlPostclassPath,
    //                 'data': {
    //                     action: 'listData'
    //                 }
    //             },
    //             "columns": [
                   
    //                 { "data": "id","visible": false},
    //                 { "data": "id",
    //                     render: function ( data, type, rows, meta )
				// 		 {
				// 		     return '<input type="checkbox" class="form-control" id="checkbox_'+data+'" />';
				// 		 }
    //                 },
    //                 { "data": "name"},
    //                 { "data": "class_name","visible": false}
    //             ]
                
    //     });     
        
        
       
         var addedListOfControlsAndModules = $('#tlb_addedListOfControlsAndModules').DataTable({
                "paging": false,
                "info": false,
                "odering":false,
                language: { search: '', searchPlaceholder: "Search..." },
                "language": {
                 "zeroRecords": "No records available",
                 "infoEmpty": "No records available",
              },
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
        
         
        $('#tlb_listOfRolls').on('click', 'tbody tr', function() {
            $('#tlb_listOfRolls tbody tr').removeClass('activeTableRowColor'); 
            $(this).addClass('activeTableRowColor');
            var rowData = listOfRolls.row(this).data();
            rowwId = rowData['id'];
            //load_listOfControlsAndModules('listOfPermissionBasedOnRolls_1', rowwId);
            if ($.fn.DataTable.isDataTable('#tlb_addedListOfControlsAndModules')) {
                addedListOfControlsAndModules.destroy();
            }
            addedListOfControlsAndModules = $('#tlb_addedListOfControlsAndModules').DataTable({
                    "paging": false,
                    "info": false,
                    language: { search: '', searchPlaceholder: "Search..." },
                    "ajax": {
                        'type': 'POST',
                        'url': UrlPostclassPath,
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
                    "initComplete": function(settings, json) {
                        load_listOfControlsAndModules('listOfPermissionBasedOnRolls_1', rowwId);
                        // var secondTableData = addedListOfControlsAndModules.rows().data();
                        // secondTableData.each(function(row) {
                        //     $('#checkbox_' + row.id).prop('checked', true);
                        // });
                    }
 
            }); 
            
            
            
           
            // if ($.fn.DataTable.isDataTable('#tlb_addedListOfControlsAndModules')) {
            //     addedListOfControlsAndModules.destroy();
            // }
            // addedListOfControlsAndModules = $('#tlb_addedListOfControlsAndModules').DataTable({
            //         "paging": false,
            //         "info": false,
            //         language: { search: '', searchPlaceholder: "Search..." },
            //         "ajax": {
            //             'type': 'POST',
            //             'url': UrlPostclassPath,
            //             'data': {
            //                 action: 'listOfPermissionBasedOnRolls',
            //                 rollId : rowData['id']
            //             }
                        
            //         },
            //         "columns": [
                       
            //             { "data": "id","visible": false},
            //             { "data": "name"},
            //             { "data": "class_name","visible": false}
                       
            //         ],
            //         // New Added
            //         "initComplete": function(settings, json) {
                        
            //             if (isDataTableEmpty('#tlb_addedListOfControlsAndModules')) {
            //                     // DataTable is empty
            //                     console.log('DataTable is empty.');
            //                     listOfControlsAndModules.ajax.reload();
            //             } 
                        
                        
            //           // Reload the first DataTable and strike out corresponding items after reload completion
            //             listOfControlsAndModules.ajax.reload(function() {
            //                 // Get array of IDs present in the second DataTable
            //                 var secondTableIds = addedListOfControlsAndModules.rows().data().pluck('id').toArray();
                            
            //                 // Iterate through rows of the first DataTable
            //                 listOfControlsAndModules.rows().every(function(rowIdx, tableLoop, rowLoop) {
            //                     var rowData = this.data(); // Get row data
            //                     var id = rowData.id; // Assuming the ID is present in rowData
                                
            //                     // Check if the ID is present in the array of IDs from the second DataTable
            //                     var isIdInSecondTable = secondTableIds.includes(id);
                                
            //                     // If the ID is present in the array, strike out the corresponding item in the first DataTable
            //                     if (isIdInSecondTable) {
            //                         $(this.node()).addClass('strikethrough'); // Add CSS class for strikethrough style
            //                         $('#checkbox_'+id).prop('checked', true);
            //                     }
            //                 });
                            
            //                 // Redraw the first DataTable to reflect changes
            //                 listOfControlsAndModules.draw();
            //             });


                        
            //         }
                    
            //         //New added ends Here
                
            // }); 
            
           // New Added

    
           //New added ends Here
            
            
        });
        
        var selected_id;
        $('#tlb_listOfControlsAndModules').on('click', 'tbody tr', function() {
            var $row = $(this).closest('tr');
            var rowData  = listOfControlsAndModules.row($row).data();
            console.log(rowData.id);
            selected_id = rowData.id;
            var checkbox = $(this).find('input[type="checkbox"]');
            checkbox.prop('checked', !checkbox.prop('checked'));
            var isChecked = checkbox.prop('checked');
            if(isChecked)
            {
                var rowdata = listOfControlsAndModules.row(this).data();
                console.log("Clicked row data:", rowdata);
                addedListOfControlsAndModules.row.add(rowdata).draw();
            }
            else
            {
                 addedListOfControlsAndModules.rows().every(function () {
                     var data = this.data();
                     var currentRowID = data.id; 
                     console.log("all ids--"+currentRowID);
                     console.log(selected_id+"==="+currentRowID);
                     if(selected_id===currentRowID)
                     {
                         this.remove();
                         addedListOfControlsAndModules.draw();
                     }
                 });
                 
            }
            
          
        });
        
        
        // $('#tlb_addedListOfControlsAndModules').on('click', 'tbody tr', function() {                                               
           
        //     if (addedListOfControlsAndModules.rows().count() === 0) {
        //         console.log("First table has no data.");
        //         return;
        //     }
          
        //     $('#tlb_addedListOfControlsAndModules tbody tr').removeClass('activeTableRowColor');
            
        //     $(this).addClass('activeTableRowColor');
            
        //      var rowData = addedListOfControlsAndModules.row(this).data();
        //     if (rowData) {
               
        //         var id = rowData.id;
                
             
        //         listOfControlsAndModules.rows().every(function(rowIdx, tableLoop, rowLoop) {
        //             var rowData = this.data(); 
        //             var rowId = rowData.id; 
                    
                   
        //             if (rowId === id) {
        //                 $(this.node()).removeClass('strikethrough'); 
        //             }
        //         });
        //     }
             
        //     addedListOfControlsAndModules.row($(this)).remove().draw();
             
        // });
        
        
        
        $('#btn_confim_privilages').on('click', function() {
            
            if(rowwId==='')
            {
                
                setupDropdown('dropdownContent','error','Please Select Roll','click');
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
            $.post(UrlPostclassPath,{action:'save_privilages',privilage_data:firstColumnData, rollId : rowwId}, function(ret){
                 setupDropdown('dropdownContent','success',ret,'click');
            });
              
        });
        
        
        
        // User List and functions
        
        var listOfUsers = $('#tlb_listOfUsers').DataTable({
                "paging": false,
                "info": false,
                "language": { search: '', searchPlaceholder: "Search..." },
                "ajax": {
                    'type': 'POST',
                    'url': UrlPostclassPath,
                    'data': {
                        action: 'listOfUsers'
                    }
                },
                "columns": [
                   
                    //{ "data": "id","visible": false},
                    { "data": "id" },
                    { "data": "username"},
                    { "data": "employee_name"},
                    { "data": "role_name","visible": false },
                   
                ]
                
        }); 
        var data,user_id,listOfRollsOfSelectedUser;
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
            
            
            if ($.fn.DataTable.isDataTable('#tlb_listOfSelectedUserRolls')) {
                listOfRollsOfSelectedUser.destroy();
            }
            listOfRollsOfSelectedUser = $('#tlb_listOfSelectedUserRolls').DataTable({
                "paging": false,
                "info": false,
                "language": { search: '', searchPlaceholder: "Search..." },
                "ajax": {
                    'type': 'POST',
                    'url': UrlPostclassPath,
                    'data': {
                        action: 'listOfSelectedUserRolls',
                        userId:user_id
                    }
                },
                	"language": {
                                 "zeroRecords": "No records available",
                                 "infoEmpty": "No records available",
                              },
                "columns": [
                   
                    { "data": "name"},
                   
                ]
                
            }); 
            
            
            
            
            
            
            
        });
        
        
        $('#tlb_listOfRollsForUsers').on('click', 'tbody tr', function() {
           
            if (listOfUsers.rows().count() === 0) {
                console.log("First table has no data.");
                return; // Exit the function if there are no rows
            }
            // Remove 'selected' class from all rows
            //$('#tlb_listOfRollsForUsers tbody tr').removeClass('activeTableRowColor');
            // Add 'selected' class to the clicked row
            //$(this).addClass('activeTableRowColor');
            if ($(this).hasClass('activeTableRowColor')) {
                $(this).removeClass('activeTableRowColor');
            } else {
                listOfRollsForUsers.$('tr.selected').removeClass('activeTableRowColor');
                $(this).addClass('activeTableRowColor');
            }
            
            
            var rowData = listOfRollsForUsers.row(this).data();
            console.log("Clicked row data:", rowData['id']);
            data = rowData['id'];
           
        });
        
        $('#btn_change_user_roll').on('click', function() {
            
            
            if(data==='')
            {
                setupDropdown('dropdownContent','error','Please Select Roll/Groups','click');
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
            $.post(UrlPostclassPath,{action:'updateUserPrivilageByUserID',privilage_id:selectedColumnData,userId:user_id}, function(ret){
                if (ret.indexOf('Error') !== -1) {
                    setupDropdown('dropdownContent','error',ret,'click');
                } else {
                    setupDropdown('dropdownContent','success',ret,'click');
                }
                
            });
              
        });
        
        $('#btn_addRolesOrGroups').on('click', function() {
           var addRolesOrGroups = $('#txt_addRolesOrGroups').val();
           if(addRolesOrGroups=="")
           {
                setupDropdown('dropdownContent','error','Please add a Role...!','click');
                return false;
           }
             $.post(UrlPostclassPath,{action:'addRolesOrGroups',add_RolesOrGroups:addRolesOrGroups}, function(ret){
                listOfRolls.ajax.reload();
                
                 setupDropdown('dropdownContent','error','Something went Wrong..!','click');
            });
        });
        
        
        //$('.dataTables_filter input').css({'width':'0', 'padding':'0', 'margin':'0', 'border':'none', 'outline':'none'});
        
        $('#modal_close_permissions').click(function(){
            $('#modal_add_permissions').modal("hide");
        });
        
        var tbl_listOfModules = $('#tbl_listOfModules').DataTable({
                "paging": false,
                "info": false,
                "language": { search: '', searchPlaceholder: "Search..." },
                "ajax": {
                    'type': 'POST',
                    'url': UrlPostclassPath,
                    'data': {
                        action: 'listOfAllModules'
                    }
                },
                "columns": [
                    { "data": "ids","visible": false },
                    { "data": "module_name" },
                ],
                "initComplete": function(settings, json) {
                    $('#tbl_listOfModules tbody tr').on('click', function() {
                        var $row = $(this).closest('tr');
                        var rowData = tbl_listOfModules.row($row).data();
                        $('#tbl_listOfModules tbody tr').removeClass('activeTableRowColor');
                        $(this).addClass('activeTableRowColor');
                        load_listOfControlsAndModules('listData', rowData.ids);
                    });
                }

        }); 
        
       


      
    });