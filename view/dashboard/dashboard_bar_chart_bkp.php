 	    <?php 
  	   
		 include_once(__DIR__ . '/../../model/db_connection/connection.php');
            $DBConn = new DBConnection();
            $varDBConnection = $DBConn->ConnectToMYSQL();
        
         
         $result1 = mysqli_query($varDBConnection," SELECT DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 0 MONTH), '%M') AS MonthName UNION SELECT DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 1 MONTH), '%M') UNION SELECT DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 2 MONTH), '%M');");
                        
         
      
  
  	        $array_collection_month_query = array();

        	while($row=mysqli_fetch_assoc($result1)) { 
        	    
        	   
                $array_contract_date = $row['MonthName'];
               
              array_push($array_collection_month_query, $array_contract_date);
              
        	}
        	
        	
        	
          $result2 = mysqli_query($varDBConnection," select count(ticket_id) as monthly_collection from tbl_tickets where YEAR(CURDATE()) = DATE_FORMAT(`created_date_time`,'%Y' ) AND DATE_FORMAT(`created_date_time`,'%M' ) = DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 0 MONTH), '%M')  UNION  select count(ticket_id) as monthly_collection from tbl_tickets where  DATE_FORMAT(`created_date_time`,'%M' ) = DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 1 MONTH), '%M')  UNION select count(ticket_id) as monthly_collection from tbl_tickets where  DATE_FORMAT(`created_date_time`,'%M' ) = DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 2 MONTH), '%M')");	
        	
        	 $array_collection_ekm_query = array();

        	while($row_ekm=mysqli_fetch_assoc($result2)) { 
        	    
        	   
                $array_month_ekm_collection = $row_ekm['monthly_collection'];
               
              array_push($array_collection_ekm_query, $array_month_ekm_collection);
              
        	}
        	
        	$result3 = mysqli_query($varDBConnection," select count(ticket_id) as monthly_collection from tbl_tickets where YEAR(CURDATE()) = DATE_FORMAT(`created_date_time`,'%Y' ) AND DATE_FORMAT(`created_date_time`,'%M' ) = DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 0 MONTH), '%M')  UNION  select count(ticket_id) as monthly_collection from tbl_tickets where  DATE_FORMAT(`created_date_time`,'%M' ) = DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 1 MONTH), '%M')  UNION select count(ticket_id) as monthly_collection from tbl_tickets where  DATE_FORMAT(`created_date_time`,'%M' ) = DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 2 MONTH), '%M')");	
        	
        	 $array_collection_tvm_query = array();

        	while($row_tvm =mysqli_fetch_assoc($result3)) { 
        	    
        	   
              $array_month_tvm_collection = $row_tvm['monthly_collection'];
               
              array_push($array_collection_tvm_query, $array_month_tvm_collection);
              
        	}
        	
        	
        	$result4 = mysqli_query($varDBConnection," select count(ticket_id) as monthly_collection from tbl_tickets where YEAR(CURDATE()) = DATE_FORMAT(`created_date_time`,'%Y' ) AND DATE_FORMAT(`created_date_time`,'%M' ) = DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 0 MONTH), '%M')  UNION  select count(ticket_id) as monthly_collection from tbl_tickets where  DATE_FORMAT(`created_date_time`,'%M' ) = DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 1 MONTH), '%M')  UNION select count(ticket_id) as monthly_collection from tbl_tickets where  DATE_FORMAT(`created_date_time`,'%M' ) = DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 2 MONTH), '%M')");	
        	
        	 $array_collection_tcr_query = array();

        	while($row_tcr=mysqli_fetch_assoc($result4)) { 
        	    
        	   
                $array_month_tcr_collection = $row_tcr['monthly_collection'];
               
              array_push($array_collection_tcr_query, $array_month_tcr_collection);
              
        	}
        	
        	$result5 = mysqli_query($varDBConnection," select count(ticket_id) as monthly_collection from tbl_tickets where YEAR(CURDATE()) = DATE_FORMAT(`created_date_time`,'%Y' ) AND DATE_FORMAT(`created_date_time`,'%M' ) = DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 0 MONTH), '%M')  UNION  select count(ticket_id) as monthly_collection from tbl_tickets where  DATE_FORMAT(`created_date_time`,'%M' ) = DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 1 MONTH), '%M')  UNION select count(ticket_id) as monthly_collection from tbl_tickets where  DATE_FORMAT(`created_date_time`,'%M' ) = DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 2 MONTH), '%M')");	
        	
        	 $array_collection_clt_query = array();

        	while($row_clt=mysqli_fetch_assoc($result5)) { 
        	    
        	   
                $array_month_clt_collection = $row_clt['monthly_collection'];
               
              array_push($array_collection_clt_query, $array_month_clt_collection);
              
        	}
        	
        	
        	$result6 = mysqli_query($varDBConnection," select count(ticket_id) as monthly_collection from tbl_tickets where YEAR(CURDATE()) = DATE_FORMAT(`created_date_time`,'%Y' ) AND DATE_FORMAT(`created_date_time`,'%M' ) = DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 0 MONTH), '%M')  UNION  select count(ticket_id) as monthly_collection from tbl_tickets where  DATE_FORMAT(`created_date_time`,'%M' ) = DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 1 MONTH), '%M')  UNION select count(ticket_id) as monthly_collection from tbl_tickets where  DATE_FORMAT(`created_date_time`,'%M' ) = DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 2 MONTH), '%M')");	
        	
        	 $array_collection_ktym_query = array();

        	while($row_ekm=mysqli_fetch_assoc($result6)) { 
        	    
        	   
                $array_month_ktym_collection = $row_ekm['monthly_collection'];
               
              array_push($array_collection_ktym_query, $array_month_ktym_collection);
              
        	}
                               
  	    ?>
  	<div class="row" id="row_boxs_details" style="height:500px;">      
    <canvas id="myChart"></canvas>
      <div class="card-content">
         <h6 class="" style="padding-left:420px;padding-bottom:12px;padding-top:5px;"><b>WOs Raised<b></h6>
		 
         <p class="caption">
          
         </p>
      </div>
    </div>