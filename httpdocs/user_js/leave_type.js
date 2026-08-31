$(document).ready(function() {
    var v_btn_leave_type_add = $('#btn_leave_type_add').ladda();
    var v_btn_leave_type_edit = $('#btn_leave_type_edit').ladda();
    var v_btn_leave_type_new = $('#btn_leave_type_new').ladda();

    $('#btn_leave_type_edit').hide();
    $('#btn_leave_type_new').hide();

    // Color picker synchronization
    $('#input_leave_type_color').on('input change', function() {
        var colorVal = $(this).val();
        $('#txt_leave_type_color_hex').val(colorVal);
        $('#color_preview_badge').css('background-color', colorVal);
    });

    $('#txt_leave_type_color_hex').on('input change', function() {
        var hexVal = $(this).val();
        if (/^#[0-9A-F]{6}$/i.test(hexVal)) {
            $('#input_leave_type_color').val(hexVal);
            $('#color_preview_badge').css('background-color', hexVal);
        }
    });

    // Preset color click
    $('.preset-color-btn').click(function() {
        var col = $(this).data('color');
        $('#input_leave_type_color').val(col);
        $('#txt_leave_type_color_hex').val(col);
        $('#color_preview_badge').css('background-color', col);
    });

    var leave_type_list_table = $('#list_of_leave_types').DataTable({});
    load_data_to_grid_leave_types();

    // Insert leave type
    v_btn_leave_type_add.click(function() {
        v_btn_leave_type_add.ladda('start');
        var name = $.trim($('#txt_leave_type_name').val());
        var color = $('#txt_leave_type_color_hex').val() || $('#input_leave_type_color').val();
        var desc = $.trim($('#txt_leave_type_description').val());

        if (name === "") {
            swal("Warning", "Please provide Leave Type Name.", "warning");
            v_btn_leave_type_add.ladda('stop');
            return false;
        }

        $.post("../controller/leave_type/leave_type_controller.php", {
            action: 'add_leave_type',
            v_leave_type_name: name,
            v_leave_type_color: color,
            v_leave_type_description: desc
        }, function(result) {
            v_btn_leave_type_add.ladda('stop');
            result = $.trim(result);
            if (result === 'Success') {
                swal("Success", "New Leave Type added successfully!", "success");
                reset_form();
                load_data_to_grid_leave_types();
            } else {
                swal("Error", result, "error");
            }
        });
    });

    // Load data to DataTable
    function load_data_to_grid_leave_types() {
        leave_type_list_table.destroy();
        leave_type_list_table = $('#list_of_leave_types').DataTable({
            "ajax": {
                'type': 'POST',
                'url': '../controller/leave_type/leave_type_controller.php',
                'data': {
                    action: 'list_leave_types'
                }
            },
            "language": {
                "zeroRecords": "No leave types available",
                "infoEmpty": "No records available"
            },
            "order": [[0, "desc"]],
            "Paginate": true,
            "bLengthChange": true,
            "bFilter": true,
            "bInfo": true,
            "autoWidth": false,
            "columns": [
                { "data": null },
                { "data": "leave_type_id", "visible": false },
                {
                    "data": "leave_type_name",
                    render: function(data, type, row) {
                        var col = row.leave_type_color || '#26a69a';
                        return '<span class="badge badge-pill text-white px-2 py-1" style="background-color:' + col + '; font-size:12px;"><i class="icon-dot mr-1"></i>' + data + '</span>';
                    }
                },
                {
                    "data": "leave_type_color",
                    render: function(data) {
                        return '<div class="d-flex align-items-center"><span style="display:inline-block; width:18px; height:18px; border-radius:3px; background-color:' + data + '; margin-right:8px; border:1px solid #ccc;"></span><code>' + data + '</code></div>';
                    }
                },
                { "data": "leave_type_description" },
                {
                    "data": "leave_type_status",
                    render: function(data) {
                        if (data === 'Active') {
                            return '<span class="badge badge-success">Active</span>';
                        } else {
                            return '<span class="badge badge-danger">Deactive</span>';
                        }
                    }
                },
                {
                    "data": "leave_type_id",
                    render: function(data, type, row) {
                        var dropdownHTML = '<div class="list-icons"><div class="dropdown">' +
                            '<a href="#" class="list-icons-item" data-toggle="dropdown" style="color: #2196f3;"><i class="icon-menu9"></i></a>' +
                            '<div class="dropdown-menu dropdown-menu-right">' +
                            '<a href="#" class="dropdown-item name_Edit" style="color: #ff9800;"><i class="icon-database-edit2 mr-2"></i>Edit</a>';
                        
                        if (row.leave_type_status === 'Active') {
                            dropdownHTML += '<a href="#" class="dropdown-item name_Deactive text-danger"><i class="icon-cross3 mr-2"></i>Deactivate</a>';
                        } else {
                            dropdownHTML += '<a href="#" class="dropdown-item name_Active text-success"><i class="icon-checkmark2 mr-2"></i>Activate</a>';
                        }
                        dropdownHTML += '</div></div></div>';
                        return dropdownHTML;
                    }
                }
            ],
            pageLength: 20,
            responsive: true,
            "fnRowCallback": function(nRow, aData, iDisplayIndex) {
                $("td:eq(0)", nRow).html(iDisplayIndex + 1);
                return nRow;
            }
        });
    }

    // Row actions (Edit / Status)
    $('#list_of_leave_types tbody').on('click', 'a.dropdown-item', function(e) {
        e.preventDefault();
        var $row = $(this).closest('tr');
        var data = leave_type_list_table.row($row).data();
        var v_id = data.leave_type_id;

        if ($(this).hasClass('name_Edit')) {
            $('#txt_leave_type_id').val(v_id);
            $('#txt_leave_type_name').val(data.leave_type_name);
            var col = data.leave_type_color || '#26a69a';
            $('#input_leave_type_color').val(col);
            $('#txt_leave_type_color_hex').val(col);
            $('#color_preview_badge').css('background-color', col);
            $('#txt_leave_type_description').val(data.leave_type_description || '');

            $('#btn_leave_type_add').hide();
            $('#btn_leave_type_edit').show();
            $('#btn_leave_type_new').show();
            $('html, body').animate({ scrollTop: 0 }, 'fast');
        }

        if ($(this).hasClass('name_Active')) {
            $.post("../controller/leave_type/leave_type_controller.php", {
                action: 'change_leave_type_status',
                v_leave_type_id: v_id,
                v_leave_type_action: 'Active'
            }, function() {
                load_data_to_grid_leave_types();
            });
        }

        if ($(this).hasClass('name_Deactive')) {
            $.post("../controller/leave_type/leave_type_controller.php", {
                action: 'change_leave_type_status',
                v_leave_type_id: v_id,
                v_leave_type_action: 'Deactive'
            }, function() {
                load_data_to_grid_leave_types();
            });
        }
    });

    // Update Leave Type
    v_btn_leave_type_edit.click(function() {
        v_btn_leave_type_edit.ladda('start');
        var v_id = $('#txt_leave_type_id').val();
        var name = $.trim($('#txt_leave_type_name').val());
        var color = $('#txt_leave_type_color_hex').val() || $('#input_leave_type_color').val();
        var desc = $.trim($('#txt_leave_type_description').val());

        if (name === "" || !v_id) {
            swal("Warning", "Please provide Leave Type Name.", "warning");
            v_btn_leave_type_edit.ladda('stop');
            return false;
        }

        $.post("../controller/leave_type/leave_type_controller.php", {
            action: 'update_leave_type',
            v_leave_type_id: v_id,
            v_leave_type_name: name,
            v_leave_type_color: color,
            v_leave_type_description: desc
        }, function(result) {
            v_btn_leave_type_edit.ladda('stop');
            result = $.trim(result);
            if (result === 'Success') {
                swal("Success", "Leave Type details updated successfully!", "success");
                reset_form();
                load_data_to_grid_leave_types();
            } else {
                swal("Error", result, "error");
            }
        });
    });

    $('#btn_leave_type_new').click(function() {
        reset_form();
    });

    function reset_form() {
        $('#btn_leave_type_add').show();
        $('#btn_leave_type_edit').hide();
        $('#btn_leave_type_new').hide();
        $('#txt_leave_type_id').val('');
        $('#txt_leave_type_name').val('');
        $('#input_leave_type_color').val('#26a69a');
        $('#txt_leave_type_color_hex').val('#26a69a');
        $('#color_preview_badge').css('background-color', '#26a69a');
        $('#txt_leave_type_description').val('');
    }
});
