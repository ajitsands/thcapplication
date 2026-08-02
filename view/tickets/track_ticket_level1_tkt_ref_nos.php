
<?PHP
include "../../model/db_connection/connection.php" ;

$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();

 	$result = mysqli_query($varDBConnection,"select *,DATE_FORMAT(date_of_visits, '%d-%m-%Y') as date_of_visits1 from  tbl_visits where   date_of_visits = '".$_POST['start_date']."' group by date_of_visits, amc_tkt_ref_no  order by date_of_visits asc");
 $i=0;
 $j=0;
 $k=0;
 $s=0;
 	$num_rows = mysqli_num_rows($result);
 	if($num_rows>0)
 {
	?>

 <?PHP 	while($row=mysqli_fetch_assoc($result)) { 

 $i=$i+1;
 ?>
 
 	<div class="card">
			<div class="card-header bg-success">
				<h6 class="card-title">
				<b></b>	<a data-toggle="collapse" class="text-white" href="#collapsible-item-nested-<?php echo $row['amc_tkt_ref_no'];?>"><?PHP echo '#'.$i.' - THC Ticket Ref. No. :  '.$row['amc_tkt_ref_no'].'  - Customer : '.$row['customer_name'].' ( '.$row['customer_code'].' )  ,- Loc. :  '.$row['location_name'].'  ,- Bldg. :  '.$row['building_name']; ?></a></b>
				</h6>
			</div>

			<div id="collapsible-item-nested-<?php echo $row['amc_tkt_ref_no'];?>" class="collapse ">
				<div class="card-body">
                <?php
               
                $result_entries = mysqli_query($varDBConnection,"select amc_tkt_id,amc_visit_id,amc_ticket from  tbl_visits where   date_of_visits = '".$_POST['start_date']."' and amc_tkt_ref_no='".$row['amc_tkt_ref_no']."'");
                 $j=0;
                     while($row_entries=mysqli_fetch_assoc($result_entries)) { 
                    
                   if($row_entries['amc_ticket']=='TKT')
                   {
                        $result_ticket_entries = mysqli_query($varDBConnection,"select ticket_id,category_name,type_name,asset_code,complaints_description,ticket_priority,service_request,job_category,'TKT' as amc_ticket from  tbl_tickets where  ticket_id=".$row_entries['amc_tkt_id']);
                   }
                   else
                   {
                        $result_ticket_entries = mysqli_query($varDBConnection,"select  amc_child_id as ticket_id,category_name,asset_type_name as type_name,asset_ref_no as asset_code,'AMC Visit' as complaints_description,'Normal' as ticket_priority,'Hard FM' as service_request,'PPM' as job_category,'AMC' as amc_ticket from  view_amc_asset_details where  amc_child_id=".$row_entries['amc_tkt_id']);
                   }
                   
                   
                   
                        while($row_ticket_entries=mysqli_fetch_assoc($result_ticket_entries)) { 
                            $j=$j+1;
                ?>
					<!-- Child level -->
					<div class="card">
						<div class="card-header header-elements-inline bg-dark">
							<h6 class="card-title">
								<a data-toggle="collapse" class="text-white" href="#collapsible-item-nested-child1_<?php echo $row_ticket_entries['ticket_id'];?>"><?PHP echo '#'.$j.' Work Order No. : WO-'.$row['amc_tkt_ref_no'].'-'.$row_ticket_entries['ticket_id'].' , - Category :  '.$row_ticket_entries['category_name'].' , - Type : '.$row_ticket_entries['type_name'].'   , - Asset :  '.$row_ticket_entries['asset_code']; ?></a>
							</h6>
							<div class="header-elements">
										<div class="list-icons">
					                		<a href="../view/work_order_print.php?ticket_id=<?php echo $row_ticket_entries['ticket_id'];?>"  target="_blank" class="list-icons-item" data-action="fullscreen"></a>
					                		
					                	</div>
				                	</div>
						</div>

						<div id="collapsible-item-nested-child1_<?php echo $row_ticket_entries['ticket_id'];?>" class="collapse ">
							<div class="card-body">
								        <div class="row"> 
        										<div class="col-lg-12 col-md-12 col-sm-12">
										<span class="form-text text-muted"><font color="purple">Request : </font><font color="black"><?php echo $row_ticket_entries['complaints_description'];?> &nbsp;</font></span>
										        </div>
										       
										</div>
									
                                         
                                    
									
										<div class="row"> 
        										<div class="col-lg-3 col-md-6 col-sm-12">
        										<span class="form-text text-muted"><font color="purple">Priority : </font><font color="black"><?php echo $row_ticket_entries['ticket_priority'];?> &nbsp;</font></span>  
        										</div>
        										<div class="col-lg-3 col-md-6 col-sm-12">
        										<span class="form-text text-muted"><font color="purple">Service Request : </font><font color="black"><?php echo $row_ticket_entries['service_request'];?> &nbsp;</font></span>  
        										</div>
        										<div class="col-lg-3 col-md-6 col-sm-12">
        										<span class="form-text text-muted"><font color="purple">Job Category : </font><font color="black"><?php echo $row_ticket_entries['job_category'];?> &nbsp;</font></span>  
        										</div>
        										<!--<div class="col-lg-3 col-md-6 col-sm-12">-->
        										<!--<span class="form-text text-muted"><font color="purple">Date & Slots: </font><font color="black"><?php echo $row_ticket_entries['job_category'];?> &nbsp;</font></span>  -->
        										<!--</div>-->
										</div>
										<br>
										<div class="row"> 
        										<div class="col-lg-12 col-md-12 col-sm-12">
        										  	 <?php
        										 $result_service_images= 	  mysqli_query($varDBConnection,"select service_image_name from  tbl_service_images where amc_ticket='".$row_ticket_entries['amc_ticket']."' and  ticket_amc_id=".$row_ticket_entries['ticket_id']);
                                        
                                       
                                         while($row_service_images=mysqli_fetch_assoc($result_service_images)) {
                                     
                                         ?>
										         <a href="../../httpdocs/images/service_images/<?php echo $row_service_images['service_image_name'];?>" target="_BLANK"><img src="../../httpdocs/images/service_images/<?php echo $row_service_images['service_image_name'];?>" class="rounded-circle" height="40px" width="40px"/> </a>   
										           <?PHP  }?> 
        										</div>
        								</div>
										<br>
										<div class="table-responsive table-scrollable">
                						<table class="table">
                							<thead>
                								<tr>
                									<th width="2%">#</th>
                									<th  width="25%">Service</th>
                								
                									<th width="6%">Status</th>
                									<th width="20%">Service Start</th>
                									<th width="20%">Service End</th>
                									<th width="10%">Duration</th>
                										<th width="25%">Feedback</th>
                									<th width="2%">Audio</th>
                									
                								</tr>
                							</thead>
                							<tbody>
                							    
                						
                							 
                							    
                						    
                							    
                							    
                							    
                							    
                							<?php 
                							if($row_ticket_entries['amc_ticket']=='TKT')
                							{
                							   	$result_services = mysqli_query($varDBConnection,"select service_description,ticket_service_status,tech_remarks,service_start_by_emp_code,service_complete_cancel_by_emp_code,tech_audio_file, DATE_FORMAT(service_start_date_time,'%d-%m-%Y %H:%i') as service_start_date_time1, DATE_FORMAT(service_complete_cancel_date_time,'%d-%m-%Y %H:%i') as service_complete_cancel_date_time1,FLOOR(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time) / 3600 / 24)as days_cnt,FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600 * 24) / 3600) as hrs_cnt,FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60) as min_ctr,MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60) as sec_ctr,CONCAT(FLOOR(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time) / 3600 / 24), ' Days. ',FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600 * 24) / 3600), ' Hrs. ',FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60), ' Min. ',MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60), ' Sec.') AS difference,CONCAT(FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600 * 24) / 3600), ' Hrs. ',FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60), ' Min. ',MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60), ' Sec.') AS difference_hrs,CONCAT(FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60), ' Min. ',MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60), ' Sec.') AS difference_mins from  tbl_ticket_services where  ticket_id=".$row_ticket_entries['ticket_id']); 
                							}
                							else
                							{
                							    	$result_services = mysqli_query($varDBConnection,"select service_description,amc_service_status as ticket_service_status,tech_remarks,service_start_by_emp_code,service_complete_cancel_by_emp_code,tech_audio_file, DATE_FORMAT(service_start_date_time,'%d-%m-%Y %H:%i') as service_start_date_time1, DATE_FORMAT(service_complete_cancel_date_time,'%d-%m-%Y %H:%i') as service_complete_cancel_date_time1, FLOOR(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time) / 3600 / 24)as days_cnt,FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600 * 24) / 3600) as hrs_cnt,FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60) as min_ctr,MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60) as sec_ctr,CONCAT(FLOOR(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time) / 3600 / 24), ' Days. ',FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600 * 24) / 3600), ' Hrs. ',FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60), ' Min. ',MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60), ' Sec.') AS difference,CONCAT(FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600 * 24) / 3600), ' Hrs. ',FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60), ' Min. ',MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60), ' Sec.') AS difference_hrs,CONCAT(FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60), ' Min. ',MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60), ' Sec.') AS difference_mins from  tbl_amc_services where  amc_child_id=".$row_ticket_entries['ticket_id']);
                							}
                							
                						
               $k=0;
                     while($row_services=mysqli_fetch_assoc($result_services)) {
                     $k=$k+1;
                     ?>
                							
                								<tr>
                									<td><?php echo $k;?></td>
                									<td><?php echo $row_services['service_description'];?></td>
                									
                									<?PHP switch($row_services['ticket_service_status'])
                									{
                									    case 'Pending': ?>
                									    <td ><span class="badge badge-warning"><?php echo $row_services['ticket_service_status'];?></span></td>
                									  <?PHP break;
                									  case 'Start': ?>
                									    <td><span class="badge badge-info"><?php echo $row_services['ticket_service_status'];?></span></td>
                									  <?PHP break;
                									  case 'Completed': ?>
                									    <td><span class="badge badge-success"><?php echo $row_services['ticket_service_status'];?></span></td>
                									  <?PHP break;
                									  case 'Cancelled': ?>
                									    <td><span class="badge badge-danger"><?php echo $row_services['ticket_service_status'];?></span></td>
                									  <?PHP break;
                									  default: ?>
                									    <td><span class="badge badge-secondary"><?php echo $row_services['ticket_service_status'];?></span></td>
                									  <?PHP break;
                									} 
                									?>
                								
                									<td>
                									<?php if($row_services['service_start_by_emp_code']!="NA" ){
                									
                									echo $row_services['service_start_date_time1'].'  by  '.$row_services['service_start_by_emp_code'];
                									}
                									?>
                									</td>
                									
                									<td>
                									<?php if($row_services['service_complete_cancel_by_emp_code']!="NA" ){
                									
                									echo $row_services['service_complete_cancel_date_time1'].'  by  '.$row_services['service_complete_cancel_by_emp_code'];
                									}
                									?>
                									</td>
                									<td>
                									<?php if($row_services['service_complete_cancel_by_emp_code']!="NA" && $row_services['service_start_by_emp_code']!="NA"){
                								if($row_services['days_cnt']!=0)
                								{
                								    echo $row_services['difference'];
                								}
                								else
                								{
                								    if($row_services['hrs_cnt']!=0)
                    								{
                    								    echo $row_services['difference_hrs'];
                    								} 
                    								else
                    								{
                    								     echo $row_services['difference_mins'];
                    								}
                								 }
                								
                									}
                									?>
                									</td>
                									<td><?php echo $row_services['tech_remarks'];?></td>
                									<td>
                									<?php if($row_services['tech_audio_file']=="NA" || $row_services['tech_audio_file']===NULL){} else {?>
                								<a href="../httpdocs/audios/<?php echo $row_services['tech_audio_file'];?>" target="_blank"><i class="icon-play3" ></i></a>	
                								<?PHP
                									}
                									?>
                									</td>
                							
                									    
                								</tr>
                							
                							<?PHP }?>
                							</tbody>
                						</table>
                					</div>
										
							</div>
						</div>
					</div>

					<!-- /child level -->
                    <?PHP
                        }
                    }?>
				</div>
			</div>
		</div>

	 <?PHP }//End of while
	 
 }
 else
 { ?>
  
  	<div class="row">
					<div class="col-md-12">
						<div class="card">
							<div class="card-header header-elements-inline">
								<h6 class="card-title" style="color:red">Sorry! No Data Found ...</h6>
								<div class="header-elements">
									
			                	</div>
							</div> 
	</div> 
 <?php }
 
	?>

 
 
 
 
 
 
 
 
 
