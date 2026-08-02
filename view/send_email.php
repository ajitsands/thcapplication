<?php session_start();?>
<?php include(__DIR__ . '/../model/db_connection/connection.php'); 
        $DBConn = new DBConnection();
		$varDBConnection = $DBConn->ConnectToMYSQL();

?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $customer_code = $_POST['customer_code'];
  $email_id = $_POST['customer_email'];
  $pass = $_POST['customer_password'];
  $cust_name = $_POST['customer_name'];
    
    $username = htmlspecialchars($customer_code);
   
    $password = htmlspecialchars($pass);
    $customerName = htmlspecialchars($cust_name); 
   $message_title='Your access to the customer panel is provided below';
             $success_msg="Login credentials have been sent to your provided email address ";
    
    $email = filter_var($email_id, FILTER_VALIDATE_EMAIL);
    $panelLink    = "https://thccustomer.sianlab.com/login"; 
    // Check if email is valid
    if (!$email) {
        echo "Invalid email address.";
        exit;
    }

    $subject = "Your Login Credentials";
    $logoUrl = "https://thccustomer.sianlab.com/assets/svg/final_logo1.png";
    $message = "
<html>
<head>
  <meta charset='UTF-8'>
  <title>Customer Portal Login Details</title>
</head>
<body style='font-family: Arial, sans-serif; background-color: #f6f6f6; padding: 20px;'>
  <table width='100%' cellspacing='0' cellpadding='0' style='max-width: 600px; margin: auto; background-color: #ffffff; border-radius: 8px; overflow: hidden;'>
    <tr style='background-color: #004080;'>
      <td align='center' style='padding: 20px;'>
        <img src='$logoUrl' alt='Company Logo' width='150' style='display: block;'>
      </td>
    </tr>
    <tr>
      <td style='padding: 20px; color: #333;'>
        <h2>Welcome to THC Facility Management Portal</h2>
        <p>Dear <strong>$customerName</strong>,</p>
        <p>$message_title. You can log in to book & track service requests, view reports, and manage your account.</p>

        <p><strong>Login URL:</strong> <a href='$panelLink' target='_blank'>$panelLink</a></p>
        <p><strong>Username:</strong> $username</p>
        <p><strong>Password:</strong> $password</p>

        <p>If you have any questions or need support, feel free to contact our helpdesk.</p>

        <p style='margin-top: 30px;'>Best regards,<br>
        <strong>THC - Facility Management</strong><br>
        Customer Support Team</p>
      </td>
    </tr>
    <tr>
      <td align='center' style='padding: 15px; font-size: 12px; color: #888; background-color: #f0f0f0;'>
        &copy; " . date('Y') . " Your Company Name. All rights reserved.
      </td>
    </tr>
  </table>
</body>
</html>
";
    // Email headers
    $headers  = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8" . "\r\n";
    $headers .= "From: THC - Facility Management <admin@thc.com.bh>" . "\r\n";

    // Send email
    if (mail($email, $subject, $message, $headers)) {
        echo $success_msg.': '. $email.'.';
        mysqli_query($varDBConnection,'update tbl_customers set customer_password="'.$pass.'" where customer_code="'.$customer_code.'"');
        
        
    } else {
        echo "Failed to send email. Please try again later or contact THC Customer Support Team";
    }
}
?>