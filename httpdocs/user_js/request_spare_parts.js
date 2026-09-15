$(document).ready(function() {
    // Initialize select2
    $('.select2').select2();
    
    // Initialize DataTable
    function initDataTable() {
        if ($.fn.DataTable.isDataTable('#tbl_requests_list')) {
            $('#tbl_requests_list').DataTable().destroy();
        }
        if ($('#tbl_requests_list').length) {
            $('#tbl_requests_list').DataTable({
                autoWidth: false,
                order: [[0, 'desc']],
                dom: '<"datatable-header"flB><"datatable-scroll-wrap"t><"datatable-footer"ip>',
                buttons: [
                    {
                        text: '<i class="icon-printer mr-2"></i> Print Report',
                        className: 'btn btn-template-print',
                        action: function ( e, dt, node, config ) {
                            var queryStr = $('#frm_filters').serialize();
                            window.open('request_spare_parts_print.php?' + queryStr, '_blank');
                        }
                    }
                ],
                language: {
                    search: '<span>Filter:</span> _INPUT_',
                    searchPlaceholder: 'Type to filter...',
                    lengthMenu: '<span>Show:</span> _MENU_',
                    paginate: { 'first': 'First', 'last': 'Last', 'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;', 'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;' }
                }
            });
        }
    }

    initDataTable();

    function refreshDataTable() {
        var queryStr = $('#frm_filters').serialize();
        $.get(window.location.pathname + '?' + queryStr, function(html) {
            var $newTable = $(html).find('#tbl_requests_list');
            $('#tbl_requests_list').html($newTable.html());
            initDataTable();
        });
    }

    // Handle Filter Customer change
    $('#filter_customer').on('change', function() {
        var customer_id = $(this).val();
        var $workorderSelect = $('#filter_workorder');
        
        $workorderSelect.empty().append('<option value="">All</option>');
        
        if (customer_id) {
            $workorderSelect.prop('disabled', false);
            $.ajax({
                url: '../controller/spare_parts/get_workorders.php',
                type: 'GET',
                data: { customer_id: customer_id },
                dataType: 'json',
                success: function(response) {
                    $.each(response, function(index, item) {
                        $workorderSelect.append(new Option(item.text, item.id, false, false));
                    });
                }
            });
        } else {
            $workorderSelect.prop('disabled', true);
        }
    });

    $('#btn_apply_filter').on('click', function() {
        refreshDataTable();
    });

    $('#btn_clear_filter').on('click', function() {
        $('#frm_filters')[0].reset();
        $('#frm_filters .select2').val('').trigger('change');
        refreshDataTable();
    });

    // Handle Customer change
    $('#customer_id').on('change', function() {
        var customer_id = $(this).val();
        var $workorderSelect = $('#workorder_id');
        
        $workorderSelect.empty().append('<option value="">-- Select Workorder --</option>');
        $workorderSelect.prop('disabled', true);
        
        if (customer_id) {
            $.ajax({
                url: '../controller/spare_parts/get_workorders.php',
                type: 'GET',
                data: { customer_id: customer_id },
                dataType: 'json',
                success: function(response) {
                    $.each(response, function(index, item) {
                        $workorderSelect.append(new Option(item.text, item.id, false, false));
                    });
                    $workorderSelect.prop('disabled', false);
                },
                error: function() {
                    swal("Error", "Could not fetch workorders.", "error");
                }
            });
        }
    });

    var rowIdx = 0;

    // Handle Add Item
    $('#btn_add_item').on('click', function() {
        var tr = `
            <tr id="row_${rowIdx}">
                <td>
                    <select class="form-control select2-category row_category" data-row="${rowIdx}" name="items[${rowIdx}][category]" required>
                        ${categoryOptionsHtml}
                    </select>
                </td>
                <td>
                    <select class="form-control select2-item item_id" name="items[${rowIdx}][item_id]" id="item_id_${rowIdx}" required disabled>
                        <option value="">-- Select Category First --</option>
                    </select>
                </td>
                <td>
                    <input type="number" class="form-control item_qty" name="items[${rowIdx}][quantity]" min="1" value="1" required>
                </td>
                <td>
                    <input type="text" class="form-control" name="items[${rowIdx}][unit]" placeholder="Unit (e.g. Nos, Kg)">
                </td>
                <td>
                    <input type="text" class="form-control" name="items[${rowIdx}][remarks]" placeholder="Remarks">
                </td>
                <td class="text-center">
                    <a href="#" class="list-icons-item text-danger btn_remove_row" data-row="${rowIdx}" title="Remove Item"><i class="icon-trash"></i></a>
                </td>
            </tr>
        `;
        $('#tbl_items tbody').append(tr);
        
        // Initialize select2 for the new row
        $('#row_' + rowIdx + ' .select2-category').select2();
        $('#row_' + rowIdx + ' .select2-item').select2();
        rowIdx++;
    });

    // Handle Category change in a specific row
    $(document).on('change', '.row_category', function() {
        var category = $(this).val();
        var row = $(this).data('row');
        var $itemSelect = $('#item_id_' + row);
        
        $itemSelect.empty().append('<option value="">-- Select Item --</option>');
        
        if (category) {
            $itemSelect.prop('disabled', false);
            // Fetch items for this category
            $.ajax({
                url: '../controller/spare_parts/get_items.php',
                type: 'GET',
                data: { category: category },
                dataType: 'json',
                success: function(response) {
                    $.each(response, function(index, item) {
                        $itemSelect.append(new Option(item.text, item.id, false, false));
                    });
                    $itemSelect.trigger('change');
                },
                error: function() {
                    swal("Error", "Could not fetch items.", "error");
                }
            });
        } else {
            $itemSelect.prop('disabled', true);
            $itemSelect.empty().append('<option value="">-- Select Category First --</option>');
            $itemSelect.trigger('change');
        }
    });

    // Remove row
    $(document).on('click', '.btn_remove_row', function() {
        var row = $(this).data('row');
        $('#row_' + row).remove();
    });

    // Handle Save Form
    $('#frm_request_spare_parts').on('submit', function(e) {
        e.preventDefault();

        if ($('.item_id').length === 0) {
            swal("Warning", "Please add at least one item.", "warning");
            return;
        }

        var formData = new FormData($('#frm_request_spare_parts')[0]);

        $.ajax({
            url: '../controller/spare_parts/save_request.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    swal("Success", response.message, "success").then(() => {
                        $('#frm_request_spare_parts')[0].reset();
                        $('#customer_id').val('').trigger('change');
                        $('#tbl_items tbody').empty();
                        rowIdx = 0;
                        refreshDataTable();
                        $('.nav-tabs a[href="#bottom-tab2"]').tab('show');
                    });
                } else {
                    swal("Error", response.message, "error");
                }
            },
            error: function() {
                swal("Error", "An unexpected error occurred.", "error");
            }
        });
    });

    // Handle View Items button in the list
    $(document).on('click', '.btn_view_items', function() {
        var requestId = $(this).data('id');
        $('#current_modal_request_id').val(requestId);
        
        var $tr = $(this).closest('tr');
        var reqNo = $tr.find('td:eq(0)').text();
        var customerName = $tr.find('td:eq(1)').text();
        var workorderName = $tr.find('td:eq(2)').text();
        
        $('#view_req_no').text(reqNo);
        $('#view_customer').text(customerName);
        $('#view_workorder').text(workorderName);
        
        loadModalItems(requestId);
        $('#modal_view_items').modal('show');
    });

    function loadModalItems(requestId) {
        var $tbody = $('#tbl_modal_items tbody');
        $tbody.html('<tr><td colspan="5" class="text-center">Loading...</td></tr>');

        $.ajax({
            url: '../controller/spare_parts/get_request_items.php',
            type: 'GET',
            data: { request_id: requestId },
            dataType: 'json',
            success: function(response) {
                $tbody.empty();
                if (response.length > 0) {
                    $.each(response, function(index, item) {
                        var reqQty = parseInt(item.quantity);
                        var issQty = parseInt(item.issued_qty);
                        var remaining = reqQty - issQty;
                        
                        var actionHtml = '';
                        if (remaining > 0) {
                            actionHtml = `
                                <div class="input-group input-group-sm">
                                    <input type="number" class="form-control txt_issue_qty" min="1" max="${remaining}" value="${remaining}" style="width: 60px;">
                                    <span class="input-group-append">
                                        <button class="btn btn-success btn_issue_item" data-itemid="${item.request_item_id}">Issue</button>
                                    </span>
                                </div>
                            `;
                        } else {
                            actionHtml = `<span class="badge badge-success">Fully Issued</span>`;
                        }

                        $tbody.append(`
                            <tr>
                                <td>${item.category_name}</td>
                                <td>${item.item_name}</td>
                                <td>${item.unit ? item.unit : '-'}</td>
                                <td>${item.remarks ? item.remarks : '-'}</td>
                                <td>${reqQty}</td>
                                <td>${issQty}</td>
                                <td>${actionHtml}</td>
                            </tr>
                        `);
                    });
                } else {
                    $tbody.html('<tr><td colspan="5" class="text-center">No items found.</td></tr>');
                }
            },
            error: function() {
                $tbody.html('<tr><td colspan="5" class="text-center text-danger">Failed to fetch items.</td></tr>');
            }
        });
    }

    // Handle Issue Item Button
    $(document).on('click', '.btn_issue_item', function() {
        var $btn = $(this);
        var requestItemId = $btn.data('itemid');
        var requestId = $('#current_modal_request_id').val();
        var issueQty = $btn.closest('td').find('.txt_issue_qty').val();

        if (issueQty <= 0) {
            swal("Warning", "Please enter a valid quantity to issue.", "warning");
            return;
        }

        $btn.prop('disabled', true).text('...');
        
        $.ajax({
            url: '../controller/spare_parts/issue_spare_part.php',
            type: 'POST',
            data: { 
                request_item_id: requestItemId,
                request_id: requestId,
                issue_qty: issueQty
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    swal("Success", response.message, "success");
                    loadModalItems(requestId); // reload the modal items
                    refreshDataTable(); // refresh the background list
                } else {
                    swal("Error", response.message, "error");
                    $btn.prop('disabled', false).text('Issue');
                }
            },
            error: function() {
                swal("Error", "Failed to issue item.", "error");
                $btn.prop('disabled', false).text('Issue');
            }
        });
    });

    // Handle Close Request button
    $(document).on('click', '.btn_close_request', function() {
        var requestId = $(this).data('id');
        swal({
            title: "Are you sure?",
            text: "This will manually close the request even if not fully issued.",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willClose) => {
            if (willClose) {
                $.ajax({
                    url: '../controller/spare_parts/close_request.php',
                    type: 'POST',
                    data: { request_id: requestId },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            swal("Success", response.message, "success").then(() => {
                                refreshDataTable();
                            });
                        } else {
                            swal("Error", response.message, "error");
                        }
                    },
                    error: function() {
                        swal("Error", "Failed to close request.", "error");
                    }
                });
            }
        });
    });

    // Handle View History button
    $(document).on('click', '.btn_view_history', function() {
        var requestId = $(this).data('id');
        var $tbody = $('#tbl_modal_history tbody');
        
        var $tr = $(this).closest('tr');
        var reqNo = $tr.find('td:eq(0)').text();
        var customerName = $tr.find('td:eq(1)').text();
        var workorderName = $tr.find('td:eq(2)').text();
        
        $('#hist_req_no').text(reqNo);
        $('#hist_customer').text(customerName);
        $('#hist_workorder').text(workorderName);
        
        $tbody.html('<tr><td colspan="6" class="text-center">Loading...</td></tr>');
        $('#modal_issue_history').modal('show');

        $.ajax({
            url: '../controller/spare_parts/get_issue_history.php',
            type: 'GET',
            data: { request_id: requestId },
            dataType: 'json',
            success: function(response) {
                $tbody.empty();
                if (response.length > 0) {
                    $.each(response, function(index, item) {
                        var dateStr = item.issued_date ? item.issued_date : '<span class="text-muted">Not Issued</span>';
                        var userStr = item.issued_by_username ? item.issued_by_username : '-';
                        var badgeClass = item.issued_qty > 0 ? 'badge-success' : 'badge-secondary';
                        
                        $tbody.append(`
                            <tr>
                                <td>${item.category}</td>
                                <td>${item.item_name}</td>
                                <td>${item.req_qty}</td>
                                <td><span class="badge ${badgeClass}">${item.issued_qty}</span></td>
                                <td>${dateStr}</td>
                                <td>${userStr}</td>
                            </tr>
                        `);
                    });
                } else {
                    $tbody.html('<tr><td colspan="5" class="text-center">No history found.</td></tr>');
                }
            },
            error: function() {
                $tbody.html('<tr><td colspan="5" class="text-center text-danger">Failed to fetch history.</td></tr>');
            }
        });
    });

    // Handle Create New Material Modal
    $('#btn_add_spare_part').on('click', function() {
        $('#frm_spare_part')[0].reset();
        
        // Auto-select the category if the user already selected one on the main page
        var mainCategory = $('#category').val();
        if (mainCategory) {
            $('#modal_category').val(mainCategory).trigger('change');
        } else {
            $('#modal_category').val('').trigger('change');
        }
        
        $('#type_name').val('').trigger('change');
        $('#part_id').val('');
        $('#action').val('add_spare_part');
        $('#modal_title').text('Add Material');
        
        // Initialize select2 for modal elements if not already done
        $('#modal_category, #type_name').select2({
            dropdownParent: $('#modal_spare_part')
        });
        
        $('#modal_spare_part').modal('show');
    });

    // Handle Create New Material Form Submit
    $('#frm_spare_part').on('submit', function(e) {
        e.preventDefault();
        
        var formData = $(this).serialize();
        
        $.ajax({
            url: '../controller/spare_parts/spare_parts_master_controller.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('#modal_spare_part').modal('hide');
                    swal("Success", response.message, "success");
                    
                    // If the newly created material matches a category currently selected in any row, refresh that row's dropdown
                    var modalCategory = $('#modal_category').val();
                    if (response.new_id && response.item_name) {
                        $('.row_category').each(function() {
                            if ($(this).val() === modalCategory) {
                                var rowIdx = $(this).data('row');
                                var $itemSelect = $('#item_id_' + rowIdx);
                                var newOption = new Option(response.item_name, response.new_id, false, false);
                                $itemSelect.append(newOption).trigger('change');
                            }
                        });
                    }
                } else {
                    swal("Error", response.message, "error");
                }
            },
            error: function() {
                swal("Error", "An unexpected error occurred.", "error");
            }
        });
    });

    // Edit Request logic
    var editRowIdx = 0;

    $(document).on('click', '.btn_edit_request', function() {
        var $btn = $(this);
        var requestId = $btn.data('id');
        
        $.ajax({
            url: '../controller/spare_parts/get_request_details_for_edit.php',
            type: 'GET',
            data: { request_id: requestId },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('#edit_request_id').val(response.header.id);
                    $('#edit_request_id_display').text('#THC-MREQ-' + response.header.id);
                    
                    var $tr = $btn.closest('tr');
                    var customerName = $tr.find('td:eq(1)').text();
                    var workorderName = $tr.find('td:eq(2)').text();
                    $('#edit_customer_name').val(customerName);
                    $('#edit_workorder_name').val(workorderName);

                    // Attachment link
                    if (response.header.attachment_path) {
                        $('#edit_current_attachment_link').html('Current: <a href="../httpdocs/uploads/request_attachments/' + response.header.attachment_path + '" target="_blank">View File</a>');
                    } else {
                        $('#edit_current_attachment_link').html('No attachment currently.');
                    }
                    $('#edit_request_attachment').val(''); // clear file input

                    // Populate items
                    var $tbody = $('#tbl_edit_items tbody');
                    $tbody.empty();
                    editRowIdx = 0;

                    $.each(response.items, function(index, item) {
                        var issQty = parseInt(item.issued_qty);
                        var isLocked = issQty > 0;
                        
                        var tr = `
                            <tr id="edit_row_${editRowIdx}">
                                <input type="hidden" name="items[${editRowIdx}][request_item_id]" value="${item.request_item_id}">
                                <td>
                                    <select class="form-control select2-category edit_row_category" data-row="${editRowIdx}" name="items[${editRowIdx}][category]" required ${isLocked ? 'disabled' : ''}>
                                        <option value="${item.category_name}">${item.category_name}</option>
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control select2-item item_id" name="items[${editRowIdx}][item_id]" id="edit_item_id_${editRowIdx}" required ${isLocked ? 'disabled' : ''}>
                                        <option value="${item.item_id}">${item.item_name}</option>
                                    </select>
                                    ${isLocked ? `<input type="hidden" name="items[${editRowIdx}][item_id]" value="${item.item_id}">` : ''}
                                </td>
                                <td>
                                    <input type="number" class="form-control" name="items[${editRowIdx}][quantity]" min="${issQty > 1 ? issQty : 1}" value="${item.quantity}" required ${isLocked ? 'readonly' : ''}>
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="items[${editRowIdx}][unit]" value="${item.unit || ''}" ${isLocked ? 'readonly' : ''}>
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="items[${editRowIdx}][remarks]" value="${item.remarks || ''}" ${isLocked ? 'readonly' : ''}>
                                </td>
                                <td>${issQty}</td>
                                <td class="text-center">
                                    ${!isLocked ? `<a href="#" class="list-icons-item text-danger btn_remove_edit_row" data-row="${editRowIdx}" title="Remove Item"><i class="icon-trash"></i></a>` : '<span class="text-muted"><i class="icon-lock2"></i></span>'}
                                </td>
                            </tr>
                        `;
                        $tbody.append(tr);
                        
                        // Initialize select2
                        $('#edit_row_' + editRowIdx + ' .select2-category').select2({ dropdownParent: $('#modal_edit_request') });
                        $('#edit_row_' + editRowIdx + ' .select2-item').select2({ dropdownParent: $('#modal_edit_request') });
                        
                        editRowIdx++;
                    });
                    
                    $('#modal_edit_request').modal('show');
                } else {
                    swal("Error", response.message, "error");
                }
            },
            error: function() {
                swal("Error", "Failed to fetch request details.", "error");
            }
        });
    });

    // Handle Edit Add Item
    $('#btn_edit_add_item').on('click', function() {
        var tr = `
            <tr id="edit_row_${editRowIdx}">
                <input type="hidden" name="items[${editRowIdx}][request_item_id]" value="new">
                <td>
                    <select class="form-control select2-category edit_row_category" data-row="${editRowIdx}" name="items[${editRowIdx}][category]" required>
                        ${categoryOptionsHtml}
                    </select>
                </td>
                <td>
                    <select class="form-control select2-item item_id" name="items[${editRowIdx}][item_id]" id="edit_item_id_${editRowIdx}" required disabled>
                        <option value="">-- Select Category First --</option>
                    </select>
                </td>
                <td>
                    <input type="number" class="form-control" name="items[${editRowIdx}][quantity]" min="1" value="1" required>
                </td>
                <td>
                    <input type="text" class="form-control" name="items[${editRowIdx}][unit]" placeholder="Unit">
                </td>
                <td>
                    <input type="text" class="form-control" name="items[${editRowIdx}][remarks]" placeholder="Remarks">
                </td>
                <td>0</td>
                <td class="text-center">
                    <a href="#" class="list-icons-item text-danger btn_remove_edit_row" data-row="${editRowIdx}" title="Remove Item"><i class="icon-trash"></i></a>
                </td>
            </tr>
        `;
        $('#tbl_edit_items tbody').append(tr);
        
        $('#edit_row_' + editRowIdx + ' .select2-category').select2({ dropdownParent: $('#modal_edit_request') });
        $('#edit_row_' + editRowIdx + ' .select2-item').select2({ dropdownParent: $('#modal_edit_request') });
        editRowIdx++;
    });

    // Remove row in Edit modal
    $(document).on('click', '.btn_remove_edit_row', function() {
        var row = $(this).data('row');
        $('#edit_row_' + row).remove();
    });

    // Handle Edit Modal Category change
    $(document).on('change', '.edit_row_category', function() {
        var category = $(this).val();
        var row = $(this).data('row');
        var $itemSelect = $('#edit_item_id_' + row);
        
        $itemSelect.empty().append('<option value="">-- Select Item --</option>');
        
        if (category) {
            $itemSelect.prop('disabled', false);
            $.ajax({
                url: '../controller/spare_parts/get_items.php',
                type: 'GET',
                data: { category: category },
                dataType: 'json',
                success: function(response) {
                    $.each(response, function(index, item) {
                        $itemSelect.append(new Option(item.text, item.id, false, false));
                    });
                    $itemSelect.trigger('change');
                }
            });
        } else {
            $itemSelect.prop('disabled', true);
            $itemSelect.trigger('change');
        }
    });

    // Submit Edit Request Form
    $('#frm_edit_request').on('submit', function(e) {
        e.preventDefault();

        if ($('#tbl_edit_items .item_id').length === 0) {
            swal("Warning", "Please add at least one item.", "warning");
            return;
        }

        var formData = new FormData($('#frm_edit_request')[0]);

        $.ajax({
            url: '../controller/spare_parts/update_request.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    swal("Success", response.message, "success").then(() => {
                        $('#modal_edit_request').modal('hide');
                        refreshDataTable();
                    });
                } else {
                    swal("Error", response.message, "error");
                }
            },
            error: function() {
                swal("Error", "Failed to update request.", "error");
            }
        });
    });
});
