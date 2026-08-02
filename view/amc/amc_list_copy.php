<!-- Highlighting rows and columns -->
				<div class="card">
					

					<table class="table table-bordered table-hover datatable-highlight" style="padding-right:10px;padding-left:10px;">
						<thead>
							<tr>
								<th>AMC No </th>
								<th>Customer Name</th>
								<th>Type</th>
								<th>Sign Date</th>
								<th>Start & End Date</th>
								<th>Status</th>
								<th class="text-center">Actions</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><a href="#" data-popup="popover" title="Other Details" data-trigger="hover" data-html="true" data-content="
								
								<div class='border-left-1 border-left-warning rounded-left-0' style='padding-bottom:0px;padding-top:0px;'>
        							<div class='card-body' >
        								<div class='row' style='padding-bottom:10px;'>
							                <div class='col-lg-6 col-md-6 col-sm-6' >
							                    <b>Amount</b> 
							                </div>
							                <div class='col-lg-6 col-md-6 col-sm-6' >
							                      20,000.000
							                </div>
							            </div>
							            <div class='row' style='padding-bottom:10px;'>
							                <div class='col-lg-6 col-md-6 col-sm-6' >
							                    <b>VAT %</b> 
							                </div>
							                <div class='col-lg-6 col-md-6 col-sm-6' >
							                      20
							                </div>
							            </div>
							            <div class='row' style='padding-bottom:10px;'>
							                <div class='col-lg-6 col-md-6 col-sm-6' >
							                    <b>NET Amount</b>  
							                </div>
							                <div class='col-lg-6 col-md-6 col-sm-6' >
							                      22,000.000
							                </div>
							            </div>
							            <div class='row' style='padding-bottom:10px;'>
							                <div class='col-lg-12 col-md-12 col-sm-12' >
							                   <b> Discription </b>:  This is a sample opup for the demon purpose please do the change and get the value from database to display.
							                </div>
							                
							            </div>
        							</div>
        						</div>
								
								">10001</a></td>
								<td>Syskode Technologies</td>
								<td>Premetive Maintinance</td>
								<td>12-12-2020</td>
								<td>01-02-2021 - 01-02-2022</td>
								<td><span class="badge badge-success">Active</span></td>
								<td class="text-center">
									<div class="list-icons">
										<div class="dropdown">
											<a href="#" class="list-icons-item" data-toggle="dropdown">
												<i class="icon-menu9"></i>
											</a>

											<div class="dropdown-menu dropdown-menu-right">
												<a href="#" class="dropdown-item" data-toggle="modal" data-target="#modal_backdrop"><i class="icon-pencil5"></i> Change Status</a>
												<a href="#" class="dropdown-item"><i class="icon-quill4"></i> Edit</a>
												<a href="#" class="dropdown-item" data-toggle="modal" data-target="#modal_backdrop_1"><i class="icon-reload-alt"></i> Renew</a>
												<a href="#" class="dropdown-item"><i class="icon-pen-plus"></i> Add Services</a>
												
												<div class="dropdown-divider"></div>
												<a href="#" class="dropdown-item"><i class="icon-file-eye"></i> View History</a>
												
											</div>
										</div>
									</div>
								</td>
							</tr>
						
						</tbody>
					</table>
				</div>
				<!-- /highlighting rows and columns -->
				
				
				<!-- Disabled backdrop -->
				<div id="modal_backdrop" class="modal fade" data-backdrop="false" tabindex="-1">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title">Change Status [AMC No : <b>100001</b>]</h5>
								<button type="button" class="close" data-dismiss="modal">&times;</button>
							</div>

							<div class="modal-body">
								
								<div class="row">
							        <div class="col-lg-4 col-md-6 col-sm-12" >
							                <div class="form-check">
												<label class="form-check-label">
													<input type="radio" name="radio-styled-color" class="form-check-input-styled-success" checked data-fouc>
													Active
												</label>
											</div>
							        </div>
							        <div class="col-lg-4 col-md-6 col-sm-12" >
							                <div class="form-check">
												<label class="form-check-label">
													<input type="radio" name="radio-styled-color" class="form-check-input-styled-danger"  data-fouc>
													Cancelled	
												</label>
											</div>
							        </div>
							        <div class="col-lg-4 col-md-6 col-sm-12" >
							            <div class="form-check">
												<label class="form-check-label">
													<input type="radio" name="radio-styled-color" class="form-check-input-styled-primary"  data-fouc>
													Hold
												</label>
											</div>
							        </div>
							       
							        
							    </div>
								
								<hr>

                                <div class="form-group row">
									<label class="col-form-label col-lg-2">Description</label>
									<div class="col-lg-12">
										<textarea rows="3" cols="3" class="form-control" placeholder="Description"></textarea>
									</div>
								</div>
								
							</div>

							<div class="modal-footer">
								<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
								<button type="button" class="btn bg-primary">Change Status</button>
							</div>
						</div>
					</div>
				</div>
				<!-- /disabled backdrop -->
				
				<!-- Disabled backdrop -->
				<div id="modal_backdrop_1" class="modal fade" data-backdrop="false" tabindex="-1">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title">Disable backdrop</h5>
								<button type="button" class="close" data-dismiss="modal">&times;</button>
							</div>

							<div class="modal-body">
								<h6 class="font-weight-semibold">Text in a modal</h6>
								<p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor.</p>

								<hr>

								<h6 class="font-weight-semibold">Another paragraph</h6>
								<p>Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.</p>
								<p>Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor.</p>
							</div>

							<div class="modal-footer">
								<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
								<button type="button" class="btn bg-primary">Save changes</button>
							</div>
						</div>
					</div>
				</div>
				<!-- /disabled backdrop -->				
				