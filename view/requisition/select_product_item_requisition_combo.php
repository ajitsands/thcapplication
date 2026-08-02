<?PHP 
include "../../model/db_connection/connection.php" ;
$DBConnn = new DBConnection();
$varDBConnectionn_new = $DBConnn->ConnectToMYSQL();

$v_prdt_type_id_master= $_POST['v_prdt_type_id_master'];
	$result_product_item_for_master = mysqli_query($varDBConnectionn_new,"select product_item_id,product_item_name from  tbl_product_items where  product_type_id='".$v_prdt_type_id_master."' and item_status='Active'");
 	
?>
     <select data-placeholder="Select Product Item" id="select_product_item_for_master" class="form-control form-control-select2" data-fouc>
         <option value="select">Select Product Item</option>
        <?PHP 	while($row_product_item_for_master=mysqli_fetch_assoc($result_product_item_for_master)) { ?>
          <option value="<?PHP echo $row_product_item_for_master['product_item_id']; ?>"><?PHP echo $row_product_item_for_master['product_item_name']; ?></option>
        
        <?PHP } ?>
      </select>
     	<span class="form-text text-muted"><font color="black">Select Product Item</font><span style="color:red;">*</span>&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" class="btn bg-blue-400 btn-icon rounded-round" id="btn_add_item_req"><i class="icon-plus22"></i></button></span>
<script>
    $(document).ready(function() {
       $("#btn_add_item_req").click(function(){
          
          $("#add_new_item_req").modal("show");
           
       })
    });
</script>