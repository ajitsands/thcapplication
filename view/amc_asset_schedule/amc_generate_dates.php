<?php

   include(__DIR__ . '/../../model/db_connection/connection.php');
   date_default_timezone_set('Asia/Bahrain');
   global $visit_id;

   function displayDates($date1, $date2,$vist_frequency,$amc_id,$amc_ref_no,$cust_id,$cust_code,$cust_name,$time_of_visit,$asset_length,$assets_array,$format = 'd-m-Y' ) 
   {
       $dates = array();
       $DBConn = new DBConnection();
       $varDBConnection = $DBConn->ConnectToMYSQL();
     
      $current1 = strtotime($date1);
      $current = strtotime($date1)-1;
      $date2 = strtotime($date2);
      $stepVal = '+1 day';
      
      $sql="insert into tbl_visits (amc_tkt_id,amc_tkt_ref_no,amc_ticket,customer_id,customer_code,customer_name,visit_mode,date_of_visits,time_of_visit,amc_visit_status,amc_schedule_color) values ";
      $sql1="insert into tbl_asset_schedule(  `visit_id`,`amc_id`,`amc_ref_no`, `asset_id`, `asset_code`, `building_id`, `building_name`, `location_id`, `location_name`, `category_id`, `category_name`, `asset_type_id`, `asset_type_name`, `customer_id`, `customer_code`, `customer_name`,`date_of_visit`,`time_of_visit`,`schedule_status`) values ";
         switch($vist_frequency)
         {
            
            case 'YSD':
               $date_of_visit=date("Y",$current1).'-'.date("m",$current1).'-'.date("d",$current1);
               $sql= $sql.'("'.$amc_id.'","'.$amc_ref_no.'","AMC","'.$cust_id.'","'.$cust_code.'","'.$cust_name.'","'.$vist_frequency.'","'.$date_of_visit.'","'.$time_of_visit.'","Scheduled","#0B9CF4"),';
            break;
            case 'ED-All':
               while( $current <= $date2 ) {
                  $dates['data'][] = date($format, $current);
                  $current = strtotime($stepVal, $current);
                  $date_of_visit=date("Y",$current).'-'.date("m",$current).'-'.date("d",$current);
                  
           // $sql= $sql.'("'.$amc_id.'","'.$amc_ref_no.'","AMC","'.$cust_id.'","'.$cust_code.'","'.$cust_name.'","'.$vist_frequency.'","'.$date_of_visit.'","'.$time_of_visit.'","Scheduled","#0B9CF4"),';
            $sql_visit= $sql.'("'.$amc_id.'","'.$amc_ref_no.'","AMC","'.$cust_id.'","'.$cust_code.'","'.$cust_name.'","'.$vist_frequency.'","'.$date_of_visit.'","'.$time_of_visit.'","Scheduled","#0B9CF4")';
                        
                      
                        mysqli_query($varDBConnection,$sql_visit);
                        
                        $last_id = mysqli_insert_id($varDBConnection);
                       
                       
                        foreach($assets_array as $entry) {
                           
                               
                                $asset_explode=explode(",",$entry);
                   
                          $sql_schedule= $sql1.'("'.$last_id.'","'.$amc_id.'","'.$amc_ref_no.'","'.$asset_explode[0].'","'.$asset_explode[5].'","'.$asset_explode[8].'","'.$asset_explode[9].'","'.$asset_explode[6].'","'.$asset_explode[7].'","'.$asset_explode[3].'","'.$asset_explode[4].'","'.$asset_explode[1].'","'.$asset_explode[2].'","'.$cust_id.'","'.$cust_code.'","'.$cust_name.'","'.$date_of_visit.'","'.$time_of_visit.'","Scheduled")';
                          mysqli_query($varDBConnection,$sql_schedule);
                      
                        }
               
               }
            break;
            case 'EW-Sunday':
                
           while( $current <= $date2 ) {
                  
                  $dates['data'][] = date($format, $current);
                  $current = strtotime($stepVal, $current);
                  $date_of_visit=date("Y",$current).'-'.date("m",$current).'-'.date("d",$current);
                  if(date("l",$current)=="Sunday")
                      {
                       
                        $sql_visit= $sql.'("'.$amc_id.'","'.$amc_ref_no.'","AMC","'.$cust_id.'","'.$cust_code.'","'.$cust_name.'","'.$vist_frequency.'","'.$date_of_visit.'","'.$time_of_visit.'","Scheduled","#0B9CF4")';
                        
                        mysqli_query($varDBConnection,$sql_visit);
                        $last_id = mysqli_insert_id($varDBConnection);
                        
                        foreach($assets_array as $entry) {
                          $asset_explode=explode(",",$entry);
                          $sql_schedule= $sql1.'("'.$last_id.'","'.$amc_id.'","'.$amc_ref_no.'","'.$asset_explode[0].'","'.$asset_explode[5].'","'.$asset_explode[8].'","'.$asset_explode[9].'","'.$asset_explode[6].'","'.$asset_explode[7].'","'.$asset_explode[3].'","'.$asset_explode[4].'","'.$asset_explode[1].'","'.$asset_explode[2].'","'.$cust_id.'","'.$cust_code.'","'.$cust_name.'","'.$date_of_visit.'","'.$time_of_visit.'","Scheduled")';
                          mysqli_query($varDBConnection,$sql_schedule);
                      
                        }
                 }
                 
                 
               }
              
            break;
            case 'EW-Monday':
                 echo $sql_visit.'Monday';
                 
               while( $current <= $date2 ) {
                  $dates['data'][] = date($format, $current);
                  $current = strtotime($stepVal, $current);
                  $date_of_visit=date("Y",$current).'-'.date("m",$current).'-'.date("d",$current);
                  if(date("l",$current)=="Monday")
                  {
                      $sql_visit= $sql.'("'.$amc_id.'","'.$amc_ref_no.'","AMC","'.$cust_id.'","'.$cust_code.'","'.$cust_name.'","'.$vist_frequency.'","'.$date_of_visit.'","'.$time_of_visit.'","Scheduled","#0B9CF4")';
                       
                      
                        mysqli_query($varDBConnection,$sql_visit);
                        
                        $last_id = mysqli_insert_id($varDBConnection);
                       
                       
                        foreach($assets_array as $entry) {
                           
                               
                                $asset_explode=explode(",",$entry);
                   
                          $sql_schedule= $sql1.'("'.$last_id.'","'.$amc_id.'","'.$amc_ref_no.'","'.$asset_explode[0].'","'.$asset_explode[5].'","'.$asset_explode[8].'","'.$asset_explode[9].'","'.$asset_explode[6].'","'.$asset_explode[7].'","'.$asset_explode[3].'","'.$asset_explode[4].'","'.$asset_explode[1].'","'.$asset_explode[2].'","'.$cust_id.'","'.$cust_code.'","'.$cust_name.'","'.$date_of_visit.'","'.$time_of_visit.'","Scheduled")';
                          mysqli_query($varDBConnection,$sql_schedule);
                      
                        }
                  }
                  
               }
              
            break;
            case 'EW-Tuesday':
               while( $current <= $date2 ) {
                  $dates['data'][] = date($format, $current);
                  $current = strtotime($stepVal, $current);
                  $date_of_visit=date("Y",$current).'-'.date("m",$current).'-'.date("d",$current);
                  if(date("l",$current)=="Tuesday")
                  {
                      $sql_visit= $sql.'("'.$amc_id.'","'.$amc_ref_no.'","AMC","'.$cust_id.'","'.$cust_code.'","'.$cust_name.'","'.$vist_frequency.'","'.$date_of_visit.'","'.$time_of_visit.'","Scheduled","#0B9CF4")';
                        
                      
                        mysqli_query($varDBConnection,$sql_visit);
                        
                        $last_id = mysqli_insert_id($varDBConnection);
                       
                       
                        foreach($assets_array as $entry) {
                           
                               
                                $asset_explode=explode(",",$entry);
                   
                          $sql_schedule= $sql1.'("'.$last_id.'","'.$amc_id.'","'.$amc_ref_no.'","'.$asset_explode[0].'","'.$asset_explode[5].'","'.$asset_explode[8].'","'.$asset_explode[9].'","'.$asset_explode[6].'","'.$asset_explode[7].'","'.$asset_explode[3].'","'.$asset_explode[4].'","'.$asset_explode[1].'","'.$asset_explode[2].'","'.$cust_id.'","'.$cust_code.'","'.$cust_name.'","'.$date_of_visit.'","'.$time_of_visit.'","Scheduled")';
                          mysqli_query($varDBConnection,$sql_schedule);
                      
                        }
                  }
                  
               }
            break;
            case 'EW-Wednesday':
               while( $current <= $date2 ) {
                  $dates['data'][] = date($format, $current);
                  $current = strtotime($stepVal, $current);
                  $date_of_visit=date("Y",$current).'-'.date("m",$current).'-'.date("d",$current);
                  if(date("l",$current)=="Wednesday")
                  {
                      $sql_visit= $sql.'("'.$amc_id.'","'.$amc_ref_no.'","AMC","'.$cust_id.'","'.$cust_code.'","'.$cust_name.'","'.$vist_frequency.'","'.$date_of_visit.'","'.$time_of_visit.'","Scheduled","#0B9CF4")';
                        
                      
                        mysqli_query($varDBConnection,$sql_visit);
                        
                        $last_id = mysqli_insert_id($varDBConnection);
                       
                       
                        foreach($assets_array as $entry) {
                           
                               
                                $asset_explode=explode(",",$entry);
                   
                          $sql_schedule= $sql1.'("'.$last_id.'","'.$amc_id.'","'.$amc_ref_no.'","'.$asset_explode[0].'","'.$asset_explode[5].'","'.$asset_explode[8].'","'.$asset_explode[9].'","'.$asset_explode[6].'","'.$asset_explode[7].'","'.$asset_explode[3].'","'.$asset_explode[4].'","'.$asset_explode[1].'","'.$asset_explode[2].'","'.$cust_id.'","'.$cust_code.'","'.$cust_name.'","'.$date_of_visit.'","'.$time_of_visit.'","Scheduled")';
                          mysqli_query($varDBConnection,$sql_schedule);
                      
                        }
                  }
                  
               }
            break;
            case 'EW-Thursday':
               while( $current <= $date2 ) {
                  $dates['data'][] = date($format, $current);
                  $current = strtotime($stepVal, $current);
                  $date_of_visit=date("Y",$current).'-'.date("m",$current).'-'.date("d",$current);
                  if(date("l",$current)=="Thursday")
                  {
                      $sql_visit= $sql.'("'.$amc_id.'","'.$amc_ref_no.'","AMC","'.$cust_id.'","'.$cust_code.'","'.$cust_name.'","'.$vist_frequency.'","'.$date_of_visit.'","'.$time_of_visit.'","Scheduled","#0B9CF4")';
                        
                      
                        mysqli_query($varDBConnection,$sql_visit);
                        
                        $last_id = mysqli_insert_id($varDBConnection);
                       
                       
                        foreach($assets_array as $entry) {
                           
                               
                                $asset_explode=explode(",",$entry);
                   
                          $sql_schedule= $sql1.'("'.$last_id.'","'.$amc_id.'","'.$amc_ref_no.'","'.$asset_explode[0].'","'.$asset_explode[5].'","'.$asset_explode[8].'","'.$asset_explode[9].'","'.$asset_explode[6].'","'.$asset_explode[7].'","'.$asset_explode[3].'","'.$asset_explode[4].'","'.$asset_explode[1].'","'.$asset_explode[2].'","'.$cust_id.'","'.$cust_code.'","'.$cust_name.'","'.$date_of_visit.'","'.$time_of_visit.'","Scheduled")';
                          mysqli_query($varDBConnection,$sql_schedule);
                      
                        }
                  }
                  
               }
            break;
            case 'EW-Friday':
               while( $current <= $date2 ) {
                  $dates['data'][] = date($format, $current);
                  $current = strtotime($stepVal, $current);
                  $date_of_visit=date("Y",$current).'-'.date("m",$current).'-'.date("d",$current);
                  if(date("l",$current)=="Friday")
                  {
                      $sql_visit= $sql.'("'.$amc_id.'","'.$amc_ref_no.'","AMC","'.$cust_id.'","'.$cust_code.'","'.$cust_name.'","'.$vist_frequency.'","'.$date_of_visit.'","'.$time_of_visit.'","Scheduled","#0B9CF4")';
                        
                      
                        mysqli_query($varDBConnection,$sql_visit);
                        
                        $last_id = mysqli_insert_id($varDBConnection);
                       
                       
                        foreach($assets_array as $entry) {
                           
                               
                                $asset_explode=explode(",",$entry);
                   
                          $sql_schedule= $sql1.'("'.$last_id.'","'.$amc_id.'","'.$amc_ref_no.'","'.$asset_explode[0].'","'.$asset_explode[5].'","'.$asset_explode[8].'","'.$asset_explode[9].'","'.$asset_explode[6].'","'.$asset_explode[7].'","'.$asset_explode[3].'","'.$asset_explode[4].'","'.$asset_explode[1].'","'.$asset_explode[2].'","'.$cust_id.'","'.$cust_code.'","'.$cust_name.'","'.$date_of_visit.'","'.$time_of_visit.'","Scheduled")';
                          mysqli_query($varDBConnection,$sql_schedule);
                      
                        }
                  }
                  
               }
            break;
            case 'EW-Saturday':
               while( $current <= $date2 ) {
                  $dates['data'][] = date($format, $current);
                  $current = strtotime($stepVal, $current);
                  $date_of_visit=date("Y",$current).'-'.date("m",$current).'-'.date("d",$current);
                  if(date("l",$current)=="Saturday")
                  {
                      $sql_visit= $sql.'("'.$amc_id.'","'.$amc_ref_no.'","AMC","'.$cust_id.'","'.$cust_code.'","'.$cust_name.'","'.$vist_frequency.'","'.$date_of_visit.'","'.$time_of_visit.'","Scheduled","#0B9CF4")';
                        
                      
                        mysqli_query($varDBConnection,$sql_visit);
                        
                        $last_id = mysqli_insert_id($varDBConnection);
                       
                       
                        foreach($assets_array as $entry) {
                           
                               
                                $asset_explode=explode(",",$entry);
                   
                          $sql_schedule= $sql1.'("'.$last_id.'","'.$amc_id.'","'.$amc_ref_no.'","'.$asset_explode[0].'","'.$asset_explode[5].'","'.$asset_explode[8].'","'.$asset_explode[9].'","'.$asset_explode[6].'","'.$asset_explode[7].'","'.$asset_explode[3].'","'.$asset_explode[4].'","'.$asset_explode[1].'","'.$asset_explode[2].'","'.$cust_id.'","'.$cust_code.'","'.$cust_name.'","'.$date_of_visit.'","'.$time_of_visit.'","Scheduled")';
                          mysqli_query($varDBConnection,$sql_schedule);
                      
                        }
                  }
                  
               }
            break;
            case 'FW-Sunday':
               while( $current <= $date2 ) {
                  $dates['data'][] = date($format, $current);
                  $current = strtotime($stepVal, $current);
                  $date_of_visit=date("Y",$current).'-'.date("m",$current).'-'.date("d",$current);
                  if(date("l",$current)=="Sunday")
                  {
                     $countmonth=weekOfMonth(strtotime($date_of_visit));
                     if($countmonth==1)
                     {
                         $sql_visit= $sql.'("'.$amc_id.'","'.$amc_ref_no.'","AMC","'.$cust_id.'","'.$cust_code.'","'.$cust_name.'","'.$vist_frequency.'","'.$date_of_visit.'","'.$time_of_visit.'","Scheduled","#0B9CF4")';
                        
                      
                        mysqli_query($varDBConnection,$sql_visit);
                        
                        $last_id = mysqli_insert_id($varDBConnection);
                       
                       
                        foreach($assets_array as $entry) {
                           
                               
                                $asset_explode=explode(",",$entry);
                   
                          $sql_schedule= $sql1.'("'.$last_id.'","'.$amc_id.'","'.$amc_ref_no.'","'.$asset_explode[0].'","'.$asset_explode[5].'","'.$asset_explode[8].'","'.$asset_explode[9].'","'.$asset_explode[6].'","'.$asset_explode[7].'","'.$asset_explode[3].'","'.$asset_explode[4].'","'.$asset_explode[1].'","'.$asset_explode[2].'","'.$cust_id.'","'.$cust_code.'","'.$cust_name.'","'.$date_of_visit.'","'.$time_of_visit.'","Scheduled")';
                          mysqli_query($varDBConnection,$sql_schedule);
                      
                        }
                     }
                     
                  }
                  
               }
               
            break;
            case 'FW-Monday':
               while( $current <= $date2 ) {
                  $dates['data'][] = date($format, $current);
                  $current = strtotime($stepVal, $current);
                  $date_of_visit=date("Y",$current).'-'.date("m",$current).'-'.date("d",$current);
                  if(date("l",$current)=="Monday")
                  {
                     $countmonth=weekOfMonth(strtotime($date_of_visit));
                     if($countmonth==1)
                     {
                         $sql_visit= $sql.'("'.$amc_id.'","'.$amc_ref_no.'","AMC","'.$cust_id.'","'.$cust_code.'","'.$cust_name.'","'.$vist_frequency.'","'.$date_of_visit.'","'.$time_of_visit.'","Scheduled","#0B9CF4")';
                        
                      
                        mysqli_query($varDBConnection,$sql_visit);
                        
                        $last_id = mysqli_insert_id($varDBConnection);
                       
                       
                        foreach($assets_array as $entry) {
                           
                               
                                $asset_explode=explode(",",$entry);
                   
                          $sql_schedule= $sql1.'("'.$last_id.'","'.$amc_id.'","'.$amc_ref_no.'","'.$asset_explode[0].'","'.$asset_explode[5].'","'.$asset_explode[8].'","'.$asset_explode[9].'","'.$asset_explode[6].'","'.$asset_explode[7].'","'.$asset_explode[3].'","'.$asset_explode[4].'","'.$asset_explode[1].'","'.$asset_explode[2].'","'.$cust_id.'","'.$cust_code.'","'.$cust_name.'","'.$date_of_visit.'","'.$time_of_visit.'","Scheduled")';
                          mysqli_query($varDBConnection,$sql_schedule);
                      
                        }
                     }
                     
                  }
                  
               }
               
            break;
            case 'FW-Tuesday':
               while( $current <= $date2 ) {
                  $dates['data'][] = date($format, $current);
                  $current = strtotime($stepVal, $current);
                  $date_of_visit=date("Y",$current).'-'.date("m",$current).'-'.date("d",$current);
                  if(date("l",$current)=="Tuesday")
                  {
                     $countmonth=weekOfMonth(strtotime($date_of_visit));
                     if($countmonth==1)
                     {
                          $sql_visit= $sql.'("'.$amc_id.'","'.$amc_ref_no.'","AMC","'.$cust_id.'","'.$cust_code.'","'.$cust_name.'","'.$vist_frequency.'","'.$date_of_visit.'","'.$time_of_visit.'","Scheduled","#0B9CF4")';
                        
                      
                        mysqli_query($varDBConnection,$sql_visit);
                        
                        $last_id = mysqli_insert_id($varDBConnection);
                       
                       
                        foreach($assets_array as $entry) {
                           
                               
                                $asset_explode=explode(",",$entry);
                   
                          $sql_schedule= $sql1.'("'.$last_id.'","'.$amc_id.'","'.$amc_ref_no.'","'.$asset_explode[0].'","'.$asset_explode[5].'","'.$asset_explode[8].'","'.$asset_explode[9].'","'.$asset_explode[6].'","'.$asset_explode[7].'","'.$asset_explode[3].'","'.$asset_explode[4].'","'.$asset_explode[1].'","'.$asset_explode[2].'","'.$cust_id.'","'.$cust_code.'","'.$cust_name.'","'.$date_of_visit.'","'.$time_of_visit.'","Scheduled")';
                          mysqli_query($varDBConnection,$sql_schedule);
                      
                        }
                     }
                     
                  }
                  
               }
               
            break;
            case 'FW-Wednesday':
               while( $current <= $date2 ) {
                  $dates['data'][] = date($format, $current);
                  $current = strtotime($stepVal, $current);
                  $date_of_visit=date("Y",$current).'-'.date("m",$current).'-'.date("d",$current);
                  if(date("l",$current)=="Wednesday")
                  {
                     $countmonth=weekOfMonth(strtotime($date_of_visit));
                     if($countmonth==1)
                     {
                         $sql_visit= $sql.'("'.$amc_id.'","'.$amc_ref_no.'","AMC","'.$cust_id.'","'.$cust_code.'","'.$cust_name.'","'.$vist_frequency.'","'.$date_of_visit.'","'.$time_of_visit.'","Scheduled","#0B9CF4")';
                        
                      
                        mysqli_query($varDBConnection,$sql_visit);
                        
                        $last_id = mysqli_insert_id($varDBConnection);
                       
                       
                        foreach($assets_array as $entry) {
                           
                               
                                $asset_explode=explode(",",$entry);
                   
                          $sql_schedule= $sql1.'("'.$last_id.'","'.$amc_id.'","'.$amc_ref_no.'","'.$asset_explode[0].'","'.$asset_explode[5].'","'.$asset_explode[8].'","'.$asset_explode[9].'","'.$asset_explode[6].'","'.$asset_explode[7].'","'.$asset_explode[3].'","'.$asset_explode[4].'","'.$asset_explode[1].'","'.$asset_explode[2].'","'.$cust_id.'","'.$cust_code.'","'.$cust_name.'","'.$date_of_visit.'","'.$time_of_visit.'","Scheduled")';
                          mysqli_query($varDBConnection,$sql_schedule);
                      
                        }
                     }
                     
                  }
                  
               }
               
            break;
            case 'FW-Thursday':
               while( $current <= $date2 ) {
                  $dates['data'][] = date($format, $current);
                  $current = strtotime($stepVal, $current);
                  $date_of_visit=date("Y",$current).'-'.date("m",$current).'-'.date("d",$current);
                  if(date("l",$current)=="Thursday")
                  {
                     $countmonth=weekOfMonth(strtotime($date_of_visit));
                     if($countmonth==1)
                     {
                         $sql_visit= $sql.'("'.$amc_id.'","'.$amc_ref_no.'","AMC","'.$cust_id.'","'.$cust_code.'","'.$cust_name.'","'.$vist_frequency.'","'.$date_of_visit.'","'.$time_of_visit.'","Scheduled","#0B9CF4")';
                        
                      
                        mysqli_query($varDBConnection,$sql_visit);
                        
                        $last_id = mysqli_insert_id($varDBConnection);
                       
                       
                        foreach($assets_array as $entry) {
                           
                               
                                $asset_explode=explode(",",$entry);
                   
                          $sql_schedule= $sql1.'("'.$last_id.'","'.$amc_id.'","'.$amc_ref_no.'","'.$asset_explode[0].'","'.$asset_explode[5].'","'.$asset_explode[8].'","'.$asset_explode[9].'","'.$asset_explode[6].'","'.$asset_explode[7].'","'.$asset_explode[3].'","'.$asset_explode[4].'","'.$asset_explode[1].'","'.$asset_explode[2].'","'.$cust_id.'","'.$cust_code.'","'.$cust_name.'","'.$date_of_visit.'","'.$time_of_visit.'","Scheduled")';
                          mysqli_query($varDBConnection,$sql_schedule);
                      
                        }
                     }
                     
                  }
                  
               }
               
            break;
            case 'FW-Friday':
               while( $current <= $date2 ) {
                  $dates['data'][] = date($format, $current);
                  $current = strtotime($stepVal, $current);
                  $date_of_visit=date("Y",$current).'-'.date("m",$current).'-'.date("d",$current);
                  if(date("l",$current)=="Friday")
                  {
                     $countmonth=weekOfMonth(strtotime($date_of_visit));
                     if($countmonth==1)
                     {
                         $sql_visit= $sql.'("'.$amc_id.'","'.$amc_ref_no.'","AMC","'.$cust_id.'","'.$cust_code.'","'.$cust_name.'","'.$vist_frequency.'","'.$date_of_visit.'","'.$time_of_visit.'","Scheduled","#0B9CF4")';
                        
                      
                        mysqli_query($varDBConnection,$sql_visit);
                        
                        $last_id = mysqli_insert_id($varDBConnection);
                       
                       
                        foreach($assets_array as $entry) {
                           
                               
                                $asset_explode=explode(",",$entry);
                   
                          $sql_schedule= $sql1.'("'.$last_id.'","'.$amc_id.'","'.$amc_ref_no.'","'.$asset_explode[0].'","'.$asset_explode[5].'","'.$asset_explode[8].'","'.$asset_explode[9].'","'.$asset_explode[6].'","'.$asset_explode[7].'","'.$asset_explode[3].'","'.$asset_explode[4].'","'.$asset_explode[1].'","'.$asset_explode[2].'","'.$cust_id.'","'.$cust_code.'","'.$cust_name.'","'.$date_of_visit.'","'.$time_of_visit.'","Scheduled")';
                          mysqli_query($varDBConnection,$sql_schedule);
                      
                        }
                     }
                     
                  }
                  
               }
               
            break;
            case 'FW-Saturday':
               while( $current <= $date2 ) {
                  $dates['data'][] = date($format, $current);
                  $current = strtotime($stepVal, $current);
                  $date_of_visit=date("Y",$current).'-'.date("m",$current).'-'.date("d",$current);
                  if(date("l",$current)=="Saturday")
                  {
                     $countmonth=weekOfMonth(strtotime($date_of_visit));
                     if($countmonth==1)
                     {
                          $sql_visit= $sql.'("'.$amc_id.'","'.$amc_ref_no.'","AMC","'.$cust_id.'","'.$cust_code.'","'.$cust_name.'","'.$vist_frequency.'","'.$date_of_visit.'","'.$time_of_visit.'","Scheduled","#0B9CF4")';
                        
                      
                        mysqli_query($varDBConnection,$sql_visit);
                        
                        $last_id = mysqli_insert_id($varDBConnection);
                       
                       
                        foreach($assets_array as $entry) {
                           
                               
                                $asset_explode=explode(",",$entry);
                   
                          $sql_schedule= $sql1.'("'.$last_id.'","'.$amc_id.'","'.$amc_ref_no.'","'.$asset_explode[0].'","'.$asset_explode[5].'","'.$asset_explode[8].'","'.$asset_explode[9].'","'.$asset_explode[6].'","'.$asset_explode[7].'","'.$asset_explode[3].'","'.$asset_explode[4].'","'.$asset_explode[1].'","'.$asset_explode[2].'","'.$cust_id.'","'.$cust_code.'","'.$cust_name.'","'.$date_of_visit.'","'.$time_of_visit.'","Scheduled")';
                          mysqli_query($varDBConnection,$sql_schedule);
                      
                        }
                     }
                     
                  }
                  
               }
               
            break;
            case 'SW-Sunday':
               while( $current <= $date2 ) {
                  $dates['data'][] = date($format, $current);
                  $current = strtotime($stepVal, $current);
                  $date_of_visit=date("Y",$current).'-'.date("m",$current).'-'.date("d",$current);
                  if(date("l",$current)=="Sunday")
                  {
                     $countmonth=weekOfMonth(strtotime($date_of_visit));
                     if($countmonth==2)
                     {
                          $sql_visit= $sql.'("'.$amc_id.'","'.$amc_ref_no.'","AMC","'.$cust_id.'","'.$cust_code.'","'.$cust_name.'","'.$vist_frequency.'","'.$date_of_visit.'","'.$time_of_visit.'","Scheduled","#0B9CF4")';
                        
                      
                        mysqli_query($varDBConnection,$sql_visit);
                        
                        $last_id = mysqli_insert_id($varDBConnection);
                       
                       
                        foreach($assets_array as $entry) {
                           
                               
                                $asset_explode=explode(",",$entry);
                   
                          $sql_schedule= $sql1.'("'.$last_id.'","'.$amc_id.'","'.$amc_ref_no.'","'.$asset_explode[0].'","'.$asset_explode[5].'","'.$asset_explode[8].'","'.$asset_explode[9].'","'.$asset_explode[6].'","'.$asset_explode[7].'","'.$asset_explode[3].'","'.$asset_explode[4].'","'.$asset_explode[1].'","'.$asset_explode[2].'","'.$cust_id.'","'.$cust_code.'","'.$cust_name.'","'.$date_of_visit.'","'.$time_of_visit.'","Scheduled")';
                          mysqli_query($varDBConnection,$sql_schedule);
                      
                        }
                     }
                     
                  }
                  
               }
               
            break;
            case 'SW-Monday':
               while( $current <= $date2 ) {
                  $dates['data'][] = date($format, $current);
                  $current = strtotime($stepVal, $current);
                  $date_of_visit=date("Y",$current).'-'.date("m",$current).'-'.date("d",$current);
                  if(date("l",$current)=="Monday")
                  {
                     $countmonth=weekOfMonth(strtotime($date_of_visit));
                     if($countmonth==2)
                     {
                         $sql_visit= $sql.'("'.$amc_id.'","'.$amc_ref_no.'","AMC","'.$cust_id.'","'.$cust_code.'","'.$cust_name.'","'.$vist_frequency.'","'.$date_of_visit.'","'.$time_of_visit.'","Scheduled","#0B9CF4")';
                        
                      
                        mysqli_query($varDBConnection,$sql_visit);
                        
                        $last_id = mysqli_insert_id($varDBConnection);
                       
                       
                        foreach($assets_array as $entry) {
                           
                               
                                $asset_explode=explode(",",$entry);
                   
                          $sql_schedule= $sql1.'("'.$last_id.'","'.$amc_id.'","'.$amc_ref_no.'","'.$asset_explode[0].'","'.$asset_explode[5].'","'.$asset_explode[8].'","'.$asset_explode[9].'","'.$asset_explode[6].'","'.$asset_explode[7].'","'.$asset_explode[3].'","'.$asset_explode[4].'","'.$asset_explode[1].'","'.$asset_explode[2].'","'.$cust_id.'","'.$cust_code.'","'.$cust_name.'","'.$date_of_visit.'","'.$time_of_visit.'","Scheduled")';
                          mysqli_query($varDBConnection,$sql_schedule);
                      
                        }
                     }
                     
                  }
                  
               }
               
            break;
            case 'SW-Tuesday':
               while( $current <= $date2 ) {
                  $dates['data'][] = date($format, $current);
                  $current = strtotime($stepVal, $current);
                  $date_of_visit=date("Y",$current).'-'.date("m",$current).'-'.date("d",$current);
                  if(date("l",$current)=="Tuesday")
                  {
                     $countmonth=weekOfMonth(strtotime($date_of_visit));
                     if($countmonth==2)
                     {
                         $sql_visit= $sql.'("'.$amc_id.'","'.$amc_ref_no.'","AMC","'.$cust_id.'","'.$cust_code.'","'.$cust_name.'","'.$vist_frequency.'","'.$date_of_visit.'","'.$time_of_visit.'","Scheduled","#0B9CF4")';
                        
                      
                        mysqli_query($varDBConnection,$sql_visit);
                        
                        $last_id = mysqli_insert_id($varDBConnection);
                       
                       
                        foreach($assets_array as $entry) {
                           
                               
                                $asset_explode=explode(",",$entry);
                   
                          $sql_schedule= $sql1.'("'.$last_id.'","'.$amc_id.'","'.$amc_ref_no.'","'.$asset_explode[0].'","'.$asset_explode[5].'","'.$asset_explode[8].'","'.$asset_explode[9].'","'.$asset_explode[6].'","'.$asset_explode[7].'","'.$asset_explode[3].'","'.$asset_explode[4].'","'.$asset_explode[1].'","'.$asset_explode[2].'","'.$cust_id.'","'.$cust_code.'","'.$cust_name.'","'.$date_of_visit.'","'.$time_of_visit.'","Scheduled")';
                          mysqli_query($varDBConnection,$sql_schedule);
                      
                        }
                     }
                     
                  }
                  
               }
               
            break;
            case 'SW-Wednesday':
               while( $current <= $date2 ) {
                  $dates['data'][] = date($format, $current);
                  $current = strtotime($stepVal, $current);
                  $date_of_visit=date("Y",$current).'-'.date("m",$current).'-'.date("d",$current);
                  if(date("l",$current)=="Wednesday")
                  {
                     $countmonth=weekOfMonth(strtotime($date_of_visit));
                     if($countmonth==2)
                     {
                          $sql_visit= $sql.'("'.$amc_id.'","'.$amc_ref_no.'","AMC","'.$cust_id.'","'.$cust_code.'","'.$cust_name.'","'.$vist_frequency.'","'.$date_of_visit.'","'.$time_of_visit.'","Scheduled","#0B9CF4")';
                        
                      
                        mysqli_query($varDBConnection,$sql_visit);
                        
                        $last_id = mysqli_insert_id($varDBConnection);
                       
                       
                        foreach($assets_array as $entry) {
                           
                               
                                $asset_explode=explode(",",$entry);
                   
                          $sql_schedule= $sql1.'("'.$last_id.'","'.$amc_id.'","'.$amc_ref_no.'","'.$asset_explode[0].'","'.$asset_explode[5].'","'.$asset_explode[8].'","'.$asset_explode[9].'","'.$asset_explode[6].'","'.$asset_explode[7].'","'.$asset_explode[3].'","'.$asset_explode[4].'","'.$asset_explode[1].'","'.$asset_explode[2].'","'.$cust_id.'","'.$cust_code.'","'.$cust_name.'","'.$date_of_visit.'","'.$time_of_visit.'","Scheduled")';
                          mysqli_query($varDBConnection,$sql_schedule);
                      
                        }
                     }
                     
                  }
                  
               }
               
            break;
            case 'SW-Thursday':
               while( $current <= $date2 ) {
                  $dates['data'][] = date($format, $current);
                  $current = strtotime($stepVal, $current);
                  $date_of_visit=date("Y",$current).'-'.date("m",$current).'-'.date("d",$current);
                  if(date("l",$current)=="Thursday")
                  {
                     $countmonth=weekOfMonth(strtotime($date_of_visit));
                     if($countmonth==2)
                     {
                         $sql_visit= $sql.'("'.$amc_id.'","'.$amc_ref_no.'","AMC","'.$cust_id.'","'.$cust_code.'","'.$cust_name.'","'.$vist_frequency.'","'.$date_of_visit.'","'.$time_of_visit.'","Scheduled","#0B9CF4")';
                        
                      
                        mysqli_query($varDBConnection,$sql_visit);
                        
                        $last_id = mysqli_insert_id($varDBConnection);
                       
                       
                        foreach($assets_array as $entry) {
                           
                               
                                $asset_explode=explode(",",$entry);
                   
                          $sql_schedule= $sql1.'("'.$last_id.'","'.$amc_id.'","'.$amc_ref_no.'","'.$asset_explode[0].'","'.$asset_explode[5].'","'.$asset_explode[8].'","'.$asset_explode[9].'","'.$asset_explode[6].'","'.$asset_explode[7].'","'.$asset_explode[3].'","'.$asset_explode[4].'","'.$asset_explode[1].'","'.$asset_explode[2].'","'.$cust_id.'","'.$cust_code.'","'.$cust_name.'","'.$date_of_visit.'","'.$time_of_visit.'","Scheduled")';
                          mysqli_query($varDBConnection,$sql_schedule);
                      
                        }
                     }
                     
                  }
                  
               }
               
            break;
            case 'SW-Friday':
               while( $current <= $date2 ) {
                  $dates['data'][] = date($format, $current);
                  $current = strtotime($stepVal, $current);
                  $date_of_visit=date("Y",$current).'-'.date("m",$current).'-'.date("d",$current);
                  if(date("l",$current)=="Friday")
                  {
                     $countmonth=weekOfMonth(strtotime($date_of_visit));
                     if($countmonth==2)
                     {
                         $sql_visit= $sql.'("'.$amc_id.'","'.$amc_ref_no.'","AMC","'.$cust_id.'","'.$cust_code.'","'.$cust_name.'","'.$vist_frequency.'","'.$date_of_visit.'","'.$time_of_visit.'","Scheduled","#0B9CF4")';
                        
                      
                        mysqli_query($varDBConnection,$sql_visit);
                        
                        $last_id = mysqli_insert_id($varDBConnection);
                       
                       
                        foreach($assets_array as $entry) {
                           
                               
                                $asset_explode=explode(",",$entry);
                   
                          $sql_schedule= $sql1.'("'.$last_id.'","'.$amc_id.'","'.$amc_ref_no.'","'.$asset_explode[0].'","'.$asset_explode[5].'","'.$asset_explode[8].'","'.$asset_explode[9].'","'.$asset_explode[6].'","'.$asset_explode[7].'","'.$asset_explode[3].'","'.$asset_explode[4].'","'.$asset_explode[1].'","'.$asset_explode[2].'","'.$cust_id.'","'.$cust_code.'","'.$cust_name.'","'.$date_of_visit.'","'.$time_of_visit.'","Scheduled")';
                          mysqli_query($varDBConnection,$sql_schedule);
                      
                        }
                     }
                     
                  }
                  
               }
               
            break;
            case 'SW-Saturday':
               while( $current <= $date2 ) {
                  $dates['data'][] = date($format, $current);
                  $current = strtotime($stepVal, $current);
                  $date_of_visit=date("Y",$current).'-'.date("m",$current).'-'.date("d",$current);
                  if(date("l",$current)=="Saturday")
                  {
                     $countmonth=weekOfMonth(strtotime($date_of_visit));
                     if($countmonth==2)
                     {
                          $sql_visit= $sql.'("'.$amc_id.'","'.$amc_ref_no.'","AMC","'.$cust_id.'","'.$cust_code.'","'.$cust_name.'","'.$vist_frequency.'","'.$date_of_visit.'","'.$time_of_visit.'","Scheduled","#0B9CF4")';
                        
                      
                        mysqli_query($varDBConnection,$sql_visit);
                        
                        $last_id = mysqli_insert_id($varDBConnection);
                       
                       
                        foreach($assets_array as $entry) {
                           
                               
                                $asset_explode=explode(",",$entry);
                   
                          $sql_schedule= $sql1.'("'.$last_id.'","'.$amc_id.'","'.$amc_ref_no.'","'.$asset_explode[0].'","'.$asset_explode[5].'","'.$asset_explode[8].'","'.$asset_explode[9].'","'.$asset_explode[6].'","'.$asset_explode[7].'","'.$asset_explode[3].'","'.$asset_explode[4].'","'.$asset_explode[1].'","'.$asset_explode[2].'","'.$cust_id.'","'.$cust_code.'","'.$cust_name.'","'.$date_of_visit.'","'.$time_of_visit.'","Scheduled")';
                          mysqli_query($varDBConnection,$sql_schedule);
                      
                        }
                     }
                     
                  }
                  
               }
               
            break;

            case 'TW-Sunday':
               while( $current <= $date2 ) {
                  $dates['data'][] = date($format, $current);
                  $current = strtotime($stepVal, $current);
                  $date_of_visit=date("Y",$current).'-'.date("m",$current).'-'.date("d",$current);
                  if(date("l",$current)=="Sunday")
                  {
                     $countmonth=weekOfMonth(strtotime($date_of_visit));
                     if($countmonth==3)
                     {
                          $sql_visit= $sql.'("'.$amc_id.'","'.$amc_ref_no.'","AMC","'.$cust_id.'","'.$cust_code.'","'.$cust_name.'","'.$vist_frequency.'","'.$date_of_visit.'","'.$time_of_visit.'","Scheduled","#0B9CF4")';
                        
                      
                        mysqli_query($varDBConnection,$sql_visit);
                        
                        $last_id = mysqli_insert_id($varDBConnection);
                       
                       
                        foreach($assets_array as $entry) {
                           
                               
                                $asset_explode=explode(",",$entry);
                   
                          $sql_schedule= $sql1.'("'.$last_id.'","'.$amc_id.'","'.$amc_ref_no.'","'.$asset_explode[0].'","'.$asset_explode[5].'","'.$asset_explode[8].'","'.$asset_explode[9].'","'.$asset_explode[6].'","'.$asset_explode[7].'","'.$asset_explode[3].'","'.$asset_explode[4].'","'.$asset_explode[1].'","'.$asset_explode[2].'","'.$cust_id.'","'.$cust_code.'","'.$cust_name.'","'.$date_of_visit.'","'.$time_of_visit.'","Scheduled")';
                          mysqli_query($varDBConnection,$sql_schedule);
                      
                        }
                     }
                     
                  }
                  
               }
               
            break;
            case 'TW-Monday':
               while( $current <= $date2 ) {
                  $dates['data'][] = date($format, $current);
                  $current = strtotime($stepVal, $current);
                  $date_of_visit=date("Y",$current).'-'.date("m",$current).'-'.date("d",$current);
                  if(date("l",$current)=="Monday")
                  {
                     $countmonth=weekOfMonth(strtotime($date_of_visit));
                     if($countmonth==3)
                     {
                        $sql_visit= $sql.'("'.$amc_id.'","'.$amc_ref_no.'","AMC","'.$cust_id.'","'.$cust_code.'","'.$cust_name.'","'.$vist_frequency.'","'.$date_of_visit.'","'.$time_of_visit.'","Scheduled","#0B9CF4")';
                        
                      
                        mysqli_query($varDBConnection,$sql_visit);
                        
                        $last_id = mysqli_insert_id($varDBConnection);
                       
                       
                        foreach($assets_array as $entry) {
                           
                               
                                $asset_explode=explode(",",$entry);
                   
                          $sql_schedule= $sql1.'("'.$last_id.'","'.$amc_id.'","'.$amc_ref_no.'","'.$asset_explode[0].'","'.$asset_explode[5].'","'.$asset_explode[8].'","'.$asset_explode[9].'","'.$asset_explode[6].'","'.$asset_explode[7].'","'.$asset_explode[3].'","'.$asset_explode[4].'","'.$asset_explode[1].'","'.$asset_explode[2].'","'.$cust_id.'","'.$cust_code.'","'.$cust_name.'","'.$date_of_visit.'","'.$time_of_visit.'","Scheduled")';
                          mysqli_query($varDBConnection,$sql_schedule);
                      
                        }
                     }
                     
                  }
                  
               }
               
            break;
            case 'TW-Tuesday':
               while( $current <= $date2 ) {
                  $dates['data'][] = date($format, $current);
                  $current = strtotime($stepVal, $current);
                  $date_of_visit=date("Y",$current).'-'.date("m",$current).'-'.date("d",$current);
                  if(date("l",$current)=="Tuesday")
                  {
                     $countmonth=weekOfMonth(strtotime($date_of_visit));
                     if($countmonth==3)
                     {
                       $sql_visit= $sql.'("'.$amc_id.'","'.$amc_ref_no.'","AMC","'.$cust_id.'","'.$cust_code.'","'.$cust_name.'","'.$vist_frequency.'","'.$date_of_visit.'","'.$time_of_visit.'","Scheduled","#0B9CF4")';
                        
                      
                        mysqli_query($varDBConnection,$sql_visit);
                        
                        $last_id = mysqli_insert_id($varDBConnection);
                       
                       
                        foreach($assets_array as $entry) {
                           
                               
                                $asset_explode=explode(",",$entry);
                   
                          $sql_schedule= $sql1.'("'.$last_id.'","'.$amc_id.'","'.$amc_ref_no.'","'.$asset_explode[0].'","'.$asset_explode[5].'","'.$asset_explode[8].'","'.$asset_explode[9].'","'.$asset_explode[6].'","'.$asset_explode[7].'","'.$asset_explode[3].'","'.$asset_explode[4].'","'.$asset_explode[1].'","'.$asset_explode[2].'","'.$cust_id.'","'.$cust_code.'","'.$cust_name.'","'.$date_of_visit.'","'.$time_of_visit.'","Scheduled")';
                          mysqli_query($varDBConnection,$sql_schedule);
                      
                        }
                     }
                     
                  }
                  
               }
               
            break;
            case 'TW-Wednesday':
               while( $current <= $date2 ) {
                  $dates['data'][] = date($format, $current);
                  $current = strtotime($stepVal, $current);
                  $date_of_visit=date("Y",$current).'-'.date("m",$current).'-'.date("d",$current);
                  if(date("l",$current)=="Wednesday")
                  {
                     $countmonth=weekOfMonth(strtotime($date_of_visit));
                     if($countmonth==3)
                     {
                         $sql_visit= $sql.'("'.$amc_id.'","'.$amc_ref_no.'","AMC","'.$cust_id.'","'.$cust_code.'","'.$cust_name.'","'.$vist_frequency.'","'.$date_of_visit.'","'.$time_of_visit.'","Scheduled","#0B9CF4")';
                        
                      
                        mysqli_query($varDBConnection,$sql_visit);
                        
                        $last_id = mysqli_insert_id($varDBConnection);
                       
                       
                        foreach($assets_array as $entry) {
                           
                               
                                $asset_explode=explode(",",$entry);
                   
                          $sql_schedule= $sql1.'("'.$last_id.'","'.$amc_id.'","'.$amc_ref_no.'","'.$asset_explode[0].'","'.$asset_explode[5].'","'.$asset_explode[8].'","'.$asset_explode[9].'","'.$asset_explode[6].'","'.$asset_explode[7].'","'.$asset_explode[3].'","'.$asset_explode[4].'","'.$asset_explode[1].'","'.$asset_explode[2].'","'.$cust_id.'","'.$cust_code.'","'.$cust_name.'","'.$date_of_visit.'","'.$time_of_visit.'","Scheduled")';
                          mysqli_query($varDBConnection,$sql_schedule);
                      
                        }
                     }
                     
                  }
                  
               }
               
            break;
            case 'TW-Thursday':
               while( $current <= $date2 ) {
                  $dates['data'][] = date($format, $current);
                  $current = strtotime($stepVal, $current);
                  $date_of_visit=date("Y",$current).'-'.date("m",$current).'-'.date("d",$current);
                  if(date("l",$current)=="Thursday")
                  {
                     $countmonth=weekOfMonth(strtotime($date_of_visit));
                     if($countmonth==3)
                     {
                         $sql_visit= $sql.'("'.$amc_id.'","'.$amc_ref_no.'","AMC","'.$cust_id.'","'.$cust_code.'","'.$cust_name.'","'.$vist_frequency.'","'.$date_of_visit.'","'.$time_of_visit.'","Scheduled","#0B9CF4")';
                        
                      
                        mysqli_query($varDBConnection,$sql_visit);
                        
                        $last_id = mysqli_insert_id($varDBConnection);
                       
                       
                        foreach($assets_array as $entry) {
                           
                               
                                $asset_explode=explode(",",$entry);
                   
                          $sql_schedule= $sql1.'("'.$last_id.'","'.$amc_id.'","'.$amc_ref_no.'","'.$asset_explode[0].'","'.$asset_explode[5].'","'.$asset_explode[8].'","'.$asset_explode[9].'","'.$asset_explode[6].'","'.$asset_explode[7].'","'.$asset_explode[3].'","'.$asset_explode[4].'","'.$asset_explode[1].'","'.$asset_explode[2].'","'.$cust_id.'","'.$cust_code.'","'.$cust_name.'","'.$date_of_visit.'","'.$time_of_visit.'","Scheduled")';
                          mysqli_query($varDBConnection,$sql_schedule);
                      
                        }
                     }
                     
                  }
                  
               }
               
            break;
            case 'TW-Friday':
               while( $current <= $date2 ) {
                  $dates['data'][] = date($format, $current);
                  $current = strtotime($stepVal, $current);
                  $date_of_visit=date("Y",$current).'-'.date("m",$current).'-'.date("d",$current);
                  if(date("l",$current)=="Friday")
                  {
                     $countmonth=weekOfMonth(strtotime($date_of_visit));
                     if($countmonth==3)
                     {
                         $sql_visit= $sql.'("'.$amc_id.'","'.$amc_ref_no.'","AMC","'.$cust_id.'","'.$cust_code.'","'.$cust_name.'","'.$vist_frequency.'","'.$date_of_visit.'","'.$time_of_visit.'","Scheduled","#0B9CF4")';
                        
                      
                        mysqli_query($varDBConnection,$sql_visit);
                        
                        $last_id = mysqli_insert_id($varDBConnection);
                       
                       
                        foreach($assets_array as $entry) {
                           
                               
                                $asset_explode=explode(",",$entry);
                   
                          $sql_schedule= $sql1.'("'.$last_id.'","'.$amc_id.'","'.$amc_ref_no.'","'.$asset_explode[0].'","'.$asset_explode[5].'","'.$asset_explode[8].'","'.$asset_explode[9].'","'.$asset_explode[6].'","'.$asset_explode[7].'","'.$asset_explode[3].'","'.$asset_explode[4].'","'.$asset_explode[1].'","'.$asset_explode[2].'","'.$cust_id.'","'.$cust_code.'","'.$cust_name.'","'.$date_of_visit.'","'.$time_of_visit.'","Scheduled")';
                          mysqli_query($varDBConnection,$sql_schedule);
                      
                        }
                     }
                     
                  }
                  
               }
               
            break;
            case 'TW-Saturday':
               while( $current <= $date2 ) {
                  $dates['data'][] = date($format, $current);
                  $current = strtotime($stepVal, $current);
                  $date_of_visit=date("Y",$current).'-'.date("m",$current).'-'.date("d",$current);
                  if(date("l",$current)=="Saturday")
                  {
                     $countmonth=weekOfMonth(strtotime($date_of_visit));
                     if($countmonth==3)
                     {
                         $sql_visit= $sql.'("'.$amc_id.'","'.$amc_ref_no.'","AMC","'.$cust_id.'","'.$cust_code.'","'.$cust_name.'","'.$vist_frequency.'","'.$date_of_visit.'","'.$time_of_visit.'","Scheduled","#0B9CF4")';
                        
                      
                        mysqli_query($varDBConnection,$sql_visit);
                        
                        $last_id = mysqli_insert_id($varDBConnection);
                       
                       
                        foreach($assets_array as $entry) {
                           
                               
                                $asset_explode=explode(",",$entry);
                   
                          $sql_schedule= $sql1.'("'.$last_id.'","'.$amc_id.'","'.$amc_ref_no.'","'.$asset_explode[0].'","'.$asset_explode[5].'","'.$asset_explode[8].'","'.$asset_explode[9].'","'.$asset_explode[6].'","'.$asset_explode[7].'","'.$asset_explode[3].'","'.$asset_explode[4].'","'.$asset_explode[1].'","'.$asset_explode[2].'","'.$cust_id.'","'.$cust_code.'","'.$cust_name.'","'.$date_of_visit.'","'.$time_of_visit.'","Scheduled")';
                          mysqli_query($varDBConnection,$sql_schedule);
                      
                        }
                     }
                     
                  }
                  
               }
               
            break;
            case 'FRW-Sunday':
               while( $current <= $date2 ) {
                  $dates['data'][] = date($format, $current);
                  $current = strtotime($stepVal, $current);
                  $date_of_visit=date("Y",$current).'-'.date("m",$current).'-'.date("d",$current);
                  if(date("l",$current)=="Sunday")
                  {
                     $countmonth=weekOfMonth(strtotime($date_of_visit));
                     if($countmonth==4)
                     {
                         $sql_visit= $sql.'("'.$amc_id.'","'.$amc_ref_no.'","AMC","'.$cust_id.'","'.$cust_code.'","'.$cust_name.'","'.$vist_frequency.'","'.$date_of_visit.'","'.$time_of_visit.'","Scheduled","#0B9CF4")';
                        
                      
                        mysqli_query($varDBConnection,$sql_visit);
                        
                        $last_id = mysqli_insert_id($varDBConnection);
                       
                       
                        foreach($assets_array as $entry) {
                           
                               
                                $asset_explode=explode(",",$entry);
                   
                          $sql_schedule= $sql1.'("'.$last_id.'","'.$amc_id.'","'.$amc_ref_no.'","'.$asset_explode[0].'","'.$asset_explode[5].'","'.$asset_explode[8].'","'.$asset_explode[9].'","'.$asset_explode[6].'","'.$asset_explode[7].'","'.$asset_explode[3].'","'.$asset_explode[4].'","'.$asset_explode[1].'","'.$asset_explode[2].'","'.$cust_id.'","'.$cust_code.'","'.$cust_name.'","'.$date_of_visit.'","'.$time_of_visit.'","Scheduled")';
                          mysqli_query($varDBConnection,$sql_schedule);
                      
                        }
                     }
                     
                  }
                  
               }
               
            break;
            case 'FRW-Monday':
               while( $current <= $date2 ) {
                  $dates['data'][] = date($format, $current);
                  $current = strtotime($stepVal, $current);
                  $date_of_visit=date("Y",$current).'-'.date("m",$current).'-'.date("d",$current);
                  if(date("l",$current)=="Monday")
                  {
                     $countmonth=weekOfMonth(strtotime($date_of_visit));
                     if($countmonth==4)
                     {
                          $sql_visit= $sql.'("'.$amc_id.'","'.$amc_ref_no.'","AMC","'.$cust_id.'","'.$cust_code.'","'.$cust_name.'","'.$vist_frequency.'","'.$date_of_visit.'","'.$time_of_visit.'","Scheduled","#0B9CF4")';
                        
                      
                        mysqli_query($varDBConnection,$sql_visit);
                        
                        $last_id = mysqli_insert_id($varDBConnection);
                       
                       
                        foreach($assets_array as $entry) {
                           
                               
                                $asset_explode=explode(",",$entry);
                   
                          $sql_schedule= $sql1.'("'.$last_id.'","'.$amc_id.'","'.$amc_ref_no.'","'.$asset_explode[0].'","'.$asset_explode[5].'","'.$asset_explode[8].'","'.$asset_explode[9].'","'.$asset_explode[6].'","'.$asset_explode[7].'","'.$asset_explode[3].'","'.$asset_explode[4].'","'.$asset_explode[1].'","'.$asset_explode[2].'","'.$cust_id.'","'.$cust_code.'","'.$cust_name.'","'.$date_of_visit.'","'.$time_of_visit.'","Scheduled")';
                          mysqli_query($varDBConnection,$sql_schedule);
                      
                        }
                     }
                     
                  }
                  
               }
               
            break;
            case 'FRW-Tuesday':
               while( $current <= $date2 ) {
                  $dates['data'][] = date($format, $current);
                  $current = strtotime($stepVal, $current);
                  $date_of_visit=date("Y",$current).'-'.date("m",$current).'-'.date("d",$current);
                  if(date("l",$current)=="Tuesday")
                  {
                     $countmonth=weekOfMonth(strtotime($date_of_visit));
                     if($countmonth==4)
                     {
                        $sql_visit= $sql.'("'.$amc_id.'","'.$amc_ref_no.'","AMC","'.$cust_id.'","'.$cust_code.'","'.$cust_name.'","'.$vist_frequency.'","'.$date_of_visit.'","'.$time_of_visit.'","Scheduled","#0B9CF4")';
                        
                      
                        mysqli_query($varDBConnection,$sql_visit);
                        
                        $last_id = mysqli_insert_id($varDBConnection);
                       
                       
                        foreach($assets_array as $entry) {
                           
                               
                                $asset_explode=explode(",",$entry);
                   
                          $sql_schedule= $sql1.'("'.$last_id.'","'.$amc_id.'","'.$amc_ref_no.'","'.$asset_explode[0].'","'.$asset_explode[5].'","'.$asset_explode[8].'","'.$asset_explode[9].'","'.$asset_explode[6].'","'.$asset_explode[7].'","'.$asset_explode[3].'","'.$asset_explode[4].'","'.$asset_explode[1].'","'.$asset_explode[2].'","'.$cust_id.'","'.$cust_code.'","'.$cust_name.'","'.$date_of_visit.'","'.$time_of_visit.'","Scheduled")';
                          mysqli_query($varDBConnection,$sql_schedule);
                      
                        }
                     }
                     
                  }
                  
               }
               
            break;
            case 'FRW-Wednesday':
               while( $current <= $date2 ) {
                  $dates['data'][] = date($format, $current);
                  $current = strtotime($stepVal, $current);
                  $date_of_visit=date("Y",$current).'-'.date("m",$current).'-'.date("d",$current);
                  if(date("l",$current)=="Wednesday")
                  {
                     $countmonth=weekOfMonth(strtotime($date_of_visit));
                     if($countmonth==4)
                     {
                         $sql_visit= $sql.'("'.$amc_id.'","'.$amc_ref_no.'","AMC","'.$cust_id.'","'.$cust_code.'","'.$cust_name.'","'.$vist_frequency.'","'.$date_of_visit.'","'.$time_of_visit.'","Scheduled","#0B9CF4")';
                        
                      
                        mysqli_query($varDBConnection,$sql_visit);
                        
                        $last_id = mysqli_insert_id($varDBConnection);
                       
                       
                        foreach($assets_array as $entry) {
                           
                               
                                $asset_explode=explode(",",$entry);
                   
                          $sql_schedule= $sql1.'("'.$last_id.'","'.$amc_id.'","'.$amc_ref_no.'","'.$asset_explode[0].'","'.$asset_explode[5].'","'.$asset_explode[8].'","'.$asset_explode[9].'","'.$asset_explode[6].'","'.$asset_explode[7].'","'.$asset_explode[3].'","'.$asset_explode[4].'","'.$asset_explode[1].'","'.$asset_explode[2].'","'.$cust_id.'","'.$cust_code.'","'.$cust_name.'","'.$date_of_visit.'","'.$time_of_visit.'","Scheduled")';
                          mysqli_query($varDBConnection,$sql_schedule);
                      
                        }
                     }
                     
                  }
                  
               }
               
            break;
            case 'FRW-Thursday':
               while( $current <= $date2 ) {
                  $dates['data'][] = date($format, $current);
                  $current = strtotime($stepVal, $current);
                  $date_of_visit=date("Y",$current).'-'.date("m",$current).'-'.date("d",$current);
                  if(date("l",$current)=="Thursday")
                  {
                     $countmonth=weekOfMonth(strtotime($date_of_visit));
                     if($countmonth==4)
                     {
                         $sql_visit= $sql.'("'.$amc_id.'","'.$amc_ref_no.'","AMC","'.$cust_id.'","'.$cust_code.'","'.$cust_name.'","'.$vist_frequency.'","'.$date_of_visit.'","'.$time_of_visit.'","Scheduled","#0B9CF4")';
                        
                      
                        mysqli_query($varDBConnection,$sql_visit);
                        
                        $last_id = mysqli_insert_id($varDBConnection);
                       
                       
                        foreach($assets_array as $entry) {
                           
                               
                                $asset_explode=explode(",",$entry);
                   
                          $sql_schedule= $sql1.'("'.$last_id.'","'.$amc_id.'","'.$amc_ref_no.'","'.$asset_explode[0].'","'.$asset_explode[5].'","'.$asset_explode[8].'","'.$asset_explode[9].'","'.$asset_explode[6].'","'.$asset_explode[7].'","'.$asset_explode[3].'","'.$asset_explode[4].'","'.$asset_explode[1].'","'.$asset_explode[2].'","'.$cust_id.'","'.$cust_code.'","'.$cust_name.'","'.$date_of_visit.'","'.$time_of_visit.'","Scheduled")';
                          mysqli_query($varDBConnection,$sql_schedule);
                      
                        }
                     }
                     
                  }
                  
               }
               
            break;
            case 'FRW-Friday':
               while( $current <= $date2 ) {
                  $dates['data'][] = date($format, $current);
                  $current = strtotime($stepVal, $current);
                  $date_of_visit=date("Y",$current).'-'.date("m",$current).'-'.date("d",$current);
                  if(date("l",$current)=="Friday")
                  {
                     $countmonth=weekOfMonth(strtotime($date_of_visit));
                     if($countmonth==4)
                     {
                         $sql_visit= $sql.'("'.$amc_id.'","'.$amc_ref_no.'","AMC","'.$cust_id.'","'.$cust_code.'","'.$cust_name.'","'.$vist_frequency.'","'.$date_of_visit.'","'.$time_of_visit.'","Scheduled","#0B9CF4")';
                        
                      
                        mysqli_query($varDBConnection,$sql_visit);
                        
                        $last_id = mysqli_insert_id($varDBConnection);
                       
                       
                        foreach($assets_array as $entry) {
                           
                               
                                $asset_explode=explode(",",$entry);
                   
                          $sql_schedule= $sql1.'("'.$last_id.'","'.$amc_id.'","'.$amc_ref_no.'","'.$asset_explode[0].'","'.$asset_explode[5].'","'.$asset_explode[8].'","'.$asset_explode[9].'","'.$asset_explode[6].'","'.$asset_explode[7].'","'.$asset_explode[3].'","'.$asset_explode[4].'","'.$asset_explode[1].'","'.$asset_explode[2].'","'.$cust_id.'","'.$cust_code.'","'.$cust_name.'","'.$date_of_visit.'","'.$time_of_visit.'","Scheduled")';
                          mysqli_query($varDBConnection,$sql_schedule);
                      
                        }
                     }
                     
                  }
                  
               }
               
            break;
            case 'FRW-Saturday':
               while( $current <= $date2 ) {
                  $dates['data'][] = date($format, $current);
                  $current = strtotime($stepVal, $current);
                  $date_of_visit=date("Y",$current).'-'.date("m",$current).'-'.date("d",$current);
                  if(date("l",$current)=="Saturday")
                  {
                     $countmonth=weekOfMonth(strtotime($date_of_visit));
                     if($countmonth==4)
                     {
                          $sql_visit= $sql.'("'.$amc_id.'","'.$amc_ref_no.'","AMC","'.$cust_id.'","'.$cust_code.'","'.$cust_name.'","'.$vist_frequency.'","'.$date_of_visit.'","'.$time_of_visit.'","Scheduled","#0B9CF4")';
                        
                      
                        mysqli_query($varDBConnection,$sql_visit);
                        
                        $last_id = mysqli_insert_id($varDBConnection);
                       
                       
                        foreach($assets_array as $entry) {
                           
                               
                                $asset_explode=explode(",",$entry);
                   
                          $sql_schedule= $sql1.'("'.$last_id.'","'.$amc_id.'","'.$amc_ref_no.'","'.$asset_explode[0].'","'.$asset_explode[5].'","'.$asset_explode[8].'","'.$asset_explode[9].'","'.$asset_explode[6].'","'.$asset_explode[7].'","'.$asset_explode[3].'","'.$asset_explode[4].'","'.$asset_explode[1].'","'.$asset_explode[2].'","'.$cust_id.'","'.$cust_code.'","'.$cust_name.'","'.$date_of_visit.'","'.$time_of_visit.'","Scheduled")';
                          mysqli_query($varDBConnection,$sql_schedule);
                      
                        }
                     }
                     
                  }
                  
               }
               
            break;

            default:
            break;
            } 
         
        // $sql=rtrim($sql, ",");
      
        return 1;
        
         //return json_encode($dates);
      
   }



              $start_date=$_POST['start_date'];
              $end_date=$_POST['end_date'];
              $v_amc_ref_id=$_POST['v_amc_ref_id'];
              $v_amc_ref_no=$_POST['v_amc_ref_no'];
              $v_cust_id=$_POST['v_cust_id'];
              $v_cust_code=$_POST['v_cust_code'];
              $v_cust_name=$_POST['v_cust_name'];
              $schedule_time=$_POST['schedule_time'];
              $asset_table_selected_count=$_POST['asset_table_selected_count'];
              $SQLString=$_POST['SQLString'];
              $visitmode=$_POST['frequency_array'];
              echo count($visitmode);
               for($i=0;$i<count($visitmode);$i++)
               {
                   //echo $visitmode[$i]; 
               $retunsql = displayDates($start_date,$end_date,$visitmode[$i],$v_amc_ref_id,$v_amc_ref_no,$v_cust_id,$v_cust_code,$v_cust_name,$schedule_time,$asset_table_selected_count,$SQLString);
               //echo $retunsql;
                 echo $visitmode[$i];  
               }
          
     
       
         function weekOfMonth($date) {
            //Get the first day of the month.
            $firstOfMonth = strtotime(date("Y-m-01", $date));
            //Apply above formula.
            return weekOfYear($date) - weekOfYear($firstOfMonth) + 1;
        }
        
        function weekOfYear($date) {
            $weekOfYear = intval(date("W", $date));
            if (date('n', $date) == "1" && $weekOfYear > 51) {
                // It's the last week of the previos year.
                $weekOfYear = 0;    
            }
            return $weekOfYear;
        }

?>