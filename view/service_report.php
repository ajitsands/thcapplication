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
				  <td colspan="2" align="center" valign="middle" bgcolor="#2e2e79" style="color: #FFFFFF;font-size:12px;"><strong>HVAC</strong></td>
				  <td colspan="2" align="center" valign="middle" bgcolor="#2e2e79" style="color: #FFFFFF;font-size:12px"><strong>PLUMBING</strong></td>
				  <td colspan="2" align="center" valign="middle" bgcolor="#2e2e79" style="color: #FFFFFF;font-size:12px"><strong>ELECTRICAL</strong></td>
				</tr>
				  <tr>
				  <td width="23%" style="border-bottom:1px solid;">Cleaned the cindenser or Evaporator coil</td>
				  <td width="7%" align="center" valign="middle" style="border:hidden;border-top:1px solid;border-bottom:1px solid;border-right:1px solid;"><input type="checkbox" name="checkbox" id="checkbox">
                    </td>
				  <td width="28%" style="border:hidden;border-top:1px solid;border-bottom:1px solid;border-left:1px solid">Unclogged the Drainage Block</td>
				  <td width="7%" align="center" valign="middle" style="border:hidden;border-top:1px solid;border-bottom:1px solid;border-right:1px solid;"><input type="checkbox" name="checkbox2" id="checkbox2">
                    </td>
				  <td width="27%" style="border:hidden;border-left:1px solid;border-bottom:1px solid;border-top:1px solid;">Reset The DB</td>
				  <td width="8%" align="center" valign="middle" style="border-bottom:1px solid;border-top:1px solid;"><input type="checkbox" name="checkbox3" id="checkbox3">
                    </td>
		        </tr>
				  <tr>
				  <td style="border-top:1px solid;border-bottom:1px solid;">Cleaned the Air Filters</td>
				  <td align="center" valign="middle" style="border:hidden;border-top:1px solid;border-bottom:1px solid;border-right:1px solid;"><input type="checkbox" name="checkbox" id="checkbox"></td>
				  <td style="border:hidden;border-top:1px solid;border-bottom:1px solid;border-left:1px solid;">Replaced the Flush Tank</td>
				  <td align="center" valign="middle" style="border:hidden;border-top:1px solid;border-bottom:1px solid;border-right:1px solid;" ><input type="checkbox" name="checkbox2" id="checkbox2"></td>
				  <td style="border:hidden;border-top:1px solid;border-bottom:1px solid;border-left:1px solid;">Repaired/Replaced the Electrical Wires</td>
				  <td align="center" valign="middle" style="border-top:1px solid;border-bottom:1px solid;"><input type="checkbox" name="checkbox3" id="checkbox3"></td>
			    </tr>
				  <tr>
				  <td style="border-top:1px solid;border-bottom:1px solid;">Cleaned the A/C Diffuser</td>
				  <td align="center" valign="middle" style="border:hidden;border-top:1px solid;border-bottom:1px solid;border-right:1px solid;"><input type="checkbox" name="checkbox" id="checkbox"></td>
				  <td style="border:hidden;border-top:1px solid;border-bottom:1px solid;border-left:1px solid;">Repaired/Replaced the Bidet/Shatta/Hose</td>
				  <td align="center" valign="middle" style="border:hidden;border-top:1px solid;border-bottom:1px solid;border-right:1px solid;"><input type="checkbox" name="checkbox2" id="checkbox2"></td>
				  <td style="border:hidden;border-top:1px solid;border-bottom:1px solid;border-left:1px solid;">Replaced MCCB/MCB/CB/ELCB/Isolator</td>
				  <td align="center" valign="middle" style="border-top:1px solid;border-bottom:1px solid;"><input type="checkbox" name="checkbox3" id="checkbox3"></td>
			    </tr>
				  <tr>
				  <td style="border-top:1px solid;border-bottom:1px solid;">Flush the Drain Pipe</td>
				  <td align="center" valign="middle" style="border:hidden;border-top:1px solid;border-bottom:1px solid;border-right:1px solid;"><input type="checkbox" name="checkbox" id="checkbox"></td>
				  <td style="border:hidden;border-top:1px solid;border-bottom:1px solid;border-left:1px solid;">Repaired the water leakage</td>
				  <td align="center" valign="middle" style="border:hidden;border-top:1px solid;border-bottom:1px solid;border-right:1px solid;"><input type="checkbox" name="checkbox2" id="checkbox2"></td>
				  <td style="border:hidden;border-top:1px solid;border-bottom:1px solid;border-left:1px solid;">Replaced The Fused Lights/Fittings/Sockets</td>
				  <td align="center" valign="middle" style="border-top:1px solid;border-bottom:1px solid;"><input type="checkbox" name="checkbox3" id="checkbox3"></td>
			    </tr>
				  <tr>
				  <td style="border-top:1px solid;border-bottom:1px solid;">Checked the Gas Pressure</td>
				  <td align="center" valign="middle" style="border:hidden;border-top:1px solid;border-bottom:1px solid;border-right:1px solid;"><input type="checkbox" name="checkbox" id="checkbox"></td>
				  <td style="border:hidden;border-top:1px solid;border-bottom:1px solid;border-left:1px solid;">Repair/Replaced the Shower Mixer/Head</td>
				  <td align="center" valign="middle" style="border:hidden;border-top:1px solid;border-bottom:1px solid;border-right:1px solid;"><input type="checkbox" name="checkbox2" id="checkbox2"></td>
				  <td style="border:hidden;border-top:1px solid;border-bottom:1px solid;border-left:1px solid;">Repaired/Replaced Electrical Pump</td>
				  <td align="center" valign="middle" style="border-top:1px solid;border-bottom:1px solid;"><input type="checkbox" name="checkbox3" id="checkbox3"></td>
			    </tr>
				  <tr>
				  <td style="border-top:1px solid;border-bottom:1px solid;">Checked the Control Circuit</td>
				  <td align="center" valign="middle" style="border:hidden;border-top:1px solid;border-bottom:1px solid;border-right:1px solid;"><input type="checkbox" name="checkbox" id="checkbox"></td>
				  <td style="border:hidden;border-top:1px solid;border-bottom:1px solid;border-left:1px solid;">Repaired/Replaced the water Tap Mixture</td>
				  <td align="center" valign="middle" style="border:hidden;border-top:1px solid;border-bottom:1px solid;border-right:1px solid;"><input type="checkbox" name="checkbox2" id="checkbox2"></td>
				  <td style="border:hidden;border-top:1px solid;border-bottom:1px solid;border-left:1px solid;">Replaced A/C Switch</td>
				  <td align="center" valign="middle" style="border-top:1px solid;border-bottom:1px solid;"><input type="checkbox" name="checkbox3" id="checkbox3"></td>
			    </tr>
				  <tr>
				  <td style="border-top:1px solid;border-bottom:1px solid;">Gas Leak repair</td>
				  <td align="center" valign="middle" style="border:hidden;border-top:1px solid;border-bottom:1px solid;border-right:1px solid;"><input type="checkbox" name="checkbox" id="checkbox"></td>
				  <td style="border:hidden;border-top:1px solid;border-bottom:1px solid;border-left:1px solid;">Repaired/Replaced the Water Heater</td>
				  <td align="center" valign="middle" style="border:hidden;border-top:1px solid;border-bottom:1px solid;border-right:1px solid;"><input type="checkbox" name="checkbox2" id="checkbox2"></td>
				  <td style="border:hidden;border-top:1px solid;border-bottom:1px solid;border-left:1px solid;">Repaired/Replaced Ceiling Fan</td>
				  <td align="center" valign="middle" style="border-top:1px solid;border-bottom:1px solid;"><input type="checkbox" name="checkbox3" id="checkbox3"></td>
			    </tr>
			      <tr>
				  <td style="border-top:1px solid;border-bottom:1px solid;">Repaired / Replaced the fan motor</td>
				  <td align="center" valign="middle" style="border:hidden;border-top:1px solid;border-bottom:1px solid;border-right:1px solid;"><input type="checkbox" name="checkbox" id="checkbox"></td>
				  <td style="border:hidden;border-top:1px solid;border-bottom:1px solid;border-left:1px solid;">Repaired/Replaced the Water Tank Valve</td>
				  <td align="center" valign="middle" style="border:hidden;border-top:1px solid;border-bottom:1px solid;border-right:1px solid;"><input type="checkbox" name="checkbox2" id="checkbox2"></td>
				  <td style="border:hidden;border-top:1px solid;border-bottom:1px solid;border-left:1px solid;">Repaired/Replaced the Float Switch</td>
				  <td align="center" valign="middle" style="border-top:1px solid;border-bottom:1px solid;"><input type="checkbox" name="checkbox3" id="checkbox3"></td>
			    </tr>
				  <tr>
				  <td style="border-top:1px solid;border-bottom:1px solid;">Replaced Space Parts</td>
				  <td align="center" valign="middle" style="border:hidden;border-top:1px solid;border-bottom:1px solid;border-right:1px solid;"><input type="checkbox" name="checkbox" id="checkbox"></td>
				  <td style="border:hidden;border-top:1px solid;border-bottom:1px solid;border-left:1px solid;">Repaired/Replaced Ball Valve Syphon set</td>
				  <td align="center" valign="middle" style="border:hidden;border-top:1px solid;border-bottom:1px solid;border-right:1px solid;"><input type="checkbox" name="checkbox2" id="checkbox2"></td>
				  <td style="border:hidden;border-top:1px solid;border-bottom:1px solid;border-left:1px solid;">Replaced Electrical Fuse</td>
				  <td align="center" valign="middle" style="border-top:1px solid;border-bottom:1px solid;"><input type="checkbox" name="checkbox3" id="checkbox3"></td>
			    </tr>
				  <tr>
				  <td style="border-top:1px solid;border-bottom:1px solid;">Others</td>
				  <td align="center" valign="middle" style="border:hidden;border-top:1px solid;border-bottom:1px solid;border-right:1px solid;"><input type="checkbox" name="checkbox" id="checkbox"></td>
				  <td style="border:hidden;border-top:1px solid;border-bottom:1px solid;border-left:1px solid;">Others</td>
				  <td align="center" valign="middle" style="border:hidden;border-top:1px solid;border-bottom:1px solid;border-right:1px solid;"><input type="checkbox" name="checkbox2" id="checkbox2"></td>
				  <td style="border:hidden;border-top:1px solid;border-bottom:1px solid;border-left:1px solid;">Others</td>
				  <td align="center" valign="middle" style="border-top:1px solid;border-bottom:1px solid;"><input type="checkbox" name="checkbox3" id="checkbox3"></td>
			    </tr>
				  <tr>
				  <td colspan="2" align="center" valign="middle" bgcolor="#2e2e79" style="color: #FFFFFF;font-size:12px;"><strong>CIVIL</strong></td>
				  <td colspan="2" align="center" valign="middle" bgcolor="#2e2e79" style="color: #FFFFFF;font-size:12px"><strong>CLEANING</strong></td>
				  <td colspan="2" align="center" valign="middle" bgcolor="#2e2e79" style="color: #FFFFFF;font-size:12px;"><strong>OTHERS</strong></td>
			    </tr>
				  <tr >
				  <td style="">Repaired/Replaced the Door lock</td>
				  <td align="center" valign="middle" style="border-left:hidden;"><input type="checkbox" name="checkbox" id="checkbox"></td>
				  <td>General Cleaning</td>
				  <td align="center" valign="middle" style="border-left:hidden;"><input type="checkbox" name="checkbox2" id="checkbox2"></td>
				  <td>Vendor Management</td>
				  <td align="center" valign="middle" style="border-left:hidden;"><input type="checkbox" name="checkbox3" id="checkbox3"></td>
			    </tr>
				  <tr>
				  <td>Minor painting Works</td>
				  <td align="center" valign="middle" style="border-left:hidden;"><input type="checkbox" name="checkbox" id="checkbox"></td>
				  <td>Shampooing(Sofa/Carpet/Chair)</td>
				  <td align="center" valign="middle" style="border-left:hidden;"><input type="checkbox" name="checkbox2" id="checkbox2"></td>
				  <td>Swimming Pool Cleaning/maintenance</td>
				  <td align="center" valign="middle" style="border-left:hidden;"><input type="checkbox" name="checkbox3" id="checkbox3"></td>
			    </tr>
				  <tr>
				  <td>Painted the Room</td>
				  <td align="center" valign="middle" style="border-left:hidden;"><input type="checkbox" name="checkbox" id="checkbox"></td>
				  <td>Cleaning(Roof/Glass)</td>
				  <td align="center" valign="middle" style="border-left:hidden;"><input type="checkbox" name="checkbox2" id="checkbox2"></td>
				  <td>Pest control Services</td>
				  <td align="center" valign="middle" style="border-left:hidden;"><input type="checkbox" name="checkbox3" id="checkbox3"></td>
			    </tr>
				 <tr>
				  <td>Repaired the Wall Crack</td>
				  <td align="center" valign="middle" style="border-left:hidden;"><input type="checkbox" name="checkbox" id="checkbox"></td>
				  <td>Janitorial Services</td>
				  <td align="center" valign="middle" style="border-left:hidden;"><input type="checkbox" name="checkbox2" id="checkbox2"></td>
				  <td>Sewage Waste Removal</td>
				  <td align="center" valign="middle" style="border-left:hidden;"><input type="checkbox" name="checkbox3" id="checkbox3"></td>
			    </tr>
				 <tr>
				  <td>Repaired/Replaced the Floor or Wall Tiles</td>
				  <td align="center" valign="middle" style="border-left:hidden;"><input type="checkbox" name="checkbox" id="checkbox"></td>
				  <td>Messenger Services</td>
				  <td align="center" valign="middle" style="border-left:hidden;"><input type="checkbox" name="checkbox2" id="checkbox2"></td>
				  <td>Portable Appliance Testing</td>
				  <td align="center" valign="middle" style="border-left:hidden;"><input type="checkbox" name="checkbox3" id="checkbox3"></td>
			    </tr>
				<tr>
				  <td>Repaired/Replaced Roof Water Proofing</td>
				  <td align="center" valign="middle" style="border-left:hidden;"><input type="checkbox" name="checkbox" id="checkbox"></td>
				  <td>Deep Cleaning</td>
				  <td align="center" valign="middle" style="border-left:hidden;"><input type="checkbox" name="checkbox2" id="checkbox2"></td>
				  <td>Man Power services</td>
				  <td align="center" valign="middle" style="border-left:hidden;"><input type="checkbox" name="checkbox3" id="checkbox3"></td>
			    </tr>
				<tr>
				  <td>Minor Carpentry Works</td>
				  <td align="center" valign="middle" style="border-left:hidden;"><input type="checkbox" name="checkbox" id="checkbox"></td>
				  <td>Others</td>
				  <td align="center" valign="middle" style="border-left:hidden;"><input type="checkbox" name="checkbox2" id="checkbox2"></td>
				  <td>General Inspection</td>
				  <td align="center" valign="middle" style="border-left:hidden;"><input type="checkbox" name="checkbox3" id="checkbox3"></td>
			    </tr>
				<tr>
				  <td>Others</td>
				  <td align="center" valign="middle" style="border-left:hidden;"><input type="checkbox" name="checkbox" id="checkbox"></td>
				  <td colspan="2">&nbsp;</td>
				  <td>Snagging/De-snagging</td>
				  <td align="center" valign="middle" style="border-left:hidden;"><input type="checkbox" name="checkbox3" id="checkbox3"></td>
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