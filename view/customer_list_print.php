<?PHP
include "../model/db_connection/connection.php" ;
$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();
 
	$customer_id = $_GET["customer_id"];
	$building_id = $_GET["building_id"];
	$category_id = $_GET["category_id"];


?>
<!doctype html>
<html>
<head><meta charset="us-ascii">
	<title>Asset List</title>
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
		<!--<tr style="border: none;">-->
		<!--	<td style="border: none;">Customer : <?PHP if($customer_name === 'All') echo 'All Customers' ; else echo $customer_name ; ?></td>-->
		<!--</tr>-->
		<!--<tr style="border: none;">-->
		<!--	<td style="border: none;">Start Date : <?PHP echo date('d-m-Y', strtotime($start_date)) ; ?></td>-->
		<!--</tr>-->
		<!--<tr style="border: none;">-->
		<!--	<td style="border: none;">End Date : <?PHP echo date('d-m-Y', strtotime($end_date)) ; ?></td>-->
		<!--</tr>-->
		
		
	</tbody>
</table>


<p></p>  
<p></p>

<table align="center" border="0" cellpadding="0" cellspacing="0" width="800">
	<tbody>
		<tr>
			<td bgcolor="#2e2e79" colspan="4" rowspan="3" style="color: #ffffff"><strong>List of Assets</strong></td>
		</tr>
	</tbody>
</table>
<p></p>

<table align="center" border="0" cellpadding="0" cellspacing="0" width="800">
	<tbody>
		 
		<tr>
			<td bgcolor="#2e2e79" style="text-align: center;color:white;width:5%;"><strong >SL No</strong></td>
			<td bgcolor="#2e2e79" style="text-align: center;color:white;width:20%;"> <strong>Asset Code</strong></td>
			<td bgcolor="#2e2e79" style="text-align: center;color:white;width:15%;"><strong>Category</strong></td>
			<td bgcolor="#2e2e79" style="text-align: center;color:white;width:8%;"><strong>Type</strong></td>
			<td bgcolor="#2e2e79" style="text-align: center;color:white;width:15%;"><strong>Customer</strong></td>
			<td bgcolor="#2e2e79" style="text-align: center;color:white;width:10%;"><strong>Location</strong></td>
			<td bgcolor="#2e2e79" style="text-align: center;color:white;width:25%;"><strong>Building</strong></td>
		</tr>
		 <?PHP 
		$sql_cond='';
		if($customer_id=='All')
		{
		    $sql_cond=$sql_cond;
		}
		else
		{
		    $sql_cond=$sql_cond.' customer_id='.$customer_id.' and ';
		}
		if($building_id=='All')
		{
		    $sql_cond=$sql_cond;
		}
		else
		{
		    $sql_cond=$sql_cond.' building_id='.$building_id.' and ';
		}
		if($category_id=='All')
		{
		    $sql_cond=$sql_cond;
		}
		else
		{
		    $sql_cond=$sql_cond.' asset_category_id='.$category_id.' and ';
		}
		if($sql_cond!='')
		{
		    $sql_cond=substr($sql_cond, 0, -4);;
		}
	if($sql_cond!='')
	{
	    $sql="select * from  tbl_assets where  asset_status='Active' and ".$sql_cond;
	}
	else
	{
	    $sql="select * from  tbl_assets where  asset_status='Active' ";
	}
	
	
			$ctr = 1;
			$amt=0; 
		
				$pr_child_table = mysqli_query($varDBConnection, $sql);
		
				while($child_row=mysqli_fetch_assoc($pr_child_table)) {
					
			?> 
	    <tr style="border-bottom: 1px solid gray;">
			<td bgcolor="#f2f2f2" style="text-align: center"><?PHP echo $ctr;?></td>
			<td bgcolor="#f2f2f2" style="text-align: center"><?PHP echo $child_row['asset_ref_no'];?></td>
			<td bgcolor="#f2f2f2" style="text-align: center"><?PHP echo $child_row['asset_category_name']; ?></td>
			<td bgcolor="#f2f2f2" style="text-align: center"><?PHP echo $child_row['asset_type_name']; ?></td>
			<td bgcolor="#f2f2f2" style="text-align: left"><?PHP echo $child_row['customer_code'] ; ?> || <?PHP echo $child_row['customer_name']; ?></td>
			<td bgcolor="#f2f2f2" style="text-align: center"><?php echo $child_row['location_code']; ?> || <?php echo $child_row['asset_location']; ?></td>
			<td bgcolor="#f2f2f2" style="text-align: center"><?PHP echo $child_row['building_code'] ; ?> || <?php echo $child_row['asset_building']; ?></td>
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