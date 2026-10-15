$(document).ready(function() {
    
    // Initialize Plugins
    $('.select2').select2();

    // Helper functions for slots
    function escapeHtml(text) {
        if (!text) return '';
        return String(text).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
    }

    // Convert HH:mm 24-hour time to formatted 12-hour AM/PM string
    function formatTime12H(timeStr) {
        if (!timeStr || timeStr === '0' || timeStr.trim() === '') return '';
        var parts = timeStr.trim().split(':');
        if (parts.length < 2) return timeStr;
        var hours = parseInt(parts[0], 10);
        var mins = parseInt(parts[1], 10);
        if (isNaN(hours) || isNaN(mins)) return timeStr;
        var ampm = hours >= 12 ? 'PM' : 'AM';
        var h12 = hours % 12;
        h12 = h12 ? h12 : 12;
        var hStr = (h12 < 10 ? '0' : '') + h12;
        var mStr = (mins < 10 ? '0' : '') + mins;
        return hStr + ':' + mStr + ' ' + ampm;
    }

    // Normalize time to standard 24h 'HH:mm' or empty string if 0/blank
    function normalizeTime24H(timeStr) {
        if (!timeStr || timeStr === '0' || timeStr.trim() === '') return '';
        var parts = timeStr.trim().split(':');
        if (parts.length >= 2) {
            var h = parseInt(parts[0], 10);
            var m = parseInt(parts[1], 10);
            if (!isNaN(h) && !isNaN(m)) {
                return (h < 10 ? '0' : '') + h + ':' + (m < 10 ? '0' : '') + m;
            }
        }
        return timeStr.trim();
    }

    function getRuleBadgeHtml(startTime, endTime) {
        var s = normalizeTime24H(startTime);
        var e = normalizeTime24H(endTime);
        var hasRule = (s !== '' && s !== '0' && e !== '' && e !== '0');
        if (hasRule) {
            if (e <= s) {
                return '<span class="badge badge-danger shadow-sm" style="font-size: 11px; padding: 4px 8px;" title="Invalid: End time must be greater than Start time">' +
                       '<i class="icon-warning22 mr-1 font-size-xs"></i> Invalid: End &le; Start</span>';
            }
            var s12 = formatTime12H(s);
            var e12 = formatTime12H(e);
            return '<span class="badge badge-info shadow-sm" style="font-size: 11px; padding: 4px 8px;" title="24-hour: ' + escapeHtml(s) + ' - ' + escapeHtml(e) + '">' +
                   '<i class="icon-alarm mr-1 font-size-xs"></i> ' + escapeHtml(s12) + ' - ' + escapeHtml(e12) + '</span>';
        } else {
            return '<span class="badge badge-secondary shadow-sm" style="font-size: 11px; padding: 4px 8px;">' +
                   '<i class="icon-unlocked2 mr-1 font-size-xs"></i> Anytime (No Rule)</span>';
        }
    }

    function addSlotRow(name, startTime, endTime) {
        name = (name !== undefined && name !== null) ? name : '';
        var sNorm = normalizeTime24H(startTime);
        var eNorm = normalizeTime24H(endTime);

        var rowIdx = $('#slots_container .slot-row').length + 1;
        var s12 = sNorm ? formatTime12H(sNorm) : '';
        var e12 = eNorm ? formatTime12H(eNorm) : '';
        var isInvalidOrder = (sNorm && eNorm && sNorm !== '0' && eNorm !== '0' && eNorm <= sNorm);

        var rowHtml = 
            '<tr class="slot-row">' +
                '<td class="text-center font-weight-bold slot-number align-middle">' + rowIdx + '</td>' +
                '<td>' +
                    '<input type="text" class="form-control form-control-sm slot-name" placeholder="e.g. Morning, Slot ' + rowIdx + '" value="' + escapeHtml(name) + '" required>' +
                '</td>' +
                '<td>' +
                    '<div class="input-group input-group-sm">' +
                        '<input type="time" class="form-control slot-start-time" value="' + escapeHtml(sNorm) + '" title="Select Start Time">' +
                        '<div class="input-group-append">' +
                            '<button type="button" class="btn btn-outline-secondary btn-set-zero" data-target="start" title="Clear / Set to Anytime (0)"><i class="icon-reset font-size-xs mr-1"></i> Anytime</button>' +
                        '</div>' +
                    '</div>' +
                    '<div class="d-flex align-items-center mt-1 slot-start-preview" style="font-size: 10.5px;">' +
                        (sNorm ? '<span class="text-primary font-weight-semibold"><i class="icon-watch2 mr-1"></i>' + escapeHtml(s12) + '</span>' : '<span class="text-muted"><i class="icon-unlocked2 mr-1"></i>Anytime</span>') +
                    '</div>' +
                '</td>' +
                '<td>' +
                    '<div class="input-group input-group-sm">' +
                        '<input type="time" class="form-control slot-end-time' + (isInvalidOrder ? ' border-danger text-danger' : '') + '" value="' + escapeHtml(eNorm) + '" title="Select End Time">' +
                        '<div class="input-group-append">' +
                            '<button type="button" class="btn btn-outline-secondary btn-set-zero" data-target="end" title="Clear / Set to Anytime (0)"><i class="icon-reset font-size-xs mr-1"></i> Anytime</button>' +
                        '</div>' +
                    '</div>' +
                    '<div class="d-flex align-items-center mt-1 slot-end-preview" style="font-size: 10.5px;">' +
                        (eNorm ? '<span class="text-primary font-weight-semibold"><i class="icon-watch2 mr-1"></i>' + escapeHtml(e12) + '</span>' : '<span class="text-muted"><i class="icon-unlocked2 mr-1"></i>Anytime</span>') +
                        (isInvalidOrder ? '<span class="text-danger font-weight-semibold ml-2" style="font-size: 10px;"><i class="icon-warning22 mr-1"></i>End must be &gt; Start</span>' : '') +
                    '</div>' +
                '</td>' +
                '<td class="text-center align-middle slot-badge-cell">' +
                    getRuleBadgeHtml(sNorm, eNorm) +
                '</td>' +
                '<td class="text-center align-middle">' +
                    '<button type="button" class="btn btn-sm btn-outline-danger btn-remove-slot p-1" title="Remove Slot"><i class="icon-trash font-size-sm"></i></button>' +
                '</td>' +
            '</tr>';

        $('#slots_container').append(rowHtml);
        renumberSlotRows();
    }

    function renumberSlotRows() {
        $('#slots_container .slot-row').each(function(idx) {
            $(this).find('.slot-number').text(idx + 1);
        });
    }

    // Initialize with 1 default slot row
    addSlotRow('Slot 1', '0', '0');

    // Slot event listeners
    $('#btn_add_slot').click(function() {
        var nextIdx = $('#slots_container .slot-row').length + 1;
        addSlotRow('Slot ' + nextIdx, '0', '0');
    });

    $(document).on('click', '.btn-remove-slot', function() {
        if ($('#slots_container .slot-row').length <= 1) {
            swal("Notice", "At least one service slot is required.", "info");
            return;
        }
        $(this).closest('tr').remove();
        renumberSlotRows();
    });

    $(document).on('input change', '.slot-start-time, .slot-end-time', function() {
        var $tr = $(this).closest('tr');
        var s = normalizeTime24H($tr.find('.slot-start-time').val());
        var e = normalizeTime24H($tr.find('.slot-end-time').val());

        var s12 = s ? formatTime12H(s) : '';
        var e12 = e ? formatTime12H(e) : '';

        var isInvalidOrder = (s && e && s !== '0' && e !== '0' && e <= s);

        $tr.find('.slot-start-preview').html(s ? '<span class="text-primary font-weight-semibold"><i class="icon-watch2 mr-1"></i>' + escapeHtml(s12) + '</span>' : '<span class="text-muted"><i class="icon-unlocked2 mr-1"></i>Anytime</span>');
        
        var endPreviewHtml = e ? '<span class="text-primary font-weight-semibold"><i class="icon-watch2 mr-1"></i>' + escapeHtml(e12) + '</span>' : '<span class="text-muted"><i class="icon-unlocked2 mr-1"></i>Anytime</span>';
        if (isInvalidOrder) {
            endPreviewHtml += '<span class="text-danger font-weight-semibold ml-2" style="font-size: 10px;"><i class="icon-warning22 mr-1"></i>End must be &gt; Start</span>';
            $tr.find('.slot-end-time').addClass('border-danger text-danger');
        } else {
            $tr.find('.slot-end-time').removeClass('border-danger text-danger');
        }
        $tr.find('.slot-end-preview').html(endPreviewHtml);

        $tr.find('.slot-badge-cell').html(getRuleBadgeHtml(s, e));
    });

    $(document).on('click', '.btn-set-zero', function() {
        var target = $(this).data('target');
        var $tr = $(this).closest('tr');
        if (target === 'start') {
            $tr.find('.slot-start-time').val('').trigger('change');
        } else {
            $tr.find('.slot-end-time').val('').trigger('change');
        }
    });

    // Initialize DataTable
    var tblAssignments = $('#tblAssignments').DataTable({
        "processing": true,
        "ajax": {
            "url": "../controller/janitor/assignment_controller.php",
            "type": "POST",
            "data": function(d) {
                d.action = "list_assignments";
            },
            "dataSrc": "data"
        },
        "columnDefs": [
            { "defaultContent": "", "targets": "_all" }
        ],
        "columns": [
            { "data": "assignment_ref_no", "defaultContent": "" },
            { "data": "employee_name", "defaultContent": "" },
            { "data": "checklist_name",
              "defaultContent": "",
              "render": function(data, type, row) {
                  if (!data) return '';
                  return '<a href="#" class="text-info font-weight-semibold btn-view-checklist-grid" data-checklist_id="'+(row.checklist_id || '')+'"><i class="icon-list mr-1 font-size-sm"></i>' + escapeHtml(data) + '</a>';
              }
            },
            { "data": "asset_ref_no", "defaultContent": "" },
            { "data": "amc_ref_no", "defaultContent": "" },
            { "data": "frequency", "defaultContent": "" },
            { "data": "start_date",
              "defaultContent": "",
              "render": function(data, type, row) {
                  if(!data && !row.end_date) return '';
                  var formatDt = function(d) {
                      if(!d) return '';
                      var dt = new Date(d);
                      return isNaN(dt.getTime()) ? d : dt.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });
                  };
                  return formatDt(row.start_date) + (row.end_date ? ' <br> ' + formatDt(row.end_date) : '');
              }
            },
            { "data": "slots",
              "defaultContent": "",
              "render": function(data, type, row) {
                  if (!data && !row.slots_detail) return '';
                  var details = [];
                  if (row.slots_detail) {
                      try { details = JSON.parse(row.slots_detail); } catch(e) {}
                  }

                  if (details && details.length > 0) {
                      return details.map(function(s) {
                          var sStart = normalizeTime24H(s.start_time);
                          var sEnd = normalizeTime24H(s.end_time);
                          var hasRule = (sStart !== '' && sStart !== '0' && sEnd !== '' && sEnd !== '0');
                          var ruleBadge = hasRule ?
                              ' <span class="badge badge-info font-weight-normal ml-1" style="font-size: 10px;" title="24-hour: ' + escapeHtml(sStart) + ' - ' + escapeHtml(sEnd) + '"><i class="icon-alarm mr-1" style="font-size: 9px;"></i>' + escapeHtml(formatTime12H(sStart)) + ' - ' + escapeHtml(formatTime12H(sEnd)) + '</span>' :
                              ' <span class="badge badge-secondary font-weight-normal ml-1" style="font-size: 10px;"><i class="icon-unlocked2 mr-1" style="font-size: 9px;"></i>Anytime</span>';
                          return '<div class="mb-1"><span class="badge badge-light badge-striped badge-striped-left border-left-info font-weight-semibold">' + escapeHtml(s.name) + '</span>' + ruleBadge + '</div>';
                      }).join('');
                  }

                  return data ? data.split(',').map(function(s) {
                      return '<span class="badge badge-light badge-striped badge-striped-left border-left-info mb-1 mr-1">' + escapeHtml(s.trim()) + '</span>';
                  }).join('') : '';
              }
            },
            { "data": "status",
              "defaultContent": "",
              "render": function(data, type, row) {
                  var badgeClass = data === 'Active' ? 'badge-success' : 'badge-danger';
                  return '<span class="badge ' + badgeClass + '">' + (data || '') + '</span>';
              }
            },
            { "data": null,
              "orderable": false,
              "defaultContent": "",
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
        
        // Validate slot rows
        var slotRows = $('#slots_container .slot-row');
        if (slotRows.length === 0) {
            swal("Validation Error", "Please configure at least one service slot.", "error");
            return;
        }

        var slotsArr = [];
        var slotNamesArr = [];
        var hasEmptyName = false;
        var mismatchedRule = false;
        var invalidTimeOrder = false;
        var invalidSlotName = '';

        slotRows.each(function(i) {
            var name = $(this).find('.slot-name').val().trim();
            var start = normalizeTime24H($(this).find('.slot-start-time').val());
            var end = normalizeTime24H($(this).find('.slot-end-time').val());

            if ((start && !end) || (!start && end)) {
                mismatchedRule = true;
            }

            if (start && end && start !== '0' && end !== '0') {
                if (end <= start) {
                    invalidTimeOrder = true;
                    if (!invalidSlotName) {
                        invalidSlotName = name || ('Slot ' + (i + 1));
                    }
                }
            }

            if (!start) start = '0';
            if (!end) end = '0';

            if (name === '') {
                hasEmptyName = true;
            } else {
                slotNamesArr.push(name);
                slotsArr.push({
                    name: name,
                    start_time: start,
                    end_time: end,
                    has_rule: (start !== '0' && start !== '' && end !== '0' && end !== '') ? 1 : 0
                });
            }
        });

        if (hasEmptyName || slotNamesArr.length === 0) {
            swal("Validation Error", "Please provide a name for each service slot.", "error");
            return;
        }

        if (mismatchedRule) {
            swal("Validation Error", "Please select both Start Time and End Time for any slot with a time rule (or click 'Anytime' on both to allow execution anytime).", "error");
            return;
        }

        if (invalidTimeOrder) {
            swal("Validation Error", "End Time must be greater than Start Time for slot: " + invalidSlotName + ". Please adjust the time window.", "error");
            return;
        }

        // Set serialized values into hidden inputs
        $('#slots_serialized').val(slotNamesArr.join(','));
        $('#slots_detail_serialized').val(JSON.stringify(slotsArr));

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
                        resetForm();
                        if (tblAssignments) {
                            tblAssignments.ajax.reload(null, false);
                        }
                        swal("Success", res.message, "success").then(function() {
                            if (tblAssignments) {
                                tblAssignments.ajax.reload(null, false);
                            }
                        });
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
        $('#employee_id').val('').trigger('change');
        $('#checklist_id').val('').trigger('change');
        $('#frequency').val('Daily').trigger('change');
        
        $('#slots_container').empty();
        addSlotRow('Slot 1', '0', '0');
        
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
                    
                    // Single Janitor selection
                    $('#employee_id').val(d.employee_id).trigger('change');
                    
                    $('#checklist_id').val(d.checklist_id).trigger('change');
                    $('#frequency').val(d.frequency).trigger('change');
                    
                    // Populate Slots Area
                    $('#slots_container').empty();
                    var loadedSlots = [];
                    if (d.slots_detail) {
                        try {
                            loadedSlots = JSON.parse(d.slots_detail);
                        } catch(e) {
                            loadedSlots = [];
                        }
                    }

                    if (!Array.isArray(loadedSlots) || loadedSlots.length === 0) {
                        if (d.slots) {
                            var names = d.slots.split(',');
                            names.forEach(function(nm) {
                                if (nm.trim()) {
                                    loadedSlots.push({
                                        name: nm.trim(),
                                        start_time: '0',
                                        end_time: '0'
                                    });
                                }
                            });
                        }
                    }

                    if (loadedSlots.length === 0) {
                        addSlotRow('Slot 1', '0', '0');
                    } else {
                        loadedSlots.forEach(function(s) {
                            addSlotRow(s.name, s.start_time || '0', s.end_time || '0');
                        });
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
                        if (tblAssignments) {
                            tblAssignments.ajax.reload(null, false);
                        }
                        swal("Updated!", "Assignment status has been updated.", "success");
                    },
                    error: function() {
                        swal("Error", "Failed to update status", "error");
                    }
                });
            }
        });
    });

});
