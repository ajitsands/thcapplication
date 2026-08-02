<?PHP
include "../../model/db_connection/connection.php" ;

$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();
 
 ?>
	<div class="row"> 
        										<div class="col-lg-12 col-md-12 col-sm-12">
        										  	 <?php $result_service_images = mysqli_query($varDBConnection,"select service_image_name from  tbl_service_images where amc_ticket='TKT' and  ticket_amc_id=".$_POST['ticket_id']);
                                        
                                       
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
                									<th width="25%">Feedback</th>
                									<th width="6%">Status</th>
                									<th width="20%">Start Date & Time</th>
                									<th width="20%">End Date & Time</th>
                									<th width="2%">Audio</th>
                									
                								</tr>
                							</thead>
                							<tbody>
                							    
                						
                							 
                							    
                						    
                							    
                							    
                							    
                							    
                							<?php $result_services = mysqli_query($varDBConnection,"select *, DATE_FORMAT(service_start_date_time,'%d-%m-%Y %H:%i') as service_start_date_time1, DATE_FORMAT(service_complete_cancel_date_time,'%d-%m-%Y %H:%i') as service_complete_cancel_date_time1 from  tbl_ticket_services where  ticket_id=".$_POST['ticket_id']);
               $k=0;
                     while($row_services=mysqli_fetch_assoc($result_services)) {
                     $k=$k+1;
                     ?>
                							
                								<tr>
                									<td><?php echo $k;?></td>
                									<td><?php echo $row_services['service_description'];?></td>
                									<td><?php echo $row_services['tech_remarks'];?></td>
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