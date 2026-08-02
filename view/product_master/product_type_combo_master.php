<?PHP 
include(__DIR__ . '/../../model/db_connection/connection.php');
$DBConnn = new DBConnection();
$varDBConnectionn = $DBConnn->ConnectToMYSQL();

$v_prdt_category_id_master= $_POST['v_prdt_category_id_master'];
 	$result_product_type_for_master = mysqli_query($varDBConnectionn,"select product_type_id,product_type_name from  tbl_product_type where product_type_status='Active' and product_category_id='".$v_prdt_category_id_master."'");
 	
?>



     <select data-placeholder="Select Category Type" id="select_product_type_for_master" class="form-control form-control-select2" data-fouc>
         <option value="select">SELECT PRODUCT TYPE</option>
        <?PHP 	while($row_product_type_for_master=mysqli_fetch_assoc($result_product_type_for_master)) { ?>
          <option value="<?PHP echo $row_product_type_for_master['product_type_id']; ?>"><?PHP echo $row_product_type_for_master['product_type_name']; ?></option>
        
        <?PHP } ?>
      </select>
     	<span class="form-text text-muted"><font color="black">PRODUCT TYPE</font></span>
