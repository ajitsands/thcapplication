function formatComplaintLines(data) {
    if (!data) return '';
    var text = String(data).trim();
    if (text === '') return '';

    if (text.indexOf('*') !== -1) {
        var parts = text.split('*');
        var intro = parts.shift().trim();
        var html = '';
        if (intro !== '') {
            html += '<div class="complaint-intro">' + $('<div>').text(intro).html().replace(/\n/g, '<br>') + '</div>';
        }
        html += '<ul class="complaint-list-items">';
        for (var idx = 0; idx < parts.length; idx++) {
            var item = parts[idx].trim();
            if (item !== '') {
                html += '<li>' + $('<div>').text(item).html().replace(/\n/g, '<br>') + '</li>';
            }
        }
        html += '</ul>';
        return html;
    } else {
        return $('<div>').text(text).html().replace(/\n/g, '<br>');
    }
}

function formatComplaintChildRow(data) {
    var contentHtml = formatComplaintLines(data);
    if (!contentHtml || $.trim(contentHtml) === '') {
        contentHtml = '<span class="text-muted font-italic" style="font-size: 12px;"><i class="icon-info22 mr-1"></i>No complaint description provided.</span>';
    }
    return '<div class="complaint-child-container">' +
               '<div class="complaint-child-card">' +
                   '<div class="complaint-child-header">' +
                       '<span class="complaint-child-badge">' +
                           '<i class="icon-file-text2 mr-1"></i> Complaint Description' +
                       '</span>' +
                   '</div>' +
                   '<div class="complaint-child-body">' +
                       contentHtml +
                   '</div>' +
               '</div>' +
           '</div>';
}

function formatDateTime(data) {
    if (!data) return '';
    var text = String(data).trim();
    if (text === '') return '';
    if (typeof moment === 'function') {
        var m = moment(text, ['DD-MM-YYYY HH:mm:ss', 'YYYY-MM-DD HH:mm:ss', 'DD-MM-YYYY', 'YYYY-MM-DD']);
        if (m.isValid()) {
            return m.format('DD-MM-YYYY HH:mm:ss');
        }
    }
    return text;
}

$(document).ready(function(){
    
var tbl_emergency_work_orders;   
var tbl_urgent_work_orders;
var tbl_normal_work_orders;

if ($('#tbl_emergency_work_orders').length > 0) {
    load_tbl_emergency_work_orders();
}
if ($('#tbl_urgent_work_orders').length > 0) {
    load_tbl_urgent_work_orders();
}
if ($('#tbl_normal_work_orders').length > 0) {
    load_tbl_normal_work_orders();
}

$(document).on('click', '#tbl_emergency_work_orders tbody td.details-control, #tbl_urgent_work_orders tbody td.details-control, #tbl_normal_work_orders tbody td.details-control', function (e) {
    if ($(e.target).is('a, button, input')) return;

    var tr = $(this).closest('tr');
    var tableEl = $(this).closest('table');
    var tableId = tableEl.attr('id');
    var dt = (tableId === 'tbl_emergency_work_orders') ? tbl_emergency_work_orders : ((tableId === 'tbl_urgent_work_orders') ? tbl_urgent_work_orders : tbl_normal_work_orders);
    if (!dt) return;
    var row = dt.row(tr);
    if (!row || !row.data()) return;

    if (row.child.isShown()) {
        row.child.hide();
        tr.removeClass('shown');
        tr.find('.toggle-icon i')
            .removeClass('icon-minus-circle2 text-primary')
            .addClass('icon-plus-circle2 text-muted');
    } else {
        var data = row.data();
        if (data) {
            row.child(formatComplaintChildRow(data.complaints_description), 'complaint-child-row').show();
            tr.addClass('shown');
            tr.find('.toggle-icon i')
                .removeClass('icon-plus-circle2 text-muted')
                .addClass('icon-minus-circle2 text-primary');
        }
    }
});

function load_tbl_emergency_work_orders()
{
    if ($('#tbl_emergency_work_orders').length === 0) return;

    if ($.fn.DataTable.isDataTable('#tbl_emergency_work_orders')) {
        tbl_emergency_work_orders.destroy();
    }
                                         
    tbl_emergency_work_orders = $('#tbl_emergency_work_orders').DataTable({
                                           
        "ajax": {
            'type': 'POST',
            'url': '../controller/ticket/ticket_completed_controller.php',
            'data': {
                action: 'list_emergency_work_orders'
            },
            beforeSend: function () {
                $("#tbl_emergency_work_orders").LoadingOverlay("show", {
                    background: "rgba(132, 194, 0, 0.2)",
                    text: "Loading..."
                });
            },
            complete: function () {
                $("#tbl_emergency_work_orders").LoadingOverlay("hide");
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                $("#tbl_emergency_work_orders").LoadingOverlay("hide");
            },    
        },
        "language": {
            "zeroRecords": "No records available",
            "infoEmpty": "No records available",
        },
                                           
        "Paginate": true,
        "bLengthChange": false,
        "bFilter": true,
        "bInfo": true,
        "autoWidth": false,
        "responsive": false,
        "pageLength": 20,
        "searching": true,
                
        "columns": [
            { 
                "data": null,
                "width": "60px",
                "orderable": false,
                "className": "details-control text-center",
                "render": function(data, type, row, meta) {
                    var num = meta.settings._iDisplayStart + meta.row + 1;
                    if (type === 'display') {
                        return '<span class="toggle-icon cursor-pointer mr-1" title="Toggle complaint description">' +
                               '<i class="icon-minus-circle2 text-primary" style="font-size: 13px; vertical-align: middle;"></i>' +
                               '</span> ' + num;
                    }
                    return num;
                }
            },
            { 
                "data": "created_date_time",
                "type": "dom-date",
                "render": function(data, type, row, meta) {
                    if (type === 'display') {
                        return formatDateTime(data);
                    }
                    return data;
                }
            },
            { 
                "data": "ticket_ref_code",
                "render": function(data, type, row, meta) {
                    return '<a href="work_order_print.php?ticket_id=' + row['ticket_id'] + '" target="_blank">WO-' + data + '-' + row['ticket_id'] + '</a>';
                }
            },
            { "data": "customer_name" },
            { "data": "building_name" },
            { "data": "location_name" },
            { 
                "data": "complaints_description",
                "visible": false
            },
            { 
                "data": "ticket_priority",
                "render": function(data, type, row, meta) {
                    return '<span class="badge bg-danger">' + data + '</span>';
                }
            }
        ],

        "drawCallback": function (settings) {
            var api = this.api();
            api.rows({ page: 'current' }).every(function () {
                var row = this;
                var data = row.data();
                if (data) {
                    row.child(formatComplaintChildRow(data.complaints_description), 'complaint-child-row').show();
                    $(row.node()).addClass('shown');
                    $(row.node()).find('.toggle-icon i')
                        .removeClass('icon-plus-circle2 text-muted')
                        .addClass('icon-minus-circle2 text-primary');
                }
            });
        },

        "initComplete": function( settings, json ) {
            $.extend($.fn.dataTableExt.oSort, {
                "dom-date-pre": function(a) {
                    return moment(a, "DD-MM-YYYY HH:mm:ss");
                },
                "dom-date-asc": function(a, b) {
                    return ((a < b) ? -1 : ((a > b) ? 1 : 0));
                },
                "dom-date-desc": function(a, b) {
                    return ((a < b) ? 1 : ((a > b) ? -1 : 0));
                }
            });
        }
    });  
}

function load_tbl_urgent_work_orders()
{
    if ($('#tbl_urgent_work_orders').length === 0) return;

    if ($.fn.DataTable.isDataTable('#tbl_urgent_work_orders')) {
        tbl_urgent_work_orders.destroy();
    }
                                         
    tbl_urgent_work_orders = $('#tbl_urgent_work_orders').DataTable({
                                           
        "ajax": {
            'type': 'POST',
            'url': '../controller/ticket/ticket_completed_controller.php',
            'data': {
                action: 'list_urgent_work_orders'
            },
            beforeSend: function () {
                $("#tbl_urgent_work_orders").LoadingOverlay("show", {
                    background: "rgba(132, 194, 0, 0.2)",
                    text: "Loading..."
                });
            },
            complete: function () {
                $("#tbl_urgent_work_orders").LoadingOverlay("hide");
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                $("#tbl_urgent_work_orders").LoadingOverlay("hide");
            },    
        },
        "language": {
            "zeroRecords": "No records available",
            "infoEmpty": "No records available",
        },
                                           
        "Paginate": true,
        "bLengthChange": false,
        "bFilter": true,
        "bInfo": true,
        "autoWidth": false,
        "responsive": false,
        "pageLength": 20,
        "searching": true,
                
        "columns": [
            { 
                "data": null,
                "width": "60px",
                "orderable": false,
                "className": "details-control text-center",
                "render": function(data, type, row, meta) {
                    var num = meta.settings._iDisplayStart + meta.row + 1;
                    if (type === 'display') {
                        return '<span class="toggle-icon cursor-pointer mr-1" title="Toggle complaint description">' +
                               '<i class="icon-minus-circle2 text-primary" style="font-size: 13px; vertical-align: middle;"></i>' +
                               '</span> ' + num;
                    }
                    return num;
                }
            },
            { 
                "data": "created_date_time",
                "type": "dom-date",
                "render": function(data, type, row, meta) {
                    if (type === 'display') {
                        return formatDateTime(data);
                    }
                    return data;
                }
            },
            { 
                "data": "ticket_ref_code",
                "render": function(data, type, row, meta) {
                    return '<a href="work_order_print.php?ticket_id=' + row['ticket_id'] + '" target="_blank">WO-' + data + '-' + row['ticket_id'] + '</a>';
                }
            },
            { "data": "customer_name" },
            { "data": "building_name" },
            { "data": "location_name" },
            { 
                "data": "complaints_description",
                "visible": false
            },
            { 
                "data": "ticket_priority",
                "render": function(data, type, row, meta) {
                    return '<span class="badge bg-warning">' + data + '</span>';
                }
            }
        ],

        "drawCallback": function (settings) {
            var api = this.api();
            api.rows({ page: 'current' }).every(function () {
                var row = this;
                var data = row.data();
                if (data) {
                    row.child(formatComplaintChildRow(data.complaints_description), 'complaint-child-row').show();
                    $(row.node()).addClass('shown');
                    $(row.node()).find('.toggle-icon i')
                        .removeClass('icon-plus-circle2 text-muted')
                        .addClass('icon-minus-circle2 text-primary');
                }
            });
        },

        "initComplete": function( settings, json ) {
            $.extend($.fn.dataTableExt.oSort, {
                "dom-date-pre": function(a) {
                    return moment(a, "DD-MM-YYYY HH:mm:ss");
                },
                "dom-date-asc": function(a, b) {
                    return ((a < b) ? -1 : ((a > b) ? 1 : 0));
                },
                "dom-date-desc": function(a, b) {
                    return ((a < b) ? 1 : ((a > b) ? -1 : 0));
                }
            });
        }
    });  
}

function load_tbl_normal_work_orders()
{
    if ($('#tbl_normal_work_orders').length === 0) return;

    if ($.fn.DataTable.isDataTable('#tbl_normal_work_orders')) {
        tbl_normal_work_orders.destroy();
    }
                                         
    tbl_normal_work_orders = $('#tbl_normal_work_orders').DataTable({
                                           
        "ajax": {
            'type': 'POST',
            'url': '../controller/ticket/ticket_completed_controller.php',
            'data': {
                action: 'list_normal_work_orders'
            },
            beforeSend: function () {
                $("#tbl_normal_work_orders").LoadingOverlay("show", {
                    background: "rgba(132, 194, 0, 0.2)",
                    text: "Loading..."
                });
            },
            complete: function () {
                $("#tbl_normal_work_orders").LoadingOverlay("hide");
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                $("#tbl_normal_work_orders").LoadingOverlay("hide");
            },    
        },
        "language": {
            "zeroRecords": "No records available",
            "infoEmpty": "No records available",
        },
                                           
        "Paginate": true,
        "bLengthChange": false,
        "bFilter": true,
        "bInfo": true,
        "autoWidth": false,
        "responsive": false,
        "pageLength": 20,
        "searching": true,
                
        "columns": [
            { 
                "data": null,
                "width": "60px",
                "orderable": false,
                "className": "details-control text-center",
                "render": function(data, type, row, meta) {
                    var num = meta.settings._iDisplayStart + meta.row + 1;
                    if (type === 'display') {
                        return '<span class="toggle-icon cursor-pointer mr-1" title="Toggle complaint description">' +
                               '<i class="icon-minus-circle2 text-primary" style="font-size: 13px; vertical-align: middle;"></i>' +
                               '</span> ' + num;
                    }
                    return num;
                }
            },
            { 
                "data": "created_date_time",
                "type": "dom-date",
                "render": function(data, type, row, meta) {
                    if (type === 'display') {
                        return formatDateTime(data);
                    }
                    return data;
                }
            },
            { 
                "data": "ticket_ref_code",
                "render": function(data, type, row, meta) {
                    return '<a href="work_order_print.php?ticket_id=' + row['ticket_id'] + '" target="_blank">WO-' + data + '-' + row['ticket_id'] + '</a>';
                }
            },
            { "data": "customer_name" },
            { "data": "building_name" },
            { "data": "location_name" },
            { 
                "data": "complaints_description",
                "visible": false
            },
            { 
                "data": "ticket_priority",
                "render": function(data, type, row, meta) {
                    return '<span class="badge bg-primary">' + data + '</span>';
                }
            }
        ],

        "drawCallback": function (settings) {
            var api = this.api();
            api.rows({ page: 'current' }).every(function () {
                var row = this;
                var data = row.data();
                if (data) {
                    row.child(formatComplaintChildRow(data.complaints_description), 'complaint-child-row').show();
                    $(row.node()).addClass('shown');
                    $(row.node()).find('.toggle-icon i')
                        .removeClass('icon-plus-circle2 text-muted')
                        .addClass('icon-minus-circle2 text-primary');
                }
            });
        },

        "initComplete": function( settings, json ) {
            $.extend($.fn.dataTableExt.oSort, {
                "dom-date-pre": function(a) {
                    return moment(a, "DD-MM-YYYY HH:mm:ss");
                },
                "dom-date-asc": function(a, b) {
                    return ((a < b) ? -1 : ((a > b) ? 1 : 0));
                },
                "dom-date-desc": function(a, b) {
                    return ((a < b) ? 1 : ((a > b) ? -1 : 0));
                }
            });
        }
    });  
}
      
    
});