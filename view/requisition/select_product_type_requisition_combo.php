<?PHP 
include "../../model/db_connection/connection.php" ;
$DBConnn = new DBConnection();
$varDBConnectionn = $DBConnn->ConnectToMYSQL();

$v_prdt_category_id_master= $_POST['v_prdt_category_id_master'];
 	$result_product_type_for_master = mysqli_query($varDBConnectionn,"select distinct product_type_id,product_type_name from  tbl_product_type where  product_category_id='".$v_prdt_category_id_master."' and product_type_status='Active'");
 	
?>



     <select data-placeholder="Select Category Type" id="select_product_type_for_master" class="form-control form-control-select2" data-fouc>
         <option value="select">Select Product Type</option>
        <?PHP 	while($row_product_type_for_master=mysqli_fetch_assoc($result_product_type_for_master)) { ?>
          <option value="<?PHP echo $row_product_type_for_master['product_type_id']; ?>"><?PHP echo $row_product_type_for_master['product_type_name']; ?></option>
        
        <?PHP } ?>
      </select>
     	<span class="form-text text-muted"><font color="black">Product Type</font><span style="color:red;">*</span>&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" class="btn bg-blue-400 btn-icon rounded-round" id="btn_add_type_req"><i class="icon-plus22"></i></button></span>
<script>
    $(document).ready(function() {
       $("#btn_add_type_req").click(function(){
         
          $("#add_new_type_req").modal("show");
           
        }); 
    });
</script>