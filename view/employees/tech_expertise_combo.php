<?PHP //include(__DIR__ . '/../../model/db_connection/connection.php');
//$DBConn = new DBConnection();
//$varDBConnection = $DBConn->ConnectToMYSQL();
 	$result = mysqli_query($varDBConnection,"Select expertise_id,expertise_name from  tbl_expertise where expertise_status='Active'");
	
			
	
?>


<div class="col-lg-12 col-md-12 col-sm-12" id="div_expertise_select">	
     <!--<select data-placeholder="Select expertise" id="select_expertise" class="form-control form-control-select2" data-fouc>-->
     <span class="form-text text-muted font-weight-bold"><font color="black">Select Expertise&nbsp;<span style="color:red;">*</span></font></span>
     <select class="form-control form-control-select2" id="select_expertise" data-placeholder="Click to select expertise" data-container-css-class="bg-slate-700" multiple="multiple" data-fouc>
	    <?PHP 	while($row=mysqli_fetch_assoc($result)) { ?>
          <option value="<?PHP echo $row['expertise_id']; ?>"><?PHP echo $row['expertise_name']; ?></option>
        
        <?PHP } ?>
      </select>
     	
</div>