<?PHP


require('../../model/db_connection/connection.php');
require('datafromdb.php');

require_once('tcpdf_include.php');


class MYPDF extends TCPDF {
        public $v_agreement_id ,$apply_seal;
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
	    public function values($ids,$apply_seals)
	    {
	        $this->v_agreement_id = $ids;
	        $this->apply_seal = $apply_seals;
	    }
	
	
	     public function Header() {
        // Logo
            $image_file = "images/blueprinthead.png";
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

           if(file_exists("../../upload/".$this->v_agreement_id."-SP-1.png"))
           {
               $path_sp = "../../upload/".$this->v_agreement_id."-SP-1.png";
           }
           else
           {
               $path_sp = "../../upload/dummy.png";
           }
           
           if(file_exists("../../upload/".$this->v_agreement_id."-V1-1.png"))
           {
               $path_v1 = "../../upload/".$this->v_agreement_id."-V1-1.png";
           }
           else
           {
               $path_v1 = "../../upload/dummy.png";
           }
           
           if(file_exists("../../upload/".$this->v_agreement_id."-V2-1.png"))
           {
               $path_v2 = "../../upload/".$this->v_agreement_id."-V2-1.png";
           }
           else
           {
               $path_v2 = "../../upload/dummy.png";
           }


           $logoX = 30; // 
           $logoFileName = $path_sp;
           $logoWidth = 30; // 15mm
           
           $logoXV1 = 125; // 
           $logoFileNameV1 = $path_v1;
           $logoWidthV1 = 30; // 15mm
           
           $logoXV2 = 170; // 
           $logoFileNameV2 = $path_v2;
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
        
            if($this->apply_seal =="true")
            {
               $seal_path = "../../print/seal.png";
            }
            else
            {
                $seal_path = "../../print/dummy.png";
            }
        
           $logo_seal_x = 85; // 
           $logoFileName_seal = $seal_path;
           $logoWidth_seal = 15; // 15mm
           $logo_y_seal = 158;
           $this->Image($logoFileName_seal, $logo_seal_x, $logo_y_seal, $logoWidth);
           
           
          // First Party Signature
          $logo_seal_x_f = 30; // 
          $logoFileName_seal_f = "../../upload/".$this->v_agreement_id."-FP-1.png";
          $logoWidth_seal_f = 30; // 15mm
          $logo_y_seal_f = 190;
          $this->Image($logoFileName_seal_f, $logo_seal_x_f, $logo_y_seal_f, $logoWidth_seal_f);
          
          //Second Party 
          $logo_seal_x_f = 20; // 
          $logoFileName_seal_f = "../../upload/".$this->v_agreement_id."-SP-1.png";
          $logoWidth_seal_f = 30; // 15mm
          $logo_y_seal_f = 228;
          $this->Image($logoFileName_seal_f, $logo_seal_x_f, $logo_y_seal_f, $logoWidth_seal_f);
           
          $logo_seal_x_f = 20; // 
          $logoFileName_seal_f = "../../upload/".$this->v_agreement_id."-WS2-1.png";
          $logoWidth_seal_f = 30; // 15mm
          $logo_y_seal_f = 257;
          $this->Image($logoFileName_seal_f, $logo_seal_x_f, $logo_y_seal_f, $logoWidth_seal_f); 
          
          
          $logo_seal_x_f = 115; // 
          $logoFileName_seal_f = "../../upload/".$this->v_agreement_id."-WS1-1.png";
          $logoWidth_seal_f = 30; // 15mm
          $logo_y_seal_f = 257;
          $this->Image($logoFileName_seal_f, $logo_seal_x_f, $logo_y_seal_f, $logoWidth_seal_f); 
           
           $this->isLastPage = true;
    }



}




$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->values($agreement_id,$apply_seal);


$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('SaNDS Lab');
$pdf->SetTitle($second_party_name.'--'.$agreement_id);
$pdf->SetSubject('Tenent Contract');
$pdf->SetKeywords('Bahrain Tenent Contact');


$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);



$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

 


$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);


$pdf->SetMargins(18, 100, 20);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);


$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);


$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);


if (@file_exists(dirname(__FILE__).'/lang/ara.php')) {
	require_once(dirname(__FILE__).'/lang/ara.php');
	$pdf->setLanguageArray($l);
}



$pdf->setFontSubsetting(true);


$pdf->SetFont('dejavusans', '', 10, '', true);



$pdf->AddPage();



$out_put_step1=str_replace('class="ql-align-center ql-direction-rtl"','style="text-align:center"',$out_put);
$out_put_step2=str_replace('class="ql-align-justify ql-direction-rtl"','style="text-align:justify"',$out_put_step1);
$out_put_step3=str_replace('class="ql-align-right ql-direction-rtl"','style="text-align:right"',$out_put_step2);
$out_put_step4=str_replace('class="ql-align-left ql-direction-rtl"','style="text-align:left"',$out_put_step3);
$out_put_step5=str_replace('style="direction: rtl;"','',$out_put_step4);

$html = <<<EOD

 	
	
<table width="95%" border="0"  cellpadding-left="30" cellpadding-right="30" cellspacing="0" border="0" style="text-align:justify;">
     <tbody>
    <tr>
      <td>$out_put_step5</td>
    </tr>
    <tr>
        <td>
            <br /><br/><br/>
        </td>
    </tr>
    <tr>
        <td style="text-align:right">ممثل السلطة المرخصة ألغراض هذا الترخيص</td>
    </tr>
    
     <tr>
        <td style="text-align:right">
                    <br><br>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tbody>
                        <tr>
                          <td>مدير عام بلدية المنطقة الجنوبية</td>
                          <td>التوقيع:</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>التاريخ:$first_party_sign_date  </td>
                        </tr>
                        <tr>
                          <br><br> <br>
                          <td>علم واستالم المرخص له: </td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td colspan="2">علمت بما ورد في هذا الترخيص من شروط واستلمت نسخة منه للعمل بموجبها، وأتعهد بالالتزام بكل شروط الترخيص 
			                             	    الاسم:</td>
                         
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>االسم: $second_party_name</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>التوقيع:</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                            <td>التاريخ:$second_party_sign_date  </td>
                       
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>االرقم الشخصي:$second_party_number</td>
                        </tr>
                        <br><br>
                        <tr>
                         <td>الشاهد االول:</td>
                         <td>الشاهد الثاني :</td>
                           
                        </tr>
                        
                        <tr>
                            <td>االسم: $witness1_name</td>
                            <td>االسم:$witness2_name </td>
                        </tr>
                         <tr>
                            <td> :التوقيع</td>
                            <td> :التوقيع</td>
                        </tr>
                        <tr>
                             <td>الرقم الشخصي:$witness1_personal_no </td>
                             <td>الرقم الشخصي:$witness2_personal_no </td>
                           
                        </tr>
                        
                      </tbody>
                    </table>
        </td>
    </tr>
  </tbody>
</table>

EOD;

// Add Javascript code
//$pdf->IncludeJS($js);



// // Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, 'R', true);

// // ---------------------------------------------------------

// // Close and output PDF document
// // This method has several options, check the source code documentation for more information.
$pdf->Output('contract-'.$agreement_id.'.pdf', 'I');

// //============================================================+
// // END OF FILE
// //============================================================+