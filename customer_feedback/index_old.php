<?PHP
include "../model/db_connection/connection.php" ;
$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();
 //	$result = mysqli_query($varDBConnection,"select *,DATE_FORMAT(created_date_time,'%d-%m-%Y') as work_request_date,TIME_FORMAT(created_date_time,'%h:%i %p') as work_request_time,DATE_FORMAT(closed_on,'%d-%m-%Y') as date_delivered from tbl_tickets where ticket_id=".$_GET["ticket_id"]);
 		// $result = mysqli_query($varDBConnection,"select *,DATE_FORMAT(created_date_time,'%d-%m-%Y') as work_request_date,TIME_FORMAT(created_date_time,'%h:%i %p') as work_request_time,DATE_FORMAT(closed_on,'%d-%m-%Y') as date_delivered, DATE_FORMAT(closed_on,'%d-%m-%Y %h:%i %p') as closed_date_time,DATE_FORMAT(service_report_upload_date_time,'%d-%m-%Y %h:%i %p') as service_report_upload_date_time from tbl_tickets where ticket_id=".$_GET["ticket_id"]);
 		
 		// $result_services = mysqli_query($varDBConnection,"select * from tbl_ticket_services where ticket_service_status not in ('Pending','Processing','Cancelled') and ticket_id=".$_GET["ticket_id"]);
	//$amc_ref_no = $_GET["v_amc_ref_no"];	
	$result_amc_details = mysqli_query($varDBConnection,"select * from tbl_customer_feedback where question_status='Active' ");
		
	 while($row_amc_details=mysqli_fetch_assoc($result_amc_details)) {
		$customer_name = $row_amc_details['question_type'];
		$contract_type_name = $row_amc_details['question_name'];
		$amc_signed_date = $row_amc_details['q1'];
		$amc_start_date = $row_amc_details['q2'];
		$amc_end_date = $row_amc_details['q3']; 
		$amc_amount = $row_amc_details['q4'];
		$amc_vat_perct = $row_amc_details['q5'];
		$amc_vat_amt = $row_amc_details['q6'];
	 }
	
?>
<!doctype html>
<html>
<head><meta charset="us-ascii">
	<title>Customer Feedback</title>
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
			    <img src="../view/global_assets/images/logo_print.png"  />
			</td>
			<td style="border: none; color: #daa505;text-align: right;font-weight:700;padding-right:20px;" width="400">
			 
			   
			   
			</td>
		</tr>
	
		<!--<tr style="border: none;">-->
		<!--	<td style="border: none;"><?PHP //echo $amc_ref_no ; ?></td>-->
		<!--	<td style="border: none;"></td>-->
		<!--	<td style="text-align: right;border: none; font-size: 25px;font-weight: 700;"><b>AMC</b></td>-->
		<!--</tr>-->
	</tbody>
</table>

<table align="center" style="border: none;" width="800">
	<tbody>
		 <tr>
            <td colspan="7" style="border: none; ">
                1. How do you rate the timeliness of maintenance repairs?
            </td>
        </tr>
        <tr>
            <td style="border: none;"><input type="radio" name="q1" value="1"> 1</td>
        </tr>
        <tr>
            <td style="border: none;"><input type="radio" name="q1" value="2"> 2</td>
        </tr>
        <tr>
            <td style="border: none;"><input type="radio" name="q1" value="3"> 3</td>
        </tr>
        <tr>
            <td style="border: none;"><input type="radio" name="q1" value="4"> 4</td>
        </tr>
        <tr>
            <td style="border: none;"><input type="radio" name="q1" value="5"> 5</td>
        </tr>
        <tr>
            <td style="border: none;"><input type="radio" name="q1" value="0"> NA</td>
        </tr>
        
        <tr>
            <td colspan="7" style="border: none; ">
                2. How do you rate the professionalism and expertise of maintenance personnel?
            </td>
        </tr>
        <tr>
            <td style="border: none;"><input type="radio" name="q1" value="1"> 1</td>
        </tr>
        <tr>
            <td style="border: none;"><input type="radio" name="q1" value="2"> 2</td>
        </tr>
        <tr>
            <td style="border: none;"><input type="radio" name="q1" value="3"> 3</td>
        </tr>
        <tr>
            <td style="border: none;"><input type="radio" name="q1" value="4"> 4</td>
        </tr>
        <tr>
            <td style="border: none;"><input type="radio" name="q1" value="5"> 5</td>
        </tr>
        <tr>
            <td style="border: none;"><input type="radio" name="q1" value="0"> NA</td>
        </tr>
        
        <tr>
            <td colspan="7" style="border: none; ">
                3. How do you rate the attitude, courtesy, and appearance of maintenance personnel?
            </td>
        </tr>
        <tr>
            <td style="border: none;"><input type="radio" name="q1" value="1"> 1</td>
        </tr>
        <tr>
            <td style="border: none;"><input type="radio" name="q1" value="2"> 2</td>
        </tr>
        <tr>
            <td style="border: none;"><input type="radio" name="q1" value="3"> 3</td>
        </tr>
        <tr>
            <td style="border: none;"><input type="radio" name="q1" value="4"> 4</td>
        </tr>
        <tr>
            <td style="border: none;"><input type="radio" name="q1" value="5"> 5</td>
        </tr>
        <tr>
            <td style="border: none;"><input type="radio" name="q1" value="0"> NA</td>
        </tr>
        

        <tr>
            <td colspan="7" style="border: none; ">
                4. How do you rate the attitude, professionalism, and courtesy of administrative personnel?
            </td>
        </tr>
        <tr>
            <td style="border: none;"><input type="radio" name="q1" value="1"> 1</td>
        </tr>
        <tr>
            <td style="border: none;"><input type="radio" name="q1" value="2"> 2</td>
        </tr>
        <tr>
            <td style="border: none;"><input type="radio" name="q1" value="3"> 3</td>
        </tr>
        <tr>
            <td style="border: none;"><input type="radio" name="q1" value="4"> 4</td>
        </tr>
        <tr>
            <td style="border: none;"><input type="radio" name="q1" value="5"> 5</td>
        </tr>
        <tr>
            <td style="border: none;"><input type="radio" name="q1" value="0"> NA</td>
        </tr>
        
        <tr>
            <td colspan="7" style="border: none; ">
                5. How do you rate the timeliness and professionalism of administrative response to customer inquiries?
            </td>
        </tr>
        <tr>
            <td style="border: none;"><input type="radio" name="q1" value="1"> 1</td>
        </tr>
        <tr>
            <td style="border: none;"><input type="radio" name="q1" value="2"> 2</td>
        </tr>
        <tr>
            <td style="border: none;"><input type="radio" name="q1" value="3"> 3</td>
        </tr>
        <tr>
            <td style="border: none;"><input type="radio" name="q1" value="4"> 4</td>
        </tr>
        <tr>
            <td style="border: none;"><input type="radio" name="q1" value="5"> 5</td>
        </tr>
        <tr>
            <td style="border: none;"><input type="radio" name="q1" value="0"> NA</td>
        </tr>
        

        <tr>
            <td colspan="7" style="border: none; ">
                6. How do you rate the appearance and cleanliness of your property?
            </td>
        </tr>
       <tr>
            <td style="border: none;"><input type="radio" name="q1" value="1"> 1</td>
        </tr>
        <tr>
            <td style="border: none;"><input type="radio" name="q1" value="2"> 2</td>
        </tr>
        <tr>
            <td style="border: none;"><input type="radio" name="q1" value="3"> 3</td>
        </tr>
        <tr>
            <td style="border: none;"><input type="radio" name="q1" value="4"> 4</td>
        </tr>
        <tr>
            <td style="border: none;"><input type="radio" name="q1" value="5"> 5</td>
        </tr>
        <tr>
            <td style="border: none;"><input type="radio" name="q1" value="0"> NA</td>
        </tr>
        
		<tr>
            <td colspan="7" style="border: none; ">
                6. How do you rate the condition and adequacy of air conditioning systems within your building?
            </td>
        </tr>
        <tr>
            <td colspan="7" style="border: none; ">
                6. How do you rate the condition and adequacy of the plumbing systems& fixtures within your building?
            </td>
        </tr>
        <tr>
            <td colspan="7" style="border: none; ">
                6. How do you rate the health & safety standards followed by the THC Facility Management?
            </td>
        </tr>
        <tr>
            <td colspan="7" style="border: none; ">
                6. What is your overall experience with regards to service delivery by THC FM?
            </td>
        </tr>
	</tbody>
</table>

<p></p>  
<p></p>


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
			 
			    <img src="../view/global_assets/images/a.png" />
			   
			</td>
		</tr>
	</table>
</div>
<p></p>

<p></p>
</body>
</html>