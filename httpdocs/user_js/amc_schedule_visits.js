$(document).ready(function(){
                  
    var v_btn_amc_generate_schedule = $('#btn_generate_schedule').ladda();
    var v_amc_scchedules_list_table = $('#tbl_amc_date_list').DataTable({"destroy": true}); 
    
       var classScheduleVisits = function(options){
 
        /*
         * Variables accessible
         * in the class
         */
        var vars = {
            myVar  : 'original Value',
            myVar1  : 'original Value New'
        };
     
      
        /*
         * Can access this.method
         * inside other methods using
         * root.method()
         */
        var root = this;
     
        /*
         * Constructor
         */
        this.construct = function(options){
            $.extend(vars , options);
        };
     
        /*
         * Public method
         * Can be called outside class
         */
        this.myPublicMethod = function(varamc_id){
            
            load_data_to_grid_amc_schedules_list(varamc_id);
        };
     
     
        this.construct(options);
     
    };
    
    function load_data_to_grid_amc_schedules_list(amc_ids)
    {
     
      v_amc_scchedules_list_table.destroy();
            
       v_amc_scchedules_list_table = $('#tbl_amc_date_list').DataTable( {
              
                "ajax": {
                    'type': 'POST',
                    'url': '../controller/amc/amc_schedule_controller.php',
                    'data': {
                       action: 'amc_list_schedules',amc_id:amc_ids
                       
                    }
                },
                "language": {
                    "zeroRecords": "No records available",
                    "infoEmpty": "No records available",
                 },
               //"order": [[ 0, "desc" ]],
              
               "Paginate": true,
               "bLengthChange": false,
               "bFilter": false,
               "bInfo": false,
               "autoWidth": false,
              
           
               "columns": [
                  
                    { "data": null},
                   
                    { "data": "year_of_visits"},
                    { "data": "month_of_visits"},
                    { "data": "day_of_visits"},
                    { "data": "date_of_visits",
                    render: function ( data, type, rows, meta ) {
                            
                            return str_actions=' <td style="padding:0px;padding-left:30px;padding-right:30px;width:200px;"><input type="date" class="form-control daterange-single" value="'+data+'" id="txt_date_'+rows["amc_visit_id"]+'"></td>';
                            
                        }   
                    },
                    { "data": "time_of_visit",
                    render: function ( data, type, rows, meta ) {
                            
                        return str_actions=' <td style="padding:0px;padding-left:30px;padding-right:30px;width:150px;"><input class="form-control" type="time" name="time" width="50px;" value="'+data+'" id="txt_time_'+rows["amc_visit_id"]+'"></td>';
                         
                        }   
                    },
                    { "data": "amc_visit_id",
                         render: function ( data, type, rows, meta ) {
                            
                            return str_actions='<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown"><i class="icon-menu9"></i></a><div class="dropdown-menu dropdown-menu-right"><a href="#" class="dropdown-item"  name="amc_visit_update" ><i class="icon-pencil5"></i> Update Schedule</a><a href="#" class="dropdown-item" name="amc_cancel_schedule"><i class="icon-quill4"></i> Cancel Schedule</a></div></div></div>';
                             
                         }   
                    }
                    
                    
                    
                    
          
                ],
                pageLength: 20,
                searching: true,
                responsive: true,
                
                "aoColumnDefs": [
                   { "bSortable": false, "aTargets": [1,2,3,4,5,6] },
                   { "width": "5%", "targets": 0 } 
                   
               ],
               
                "initComplete": function( settings, json ) {
                       
                  
   
                 },
                   "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                    $("td:eq(0)", nRow).html(iDisplayIndex + 1);
                    return nRow;
                 },
                 drawCallback: function (settings) {
                  
               }
               
        });  
   
    }


    $('#tbl_amc_date_list tbody').on('click', 'a', function(e){
        var $row = $(this).closest('tr');
        var data = v_amc_scchedules_list_table.row($row).data();
        var v_amc_visit_id  = data.amc_visit_id;
        var v_amc_ids=data.amc_id;
         if($(this).attr("name")=='amc_visit_update')
         {
           var visit_date=$("#txt_date_"+v_amc_visit_id).val();
           var visit_time=$("#txt_time_"+v_amc_visit_id).val();
           $.post("../controller/amc/amc_schedule_controller.php",{action:'update_visit',amc_visit_id:v_amc_visit_id,visit_date:visit_date,visit_time:visit_time}
           , function(result,status)
             {
              
                    result = $.trim(result);
                    
                    if(status=='success')
                        {
                            
                            swal("Success", "Successfully updated the schedule...", "success");
                            
                            
                        }
                    else 
                        {
                            
                                swal("Error", "Sorry! Could not update the schedule...", "error");
                                return false;
                                
                        }
             });
             
         }
         if($(this).attr("name")=='amc_cancel_schedule')
         {
            $.post("../controller/amc/amc_schedule_controller.php",{action:'cancel_visit',amc_visit_id:v_amc_visit_id}
           , function(result,status)
             {
              
                    result = $.trim(result);
                    
                    if(status=='success')
                        {
                            
                            swal("Success", "Successfully cancelled the schedule...", "success");
                            
                            load_data_to_grid_amc_schedules_list(v_amc_ids);
                        }
                    else 
                        {
                            
                                swal("Error", "Sorry! Could not cancel the schedule...", "error");
                                return false;
                                
                        }
             });
            
             
         }
       
});
 

    function dateconvert(dates)
    {
       
       return dates.split("-").reverse().join("-");
    }
    
   v_btn_amc_generate_schedule.click(function(){ 
       var amc_id = $("#txt_amc_id_schedule_visit").val();
       var amc_ref_no = $("#txt_amc_ref_no_schedule_visit").val();
       var frequency_array=$("#select_visit_frequency option:selected'").toArray().map(item => item.value);
       var frequency_array=$("#select_visit_frequency").val();
       var start_date = dateconvert($("#txt_from_date").val());
       var end_date =dateconvert($("#txt_to_date").val());
       var schedule_time = $("#time").val();
       
       if($.trim(amc_id)==""||$.trim(amc_ref_no)=="")
       {
           swal("Warning","Please select the AMC details ....", "warning");
           v_btn_amc_generate_schedule.ladda( 'stop' );
           return false;
       }
       if(frequency_array=="")
       {
           swal("Warning","Please select Frequency of Visits ....", "warning");
           v_btn_amc_generate_schedule.ladda( 'stop' );
           return false;
       }
       else
       {         
       var schedule_time = $("#time").val();
       $.post("../view/amc/amc_generate_dates.php",{action:'schedule_visits',amc_id:amc_id,amc_ref_no:amc_ref_no,frequency_array:frequency_array,start_date:start_date,end_date:end_date,schedule_time:schedule_time}
                   , function(result,status)
                   {
                      
                       result = $.trim(result);
                       if(result.charAt(0)=='S')
                           {
                               v_btn_amc_generate_schedule.ladda( 'stop' );
                               swal("Success", "Visits scheduled successfully..", "success");
                            
                               $('#select_visit_frequency').val(null).trigger('change');
                               load_data_to_grid_amc_schedules_list(amc_id);
                           }
                       else 
                           {
                               v_btn_amc_generate_schedule.ladda( 'stop' );
                                swal("Error", "Sorry! Could not schedule the visits..", "error");
                                return false;
                                
                           }
           });
   
       }
   });       
   
   });