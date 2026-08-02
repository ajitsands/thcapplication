
<?PHP
include(__DIR__ . '/../../model/db_connection/connection.php');

$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();

 	$result = mysqli_query($varDBConnection,"SELECT distinct(
GROUP_CONCAT( employee_name)) as Emp_name, GROUP_CONCAT( employee_id) as Emp_id,visit_id FROM  tbl_ticket_teams where ticket_team_status='Active' and visit_date = '".$_POST['start_date']."' GROUP BY visit_date");
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
			<div class="card-header header-elements-inline bg-success">
				<h6 class="card-title">
				<b></b>	<a data-toggle="collapse" class="text-white" href="#collapsible-item-nested-<?php echo $i;?>"><?PHP echo '#'.$i.' - Team :  '.$row['Emp_name']; ?></a></b>
				</h6>
					<div class="header-elements ">
										<div class="list-icons">
					                		<a href="../view/daily_reports/daily_team_tasks_print.php?start_date=<?php echo $_POST['start_date'];?>&Emp_id=<?php echo $row['Emp_id'];?>"  target="_blank" class="list-icons-item" data-action="fullscreen"></a>
					                		
					                	</div>
				                	</div>
			</div>

			<div id="collapsible-item-nested-<?php echo $i;?>" class="collapse ">
				<div class="card-body">
                <?php
               
                $result_entries = mysqli_query($varDBConnection,"SELECT ticket_ref_no,ticket_id,amc_ticket,visit_id FROM  tbl_ticket_teams where ticket_team_status='Active' and visit_date = '".$_POST['start_date']."' and employee_id in (".$row['Emp_id'].") GROUP BY ticket_ref_no");
                 $j=0;
                     while($row_entries=mysqli_fetch_assoc($result_entries)) { 
                    
           
                            $j=$j+1;
                ?>
					<!-- Child level -->
					<div class="card">
						<div class="card-header header-elements-inline bg-dark">
							<h6 class="card-title">
								<a data-toggle="collapse" class="text-white" href="#collapsible-item-nested-child1_<?php echo $j;?>"><?PHP echo '#'.$j.' Ref. No. : '.$row_entries['ticket_ref_no']; ?></a>
							</h6>
							<div class="header-elements">
										<div class="list-icons">
					                		<a href="../view/daily_reports/daily_team_report_print.php?start_date=<?php echo $_POST['start_date'];?>&Emp_id=<?php echo $row['Emp_id'];?>"  target="_blank" class="list-icons-item" data-action="fullscreen"></a>
					                		
					                	</div>
				                	</div>
						</div>

						<div id="collapsible-item-nested-child1_<?php echo $j;?>" class="collapse ">
							<div class="card-body">
								        
										<br>
										<div class="table-responsive table-scrollable">
                						<table class="table">
                							<thead>
                								<tr>
                										<th width="1%">#</th>
                									<th width="25%">Work Order No.</th>
                									<th  width="25%">Service</th>
                									
                									<th width="6%">Status</th>
                									<th width="15%">Service Start</th>
                									<th width="15%">Service End</th>
                										<th width="10%">Duration</th>
                									<th width="20%">Feedback</th>
                									<th width="2%">Audio</th>
                								</tr>
                							</thead>
                							<tbody>
                							    
                						
                							 
                							    
                						    
                							    
                							    
                							    
                							    
                							<?php 
                						
                // $result_entries = mysqli_query($varDBConnection,"select ticket_id,amc_ticket from   tbl_ticket_teams where   visit_date = '".$_POST['start_date']."' and employee_id in (".$row['Emp_id'].") and ticket_team_status='Active' group by ticket_id");
                //   while($row_entries=mysqli_fetch_assoc($result_entries)) { 
                      if($row_entries['amc_ticket']=='TKT')
                      {
                          	$result_services = mysqli_query($varDBConnection,"select  ticket_id,ticket_ref_code,service_description,tech_remarks,ticket_service_status,service_start_by_emp_code,service_complete_cancel_by_emp_code,tech_audio_file,DATE_FORMAT(service_start_date_time,'%d-%m-%Y %H:%i') as service_start_date_time1,DATE_FORMAT(service_complete_cancel_date_time,'%Y-%m-%d %H:%i') as service_complete_cancel_date_time1,FLOOR(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time) / 3600 / 24)as days_cnt,FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600 * 24) / 3600) as hrs_cnt,FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60) as min_ctr,MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60) as sec_ctr,CONCAT(FLOOR(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time) / 3600 / 24), ' Days. ',FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600 * 24) / 3600), ' Hrs. ',FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60), ' Min. ',MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60), ' Sec.') AS difference,CONCAT(FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600 * 24) / 3600), ' Hrs. ',FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60), ' Min. ',MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60), ' Sec.') AS difference_hrs,CONCAT(FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60), ' Min. ',MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60), ' Sec.') AS difference_mins from  tbl_ticket_services where  ticket_ref_code='".$row_entries['ticket_ref_no']."'");
                      }
                      else
                      {
                          	$result_services = mysqli_query($varDBConnection,"select amc_child_id as ticket_id, amc_ref_code as ticket_ref_code,service_description,tech_remarks,amc_service_status as ticket_service_status,service_start_by_emp_code,service_complete_cancel_by_emp_code,tech_audio_file,DATE_FORMAT(service_start_date_time,'%d-%m-%Y %H:%i') as service_start_date_time1,DATE_FORMAT(service_complete_cancel_date_time,'%Y-%m-%d %H:%i') as service_complete_cancel_date_time1,FLOOR(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time) / 3600 / 24)as days_cnt,FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600 * 24) / 3600) as hrs_cnt,FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60) as min_ctr,MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60) as sec_ctr,CONCAT(FLOOR(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time) / 3600 / 24), ' Days. ',FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600 * 24) / 3600), ' Hrs. ',FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60), ' Min. ',MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60), ' Sec.') AS difference,CONCAT(FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600 * 24) / 3600), ' Hrs. ',FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60), ' Min. ',MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60), ' Sec.') AS difference_hrs,CONCAT(FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60), ' Min. ',MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60), ' Sec.') AS difference_mins from  tbl_amc_services where  amc_ref_code='".$row_entries['ticket_ref_no']."'");
                      }
                						
                						
                		
                		$k=0;	
                						
                     while($row_services=mysqli_fetch_assoc($result_services)) {
                     $k=$k+1;
                     ?>
                							
                							<tr>
                									<td><?php echo $k;?></td>
                									<td><a href="../view/work_order_print.php?ticket_id=<?php echo $row_entries['ticket_id'];?>"  target="_blank"><?php echo 'WO-'.$row_services['ticket_ref_code'].'-'.$row_services['ticket_id'];?></a></td>
                										
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

					<!-- /child level -->
                    <?PHP
                       // }
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

 
 
 
 
 
 
 
 
 
