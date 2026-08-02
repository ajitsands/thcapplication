<?php

require ('../../model/common/common_functions.php');




class projectController
{
        var $varModelObj,$varDBConnection;
        public $actionevents,$ctrl_name;
    
        
    function __construct()
	{
	  
        $this->varModelObj = new CommonModel();
        $this->varDBConnection = $this->varModelObj->varDBConnection;
        $this->actionevents = $_POST['action'];
        $this->ctrl_name = $_POST['v_ctrl_name'];
     
        $this->v_project_entries_id = $_POST['v_project_entries_id'];
        $this->v_project_id = $_POST['v_project_id'];
        $this->v_priority = $_POST['v_priority'];
        $this->v_project_name = $this->varDBConnection->real_escape_string($_POST['v_project_name']);
        $this->v_category = $this->varDBConnection->real_escape_string($_POST['v_category']);
        $this->v_comments = $this->varDBConnection->real_escape_string($_POST['v_comments']);
        $this->v_parts = $this->varDBConnection->real_escape_string($_POST['v_parts']);
        $this->v_place = $this->varDBConnection->real_escape_string($_POST['v_place']);
        $this->v_location = $this->varDBConnection->real_escape_string($_POST['v_location']);
        $this->v_description = $this->varDBConnection->real_escape_string($_POST['v_description']);
        $this->v_session_image = $_POST['v_session_image'];
        $this->v_date = $_POST['v_date'];
        $this->v_todate = $_POST['v_todate'];
        $this->v_emp = $_POST['v_emp'];
        
        date_default_timezone_set('Asia/Bahrain');
        $this->current_date = date("Y-m-d"); 
        
       
    }
    
    
    
    function SQLArray()
    { 
        $array =  array();
        $array[1] = "INSERT INTO `tbl_project_entries` (project_id, project_name,description,location,place,parts,category,comments,priority,pic_name,inserted_date,inserted_id,inserted_name) VALUES (".$this->v_project_id.",'".$this->v_project_name."','".$this->v_description."','".$this->v_location."','".$this->v_place."','".$this->v_parts."','".$this->v_category."','".$this->v_comments."','".$this->v_priority."','".$this->v_session_image."','".$this->v_date."',".$_SESSION["user_id"].",'".$_SESSION["username"]."' )";
        
        
        // $array[2] = "select project_entries_id,project_id,project_name,description,location,place,parts,category,comments,priority,pic_name,inserted_date,inserted_id,inserted_name from 	tbl_project_entries where project_id=".$this->v_project_id." and inserted_date >='".$this->v_date."'  and inserted_date <='".$this->v_todate."' order by project_entries_id desc";
        // $array[5] = "select project_entries_id,project_id,project_name,description,location,place,parts,category,comments,priority,pic_name,inserted_date,inserted_id,inserted_name from 	tbl_project_entries where  inserted_date >='".$this->v_date."'  and inserted_date <='".$this->v_todate."'  order by project_entries_id desc";
        
      
         $array[3] ="update tbl_project_entries set project_id=".$this->v_project_id.", project_name='".$this->v_project_name."',description='".$this->v_description."',location='".$this->v_location."',place='".$this->v_place."',parts='".$this->v_parts."',category='".$this->v_category."',comments='".$this->v_comments."',priority='".$this->v_priority."',pic_name='".$this->v_session_image."' where project_entries_id=".$this->v_project_entries_id;
        
         $array[4] ="delete from tbl_project_entries where project_entries_id=".$this->v_project_entries_id;
         
         
       
        return $array;
    }
    function RequestAccept($FunctionEvents)
    {
        $var =  $this->SQLArray();
      
        switch ($FunctionEvents)
        {

            
            
           
            case 'add_entries':
               
                $this->varModelObj->AddToTable($var[1]);
            break;
            
            
            case 'list_entries':
                $sql_condition='';
                
                if($this->v_location=='0')
                {
                    $sql_condition=$sql_condition;
                }
                else
                {
                    $sql_condition=$sql_condition." location = '".$this->v_location."'  and";
                }
                
                if($this->v_place=='0')
                {
                   
                    $sql_condition=$sql_condition;
                }
                else
                {
                   
                    $sql_condition=$sql_condition." place = '".$this->v_place."' and";
                }
                if($this->v_parts=='0')
                {
                    $sql_condition=$sql_condition;
                }
                else
                {
                    $sql_condition=$sql_condition." parts = '".$this->v_parts."' and";
                }
                
                if($this->v_category=='0')
                {
                    $sql_condition=$sql_condition;
                }
                else
                {
                    $sql_condition=$sql_condition." category = '".$this->v_category."' and";
                }
                if($this->v_priority=='0')
                {
                    $sql_condition=$sql_condition;
                }
                else
                {
                    $sql_condition=$sql_condition." priority = '".$this->v_priority."' and";
                }
                if($this->v_emp=='0')
                {
                    $sql_condition=$sql_condition;
                }
                else
                {
                    $sql_condition=$sql_condition." inserted_id = ".$this->v_emp." and";
                }
               if($this->v_project_id==0)
               {
                   $sql_condition=$sql_condition;
               }
               else
               {
                   $sql_condition=$sql_condition." project_id = '".$this->v_project_id."' and";
               }
                
               if($sql_condition=='')
                {
                    $this->varModelObj->ListFromTable("select project_entries_id,project_id,project_name,description,location,place,parts,category,comments,priority,pic_name,inserted_date,inserted_id,inserted_name from 	tbl_project_entries where  inserted_date >='".$this->v_date."'  and inserted_date <='".$this->v_todate."'    order by project_entries_id desc");
                   
                }
                else
                {
                    $sql_condition=substr($sql_condition, 0, -3);
                    $this->varModelObj->ListFromTable("select project_entries_id,project_id,project_name,description,location,place,parts,category,comments,priority,pic_name,inserted_date,inserted_id,inserted_name from 	tbl_project_entries where  inserted_date >='".$this->v_date."'  and inserted_date <='".$this->v_todate."'   and ".$sql_condition."  order by project_entries_id desc");
                   
                }
                
                
            
                  
                 
             break;
            case 'edit_entries':
           
                $this->varModelObj->UpdateTable($var[3]);
            break;
            
            
            
             case 'delete_entries':
              if($_SESSION["user_type"]=='Administrator')
              {
                  $this->varModelObj->DeleteRow($var[4]);
              }
              else
              {
                  echo 'No';
              }
                
            break;
            
           
            
            
           
            default:
             echo 'No Action Found...!';
             break;
            
        }

    }
}//end of class

$obj = new projectController();
$obj->RequestAccept($obj->actionevents);
?>