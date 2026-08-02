<?php

require ('../../model/common/common_functions_copy.php');



class apartmentController
{
        var $varModelObj,$varDBConnection;
      public $actionevents,$ctrl_name,$employee_type_id, $employee_type_name,$employee_code,$emp_cnt, $employee_password,$employee_name,$employee_contact_no,$employee_email_id,$employee_address,$employee_image,$employee_status,$expertise_length,$expertise_id1,$expertise_name1,$employee_action;
       public $expertise_id=array();
        
    function __construct()
	{
	  
        $this->varModelObj = new CommonModel();
        $this->varDBConnection = $this->varModelObj->varDBConnection;
        $this->actionevents = $_POST['action'];
        $this->ctrl_name = $_POST['v_ctrl_name'];
        $this->employee_type_id = $_POST['v_employee_type_id'];
        $this->employee_type_name = $_POST['v_employee_type_name'];
        $this->employee_code = $_POST['v_employee_code'];
        $this->employee_password = $_POST['v_employee_password'];
        $this->employee_name = $_POST['v_employee_name'];
        $this->employee_contact_no = $_POST['v_employee_contact_no'];
        $this->employee_email_id = $_POST['v_employee_email_id'];
        $this->employee_address = $_POST['v_employee_address'];
        $this->employee_image = $_POST['v_employee_image'];
        $this->employee_status = $_POST['v_employee_status'];
        $this->employee_id = $_POST['v_employee_id'];
        $this->expertise_id = $_POST['v_expertise_id'];
        $this->expertise_name = $_POST['v_expertise_name'];
        $this->expertise_length = count($this->expertise_id);
        
        $this->employee_cpr_number = $_POST['v_emp_cpr_number'];
        $this->employee_blood_group = $_POST['v_emp_blood_group'];
        $this->employee_passport_number = $_POST['v_emp_passport_no'];
        $this->employee_joining_date = $_POST['v_emp_joining_date'];
        $this->employee_cpr_expiry_date = $_POST['v_emp_cpr_expiry_date'];
        $this->employee_visa_validity = $_POST['v_emp_visa_validity'];
        $this->employee_is_driving_licence = $_POST['v_checked_val'];
        $this->employee_tech_type_name = $_POST['v_emp_tech_type_name'];
        
        $this->employee_native_number = $_POST['v_emp_native_no'];
        $this->employee_native_address = $_POST['v_emp_native_address'];
        $this->employee_visa_type = $_POST['v_emp_visa_type'];
        
        $this->employee_action = $_POST['v_employee_action'];
        date_default_timezone_set('Asia/Bahrain');
        $this->current_date = date("Y-m-d h:i:s");
       
    }
    
    
    
    function SQLArray()
    { 
        $array =  array();
        
        //$array[1]="call proc_add_employee_details('".$this->employee_type_id."','".$this->employee_type_name."','".$this->employee_code."','".$this->employee_password."','".$this->employee_name."','".$this->employee_contact_no."','".$this->employee_email_id."','".$this->employee_address."','".$this->employee_image."','". $this->expertise_id1."','".$this->expertise_name1."','". $this->employee_cpr_number."','".$this->employee_blood_group."','".$this->employee_passport_number."','".$this->employee_joining_date."','".$this->employee_cpr_expiry_date."','". $this->employee_visa_validity."','".$this->employee_is_driving_licence ."','".$this->employee_tech_type_name."','".$this->employee_native_number."','".$this->employee_native_address."','".$this->employee_visa_type."',@msg )";
         $array[1]="call proc_add_employee_details_v1('".$this->employee_type_id."','".$this->employee_type_name."','".$this->employee_password."','".$this->employee_name."','".$this->employee_contact_no."','".$this->employee_email_id."','".$this->employee_address."','".$this->employee_image."','". $this->expertise_id1."','".$this->expertise_name1."','". $this->employee_cpr_number."','".$this->employee_blood_group."','".$this->employee_passport_number."','".$this->employee_joining_date."','".$this->employee_cpr_expiry_date."','". $this->employee_visa_validity."','".$this->employee_is_driving_licence ."','".$this->employee_tech_type_name."','".$this->employee_native_number."','".$this->employee_native_address."','".$this->employee_visa_type."',@msg )";
        $array[2] = "select *,DATE_FORMAT(joining_date, '%d-%m-%Y') as joining_date_format,DATE_FORMAT(cpr_expiry_date, '%d-%m-%Y') as cpr_expiry_date_format,DATE_FORMAT(visa_validity_on, '%d-%m-%Y') as visa_validity_on_format from view_employee_expertiser_list where employee_id !=1 order by employee_id desc";
        
      
        $array[3]="call proc_edit_employee_details('".$this->employee_type_id."','".$this->employee_type_name."','".$this->employee_code."','".$this->employee_password."','".$this->employee_name."','".$this->employee_contact_no."','".$this->employee_email_id."','".$this->employee_address."','".$this->employee_image."','". $this->expertise_id1."','".$this->expertise_name1."','".$this->employee_id."','". $this->employee_cpr_number."','".$this->employee_blood_group."','".$this->employee_passport_number."','".$this->employee_joining_date."','".$this->employee_cpr_expiry_date."','". $this->employee_visa_validity."','".$this->employee_is_driving_licence ."','".$this->employee_tech_type_name."','".$this->employee_native_number."','".$this->employee_native_address."','".$this->employee_visa_type."',@msg )";
        
        
        $array[4] ="update tbl_employees set `employee_status`='Deactive' where employee_id='".$this->employee_id."'";
        
        $array[5] ="update tbl_employees set `employee_status`='Active' where employee_id='".$this->employee_id."'";
       
        $array[6] = "select employee_code from tbl_employees where employee_id =(SELECT employee_id FROM tbl_employees ORDER BY employee_id DESC LIMIT 1)";
        $array[7] ="SELECT expertise_id,expertise_name FROM tbl_technician_expertise where employee_id='".$this->employee_id."'";
        $array[8] ="Delete from tbl_technician_expertise where employee_id='".$this->employee_id."'";
        $array[9] ="Select employee_code from tbl_employees  where employee_code='".$this->employee_code."'";
        $array[10] ="update tbl_employees set `employee_code`='".$this->employee_code ."' where employee_id='".$this->employee_id."'";
        
        return $array;
    }
    function RequestAccept($FunctionEvents)
    {
        $var =  $this->SQLArray();
     
        switch ($FunctionEvents)
        {
        
            case 'employee_code_check':
                //echo $var[9];
              // $this->varModelObj->ReturnCountValue($var[9]);
            if($this->varModelObj->ReturnCountValue($var[9])==0)
              {
                  echo "not exist";
              }
              else
              {
            echo 1;
              }
               
                
            break;
            case 'add_employee':
                // Handle expertise and employee insertion
                if($this->expertise_length > 0) {
                    for($this->x = 0; $this->x < $this->expertise_length; $this->x++) {
                        $this->str[] = "('{$this->expertise_id[$this->x]}','{$this->expertise_name[$this->x]}')";
                        $this->expertise_id1 = $this->expertise_id[$this->x];
                        $this->expertise_name1 = $this->expertise_name[$this->x];
                        $var = $this->SQLArray();
                        $this->varModelObj->ExecuteProcedure($var[1]);
                    }
                } else {
                    $this->expertise_id1 = 0;
                    $this->expertise_name1 = 'NA';
                    $this->varModelObj->ExecuteProcedure($var[1]);   
                }
                
                // Fetch the last inserted employee_id
                $employee_id_query = "SELECT @msg AS employee_id";
                $result = $this->varDBConnection->query($employee_id_query);
                $row = $result->fetch_assoc();
                $employee_id = $row['employee_id'];
                
                // Handle document uploads and insertion
                $upload_dir = "../../httpdocs/employeeDoc/";
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }
                
                $document_data = json_decode($_POST['v_document_data'], true);
                if (!empty($document_data)) {
                    foreach ($document_data as $index => $doc) {
                        $doc_type = $doc['type'];
                        $file_names = explode(',', $doc['files']); // Split comma-separated file names
                        $expiry_date = $doc['expiry'] ?: '0000-00-00';
                        $remark = $doc['remark'];
                        
                        // Process uploaded files for this document row
                        $saved_file_names = [];
                        foreach ($_FILES as $key => $file) {
                            if (preg_match("/^document_files_{$index}_(\d+)$/", $key, $matches)) {
                                $file_index = $matches[1];
                                $file_name = $file['name'];
                                $tmp_name = $file['tmp_name'];
                                $destination = $upload_dir . basename($file_name);
                                
                                if (move_uploaded_file($tmp_name, $destination)) {
                                    $saved_file_names[] = $file_name;
                                } else {
                                    error_log("Failed to upload file: " . $file_name);
                                }
                            }
                        }
                        
                        // Insert into employee_doc table with comma-separated file names
                        if (!empty($saved_file_names)) {
                            $file_names_str = implode(',', $saved_file_names);
                            $sql = "INSERT INTO employee_doc (employee_id, document_type, document_name, expiry_date, remark) 
                                    VALUES (?, ?, ?, ?, ?)";
                            $stmt = $this->varDBConnection->prepare($sql);
                            $stmt->bind_param('issss', $employee_id, $doc_type, $file_names_str, $expiry_date, $remark);
                            $stmt->execute();
                        }
                    }
                }
                
                // Handle employee image upload
                if (isset($_FILES['employee_image']) && $_FILES['employee_image']['error'] == 0) {
                    $upload_dir1 = "../../httpdocs/images/";
                    $image_name = $_FILES['employee_image']['name'];
                    $image_tmp = $_FILES['employee_image']['tmp_name'];
                    $image_destination = $upload_dir1 . basename($image_name);
                    if (!move_uploaded_file($image_tmp, $image_destination)) {
                        error_log("Failed to upload employee image: " . $image_name);
                    }
                }
                
                echo "Success";
                break;
            
            case 'employee_list_view':
           // echo $var[2];
                $this->varModelObj->ListFromTable($var[2]);
            break;
            
             case 'select_expertise_names':
            
                 $this->varModelObj->ListFromTable($var[7]);
             break;


             case 'update_employee':
                 
                  $this->varModelObj->DeleteRow($var[8]);
                 if($this->expertise_length >0)
                 {
                  for($this->x = 0; $this->x < $this->expertise_length; $this->x++){
                      
                     $this->str[] = "('{$this->expertise_id[$this->x]}','{$this->expertise_name[$this->x]}')";
                     $this->expertise_id1= $this->expertise_id[$this->x];
                     $this->expertise_name1= $this->expertise_name[$this->x];
                     $var =  $this->SQLArray();
                     echo $this->expertise_name1;
                     echo $var[3];
                     $this->varModelObj->ExecuteProcedure($var[3]);
                     }
                  }
                  else
                  {
                      //echo 'else';
                  $this->expertise_id1=0;
                  $this->expertise_name1='NA';
                  //echo $var[3];
                  $this->varModelObj->ExecuteProcedure($var[3]);   
                  }
               
                  // Handle employee image update
                  $old_image = '';
                  $result = $this->varDBConnection->query("SELECT employee_image FROM tbl_employees WHERE employee_id = '{$this->employee_id}'");
                  if ($row = $result->fetch_assoc()) {
                      $old_image = $row['employee_image'];
                  }
                  
                  if (isset($_FILES['employee_image']) && $_FILES['employee_image']['error'] == 0) {
                      $upload_dir1 = "../../httpdocs/images/";
                      $image_tmp = $_FILES['employee_image']['tmp_name'];
                      $image_destination = $upload_dir1 . $this->employee_image;
                      if (move_uploaded_file($image_tmp, $image_destination)) {
                          if ($old_image != $this->employee_image && $old_image != 'default.jpg') {
                              $old_path = $upload_dir1 . $old_image;
                              if (file_exists($old_path)) {
                                  unlink($old_path);
                              }
                          }
                      }
                  }
                  
                  // Delete existing document rows
                  $sql = "DELETE FROM employee_doc WHERE employee_id = ?";
                  $stmt = $this->varDBConnection->prepare($sql);
                  $stmt->bind_param('i', $this->employee_id);
                  $stmt->execute();
                  
                  // Handle new/updated documents (same as add)
                  $upload_dir = "../../httpdocs/employeeDoc/";
                  if (!is_dir($upload_dir)) {
                      mkdir($upload_dir, 0777, true);
                  }
                  
                  $document_data = json_decode($_POST['v_document_data'], true);
                  if (!empty($document_data)) {
                      foreach ($document_data as $index => $doc) {
                          $doc_type = $doc['type'];
                          $file_names_str = $doc['files'];
                          $expiry_date = $doc['expiry'] ?: '0000-00-00';
                          $remark = $doc['remark'];
                          
                          // Process new uploaded files (existing files are already in file_names_str)
                          foreach ($_FILES as $key => $file) {
                              if (preg_match("/^document_files_{$index}_(\d+)$/", $key, $matches)) {
                                  $file_index = $matches[1];
                                  $file_name = $file['name'];
                                  $tmp_name = $file['tmp_name'];
                                  $destination = $upload_dir . basename($file_name);
                                  if (move_uploaded_file($tmp_name, $destination)) {
                                      // File uploaded successfully
                                  } else {
                                      error_log("Failed to upload file: " . $file_name);
                                  }
                              }
                          }
                          
                          // Insert updated document row
                          if (!empty($file_names_str)) {
                              $sql = "INSERT INTO employee_doc (employee_id, document_type, document_name, expiry_date, remark) 
                                      VALUES (?, ?, ?, ?, ?)";
                              $stmt = $this->varDBConnection->prepare($sql);
                              $stmt->bind_param('issss', $this->employee_id, $doc_type, $file_names_str, $expiry_date, $remark);
                              $stmt->execute();
                          }
                      }
                  }
                  
                  // Handle deleted files (remove from server)
                  $deleted_files = json_decode($_POST['deleted_files'], true);
                  if (!empty($deleted_files)) {
                      foreach ($deleted_files as $file) {
                          $file_path = $upload_dir . $file;
                          if (file_exists($file_path)) {
                              unlink($file_path);
                          }
                      }
                  }
               
              // $this->varModelObj->UpdateTable($var[3]);
            break;
            
            case 'change_employee_status':
                if($this->employee_action=='Active')
                {
                  $this->varModelObj->UpdateTable($var[5]);
                }
                else
                {
                  $this->varModelObj->UpdateTable($var[4]);  
                }
            break;
             case 'update_employee_code':
            
                $this->varModelObj->UpdateTable($var[10]);
            break;

            case 'get_employee_documents':
                $sql = "SELECT * FROM employee_doc WHERE employee_id = ?";
                $stmt = $this->varDBConnection->prepare($sql);
                $stmt->bind_param('i', $this->employee_id);
                $stmt->execute();
                $result = $stmt->get_result();
                $docs = [];
                while ($row = $result->fetch_assoc()) {
                    $docs[] = $row;
                }
                echo json_encode($docs);
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