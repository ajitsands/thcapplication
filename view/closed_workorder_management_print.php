<?PHP
include(__DIR__ . '/../model/db_connection/connection.php');
$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();
 
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
		
	</tbody>
</table>


<p></p>  
<p></p>

<table align="center" border="0" cellpadding="0" cellspacing="0" width="800">
	<tbody>
		<tr>
			<td bgcolor="#2e2e79" colspan="4" rowspan="3" style="color: #ffffff"><strong>List of Work Order - Closed</strong></td>
		</tr>
	</tbody>
</table>
<p></p>

<table align="center" border="0" cellpadding="0" cellspacing="0" width="800">
	<tbody>
		 
		<tr>
			<td bgcolor="#2e2e79" style="text-align: center;color:white;width:5%;"><strong >SL No</strong></td>
			<td bgcolor="#2e2e79" style="text-align: center;color:white;width:10%;"> <strong>Date & Time</strong></td>
			<td bgcolor="#2e2e79" style="text-align: center;color:white;width:10%;"><strong>Ref. No.</strong></td>
			<td bgcolor="#2e2e79" style="text-align: center;color:white;width:25%;"><strong>Customer</strong></td>
			<td bgcolor="#2e2e79" style="text-align: center;color:white;width:10%;"><strong>Location</strong></td>
			<td bgcolor="#2e2e79" style="text-align: center;color:white;width:10%;"><strong>Building</strong></td>
			<td bgcolor="#2e2e79" style="text-align: center;color:white;width:10%;"><strong>Priority</strong></td>
		</tr>
		 <?PHP 
		
			$ctr = 1;
			$amt=0; 
			
				$pr_child_table = mysqli_query($varDBConnection, "select distinct(ticket_ref_code) as ticket_ref_code,DATE_FORMAT(created_date_time, '%d-%m-%Y %H:%i:%s') as created_date_time,customer_id,customer_code,customer_name,location_code,location_name,building_code,building_name,ticket_priority,location_id,building_id,ticket_ref_no,ticket_id  from  tbl_tickets where ticket_status='Closed'  group by ticket_ref_code order by YEAR(created_date_time) asc,MONTH(created_date_time) asc,DAY(created_date_time) asc,HOUR(created_date_time) asc,MINUTE(created_date_time) asc,SECOND(created_date_time) asc");
			
				while($child_row=mysqli_fetch_assoc($pr_child_table)) {
					
			?> 
	    <tr style="border-bottom: 1px solid gray;">
			<td bgcolor="#f2f2f2" style="text-align: center"><?PHP echo $ctr;?></td>
			<td bgcolor="#f2f2f2" style="text-align: center"><?PHP echo $child_row['created_date_time'];?></td>
			<td bgcolor="#f2f2f2" style="text-align: center"><?PHP echo $child_row['ticket_ref_code']; ?></td>
			<td bgcolor="#f2f2f2" style="text-align: left"><?PHP echo $child_row['customer_code'] ; ?> - <?PHP echo $child_row['customer_name']; ?></td>
			<td bgcolor="#f2f2f2" style="text-align: center"><?php echo $child_row['location_name']; ?></td>
			<td bgcolor="#f2f2f2" style="text-align: center"><?PHP echo $child_row['building_name'] ; ?></td>
			<td bgcolor="#f2f2f2" style="text-align: center"><?PHP echo $child_row['ticket_priority'] ; ?></td>
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