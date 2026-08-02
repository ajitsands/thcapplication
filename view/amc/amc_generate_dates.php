<?php
include "../../model/db_connection/connection.php" ;
   $DBConn = new DBConnection();
   $varDBConnection;
 $varDBConnection = $DBConn->ConnectToMYSQL();
   date_default_timezone_set('Asia/Bahrain');

   function displayDates($date1, $date2,$vist_frequency,$amc_id,$amc_ref_no,$time_of_visit,$format = 'd-m-Y' ) {
      $dates = array();
       $current1 = strtotime($date1);
      $current = strtotime($date1)-1;
      $date2 = strtotime($date2);
      $stepVal = '+1 day';
      
      $sql="insert into tbl_amc_visits (amc_id,amc_ref_no,visit_mode,date_of_visits,time_of_visit) values ";
     
         switch($vist_frequency)
         {
            
            case 'YSD':
               $date_of_visit=date("Y",$current1).'-'.date("m",$current1).'-'.date("d",$current1);
               $sql= $sql.'('.$amc_id.',"'.$amc_ref_no.'","'.$vist_frequency.'","'.$date_of_visit.'","'.$time_of_visit.'"),';
            break;
            case 'ED-All':
               while( $current <= $date2 ) {
                  $dates['data'][] = date($format, $current);
                  $current = strtotime($stepVal, $current);
                  $date_of_visit=date("Y",$current).'-'.date("m",$current).'-'.date("d",$current);
                  
                     $sql= $sql.'('.$amc_id.',"'.$amc_ref_no.'","'.$vist_frequency.'","'.$date_of_visit.'","'.$time_of_visit.'"),';
               
               }
            break;
            case 'EW-Sunday':
               while( $current <= $date2 ) {
                  $dates['data'][] = date($format, $current);
                  $current = strtotime($stepVal, $current);
                  $date_of_visit=date("Y",$current).'-'.date("m",$current).'-'.date("d",$current);
                  if(date("l",$current)=="Sunday")
                  {
                     $sql= $sql.'('.$amc_id.',"'.$amc_ref_no.'","'.$vist_frequency.'","'.$date_of_visit.'","'.$time_of_visit.'"),';
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
                     $sql= $sql.'('.$amc_id.',"'.$amc_ref_no.'","'.$vist_frequency.'","'.$date_of_visit.'","'.$time_of_visit.'"),';
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
                     $sql= $sql.'('.$amc_id.',"'.$amc_ref_no.'","'.$vist_frequency.'","'.$date_of_visit.'","'.$time_of_visit.'"),';
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
                     $sql= $sql.'('.$amc_id.',"'.$amc_ref_no.'","'.$vist_frequency.'","'.$date_of_visit.'","'.$time_of_visit.'"),';
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
                     $sql= $sql.'('.$amc_id.',"'.$amc_ref_no.'","'.$vist_frequency.'","'.$date_of_visit.'","'.$time_of_visit.'"),';
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
                     $sql= $sql.'('.$amc_id.',"'.$amc_ref_no.'","'.$vist_frequency.'","'.$date_of_visit.'","'.$time_of_visit.'"),';
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
                     $sql= $sql.'('.$amc_id.',"'.$amc_ref_no.'","'.$vist_frequency.'","'.$date_of_visit.'","'.$time_of_visit.'"),';
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
                        $sql= $sql.'('.$amc_id.',"'.$amc_ref_no.'","'.$vist_frequency.'","'.$date_of_visit.'","'.$time_of_visit.'"),';
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
                        $sql= $sql.'('.$amc_id.',"'.$amc_ref_no.'","'.$vist_frequency.'","'.$date_of_visit.'","'.$time_of_visit.'"),';
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
                        $sql= $sql.'('.$amc_id.',"'.$amc_ref_no.'","'.$vist_frequency.'","'.$date_of_visit.'","'.$time_of_visit.'"),';
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
                        $sql= $sql.'('.$amc_id.',"'.$amc_ref_no.'","'.$vist_frequency.'","'.$date_of_visit.'","'.$time_of_visit.'"),';
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
                        $sql= $sql.'('.$amc_id.',"'.$amc_ref_no.'","'.$vist_frequency.'","'.$date_of_visit.'","'.$time_of_visit.'"),';
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
                        $sql= $sql.'('.$amc_id.',"'.$amc_ref_no.'","'.$vist_frequency.'","'.$date_of_visit.'","'.$time_of_visit.'"),';
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
                        $sql= $sql.'('.$amc_id.',"'.$amc_ref_no.'","'.$vist_frequency.'","'.$date_of_visit.'","'.$time_of_visit.'"),';
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
                        $sql= $sql.'('.$amc_id.',"'.$amc_ref_no.'","'.$vist_frequency.'","'.$date_of_visit.'","'.$time_of_visit.'"),';
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
                        $sql= $sql.'('.$amc_id.',"'.$amc_ref_no.'","'.$vist_frequency.'","'.$date_of_visit.'","'.$time_of_visit.'"),';
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
                        $sql= $sql.'('.$amc_id.',"'.$amc_ref_no.'","'.$vist_frequency.'","'.$date_of_visit.'","'.$time_of_visit.'"),';
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
                        $sql= $sql.'('.$amc_id.',"'.$amc_ref_no.'","'.$vist_frequency.'","'.$date_of_visit.'","'.$time_of_visit.'"),';
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
                        $sql= $sql.'('.$amc_id.',"'.$amc_ref_no.'","'.$vist_frequency.'","'.$date_of_visit.'","'.$time_of_visit.'"),';
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
                        $sql= $sql.'('.$amc_id.',"'.$amc_ref_no.'","'.$vist_frequency.'","'.$date_of_visit.'","'.$time_of_visit.'"),';
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
                        $sql= $sql.'('.$amc_id.',"'.$amc_ref_no.'","'.$vist_frequency.'","'.$date_of_visit.'","'.$time_of_visit.'"),';
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
                        $sql= $sql.'('.$amc_id.',"'.$amc_ref_no.'","'.$vist_frequency.'","'.$date_of_visit.'","'.$time_of_visit.'"),';
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
                        $sql= $sql.'('.$amc_id.',"'.$amc_ref_no.'","'.$vist_frequency.'","'.$date_of_visit.'","'.$time_of_visit.'"),';
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
                        $sql= $sql.'('.$amc_id.',"'.$amc_ref_no.'","'.$vist_frequency.'","'.$date_of_visit.'","'.$time_of_visit.'"),';
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
                        $sql= $sql.'('.$amc_id.',"'.$amc_ref_no.'","'.$vist_frequency.'","'.$date_of_visit.'","'.$time_of_visit.'"),';
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
                        $sql= $sql.'('.$amc_id.',"'.$amc_ref_no.'","'.$vist_frequency.'","'.$date_of_visit.'","'.$time_of_visit.'"),';
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
                        $sql= $sql.'('.$amc_id.',"'.$amc_ref_no.'","'.$vist_frequency.'","'.$date_of_visit.'","'.$time_of_visit.'"),';
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
                        $sql= $sql.'('.$amc_id.',"'.$amc_ref_no.'","'.$vist_frequency.'","'.$date_of_visit.'","'.$time_of_visit.'"),';
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
                        $sql= $sql.'('.$amc_id.',"'.$amc_ref_no.'","'.$vist_frequency.'","'.$date_of_visit.'","'.$time_of_visit.'"),';
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
                        $sql= $sql.'('.$amc_id.',"'.$amc_ref_no.'","'.$vist_frequency.'","'.$date_of_visit.'","'.$time_of_visit.'"),';
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
                        $sql= $sql.'('.$amc_id.',"'.$amc_ref_no.'","'.$vist_frequency.'","'.$date_of_visit.'","'.$time_of_visit.'"),';
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
                        $sql= $sql.'('.$amc_id.',"'.$amc_ref_no.'","'.$vist_frequency.'","'.$date_of_visit.'","'.$time_of_visit.'"),';
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
                        $sql= $sql.'('.$amc_id.',"'.$amc_ref_no.'","'.$vist_frequency.'","'.$date_of_visit.'","'.$time_of_visit.'"),';
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
                        $sql= $sql.'('.$amc_id.',"'.$amc_ref_no.'","'.$vist_frequency.'","'.$date_of_visit.'","'.$time_of_visit.'"),';
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
                        $sql= $sql.'('.$amc_id.',"'.$amc_ref_no.'","'.$vist_frequency.'","'.$date_of_visit.'","'.$time_of_visit.'"),';
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
   
  
   $retunsql = displayDates($_POST['start_date'],$_POST['end_date'],$visitmode[$i],$_POST['amc_id'],$_POST['amc_ref_no'],$_POST['schedule_time']);
 
  
       if (mysqli_query($varDBConnection,$retunsql))
         {
         echo "Success";
         }
         else
         {
         echo "Error: " . $retunsql . "<br>" . mysqli_error($varDBConnection);
         }
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