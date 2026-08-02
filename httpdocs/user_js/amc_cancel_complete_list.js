$(document).ready(function(){
    var v_amc_id,checked_val_edit,v_first_attachment_edit,v_second_attachment_edit,v_third_attachment_edit,result,v_third_attachment_edit,v_second_attachment_edit,v_first_attachment_edit,randomNum,attachments =[];
 var v_amc_list_table = $('#tbl_amc_list').DataTable({});   
    load_data_to_grid_amc_list();
//load data to amc_list table
                 function load_data_to_grid_amc_list()
                 {
                     
                    v_amc_list_table.destroy();
                         
                     v_amc_list_table = $('#tbl_amc_list').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/amc/amc_controller.php',
                                 'data': {
                                    action: 'amc_list_cance_complete_view'
                                    
                                 }
                             },
                             "language": {
                                 "zeroRecords": "No records available",
                                 "infoEmpty": "No records available",
                              },
                            "order": [[ 0, "desc" ]],
                           
            				"Paginate": true,
            				"bLengthChange": false,
            				"bFilter": false,
            				"bInfo": false,
            				"autoWidth": true,
            				
            			
                            "columns": [
                               
                                 { "data": null},
                                 { "data": "amc_id","visible":false },
                                 { "data": "amc_ref_no",
                                     render: function ( data, type, rows, meta ) {
                                            str_net_amount=parseFloat(rows['amc_vat_amt'])+parseFloat(rows['amc_amount']);
                                            struct = '<div class="border-left-1 border-left-warning rounded-left-0" style="padding-bottom:0px;padding-top:0px;"> <div class="card-body"><div class="row" style="padding-bottom:10px;"><div class="col-lg-6 col-md-6 col-sm-6" ><b>Amount</b></div><div class="col-lg-6 col-md-6 col-sm-6" >'+$.fn.dataTable.render.number(',', '.', 3, '').display(rows['amc_amount'])+'</div></div><div class="row"style="padding-bottom:10px;"><div class="col-lg-6 col-md-6 col-sm-6" ><b>VAT %</b></div><div class="col-lg-6 col-md-6 col-sm-6" >'+$.fn.dataTable.render.number(',', '.', 3, '').display(rows['amc_vat_perct'])+'</div></div><div class="row" style="padding-bottom:10px;"><div class="col-lg-6 col-md-6 col-sm-6" ><b>NET Amount</b></div><div class="col-lg-6 col-md-6 col-sm-6" >'+$.fn.dataTable.render.number(',', '.', 3, '').display(str_net_amount)+'</div></div><div class="row" style="padding-bottom:10px;"><div class="col-lg-12 col-md-12 col-sm-12" ><b> Description </b>: '+rows['amc_description']+'</div></div></div></div>';
                                            str_ref="<a href='#' data-popup='popover' class='popoverButton' title='Other Details' data-trigger='hover' data-html='true' data-content=' "+ struct +"    '>";
                                            str_ref  = str_ref + data+"</a>";
                                         return str_ref;
                                     }     
                                     
                                 },
                                 { "data": "customer_name"},
                                 { "data": "contract_type_name"},
                                 { "data": "amc_signed_date"},
                                 
                                 { "data": "amc_start_date",
                                      render: function ( data, type, rows, meta ) {
                                          str_amc_date = rows['amc_start_date']+'  -  '+rows['amc_end_date'];
                                          return str_amc_date;
                                          
                                      }   
                                 },
                               
                                 { "data": "amc_status",
                                      render: function ( data, type, rows, meta ) {
                                          if(data=='Active')
                                          {
                                          str_active_status='<span class="badge badge-success">'+data+'</span>'
                                          }
                                         
                                          else if(data=='Hold')
                                          {

                                             
                                            struct = '<div class="border-left-1 border-left-primary rounded-left-0" style="padding-bottom:0px;padding-top:0px;"> <div class="card-body"><div class="row" ><div class="col-lg-12 col-md-12 col-sm-12" >'+rows['hold_description']+'</div></div></div>';
                                            str_active_status="<span class='badge badge-primary'> <a href='#' data-popup='popover' class='popoverButton' title='Hold Description' data-trigger='hover' data-html='true' data-content=' "+ struct +"    ' style='color:white'>";
                                            str_active_status  = str_active_status + data+"</a></span>";
                                       
                                          }
                                          else if(data=='Cancelled')
                                          {
                                            struct = '<div class="border-left-1 border-left-danger rounded-left-0" style="padding-bottom:0px;padding-top:0px;"> <div class="card-body"><div class="row" ><div class="col-lg-12 col-md-12 col-sm-12" > Cancelled   Date : '+rows['cancelled_on'] + '<br>' +rows['cancelled_description']+'</div></div></div>';
                                            str_active_status="<span class='badge badge-danger'> <a href='#' data-popup='popover' class='popoverButton' title='Cancelled Description' data-trigger='hover' data-html='true' data-content=' "+ struct +"    ' style='color:white'>";
                                            str_active_status  = str_active_status + data+"</a></span>";   
                                          }
                                          else if(data=='Completed')
                                          {
                                            str_active_status='<span class="badge badge-info">'+data+'</span>'   
                                          }
                                     	return str_active_status;
                                          
                                      }   
                                 },
                                 { "data": "amc_id","className":"text-center",
                                      render: function ( data, type, rows, meta ) {
                                          if(rows['amc_status']=='Hold' || rows['amc_status']=='Active')
                                         {
                                     	return str_actions='<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown"><i class="icon-menu9"></i></a><div class="dropdown-menu dropdown-menu-right"><a href="#" class="dropdown-item" data-toggle="modal" name="amc_change_status" data-target="#modal_change_status"><i class="icon-pencil5"></i> Change Status</a><a href="#" class="dropdown-item" name="Edit_data"><i class="icon-quill4"></i> Edit</a><a href="#" class="dropdown-item" data-toggle="modal" data-target="#modal_backdrop_1"><i class="icon-reload-alt"></i> Renew</a><div class="dropdown-divider"></div><a href="#" class="dropdown-item" data-toggle="modal" data-target="#modal_add_assets"><i class="icon-barcode2"></i> Add Assets </a><a href="#" class="dropdown-item"><i class="icon-pen-plus"></i> Add Services</a><a href="#" class="dropdown-item"><i class="icon-list-numbered"></i> Add Services History</a><div class="dropdown-divider"></div><a href="#" class="dropdown-item" data-toggle="modal" data-target="#modal_backdrop_amc_schedule"><i class="icon-calendar"></i> Schedule  Visits</a><a href="#" class="dropdown-item"><i class="icon-calculator3"></i> Payment Collection</a><div class="dropdown-divider"></div><a href="#" class="dropdown-item"><i class="icon-file-eye"></i> View History</a></div></div></div>';
                                         }
                                         else if(rows['amc_status']=='Completed' || rows['amc_status']=='Cancelled')
                                         {
                                           return str_actions='<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown"><i class="icon-menu9"></i></a><div class="dropdown-menu dropdown-menu-right"><a href="#" class="dropdown-item" data-toggle="modal" name="amc_change_status" data-target="#modal_change_status"><i class="icon-pencil5"></i> Change Status</a><a href="#" class="dropdown-item" data-toggle="modal" data-target="#modal_backdrop_1"><i class="icon-reload-alt"></i> Renew</a><div class="dropdown-divider"></div><a href="#" class="dropdown-item"><i class="icon-calculator3"></i> Payment Collection</a><div class="dropdown-divider"></div><a href="#" class="dropdown-item"><i class="icon-file-eye"></i> View History</a></div></div></div>';
                                          
                                         }
                                      }   
                                 }
                                 
                                 
                                 
                                 
                       
                             ],
                             pageLength: 10,
            				 searching: true,
                             responsive: true,
                             
                             "aoColumnDefs": [
            					{ "bSortable": false, "aTargets": [0,1,2,3,4,5,6,7,8] }, 
            					
            				],
                            
                             "initComplete": function( settings, json ) {
                                    
                               
             
                              },
                                "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                                 $("td:eq(0)", nRow).html(iDisplayIndex + 1);
                                 return nRow;
                              },
                              drawCallback: function (settings) {
                                //   var api = this.api();
                                //     $('.popoverButton').popover({
                                //             "html": true,
                                //             trigger: 'manual',
                                //             placement: 'left',
                                //             "content": function () {
                                //                 return "<div>Popover content</div>";
                                //             }
                                //     })
                            }
                            
                     });  
                
                 }
                 
                 
                  $('#tbl_amc_list tbody').on('click', 'tr', function(e){
                        if($('.popoverButton').length>1)
                            $('.popoverButton').popover('hide');
                            $(e.target).popover('toggle'); 
                      
                  })
             
               
                $('#tbl_amc_list tbody').on('click', 'a', function(e){
                        var $row = $(this).closest('tr');
                        var data = v_amc_list_table.row($row).data();
                        v_amc_id  = data.amc_id;
                        v_amc_ref_no  = data.amc_ref_no;
                        
                        $("#txt_amc_ref_no").val(v_amc_ref_no);
                         if($(this).attr("name")=='amc_change_status')
                         {
                           $("#txt_amc_ref_no").val(v_amc_ref_no);
                             $("#amc_no_view_head").html("Change Status [AMC No : <b>"+v_amc_ref_no+"</b>]");
                             
                         }
                         
                         if($(this).attr("name")=='Edit_data')
						 {
							$('#btn_amc_edit').show();
							$('#btn_amc_add').hide();
							$('#btn_amc_new').show();
							$("#txt_amc_number").val(data.amc_ref_no);
							$("#select_customer_for_amc").val(data.customer_id).trigger("change");
							$("#select_contract_type_for_amc").val(data.contract_type_id).trigger("change");
							
							$("#txt_amc_signed_date").val(data.amc_signed_date);
							var start_date=data.amc_start_date+'-'+data.amc_end_date;
							
							$("#txt_amc_start_end_date").val(start_date);
							
							  var checked_val=data.is_rfp;
                                    						 
								if(checked_val==='No'||checked_val==='')	
								{
									$('input[type="checkbox"]').prop('checked', false);
								}
							    else if(checked_val==='Yes')	
								{								
							$('input[type="checkbox"]').prop('checked', true);
								} 
							$("#txt_amc_amount").val(data.amc_amount);  
							$("#txt_vat_percentage").val(data.amc_vat_perct);
							$("#txt_amc_vat_amount").val(data.amc_vat_amt);
							$("#txt_amc_description").val(data.amc_description);
							$("#txt_first_attachment_desc").val(data.amc_attachment1_desc);
							$("#txt_sec_attachment_desc").val(data.amc_attachment2_desc);
							$("#txt_third_attachment_desc").val(data.amc_attachment3_desc);
							
							$("#first_image_name").html(data.amc_attachment1);
							
							$("#second_image_name").html(data.amc_attachment2);
							$("#thrid_image_name").html(data.amc_attachment3);
							
							}
                         
                       
                });
                 
                 $('#first_attachment').change(function (e) {
			 attachment_upload('#first_attachment',v_first_attachment_edit);
				
		});
		$('#second_attachment').change(function (e) {
			 
				 attachment_upload('#second_attachment',v_second_attachment_edit);
		});
		$('#third_attachment').change(function (e) {
			 
				 attachment_upload('#third_attachment',v_third_attachment_edit);
		});
				  

		function attachment_upload(txt_param,v_attachment)
		 {
				v_attachment = $(txt_param).val();
				randomNum = Math.ceil(Math.random() * 999999);
			   
				if(v_attachment=="")
				{
					alert("inside if");
					v_attachment="default.jpg";
				}
				else
				{
					var doc_file_obj = $(txt_param)[0].files[0];
					var upload = new ns.Upload(doc_file_obj);
					doc_file1= doc_file_obj.name;
					 v_attachment=$.trim(randomNum+'_'+doc_file1);
					 attachments.push(v_attachment);
					var success = upload.doUpload("../httpdocs/user_upload/amc_attachements.php?random_no="+randomNum);
				} 
		 }
               
               //AMC UPDATE STARTS
		$("#btn_amc_edit").click(function(){
						
						$('input[type="checkbox"]').click(function(){
							if($(this).prop("checked") === true)
								{
									checked_val_edit='Yes';
								}
						
							else 
								{
								 checked_val_edit='No';
								}
							});
							if(v_first_attachment_edit===""||typeof v_first_attachment_edit === "undefined")
								{
									v_first_attachment_edit="default.jpg";
								}
								
							if(v_second_attachment_edit===""||typeof v_second_attachment_edit === "undefined")
								{
									   
									v_second_attachment_edit="default.jpg";
								}
									
							if(v_third_attachment_edit===""||typeof v_third_attachment_edit === "undefined")
								{
										   
									v_third_attachment_edit="default.jpg";
								}
								

						$("#update").val(v_amc_id);
						v_first_attachment_edit=attachments[0];
                        v_second_attachment_edit=attachments[1];
                        v_third_attachment_edit=attachments[2];
						var v_amc_hidden_id=$("#update").val();
						
						var v_amc_cust_id_edit=$("#select_customer_for_amc option:selected").val();
						var v_amc_cust_name_code_edit=$("#select_customer_for_amc option:selected").text();
						var res_edit = v_amc_cust_name_code_edit.split("-");
						var v_amc_cust_code_edit=res_edit[0];
						var v_amc_cust_name_edit=res_edit[1]; 
						var v_amc_contract_type_id_edit=$("#select_contract_type_for_amc option:selected").val();
						var v_amc_contract_type_name_edit=$("#select_contract_type_for_amc option:selected").text();
						var v_amc_signed_date_edit=$("#txt_amc_signed_date").val();
						 v_amc_signed_date_edit = v_amc_signed_date_edit.split("/").reverse();
						var tmp_edit = v_amc_signed_date_edit[2];
						v_amc_signed_date_edit[2] = v_amc_signed_date_edit[1];
						v_amc_signed_date_edit[0] = v_amc_signed_date_edit[0];
						v_amc_signed_date_edit[1] = tmp_edit;
						v_amc_signed_date_edit = v_amc_signed_date_edit.join("-");
						var v_amc_start_end_date_edit=$("#txt_amc_start_end_date").val();
						var res_start_end_edit = v_amc_start_end_date_edit.split("-");
						var v_amc_start_date_edit=$.trim(res_start_end_edit[0]);
						var v_amc_end_date_edit=$.trim(res_start_end_edit[1]);
						v_amc_start_date_edit = v_amc_start_date_edit.split("/").reverse();
						var tmpstart_edit = v_amc_start_date_edit[2];
						v_amc_start_date_edit[2] = v_amc_start_date_edit[1];
						v_amc_start_date_edit[0] = v_amc_start_date_edit[0];
						v_amc_start_date_edit[1] = tmpstart_edit;
						v_amc_start_date_edit = v_amc_start_date_edit.join("-");
						v_amc_end_date_edit = v_amc_end_date_edit.split("/").reverse();
						var tmpend_edit = v_amc_end_date_edit[2];
						v_amc_end_date_edit[2] = v_amc_end_date_edit[1];
						v_amc_end_date_edit[0] = v_amc_end_date_edit[0];
						v_amc_end_date_edit[1] = tmpend_edit;
						v_amc_end_date_edit = v_amc_end_date_edit.join("-");
						var v_amc_amount_edit = $("#txt_amc_amount").val();
						var v_amc_vat_percentage_edit = $("#txt_vat_percentage").val();
						var v_amc_vat_per_amount_edit=$("#txt_amc_vat_amount").val();
						var v_amc_is_rfp_edit=checked_val_edit;
						var v_amc_description_edit=$("#txt_amc_description").val();
						var v_amc_first_desc_edit=$("#txt_first_attachment_desc").val();
						var v_amc_second_desc_edit=$("#txt_sec_attachment_desc").val();
                        var v_amc_third_desc_edit=$("#txt_third_attachment_desc").val();
						
				$.post("../controller/amc/amc_controller.php",{action:'update_amc',v_amc_cust_id_edit:v_amc_cust_id_edit,v_amc_cust_code_edit:v_amc_cust_code_edit,v_amc_cust_name_edit:v_amc_cust_name_edit,v_amc_contract_type_id_edit:v_amc_contract_type_id_edit,v_amc_contract_type_name_edit:v_amc_contract_type_name_edit,v_amc_signed_date_edit:v_amc_signed_date_edit,v_amc_start_date_edit:v_amc_start_date_edit,v_amc_end_date_edit:v_amc_end_date_edit,v_amc_amount_edit:v_amc_amount_edit,v_amc_vat_percentage_edit:v_amc_vat_percentage_edit,v_amc_vat_per_amount_edit:v_amc_vat_per_amount_edit,v_amc_is_rfp_edit:v_amc_is_rfp_edit,v_amc_description_edit:v_amc_description_edit,v_first_attachment_edit:v_first_attachment_edit,v_second_attachment_edit:v_second_attachment_edit,v_third_attachment_edit:v_third_attachment_edit,v_amc_first_desc_edit:v_amc_first_desc_edit,v_amc_second_desc_edit:v_amc_second_desc_edit,v_amc_third_desc_edit:v_amc_third_desc_edit,v_amc_hidden_id:v_amc_hidden_id}, function(result,status)
				{
							
				
						result = $.trim(result);
						if(result.charAt(0)=='U')
							{
								
								swal("Error", result, "error");
							  
							}
						else 
							{
								 
								 swal("Success", "AMC details added successfully..", "success");
								 
							}
							
						
				});
						
	});	//close the update of AMC
	  
              $("#btn_amc_new").click(function(){
			location.reload();
	});   
                $("#btn_change_status").click(function(){
                 var v_amc_status_value=   $("input[name='radio-styled-color']:checked").val();
                 var v_amc_staus_description= $("#txt_status_description").val();
                 var v_amc_ref_no=$("#txt_amc_ref_no").val();
                 if(v_amc_status_value==1){
                     v_amc_status="Active";
                 }
                 else if(v_amc_status_value==2)
                 {
                    v_amc_status="Cancelled" 
                 }
                 else if(v_amc_status_value==3)
                 {
                    v_amc_status="Hold" 
                 }
                 else if(v_amc_status_value==4)
                 {
                    v_amc_status="Completed" 
                 }
                 if(v_amc_status_value==3 || v_amc_status_value==2)
                 {
                     if(v_amc_staus_description=='')
                     {
                         swal("Warning","Please provide status description... ","warning")
                     }
                     else
                     {
                        $.post("../controller/amc/amc_controller.php",{action:"change_status",v_amc_status:v_amc_status,v_amc_staus_description:v_amc_staus_description,v_amc_ref_no:v_amc_ref_no},function(result,res){
                             swal("Success","AMC status changed successfully....","success");
                             $("#txt_status_description").val('');
                             load_data_to_grid_amc_list();
                         })  
                     }
                 }
                     else
                     {
                         $.post("../controller/amc/amc_controller.php",{action:"change_status",v_amc_status:v_amc_status,v_amc_staus_description:v_amc_staus_description,v_amc_ref_no:v_amc_ref_no},function(result,res){
                             swal("Success","AMC status changed successfully....","success");
                             $("#txt_status_description").val('');
                             load_data_to_grid_amc_list();
                         })
                     }
                    
                })         

});