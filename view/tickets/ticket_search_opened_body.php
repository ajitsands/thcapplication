<style>
    .password_disable {
		pointer-events: none;
		opacity: 0.4;
}
</style>
<style>
    input[type='file'] {
  width: 95px;
 }
</style>
<?php include('modal_ticket_search_all_details.php');?>
<?php 
$wo_type_test='';
$wo_type_text2='';

switch($_GET['wo_type'])
{
    case 'open':
        $wo_type_test='List of Opened Work Orders';
        $wo_type_text2='Opened';
    break;
    case 'close':
        $wo_type_test='List of Closed Work Orders';
        $wo_type_text2='Closed';
    break;
    case 'pending':
        $wo_type_test='List of Pending Work Orders';
        $wo_type_text2='Pending';
    break;
   
}

?>
<input type="hidden" id="txt_wo_condition" value="<?php echo $_GET['wo_condition'];?>">
<input type="hidden" id="txt_wo_type" value="<?php echo $_GET['wo_type'];?>">
	<div class="card">
				<div class="card-header header-elements-inline">
						<h5 class="card-title"><?php echo $wo_type_test;?> - <span id="span_caption"><?php echo $_GET['wo_condition'];?></span></h5>
						<div class="header-elements">
						
	                	</div>
					</div>


					<div class="card-body"  id="tabs">
						 <ul class="nav nav-tabs nav-tabs-highlight" style="padding-top:2px;margin-bottom: 0.00rem;">
									<li class="nav-item"><a href="#ticket-tab1" class="nav-link active" data-toggle="tab"  id="tab_tickets_not_assigned"><span class="badge badge-info badge-pill mr-2" id="span_count_not_assigned"><?php echo $_GET['wo_count'];?></span><?php echo $wo_type_text2;?></a></li>
								
									
								</ul>
								<div class="tab-content" >
									<div class="tab-pane fade show active" id="ticket-tab1">
									
									    <?PHP include_once('tickets/tickets_dash_opened_list.php');?>
									
									</div>
                                  
									
								</div>
			
					
					
					
					
					
					
						
					</div>
				
					
					
	</div>
				
				
				

				