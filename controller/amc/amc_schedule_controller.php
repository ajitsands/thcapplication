<?php

require ('../../model/common/common_functions.php');



class apartmentController
{
    var $varModelObj,$varDBConnection;
    public $actionevents,$amc_id,$amc_visit_id,$visit_date,$visit_time;
       
        
    function __construct()
	{
	  
        $this->varModelObj = new CommonModel();
        $this->varDBConnection = $this->varModelObj->varDBConnection;
        $this->actionevents = $_POST['action'];
        
      
        $this->amc_id = $_POST['amc_id'];
        $this->amc_visit_id = $_POST['amc_visit_id'];
        $this->visit_date = $_POST['visit_date'];
        $this->visit_time = $_POST['visit_time'];
        
    }
    
    
    
    
    function SQLArray()
    { 
        $array =  array();
        
         $array[1]="select amc_visit_id,amc_id,amc_ref_no,visit_mode,DATE_FORMAT(date_of_visits, '%Y') as year_of_visits,DATE_FORMAT(date_of_visits, '%M') as month_of_visits,DAYNAME(date_of_visits) as day_of_visits,date_of_visits,time_of_visit from  tbl_amc_visits where amc_id=".$this->amc_id." order by date_of_visits asc,time_of_visit asc";
         $array[2]="update tbl_amc_visits set date_of_visits='".$this->visit_date."',time_of_visit='".$this->visit_time."' where amc_visit_id=".$this->amc_visit_id;
         $array[3]="delete from tbl_amc_visits where amc_visit_id=".$this->amc_visit_id;
        return $array;
    }
    function RequestAccept($FunctionEvents)
    {
        $var =  $this->SQLArray();
      
        switch ($FunctionEvents)
        {
        
            
         
            
            case 'amc_list_schedules':
               
                    $this->varModelObj->ListFromTable($var[1]);
            break;

            case 'update_visit':
               
                $this->varModelObj->UpdateTable($var[2]);
            break;
            case 'cancel_visit':
               
                $this->varModelObj->DeleteRow($var[3]);
            break;
                
           
            default:
             echo 'No Action Found...!';
             break;
            
        }

    }
}//end of class

$obj = new apartmentController();
$obj->RequestAccept($obj->actionevents);
?>