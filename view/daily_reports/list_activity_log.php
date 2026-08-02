
<?PHP
include(__DIR__ . '/../../model/db_connection/connection.php');

$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();
 	$result = mysqli_query($varDBConnection,"SELECT *,DATE_FORMAT(date_of_visits,'%d-%m-%Y') as visit_dates FROM  tbl_visits where amc_visit_status not in ('Cancelled') and date_of_visits= '".$_POST['start_date']."'");
 	
 $i=0;
 $j=0;
 	$num_rows = mysqli_num_rows($result);
 	if($num_rows>0)
 {
	?>

 <?PHP 	while($row=mysqli_fetch_assoc($result)) { 

 $i=$i+1;
 $start_slot=$row['time_of_visit'];
 $end_slot=$start_slot+$row['additional_slots'];
 
 if($row['amc_ticket']='TKT')
 {
     $result_status = mysqli_query($varDBConnection,"SELECT ticket_status FROM   tbl_tickets where ticket_id=".$row['amc_tkt_id']);
     while($row_status=mysqli_fetch_assoc($result_status)) {
         $wo_status=$row_status['ticket_status'];
     }
 }
 
 ?>
 
 	<div class="card">
			<div class="card-header header-elements-inline bg-dark">
				<h6 class="card-title">
				<b></b>	<a class="text-white" data-toggle="collapse" class="text-default" href="#collapsible-item-nested-<?php echo $i;?>"><?PHP echo '#'.$i.' - Work Order No. : WO-'.$row['amc_tkt_ref_no'].'-'.$row['amc_tkt_id'].'  , Customer : '.$row['customer_code'].'  '.$row['customer_name'].'  , Location : '.$row['location_name'].' , Building : '.$row['building_name']; ?></a></b>
				</h6>
				<div class="header-elements">
										<div class="list-icons">
					                	<?php echo $wo_status;?>&nbsp;&nbsp;	<a href="../view/work_order_print.php?ticket_id=<?php echo $row['amc_tkt_id'];?>"  target="_blank" class="list-icons-item" data-action="fullscreen"></a>
					                		
					                	</div>
				                	</div>
			</div>

			<div id="collapsible-item-nested-<?php echo $i;?>" class="collapse ">
				<div class="card-body">
               	        <div class="row">
							    	    
					       <div class="col-lg-4 col-md-4 col-sm-12" >
					           <div class="font-weight-semibold">Customer : <span class="text-primary"><?php echo $row['customer_code'].' : '.$row['customer_name'];?></span></div>
					       </div>
					       <div class="col-lg-4 col-md-4 col-sm-12" >
					           	<div class="font-weight-semibold">Location : <span class="text-primary"><?php echo $row['location_name'].' ('.$row['location_code'].')';?></span></div>
					       </div>
					       <div class="col-lg-4 col-md-4 col-sm-12" >
					           	<div class="font-weight-semibold">Building: <span class="text-primary"><?php echo $row['building_name'].' ('.$row['building_code'].')';?></span></div>
					       </div>
					       
					    <?php
					    if($row['amc_ticket']='TKT')
					    {
					     
					         $result_team = mysqli_query($varDBConnection,"SELECT GROUP_CONCAT(concat(employee_name,' (',employee_code,') ')) as team_members FROM  tbl_ticket_teams where ticket_team_status  in ('Active') and amc_ticket='TKT' and visit_id=".$row['amc_visit_id']." and ticket_id= ".$row['amc_tkt_id']);
					         
					    }
					    else
					    {
					      
					         $result_team = mysqli_query($varDBConnection,"SELECT GROUP_CONCAT(concat(employee_name,' (',employee_code,') ')) as team_members FROM  tbl_ticket_teams where ticket_team_status  in ('Active') and amc_ticket='AMC' and visit_id=".$row['amc_visit_id']." and ticket_id= ".$row['amc_tkt_id']);
					    }
					    while($row_team=mysqli_fetch_assoc($result_team)) { 
					        $team_list=$row_team['team_members'];
					    }
					    ?>
					       <div class="col-lg-4 col-md-4 col-sm-12" >
					           	<div class="font-weight-semibold">Team :<span class="text-primary"><?php echo $team_list;?></span></div>
					       </div>
					       <div class="col-lg-4 col-md-4 col-sm-12" >
					           		<div class="font-weight-semibold">Date & Time: <span class="text-primary"><?php echo $row['visit_dates'].'  '.$row['visit_start_time'];?></span></div>
					       </div>
					       <div class="col-lg-4 col-md-4 col-sm-12" >
					           		<div class="font-weight-semibold">Time Slots : <span class="text-primary"><?php for($se=$start_slot;$se<=$end_slot;$se++){echo $se.'     ';}?></span></div>
					       </div>
					        <?php
					    if($row['amc_ticket']='TKT')
					    {
					       
					         $result_team_attend = mysqli_query($varDBConnection,"SELECT GROUP_CONCAT(concat(employee_name,' (',employee_code,') ')) as team_members_attend FROM  tbl_ticket_teams where ticket_team_status  in ('Active') and amc_ticket='TKT' and visit_id=".$row['amc_visit_id']." and ticket_id= ".$row['amc_tkt_id']." and is_attend='Yes'");
					         
					    }
					    else
					    {
					         $result_team_attend = mysqli_query($varDBConnection,"SELECT GROUP_CONCAT(concat(employee_name,' (',employee_code,') ')) as team_members_attend FROM  tbl_ticket_teams where ticket_team_status  in ('Active') and amc_ticket='AMC' and visit_id=".$row['amc_visit_id']." and ticket_id= ".$row['amc_tkt_id']." and is_attend='Yes'");
					    }
					    while($row_team_attend=mysqli_fetch_assoc($result_team_attend)) { 
					        $team_list_attend=$row_team_attend['team_members_attend'];
					    }
					    ?>
					       <div class="col-lg-4 col-md-4 col-sm-12" >
					           	<div class="font-weight-semibold">Team Attend:<span class="text-primary"><?php echo $team_list_attend;?></span></div>
					       </div>
					   </div>
                            		<br>
										<div class="row"> 
        										<div class="col-lg-12 col-md-12 col-sm-12">
        										  	 <?php
        										  	 if($row['amc_ticket']='TKT')
                					    {
                					       
                					          $result_service_images = mysqli_query($varDBConnection,"select service_image_name from  tbl_service_images where amc_ticket='TKT' and  ticket_amc_id=".$row['amc_tkt_id']." and DATE_FORMAT(uploaded_date_time,'%Y-%m-%d')");
                					    }
                					    else
                					    {
                					          $result_service_images = mysqli_query($varDBConnection,"select service_image_name from  tbl_service_images where amc_ticket='AMC' and  ticket_amc_id=".$row['amc_tkt_id']." and DATE_FORMAT(uploaded_date_time,'%Y-%m-%d')");
                					    }
        										  	 
        										  	 
        										  	
                                        
                                       
                                         while($row_service_images=mysqli_fetch_assoc($result_service_images)) {
                                     
                                         ?>
										         <a href="../../httpdocs/images/service_images/<?php echo $row_service_images['service_image_name'];?>" target="_BLANK"><img src="../../httpdocs/images/service_images/<?php echo $row_service_images['service_image_name'];?>" class="rounded-circle" height="40px" width="40px"/> </a>   
										           <?PHP  }?> 
        										</div>
        								</div>
										<br><br>							
										<div class="table-responsive table-scrollable">
                						<table class="table">
                							<thead>
                								<tr>
                									<th width="2%">#</th>
                									<th  width="25%">Service</th>
                								
                									<th width="6%">Status</th>
                									<th width="15%">Service Start</th>
                									<th width="15%">Service End</th>
                									<th width="15%">Duration</th>
                										<th width="20%">Feedback</th>
                									<th width="2%">Audio</th>
                									
                								</tr>
                							</thead>
                							<tbody>
                							    
                						
                							 
                							    
                						    
                							    
                							    
                							    
                							    
                							<?php 
                							
                							   $j=0;
             // echo $row['amc_ticket'];
                                     if($row['amc_ticket']='TKT')
                					    {
                					      //  $sql1="select  ticket_ref_code,service_description,tech_remarks,ticket_service_status,service_start_by_emp_code,service_complete_cancel_by_emp_code,tech_audio_file,DATE_FORMAT(service_start_date_time,'%d-%m-%Y %H:%i') as service_start_date_time1,DATE_FORMAT(service_complete_cancel_date_time,'%d-%m-%Y %H:%i') as service_complete_cancel_date_time1,FLOOR(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time) / 3600 / 24)as days_cnt,FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600 * 24) / 3600) as hrs_cnt,FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60) as min_ctr,MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60) as sec_ctr,CONCAT(FLOOR(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time) / 3600 / 24), ' Days. ',FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600 * 24) / 3600), ' Hrs. ',FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60), ' Min. ',MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60), ' Sec.') AS difference,CONCAT(FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600 * 24) / 3600), ' Hrs. ',FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60), ' Min. ',MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60), ' Sec.') AS difference_hrs,CONCAT(FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60), ' Min. ',MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60), ' Sec.') AS difference_mins from  tbl_ticket_services where  ticket_id=".$row['amc_tkt_id']." and (DATE_FORMAT(service_start_date_time,'%Y-%m-%d')='".$_POST['start_date']."' or  DATE_FORMAT(service_complete_cancel_date_time,'%Y-%m-%d')='".$_POST['start_date']."')";
                					      $sql1="select  ticket_ref_code,service_description,tech_remarks,ticket_service_status,service_start_by_emp_code,service_complete_cancel_by_emp_code,tech_audio_file,DATE_FORMAT(service_start_date_time,'%d-%m-%Y %H:%i') as service_start_date_time1,DATE_FORMAT(service_complete_cancel_date_time,'%d-%m-%Y %H:%i') as service_complete_cancel_date_time1,FLOOR(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time) / 3600 / 24)as days_cnt,FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600 * 24) / 3600) as hrs_cnt,FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60) as min_ctr,MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60) as sec_ctr,CONCAT(FLOOR(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time) / 3600 / 24), ' Days. ',FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600 * 24) / 3600), ' Hrs. ',FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60), ' Min. ',MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60), ' Sec.') AS difference,CONCAT(FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600 * 24) / 3600), ' Hrs. ',FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60), ' Min. ',MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60), ' Sec.') AS difference_hrs,CONCAT(FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60), ' Min. ',MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60), ' Sec.') AS difference_mins from  tbl_ticket_services where  ticket_id in (select amc_tkt_id from tbl_visits where amc_ticket='TKT' and amc_visit_status not in ('Cancelled') and DATE_FORMAT(date_of_visits,'%Y-%m-%d')='".$_POST['start_date']."')";
                					        $result_services = mysqli_query($varDBConnection,$sql1);			
                					    }
                					    else
                					    {
                					        
                					       //$sql1="select  amc_ref_code as ticket_ref_code,service_description,tech_remarks,amc_service_status as ticket_service_status,service_start_by_emp_code,service_complete_cancel_by_emp_code,tech_audio_file,DATE_FORMAT(service_start_date_time,'%d-%m-%Y %H:%i') as service_start_date_time1,DATE_FORMAT(service_complete_cancel_date_time,'%d-%m-%Y %H:%i') as service_complete_cancel_date_time1,FLOOR(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time) / 3600 / 24)as days_cnt,FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600 * 24) / 3600) as hrs_cnt,FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60) as min_ctr,MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60) as sec_ctr,CONCAT(FLOOR(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time) / 3600 / 24), ' Days. ',FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600 * 24) / 3600), ' Hrs. ',FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60), ' Min. ',MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60), ' Sec.') AS difference,CONCAT(FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600 * 24) / 3600), ' Hrs. ',FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60), ' Min. ',MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60), ' Sec.') AS difference_hrs,CONCAT(FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60), ' Min. ',MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60), ' Sec.') AS difference_mins from  tbl_ticket_services where  ticket_id=".$row['amc_tkt_id']." and (DATE_FORMAT(service_start_date_time,'%Y-%m-%d')='".$_POST['start_date']."' or  DATE_FORMAT(service_complete_cancel_date_time,'%Y-%m-%d')='".$_POST['start_date']."')";
                					       $sql1="select  amc_ref_code as ticket_ref_code,service_description,tech_remarks,amc_service_status as ticket_service_status,service_start_by_emp_code,service_complete_cancel_by_emp_code,tech_audio_file,DATE_FORMAT(service_start_date_time,'%d-%m-%Y %H:%i') as service_start_date_time1,DATE_FORMAT(service_complete_cancel_date_time,'%d-%m-%Y %H:%i') as service_complete_cancel_date_time1,FLOOR(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time) / 3600 / 24)as days_cnt,FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600 * 24) / 3600) as hrs_cnt,FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60) as min_ctr,MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60) as sec_ctr,CONCAT(FLOOR(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time) / 3600 / 24), ' Days. ',FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600 * 24) / 3600), ' Hrs. ',FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60), ' Min. ',MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60), ' Sec.') AS difference,CONCAT(FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600 * 24) / 3600), ' Hrs. ',FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60), ' Min. ',MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60), ' Sec.') AS difference_hrs,CONCAT(FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60), ' Min. ',MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60), ' Sec.') AS difference_mins from  tbl_ticket_services where  ticket_id in (select amc_tkt_id from tbl_visits where amc_ticket='AMC' and amc_visit_status not in ('Cancelled') and DATE_FORMAT(date_of_visits,'%Y-%m-%d')='".$_POST['start_date']."')";
                					        $result_services = mysqli_query($varDBConnection,$sql2);
                					    }
                							
                					
                     while($row_services=mysqli_fetch_assoc($result_services)) {
                     $j=$j+1;
                     ?>
                							
                								<tr>
                									<td><?php echo $j;?></td>
                									
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

 
 
 
 
 
 
