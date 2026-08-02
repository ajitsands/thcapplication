<?php

require ('../../model/common/common_functions.php');




class apartmentController
{
        var $varModelObj,$varDBConnection;
        public $actionevents,$ctrl_name,$exp_id, $exp_name,$exp_status;
    
        
    function __construct()
	{
	  
        $this->varModelObj = new CommonModel();
        $this->varDBConnection = $this->varModelObj->varDBConnection;
        $this->actionevents = $_POST['action'];
        $this->ctrl_name = $_POST['v_ctrl_name'];
     
        $this->question_type = $_POST['v_question_type'];
        $this->question_name = $_POST['v_question'];
		$this->question1 = $_POST['v_question1'];
		$this->question2 = $_POST['v_question2'];
        $this->question3 = $_POST['v_question3'];
		$this->question4 = $_POST['v_question4'];
		$this->question5 = $_POST['v_question5'];
		$this->question6 = $_POST['v_question6'];
		$this->question1_id = $_POST['v_question1_id'];
		$this->question2_id = $_POST['v_question2_id'];
        $this->question3_id = $_POST['v_question3_id'];
		$this->question4_id = $_POST['v_question4_id'];
		$this->question5_id = $_POST['v_question5_id'];
		$this->question6_id = $_POST['v_question6_id'];
		
		$this->end_date = $_POST['v_end_date'];
		$this->start_date = $_POST['v_start_date'];
		$this->customer = $_POST['v_customer'];
		
		$this->question_id = $_POST['v_question_id'];
        $this->question_status = $_POST['v_question_status'];
        $this->action_status = $_POST['v_action_status'];
        $this->v_category = $_POST['v_category'];
        $this->v_category_name = $_POST['v_category_name'];
      
        //v_asset_status
       
        date_default_timezone_set('Asia/Bahrain');
        $this->current_date = date("Y-m-d h:i:s");
       
    }
    
    
    
    function SQLArray()
    { 
        $array =  array();
        $array[1] = "INSERT INTO `tbl_customer_feedback` ( `question_type`, `question_name`, `q1`, `q2`, `q3`, `q4`, `q5`, `q6`,`category`) VALUES ('".$this->question_type."','".$this->question_name."','".$this->question1."','".$this->question2."','".$this->question3."','".$this->question4."','".$this->question5."','".$this->question6."','".$this->v_category."')";
        
        
       // $array[2] = "select * from 	tbl_customer_feedback order by question_id desc";
         $array[2] = "select * from feedback_questions order by id desc";
        
      
         //$array[3] ="update tbl_customer_feedback set `question_status`='Active' where question_id='".$this->question_id."'";
          $array[3] ="update feedback_questions set `status`='Active' where id='".$this->question_id."'";
        
         //$array[4] ="update tbl_customer_feedback set `question_status`='Deactive' where question_id='".$this->question_id."'";
          $array[4] ="update feedback_questions set `status`='Deactive' where id='".$this->question_id."'";
         
         //$array[5] = "UPDATE `tbl_customer_feedback` SET `question_type`='".$this->question_type."',`question_name`='".$this->question_name."',`q1`='".$this->question1."',`q2`='".$this->question2."',`q3`='".$this->question3."',`q4`='".$this->question4."',`q5`='".$this->question5."',`q6`='".$this->question6."' where question_id='".$this->question_id."'";
        
         $array[5] = "UPDATE `feedback_questions` SET `type`='".$this->question_type."',`question_text`='".$this->question_name."',category='".$this->v_category_name."',category_id=".$this->v_category." where id='".$this->question_id."'";
         
         $array[6] = "SELECT *,DATE_FORMAT((default_date), '%d-%m-%Y %H:%i:%s %p') as default_date FROM tbl_customer_feedback_details WHERE DATE(default_date) BETWEEN '".$this->start_date."' AND '".$this->end_date."' AND main_customer_name ='".$this->customer."' GROUP BY form_number"; 
         $array[7] = "SELECT *,DATE_FORMAT((default_date), '%d-%m-%Y %H:%i:%s %p') as default_date FROM tbl_customer_feedback_details WHERE DATE(default_date) = DATE('".$this->current_date."') GROUP BY form_number ";
         $array[8] = "SELECT *,DATE_FORMAT((default_date), '%d-%m-%Y %H:%i:%s %p') as default_date FROM tbl_customer_feedback_details WHERE DATE(default_date) BETWEEN '".$this->start_date."' AND '".$this->end_date."' GROUP BY form_number"; 
         $array[9] = "insert into feedback_questions (type,question_text,category,category_id)values('".$this->question_type."','".$this->question_name."','".$this->v_category_name."','".$this->v_category."')";
         $array[10] = "insert into feedback_options (question_id,option_text)values('".$this->question_type."','".$this->question_name."')";
        
         $array[11] = "select * from feedback_options where question_id='".$this->question_id."' order by id asc ";
        return $array;
    }
    function RequestAccept($FunctionEvents)
    {
        $var =  $this->SQLArray();
      
        switch ($FunctionEvents)
        {

            case 'add_question':
                //echo $var[1];
               $ret_id =  $this->varModelObj->AddToTable($var[9]);
               if($this->question_type!='text')
               {
                   $myArray = array();
               $myArray[0] = $this->question1;
               $myArray[1] = $this->question2;
               $myArray[2] = $this->question3;
               $myArray[3] = $this->question4;
               $myArray[4] = $this->question5;
               $myArray[5] = $this->question6;
               //$myArray[6] = 'NA';
               for($i=0;$i<=5;$i++)
               {
                   $this->varModelObj->AddToTable("insert into feedback_options (question_id,option_text)values('".$ret_id."','".$myArray[$i]."')");
               } 
               }
              
               
            break;
            
            
            
            case 'list_feedback_questions':
             
                $this->varModelObj->ListFromTable($var[2]);
            break;
            
            case 'fetch_options':
             
                $this->varModelObj->ListFromTable($var[11]);
            break;
            
            case 'update_question':
              //echo $var[5];
              $this->varModelObj->UpdateTable($var[5]);
              if($this->question_type!='text')
               {
                   $myArray = array();
                   $myArray[0] = $this->question1;
                   $myArray[1] = $this->question2;
                   $myArray[2] = $this->question3;
                   $myArray[3] = $this->question4;
                   $myArray[4] = $this->question5;
                   $myArray[5] = $this->question6;
                    $myArray_id = array();
                   $myArray_id[0] = $this->question1_id;
                   $myArray_id[1] = $this->question2_id;
                   $myArray_id[2] = $this->question3_id;
                   $myArray_id[3] = $this->question4_id;
                   $myArray_id[4] = $this->question5_id;
                   $myArray_id[5] = $this->question6_id;
              
                   for($i=0;$i<=5;$i++)
                   {
                       $this->varModelObj->UpdateTable("update feedback_options set option_text='".$myArray[$i]."' where  question_id='".$this->question_id."' and id='".$myArray_id[$i]."'");
                   }
               }
            break;
            
            case 'change_question_status':
               // echo $this->action_status;
                if($this->action_status=='Active')
                {
                  $this->varModelObj->UpdateTable($var[3]);
                }
                else
                {
                  $this->varModelObj->UpdateTable($var[4]);  
                }
            break;
            
            case 'list_customer_feedback':
               
                if($this->start_date == '' && $this->end_date ==''){
                   
                   $this->varModelObj->ListFromTable($var[7]); 
                }
                else if($this->start_date != '' && $this->end_date !='' && $this->customer=='All')
                {
                    $this->varModelObj->ListFromTable($var[8]);
                }
                else
                {
                    $this->varModelObj->ListFromTable($var[6]);
                }
                
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