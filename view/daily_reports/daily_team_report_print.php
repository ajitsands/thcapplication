<?PHP
include "../../model/db_connection/connection.php" ;
$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();
  $result_entries = mysqli_query($varDBConnection,"select ticket_id,amc_ticket ,ticket_ref_no,visit_id from   tbl_ticket_teams where   visit_date = '".$_GET['start_date']."' and  ticket_team_ids in (".$_GET['ids'].") and ticket_team_status='Active' group by ticket_id");
                 
?>
<!doctype html>
<html>
<head><meta charset="us-ascii">
	<title>Daily Team Report</title>
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
			<td width="255"> <?PHP echo date("d-m-Y",strtotime($_GET['start_date']));  ?> </td>
			
		
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
			<td bgcolor="#2e2e79" colspan="9" style="color: #ffffff"><strong>DAILY TASKS DETAILS</strong></td>
		</tr>
		<tr bgcolor="#C1C1C1">
		    <td width="80" style="text-align:center"><b>SL.No. </b></td>
		    <td width="158" style="text-align:center"><b>WO.No. </b></td>
		    <td width="225" style="text-align:center"><b>Tasks </b></td>
		    <td width="158" style="text-align:center"><b>Status </b></td>
		    <td width="158" style="text-align:center"><b>Service Start </b></td>
		    <td width="158" style="text-align:center"><b>Service End </b></td>
		    <td width="158" style="text-align:center"><b>Duration </b></td>
		    <td width="158" style="text-align:center"><b>Remarks </b></td>
		    <td width="158" style="text-align:center"><b>Service Report No. </b></td>
		</tr>
	<?php 
	 while($row_entries=mysqli_fetch_assoc($result_entries)) { 
                      if($row_entries['amc_ticket']=='TKT')
                      {
                          	$result_services = mysqli_query($varDBConnection,"select  ticket_id,ticket_ref_code,service_description,tech_remarks,ticket_service_status,service_start_by_emp_code,service_complete_cancel_by_emp_code,tech_audio_file,DATE_FORMAT(service_start_date_time,'%d-%m-%Y %H:%i') as service_start_date_time1,DATE_FORMAT(service_complete_cancel_date_time,'%Y-%m-%d %H:%i') as service_complete_cancel_date_time1,FLOOR(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time) / 3600 / 24)as days_cnt,FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600 * 24) / 3600) as hrs_cnt,FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60) as min_ctr,MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60) as sec_ctr,CONCAT(FLOOR(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time) / 3600 / 24), ' Days. ',FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600 * 24) / 3600), ' Hrs. ',FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60), ' Min. ',MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60), ' Sec.') AS difference,CONCAT(FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600 * 24) / 3600), ' Hrs. ',FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60), ' Min. ',MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60), ' Sec.') AS difference_hrs,CONCAT(FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60), ' Min. ',MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60), ' Sec.') AS difference_mins from  tbl_ticket_services where  ticket_id=".$row_entries['ticket_id']);
                          		$result_job_description = mysqli_query($varDBConnection,"select  * from  tbl_tickets where  ticket_id=".$row_entries['ticket_id']);
                          		while($row_job_description=mysqli_fetch_assoc($result_job_description)) {
                                        $job_description=$row_job_description['complaints_description'];
                                        $service_report_no=$row_job_description['service_report_no'];
                                     }
                      }
                      else
                      {
                          	$result_services = mysqli_query($varDBConnection,"select  amc_visit_id as ticket_id, amc_ref_code as ticket_ref_code,service_description,tech_remarks,amc_service_status as ticket_service_status,service_start_by_emp_code,service_complete_cancel_by_emp_code,tech_audio_file,DATE_FORMAT(service_start_date_time,'%d-%m-%Y %H:%i') as service_start_date_time1,DATE_FORMAT(service_complete_cancel_date_time,'%Y-%m-%d %H:%i') as service_complete_cancel_date_time1,FLOOR(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time) / 3600 / 24)as days_cnt,FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600 * 24) / 3600) as hrs_cnt,FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60) as min_ctr,MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60) as sec_ctr,CONCAT(FLOOR(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time) / 3600 / 24), ' Days. ',FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600 * 24) / 3600), ' Hrs. ',FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60), ' Min. ',MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60), ' Sec.') AS difference,CONCAT(FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600 * 24) / 3600), ' Hrs. ',FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60), ' Min. ',MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60), ' Sec.') AS difference_hrs,CONCAT(FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60), ' Min. ',MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60), ' Sec.') AS difference_mins from  tbl_amc_services where  amc_visit_id=".$row_entries['visit_id']);
                          
                      }
                						
                						
                		
                			
             
                    
                     
	
	
	
	
	while($row_services=mysqli_fetch_assoc($result_services)) {
                     $j=$j+1;
                     ?>
                     	<tr>
                									<td width="80" style="text-align:center"><?php echo $j;?></td>
                									
                									<td><?php echo 'WO-'.$row_services['ticket_ref_code'].'-'.$row_services['ticket_id'];?></td>
                										
                									<td><?php if($row_entries['amc_ticket']=='TKT'){ echo $row_services['service_description'];} else { echo $row_services['service_description'];}?></td>
                									
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
                									<td><?php if($row_entries['amc_ticket']=='TKT'){ echo  $service_report_no;} else { echo '';}?></td>
                								    
                								</tr>
                								<?php }
                								
                								}?>
	</tbody>
	
</table>

<p></p>

<p></p>

<!--<table align="center" border="0" cellpadding="0" cellspacing="0" width="1000">-->
<!--	<tbody>-->
<!--			<tr >-->
<!--			<td bgcolor="#1b2441" colspan="4" style="color: #daa505"><strong>DAILY TASKS DETAILS</strong></td>-->
<!--		</tr>-->
<!--		<tr>-->
<!--		    <td width="158"><b>SL.No. </b></td>-->
<!--		    <td width="158"><b>WO.No. </b></td>-->
<!--		    <td width="158"><b>Material Req.Ref.No. </b></td>-->
<!--		    <td width="158"><b>Request Date </b></td>-->
<!--		</tr>-->
	
<!--	</tbody>-->
<!--</table>-->

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