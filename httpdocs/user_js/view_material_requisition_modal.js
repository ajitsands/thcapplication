// Handle Material Requisition Drill-down logic

function openMaterialRequisitionModal(ticket_ref_code) {
    $('#mat_req_ticket_ref').text('#' + ticket_ref_code);
    
    // Reset views
    matReqGoBack(1);
    
    // Show modal
    $('#modal_view_material_requisitions').modal('show');
    
    // Load Level 1 Data (Work Orders)
    $('#tbl_mat_req_work_orders tbody').html('<tr><td colspan="5" class="text-center py-3"><i class="icon-spinner2 spinner mr-2"></i> Loading Work Orders...</td></tr>');
    
    $.ajax({
        type: 'POST',
        url: '../controller/ticket/get_material_requisition_tree.php',
        data: { action: 'get_work_orders', ticket_ref_code: ticket_ref_code },
        dataType: 'json',
        success: function(response) {
            if(response.success) {
                var html = '';
                if(response.data.length > 0) {
                    $.each(response.data, function(i, row) {
                        html += '<tr>';
                        html += '<td>WO-'+ticket_ref_code+'-'+row.ticket_id+'</td>';
                        html += '<td>'+(row.category_name || 'NA')+'</td>';
                        html += '<td>'+(row.type_name || 'NA')+'</td>';
                        html += '<td>'+(row.asset_code || 'NA')+'</td>';
                        html += '<td class="text-center">';
                        html += '<button type="button" class="btn btn-sm btn-outline-primary" style="padding: 2px 6px; font-size: 11px;" onclick="loadMaterialRequests('+row.ticket_id+', \'WO-'+ticket_ref_code+'-'+row.ticket_id+'\')"><i class="icon-cube mr-1"></i> View Requests</button>';
                        html += '</td>';
                        html += '</tr>';
                    });
                } else {
                    html = '<tr><td colspan="5" class="text-center text-muted py-3">No work orders found for this ticket.</td></tr>';
                }
                $('#tbl_mat_req_work_orders tbody').html(html);
            } else {
                $('#tbl_mat_req_work_orders tbody').html('<tr><td colspan="5" class="text-center text-danger py-3">Error: '+response.message+'</td></tr>');
            }
        },
        error: function() {
            $('#tbl_mat_req_work_orders tbody').html('<tr><td colspan="5" class="text-center text-danger py-3">Failed to load data.</td></tr>');
        }
    });
}

function loadMaterialRequests(ticket_id, wo_format) {
    $('#mat_req_selected_wo').text(wo_format);
    
    // Transition UI
    $('#mat_req_level_1').addClass('d-none');
    $('#mat_req_level_2').removeClass('d-none');
    $('#mat_req_level_3').addClass('d-none');
    
    $('#tbl_mat_req_requests tbody').html('<tr><td colspan="4" class="text-center py-3"><i class="icon-spinner2 spinner mr-2"></i> Loading Requests...</td></tr>');
    
    $.ajax({
        type: 'POST',
        url: '../controller/ticket/get_material_requisition_tree.php',
        data: { action: 'get_requests', ticket_id: ticket_id },
        dataType: 'json',
        success: function(response) {
            if(response.success) {
                var html = '';
                if(response.data.length > 0) {
                    $.each(response.data, function(i, row) {
                        var status_badge = '';
                        if(row.status == 'Completed') status_badge = '<span class="badge badge-success">Completed</span>';
                        else if(row.status == 'Partial Issue') status_badge = '<span class="badge badge-info">Partial Issue</span>';
                        else if(row.status == 'Pending') status_badge = '<span class="badge badge-warning">Pending</span>';
                        else status_badge = '<span class="badge badge-secondary">'+row.status+'</span>';
                        
                        html += '<tr>';
                        html += '<td>THC-MREQ-'+row.request_id+'</td>';
                        html += '<td>'+moment(row.request_date).format('DD-MM-YYYY hh:mm A')+'</td>';
                        html += '<td>'+status_badge+'</td>';
                        html += '<td class="text-center">';
                        html += '<button type="button" class="btn btn-sm btn-outline-success" style="padding: 2px 6px; font-size: 11px;" onclick="loadMaterialRequestItems('+row.request_id+')"><i class="icon-list3 mr-1"></i> View Items</button>';
                        html += '</td>';
                        html += '</tr>';
                    });
                } else {
                    html = '<tr><td colspan="4" class="text-center text-muted py-3">No material requests found for this work order.</td></tr>';
                }
                $('#tbl_mat_req_requests tbody').html(html);
            } else {
                $('#tbl_mat_req_requests tbody').html('<tr><td colspan="4" class="text-center text-danger py-3">Error: '+response.message+'</td></tr>');
            }
        },
        error: function() {
            $('#tbl_mat_req_requests tbody').html('<tr><td colspan="4" class="text-center text-danger py-3">Failed to load data.</td></tr>');
        }
    });
}

function loadMaterialRequestItems(request_id) {
    $('#mat_req_selected_req').text('THC-MREQ-' + request_id);
    
    // Transition UI
    $('#mat_req_level_1').addClass('d-none');
    $('#mat_req_level_2').addClass('d-none');
    $('#mat_req_level_3').removeClass('d-none');
    
    $('#tbl_mat_req_items tbody').html('<tr><td colspan="5" class="text-center py-3"><i class="icon-spinner2 spinner mr-2"></i> Loading Line Items...</td></tr>');
    
    $.ajax({
        type: 'POST',
        url: '../controller/ticket/get_material_requisition_tree.php',
        data: { action: 'get_request_items', request_id: request_id },
        dataType: 'json',
        success: function(response) {
            if(response.success) {
                var html = '';
                if(response.data.length > 0) {
                    $.each(response.data, function(i, row) {
                        html += '<tr>';
                        html += '<td>'+(row.category_name || '-')+'</td>';
                        html += '<td><strong>'+row.item_code+' - '+row.item_name+'</strong></td>';
                        html += '<td class="text-center text-dark font-weight-bold">'+row.requested_qty+'</td>';
                        html += '<td class="text-center text-success font-weight-bold">'+row.issued_qty+'</td>';
                        html += '<td class="text-center">'+(row.unit || '-')+'</td>';
                        html += '</tr>';
                    });
                } else {
                    html = '<tr><td colspan="5" class="text-center text-muted py-3">No line items found.</td></tr>';
                }
                $('#tbl_mat_req_items tbody').html(html);
            } else {
                $('#tbl_mat_req_items tbody').html('<tr><td colspan="5" class="text-center text-danger py-3">Error: '+response.message+'</td></tr>');
            }
        },
        error: function() {
            $('#tbl_mat_req_items tbody').html('<tr><td colspan="5" class="text-center text-danger py-3">Failed to load data.</td></tr>');
        }
    });
}

function matReqGoBack(level) {
    if(level === 1) {
        $('#mat_req_level_1').removeClass('d-none');
        $('#mat_req_level_2').addClass('d-none');
        $('#mat_req_level_3').addClass('d-none');
    } else if(level === 2) {
        $('#mat_req_level_1').addClass('d-none');
        $('#mat_req_level_2').removeClass('d-none');
        $('#mat_req_level_3').addClass('d-none');
    }
}
