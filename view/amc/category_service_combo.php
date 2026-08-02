<?PHP
include "../../model/db_connection/connection.php" ;
$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();
$cus_id=$_POST['v_cust_id'];
 $result_cate= mysqli_query($varDBConnection,"select DISTINCT asset_category_id,asset_category_name from  tbl_assets where customer_id='".$cus_id."'");
	
?>



     <!--<select data-placeholder="Select expertise" id="select_expertise" class="form-control form-control-select2" data-fouc>-->
     <select class="form-control form-control-select2" id="select_cate" data-placeholder="Select Category" data-fouc>
	    <option>Select Category</option>
	    
	   <?PHP 	while($row_cate=mysqli_fetch_assoc($result_cate)) { ?>
          <option value="<?PHP echo $row_cate['asset_category_id']; ?>"><?PHP echo $row_cate['asset_category_name']; ?></option>
        
        <?PHP } ?>
      </select>
     	<span class="form-text text-muted"><font color="black">CATEGORY&nbsp;<span style="color:red;">*</span> </font></span>
