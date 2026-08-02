<?PHP
include "../../model/db_connection/connection.php" ;
$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();
//echo $varDBConnection.'hai';
 	$result = mysqli_query($varDBConnection,"select category_id,category_name from  tbl_category where category_status='Active'");
	
?>


	<span class="form-text text-muted font-weight-bold"><font color="black">Select Category&nbsp;<span style="color:red;">*</span> </font></span>

     <!--<select data-placeholder="Select expertise" id="select_expertise" class="form-control form-control-select2" data-fouc>-->
     <select class="form-control form-control-select2 " id="select_category1" data-placeholder="Select Category" data-fouc>
	    <option value="select">Select Category</option>
	    
	    <?PHP 	while($row=mysqli_fetch_assoc($result)) { ?>
          <option value="<?PHP echo $row['category_id']; ?>"><?PHP echo $row['category_name']; ?></option>
        
        <?PHP } ?>
      </select>
     