// Material Requests for a full Ticket (used on reschedule_pending_complaints.php)
// 3-Column Layout: Work Orders -> Requests -> Line Items

function openMaterialRequisitionModal(ticket_ref_code) {
    $('#mat_req_ticket_label').text(ticket_ref_code);
    
    // Reset modal state
    $('#mat_req_wo_list_container').html('<div class="text-center py-4"><i class="icon-spinner2 spinner mr-2"></i> Loading Work Orders...</div>');
    $('#mat_req_req_list_container').html(
        '<div class="text-center text-muted py-5 mt-4">' +
        '<i class="icon-arrow-left16 icon-2x mb-3 text-light"></i><br>' +
        '<h6>Select a Work Order first</h6>' +
        '</div>'
    );
    $('#mat_req_items_container_ticket').html(
        '<div class="text-center text-muted py-5 mt-5">' +
        '<i class="icon-arrow-left16 icon-2x mb-3 text-light"></i><br>' +
        '<h5>Select a Material Request</h5>' +
        '<span>Click on any material request in the second column to view its line items here.</span>' +
        '</div>'
    );
    $('#mat_req_selected_id_ticket').text('');
    $('#mat_req_items_count_ticket').text('');
    
    $('#modal_view_material_requests_ticket').modal('show');

    // Fetch Work Orders list
    $.ajax({
        type: 'POST',
        url: '../controller/ticket/get_material_requisition_tree.php',
        data: { action: 'get_work_orders', ticket_ref_code: ticket_ref_code },
        dataType: 'json',
        success: function(response) {
            var html = '';
            if (response.success && response.data.length > 0) {
                $.each(response.data, function(i, row) {
                    html += '<div class="mat-req-list-item" data-ticket-id="' + row.ticket_id + '">';
                    html += '  <div class="d-flex justify-content-between align-items-center mb-1">';
                    html += '    <div class="req-title">WO-' + ticket_ref_code + '-' + row.ticket_id + '</div>';
                    html += '  </div>';
                    html += '  <div class="req-date"><i class="icon-price-tag2 mr-1"></i>' + (row.category_name || '-') + ' / ' + (row.type_name || '-') + '</div>';
                    html += '</div>';
                });
            } else {
                html = '<div class="text-center text-muted py-4"><i class="icon-info22 mr-2"></i>No work orders found.</div>';
            }
            $('#mat_req_wo_list_container').html(html);

            // Click handler for Work Orders
            $('#mat_req_wo_list_container').off('click', '.mat-req-list-item').on('click', '.mat-req-list-item', function() {
                $('#mat_req_wo_list_container .mat-req-list-item').removeClass('active');
                $(this).addClass('active');

                var ticket_id = $(this).data('ticket-id');
                loadTicketMaterialRequests(ticket_id);
            });
            
            // Auto-select first Work Order if available
            if (response.success && response.data.length > 0) {
                $('#mat_req_wo_list_container .mat-req-list-item:first').trigger('click');
            }
            
        },
        error: function() {
            $('#mat_req_wo_list_container').html(
                '<div class="text-center text-danger py-4"><i class="icon-warning2 mr-2"></i>Failed to load Work Orders.</div>'
            );
        }
    });
}

function loadTicketMaterialRequests(ticket_id) {
    var container = $('#mat_req_req_list_container');
    container.html('<div class="text-center py-4"><i class="icon-spinner2 spinner mr-2"></i> Loading Requests...</div>');
    
    // Clear the third column
    $('#mat_req_items_container_ticket').html(
        '<div class="text-center text-muted py-5 mt-5">' +
        '<i class="icon-arrow-left16 icon-2x mb-3 text-light"></i><br>' +
        '<h5>Select a Material Request</h5>' +
        '<span>Click on any material request in the second column to view its line items here.</span>' +
        '</div>'
    );
    $('#mat_req_selected_id_ticket').text('');
    $('#mat_req_items_count_ticket').text('');

    $.ajax({
        type: 'POST',
        url: '../controller/ticket/get_material_requisition_tree.php',
        data: { action: 'get_requests', ticket_id: ticket_id },
        dataType: 'json',
        success: function(response) {
            var html = '';
            if (response.success && response.data.length > 0) {
                $.each(response.data, function(i, row) {
                    var status_badge = '';
                    if (row.status == 'Completed')         status_badge = '<span class="badge badge-success px-2 py-1">Completed</span>';
                    else if (row.status == 'Partial Issue') status_badge = '<span class="badge badge-info px-2 py-1">Partial Issue</span>';
                    else if (row.status == 'Pending')       status_badge = '<span class="badge badge-warning px-2 py-1">Pending</span>';
                    else                                    status_badge = '<span class="badge badge-secondary px-2 py-1">' + (row.status || 'N/A') + '</span>';

                    var req_date = row.request_date ? moment(row.request_date).format('DD-MM-YYYY hh:mm A') : '-';
                    
                    var attach_html = '';
                    if (row.attachment_path && row.attachment_path.trim() !== '') {
                        attach_html = '<a href="../httpdocs/uploads/request_attachments/' + row.attachment_path + '" target="_blank" class="ml-2" title="View Attachment" onclick="event.stopPropagation();"><i class="icon-attachment text-primary"></i></a>';
                    }

                    html += '<div class="mat-req-list-item req-item" data-request-id="' + row.request_id + '">';
                    html += '  <div class="d-flex justify-content-between align-items-center mb-1">';
                    html += '    <div class="req-title">THC-MREQ-' + row.request_id + attach_html + '</div>';
                    html += '    <div>' + status_badge + '</div>';
                    html += '  </div>';
                    html += '  <div class="req-date"><i class="icon-calendar3 mr-1"></i>' + req_date + '</div>';
                    html += '</div>';
                });
            } else {
                html = '<div class="text-center text-muted py-4"><i class="icon-info22 mr-2"></i>No material requests found.</div>';
            }
            container.html(html);

            // Click handler for list items
            container.off('click', '.req-item').on('click', '.req-item', function() {
                container.find('.req-item').removeClass('active');
                $(this).addClass('active');

                var request_id = $(this).data('request-id');
                $('#mat_req_selected_id_ticket').text('(THC-MREQ-' + request_id + ')');
                
                loadTicketMaterialRequestItems(request_id);
            });
            
            // Auto-select first item if available
            if (response.success && response.data.length > 0) {
                container.find('.req-item:first').trigger('click');
            }
            
        },
        error: function() {
            container.html(
                '<div class="text-center text-danger py-4"><i class="icon-warning2 mr-2"></i>Failed to load requests.</div>'
            );
        }
    });
}

function loadTicketMaterialRequestItems(request_id) {
    var container = $('#mat_req_items_container_ticket');
    container.html('<div class="text-center text-muted py-5 mt-4"><i class="icon-spinner2 spinner mr-2 icon-2x"></i><br><br>Loading items...</div>');
    $('#mat_req_items_count_ticket').text('...');

    $.ajax({
        type: 'POST',
        url: '../controller/ticket/get_material_requisition_tree.php',
        data: { action: 'get_request_items', request_id: request_id },
        dataType: 'json',
        success: function(response) {
            if (response.success && response.data.length > 0) {
                $('#mat_req_items_count_ticket').text(response.data.length + ' item(s)');
                
                var html = '<table class="mat-req-items-table">';
                html += '<thead><tr>';
                html += '<th style="width:40px;">#</th>';
                html += '<th>Category</th>';
                html += '<th>Item Code</th>';
                html += '<th>Material Item</th>';
                html += '<th>Remarks</th>';
                html += '<th class="text-center" style="width:70px;">Req. Qty</th>';
                html += '<th class="text-center" style="width:70px;">Iss. Qty</th>';
                html += '<th class="text-center" style="width:60px;">Unit</th>';
                html += '</tr></thead><tbody>';

                $.each(response.data, function(i, item) {
                    var req_qty = parseInt(item.requested_qty) || 0;
                    var iss_qty = parseInt(item.issued_qty) || 0;

                    var req_class  = 'qty-badge qty-none';
                    var iss_class  = 'qty-badge qty-none';
                    if (req_qty > 0) req_class = 'qty-badge qty-full';
                    if (iss_qty >= req_qty && iss_qty > 0)  iss_class = 'qty-badge qty-full';
                    else if (iss_qty > 0)                   iss_class = 'qty-badge qty-partial';

                    html += '<tr>';
                    html += '<td>' + (i + 1) + '</td>';
                    html += '<td>' + (item.category_name || '<span class="text-muted">-</span>') + '</td>';
                    html += '<td><code>' + (item.item_code || '-') + '</code></td>';
                    html += '<td>' + (item.item_name || '<span class="text-muted">-</span>') + '</td>';
                    html += '<td style="max-width:150px; word-wrap:break-word;">' + (item.remarks || '<span class="text-muted">-</span>') + '</td>';
                    html += '<td class="text-center"><span class="' + req_class + '">' + req_qty + '</span></td>';
                    html += '<td class="text-center"><span class="' + iss_class + '">' + iss_qty + '</span></td>';
                    html += '<td class="text-center text-muted">' + (item.unit || '-') + '</td>';
                    html += '</tr>';
                });

                html += '</tbody></table>';
                container.html(html);
            } else {
                $('#mat_req_items_count_ticket').text('0 items');
                container.html(
                    '<div class="text-center text-muted py-5 mt-4">' +
                    '<i class="icon-info22 icon-2x mb-3 text-light"></i><br>' +
                    '<h5>No line items</h5>' +
                    '<span>There are no line items for this material request.</span>' +
                    '</div>'
                );
            }
        },
        error: function() {
            $('#mat_req_items_count_ticket').text('Error');
            container.html('<div class="text-center text-danger py-5 mt-4"><i class="icon-warning2 icon-2x mb-3"></i><br>Failed to load items.</div>');
        }
    });
}
