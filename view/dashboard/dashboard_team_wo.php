	<div class="card">
		<div class="card-header header-elements-inline d-flex align-items-center justify-content-between flex-wrap" style="padding-bottom: 0;">
			<h6 class="card-title">Work Orders - Team Wise</h6>
			<div class="header-elements d-flex align-items-center flex-wrap ml-auto mb-2" style="gap: 12px;">
				<div class="d-flex align-items-center" style="gap: 6px;">
					<span class="font-weight-semibold text-muted mr-1" style="font-size:0.85rem;">From</span>
					<input class="form-control form-control-sm" type="date" name="txt_start_date" id="txt_start_date" value="<?php date_default_timezone_set('Asia/Bahrain'); echo date("Y-m-d"); ?>" style="width:165px;">
				</div>
				<div class="d-flex align-items-center ml-2" style="gap: 6px;">
					<span class="font-weight-semibold text-muted mr-1" style="font-size:0.85rem;">To</span>
					<input class="form-control form-control-sm" type="date" name="txt_end_date" id="txt_end_date" value="<?php date_default_timezone_set('Asia/Bahrain'); echo date("Y-m-d"); ?>" style="width:165px;">
				</div>
				<button type="button" class="btn btn-info btn-sm font-weight-bold ml-2" id="btn_dash_wo_search" style="border-radius:50px; padding:6px 22px; background:linear-gradient(135deg, #00b4d8 0%, #0077b6 100%); border:none; box-shadow:0 4px 12px rgba(0,180,216,0.3); color:#fff; text-transform:uppercase; letter-spacing:0.5px;">SEARCH</button>
			</div>
		</div>

						
                            <div id="div_load_dashboard_wos"></div>
						
						</div>