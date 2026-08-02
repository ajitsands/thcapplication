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
                     if(type=='text')
                     {
                         $('#div_options').hide();
                     }
                     else
                     {
                         $('#div_options').show();
                         if(type=='radio')
                         {
                            $("#txt_question1").val('Poor');
                            $("#txt_question2").val('Good');
                            $("#txt_question3").val('Very Good');
                            $("#txt_question4").val('Excellent');
                            $("#txt_question5").val('Outstanding');
                            $("#txt_question6").val('NA'); 
                         }
                     }
                 });
 
                v_btn_question_add.click(function(){
                    
                    v_btn_question_add.ladda( 'start' );
                    //var v_exp_id=$("#txt_exp_id").val();
					var v_question_type=$("#select_question_type option:selected").val();
					var v_category=$("#select_category option:selected").val();
					var v_category_name=$("#select_category option:selected").text();
                    var v_question=$("#txt_question").val();
                    var v_question1=$("#txt_question1").val();
                    var v_question2=$("#txt_question2").val();
                    var v_question3=$("#txt_question3").val();
                    var v_question4=$("#txt_question4").val();
                    var v_question5=$("#txt_question5").val();
                    var v_question6=$("#txt_question6").val();
                  if($("#select_category option:selected").val() == 0)
                    {
                          
                            swal("Warning","Please select a category question....", "warning");
                            v_btn_question_add.ladda( 'stop' );
                            flag = 1;
                            return false;
                           
                        
                        
                    }
                    else
                    {
                        flag=0;  
                    }
				       
                 if($("#select_question_type option:selected").val() == 'text')
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
                           
                        }
                        else
                        {
                            //alert("one"+flag);
                            flag=0;
                        }
			
                    if(flag==0)
                    {
                         $.post("../controller/customer_feedback/customer_feedback_controller.php",{action:'add_question',v_question_type:v_question_type,v_question:v_question,v_question1:v_question1,v_question2:v_question2,v_question3:v_question3,v_question4:v_question4,v_question5:v_question5,v_question6:v_question6,v_category:v_category,v_category_name:v_category_name }
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
                                    swal("Success", "New question added successfully..", "success");
                                    clear_text();
                                    load_data_to_grid_asset_type();
                                    
                                }
                                
                                 
                            
                        });
                        
                       
                        
                     }
                     else
                     {
                        
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
                                 { "data": "id","visible":false },
                                 { "data": "category" },
                                 { "data": "type" ,"visible":false },								
								 { "data": "question_text", "width": "20%" },
                                 { "data": "status",
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
                                 { "data": null,
                                      render: function ( data, type, rows, meta ) {
                                          str_active_status_edit = '<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown" style="color:info">	<i class="icon-menu9"></i>	</a>	<div class="dropdown-menu dropdown-menu-right">	<a href="#" class="dropdown-item" name="Edit_Question" style="color:orange"><i class="icon-database-edit2"></i> Edit</a><a href="#" class="dropdown-item" name="Active" style="color:green"><i class="icon-database-edit2"></i> Active</a><a href="#" class="dropdown-item" name="Deactive" style="color:red"><i class="icon-database-edit2"></i> Deactive</a></div></div></div>';
                                          return str_active_status_edit;
                                          
                                      }   
                                 }
                                 
                       
                             ],
                             pageLength: 100,
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
                        v_question_id  = data.id;
                        v_question_status  = data.status;
						
                         if($(this).attr("name")=='Edit_Question')
                         {
                             $("#select_question_type").val(data.type).trigger("change");
                             $("#select_category").val(data.category_id).trigger("change");
                             $("#txt_question").val(data.question_text);
                             $("#txt_question_id").val(v_question_id);  
                             if(data.type=="text")
                             {
                                 $("#txt_question1").val();
                                 $("#txt_question2").val();
                                 $("#txt_question3").val();
                                 $("#txt_question4").val();
                                 $("#txt_question5").val();
                                 $("#txt_question6").val();
                                 $("#txt_question1_id").val();
                                 $("#txt_question2_id").val();
                                 $("#txt_question3_id").val();
                                 $("#txt_question4_id").val();
                                 $("#txt_question5_id").val();
                                 $("#txt_question6_id").val();
                             }
                            else
                            {
                                 $.post("../controller/customer_feedback/customer_feedback_controller.php",{action:"fetch_options",v_question_id:v_question_id},function(result,status){
                                     
                                       result = $.trim(result);
                                       console.log(result);
                                       d = JSON.parse(result);
                                       $("#txt_question1").val(d.data[0].option_text);
                                       $("#txt_question1_id").val(d.data[0].id);
                                         $("#txt_question2").val(d.data[1].option_text);
                                         $("#txt_question2_id").val(d.data[1].id);
                                         $("#txt_question3").val(d.data[2].option_text);
                                         $("#txt_question3_id").val(d.data[2].id);
                                         $("#txt_question4").val(d.data[3].option_text);
                                          $("#txt_question4_id").val(d.data[3].id);
                                         $("#txt_question5").val(d.data[4].option_text);
                                         $("#txt_question5_id").val(d.data[4].id);
                                         $("#txt_question6").val(d.data[5].option_text);
                                         $("#txt_question6_id").val(d.data[5].id);
                                 });
                                       
                            }
    						 
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
                   	var v_category=$("#select_category option:selected").val();
					var v_category_name=$("#select_category option:selected").text();
                    var v_question=$("#txt_question").val();
                    var v_question1=$("#txt_question1").val();
                    var v_question2=$("#txt_question2").val();
                    var v_question3=$("#txt_question3").val();
                    var v_question4=$("#txt_question4").val();
                    var v_question5=$("#txt_question5").val();
                    var v_question6=$("#txt_question6").val();
                    var v_question1_id=$("#txt_question1_id").val();
                    var v_question2_id=$("#txt_question2_id").val();
                    var v_question3_id=$("#txt_question3_id").val();
                    var v_question4_id=$("#txt_question4_id").val();
                    var v_question5_id=$("#txt_question5_id").val();
                    var v_question6_id=$("#txt_question6_id").val();
  
    
                    if($("#select_question_type option:selected").val() == 'text')
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
                         
                        }
                        else
                        {
                            //alert("one"+flag);
                            flag=0;
                        }
			
                    if(flag==0)
                    {         
                         $.post("../controller/customer_feedback/customer_feedback_controller.php",{action:'update_question',v_question_type:v_question_type,v_question:v_question,v_question1:v_question1,v_question2:v_question2,v_question3:v_question3,v_question4:v_question4,v_question5:v_question5,v_question6:v_question6,v_question_id:v_question_id,v_question1_id:v_question1_id,v_question2_id:v_question2_id,v_question3_id:v_question3_id,v_question4_id:v_question4_id,v_question5_id:v_question5_id,v_question6_id:v_question6_id ,v_category:v_category,v_category_name:v_category_name}
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