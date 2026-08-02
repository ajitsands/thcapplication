
<!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
    
    .activeTableRowColor {
      background: gold !important;
    }
    .dataTables_wrapper .dataTables_filter input[type="search"] {
        width: 100%;
    }
    
    .strikethrough {
        text-decoration: line-through;
        color: red;
    }
    
    /* Define the fixed height for the div */
  .fixed-height-div {
    height: 400px; /* Adjust this value as needed */
    overflow-y: auto; /* Add scrollbar when content exceeds the fixed height */
    overflow-x: hidden; /* Hide horizontal scrollbar */
    border: 1px solid #ccc; /* Optional: Add border for styling */
    padding: 5px; /* Optional: Add padding for content */
  }
  
  /* Style the scrollbar */
  .fixed-height-div::-webkit-scrollbar {
    width: 5px; /* Adjust the width of the scrollbar */
  }

  /* Style the scrollbar track */
  .fixed-height-div::-webkit-scrollbar-track {
    background-color: #f1f1f1; /* Light grey */
  }

  /* Style the scrollbar thumb */
  .fixed-height-div::-webkit-scrollbar-thumb {
    background-color: #FF5733; /* Grey */
    border-radius: 10px; /* Rounded corners */
  }

  /* Style the scrollbar thumb on hover */
  .fixed-height-div::-webkit-scrollbar-thumb:hover {
    background-color: #C70039; /* Dark grey */
  }
</style>

<div class="container" style="padding-top:5px;">
    <div class="row">
        <div class="col-6" style="padding-top:20px;">
            
        </div>
        <div class="col-3" style="padding-top:20px;text-align:right;">
            <button type="button" class="btn btn-primary" id="btn_confim_privilages">Confirm Privilages</button>
           
        </div>
    </div>
    
<div class="row" style="padding-top:20px;">
    <!--<div class="col-12">
        <div class="row">
            <div class="col-6">
                <label for="" class="form-label">Enter Control / Module Name <span style="color:red">*</span></label>
                <input type="text" id="moduleOrControlName" class="form-control" id="exampleFormControlInput1" placeholder="Enter Control / Module Name">
            </div>
             <div class="col-6">
                 <label for="" class="form-label">Create a Permission</label><br>
                <button class="addNewEventstoJS">Add Actions</button>
            </div>
        </div>
    </div>-->
    <div class="col-3 fixed-height-div" style="padding-top:20px;">
        <div class="row">
            <div class="col-12" >
                <table id="tlb_listOfRolls" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                           
                            <th>List of Rolls/Groups</th>
                           
                           
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
             <div class="col-12" style="padding-top:20px;">
                <div class="row" style="padding:20px;">
                  <!--<label for="" class="form-label">Rolls/Groups</label>-->
                  <input type="text" class="form-control" placeholder="Rolls/Groups" id="txt_addRolesOrGroups"><p style="padding-top:10px;"/>
                  <button type="button" class="btn btn-primary" id="btn_addRolesOrGroups" style="width:100%">Add Rolls/Groups</button>
                </div>
             </div>
        </div>
       
    </div>
     <div class="col-3 fixed-height-div" style="padding-top:20px;">
        <table id="tlb_listOfControlsAndModules" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>ID</th>
                   
                    <th>Controls/Modules</th>
                    <th>Class Name</th>
                   
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    
    <div class="col-3 fixed-height-div" style="padding-top:20px;">
        <table id="tlb_addedListOfControlsAndModules" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>ID</th>
                   
                    <th>Privilage for Selected Roll</th>
                   <th>Class Name</th>
                   
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    
    
    
</div>

<div class="row" style="padding-top:20px;">
    
    <div class="col-4 fixed-height-div" style="padding-top:20px;">
          <table id="tlb_listOfUsers" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>ID</th>
                   
                    <th>User Name</th>
                    <th>Roll</th>
                   
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    <div class="col-3 fixed-height-div" style="padding-top:20px;">
           <table id="tlb_listOfRollsForUsers" class="display" style="width:100%">
             <thead>
                    <tr>
                        <th>ID</th>
                       
                        <th>List of Rolls/Groups</th>
                       
                       
                    </tr>
                </thead>
                <tbody>
                </tbody>
        </table>
    </div>
     
    
</div>

<div class="row" style="padding-top:10px;padding-bottom:10px;">
     <div class="col-4" >
         
     </div>
    <div class="col-3" style="text-align:right;">
       
       <button type="button" class="btn btn-primary" id="btn_change_user_roll">Change User Role</button>
    </div>
</div>

</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<!-- DataTables JavaScript -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
<!-- User Permission Script -->
<script type="text/javascript" src="js/jsfunctions.js?timestamp=<?php echo time(); ?>"></script>
