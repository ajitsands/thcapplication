	                   <div class="card">
	                            <?PHP
					
						            include('template/card_head_control.inc');
					
					            ?>
	                       <div class="card-body" id="tabs">
	                            <ul class="nav nav-tabs nav-tabs-highlight" style="padding-top:2px;margin-bottom: 0.00rem;">
									<li class="nav-item"><a href="#highlight-tab1" class="nav-link active" data-toggle="tab"  id="1">AMC Creation</a></li>
									<li class="nav-item"><a href="#highlighted-tab2" class="nav-link" data-toggle="tab"  id="2">List of AMC</a></li>
									<li class="nav-item"><a href="#highlighted-tab3" class="nav-link" data-toggle="tab"  id="3">Inactive</a></li>
								
								</ul>

								<div class="tab-content" >
									<div class="tab-pane fade show active" id="highlight-tab1">
									
									    <?PHP include_once('amc_details.php');?>
									
									</div>

									<div class="tab-pane fade" id="highlighted-tab2">
										<?PHP include_once('amc_list.php');?>
										
									</div>

									<div class="tab-pane fade" id="highlighted-tab3">
										Tab 3
									</div>

									
								</div>
							</div>
						</div>