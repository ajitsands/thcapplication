<?PHP 
require(__DIR__ . '/../../model/common/common_functions.php');
   
   // var	$invoice_number,$invoice_date,$company_name,$po_box,$telephone_no,$fax,$address,$attn,$quotation_reference,$LPO_no;
   
   $db_con = new DBConnection();
   $conns = $db_con->ConnectToMYSQL();
    
    $result = mysqli_query($conns,"select * from  tbl_mateial_requisition  where requisition_serial_no = '".$_GET['requsition_number']."'");
    while($row=mysqli_fetch_assoc($result)) {
        $requisition_serial_no = $row['requisition_serial_no'];
        $requisition_date = date("m-d-Y", strtotime($row['requisition_date']));
        $amc_tkt_ref_no= $row['amc_tkt_ref_no'];
        $customer_name = $row['customer_name'];
        $prepared_by = $row['prepared_by'];
       
        
    } 
    
    
    
         
         
    
                               
?>


<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
	
	<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Spartan:wght@300;400&display=swap" rel="stylesheet">
    <style>
      body {
    font-family: 'Spartan', serif;
    font-size: 14px;
    text-align: center;
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
      
      @media print {
      #print_but {
        display: none;
      }
      #export_excel_but {
        display: none;
      }
    }
    </style>
</head>


<body>
	
	<table width="1200"  align="center" cellpadding="0" cellspacing="0" bord id="main_table">
  <tbody>
    <tr >
      <td width="204" rowspan="2"><img src="http://thc.sianlab.com/view/global_assets/images/backgrounds/login_logo_tch.png"  alt=""/></td>
      <td width="409" style="text-align: center"><strong>IN OUT TOTAL HOME CARE </strong><br>
        <span style="font-size: 10px">Tele: +973 17100190, Fax : +973 77226060, Email : info@thc.com.bh<br>
        PO BOX 15069, Kingdom of Bahrain</span></td>
      <td width="179" style="text-align: center"><strong>Sl No : <?PHP echo $requisition_serial_no ?></strong><br>
<br>
      Date : <?PHP echo date("d/m/Y")?> </td>
    </tr>
    <tr >
      <td align="center">&nbsp;<span style="font-weight: bold; text-align: center;">MATERIAL REQUISITION FORM</span></td>
      <td>&nbsp;</td>
    </tr>
	<tr >
      <td colspan="3" style="border-top: 1pt solid #000000;">
		  <table width="100%"  cellspacing="0" cellpadding="5" style="font-size:11px;">
        <tbody>
          <tr class="border-All">
            <td width="52%" style="text-align: left">Person Preparing Requsition:  <?PHP echo $prepared_by ?>  </td>
            <td width="13%">Site Delevery              </td>
            <td width="6%" style="text-align: center"><input type="checkbox" name="checkbox" id="checkbox"></td>
            <td width="7%">Stock</td>
            <td width="6%" style="text-align: center"><input type="checkbox" name="checkbox3" id="checkbox3"></td>
            <td width="10%">Sampling</td>
            <td width="6%" style="text-align: center;border-right: 1pt solid #000000;"><input type="checkbox" name="checkbox5" id="checkbox5"></td>
          </tr>
          <tr class="border-All">
            <td style="text-align: left">Name &amp; Location</td>
            <td>Own Use</td>
            <td style="text-align: center"><input type="checkbox" name="checkbox2" id="checkbox2"></td>
            <td>Resale</td>
            <td style="text-align: center"><input type="checkbox" name="checkbox4" id="checkbox4"></td>
            <td>Non-Stock</td>
            <td style="text-align: center; border-right: 1pt solid #000000;"><input type="checkbox" name="checkbox6" id="checkbox6"></td>
          </tr >
          <tr class="border-All">
            <td style="text-align: left">Of Usage</td>
            <td colspan="6" style="text-align: center; border-right: 1pt solid #000000;">&nbsp;</td>
            </tr>
        </tbody>
      </table></td>
    </tr>
	<tr>
	  <td colspan="3"><table width="100%" cellspacing="0" cellpadding="5" style="font-size:11px;">
	    <tbody>
	      <tr class="border-All">
	        <td width="6%" style="text-align: center"><strong>Sl NO</strong></td>
	        <td width="48%" style="text-align: center"><strong>Description</strong></td>
	        <td width="9%" style="text-align: center"><strong>Qty</strong></td>
	        <td width="9%" style="text-align: center"><strong>Unit</strong></td>
	        <td width="14%" style="text-align: center"><strong>Unit Rate<br>
	          (BD)</strong></td>
	        <td width="14%" style="text-align: center; border-right: 1pt solid #000000;"><strong>Total Amount<br>
	          (BD)</strong></td>
	        </tr>
	         <?PHP 
                $ctr = 1;
                $amt=0;
                 $result = mysqli_query($conns,"select * from  tbl_requision_child where requisition_serial_no = '".$_GET['requsition_number']."'");
                     while($row=mysqli_fetch_assoc($result)) {
                         
                ?>
	        <tr class="border-All">
	       
	      
	        <td style="text-align: center"><?PHP echo $ctr;?></td>
	        <td style="text-align: center"><?PHP echo $row['product_item_name'];?></td>
	        <td style="text-align: center"><?PHP echo $ctr;echo $row['product_quantity'];?></td>
	        <td style="text-align: center"><?PHP echo $row['product_unit'];?></td>
	        <td style="text-align: center; "><?PHP  echo $row['product_unit_rate'];?></td>
	        <td style="text-align: center; border-right: 1pt solid #000000;"><?PHP echo $row['grant_total'];  $amt = floor($amt) + floor($row['grant_total']);?></td>
	        </tr>
	       
	        
	        <?PHP $ctr = $ctr +1; } ?>
	        
	        
	      <tr class="border-All">
	        <td style="text-align: center">&nbsp;</td>
	        <td style="text-align: right"><strong>Total</strong></td>
	        <td style="text-align: center">&nbsp;</td>
	        <td style="text-align: center">&nbsp;</td>
	        <td style="text-align: center">&nbsp;</td>
	        <td style="text-align: center; border-right: 1pt solid #000000;"><?PHP echo number_format($amt,3) ?></td>
	        </tr>
	      </tbody>
      </table></td>
    </tr>
	<tr>
	  <td colspan="3"><table width="100%" border="0" cellspacing="0" cellpadding="5" style="font-size:11px;">
	    <tbody>
	      <tr >
	        <td style="text-align: center" ><strong>Prepared by</strong></td>
	        <td style="text-align: center"><strong>Raised By</strong></td>
	        <td style="text-align: center"><strong>Procurement</strong></td>
	        <td style="text-align: center"><strong>Checked by</strong></td>
	        </tr>
	      <tr class="border-bottom">
	        <td height="35">&nbsp;</td>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	        </tr>
	      <tr>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	        </tr>
	      </tbody>
      </table></td>
    </tr>
	<tr>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
    </tr>
  </tbody>
</table>
	<footer>
    
    <div style="text-align:right;padding-right:30px;">
       <input type="button" value="Export To Excel" onclick="fnExcelReport();" id="export_excel_but">
       <input type="button" value="Print this page" onClick="window.print()" id="print_but">
        
    </div>
  </footer>
</body>
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
        sa=txtArea1.document.execCommand("SaveAs",true,"incomeexpense.xls");
    }  
    else                 //other browser not tested on IE 11
        sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));  

    return (sa);
}


</script>