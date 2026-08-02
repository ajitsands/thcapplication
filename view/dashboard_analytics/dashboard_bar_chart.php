
<?php  include_once(__DIR__ . '/../../model/db_connection/connection.php');
            $DBConn = new DBConnection();
            $varDBConnection = $DBConn->ConnectToMYSQL();?>
            <?php 
            switch($_GET['wo']){
                case 'y':
                                $title='Yearly';
                               $yr=date("Y")-5;
                                 $y_val="[";
                                $wo_open_str="[";
                                $wo_pend_str="[";
                                $wo_comp_str="[";
                                $wo_closed_str="[";
                                for($i=$yr;$i<=date("Y");$i++)
                                {
                                    
                                    $sq_op= "SELECT count(ticket_id) as ct,book_year FROM `tbl_tickets` WHERE `ticket_status`!='Cancelled' and book_year=".$i;
                                    $result_sq_op = mysqli_query($varDBConnection,$sq_op);
                                    	while($row_sq_op=mysqli_fetch_assoc($result_sq_op)) { 
                                    	    if($row_sq_op['ct']!=0)
                                    	    {
                                    	        $wo_open_str=$wo_open_str.$row_sq_op['ct'].",";
                                    	        $y_val=$y_val."'".$i."',";
                                    	    }
                                    	    
                                    	   
                                    	}
                                    $sq_pend= "SELECT count(amc_visit_id) as ct FROM `tbl_visits` WHERE amc_visit_status not in ('Closed','Opened','Cancelled','Completed') and amc_ticket='TKT'  and DATE_FORMAT(date_of_visits,'%Y')=".$i;
                                    $result_sq_pend = mysqli_query($varDBConnection,$sq_pend);
                                    	while($row_sq_pend=mysqli_fetch_assoc($result_sq_pend)) { 
                                    	    if($row_sq_pend['ct']!=0)
                                    	    {
                                    	        $wo_pend_str=$wo_pend_str.$row_sq_pend['ct'].",";
                                    	    }
                                    	    
                                    	   
                                    	}
                                
                                  $sq_comp= "select count(ticket_id ) as ct from tbl_tickets where   ticket_status  in ('Completed','Closed') and  DATE_FORMAT(completed_date_time,'%Y')=".$i;
                                    $result_sq_comp = mysqli_query($varDBConnection,$sq_comp);
                                    	while($row_sq_comp=mysqli_fetch_assoc($result_sq_comp)) { 
                                    	    if($row_sq_comp['ct']!=0)
                                    	    {
                                    	        $wo_comp_str=$wo_comp_str.$row_sq_comp['ct'].",";
                                    	    }
                                    	    
                                    	   
                                    	}
                                 $sq_closed= "select count(ticket_id ) as ct from tbl_tickets where   ticket_status  in ('Closed') and  DATE_FORMAT(closed_on,'%Y')=".$i;
                                    $result_sq_closed = mysqli_query($varDBConnection,$sq_closed);
                                    	while($row_sq_closed=mysqli_fetch_assoc($result_sq_closed)) { 
                                    	    if($row_sq_closed['ct']!=0)
                                    	    {
                                    	        $wo_closed_str=$wo_closed_str.$row_sq_closed['ct'].",";
                                    	    }
                                    	    
                                    	   
                                    	}
                                 }
                break;
                case 'm':
                        $title='Monthly';
                        $y_val="[";
                        $wo_open_str="[";
                        $wo_pend_str="[";
                        $wo_comp_str="[";
                        $wo_closed_str="[";
                         for($i=4;$i>=0;$i--)
                        { 
                            if($i==0)
                            {
                                 $month_val=date('Y-m');
                                 $month_name=date('M-Y');
                            }
                            else
                            {
                                 $month_val=date('Y-m', strtotime("-".$i." month"));
                                 $month_name=date('M-Y', strtotime("-".$i." month"));
                            }
                            $y_val=$y_val."'".$month_name."' ,";
                            $sq_op= "SELECT count(ticket_id) as ct FROM `tbl_tickets` WHERE `ticket_status`!='Cancelled' and date_format(created_date_time,'%Y-%m')='".$month_val."'";
                            $result_sq_op = mysqli_query($varDBConnection,$sq_op);
                            	while($row_sq_op=mysqli_fetch_assoc($result_sq_op)) { 
                            	    
                            	    $wo_open_str=$wo_open_str.$row_sq_op['ct'].",";
                            	   
                            	}
                            
                            $sq_pend= "SELECT count(amc_visit_id) as ct FROM `tbl_visits` WHERE amc_visit_status not in ('Closed','Opened','Cancelled','Completed') and amc_ticket='TKT'  and DATE_FORMAT(date_of_visits,'%Y-%m')='".$month_val."'";
                            $result_sq_pend = mysqli_query($varDBConnection,$sq_pend);
                            	while($row_sq_pend=mysqli_fetch_assoc($result_sq_pend)) { 
                            	   
                            	    $wo_pend_str=$wo_pend_str.$row_sq_pend['ct'].",";
                            	   
                            	}
                        
                          $sq_comp= "select count(ticket_id ) as ct from tbl_tickets where   ticket_status  in ('Completed','Closed') and  DATE_FORMAT(completed_date_time,'%Y-%m')='".$month_val."'";
                            $result_sq_comp = mysqli_query($varDBConnection,$sq_comp);
                            	while($row_sq_comp=mysqli_fetch_assoc($result_sq_comp)) { 
                            	   
                            	    $wo_comp_str=$wo_comp_str.$row_sq_comp['ct'].",";
                            	   
                            	}
                         $sq_closed= "select count(ticket_id ) as ct from tbl_tickets where   ticket_status  in ('Closed') and  DATE_FORMAT(closed_on,'%Y-%m')='".$month_val."'";
                            $result_sq_closed = mysqli_query($varDBConnection,$sq_closed);
                            	while($row_sq_closed=mysqli_fetch_assoc($result_sq_closed)) { 
                            	   
                            	    $wo_closed_str=$wo_closed_str.$row_sq_closed['ct'].",";
                            	   
                            	}
                            
                          
                         }
                break;
                case 'w':
                        $title='Weekly';
                        $y_val="[";
                        $wo_open_str="[";
                        $wo_pend_str="[";
                        $wo_comp_str="[";
                        $wo_closed_str="[";
                        for($i=4;$i>=0;$i--)
                        {
                            $y=($i*7)+1;
                            $z=($i+1)*7;
                            if($i==0)
                            {
                                 $week_edval=date("Y-m-d");
                                 $week_stval=date("Y-m-d", strtotime('-7 days'));
                                 $week_name="Week".($i+1)."  ".date("d/M/Y",strtotime('-7 days'))."-" .date("d/M/Y");
                            }
                            else
                            {
                                 $week_edval=date("Y-m-d", strtotime('-'.$y.' days'));
                                 $week_stval=date("Y-m-d", strtotime('-'.$z.' days'));
                                 $week_name=" Week".($i+1)."  ".date("d/M/Y",strtotime('-'.$z.' days'))."-" .date("d/M/Y",strtotime('-'.$y.' days'));
                            }
                             $y_val=$y_val."'".$week_name."' ,";
                              $sq_op= "SELECT count(ticket_id) as ct FROM `tbl_tickets` WHERE `ticket_status`!='Cancelled' and date_format(created_date_time,'%Y-%m-%d') between '".$week_stval."'  and '".$week_edval."'";
                            $result_sq_op = mysqli_query($varDBConnection,$sq_op);
                            	while($row_sq_op=mysqli_fetch_assoc($result_sq_op)) { 
                            	    
                            	    $wo_open_str=$wo_open_str.$row_sq_op['ct'].",";
                            	   
                            	}
                            
                            $sq_pend= "SELECT count(amc_visit_id) as ct FROM `tbl_visits` WHERE amc_visit_status not in ('Closed','Opened','Cancelled','Completed') and amc_ticket='TKT'  and DATE_FORMAT(date_of_visits,'%Y-%m-%d') between '".$week_stval."'  and '".$week_edval."'";
                            $result_sq_pend = mysqli_query($varDBConnection,$sq_pend);
                            	while($row_sq_pend=mysqli_fetch_assoc($result_sq_pend)) { 
                            	   
                            	    $wo_pend_str=$wo_pend_str.$row_sq_pend['ct'].",";
                            	   
                            	}
                        
                          $sq_comp= "select count(ticket_id ) as ct from tbl_tickets where   ticket_status  in ('Completed','Closed') and  DATE_FORMAT(completed_date_time,'%Y-%m-%d') between '".$week_stval."'  and '".$week_edval."'";
                            $result_sq_comp = mysqli_query($varDBConnection,$sq_comp);
                            	while($row_sq_comp=mysqli_fetch_assoc($result_sq_comp)) { 
                            	   
                            	    $wo_comp_str=$wo_comp_str.$row_sq_comp['ct'].",";
                            	   
                            	}
                         $sq_closed= "select count(ticket_id ) as ct from tbl_tickets where   ticket_status  in ('Closed') and  DATE_FORMAT(completed_date_time,'%Y-%m-%d') between '".$week_stval."'  and '".$week_edval."'";
                            $result_sq_closed = mysqli_query($varDBConnection,$sq_closed);
                            	while($row_sq_closed=mysqli_fetch_assoc($result_sq_closed)) { 
                            	   
                            	    $wo_closed_str=$wo_closed_str.$row_sq_closed['ct'].",";
                            	   
                            	}
                           
                        }
                break;
                case 'd':
                        $title='Daily';
                        $y_val="[";
                        $wo_open_str="[";
                        $wo_pend_str="[";
                        $wo_comp_str="[";
                        $wo_closed_str="[";
                       for($i=6;$i>=0;$i--)
                        {
                           
                            if($i==0)
                            {
                                 $dval=date("Y-m-d");
                                  $d_name=date(" d-M-Y");
                               
                            }
                            else
                            {
                                 $dval=date("Y-m-d", strtotime('-'.$i.' days'));
                                
                                 $d_name=date(" d-M-Y",strtotime('-'.$i.' days'));
                            }
                             $y_val=$y_val."'".$d_name."' ,";
                              $sq_op= "SELECT count(ticket_id) as ct FROM `tbl_tickets` WHERE `ticket_status`!='Cancelled' and date_format(created_date_time,'%Y-%m-%d') ='".$dval."'";
                            $result_sq_op = mysqli_query($varDBConnection,$sq_op);
                            	while($row_sq_op=mysqli_fetch_assoc($result_sq_op)) { 
                            	    
                            	    $wo_open_str=$wo_open_str.$row_sq_op['ct'].",";
                            	   
                            	}
                            
                            $sq_pend= "SELECT count(amc_visit_id) as ct FROM `tbl_visits` WHERE amc_visit_status not in ('Closed','Opened','Cancelled','Completed') and amc_ticket='TKT'  and DATE_FORMAT(date_of_visits,'%Y-%m-%d') ='".$dval."'";
                            $result_sq_pend = mysqli_query($varDBConnection,$sq_pend);
                            	while($row_sq_pend=mysqli_fetch_assoc($result_sq_pend)) { 
                            	   
                            	    $wo_pend_str=$wo_pend_str.$row_sq_pend['ct'].",";
                            	   
                            	}
                        
                          $sq_comp= "select count(ticket_id ) as ct from tbl_tickets where   ticket_status  in ('Completed','Closed') and  DATE_FORMAT(completed_date_time,'%Y-%m-%d') ='".$dval."'";
                            $result_sq_comp = mysqli_query($varDBConnection,$sq_comp);
                            	while($row_sq_comp=mysqli_fetch_assoc($result_sq_comp)) { 
                            	   
                            	    $wo_comp_str=$wo_comp_str.$row_sq_comp['ct'].",";
                            	   
                            	}
                         $sq_closed= "select count(ticket_id ) as ct from tbl_tickets where   ticket_status  in ('Closed') and  DATE_FORMAT(closed_on,'%Y-%m-%d')='".$dval."'";
                            $result_sq_closed = mysqli_query($varDBConnection,$sq_closed);
                            	while($row_sq_closed=mysqli_fetch_assoc($result_sq_closed)) { 
                            	   
                            	    $wo_closed_str=$wo_closed_str.$row_sq_closed['ct'].",";
                            	   
                            	}
                         
                        }
                break;
                default:
                         $title='Monthly';
                        $y_val="[";
                        $wo_open_str="[";
                        $wo_pend_str="[";
                        $wo_comp_str="[";
                        $wo_closed_str="[";
                         for($i=4;$i>=0;$i--)
                        { 
                            if($i==0)
                            {
                                 $month_val=date('Y-m');
                                 $month_name=date('M-Y');
                            }
                            else
                            {
                                 $month_val=date('Y-m', strtotime("-".$i." month"));
                                 $month_name=date('M-Y', strtotime("-".$i." month"));
                            }
                            $y_val=$y_val."'".$month_name."' ,";
                            $sq_op= "SELECT count(ticket_id) as ct FROM `tbl_tickets` WHERE `ticket_status`!='Cancelled' and date_format(created_date_time,'%Y-%m')='".$month_val."'";
                            $result_sq_op = mysqli_query($varDBConnection,$sq_op);
                            	while($row_sq_op=mysqli_fetch_assoc($result_sq_op)) { 
                            	    
                            	    $wo_open_str=$wo_open_str.$row_sq_op['ct'].",";
                            	   
                            	}
                            
                            $sq_pend= "SELECT count(amc_visit_id) as ct FROM `tbl_visits` WHERE amc_visit_status not in ('Closed','Opened','Cancelled','Completed') and amc_ticket='TKT'  and DATE_FORMAT(date_of_visits,'%Y-%m')='".$month_val."'";
                            $result_sq_pend = mysqli_query($varDBConnection,$sq_pend);
                            	while($row_sq_pend=mysqli_fetch_assoc($result_sq_pend)) { 
                            	   
                            	    $wo_pend_str=$wo_pend_str.$row_sq_pend['ct'].",";
                            	   
                            	}
                        
                          $sq_comp= "select count(ticket_id ) as ct from tbl_tickets where   ticket_status  in ('Completed','Closed') and  DATE_FORMAT(completed_date_time,'%Y-%m')='".$month_val."'";
                            $result_sq_comp = mysqli_query($varDBConnection,$sq_comp);
                            	while($row_sq_comp=mysqli_fetch_assoc($result_sq_comp)) { 
                            	   
                            	    $wo_comp_str=$wo_comp_str.$row_sq_comp['ct'].",";
                            	   
                            	}
                         $sq_closed= "select count(ticket_id ) as ct from tbl_tickets where   ticket_status  in ('Closed') and  DATE_FORMAT(closed_on,'%Y-%m')='".$month_val."'";
                            $result_sq_closed = mysqli_query($varDBConnection,$sq_closed);
                            	while($row_sq_closed=mysqli_fetch_assoc($result_sq_closed)) { 
                            	   
                            	    $wo_closed_str=$wo_closed_str.$row_sq_closed['ct'].",";
                            	   
                            	}
                            
                          
                         }
                 break;
            }
           
            
                  $wo_open_str= rtrim($wo_open_str,',');
                    $wo_open_str=$wo_open_str."]";
                     $wo_pend_str= rtrim($wo_pend_str,',');
                    $wo_pend_str=$wo_pend_str."]";
                     $wo_comp_str= rtrim($wo_comp_str,',');
                    $wo_comp_str=$wo_comp_str."]";
                     $wo_closed_str= rtrim($wo_closed_str,',');
                    $wo_closed_str=$wo_closed_str."]";
                     $y_val= rtrim($y_val,',');
                    $y_val=$y_val."]";
      ?>
  	    
  <div class="card" >
						<div class="card-header">
							<div class="card-header header-elements-inline" >
								<h5 class="card-title">Work Orders Raised - <?php echo $title;?></h5>
								<div class="header-elements">
								
									<div class="list-icons ml-3">
									    <div class="btn-group ml-1">
			                    	<button type="button" class="btn btn-outline bg-purple-300 text-purple-800 btn-icon dropdown-toggle" data-toggle="dropdown">
				                    	<i class="icon-link"></i>
			                    	</button>

			                    	<div class="dropdown-menu dropdown-menu-right">
										<a href="dashboard.php?wo=y&param=<?PHP echo $OBJ->URLEncode('title=dashboard');?>" class="dropdown-item" id="a_graph_year"><i class="icon-screen-full" ></i>Yearly</a>
										<a href="dashboard.php?wo=m&param=<?PHP echo $OBJ->URLEncode('title=dashboard');?>" class="dropdown-item" id="a_graph_month"><i class="icon-screen-full" ></i>Monthly</a>
										<a href="dashboard.php?wo=w&param=<?PHP echo $OBJ->URLEncode('title=dashboard');?>" class="dropdown-item" id="a_graph_week"><i class="icon-screen-full" ></i>Weekly</a>
										<a href="dashboard.php?wo=d&param=<?PHP echo $OBJ->URLEncode('title=dashboard');?>" class="dropdown-item" id="a_graph_day"><i class="icon-screen-full"></i>Daily</a>
										
									</div>
								</div>
				      
				                	</div>
								</div>
							</div>
						</div>

						<div class="card-body">
							

							<div class="chart-container">
							    <div class="chart has-fixed-height" id="bars_basic"></div>
							 
							</div>
						</div>
					</div>
					
					 <script>
	
 

    var EchartsBarsBasicLight = function() {


    // Basic bar chart
    var _barsBasicLightExample = function() {
        if (typeof echarts == 'undefined') {
            console.warn('Warning - echarts.min.js is not loaded.');
            return;
        }

        // Define element
        var bars_basic_element = document.getElementById('bars_basic');


        //
        // Charts configuration
        //

        if (bars_basic_element) {

            // Initialize chart
            var bars_basic = echarts.init(bars_basic_element);

            //
            // Chart config
            //

            // Options
            bars_basic.setOption({

                // Global text styles
                textStyle: {
                    fontFamily: 'Roboto, Arial, Verdana, sans-serif',
                    fontSize: 13
                },

                // Chart animation duration
                animationDuration: 750,

                // Setup grid
                grid: {
                    left: 0,
                    right: 30,
                    top: 35,
                    bottom: 0,
                    containLabel: true
                },

                // Add legend
                legend: {
                    data: ['Raised', 'Pending','Completed', 'Closed'],
                    itemHeight: 8,
                    itemGap: 20,
                    textStyle: {
                        padding: [0, 5]
                    }
                },

                // Add tooltip
                tooltip: {
                    trigger: 'axis',
                    backgroundColor: 'rgba(0,0,0,0.75)',
                    padding: [10, 15],
                    textStyle: {
                        fontSize: 13,
                        fontFamily: 'Roboto, sans-serif'
                    },
                    axisPointer: {
                        type: 'shadow',
                        shadowStyle: {
                            color: 'rgba(0,0,0,0.025)'
                        }
                    }
                },

                // Horizontal axis
                xAxis: [{
                    type: 'value',
                    boundaryGap: [0, 0.01],
                    axisLabel: {
                        color: '#333'
                    },
                    axisLine: {
                        lineStyle: {
                            color: '#999'
                        }
                    },
                    splitLine: {
                        show: true,
                        lineStyle: {
                            color: '#eee',
                            type: 'dashed'
                        }
                    }
                }],

                // Vertical axis
                yAxis: [{
                    type: 'category',
                    data: <?php echo $y_val; ?>,
                    axisLabel: {
                        color: '#333'
                    },
                    axisLine: {
                        lineStyle: {
                            color: '#999'
                        }
                    },
                    splitLine: {
                        show: true,
                        lineStyle: {
                            color: ['#eee']
                        }
                    },
                    splitArea: {
                        show: true,
                        areaStyle: {
                            color: ['rgba(250,250,250,0.1)', 'rgba(0,0,0,0.015)']
                        }
                    }
                }],

                // Add series
                series: [
                    {
                        name: 'Raised',
                        type: 'bar',
                        itemStyle: {
                            normal: {
                                color: '#42A5F5'
                            }
                        },
                        data: <?php echo $wo_open_str; ?>
                    },
                    {
                        name: 'Pending',
                        type: 'bar',
                        itemStyle: {
                            normal: {
                                color: '#EF5350'
                            }
                        },
                        data: <?php echo $wo_pend_str;?>
                    },
                    {
                        name: 'Completed',
                        type: 'bar',
                        itemStyle: {
                            normal: {
                                color: '#2ec7c9'
                            }
                        },
                        data: <?php echo $wo_comp_str;?>
                    },
                    {
                        name: 'Closed',
                        type: 'bar',
                        itemStyle: {  
                            normal: {
                                color: '#66BB6A'
                            }
                        },
                        data: <?php echo $wo_closed_str;?>
                    }
                ]
                
            });
        }
        
        bars_basic.on('click', function(params) {
            if (params.componentType === 'series') {
                var seriesName = params.seriesName;
                var dataIndex = params.dataIndex;
                var value = params.value;
                console.log('Clicked bar:', seriesName, 'at index:', dataIndex, 'with value:', value);
            }
        });

        //
        // Resize charts
        //

        // Resize function
        var triggerChartResize = function() {
            bars_basic_element && bars_basic.resize();
        };

        // On sidebar width change
        var sidebarToggle = document.querySelector('.sidebar-control');
        sidebarToggle && sidebarToggle.addEventListener('click', triggerChartResize);

        // On window resize
        var resizeCharts;
        window.addEventListener('resize', function() {
            clearTimeout(resizeCharts);
            resizeCharts = setTimeout(function () {
                triggerChartResize();
            }, 200);
        });
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _barsBasicLightExample();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    EchartsBarsBasicLight.init();
});

 </script>