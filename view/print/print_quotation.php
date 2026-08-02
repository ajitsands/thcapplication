<?PHP 
require ('../../model/common/common_functions.php');
   
   // var	$invoice_number,$invoice_date,$company_name,$po_box,$telephone_no,$fax,$address,$attn,$quotation_reference,$LPO_no;
   
   $db_con = new DBConnection();
   $conns = $db_con->ConnectToMYSQL();
    
    $result = mysqli_query($conns,"select * from  tbl_quotation_master  where quotation_ref_no = '".$_GET['quotation_number']."'");
    while($row=mysqli_fetch_assoc($result)) {
        $quotation_ref_no = $row['quotation_ref_no'];
        $date = date("m-d-Y", strtotime($row['date']));
        $amc_tkt_ref_no= $row['amc_tkt_ref_no'];
        $customer_name = $row['customer_name'];
        $po_box = $row['po_box'];
        $contact_no = $row['contact_no'];
        $address = $row['address'];
        $attention = $row['attention'];
        $subject = $row['subject'];
        $vat_content = $row['vat_content'];
        $terms_and_condition = $row['terms_and_condition'];
        $created_by_name = $row['created_by_name'];
       echo $terms_and_condition;
        
    } 
    
     function getCurrency($number)
    {
    $decimal = round($number - ($no = floor($number)), 3) * 1000;
    $hundred = null;
    $digits_length = strlen($no);
    $i = 0;
    $str = array();
    $words = array(0 => '', 1 => 'one', 2 => 'two',
        3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
        7 => 'seven', 8 => 'eight', 9 => 'nine',
        10 => 'ten', 11 => 'eleven', 12 => 'twelve',
        13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
        16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
        19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
        40 => 'forty', 50 => 'fifty', 60 => 'sixty',
        70 => 'seventy', 80 => 'eighty', 90 => 'ninety');
    $digits = array('', 'hundred','thousand','lakh', 'crore');
    while( $i < $digits_length ) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += $divider == 10 ? 1 : 2;
        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
            $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
            $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
        } else $str[] = null;
    }
    $Rupees = implode('', array_reverse($str));
    $paise = ($decimal > 0) ? ". " . ($words[$decimal / 100] . " " . $words[$decimal / 10]. " " . $words[$decimal % 10]) . ' ' : '';
    return ucwords(($Rupees ? $Rupees . ' ' : ' ') . $paise);
}
                               
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>THC Quotation</title>
		<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Spartan:wght@300;400&display=swap" rel="stylesheet">
    <style>
      body {
    font-family: 'Spartan', serif;
    font-size: 12px;
    text-align: left;
      }
    </style>
	
	<style>
      tr.border-bottom td {
        border-bottom: 1pt solid #000000;
      }
    </style>
	<style>
      tr.border-All td {
        border-left: 1pt solid #000000;
		border-bottom: 1pt solid #000000;  
		
      }
    </style>
</head>

<body>
<table width="800" border="0" align="center" cellpadding="2" cellspacing="0">
  <tbody>
    <tr>
      <td colspan="2"><img src="http://thc.sianlab.com/view/global_assets/images/backgrounds/login_logo_tch.png"  alt=""/></td>
    </tr>
    <tr>
      <td><strong>Our Ref: <?PHP echo $quotation_ref_no?></strong></td>
      <td style="text-align: right"><strong>Date: <?PHP echo date("d/m/Y")?> </strong></td>
    </tr>
    <tr>
      <td colspan="2"><p>To,<br>
        <strong><?PHP echo $customer_name ?>, </strong><br>
        <strong>P.O Box <?PHP echo $po_box  ?></strong><br>
        <strong><?PHP echo $address ?></strong><br>
      <strong>Kingdom of Bahrain</strong></p></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2"><p align="left"><strong>Kind Attn: Mr/Mrs. <?PHP echo $attention ?> - </strong></p></td>
    </tr>
   
    <tr>
      <td colspan="2"><p align="left"><strong><u>Sub: <?PHP echo $subject?></u></strong></p></td>
    </tr>
    
    <tr>
      <td colspan="2">With reference to subject job, we are pleased to  submit our offer as under-</td>
    </tr>
    
    <tr>
      <td colspan="2"><p><strong><u>Scope of works:</u></strong></p></td>
    </tr>
    <tr>
      <td colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="5" class="border-All">
        <tbody>
          <tr bgcolor="#DADADA" style="text-align: center" class="border-All">
            <td width="8%" style="border-top: 1pt solid #000000;"><strong>Sl.&nbsp;No.</strong></td>
            <td width="44%" style="border-top: 1pt solid #000000;"><strong>Description</strong></td>
            <td width="15%" style="border-top: 1pt solid #000000;"><strong>Qty.</strong></td>
            <td width="17%" style="border-top: 1pt solid #000000;"><p align="center"><strong>Unit Price</strong><br>
              <strong>(BHD)</strong></p></td>
            <td width="16%" style="border-right: 1pt solid #000000;border-top: 1pt solid #000000;"><strong>Total Price<br>
(BHD)</strong></td>
          </tr>
           <?PHP 
                $ctr = 1;
                $amt=0;
                 $result = mysqli_query($conns,"select * from  tbl_quotation_child where quotation_ref_no = '".$_GET['quotation_number']."'");
                     while($row=mysqli_fetch_assoc($result)) {
                         
            ?>
          <tr class="border-All">
            <td style="text-align: center"><?PHP echo $ctr;?></td>
            <td><?PHP echo $row['description']?> </td>
            <td style="text-align: center"><?PHP echo ($row['quantity']== 0 ?  '':  $row['quantity'].' '.$row['unit'] )?></td>
            <td style="text-align: center">&nbsp;<?PHP echo ($row['rate']== 0 ? '' :$row['rate']) ?> </td>
            <td style="text-align: center;border-right: 1pt solid #000000;"><?PHP echo ($row['total']==0 ? '':$row['total']) ; $amt = floor($amt) + floor($row['total']);?></td>
          </tr>
         
          <?PHP $ctr = $ctr +1; } ?>
         
          <tr class="border-All">
            <td colspan="4" bgcolor="#E1E1E1" style="text-align: right">TOTAL AMOUNT (EXCLUSIVE OF VAT) </td>
            <td bgcolor="#E1E1E1" style="text-align: center;border-right: 1pt solid #000000;"><?PHP echo number_format($amt,3) ?></td>
          </tr>
          <tr class="border-All">
            <td colspan="4" bgcolor="#E1E1E1" style="text-align: right">VAT 5%</td>
            <td bgcolor="#E1E1E1" style="text-align: center;border-right: 1pt solid #000000;"><?PHP echo number_format((floor($amt)*floor($vat_content)/100),3) ?></td>
          </tr>
          <tr class="border-All">
            <td colspan="4" bgcolor="#E1E1E1" style="text-align: right"><strong>THC NET TOTAL AMOUNT  (INCLUSIVE OF VAT)</strong></td>
            <td bgcolor="#E1E1E1" style="text-align: center;border-right: 1pt solid #000000;"><strong><?PHP echo number_format(floor($amt)+(floor($amt)*floor(5)/100),3)?></strong></td>
          </tr>
          <tr class="border-All">
            <td colspan="5" bgcolor="#E1E1E1" style="text-align: center;border-right: 1pt solid #000000;"><strong>Amount in Words: (Bahraini Dinars <?PHP echo getCurrency(number_format(floor($amt)+(floor($amt)*floor(5)/100),3));?> Only)</strong></td>
            </tr>
        </tbody>
      </table></td>
    </tr>
    <tr>
      <td colspan="2" align="left" valign="top"><?PHP echo $terms_and_condition; ?></td>
    </tr>
    <tr>
      <td><p><strong>Thanking  you,<br>
      </strong><strong>Yours sincerely,</strong><strong> </strong><strong> </strong>
        </p>
        </p>
        <p><strong>          </strong><br>
      </p></td>
      <td rowspan="2" align="left" valign="top" bgcolor="#D8D8D8" style="padding-left: 10px;border: 1pt solid #000000; "><p><strong>Approved  By:<br>
        <br>
        Name:<br>
        <br>
      Date:</strong></p></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2"><p><strong>Total Home Care W.L.L</strong></p></td>
    </tr>
    <tr>
      <td colspan="2"><p>&nbsp;</p>
      <p>&nbsp;</p></td>
    </tr>
    <tr>
      <td colspan="2"><p><strong>Naushad  Noor</strong><strong> </strong><br>
        <strong>Operations</strong><br>
      <strong>+973 33123543</strong></p></td>
    </tr>
  </tbody>
</table>
</body>
</html>
