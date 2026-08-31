$(document).ready(function(){
    var start_date,end_date;
                    
    var v_btn_employee_leave_add = $('#btn_employee_leave_add').ladda();
    $("#div_reason_for_leave").hide();              
                 
    var v_list_of_employees_on_leave_table;
    load_data_to_grid_employees_on_leave_list();

    // Initialize inline calendar view (8-column panel)
    if ($('#leave_calendar_inline').length) {
        $('#leave_calendar_inline').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            buttonIcons: {
                prev: 'left-single-arrow',
                next: 'right-single-arrow'
            },
            buttonText: {
                prev: '‹',
                next: '›',
                today: 'today',
                month: 'month',
                week: 'week',
                day: 'day'
            },
            editable: false,
            events: function(start, end, timezone, callback) {
                var v_emp_type = $('#select_filter_emp_type').val() || 'all';
                var v_leave_type = $('#select_filter_leave_type').val() || 'all';
                var v_from_date = $('#txt_filter_from_date').val() || '';
                var v_to_date = $('#txt_filter_to_date').val() || '';

                $.ajax({
                    url: '../controller/employees/employees_controller.php',
                    type: 'POST',
                    data: {
                        action: 'fetch_leave_calendar',
                        emp_type: v_emp_type,
                        leave_type: v_leave_type,
                        from_date: v_from_date,
                        to_date: v_to_date
                    },
                    success: function(doc) {
                        var events = [];
                        try {
                            var data = typeof doc === 'string' ? JSON.parse(doc) : doc;
                            $.each(data, function(i, item) {
                                events.push({
                                    leave_id: item.leave_id,
                                    table_source: item.table_source,
                                    employee_code: item.employee_code,
                                    employee_name: item.employee_name,
                                    leave_type: item.leave_type,
                                    leave_reason: item.leave_reason,
                                    start_date_raw: item.start_date_raw,
                                    end_date_raw: item.end_date_raw,
                                    title: item.title,
                                    start: item.start,
                                    end: item.end,
                                    color: item.color
                                });
                            });
                        } catch (e) {
                            console.error("Error parsing JSON:", e);
                        }
                        callback(events);
                    }
                });
            },
            eventClick: function(calEvent, jsEvent, view) {
                openEditLeaveModal(calEvent);
            }
        });
    }

    function openEditLeaveModal(calEvent) {
        $('#edit_leave_id').val(calEvent.leave_id || '');
        $('#edit_leave_table_source').val(calEvent.table_source || 'short');
        $('#edit_leave_emp_code').val(calEvent.employee_code || '');
        var empDisplay = (calEvent.employee_code ? '[' + calEvent.employee_code + '] ' : '') + (calEvent.employee_name || '');
        $('#edit_leave_emp_name').val(empDisplay);

        if (calEvent.leave_type) {
            $('#edit_leave_type').val(calEvent.leave_type);
        }

        var sDate = calEvent.start_date_raw || (calEvent.start ? moment(calEvent.start).format('YYYY-MM-DD') : '');
        var eDate = calEvent.end_date_raw || '';
        if (!eDate && calEvent.end) {
            eDate = moment(calEvent.end).subtract(1, 'days').format('YYYY-MM-DD');
        } else if (!eDate) {
            eDate = sDate;
        }

        $('#edit_leave_start_date').val(sDate);
        $('#edit_leave_end_date').val(eDate);
        $('#edit_leave_reason').val(calEvent.leave_reason || '');

        $('#modal_edit_leave').modal('show');
    }

    $('#btn_update_leave').click(function() {
        var leave_id = $('#edit_leave_id').val();
        var table_source = $('#edit_leave_table_source').val();
        var leave_type = $('#edit_leave_type').val();
        var start_date = $('#edit_leave_start_date').val();
        var end_date = $('#edit_leave_end_date').val();
        var leave_reason = $('#edit_leave_reason').val();

        if (!leave_id || !start_date || !end_date) {
            swal("Warning", "Please provide Start Date and End Date.", "warning");
            return;
        }

        if (end_date < start_date) {
            swal("Warning", "End Date cannot be before Start Date.", "warning");
            return;
        }

        $.post('../controller/employees/employees_controller.php', {
            action: 'update_leave_record',
            leave_id: leave_id,
            table_source: table_source,
            leave_type: leave_type,
            start_date: start_date,
            end_date: end_date,
            leave_reason: leave_reason
        }, function(res) {
            res = $.trim(res);
            if (res === 'Success') {
                swal("Success", "Leave record updated successfully!", "success");
                $('#modal_edit_leave').modal('hide');
                if ($('#leave_calendar_inline').length) {
                    $('#leave_calendar_inline').fullCalendar('refetchEvents');
                }
                if ($('#leave_calendar_view').length) {
                    $('#leave_calendar_view').fullCalendar('refetchEvents');
                }
                if (typeof load_data_to_grid_employees_on_leave_list === 'function') {
                    load_data_to_grid_employees_on_leave_list();
                }
            } else {
                swal("Error", res, "error");
            }
        });
    });

    $('#btn_delete_leave').click(function() {
        var leave_id = $('#edit_leave_id').val();
        var table_source = $('#edit_leave_table_source').val();
        var employee_code = $('#edit_leave_emp_code').val();

        if (!leave_id) {
            swal("Warning", "Invalid leave record.", "warning");
            return;
        }

        swal({
            title: "Delete Leave Record?",
            text: "Are you sure you want to delete this leave entry? This action cannot be undone.",
            icon: "warning",
            buttons: {
                cancel: "No, Cancel",
                confirm: {
                    text: "Yes, Delete",
                    className: "btn-danger"
                }
            },
            dangerMode: true,
        }).then(function(willDelete) {
            if (willDelete) {
                $.post('../controller/employees/employees_controller.php', {
                    action: 'delete_leave_record',
                    leave_id: leave_id,
                    table_source: table_source,
                    employee_code: employee_code
                }, function(res) {
                    res = $.trim(res);
                    if (res === 'Success') {
                        swal("Deleted!", "Leave record deleted successfully.", "success");
                        $('#modal_edit_leave').modal('hide');
                        if ($('#leave_calendar_inline').length) {
                            $('#leave_calendar_inline').fullCalendar('refetchEvents');
                        }
                        if ($('#leave_calendar_view').length) {
                            $('#leave_calendar_view').fullCalendar('refetchEvents');
                        }
                        if (typeof load_data_to_grid_employees_on_leave_list === 'function') {
                            load_data_to_grid_employees_on_leave_list();
                        }
                    } else {
                        swal("Error", res, "error");
                    }
                });
            }
        });
    });
                 
                 
                $("#div_reason_select").change(function(){
                
                        var v_reason_id=$("#select_reason_for_leave option:selected").val();
                        var v_emp_details=$("#select_employee_for_leave option:selected").text();
                        v_emp_details=v_emp_details.split("-");
                        var v_emp_code=$.trim(v_emp_details[0]);
                        var v_emp_name=v_emp_details[1];
                          if(v_reason_id=='add_reason')
                          {
                              
                             $('#div_reason_for_leave').show(); 
                             
                          }
                        
            
                });
                    
                 
                 $('#txt_leave_from_date').change(function (e) {
                     start_date = $("#txt_leave_from_date").val();
                     end_date = $("#txt_leave_to_date").val();
                     if (start_date && end_date && end_date < start_date) {
                         swal("Warning", "End Date cannot be before Start Date.", "warning");
                         $('#txt_leave_to_date').val("");
                     }
                 });         
              
                 $('#txt_leave_to_date').change(function (e) {  
                     start_date = $("#txt_leave_from_date").val();
                     end_date = $("#txt_leave_to_date").val();
                     if (start_date && end_date && end_date < start_date) {
                         swal("Warning", "End Date cannot be before Start Date.", "warning");
                         $('#txt_leave_to_date').val("");
                     }
                 });       
            // Insert employee details....
 
                v_btn_employee_leave_add.click(function(){
                    v_btn_employee_leave_add.ladda( 'start' );
                   // v_emp_id=$("#select_employee_for_leave option:selected").val();
                     v_btn_employee_leave_add.ladda( 'start' );
                     var selectedOpt = $("#select_employee_for_leave option:selected");
                     var v_emp_id = selectedOpt.val();
                     var v_emp_code = selectedOpt.data('code') || '';
                     var v_emp_name = selectedOpt.data('name') || '';

                     if (!v_emp_code || !v_emp_name) {
                         var fullText = selectedOpt.text();
                         var dashIndex = fullText.lastIndexOf(' - ');
                         if (dashIndex !== -1) {
                             v_emp_code = $.trim(fullText.substring(0, dashIndex));
                             v_emp_name = $.trim(fullText.substring(dashIndex + 3));
                         } else {
                             v_emp_code = $.trim(fullText);
                             v_emp_name = $.trim(fullText);
                         }
                     }

                     start_date = $("#txt_leave_from_date").val();
                     end_date = $("#txt_leave_to_date").val();
                     var type_of_leave = $("#select_type_of_leave option:selected").val();
                     if (type_of_leave === "select" || !type_of_leave) {
                         type_of_leave = $("#select_type_of_leave option:selected").text();
                     }
                     var v_reason_id = $("#select_reason_for_leave option:selected").val();
                     var reason_for_leave = "";
                     if(v_reason_id == 'add_reason') {
                         reason_for_leave = $("#txt_reason_for_leave").val(); 
                     } else {
                         reason_for_leave = $("#select_reason_for_leave option:selected").text();
                     }

                     if (v_emp_id === "select" || !v_emp_name || !start_date || !end_date || type_of_leave === "select" || !type_of_leave || reason_for_leave === "Select ") {
                         swal("Warning", "Please provide all the details ....", "warning");
                         v_btn_employee_leave_add.ladda('stop');
                         return false;
                     }
                     if (end_date < start_date) {
                         swal("Warning", "End Date cannot be before Start Date.", "warning");
                         v_btn_employee_leave_add.ladda('stop');
                         return false;
                     }
                    
                     else
                     {        
                        
                        
                        
                        
                         $.post("../controller/employee_leave/employee_leave_controller.php",{action:'add_leave_for_employee',v_employee_code:v_emp_code,v_employee_name:v_emp_name,start_date:start_date,end_date:end_date,type_of_leave:type_of_leave,reason_for_leave:reason_for_leave}
                                , function(result,status)
                                {
                                  console.log(result);
                                result = $.trim(result);
                               
                                if(result.charAt(0)=='U')
                                {
                                    v_btn_employee_leave_add.ladda( 'stop' );
                                    swal("Error", result, "error");
                                   
                                    clear_text();
                                   

                                
                                }
                                else 
                                {
                                      v_btn_employee_leave_add.ladda( 'stop' );
                                      swal("Success", "Employee leave added successfully..", "success");
                                      load_data_to_grid_employees_on_leave_list();
                                      if ($('#leave_calendar_inline').length) {
                                          $('#leave_calendar_inline').fullCalendar('refetchEvents');
                                      }
                                      clear_text();
                                 }
                                 
                                  
                             
                         });
                         
                        
                         
                      }
                  
                });
                //load data to employeegrid
                  function load_data_to_grid_employees_on_leave_list()
                  {
                     var v_emp_type = $('#select_filter_emp_type').val() || 'all';
                     var v_leave_type = $('#select_filter_leave_type').val() || 'all';
                     var v_from_date = $('#txt_filter_from_date').val() || '';
                     var v_to_date = $('#txt_filter_to_date').val() || '';
                      
                     if ($.fn.DataTable.isDataTable('#list_of_employees_on_leave')) {
                         $('#list_of_employees_on_leave').DataTable().destroy();
                     }
                          
                      v_list_of_employees_on_leave_table = $('#list_of_employees_on_leave').DataTable( {
                            
                              "ajax": {
                                  'type': 'POST',
                                  'url': '../controller/employee_leave/employee_leave_controller.php',
                                  'data': {
                                     action: 'employee_on_leave_list',
                                     emp_type: v_emp_type,
                                     leave_type: v_leave_type,
                                     from_date: v_from_date,
                                     to_date: v_to_date
                                  }
                              },
                              "language": {
                                  "zeroRecords": "No leave records available",
                                  "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                                  "infoEmpty": "Showing 0 to 0 of 0 entries",
                                  "infoFiltered": "(filtered from _MAX_ total entries)",
                                  "paginate": {
                                      "first": "First",
                                      "last": "Last",
                                      "next": "Next &rarr;",
                                      "previous": "&larr; Prev"
                                  }
                              },
                             "order": [[ 0, "desc" ]],
                             "dom": '<"datatable-header"flB><"datatable-scroll"t><"datatable-footer"ip>',
                             "buttons": [
                                {
                                    extend: 'excelHtml5',
                                    text: '<i class="icon-file-excel mr-2"></i> Export to Excel',
                                    className: 'btn btn-success btn-sm mb-2',
                                    exportOptions: {
                                        columns: [0, 1, 2, 3, 4, 5, 6, 7]
                                    }
                                }
                            ],
            				"Paginate": true,
            				"bLengthChange": true,
            				"bFilter": true,
            				"bInfo": true,
            				"autoWidth": false,
            				
            			
                            "columns": [
                                 { "data": null},
                                 { "data": "employee_code"},
                                 { "data": "employee_name" },
                                 { "data": "employee_type_name" },
                                 { 
                                     "data": "leave_type",
                                     render: function(data, type, row) {
                                         var col = row.leave_type_color || '#26a69a';
                                         return '<span class="badge badge-pill text-white px-2 py-1" style="background-color:' + col + '; font-size:11px; font-weight:500;"><i class="icon-primitive-dot mr-1"></i>' + (data || 'Leave') + '</span>';
                                     }
                                 },
                                 { "data": "leave_reason"},
                                 { "data": "start_time"},
                                 { "data": "end_time" }
                             ],
                             pageLength: 10,
            				 searching: true,
                             responsive: true,
                             
                             "aoColumnDefs": [
            					{ "bSortable": false, "aTargets": [ 0,1,2,3,4,5,6,7] }, 
            					
            				],
                            
            				
                             "initComplete": function( settings, json ) {
                                    
                               
             
                              },
                                "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                                 $("td:eq(0)", nRow).html(iDisplayIndex + 1);
                                 return nRow;
                              },
                              "drawCallback": function () {
                                   
                                }
                            
                     });  
                
                 }
                 
                  $('#list_of_employees_on_leave tbody').on('click', 'td a', function(){
                        var $row = $(this).closest('tr');
                        var emp_data = v_list_of_employees_on_leave_table.row($row).data();
                        employee_code  = emp_data.employee_code;
                        
                        
                        swal({
                                
    							title: "Are you sure?",
    							text: "Do you want to mark the employee back to work ?",
    							icon: 'warning',
    							dangerMode: true,
    							allowOutsideClick: false,
                                closeOnClickOutside: false,
    							buttons: {
    							  cancel: 'No Cancel !',
    							  delete: 'Yes Proceed'
    							}
    							}).then(function (willDelete) {
    							if (willDelete) {
    						
    						       $.post("../controller/employee_leave/employee_leave_controller.php",{action:'change_employee_leave_status',v_employee_code:employee_code}
                                , function(result,status)
                                {
                                   
                                  load_data_to_grid_employees_on_leave_list();
                                
                                });
                 						 
    							} else {
    							    
    							   
    							 
    							}
    						 });
                          
                         //var v_employee_action=$(this).attr("name");
                            //  $.post("../controller/employee_leave/employee_leave_controller.php",{action:'change_employee_leave_status',v_employee_code:employee_code}
                            //     , function(result,status)
                            //     {
                                   
                            //       load_data_to_grid_employees_on_leave_list();
                                
                            // });
                        
                          
                        
        });
       
            
                //  $( '#btn_employee_new' ).click(function(){
                  
                //         $( '#btn_employee_leave_add' ).show();
                        
                //         clear_text();
                //     })
            
                // //function clear text
                  function clear_text()
                     {
                        
                        $("#txt_leave_from_date").val("");
                        $("#txt_leave_to_date").val("");
                        $("#select_employee_for_leave").val(null).trigger("change");
                        $("#select_type_of_leave").val(null).trigger("change");
                        $("#select_reason_for_leave").val(null).trigger("change");
                       
                     }

    // Filter Leave Records Action
    $('#btn_apply_leave_filter').click(function(){
        load_data_to_grid_employees_on_leave_list();
        if ($('#leave_calendar_inline').length) {
            $('#leave_calendar_inline').fullCalendar('refetchEvents');
        }
    });

    // Reset Leave Records Filter Action
    $('#btn_reset_leave_filter').click(function(){
        $('#select_filter_emp_type').val('all').trigger('change');
        $('#select_filter_leave_type').val('all').trigger('change');
        $('#txt_filter_from_date').val('');
        $('#txt_filter_to_date').val('');
        load_data_to_grid_employees_on_leave_list();
        if ($('#leave_calendar_inline').length) {
            $('#leave_calendar_inline').fullCalendar('refetchEvents');
        }
    });
        
});