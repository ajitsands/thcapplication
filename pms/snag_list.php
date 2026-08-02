<?PHP
include "../model/db_connection/connection.php" ;
$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();

    $sql_condition='';
                
                if($_GET['v_location']=='0')
                {
                    $sql_condition=$sql_condition;
                }
                else
                {
                    $sql_condition=$sql_condition." location = '".$_GET['v_location']."'  and";
                }
                
                if($_GET['v_place']=='0')
                {
                   
                    $sql_condition=$sql_condition;
                }
                else
                {
                   
                    $sql_condition=$sql_condition." place = '".$_GET['>v_place']."' and";
                }
                if($_GET['v_parts']=='0')
                {
                    $sql_condition=$sql_condition;
                }
                else
                {
                    $sql_condition=$sql_condition." parts = '".$_GET['v_parts']."' and";
                }
                
                if($_GET['v_category']=='0')
                {
                    $sql_condition=$sql_condition;
                }
                else
                {
                    $sql_condition=$sql_condition." category = '".$_GET['v_category']."' and";
                }
                if($_GET['v_priority']=='0')
                {
                    $sql_condition=$sql_condition;
                }
                else
                {
                    $sql_condition=$sql_condition." priority = '".$_GET['v_priority']."' and";
                }
                if($_GET['v_emp']=='0')
                {
                    $sql_condition=$sql_condition;
                }
                else
                {
                    $sql_condition=$sql_condition." inserted_id = ".$_GET['v_emp']." and";
                }
               if($_GET['v_project_id']==0)
               {
                   $sql_condition=$sql_condition;
               }
               else
               {
                   $sql_condition=$sql_condition." project_id = '".$_GET['v_project_id']."' and";
               }
                
               if($sql_condition=='')
                {
                    $sql="select project_entries_id,project_id,project_name,description,location,place,parts,category,comments,priority,pic_name,inserted_date,inserted_id,inserted_name from 	tbl_project_entries where  inserted_date >='".$_GET['v_date']."'  and inserted_date <='".$_GET['v_todate']."'    order by project_entries_id asc";
                    
                   
                }
                else
                {
                    $sql_condition=substr($sql_condition, 0, -3);
                    $sql="select project_entries_id,project_id,project_name,description,location,place,parts,category,comments,priority,pic_name,inserted_date,inserted_id,inserted_name from 	tbl_project_entries where  inserted_date >='".$_GET['v_date']."'  and inserted_date <='".$_GET['v_todate']."'   and ".$sql_condition."  order by project_entries_id asc";
                  
                   
                }
                $result = mysqli_query($varDBConnection,$sql);
                 $rowcount=mysqli_num_rows($result)
                         
?>
<html lang="en">
<head>
<title>Snag List</title>
 <!--   <link href="https://fonts.googleapis.com" rel="preconnect" />-->
	<!--<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />-->
	<!--<link href="https://fonts.googleapis.com/css2?family=Montserrat&amp;display=swap" rel="stylesheet" />-->
	
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap" rel="stylesheet">
<style type="text/css">
/*body,td,th {*/
/*    font-family:  'Montserrat', sans-serif;*/
/*    font-style: normal;*/
/*    font-size: 13pt;*/
/*    color: #000000;*/
    
/*}*/
@media print {
  div.divFooter {
    position: fixed;
    bottom: 0;
  }
   #export {
    display: none;
  }
}
</style>
</head>
<div id="tableHolder" style="font-family: 'Montserrat', sans-serif;">
	<table width="800px" border="0" align="center" cellpadding="3" cellspacing="0" id="tblExport" class="table2excel table2excel_with_colors">
    
    <tr>
       <td colspan="3" rowspan="5" style="text-align:center;vertical-align: middle;"><img src="https://sianlab.com/thc/pms/thc_logo.png" width="250" height="150" /></td>
      <td colspan="4" style="border: 1px solid black;border-collapse: collapse;font-size: 25pt;text-align:center;"><strong>SNAG LIST </strong></td>
      <td colspan="2" rowspan="5" style="text-align:center;vertical-align: middle;"><img src="https://sianlab.com/thc/pms/logos.jpg" /></td>
      <td colspan="3" rowspan="5" style="text-align:center;vertical-align: middle;"></td>
    </tr>
    <tr >
      <td colspan="2" bgcolor="#e6f2ff" style="border: 1px solid black;border-collapse: collapse;font-size: 13pt;text-align:center">Project Name</td>
      <td colspan="2" style="border: 1px solid black;border-collapse: collapse;font-size: 13pt;text-align:center"><?php echo $_GET['v_project_name'];?></td>
    </tr>
    <tr>
      <td colspan="2" bgcolor="#e6f2ff" style="border: 1px solid black;border-collapse: collapse;font-size: 13pt;text-align:center">Location</td>
      <td colspan="2" style="border: 1px solid black;border-collapse: collapse;font-size: 13pt;text-align:center"></td>
    </tr>
    <tr >
      <td colspan="2" bgcolor="#e6f2ff" style="border: 1px solid black;border-collapse: collapse;font-size: 13pt;text-align:center">Date</td>
      <!--<td colspan="2" style="border: 1px solid black;border-collapse: collapse;font-size: 13pt;text-align:center"><?PHP date_default_timezone_set('Asia/Bahrain'); echo date("d-m-Y");  ?></td>-->
       <td colspan="2" style="border: 1px solid black;border-collapse: collapse;font-size: 13pt;text-align:center"><?PHP date_default_timezone_set('Asia/Bahrain'); echo date("d/m/Y", strtotime($_GET['v_date'])).' - '.date("d/m/Y", strtotime($_GET['v_todate'])); ?></td>
    </tr>
    <tr >
      <td colspan="2" bgcolor="#e6f2ff" style="border: 1px solid black;border-collapse: collapse;font-size: 13pt;text-align:center">Total No. of Snags</td>
      <td colspan="2" style="border: 1px solid black;border-collapse: collapse;font-size: 13pt;text-align:center"><?php echo $rowcount;?></td>
    </tr>
    
    <tr>
      <td colspan="12"><table  width="100%" border="0" cellspacing="0" cellpadding="5" style="border: 1px solid black;border-collapse: collapse;font-size: 13pt;">
      
          <tr style=" border: 1px solid black;border-collapse: collapse;font-size: 13pt;background-color: #e6f2ff;">
            <td style=" border: 1px solid black;border-collapse: collapse;font-size: 13pt;background-color: #e6f2ff;text-align:center;width:30px"><strong>Sl.</strong></td>
            <td style=" border: 1px solid black;border-collapse: collapse;font-size: 13pt;background-color: #e6f2ff;text-align:center;"><strong>Description</strong></td>
            <td style=" border: 1px solid black;border-collapse: collapse;font-size: 13pt;background-color: #e6f2ff;text-align:center;"><strong>Location</strong></td>
            <td style=" border: 1px solid black;border-collapse: collapse;font-size: 13pt;background-color: #e6f2ff;text-align:center;"><strong>Place</strong></td>
            <td style=" border: 1px solid black;border-collapse: collapse;font-size: 13pt;background-color: #e6f2ff;text-align:center;"><strong>Part</strong></td>
            <td style=" border: 1px solid black;border-collapse: collapse;font-size: 13pt;background-color: #e6f2ff;text-align:center;width: 120px"><strong>THC Comments </strong></td>
            <td style=" border: 1px solid black;border-collapse: collapse;font-size: 13pt;background-color: #e6f2ff;text-align:center;"><strong>Category</strong></td>
            <td style=" border: 1px solid black;border-collapse: collapse;font-size: 13pt;background-color: #e6f2ff;text-align:center;"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Photo &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></td>
            <td style=" border: 1px solid black;border-collapse: collapse;font-size: 13pt;background-color: #e6f2ff;text-align:center;width:100px"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Status&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></td>
            <td style=" border: 1px solid black;border-collapse: collapse;font-size: 13pt;background-color: #e6f2ff;text-align:center;width:100px"><strong>Project Remarks</strong></td>
            <td style=" border: 1px solid black;border-collapse: collapse;font-size: 13pt;background-color: #e6f2ff;text-align:center;width:100px"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Remarks&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></td>
            <td style=" border: 1px solid black;border-collapse: collapse;font-size: 13pt;background-color: #e6f2ff;text-align:center;width:100px"><strong>Rectification Date</strong></td>
          </tr>
          <?php 
	            $i=0;

            	while($row=mysqli_fetch_assoc($result)) {
                   $i=$i+1; 
        ?>
         
          <tr style="border: 1px solid black;border-collapse: collapse;font-size: 13pt; height:114pt">
            <td style="border: 1px solid black;border-collapse: collapse;font-size: 13pt;vertical-align: middle;text-align:center;width:30px"><?php echo $i;?></td>
            <td style="border: 1px solid black;border-collapse: collapse;font-size: 13pt;vertical-align: middle;text-align:center"><?php echo $row['description'];?></td>
            <td style="border: 1px solid black;border-collapse: collapse;font-size: 13pt;vertical-align: middle;text-align:center"><?php echo $row['location'];?></td>
            <td style="border: 1px solid black;border-collapse: collapse;font-size: 13pt;vertical-align: middle;text-align:center"><?php echo $row['place'];?></td>
            <td style="border: 1px solid black;border-collapse: collapse;font-size: 13pt;vertical-align: middle;text-align:center"><?php echo $row['parts'];?></td>
            <td style="border: 1px solid black;border-collapse: collapse;font-size: 13pt;vertical-align: middle;text-align:center;"><?php echo $row['comments'];?></td>
            <td style="border: 1px solid black;border-collapse: collapse;font-size: 13pt;vertical-align: middle;text-align:center"><?php echo $row['category'];?></td>
            <td style="border: 1px solid black;border-collapse: collapse;font-size: 13pt;vertical-align: middle;width: 150px;height:114pt;display: inline-block;text-align:center"><img src="https://sianlab.com/thc/httpdocs/images/pms_uploads/<?php echo $row['pic_name'];?>" width="150" height="150"></td>
            <td style="border: 1px solid black;border-collapse: collapse;font-size: 13pt;vertical-align: middle;text-align:center">&nbsp;</td>
            <td style="border: 1px solid black;border-collapse: collapse;font-size: 13pt;vertical-align: middle;text-align:center;">&nbsp;</td>
            <td style="border: 1px solid black;border-collapse: collapse;font-size: 13pt;vertical-align: middle;text-align:center">&nbsp;</td>
            <td style="border: 1px solid black;border-collapse: collapse;font-size: 13pt;vertical-align: middle;text-align:center;">&nbsp;</td>
          </tr>
          <?PHP } ?>
          <tr>
            <td>Prepared By</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td colspan="12">&nbsp;</td>
            </tr>
        
      </table>
	
		</td>
    </tr>

</table>
</div>
<!--<button id="export" onclick="tableToExcel('tblExport', 'Snag List')" >Export to Excel</button>-->

<button id="export" >Export to Excel</button>

<input type="hidden" id="datatodisplay" name="datatodisplay">  
   
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>    
<script src="tableexport-2.1.js"></script>   

<script>
    
    $(document).ready(function() {
    	$("#export").click(function (e) {
            window.open('data:application/vnd.ms-excel,' + encodeURIComponent($('#tableHolder').html()));
            e.preventDefault();
        });
   
    
    
    
    // New Implementation
    
    //             $("#export").click(function(e){
                   
    // 					var table = $(this).prev('.table2excel');
    // 					if(table && table.length){
    // 						var preserveColors = (table.hasClass('table2excel_with_colors') ? true : false);
    // 						$(table).table2excel({
    // 							exclude: ".noExl",
    // 							name: "Excel Document Name",
    // 							filename: "myFileName" + new Date().toISOString().replace(/[\-\:\.]/g, "") + ".xlsx",
    // 							fileext: ".xlsx",
    // 							exclude_img: true,
    // 							exclude_links: true,
    // 							exclude_inputs: true,
    // 							preserveColors: preserveColors
    // 						});
    // 					}
				// });
    
});

</script>    

<script type="text/javascript">
var tableToExcel = (function() {
  var uri = 'data:application/vnd.ms-excel;base64,'
    , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
    , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
    , format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
  return function(table, name) {
    if (!table.nodeType) table = document.getElementById(table)
    var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
    window.location.href = uri + base64(format(template, ctx))
  }
})()
</script>
</html></html>
