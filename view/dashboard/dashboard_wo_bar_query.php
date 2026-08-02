 	    <?php 
  	   
		 include_once(__DIR__ . '/../../model/db_connection/connection.php');
            $DBConn = new DBConnection();
            $varDBConnection = $DBConn->ConnectToMYSQL();
            $yr=date("Y")-5;
                 $y_val="[";
                 
                $wo_open_str="[";
                $wo_pend_str="[";
                $wo_comp_str="[";
                $wo_closed_str="[";
                for($i=$yr;$i<=date("Y");$i++)
                {
                    
                    $sq_op= "SELECT count(ticket_id) as ct,book_year FROM `tbl_tickets` WHERE `ticket_status`!='Cancelled' and book_year=".$i;
                    $result_sq_op = mysqli_query($varDBConnection,$sq_op);
                    	while($row_sq_op=mysqli_fetch_assoc($result_sq_op)) { 
                    	    if($row_sq_op['ct']!=0)
                    	    {
                    	        $wo_open_str=$wo_open_str.$row_sq_op['ct'].",";
                    	        $y_val=$y_val."'".$i."',";
                    	    }
                    	    
                    	   
                    	}
                    $sq_pend= "SELECT count(amc_visit_id) as ct FROM `tbl_visits` WHERE amc_visit_status not in ('Closed','Opened','Cancelled','Completed') and amc_ticket='TKT'  and DATE_FORMAT(date_of_visits,'%Y')=".$i;
                    $result_sq_pend = mysqli_query($varDBConnection,$sq_pend);
                    	while($row_sq_pend=mysqli_fetch_assoc($result_sq_pend)) { 
                    	    if($row_sq_pend['ct']!=0)
                    	    {
                    	        $wo_pend_str=$wo_pend_str.$row_sq_pend['ct'].",";
                    	    }
                    	    
                    	   
                    	}
                
                  $sq_comp= "select count(ticket_id ) as ct from tbl_tickets where   ticket_status  in ('Completed','Closed') and  DATE_FORMAT(completed_date_time,'%Y')=".$i;
                    $result_sq_comp = mysqli_query($varDBConnection,$sq_comp);
                    	while($row_sq_comp=mysqli_fetch_assoc($result_sq_comp)) { 
                    	    if($row_sq_comp['ct']!=0)
                    	    {
                    	        $wo_comp_str=$wo_comp_str.$row_sq_comp['ct'].",";
                    	    }
                    	    
                    	   
                    	}
                 $sq_closed= "select count(ticket_id ) as ct from tbl_tickets where   ticket_status  in ('Closed') and  DATE_FORMAT(closed_on,'%Y')=".$i;
                    $result_sq_closed = mysqli_query($varDBConnection,$sq_closed);
                    	while($row_sq_closed=mysqli_fetch_assoc($result_sq_closed)) { 
                    	    if($row_sq_closed['ct']!=0)
                    	    {
                    	        $wo_closed_str=$wo_closed_str.$row_sq_closed['ct'].",";
                    	    }
                    	    
                    	   
                    	}
                 }
                  $wo_open_str= rtrim($wo_open_str,',');
                    $wo_open_str=$wo_open_str."]";
                     $wo_pend_str= rtrim($wo_pend_str,',');
                    $wo_pend_str=$wo_pend_str."]";
                     $wo_comp_str= rtrim($wo_comp_str,',');
                    $wo_comp_str=$wo_comp_str."]";
                     $wo_closed_str= rtrim($wo_closed_str,',');
                    $wo_closed_str=$wo_closed_str."]";
                     $y_val= rtrim($y_val,',');
                    $y_val=$y_val."]";
                     
                    $array = array('y_val' => $y_val, 'wo_open_str' => $wo_open_str, 'wo_pend_str' => $wo_pend_str, 'wo_comp_str' => $wo_comp_str, 'wo_closed_str' => $wo_closed_str);
                    echo json_encode($array);
                    //echo $y_val.'#'.$wo_open_str.'#'.$wo_pend_str.'#'.$wo_comp_str.'#'.$wo_closed_str;
  	    ?>