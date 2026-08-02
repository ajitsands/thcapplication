<?php
include(__DIR__ . '/../../model/db_connection/connection.php');
//   $DBConn = new DBConnection();
//   $varDBConnection;
//  $varDBConnection = $DBConn->ConnectToMYSQL();
//   date_default_timezone_set('Asia/Bahrain');

   function displayDates($date1,$date2,$vist_frequency,$amc_id,$amc_ref_no,$time_of_visit,$amc_childarray,$asset_table_selected_count,$amc_assetarray,$start_slot,$add_slot,$format = 'd-m-Y' ) {
      $dates = array();
       $current1 = strtotime($date1);
      $current = strtotime($date1)-1;
      $date2 = strtotime($date2);
      $stepVal = '+1 day';
      $customer_id;
      $customer_name;
      $customer_code;
       $location_id;
       $location_code;
       $asset_location;
       $building_id;
       $building_code;
       $asset_building;
         $DBConn = new DBConnection();
   $varDBConnection;
 $varDBConnection = $DBConn->ConnectToMYSQL();
   date_default_timezone_set('Asia/Bahrain');      
               
     // $sql="insert into tbl_visits (amc_tkt_id,amc_tkt_ref_no,amc_ticket,customer_id,customer_code,customer_name,location_id,location_code,location_name,building_id,building_code,building_name,visit_mode,date_of_visits,time_of_visit,additional_slots,amc_visit_status,amc_schedule_color) values ";
     
         switch($vist_frequency)
         {
            
            case 'YSD':
               $date_of_visit=date("Y",$current1).'-'.date("m",$current1).'-'.date("d",$current1);
                for ($i=0;$i<$asset_table_selected_count; $i++) {
                  
                     $result_cust =  mysqli_query($varDBConnection,"SELECT customer_id,customer_name,customer_code,location_id,location_code,asset_location,building_id,building_code,asset_building from view_amc_asset_details where amc_ref_no='".$amc_ref_no."' and asset_ref_no='".$amc_assetarray[$i]."' limit 1");
                            while($row_cust=mysqli_fetch_assoc($result_cust)) { 
                               $customer_id= $row_cust['customer_id'];
                               $customer_name= $row_cust['customer_name'];
                               $customer_code= $row_cust['customer_code'];
                               $location_id= $row_cust['location_id'];
                               $location_code= $row_cust['location_code'];
                               $asset_location= $row_cust['asset_location'];
                               $building_id= $row_cust['building_id'];
                               $building_code= $row_cust['building_code'];
                               $asset_building= $row_cust['asset_building'];
                                
                            }
                           
                            $sql= 'insert into tbl_visits (amc_tkt_id,amc_tkt_ref_no,amc_ticket,customer_id,customer_code,customer_name,location_id,location_code,location_name,building_id,building_code,building_name,visit_mode,date_of_visits,time_of_visit,additional_slots,amc_visit_status,amc_schedule_color,visit_start_time) values ('.$amc_childarray[$i].',"'.$amc_ref_no.'","AMC",'.$customer_id.',"'.$customer_code.'","'.$customer_name.'",'.$location_id.',"'.$location_code.'","'.$asset_location.'",'.$building_id.',"'.$building_code.'","'.$asset_building.'","'.$vist_frequency.'","'.$date_of_visit.'",'.$start_slot.','.$add_slot.',"Scheduled","#39C0ED","'.$time_of_visit.'")';
                         
                            mysqli_query($varDBConnection,$sql);
                    
                }
              
            break;
            case 'ED-All':
               while( $current <= $date2 ) {
                  $dates['data'][] = date($format, $current);
                  $current = strtotime($stepVal, $current);
                  $date_of_visit=date("Y",$current).'-'.date("m",$current).'-'.date("d",$current);
                  
                   for ($i=0;$i<$asset_table_selected_count; $i++) {
                  
                     $result_cust =  mysqli_query($varDBConnection,"SELECT customer_id,customer_name,customer_code,location_id,location_code,asset_location,building_id,building_code,asset_building from view_amc_asset_details where amc_ref_no='".$amc_ref_no."' and asset_ref_no='".$amc_assetarray[$i]."' limit 1");
                            while($row_cust=mysqli_fetch_assoc($result_cust)) { 
                               $customer_id= $row_cust['customer_id'];
                               $customer_name= $row_cust['customer_name'];
                               $customer_code= $row_cust['customer_code'];
                               $location_id= $row_cust['location_id'];
                               $location_code= $row_cust['location_code'];
                               $asset_location= $row_cust['asset_location'];
                               $building_id= $row_cust['building_id'];
                               $building_code= $row_cust['building_code'];
                               $asset_building= $row_cust['asset_building'];
                                
                            }
                           
                            $sql= 'insert into tbl_visits (amc_tkt_id,amc_tkt_ref_no,amc_ticket,customer_id,customer_code,customer_name,location_id,location_code,location_name,building_id,building_code,building_name,visit_mode,date_of_visits,time_of_visit,additional_slots,amc_visit_status,amc_schedule_color,visit_start_time) values ('.$amc_childarray[$i].',"'.$amc_ref_no.'","AMC",'.$customer_id.',"'.$customer_code.'","'.$customer_name.'",'.$location_id.',"'.$location_code.'","'.$asset_location.'",'.$building_id.',"'.$building_code.'","'.$asset_building.'","'.$vist_frequency.'","'.$date_of_visit.'",'.$start_slot.','.$add_slot.',"Scheduled","#39C0ED","'.$time_of_visit.'")';
                         
                            mysqli_query($varDBConnection,$sql);
                    
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
                      for ($i=0;$i<$asset_table_selected_count; $i++) {
                  
                     $result_cust =  mysqli_query($varDBConnection,"SELECT customer_id,customer_name,customer_code,location_id,location_code,asset_location,building_id,building_code,asset_building from view_amc_asset_details where amc_ref_no='".$amc_ref_no."' and asset_ref_no='".$amc_assetarray[$i]."' limit 1");
                            while($row_cust=mysqli_fetch_assoc($result_cust)) { 
                               $customer_id= $row_cust['customer_id'];
                               $customer_name= $row_cust['customer_name'];
                               $customer_code= $row_cust['customer_code'];
                               $location_id= $row_cust['location_id'];
                               $location_code= $row_cust['location_code'];
                               $asset_location= $row_cust['asset_location'];
                               $building_id= $row_cust['building_id'];
                               $building_code= $row_cust['building_code'];
                               $asset_building= $row_cust['asset_building'];
                                
                            }
                           
                            $sql= 'insert into tbl_visits (amc_tkt_id,amc_tkt_ref_no,amc_ticket,customer_id,customer_code,customer_name,location_id,location_code,location_name,building_id,building_code,building_name,visit_mode,date_of_visits,time_of_visit,additional_slots,amc_visit_status,amc_schedule_color,visit_start_time) values ('.$amc_childarray[$i].',"'.$amc_ref_no.'","AMC",'.$customer_id.',"'.$customer_code.'","'.$customer_name.'",'.$location_id.',"'.$location_code.'","'.$asset_location.'",'.$building_id.',"'.$building_code.'","'.$asset_building.'","'.$vist_frequency.'","'.$date_of_visit.'",'.$start_slot.','.$add_slot.',"Scheduled","#39C0ED","'.$time_of_visit.'")';
                         
                            mysqli_query($varDBConnection,$sql);
                    
                }
                  }
                 
               }
              
            break;
            case 'EW-Monday':
               while( $current <= $date2 ) {
                  $dates['data'][] = date($format, $current);
                  $current = strtotime($stepVal, $current);
                  $date_of_visit=date("Y",$current).'-'.date("m",$current).'-'.date("d",$current);
                  if(date("l",$current)=="Monday")
                  {
                      for ($i=0;$i<$asset_table_selected_count; $i++) {
                  
                     $result_cust =  mysqli_query($varDBConnection,"SELECT customer_id,customer_name,customer_code,location_id,location_code,asset_location,building_id,building_code,asset_building from view_amc_asset_details where amc_ref_no='".$amc_ref_no."' and asset_ref_no='".$amc_assetarray[$i]."' limit 1");
                            while($row_cust=mysqli_fetch_assoc($result_cust)) { 
                               $customer_id= $row_cust['customer_id'];
                               $customer_name= $row_cust['customer_name'];
                               $customer_code= $row_cust['customer_code'];
                               $location_id= $row_cust['location_id'];
                               $location_code= $row_cust['location_code'];
                               $asset_location= $row_cust['asset_location'];
                               $building_id= $row_cust['building_id'];
                               $building_code= $row_cust['building_code'];
                               $asset_building= $row_cust['asset_building'];
                                
                            }
                           
                            $sql= 'insert into tbl_visits (amc_tkt_id,amc_tkt_ref_no,amc_ticket,customer_id,customer_code,customer_name,location_id,location_code,location_name,building_id,building_code,building_name,visit_mode,date_of_visits,time_of_visit,additional_slots,amc_visit_status,amc_schedule_color,visit_start_time) values ('.$amc_childarray[$i].',"'.$amc_ref_no.'","AMC",'.$customer_id.',"'.$customer_code.'","'.$customer_name.'",'.$location_id.',"'.$location_code.'","'.$asset_location.'",'.$building_id.',"'.$building_code.'","'.$asset_building.'","'.$vist_frequency.'","'.$date_of_visit.'",'.$start_slot.','.$add_slot.',"Scheduled","#39C0ED","'.$time_of_visit.'")';
                         
                            mysqli_query($varDBConnection,$sql);
                    
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
                       for ($i=0;$i<$asset_table_selected_count; $i++) {
                  
                     $result_cust =  mysqli_query($varDBConnection,"SELECT customer_id,customer_name,customer_code,location_id,location_code,asset_location,building_id,building_code,asset_building from view_amc_asset_details where amc_ref_no='".$amc_ref_no."' and asset_ref_no='".$amc_assetarray[$i]."' limit 1");
                            while($row_cust=mysqli_fetch_assoc($result_cust)) { 
                               $customer_id= $row_cust['customer_id'];
                               $customer_name= $row_cust['customer_name'];
                               $customer_code= $row_cust['customer_code'];
                               $location_id= $row_cust['location_id'];
                               $location_code= $row_cust['location_code'];
                               $asset_location= $row_cust['asset_location'];
                               $building_id= $row_cust['building_id'];
                               $building_code= $row_cust['building_code'];
                               $asset_building= $row_cust['asset_building'];
                                
                            }
                           
                            $sql= 'insert into tbl_visits (amc_tkt_id,amc_tkt_ref_no,amc_ticket,customer_id,customer_code,customer_name,location_id,location_code,location_name,building_id,building_code,building_name,visit_mode,date_of_visits,time_of_visit,additional_slots,amc_visit_status,amc_schedule_color,visit_start_time) values ('.$amc_childarray[$i].',"'.$amc_ref_no.'","AMC",'.$customer_id.',"'.$customer_code.'","'.$customer_name.'",'.$location_id.',"'.$location_code.'","'.$asset_location.'",'.$building_id.',"'.$building_code.'","'.$asset_building.'","'.$vist_frequency.'","'.$date_of_visit.'",'.$start_slot.','.$add_slot.',"Scheduled","#39C0ED","'.$time_of_visit.'")';
                         
                            mysqli_query($varDBConnection,$sql);
                    
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
                      for ($i=0;$i<$asset_table_selected_count; $i++) {
                  
                     $result_cust =  mysqli_query($varDBConnection,"SELECT customer_id,customer_name,customer_code,location_id,location_code,asset_location,building_id,building_code,asset_building from view_amc_asset_details where amc_ref_no='".$amc_ref_no."' and asset_ref_no='".$amc_assetarray[$i]."' limit 1");
                            while($row_cust=mysqli_fetch_assoc($result_cust)) { 
                               $customer_id= $row_cust['customer_id'];
                               $customer_name= $row_cust['customer_name'];
                               $customer_code= $row_cust['customer_code'];
                               $location_id= $row_cust['location_id'];
                               $location_code= $row_cust['location_code'];
                               $asset_location= $row_cust['asset_location'];
                               $building_id= $row_cust['building_id'];
                               $building_code= $row_cust['building_code'];
                               $asset_building= $row_cust['asset_building'];
                                
                            }
                           
                            $sql= 'insert into tbl_visits (amc_tkt_id,amc_tkt_ref_no,amc_ticket,customer_id,customer_code,customer_name,location_id,location_code,location_name,building_id,building_code,building_name,visit_mode,date_of_visits,time_of_visit,additional_slots,amc_visit_status,amc_schedule_color,visit_start_time) values ('.$amc_childarray[$i].',"'.$amc_ref_no.'","AMC",'.$customer_id.',"'.$customer_code.'","'.$customer_name.'",'.$location_id.',"'.$location_code.'","'.$asset_location.'",'.$building_id.',"'.$building_code.'","'.$asset_building.'","'.$vist_frequency.'","'.$date_of_visit.'",'.$start_slot.','.$add_slot.',"Scheduled","#39C0ED","'.$time_of_visit.'")';
                         
                            mysqli_query($varDBConnection,$sql);
                    
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
                      for ($i=0;$i<$asset_table_selected_count; $i++) {
                  
                     $result_cust =  mysqli_query($varDBConnection,"SELECT customer_id,customer_name,customer_code,location_id,location_code,asset_location,building_id,building_code,asset_building from view_amc_asset_details where amc_ref_no='".$amc_ref_no."' and asset_ref_no='".$amc_assetarray[$i]."' limit 1");
                            while($row_cust=mysqli_fetch_assoc($result_cust)) { 
                               $customer_id= $row_cust['customer_id'];
                               $customer_name= $row_cust['customer_name'];
                               $customer_code= $row_cust['customer_code'];
                               $location_id= $row_cust['location_id'];
                               $location_code= $row_cust['location_code'];
                               $asset_location= $row_cust['asset_location'];
                               $building_id= $row_cust['building_id'];
                               $building_code= $row_cust['building_code'];
                               $asset_building= $row_cust['asset_building'];
                                
                            }
                           
                            $sql= 'insert into tbl_visits (amc_tkt_id,amc_tkt_ref_no,amc_ticket,customer_id,customer_code,customer_name,location_id,location_code,location_name,building_id,building_code,building_name,visit_mode,date_of_visits,time_of_visit,additional_slots,amc_visit_status,amc_schedule_color,visit_start_time) values ('.$amc_childarray[$i].',"'.$amc_ref_no.'","AMC",'.$customer_id.',"'.$customer_code.'","'.$customer_name.'",'.$location_id.',"'.$location_code.'","'.$asset_location.'",'.$building_id.',"'.$building_code.'","'.$asset_building.'","'.$vist_frequency.'","'.$date_of_visit.'",'.$start_slot.','.$add_slot.',"Scheduled","#39C0ED","'.$time_of_visit.'")';
                         
                            mysqli_query($varDBConnection,$sql);
                    
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
                      for ($i=0;$i<$asset_table_selected_count; $i++) {
                  
                     $result_cust =  mysqli_query($varDBConnection,"SELECT customer_id,customer_name,customer_code,location_id,location_code,asset_location,building_id,building_code,asset_building from view_amc_asset_details where amc_ref_no='".$amc_ref_no."' and asset_ref_no='".$amc_assetarray[$i]."' limit 1");
                            while($row_cust=mysqli_fetch_assoc($result_cust)) { 
                               $customer_id= $row_cust['customer_id'];
                               $customer_name= $row_cust['customer_name'];
                               $customer_code= $row_cust['customer_code'];
                               $location_id= $row_cust['location_id'];
                               $location_code= $row_cust['location_code'];
                               $asset_location= $row_cust['asset_location'];
                               $building_id= $row_cust['building_id'];
                               $building_code= $row_cust['building_code'];
                               $asset_building= $row_cust['asset_building'];
                                
                            }
                           
                            $sql= 'insert into tbl_visits (amc_tkt_id,amc_tkt_ref_no,amc_ticket,customer_id,customer_code,customer_name,location_id,location_code,location_name,building_id,building_code,building_name,visit_mode,date_of_visits,time_of_visit,additional_slots,amc_visit_status,amc_schedule_color,visit_start_time) values ('.$amc_childarray[$i].',"'.$amc_ref_no.'","AMC",'.$customer_id.',"'.$customer_code.'","'.$customer_name.'",'.$location_id.',"'.$location_code.'","'.$asset_location.'",'.$building_id.',"'.$building_code.'","'.$asset_building.'","'.$vist_frequency.'","'.$date_of_visit.'",'.$start_slot.','.$add_slot.',"Scheduled","#39C0ED","'.$time_of_visit.'")';
                         
                            mysqli_query($varDBConnection,$sql);
                    
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
                      for ($i=0;$i<$asset_table_selected_count; $i++) {
                  
                     $result_cust =  mysqli_query($varDBConnection,"SELECT customer_id,customer_name,customer_code,location_id,location_code,asset_location,building_id,building_code,asset_building from view_amc_asset_details where amc_ref_no='".$amc_ref_no."' and asset_ref_no='".$amc_assetarray[$i]."' limit 1");
                            while($row_cust=mysqli_fetch_assoc($result_cust)) { 
                               $customer_id= $row_cust['customer_id'];
                               $customer_name= $row_cust['customer_name'];
                               $customer_code= $row_cust['customer_code'];
                               $location_id= $row_cust['location_id'];
                               $location_code= $row_cust['location_code'];
                               $asset_location= $row_cust['asset_location'];
                               $building_id= $row_cust['building_id'];
                               $building_code= $row_cust['building_code'];
                               $asset_building= $row_cust['asset_building'];
                                
                            }
                           
                            $sql= 'insert into tbl_visits (amc_tkt_id,amc_tkt_ref_no,amc_ticket,customer_id,customer_code,customer_name,location_id,location_code,location_name,building_id,building_code,building_name,visit_mode,date_of_visits,time_of_visit,additional_slots,amc_visit_status,amc_schedule_color,visit_start_time) values ('.$amc_childarray[$i].',"'.$amc_ref_no.'","AMC",'.$customer_id.',"'.$customer_code.'","'.$customer_name.'",'.$location_id.',"'.$location_code.'","'.$asset_location.'",'.$building_id.',"'.$building_code.'","'.$asset_building.'","'.$vist_frequency.'","'.$date_of_visit.'",'.$start_slot.','.$add_slot.',"Scheduled","#39C0ED","'.$time_of_visit.'")';
                         
                            mysqli_query($varDBConnection,$sql);
                    
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
                         for ($i=0;$i<$asset_table_selected_count; $i++) {
                  
                     $result_cust =  mysqli_query($varDBConnection,"SELECT customer_id,customer_name,customer_code,location_id,location_code,asset_location,building_id,building_code,asset_building from view_amc_asset_details where amc_ref_no='".$amc_ref_no."' and asset_ref_no='".$amc_assetarray[$i]."' limit 1");
                            while($row_cust=mysqli_fetch_assoc($result_cust)) { 
                               $customer_id= $row_cust['customer_id'];
                               $customer_name= $row_cust['customer_name'];
                               $customer_code= $row_cust['customer_code'];
                               $location_id= $row_cust['location_id'];
                               $location_code= $row_cust['location_code'];
                               $asset_location= $row_cust['asset_location'];
                               $building_id= $row_cust['building_id'];
                               $building_code= $row_cust['building_code'];
                               $asset_building= $row_cust['asset_building'];
                                
                            }
                           
                            $sql= 'insert into tbl_visits (amc_tkt_id,amc_tkt_ref_no,amc_ticket,customer_id,customer_code,customer_name,location_id,location_code,location_name,building_id,building_code,building_name,visit_mode,date_of_visits,time_of_visit,additional_slots,amc_visit_status,amc_schedule_color,visit_start_time) values ('.$amc_childarray[$i].',"'.$amc_ref_no.'","AMC",'.$customer_id.',"'.$customer_code.'","'.$customer_name.'",'.$location_id.',"'.$location_code.'","'.$asset_location.'",'.$building_id.',"'.$building_code.'","'.$asset_building.'","'.$vist_frequency.'","'.$date_of_visit.'",'.$start_slot.','.$add_slot.',"Scheduled","#39C0ED","'.$time_of_visit.'")';
                         
                            mysqli_query($varDBConnection,$sql);
                    
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
                         for ($i=0;$i<$asset_table_selected_count; $i++) {
                  
                     $result_cust =  mysqli_query($varDBConnection,"SELECT customer_id,customer_name,customer_code,location_id,location_code,asset_location,building_id,building_code,asset_building from view_amc_asset_details where amc_ref_no='".$amc_ref_no."' and asset_ref_no='".$amc_assetarray[$i]."' limit 1");
                            while($row_cust=mysqli_fetch_assoc($result_cust)) { 
                               $customer_id= $row_cust['customer_id'];
                               $customer_name= $row_cust['customer_name'];
                               $customer_code= $row_cust['customer_code'];
                               $location_id= $row_cust['location_id'];
                               $location_code= $row_cust['location_code'];
                               $asset_location= $row_cust['asset_location'];
                               $building_id= $row_cust['building_id'];
                               $building_code= $row_cust['building_code'];
                               $asset_building= $row_cust['asset_building'];
                                
                            }
                           
                            $sql= 'insert into tbl_visits (amc_tkt_id,amc_tkt_ref_no,amc_ticket,customer_id,customer_code,customer_name,location_id,location_code,location_name,building_id,building_code,building_name,visit_mode,date_of_visits,time_of_visit,additional_slots,amc_visit_status,amc_schedule_color,visit_start_time) values ('.$amc_childarray[$i].',"'.$amc_ref_no.'","AMC",'.$customer_id.',"'.$customer_code.'","'.$customer_name.'",'.$location_id.',"'.$location_code.'","'.$asset_location.'",'.$building_id.',"'.$building_code.'","'.$asset_building.'","'.$vist_frequency.'","'.$date_of_visit.'",'.$start_slot.','.$add_slot.',"Scheduled","#39C0ED","'.$time_of_visit.'")';
                         
                            mysqli_query($varDBConnection,$sql);
                    
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
                         for ($i=0;$i<$asset_table_selected_count; $i++) {
                  
                     $result_cust =  mysqli_query($varDBConnection,"SELECT customer_id,customer_name,customer_code,location_id,location_code,asset_location,building_id,building_code,asset_building from view_amc_asset_details where amc_ref_no='".$amc_ref_no."' and asset_ref_no='".$amc_assetarray[$i]."' limit 1");
                            while($row_cust=mysqli_fetch_assoc($result_cust)) { 
                               $customer_id= $row_cust['customer_id'];
                               $customer_name= $row_cust['customer_name'];
                               $customer_code= $row_cust['customer_code'];
                               $location_id= $row_cust['location_id'];
                               $location_code= $row_cust['location_code'];
                               $asset_location= $row_cust['asset_location'];
                               $building_id= $row_cust['building_id'];
                               $building_code= $row_cust['building_code'];
                               $asset_building= $row_cust['asset_building'];
                                
                            }
                           
                            $sql= 'insert into tbl_visits (amc_tkt_id,amc_tkt_ref_no,amc_ticket,customer_id,customer_code,customer_name,location_id,location_code,location_name,building_id,building_code,building_name,visit_mode,date_of_visits,time_of_visit,additional_slots,amc_visit_status,amc_schedule_color,visit_start_time) values ('.$amc_childarray[$i].',"'.$amc_ref_no.'","AMC",'.$customer_id.',"'.$customer_code.'","'.$customer_name.'",'.$location_id.',"'.$location_code.'","'.$asset_location.'",'.$building_id.',"'.$building_code.'","'.$asset_building.'","'.$vist_frequency.'","'.$date_of_visit.'",'.$start_slot.','.$add_slot.',"Scheduled","#39C0ED","'.$time_of_visit.'")';
                         
                            mysqli_query($varDBConnection,$sql);
                    
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
                         for ($i=0;$i<$asset_table_selected_count; $i++) {
                  
                     $result_cust =  mysqli_query($varDBConnection,"SELECT customer_id,customer_name,customer_code,location_id,location_code,asset_location,building_id,building_code,asset_building from view_amc_asset_details where amc_ref_no='".$amc_ref_no."' and asset_ref_no='".$amc_assetarray[$i]."' limit 1");
                            while($row_cust=mysqli_fetch_assoc($result_cust)) { 
                               $customer_id= $row_cust['customer_id'];
                               $customer_name= $row_cust['customer_name'];
                               $customer_code= $row_cust['customer_code'];
                               $location_id= $row_cust['location_id'];
                               $location_code= $row_cust['location_code'];
                               $asset_location= $row_cust['asset_location'];
                               $building_id= $row_cust['building_id'];
                               $building_code= $row_cust['building_code'];
                               $asset_building= $row_cust['asset_building'];
                                
                            }
                           
                            $sql= 'insert into tbl_visits (amc_tkt_id,amc_tkt_ref_no,amc_ticket,customer_id,customer_code,customer_name,location_id,location_code,location_name,building_id,building_code,building_name,visit_mode,date_of_visits,time_of_visit,additional_slots,amc_visit_status,amc_schedule_color,visit_start_time) values ('.$amc_childarray[$i].',"'.$amc_ref_no.'","AMC",'.$customer_id.',"'.$customer_code.'","'.$customer_name.'",'.$location_id.',"'.$location_code.'","'.$asset_location.'",'.$building_id.',"'.$building_code.'","'.$asset_building.'","'.$vist_frequency.'","'.$date_of_visit.'",'.$start_slot.','.$add_slot.',"Scheduled","#39C0ED","'.$time_of_visit.'")';
                         
                            mysqli_query($varDBConnection,$sql);
                    
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
                         for ($i=0;$i<$asset_table_selected_count; $i++) {
                  
                     $result_cust =  mysqli_query($varDBConnection,"SELECT customer_id,customer_name,customer_code,location_id,location_code,asset_location,building_id,building_code,asset_building from view_amc_asset_details where amc_ref_no='".$amc_ref_no."' and asset_ref_no='".$amc_assetarray[$i]."' limit 1");
                            while($row_cust=mysqli_fetch_assoc($result_cust)) { 
                               $customer_id= $row_cust['customer_id'];
                               $customer_name= $row_cust['customer_name'];
                               $customer_code= $row_cust['customer_code'];
                               $location_id= $row_cust['location_id'];
                               $location_code= $row_cust['location_code'];
                               $asset_location= $row_cust['asset_location'];
                               $building_id= $row_cust['building_id'];
                               $building_code= $row_cust['building_code'];
                               $asset_building= $row_cust['asset_building'];
                                
                            }
                           
                            $sql= 'insert into tbl_visits (amc_tkt_id,amc_tkt_ref_no,amc_ticket,customer_id,customer_code,customer_name,location_id,location_code,location_name,building_id,building_code,building_name,visit_mode,date_of_visits,time_of_visit,additional_slots,amc_visit_status,amc_schedule_color,visit_start_time) values ('.$amc_childarray[$i].',"'.$amc_ref_no.'","AMC",'.$customer_id.',"'.$customer_code.'","'.$customer_name.'",'.$location_id.',"'.$location_code.'","'.$asset_location.'",'.$building_id.',"'.$building_code.'","'.$asset_building.'","'.$vist_frequency.'","'.$date_of_visit.'",'.$start_slot.','.$add_slot.',"Scheduled","#39C0ED","'.$time_of_visit.'")';
                         
                            mysqli_query($varDBConnection,$sql);
                    
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
                         for ($i=0;$i<$asset_table_selected_count; $i++) {
                  
                     $result_cust =  mysqli_query($varDBConnection,"SELECT customer_id,customer_name,customer_code,location_id,location_code,asset_location,building_id,building_code,asset_building from view_amc_asset_details where amc_ref_no='".$amc_ref_no."' and asset_ref_no='".$amc_assetarray[$i]."' limit 1");
                            while($row_cust=mysqli_fetch_assoc($result_cust)) { 
                               $customer_id= $row_cust['customer_id'];
                               $customer_name= $row_cust['customer_name'];
                               $customer_code= $row_cust['customer_code'];
                               $location_id= $row_cust['location_id'];
                               $location_code= $row_cust['location_code'];
                               $asset_location= $row_cust['asset_location'];
                               $building_id= $row_cust['building_id'];
                               $building_code= $row_cust['building_code'];
                               $asset_building= $row_cust['asset_building'];
                                
                            }
                           
                            $sql= 'insert into tbl_visits (amc_tkt_id,amc_tkt_ref_no,amc_ticket,customer_id,customer_code,customer_name,location_id,location_code,location_name,building_id,building_code,building_name,visit_mode,date_of_visits,time_of_visit,additional_slots,amc_visit_status,amc_schedule_color,visit_start_time) values ('.$amc_childarray[$i].',"'.$amc_ref_no.'","AMC",'.$customer_id.',"'.$customer_code.'","'.$customer_name.'",'.$location_id.',"'.$location_code.'","'.$asset_location.'",'.$building_id.',"'.$building_code.'","'.$asset_building.'","'.$vist_frequency.'","'.$date_of_visit.'",'.$start_slot.','.$add_slot.',"Scheduled","#39C0ED","'.$time_of_visit.'")';
                         
                            mysqli_query($varDBConnection,$sql);
                    
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
                         for ($i=0;$i<$asset_table_selected_count; $i++) {
                  
                     $result_cust =  mysqli_query($varDBConnection,"SELECT customer_id,customer_name,customer_code,location_id,location_code,asset_location,building_id,building_code,asset_building from view_amc_asset_details where amc_ref_no='".$amc_ref_no."' and asset_ref_no='".$amc_assetarray[$i]."' limit 1");
                            while($row_cust=mysqli_fetch_assoc($result_cust)) { 
                               $customer_id= $row_cust['customer_id'];
                               $customer_name= $row_cust['customer_name'];
                               $customer_code= $row_cust['customer_code'];
                               $location_id= $row_cust['location_id'];
                               $location_code= $row_cust['location_code'];
                               $asset_location= $row_cust['asset_location'];
                               $building_id= $row_cust['building_id'];
                               $building_code= $row_cust['building_code'];
                               $asset_building= $row_cust['asset_building'];
                                
                            }
                           
                            $sql= 'insert into tbl_visits (amc_tkt_id,amc_tkt_ref_no,amc_ticket,customer_id,customer_code,customer_name,location_id,location_code,location_name,building_id,building_code,building_name,visit_mode,date_of_visits,time_of_visit,additional_slots,amc_visit_status,amc_schedule_color,visit_start_time) values ('.$amc_childarray[$i].',"'.$amc_ref_no.'","AMC",'.$customer_id.',"'.$customer_code.'","'.$customer_name.'",'.$location_id.',"'.$location_code.'","'.$asset_location.'",'.$building_id.',"'.$building_code.'","'.$asset_building.'","'.$vist_frequency.'","'.$date_of_visit.'",'.$start_slot.','.$add_slot.',"Scheduled","#39C0ED","'.$time_of_visit.'")';
                         
                            mysqli_query($varDBConnection,$sql);
                    
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
                         for ($i=0;$i<$asset_table_selected_count; $i++) {
                  
                     $result_cust =  mysqli_query($varDBConnection,"SELECT customer_id,customer_name,customer_code,location_id,location_code,asset_location,building_id,building_code,asset_building from view_amc_asset_details where amc_ref_no='".$amc_ref_no."' and asset_ref_no='".$amc_assetarray[$i]."' limit 1");
                            while($row_cust=mysqli_fetch_assoc($result_cust)) { 
                               $customer_id= $row_cust['customer_id'];
                               $customer_name= $row_cust['customer_name'];
                               $customer_code= $row_cust['customer_code'];
                               $location_id= $row_cust['location_id'];
                               $location_code= $row_cust['location_code'];
                               $asset_location= $row_cust['asset_location'];
                               $building_id= $row_cust['building_id'];
                               $building_code= $row_cust['building_code'];
                               $asset_building= $row_cust['asset_building'];
                                
                            }
                           
                            $sql= 'insert into tbl_visits (amc_tkt_id,amc_tkt_ref_no,amc_ticket,customer_id,customer_code,customer_name,location_id,location_code,location_name,building_id,building_code,building_name,visit_mode,date_of_visits,time_of_visit,additional_slots,amc_visit_status,amc_schedule_color,visit_start_time) values ('.$amc_childarray[$i].',"'.$amc_ref_no.'","AMC",'.$customer_id.',"'.$customer_code.'","'.$customer_name.'",'.$location_id.',"'.$location_code.'","'.$asset_location.'",'.$building_id.',"'.$building_code.'","'.$asset_building.'","'.$vist_frequency.'","'.$date_of_visit.'",'.$start_slot.','.$add_slot.',"Scheduled","#39C0ED","'.$time_of_visit.'")';
                         
                            mysqli_query($varDBConnection,$sql);
                    
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
                         for ($i=0;$i<$asset_table_selected_count; $i++) {
                  
                     $result_cust =  mysqli_query($varDBConnection,"SELECT customer_id,customer_name,customer_code,location_id,location_code,asset_location,building_id,building_code,asset_building from view_amc_asset_details where amc_ref_no='".$amc_ref_no."' and asset_ref_no='".$amc_assetarray[$i]."' limit 1");
                            while($row_cust=mysqli_fetch_assoc($result_cust)) { 
                               $customer_id= $row_cust['customer_id'];
                               $customer_name= $row_cust['customer_name'];
                               $customer_code= $row_cust['customer_code'];
                               $location_id= $row_cust['location_id'];
                               $location_code= $row_cust['location_code'];
                               $asset_location= $row_cust['asset_location'];
                               $building_id= $row_cust['building_id'];
                               $building_code= $row_cust['building_code'];
                               $asset_building= $row_cust['asset_building'];
                                
                            }
                           
                            $sql= 'insert into tbl_visits (amc_tkt_id,amc_tkt_ref_no,amc_ticket,customer_id,customer_code,customer_name,location_id,location_code,location_name,building_id,building_code,building_name,visit_mode,date_of_visits,time_of_visit,additional_slots,amc_visit_status,amc_schedule_color,visit_start_time) values ('.$amc_childarray[$i].',"'.$amc_ref_no.'","AMC",'.$customer_id.',"'.$customer_code.'","'.$customer_name.'",'.$location_id.',"'.$location_code.'","'.$asset_location.'",'.$building_id.',"'.$building_code.'","'.$asset_building.'","'.$vist_frequency.'","'.$date_of_visit.'",'.$start_slot.','.$add_slot.',"Scheduled","#39C0ED","'.$time_of_visit.'")';
                         
                            mysqli_query($varDBConnection,$sql);
                    
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
                         for ($i=0;$i<$asset_table_selected_count; $i++) {
                  
                     $result_cust =  mysqli_query($varDBConnection,"SELECT customer_id,customer_name,customer_code,location_id,location_code,asset_location,building_id,building_code,asset_building from view_amc_asset_details where amc_ref_no='".$amc_ref_no."' and asset_ref_no='".$amc_assetarray[$i]."' limit 1");
                            while($row_cust=mysqli_fetch_assoc($result_cust)) { 
                               $customer_id= $row_cust['customer_id'];
                               $customer_name= $row_cust['customer_name'];
                               $customer_code= $row_cust['customer_code'];
                               $location_id= $row_cust['location_id'];
                               $location_code= $row_cust['location_code'];
                               $asset_location= $row_cust['asset_location'];
                               $building_id= $row_cust['building_id'];
                               $building_code= $row_cust['building_code'];
                               $asset_building= $row_cust['asset_building'];
                                
                            }
                           
                            $sql= 'insert into tbl_visits (amc_tkt_id,amc_tkt_ref_no,amc_ticket,customer_id,customer_code,customer_name,location_id,location_code,location_name,building_id,building_code,building_name,visit_mode,date_of_visits,time_of_visit,additional_slots,amc_visit_status,amc_schedule_color,visit_start_time) values ('.$amc_childarray[$i].',"'.$amc_ref_no.'","AMC",'.$customer_id.',"'.$customer_code.'","'.$customer_name.'",'.$location_id.',"'.$location_code.'","'.$asset_location.'",'.$building_id.',"'.$building_code.'","'.$asset_building.'","'.$vist_frequency.'","'.$date_of_visit.'",'.$start_slot.','.$add_slot.',"Scheduled","#39C0ED","'.$time_of_visit.'")';
                         
                            mysqli_query($varDBConnection,$sql);
                    
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
                         for ($i=0;$i<$asset_table_selected_count; $i++) {
                  
                     $result_cust =  mysqli_query($varDBConnection,"SELECT customer_id,customer_name,customer_code,location_id,location_code,asset_location,building_id,building_code,asset_building from view_amc_asset_details where amc_ref_no='".$amc_ref_no."' and asset_ref_no='".$amc_assetarray[$i]."' limit 1");
                            while($row_cust=mysqli_fetch_assoc($result_cust)) { 
                               $customer_id= $row_cust['customer_id'];
                               $customer_name= $row_cust['customer_name'];
                               $customer_code= $row_cust['customer_code'];
                               $location_id= $row_cust['location_id'];
                               $location_code= $row_cust['location_code'];
                               $asset_location= $row_cust['asset_location'];
                               $building_id= $row_cust['building_id'];
                               $building_code= $row_cust['building_code'];
                               $asset_building= $row_cust['asset_building'];
                                
                            }
                           
                            $sql= 'insert into tbl_visits (amc_tkt_id,amc_tkt_ref_no,amc_ticket,customer_id,customer_code,customer_name,location_id,location_code,location_name,building_id,building_code,building_name,visit_mode,date_of_visits,time_of_visit,additional_slots,amc_visit_status,amc_schedule_color,visit_start_time) values ('.$amc_childarray[$i].',"'.$amc_ref_no.'","AMC",'.$customer_id.',"'.$customer_code.'","'.$customer_name.'",'.$location_id.',"'.$location_code.'","'.$asset_location.'",'.$building_id.',"'.$building_code.'","'.$asset_building.'","'.$vist_frequency.'","'.$date_of_visit.'",'.$start_slot.','.$add_slot.',"Scheduled","#39C0ED","'.$time_of_visit.'")';
                         
                            mysqli_query($varDBConnection,$sql);
                    
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
                         for ($i=0;$i<$asset_table_selected_count; $i++) {
                  
                     $result_cust =  mysqli_query($varDBConnection,"SELECT customer_id,customer_name,customer_code,location_id,location_code,asset_location,building_id,building_code,asset_building from view_amc_asset_details where amc_ref_no='".$amc_ref_no."' and asset_ref_no='".$amc_assetarray[$i]."' limit 1");
                            while($row_cust=mysqli_fetch_assoc($result_cust)) { 
                               $customer_id= $row_cust['customer_id'];
                               $customer_name= $row_cust['customer_name'];
                               $customer_code= $row_cust['customer_code'];
                               $location_id= $row_cust['location_id'];
                               $location_code= $row_cust['location_code'];
                               $asset_location= $row_cust['asset_location'];
                               $building_id= $row_cust['building_id'];
                               $building_code= $row_cust['building_code'];
                               $asset_building= $row_cust['asset_building'];
                                
                            }
                           
                            $sql= 'insert into tbl_visits (amc_tkt_id,amc_tkt_ref_no,amc_ticket,customer_id,customer_code,customer_name,location_id,location_code,location_name,building_id,building_code,building_name,visit_mode,date_of_visits,time_of_visit,additional_slots,amc_visit_status,amc_schedule_color,visit_start_time) values ('.$amc_childarray[$i].',"'.$amc_ref_no.'","AMC",'.$customer_id.',"'.$customer_code.'","'.$customer_name.'",'.$location_id.',"'.$location_code.'","'.$asset_location.'",'.$building_id.',"'.$building_code.'","'.$asset_building.'","'.$vist_frequency.'","'.$date_of_visit.'",'.$start_slot.','.$add_slot.',"Scheduled","#39C0ED","'.$time_of_visit.'")';
                         
                            mysqli_query($varDBConnection,$sql);
                    
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
                         for ($i=0;$i<$asset_table_selected_count; $i++) {
                  
                     $result_cust =  mysqli_query($varDBConnection,"SELECT customer_id,customer_name,customer_code,location_id,location_code,asset_location,building_id,building_code,asset_building from view_amc_asset_details where amc_ref_no='".$amc_ref_no."' and asset_ref_no='".$amc_assetarray[$i]."' limit 1");
                            while($row_cust=mysqli_fetch_assoc($result_cust)) { 
                               $customer_id= $row_cust['customer_id'];
                               $customer_name= $row_cust['customer_name'];
                               $customer_code= $row_cust['customer_code'];
                               $location_id= $row_cust['location_id'];
                               $location_code= $row_cust['location_code'];
                               $asset_location= $row_cust['asset_location'];
                               $building_id= $row_cust['building_id'];
                               $building_code= $row_cust['building_code'];
                               $asset_building= $row_cust['asset_building'];
                                
                            }
                           
                            $sql= 'insert into tbl_visits (amc_tkt_id,amc_tkt_ref_no,amc_ticket,customer_id,customer_code,customer_name,location_id,location_code,location_name,building_id,building_code,building_name,visit_mode,date_of_visits,time_of_visit,additional_slots,amc_visit_status,amc_schedule_color,visit_start_time) values ('.$amc_childarray[$i].',"'.$amc_ref_no.'","AMC",'.$customer_id.',"'.$customer_code.'","'.$customer_name.'",'.$location_id.',"'.$location_code.'","'.$asset_location.'",'.$building_id.',"'.$building_code.'","'.$asset_building.'","'.$vist_frequency.'","'.$date_of_visit.'",'.$start_slot.','.$add_slot.',"Scheduled","#39C0ED","'.$time_of_visit.'")';
                         
                            mysqli_query($varDBConnection,$sql);
                    
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
                         for ($i=0;$i<$asset_table_selected_count; $i++) {
                  
                     $result_cust =  mysqli_query($varDBConnection,"SELECT customer_id,customer_name,customer_code,location_id,location_code,asset_location,building_id,building_code,asset_building from view_amc_asset_details where amc_ref_no='".$amc_ref_no."' and asset_ref_no='".$amc_assetarray[$i]."' limit 1");
                            while($row_cust=mysqli_fetch_assoc($result_cust)) { 
                               $customer_id= $row_cust['customer_id'];
                               $customer_name= $row_cust['customer_name'];
                               $customer_code= $row_cust['customer_code'];
                               $location_id= $row_cust['location_id'];
                               $location_code= $row_cust['location_code'];
                               $asset_location= $row_cust['asset_location'];
                               $building_id= $row_cust['building_id'];
                               $building_code= $row_cust['building_code'];
                               $asset_building= $row_cust['asset_building'];
                                
                            }
                           
                            $sql= 'insert into tbl_visits (amc_tkt_id,amc_tkt_ref_no,amc_ticket,customer_id,customer_code,customer_name,location_id,location_code,location_name,building_id,building_code,building_name,visit_mode,date_of_visits,time_of_visit,additional_slots,amc_visit_status,amc_schedule_color,visit_start_time) values ('.$amc_childarray[$i].',"'.$amc_ref_no.'","AMC",'.$customer_id.',"'.$customer_code.'","'.$customer_name.'",'.$location_id.',"'.$location_code.'","'.$asset_location.'",'.$building_id.',"'.$building_code.'","'.$asset_building.'","'.$vist_frequency.'","'.$date_of_visit.'",'.$start_slot.','.$add_slot.',"Scheduled","#39C0ED","'.$time_of_visit.'")';
                         
                            mysqli_query($varDBConnection,$sql);
                    
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
                        for ($i=0;$i<$asset_table_selected_count; $i++) {
                  
                     $result_cust =  mysqli_query($varDBConnection,"SELECT customer_id,customer_name,customer_code,location_id,location_code,asset_location,building_id,building_code,asset_building from view_amc_asset_details where amc_ref_no='".$amc_ref_no."' and asset_ref_no='".$amc_assetarray[$i]."' limit 1");
                            while($row_cust=mysqli_fetch_assoc($result_cust)) { 
                               $customer_id= $row_cust['customer_id'];
                               $customer_name= $row_cust['customer_name'];
                               $customer_code= $row_cust['customer_code'];
                               $location_id= $row_cust['location_id'];
                               $location_code= $row_cust['location_code'];
                               $asset_location= $row_cust['asset_location'];
                               $building_id= $row_cust['building_id'];
                               $building_code= $row_cust['building_code'];
                               $asset_building= $row_cust['asset_building'];
                                
                            }
                           
                            $sql= 'insert into tbl_visits (amc_tkt_id,amc_tkt_ref_no,amc_ticket,customer_id,customer_code,customer_name,location_id,location_code,location_name,building_id,building_code,building_name,visit_mode,date_of_visits,time_of_visit,additional_slots,amc_visit_status,amc_schedule_color,visit_start_time) values ('.$amc_childarray[$i].',"'.$amc_ref_no.'","AMC",'.$customer_id.',"'.$customer_code.'","'.$customer_name.'",'.$location_id.',"'.$location_code.'","'.$asset_location.'",'.$building_id.',"'.$building_code.'","'.$asset_building.'","'.$vist_frequency.'","'.$date_of_visit.'",'.$start_slot.','.$add_slot.',"Scheduled","#39C0ED","'.$time_of_visit.'")';
                         
                            mysqli_query($varDBConnection,$sql);
                    
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
                         for ($i=0;$i<$asset_table_selected_count; $i++) {
                  
                     $result_cust =  mysqli_query($varDBConnection,"SELECT customer_id,customer_name,customer_code,location_id,location_code,asset_location,building_id,building_code,asset_building from view_amc_asset_details where amc_ref_no='".$amc_ref_no."' and asset_ref_no='".$amc_assetarray[$i]."' limit 1");
                            while($row_cust=mysqli_fetch_assoc($result_cust)) { 
                               $customer_id= $row_cust['customer_id'];
                               $customer_name= $row_cust['customer_name'];
                               $customer_code= $row_cust['customer_code'];
                               $location_id= $row_cust['location_id'];
                               $location_code= $row_cust['location_code'];
                               $asset_location= $row_cust['asset_location'];
                               $building_id= $row_cust['building_id'];
                               $building_code= $row_cust['building_code'];
                               $asset_building= $row_cust['asset_building'];
                                
                            }
                           
                            $sql= 'insert into tbl_visits (amc_tkt_id,amc_tkt_ref_no,amc_ticket,customer_id,customer_code,customer_name,location_id,location_code,location_name,building_id,building_code,building_name,visit_mode,date_of_visits,time_of_visit,additional_slots,amc_visit_status,amc_schedule_color,visit_start_time) values ('.$amc_childarray[$i].',"'.$amc_ref_no.'","AMC",'.$customer_id.',"'.$customer_code.'","'.$customer_name.'",'.$location_id.',"'.$location_code.'","'.$asset_location.'",'.$building_id.',"'.$building_code.'","'.$asset_building.'","'.$vist_frequency.'","'.$date_of_visit.'",'.$start_slot.','.$add_slot.',"Scheduled","#39C0ED","'.$time_of_visit.'")';
                         
                            mysqli_query($varDBConnection,$sql);
                    
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
                         for ($i=0;$i<$asset_table_selected_count; $i++) {
                  
                     $result_cust =  mysqli_query($varDBConnection,"SELECT customer_id,customer_name,customer_code,location_id,location_code,asset_location,building_id,building_code,asset_building from view_amc_asset_details where amc_ref_no='".$amc_ref_no."' and asset_ref_no='".$amc_assetarray[$i]."' limit 1");
                            while($row_cust=mysqli_fetch_assoc($result_cust)) { 
                               $customer_id= $row_cust['customer_id'];
                               $customer_name= $row_cust['customer_name'];
                               $customer_code= $row_cust['customer_code'];
                               $location_id= $row_cust['location_id'];
                               $location_code= $row_cust['location_code'];
                               $asset_location= $row_cust['asset_location'];
                               $building_id= $row_cust['building_id'];
                               $building_code= $row_cust['building_code'];
                               $asset_building= $row_cust['asset_building'];
                                
                            }
                           
                            $sql= 'insert into tbl_visits (amc_tkt_id,amc_tkt_ref_no,amc_ticket,customer_id,customer_code,customer_name,location_id,location_code,location_name,building_id,building_code,building_name,visit_mode,date_of_visits,time_of_visit,additional_slots,amc_visit_status,amc_schedule_color,visit_start_time) values ('.$amc_childarray[$i].',"'.$amc_ref_no.'","AMC",'.$customer_id.',"'.$customer_code.'","'.$customer_name.'",'.$location_id.',"'.$location_code.'","'.$asset_location.'",'.$building_id.',"'.$building_code.'","'.$asset_building.'","'.$vist_frequency.'","'.$date_of_visit.'",'.$start_slot.','.$add_slot.',"Scheduled","#39C0ED","'.$time_of_visit.'")';
                         
                            mysqli_query($varDBConnection,$sql);
                    
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
                         for ($i=0;$i<$asset_table_selected_count; $i++) {
                  
                     $result_cust =  mysqli_query($varDBConnection,"SELECT customer_id,customer_name,customer_code,location_id,location_code,asset_location,building_id,building_code,asset_building from view_amc_asset_details where amc_ref_no='".$amc_ref_no."' and asset_ref_no='".$amc_assetarray[$i]."' limit 1");
                            while($row_cust=mysqli_fetch_assoc($result_cust)) { 
                               $customer_id= $row_cust['customer_id'];
                               $customer_name= $row_cust['customer_name'];
                               $customer_code= $row_cust['customer_code'];
                               $location_id= $row_cust['location_id'];
                               $location_code= $row_cust['location_code'];
                               $asset_location= $row_cust['asset_location'];
                               $building_id= $row_cust['building_id'];
                               $building_code= $row_cust['building_code'];
                               $asset_building= $row_cust['asset_building'];
                                
                            }
                           
                            $sql= 'insert into tbl_visits (amc_tkt_id,amc_tkt_ref_no,amc_ticket,customer_id,customer_code,customer_name,location_id,location_code,location_name,building_id,building_code,building_name,visit_mode,date_of_visits,time_of_visit,additional_slots,amc_visit_status,amc_schedule_color,visit_start_time) values ('.$amc_childarray[$i].',"'.$amc_ref_no.'","AMC",'.$customer_id.',"'.$customer_code.'","'.$customer_name.'",'.$location_id.',"'.$location_code.'","'.$asset_location.'",'.$building_id.',"'.$building_code.'","'.$asset_building.'","'.$vist_frequency.'","'.$date_of_visit.'",'.$start_slot.','.$add_slot.',"Scheduled","#39C0ED","'.$time_of_visit.'")';
                         
                            mysqli_query($varDBConnection,$sql);
                    
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
                         for ($i=0;$i<$asset_table_selected_count; $i++) {
                  
                     $result_cust =  mysqli_query($varDBConnection,"SELECT customer_id,customer_name,customer_code,location_id,location_code,asset_location,building_id,building_code,asset_building from view_amc_asset_details where amc_ref_no='".$amc_ref_no."' and asset_ref_no='".$amc_assetarray[$i]."' limit 1");
                            while($row_cust=mysqli_fetch_assoc($result_cust)) { 
                               $customer_id= $row_cust['customer_id'];
                               $customer_name= $row_cust['customer_name'];
                               $customer_code= $row_cust['customer_code'];
                               $location_id= $row_cust['location_id'];
                               $location_code= $row_cust['location_code'];
                               $asset_location= $row_cust['asset_location'];
                               $building_id= $row_cust['building_id'];
                               $building_code= $row_cust['building_code'];
                               $asset_building= $row_cust['asset_building'];
                                
                            }
                           
                            $sql= 'insert into tbl_visits (amc_tkt_id,amc_tkt_ref_no,amc_ticket,customer_id,customer_code,customer_name,location_id,location_code,location_name,building_id,building_code,building_name,visit_mode,date_of_visits,time_of_visit,additional_slots,amc_visit_status,amc_schedule_color,visit_start_time) values ('.$amc_childarray[$i].',"'.$amc_ref_no.'","AMC",'.$customer_id.',"'.$customer_code.'","'.$customer_name.'",'.$location_id.',"'.$location_code.'","'.$asset_location.'",'.$building_id.',"'.$building_code.'","'.$asset_building.'","'.$vist_frequency.'","'.$date_of_visit.'",'.$start_slot.','.$add_slot.',"Scheduled","#39C0ED","'.$time_of_visit.'")';
                         
                            mysqli_query($varDBConnection,$sql);
                    
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
                         for ($i=0;$i<$asset_table_selected_count; $i++) {
                  
                     $result_cust =  mysqli_query($varDBConnection,"SELECT customer_id,customer_name,customer_code,location_id,location_code,asset_location,building_id,building_code,asset_building from view_amc_asset_details where amc_ref_no='".$amc_ref_no."' and asset_ref_no='".$amc_assetarray[$i]."' limit 1");
                            while($row_cust=mysqli_fetch_assoc($result_cust)) { 
                               $customer_id= $row_cust['customer_id'];
                               $customer_name= $row_cust['customer_name'];
                               $customer_code= $row_cust['customer_code'];
                               $location_id= $row_cust['location_id'];
                               $location_code= $row_cust['location_code'];
                               $asset_location= $row_cust['asset_location'];
                               $building_id= $row_cust['building_id'];
                               $building_code= $row_cust['building_code'];
                               $asset_building= $row_cust['asset_building'];
                                
                            }
                           
                            $sql= 'insert into tbl_visits (amc_tkt_id,amc_tkt_ref_no,amc_ticket,customer_id,customer_code,customer_name,location_id,location_code,location_name,building_id,building_code,building_name,visit_mode,date_of_visits,time_of_visit,additional_slots,amc_visit_status,amc_schedule_color,visit_start_time) values ('.$amc_childarray[$i].',"'.$amc_ref_no.'","AMC",'.$customer_id.',"'.$customer_code.'","'.$customer_name.'",'.$location_id.',"'.$location_code.'","'.$asset_location.'",'.$building_id.',"'.$building_code.'","'.$asset_building.'","'.$vist_frequency.'","'.$date_of_visit.'",'.$start_slot.','.$add_slot.',"Scheduled","#39C0ED","'.$time_of_visit.'")';
                         
                            mysqli_query($varDBConnection,$sql);
                    
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
                        for ($i=0;$i<$asset_table_selected_count; $i++) {
                  
                     $result_cust =  mysqli_query($varDBConnection,"SELECT customer_id,customer_name,customer_code,location_id,location_code,asset_location,building_id,building_code,asset_building from view_amc_asset_details where amc_ref_no='".$amc_ref_no."' and asset_ref_no='".$amc_assetarray[$i]."' limit 1");
                            while($row_cust=mysqli_fetch_assoc($result_cust)) { 
                               $customer_id= $row_cust['customer_id'];
                               $customer_name= $row_cust['customer_name'];
                               $customer_code= $row_cust['customer_code'];
                               $location_id= $row_cust['location_id'];
                               $location_code= $row_cust['location_code'];
                               $asset_location= $row_cust['asset_location'];
                               $building_id= $row_cust['building_id'];
                               $building_code= $row_cust['building_code'];
                               $asset_building= $row_cust['asset_building'];
                                
                            }
                           
                            $sql= 'insert into tbl_visits (amc_tkt_id,amc_tkt_ref_no,amc_ticket,customer_id,customer_code,customer_name,location_id,location_code,location_name,building_id,building_code,building_name,visit_mode,date_of_visits,time_of_visit,additional_slots,amc_visit_status,amc_schedule_color,visit_start_time) values ('.$amc_childarray[$i].',"'.$amc_ref_no.'","AMC",'.$customer_id.',"'.$customer_code.'","'.$customer_name.'",'.$location_id.',"'.$location_code.'","'.$asset_location.'",'.$building_id.',"'.$building_code.'","'.$asset_building.'","'.$vist_frequency.'","'.$date_of_visit.'",'.$start_slot.','.$add_slot.',"Scheduled","#39C0ED","'.$time_of_visit.'")';
                         
                            mysqli_query($varDBConnection,$sql);
                    
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
                         for ($i=0;$i<$asset_table_selected_count; $i++) {
                  
                     $result_cust =  mysqli_query($varDBConnection,"SELECT customer_id,customer_name,customer_code,location_id,location_code,asset_location,building_id,building_code,asset_building from view_amc_asset_details where amc_ref_no='".$amc_ref_no."' and asset_ref_no='".$amc_assetarray[$i]."' limit 1");
                            while($row_cust=mysqli_fetch_assoc($result_cust)) { 
                               $customer_id= $row_cust['customer_id'];
                               $customer_name= $row_cust['customer_name'];
                               $customer_code= $row_cust['customer_code'];
                               $location_id= $row_cust['location_id'];
                               $location_code= $row_cust['location_code'];
                               $asset_location= $row_cust['asset_location'];
                               $building_id= $row_cust['building_id'];
                               $building_code= $row_cust['building_code'];
                               $asset_building= $row_cust['asset_building'];
                                
                            }
                           
                            $sql= 'insert into tbl_visits (amc_tkt_id,amc_tkt_ref_no,amc_ticket,customer_id,customer_code,customer_name,location_id,location_code,location_name,building_id,building_code,building_name,visit_mode,date_of_visits,time_of_visit,additional_slots,amc_visit_status,amc_schedule_color,visit_start_time) values ('.$amc_childarray[$i].',"'.$amc_ref_no.'","AMC",'.$customer_id.',"'.$customer_code.'","'.$customer_name.'",'.$location_id.',"'.$location_code.'","'.$asset_location.'",'.$building_id.',"'.$building_code.'","'.$asset_building.'","'.$vist_frequency.'","'.$date_of_visit.'",'.$start_slot.','.$add_slot.',"Scheduled","#39C0ED","'.$time_of_visit.'")';
                         
                            mysqli_query($varDBConnection,$sql);
                    
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
                        for ($i=0;$i<$asset_table_selected_count; $i++) {
                  
                     $result_cust =  mysqli_query($varDBConnection,"SELECT customer_id,customer_name,customer_code,location_id,location_code,asset_location,building_id,building_code,asset_building from view_amc_asset_details where amc_ref_no='".$amc_ref_no."' and asset_ref_no='".$amc_assetarray[$i]."' limit 1");
                            while($row_cust=mysqli_fetch_assoc($result_cust)) { 
                               $customer_id= $row_cust['customer_id'];
                               $customer_name= $row_cust['customer_name'];
                               $customer_code= $row_cust['customer_code'];
                               $location_id= $row_cust['location_id'];
                               $location_code= $row_cust['location_code'];
                               $asset_location= $row_cust['asset_location'];
                               $building_id= $row_cust['building_id'];
                               $building_code= $row_cust['building_code'];
                               $asset_building= $row_cust['asset_building'];
                                
                            }
                           
                            $sql= 'insert into tbl_visits (amc_tkt_id,amc_tkt_ref_no,amc_ticket,customer_id,customer_code,customer_name,location_id,location_code,location_name,building_id,building_code,building_name,visit_mode,date_of_visits,time_of_visit,additional_slots,amc_visit_status,amc_schedule_color,visit_start_time) values ('.$amc_childarray[$i].',"'.$amc_ref_no.'","AMC",'.$customer_id.',"'.$customer_code.'","'.$customer_name.'",'.$location_id.',"'.$location_code.'","'.$asset_location.'",'.$building_id.',"'.$building_code.'","'.$asset_building.'","'.$vist_frequency.'","'.$date_of_visit.'",'.$start_slot.','.$add_slot.',"Scheduled","#39C0ED","'.$time_of_visit.'")';
                         
                            mysqli_query($varDBConnection,$sql);
                    
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
                         for ($i=0;$i<$asset_table_selected_count; $i++) {
                  
                     $result_cust =  mysqli_query($varDBConnection,"SELECT customer_id,customer_name,customer_code,location_id,location_code,asset_location,building_id,building_code,asset_building from view_amc_asset_details where amc_ref_no='".$amc_ref_no."' and asset_ref_no='".$amc_assetarray[$i]."' limit 1");
                            while($row_cust=mysqli_fetch_assoc($result_cust)) { 
                               $customer_id= $row_cust['customer_id'];
                               $customer_name= $row_cust['customer_name'];
                               $customer_code= $row_cust['customer_code'];
                               $location_id= $row_cust['location_id'];
                               $location_code= $row_cust['location_code'];
                               $asset_location= $row_cust['asset_location'];
                               $building_id= $row_cust['building_id'];
                               $building_code= $row_cust['building_code'];
                               $asset_building= $row_cust['asset_building'];
                                
                            }
                           
                            $sql= 'insert into tbl_visits (amc_tkt_id,amc_tkt_ref_no,amc_ticket,customer_id,customer_code,customer_name,location_id,location_code,location_name,building_id,building_code,building_name,visit_mode,date_of_visits,time_of_visit,additional_slots,amc_visit_status,amc_schedule_color,visit_start_time) values ('.$amc_childarray[$i].',"'.$amc_ref_no.'","AMC",'.$customer_id.',"'.$customer_code.'","'.$customer_name.'",'.$location_id.',"'.$location_code.'","'.$asset_location.'",'.$building_id.',"'.$building_code.'","'.$asset_building.'","'.$vist_frequency.'","'.$date_of_visit.'",'.$start_slot.','.$add_slot.',"Scheduled","#39C0ED","'.$time_of_visit.'")';
                         
                            mysqli_query($varDBConnection,$sql);
                    
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
                        for ($i=0;$i<$asset_table_selected_count; $i++) {
                  
                     $result_cust =  mysqli_query($varDBConnection,"SELECT customer_id,customer_name,customer_code,location_id,location_code,asset_location,building_id,building_code,asset_building from view_amc_asset_details where amc_ref_no='".$amc_ref_no."' and asset_ref_no='".$amc_assetarray[$i]."' limit 1");
                            while($row_cust=mysqli_fetch_assoc($result_cust)) { 
                               $customer_id= $row_cust['customer_id'];
                               $customer_name= $row_cust['customer_name'];
                               $customer_code= $row_cust['customer_code'];
                               $location_id= $row_cust['location_id'];
                               $location_code= $row_cust['location_code'];
                               $asset_location= $row_cust['asset_location'];
                               $building_id= $row_cust['building_id'];
                               $building_code= $row_cust['building_code'];
                               $asset_building= $row_cust['asset_building'];
                                
                            }
                           
                            $sql= 'insert into tbl_visits (amc_tkt_id,amc_tkt_ref_no,amc_ticket,customer_id,customer_code,customer_name,location_id,location_code,location_name,building_id,building_code,building_name,visit_mode,date_of_visits,time_of_visit,additional_slots,amc_visit_status,amc_schedule_color,visit_start_time) values ('.$amc_childarray[$i].',"'.$amc_ref_no.'","AMC",'.$customer_id.',"'.$customer_code.'","'.$customer_name.'",'.$location_id.',"'.$location_code.'","'.$asset_location.'",'.$building_id.',"'.$building_code.'","'.$asset_building.'","'.$vist_frequency.'","'.$date_of_visit.'",'.$start_slot.','.$add_slot.',"Scheduled","#39C0ED","'.$time_of_visit.'")';
                         
                            mysqli_query($varDBConnection,$sql);
                    
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
                         for ($i=0;$i<$asset_table_selected_count; $i++) {
                  
                     $result_cust =  mysqli_query($varDBConnection,"SELECT customer_id,customer_name,customer_code,location_id,location_code,asset_location,building_id,building_code,asset_building from view_amc_asset_details where amc_ref_no='".$amc_ref_no."' and asset_ref_no='".$amc_assetarray[$i]."' limit 1");
                            while($row_cust=mysqli_fetch_assoc($result_cust)) { 
                               $customer_id= $row_cust['customer_id'];
                               $customer_name= $row_cust['customer_name'];
                               $customer_code= $row_cust['customer_code'];
                               $location_id= $row_cust['location_id'];
                               $location_code= $row_cust['location_code'];
                               $asset_location= $row_cust['asset_location'];
                               $building_id= $row_cust['building_id'];
                               $building_code= $row_cust['building_code'];
                               $asset_building= $row_cust['asset_building'];
                                
                            }
                           
                            $sql= 'insert into tbl_visits (amc_tkt_id,amc_tkt_ref_no,amc_ticket,customer_id,customer_code,customer_name,location_id,location_code,location_name,building_id,building_code,building_name,visit_mode,date_of_visits,time_of_visit,additional_slots,amc_visit_status,amc_schedule_color,visit_start_time) values ('.$amc_childarray[$i].',"'.$amc_ref_no.'","AMC",'.$customer_id.',"'.$customer_code.'","'.$customer_name.'",'.$location_id.',"'.$location_code.'","'.$asset_location.'",'.$building_id.',"'.$building_code.'","'.$asset_building.'","'.$vist_frequency.'","'.$date_of_visit.'",'.$start_slot.','.$add_slot.',"Scheduled","#39C0ED","'.$time_of_visit.'")';
                         
                            mysqli_query($varDBConnection,$sql);
                    
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
                         for ($i=0;$i<$asset_table_selected_count; $i++) {
                  
                     $result_cust =  mysqli_query($varDBConnection,"SELECT customer_id,customer_name,customer_code,location_id,location_code,asset_location,building_id,building_code,asset_building from view_amc_asset_details where amc_ref_no='".$amc_ref_no."' and asset_ref_no='".$amc_assetarray[$i]."' limit 1");
                            while($row_cust=mysqli_fetch_assoc($result_cust)) { 
                               $customer_id= $row_cust['customer_id'];
                               $customer_name= $row_cust['customer_name'];
                               $customer_code= $row_cust['customer_code'];
                               $location_id= $row_cust['location_id'];
                               $location_code= $row_cust['location_code'];
                               $asset_location= $row_cust['asset_location'];
                               $building_id= $row_cust['building_id'];
                               $building_code= $row_cust['building_code'];
                               $asset_building= $row_cust['asset_building'];
                                
                            }
                           
                            $sql= 'insert into tbl_visits (amc_tkt_id,amc_tkt_ref_no,amc_ticket,customer_id,customer_code,customer_name,location_id,location_code,location_name,building_id,building_code,building_name,visit_mode,date_of_visits,time_of_visit,additional_slots,amc_visit_status,amc_schedule_color,visit_start_time) values ('.$amc_childarray[$i].',"'.$amc_ref_no.'","AMC",'.$customer_id.',"'.$customer_code.'","'.$customer_name.'",'.$location_id.',"'.$location_code.'","'.$asset_location.'",'.$building_id.',"'.$building_code.'","'.$asset_building.'","'.$vist_frequency.'","'.$date_of_visit.'",'.$start_slot.','.$add_slot.',"Scheduled","#39C0ED","'.$time_of_visit.'")';
                         
                            mysqli_query($varDBConnection,$sql);
                    
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
                        for ($i=0;$i<$asset_table_selected_count; $i++) {
                  
                     $result_cust =  mysqli_query($varDBConnection,"SELECT customer_id,customer_name,customer_code,location_id,location_code,asset_location,building_id,building_code,asset_building from view_amc_asset_details where amc_ref_no='".$amc_ref_no."' and asset_ref_no='".$amc_assetarray[$i]."' limit 1");
                            while($row_cust=mysqli_fetch_assoc($result_cust)) { 
                               $customer_id= $row_cust['customer_id'];
                               $customer_name= $row_cust['customer_name'];
                               $customer_code= $row_cust['customer_code'];
                               $location_id= $row_cust['location_id'];
                               $location_code= $row_cust['location_code'];
                               $asset_location= $row_cust['asset_location'];
                               $building_id= $row_cust['building_id'];
                               $building_code= $row_cust['building_code'];
                               $asset_building= $row_cust['asset_building'];
                                
                            }
                           
                            $sql= 'insert into tbl_visits (amc_tkt_id,amc_tkt_ref_no,amc_ticket,customer_id,customer_code,customer_name,location_id,location_code,location_name,building_id,building_code,building_name,visit_mode,date_of_visits,time_of_visit,additional_slots,amc_visit_status,amc_schedule_color,visit_start_time) values ('.$amc_childarray[$i].',"'.$amc_ref_no.'","AMC",'.$customer_id.',"'.$customer_code.'","'.$customer_name.'",'.$location_id.',"'.$location_code.'","'.$asset_location.'",'.$building_id.',"'.$building_code.'","'.$asset_building.'","'.$vist_frequency.'","'.$date_of_visit.'",'.$start_slot.','.$add_slot.',"Scheduled","#39C0ED","'.$time_of_visit.'")';
                         
                            mysqli_query($varDBConnection,$sql);
                    
                }
                     }
                     
                  }
                  
               }
               
            break;

            default:
            break;
            } 
         
         $sql=rtrim($sql, ",");
      
        return $sql;
        
         //return json_encode($dates);
      
   }


   //$visitmode=array('FRW-Saturday','YSD');
   $visitmode=$_POST['frequency_array'];
   for($i=0;$i<count($visitmode);$i++)
   {
   
  
   $retunsql = displayDates($_POST['start_date'],$_POST['end_date'],$visitmode[$i],$_POST['amc_id'],$_POST['amc_ref_no'],$_POST['schedule_time'],$_POST['amc_childarray'],$_POST['asset_table_selected_count'],$_POST['amc_assetarray'],$_POST['start_slot'],$_POST['add_slot']);
 
  
    //   if (mysqli_query($varDBConnection,$retunsql))
    //      {
         echo "Success";
    //      }
    //      else
    //      {
    //      echo "Error: " . $retunsql . "<br>" . mysqli_error($varDBConnection);
    //      }
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