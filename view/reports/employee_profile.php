<?PHP
include(__DIR__ . '/../../model/db_connection/connection.php');
$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();

 	
	
?>
<!doctype html>
<html>
<head><meta charset="us-ascii">
	<title>Employee Profile</title>
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
   #export_excel_but {
    display: none;
  }
}
	</style>
</head>
<body>
     <?PHP 
     date_default_timezone_set('Asia/Bahrain');
     $result = mysqli_query($varDBConnection,"select *,DATE_FORMAT(joining_date,'%d-%m-%Y') as joining_date,DATE_FORMAT(cpr_expiry_date,'%d-%m-%Y') as cpr_expiry_date,DATE_FORMAT(visa_validity_on,'%d-%m-%Y') as visa_validity_on from  view_employee_expertiser_list where  employee_id=".$_GET["employee_id"]);
            while($row=mysqli_fetch_assoc($result)) {
     ?>
                                      
                                    
                                   
<table align="center" style="border: none;" width="800">
	<tbody>
		<tr style="border: none; ">
			<td style="border: none;" width="400">
			     <img src="../global_assets/images/logo_print.png"  />
			</td>
			<td style="border: none; color: #daa505;text-align: right;font-weight:700;padding-right:20px;" width="400">
			 
			   
			   
			</td>
		</tr>
		
		<tr style="border: none;">
			<td style="border: none;font-size: 15px;font-weight: 700;"><b>EMPLOYEE PROFILE</b></td>
			<td style="text-align: right;border: none;"><b>Date :</b> <?PHP  echo date("d-m-Y"); ?></td>
		</tr>
	</tbody>
</table>
<table id="main_table" align="center" style="border: none;">
    <tbody>
        <tr style="border: none;">
            <td style="border: none;">
                
            
<table align="center" width="800">
	<tbody>
	
		<tr>
			<td bgcolor="#2e2e79" colspan="6" style="color: #ffffff"><strong>EMPLOYEE DETAILS</strong></td>
		</tr>
		<tr>
		<td colspan="2" rowspan="4" align="center" valign="middle" ><img src="../../httpdocs/images/employee_image/<?PHP echo $row['employee_image']; ?>" width="160" height="184" border="1px" alt=""/></td>
		    <td style="text-align: center" width="170"><b>Employee Name: </b></td>
			<td width="225" style="text-align: left"><?PHP echo $row['employee_name']; ?></td>
			<td style="text-align: center" width="170"><b>Employee Type: </b></td>
			<?php if($row['employee_type_name']=='Technician'){?>
			<td style="text-align: left" width="225"><?php echo $row['employee_type_name'].' - '.$row['technician_type'];?></td>
			<?php }
			else
			{?>
			<td style="text-align: left" width="225"><?php echo $row['employee_type_name'];?></td>
			<?php }?>
		</tr>
		<tr>
			 <td style="text-align: center" width="170"><b>Employee Code: </b></td>
			<td width="225" style="text-align: left"><?PHP echo $row['employee_code']; ?></td>
			<td style="text-align: center" width="170"><b>CPR No: </b></td>
			<td style="text-align: left" width="225"><?php echo $row['cpr_no'];?></td>
		</tr>
		<tr>
			 <td style="text-align: center" width="170"><b>Contact No: </b></td>
			<td width="225" style="text-align: left"><?PHP echo $row['employee_contact_no']; ?></td>
			<td style="text-align: center" width="170"><b>Passport No: </b></td>
			<td style="text-align: left" width="225"><?php echo $row['passport_no'];?></td>
		</tr>
		<tr>
			 <td style="text-align: center" width="170"><b>Email Id: </b></td>
			<td width="225" style="text-align: left"><?PHP echo $row['employee_email_id']; ?></td>
			<td style="text-align: center" width="170"><b>Date of Join: </b></td>
			<td style="text-align: left" width="225"><?php echo $row['joining_date'];?></td>
		</tr>
		
	</tbody>
</table>

<p></p>



<p></p>

<table align="center" border="0" cellpadding="0" cellspacing="0" width="800">
	<tbody>
	    <tr>
			<td width="143" style="text-align: center" ><b>Address:</b></td>
			<td width="184" colspan="2"><?php echo $row['employee_address']; ?></td>
			<td width="143" style="text-align: center" ><b>Expertise:</b></td>
			<?php if($row['employee_type_name']=='Technician'){?>
			<td width="184" colspan="2"><?php echo $row['expertise_name']; ?></td>
			<?php } else {?>
				<td width="184" colspan="2"><?php echo $row['employee_type_name']; ?></td>
				<?php }?>
		</tr>
		<tr>
			<td width="143" style="text-align: center"><b>CPR Expiry Date:</b></td>
			<td width="184" ><?php echo $row['cpr_expiry_date']; ?></td>
			<td width="143" style="text-align: center"><b>Visa Type:</b></td>
			<td width="184" ><?php echo $row['visa_type']; ?></td>
			<td width="143" style="text-align: center"><b>Visa Validity Upto</b></td>
			<td width="107"><?php echo $row['visa_validity_on']; ?></td>
		</tr>
    	<tr>
			<td width="143" style="text-align: center"><b>Driving License:</b></td>
			<td width="184" ><?php echo $row['is_driving_license']; ?></td>
			<td width="143" style="text-align: center"><b>Blood Group:</b></td>
			<td width="184" ><?php echo $row['blood_group']; ?></td>
			<td width="143" style="text-align: center"><b>Native No.</b></td>
			<td width="107"><?php echo $row['native_number']; ?></td>
		</tr>
    	<tr>
			<td width="143" style="text-align: center" ><b>Native Address:</b></td>
			<td width="184" colspan="2"><?php echo $row['native_address']; ?></td>
			<td width="143" style="text-align: center" ><b>Status:</b></td>
			<td width="184" colspan="2"><?php echo $row['employee_status']; ?></td>
		</tr>
		
	</tbody>

</table>
</td>
        </tr>
    </tbody>
</table>
<p></p>
 <?PHP 
     
 } ?>
<p></p>
<div class="divFooter">
	<table align="center" border="0" cellpadding="0" cellspacing="0" width="800" style="border: none; padding: 25px;" >
	    <tr style="border: none; background-color: #2e2e79; padding: 25px;">
			<td style="border: none;padding-left: 20px;color:white" width="500">
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
<!--<footer>-->
    
<!--    <div style="text-align:right;padding-right:30px;">-->
<!--       <input type="button" value="Export To Excel" onclick="fnExcelReport();" id="export_excel_but">-->
      <!-- <input type="button" value="Print this page" onClick="window.print()" id="print_but">-->
        
<!--    </div>-->
<!--</footer>-->
</html>

<script>
function fnExcelReport()
{
    var tab_text="<table border='2px' ><tr bgcolor='#FFFFFF' style='border-bottom: 1px solid #FFFFFF;'>";
    var textRange; var j=0;
    tab = document.getElementById('main_table'); // id of table

    for(j = 0 ; j < tab.rows.length ; j++) 
    {     
        tab_text=tab_text+tab.rows[j].innerHTML+"</tr>";
        //tab_text=tab_text+"</tr>";
    }

    tab_text=tab_text+"</table>";
    tab_text= tab_text.replace(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table
   // tab_text= tab_text.replace(/<img[^>]*>/gi,""); // remove if u want images in your table
    tab_text= tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params

    var ua = window.navigator.userAgent;
    var msie = ua.indexOf("MSIE "); 

    if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer
    {
        txtArea1.document.open("txt/html","replace");
        txtArea1.document.write(tab_text);
        txtArea1.document.close();
        txtArea1.focus(); 
        sa=txtArea1.document.execCommand("SaveAs",true,"employees.xls");
    }  
    else                 //other browser not tested on IE 11
        sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));  

    return (sa);
}

</script>