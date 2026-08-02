<?php
   function displayDates($date1, $date2, $format = 'd-m-Y' ) {
      $dates = array();
      $current = strtotime($date1);
      $date2 = strtotime($date2);
      $stepVal = '+1 day';
      while( $current <= $date2 ) {
         $dates['data'][] = date($format, $current);
         $current = strtotime($stepVal, $current);
         echo time_for_week_day('monday').'<br>';
      }
      return json_encode($dates);
   }
   $date = displayDates('2019-11-10', '2019-11-20');
   echo $date;
   
   
   function time_for_week_day($day_name, $ref_time=null){
    $monday = strtotime(date('o-\WW',$ref_time));
    if(substr(strtoupper($day_name),0,3) === "MON")
        return $monday;
    else
        return strtotime("next $day_name",$monday);
}
?>