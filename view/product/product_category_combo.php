<?PHP include(__DIR__ . '/../model/db_connection/connection.php');
$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();
 	$result = mysqli_query($varDBConnection,"select product_category_id,product_category_name from  tbl_product_category ");

	
			
	
?>


<div class="col-lg-6 col-md-6 col-sm-12" id="div_category_select">	
     <!--<select data-placeholder="Select expertise" id="select_expertise" class="form-control form-control-select2" data-fouc>-->
     <select class="form-control form-control-select2" id="select_product_category" data-placeholder="Select Product Category" data-fouc>
	    <option value="select">Select Product Category</option>
	    
	    <?PHP 	while($row=mysqli_fetch_assoc($result)) { ?>
          <option value="<?PHP echo $row['product_category_id']; ?>"><?PHP echo $row['product_category_name']; ?></option>
        
        <?PHP } ?>
      </select>
     	<span class="form-text text-muted"><font color="black">PRODUCT CATEGORY </font></span>
</div>