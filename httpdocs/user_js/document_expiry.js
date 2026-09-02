$(document).ready(function () {
    // Initialize Select2 dropdowns if available
    if ($.fn.select2) {
        $('.form-control-select2').select2({
            minimumResultsForSearch: Infinity
        });
        $('#select_doc_type, #select_emp_type').select2();
    }

    // Load Filter Dropdown Options
    loadDocTypesFilter();
    loadEmpTypesFilter();

    // Toggle custom days input
    $('#select_days_filter').on('change', function () {
        var val = $(this).val();
        if (val === 'custom') {
            $('#div_custom_days').slideDown(200);
            $('#txt_custom_days').focus();
        } else {
            $('#div_custom_days').slideUp(200);
            $('#txt_custom_days').val('');
        }
    });

    // Initialize DataTable
    var tblDocExpiry = $('#tbl_document_expiries').DataTable({
        "processing": true,
        "serverSide": false,
        "ajax": {
            "url": "../controller/expiry/document_expiry_controller.php",
            "type": "POST",
            "data": function (d) {
                d.action = 'list_document_expiries';
                d.from_date = $('#txt_from_date').val();
                d.to_date = $('#txt_to_date').val();
                d.days_filter = $('#select_days_filter').val();
                d.custom_days = $('#txt_custom_days').val();
                d.doc_name = $('#select_doc_type').val();
                d.emp_type_id = $('#select_emp_type').val();
                d.emp_status = $('#select_emp_status').val();
            },
            "dataSrc": function (json) {
                if (json && json.stats) {
                    $('#stat_total_docs').text(json.stats.total || 0);
                    $('#stat_expired_docs').text(json.stats.expired || 0);
                    $('#stat_soon_docs').text(json.stats.expiring_soon || 0);
                    $('#stat_valid_docs').text(json.stats.valid || 0);
                    $('#badge_record_count').text((json.data ? json.data.length : 0) + ' Records Found');
                }
                return json.data || [];
            }
        },
        "order": [[6, "asc"]],
        "autoWidth": false,
        "pageLength": 25,
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        "language": {
            "emptyTable": "No document expiry records found matching the criteria",
            "zeroRecords": "No matching document records found",
            "info": "Showing _START_ to _END_ of _TOTAL_ document expiries",
            "infoEmpty": "Showing 0 to 0 of 0 entries",
            "infoFiltered": "(filtered from _MAX_ total records)"
        },
        "columnDefs": [
            { "type": "date-eu", "targets": 6 },
            { "orderable": false, "targets": [0, 1, 10] }
        ],
        "columns": [
            {
                "data": null,
                "className": "text-center",
                "render": function (data, type, row, meta) {
                    return meta.row + 1;
                }
            },
            {
                "data": "employee_image_formatted",
                "className": "text-center",
                "render": function (data, type, row) {
                    var imgPath = '../httpdocs/images/employee_image/' + (data || 'default.jpg');
                    return '<img src="' + imgPath + '" alt="Avatar" style="width: 38px; height: 38px; border-radius: 50%; object-fit: cover; border: 1px solid #cbd5e1;" onerror="this.src=\'../httpdocs/images/employee_image/default.jpg\';">';
                }
            },
            {
                "data": "employee_code",
                "render": function (data, type, row) {
                    if (!data) return '-';
                    return '<a href="reports/employee_profile.php?employee_id=' + row.employee_id + '" target="_blank" class="font-weight-bold text-primary" title="View Profile">' + data + '</a>';
                }
            },
            {
                "data": "employee_name",
                "className": "col-employee-name",
                "render": function (data) {
                    return '<span class="font-weight-semibold text-dark">' + (data || 'N/A') + '</span>';
                }
            },
            {
                "data": "employee_type_name",
                "render": function (data) {
                    return data || '-';
                }
            },
            {
                "data": "document_name",
                "render": function (data) {
                    return '<span class="badge-doc-name">' + (data || 'Document') + '</span>';
                }
            },
            {
                "data": "formatted_expiry_date",
                "className": "text-center font-weight-semibold",
                "render": function (data) {
                    return data || '-';
                }
            },
            {
                "data": "days_to_expire",
                "className": "text-center",
                "render": function (data, type, row) {
                    var days = parseInt(data, 10);
                    if (isNaN(days)) return '-';

                    if (days < 0) {
                        var absDays = Math.abs(days);
                        return '<span class="badge-expired"><i class="icon-alert"></i> Expired ' + absDays + ' ' + (absDays === 1 ? 'day' : 'days') + ' ago</span>';
                    } else if (days === 0) {
                        return '<span class="badge-soon"><i class="icon-alarm"></i> Expires Today</span>';
                    } else if (days <= 30) {
                        return '<span class="badge-soon"><i class="icon-alarm"></i> ' + days + ' ' + (days === 1 ? 'day' : 'days') + ' left</span>';
                    } else {
                        return '<span class="badge-valid"><i class="icon-checkmark3"></i> ' + days + ' days left</span>';
                    }
                }
            },
            {
                "data": "expiry_status_label",
                "className": "text-center",
                "render": function (data, type, row) {
                    var status = data || '';
                    if (status === 'Expired') {
                        return '<span class="badge badge-danger" style="font-size: 11px; padding: 4px 8px;">Expired</span>';
                    } else if (status === 'Expiring Soon') {
                        return '<span class="badge badge-warning" style="font-size: 11px; padding: 4px 8px; color: #000;">Expiring Soon</span>';
                    } else {
                        return '<span class="badge badge-success" style="font-size: 11px; padding: 4px 8px;">Valid</span>';
                    }
                }
            },
            {
                "data": "remarks",
                "render": function (data) {
                    return data ? '<span class="text-muted" style="font-size: 11px;">' + data + '</span>' : '-';
                }
            },
            {
                "data": "file_path",
                "className": "text-center",
                "render": function (data) {
                    if (data && data !== '' && data !== 'null') {
                        return '<a href="../' + data + '" target="_blank" class="btn btn-sm btn-outline-primary py-0 px-2" style="font-size: 11px;" title="View Attachment"><i class="icon-file-eye mr-1"></i> View</a>';
                    }
                    return '<span class="text-muted" style="font-size: 11px;">No File</span>';
                }
            },
            {
                "data": "employee_status",
                "className": "text-center",
                "render": function (data) {
                    if (data === 'Active') {
                        return '<span class="badge badge-flat border-success text-success" style="font-size: 10px;">Active</span>';
                    } else {
                        return '<span class="badge badge-flat border-danger text-danger" style="font-size: 10px;">Inactive</span>';
                    }
                }
            }
        ]
    });

    // Search Button Click
    $('#btn_doc_search').on('click', function () {
        var fromDate = $('#txt_from_date').val();
        var toDate = $('#txt_to_date').val();

        if (fromDate !== '' && toDate !== '' && fromDate > toDate) {
            swal("Invalid Date Range", "From Date cannot be greater than To Date.", "warning");
            return false;
        }

        var daysFilter = $('#select_days_filter').val();
        if (daysFilter === 'custom') {
            var customDays = $('#txt_custom_days').val();
            if (!customDays || parseInt(customDays, 10) <= 0) {
                swal("Invalid Input", "Please enter a valid number of days greater than 0.", "warning");
                return false;
            }
        }

        tblDocExpiry.ajax.reload();
    });

    // Reset Button Click
    $('#btn_doc_reset').on('click', function () {
        $('#txt_from_date').val('');
        $('#txt_to_date').val('');
        $('#select_days_filter').val('all').trigger('change');
        $('#txt_custom_days').val('');
        $('#div_custom_days').hide();
        $('#select_doc_type').val('all').trigger('change');
        $('#select_emp_type').val('all').trigger('change');
        $('#select_emp_status').val('Active').trigger('change');

        tblDocExpiry.ajax.reload();
    });

    // Export / Print Button Click
    $('#btn_doc_export_pdf').on('click', function () {
        var fromDate = $('#txt_from_date').val();
        var toDate = $('#txt_to_date').val();
        var daysFilter = $('#select_days_filter').val();
        var customDays = $('#txt_custom_days').val();
        var docName = $('#select_doc_type').val();
        var empTypeId = $('#select_emp_type').val();
        var empStatus = $('#select_emp_status').val();

        var params = [];
        if (fromDate) params.push('from_date=' + encodeURIComponent(fromDate));
        if (toDate) params.push('to_date=' + encodeURIComponent(toDate));
        if (daysFilter && daysFilter !== 'all') params.push('days_filter=' + encodeURIComponent(daysFilter));
        if (daysFilter === 'custom' && customDays) params.push('custom_days=' + encodeURIComponent(customDays));
        if (docName && docName !== 'all') params.push('doc_name=' + encodeURIComponent(docName));
        if (empTypeId && empTypeId !== 'all') params.push('emp_type_id=' + encodeURIComponent(empTypeId));
        if (empStatus) params.push('emp_status=' + encodeURIComponent(empStatus));

        var queryString = params.length > 0 ? '?' + params.join('&') : '';
        window.open('document_expiry_list_print.php' + queryString, '_blank');
    });

    // Function to load document types
    function loadDocTypesFilter() {
        $.ajax({
            url: '../controller/expiry/document_expiry_controller.php',
            type: 'POST',
            data: { action: 'get_distinct_doc_types' },
            dataType: 'json',
            success: function (res) {
                if (res && res.status === 'success' && res.data && res.data.length > 0) {
                    var select = $('#select_doc_type');
                    var currentVal = select.val() || 'all';
                    select.empty();
                    select.append('<option value="all">All Document Types</option>');
                    $.each(res.data, function (idx, docName) {
                        select.append('<option value="' + docName + '">' + docName + '</option>');
                    });
                    select.val(currentVal);
                    if ($.fn.select2) {
                        select.select2();
                        select.trigger('change');
                    }
                }
            }
        });
    }

    // Function to load employee types
    function loadEmpTypesFilter() {
        $.ajax({
            url: '../controller/expiry/document_expiry_controller.php',
            type: 'POST',
            data: { action: 'get_employee_types' },
            dataType: 'json',
            success: function (res) {
                if (res && res.status === 'success' && res.data && res.data.length > 0) {
                    var select = $('#select_emp_type');
                    var currentVal = select.val() || 'all';
                    select.empty();
                    select.append('<option value="all">All Employee Types</option>');
                    $.each(res.data, function (idx, item) {
                        select.append('<option value="' + item.employee_type_id + '">' + item.employee_type_name + '</option>');
                    });
                    select.val(currentVal);
                    if ($.fn.select2) {
                        select.select2();
                        select.trigger('change');
                    }
                }
            }
        });
    }
});
