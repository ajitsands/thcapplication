<div class="card">
    <div class="card-header bg-white header-elements-inline">
        <h6 class="card-title">Checklist Master</h6>
        <div class="header-elements">
            <div class="list-icons">
                <a class="list-icons-item" data-action="collapse"></a>
            </div>
        </div>
    </div>

    <div class="card-body">
        <form id="frmChecklistMaster">
            <input type="hidden" name="action" value="save_checklist">
            <input type="hidden" name="checklist_id" id="checklist_id" value="0">
            
            <div class="row mb-1">
                <div class="col-md-12">
                    <div class="form-group mb-1">
                        <label>Checklist Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="checklist_name" id="checklist_name" required>
                    </div>
                </div>
            </div>

            <fieldset class="mb-3">
                <legend class="text-uppercase font-size-sm font-weight-bold">Checklist Categories & Points</legend>
                <div id="categories_container">
                    <!-- Dynamic categories will go here -->
                    <div class="category-block border p-3 mb-3 bg-light rounded" data-cat-index="0">
                        <div class="row mb-2 align-items-center">
                            <div class="col-md-10">
                                <input type="text" class="form-control font-weight-semibold" name="categories[0][name]" placeholder="Enter Category Name (e.g. Cleaning)..." required>
                            </div>
                            <div class="col-md-2 text-right">
                                <button type="button" class="btn btn-danger btn-remove-category" style="padding: 0; width: 22px; height: 22px; display: inline-flex; align-items: center; justify-content: center;"><i class="icon-trash" style="font-size: 10px;"></i></button>
                            </div>
                        </div>
                        
                        <div class="points-container ml-4 border-left pl-3">
                            <div class="row point-row mb-2">
                                <div class="col-md-11">
                                    <input type="text" class="form-control form-control-sm" name="categories[0][points][]" placeholder="Enter checklist point..." required>
                                </div>
                                <div class="col-md-1 pl-0">
                                    <button type="button" class="btn btn-sm btn-light btn-icon rounded-round text-danger btn-remove-point"><i class="icon-trash"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="ml-4 pl-3 mt-2">
                            <button type="button" class="btn btn-sm btn-outline-success btn-add-point border-success text-success" data-cat-index="0"><i class="icon-plus22 mr-1"></i> Add Point</button>
                        </div>
                    </div>
                </div>
                
                <div class="text-center mt-3">
                    <button type="button" class="btn btn-outline bg-teal-400 text-teal-400 border-teal-400" id="btn-add-category"><i class="icon-plus3 mr-2"></i> Add Another Category</button>
                </div>
            </fieldset>

            <div class="text-right">
                <button type="button" class="btn btn-light" id="btnReset">Reset</button>
                <button type="submit" class="btn btn-primary" id="btnSaveChecklist">Submit <i class="icon-paperplane ml-2"></i></button>
            </div>
        </form>
    </div>
</div>

<div class="card mt-3">
    <div class="card-header bg-white header-elements-inline">
        <h6 class="card-title">Existing Checklists</h6>
    </div>

    <table class="table datatable-basic" id="tblChecklists">
        <thead>
            <tr>
                <th>ID</th>
                <th>Checklist Name</th>
                <th>Categories</th>
                <th>Total Points</th>
                <th>Status</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<!-- Modal for Viewing Points -->
<div id="modal_view_points" class="modal fade" tabindex="-1">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Checklist Details</h5>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>

			<div class="modal-body" id="div_checklist_details_body">
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
