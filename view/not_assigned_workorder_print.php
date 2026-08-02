<?PHP
include "../model/db_connection/connection.php" ;
$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();
 
	$start_date = $_GET["start_date"];
	$end_date = $_GET["end_date"];
	$customer_id = $_GET["v_customer"];
	$customer_name = $_GET["v_customer_name"];
	// echo $start_date;
	// echo $end_date;
	//echo $customer_id;

?>
<!doctype html>
<html>
<head><meta charset="us-ascii">
	<title>Work Order List</title>
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
		<tr style="border: none;">
			<td style="border: none;">Customer : <?PHP if($customer_name === 'All') echo 'All Customers' ; else echo $customer_name ; ?></td>
		</tr>
		<tr style="border: none;">
			<td style="border: none;">Start Date : <?PHP echo date('d-m-Y', strtotime($start_date)) ; ?></td>
		</tr>
		<tr style="border: none;">
			<td style="border: none;">End Date : <?PHP echo date('d-m-Y', strtotime($end_date)) ; ?></td>
		</tr>
		
		
	</tbody>
</table>


<p></p>  
<p></p>

<table align="center" border="0" cellpadding="0" cellspacing="0" width="800">
	<tbody>
		<tr>
			<td bgcolor="#2e2e79" colspan="4" rowspan="3" style="color: #ffffff"><strong>List of Work Order - Not Assigned</strong></td>
		</tr>
	</tbody>
</table>
<p></p>

<table align="center" border="0" cellpadding="0" cellspacing="0" width="800">
	<tbody>
		 
		<tr>
			<td bgcolor="#2e2e79" style="text-align: center;color:white;width:5%;"><strong >SL No</strong></td>
			<td bgcolor="#2e2e79" style="text-align: center;color:white;width:10%;"> <strong>Date</strong></td>
			<td bgcolor="#2e2e79" style="text-align: center;color:white;width:15%;"><strong>Work Order No</strong></td>
			<td bgcolor="#2e2e79" style="text-align: center;color:white;width:8%;"><strong>Slots</strong></td>
			<td bgcolor="#2e2e79" style="text-align: center;color:white;width:25%;"><strong>Customer</strong></td>
			<td bgcolor="#2e2e79" style="text-align: center;color:white;width:10%;"><strong>Location</strong></td>
			<td bgcolor="#2e2e79" style="text-align: center;color:white;width:10%;"><strong>Building</strong></td>
		</tr>
		 <?PHP 
		
			$ctr = 1;
			$amt=0; 
			if($customer_id === 'All')
			{
				$pr_child_table = mysqli_query($varDBConnection, "select *,DATE_FORMAT(date_of_visits, '%d-%m-%Y') as date_of_visits1,DATE_FORMAT(visit_start_time, '%d-%m-%Y %H:%i')as visit_start_time from  tbl_visits where amc_ticket='TKT' and date_of_visits between '".$start_date."' and '".$end_date."' and amc_visit_status='Scheduled' order by date_of_visits asc");
			}
			else
			{
				$pr_child_table = mysqli_query($varDBConnection, "select *,DATE_FORMAT(date_of_visits, '%d-%m-%Y') as date_of_visits1,DATE_FORMAT(visit_start_time, '%d-%m-%Y %H:%i')as visit_start_time from  tbl_visits where amc_ticket='TKT' and date_of_visits between '".$start_date."' and '".$end_date."' and amc_visit_status='Scheduled' and customer_id = '".$customer_id."' order by date_of_visits asc");
			}
			
				while($child_row=mysqli_fetch_assoc($pr_child_table)) {
					
			?> 
	    <tr style="border-bottom: 1px solid gray;">
			<td bgcolor="#f2f2f2" style="text-align: center"><?PHP echo $ctr;?></td>
			<td bgcolor="#f2f2f2" style="text-align: center"><?PHP echo $child_row['date_of_visits1'];?></td>
			<td bgcolor="#f2f2f2" style="text-align: center">WO - <?PHP echo $child_row['amc_tkt_ref_no']; ?> - <?PHP echo $child_row['amc_tkt_id']; ?></td>
			<td bgcolor="#f2f2f2" style="text-align: center"><?PHP  $time_of_visit = $child_row['time_of_visit'];
			$additional_slots = $child_row['additional_slots'];

			if ($additional_slots != 0) {
				$endslot = $time_of_visit + $additional_slots;
				$slots = "$time_of_visit - $endslot";
			} else {
				$slots = $time_of_visit;
			}

			echo $slots; ?></td>
			<td bgcolor="#f2f2f2" style="text-align: left"><?PHP echo $child_row['customer_code'] ; ?> - <?PHP echo $child_row['customer_name']; ?></td>
			<td bgcolor="#f2f2f2" style="text-align: center"><?php echo $child_row['location_name']; ?></td>
			<td bgcolor="#f2f2f2" style="text-align: center"><?PHP echo $child_row['building_name'] ; ?></td>
	    </tr>
					
	  <?PHP 
	  
		$ctr = $ctr +1;
		} ?>
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