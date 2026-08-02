

<?php switch($_GET['tab']) { 
   
    case "Emergency":  ?>
       <div class="card mt-5" style="overflow: auto;">
            <div class="card-header header-elements-inline">
                <h5 class="card-title">List of Emergency Work Oders</h5>
            </div>
            <table class="table datatable-selection-single" id="tbl_emergency_work_orders">
                <thead>
                    <tr>
                        <th>SINO</th>
                        <th>Date & Time</th>
                        <th>Work Order NO</th>
                        <th>Customer</th>
                        <th>Building</th>
                        <th>Location</th>
                        <th>Complaint</th>
                        <th>Priority</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div> 
   <?php   break;  
    case "Urgent": ?>
    <div class="card mt-5" style="overflow: auto;">
            <div class="card-header header-elements-inline">
                <h5 class="card-title">List of Urgent Work Oders</h5>
            </div>
            <table class="table datatable-selection-single" id="tbl_urgent_work_orders">
                <thead>
                    <tr>
                        <th>SINO</th>
                        <th>Date & Time</th>
                        <th>Work Order NO</th>
                        <th>Customer</th>
                        <th>Building</th>
                        <th>Location</th>
                        <th>Complaint</th>
                        <th>Priority</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div> 
   <?php break; 
    case "Normal": ?>
        <div class="card mt-5" style="overflow: auto;">
            <div class="card-header header-elements-inline">
                <h5 class="card-title">List of Normal Work Oders</h5>
            </div>
            <table class="table datatable-selection-single" id="tbl_normal_work_orders">
                <thead>
                    <tr>
                        <th>SINO</th>
                        <th>Date & Time</th>
                        <th>Work Order NO</th>
                        <th>Customer</th>
                        <th>Building</th>
                        <th>Location</th>
                        <th>Complaint</th>
                        <th>Priority</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div> 
    <?php break; 
     default:  ?>
        <div class="card mt-5" style="overflow: auto;">
            <div class="card-header header-elements-inline">
                <h5 class="card-title">404 Page Not Found !</h5>
            </div>
        </div>    
    <?php  break; }  ?>       
