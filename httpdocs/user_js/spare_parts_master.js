$(document).ready(function() {
    // Initialize select2 for filters (no dropdownParent)
    $('#filter_category, #filter_status').select2();

    // Initialize select2 for modal elements
    $('#category, #type_name').select2({
        dropdownParent: $('#modal_spare_part')
    });

    // Initialize DataTable
    var table = $('#tbl_spare_parts_master').DataTable({
        autoWidth: false,
        ajax: {
            url: '../controller/spare_parts/spare_parts_master_controller.php',
            type: 'GET',
            data: function(d) {
                d.action = 'get_spare_parts';
                d.filter_category = $('#filter_category').val();
                d.filter_status = $('#filter_status').val();
            },
            dataSrc: 'data'
        },
        columns: [
            { 
                data: null,
                searchable: false,
                orderable: false,
                targets: 0
            },
            { data: 'category' },
            { data: 'item_code' },
            { data: 'item_name' },
            { data: 'type_name' },
            { data: 'description' },
            { 
                data: 'status',
                render: function(data, type, row) {
                    var badgeClass = data === 'Active' ? 'badge-success' : 'badge-secondary';
                    return '<span class="badge ' + badgeClass + '">' + data + '</span>';
                }
            },
            {
                data: null,
                className: 'text-center',
                render: function(data, type, row) {
                    var toggleStatusStr = row.status === 'Active' ? 'Deactivate' : 'Activate';
                    var toggleStatusClass = row.status === 'Active' ? 'text-warning' : 'text-success';
                    var toggleStatusIcon = row.status === 'Active' ? 'icon-blocked' : 'icon-checkmark3';
                    
                    return `
                        <div class="list-icons">
                            <a href="#" class="list-icons-item text-primary btn_edit" data-id="${row.id}" title="Edit"><i class="icon-pencil5"></i></a>
                            <a href="#" class="list-icons-item ${toggleStatusClass} btn_toggle_status" data-id="${row.id}" data-status="${row.status}" title="${toggleStatusStr}"><i class="${toggleStatusIcon}"></i></a>
                            <a href="#" class="list-icons-item text-danger btn_delete" data-id="${row.id}" title="Delete"><i class="icon-trash"></i></a>
                        </div>
                    `;
                }
            }
        ],
        order: [[1, 'asc'], [3, 'asc']],
        dom: '<"datatable-header"flB><"datatable-scroll"t><"datatable-footer"ip>',
        buttons: [
            {
                extend: 'excelHtml5',
                className: 'btn btn-light text-success',
                text: '<i class="icon-file-excel mr-2"></i> Excel',
                title: function() {
                    var selectedCategory = $('#filter_category').val();
                    var categoryText = selectedCategory ? selectedCategory : 'All Categories';
                    return 'THC - Material List - ' + categoryText;
                },
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6 ], // Exclude action column
                    format: {
                        body: function (data, row, column, node) {
                            // Extracts pure text from the DOM node (fixes serial number and badge HTML)
                            return $(node).text().trim();
                        }
                    }
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

    // Update serial numbers on draw/search/order
    table.on('order.dt search.dt draw.dt', function () {
        table.column(0, {search:'applied', order:'applied'}).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    });

    // Handle Search Button Click
    $('#btn_search_materials').on('click', function() {
        table.ajax.reload();
    });

    // Show Add Modal
    $('#btn_add_spare_part').on('click', function() {
        $('#frm_spare_part')[0].reset();
        $('#category').val('').trigger('change');
        $('#type_name').val('').trigger('change');
        $('#part_id').val('');
        $('#action').val('add_spare_part');
        $('#modal_title').text('Add Material');
        $('#modal_spare_part').modal('show');
    });

    // Handle Edit Click
    $('#tbl_spare_parts_master tbody').on('click', '.btn_edit', function(e) {
        e.preventDefault();
        var data = table.row($(this).parents('tr')).data();
        if(data === undefined) {
             data = table.row($(this)).data(); // in case of responsive layout
        }
        
        $('#part_id').val(data.id);
        $('#item_code').val(data.item_code);
        $('#item_name').val(data.item_name);
        $('#description').val(data.description);
        
        $('#category').val(data.category).trigger('change');
        $('#type_name').val(data.type_name).trigger('change');
        
        $('#action').val('update_spare_part');
        $('#modal_title').text('Edit Material');
        $('#modal_spare_part').modal('show');
    });

    // Handle Form Submit
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
                    table.ajax.reload();
                } else {
                    swal("Error", response.message, "error");
                }
            },
            error: function() {
                swal("Error", "An unexpected error occurred.", "error");
            }
        });
    });

    // Handle Delete Click
    $('#tbl_spare_parts_master tbody').on('click', '.btn_delete', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this material!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: '../controller/spare_parts/spare_parts_master_controller.php',
                    type: 'POST',
                    data: { action: 'delete_spare_part', part_id: id },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            swal("Deleted!", response.message, "success");
                            table.ajax.reload();
                        } else {
                            swal("Error", response.message, "error");
                        }
                    },
                    error: function() {
                        swal("Error", "An unexpected error occurred.", "error");
                    }
                });
            }
        });
    });

    // Handle Toggle Status
    $(document).on('click', '.btn_toggle_status', function() {
        var partId = $(this).data('id');
        var currentStatus = $(this).data('status');
        var newStatus = currentStatus === 'Active' ? 'Inactive' : 'Active';
        
        swal({
            title: "Are you sure?",
            text: "You are about to change the status to " + newStatus + ".",
            icon: "warning",
            buttons: true,
            dangerMode: currentStatus === 'Active',
        })
        .then((willChange) => {
            if (willChange) {
                $.ajax({
                    url: '../controller/spare_parts/spare_parts_master_controller.php',
                    type: 'POST',
                    data: { 
                        action: 'toggle_status',
                        part_id: partId,
                        status: newStatus
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            swal("Success", response.message, "success");
                            table.ajax.reload(null, false);
                        } else {
                            swal("Error", response.message, "error");
                        }
                    },
                    error: function() {
                        swal("Error", "An unexpected error occurred.", "error");
                    }
                });
            }
        });
    });

});
