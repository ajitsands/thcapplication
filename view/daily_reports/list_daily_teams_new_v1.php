
<?PHP
include(__DIR__ . '/../../model/db_connection/connection.php');

$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();

$result_date = mysqli_query($varDBConnection,"SELECT visit_date,DATE_FORMAT(visit_date, '%d-%M-%Y') as visit_date_new FROM  tbl_ticket_teams where ticket_team_status='Active' and visit_date >= '".$_POST['start_date']."' and visit_date <='".$_POST['end_date']."' group by visit_date ");

 	
 $i=0;
 $j=0;
 $k=0;
 $s=0;
  $dsl=0;
 	$num_rows = mysqli_num_rows($result_date);
 	if($num_rows>0)
 {
	?>

 <?PHP 	while($row_date=mysqli_fetch_assoc($result_date)) { 

 $dsl=$dsl+1;
 
 ?>
 <div class="card">
			<div class="card-header header-elements-inline">
				<h6 class="card-title">
					<a data-toggle="collapse" href="#collapsible-item-nested-date-<?php echo $dsl;?>"><?PHP echo $row_date['visit_date_new']; ?></a>
				</h6>
					<div class="header-elements ">
							<div class="list-icons">
		                		<a data-toggle="tooltip" data-placement="bottom" title="Print Team List" href="../view/daily_reports/daily_team_tasks_print_date.php?start_date=<?php echo $row_date['visit_date'];?>"  target="_blank" class="list-icons-item" data-action="fullscreen" ></a>
		                		
		                	</div>
					</div>
			</div>
			<div id="collapsible-item-nested-date-<?php echo $dsl;?>" class="collapse ">
				<div class="card-body">
				    <?PHP 	
				    
				    	$result = mysqli_query($varDBConnection,"SELECT  distinct(GROUP_CONCAT( distinct(employee_id) ORDER BY employee_id ASC)) as Emp_id FROM  tbl_ticket_teams where ticket_team_status='Active' and visit_date = '".$row_date['visit_date']."' group by ticket_ref_no  ");
				    		
				    	
                        while($row=mysqli_fetch_assoc($result)) { 
                        
                        
                         
                         $result_name = mysqli_query($varDBConnection,"SELECT  distinct(GROUP_CONCAT( distinct(employee_name))) as Emp_name FROM  tbl_ticket_teams where ticket_team_status='Active' and visit_date = '".$row_date['visit_date']."' and employee_id in (".$row['Emp_id'].")");
                         while($row_name=mysqli_fetch_assoc($result_name)) {
                          $emp_names= $row_name['Emp_name'];
                         }
                         $eds='';
                         $i=rand(10,100);
                  	$result1 = mysqli_query($varDBConnection,"SELECT GROUP_CONCAT(ticket_team_ids) as team_ids,GROUP_CONCAT(employee_id ORDER BY employee_id ASC) as e_ids FROM `tbl_ticket_teams` WHERE `visit_date`='".$row_date['visit_date']."' and ticket_team_status='Active' group by `ticket_ref_no` ");
                  	while($row1=mysqli_fetch_assoc($result1)) {
                  	 
                              if ($row['Emp_id']== $row1['e_ids'])
                              {
                                  $eds=$eds.$row1['team_ids'].',';
                                  
                              }
                              
                          }
                        
                          $eds=rtrim($eds, ",");
                          
                           
 ?>
 
 	<div class="card">
			<div class="card-header header-elements-inline">
				<h6 class="card-title">
					<a data-toggle="collapse" href="#collapsible-item-nested-<?php echo $dsl.'-'.$i;?>"><?PHP echo 'Team :  '.$emp_names; ?></a>
				</h6>
					<div class="header-elements ">
										<div class="list-icons">
					                		<a data-toggle="tooltip" data-placement="bottom" title="Print Daily Team Report" href="../view/daily_reports/daily_team_tasks_print.php?start_date=<?php echo $row_date['visit_date'];?>&Emp_id=<?php echo $row['Emp_id'];?>&ids=<?php echo $eds;?>"  target="_blank" class="list-icons-item" data-action="fullscreen"></a>
					                		
					                	</div>
				                	</div>
			</div>

			<div id="collapsible-item-nested-<?php echo $dsl.'-'.$i;?>" class="collapse ">
				<div class="card-body">
                <?php
              
                $result_entries = mysqli_query($varDBConnection,"SELECT ticket_ref_no,ticket_id,amc_ticket,visit_id FROM  tbl_ticket_teams where ticket_team_status='Active' and visit_date = '".$row_date['visit_date']."' and ticket_team_ids in (".$eds.") group by ticket_id");
                 $j=0;
                     while($row_entries=mysqli_fetch_assoc($result_entries)) { 
                    
          $j= rand(101,1000);
                           // $j=$j+1;
                ?>
					<!-- Child level -->
					<div class="card">
						<div class="card-header header-elements-inline">
							<h6 class="card-title">
								<a data-toggle="collapse" href="#collapsible-item-nested-child1_<?php echo $j.'-'.$i;?>">
								<?PHP if($row_entries['ticket_id']=='AMC')
								{ echo 'WO-'.$row_entries['ticket_ref_no'].'-'.$row_entries['visit_id'];} else{ echo 'WO-'.$row_entries['ticket_ref_no'].'-'.$row_entries['ticket_id'];}
							 ?></a>
							</h6>
							<div class="header-elements">
										<div class="list-icons">
					                		<a href="../view/daily_reports/daily_team_report_print.php?start_date=<?php echo $row_date['visit_date'];?>&Emp_id=<?php echo $row['Emp_id'];?>&ids=<?php echo $eds;?>"  target="_blank" class="list-icons-item" data-action="fullscreen"></a>
					                		
					                	</div>
				                	</div>
						</div>

						<div id="collapsible-item-nested-child1_<?php echo $j.'-'.$i;?>" class="collapse ">
						    
							<div class="card-body">
								       <div class="table-responsive table-scrollable">
                						<table class="table">
                							<thead style="background-color: lightgray;">
                								<tr>
                									
                									<th >Customer</th>
                									<th  >Bldg./Loc.</th>
                									<th >Address</th>
                									<th >Contact Point</th>
                									<th >WO.No.</th>
                									<th >Slots</th>
                									<th >Details</th>
                									<th >Asset/Addln.Info.</th>
                									<th >Job Status</th>
                								</tr>
                							</thead>
            							    <tbody>
            							        
            							        <?php 
            							      
            	$result_entries_sub = mysqli_query($varDBConnection,"select ticket_id,amc_ticket,ticket_ref_no from   tbl_ticket_teams where   visit_date = '".$row_date['visit_date']."' and employee_id in (".$row['Emp_id'].")  and ticket_ref_no='".$row_entries['ticket_ref_no']."'  and ticket_id='".$row_entries['ticket_id']."' and ticket_team_status='Active' group by ticket_id,amc_ticket");
                while($row_entries_sub=mysqli_fetch_assoc($result_entries_sub)) { 
                      if($row_entries_sub['amc_ticket']=='TKT')
                      {
                          	$result_details = mysqli_query($varDBConnection,"select ticket_id,ticket_ref_code,customer_code,customer_name,location_name,building_name,customer_id,asset_code,complaints_description,category_name,type_name,location_id,building_id,additional_info from   tbl_tickets where  ticket_id=".$row_entries_sub['ticket_id']);
                          
                      }
                      else
                      {
                          $asset_ids = 0;
                          $result_assets = mysqli_query($varDBConnection,"select asset_id from    tbl_amc_child where  amc_child_id=".$row_entries_sub['ticket_id']);
                            if($result_assets) {
                                while($row_assets=mysqli_fetch_assoc($result_assets))   {
                                            $asset_ids=$row_assets['asset_id'];
                                        }
                            }
                         $result_details = mysqli_query($varDBConnection,"select ".$row_entries_sub['ticket_id']." as ticket_id,'".$row_entries_sub['ticket_ref_no']."' as ticket_ref_code,customer_code,customer_name,asset_location as location_name,asset_building as building_name,customer_id,asset_ref_no as asset_code,'AMC-PPM' as complaints_description,asset_category_name as category_name,asset_type_name as type_name,location_id,building_id,'' as additional_info from   tbl_assets where  asset_id=".$asset_ids);
                         
                      }
                      
            	while($row_details=mysqli_fetch_assoc($result_details)) {
	        $result_building_details = mysqli_query($varDBConnection,"select building_address,contact_person_name,contact_person_no from   tbl_customer_location where   customer_id=".$row_details['customer_id']." and location_id=".$row_details['location_id']." and building_id=".$row_details['building_id']."");
	      
                    // $j=$j+1;
                     while($row_building_details=mysqli_fetch_assoc($result_building_details)) { ?>
                             <tr>
                		
                			<td><?php echo $row_details['customer_name'];?></td>
                			<td><?php echo $row_details['building_name'].', '.$row_details['location_name'];?></td>
                		    <td><?php echo $row_building_details['building_address'];?></td>
                				<td><?php echo $row_building_details['contact_person_name'].', '.$row_building_details['contact_person_no'];?></td>
                									<td><?php if($row_entries_sub['amc_ticket']=='AMC'){echo 'WO-'.$row_details['ticket_ref_code'].'-'.$row_entries['visit_id'];} else {echo 'WO-'.$row_details['ticket_ref_code'].'-'.$row_details['ticket_id'];} ?></td>
                										<td>
                								<?php if($row_entries_sub['amc_ticket']=='AMC'){	 
                								    $result_slots = mysqli_query($varDBConnection,"select visit_date,visit_time,additional_slots from    tbl_ticket_teams where   ticket_id=".$row_details['ticket_id']." and amc_ticket='AMC' and ticket_team_status='Active' and visit_date = '".$row_date['visit_date']."' group by visit_id");
                								}
                								else
                								{
                								    $result_slots = mysqli_query($varDBConnection,"select visit_date,visit_time,additional_slots from    tbl_ticket_teams where   ticket_id=".$row_details['ticket_id']." and amc_ticket='TKT' and ticket_team_status='Active' and visit_date = '".$row_date['visit_date']."' group by visit_id");
                								}
                								while($row_slots=mysqli_fetch_assoc($result_slots)) {
                							 $visit_date=$row_slots['visit_date'];
                                         $start_slot=$row_slots['visit_time'];
                                         $add_slots=$row_slots['additional_slots'];
                                            			$strslot="";
                                            		
                                            			for($i=intval($start_slot);$i<=intval($start_slot)+intval($add_slots);$i++)
                                            			{
                                            			    switch($i)
                                            			    {
                                            			     
                                            			        case '12':
                                            			             $strslot.='12 Noon - ';
                                            			        break;
                                            			        case '13':
                                            			             $strslot.='1 PM - ';
                                            			        break;
                                            			        case '14':
                                            			             $strslot.='2 PM - ';
                                            			        break;
                                            			        case '15':
                                            			             $strslot.='3 PM - ';
                                            			        break;
                                            			        case '16':
                                            			             $strslot.='4 PM - ';
                                            			        break;
                                            			        case '17':
                                            			             $strslot.='5 PM - ';
                                            			        break;
                                            			        case '18':
                                            			             $strslot.='6 PM - ';
                                            			        break;
                                            			         case '19':
                                            			             $strslot.='7 PM - ';
                                            			        break;
                                            			         case '20':
                                            			             $strslot.='8 PM - ';
                                            			        break;
                                            			         case '21':
                                            			             $strslot.='9 PM - ';
                                            			        break;
                                            			         case '22':
                                            			             $strslot.='10 PM - ';
                                            			        break;
                                            			         case '23':
                                            			             $strslot.='11 PM - ';
                                            			        break;
                                            			         case '24':
                                            			             $strslot.='12 PM - ';
                                            			        break;
                                            			        case $i<=11:
                                            			            $strslot.=$i.' AM, ';
                                            			        break;
                                            			    }
                                            			   
                                            			}
                                            			$strslot1 = rtrim($strslot, ' -');
                                            		echo $strslot1; }?></td>
                                            	
                									<td><?php echo isset($row_details['complaints_description']) ? $row_details['complaints_description'] : '';?></td>
                										<td><?php echo (isset($row_details['asset_code']) ? $row_details['asset_code'] : '') . ((isset($row_details['additional_info']) && $row_details['additional_info'] != '') ? ' - '.$row_details['additional_info'] : '');?></td>
                								<td><?php echo (isset($row_details['category_name']) ? $row_details['category_name'] : '') . ' - ' . (isset($row_details['type_name']) ? $row_details['type_name'] : '');?></td>
                								</tr>       			
                  
                                              <?php }// close of row_building_details
                                              ?>
                                             
                                               <?php }// close of row_details
                                                }	// close of row_entries_sub					
                                                 ?>       						
                                 
                                	</tbody>
            							   
            							    </table>
            							     <div class="card-body">
										
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
                						
                
                      if($row_entries['amc_ticket']=='TKT')
                      {
                          	$result_services = mysqli_query($varDBConnection,"select  ticket_id,ticket_ref_code,service_description,tech_remarks,ticket_service_status,service_start_by_emp_code,service_complete_cancel_by_emp_code,tech_audio_file,DATE_FORMAT(service_start_date_time,'%d-%m-%Y %H:%i') as service_start_date_time1,DATE_FORMAT(service_complete_cancel_date_time,'%d-%m-%Y %H:%i') as service_complete_cancel_date_time1,FLOOR(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time) / 3600 / 24)as days_cnt,FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600 * 24) / 3600) as hrs_cnt,FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60) as min_ctr,MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60) as sec_ctr,CONCAT(FLOOR(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time) / 3600 / 24), ' Days. ',FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600 * 24) / 3600), ' Hrs. ',FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60), ' Min. ',MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60), ' Sec.') AS difference,CONCAT(FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600 * 24) / 3600), ' Hrs. ',FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60), ' Min. ',MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60), ' Sec.') AS difference_hrs,CONCAT(FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60), ' Min. ',MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60), ' Sec.') AS difference_mins from  tbl_ticket_services where  ticket_id='".$row_entries['ticket_id']."'");
                      }
                      else
                      {
                          	$result_services = mysqli_query($varDBConnection,"select visit_id as ticket_id, amc_ref_code as ticket_ref_code,service_description,tech_remarks,amc_service_status as ticket_service_status,service_start_by_emp_code,service_complete_cancel_by_emp_code,tech_audio_file,DATE_FORMAT(service_start_date_time,'%d-%m-%Y %H:%i') as service_start_date_time1,DATE_FORMAT(service_complete_cancel_date_time,'%d-%m-%Y %H:%i') as service_complete_cancel_date_time1,FLOOR(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time) / 3600 / 24)as days_cnt,FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600 * 24) / 3600) as hrs_cnt,FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60) as min_ctr,MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60) as sec_ctr,CONCAT(FLOOR(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time) / 3600 / 24), ' Days. ',FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600 * 24) / 3600), ' Hrs. ',FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60), ' Min. ',MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60), ' Sec.') AS difference,CONCAT(FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600 * 24) / 3600), ' Hrs. ',FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60), ' Min. ',MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60), ' Sec.') AS difference_hrs,CONCAT(FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60), ' Min. ',MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60), ' Sec.') AS difference_mins from  tbl_amc_services where  amc_visit_id='".$row_entries['visit_id']."'");
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
        	 ?>
        				    
             	</div>  
             </div>
        </div>
	
	
    
 <?PHP 
    }//End of while date
	 
 }//End of If
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

 
 
 
 
 
 
 
 
 
