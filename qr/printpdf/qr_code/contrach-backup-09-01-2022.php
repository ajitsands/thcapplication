<?php


require('../../model/db_connection/connection.php');
require('datafromdb.php');

require_once('tcpdf_include.php');


class MYPDF extends TCPDF {
        public $v_agreement_id ;
	//Page header
// 	public function Header() {
// 		// Logo
// 		$image_file = K_PATH_IMAGES.'logo_example.jpg';
// 		$this->Image($image_file, 10, 10, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
// 		// Set font
// 		$this->SetFont('helvetica', 'B', 20);
// 		// Title
// 		$this->Cell(0, 15, '<< TCPDF Example 003 >>', 0, false, 'C', 0, '', 0, false, 'M', 'M');
// 	}

	// Page footer
	    public function values($ids)
	    {
	        $this->v_agreement_id = $ids;
	    }
	
	
	     public function Header() {
        // Logo
            $image_file = K_PATH_IMAGES."../images/blueprinthead.png";
            $this->Image($image_file, 0, 0, 210, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
            // Set font
            $this->SetFont('helvetica', 'B', 20);
            // Title
            $this->Cell(0, 15, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        }
	
	
	
	
		public function Footer() {
// 	    $image_file = K_PATH_IMAGES.'../../upload/10-V2.jpg';
// 	    $this->Image($image_file, 0, 208, 210, "", "JPG", "", "T", false, 300, "", false, false, 0, false, false, false);
	
// 		// Position at 15 mm from bottom
// 		$this->SetY(-15);
// 		// Set font
// 		$this->SetFont('helvetica', 'I', 8);
// 		// Page number
// 		$this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'M', 'M');

           $logoX = 30; // 
           $logoFileName = "../../upload/".$this->v_agreement_id."-SP-1.png";
           $logoWidth = 30; // 15mm
           
           $logoXV1 = 125; // 
           $logoFileNameV1 = "../../upload/".$this->v_agreement_id."-V1-1.png";
           $logoWidthV1 = 30; // 15mm
           
           $logoXV2 = 170; // 
           $logoFileNameV2 = "../../upload/".$this->v_agreement_id."-V2-1.png";
           $logoWidthV2 = 30; // 15mm
           
           $logoY = 283;
          
           $logo =  $this->getAliasNumPage().'/'.$this->getAliasNbPages() . $this->Image($logoFileName, $logoX, $logoY, $logoWidth).$this->Image($logoFileNameV1, $logoXV1, $logoY, $logoWidthV1).$this->Image($logoFileNameV2, $logoXV2, $logoY, $logoWidthV2) ;
        
           $this->SetX($this->w - $this->documentRightMargin - $logoWidth); // documentRightMargin = 18
           if($this->page == 1)
           {
               $this->Cell(10,10, $logo, 0, false, 'C', 0, '', 0, false, 'M', 'M');
           }
           else
           {
               $this->Cell(10,10, substr($logo,0,-3), 0, false, 'C', 0, '', 0, false, 'M', 'M');
           }
           // $this->Cell(10,10, substr($logo,0,-3), 0, false, 'C', 0, '', 0, false, 'M', 'M');
           
	}
	
	public function lastPage($resetmargins=false) {
        //$this->setPage($this->getNumPages(), $resetmargins);
        //$this->isLastPage = true;
           $logo_seal_x = 70; // 
           $logoFileName_seal = "../../print/seal.png";
           $logoWidth_seal = 15; // 15mm
           $logo_y_seal = 110;
           $this->Image($logoFileName_seal, $logo_seal_x, $logo_y_seal, $logoWidth);
           
           
           
        //   $logo_seal_x_f = 120; // 
        //   $logoFileName_seal_f = "../../upload/".$this->v_agreement_id."-FP-1.png";
        //   $logoWidth_seal_f = 15; // 15mm
        //   $logo_y_seal_f = 90;
        //   $this->Image($logoFileName_seal_f, $logo_seal_x_f, $logo_y_seal_f, $logoWidth_f);
           
           
           
           $this->isLastPage = true;
    }



}



// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->values($agreement_id);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('SaNDS Lab');
$pdf->SetTitle($second_party_name.'--'.$agreement_id);
$pdf->SetSubject('Tenent Contract');
$pdf->SetKeywords('Bahrain Tenent Contact');

// set default header data
//$pdf->SetHeaderData("../images/blueprinthead.png", 210, '', '', array(0,64,255), array(0,64,128));
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
//$pdf->setFooterData(array(0,64,0), array(0,64,128));

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));



// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(0, 100, 20);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/ara.php')) {
	require_once(dirname(__FILE__).'/lang/ara.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set default font subsetting mode
$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('dejavusans', '', 12, '', true);


// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();

// set text shadow effect
//$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

// Set some content to print

 

$html = <<<EOD

 	
	
<table width="95%" border="0"  cellpadding-left="30" cellpadding-right="30" cellspacing="0" border="0" >
     <tbody>
    <tr>
      <td>$out_put</td>
    </tr>
    
    <tr>
      <td><table width="95%" border="0" cellspacing="0" cellpadding="0" border="0" style="font-weight:800;">
        <tbody>
          <tr>
            <td align="right" valign="middle">
            
            &#1605;&#1605;&#1579;&#1604; &#1575;&#1604;&#1587;&#1604;&#1591;&#1577; &#1575;&#1604;&#1605;&#1585;&#1582;&#1589;&#1577; &#1571;&#1604;&#1594;&#1585;&#1575;&#1590; &#1607;&#1584;&#1575; &#1575;&#1604;&#1578;&#1585;&#1582;&#1610;&#1589;
            </td>
            <td align="right" valign="middle">
                    <br> <br> <br><br> <br> <br><br> <br> <br>
            </td>
          </tr>
          <tr>
            <td><table width="95%" border="0" cellspacing="0" cellpadding="0" border="0">
              <tbody>
                <tr>
                  <td style="text-align:left;"><img src="../../upload/$agreement_id-FP-1.png" width="100px" height="48px" border="0" /></td>
                  <td valign="middle">&#1575;&#1604;&#1578;&#1608;&#1602;&#1610;</td>
                </tr>
                <tr>
                  <td>$dates </td>
                  <td valign="middle">&#1575;&#1604;&#1578;&#1575;&#1585;&#1610;&#1582;</td>
                </tr>
              </tbody>
            </table></td>
            <td valign="middle">&#1605;&#1583;&#1610;&#1585; &#1593;&#1575;&#1605; &#1576;&#1604;&#1583;&#1610;&#1577; &#1575;&#1604;&#1605;&#1606;&#1591;&#1602;&#1577; &#1575;&#1604;&#1580;&#1606;</td>
          </tr>
        </tbody>
      </table></td>
    </tr>
    <tr>
      <td valign="middle">&#1593;&#1604;&#1605; &#1608;&#1575;&#1587;&#1578;&#1575;&#1604;&#1605; &#1575;&#1604;&#1605;&#1585;&#1582;&#1589; &#1604;&#1607;<br />
&#1593;&#1604;&#1605;&#1578; &#1576;&#1605;&#1575; &#1608;&#1585;&#1583; &#1601;&#1610; &#1607;&#1584;&#1575; &#1575;&#1604;&#1578;&#1585;&#1582;&#1610;&#1589; &#1605;&#1606; &#1588;&#1585;&#1608;&#1591; &#1608;&#1575;&#1587;&#1578;&#1604;&#1605;&#1578; &#1606;&#1587;&#1582;&#1577; &#1605;&#1606;&#1607; &#1604;&#1604;&#1593;&#1605;&#1604; &#1576;&#1605;&#1608;&#1580;&#1576;&#1607;&#1575;&#1548; &#1608;&#1571;&#1578;&#1593;&#1607;&#1583; &#1576;&#1575;&#1575;&#1604;&#1604;&#1578;&#1586;&#1575;&#1605; &#1576;&#1603;&#1604; &#1588;&#1585;&#1608;&#1591; &#1575;&#1604;&#1578;&#1585;&#1582;&#1610;&#1589;</td>
    </tr>
    <tr>
      <td><table width="95%" border="0" cellspacing="0" cellpadding="0">
        <tbody>
          <tr>
            <td>$second_party_name </td>
            <td>&#1575;&#1575;&#1604;&#1587;&#1605;</td>
          </tr>
          <tr>
            <td align="left"><img src="../../upload/$agreement_id-SP-1.png"  width="100px" height="48px;" border="0" />&nbsp;</td>
            <td valign="middle">&#1575;&#1604;&#1578;&#1608;&#1602;&#1610;&#1593;</td>
          </tr>
          <tr>
            <td>Contract Signing Date :$contract_date</td>
            <td>&#1575;&#1604;&#1578;&#1575;&#1585;&#1610;&#1582;</td>
          </tr>
          <tr>
            <td>CPR : $second_party_number</td>
            <td>&#1575;&#1604;&#1588;&#1582;&#1589;&#1610;&#1575;&#1604;&#1585;&#1602;&#1605;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&#1575;&#1604;&#1579;&#1575;&#1606;&#1610; &#1575;&#1604;&#1588;&#1575;&#1607;&#1583;</td>
            <td>&#1575;&#1575;&#1604;&#1608;&#1604; &#1575;&#1604;&#1588;&#1575;&#1607;&#1583;</td>
          </tr>
        </tbody>
      </table></td>
    </tr>
	  <tr>
	  	<td><table width="95%" border="0" cellspacing="0" cellpadding="0" bordder="0">
	  	  <tbody>
	  	    <tr>
	  	      <td>$witness2_name</td>
	  	      <td>&#1575;&#1575;&#1604;&#1587;&#1605;</td>
	  	      <td>$witness1_name</td>
	  	      <td>&#1575;&#1575;&#1604;&#1587;&#1605;</td>
  	        </tr>
	  	    <tr>
	  	      <td align="left" valign="middle"><img src="../../upload/$agreement_id-WS2-1.png" width="100px" height="48px;" border="0"/></td>
	  	      <td valign="middle">&#1575;&#1604;&#1578;&#1608;&#1602;&#1610;&#1593;</td>
	  	      <td align="left" valign="middle"><img src="../../upload/$agreement_id-WS1-1.png" width="100px" height="48px;" border="0" /></td>
	  	      <td valign="middle">&#1575;&#1604;&#1578;&#1608;&#1602;&#1610;&#1593;</td>
  	        </tr>
	  	    <tr>
	  	      <td align="center" valign="middle">2nd Witness CPR:$witness2_personal_no</td>
	  	      <td>&#1575;&#1604;&#1588;&#1582;&#1589;&#1610; &#1575;&#1604;&#1585;&#1602;&#1605;</td>
	  	      <td align="center" valign="middle">1st Witness CPR :$witness1_personal_no</td>
	  	      <td>&#1575;&#1604;&#1588;&#1582;&#1589;&#1610; &#1575;&#1604;&#1585;&#1602;&#1605;</td>
  	        </tr>
  	      </tbody>
  	    </table></td>
	  </tr>
	  <tr>
	    <td> </td>
    </tr>
  </tbody>
</table>

EOD;

// Add Javascript code
//$pdf->IncludeJS($js);



// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, 'R', true);

// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('contract-'.$agreement_id.'.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
