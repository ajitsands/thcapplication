$(document).ready(function() {
    // Initialize Select2 dropdowns
    $('.form-control-select2').select2();

    // Initialize DataTable
    var dataTable = $('#table_wo_material_report').DataTable({
        dom: '<"datatable-header"fBl><"datatable-scroll"t><"datatable-footer"ip>',
        buttons: [
            {
                extend: 'excelHtml5',
                className: 'btn bg-teal-400',
                text: '<i class="icon-file-excel mr-2"></i> Export to Excel',
                title: 'THC WO Material Consolidated Report',
                exportOptions: {
                    columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
                    format: {
                        body: function ( data, row, column, node ) {
                            if (typeof data === 'string') {
                                data = data.replace(/<br\s*\/?>/ig, ", ");
                                data = data.replace(/<.*?>/ig, "");
                            }
                            return data;
                        }
                    }
                }
            },
            {
                extend: 'pdfHtml5',
                className: 'btn bg-danger',
                text: '<i class="icon-file-pdf mr-2"></i> Export to PDF',
                title: 'THC WO Material Consolidated Report',
                exportOptions: {
                    columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
                    format: {
                        body: function ( data, row, column, node ) {
                            if (typeof data === 'string') {
                                data = data.replace(/<br\s*\/?>/ig, ", ");
                                data = data.replace(/<.*?>/ig, "");
                            }
                            return data;
                        }
                    }
                },
                orientation: 'landscape'
            }
        ],
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        autoWidth: false,
        order: [[9, 'desc']], // Order by Request Date descending
        columns: [
            {
                className: 'details-control text-center',
                orderable: false,
                data: null,
                defaultContent: '<i class="icon-plus-circle2 text-primary" style="cursor:pointer; font-size:16px;"></i>'
            },
            { data: 'sno' },
            { data: 'customer_name' },
            { data: 'wo_ref' },
            { data: 'request_id' },
            { data: 'item_code' },
            { data: 'item_name' },
            { data: 'req_qty' },
            { data: 'iss_qty' },
            { data: 'request_date' },
            { data: 'status' },
            { data: 'delivery_logs', visible: false },
            { data: 'remarks', visible: false }
        ]
    });

    // Add event listener for opening and closing details
    $('#table_wo_material_report tbody').on('click', 'td.details-control i', function () {
        var tr = $(this).closest('tr');
        var row = dataTable.row(tr);
        var icon = $(this);

        if (row.child.isShown()) {
            row.child.hide();
            tr.removeClass('shown');
            icon.removeClass('icon-minus-circle2 text-danger').addClass('icon-plus-circle2 text-primary');
        } else {
            var rowData = row.data();
            var deliveryText = rowData.delivery_logs && rowData.delivery_logs !== '-' ? rowData.delivery_logs : 'No deliveries yet.';
            var remarksText = rowData.remarks && rowData.remarks !== '-' ? rowData.remarks : 'No remarks.';
            
            var detailsHtml = '<div class="p-3 bg-light border rounded">' +
                              '<div class="mb-2"><strong>Delivery Logs:</strong><br>' + deliveryText + '</div>' +
                              '<div><strong>Notes / Remarks:</strong><br>' + remarksText + '</div>' +
                              '</div>';
            row.child(detailsHtml).show();
            tr.addClass('shown');
            icon.removeClass('icon-plus-circle2 text-primary').addClass('icon-minus-circle2 text-danger');
        }
    });


    // Populate Material Dropdown on load
    $.ajax({
        url: '../controller/ticket/wo_material_report_controller.php',
        type: 'POST',
        data: { action: 'get_materials' },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                var options = '<option value="All">All</option>';
                $.each(response.data, function(index, item) {
                    options += '<option value="' + item.id + '">' + item.item_code + ' - ' + item.item_name + '</option>';
                });
                $('#select_material').html(options).trigger('change');
            }
        }
    });

    // On Customer Change -> Populate Work Orders
    $('#select_customer').on('change', function() {
        var customerId = $(this).val();
        
        $('#select_workorder').html('<option value="All">Loading...</option>').trigger('change');

        if (customerId === 'All' || !customerId) {
            $('#select_workorder').html('<option value="All">All</option>').trigger('change');
            return;
        }

        $.ajax({
            url: '../controller/ticket/wo_material_report_controller.php',
            type: 'POST',
            data: { 
                action: 'get_work_orders',
                customer_id: customerId
            },
            dataType: 'json',
            success: function(response) {
                var options = '<option value="All">All</option>';
                if (response.success && response.data.length > 0) {
                    $.each(response.data, function(index, item) {
                        options += '<option value="' + item.ticket_id + '">' + item.ticket_ref_code + '</option>';
                    });
                }
                $('#select_workorder').html(options).trigger('change');
            }
        });
    });

    // On Search Click
    $('#btn_search_report').on('click', function() {
        var customerId = $('#select_customer').val();
        var workorderId = $('#select_workorder').val();
        var materialId = $('#select_material').val();

        var btn = $(this);
        btn.html('<i class="icon-spinner2 spinner"></i> Loading...').prop('disabled', true);

        $.ajax({
            url: '../controller/ticket/wo_material_report_controller.php',
            type: 'POST',
            data: {
                action: 'get_report_data',
                customer_id: customerId,
                workorder_id: workorderId,
                material_id: materialId
            },
            dataType: 'json',
            success: function(response) {
                btn.html('Search').prop('disabled', false);
                dataTable.clear();

                if (response.success && response.data.length > 0) {
                    var rows = [];
                    $.each(response.data, function(index, item) {
                        
                        var req_qty = parseInt(item.requested_qty) || 0;
                        var iss_qty = parseInt(item.issued_qty) || 0;

                        var req_class = 'badge badge-light';
                        var iss_class = 'badge badge-light';
                        
                        if (req_qty > 0) req_class = 'badge badge-success';
                        if (iss_qty >= req_qty && iss_qty > 0) iss_class = 'badge badge-success';
                        else if (iss_qty > 0) iss_class = 'badge badge-info';

                        var statusBadge = '';
                        if (item.request_status == 'Completed') statusBadge = '<span class="badge badge-success">Completed</span>';
                        else if (item.request_status == 'Pending') statusBadge = '<span class="badge badge-warning">Pending</span>';
                        else statusBadge = '<span class="badge badge-secondary">' + item.request_status + '</span>';

                        rows.push({
                            sno: index + 1,
                            customer_name: item.customer_name || '-',
                            wo_ref: 'WO-' + (item.ticket_ref_code || '') + '-' + (item.ticket_id || ''),
                            request_id: 'THC-MREQ-' + item.request_id,
                            item_code: '<code>' + (item.item_code || '-') + '</code>',
                            item_name: item.item_name || '-',
                            req_qty: '<span class="' + req_class + '">' + req_qty + '</span>',
                            iss_qty: '<span class="' + iss_class + '">' + iss_qty + '</span>',
                            request_date: item.request_date || '-',
                            status: statusBadge,
                            delivery_logs: item.delivery_logs || '-',
                            remarks: item.remarks || '-'
                        });
                    });
                    dataTable.rows.add(rows).draw();
                } else {
                    dataTable.draw();
                }
            },
            error: function() {
                btn.html('Search').prop('disabled', false);
                alert('An error occurred while fetching the report.');
            }
        });
    });
});
