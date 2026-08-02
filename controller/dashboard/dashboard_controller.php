<?php

require ('../../model/common/common_functions.php');



class customerController
{
       var $varModelObj,$varDBConnection,$start_date,$end_date;
	   public $actionevents;
         
    function __construct()
	{
	  
        $this->varModelObj = new CommonModel();
        $this->varDBConnection = $this->varModelObj->varDBConnection;
        $this->actionevents = $_POST['action'];
        $this->criteria = $_POST['criteria'];
        $this->wo_type = $_POST['wo_type'];
        $this->wo_condition = $_POST['wo_condition'];
		
        
        date_default_timezone_set('Asia/Bahrain');
        $this->current_date = date("Y-m-d h:i:s");
        
        $this->monday = strtotime('next Monday -1 week');
        $this->monday = date('w', $this->monday)==date('w') ? strtotime(date("Y-m-d",$this->monday)." +7 days") :$this->monday;
        $this->sunday = strtotime(date("Y-m-d",$this->monday)." +6 days");
        $this->this_week_ed=date("Y-m-d");
        $this->this_week_sd=date("Y-m-d", strtotime('-7 days'));
       // $this->this_week_sd = date("Y-m-d",$this->monday);
       // $this->this_week_ed = date("Y-m-d",$this->sunday);
        
        $this->first_day_this_month = date('Y-m-01'); 
        $this->last_day_this_month  = date('Y-m-y');
        
        $this->first_day_this_year = date('Y-01-01'); 
        $this->last_day_this_year  = date('Y-12-31');
        
        $this->month_val = $_POST['month_val'];
        $this->year_val = $_POST['year_val'];
        $this->compare_val=$this->year_val.'-'.$this->month_val;
        $this->categoryId = $_POST['category'];  
        
        // if($this->category=="all")
        // {
        //     $remainingQuery="";
        // }
        // else
        // {
        //      $remainingQuery=" and ";
        // }
        
    }
    
    
    
    function SQLArray()
    { 
        $array =  array();

       
		$array[1] = "select count(ticket_id) as today_wo_opened from tbl_tickets where    ticket_status!='Cancelled' and DATE_FORMAT(created_date_time,'%Y-%m-%d')=DATE_FORMAT(now(),'%Y-%m-%d')";
		
        $array[2] = "select count(ticket_id) as today_wo_closed from tbl_tickets where    ticket_status='Closed' and DATE_FORMAT(closed_on,'%Y-%m-%d') = DATE_FORMAT(now(),'%Y-%m-%d')";
        
		$array[3] = "select count(amc_visit_id) as today_wo_pending from tbl_visits where    amc_ticket='TKT' and  amc_visit_status not in ('Closed','Opened','Cancelled','Completed') and `date_of_visits` = DATE_FORMAT(now(),'%Y-%m-%d')";
        
		$array[4] = "select count(ticket_id) as week_wo_opened from tbl_tickets where    ticket_status!='Cancelled' and DATE_FORMAT(created_date_time,'%Y-%m-%d') >= '".$this->this_week_sd."' and  DATE_FORMAT(created_date_time,'%Y-%m-%d') <=  '".$this->this_week_ed."'";
		
        $array[5] = "select count(ticket_id) as week_wo_closed from tbl_tickets where    ticket_status='Closed' and DATE_FORMAT(closed_on,'%Y-%m-%d') >= '".$this->this_week_sd."' and  DATE_FORMAT(closed_on,'%Y-%m-%d') <= '".$this->this_week_ed."'";
        
		$array[6] = "select count(amc_visit_id) as week_wo_pending from tbl_visits where   amc_ticket='TKT' and amc_visit_status not in ('Closed','Opened','Cancelled','Completed') and `date_of_visits` >= '".$this->this_week_sd."' and  `date_of_visits` <= '".$this->this_week_ed."'";
		
		$array[7] = "select count(ticket_id) as month_wo_opened from tbl_tickets where    ticket_status!='Cancelled' and DATE_FORMAT(created_date_time,'%Y-%m-%d') >= '".$this->first_day_this_month."' and  DATE_FORMAT(created_date_time,'%Y-%m-%d') <= '".$this->last_day_this_month."'";
		
        $array[8] = "select count(ticket_id) as month_wo_closed from tbl_tickets where    ticket_status='Closed' and DATE_FORMAT(closed_on,'%Y-%m-%d') >= '".$this->first_day_this_month."' and DATE_FORMAT(closed_on,'%Y-%m-%d') <= '".$this->last_day_this_month."'";
        
		$array[9] = "select count(amc_visit_id) as month_wo_pending from tbl_visits where   amc_ticket='TKT' and amc_visit_status not in ('Closed','Opened','Cancelled','Completed') and `date_of_visits` >= '".$this->first_day_this_month."' and `date_of_visits` <= '".$this->last_day_this_month."'";
		
		$array[10] = "select count(ticket_id) as year_wo_opened from tbl_tickets where    ticket_status!='Cancelled' and DATE_FORMAT(created_date_time,'%Y-%m-%d') >= '".$this->first_day_this_year."' and  DATE_FORMAT(created_date_time,'%Y-%m-%d') <= '".$this->last_day_this_year."'";
		
        $array[11] = "select count(ticket_id) as year_wo_closed from tbl_tickets where    ticket_status='Closed' and DATE_FORMAT(closed_on,'%Y-%m-%d') >= '".$this->first_day_this_year."' and DATE_FORMAT(closed_on,'%Y-%m-%d') <= '".$this->last_day_this_year."'";
        
		$array[12] = "select count(amc_visit_id) as year_wo_pending from tbl_visits where  amc_ticket='TKT' and  amc_visit_status not in ('Closed','Opened','Cancelled','Completed') and `date_of_visits` >= '".$this->first_day_this_year."' and `date_of_visits` <= '".$this->last_day_this_year."'";
		
		
		
		
		$array[13] = "select count(ticket_id) as wo_normal from tbl_tickets where ticket_status!='Cancelled' and ticket_priority not in ('Emergency','Urgent') and DATE_FORMAT(created_date_time,'%Y-%m') = '".$this->compare_val."'";
		$array[14] = "select count(ticket_id) as wo_urgent from tbl_tickets where ticket_status!='Cancelled' and ticket_priority='Urgent' and DATE_FORMAT(created_date_time,'%Y-%m') = '".$this->compare_val."'";
		$array[15] = "select count(ticket_id) as wo_emergency from tbl_tickets where ticket_status!='Cancelled' and ticket_priority='Emergency' and DATE_FORMAT(created_date_time,'%Y-%m') = '".$this->compare_val."'";
       
       
       
       
       
       
        $array[17] = "select *,DATE_FORMAT(created_date_time, '%d-%m-%Y') as date_of_visits1 from  tbl_tickets where    ticket_status='Closed' and DATE_FORMAT(closed_on,'%Y-%m-%d') = DATE_FORMAT(now(),'%Y-%m-%d')";
        $array[16] = "select *,DATE_FORMAT(created_date_time, '%d-%m-%Y') as date_of_visits1 from tbl_tickets where    ticket_status!='Cancelled' and DATE_FORMAT(created_date_time,'%Y-%m-%d')=DATE_FORMAT(now(),'%Y-%m-%d')";
        
        
        $array[18] = "select *,DATE_FORMAT(date_of_visits, '%d-%m-%Y') as date_of_visits1,amc_tkt_id as ticket_id,amc_tkt_ref_no as ticket_ref_code from tbl_visits where  amc_ticket='TKT' and  amc_visit_status not in ('Closed','Opened','Cancelled','Completed') and `date_of_visits` = DATE_FORMAT(now(),'%Y-%m-%d')";
       
       
       $array[19] = "select *,DATE_FORMAT(created_date_time, '%d-%m-%Y') as date_of_visits1 from tbl_tickets where    ticket_status!='Cancelled' and DATE_FORMAT(created_date_time,'%Y-%m-%d') >= '".$this->this_week_sd."' and  DATE_FORMAT(created_date_time,'%Y-%m-%d') <=  '".$this->this_week_ed."'";
		
        $array[20] = "select *,DATE_FORMAT(created_date_time, '%d-%m-%Y') as date_of_visits1 from tbl_tickets where    ticket_status='Closed' and DATE_FORMAT(closed_on,'%Y-%m-%d') >= '".$this->this_week_sd."' and  DATE_FORMAT(closed_on,'%Y-%m-%d') <= '".$this->this_week_ed."'";
        
		$array[21] = "select *,DATE_FORMAT(date_of_visits, '%d-%m-%Y') as date_of_visits1,amc_tkt_id as ticket_id,amc_tkt_ref_no as ticket_ref_code from tbl_visits where  amc_ticket='TKT' and  amc_visit_status not in ('Closed','Opened','Cancelled','Completed') and `date_of_visits` >= '".$this->this_week_sd."' and  `date_of_visits` <= '".$this->this_week_ed."'";
		
		$array[22] = "select *,DATE_FORMAT(created_date_time, '%d-%m-%Y') as date_of_visits1 from tbl_tickets where    ticket_status!='Cancelled' and DATE_FORMAT(created_date_time,'%Y-%m-%d') >= '".$this->first_day_this_month."' and  DATE_FORMAT(created_date_time,'%Y-%m-%d') <= '".$this->last_day_this_month."'";
		
        $array[23] = "select *,DATE_FORMAT(created_date_time, '%d-%m-%Y') as date_of_visits1 from tbl_tickets where    ticket_status='Closed' and DATE_FORMAT(closed_on,'%Y-%m-%d') >= '".$this->first_day_this_month."' and DATE_FORMAT(closed_on,'%Y-%m-%d') <= '".$this->last_day_this_month."'";
        
		$array[24] = "select *,DATE_FORMAT(date_of_visits, '%d-%m-%Y') as date_of_visits1,amc_tkt_id as ticket_id,amc_tkt_ref_no as ticket_ref_code from tbl_visits where  amc_ticket='TKT' and  amc_visit_status not in ('Closed','Opened','Cancelled','Completed') and `date_of_visits` >= '".$this->first_day_this_month."' and `date_of_visits` <= '".$this->last_day_this_month."'";
        
        $array[25] = "select *,DATE_FORMAT(created_date_time, '%d-%m-%Y') as date_of_visits1 from tbl_tickets where    ticket_status!='Cancelled' and DATE_FORMAT(created_date_time,'%Y-%m-%d') >= '".$this->first_day_this_year."' and  DATE_FORMAT(created_date_time,'%Y-%m-%d') <= '".$this->last_day_this_year."'";
		
        $array[26] = "select *,DATE_FORMAT(created_date_time, '%d-%m-%Y') as date_of_visits1 from tbl_tickets where    ticket_status='Closed' and DATE_FORMAT(closed_on,'%Y-%m-%d') >= '".$this->first_day_this_year."' and DATE_FORMAT(closed_on,'%Y-%m-%d') <= '".$this->last_day_this_year."'";
        
		$array[27] = "select *,DATE_FORMAT(date_of_visits, '%d-%m-%Y') as date_of_visits1,amc_tkt_id as ticket_id,amc_tkt_ref_no as ticket_ref_code from tbl_visits where  amc_ticket='TKT' and  amc_visit_status not in ('Closed','Opened','Cancelled','Completed') and `date_of_visits` >= '".$this->first_day_this_year."' and `date_of_visits` <= '".$this->last_day_this_year."'";
		
		$array[28] = "select *,DATE_FORMAT(date_of_visits, '%d-%m-%Y') as date_of_visits1,amc_tkt_id as ticket_id,amc_tkt_ref_no as ticket_ref_code from tbl_visits where  amc_ticket='TKT' and  amc_visit_status  in ('Completed','Closed') and `date_of_visits` = DATE_FORMAT(now(),'%Y-%m-%d')";
		$array[29] = "select *,DATE_FORMAT(date_of_visits, '%d-%m-%Y') as date_of_visits1,amc_tkt_id as ticket_id,amc_tkt_ref_no as ticket_ref_code from tbl_visits where  amc_ticket='TKT' and  amc_visit_status  in ('Completed','Closed') and `date_of_visits` >= '".$this->this_week_sd."' and  `date_of_visits` <= '".$this->this_week_ed."'";
		$array[30] = "select *,DATE_FORMAT(date_of_visits, '%d-%m-%Y') as date_of_visits1,amc_tkt_id as ticket_id,amc_tkt_ref_no as ticket_ref_code from tbl_visits where  amc_ticket='TKT' and  amc_visit_status  in ('Completed','Closed') and `date_of_visits` >= '".$this->first_day_this_month."' and `date_of_visits` <= '".$this->last_day_this_month."'";
		$array[31] = "select *,DATE_FORMAT(date_of_visits, '%d-%m-%Y') as date_of_visits1,amc_tkt_id as ticket_id,amc_tkt_ref_no as ticket_ref_code from tbl_visits where  amc_ticket='TKT' and  amc_visit_status  in ('Completed','Closed') and `date_of_visits` >= '".$this->first_day_this_year."' and `date_of_visits` <= '".$this->last_day_this_year."'";
		$array[32] = "select count(ticket_id ) as year_wo_completed from tbl_tickets where  ticket_status  in ('Completed','Closed') and  DATE_FORMAT(completed_date_time,'%Y-%m-%d') >= '".$this->first_day_this_year."' and  DATE_FORMAT(completed_date_time,'%Y-%m-%d') <= '".$this->last_day_this_year."'";
        $array[33] = "select count(ticket_id ) as month_wo_completed from tbl_tickets where   ticket_status  in ('Completed','Closed') and  DATE_FORMAT(completed_date_time,'%Y-%m-%d') >= '".$this->first_day_this_month."' and  DATE_FORMAT(completed_date_time,'%Y-%m-%d') <= '".$this->last_day_this_month."'";
        $array[34] = "select count(ticket_id ) as week_wo_completed from tbl_tickets where   ticket_status  in ('Completed','Closed') and  DATE_FORMAT(completed_date_time,'%Y-%m-%d') >= '".$this->this_week_sd."' and   DATE_FORMAT(completed_date_time,'%Y-%m-%d') <= '".$this->this_week_ed."'";
        $array[35] = "select count(ticket_id ) as today_wo_completed from tbl_tickets where   ticket_status  in ('Completed','Closed') and  DATE_FORMAT(completed_date_time,'%Y-%m-%d') = DATE_FORMAT(now(),'%Y-%m-%d')";
       
       
       $array[36] = "select count(ticket_id) as wo_normal from tbl_tickets where ticket_status!='Cancelled' and ticket_priority not in ('Emergency','Urgent') and DATE_FORMAT(created_date_time,'%Y-%m') = '".$this->compare_val."' and category_id='".$this->categoryId."'";
	   $array[37] = "select count(ticket_id) as wo_urgent from tbl_tickets where ticket_status!='Cancelled' and ticket_priority='Urgent' and DATE_FORMAT(created_date_time,'%Y-%m') = '".$this->compare_val."' and category_id='".$this->categoryId."'";
	   $array[38] = "select count(ticket_id) as wo_emergency from tbl_tickets where ticket_status!='Cancelled' and ticket_priority='Emergency' and DATE_FORMAT(created_date_time,'%Y-%m') = '".$this->compare_val."' and category_id='".$this->categoryId."'";
       $array[39] = "SELECT c.category_id, c.category_name, IFNULL(COUNT(t.category_id), 0) AS count_wo FROM tbl_category c LEFT JOIN tbl_tickets t ON c.category_id = t.category_id AND t.ticket_status != 'Cancelled' AND t.ticket_priority NOT IN ('Emergency', 'Urgent') AND DATE_FORMAT(t.created_date_time, '%Y-%m') = '".$this->compare_val."' GROUP BY c.category_id";
       return $array;
    }
    function RequestAccept($FunctionEvents)
    {
        $var =  $this->SQLArray();
      
        switch ($FunctionEvents)
        {
             case 'list_dash_wos':
                switch($this->wo_type)
                {
                   case 'open':
                       switch($this->wo_condition)
                       {
                          case 'Today':
                              $this->varModelObj->ListFromTable($var[16]);
                          break;
                          case 'This Week':
                              $this->varModelObj->ListFromTable($var[19]);
                          break;
                          case 'This Month':
                              $this->varModelObj->ListFromTable($var[22]);
                          break;
                          case 'This Year':
                              $this->varModelObj->ListFromTable($var[25]);
                          break;
                       }
                       
                   break;
                   case 'close':
                       switch($this->wo_condition)
                       {
                          case 'Today':
                              $this->varModelObj->ListFromTable($var[17]);
                          break;
                          case 'This Week':
                              $this->varModelObj->ListFromTable($var[20]);
                          break;
                          case 'This Month':
                              $this->varModelObj->ListFromTable($var[23]);
                          break;
                          case 'This Year':
                              $this->varModelObj->ListFromTable($var[26]);
                          break;
                       }
                   break;
                   case 'pending':
                        switch($this->wo_condition)
                       {
                          case 'Today':
                              $this->varModelObj->ListFromTable($var[18]);
                          break;
                          case 'This Week':
                              $this->varModelObj->ListFromTable($var[21]);
                          break;
                          case 'This Month':
                              $this->varModelObj->ListFromTable($var[24]);
                          break;
                          case 'This Year':
                              $this->varModelObj->ListFromTable($var[27]);
                          break;
                       }
                   break;
                   case 'completed':
                        switch($this->wo_condition)
                       {
                          case 'Today':
                              $this->varModelObj->ListFromTable($var[28]);
                          break;
                          case 'This Week':
                              $this->varModelObj->ListFromTable($var[29]);
                          break;
                          case 'This Month':
                              $this->varModelObj->ListFromTable($var[30]);
                          break;
                          case 'This Year':
                              $this->varModelObj->ListFromTable($var[31]);
                          break;
                       }
                   break;
                }
            break;
        
            case 'check_wo_today':
                switch($this->criteria)
                {
                   case 'opened':
                       $this->varModelObj->ListFromTable($var[1]);
                   break;
                   case 'closed':
                       $this->varModelObj->ListFromTable($var[2]);
                   break;
                   case 'pending':
                       $this->varModelObj->ListFromTable($var[3]);
                   break;
                    case 'completed':
                       $this->varModelObj->ListFromTable($var[35]);
                   break;
                }
            break;
            case 'check_wo_week':
                switch($this->criteria)
                {
                   case 'opened':
                    
                       $this->varModelObj->ListFromTable($var[4]);
                   break;
                   case 'closed':
                       $this->varModelObj->ListFromTable($var[5]);
                   break;
                   case 'pending':
                       $this->varModelObj->ListFromTable($var[6]);
                   break;
                    case 'completed':
                       $this->varModelObj->ListFromTable($var[34]);
                   break;
                }
            break;
            
            case 'check_wo_month':
                switch($this->criteria)
                {
                   case 'opened':
                    
                       $this->varModelObj->ListFromTable($var[7]);
                   break;
                   case 'closed':
                       $this->varModelObj->ListFromTable($var[8]);
                   break;
                   case 'pending':
                       $this->varModelObj->ListFromTable($var[9]);
                   break;
                   case 'completed':
                       $this->varModelObj->ListFromTable($var[33]);
                   break;
                }
            break;
            case 'check_wo_year':
                switch($this->criteria)
                {
                   case 'opened':
                    
                       $this->varModelObj->ListFromTable($var[10]);
                   break;
                   case 'closed':
                       
                       $this->varModelObj->ListFromTable($var[11]);
                   break;
                   case 'pending':
                       $this->varModelObj->ListFromTable($var[12]);
                   break;
                   case 'completed':
                       $this->varModelObj->ListFromTable($var[32]);
                   break;
                }
            break;
            case 'check_wo_normal_graph':
                if($this->categoryId=="all")
                {
                     $this->varModelObj->ListFromTable($var[13]);
                }
                else
                {
                     $this->varModelObj->ListFromTable($var[36]);
                }
                 //$this->varModelObj->ListFromTable($var[13]);
            break;
            case 'check_wo_urgent_graph':
                if($this->categoryId=="all")
                {
                     $this->varModelObj->ListFromTable($var[14]);
                }
                else
                {
                     $this->varModelObj->ListFromTable($var[37]);
                }
                //$this->varModelObj->ListFromTable($var[14]);
            break;
            case 'check_wo_emergency_graph':
               if($this->categoryId=="all")
                {
                     $this->varModelObj->ListFromTable($var[15]);
                }
                else
                {
                     $this->varModelObj->ListFromTable($var[38]);
                }
                //$this->varModelObj->ListFromTable($var[15]);
            break;
            	
            	
            case 'check_wo_normal_graph_type':
                if($this->categoryId=="all")
                {
                    $this->varModelObj->ListFromTable($var[13]);
                }
                else
                {
                    $this->varModelObj->ListFromTable($var[36]);
                }
            break;
            
            case 'check_wo_urgent_graph_type':
                if($this->categoryId=="all")
                {
                    $this->varModelObj->ListFromTable($var[14]);
                }
                else
                {
                    $this->varModelObj->ListFromTable($var[37]);
                }
            break;
            
            case 'check_wo_emergency_graph_type':
                if($this->categoryId=="all")
                {
                    $this->varModelObj->ListFromTable($var[15]);
                }
                else
                {
                    $this->varModelObj->ListFromTable($var[38]);
                }
            break;	
            
            case "fetch_all_pie_data":
                $this->varModelObj->ListFromTable($var[39]);
            break;    
            
          
            default:
              echo 'No Action Found...!';
            break;
            
        }

    }
}//end of class

$obj = new customerController();
$obj->RequestAccept($obj->actionevents);
?>