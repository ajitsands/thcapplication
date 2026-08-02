<?PHP
session_start();
include "../../model/db_connection/connection.php" ;
$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();
    function getFormatDate($date){
    $date = substr($date,8,2).'-'.substr($date,5,2).'-'.substr($date,0,4);
    return $date;
    } 
    
   
     $emp_details = mysqli_query($varDBConnection,"SELECT * FROM `view_employee_expertiser_list` where employee_id=".$_GET["employee_id"]." ");
    while($emp_details_row=mysqli_fetch_array($emp_details)) { 

        $v_emp_name=$emp_details_row['employee_name'];
        $v_emp_type_name=$emp_details_row['employee_type_name'];
        $v_emp_code=$emp_details_row['employee_code'];
        $v_joining_date=$emp_details_row['joining_date'];
        
        $joindate = explode('-', $v_joining_date);
        $month = $joindate[1];
        $day   = $joindate[2];
        $year  = $joindate[0];
        $dateObj   = DateTime::createFromFormat('!m', $month);
        $monthName = $dateObj->format('F'); // March
        $v_emp_joining_date=$day.'-'. $monthName.'-'. $year;
        
        $v_emp_contact=$emp_details_row['employee_contact_no'];
        $v_emp_email=$emp_details_row['employee_email_id'];
        $v_emp_cpr_no=$emp_details_row['cpr_no'];
        
        $v_emp_cpr_ex=$emp_details_row['cpr_expiry_date'];
         $cprdate = explode('-', $v_emp_cpr_ex);
        $monthcpr = $cprdate[1];
        $daycpr   = $cprdate[2];
        $yearcpr  = $cprdate[0];
        
        $dateObjcpr   = DateTime::createFromFormat('!m', $month);
        $monthNamecpr = $dateObjcpr->format('F'); // March
        $v_emp_cpr_ex_date=$daycpr.'-'. $monthNamecpr.'-'. $yearcpr;
        
        $v_emp_passport_no=$emp_details_row['passport_no'];
        $v_emp_visa_validity=$emp_details_row['visa_validity_on'];
        
        $v_emp_blood_gp=$emp_details_row['blood_group'];
        $v_emp_driving_licence=$emp_details_row['is_driving_license'];
        if($v_emp_driving_licence=='')
        {
            $v_emp_driving_licence='No';
        }
        $v_emp_address=$emp_details_row['employee_address'];
        $v_emp_expirtise_name=$emp_details_row['expertise_name'];
         $v_emp_img=$emp_details_row['employee_image'];
        
        
        

}

 
       

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Employee Details</title>
	<style type="text/css">
body,td,th {
    font-family: Consolas, "Andale Mono", "Lucida Console", "Lucida Sans Typewriter", Monaco, "Courier New", monospace;
    font-style: normal;
    font-size: 12px;
    color: #000000;
    border-bottom: 1px solid #7F7F7F;
}
tr td img {
    text-align: center;
}
    </style>
</head>

<body>
<table width="800" border="0" cellspacing="0" cellpadding="5" align="center">
  <tbody>
  <tr>
    <td><img src="../global_assets/images/backgrounds/login_logo_tch.png" alt="Logo" width="138" height="135" /></td>
    <td colspan="2" style="font-size: 16px; font-style: normal; font-weight: bold;"><p>Total Home Care<br />
      Villa 342,Block 333 <br />
      Road 3307 <br />
      (973) 17 100 190, info@thc.com.bh<br />
      Kingdom of Bahrain <br />
    </p>
      </td>
  </tr>
    <tr>
      <td colspan="2" align="center" bgcolor="#F1C40F" style="font-size: 16px; font-style: normal; font-weight: bold;"><strong>EMPLOYEE DETAILS</strong></td>
    </tr>
    
	   <!--Loop Start-->
    
    	  
        <tr>
          <td colspan="2"><table width="800" border="0" cellspacing="0" cellpadding="5">
            <tbody>
            
              <tr>
                <td colspan="7" align="center" bgcolor="#EBEBEB" style="font-size: 14px; font-style: normal; font-weight: bold;">BASIC INFORMATION</td>
                </tr>
              <tr bgcolor="#EBEBEB">
                <td colspan="2" rowspan="9" align="center" valign="middle" ><img src="../../httpdocs/images/employee_image/<?PHP echo $v_emp_img;?>" width="160" height="184" border="1px" alt=""/></td>
                <td width="110" align="left" style="font-weight: normal">NAME</td>
                <td colspan="2" align="center" bgcolor="#FFFDFD" style="text-align: left"><?PHP echo $v_emp_name;?></td>
                <td width="121" align="left" style="font-weight: normal">TYPE</td>
                <td width="121" align="center" bgcolor="#FFFFFF" style="text-align: left"><?PHP echo $v_emp_type_name?></td>
              </tr>
              <tr bgcolor="#EBEBEB">
                <td align="left" style="font-weight: normal">CODE</td>
                <td colspan="2" align="center" bgcolor="#FFFDFD" style="text-align: left"><?PHP echo $v_emp_code;?></td>
                <td align="left" style="font-weight: normal">DOJ</td>
                <td width="121" align="center" bgcolor="#FFFFFF" style="text-align: left"><?PHP echo $v_emp_joining_date;?></td>
              </tr>
              <tr bgcolor="#EBEBEB">
                <td align="left" style="font-weight: normal">CONTACT No</td>
                <td colspan="2" align="center" bgcolor="#FFFDFD" style="text-align: left"><?PHP echo $v_emp_contact;?></td>
                <td align="left" style="font-weight: normal">EMAIL ID</td>
                <td width="121" align="center" bgcolor="#FFFFFF" style="text-align: left"><?PHP echo $v_emp_email;?></td>
              </tr>
              <tr bgcolor="#EBEBEB">
                <td align="left" style="font-weight: normal">CPR No</td>
                <td colspan="2" align="center" bgcolor="#FFFDFD" style="text-align: left"><?PHP echo $v_emp_cpr_no;?></td>
                <td align="left" style="font-weight: normal">CPR EXPIRY DATE</td>
                <td width="121" align="center" bgcolor="#FFFFFF" style="text-align: left"><?PHP echo $v_emp_cpr_ex_date;?></td>
              </tr>
              <tr bgcolor="#EBEBEB">
                <td align="left" style="font-weight: normal">PASSPORT NO</td>
                <td colspan="2" align="center" bgcolor="#FFFDFD" style="text-align: left"><?PHP echo $v_emp_passport_no;?></td>
                <td align="left" style="font-weight: normal">VISA EXPIRY DATE</td>
                <td width="121" align="center" bgcolor="#FFFFFF" style="text-align: left"><?PHP echo $v_emp_visa_validity;?></td>
              </tr>
              <tr bgcolor="#EBEBEB">
                <td align="left" style="font-weight: normal">BLOOD GROUP</td>
                <td colspan="2" align="center" bgcolor="#FFFDFD" style="text-align: left"><?PHP echo $v_emp_blood_gp;?></td>
                <td align="left" style="font-weight: normal">DRIVING LICENSE</td>
                <td width="121" align="center" bgcolor="#FFFFFF" style="text-align: left"><?PHP echo $v_emp_driving_licence;?></td>
              </tr>
              
              <tr bgcolor="#EBEBEB">
                <td align="left" style="font-weight: normal">ADDRESS</td>
                <td colspan="4" align="center" bgcolor="#FFFDFD" style="text-align: left"><?PHP echo $v_emp_address;?></td>
                
              </tr>
             <?PHP if($v_emp_expirtise_name!='')
             {?>
              <tr>
                <td colspan="7" align="center" bgcolor="#E9E9E9" style="font-size: 14px; font-style: normal; font-weight: bold;"> TECHNICAL EXPERTISE</td>
              </tr>
             
              <tr>
                <td colspan="7" bgcolor="#FFFDFD" style="text-align: center"><?PHP echo $v_emp_expirtise_name;?></td>
               
              </tr>
              
<?PHP }?>
              
             
             


    <!--Outer Loop End-->
        </tbody>
      </table></td>
    </tr>
 
	
	</tbody>
</table>
</body>
</html>
