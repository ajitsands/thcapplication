<?PHP
include "../../model/db_connection/connection.php" ;
$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();

      $j=0;           
?>
<!doctype html>
<html>
<head><meta charset="us-ascii">
	<title>Daily Team List</title>
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
			    <img src="../global_assets/images/logo_print.png"  />
			</td>
			<td style="border: none; color: #daa505;text-align: right;font-weight:700;padding-right:20px;" width="400">
			 
			   
			   
			</td>
		</tr>
	
		<tr style="border: none;">
			<td style="border: none;font-size: 15px;font-weight: 700;"><b>DAILY TEAM LIST </b></td>
			<td style="text-align: right;border: none;"><b>Date & Time:</b> <?PHP date_default_timezone_set('Asia/Bahrain'); echo date("d-m-Y H:i:s");  ?></td>
		</tr>
	</tbody>
</table>

<table align="center" width="1000">
	<tbody>
		
		
		<tr>
			<td width="30"><b>Date </b></td>
			<td width="255"> <?PHP echo date("d-m-Y",strtotime($_GET['visit_date']));  ?> </td>
			
		</tr>
	
	</tbody>
</table>

<p></p>

<table align="center" border="0" cellpadding="0" cellspacing="0" width="1000">
	<tbody>
		<tr >
			<td bgcolor="#2e2e79" colspan="8" style="color: #ffffff"><strong> TEAM DETAILS</strong></td>
		</tr>
		<tr>
		    <td width="158" style="text-align:center"><b>SL.No. </b></td>
		    <td width="225" style="text-align:center"><b>Team Members </b></td>
		    <td width="225" style="text-align:center"><b>WO. Ref. No. </b></td>
		    <!--<td width="158" style="text-align:center"><b>Contact Number </b></td>-->
		   
		</tr>
	<?php 
	 $result = mysqli_query($varDBConnection,"SELECT GROUP_CONCAT( distinct(employee_name)) as Emp_name1, GROUP_CONCAT( distinct(employee_id)) as Emp_id,GROUP_CONCAT(employee_name,(case when (is_attend = 'No')THEN ' ( Ab )'  ELSE ''  END)) as Emp_name,visit_id,ticket_ref_no,ticket_id,amc_ticket FROM  tbl_ticket_teams where ticket_team_status='Active' and visit_date = '".$_GET['visit_date']."' group by ticket_id ");	
	while($row=mysqli_fetch_assoc($result)) {
                     $j=$j+1;
                    
                     ?>
                     	<tr>
                			<td style="text-align:center"><?php echo $j;?></td>
                									
                			<td><?php echo $row['Emp_name'];?></td>
                			<td style="text-align:center"><?php if($row['ticket_id']=='AMC')
								{ echo 'WO-'.$row['ticket_ref_no'].'-'.$row['visit_id'];} else{ echo 'WO-'.$row['ticket_ref_no'].'-'.$row['ticket_id'];}?></td>
                			<?php $result_cn = mysqli_query($varDBConnection,"select distinct(GROUP_CONCAT(employee_contact_no)) as employee_contact_no,GROUP_CONCAT(employee_name) as Emp_name from   tbl_employees where   employee_id in (".$row['Emp_id'].")");
                                while($row_cn=mysqli_fetch_assoc($result_cn)) { ?>
                                        <!--<td><?php //echo $row_cn['employee_contact_no'];?></td>-->
                                    <?php } ?>	 
                								</tr>
                								<?php 
                								
                								}?>
	</tbody>
	
</table>

<p></p>

<p></p>



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
</body>
</html>