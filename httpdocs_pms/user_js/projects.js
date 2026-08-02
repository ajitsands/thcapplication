$(document).ready(function(){
  
   $(":input:not(:hidden)").each(function (i) { $(this).attr('tabindex', i + 1); });
  
                    var v_btn_project_add = $( '#btn_project_add' ).ladda();
                    var v_btn_project_edit = $( '#btn_project_edit' ).ladda();
                    var v_btn_project_new = $( '#btn_project_new' ).ladda();
                    
                    $("#btn_project_edit").hide();
                    $("#btn_project_new").hide();
                   project_list_table = $('#list_of_project').DataTable( {} );
                   load_data_to_grid_project();
            
                v_btn_project_add.click(function(){
                    
                    v_btn_project_add.ladda( 'start' );
                    //var v_exp_id=$("#txt_exp_id").val();
                    var v_project_name=$("#txt_project_name").val();
                  
                    if($.trim(v_project_name)=="")
                    
                    {
                        swal("Warning","Please provide project name ....", "warning");
                        v_btn_project_add.ladda( 'stop' );
                        return false;
                    }
                   
                    else
                    {         
                         $.post("../controller/project/project_controller.php",{action:'add_project',v_project_name:v_project_name }
                                , function(result,status)
                                {
                                   
                                result = $.trim(result);
                               
                                if(result.charAt(0)=='U')
                                {
                                    v_btn_project_add.ladda( 'stop' );
                                    swal("Error", result, "error");
                                   
                                   
                                }
                                else 
                                {
                                     v_btn_project_add.ladda( 'stop' );
                                     swal("Success", "New project added successfully..", "success");
                                     
                                    load_data_to_grid_project();
                                    $("#txt_project_name").val('');
                                }
                                
                                 
                            
                        });
                        
                       
                        
                     }
                  
                });
            
       
       

       
       
        
        
        function load_data_to_grid_project()
                 {
                     
                    project_list_table.destroy();
                         
                     project_list_table = $('#list_of_project').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/project/project_controller.php',
                                 'data': {
                                    action: 'list_project'
                                 }
                             },
                             "language": {
                                 "zeroRecords": "No records available",
                                 "infoEmpty": "No records available",
                              },
                           // "order": [[ 0, "desc" ]],
                           
            				"Paginate": true,
            				"bLengthChange": true,
            				"bFilter": true,
            				"bInfo": true,
            				"autoWidth": false,
            				
            			
                            "columns": [
                                
                                 
                                 { "data": null},
                                   { "data": "project_id",
                                      render: function ( data, type, rows, meta ) {
                                          str_active_status_edit = '<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown" style="color:info">	<i class="icon-menu9"></i>	</a>	<div class="dropdown-menu dropdown-menu-right">	<a href="#" class="dropdown-item" name="Edit_project" style="color:orange"><i class="icon-database-edit2"></i> Edit</a><a href="#" class="dropdown-item" name="Active" style="color:green"><i class="icon-database-edit2"></i> Active</a><a href="#" class="dropdown-item" name="Deactive" style="color:red"><i class="icon-database-edit2"></i> Deactive</a></div></div></div>';
                                          return str_active_status_edit;
                                          
                                      }   
                                 },
                                 { "data": "project_id","visible":false },
                                 { "data": "project_name" },
                                 { "data": "project_status",
                                    render: function ( data, type, rows, meta ) {
                                        if(data=='Active'){
                                          str_active_status = '<span class="badge badge-success">'+data+'</span>';
                                          return str_active_status;
                                        }
                                        else{
                                            str_active_status = '<span class="badge badge-danger">'+data+'</span>';
                                            return str_active_status;
                                        }
                                      }    
                                 },
                              
                       
                             ],
                             pageLength: 30,
            				 searching: false,
                             responsive: true,
                             
                             "aoColumnDefs": [
            				//	{ "bSortable": false, "aTargets": [ 1,2] }, 
            					
            				],
                            
            				
                             "initComplete": function( settings, json ) {
                                    
                               
             
                              },
                                "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                                 $("td:eq(0)", nRow).html(iDisplayIndex + 1);
                                 return nRow;
                              },
                              "drawCallback": function () {
                                   
                                }
                            
                     });  
                
                 } 
                 
                 
          $('#list_of_project tbody').on('click', 'a', function(){
                        var $row = $(this).closest('tr');
                        var data = project_list_table.row($row).data();
                        v_project_id  = data.project_id;
                        v_project_status  = data.project_status;
                         if($(this).attr("name")=='Edit_project')
                         {
                         
            			 $("#txt_project_id").val(v_project_id);  
                         $("#txt_project_name").val(data.project_name);
                         
            			    $( '#btn_project_add').hide();
                            $( '#btn_project_edit').show();
                            $( '#btn_project_new').show();
               
            			 }
                        
                         if($(this).attr("name")=='Active' || $(this).attr("name")=='Deactive')
                         {
                             var v_project_action=$(this).attr("name");
                             $.post("../controller/project/project_controller.php",{action:'change_project_status',v_project_id:v_project_id,v_project_status:v_project_status,v_project_action:v_project_action}
                                , function(result,status)
                                {
                                   
                                   load_data_to_grid_project();
                                
                            });
                        }
                          
                
                        
        });
                 
                 
       v_btn_project_edit.click(function(){
                      
                 
                     v_btn_project_edit.ladda( 'start' );
                    var v_project_id=$("#txt_project_id").val();
                    var v_project_name=$("#txt_project_name").val();
  
    
                    if($.trim(v_project_id)=="")
                    
                    {
                        swal("Warning","Please provide all the details ....", "warning");
                        v_btn_project_edit.ladda( 'stop' );
                        return false;
                    }
                   
                    else
                    {         
                         $.post("../controller/project/project_controller.php",{action:'update_project',v_project_id:v_project_id,v_project_name:v_project_name}
                                , function(result,status)
                                {
                                   
                                result = $.trim(result);
                               
                                if(result.charAt(0)=='U')
                                {
                                    v_btn_project_edit.ladda( 'stop' );
                                    swal("Error", result, "error");
                                   
                                }
                                else 
                                {
                                     v_btn_project_edit.ladda( 'stop' );
                                     swal("Success", " Project details updated successfully..", "success");
                                     
                                      $( '#btn_project_add' ).show();
                                      $( '#btn_project_edit' ).hide();
                                      $( '#btn_project_new' ).hide();
                                        $("#txt_project_name").val('');
                                      load_data_to_grid_project();
                                }
                                
                                 
                            
                        });
                        
                       
                        
                     }
            
                   
                });
      $( '#btn_project_new' ).click(function(){
                  
                  $( '#btn_project_add' ).show();
                  $( '#btn_project_edit' ).hide();
                  $( '#btn_project_new' ).hide();
                  $("#txt_project_name").val('');
                 
              })
                  
         

});