<?PHP //include(__DIR__ . '/../../model/db_connection/connection.php');
//$DBConn = new DBConnection();
//$varDBConnection = $DBConn->ConnectToMYSQL();
 	$result = mysqli_query($varDBConnection,"Select expertise_id,expertise_name from  tbl_expertise where expertise_status='Active'");
	
			
	
?>


<style>
#div_expertise_select .select2-container .select2-selection--multiple,
#div_expertise_select .select2-selection {
    border: 1px solid #ced4da !important;
    border-radius: 4px !important;
    min-height: 36px !important;
    background-color: #fff !important;
}
</style>
<div class="col-lg-12 col-md-12 col-sm-12" id="div_expertise_select">	
     <span class="form-text text-muted font-weight-bold"><font color="black">Select Expertise&nbsp;<span style="color:red;">*</span></font></span>
     <select class="form-control form-control-select2" id="select_expertise" data-placeholder="Select Expertise" multiple="multiple" data-fouc>
	    <?PHP 	while($row=mysqli_fetch_assoc($result)) { ?>
          <option value="<?PHP echo $row['expertise_id']; ?>"><?PHP echo $row['expertise_name']; ?></option>
        <?PHP } ?>
      </select>
</div>