<div class="card-header header-elements-inline">
						<h5 class="card-title">
						<?PHP
						$params = $OBJ->URLDecode(trim($_GET['param']));
						
							switch($params['title1'])
							{
								case 'product_type':
									echo 'Product Type';
								break;
							    case 'category':
									echo 'Asset Category';
								break;
								
								default:
								break;
							}
						
						?>
						
						</h5>
						<div class="header-elements">
							<div class="list-icons">
		                		<a class="list-icons-item" data-action="collapse"></a>
		                		<a class="list-icons-item" data-action="reload"></a>
		                		<a class="list-icons-item" data-action="remove"></a>
		                	</div>
	                	</div>
					</div>