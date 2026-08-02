<?php
$ids = $_GET['ids'];
include(__DIR__ . '/../model/db_connection/connection.php');
$connection = new DBConnection();
$conn = $connection->ConnectToMYSQL();
?>

<!doctype html>
<html>
<head><meta charset="us-ascii">
	<title>Employee List</title>
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
     
                                     
                            
<table align="center" style="border: none;" width="1000" >
	<tbody>
		<tr style="border: none; ">
			<td style="border: none;" width="400">
			    <img src="global_assets/images/logo_print.png"  />
			</td>
			<td style="border: none; color: #ffffff;text-align: right;font-weight:700;padding-right:20px;" width="400">
			</td>
		</tr>
		<tr style="border: none;">
			<td style="border: none;"><b>EMPLOYEE TYPE LIST</b></td>
			<td style="text-align: right;border: none;"><b>Date :</b> <?PHP  echo date("d-m-Y"); ?></td>
		</tr>
	</tbody>
</table>

<table align="center" width="1000"  id="main_table">
	<tbody style="padding-bottom: 200px;" height="0px">
		
		<tr>
		    <td bgcolor="#2e2e79"  style="color: #ffffff;text-align: center;" width="100"><b>SL.No</b></td>
			<td bgcolor="#2e2e79"  style="color: #ffffff;text-align: center;" width="100"><b>Pic</b></td>
			<td bgcolor="#2e2e79"  style="color: #ffffff;text-align: center;" width="100"><b>Code</b></td>
		    <td bgcolor="#2e2e79"  style="color: #ffffff;text-align: center;" width="200"><b>Name</b></td>
			<td bgcolor="#2e2e79"  style="color: #ffffff;text-align: center;" width="100"><b>Type </b></td>
			<td bgcolor="#2e2e79"  style="color: #ffffff;text-align: center;" width="100"><b>Contact No</b></td>
			<td bgcolor="#2e2e79"  style="color: #ffffff;text-align: center;" width="100"><b>CPR No</b></td>
			<td bgcolor="#2e2e79"  style="color: #ffffff;text-align: center;" width="100"><b>Status</b></td>
		</tr>
		
	<?PHP 
	    $sql = "SELECT employee_id, employee_type_name, employee_code, employee_name, cpr_no, employee_email_id, employee_image, employee_contact_no, employee_status FROM tbl_employees WHERE employee_type_id IN($ids)";
        $result = mysqli_query($conn, $sql);
        $count=1;
        while($row=mysqli_fetch_assoc($result)) {
                
     ?>
	<tr>
	        <td style="text-align: center;" width="100"><?PHP echo $count; ?></td>
	        <td style="text-align: center;" width="100"><img src="../httpdocs/images/employee_image/<?PHP echo $row['employee_image']; ?>" width="60" height="60"  alt=""/></td>
			<?php $link="reports/employee_profile.php?employee_id=".$row['employee_id']; ?>
			<td style="text-align: center;" width="100"><a href="<?php echo $link; ?>" target="blank"><?PHP echo $row['employee_code']; ?></a></td>
			<td style="text-align: center;" width="200"><?PHP echo $row['employee_name']; ?></td>
			<td style="text-align: center;" width="100"><?PHP echo $row['employee_type_name']; ?></td>
	        <td style="text-align: center;" width="100"><?PHP echo $row['employee_contact_no']; ?></td>
			<td style="text-align: center;" width="100"><?PHP echo $row['cpr_no']; ?></td>
			<td style="text-align: center;" width="100"><?PHP if($row['employee_status']=='Active'){?><font style="color:green">Active</font> <?php } else {?><font style="color:red">Deactive</font> <?php } ?></td>
	</tr>
	 <?PHP $count=$count+1; } ?>
	</tbody>
</table>


<div class="divFooter" style="padding-top: 25px;" width="1100">
    
	<table align="center" border="0" cellpadding="0" cellspacing="0" width="1000" style="border: none; padding: 25px;" >
	    <tr style="border: none; background-color: #2e2e79; padding: 10px;">
			<td style="border: none;padding-left: 20px;color:white;" width="400">
			    <small>Tele:</small> +973 17 100 190 | info@thc.com.bh | <strong>www.thc.com.bh</strong><br>
			     CR. <strong>88982-1</strong> | Level 14, Enterance 143/144,  Bldg 155, Road 1703, Block 317<br>
			    <strong>YBA Kanoo Tower, Diplomatic Area</strong>, Kingdom of Bahrain
			</td>
			<td style="border: none;text-align: right;padding-right:20px;padding: 10px;color:white;padding-right:10px;" width="400">
			 
			        <img src="global_assets/images/a.png" />
			   
			</td>
		</tr>
	</table>
</div>
<p></p>

<p></p>
</div>

</body>
<!--<footer>-->
    
<!--    <div style="text-align:right;padding-right:30px;">-->
<!--       <input type="button" value="Export To Excel" onclick="fnExcelReport();" id="export_excel_but">-->
      <!-- <input type="button" value="Print this page" onClick="window.print()" id="print_but">-->
        
<!--    </div>-->
<!--</footer>-->
</html>

<script>
// function fnExcelReport()
// {
//     var tab_text="<table border='2px' ><tr bgcolor='#FFFFFF' style='border-bottom: 1px solid #FFFFFF;'>";
//     var textRange; var j=0;
//     tab = document.getElementById('main_table'); // id of table

//     for(j = 0 ; j < tab.rows.length ; j++) 
//     {     
//         tab_text=tab_text+tab.rows[j].innerHTML+"</tr>";
//         //tab_text=tab_text+"</tr>";
//     }

//     tab_text=tab_text+"</table>";
//     tab_text= tab_text.replace(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table
//   // tab_text= tab_text.replace(/<img[^>]*>/gi,""); // remove if u want images in your table
//     tab_text= tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params

//     var ua = window.navigator.userAgent;
//     var msie = ua.indexOf("MSIE "); 

//     if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer
//     {
//         txtArea1.document.open("txt/html","replace");
//         txtArea1.document.write(tab_text);
//         txtArea1.document.close();
//         txtArea1.focus(); 
//         sa=txtArea1.document.execCommand("SaveAs",true,"incomeexpense.xls");
//     }  
//     else                 //other browser not tested on IE 11
//         sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));  

//     return (sa);
// }

</script>