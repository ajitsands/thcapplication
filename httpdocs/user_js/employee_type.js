$(document).ready(function() {
    list_employee_types();

    $('#btn_employee_type_add').click(function() {
        var name = $('#txt_employee_type_name').val().trim();
        var desc = $('#txt_employee_type_description').val().trim();

        if (name === '') {
            swal("Error", "Please provide Employee Type Name.", "error");
            return;
        }

        var ladda = Ladda.create(this);
        ladda.start();

        $.ajax({
            type: "POST",
            url: "../controller/employee_type/employee_type_controller.php",
            data: {
                action: 'add_employee_type',
                v_employee_type_name: name,
                v_employee_type_description: desc
            },
            success: function(response) {
                ladda.stop();
                if (response.trim() === 'Success') {
                    swal("Success", "Employee Type Added Successfully", "success");
                    clearForm();
                    list_employee_types();
                } else {
                    swal("Error", response, "error");
                }
            }
        });
    });

    $('#btn_employee_type_edit').click(function() {
        var id = $('#txt_employee_type_id').val();
        var name = $('#txt_employee_type_name').val().trim();
        var desc = $('#txt_employee_type_description').val().trim();

        if (name === '') {
            swal("Error", "Please provide Employee Type Name.", "error");
            return;
        }

        var ladda = Ladda.create(this);
        ladda.start();

        $.ajax({
            type: "POST",
            url: "../controller/employee_type/employee_type_controller.php",
            data: {
                action: 'update_employee_type',
                v_employee_type_id: id,
                v_employee_type_name: name,
                v_employee_type_description: desc
            },
            success: function(response) {
                ladda.stop();
                if (response.trim() === 'Success') {
                    swal("Success", "Employee Type Updated Successfully", "success");
                    clearForm();
                    list_employee_types();
                } else {
                    swal("Error", response, "error");
                }
            }
        });
    });

    $('#btn_employee_type_new').click(function() {
        clearForm();
    });
});

function clearForm() {
    $('#txt_employee_type_id').val('');
    $('#txt_employee_type_name').val('');
    $('#txt_employee_type_description').val('');
    $('#btn_employee_type_add').show();
    $('#btn_employee_type_edit').hide();
    $('#btn_employee_type_new').hide();
}

function list_employee_types() {
    if ($.fn.DataTable.isDataTable('#list_of_employee_types')) {
        $('#list_of_employee_types').DataTable().destroy();
    }

    var table = $('#list_of_employee_types').DataTable({
        "ajax": {
            "url": "../controller/employee_type/employee_type_controller.php",
            "type": "POST",
            "data": { action: "list_employee_types" },
            "dataSrc": "data"
        },
        "columns": [
            {
                "data": null,
                "render": function(data, type, row, meta) {
                    return meta.row + 1;
                }
            },
            { "data": "user_type_name" },
            { "data": "user_type_description" },
            { "data": "assigned_count" },
            {
                "data": "user_type_status",
                "render": function(data, type, row) {
                    if (data === 'Active') {
                        return '<span class="badge badge-success">Active</span>';
                    } else {
                        return '<span class="badge badge-danger">Deactive</span>';
                    }
                }
            },
            {
                "data": null,
                "render": function(data, type, row) {
                    var editBtn = '<a href="javascript:void(0)" onclick="edit_employee_type(\'' + row.user_type_id + '\', \'' + btoa(unescape(encodeURIComponent(row.user_type_name))) + '\', \'' + btoa(unescape(encodeURIComponent(row.user_type_description))) + '\')" class="list-icons-item text-primary-600"><i class="icon-pencil7"></i></a>';
                    
                    var statusBtn = '';
                    if (row.user_type_status === 'Active') {
                        statusBtn = '<a href="javascript:void(0)" onclick="change_status(\'' + row.user_type_id + '\', \'Deactive\')" class="list-icons-item text-danger-600 ml-2" title="Deactivate"><i class="icon-cancel-circle2"></i></a>';
                    } else {
                        statusBtn = '<a href="javascript:void(0)" onclick="change_status(\'' + row.user_type_id + '\', \'Active\')" class="list-icons-item text-success-600 ml-2" title="Activate"><i class="icon-checkmark4"></i></a>';
                    }

                    var deleteBtn = '';
                    if (parseInt(row.assigned_count) === 0) {
                        deleteBtn = '<a href="javascript:void(0)" onclick="delete_employee_type(\'' + row.user_type_id + '\')" class="list-icons-item text-danger-600 ml-2" title="Delete"><i class="icon-trash"></i></a>';
                    }

                    return '<div class="list-icons">' + editBtn + statusBtn + deleteBtn + '</div>';
                }
            }
        ],
        "dom": '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
        "language": {
            search: '<span>Filter:</span> _INPUT_',
            lengthMenu: '<span>Show:</span> _MENU_',
            paginate: { 'first': 'First', 'last': 'Last', 'next': '→', 'previous': '←' }
        }
    });
}

function edit_employee_type(id, nameBase64, descBase64) {
    var name = decodeURIComponent(escape(atob(nameBase64)));
    var desc = decodeURIComponent(escape(atob(descBase64)));

    $('#txt_employee_type_id').val(id);
    $('#txt_employee_type_name').val(name);
    $('#txt_employee_type_description').val(desc);

    $('#btn_employee_type_add').hide();
    $('#btn_employee_type_edit').show();
    $('#btn_employee_type_new').show();
    
    // Scroll to top smoothly
    $('html, body').animate({
        scrollTop: 0
    }, 'fast');
}

function change_status(id, new_status) {
    swal({
        title: "Are you sure?",
        text: "You want to " + (new_status === 'Active' ? 'Activate' : 'Deactivate') + " this Employee Type!",
        icon: "warning",
        buttons: true,
        dangerMode: new_status !== 'Active',
    })
    .then((willChange) => {
        if (willChange) {
            $.ajax({
                type: "POST",
                url: "../controller/employee_type/employee_type_controller.php",
                data: {
                    action: 'change_employee_type_status',
                    v_employee_type_id: id,
                    v_employee_type_action: new_status
                },
                success: function(response) {
                    if (response.trim() === 'Success') {
                        swal("Success", "Status Changed Successfully", "success");
                        list_employee_types();
                    } else {
                        swal("Error", response, "error");
                    }
                }
            });
        }
    });
}

function delete_employee_type(id) {
    swal({
        title: "Are you sure?",
        text: "You want to completely delete this Employee Type! This cannot be undone.",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            $.ajax({
                type: "POST",
                url: "../controller/employee_type/employee_type_controller.php",
                data: {
                    action: 'delete_employee_type',
                    v_employee_type_id: id
                },
                success: function(response) {
                    if (response.trim() === 'Success') {
                        swal("Deleted", "Employee Type Deleted Successfully", "success");
                        list_employee_types();
                    } else {
                        swal("Error", response, "error");
                    }
                }
            });
        }
    });
}
