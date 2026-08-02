   <?php 
  	   
		 include_once "../../model/db_connection/connection.php" ;
	
            $DBConn = new DBConnection();
            $varDBConnection = $DBConn->ConnectToMYSQL();
           	$emparray = array();
                    $sq_emp= "SELECT count(`employee_id`) as value,'Technicians' as name FROM `tbl_employees` WHERE `employee_type_name`='Technician' and employee_status='Active' union SELECT count(`employee_id`) as value,'Baggage Handlers' as name FROM `tbl_employees` WHERE `employee_type_name`='Baggage Handlers' and employee_status='Active' union SELECT count(`employee_id`) as value,'Drivers' as name FROM `tbl_employees`  WHERE `employee_type_name`='Driver' and employee_status='Active' union SELECT count(`employee_id`) as value,'Cleaners' as name FROM `tbl_employees` WHERE `employee_type_name`='Cleaner' and employee_status='Active' union  SELECT count(`employee_id`) as value,'Others' as name FROM `tbl_employees` WHERE `employee_type_name` not in ('Baggage Handlers','Technician','Driver','Cleaner') and employee_status='Active'";
                   
                    $result_sq_emp = mysqli_query($varDBConnection,$sq_emp);
                     
                    while($row_emp =mysqli_fetch_assoc($result_sq_emp)){
                        $emparray[] = $row_emp;
                    }
                    echo json_encode($emparray); 
                    
           
            ?>