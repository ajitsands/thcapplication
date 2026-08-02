<?PHP  
include(__DIR__ . '/../../model/db_connection/connection.php');
$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();


$result_category = mysqli_query($varDBConnection,"select category_id,category_name from  tbl_category where category_status='Active'");
 	


 	
?>

<span class="form-text text-muted font-weight-bold"><font color="black">Category &nbsp;<span style="color:red;">*</span></font></span>    

     <select data-placeholder="Select Category" id="select_asset_category_customer" class="form-control form-control-select2" data-fouc>
         <option value="select">Select Category</option>
         <option value="All">All</option>
        <?PHP 	while($row_category=mysqli_fetch_assoc($result_category)) { ?>
          <option value="<?PHP echo $row_category['category_id']; ?>"><?PHP echo $row_category['category_name'] ;?></option>
        
        <?PHP } ?>
      </select>
     	
