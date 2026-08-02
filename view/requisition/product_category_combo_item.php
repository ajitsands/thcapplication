<?PHP 
 	$result = mysqli_query($varDBConnection,"Select product_category_id,product_category_name from tbl_product_category where product_category_status='Active'");
	
			
	
?>


<div class="col-lg-4 col-md-4 col-sm-12" id="div_employee_select">	
     <select data-placeholder="Select Category Type" id="select_product_category_for_item" class="form-control form-control-select2" data-fouc>
         <option value="select">SELECT CATEGORY TYPE</option>
        <?PHP 	while($row=mysqli_fetch_assoc($result)) { ?>
          <option value="<?PHP echo $row['product_category_id']; ?>"><?PHP echo $row['product_category_name']; ?></option>
        
        <?PHP } ?>
      </select>
     	<span class="form-text text-muted"><font color="black">PRODUCT CATEGORY TYPE</font></span>
</div>