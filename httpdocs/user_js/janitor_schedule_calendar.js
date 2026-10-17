/**
 * Janitor Schedule & Slot Status Calendar
 * Total Home Care (THC) Facilities Management System
 */

var JanitorCalendarApp = (function() {
    var calendar = null;
    var currentJanitorId = null;

    // Initialize Select2 and load Janitors
    function initJanitorDropdown() {
        $('#select_janitor').select2({
            placeholder: 'Select a Janitor...',
            allowClear: false,
            width: '100%'
        });

        // Fetch janitors list from backend
        $.ajax({
            url: '../controller/janitor/calendar_controller.php',
            type: 'GET',
            data: { action: 'get_janitors' },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success' && response.data && response.data.length > 0) {
                    var dropdown = $('#select_janitor');
                    dropdown.empty();

                    $.each(response.data, function(index, janitor) {
                        var isSelected = (index === 0); // select first janitor by default
                        var assignText = parseInt(janitor.active_assignments_count) > 0 
                            ? ' (' + janitor.active_assignments_count + ' active jobs)' 
                            : ' (0 active jobs)';
                        
                        var option = new Option(
                            janitor.employee_name + ' [' + janitor.employee_code + ']' + assignText,
                            janitor.employee_id,
                            isSelected,
                            isSelected
                        );
                        $(option).data('janitor', janitor);
                        dropdown.append(option);
                    });

                    dropdown.trigger('change');
                    currentJanitorId = dropdown.val();

                    // Load overview and init calendar
                    loadJanitorOverview(currentJanitorId);
                    if (!calendar) {
                        initCalendar();
                    } else {
                        calendar.refetchEvents();
                    }
                } else {
                    $('#select_janitor').html('<option value="">No Janitors found</option>');
                }
            },
            error: function(xhr, status, error) {
                console.error('Failed to load janitors:', error);
            }
        });

        // Change event
        $('#select_janitor').on('change', function() {
            var selectedId = $(this).val();
            if (selectedId && selectedId !== currentJanitorId) {
                currentJanitorId = selectedId;
                loadJanitorOverview(currentJanitorId);
                if (calendar) {
                    calendar.refetchEvents();
                }
            }
        });
    }

    // Load Janitor overview details
    function loadJanitorOverview(employeeId) {
        if (!employeeId) return;

        $.ajax({
            url: '../controller/janitor/calendar_controller.php',
            type: 'GET',
            data: { action: 'get_janitor_overview', employee_id: employeeId },
            dataType: 'json',
            success: function(res) {
                if (res.status === 'success' && res.employee) {
                    var emp = res.employee;
                    $('#badge_janitor_name').text(emp.employee_name || 'N/A');
                    $('#badge_janitor_code').text(emp.employee_code || 'N/A');
                    $('#badge_janitor_phone').text(emp.employee_contact_no || 'N/A');
                    
                    var activeJobs = (res.assignments && res.assignments.length) ? res.assignments.length : 0;
                    $('#badge_active_jobs_count').text(activeJobs);
                    
                    // Populate quick active jobs dropdown/tooltip
                    var jobsListHtml = '';
                    if (activeJobs > 0) {
                        $.each(res.assignments, function(i, a) {
                            jobsListHtml += '<div class="text-muted small py-1 border-bottom">' +
                                '<strong>' + (a.assignment_ref_no || '') + '</strong>: ' + (a.building_name || '') + ' • ' + (a.asset_ref_no || '') +
                                '<br><span class="text-primary font-weight-semibold">Slots:</span> ' + (a.slots || 'Default') +
                                '</div>';
                        });
                    } else {
                        jobsListHtml = '<div class="text-muted small">No active assignments configured.</div>';
                    }
                    $('#janitor_jobs_summary_content').html(jobsListHtml);
                }
            }
        });
    }

    // Initialize FullCalendar v4
    function initCalendar() {
        var calendarEl = document.getElementById('janitor_calendar');
        if (!calendarEl) return;

        calendar = new FullCalendar.Calendar(calendarEl, {
            plugins: ['dayGrid', 'timeGrid', 'list', 'interaction'],
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
            },
            views: {
                dayGridMonth: { buttonText: 'Month' },
                timeGridWeek: { buttonText: 'Week' },
                timeGridDay: { buttonText: 'Day' },
                listMonth: { buttonText: 'List' }
            },
            defaultView: 'dayGridMonth',
            editable: false,
            eventLimit: 4, // allow "more" link when slots exceed cell
            navLinks: true,
            displayEventTime: true,
            displayEventEnd: true,
            eventTimeFormat: {
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            },
            events: function(fetchInfo, successCallback, failureCallback) {
                if (!currentJanitorId) {
                    successCallback([]);
                    return;
                }

                $('#calendar_loader').show();

                $.ajax({
                    url: '../controller/janitor/calendar_controller.php',
                    type: 'GET',
                    data: {
                        action: 'get_calendar_events',
                        employee_id: currentJanitorId,
                        start: fetchInfo.startStr,
                        end: fetchInfo.endStr
                    },
                    dataType: 'json',
                    success: function(response) {
                        $('#calendar_loader').hide();
                        if (response.status === 'success') {
                            updateKpis(response.kpis);
                            successCallback(response.events || []);
                        } else {
                            failureCallback(response.message || 'Failed to fetch calendar events');
                        }
                    },
                    error: function(xhr, status, error) {
                        $('#calendar_loader').hide();
                        console.error('Error fetching calendar events:', error);
                        failureCallback(error);
                    }
                });
            },
            eventRender: function(info) {
                var props = info.event.extendedProps || {};
                var status = props.status || '';
                var statusCode = props.status_code || '';
                var slotName = props.slot_name || '';
                var assetRef = props.asset_ref_no || '';
                var timeWindow = props.start_time + ' - ' + props.end_time;

                // Tooltip
                var tooltipText = slotName + ' (' + timeWindow + ')\n' +
                                  'Asset: ' + assetRef + '\n' +
                                  'Status: ' + status + '\n' +
                                  'Building: ' + (props.building_name || 'N/A');
                info.el.setAttribute('title', tooltipText);

                // Custom styling on event elements
                if (info.view.type === 'dayGridMonth') {
                    var iconHtml = '<i class="' + (props.status_icon || 'icon-primitive-dot') + ' mr-1" style="font-size: 10px;"></i>';
                    var customHtml = '<div class="fc-content d-flex align-items-center px-1" style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">' +
                                     iconHtml + 
                                     '<span class="fc-title font-weight-semibold">' + slotName + '</span>' +
                                     '<span class="ml-auto badge badge-pill ' + (props.status_badge || 'badge-secondary') + '" style="font-size: 9px; padding: 2px 5px;">' + status + '</span>' +
                                     '</div>';
                    info.el.innerHTML = customHtml;
                }
            },
            eventClick: function(info) {
                info.jsEvent.preventDefault();
                var props = info.event.extendedProps || {};
                openSlotDetailsModal(props);
            }
        });

        calendar.render();
    }

    // Update KPI Stat Badges on top of calendar
    function updateKpis(kpis) {
        if (!kpis) return;

        $('#kpi_total_slots').text(kpis.total_slots || 0);
        $('#kpi_completed_ontime').text(kpis.completed_ontime || 0);
        $('#kpi_completed_late').text(kpis.completed_late || 0);
        $('#kpi_missed').text(kpis.missed || 0);
        $('#kpi_upcoming_active').text((kpis.upcoming || 0) + (kpis.active || 0));
        
        var ontimeRate = (kpis.ontime_rate !== undefined) ? kpis.ontime_rate : 0;
        $('#kpi_ontime_rate').text(ontimeRate + '%');
        $('#kpi_ontime_progress').css('width', ontimeRate + '%');
    }

    // Open Slot Details Modal and fetch full checklist points & GPS info
    function openSlotDetailsModal(props) {
        var modal = $('#modal_slot_details');
        
        // Initial setup with available props
        $('#modal_slot_name').text(props.slot_name || 'Slot Details');
        $('#modal_slot_date').text(props.date || '');
        $('#modal_status_badge').html('<span class="badge ' + (props.status_badge || 'badge-secondary') + ' px-2 py-1"><i class="' + (props.status_icon || 'icon-info22') + ' mr-1"></i> ' + (props.status || 'Pending') + '</span>');
        
        $('#detail_assignment_ref').text(props.assignment_ref_no || 'N/A');
        $('#detail_customer_name').text(props.customer_name || 'N/A');
        $('#detail_building_name').text(props.building_name || 'N/A');
        $('#detail_location_name').text(props.location_name || 'N/A');
        $('#detail_asset_ref').text(props.asset_ref_no || 'N/A');
        $('#detail_asset_desc').text(props.asset_description || 'N/A');
        $('#detail_slot_window').text((props.start_time || '') + ' to ' + (props.end_time || '') + ' (Deadline: ' + (props.late_deadline || '') + ')');
        $('#detail_checklist_name').text(props.checklist_name || 'N/A');

        // Loading state for dynamic sections
        $('#slot_execution_info_container').html('<div class="text-center py-3 text-muted"><i class="icon-spinner2 spinner mr-2"></i> Loading slot details & verification...</div>');
        $('#slot_checklist_container').html('<div class="text-center py-3 text-muted"><i class="icon-spinner2 spinner mr-2"></i> Loading checklist items...</div>');

        modal.modal('show');

        // AJAX request for full details
        $.ajax({
            url: '../controller/janitor/calendar_controller.php',
            type: 'GET',
            data: {
                action: 'get_slot_details',
                assignment_id: props.assignment_id,
                date: props.date,
                slot_name: props.slot_name,
                execution_id: props.execution_id || 0
            },
            dataType: 'json',
            success: function(res) {
                if (res.status === 'success') {
                    renderExecutionInfo(res.execution, res.assignment, props);
                    renderChecklistPoints(res.checklist_categories, res.execution);
                } else {
                    $('#slot_execution_info_container').html('<div class="alert alert-danger">' + (res.message || 'Error loading details') + '</div>');
                    $('#slot_checklist_container').empty();
                }
            },
            error: function(xhr, status, error) {
                $('#slot_execution_info_container').html('<div class="alert alert-danger">Network error loading details.</div>');
                $('#slot_checklist_container').empty();
            }
        });
    }

    // Render Execution & GPS Section in Modal
    function renderExecutionInfo(execution, assignment, props) {
        var container = $('#slot_execution_info_container');
        var html = '';

        if (execution) {
            // Execution completed (On-Time, Late, or Partial)
            var isLate = (execution.status && execution.status.indexOf('Late') !== -1);
            var statusBadgeClass = isLate ? 'badge-warning' : 'badge-success';
            var statusIcon = isLate ? 'icon-alarm-check' : 'icon-checkmark3';

            var distanceMeters = execution.distance_meters !== null ? parseFloat(execution.distance_meters).toFixed(1) : 'N/A';
            var scanLat = execution.scan_lat || 'N/A';
            var scanLng = execution.scan_lng || 'N/A';
            var assetLat = execution.asset_lat || assignment.effective_asset_lat || 'N/A';
            var assetLng = execution.asset_lng || assignment.effective_asset_lng || 'N/A';

            var mapBtn = execution.scan_map_url 
                ? '<a href="' + execution.scan_map_url + '" target="_blank" class="btn btn-sm btn-outline-primary ml-auto"><i class="icon-google mr-1"></i> View Scan on Map</a>'
                : '';

            html += '<div class="card card-body bg-light mb-0 p-3 border-left-3 border-left-success">' +
                    '  <div class="d-flex align-items-center mb-2">' +
                    '    <h6 class="font-weight-semibold mb-0 text-success"><i class="' + statusIcon + ' mr-2"></i> Executed & Verified</h6>' +
                    '    <span class="badge ' + statusBadgeClass + ' ml-2 px-2 py-1">' + execution.status + '</span>' +
                    '    ' + mapBtn +
                    '  </div>' +
                    '  <div class="row small text-muted">' +
                    '    <div class="col-md-4 mb-2"><strong>Submitted At:</strong> <span class="text-dark">' + (execution.created_at || 'N/A') + '</span></div>' +
                    '    <div class="col-md-4 mb-2"><strong>GPS Distance:</strong> <span class="badge badge-info">' + distanceMeters + ' m</span></div>' +
                    '    <div class="col-md-4 mb-2"><strong>Janitor Scan Coords:</strong> <span class="text-dark">' + scanLat + ', ' + scanLng + '</span></div>' +
                    '    <div class="col-md-12"><strong>Remarks:</strong> <span class="text-dark">' + (execution.remarks ? execution.remarks : '<em>None</em>') + '</span></div>' +
                    '  </div>' +
                    '</div>';
        } else {
            // Not executed
            var statusCode = props.status_code;
            if (statusCode === 'MISSED') {
                html += '<div class="alert alert-danger mb-0 d-flex align-items-center">' +
                        '  <i class="icon-blocked mr-2 icon-2x"></i>' +
                        '  <div>' +
                        '    <strong>Missed Slot:</strong> This job task was not executed by the Janitor within the scheduled window (deadline expired at ' + (props.late_deadline || '') + ').' +
                        '  </div>' +
                        '</div>';
            } else if (statusCode === 'ACTIVE') {
                html += '<div class="alert alert-primary mb-0 d-flex align-items-center">' +
                        '  <i class="icon-play3 mr-2 icon-2x"></i>' +
                        '  <div>' +
                        '    <strong>Currently Active Window:</strong> This job slot is open today between ' + props.start_time + ' and ' + props.end_time + ' (late submission accepted until ' + props.late_deadline + '). Awaiting Janitor QR scan.' +
                        '  </div>' +
                        '</div>';
            } else {
                html += '<div class="alert alert-info mb-0 d-flex align-items-center">' +
                        '  <i class="icon-calendar3 mr-2 icon-2x"></i>' +
                        '  <div>' +
                        '    <strong>Upcoming Schedule:</strong> This slot is scheduled for future execution on ' + props.date + ' (' + props.start_time + ' - ' + props.end_time + ').' +
                        '  </div>' +
                        '</div>';
            }
        }

        container.html(html);
    }

    // Render Checklist points organized by categories
    function renderChecklistPoints(categories, execution) {
        var container = $('#slot_checklist_container');
        var html = '';

        if (!categories || Object.keys(categories).length === 0) {
            container.html('<div class="text-muted small text-center py-2">No checklist items configured for this job.</div>');
            return;
        }

        var isExecuted = (execution !== null && execution !== undefined);

        $.each(categories, function(catName, items) {
            html += '<div class="mb-3">' +
                    '  <div class="bg-slate-700 text-white font-weight-semibold px-3 py-1 rounded-top" style="font-size: 13px;">' +
                    '    <i class="icon-task mr-2"></i>' + catName + ' (' + items.length + ' points)' +
                    '  </div>' +
                    '  <div class="table-responsive border border-top-0 rounded-bottom">' +
                    '    <table class="table table-sm table-striped mb-0">' +
                    '      <thead class="bg-light text-muted small">' +
                    '        <tr>' +
                    '          <th style="width: 50%;">Checklist Item</th>' +
                    '          <th style="width: 20%;">Status</th>' +
                    '          <th style="width: 30%;">Remarks / Proof</th>' +
                    '        </tr>' +
                    '      </thead>' +
                    '      <tbody>';

            $.each(items, function(idx, item) {
                var isCompleted = (item.is_completed === 'Yes' || item.is_completed === '1');
                var statusHtml = '';
                
                if (isExecuted) {
                    if (isCompleted) {
                        statusHtml = '<span class="badge badge-success"><i class="icon-checkmark2 mr-1"></i> Done</span>';
                    } else {
                        statusHtml = '<span class="badge badge-danger"><i class="icon-cross2 mr-1"></i> Not Done</span>';
                    }
                } else {
                    statusHtml = '<span class="badge badge-secondary"><i class="icon-minus2 mr-1"></i> Scheduled</span>';
                }

                var proofHtml = item.remarks ? '<span class="text-dark">' + item.remarks + '</span>' : '<span class="text-muted small">None</span>';
                if (item.photo_url) {
                    var fullPhotoUrl = (item.photo_url.indexOf('http') === 0) ? item.photo_url : '../' + item.photo_url;
                    proofHtml += '<div class="mt-1">' +
                                 '  <a href="' + fullPhotoUrl + '" target="_blank" class="badge badge-light border">' +
                                 '    <i class="icon-image2 mr-1 text-primary"></i> View Photo Proof' +
                                 '  </a>' +
                                 '</div>';
                }

                html += '        <tr>' +
                        '          <td class="align-middle font-weight-semibold">' + (idx + 1) + '. ' + item.item_description + '</td>' +
                        '          <td class="align-middle">' + statusHtml + '</td>' +
                        '          <td class="align-middle small">' + proofHtml + '</td>' +
                        '        </tr>';
            });

            html += '      </tbody>' +
                    '    </table>' +
                    '  </div>' +
                    '</div>';
        });

        container.html(html);
    }

    return {
        init: function() {
            initJanitorDropdown();
        },
        refresh: function() {
            if (calendar) {
                calendar.refetchEvents();
            }
        }
    };
})();

// Document Ready trigger
$(document).ready(function() {
    JanitorCalendarApp.init();

    // Refresh button click
    $('#btn_refresh_calendar').on('click', function() {
        JanitorCalendarApp.refresh();
    });
});
