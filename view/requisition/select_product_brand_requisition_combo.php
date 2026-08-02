 <?PHP 
 
 
 $v_prdt_item_id_master_req= $_POST['v_prdt_item_id_master_req'];
 include(__DIR__ . '/../../model/db_connection/connection.php');
$DBConnn1 = new DBConnection();
$varDBConnectionn_brand = $DBConnn1->ConnectToMYSQL();
 	$result_prdt_brand = mysqli_query($varDBConnectionn_brand,"Select distinct product_master_id,product_brand_name from tbl_product_master where product_item_id ='".$v_prdt_item_id_master_req."'");

?>
    	

	
     <select data-placeholder="Select Brand" id="select_product_brand" class="form-control form-control-select2" data-fouc>
         <option value="select">Select Brand</option>
        <?PHP 	while($row_prdt_brand=mysqli_fetch_assoc($result_prdt_brand)) { ?>
          <option value="<?PHP echo $row_prdt_brand['product_master_id']; ?>"><?PHP echo $row_prdt_brand['product_brand_name']; ?></option>
        
        <?PHP } ?>
      </select>
     	<span class="form-text text-muted"><font color="black">Select Brand</font><span style="color:red;"></span> &nbsp;&nbsp;&nbsp;&nbsp;<button type="button" class="btn bg-blue-400 btn-icon rounded-round" id="btn_add_brand_req"><i class="icon-plus22"></i></button></span>
<script>
    $(document).ready(function() {
      $("#btn_add_brand_req").click(function(){
          
          $("#add_new_master_req").modal("show");
           
       })
    });
</script>