<?PHP
include(__DIR__ . '/../../model/db_connection/connection.php');
$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();
  $result_entries = mysqli_query($varDBConnection,"select ticket_id,amc_ticket,ticket_ref_no,visit_id from   tbl_ticket_teams where   visit_date = '".$_GET['start_date']."' and employee_id in (".$_GET['Emp_id'].") and ticket_team_status='Active' group by ticket_id");
                 
                     
?>
<!doctype html>
<html>
<head><meta charset="us-ascii">
	<title>Daily Team Tasks</title>
	<link href="https://fonts.googleapis.com" rel="preconnect" />
	<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
	<link href="https://fonts.googleapis.com/css2?family=Montserrat&amp;display=swap" rel="stylesheet" />
	<style type="text/css">body,td,th {
    font-family:  'Montserrat', sans-serif;
    font-style: normal;
    font-size: 12px;
    color: #000000;
    
}

table, th, td {
    border: 1px solid #4E4E4E;
    border-collapse: collapse;
    padding: 5px;
}

@media print {
  div.divFooter {
    position: fixed;
    bottom: 0;
  }
	</style>
</head>
<body>
                             
<table align="center" style="border: none;" width="1000">
	<tbody>
		<tr style="border: none; ">
			<td style="border: none;" width="400">
			    <img src="../global_assets/images/backgrounds/thc_logo.png" height="100" width="100" />
			</td>
			<td style="border: none; color: #daa505;text-align: right;font-weight:700;padding-right:20px;" width="400">
			 
			   
			   
			</td>
		</tr>
	
		<tr style="border: none;">
			<td style="border: none;font-size: 15px;font-weight: 700;"><b>DAILY TEAM REPORT</b></td>
			<td style="text-align: right;border: none;"><b>Date & Time:</b> <?PHP date_default_timezone_set('Asia/Bahrain'); echo date("d-m-Y H:i:s");  ?></td>
		</tr>
	</tbody>
</table>
<?php
                  $result_cn = mysqli_query($varDBConnection,"select distinct(GROUP_CONCAT(employee_contact_no)) as employee_contact_no,GROUP_CONCAT(employee_name) as Emp_name from   tbl_employees where   employee_id in (".$_GET['Emp_id'].")");
                  while($row_cn=mysqli_fetch_assoc($result_cn)) {
                      $Emp_name=$row_cn['Emp_name'];
                     
                       $employee_contact_no=$row_cn['employee_contact_no'];
                  }
                      ?>
<table align="center" width="1000">
	<tbody>
		
		<tr>
			<td bgcolor="#1b2441" colspan="4" style="color: #daa505"><strong>TEAM DETAILS</strong></td>
		</tr>
		<tr>
			<td width="158"><b>Date </b></td>
			<td width="255"><?PHP echo date("d-m-Y",strtotime($_GET['start_date']));  ?></td>
		
		</tr>
	
		<tr>
			<td><b>Team Members</b></td>
			
			<td colspan="3"><?PHP echo $Emp_name; ?></td>
	
		</tr>
			<tr>
			<td><b>Contact Numbers</b></td>
			<td colspan="3"><?PHP echo $employee_contact_no; ?></td>
		
		</tr>
	
	</tbody>
</table>

<p></p>

<table align="center" border="0" cellpadding="0" cellspacing="0" width="1000">
	<tbody>
		<tr >
			<td bgcolor="#1b2441" colspan="10" style="color: #daa505"><strong>DAILY TASKS DETAILS</strong></td>
		</tr>
		<tr>
		    <td width="158" style="text-align:center"><b>SL.No. </b></td>
		    <td width="158" style="text-align:center"><b>Customer </b></td>
		     <td width="158" style="text-align:center"><b>Bldg./Loc. </b></td>
		     <td width="158" style="text-align:center"><b>Address </b></td>
		      <td width="158" style="text-align:center"><b>Contact Point </b></td>
		    <td width="158" style="text-align:center"><b>WO.No. </b></td>
		    <td width="158" style="text-align:center"><b>Slots </b></td>
		      <td width="158" style="text-align:center"><b>Details </b></td>
		      <td width="158" style="text-align:center"><b>Asset/Addln.Info.</b></td>
		    <td width="225" style="text-align:center"><b>Job Status </b></td>
		</tr>
	<?php 
 while($row_entries=mysqli_fetch_assoc($result_entries)) { 
                      if($row_entries['amc_ticket']=='TKT')
                      {
                          	$result_details = mysqli_query($varDBConnection,"select ticket_id,ticket_ref_code,customer_code,customer_name,location_name,building_name,customer_id,category_name,asset_code,complaints_description,category_name,type_name,location_id,building_id,additional_info,asset_code from   tbl_tickets where  ticket_id=".$row_entries['ticket_id']);
                          
                      }
                      else
                      {
                            $result_assets = mysqli_query($varDBConnection,"select asset_id from    tbl_amc_child where  amc_child_id=".$row_entries['ticket_id']);
                            while($row_assets=mysqli_fetch_assoc($result_assets))   {
                                        $asset_ids=$row_assets['asset_id'];
                                    }
                         $result_details = mysqli_query($varDBConnection,"select ".$row_entries['ticket_id']." as ticket_id,'".$row_entries['ticket_ref_no']."' as ticket_ref_code,customer_code,customer_name,asset_location as location_name,asset_building as building_name,customer_id,asset_ref_no as asset_code,'AMC-PPM' as complaints_description,asset_category_name as category_name,asset_type_name as type_name,location_id,building_id,'' as additional_info from   tbl_assets where  asset_id=".$asset_ids);
                      }
                      
            	while($row_details=mysqli_fetch_assoc($result_details)) {
	        $result_building_details = mysqli_query($varDBConnection,"select building_address,contact_person_name,contact_person_no from   tbl_customer_location where   customer_id=".$row_details['customer_id']." and location_id=".$row_details['location_id']." and building_id=".$row_details['building_id']."");
	      
                     $j=$j+1;
                     while($row_building_details=mysqli_fetch_assoc($result_building_details)) { ?>
                             <tr>
                			<td style="text-align:center"><?php echo $j;?></td>
                			<td><?php echo $row_details['customer_name'];?></td>
                			<td><?php echo $row_details['building_name'].', '.$row_details['location_name'];?></td>
                		    <td><?php echo $row_building_details['building_address'];?></td>
                				<td><?php echo $row_building_details['contact_person_name'].', '.$row_building_details['contact_person_no'];?></td>
                									<td><?php if($row_entries['amc_ticket']=='AMC'){echo 'WO-'.$row_details['ticket_ref_code'].'-'.$row_entries['visit_id'];} else {echo 'WO-'.$row_details['ticket_ref_code'].'-'.$row_details['ticket_id'];} ?></td>
                										<td>
                								
                								<?php if($row_entries['amc_ticket']=='AMC'){	 
                								    $result_slots = mysqli_query($varDBConnection,"select visit_date,visit_time,additional_slots from    tbl_ticket_teams where   ticket_id=".$row_details['ticket_id']." and amc_ticket='AMC' and ticket_team_status='Active' and visit_date = '".$_GET['start_date']."' group by visit_id");
                								}
                								else
                								{
                								   	$result_slots = mysqli_query($varDBConnection,"select visit_date,visit_time,additional_slots from    tbl_ticket_teams where   ticket_id=".$row_details['ticket_id']." and amc_ticket='TKT' and ticket_team_status='Active' and visit_date = '".$_GET['start_date']."' group by visit_id");
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
                                            			             $strslot.='12 Noon, ';
                                            			        break;
                                            			        case '13':
                                            			             $strslot.='1 PM, ';
                                            			        break;
                                            			        case '14':
                                            			             $strslot.='2 PM, ';
                                            			        break;
                                            			        case '15':
                                            			             $strslot.='3 PM, ';
                                            			        break;
                                            			        case '16':
                                            			             $strslot.='4 PM, ';
                                            			        break;
                                            			        case '17':
                                            			             $strslot.='5 PM, ';
                                            			        break;
                                            			        case '18':
                                            			             $strslot.='6 PM, ';
                                            			        break;
                                            			         case '19':
                                            			             $strslot.='7 PM, ';
                                            			        break;
                                            			         case '20':
                                            			             $strslot.='8 PM, ';
                                            			        break;
                                            			         case '21':
                                            			             $strslot.='9 PM, ';
                                            			        break;
                                            			         case '22':
                                            			             $strslot.='10 PM, ';
                                            			        break;
                                            			         case '23':
                                            			             $strslot.='11 PM, ';
                                            			        break;
                                            			         case '24':
                                            			             $strslot.='12 PM, ';
                                            			        break;
                                            			        case $i<=11:
                                            			            $strslot.=$i.' AM, ';
                                            			        break;
                                            			    }
                                            			   
                                            			}
                                            			$strslot1 = rtrim($strslot, ' ,');
                                            		echo $strslot1; }?></td>
                                            	
                									<td><?php echo $row_entries['complaints_description'];?></td>
                										<td><?php echo $row_entries['asset_code'].' - '.$row_entries['additional_info'];?></td>
                								<td><?php echo $row_details['category_name'].' - '.$row_details['type_name'];?></td>
                								</tr>       			
                   
              <?php }// close of row_building_details
              ?>
             
               <?php }// close of row_details
 }	// close of row_entries					
     ?>           		
         		
                										
                										
                										
                						
 
	</tbody>
	
</table>



<p></p>


<table align="center" border="0" cellpadding="0" cellspacing="0" width="1000">
	<tbody>
		<tr >
			<td bgcolor="#1b2441" colspan="8" style="color: #daa505"><strong>DAILY SERVICE DETAILS</strong></td>
		</tr>
		<tr>
		   
		    <td width="158" style="text-align:center"><b>WO.No. </b></td>
		    <td width="225" style="text-align:center"><b>Tasks </b></td>
		    <td width="158" style="text-align:center"><b>Status </b></td>
		    <td width="158" style="text-align:center"><b>Service Start </b></td>
		    <td width="158" style="text-align:center"><b>Service End </b></td>
		    <td width="158" style="text-align:center"><b>Duration </b></td>
		    <td width="158" style="text-align:center"><b>Remarks </b></td>
		</tr>
	<?php 
	
	 $result_entries1 = mysqli_query($varDBConnection,"select ticket_id,amc_ticket,visit_id from   tbl_ticket_teams where   visit_date = '".$_GET['start_date']."' and employee_id in (".$_GET['Emp_id'].") and ticket_team_status='Active' group by ticket_id");
	
	 while($row_entries1=mysqli_fetch_assoc($result_entries1)) { 
                      if($row_entries1['amc_ticket']=='TKT')
                      {
                          	$result_services = mysqli_query($varDBConnection,"select ticket_id, ticket_ref_code,service_description,tech_remarks,ticket_service_status,service_start_by_emp_code,service_complete_cancel_by_emp_code,tech_audio_file,DATE_FORMAT(service_start_date_time,'%d-%m-%Y %H:%i') as service_start_date_time1,DATE_FORMAT(service_complete_cancel_date_time,'%Y-%m-%d %H:%i') as service_complete_cancel_date_time1,FLOOR(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time) / 3600 / 24)as days_cnt,FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600 * 24) / 3600) as hrs_cnt,FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60) as min_ctr,MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60) as sec_ctr,CONCAT(FLOOR(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time) / 3600 / 24), ' Days. ',FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600 * 24) / 3600), ' Hrs. ',FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60), ' Min. ',MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60), ' Sec.') AS difference,CONCAT(FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600 * 24) / 3600), ' Hrs. ',FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60), ' Min. ',MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60), ' Sec.') AS difference_hrs,CONCAT(FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60), ' Min. ',MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60), ' Sec.') AS difference_mins from  tbl_ticket_services where  ticket_id=".$row_entries1['ticket_id']);
                      }
                      else
                      {
                          	$result_services = mysqli_query($varDBConnection,"select amc_visit_id as ticket_id, amc_ref_code as ticket_ref_code,service_description,tech_remarks,amc_service_status as ticket_service_status,service_start_by_emp_code,service_complete_cancel_by_emp_code,tech_audio_file,DATE_FORMAT(service_start_date_time,'%d-%m-%Y %H:%i') as service_start_date_time1,DATE_FORMAT(service_complete_cancel_date_time,'%Y-%m-%d %H:%i') as service_complete_cancel_date_time1,FLOOR(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time) / 3600 / 24)as days_cnt,FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600 * 24) / 3600) as hrs_cnt,FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60) as min_ctr,MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60) as sec_ctr,CONCAT(FLOOR(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time) / 3600 / 24), ' Days. ',FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600 * 24) / 3600), ' Hrs. ',FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60), ' Min. ',MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60), ' Sec.') AS difference,CONCAT(FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600 * 24) / 3600), ' Hrs. ',FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60), ' Min. ',MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60), ' Sec.') AS difference_hrs,CONCAT(FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60), ' Min. ',MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60), ' Sec.') AS difference_mins from  tbl_amc_services where  amc_visit_id=".$row_entries1['visit_id']);
                          
                      }
                						
                						
                		
                			
                						
                    
                     
	
	
	

	while($row_services=mysqli_fetch_assoc($result_services)) {
                    
                     ?>
                     	<tr>
                								
                									<td><?php echo 'WO-'.$row_services['ticket_ref_code'].'-'.$row_services['ticket_id'];?></td>
                										
                									<td><?php echo $row_services['service_description'];?></td>
                									
                									<?PHP switch($row_services['ticket_service_status'])
                									{
                									    case 'Pending': ?>
                									    <td style="text-align:center"><span style="color:orange"><?php echo $row_services['ticket_service_status'];?></span></td>
                									  <?PHP break;
                									  case 'Start': ?>
                									    <td style="text-align:center"><span tyle="color:blue"><?php echo $row_services['ticket_service_status'];?></span></td>
                									  <?PHP break;
                									  case 'Completed': ?>
                									    <td style="text-align:center"><span tyle="color:green"><?php echo $row_services['ticket_service_status'];?></span></td>
                									  <?PHP break;
                									  case 'Cancelled': ?>
                									    <td style="text-align:center"><span tyle="color:red"><?php echo $row_services['ticket_service_status'];?></span></td>
                									  <?PHP break;
                									  default: ?>
                									    <td style="text-align:center"><span tyle="color:brown"><?php echo $row_services['ticket_service_status'];?></span></td>
                									  <?PHP break;
                									} 
                									?>
                								
                									<td >
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
                								    
                								</tr>
                								<?php }
                								
                								}?>
	</tbody>
	
</table>

<p></p>


<p></p>

<p></p>


<table align="center" border="0" cellpadding="0" cellspacing="0" width="1000">
	<tbody>
		<tr>
			<td width="143"><b>Supervisor</b></td>
			<td width="184"></td>
			<td width="143"><b>Operation Coordinator</b></td>
			<td width="184"></td>
		
		</tr>
	
	
	</tbody>

</table>
<p></p>

<p></p>
<div class="divFooter">
	<table align="center" border="0" cellpadding="0" cellspacing="0" width="1000" style="border: none; padding: 25px;" >
	    <tr style="border: none; background-color: #f9df5c; padding: 25px;">
			<td style="border: none;padding-left: 20px;" width="400">
			    C.R. 88982-1, Bldg 155, Road 1703, Block 317<br>
			    Entrance 144, Diplomatic Area, Kingdom of Bahrain
			</td>
			<td style="border: none;text-align: right;padding-right:20px;padding: 25px;" width="400">
			 
			   Tele: <strong>+973 17 100 190</strong> Fax: +973 77 226 060<br>
			   info@thc.com.bh <strong>www.thc.com.bh</strong>
			   
			</td>
		</tr>
	</table>
</div>
<p></p>

<p></p>
</body>
</html>