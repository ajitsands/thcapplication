$(document).ready(function(){
    loadCustomer();
    load_data_to_grid_available_technicians_multiple ();
    function loadCustomer(){
        $.ajax({
    		type: "POST",
    		url: "../view/customer_location/customer_combo_customer_location.php",
		}).done(function(data){
			$("#div_customer_details_asset").html(data);
			$("#select_customer_for_customer_location").select2();
    	});
    }

    load_team();

    function load_team() {
        if ($.fn.DataTable.isDataTable('#list_team')) {
            $('#list_team').DataTable().destroy();
        }
    
        var load_team = $('#list_team').DataTable({
            "ajax": {
                'type': 'POST',
                'url': '../controller/ticket/team_controller.php',
                'data': {
                    action: 'get_team_list'
                }
            },
            "language": {
                "zeroRecords": "No records available",
                "infoEmpty": "No records available"
            },
            "order": [[0, "desc"]],
            "paginate": true,
            "bLengthChange": true,
            "bFilter": true,
            "bInfo": true,
            "autoWidth": false,
            "columns": [
                { "data": null },  // Serial number column
                { "data": "team_ref" },
                { "data": "customer_name" },
                { "data": null,
                    "render": function(data, type, row) {
                        var leader = row.leader;
                        var employeesStr = row.employees || "";
                        
                        // Convert comma-separated string to array
                        var employees = employeesStr.split(',');
                
                        var leaderHtml = '';
                        var membersHtml = [];
                
                        employees.forEach(function(emp) {
                            if (emp.trim() === leader) {
                                leaderHtml = `<div><strong style="color: #007bff;">${emp.trim()}</strong></div>`;
                            } else {
                                membersHtml.push(`<div>${emp.trim()}</div>`);
                            }
                        });
                
                        return leaderHtml + membersHtml.join('');
                    }
                },
                { "data": "status",
                    "render": function(data, type, row) {
                        if (data === "Active") {
                            return `<span style="background-color: #d4edda; color: black; padding: 4px 8px; border-radius: 4px; display: inline-block;">${data}</span>`;
                        } else {
                            return `<span style="background-color: #ffeeba; color: black; padding: 4px 8px; border-radius: 4px; display: inline-block;">${data}</span>`;
                        }
                    }
                },
                { "data": null,
                    "orderable": false,
                    "render": function(data, type, row) {
                        return `
                            <div class="list-icons">
                                <div class="dropdown">
                                    <a href="#" class="list-icons-item" data-toggle="dropdown" aria-expanded="false">
                                        <i class="icon-menu9"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a href="#" class="dropdown-item name_Edit" data-id="${row.team_ref}" data-emid="${row.customer_ids}" style="color: orange;">
                                            <i class="icon-database-edit2"></i> Edit
                                        </a>
                                        <a href="#" class="dropdown-item name_Active" data-id="${row.team_ref}" data-emid="${row.customer_ids}" style="color: green;">
                                            <i class="icon-checkmark2"></i> Active
                                        </a>
                                        <a href="#" class="dropdown-item name_Deactive" data-id="${row.team_ref}" data-emid="${row.customer_ids}" style="color: red;">
                                            <i class="icon-cross3"></i> Deactive
                                        </a>
                                    </div>
                                </div>
                            </div>
                        `;
                    }
                }
            ],
            pageLength: 10,
            searching: true,
            responsive: true,
            "aoColumnDefs": [],
            "rowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                var api = this.api();
                var pageInfo = api.page.info();
                var serialNumber = pageInfo.start + iDisplayIndex + 1;
                $('td:eq(0)', nRow).html(serialNumber);
            }
        });
    }
    
    $('#list_team').on('click', '.name_Edit', function(e) {
        e.preventDefault();
        const team_reference = $(this).data('id');
        const customer_id = $(this).data('emid');
        const row = $(this).closest('tr');
        const table = $('#list_team').DataTable();
        const rowData = table.row(row).data();
        
        console.log("Editing team:", rowData);
        
        // Set form values
        $("#hidden_ids").val(rowData.row_ids);
        $("#team_reference").val(team_reference);
        $('#select_customer_for_customer_location').val(customer_id).trigger('change');
        
        // Clear previous selections
        selectedTeamMembers = [];
        selectedLeader = null;
        
        // Get employees and leader from the row data
        const employeesStr = rowData.employees || "";
        const employeeNames = employeesStr.split(',').map(emp => emp.trim());
        const leaderName = rowData.leader;
        
        console.log("Team member names:", employeeNames);
        console.log("Team leader name:", leaderName);
        
        // Select team members in the technicians table
        if (v_list_of_techsavail_multiple) {
            // Clear all selections first
            v_list_of_techsavail_multiple.$('tr').removeClass('selected leader-selected');
            $('.leader-checkbox').prop('checked', false).trigger('change');
            
            // Process each row in the technicians table
            v_list_of_techsavail_multiple.rows().every(function() {
                var data = this.data();
                var employeeName = data.employee_name.trim();
                var employeeId = data.employee_id.toString();
                var rowNode = this.node();
                
                if (employeeNames.includes(employeeName)) {
                    // Add to selected array
                    selectedTeamMembers.push(employeeId);
                    
                    // Highlight the row
                    $(rowNode).addClass('selected');
                    
                    // Check if this is the leader
                    if (employeeName === leaderName) {
                        selectedLeader = employeeId;
                        $(rowNode).addClass('leader-selected');
                        $(rowNode).find('.leader-checkbox')
                            .prop('checked', true)
                            .trigger('change');
                    }
                }
            });
            
            console.log("Selected Team Members IDs:", selectedTeamMembers);
            console.log("Selected Leader ID:", selectedLeader);
            
            // Redraw the table if needed
            v_list_of_techsavail_multiple.draw();
        }
        
        // Change button to Update mode
        $("#btn_team_add").hide();
        $("#team_edit").show();
    });

    $('#list_team').on('click', '.name_Active', function(e) {
        e.preventDefault();
        
        const team_reference = $(this).data('id');
        const customer_id = $(this).data('emid');
        const row = $(this).closest('tr');
        const table = $('#list_team').DataTable();
        const rowData = table.row(row).data();
        const status = rowData.status;
    
        console.log("teamRef:", team_reference);
        console.log("empRef:", customer_id);
        console.log("Status:", status);
    
        if (status === 'Active') {
            swal("Warning", "You can't change it; it's already Active", "warning");
            return;
        }
        
        $.ajax({
            type: "POST",
            url: "../controller/ticket/team_controller.php",
            data: {
                action: 'active_status',
                customer_id: customer_id,
                team_reference: team_reference
            },
            success: function(response) {
                swal("Success", "Team status updated to Active!", "success");
                load_team();
            },
            error: function(xhr) {
                swal("Request failed", xhr.responseText, "error");
            }
        });
    });

    $('#list_team').on('click', '.name_Deactive', function(e) {
        e.preventDefault();
        
        const team_reference = $(this).data('id');
        const customer_id = $(this).data('emid');
        const row = $(this).closest('tr');
        const table = $('#list_team').DataTable();
        const rowData = table.row(row).data();
        const status = rowData.status;
    
        console.log("teamRef:", team_reference);
        console.log("empRef:", customer_id);
        console.log("Status:", status);
    
        if (status === 'Deactive') {
            swal("Warning", "You can't change it; it's already Deactive", "warning");
            return;
        }
        
        $.ajax({
            type: "POST",
            url: "../controller/ticket/team_controller.php",
            data: {
                action: 'deactive_status',
                customer_id: customer_id,
                team_reference: team_reference
            },
            success: function(response) {
                swal("Success", "Team status updated to Deactive!", "success");
                load_team();
            },
            error: function(xhr) {
                swal("Request failed", xhr.responseText, "error");
            }
        });
    });
    // Global array to store selected team members
    var selectedTeamMembers = [];
    var selectedLeader = null;
    
    function load_data_to_grid_available_technicians_multiple() {
        if ($.fn.DataTable.isDataTable('#tbl_techs_schedule_ticket_multiple')) {
            $('#tbl_techs_schedule_ticket_multiple').DataTable().destroy();
        }
        
        v_list_of_techsavail_multiple = $('#tbl_techs_schedule_ticket_multiple').DataTable({
            "ajax": {
                'type': 'POST',
                'url': '../controller/ticket/team_controller.php',
                'data': {
                    action: 'list_avail_tech_in_schedule_ticket'
                }
            },
            "language": {
                "zeroRecords": "No records available",
                "infoEmpty": "No records available",
            },
            "order": [[0, "asc"]],
            "paginate": true,
            "bLengthChange": true,
            "bFilter": true,
            "bInfo": true,
            "autoWidth": false,
            "columns": [
                { 
                    "data": "employee_code",
                    render: function (data, type, rows, meta) {
                        str_active_status = data + ' - ' + rows['employee_name'];
                        return str_active_status;
                    },
                },
                { 
                    "data": "employee_id",
                    "width": "100px",
                    render: function (data, type, rows, meta) {
                        // Check if this employee is in our selectedTeamMembers array
                        var isSelected = selectedTeamMembers.includes(rows["employee_id"]);
                        // Check if this is the selected leader
                        var isLeader = selectedLeader === rows["employee_id"];
                        
                        return `<div class="text-center" style="display:flex; justify-content:center; align-items:center;">
                                    <input type="checkbox" class="leader-checkbox" id="${rows["employee_id"]}" ${isLeader ? 'checked' : ''} style="transform:scale(1.2); cursor:pointer;">
                                </div>`;
                    }   
                }
            ],
            pageLength: 10,
            searching: true,
            responsive: true,
            "aoColumnDefs": [],
            "createdRow": function(row, data, dataIndex) {
                // Add 'selected' class if this row is in our selectedTeamMembers array
                if (selectedTeamMembers.includes(data.employee_id)) {
                    $(row).addClass('selected');
                }
                // Add 'leader-selected' class if this is the leader
                if (selectedLeader === data.employee_id) {
                    $(row).addClass('leader-selected');
                }
            }
        });  
    }
    
    // Row click handler for selecting team members
    $('#tbl_techs_schedule_ticket_multiple tbody').on('click', 'tr', function(e) {
        // Don't toggle selection if checkbox was clicked
        if ($(e.target).is('input[type="checkbox"]')) {
            return;
        }
        
        var rowData = v_list_of_techsavail_multiple.row(this).data();
        if (!rowData) return;
        
        var employeeId = rowData.employee_id;
        var $row = $(this);
        
        if ($row.hasClass('selected')) {
            // Remove from selected array
            selectedTeamMembers = selectedTeamMembers.filter(id => id !== employeeId);
            $row.removeClass('selected');
            
            // If this was the leader, clear leader selection
            if (selectedLeader === employeeId) {
                selectedLeader = null;
                $row.removeClass('leader-selected');
                $row.find('.leader-checkbox').prop('checked', false);
            }
        } else {
            // Add to selected array
            if (!selectedTeamMembers.includes(employeeId)) {
                selectedTeamMembers.push(employeeId);
            }
            $row.addClass('selected');
        }
    });
    
    // Checkbox click handler for selecting leader
    $("#tbl_techs_schedule_ticket_multiple tbody").on('change', "input[type='checkbox'].leader-checkbox", function(e) {
        var employeeId = $(this).attr('id');
        var $row = $(this).closest('tr');
        
        if ($(this).is(':checked')) {
            // Set as leader
            selectedLeader = employeeId;
            
            // Make sure this employee is in the team members list
            if (!selectedTeamMembers.includes(employeeId)) {
                selectedTeamMembers.push(employeeId);
                $row.addClass('selected');
            }
            
            // Update UI
            $('#tbl_techs_schedule_ticket_multiple tr').removeClass('leader-selected');
            $row.addClass('leader-selected');
        } else {
            // Unset leader
            if (selectedLeader === employeeId) {
                selectedLeader = null;
                $row.removeClass('leader-selected');
            }
        }
        
        // Uncheck all other checkboxes
        $('#tbl_techs_schedule_ticket_multiple input.leader-checkbox').not(this).prop('checked', false);
    });
    
    $("#team_edit").click(function() {
       // Get customer ID from select2 dropdown
        var customer_id = $("#select_customer_for_customer_location").val();
        var hiddenids = $("#hidden_ids").val();
        // Get team reference from textarea
        var team_reference = $("#team_reference").val();
        
        // Validation
        if (!customer_id || customer_id === 'select') {
            swal("Warning","Please select a customer", "warning");
            return;
        }
        
        if (!team_reference || team_reference.trim() === '') {
            swal("Warning","Please enter a team reference", "warning");
            return;
        }
        
        if (selectedTeamMembers.length === 0) {
            swal("Warning","Please select at least one team member", "warning");
            return;
        }
        
        if (!selectedLeader) {
            swal("Warning","Please select a leader", "warning");
            return;
        }
        
        // Verify leader is part of the team
        if (!selectedTeamMembers.includes(selectedLeader)) {
            swal("Warning","The leader must be part of the team members", "warning");
            return;
        }
        
        var l = Ladda.create(this);
        l.start();
        
        $.ajax({
            type: "POST",
            url: "../controller/ticket/team_controller.php",
            data: {
                action: 'update_team',
                customer_id: customer_id,
                team_reference: team_reference,
                team_members: selectedTeamMembers,
                leader_id: selectedLeader,
                hiddenids:hiddenids
            },
            dataType: "json"
        }).done(function(response) {
            if (response.status === 'success') {
                swal("Success","Team Updated successfully!", "success");
                // Reset form
                $("#team_reference").val('');
                $('#select_customer_for_customer_location').val('select').trigger('change');
                selectedTeamMembers = [];
                selectedLeader = null;
                // Change button to Update mode
                $("#btn_team_add").show();
                $("#team_edit").hide();
                // Refresh the DataTable to clear selections
                v_list_of_techsavail_multiple.ajax.reload();
                
                load_team();
            } else {
                swal("Error",response.message, "error");
            }
        }).fail(function(xhr) {
            swal("Request failed:",xhr.responseText, "error");
        }).always(function() {
            l.stop();
        });
    });
    
    $("#btn_team_add").click(function() {
        // Get customer ID from select2 dropdown
        var customer_id = $("#select_customer_for_customer_location").val();
        
        // Get team reference from textarea
        var team_reference = $("#team_reference").val();
        
        // Validation
        if (!customer_id || customer_id === 'select') {
            swal("Warning","Please select a customer", "warning");
            return;
        }
        
        if (!team_reference || team_reference.trim() === '') {
            swal("Warning","Please enter a team reference", "warning");
            return;
        }
        
        if (selectedTeamMembers.length === 0) {
            swal("Warning","Please select at least one team member", "warning");
            return;
        }
        
        if (!selectedLeader) {
            swal("Warning","Please select a leader", "warning");
            return;
        }
        
        // Verify leader is part of the team
        if (!selectedTeamMembers.includes(selectedLeader)) {
            swal("Warning","The leader must be part of the team members", "warning");
            return;
        }
        
        var l = Ladda.create(this);
        l.start();
        
        $.ajax({
            type: "POST",
            url: "../controller/ticket/team_controller.php",
            data: {
                action: 'add_team',
                customer_id: customer_id,
                team_reference: team_reference,
                team_members: selectedTeamMembers,
                leader_id: selectedLeader
            },
            dataType: "json"
        }).done(function(response) {
            if (response.status === 'success') {
                swal("Success","Team saved successfully!", "success");
                // Reset form
                $("#team_reference").val('');
                $('#select_customer_for_customer_location').val('select').trigger('change');
                selectedTeamMembers = [];
                selectedLeader = null;
                
                // Refresh the DataTable to clear selections
                v_list_of_techsavail_multiple.ajax.reload();
                
                load_team();
            } else {
                swal("Error",response.message, "error");
            }
        }).fail(function(xhr) {
            swal("Request failed:",xhr.responseText, "error");
        }).always(function() {
            l.stop();
        });
    });
});