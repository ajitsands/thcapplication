<?PHP
include(__DIR__ . '/../model/db_connection/connection.php');
$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();
 //	$result = mysqli_query($varDBConnection,"select *,DATE_FORMAT(created_date_time,'%d-%m-%Y') as work_request_date,TIME_FORMAT(created_date_time,'%h:%i %p') as work_request_time,DATE_FORMAT(closed_on,'%d-%m-%Y') as date_delivered from tbl_tickets where ticket_id=".$_GET["ticket_id"]);
 		$result = mysqli_query($varDBConnection,"select *,DATE_FORMAT(created_date_time,'%d-%m-%Y') as work_request_date,TIME_FORMAT(created_date_time,'%h:%i %p') as work_request_time,DATE_FORMAT(closed_on,'%d-%m-%Y') as date_delivered, DATE_FORMAT(closed_on,'%d-%m-%Y %h:%i %p') as closed_date_time,DATE_FORMAT(service_report_upload_date_time,'%d-%m-%Y %h:%i %p') as service_report_upload_date_time,DATE_FORMAT(cancelled_date_time,'%d-%m-%Y') as cancelled_date from tbl_tickets where ticket_id=".$_GET["ticket_id"]);
 		
 		$result_services = mysqli_query($varDBConnection,"select * from tbl_ticket_services where ticket_service_status not in ('Pending','Processing','Cancelled') and ticket_id=".$_GET["ticket_id"]);
		
	
?>
<!doctype html>
<html>
<head><meta charset="us-ascii">
	<title>Work Order Form</title>
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
     <?PHP 	while($row=mysqli_fetch_assoc($result)) {
     $result_customer_details = mysqli_query($varDBConnection,"select * from tbl_customers where customer_id=".$row['customer_id']);
            while($row_customer_details=mysqli_fetch_assoc($result_customer_details)) {
     ?>
                                      
                                    
                                   
<table align="center" style="border: none;" width="800">
	<tbody>
		<tr style="border: none; ">
			<td style="border: none;" width="400">
			   <img src="global_assets/images/logo_print.png"  />
			</td>
			<td style="border: none; color: #daa505;text-align: right;font-weight:700;padding-right:20px;" width="400">
			 
			   
			   
			</td>
		</tr>
		<tr style="border: none;">
			<td style="border: none;"></td>
			<td style="text-align: right;border: none; font-size: 15px;font-weight: 700;padding-bottom: 30px;"><b>WORK ORDER FORM</b></td>
		</tr>
		<tr style="border: none;">
			<td style="border: none;"><?PHP echo 'WO-'.$row['ticket_ref_code'].'-'.$row['ticket_id']; ?></td>
			<td style="text-align: right;border: none;"><b>Work Request Date :</b> <?PHP echo $row['work_request_date']; ?></td>
		</tr>
	</tbody>
</table>

<table align="center" width="800">
	<tbody>
		<!--<tr>-->
		<!--	<td colspan="2" style="text-align: center"></td>-->
		<!--	<td colspan="2" style="text-align: center"></td>-->
		<!--</tr>-->
		<!--<tr>-->
		<!--	<td colspan="4" style="text-align: right"></td>-->
		<!--</tr>-->
		<!--<tr>-->
		<!--	<td colspan="2"></td>-->
		<!--	<td colspan="2" style="text-align: right"></td>-->
		<!--</tr>-->
		<tr>
			<td bgcolor="#2e2e79" colspan="4" style="color: #ffffff"><strong>INFORMATION</strong></td>
		</tr>
		<tr>
			<td width="158"><b>Date </b></td>
			<td width="255"><?PHP echo $row['work_request_date']; ?></td>
			<td style="text-align: left" width="170"><b>Time </b></td>
			<td style="text-align: left" width="217"><?php echo $row['work_request_time'];?></td>
		</tr>
		<tr>
			<td><b>Requester Name</b></td>
			<td><?PHP echo $row['customer_name']; ?></td>
			<td style="text-align: left"><b>Email</b></td>
			<td style="text-align: left"><?PHP echo $row_customer_details['customer_email_id']; ?></td>
		</tr>
		<tr>
			<td><b>Service Request</b></td>
			<td><input id="checkbox" name="checkbox" type="checkbox" <?php if($row['service_request']=='Hard FM') {?> checked <?php }  ?> disabled/> <label for="checkbox">Hard FM <input id="checkbox2" name="checkbox2" type="checkbox" <?php if($row['service_request']=='Soft FM') {?> checked <?php }  ?> disabled/> Soft FM </label> <input id="checkbox3" name="checkbox3" type="checkbox"  <?php if($row['service_request']=='Others') {?> checked <?php }  ?> disabled/> <label for="checkbox3">Others</label></td>
			<td style="text-align: left"><b>Category / Type</b></td>
			<td style="text-align: left"><?PHP echo $row['category_name'].' / '.$row['type_name']; ?></td>
		</tr>
		<tr>
			<td><b>Location / Building</b></td>
			<td><?PHP echo $row['location_name'].' / '.$row['building_name']; ?></td>
			<td style="text-align: left"><b>Asset</b></td>
			<td style="text-align: left"><?PHP if($row['asset_code']=='0') { echo $row['type_name'];} else { echo $row['type_name'].' / '.$row['asset_code']; }?></td>
		</tr>
		<tr>
			<td><b>Assigned By</b></td>
				<?php 
			$result_created_by = mysqli_query($varDBConnection,"select employee_name from tbl_employees where employee_id=".$row['created_by_id']);
			while($row_created_by=mysqli_fetch_assoc($result_created_by)) {
			?>
			<td><?php echo $row_created_by['employee_name'];?></td>
			<?php }?>
			<td style="text-align: left"><b>Technicians Assigned</b></td>
			<td style="text-align: left">
			<?php 
			$str_team='';
			$result_team = mysqli_query($varDBConnection,"select * from tbl_ticket_teams where ticket_team_status  in ('Active') and is_leader='Yes' and ticket_id=".$row['ticket_id']." order by ticket_team_ids asc limit 1");
				$result_team_all = mysqli_query($varDBConnection,"select * from tbl_ticket_teams where ticket_team_status  in ('Active') and ticket_id=".$row['ticket_id']." and is_attend='Yes' order by ticket_team_ids ");
    			while($row_team_all=mysqli_fetch_assoc($result_team_all)) {?>
    		<?php if($row_team_all['is_leader']=='Yes')
    			{
    			$str_team=$str_team.', '.$row_team_all['employee_name'].' (L)';
    			
    			}
    			else
    			{ 
    			
    			$str_team=$str_team.', '.$row_team_all['employee_name'];
    		     } 
    		     
    		     }
    		     
    		     echo ltrim($str_team,',') ;
    		     ?>
    			  </td>      
                	<?php	
    			    //if(mysqli_num_rows($result_team)!=0)
    			    //{
    			        //while($row_team=mysqli_fetch_assoc($result_team)) {
    			    ?>
    			        	<!--<td style="text-align: left"><?php //echo $row_team['employee_name'];?></td>-->
    			  <?php  //}
    			    //}
    			  //else { 
    			  //	while($row_team_all=mysqli_fetch_assoc($result_team_all)) {?>
    			        	<!--<td style="text-align: left"><?php //echo $row_team_all['employee_name'];?></td>-->
                	<?php	//}
        			//}
        			?>
    		
		</tr>
		<tr>
			<td><b>Job Category</b></td>
			<td style="align-items: center"><input id="checkbox4" name="checkbox4" type="checkbox" disabled <?php if($row['job_category']=='PPM') {?> checked <?php }  ?>/> <label for="checkbox4">PPM<br />
			<input id="checkbox5" name="checkbox5" type="checkbox" disabled <?php if($row['job_category']=='Reactive') {?> checked <?php }  ?>/> Reactive<br />
			<input id="checkbox6" name="checkbox6" type="checkbox"  disabled <?php if($row['job_category']=='Variable') {?> checked <?php }  ?>/> Variable</label></td>
			
			<td style="text-align: left"><b>Priority</b></td>
			<td style="text-align: left"><input id="checkbox7" name="checkbox7" type="checkbox" disabled <?php if($row['ticket_priority']=='Emergency') {?> checked <?php }  ?>/> Emergency ( 1 - 3 Hrs )<br />
			<input id="checkbox8" name="checkbox8" type="checkbox" disabled <?php if($row['ticket_priority']=='Urgent') {?> checked <?php }  ?>/> <label for="checkbox8">Urgent ( Within 24 Hrs )<br />
			<input id="checkbox10" name="checkbox10" type="checkbox" disabled <?php if($row['ticket_priority']=='Others' || $row['ticket_priority']=='Normal') {?> checked <?php }  ?>/> Normal ( 24 - 48 Hrs )</label></td>
		</tr>
			<tr>
			<td><b>Quote Required</b></td>
			<td><input id="checkbox11" name="checkbox11" type="checkbox" <?php if($row['quote_required']=='Yes') {?> checked <?php }  ?> disabled/> <label for="checkbox11">Yes <input id="checkbox12" name="checkbox12" type="checkbox" disabled <?php if($row['quote_required']=='No') {?> checked <?php }  ?>/> No</label></td>
			<td style="text-align: left"><b>Quotation Ref No.</b></td>
			<td style="text-align: left"><?php echo $row['quote_ref_no'];?></td>
		</tr>
		<tr>
			
			<td style="text-align: left"><b>Completed Date</b></td>
			<td style="text-align: left"><?php echo $row['date_delivered'];?></td>
		</tr>
		<!--<tr>-->
		<!--	<td>Date Needed</td>-->
		<!--	<td></td>-->
		<!--	<td style="text-align: left">Date Delivered</td>-->
		<!--	<td style="text-align: left"></td>-->
		<!--</tr>-->
		<!--<tr>-->
		<!--	<td></td>-->
		<!--	<td></td>-->
		<!--	<td style="text-align: left"></td>-->
		<!--	<td style="text-align: left"></td>-->
		<!--</tr>-->
	</tbody>
</table>

<p></p>

<table align="center" border="0" cellpadding="0" cellspacing="0" width="800">
	<tbody>
		<tr bgcolor="#2e2e79" style="color: #FFFFFF">
			<td style="color: #ffffff"><strong>Request Description</strong></td>
		</tr>
		<tr>
			<td>
			<p><?php if($row['complaints_description']==''){ echo 'NA';} else { echo $row['complaints_description'];}?></p>

			<p></p>
			</td>
		</tr>
	</tbody>
</table>

<p></p>

<p></p>

<table align="center" border="0" cellpadding="0" cellspacing="0" width="800">
	<tbody>
		<tr bgcolor="#2e2e79" style="color: #FFFFFF">
			<td style="color: #ffffff"><strong>Description of Work Completed
</strong></td>
		</tr>
		<tr>
			<td>
			     <?PHP 	
			     $ctrservice=1;
			     while($row_services=mysqli_fetch_assoc($result_services)) {?>
			<p><?php echo $ctrservice.' ) ';?><?php echo $row_services['service_description'];
			if(trim($row_services['tech_remarks'])!= '' && trim($row_services['tech_remarks'])!= 'NA' && $row_services['tech_remarks']!== null)
			{ ?><br><?php
			    echo " Remarks: ". $row_services['tech_remarks'];
			}
			?></p>
            <?php 
            $ctrservice=$ctrservice+1;
            }?>
			<p></p>
			</td>
		</tr>
	</tbody>
</table>

<p></p>

<p></p>

<table align="center" border="0" cellpadding="0" cellspacing="0" width="800">
	<tbody>
		<tr bgcolor="#2e2e79" style="color: #FFFFFF">
			<td style="color: #ffffff"><strong>Additional Comments / Suggestions</strong></td>
		</tr>
		<tr>
			<td>
			<p><?php if($row['ticket_status']=='Cancelled'){ echo $row['cancelled_reason'];} else { echo $row['closed_reason'];}  ?></p>

			<p></p>
			</td>
		</tr>
	</tbody>
</table>

<p></p>

<p></p>

<table align="center" border="0" cellpadding="0" cellspacing="0" width="800">
	<tbody>
		<tr>
			<td width="143">Service Report No.</td>
			<td width="184"><?php echo $row['service_report_no']; ?></td>
			<!--<td width="81">Signature</td>-->
			<!--<td width="200"></td>-->
			<td width="83">Date &amp; Time</td>
			<td width="107"><?php echo $row['service_report_upload_date_time']; ?></td>
		</tr>
		<?php if($row['ticket_status']=='Cancelled'){?>
		<tr>
			<td>Work Cancelled By</td>
			<td>	<?php 
			$result_cancelled_by = mysqli_query($varDBConnection,"select employee_name from tbl_employees where employee_id=".$row['cancelled_by_id']);
			while($row_cancelled_by=mysqli_fetch_assoc($result_cancelled_by)) {
			?>
			<?php echo $row_cancelled_by['employee_name'];?>
			<?php }?>
			</td>
			<!--<td>Signature</td>-->
			<!--<td></td>-->
			<td>Date &amp; Time</td>
			<td><?php echo $row['cancelled_date']; ?></td>
		</tr>
	<?php } else {?>
	<tr>
			<td>Work Closed By</td>
			<td>	<?php 
			$result_closed_by = mysqli_query($varDBConnection,"select employee_name from tbl_employees where employee_id=".$row['closed_by_id']);
			while($row_closed_by=mysqli_fetch_assoc($result_closed_by)) {
			?>
			<?php echo $row_closed_by['employee_name'];?>
			<?php }?>
			</td>
			<!--<td>Signature</td>-->
			<!--<td></td>-->
			<td>Date &amp; Time</td>
			<td><?php echo $row['closed_date_time']; ?></td>
		</tr>
	<?php }?>
		</tr>
		
	</tbody>

</table>
<p></p>
 <?PHP 
     }
 } ?>
<p></p>
<div class="divFooter">
	<table align="center" border="0" cellpadding="0" cellspacing="0" width="800" style="border: none; padding: 25px;" >
	    <tr style="border: none; background-color: #2e2e79; padding: 25px;">
			<td style="border: none;padding-left: 20px;color:white; font-size:11px;" width="500">
			   <p style="line-height: 1.8;"> <small>Tele:</small> +973 17 100 190 | info@thc.com.bh | <strong>www.thc.com.bh</strong><br >
			     CR. <strong>88982-1</strong> | Level 14, Enterance 143/144,  Bldg 155, Road 1703, Block 317<br>
			    <strong>YBA Kanoo Tower, Diplomatic Area</strong>, Kingdom of Bahrain
			    </p>
			</td>
			<td style="border: none;text-align: right;padding-right:20px;padding: 25px;" width="300">
			 
			    <img src="global_assets/images/a.png" />
			   
			</td>
		</tr>
	</table>
</div>
<p></p>

<p></p>
</body>
</html>