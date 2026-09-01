<div class="card" style="box-shadow: 0 4px 18px rgba(0,0,0,0.04); border-radius: 8px; border: 1px solid #e2e8f0;">
    <div class="card-header header-elements-inline" style="background: linear-gradient(135deg, #f8fafc 0%, #eef2ff 100%); border-bottom: 1px solid #e2e8f0; padding: 16px 20px;">
        <h5 class="card-title font-weight-bold" style="color: #2e2e79; margin: 0; display: flex; align-items: center; gap: 8px;">
            <i class="icon-barcode2" style="font-size: 20px;"></i> Track &amp; Search Assets
        </h5>
    </div>

    <div class="card-body" style="padding: 24px 20px;">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-8 col-sm-12">
                <label class="font-weight-semibold text-muted mb-1" style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">
                    Asset Barcode / QR Code Reference
                </label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" style="background: #f1f5f9; border-color: #cbd5e1; color: #2e2e79;">
                            <i class="icon-barcode2"></i>
                        </span>
                    </div>
                    <input class="form-control" type="text" name="txt_asset_barcode" id="txt_asset_barcode" placeholder="Scan or enter Asset Barcode (e.g. THC-...)" style="border-color: #cbd5e1; font-weight: 600; font-size: 14px; height: 42px;" autofocus>
                    <div class="input-group-append">
                        <button type="button" id="btn_search_assets" class="btn ladda-button" data-style="expand-right" style="background: #2e2e79; color: #ffffff; font-weight: 600; padding: 0 20px; font-size: 13px;">
                            <span class="ladda-label"><i class="icon-search4 mr-1"></i> Track Asset</span>
                            <span class="ladda-spinner"></span>
                        </button>
                    </div>
                </div>
                <small class="form-text text-muted mt-1">
                    <i class="icon-info22 mr-1"></i> Enter or scan the barcode and click <strong>Track Asset</strong> or press <strong>Enter</strong>.
                </small>
            </div>
        </div>
    </div>
</div>

<div id="div_asset_basic_info" style="margin-top: 20px;"></div>