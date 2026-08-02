<!-- Vertical tabs -->
<?PHP
include(__DIR__ . '/../../model/db_connection/connection.php');

$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();
$i=0;
 	$result = mysqli_query($varDBConnection,"select *,DATE_FORMAT(warentee_end_date, '%d-%m-%Y') as warentee_end_date from  tbl_assets where asset_ref_no = '".$_POST['asset_code']."'");
 	$result_service = mysqli_query($varDBConnection,"select service_description,DATE_FORMAT(service_complete_cancel_date_time, '%d-%m-%Y') as service_complete_cancel_date_time,tech_remarks,tech_audio_file, ticket_ref_code as ref,ticket_id from  tbl_ticket_services where asset_code = '".$_POST['asset_code']."' and ticket_service_status in ('Completed','Closed') union select service_description,DATE_FORMAT(service_complete_cancel_date_time, '%d-%m-%Y') as service_complete_cancel_date_time,tech_remarks,tech_audio_file,amc_ref_code as ref,amc_visit_id as ticket_id  from  tbl_amc_services where asset_code = '".$_POST['asset_code']."' and amc_service_status in ('Completed','Closed')");
 	
 	
 	$num_rows = mysqli_num_rows($result);
 	if($num_rows>0)
 {
      	while($row=mysqli_fetch_assoc($result)) { 
      		$result_cust = mysqli_query($varDBConnection,"select customer_contact_no,customer_email_id from  tbl_customers where customer_code = '".$row['customer_code']."'");
      		while($row_cust=mysqli_fetch_assoc($result_cust)) { 
      		    
      		    $cust_contact_no=$row_cust['customer_contact_no'];
      		    $cust_email_id=$row_cust['customer_email_id'];
      		}
      		
      	
      	
      	?>

 	<div class="row">
					<div class="col-md-12">
						<div class="card">
							<div class="card-header header-elements-inline">
								<h6 class="card-title">Asset Details</h6>
								<div class="header-elements">
									
			                	</div>
							</div>

							<div class="card-body">
								<div class="d-md-flex">
									<ul class="nav nav-tabs nav-tabs-vertical flex-column mr-md-3 wmin-md-200 mb-md-0 border-bottom-0">
										<li class="nav-item"><a href="#vertical-left-tab1" class="nav-link active" data-toggle="tab"><i class="icon-location4"></i> Customer & Location </a></li>
										<li class="nav-item"><a href="#vertical-left-tab2" class="nav-link" data-toggle="tab"><i class="icon-mention mr-2"></i>  General Details</a></li>
											<li class="nav-item"><a href="#vertical-left-tab3" class="nav-link" data-toggle="tab"><i class="icon-hammer-wrench"></i> Service Details</a></li>
									
									</ul>

									<div class="tab-content">
										<div class="tab-pane fade show active" id="vertical-left-tab1">
										
                            							<!--<div class="card-body border-top-0">-->
                            							
                            								<div class="d-sm-flex flex-sm-wrap mb-3">
                            									<div class="font-weight-semibold"><h4>Asset Barcode:</h4></div>
                            									<div ><h4><b>&nbsp;<code><?php echo $_POST['asset_code'];?></code></b></h4></div>
                            								</div>
                            									<div class="d-sm-flex flex-sm-wrap mb-3">
                            									<div class="font-weight-semibold">Customer:</div>
                            									<div class="ml-sm-auto mt-2 mt-sm-0">&nbsp;<span class="text-primary"><?php echo $row['customer_code'].' : '.$row['customer_name'];?></span></div>
                            								</div>
                            									<div class="d-sm-flex flex-sm-wrap mb-3">
                            									<div class="font-weight-semibold">Contact No:</div>
                            									<div class="ml-sm-auto mt-2 mt-sm-0">&nbsp;<span class="text-primary"><?php echo $cust_contact_no;?></span></div>
                            								</div>
                            									<div class="d-sm-flex flex-sm-wrap mb-3">
                            									<div class="font-weight-semibold">Email Id:</div>
                            									<div class="ml-sm-auto mt-2 mt-sm-0">&nbsp;<span class="text-primary"><?php echo $cust_email_id;?></span></div>
                            								</div>
                            								
                            									<div class="d-sm-flex flex-sm-wrap mb-3">
                            									<div class="font-weight-semibold">Location:</div>
                            									<div class="ml-sm-auto mt-2 mt-sm-0">&nbsp;<span class="text-primary"><?php echo $row['location_code'].' : '.$row['asset_location'];?></span></div>
                            								</div>
                                                             	<div class="d-sm-flex flex-sm-wrap mb-3">
                            									<div class="font-weight-semibold">Building:</div>
                            									<div class="ml-sm-auto mt-2 mt-sm-0">&nbsp;<span class="text-primary"><?php echo $row['building_code'].' : '.$row['asset_building'];?></span></div>
                            								</div>
                            								<div class="d-sm-flex flex-sm-wrap mb-3">
                            									<div class="font-weight-semibold">Zone:</div>
                            									<div class="ml-sm-auto mt-2 mt-sm-0">&nbsp;<span class="text-primary"><?php echo $row['zone_floor'];?></span></div>
                            								</div>
                            
                            								<div class="d-sm-flex flex-sm-wrap mb-3">
                            									<div class="font-weight-semibold">Flat:</div>
                            									<div class="ml-sm-auto mt-2 mt-sm-0">&nbsp;<span class="text-primary"><?php echo $row['flat_area_code'];?></span></div>
                            								</div>
                            								<div class="d-sm-flex flex-sm-wrap mb-3">
                                                        	<div class="font-weight-semibold">Room:</div>
                            									<div class="ml-sm-auto mt-2 mt-sm-0">&nbsp;<span class="text-primary"><?php echo $row['room_no'];?></span></div>
                            								</div>
                            								<div class="d-sm-flex flex-sm-wrap mb-3">
                            									<div class="font-weight-semibold">Specify:</div>
                            									<div class="ml-sm-auto mt-2 mt-sm-0">&nbsp;<span class="text-primary"><?php echo $row['asset_sp_des'];?></span></div>
                            								</div>
                            							
                            							<!--</div>-->
											
										</div>

										<div class="tab-pane fade" id="vertical-left-tab2">
															<!--<div class="card-body border-top-0">-->
                            							
                            								<div class="d-sm-flex flex-sm-wrap mb-3">
                            									<div class="font-weight-semibold"><h4>Asset Barcode:</h4></div>
                            									<div ><h4><b>&nbsp;<code><?php echo $_POST['asset_code'];?></code></b></h4></div>
                            								</div>
                            									<div class="d-sm-flex flex-sm-wrap mb-3">
                            									<div class="font-weight-semibold">Category:</div>
                            									<div class="ml-sm-auto mt-2 mt-sm-0"&nbsp;<span class="text-primary"><?php echo $row['asset_category_name'];?></span></div>
                            								</div>
                            									<div class="d-sm-flex flex-sm-wrap mb-3">
                            									<div class="font-weight-semibold">Type:</div>
                            									<div class="ml-sm-auto mt-2 mt-sm-0">&nbsp;<span class="text-primary"><?php echo $row['asset_type_name'];?></span></div>
                            								</div>
                            									<div class="d-sm-flex flex-sm-wrap mb-3">
                            									<div class="font-weight-semibold">Brand:</div>
                            									<div class="ml-sm-auto mt-2 mt-sm-0">&nbsp;<span class="text-primary"><?php echo $row['asset_brand'];?></span></div>
                            								</div>
                            								
                            									<div class="d-sm-flex flex-sm-wrap mb-3">
                            									<div class="font-weight-semibold">Model No:</div>
                            									<div class="ml-sm-auto mt-2 mt-sm-0">&nbsp;<span class="text-primary"><?php echo $row['asset_serial_no'];?></span></div>
                            								</div>
                                                             	<div class="d-sm-flex flex-sm-wrap mb-3">
                            									<div class="font-weight-semibold">Capacity:</div>
                            									<div class="ml-sm-auto mt-2 mt-sm-0">&nbsp;<span class="text-primary"><?php echo $row['asset_capacity'];?></span></div>
                            								</div>
                            								<div class="d-sm-flex flex-sm-wrap mb-3">
                            									<div class="font-weight-semibold">Cost:</div>
                            									<div class="ml-sm-auto mt-2 mt-sm-0">&nbsp;<span class="text-primary"><?php echo $row['asset_cost'];?></span></div>
                            								</div>
                            
                            								<div class="d-sm-flex flex-sm-wrap mb-3">
                            									<div class="font-weight-semibold">G/W:</div>
                            									<div class="ml-sm-auto mt-2 mt-sm-0">&nbsp;<span class="text-primary"><?php echo $row['is_warentee'];?></span></div>
                            								</div>
                            								<div class="d-sm-flex flex-sm-wrap mb-3">
                                                        	<div class="font-weight-semibold">G/W Upto:</div>
                            									<div class="ml-sm-auto mt-2 mt-sm-0">&nbsp;<span class="text-primary"><?php echo $row['warentee_end_date'];?></span></div>
                            								</div>
                            								<div class="d-sm-flex flex-sm-wrap mb-3">
                            									<div class="font-weight-semibold">Description:</div>
                            									<div class="ml-sm-auto mt-2 mt-sm-0">&nbsp;<span class="text-primary"><?php echo $row['asset_description'];?></span></div>
                            								</div>
                            								<div class="d-sm-flex flex-sm-wrap mb-3">
                            									<div class="font-weight-semibold">Image:</div>
                            									<div class="ml-sm-auto mt-2 mt-sm-0"><a href="../../httpdocs/images/amc_attachements/<?php echo $row['asset_attachment'];?>" target="_BLANK"><img src="../../httpdocs/images/amc_attachements/<?php echo $row['asset_attachment'];?>" class="rounded-circle" height="50px" width="50px"/> </a>  </div>
                            								</div>
                            							
                            							<!--</div>-->
										</div>
										
                                        <div class="tab-pane fade" id="vertical-left-tab3">
                                            	
												<div class="row">
												    <div class="d-sm-flex flex-sm-wrap mb-3">
                            									<div class="font-weight-semibold"><h4>Asset Barcode:</h4></div>
                            									<div ><h4><b>&nbsp;<code><?php echo $_POST['asset_code'];?></code></b></h4></div>
                            								</div>
								  <div class="col-lg-12 col-md-12 col-sm-12" >
								      <div  class="table-responsive table-scrollable">
                        			 <table class="table" >
                        						<thead>
                        							<tr>
                        							    <th width="5%">#</th>
                        							    <th width="20%">Work Order No.</th>
                        							   
                        							    <th width="25%">Services</th> 
                        							    <th width="20%">Service On</th>
                        							     
                        							    <th width="25%">Remarks</th>
                        							    <th width="5%">Audio</th>
                        							
                        							</tr>
                        						</thead>
                        						<tbody>
                        						    <?PHP 
                        	while($row_services=mysqli_fetch_assoc($result_service)) {
                        	    $i=$i+1;?>
      		   
                        						    <tr>
                        						        <td><?php echo $i;?></td>
                        						         <td><a href="../view/work_order_print.php?ticket_id=<?php echo $row_services['ticket_id'];?>" target="_BLANK"><?php echo 'WO-'.$row_services['ref'].'-'.$row_services['ticket_id'];?></a></td>
                        						        <td><?php echo $row_services['service_description'];?></td>
                        						        
                        						        <td><?php echo $row_services['service_complete_cancel_date_time'];?></td>
                        						       <td><?php echo $row_services['tech_remarks'];?></td>
                        						       	<td>
                									<?php if($row_services['tech_audio_file']=="NA" || $row_services['tech_audio_file']===NULL){} else {?>
                								<a href="../httpdocs/audios/<?php echo $row_services['tech_audio_file'];?>" target="_blank"><i class="icon-play3" ></i></a>	
                								<?PHP
                									}
                									?>
                									</td>
                        						    </tr>
                        						    <?php }?>
                        						</tbody>
                        						
                        				</table>
                        				</div>
							        </div>
								</div>

										</div>
										
									</div>
								</div>
							</div>
						</div>
					</div>

				
				</div>
   <?PHP    }
 }
 else
 { ?>
  
  	<div class="row">
					<div class="col-md-12">
						<div class="card">
							<div class="card-header header-elements-inline">
								<h6 class="card-title" style="color:red">Asset Details Not Found ...</h6>
								<div class="header-elements">
									
			                	</div>
							</div> 
	</div> 
 <?php }
 
	?>

 			

			
				<!-- /vertical tabs -->