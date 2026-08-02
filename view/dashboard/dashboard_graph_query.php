 	    <?php 
  	   
		 include_once "../../model/db_connection/connection.php" ;
            $DBConn = new DBConnection();
            $varDBConnection = $DBConn->ConnectToMYSQL();
            $con_val=$_POST['action'];
         
            if($con_val=='Year Wise'){
                 $yr=date("Y")-11;
                $data_str=" [['Year', 'WOs Raised'],";
                for($i=$yr;$i<=date("Y");$i++)
                {
              
                    $sq= "SELECT count(ticket_id) as ct,book_year FROM `tbl_tickets` WHERE `ticket_status`!='Cancelled' and book_year=".$i;
                    $result_sq = mysqli_query($varDBConnection,$sq);
                    	while($row_sq=mysqli_fetch_assoc($result_sq)) { 
                    	    $data_str=$data_str."['".$i."',".$row_sq['ct']."],";
                    	   
                    	}
                 }
                  $data_str= rtrim($data_str,',');
                    $data_str=$data_str."]";
                    echo $data_str; 
            }
        if($con_val=='Month Wise'){
          
                $data_str=" [['Month', 'WOs Raised'],";
                for($i=11;$i>=0;$i--)
                { 
                    if($i==0)
                    {
                         $month_val=date('Y-m');
                         $month_name=date('M-Y');
                    }
                    else
                    {
                         $month_val=date('Y-m', strtotime("-".$i." month"));
                         $month_name=date('M-Y', strtotime("-".$i." month"));
                    }
                   
                    
                    $sq= "SELECT count(ticket_id) as ct FROM `tbl_tickets` WHERE `ticket_status`!='Cancelled' and date_format(created_date_time,'%Y-%m')='".$month_val."' ";
                  
                    $result_sq = mysqli_query($varDBConnection,$sq);
                    	while($row_sq=mysqli_fetch_assoc($result_sq)) { 
                    	    $data_str=$data_str."['".$month_name."',".$row_sq['ct']."],";
                    	   
                    	}
                 }
                  $data_str= rtrim($data_str,',');
                    $data_str=$data_str."]";
                    echo $data_str; 
            }
         
         if($con_val=='Week Wise'){
  
             $data_str=" [['Week', 'WOs Raised'],";
             for($i=11;$i>=0;$i--)
                {
                    $y=($i*7)+1;
                    $z=($i+1)*7;
                    if($i==0)
                    {
                         $week_edval=date("Y-m-d");
                         $week_stval=date("Y-m-d", strtotime('-7 days'));
                         $week_name="W".($i+1)."  ".date("d/M/Y",strtotime('-7 days'))."-" .date("d/M/Y");
                    }
                    else
                    {
                         $week_edval=date("Y-m-d", strtotime('-'.$y.' days'));
                         $week_stval=date("Y-m-d", strtotime('-'.$z.' days'));
                         $week_name="W".($i+1)."  ".date("d/M/Y",strtotime('-'.$z.' days'))."-" .date("d/M/Y",strtotime('-'.$y.' days'));
                    }
                    $sq= "SELECT count(ticket_id) as ct FROM `tbl_tickets` WHERE `ticket_status`!='Cancelled' and date_format(created_date_time,'%Y-%m-%d') between '".$week_stval."'  and '".$week_edval."'";
                  
                    $result_sq = mysqli_query($varDBConnection,$sq);
                    	while($row_sq=mysqli_fetch_assoc($result_sq)) { 
                    	    $data_str=$data_str."['".$week_name."',".$row_sq['ct']."],";
                    	   
                    	}
                }
                  $data_str= rtrim($data_str,',');
                    $data_str=$data_str."]";
                    echo $data_str; 
            
            
         }
         
           if($con_val=='Day Wise'){
  
             $data_str=" [['Days', 'WOs Raised'],";
             for($i=6;$i>=0;$i--)
                {
                   
                    if($i==0)
                    {
                         $dval=date("Y-m-d");
                          $d_name=date("d/M/Y");
                       
                    }
                    else
                    {
                         $dval=date("Y-m-d", strtotime('-'.$i.' days'));
                        
                         $d_name=date("d/M/Y",strtotime('-'.$i.' days'));
                    }
                    $sq= "SELECT count(ticket_id) as ct FROM `tbl_tickets` WHERE `ticket_status`!='Cancelled' and date_format(created_date_time,'%Y-%m-%d') = '".$dval."' ";
                  
                    $result_sq = mysqli_query($varDBConnection,$sq);
                    	while($row_sq=mysqli_fetch_assoc($result_sq)) { 
                    	    $data_str=$data_str."['".$d_name."',".$row_sq['ct']."],";
                    	   
                    	}
                }
                  $data_str= rtrim($data_str,',');
                    $data_str=$data_str."]";
                    echo $data_str; 
            
            
         }
  	    ?>