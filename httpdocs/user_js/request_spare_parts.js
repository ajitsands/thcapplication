$(document).ready(function() {
    // Initialize select2
    $('.select2').select2();
    
    // Initialize DataTable
    if ($('#tbl_requests_list').length) {
        $('#tbl_requests_list').DataTable({
            autoWidth: false,
            order: [[0, 'desc']],
            dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
            language: {
                search: '<span>Filter:</span> _INPUT_',
                searchPlaceholder: 'Type to filter...',
                lengthMenu: '<span>Show:</span> _MENU_',
                paginate: { 'first': 'First', 'last': 'Last', 'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;', 'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;' }
            }
        });
    }

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
        var category = $('#category').val();
        if (!category) {
            swal("Warning", "Please select a category first.", "warning");
            return;
        }

        // Fetch items for this category
        $.ajax({
            url: '../controller/spare_parts/get_items.php',
            type: 'GET',
            data: { category: category },
            dataType: 'json',
            success: function(response) {
                var options = '<option value="">-- Select Item --</option>';
                $.each(response, function(index, item) {
                    options += '<option value="' + item.id + '">' + item.text + '</option>';
                });

                var tr = `
                    <tr id="row_${rowIdx}">
                        <td>${category}</td>
                        <td>
                            <select class="form-control select2-item item_id" name="items[${rowIdx}][item_id]" required>
                                ${options}
                            </select>
                        </td>
                        <td>
                            <input type="number" class="form-control item_qty" name="items[${rowIdx}][quantity]" min="1" value="1" required>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm btn_remove_row" data-row="${rowIdx}">Remove</button>
                        </td>
                    </tr>
                `;
                $('#tbl_items tbody').append(tr);
                
                // Initialize select2 for the new row
                $('#row_' + rowIdx + ' .select2-item').select2();
                rowIdx++;
            },
            error: function() {
                swal("Error", "Could not fetch items.", "error");
            }
        });
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

        var formData = $(this).serialize();

        $.ajax({
            url: '../controller/spare_parts/save_request.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    swal("Success", response.message, "success").then(() => {
                        window.location.reload();
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
                                window.location.reload();
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
        
        $tbody.html('<tr><td colspan="5" class="text-center">Loading...</td></tr>');
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
});
