<div class="card-header header-elements-inline">
						<h5 class="card-title">
						<?PHP
						$params = $OBJ->URLDecode(trim($_GET['param']));
						
							switch($params['title'])
							{
								case 'dashboard':
									echo 'Dashboard';
								break;
								case 'employees':
									echo 'Add Employees ';
								break;
								case 'expertise':
									echo 'Add Expertise';
								break;
								case 'teams':
									echo 'Team';
								break;
								case 'contract':
									echo 'Contract Type';
								break;
								case 'asset_type':
									echo 'Asset Types';
								break;
								case 'services':
									echo 'Services';
								break;
								case 'customer':
									echo 'Customers';
								break;
							
								case 'product_category':
									echo 'Product Category';
								break;
								case 'product_item':
									echo 'Product Item';
								break;
								case 'product_master':
									echo 'Product Master';
								break;
								
								case 'amc':
									echo 'AMC (Annual Maintenance Contract)';
								break;
								case 'vendor_master':
									echo 'Vendor Details';
								break;
								case 'location':
									echo 'Location Details';
								break;
								case 'customer_asset':
									echo 'Customer Building Details';
								break;
								case 'amc_list':
									echo 'AMC List';
								break;
								
								case 'amc_calendar':
									echo 'AMC List';
								break;
								case 'asset_tracking':
									echo 'Asset Tracking';
								break;
								case 'customer_amc_asset':
									echo 'Customer Asset Details';
								break;
								case 'ticket':
									echo 'Ticket Booking';
								break;
							    case 'buildings':
									echo 'Building Details';
								break;
							    case 'ticket_pending':
									echo 'Open Tickets';
								break;
								case 'ticket_scheduled':
									echo 'Scheduled Tickets';
								break;
								case 'ticket_track':
									echo 'Track Complaints';
								break;
							    case 'employee_leave':
									echo 'Add Employee Leave';
								break;
								case 'add_requisition':
									echo 'Add Requisition';
								break;
							    case 'view_requisition':
									echo 'View Requisition';
								break;
								
								case 'add_quotation':
									echo 'Quotation';
								break;
							
								 case 'local_po':
									echo 'Local PO';
								break;
								 case 'local_po_list':
									echo 'Local PO List';
								break;
								 case 'view_quotation':
									echo 'View Quotation List';
								break;
								 case 'add_requisition':
									echo 'Add Requisition';
								break;
								
								case 'view_quotation_rivision':
									echo 'View Quotation Rivision List';
								break;
								case 'team_report':
									echo 'Daily Team Report';
								break;
								case 'activity_log':
									echo 'Daily Activity Log';
								break;
								case 'ticket_reschedule':
									echo 'Reschedule Pending';
								break;
								case 'view_log':
									echo 'Login & Logout Details';
								break;
								
								default:
								break;
							}
						
						?>
						
						</h5>
						<div class="header-elements">
							<div class="list-icons">
		                		<a class="list-icons-item" data-action="collapse"></a>
		                		<!--<a class="list-icons-item" data-action="reload"></a>-->
		                		<a class="list-icons-item" data-action="remove"></a>
		                	</div>
	                	</div>
					</div>