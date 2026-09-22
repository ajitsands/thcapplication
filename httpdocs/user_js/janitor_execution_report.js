$(document).ready(function() {
    
    // Initialize Plugins
    $('.select2').select2();

    // Setup Export Buttons
    $.extend( $.fn.dataTable.defaults, {
        autoWidth: false,
        dom: '<"datatable-header"fBl><"datatable-scroll-wrap"t><"datatable-footer"ip>',
        language: {
            search: '<span>Filter:</span> _INPUT_',
            searchPlaceholder: 'Type to filter...',
            lengthMenu: '<span>Show:</span> _MENU_',
            paginate: { 'first': 'First', 'last': 'Last', 'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;', 'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;' }
        }
    });

    // Initialize DataTable
    var tblExecutionReport = $('.datatable-execution-report').DataTable({
        "ajax": {
            "url": "../controller/janitor/execution_report_controller.php",
            "type": "POST",
            "data": function(d) {
                d.action = "list_executions";
                d.customer_id = $('#filter_customer').val();
                d.asset_id = $('#filter_asset').val();
                d.amc_ref_no = $('#filter_amc').val();
                d.employee_id = $('#filter_janitor').val();
                d.from_date = $('#filter_from_date').val();
                d.to_date = $('#filter_to_date').val();
            }
        },
        "buttons": [
            {
                extend: 'excelHtml5',
                className: 'btn btn-light',
                text: '<i class="icon-file-excel text-success"></i> Excel Export',
                title: 'Janitor Execution Report',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6]
                }
            },
            {
                extend: 'pdfHtml5',
                className: 'btn btn-light',
                text: '<i class="icon-file-pdf text-danger"></i> PDF Export',
                title: 'Janitor Execution Report',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6]
                }
            }
        ],
        "columns": [
            { "data": "assignment_ref_no" },
            { "data": "executed_date",
              "render": function(data, type, row) {
                  if(!data) return '';
                  var dt = new Date(data);
                  return dt.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });
              }
            },
            { "data": "executed_slot",
              "render": function(data, type, row) {
                  return '<span class="badge badge-light badge-striped badge-striped-left border-left-info">' + data + '</span>';
              }
            },
            { "data": "employee_name",
              "render": function(data, type, row) {
                  return data + (row.employee_code ? ' <small class="text-muted">(' + row.employee_code + ')</small>' : '');
              }
            },
            { "data": "asset_ref_no",
              "render": function(data, type, row) {
                  return data + (row.asset_description ? ' <br><small class="text-muted">' + row.asset_description + '</small>' : '');
              }
            },
            { "data": "checklist_name" },
            { "data": "status",
              "render": function(data, type, row) {
                  var badgeClass = data === 'Completed' ? 'badge-success' : 'badge-warning';
                  return '<span class="badge ' + badgeClass + '">' + (data || 'Submitted') + '</span>';
              }
            },
            { "data": null,
              "orderable": false,
              "className": "text-center",
              "render": function(data, type, row) {
                  return '<button type="button" class="btn btn-outline-info btn-sm btn-view-execution" data-id="'+row.execution_id+'"><i class="icon-eye font-size-sm mr-1"></i> View Data</button>';
              }
            }
        ],
        "order": [[1, "desc"], [0, "desc"]]
    });

    // View Execution Details Modal
    $(document).on('click', '.btn-view-execution', function(e) {
        e.preventDefault();
        var exec_id = $(this).data('id');
        if (!exec_id) return;
        
        $('#div_execution_details_body').html('<div class="text-center p-3"><i class="icon-spinner2 spinner"></i> Loading...</div>');
        $('#modal_view_execution').modal('show');
        
        $.ajax({
            url: '../controller/janitor/execution_report_controller.php',
            type: 'POST',
            data: { action: 'get_execution_points', execution_id: exec_id },
            success: function(response) {
                var res = JSON.parse(response);
                var html = '';
                
                if (res.categories && Object.keys(res.categories).length > 0) {
                    Object.keys(res.categories).forEach(function(catName) {
                        html += '<div class="card mb-3">';
                        html += '<div class="card-header bg-light border-bottom-0 pt-2 pb-2"><h6 class="font-weight-semibold text-primary mb-0"><i class="icon-folder mr-2"></i>' + catName + '</h6></div>';
                        html += '<div class="card-body p-0"><div class="table-responsive"><table class="table table-sm table-striped mb-0">';
                        html += '<thead><tr><th>Task</th><th class="text-center" style="width: 120px;">Status</th><th>Remarks</th><th class="text-center" style="width: 80px;">Photo</th></tr></thead><tbody>';
                        
                        var points = res.categories[catName];
                        if (points && points.length > 0) {
                            points.forEach(function(pt) {
                                var isDone = pt.is_completed === 'Yes' || pt.is_completed === '1' || pt.is_completed === 'true' || pt.is_completed === 'Completed';
                                var statusIcon = isDone ? 
                                    '<span class="badge badge-success"><i class="icon-checkmark3 mr-1"></i> Done</span>' : 
                                    '<span class="badge badge-danger"><i class="icon-cross2 mr-1"></i> Missed</span>';
                                
                                var photoHtml = pt.photo_url ? '<a href="' + pt.photo_url + '" target="_blank" class="text-info"><i class="icon-image2"></i> View</a>' : '<span class="text-muted">-</span>';
                                
                                html += '<tr>';
                                html += '<td>' + pt.item_description + '</td>';
                                html += '<td class="text-center">' + statusIcon + '</td>';
                                html += '<td>' + (pt.remarks || '<span class="text-muted">-</span>') + '</td>';
                                html += '<td class="text-center">' + photoHtml + '</td>';
                                html += '</tr>';
                            });
                        } else {
                            html += '<tr><td colspan="4" class="text-center text-muted">No points submitted.</td></tr>';
                        }
                        html += '</tbody></table></div></div></div>';
                    });
                } else {
                    html = '<div class="alert alert-info">No checklist data found for this submission.</div>';
                }
                
                $('#div_execution_details_body').html(html);
            },
            error: function() {
                $('#div_execution_details_body').html('<div class="alert alert-danger">Error retrieving details.</div>');
            }
        });
    });

    // Search button click
    $('#btn_search').on('click', function() {
        tblExecutionReport.ajax.reload();
    });

});
