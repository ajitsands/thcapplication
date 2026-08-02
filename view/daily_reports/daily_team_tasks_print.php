<?PHP
include(__DIR__ . '/../../model/db_connection/connection.php');
$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();
  $result_entries = mysqli_query($varDBConnection,"select ticket_id,amc_ticket,ticket_ref_no,visit_id from   tbl_ticket_teams where   visit_date = '".$_GET['start_date']."' and ticket_team_ids in (".$_GET['ids'].") and ticket_team_status='Active' group by ticket_id");
                 
                     
?>
<!doctype html>
<html>
<head><meta charset="us-ascii">
	<title>Daily Team Tasks</title>
	<link href="https://fonts.googleapis.com" rel="preconnect" />
	<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
	<link href="https://fonts.googleapis.com/css2?family=Montserrat&amp;display=swap" rel="stylesheet" />
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
	
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
  
  #exportExcelButton {
    display: none; /* Hide the Excel button when printing */
  }
  
}
	</style>
</head>
<body>
    
    <div align="center" style="border: none; width: 1000px; margin: 0 auto;">
        <div style="border: none; display: flex; justify-content: space-between;">
            <div style="border: none;">
                <!-- Your content for the left side of the div goes here -->
            </div>
            <div style="border: none; color: #daa505; text-align: right; font-weight: 700; padding-right: 20px;">
                <button id="exportExcelButton" class="btn btn-success btn-sm" onclick="exportToExcel()">Export to Excel</button>
            </div>
        </div>
    </div>
                             
<table align="center" style="border: none;" width="1000" id="first_table">
	<tbody>
		<tr style="border: none; ">
				<td style="border: none;" width="400">
			    <img src="../global_assets/images/logo_print.png"  />
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
<table align="center" width="1000" id="second_table">
	<tbody>
		
		<tr>
			<td bgcolor="#2e2e79" colspan="4" style="color: #ffffff"><strong>TEAM DETAILS</strong></td>
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

<table align="center" border="0" cellpadding="0" cellspacing="0" width="1000" id="third_table">
	<tbody>
		<tr >
			<td bgcolor="#2e2e79" colspan="13" style="color: #ffffff"><strong>DAILY TASKS DETAILS</strong></td>
		</tr>
		<tr bgcolor="#C1C1C1">
		    <td width="80" style="text-align:center" ><b>SL.No. </b></td>
		    <td width="158" style="text-align:center"><b>WO.No. </b></td>
		    <td width="158" style="text-align:center" ><b>Customer </b></td>
		     <td width="158" style="text-align:center" ><b>Bldg./Loc. </b></td>
		    <td width="158" style="text-align:center"><b>Time Slot </b></td>
		    <td width="158" style="text-align:center"><b>Start Time </b></td>
		    <td width="158" style="text-align:center"><b>End Time </b></td>
		    <td width="158" style="text-align:center"><b>Duration </b></td>
		      <td width="200" style="text-align:center"><b>Job Description</b></td>
		       <td width="158" style="text-align:center"><b>Service</b></td>
		    <td width="200" style="text-align:center"><b>Status </b></td>
		    <td width="200" style="text-align:center"><b>Remarks </b></td>
		    <td width="158" style="text-align:center"><b>Service Report No. </b></td>
		</tr>
	
	<?php 
 while($row_entries=mysqli_fetch_assoc($result_entries)) { 
     	
                      if($row_entries['amc_ticket']=='TKT')
                      {
                          	$result_services = mysqli_query($varDBConnection,"select ticket_id, ticket_ref_code,service_description,tech_remarks,ticket_service_status,service_start_by_emp_code,service_complete_cancel_by_emp_code,tech_audio_file,DATE_FORMAT(service_start_date_time,'%d-%m-%Y %H:%i') as service_start_date_time1,DATE_FORMAT(service_start_date_time,'%H:%i:%s') as service_start_date_time2,DATE_FORMAT(service_complete_cancel_date_time,'%d-%m-%Y %H:%i') as service_complete_cancel_date_time1,DATE_FORMAT(service_complete_cancel_date_time,'%H:%i:%s') as service_complete_cancel_date_time2,FLOOR(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time) / 3600 / 24)as days_cnt,FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600 * 24) / 3600) as hrs_cnt,FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60) as min_ctr,MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60) as sec_ctr,CONCAT(FLOOR(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time) / 3600 / 24), ' Days. ',FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600 * 24) / 3600), ' Hrs. ',FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60), ' Min. ',MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60), ' Sec.') AS difference,CONCAT(FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600 * 24) / 3600), ' Hrs. ',FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60), ' Min. ',MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60), ' Sec.') AS difference_hrs,CONCAT(FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60), ' Min. ',MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60), ' Sec.') AS difference_mins from  tbl_ticket_services where  ticket_id=".$row_entries['ticket_id']);
                          	$result_job_description = mysqli_query($varDBConnection,"select  * from  tbl_tickets where  ticket_id=".$row_entries['ticket_id']);
                          		while($row_job_description=mysqli_fetch_assoc($result_job_description)) {
                                        $job_description=$row_job_description['complaints_description'];
                                        $service_report_no=$row_job_description['service_report_no'];
                                     }
                      }
                      else
                      {
                          	$result_services = mysqli_query($varDBConnection,"select amc_visit_id as ticket_id, amc_ref_code as ticket_ref_code,service_description,tech_remarks,amc_service_status as ticket_service_status,service_start_by_emp_code,service_complete_cancel_by_emp_code,tech_audio_file,DATE_FORMAT(service_start_date_time,'%d-%m-%Y %H:%i') as service_start_date_time1,DATE_FORMAT(service_start_date_time,'%H:%i') as service_start_date_time2,DATE_FORMAT(service_complete_cancel_date_time,'%d-%m-%Y %H:%i') as service_complete_cancel_date_time1,DATE_FORMAT(service_complete_cancel_date_time,'%H:%i') as service_complete_cancel_date_time2,FLOOR(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time) / 3600 / 24)as days_cnt,FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600 * 24) / 3600) as hrs_cnt,FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60) as min_ctr,MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60) as sec_ctr,CONCAT(FLOOR(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time) / 3600 / 24), ' Days. ',FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600 * 24) / 3600), ' Hrs. ',FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60), ' Min. ',MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60), ' Sec.') AS difference,CONCAT(FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600 * 24) / 3600), ' Hrs. ',FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60), ' Min. ',MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60), ' Sec.') AS difference_hrs,CONCAT(FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60), ' Min. ',MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60), ' Sec.') AS difference_mins from  tbl_amc_services where  amc_visit_id=".$row_entries['visit_id']);
                          	$result_job_description = mysqli_query($varDBConnection,"select  amc_description from  tbl_amc_master where  mc_ref_no=".$row_entries['amc_ref_code']);
                          		while($row_job_description=mysqli_fetch_assoc($result_job_description)) {
                                        $job_description=$row_job_description['amc_description'];
                                        $service_report_no='';
                                     }
                          
                      }
                						
            

	while($row_services=mysqli_fetch_assoc($result_services)) {
                    
                    
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
                			<td style="text-align:center;"><?php echo $j;?></td>
                			<td ><?php if($row_entries['amc_ticket']=='AMC'){echo 'WO-'.$row_details['ticket_ref_code'].'-'.$row_entries['visit_id'];} else {echo 'WO-'.$row_details['ticket_ref_code'].'-'.$row_details['ticket_id'];} ?></td>
                			<td ><?php echo $row_details['customer_name'];?></td>
                			<td ><?php echo $row_details['building_name'].', '.$row_details['location_name'];?></td>
                		
                									
                										<td  >
                								
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
                                            			             $strslot.='9 PM, ';
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
                                            			            $strslot.=$i.' AM - ';
                                            			        break;
                                            			    }
                                            			   
                                            			}
                                            			$strslot1 = rtrim($strslot, ' -');
                                            		echo $strslot1; }?></td>
                                            	
                											

                     						
                										<td >
                									<?php if($row_services['service_start_by_emp_code']!="NA" ){
                										echo $row_services['service_start_date_time2'];
                						
                									}
                									?>
                									</td>
                									
                									<td>
                									<?php if($row_services['service_complete_cancel_by_emp_code']!="NA" ){
                									echo $row_services['service_complete_cancel_date_time2'];
                								
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
                								<td><?php  echo $job_description;?></td>
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
                								
                								
                									<td><?php echo $row_services['tech_remarks'];?></td>
                								   	<td><?php if($row_entries['amc_ticket']=='TKT'){ echo  $service_report_no;} else { echo '';}?></td> 
                								</tr>
                								
                								
                								<?php }
                								
                	 ?>

              <?php }// close of row_building_details
              ?>
           
               <?php }// close of row_details
 }	// close of row_entries					
     ?>           		
         		
                										
                										
                										
                						
 
	</tbody>
	
</table>



<p></p>



<p></p>


<p></p>

<p></p>


<table align="center" border="0" cellpadding="0" cellspacing="0" width="1000" id="fourth_table">
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
	    <tr style="border: none; background-color: #2e2e79; padding: 25px;">
			<td style="border: none;padding-left: 20px;color:white;" width="500">
			    <small>Tele:</small> +973 17 100 190 | info@thc.com.bh | <strong>www.thc.com.bh</strong><br>
			     CR. <strong>88982-1</strong> | Level 14, Enterance 143/144,  Bldg 155, Road 1703, Block 317<br>
			    <strong>YBA Kanoo Tower, Diplomatic Area</strong>, Kingdom of Bahrain
			</td>
			<td style="border: none;text-align: right;padding-right:20px;padding: 25px;" width="300">
			 
			    <img src="../global_assets/images/a.png" />
			   
			</td>
		</tr>
	</table>
</div>
<p></p>

<p></p>

<script>
     function exportToExcel() {
         
        var filename = "Daily Team Report.xls";
        var tab_text = "<table border='2px' ><tr bgcolor='#FFFFFF' style='border-bottom: 1px solid #FFFFFF;'>";
    
        // Get all tables in the document
        var tables = document.getElementsByTagName('table');
    
        for (var k = 0; k < tables.length; k++) {
            var table = tables[k];
    
            for (var j = 0; j < table.rows.length; j++) {
                tab_text = tab_text + "<tr>" + table.rows[j].innerHTML + "</tr>";
            }
        }
    
        tab_text = tab_text + "</table>";
        tab_text = tab_text.replace(/<A[^>]*>|<\/A>/g, "");
        tab_text = tab_text.replace(/<input[^>]*>|<\/input>/gi, "");
    
        var ua = window.navigator.userAgent;
        var msie = ua.indexOf("MSIE");
    
        if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./)) {
            txtArea1.document.open("txt/html", "replace");
            txtArea1.document.write(tab_text);
            txtArea1.document.close();
            txtArea1.focus();
            sa = txtArea1.document.execCommand("SaveAs", true, "work_order.xlsx");
        } else {
            var link = document.createElement('a');
            link.href = 'data:application/vnd.ms-excel,' + encodeURIComponent(tab_text);
            link.download = filename;
            link.click();
            return link;
        }
    }
</script>

</body>
</html>