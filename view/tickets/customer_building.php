<?PHP 
 	$result_customer_building = mysqli_query($varDBConnection,"Select distinct building_name,building_code from  tbl_customer_location where customer_location_status='Active'");
?>


<div class="col-lg-5 col-md-6 col-sm-12" id="div_select_building">	
     <select data-placeholder="Select Building" id="select_building_for_location" class="form-control form-control-select2" data-fouc>
         <option value="select">Select Building</option>
        <?PHP 	while($row_customer_building=mysqli_fetch_assoc($result_customer_building)) { ?>
          <option value="<?PHP echo $row_customer_building['building_code']; ?>"><?PHP echo $row_customer_building['building_code']."--".$row_customer_building['building_name']; ?></option>
        
        <?PHP } ?>
      </select>
     	<span class="form-text text-muted"><font color="black">Select Building &nbsp;<span style="color:red;">*</span></font></span>    
</div>