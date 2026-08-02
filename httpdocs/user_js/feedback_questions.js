$(document).ready(function(){
  
        $(":input:not(:hidden)").each(function (i) { $(this).attr('tabindex', i + 1); });
                    var v_btn_question_add = $('#btn_question_add').ladda();
                    var v_btn_question_edit = $('#btn_question_edit').ladda();
                    var v_btn_question_new = $('#btn_question_new').ladda();
                    
                    $("#btn_question_edit").hide();
                    $("#btn_question_new").hide();
                    asset_type_list_table = $('#list_of_feedback_questions').DataTable( {} );
					load_data_to_grid_asset_type();
            // Insert expertise details....
 
                var flag = 0;
                 $("#select_question_type").change(function(){
                     var type = $(this).val();
                     if(type=='Text')
                     {
                         $('#div_options').hide();
                     }
                     else
                     {
                         $('#div_options').show();
                     }
                 });
 
                v_btn_question_add.click(function(){
                    
                    v_btn_question_add.ladda( 'start' );
                    //var v_exp_id=$("#txt_exp_id").val();
					var v_question_type=$("#select_question_type option:selected").val();
                    var v_question=$("#txt_question").val();
                    var v_question1=$("#txt_question1").val();
                    var v_question2=$("#txt_question2").val();
                    var v_question3=$("#txt_question3").val();
                    var v_question4=$("#txt_question4").val();
                    var v_question5=$("#txt_question5").val();
                    var v_question6=$("#txt_question6").val();
                    
                 if($("#select_question_type option:selected").val() == 'Text')
                    {
                         if($.trim(v_question)=="")
                         { 
                            swal("Warning","Please provide question....", "warning");
                            v_btn_question_add.ladda( 'stop' );
                            flag = 1;
                            return false;
                           
                         }
                         else
                         {
                            
                            flag=0;  
                            
                         }
                        
                    }
				
					else if($("#select_question_type option:selected").val() == '0'||$.trim(v_question)==""||$.trim(v_question1)==""||$.trim(v_question2)==""||$.trim(v_question3)==""||$.trim(v_question4)==""||$.trim(v_question5)==""||$.trim(v_question6)==""){
                            swal("Warning","Please provide all field....", "warning");
                            v_btn_question_add.ladda( 'stop' );
                            flag = 1;
                            return false;
                           alert(flag);
                        }
                        else
                        {
                            //alert("one"+flag);
                            flag=0;
                        }
			
                    if(flag==0)
                    {
                         $.post("../controller/customer_feedback/customer_feedback_controller.php",{action:'add_question',v_question_type:v_question_type,v_question:v_question,v_question1:v_question1,v_question2:v_question2,v_question3:v_question3,v_question4:v_question4,v_question5:v_question5,v_question6:v_question6 }
                                , function(result,status)
                                {
                                  
                                result = $.trim(result);
                                
                                if(result.charAt(0)=='U')
                                {
                                    v_btn_question_add.ladda( 'stop' );
                                    swal("Error", result, "error");
                                   
                                   
                                }
                                else 
                                {
                                    v_btn_question_add.ladda( 'stop' );
                                    swal("Success", "New feedback question added successfully..", "success");
                                    clear_text();
                                    load_data_to_grid_asset_type();
                                    
                                }
                                
                                 
                            
                        });
                        
                       
                        
                     }
                     else
                     {
                        // swal("Warning","Something went wrong....", "warning");
                        // v_btn_question_add.ladda( 'stop' ); 
                     }
                     
                   
                });
            
        
        
       function load_data_to_grid_asset_type()
                 {
                     var i=1;
                   asset_type_list_table.destroy();
                         
                       asset_type_list_table = $('#list_of_feedback_questions').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/customer_feedback/customer_feedback_controller.php',
                                 'data': {
                                    action: 'list_feedback_questions'
                                 }
                             },
                             "language": {
                                 "zeroRecords": "No records available",
                                 "infoEmpty": "No records available",
                              },
                            "order": [[ 0, "asc" ]],
                           
            				"Paginate": true,
            				"bLengthChange": true,
            				"bFilter": true,
            				"bInfo": true,
            				"autoWidth": false,
            				
            			
                         "columns": [
                               
                                 { "data": null,className: "text-center",
                                        "render": function(data, type, full, meta) {
                                            return i++;
                                          },
                                    },
                                 { "data": "question_id","visible":false },
                                 { "data": "question_type", "width": "10%" },								
								 { "data": "question_name", "width": "20%" },
								 { "data": "q1", "width": "5%" },
								 { "data": "q2", "width": "5%" },
								 { "data": "q3", "width": "5%" },
								 { "data": "q4", "width": "5%" },
								 { "data": "q5", "width": "5%" },
								 { "data": "q6", "width": "5%" },
                                 { "data": "question_status",
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
                                 { "data": "asset_type_id",
                                      render: function ( data, type, rows, meta ) {
                                          str_active_status_edit = '<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown" style="color:info">	<i class="icon-menu9"></i>	</a>	<div class="dropdown-menu dropdown-menu-right">	<a href="#" class="dropdown-item" name="Edit_Question" style="color:orange"><i class="icon-database-edit2"></i> Edit</a><a href="#" class="dropdown-item" name="Active" style="color:green"><i class="icon-database-edit2"></i> Active</a><a href="#" class="dropdown-item" name="Deactive" style="color:red"><i class="icon-database-edit2"></i> Deactive</a></div></div></div>';
                                          return str_active_status_edit;
                                          
                                      }   
                                 }
                                 
                       
                             ],
                             pageLength: 20,
            				 searching: false,
                             responsive: true,
                             
                //              "aoColumnDefs": [
            				// 	{ "bSortable": false, "aTargets": [ 1,2,3,4,5] }, 
            					
            				// ],
                            
            				
                             "initComplete": function( settings, json ) {
                                    
                               
             
                              },
                                "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                               //  $("td:eq(0)", nRow).html(iDisplayIndex + 1);
                               //  return nRow;
                              },
                              "drawCallback": function () {
                                   
                                }
                            
                     });   
                
                 } 
               
          $('#list_of_feedback_questions tbody').on('click', 'a', function(){
                        var $row = $(this).closest('tr');
                        var data = asset_type_list_table.row($row).data();
                        v_question_id  = data.question_id;
                        v_question_status  = data.question_status;
						//v_category_id  = data.category_id;
                        //v_category_name  = data.category_status;
                         if($(this).attr("name")=='Edit_Question')
                         {
                         
            			 $("#txt_question_id").val(v_question_id);  
                         $("#txt_question").val(data.question_name);
                         $("#txt_question1").val(data.q1);
                         $("#txt_question2").val(data.q2);
                         $("#txt_question3").val(data.q3);
                         $("#txt_question4").val(data.q4);
                         $("#txt_question5").val(data.q5);
                         $("#txt_question6").val(data.q6);
                         $("#select_question_type").val(data.question_type).trigger("change");
						 
            			    $( '#btn_question_add').hide();
                            $( '#btn_question_edit').show();
                            $( '#btn_question_new').show();
               
            			 }
                        
                         if($(this).attr("name")=='Active' || $(this).attr("name")=='Deactive')
                         {
                             var v_action_status=$(this).attr("name");
                             $.post("../controller/customer_feedback/customer_feedback_controller.php",{action:'change_question_status',v_question_id:v_question_id,v_question_status:v_question_status,v_action_status:v_action_status}
                                , function(result,status)
                                {
                                   
                                   load_data_to_grid_asset_type();
                                
                            });
                        }
                          
                
                        
        });
                 
                 
       v_btn_question_edit.click(function(){
                      
                 
                   v_btn_question_edit.ladda( 'start' );
                   var v_question_type=$("#select_question_type option:selected").val();
                    var v_question=$("#txt_question").val();
                    var v_question1=$("#txt_question1").val();
                    var v_question2=$("#txt_question2").val();
                    var v_question3=$("#txt_question3").val();
                    var v_question4=$("#txt_question4").val();
                    var v_question5=$("#txt_question5").val();
                    var v_question6=$("#txt_question6").val();
  
    
                    if($("#select_question_type option:selected").val() == 'Text')
                    {
                         if($.trim(v_question)=="")
                         { 
                            swal("Warning","Please provide question....", "warning");
                            v_btn_question_edit.ladda( 'stop' );
                            flag = 1;
                            return false;
                           
                         }
                         else
                         {
                            
                            flag=0;  
                            
                         }
                        
                    }
				
					else if($("#select_question_type option:selected").val() == '0'||$.trim(v_question)==""||$.trim(v_question1)==""||$.trim(v_question2)==""||$.trim(v_question3)==""||$.trim(v_question4)==""||$.trim(v_question5)==""||$.trim(v_question6)==""){
                            swal("Warning","Please provide all field....", "warning");
                            v_btn_question_edit.ladda( 'stop' );
                            flag = 1;
                            return false;
                           alert(flag);
                        }
                        else
                        {
                            //alert("one"+flag);
                            flag=0;
                        }
			
                    if(flag==0)
                    {         
                         $.post("../controller/customer_feedback/customer_feedback_controller.php",{action:'update_question',v_question_type:v_question_type,v_question:v_question,v_question1:v_question1,v_question2:v_question2,v_question3:v_question3,v_question4:v_question4,v_question5:v_question5,v_question6:v_question6,v_question_id:v_question_id }
                                , function(result,status)
                                {
                                   
                                result = $.trim(result);
                               
                                if(result.charAt(0)=='U')
                                {
                                    v_btn_question_edit.ladda( 'stop' );
                                    swal("Error", result, "error");
                                   
                                }
                                else 
                                {
                                     v_btn_question_edit.ladda( 'stop' );
                                     swal("Success", "Question details updated successfully..", "success");
                                     
                                      $( '#btn_question_add' ).show();
                                      $( '#btn_question_edit' ).hide();
                                      $( '#btn_question_new' ).hide();
                                      clear_text();
                                      
                                      load_data_to_grid_asset_type();
                                }
                                
                                 
                            
                        });
                        
                       
                        
                     }
                     else
                     {
                         
                     }
            
                   
                });
      $( '#btn_question_new' ).click(function(){
                  
                  $( '#btn_question_add' ).show();
                  $( '#btn_question_edit' ).hide();
                  $( '#btn_question_new' ).hide();
                  clear_text();
                 
              })
                  
         
         function clear_text()
         {
            $("#txt_question").val('');
			$("#select_question_type").val(null).trigger("change");
			$("#txt_question1").val('');
			$("#txt_question2").val('');
			$("#txt_question3").val('');
			$("#txt_question4").val('');
			$("#txt_question5").val('');
			$("#txt_question6").val('');
         }

});