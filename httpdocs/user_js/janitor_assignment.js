$(document).ready(function() {
    
    // Initialize Plugins
    $('.select2').select2();
    $('#slots').tagsinput();

    // Initialize DataTable
    var tblAssignments = $('#tblAssignments').DataTable({
        "ajax": {
            "url": "../controller/janitor/assignment_controller.php",
            "type": "POST",
            "data": { action: "list_assignments" }
        },
        "columns": [
            { "data": "assignment_ref_no" },
            { "data": "employee_name" },
            { "data": "checklist_name",
              "render": function(data, type, row) {
                  return '<a href="#" class="text-info font-weight-semibold btn-view-checklist-grid" data-checklist_id="'+row.checklist_id+'"><i class="icon-list mr-1 font-size-sm"></i>' + data + '</a>';
              }
            },
            { "data": "asset_ref_no" },
            { "data": "amc_ref_no" },
            { "data": "frequency" },
            { "data": "start_date",
              "render": function(data, type, row) {
                  if(!data) return '';
                  var formatDt = function(d) {
                      if(!d) return '';
                      var dt = new Date(d);
                      return dt.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });
                  };
                  return formatDt(row.start_date) + ' <br> ' + formatDt(row.end_date);
              }
            },
            { "data": "slots",
              "render": function(data, type, row) {
                  if(!data) return '';
                  var badges = data.split(',').map(function(s) {
                      return '<span class="badge badge-light badge-striped badge-striped-left border-left-info mb-1 mr-1">' + s.trim() + '</span>';
                  }).join('');
                  return badges;
              }
            },
            { "data": "status",
              "render": function(data, type, row) {
                  var badgeClass = data === 'Active' ? 'badge-success' : 'badge-danger';
                  return '<span class="badge ' + badgeClass + '">' + data + '</span>';
              }
            },
            { "data": null,
              "orderable": false,
              "render": function(data, type, row) {
                  var stBtn = row.status === 'Active' ? 
                      '<button class="btn btn-danger btn-status" style="padding: 1px 5px; font-size: 10px; line-height: 1.5; border-radius: 2px;" data-id="'+row.id+'" data-status="Inactive"><i class="icon-cross2 font-size-sm"></i> Disable</button>' : 
                      '<button class="btn btn-success btn-status" style="padding: 1px 5px; font-size: 10px; line-height: 1.5; border-radius: 2px;" data-id="'+row.id+'" data-status="Active"><i class="icon-checkmark3 font-size-sm"></i> Enable</button>';
                  
                  return '<div class="list-icons">' +
                            '<button type="button" class="btn btn-primary btn-edit" style="padding: 1px 5px; font-size: 10px; line-height: 1.5; border-radius: 2px;" data-id="'+row.id+'"><i class="icon-pencil font-size-sm"></i> Edit</button> &nbsp;' +
                            stBtn +
                         '</div>';
              }
            }
        ]
    });

    // Load initial dropdowns
    function loadInitialDropdowns() {
        $.ajax({
            url: "../controller/janitor/assignment_controller.php",
            type: "POST",
            data: { action: "get_dropdown_data" },
            success: function(response) {
                var res = JSON.parse(response);
                
                $('#customer_id').empty().append('<option value="">-Select Customer-</option>');
                res.customers.forEach(function(c) {
                    $('#customer_id').append('<option value="'+c.customer_id+'">'+c.customer_name+' ('+c.customer_code+')</option>');
                });

                $('#employee_id').empty().append('<option value="">-Select Janitor-</option>');
                res.janitors.forEach(function(j) {
                    $('#employee_id').append('<option value="'+j.employee_id+'">'+j.employee_name+' ('+j.employee_code+')</option>');
                });

                $('#checklist_id').empty().append('<option value="">-Select Checklist-</option>');
                res.checklists.forEach(function(c) {
                    $('#checklist_id').append('<option value="'+c.id+'">'+c.checklist_name+'</option>');
                });
            }
        });
    }

    loadInitialDropdowns();

    // Cascading: Customer -> Locations & AMCs
    $('#customer_id').change(function() {
        var customer_id = $(this).val();
        
        // Reset dependents
        $('#location_id').empty().append('<option value="">-Select Location-</option>');
        $('#building_id').empty().append('<option value="">-Select Building-</option>');
        $('#asset_id').empty().append('<option value="">-Select Asset-</option>');
        $('#amc_ref_no').empty().append('<option value="">-Select AMC-</option>');

        if(customer_id) {
            // Get Locations
            $.ajax({
                url: "../controller/janitor/assignment_controller.php",
                type: "POST",
                data: { action: "get_locations", customer_id: customer_id },
                success: function(response) {
                    var res = JSON.parse(response);
                    res.locations.forEach(function(l) {
                        $('#location_id').append('<option value="'+l.location_id+'">'+l.location_name+'</option>');
                    });
                }
            });

            // Get AMCs
            $.ajax({
                url: "../controller/janitor/assignment_controller.php",
                type: "POST",
                data: { action: "get_amcs", customer_id: customer_id },
                success: function(response) {
                    var res = JSON.parse(response);
                    res.amcs.forEach(function(a) {
                        $('#amc_ref_no').append('<option value="'+a.amc_ref_no+'">'+a.amc_ref_no+'</option>');
                    });
                }
            });
        }
    });

    // Cascading: Location -> Buildings
    $('#location_id').change(function() {
        var customer_id = $('#customer_id').val();
        var location_id = $(this).val();
        
        // Reset dependents
        $('#building_id').empty().append('<option value="">-Select Building-</option>');
        $('#asset_id').empty().append('<option value="">-Select Asset-</option>');

        if(customer_id && location_id) {
            $.ajax({
                url: "../controller/janitor/assignment_controller.php",
                type: "POST",
                data: { action: "get_buildings", customer_id: customer_id, location_id: location_id },
                success: function(response) {
                    var res = JSON.parse(response);
                    res.buildings.forEach(function(b) {
                        $('#building_id').append('<option value="'+b.building_id+'">'+b.building_name+'</option>');
                    });
                }
            });
        }
    });

    // Cascading: Building -> Assets
    $('#building_id').change(function() {
        var customer_id = $('#customer_id').val();
        var location_id = $('#location_id').val();
        var building_id = $(this).val();
        
        $('#asset_id').empty().append('<option value="">-Select Asset-</option>');

        if(customer_id && location_id && building_id) {
            $.ajax({
                url: "../controller/janitor/assignment_controller.php",
                type: "POST",
                data: { action: "get_assets", customer_id: customer_id, location_id: location_id, building_id: building_id },
                success: function(response) {
                    var res = JSON.parse(response);
                    res.assets.forEach(function(a) {
                        $('#asset_id').append('<option value="'+a.asset_id+'">'+a.asset_ref_no+'</option>');
                    });
                }
            });
        }
    });

    // Fetch AMC details on AMC select
    $('#amc_ref_no').change(function() {
        var amc = $(this).val();
        if(amc) {
            $.ajax({
                url: "../controller/janitor/assignment_controller.php",
                type: "POST",
                data: { action: "get_amc_details", amc_ref_no: amc },
                success: function(response) {
                    var res = JSON.parse(response);
                    if(res.data) {
                        $('#lbl_amc_ref').text(res.data.amc_ref_no);
                        $('#lbl_amc_status').text(res.data.amc_status);
                        $('#lbl_amc_type').text(res.data.contract_type_name);
                        
                        var formatDt = function(d) {
                            if(!d) return '';
                            var dt = new Date(d);
                            return dt.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });
                        };
                        
                        $('#lbl_amc_dates').text(formatDt(res.data.amc_start_date) + ' - ' + formatDt(res.data.amc_end_date));
                        $('#amc_details_card').removeClass('d-none');
                        
                        // Auto-fill form dates if empty or user wants to overwrite
                        $('#start_date').val(res.data.amc_start_date);
                        $('#end_date').val(res.data.amc_end_date);
                    }
                }
            });
        } else {
            $('#amc_details_card').addClass('d-none');
        }
    });

    // Fetch Asset details on Asset select
    $('#asset_id').change(function() {
        var ast = $(this).val();
        if(ast) {
            $.ajax({
                url: "../controller/janitor/assignment_controller.php",
                type: "POST",
                data: { action: "get_asset_details", asset_id: ast },
                success: function(response) {
                    var res = JSON.parse(response);
                    if(res.data) {
                        $('#lbl_asset_ref').text(res.data.asset_ref_no);
                        $('#lbl_asset_status').text(res.data.asset_status);
                        $('#lbl_asset_cat').text(res.data.asset_category_name || 'N/A');
                        $('#lbl_asset_type').text(res.data.asset_type_name || 'N/A');
                        
                        if(res.data.asset_description && res.data.asset_description.trim() !== '') {
                            $('#lbl_asset_desc').text(res.data.asset_description);
                            $('#lbl_asset_desc_container').removeClass('d-none');
                        } else {
                            $('#lbl_asset_desc_container').addClass('d-none');
                        }
                        
                        $('#asset_details_card').removeClass('d-none');
                    }
                }
            });
        } else {
            $('#asset_details_card').addClass('d-none');
        }
    });

    // Fetch Checklist details on Checklist select
    $('#checklist_id').change(function() {
        var chk = $(this).val();
        if(chk) {
            $.ajax({
                url: "../controller/janitor/assignment_controller.php",
                type: "POST",
                data: { action: "get_checklist_details", checklist_id: chk },
                success: function(response) {
                    var res = JSON.parse(response);
                    if(res.data) {
                        $('#lbl_chk_name').text(res.data.checklist_name);
                        $('#lbl_chk_status').text(res.data.status);
                        $('#lbl_chk_stats').text(res.data.category_count + ' Categories, ' + res.data.point_count + ' Points');
                        $('#checklist_details_card').removeClass('d-none');
                    }
                }
            });
        } else {
            $('#checklist_details_card').addClass('d-none');
        }
    });

    // View Checklist Details Modal
    $(document).on('click', '#btn_view_checklist, .btn-view-checklist-grid', function(e) {
        e.preventDefault();
        var chk_id = $(this).data('checklist_id') || $('#checklist_id').val();
        if (!chk_id) return;
        
        $('#div_checklist_details_body').html('<div class="text-center p-3"><i class="icon-spinner2 spinner"></i> Loading...</div>');
        $('#modal_view_points').modal('show');
        
        $.ajax({
            url: '../controller/janitor/checklist_controller.php',
            type: 'POST',
            data: { action: 'get_checklist', checklist_id: chk_id },
            success: function(response) {
                var res = JSON.parse(response);
                var html = '';
                
                if (res.categories && res.categories.length > 0) {
                    res.categories.forEach(function(cat) {
                        html += '<div class="mb-3">';
                        html += '<h6 class="font-weight-semibold text-primary border-bottom pb-1 mb-2"><i class="icon-folder mr-2"></i>' + cat.category_name + '</h6>';
                        html += '<ul class="list-unstyled pl-3">';
                        if (cat.points && cat.points.length > 0) {
                            cat.points.forEach(function(pt) {
                                html += '<li class="mb-1"><i class="icon-checkmark3 mr-2 text-success" style="font-size:11px;"></i>' + pt.item_description + '</li>';
                            });
                        } else {
                            html += '<li class="text-muted">No points defined.</li>';
                        }
                        html += '</ul></div>';
                    });
                } else {
                    html = '<p class="text-muted">No categories defined for this checklist.</p>';
                }
                
                $('#modal_view_points .modal-title').text(res.checklist ? res.checklist.checklist_name : 'Checklist Details');
                $('#div_checklist_details_body').html(html);
            }
        });
    });

    // Save Assignment
    $('#frmAssignment').on('submit', function(e) {
        e.preventDefault();
        
        var l = Ladda.create(document.querySelector('#btnSaveAssignment'));
        l.start();

        $.ajax({
            url: "../controller/janitor/assignment_controller.php",
            type: "POST",
            data: $(this).serialize(),
            success: function(response) {
                l.stop();
                try {
                    var res = JSON.parse(response);
                    if (res.status === 'success') {
                        swal("Success", res.message, "success");
                        resetForm();
                        tblAssignments.ajax.reload();
                    } else {
                        swal("Error", res.message, "error");
                    }
                } catch(e) {
                    swal("Error", "Invalid response from server", "error");
                }
            },
            error: function() {
                l.stop();
                swal("Error", "Something went wrong!", "error");
            }
        });
    });

    // Reset
    $('#btnReset').click(function() {
        resetForm();
    });

    function resetForm() {
        $('#frmAssignment')[0].reset();
        $('#assignment_id').val('0');
        
        $('#customer_id').val('').trigger('change');
        $('#employee_id').val(null).trigger('change');
        $('#checklist_id').val('').trigger('change');
        $('#frequency').val('Daily').trigger('change');
        $('#slots').tagsinput('removeAll');
        
        $('#amc_details_card').addClass('d-none');
        $('#asset_details_card').addClass('d-none');
        $('#checklist_details_card').addClass('d-none');
    }

    // Edit
    $(document).on('click', '.btn-edit', function() {
        var id = $(this).data('id');
        $.ajax({
            url: "../controller/janitor/assignment_controller.php",
            type: "POST",
            data: { action: "get_assignment", assignment_id: id },
            success: function(response) {
                try {
                    var res = JSON.parse(response);
                    var d = res.data;
                    
                    $('#assignment_id').val(d.id);
                    
                    var empArr = d.employee_id ? d.employee_id.split(',') : [];
                    $('#employee_id').val(empArr).trigger('change');
                    
                    $('#checklist_id').val(d.checklist_id).trigger('change');
                    $('#frequency').val(d.frequency).trigger('change');
                    
                    $('#slots').tagsinput('removeAll');
                    if(d.slots) {
                        $('#slots').tagsinput('add', d.slots);
                    }
                    $('#start_date').val(d.start_date);
                    $('#end_date').val(d.end_date);

                    // Sequential Loading to handle cascades properly
                    if(d.customer_id) {
                        $('#customer_id').val(d.customer_id).trigger('change.select2'); // update select2 visually

                        // Fetch locations & AMCs
                        $.when(
                            $.ajax({ url: "../controller/janitor/assignment_controller.php", type: "POST", data: { action: "get_locations", customer_id: d.customer_id } }),
                            $.ajax({ url: "../controller/janitor/assignment_controller.php", type: "POST", data: { action: "get_amcs", customer_id: d.customer_id } })
                        ).done(function(locReq, amcReq) {
                            var locRes = JSON.parse(locReq[0]);
                            var amcRes = JSON.parse(amcReq[0]);

                            $('#location_id').empty().append('<option value="">-Select Location-</option>');
                            locRes.locations.forEach(function(l) { $('#location_id').append('<option value="'+l.location_id+'">'+l.location_name+'</option>'); });

                            $('#amc_ref_no').empty().append('<option value="">-Select AMC-</option>');
                            amcRes.amcs.forEach(function(a) { $('#amc_ref_no').append('<option value="'+a.amc_ref_no+'">'+a.amc_ref_no+'</option>'); });

                            $('#amc_ref_no').val(d.amc_ref_no).trigger('change.select2');

                            if(d.location_id) {
                                $('#location_id').val(d.location_id).trigger('change.select2');

                                // Fetch Buildings
                                $.ajax({
                                    url: "../controller/janitor/assignment_controller.php", type: "POST",
                                    data: { action: "get_buildings", customer_id: d.customer_id, location_id: d.location_id },
                                    success: function(bldResStr) {
                                        var bldRes = JSON.parse(bldResStr);
                                        $('#building_id').empty().append('<option value="">-Select Building-</option>');
                                        bldRes.buildings.forEach(function(b) { $('#building_id').append('<option value="'+b.building_id+'">'+b.building_name+'</option>'); });
                                        
                                        if(d.building_id) {
                                            $('#building_id').val(d.building_id).trigger('change.select2');

                                            // Fetch Assets
                                            $.ajax({
                                                url: "../controller/janitor/assignment_controller.php", type: "POST",
                                                data: { action: "get_assets", customer_id: d.customer_id, location_id: d.location_id, building_id: d.building_id },
                                                success: function(astResStr) {
                                                    var astRes = JSON.parse(astResStr);
                                                    $('#asset_id').empty().append('<option value="">-Select Asset-</option>');
                                                    astRes.assets.forEach(function(a) { $('#asset_id').append('<option value="'+a.asset_id+'">'+a.asset_ref_no+'</option>'); });
                                                    
                                                    $('#asset_id').val(d.asset_id).trigger('change.select2');
                                                }
                                            });
                                        }
                                    }
                                });
                            }
                        });
                    }

                    window.scrollTo(0, 0);
                } catch(e) { }
            }
        });
    });

    // Change Status
    $(document).on('click', '.btn-status', function() {
        var id = $(this).data('id');
        var status = $(this).data('status');
        
        swal({
            title: "Are you sure?",
            text: "You want to " + (status==='Active'?'Enable':'Disable') + " this assignment!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willChange) => {
            if (willChange) {
                $.ajax({
                    url: "../controller/janitor/assignment_controller.php",
                    type: "POST",
                    data: { action: "change_status", assignment_id: id, status: status },
                    success: function(response) {
                        tblAssignments.ajax.reload();
                    }
                });
            }
        });
    });

});
