$(document).ready(function() {
    
    var catIndex = 1; // Used for unique names when adding categories

    // Initialize DataTable
    var tblChecklists = $('#tblChecklists').DataTable({
        "ajax": {
            "url": "../controller/janitor/checklist_controller.php",
            "type": "POST",
            "data": { action: "list_checklists" }
        },
        "columns": [
            { "data": "id" },
            { "data": "checklist_name" },
            { "data": "total_categories" },
            { "data": "total_points",
              "render": function(data, type, row) {
                  return data + ' <button type="button" class="btn btn-info ml-2 btn-view-points" style="padding: 1px 5px; font-size: 10px; line-height: 1.5; border-radius: 2px;" data-id="'+row.id+'"><i class="icon-eye font-size-sm"></i> View</button>';
              }
            },
            { "data": "status",
              "render": function(data, type, row) {
                  var badgeClass = data === 'Active' ? 'badge-success' : 'badge-danger';
                  return '<span class="badge ' + badgeClass + '">' + data + '</span>';
              }
            },
            { "data": null,
              "orderable": false,
              "render": function(data, type, row) {
                  var stBtn = row.status === 'Active' ? 
                      '<button class="btn btn-danger btn-status" style="padding: 1px 5px; font-size: 10px; line-height: 1.5; border-radius: 2px;" data-id="'+row.id+'" data-status="Inactive"><i class="icon-cross2 font-size-sm"></i> Disable</button>' : 
                      '<button class="btn btn-success btn-status" style="padding: 1px 5px; font-size: 10px; line-height: 1.5; border-radius: 2px;" data-id="'+row.id+'" data-status="Active"><i class="icon-checkmark3 font-size-sm"></i> Enable</button>';
                  
                  return '<div class="list-icons">' +
                            '<button type="button" class="btn btn-primary btn-edit" style="padding: 1px 5px; font-size: 10px; line-height: 1.5; border-radius: 2px;" data-id="'+row.id+'"><i class="icon-pencil font-size-sm"></i> Edit</button> &nbsp;' +
                            stBtn +
                         '</div>';
              }
            }
        ]
    });

    // Dynamic Categories adding
    $('#btn-add-category').click(function() {
        var newCat = `
            <div class="category-block border p-3 mb-3 bg-light rounded" data-cat-index="${catIndex}">
                <div class="row mb-2 align-items-center">
                    <div class="col-md-10">
                        <input type="text" class="form-control font-weight-semibold" name="categories[${catIndex}][name]" placeholder="Enter Category Name (e.g. Cleaning)..." required>
                    </div>
                    <div class="col-md-2 text-right">
                        <button type="button" class="btn btn-danger btn-remove-category" style="padding: 0; width: 22px; height: 22px; display: inline-flex; align-items: center; justify-content: center;"><i class="icon-trash" style="font-size: 10px;"></i></button>
                    </div>
                </div>
                
                <div class="points-container ml-4 border-left pl-3">
                    <div class="row point-row mb-2">
                        <div class="col-md-11">
                            <input type="text" class="form-control form-control-sm" name="categories[${catIndex}][points][]" placeholder="Enter checklist point..." required>
                        </div>
                        <div class="col-md-1 pl-0">
                            <button type="button" class="btn btn-sm btn-light btn-icon rounded-round text-danger btn-remove-point"><i class="icon-trash"></i></button>
                        </div>
                    </div>
                </div>
                <div class="ml-4 pl-3 mt-2">
                    <button type="button" class="btn btn-sm btn-outline-success btn-add-point border-success text-success" data-cat-index="${catIndex}"><i class="icon-plus22 mr-1"></i> Add Point</button>
                </div>
            </div>`;
        $('#categories_container').append(newCat);
        catIndex++;
    });

    $(document).on('click', '.btn-remove-category', function() {
        $(this).closest('.category-block').remove();
    });

    // Dynamic points adding/removing
    $(document).on('click', '.btn-add-point', function() {
        var idx = $(this).data('cat-index');
        var newRow = `
            <div class="row point-row mb-2">
                <div class="col-md-11">
                    <input type="text" class="form-control form-control-sm" name="categories[${idx}][points][]" placeholder="Enter checklist point..." required>
                </div>
                <div class="col-md-1 pl-0">
                    <button type="button" class="btn btn-sm btn-light btn-icon rounded-round text-danger btn-remove-point"><i class="icon-trash"></i></button>
                </div>
            </div>`;
        $(this).closest('.points-container').append(newRow);
    });

    $(document).on('click', '.btn-remove-point', function() {
        $(this).closest('.point-row').remove();
    });

    // Save Checklist
    $('#frmChecklistMaster').on('submit', function(e) {
        e.preventDefault();
        
        var l = Ladda.create(document.querySelector('#btnSaveChecklist'));
        l.start();

        $.ajax({
            url: "../controller/janitor/checklist_controller.php",
            type: "POST",
            data: $(this).serialize(),
            success: function(response) {
                l.stop();
                try {
                    var res = JSON.parse(response);
                    if (res.status === 'success') {
                        swal("Success", res.message, "success");
                        resetForm();
                        tblChecklists.ajax.reload();
                    } else {
                        swal("Error", res.message, "error");
                    }
                } catch(e) {
                    swal("Error", "Invalid response from server", "error");
                }
            },
            error: function() {
                l.stop();
                swal("Error", "Something went wrong!", "error");
            }
        });
    });

    // Reset Form
    $('#btnReset').click(function() {
        resetForm();
    });

    function resetForm() {
        $('#frmChecklistMaster')[0].reset();
        $('#checklist_id').val('0');
        catIndex = 1;

        // Keep only first category and its first point
        var firstCat = $('#categories_container .category-block').first().clone();
        firstCat.find('input').val('');
        firstCat.attr('data-cat-index', '0');
        firstCat.find('input[name^="categories"]').each(function() {
            var name = $(this).attr('name');
            name = name.replace(/\[\d+\]/, '[0]');
            $(this).attr('name', name);
        });
        firstCat.find('.btn-add-point').attr('data-cat-index', '0');
        
        // Remove all but first point
        firstCat.find('.point-row:not(:first)').remove();

        $('#categories_container').empty().append(firstCat);
    }

    // View Points Modal
    $(document).on('click', '.btn-view-points', function() {
        var id = $(this).data('id');
        $.ajax({
            url: "../controller/janitor/checklist_controller.php",
            type: "POST",
            data: { action: "get_checklist", checklist_id: id },
            success: function(response) {
                try {
                    var res = JSON.parse(response);
                    var cats = res.categories;
                    
                    $('#div_checklist_details_body').empty();
                    
                    var html = '';
                    cats.forEach(function(cat) {
                        html += '<h6 class="font-weight-semibold text-primary mb-2 mt-3">' + cat.category_name + '</h6>';
                        html += '<ul class="list-group list-group-flush mb-3">';
                        cat.points.forEach(function(pt) {
                            html += '<li class="list-group-item py-1"><i class="icon-arrow-right5 text-muted mr-2"></i> ' + pt.item_description + '</li>';
                        });
                        html += '</ul>';
                    });
                    
                    $('#div_checklist_details_body').html(html);
                    $('#modal_view_points').modal('show');
                } catch(e) { }
            }
        });
    });

    // Edit Checklist
    $(document).on('click', '.btn-edit', function() {
        var id = $(this).data('id');
        $.ajax({
            url: "../controller/janitor/checklist_controller.php",
            type: "POST",
            data: { action: "get_checklist", checklist_id: id },
            success: function(response) {
                try {
                    var res = JSON.parse(response);
                    var chk = res.checklist;
                    var cats = res.categories;
                    
                    $('#checklist_id').val(chk.id);
                    $('#checklist_name').val(chk.checklist_name);

                    $('#categories_container').empty();
                    catIndex = 0;

                    cats.forEach(function(cat, cIndex) {
                        
                        var catBlock = `
                            <div class="category-block border p-3 mb-3 bg-light rounded" data-cat-index="${cIndex}">
                                <div class="row mb-2 align-items-center">
                                    <div class="col-md-10">
                                        <input type="text" class="form-control font-weight-semibold" name="categories[${cIndex}][name]" value="${cat.category_name}" required>
                                    </div>
                                    <div class="col-md-2 text-right">
                                        <button type="button" class="btn btn-danger btn-remove-category" style="padding: 0; width: 22px; height: 22px; display: inline-flex; align-items: center; justify-content: center;"><i class="icon-trash" style="font-size: 10px;"></i></button>
                                    </div>
                                </div>
                                <div class="points-container ml-4 border-left pl-3">`;

                        cat.points.forEach(function(pt, pIndex) {
                            catBlock += `
                                <div class="row point-row mb-2">
                                    <div class="col-md-11">
                                        <input type="text" class="form-control form-control-sm" name="categories[${cIndex}][points][]" value="${pt.item_description}" required>
                                    </div>
                                    <div class="col-md-1 pl-0">
                                        <button type="button" class="btn btn-sm btn-light btn-icon rounded-round text-danger btn-remove-point"><i class="icon-trash"></i></button>
                                    </div>
                                </div>`;
                        });

                        catBlock += `
                                </div>
                                <div class="ml-4 pl-3 mt-2">
                                    <button type="button" class="btn btn-sm btn-outline-success btn-add-point border-success text-success" data-cat-index="${cIndex}"><i class="icon-plus22 mr-1"></i> Add Point</button>
                                </div>
                            </div>`; // Close category-block
                        $('#categories_container').append(catBlock);
                        
                        catIndex++; // increment for next
                    });
                    
                    window.scrollTo(0, 0);
                } catch(e) { }
            }
        });
    });

    // Change Status
    $(document).on('click', '.btn-status', function() {
        var id = $(this).data('id');
        var status = $(this).data('status');
        
        swal({
            title: "Are you sure?",
            text: "You want to " + (status==='Active'?'Enable':'Disable') + " this checklist!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willChange) => {
            if (willChange) {
                $.ajax({
                    url: "../controller/janitor/checklist_controller.php",
                    type: "POST",
                    data: { action: "change_status", checklist_id: id, status: status },
                    success: function(response) {
                        tblChecklists.ajax.reload();
                    }
                });
            }
        });
    });

});
