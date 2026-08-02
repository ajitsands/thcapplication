<?php
require ('../../model/common/common_functions.php');
class customerController
{
        var $varModelObj,
        $varDBConnection,
        $start_date,
        $end_date,
        $customer,
        $job_category,
        $category_id,
        $ticket_priority,
        $service_request,
        $sel_status;
	   public $actionevents;
         
    function __construct()
	{
	  
        $this->varModelObj = new CommonModel();
        $this->varDBConnection = $this->varModelObj->varDBConnection;
        $this->actionevents = $_POST['action']; 
        $this->start_date = $_POST['start_date'] ;
        $this->end_date  = $_POST['end_date'];
        $this->customer        = $_POST['customer'];
        $this->job_category  = $_POST['job_category'];
        $this->category_id     = $_POST['category_id'];
        $this->ticket_priority  = $_POST['ticket_priority'];
        $this->service_request   = $_POST['service_request'];
        $this->sel_status   = $_POST['sel_status'];
        
    }
    
    function SQLArray()
    { 
        $array =  array();
        
   
       return $array;
    }
    function RequestAccept($FunctionEvents)
    {
        $var =  $this->SQLArray();
      
        switch ($FunctionEvents)
        {
            case 'list_ppm':

$sql = "SELECT
            v.*,

            DATE_FORMAT(v.date_of_visits,'%d/%m/%Y') AS date_of_visits1,
            DATE_FORMAT(v.visit_start_time,'%d-%m-%Y %H:%i') AS visit_start_time1,

            t.customer_name,
            t.closed_reason,
            t.cancelled_reason,
            t.escalated_reason,
            t.complaints_description,
            t.service_report_no,
            t.ticket_priority,
            t.category_id,
            t.category_name,
            t.location_name,
            t.building_name,
            t.service_request,
            
           COALESCE(
(
    SELECT GROUP_CONCAT(
        CONCAT(
            ts.service_description,
            CASE 
                WHEN ts.tech_remarks IS NOT NULL 
                     AND TRIM(ts.tech_remarks) <> '' 
                     AND ts.tech_remarks <> 'NA'
                THEN CONCAT(' : ', ts.tech_remarks)
                ELSE ''
            END
        )
        SEPARATOR '\n'
    )
    FROM tbl_ticket_services ts
    WHERE ts.ticket_id = v.amc_tkt_id
    AND ts.ticket_service_status NOT IN ('Pending','Processing','Cancelled')
),
''
) AS service_details

        FROM tbl_visits v

        LEFT JOIN tbl_tickets t
            ON t.ticket_id = v.amc_tkt_id

        WHERE
            v.amc_ticket='TKT'
            AND t.job_category='".$this->job_category."'
            AND v.date_of_visits BETWEEN '".$this->start_date."' 
            AND '".$this->end_date."'";


if($this->customer != "All")
{
    $sql .= " AND t.customer_id='".$this->customer."'";
}


if($this->ticket_priority != "All")
{
    $sql .= " AND t.ticket_priority='".$this->ticket_priority."'";
}


if($this->category_id != "All")
{
    $sql .= " AND t.category_id='".$this->category_id."'";
}


if($this->service_request != "All")
{
    $sql .= " AND t.service_request='".$this->service_request."'";
}

if($this->sel_status == "Pending")
{
    $sql .= " AND v.amc_visit_status not in ('Closed','Completed','Cancelled')";
}
if($this->sel_status != "All" && $this->sel_status != "Pending")
{
    $sql .= " AND v.amc_visit_status='".$this->sel_status."'";
}


$sql .= " ORDER BY v.date_of_visits ASC";
                 
			    $result = mysqli_query($this->varDBConnection, $sql);

                $data = array();
                
                while($row = mysqli_fetch_assoc($result))
                {
                    $data[] = $row;
                }
                
                
                echo json_encode([
                    "data" => $data
                ]);
                
                exit;
            break;
            case 'list_reactive':

$sql = "SELECT
            v.*,

            DATE_FORMAT(v.date_of_visits,'%d/%m/%Y') AS date_of_visits1,
            DATE_FORMAT(v.visit_start_time,'%d-%m-%Y %H:%i') AS visit_start_time1,

            t.customer_name,
            t.closed_reason,
            t.cancelled_reason,
            t.escalated_reason,
            t.complaints_description,
            t.service_report_no,
            t.ticket_priority,
            t.category_id,
            t.category_name,
            t.location_name,
            t.building_name,
            t.service_request,

          COALESCE(
(
    SELECT GROUP_CONCAT(
        CONCAT(
            ts.service_description,
            CASE 
                WHEN ts.tech_remarks IS NOT NULL 
                     AND TRIM(ts.tech_remarks) <> '' 
                     AND ts.tech_remarks <> 'NA'
                THEN CONCAT(' : ', ts.tech_remarks)
                ELSE ''
            END
        )
        SEPARATOR '\n'
    )
    FROM tbl_ticket_services ts
    WHERE ts.ticket_id = v.amc_tkt_id
    AND ts.ticket_service_status NOT IN ('Pending','Processing','Cancelled')
),
''
) AS service_details

        FROM tbl_visits v

        LEFT JOIN tbl_tickets t
            ON t.ticket_id = v.amc_tkt_id

        WHERE
            v.amc_ticket='TKT'
            AND t.job_category='".$this->job_category."'
            AND v.date_of_visits BETWEEN '".$this->start_date."' 
            AND '".$this->end_date."'";


if($this->customer != "All")
{
    $sql .= " AND t.customer_id='".$this->customer."'";
}


if($this->ticket_priority != "All")
{
    $sql .= " AND t.ticket_priority='".$this->ticket_priority."'";
}


if($this->category_id != "All")
{
    $sql .= " AND t.category_id='".$this->category_id."'";
}


if($this->service_request != "All")
{
    $sql .= " AND t.service_request='".$this->service_request."'";
}
if($this->sel_status == "Pending")
{
    $sql .= " AND v.amc_visit_status not in ('Closed','Completed','Cancelled')";
}
if($this->sel_status != "All" && $this->sel_status != "Pending")
{
    $sql .= " AND v.amc_visit_status='".$this->sel_status."'";
}

$sql .= " ORDER BY v.date_of_visits ASC";
                 
			    $result = mysqli_query($this->varDBConnection, $sql);

                $data = array();
                
                while($row = mysqli_fetch_assoc($result))
                {
                    $data[] = $row;
                }
                
                
                echo json_encode([
                    "data" => $data
                ]);
                
                exit;
            break;
             case 'list_other':

$sql = "SELECT
            v.*,

            DATE_FORMAT(v.date_of_visits,'%d/%m/%Y') AS date_of_visits1,
            DATE_FORMAT(v.visit_start_time,'%d-%m-%Y %H:%i') AS visit_start_time1,

            t.customer_name,
            t.closed_reason,
            t.cancelled_reason,
            t.escalated_reason,
            t.complaints_description,
            t.service_report_no,
            t.ticket_priority,
            t.category_id,
            t.category_name,
            t.location_name,
            t.building_name,
            t.service_request,

           COALESCE(
(
    SELECT GROUP_CONCAT(
        CONCAT(
            ts.service_description,
            CASE 
                WHEN ts.tech_remarks IS NOT NULL 
                     AND TRIM(ts.tech_remarks) <> '' 
                     AND ts.tech_remarks <> 'NA'
                THEN CONCAT(' : ', ts.tech_remarks)
                ELSE ''
            END
        )
        SEPARATOR '\n'
    )
    FROM tbl_ticket_services ts
    WHERE ts.ticket_id = v.amc_tkt_id
    AND ts.ticket_service_status NOT IN ('Pending','Processing','Cancelled')
),
''
) AS service_details

        FROM tbl_visits v

        LEFT JOIN tbl_tickets t
            ON t.ticket_id = v.amc_tkt_id

        WHERE
            v.amc_ticket='TKT'
            AND t.job_category='".$this->job_category."'
            AND v.date_of_visits BETWEEN '".$this->start_date."' 
            AND '".$this->end_date."'";


if($this->customer != "All")
{
    $sql .= " AND t.customer_id='".$this->customer."'";
}


if($this->ticket_priority != "All")
{
    $sql .= " AND t.ticket_priority='".$this->ticket_priority."'";
}


if($this->category_id != "All")
{
    $sql .= " AND t.category_id='".$this->category_id."'";
}


if($this->service_request != "All")
{
    $sql .= " AND t.service_request='".$this->service_request."'";
}
if($this->sel_status == "Pending")
{
    $sql .= " AND v.amc_visit_status not in ('Closed','Completed','Cancelled')";
}
if($this->sel_status != "All" && $this->sel_status != "Pending")
{
    $sql .= " AND v.amc_visit_status='".$this->sel_status."'";
}

$sql .= " ORDER BY v.date_of_visits ASC";
                 
			    $result = mysqli_query($this->varDBConnection, $sql);

                $data = array();
                
                while($row = mysqli_fetch_assoc($result))
                {
                    $data[] = $row;
                }
                
                
                echo json_encode([
                    "data" => $data
                ]);
                
                exit;
            break;
             case 'load_search':
                 $startDate=$this->startDate;
                 $endDate=$this->endDate;
                 $customer=$this->customer;
                 $ticketWhere = " WHERE ticket_status <> 'Cancelled' ";

                if ($startDate != '') {
                    $ticketWhere .= " AND DATE(created_date_time) >= '$startDate'";
                }
                
                if ($endDate != '') {
                    $ticketWhere .= " AND DATE(created_date_time) <= '$endDate'";
                }
                
                if ($customer != 'All') {
                    $ticketWhere .= " AND customer_id = '$customer'";
                }
                 
                
                    $response = array();

                        /* ===========================
                           Total Work Orders
                        =========================== */
                        
                               $sql1 = "SELECT
        
                                COUNT(ticket_id) total,
                                
                                SUM(ticket_priority='Emergency') emergency,
                                SUM(ticket_priority='Urgent') urgent,
                                SUM(ticket_priority='Normal') normal,
                                
                                SUM(service_request='Hard FM') hard_fm,
                                SUM(service_request='Soft FM') soft_fm,
                                SUM(service_request='Others') others,
                                
                                SUM(job_category='PPM') ppm,
                                SUM(job_category='Reactive') reactive,
                                SUM(job_category='Variable') variable,
                                
                                SUM(quote_required='Yes') quoted,
                                SUM(quote_required='No') not_quoted
                                
                                FROM tbl_tickets
                                
                                $ticketWhere";
                      
                        $response['total'] = mysqli_fetch_assoc(mysqli_query($this->varDBConnection,$sql1));
                        
                        
                        /* ===========================
                           Raised
                        =========================== */
                        $whereRaised = str_replace(
                            "ticket_status <> 'Cancelled'",
                            "ticket_status = 'Opened'",
                            $ticketWhere
                        );
                        $sql2 = "SELECT
                        COUNT(ticket_id) total,
                        
                        SUM(ticket_priority='Emergency') emergency,
                        SUM(ticket_priority='Urgent') urgent,
                        SUM(ticket_priority='Normal') normal,
                        
                        SUM(service_request='Hard FM') hard_fm,
                        SUM(service_request='Soft FM') soft_fm,
                        SUM(service_request='Others') others,
                        
                        SUM(job_category='PPM') ppm,
                        SUM(job_category='Reactive') reactive,
                        SUM(job_category='Variable') variable,
                        
                        SUM(quote_required='Yes') quoted,
                        SUM(quote_required='No') not_quoted
                        
                        FROM tbl_tickets
                        
                        $whereRaised";
                        
                        $response['raised'] = mysqli_fetch_assoc(mysqli_query($this->varDBConnection,$sql2));
                        
                        
                        /* ===========================
                           Pending
                        =========================== */
                    $wherePending = "
                            WHERE v.amc_ticket = 'TKT'
                            AND v.amc_visit_status NOT IN ('Completed','Closed','Cancelled')
                            ";
                            
                            if ($startDate != '') {
                                $wherePending .= " AND DATE(v.date_of_visits) >= '$startDate'";
                            }
                            
                            if ($endDate != '') {
                                $wherePending .= " AND DATE(v.date_of_visits) <= '$endDate'";
                            }
                            
                            if ($customer != 'All') {
                                $wherePending .= " AND t.customer_id = '$customer'";
                            }
                            
                            $sql3 = "
                            SELECT
                            
                            COUNT(v.amc_visit_id) AS total,
                            
                            SUM(t.ticket_priority='Emergency') AS emergency,
                            SUM(t.ticket_priority='Urgent') AS urgent,
                            SUM(t.ticket_priority='Normal') AS normal,
                            
                            SUM(t.service_request='Hard FM') AS hard_fm,
                            SUM(t.service_request='Soft FM') AS soft_fm,
                            SUM(t.service_request='Others') AS others,
                            
                            SUM(t.job_category='PPM') AS ppm,
                            SUM(t.job_category='Reactive') AS reactive,
                            SUM(t.job_category='Variable') AS variable,
                            
                            SUM(t.quote_required='Yes') AS quoted,
                            SUM(t.quote_required='No') AS not_quoted
                            
                            FROM tbl_visits v
                            INNER JOIN tbl_tickets t
                                ON t.ticket_id = v.amc_tkt_id
                            
                            $wherePending
                            ";
                     
                        $response['pending'] = mysqli_fetch_assoc(mysqli_query($this->varDBConnection,$sql3));
                        
                        
                        /* ===========================
                           Completed
                        =========================== */
                        $whereCompleted = " WHERE ticket_status IN ('Completed','Closed') ";

                        if ($startDate != '')
                            $whereCompleted .= " AND DATE(completed_date_time) >= '$startDate'";
                        
                        if ($endDate != '')
                            $whereCompleted .= " AND DATE(completed_date_time) <= '$endDate'";
                        
                        if ($customer != 'All')
                            $whereCompleted .= " AND customer_id='$customer'";
                        $sql4 = "SELECT
                        COUNT(ticket_id) total,
                        
                        SUM(ticket_priority='Emergency') emergency,
                        SUM(ticket_priority='Urgent') urgent,
                        SUM(ticket_priority='Normal') normal,
                        
                        SUM(service_request='Hard FM') hard_fm,
                        SUM(service_request='Soft FM') soft_fm,
                        SUM(service_request='Others') others,
                        
                        SUM(job_category='PPM') ppm,
                        SUM(job_category='Reactive') reactive,
                        SUM(job_category='Variable') variable,
                        
                        SUM(quote_required='Yes') quoted,
                        SUM(quote_required='No') not_quoted
                        
                        FROM tbl_tickets
                        
                        $whereCompleted";
                       
                        $response['completed'] = mysqli_fetch_assoc(mysqli_query($this->varDBConnection,$sql4));
                       
                        
                        /* ===========================
                           Closed
                        =========================== */
                        $whereClosed = " WHERE ticket_status='Closed' ";

                        if ($startDate != '')
                            $whereClosed .= " AND DATE(closed_on) >= '$startDate'";
                        
                        if ($endDate != '')
                            $whereClosed .= " AND DATE(closed_on) <= '$endDate'";
                        
                        if ($customer != 'All')
                            $whereClosed .= " AND customer_id='$customer'";
                        $sql5 = "SELECT
                        COUNT(ticket_id) total,
                        
                        SUM(ticket_priority='Emergency') emergency,
                        SUM(ticket_priority='Urgent') urgent,
                        SUM(ticket_priority='Normal') normal,
                        
                        SUM(service_request='Hard FM') hard_fm,
                        SUM(service_request='Soft FM') soft_fm,
                        SUM(service_request='Others') others,
                        
                        SUM(job_category='PPM') ppm,
                        SUM(job_category='Reactive') reactive,
                        SUM(job_category='Variable') variable,
                        
                        SUM(quote_required='Yes') quoted,
                        SUM(quote_required='No') not_quoted
                        
                        FROM tbl_tickets
                        
                        $whereClosed";
                     
                        $response['closed'] = mysqli_fetch_assoc(mysqli_query($this->varDBConnection,$sql5));
                        
                       
                       echo json_encode($response);
                
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