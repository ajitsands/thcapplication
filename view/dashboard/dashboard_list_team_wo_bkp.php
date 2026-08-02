
<?PHP
include "../../model/db_connection/connection.php" ;

$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();
?>
	<div class="table-responsive">
								<table class="table text-nowrap">
									<thead>
										<tr>
											<th class="w-70">Team</th>
											<th align="center" >Total WOs</th>
											<th align="center">Completed WOs</th>
											<th align="center">Closed WOs</th>
											
											<th align="center" style="color:red">Pending WOs</th>
										</tr>
									</thead>
									<tbody>
									    
									    
		<?php	

 
									$result = mysqli_query($varDBConnection,"SELECT  distinct(GROUP_CONCAT( distinct(employee_id) ORDER BY employee_id ASC)) as Emp_id FROM  tbl_ticket_teams where ticket_team_status='Active' and (visit_date >= '".$_POST['start_date']."' and visit_date <='".$_POST['end_date']."' or ticket_id in (select ticket_id from tbl_tickets where DATE_FORMAT(closed_on, '%Y-%m-%d')>= '".$_POST['start_date']."' and DATE_FORMAT(closed_on, '%Y-%m-%d') <='".$_POST['end_date']."' and ticket_status='Closed' )) group by `ticket_ref_no` ");
				    		
				    	
                        while($row=mysqli_fetch_assoc($result)) { 
                             $result_name = mysqli_query($varDBConnection,"SELECT  distinct(GROUP_CONCAT( distinct(employee_name))) as Emp_name FROM  tbl_ticket_teams where employee_id in (".$row['Emp_id'].")");
                         while($row_name=mysqli_fetch_assoc($result_name)) {
                          $emp_names= $row_name['Emp_name'];
                         }
                         $eds='';
                        
                           $j=0;     
                 	$result1 = mysqli_query($varDBConnection,"SELECT GROUP_CONCAT(ticket_id) as team_ids,GROUP_CONCAT(employee_id ORDER BY employee_id ASC) as e_ids FROM `tbl_ticket_teams` WHERE ticket_team_status='Active'  and (visit_date >= '".$_POST['start_date']."' and visit_date <='".$_POST['end_date']."' or ticket_id in (select ticket_id from tbl_tickets where DATE_FORMAT(closed_on, '%Y-%m-%d')>= '".$_POST['start_date']."' and DATE_FORMAT(closed_on, '%Y-%m-%d') <='".$_POST['end_date']."' and ticket_status='Closed' )) group by `ticket_ref_no` ");
                 	while($row1=mysqli_fetch_assoc($result1)) {
                 	 
                             if ($row['Emp_id']== $row1['e_ids'])
                             {
                                 $eds=$eds.$row1['team_ids'].',';
                                 
                             }
                             
                         }
                        
                          $eds=rtrim($eds, ",");
                    
                  	$result_raised = mysqli_query($varDBConnection,"SELECT count(ticket_id) as ct_r FROM `tbl_tickets` WHERE  ticket_status not in ('Opened','Cancelled') and ticket_id in (".$eds.")    ");
                 	while($row_ctraised=mysqli_fetch_assoc($result_raised)) {
                 	 
                               $ct_r=$row_ctraised['ct_r'];
                            
                             
                         } 
                         $result_completed = mysqli_query($varDBConnection,"SELECT count(ticket_id) as ct_com FROM `tbl_tickets` WHERE  ticket_status  in ('Completed') and ticket_id in  (".$eds.")  ");
                 	while($row_ctcom=mysqli_fetch_assoc($result_completed)) {
                 	 
                               $ct_com=$row_ctcom['ct_com'];
                            
                             
                         } 
                          $result_closed = mysqli_query($varDBConnection,"SELECT count(ticket_id) as ct_clo FROM `tbl_tickets` WHERE  ticket_status  in ('Closed') and ticket_id in  (".$eds.")   ");
                 	while($row_ctclo=mysqli_fetch_assoc($result_closed)) {
                 	 
                               $ct_clo=$row_ctclo['ct_clo'];
                            
                             
                         } 
                         	$result_pending = mysqli_query($varDBConnection,"SELECT count(ticket_id) as ct_pen FROM `tbl_tickets` WHERE  ticket_status not in ('Opened','Cancelled','Completed','Closed') and ticket_id in (".$eds.")    ");
                 	while($row_ctrpend=mysqli_fetch_assoc($result_pending)) {
                 	 
                               $ct_pen=$row_ctrpend['ct_pen'];
                            
                             
                         } 
                        ?>	    
										<tr>
											<td>
												<div class="d-flex align-items-center">
												
													<div>
														<a href="#" class="text-default font-weight-semibold letter-icon-title"><?php echo $emp_names;?></a>
														
													</div>
												</div>
											</td>
										<td align="center">
												<h6 class="font-weight-semibold mb-0"><?php echo $ct_r;?></h6>
											</td>
											<td align="center">
												<h6 class="font-weight-semibold mb-0"><?php echo $ct_com;?></h6>
											</td>
											<td align="center">
												<h6 class="font-weight-semibold mb-0"><?php echo $ct_clo;?></h6>
											</td>
												
												<td align="center" style="color:red">
												<h6 class="font-weight-semibold mb-0;"><?php echo $ct_pen;?></h6>
											</td>
										</tr>
<?php }

?>
										
									</tbody>
								</table>
							</div>