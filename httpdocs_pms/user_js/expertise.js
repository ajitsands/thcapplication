$(document).ready(function(){
  
   $(":input:not(:hidden)").each(function (i) { $(this).attr('tabindex', i + 1); });
  
                    var v_btn_expertise_add = $( '#btn_expertise_add' ).ladda();
                    var v_btn_expertise_edit = $( '#btn_expertise_edit' ).ladda();
                    var v_btn_expertise_new = $( '#btn_expertise_new' ).ladda();
                    
                    $("#btn_expertise_edit").hide();
                    $("#btn_expertise_new").hide();
                   expertise_list_table = $('#list_of_expertise').DataTable( {} );
                   load_data_to_grid_expertise();
            
                v_btn_expertise_add.click(function(){
                    
                    v_btn_expertise_add.ladda( 'start' );
                    //var v_exp_id=$("#txt_exp_id").val();
                    var v_exp_name=$("#txt_exp_name").val();
                  
                    if($.trim(v_exp_name)=="")
                    
                    {
                        swal("Warning","Please provide expertise name ....", "warning");
                        v_btn_expertise_add.ladda( 'stop' );
                        return false;
                    }
                   
                    else
                    {         
                         $.post("../controller/expertise/expertise_controller.php",{action:'add_expertise',v_expertise_name:v_exp_name }
                                , function(result,status)
                                {
                                   
                                result = $.trim(result);
                               
                                if(result.charAt(0)=='U')
                                {
                                    v_btn_expertise_add.ladda( 'stop' );
                                    swal("Error", result, "error");
                                   
                                   
                                }
                                else 
                                {
                                     v_btn_expertise_add.ladda( 'stop' );
                                     swal("Success", "New expertise added successfully..", "success");
                                     
                                    load_data_to_grid_expertise();
                                    $("#txt_exp_name").val('');
                                }
                                
                                 
                            
                        });
                        
                       
                        
                     }
                  
                });
            
       
       

       
       
        
        
        function load_data_to_grid_expertise()
                 {
                     
                    expertise_list_table.destroy();
                         
                     expertise_list_table = $('#list_of_expertise').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/expertise/expertise_controller.php',
                                 'data': {
                                    action: 'list_expertise'
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
                                   { "data": "expertise_id",
                                      render: function ( data, type, rows, meta ) {
                                          str_active_status_edit = '<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown" style="color:info">	<i class="icon-menu9"></i>	</a>	<div class="dropdown-menu dropdown-menu-right">	<a href="#" class="dropdown-item" name="Edit_Expertise" style="color:orange"><i class="icon-database-edit2"></i> Edit</a><a href="#" class="dropdown-item" name="Active" style="color:green"><i class="icon-database-edit2"></i> Active</a><a href="#" class="dropdown-item" name="Deactive" style="color:red"><i class="icon-database-edit2"></i> Deactive</a></div></div></div>';
                                          return str_active_status_edit;
                                          
                                      }   
                                 },
                                 { "data": "expertise_id","visible":false },
                                 { "data": "expertise_name" },
                                 { "data": "expertise_status",
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
                 
                 
          $('#list_of_expertise tbody').on('click', 'a', function(){
                        var $row = $(this).closest('tr');
                        var data = expertise_list_table.row($row).data();
                        v_expertise_id  = data.expertise_id;
                        v_expertise_status  = data.expertise_status;
                         if($(this).attr("name")=='Edit_Expertise')
                         {
                         
            			 $("#txt_exp_id").val(v_expertise_id);  
                         $("#txt_exp_name").val(data.expertise_name);
                         
            			    $( '#btn_expertise_add').hide();
                            $( '#btn_expertise_edit').show();
                            $( '#btn_expertise_new').show();
               
            			 }
                        
                         if($(this).attr("name")=='Active' || $(this).attr("name")=='Deactive')
                         {
                             var v_expertise_action=$(this).attr("name");
                             $.post("../controller/expertise/expertise_controller.php",{action:'change_expertise_status',v_expertise_id:v_expertise_id,v_expertise_status:v_expertise_status,v_expertise_action:v_expertise_action}
                                , function(result,status)
                                {
                                   
                                   load_data_to_grid_expertise();
                                
                            });
                        }
                          
                
                        
        });
                 
                 
       v_btn_expertise_edit.click(function(){
                      
                 
                     v_btn_expertise_edit.ladda( 'start' );
                    var v_expertise_id=$("#txt_exp_id").val();
                    var v_expertise_name=$("#txt_exp_name").val();
  
    
                    if($.trim(v_expertise_id)=="")
                    
                    {
                        swal("Warning","Please provide all the details ....", "warning");
                        v_btn_expertise_edit.ladda( 'stop' );
                        return false;
                    }
                   
                    else
                    {         
                         $.post("../controller/expertise/expertise_controller.php",{action:'update_expertise',v_expertise_id:v_expertise_id,v_expertise_name:v_expertise_name}
                                , function(result,status)
                                {
                                   
                                result = $.trim(result);
                               
                                if(result.charAt(0)=='U')
                                {
                                    v_btn_expertise_edit.ladda( 'stop' );
                                    swal("Error", result, "error");
                                   
                                }
                                else 
                                {
                                     v_btn_expertise_edit.ladda( 'stop' );
                                     swal("Success", " Expertise details updated successfully..", "success");
                                     
                                      $( '#btn_expertise_add' ).show();
                                      $( '#btn_expertise_edit' ).hide();
                                      $( '#btn_expertise_new' ).hide();
                                        $("#txt_exp_name").val('');
                                      load_data_to_grid_expertise();
                                }
                                
                                 
                            
                        });
                        
                       
                        
                     }
            
                   
                });
      $( '#btn_expertise_new' ).click(function(){
                  
                  $( '#btn_expertise_add' ).show();
                  $( '#btn_expertise_edit' ).hide();
                  $( '#btn_expertise_new' ).hide();
                  $("#txt_exp_name").val('');
                 
              })
                  
         

});