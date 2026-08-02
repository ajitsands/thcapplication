<?PHP
include(__DIR__ . '/../model/db_connection/connection.php');
$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();
 //	$result = mysqli_query($varDBConnection,"select *,DATE_FORMAT(created_date_time,'%d-%m-%Y') as work_request_date,TIME_FORMAT(created_date_time,'%h:%i %p') as work_request_time,DATE_FORMAT(closed_on,'%d-%m-%Y') as date_delivered from tbl_tickets where ticket_id=".$_GET["ticket_id"]);
 		// $result = mysqli_query($varDBConnection,"select *,DATE_FORMAT(created_date_time,'%d-%m-%Y') as work_request_date,TIME_FORMAT(created_date_time,'%h:%i %p') as work_request_time,DATE_FORMAT(closed_on,'%d-%m-%Y') as date_delivered, DATE_FORMAT(closed_on,'%d-%m-%Y %h:%i %p') as closed_date_time,DATE_FORMAT(service_report_upload_date_time,'%d-%m-%Y %h:%i %p') as service_report_upload_date_time from tbl_tickets where ticket_id=".$_GET["ticket_id"]);
 		
 		// $result_services = mysqli_query($varDBConnection,"select * from tbl_ticket_services where ticket_service_status not in ('Pending','Processing','Cancelled') and ticket_id=".$_GET["ticket_id"]);
	$amc_ref_no = $_GET["v_amc_ref_no"];	
	$result_amc_details = mysqli_query($varDBConnection,"select * from tbl_amc_master where amc_ref_no='".$_GET["v_amc_ref_no"]."' ");
		
	 while($row_amc_details=mysqli_fetch_assoc($result_amc_details)) {
		$customer_name = $row_amc_details['customer_name'];
		$contract_type_name = $row_amc_details['contract_type_name'];
		$amc_signed_date = $row_amc_details['amc_signed_date'];
		$amc_start_date = $row_amc_details['amc_start_date'];
		$amc_end_date = $row_amc_details['amc_end_date']; 
		$amc_amount = $row_amc_details['amc_amount'];
		$amc_vat_perct = $row_amc_details['amc_vat_perct'];
		$amc_vat_amt = $row_amc_details['amc_vat_amt'];
		$amc_description = $row_amc_details['amc_description']; 
		$amc_status = $row_amc_details['amc_status'];
		$is_rfp = $row_amc_details['is_rfp'];
		$hold_description = $row_amc_details['hold_description'];
		$cancelled_on = $row_amc_details['cancelled_on'];
		$cancelled_description = $row_amc_details['cancelled_description'];
	 }
	
?>
<!doctype html>
<html>
<head><meta charset="us-ascii">
	<title>AMC Form</title>
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
                             
<table align="center" style="border: none;" width="800">
	<tbody>
		<tr style="border: none; ">
			<td style="border: none;" width="400">
			    <img src="global_assets/images/logo_print.png"  />
			</td>
			<td style="border: none; color: #daa505;text-align: right;font-weight:700;padding-right:20px;" width="400">
			 
			   
			   
			</td>
		</tr>
		<!--<tr style="border: none;">
			<td style="border: none;"></td>
			<td style="text-align: right;border: none; font-size: 15px;font-weight: 700;padding-bottom: 30px;"><b>AMC</b></td>
		</tr>-->
		<!--<tr style="border: none;">
			<td style="border: none; margin-top:20px;"><?PHP //echo $amc_ref_no ; ?></td>
			<td style="text-align: right;border: none;"><b>Work Request Date :</b></td>
		</tr>-->
		<tr style="border: none;">
			<td style="border: none;"><?PHP echo $amc_ref_no ; ?></td>
			<td style="border: none;"></td>
			<td style="text-align: right;border: none; font-size: 25px;font-weight: 700;"><b>AMC</b></td>
		</tr>
	</tbody>
</table>

<table align="center" width="800">
	<tbody>
		
		<tr>
			<td bgcolor="#2e2e79" colspan="4" style="color: #ffffff"><strong>INFORMATION</strong></td>
		</tr>
		<tr>
			<td width="158"><b>Customer Name </b></td>
			<td width="255"><?PHP echo $customer_name ;?></td>
			<td style="text-align: left" width="170"><b>Contract Type </b></td>
			<td style="text-align: left" width="217"><?PHP echo $contract_type_name ;?></td>
		</tr>
		<tr>
			<td><b>Initial Start Date</b></td>
			<td><?PHP echo date('d-m-Y', strtotime($amc_signed_date)) ;?></td>
			<td style="text-align: left"><b>AMC Date</b></td>
			<td style="text-align: left"><?PHP echo date('d/m/Y', strtotime($amc_start_date)) ;?> - <?PHP echo date('d/m/Y', strtotime($amc_end_date)) ;?></td>
		</tr>
		
		<tr> 
			<td><b>RFP</b></td>
			<td><?PHP echo $is_rfp ;?></td>	
			<td><b>Contract Value p.a</b></td>
			<td><?PHP echo number_format($amc_amount + $amc_vat_amt,3) ;?></td>
		</tr> 
		<tr>
			
		</tr>
		<?php
		if ($amc_status == 'Cancelled') {
		echo 
		'<tr>
			<td style="text-align: left"><b>Status</b></td>
			<td style="text-align: left">'.$amc_status.'</td>
			<td style="text-align: left"><b>Cancelled On</b></td>
			<td style="text-align: left">'.date('d-m-Y', strtotime($cancelled_on)).'</td>
		</tr>
		<tr>
			<td style="text-align: left"><b>Cancelled Description</b></td>
			<td colspan="3">'.$cancelled_description.'</td>
		</tr>';
		} elseif($amc_status == 'Hold'){
			echo '<tr>
			<td style="text-align: left"><b>Status</b></td>
			<td style="text-align: left">'.$amc_status.'</td>
		</tr>
		<tr>
			<td><b>Hold Description</b></td>
			<td colspan="3">'.$hold_description.'</td>
		</tr>';
		} else{
			echo '<tr>
			<td style="text-align: left"><b>Status</b></td>
			<td style="text-align: left">'.$amc_status.'</td>
		</tr>';
		}?>
		<tr>
			<td style="text-align: left"><b>Description </b></td>
			<td colspan="3"> <?PHP echo $amc_description ;?></td>
		</tr>
	</tbody>
</table>

<p></p>  
<p></p>

<table align="center" border="0" cellpadding="0" cellspacing="0" width="800">
	<tbody>
		<tr>
			<td bgcolor="#2e2e79" colspan="4" style="color: #ffffff"><strong>List of Subcontractors</strong></td>
		</tr>
	</tbody>
</table>
<p></p>

<table align="center" border="0" cellpadding="0" cellspacing="0" width="800">
	<tbody>
		 
		<tr>
			<td bgcolor="#2e2e79" style="text-align: center;color:white;width:5%;"><strong >SL No</strong></td>
			<td bgcolor="#2e2e79" style="text-align: center;color:white;width:15%;"> <strong>Name</strong></td>
			<td bgcolor="#2e2e79" style="text-align: center;color:white;width:25%;"><strong>Description</strong></td>
			<td bgcolor="#2e2e79" style="text-align: center;color:white;width:15%;"><strong>Date</strong></td>
			<td bgcolor="#2e2e79" style="text-align: center;color:white;width:15%;"><strong>Status</strong></td>
			<td bgcolor="#2e2e79" style="text-align: center;color:white;width:8%;"><strong>Amount</strong></td>
		</tr>
		 <?PHP 
			$ctr = 1;
			$amt=0; 
			$pr_child_table = mysqli_query($varDBConnection, "SELECT * FROM tbl_amc_subcontractors WHERE amc_number = '".$_GET['v_amc_ref_no']."' ");
				while($child_row=mysqli_fetch_assoc($pr_child_table)) {
					$contract_total_amount = $child_row['contract_total_amount'];
					   
			?>
	    <tr style="border-bottom: 1px solid gray;">
			<td bgcolor="#f2f2f2" style="text-align: center"><?PHP echo $ctr;?></td>
			<td bgcolor="#f2f2f2" style="text-align: center"><?PHP echo $child_row['subcontractor_name']; ?></td>
			<td bgcolor="#f2f2f2" style="text-align: center"><?PHP echo $child_row['contractor_description']; ?></td>
			<td bgcolor="#f2f2f2" style="text-align: center">
			  <?php echo date('d/m/Y', strtotime($child_row['contract_start_date'])); ?> - 
			  <?php echo date('d/m/Y', strtotime($child_row['contract_end_date'])); ?>
			</td>
			<td bgcolor="#f2f2f2" style="text-align: center"><?PHP if ($child_row['amc_subcontractor_status'] == 'Active') {
				// Display only if the status is active
				echo 'Active';
			} else {
				// Display deactive reason and deactive date if the status is deactive
				echo $child_row['amc_subcontractor_status'] . '<br><hr>';
				echo 'Reason: ' . $child_row['contractor_deactive_reason'] . '<br><hr>'; 
				echo 'Date: ' . date('d/m/Y', strtotime($child_row['contractor_deactive_date']));
			} ?></td>
			<td bgcolor="#f2f2f2" style="text-align: right"><?PHP echo number_format($contract_total_amount,3); $amt = $amt+$contract_total_amount; ?></td>
	    </tr>
					
	  <?PHP 
	  
		$ctr = $ctr +1;
		} ?>
		<tr style="border-bottom: 1px solid gray;">
			
			<td colspan="5" style="text-align: right"> <strong>Total Amount</strong></td>
			<td style="text-align: right" colspan="2"><strong><?PHP echo number_format($amt,3); ?></strong></td>
		</tr>
	</tbody>
</table>

<p></p>

<p></p>
<div class="divFooter">
	<table align="center" border="0" cellpadding="0" cellspacing="0" width="800" style="border: none; padding: 25px;" >
	    <tr style="border: none; background-color: #2e2e79; padding: 25px;">
			<td style="border: none;padding-left: 20px;color:white;" width="500">
			    <small>Tele:</small> +973 17 100 190 | info@thc.com.bh | <strong>www.thc.com.bh</strong><br>
			     CR. <strong>88982-1</strong> | Level 14, Enterance 143/144,  Bldg 155, Road 1703, Block 317<br>
			    <strong>YBA Kanoo Tower, Diplomatic Area</strong>, Kingdom of Bahrain
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