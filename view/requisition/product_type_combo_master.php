<?PHP 
include(__DIR__ . '/../../model/db_connection/connection.php');
$DBConnn_type = new DBConnection();
$varDBConnectionn_type = $DBConnn_type->ConnectToMYSQL();

$v_prdt_category_id_master= $_POST['v_prdt_category_id_master'];
 	$result_product_type_for_master = mysqli_query($varDBConnectionn_type,"select product_type_id,product_type_name from  tbl_product_type where product_type_status='Active' and product_category_id='".$v_prdt_category_id_master."'");
 	
?>

    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">

	<link href="assets/css/bootstrap_limitless.min.css" rel="stylesheet" type="text/css">
	<link href="assets/css/layout.min.css" rel="stylesheet" type="text/css">
	<link href="assets/css/components.min.css" rel="stylesheet" type="text/css">
	<link href="assets/css/colors.min.css" rel="stylesheet" type="text/css">
	<script src="global_assets/js/plugins/extensions/jquery_ui/interactions.min.js"></script>
	<script src="global_assets/js/plugins/forms/selects/select2.min.js"></script>

	<script src="global_assets/js/demo_pages/form_select2.js"></script>

     <select data-placeholder="Select Category Type" id="select_product_type_for_master_req" class="form-control form-control-select2" data-fouc>
         <option value="select">SELECT PRODUCT TYPE</option>
        <?PHP 	while($row_product_type_for_master=mysqli_fetch_assoc($result_product_type_for_master)) { ?>
          <option value="<?PHP echo $row_product_type_for_master['product_type_id']; ?>"><?PHP echo $row_product_type_for_master['product_type_name']; ?></option>
        
        <?PHP } ?>
      </select>
     	<span class="form-text text-muted"><font color="black">PRODUCT TYPE</font></span>
