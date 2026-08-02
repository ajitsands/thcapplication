<?PHP
   include('../model/db_connection/connection.php');
   $connection = new DBConnection();
   $conn = $connection->ConnectToMYSQL();
   $ticketId = $_GET['ticket_id'];
   
        $ticketResults = mysqli_query($conn,"SELECT * FROM tbl_tickets WHERE `ticket_id`='".$ticketId."'");
		while($ticketRow=mysqli_fetch_assoc($ticketResults))
		{
			$complaints_description = $ticketRow['complaints_description'];
			$customer_id = $ticketRow['customer_id'];
			$ticket_ref_code = $ticketRow['ticket_ref_code'];
			$asset_code = $ticketRow['asset_code'];
			$building_name = $ticketRow['building_name'];
			$location_name = $ticketRow['location_name'];
			$job_category = $ticketRow['job_category'];
			$service_report_remarks = $ticketRow['service_report_remarks'];
		}
		
		$custResults = mysqli_query($conn,"SELECT customer_name,customer_address FROM tbl_customers WHERE `customer_id`='".$customer_id."'");
		while($custRow=mysqli_fetch_assoc($custResults))
		{
		    $customer_name = $custRow['customer_name'];
			$customer_address = $custRow['customer_address'];
		}
	
   
?>
<!doctype html>
<html>
<head><meta charset="us-ascii">
	<title>Service Report</title>
	<link href="https://fonts.googleapis.com" rel="preconnect" />
	<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
	<link href="https://fonts.googleapis.com/css2?family=Montserrat&amp;display=swap" rel="stylesheet" />
	<style type="text/css">
	body,td,th {
    font-family:  'Montserrat', sans-serif;
    font-style: normal;
    font-size: 10px;
    color: #2e2e79;
    
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
	
	
    table.brprint {
        page-break-before: always;
    }

}
	</style>
</head>
<body>
    
                                      
                                    
                                   
<table align="center" style="border: none;" width="800">
	<tbody>
		<tr style="border: none; ">
			<td style="border: none;" width="396">
			   <!-- <img src="global_assets/images/logo_print.png"  />-->
			  <img src="https://sianlab.com/thc/view/global_assets/images/logo_print.png"  />
			</td>
			<td colspan="2" style="border: none; color: #daa505;text-align: right;font-weight:700;padding-right:20px;">
			 
			   
			   
			</td>
		</tr>
		<tr style="border: none;">
			<td colspan="3" align="center" valign="top" style="border:none;font-size:25px;color:#2e2e79"><strong>SERVICE REPORT</strong></td>
		</tr>
		<tr style="border: none;">
			<td align="right" style="border: none;"></td>
			<td width="135" align="middle" style="border: none;"></td>
			<td width="253" align="left" valign="top" style="border: none;color:#2e2e79"><strong>NO : <?php echo $ticketId; ?></strong></td>
		</tr>
		<tr style="border:hidden">
			<td colspan="3" align="right" valign="bottom" style="border:hidden;"><table width="100%" border="0">
  <tbody>
    <tr>
      <td width="20%" align="left" valign="bottom" style="border:hidden;color:#2e2e79"><strong>Customer Name & Address</strong></td>
      <td width="80%" align="left" valign="bottom" style="border:hidden;"><?php echo $customer_name.', '.$customer_address; ?><hr style="border-top: 1px solid;">
      </td>
    </tr>
  </tbody>
</table>
</td>
		</tr>
		<tr style="border: none;">
			<td colspan="3" align="right" style="border: none;"><table width="100%" border="1">
  <tbody>
    <tr>
      <td width="16%" align="left" valign="top" style="border:hidden; font-weight: bold;">Work Request Details</td>
      <td width="19%" style="border:hidden;"><?php echo $complaints_description; ?><hr style="border-top: 1px solid;"></td>
      <td width="11%" align="left" valign="top" style="border:hidden; font-weight: bold;">Work Order No</td>
      <td width="16%" style="border:hidden;"><?php echo "WO-".$ticket_ref_code."-".$ticketId; ?><hr style="border-top: 1px solid;"></td>
      <td width="5%" align="left" valign="top" style="border:hidden; font-weight: bold;">Date</td>
      <td width="12%" style="border:hidden;"><hr style="border-top: 1px solid;">
        </td>
      <td width="4%" align="left" valign="top" style="border:hidden; font-weight: bold;">Time</td>
      <td width="17%" style="border:hidden;"><hr style="border-top: 1px solid;">
        </td>
    </tr>
  </tbody>
</table>

				
        </td>
		</tr> 
	    <tr style="border: none;">
			<td colspan="3" align="right" style="border:hidden;"><table width="100%" border="1">
  <tbody>
    <tr>
      <td width="7%" align="left" valign="top" style="font-size:10px;border:hidden; font-weight: bold;">Asset No</td>
      <td width="9%" style="border:hidden;"><?php if($asset_code==0){ echo"NA"; } ?><hr style="border-top: 1px solid;">
       </td>
      <td width="9%" align="left" valign="top" style="font-size:10px;border:hidden; font-weight: bold;">Location</td>
      <td width="12%" style="border:hidden;">
          <?php echo $building_name.", ".$location_name; ?>
        <hr style="border-top: 1px solid;"></td>
      <td width="28%" style="font-size:10px;border:hidden; font-weight: bold;">Type Of Work:PPM
        <input type="checkbox" name="checkbox9" id="checkbox9" <?php if($job_category=="PPM"){ echo "checked"; } ?> >
        RM
        <input type="checkbox" name="checkbox13" id="checkbox13" <?php if($job_category=="Reactive"){ echo "checked"; } ?> >
        CM
        <input type="checkbox" name="checkbox14" id="checkbox14" <?php if($job_category=="Variable" || $job_category==""){ echo "checked"; } ?> ></td>
      <td width="14%" align="left" valign="top" style="font-size:10px;border:hidden; font-weight: bold;">Work Completed Date</td>
      <td width="8%" style="border:hidden;"><hr style="border-top: 1px solid;">
        </td>
      <td width="5%" align="left" valign="top" style="border:hidden; font-weight: bold;">Time</td>
      <td width="8%" style="border:hidden;"><hr style="border-top: 1px solid;"></td>
      </tr>
  </tbody>
</table>

				
        </td>
		</tr>
	
	
	</tbody>
</table>

<table align="center" width="800">
	<tbody>
		<tr>
			<td align="center" valign="middle" style="border:hidden;"><table width="100%" border="0">
			  <tbody>
				  <tr>
				  <td colspan="6" align="center" valign="middle" bgcolor="#2e2e79" style="color: #FFFFFF;font-size:12px;"><strong>HVAC</strong></td>
			      </tr>
				  <tr>
				  <td colspan="2" style="border-bottom:1px solid;">Cleaned the cindenser or Evaporator coil</td>
				  <td colspan="2" style=""><span style="">Cleaned the Air Filters </span></td>
				  <td colspan="2" style="="><span style="">Cleaned the A/C Diffuser </span></td>
			      </tr>
				  <tr>
				  <td colspan="2" style="border-top:1px solid;border-bottom:1px solid;">Flush the Drain Pipe</td>
				  <td colspan="2" style=""><span style="">Checked the Gas Pressure</span></td>
				  <td colspan="2" style="="><span style="">Checked the Control Circuit</span></td>
			    </tr>
				  <tr>
				  <td colspan="2" style="=">Gas Leak repair</td>
				  <td colspan="2" style=""><span style="">Repaired / Replaced the fan motor</span></td>
				  <td colspan="2" style=""><span style="">Replaced Space Parts</span></td>
			    </tr>
				  <tr>
				  <td colspan="2" style="border-top:1px solid;border-bottom:1px solid;">Others</td>
				  <td colspan="2" style="">&nbsp;</td>
				  <td colspan="2" style="">&nbsp;</td>
			    </tr>
				  <tr>
				  <td colspan="6" align="center" valign="middle" bgcolor="#2e2e79" style="color: #FFFFFF;font-size:12px;"><strong>PLUMBING</strong><strong></strong></td>
			      </tr>
				  <tr>
				  <td colspan="2" style="border-bottom:1px solid;">Cleaned the cindenser or Evaporator coil</td>
				  <td colspan="2" style=""><span style="">Cleaned the Air Filters </span></td>
				  <td colspan="2" style=""><span style="">Cleaned the A/C Diffuser </span></td>
			    </tr>
				  <tr>
				  <td colspan="2" style="border-top:1px solid;border-bottom:1px solid;">Flush the Drain Pipe</td>
				  <td colspan="2" style=""><span style="">Checked the Gas Pressure</span></td>
				  <td colspan="2" style=""><span style="">Checked the Control Circuit</span></td>
			    </tr>
				  <tr>
				  <td colspan="2" style="border-top:1px solid;border-bottom:1px solid;">Gas Leak repair</td>
				  <td colspan="2" style=""><span style="">Repaired / Replaced the fan motor</span></td>
				  <td colspan="2" style=""><span style="">Replaced Space Parts</span></td>
			    </tr>
				  <tr>
				  <td colspan="2" style="border-top:1px solid;border-bottom:1px solid;">Others</td>
				  <td colspan="2" style="">&nbsp;</td>
				  <td colspan="2" style="">&nbsp;</td>
			    </tr>
				 
				</tbody>
			</table>
     </td>
		</tr>
		
		
	</tbody>
</table>


<br>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="800" style="">
	<tbody>
	  <tr style="color: #FFFFFF;">
			<td align="left" valign="top" style="height:80px;" ><strong><?php echo $service_report_remarks; ?></strong></td>
		</tr>
		
  </tbody>
</table>

<br>

<table align="center" border="0" cellpadding="0" cellspacing="0" width="800" class="brprint">
	<tbody>
		<tr bgcolor="#2e2e79" style="color: #FFFFFF">
			<td colspan="9" align="center" valign="middle" style="color: #ffffff;font-size:12px"><strong>A . LABOUR DETAILS
         </strong></td>
		</tr>
		<tr style="color: #FFFFFF">
			<td width="36" align="center" valign="middle" style=" font-weight: bold;">S/N</td>
			<td width="208" align="center" valign="middle" style=" font-weight: bold;">Name</td>
			<td width="61" align="center" valign="middle" style=" font-weight: bold;">Date</td>
			<td width="82" align="center" valign="middle" style=" font-weight: bold;">Start Time</td>
			<td width="83" align="center" valign="middle" style=" font-weight: bold;">End Time</td>
			<td width="83" align="center" valign="middle" style=" font-weight: bold;">Total Hrs</td>
			<td width="77" align="center" valign="middle" style=" font-weight: bold;">RT/OT</td>
			<td width="95" align="center" valign="middle" style=" font-weight: bold;">Charge Per Hr</td>
			<td width="73" align="center" valign="middle" style=" font-weight: bold;">Total Amount</td>
		</tr>
	    <tr style="color: #FFFFFF">
			<td width="36" align="center" valign="middle" style="">&nbsp;</td>
			<td width="208" align="center" valign="middle" style="">&nbsp;</td>
			<td width="61" align="center" valign="middle" style="">&nbsp;</td>
			<td width="82" align="center" valign="middle" style="">&nbsp;</td>
			<td width="83" align="center" valign="middle" style="">&nbsp;</td>
			<td width="83" align="center" valign="middle" style="">&nbsp;</td>
			<td width="77" align="center" valign="middle" style="">&nbsp;</td>
			<td width="95" align="center" valign="middle" style="">&nbsp;</td>
			<td width="73" align="center" valign="middle" style="">&nbsp;</td>
		</tr>
	    <tr style="color: #FFFFFF">
			<td width="36" align="center" valign="middle" style="">&nbsp;</td>
			<td width="208" align="center" valign="middle" style="">&nbsp;</td>
			<td width="61" align="center" valign="middle" style="">&nbsp;</td>
			<td width="82" align="center" valign="middle" style="">&nbsp;</td>
			<td width="83" align="center" valign="middle" style="">&nbsp;</td>
			<td width="83" align="center" valign="middle" style="">&nbsp;</td>
			<td width="77" align="center" valign="middle" style="">&nbsp;</td>
			<td width="95" align="center" valign="middle" style="">&nbsp;</td>
			<td width="73" align="center" valign="middle" style="">&nbsp;</td>
		</tr>
	    <tr style="color: #FFFFFF">
			<td width="36" align="center" valign="middle" style="">&nbsp;</td>
			<td width="208" align="center" valign="middle" style="">&nbsp;</td>
			<td width="61" align="center" valign="middle" style="">&nbsp;</td>
			<td width="82" align="center" valign="middle" style="">&nbsp;</td>
			<td width="83" align="center" valign="middle" style="">&nbsp;</td>
			<td width="83" align="center" valign="middle" style="">&nbsp;</td>
			<td width="77" align="center" valign="middle" style="">&nbsp;</td>
			<td width="95" align="center" valign="middle" style="">&nbsp;</td>
			<td width="73" align="center" valign="middle" style="">&nbsp;</td>
		</tr>
	    <tr style="color: #FFFFFF">
			<td width="36" align="center" valign="middle" style="">&nbsp;</td>
			<td width="208" align="center" valign="middle" style="">&nbsp;</td>
			<td width="61" align="center" valign="middle" style="">&nbsp;</td>
			<td width="82" align="center" valign="middle" style="">&nbsp;</td>
			<td width="83" align="center" valign="middle" style="">&nbsp;</td>
			<td width="83" align="center" valign="middle" style="">&nbsp;</td>
			<td width="77" align="center" valign="middle" style="">&nbsp;</td>
			<td width="95" align="center" valign="middle" style="">&nbsp;</td>
			<td width="73" align="center" valign="middle" style="">&nbsp;</td>
		</tr>
	    <tr style="color: #FFFFFF">
			<td width="36" align="center" valign="middle" style="">&nbsp;</td>
			<td width="208" align="center" valign="middle" style="">&nbsp;</td>
			<td width="61" align="center" valign="middle" style="">&nbsp;</td>
			<td width="82" align="center" valign="middle" style="">&nbsp;</td>
			<td width="83" align="center" valign="middle" style="">&nbsp;</td>
			<td width="83" align="center" valign="middle" style="">&nbsp;</td>
			<td width="77" align="center" valign="middle" style="">&nbsp;</td>
			<td width="95" align="center" valign="middle" style="">&nbsp;</td>
			<td width="73" align="center" valign="middle" style="">&nbsp;</td>
		</tr>
	</tbody>
</table>
<br>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="800">
	<tbody>
		<tr style="color: #FFFFFF">
			<td colspan="4" align="center" valign="middle" style="color: #ffffff;font-size:12px" bgcolor="#2e2e79"><strong>B . MATERIAL DETAILS
         </strong></td>
			<td align="center" valign="middle" style="color: #ffffff;font-size:12px;border-top:hidden;border-bottom:hidden;">&nbsp;</td>
			<td colspan="4" align="center" valign="middle" style="color: #ffffff;font-size:12pxborder-left:1px solid">&nbsp;</td>
			
		</tr>
		<tr style="color: #FFFFFF">
			<td width="208" align="center" valign="middle" style=" font-weight: bold;">Description</td>
			<td width="58" align="center" valign="middle" style=" font-weight: bold;">Qty</td>
			<td width="80" align="center" valign="middle" style=" font-weight: bold;">Unit Price</td>
			<td width="69" align="center" valign="middle" style=" font-weight: bold;">Total</td>
			<td width="22" align="center" valign="middle" style="border-top:hidden;border-bottom:hidden;">&nbsp;</td>
			<td align="left" valign="bottom" style="border-top:hidden;border-right:hidden;"><strong>Technician Signature:</strong></td>
			<td align="center" valign="middle" style="border-top:hidden;border-right:hidden"><hr style="border-top: 1px solid;"></td>
		  <td align="left" valign="bottom" style="border-top:hidden;border-right:hidden"><strong>Date:</strong></td>
			<td align="center" valign="middle" style="border-top:hidden;"><hr style="border-top: 1px solid;"></td>
		</tr>
	    <tr style="color: #FFFFFF">
			<td width="208" align="center" valign="middle" style="">&nbsp;</td>
			<td width="58" align="center" valign="middle" style="">&nbsp;</td>
			<td width="80" align="center" valign="middle" style="">&nbsp;</td>
			<td width="69" align="center" valign="middle" style="">&nbsp;</td>
			<td width="22" align="center" valign="middle" style="border-top:hidden;border-bottom:hidden;">&nbsp;</td>
			<td width="125" align="left" valign="bottom" style="border-top:hidden;border-right:hidden;"><strong>Supervisor Signature:</strong></td>
			<td width="102" align="center" valign="middle" style="border-top:hidden;border-right:hidden;"><hr style="border-top: 1px solid;"></td>
			<td width="37" align="left" valign="bottom" style="border-top:hidden;border-right:hidden;"><strong>Date:</strong></td>
			<td width="97" align="center" valign="middle" style="border-top:hidden;"><hr style="border-top: 1px solid;"></td>
		</tr>
	    <tr style="color: #FFFFFF">
			<td width="208" align="center" valign="middle" style="">&nbsp;</td>
			<td width="58" align="center" valign="middle" style="">&nbsp;</td>
			<td width="80" align="center" valign="middle" style="">&nbsp;</td>
			<td width="69" align="center" valign="middle" style="">&nbsp;</td>
			<td width="22" align="center" valign="middle" style="border-top:hidden;border-bottom:hidden;">&nbsp;</td>
			<td width="125" align="left" valign="bottom" style="border-top:hidden;border-right:hidden;"><strong>Customer Signature:</strong></td>
			<td width="102" align="center" valign="middle" style="border-top:hidden;border-right:hidden;"><hr style="border-top: 1px solid;"></td>
			<td width="37" align="left" valign="bottom" style="border-top:hidden;border-right:hidden;"><strong>Date:</strong></td>
			<td width="97" align="center" valign="middle" style="border-top:hidden;"><hr style="border-top: 1px solid;"></td>
		</tr>
	    <tr style="color: #FFFFFF">
			<td width="208" align="center" valign="middle" style="">&nbsp;</td>
			<td width="58" align="center" valign="middle" style="">&nbsp;</td>
			<td width="80" align="center" valign="middle" style="">&nbsp;</td>
			<td width="69" align="center" valign="middle" style="">&nbsp;</td>
			<td width="22" align="center" valign="middle" style="border-top:hidden;border-bottom:hidden;">&nbsp;</td>
			<td width="125" align="left" valign="bottom" style="border-top:hidden;border-right:hidden;">&nbsp;</td>
			<td width="102" align="center" valign="middle" style="border-top:hidden;border-right:hidden;">&nbsp;</td>
			<td width="37" align="left" valign="bottom" style="border-top:hidden;border-right:hidden;">&nbsp;</td>
			<td width="97" align="center" valign="middle" style="border-top:hidden;">&nbsp;</td>
		</tr>
	    <tr style="color: #FFFFFF">
			<td width="208" align="center" valign="middle" style="">&nbsp;</td>
			<td width="58" align="center" valign="middle" style="">&nbsp;</td>
			<td width="80" align="center" valign="middle" style="">&nbsp;</td>
			<td width="69" align="center" valign="middle" style="">&nbsp;</td>
			<td width="22" align="center" valign="middle" style="border-top:hidden;border-bottom:hidden;">&nbsp;</td>
			
			<td colspan="4" rowspan="5" align="left" valign="top" style=""><strong>Customer Feedback:</strong></td>
		</tr>
	    <tr style="color: #FFFFFF">
			<td width="208" align="center" valign="middle" style="">&nbsp;</td>
			<td width="58" align="center" valign="middle" style="">&nbsp;</td>
			<td width="80" align="center" valign="middle" style="">&nbsp;</td>
			<td width="69" align="center" valign="middle" style="">&nbsp;</td>
			<td width="22" align="center" valign="middle" style="border-top:hidden;border-bottom:hidden;">&nbsp;</td>
		</tr>
	    <tr style="color: #FFFFFF">
			<td colspan="4" align="left" valign="bottom" style=" font-weight: bold;">A.Total Labour Charge</td>
			<td width="22" align="center" valign="middle" style="border-top:hidden;border-bottom:hidden;">&nbsp;</td>
		</tr>
	    <tr style="color: #FFFFFF">
			<td colspan="4" align="left" valign="bottom" style=" font-weight: bold;">B.Total Material Charge</td>
			<td width="22" align="center" valign="middle" style="border-top:hidden;border-bottom:hidden;">&nbsp;</td>
		</tr>
	    <tr style="color: #FFFFFF">
			<td colspan="4" align="left" valign="bottom" style=""><strong>Grand Total A+B</strong></td>
			<td width="22" align="center" valign="middle" style="border-top:hidden;border-bottom:hidden;">&nbsp;</td>
		</tr>
	    
	
	</tbody>
</table>	
	<br>




	
	
	
	
<div class="divFooter">
	<table align="center" border="0" cellpadding="0" cellspacing="0" width="800" style="border: none; padding: 25px;" >
	    <tr style="border: none; background-color: #2e2e79; padding: 25px;">
			<td style="border: none;padding-left: 20px;color:white;" width="500">
			    <small>Tele:</small> +973 17 100 190 | info@thc.com.bh | <strong>www.thc.com.bh</strong><br>
			     CR. <strong>88982-1</strong> | Level 14, Enterance 143/144,  Bldg 155, Road 1703, Block 317<br>
			    <strong>YBA Kanoo Tower, Diplomatic Area</strong>, Kingdom of Bahrain
			</td>
			<td style="border: none;text-align: right;padding-right:20px;padding: 25px;" width="300">
			 
			    <!--<img src="global_assets/images/a.png" />-->
			  <img src="https://sianlab.com/thc/view/global_assets/images/a.png">

			   
		  </td>
		</tr>
	</table>
</div>
<p></p>

<p></p>
</body>
</html>