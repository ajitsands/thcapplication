<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">Material Master</h5>
        <div class="header-elements">
            <button type="button" class="btn btn-primary" id="btn_add_spare_part">
                <i class="icon-plus3 mr-2"></i> Add Material
            </button>
        </div>
    </div>

    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-3">
                <label>Filter by Category</label>
                <select class="form-control select2" id="filter_category">
                    <option value="">All Categories</option>
                    <?php
                    include_once(__DIR__ . '/../../model/db_connection/connection.php');
                    $conn = (new DBConnection())->ConnectToMYSQL();
                    $resCatFilter = $conn->query("SELECT category_name FROM tbl_category WHERE category_status = 'Active'");
                    if($resCatFilter) {
                        while($rowCatF = $resCatFilter->fetch_assoc()) {
                            echo "<option value='".$rowCatF['category_name']."'>".$rowCatF['category_name']."</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-3">
                <label>Filter by Status</label>
                <select class="form-control select2" id="filter_status">
                    <option value="">All Statuses</option>
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                </select>
            </div>
            <div class="col-md-3">
                <label>&nbsp;</label>
                <button type="button" class="btn btn-primary d-block" id="btn_search_materials">
                    <i class="icon-search4 mr-2"></i> Search
                </button>
            </div>
        </div>
        
        <table class="table datatable-basic" id="tbl_spare_parts_master">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Category</th>
                    <th>Item Code</th>
                    <th>Item Name</th>
                    <th>Type</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Populated via AJAX -->
            </tbody>
        </table>
    </div>
</div>

<!-- Modal for Add/Edit Material -->
<div id="modal_spare_part" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="frm_spare_part">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="modal_title">Add Material</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <input type="hidden" id="part_id" name="part_id" value="">
                    <input type="hidden" id="action" name="action" value="add_spare_part">

                    <div class="form-group">
                        <label>Category <span class="text-danger">*</span></label>
                        <select class="form-control select2" id="category" name="category" required>
                            <option value="">-- Select Category --</option>
                            <?php
                            include_once(__DIR__ . '/../../model/db_connection/connection.php');
                            $conn = (new DBConnection())->ConnectToMYSQL();
                            $resCat = $conn->query("SELECT category_name FROM tbl_category WHERE category_status = 'Active'");
                            if($resCat) {
                                while($rowCat = $resCat->fetch_assoc()) {
                                    echo "<option value='".$rowCat['category_name']."'>".$rowCat['category_name']."</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Item Code <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="item_code" name="item_code" required>
                    </div>

                    <div class="form-group">
                        <label>Item Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="item_name" name="item_name" required>
                    </div>

                    <div class="form-group">
                        <label>Type <span class="text-danger">*</span></label>
                        <select class="form-control select2" id="type_name" name="type_name" required>
                            <option value="">-- Select Type --</option>
                            <option value="Goods">Goods</option>
                            <option value="Products">Products</option>
                            <option value="Both">Both</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="btn_save_spare_part">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
