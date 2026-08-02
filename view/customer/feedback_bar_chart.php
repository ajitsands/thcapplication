
<?php  include_once(__DIR__ . '/../../model/db_connection/connection.php');
            $DBConn = new DBConnection();
            $varDBConnection = $DBConn->ConnectToMYSQL();?>
            <?php 
          // '#42A5F5','#EF5350','#2ec7c9','#66BB6A'
          $sql_cond='';
          if($_GET['cust_id']=='All')
          {
            $sql_cond=$sql_cond;
          }
          else
          {
              $sql_cond=$sql_cond. " customer_code='".$_GET['cust_id']."' and ";
          }
          if($_GET['cat_text']=='All')
          {
            $sql_cond=$sql_cond;
          }
          else if($_GET['cat_text']='Hard ')
          {
              $sql_cond=$sql_cond. " contract_type='Hard & Soft Facility Management Service' and ";
          }
         else
          {
              $sql_cond=$sql_cond. " contract_type='".$_GET['cat_text']."' and ";
          }
         //  $sql_cond=substr($sql_cond, 0, -4);
          //echo $sql_cond;
          $i=0;
            $sql_question="SELECT * FROM feedback_questions ";
            $result_question = mysqli_query($varDBConnection,$sql_question);
            while($row_question=mysqli_fetch_assoc($result_question)) { 
                $i=$i+1;
                if($i%2==0)
                  {
                     $color_scheme='#66BB6A'; 
                  }
                  else
                  {
                     $color_scheme='#2ec7c9'; 
                  }
                   $ids=$row_question['id']; 
                  $question=$row_question['question_text'];
                if($row_question['type']!='text')
                {
                   
                $y_val="[";
                $option_str="[";
                $sql_options="SELECT * FROM feedback_options WHERE question_id =".$row_question['id'] ;
                $result_options = mysqli_query($varDBConnection,$sql_options);
        	          while($row_options=mysqli_fetch_assoc($result_options)) {
        	               $y_val=$y_val."'".$row_options['option_text']."',";
        	                $sql_options_count="SELECT COUNT(*) as feedback_option_count FROM feedback_responses WHERE ".$sql_cond."question_id = ".$row_question['id']." AND option_id = ".$row_options['id']." and  date_format(default_date,'%Y-%m-%d') >= '".$_GET['start_date']."' and date_format(default_date,'%Y-%m-%d') <= '".$_GET['end_date']."'" ;
        	              // echo $sql_options_count;
        	                $result_options_count = mysqli_query($varDBConnection,$sql_options_count);
                	          while($row_options_count=mysqli_fetch_assoc($result_options_count)) {
                	              $option_str=$option_str.$row_options_count['feedback_option_count'].",";
                	          }
        	               
        	              
        	          }
        	           $y_val= rtrim($y_val,',');
                        $y_val=$y_val."]";
                        $option_str= rtrim($option_str,',');
                        $option_str=$option_str."]";
                        
                        ?>
                          <div class="card" >
						<div class="card-header">
							<div class="card-header header-elements-inline" >
								<h5 class="card-title"> <?php echo $row_question['question_text'];?></h5>
							
							</div>
						</div>

						<div class="card-body">
							

							<div class="chart-container">
							  
							    <div class="chart has-fixed-height" id="bars_basic_<?php echo $ids;?>"></div>
							 
							</div>
						</div>
					</div>
			
	<script>
	
 

    var EchartsBarsBasicLight_<?php echo $ids;?> = function() {


    // Basic bar chart
    var _barsBasicLightExample_<?php echo $ids;?> = function() {
        if (typeof echarts == 'undefined') {
            console.warn('Warning - echarts.min.js is not loaded.');
            return;
        }

        // Define element
        var bars_basic_element_<?php echo $ids;?> = document.getElementById('bars_basic_<?php echo $ids;?>');


        //
        // Charts configuration
        //

        if (bars_basic_element_<?php echo $ids;?>) {

            // Initialize chart
            var bars_basic_<?php echo $ids;?> = echarts.init(bars_basic_element_<?php echo $ids;?>);

            //
            // Chart config
            //

            // Options
            bars_basic_<?php echo $ids;?>.setOption({

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
                    data: ['Feedback'],
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
                yAxis: [{
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
                xAxis: [{
                    type: 'category',
                    data: <?php echo $y_val;?>,
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
                        name: 'Feedback Count',
                        type: 'line',
                        itemStyle: {
                            normal: {
                                color: '<?php echo $color_scheme;?>'
                            }
                        },
                        data: <?php echo $option_str;?>
                    }
                   
                ]
            });
        }


        //
        // Resize charts
        //

        // Resize function
        var triggerChartResize_<?php echo $ids;?> = function() {
            bars_basic_element_<?php echo $ids;?> && bars_basic_<?php echo $ids;?>.resize();
        };

        // On sidebar width change
        var sidebarToggle_<?php echo $ids;?> = document.querySelector('.sidebar-control');
        sidebarToggle_<?php echo $ids;?> && sidebarToggle_<?php echo $ids;?>.addEventListener('click', triggerChartResize_<?php echo $ids;?>);

        // On window resize
        var resizeCharts_<?php echo $ids;?>;
        window.addEventListener('resize', function() {
            clearTimeout(resizeCharts_<?php echo $ids;?>);
            resizeCharts_<?php echo $ids;?> = setTimeout(function () {
                triggerChartResize_<?php echo $ids;?>();
            }, 200);
        });
    };


    return {
        init: function() {
            _barsBasicLightExample_<?php echo $ids;?>();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    EchartsBarsBasicLight_<?php echo $ids;?>.init();
});

 </script>
                        
                        
        <?php          
            } //close of if
            else
            {
               
              
            // $sql_text_response="SELECT response_text FROM feedback_text_responses WHERE question_id =".$ids;
           
            //  $result_text_response = mysqli_query($varDBConnection,$sql_text_response);
        	   //       while($row_text_response=mysqli_fetch_assoc($result_text_response)) {
        	   //            $texts[] = $row_text_response['response_text'];
        	   //       }
                
                
                
            //     $y_val="['Positive','Negative','Neutral']";
            
                ?>
               
                 <div class="card" >
						<div class="card-header">
							<div class="card-header header-elements-inline" >
								<h5 class="card-title"> <?php echo $row_question['question_text'];?></h5>
							
							</div>
							<div class="col-lg-12 col-md-12 col-sm-12 " >
								<button type="button"  id="<?php echo $ids;?>" class="btn bg-info legitRipple ladda-button btn_question_comments" tabindex="4" data-style="expand-right" fdprocessedid="mqx0bj"><span class="ladda-label">View Responses</span></button>
                            </div>
						</div>

						<!--<div class="card-body">-->
						    
							<!--<div class="chart-container">-->
							  
							<!--    <div class="chart has-fixed-height" id="bars_basic_<?php //echo $ids;?>"></div>-->
							 
							<!--</div>-->
						<!--</div>-->
					</div>
                	<?php 
                
                	//include("../../customer_feedback/feedback_sentimental_analysis.php");?>
               	<script>


//   var EchartsBarsBasicLight_<?php echo $ids;?> = function() {

//     var _barsBasicLightExample_<?php echo $ids;?> = function() {
//         if (typeof echarts == 'undefined') {
//             console.warn('Warning - echarts.min.js is not loaded.');
//             return;
//         }

//         // Define element
//         var bars_basic_element_<?php echo $ids;?> = document.getElementById('bars_basic_<?php echo $ids;?>');


//         //
//         // Charts configuration
//         //

//         if (bars_basic_element_<?php echo $ids;?>) {

//             // Initialize chart
//             var bars_basic_<?php echo $ids;?> = echarts.init(bars_basic_element_<?php echo $ids;?>);

//             //
//             // Chart config
//             //
 
    
//             // Options
//             bars_basic_<?php echo $ids;?>.setOption({
 
//                 // Global text styles
//                 textStyle: {
//                     fontFamily: 'Roboto, Arial, Verdana, sans-serif',
//                     fontSize: 13
//                 },

//                 // Chart animation duration
//                 animationDuration: 750,

//                 // Setup grid
//                 grid: {
//                     left: 0,
//                     right: 30,
//                     top: 35,
//                     bottom: 0,
//                     containLabel: true
//                 },

//                 // Add legend
//                 legend: {
//                     data: ['Feedback'],
//                     itemHeight: 8,
//                     itemGap: 20,
//                     textStyle: {
//                         padding: [0, 5]
//                     }
//                 },

//                 // Add tooltip
//                 tooltip: {
//                     trigger: 'axis',
//                     backgroundColor: 'rgba(0,0,0,0.75)',
//                     padding: [10, 15],
//                     textStyle: {
//                         fontSize: 13,
//                         fontFamily: 'Roboto, sans-serif'
//                     },
//                     axisPointer: {
//                         type: 'shadow',
//                         shadowStyle: {
//                             color: 'rgba(0,0,0,0.025)'
//                         }
//                     }
//                 },

//                 // Horizontal axis
//                 yAxis: [{
//                     type: 'value',
//                     boundaryGap: [0, 0.01],
//                     axisLabel: {
//                         color: '#333'
//                     },
//                     axisLine: {
//                         lineStyle: {
//                             color: '#999'
//                         }
//                     },
//                     splitLine: {
//                         show: true,
//                         lineStyle: {
//                             color: '#eee',
//                             type: 'dashed'
//                         }
//                     }
//                 }],

//                 // Vertical axis
//                 xAxis: [{
//                     type: 'category',
//                     data: <?php echo $y_val;?>,
//                     axisLabel: {
//                         color: '#333'
//                     },
//                     axisLine: {
//                         lineStyle: {
//                             color: '#999'
//                         }
//                     },
//                     splitLine: {
//                         show: true,
//                         lineStyle: {
//                             color: ['#eee']
//                         }
//                     },
//                     splitArea: {
//                         show: true,
//                         areaStyle: {
//                             color: ['rgba(250,250,250,0.1)', 'rgba(0,0,0,0.015)']
//                         }
//                     }
//                 }],

//                 // Add series
//                 series: [
//                     {
//                         name: 'Feedback Count',
//                         type: 'line',
//                         itemStyle: {
//                             normal: {
//                                 color: '#EF5350'
//                             }
//                         },
                        
//                       data: <?php echo $xy_val;?>
//                     }
                   
//                 ]
//             }); 
            
 
//         }



//         // Resize function
//         var triggerChartResize_<?php echo $ids;?> = function() {
//             bars_basic_element_<?php echo $ids;?> && bars_basic_<?php echo $ids;?>.resize();
//         };

//         // On sidebar width change
//         var sidebarToggle_<?php echo $ids;?> = document.querySelector('.sidebar-control');
//         sidebarToggle_<?php echo $ids;?> && sidebarToggle_<?php echo $ids;?>.addEventListener('click', triggerChartResize_<?php echo $ids;?>);

//         // On window resize
//         var resizeCharts_<?php echo $ids;?>;
//         window.addEventListener('resize', function() {
//             clearTimeout(resizeCharts_<?php echo $ids;?>);
//             resizeCharts_<?php echo $ids;?> = setTimeout(function () {
//                 triggerChartResize_<?php echo $ids;?>();
//             }, 200);
//         });
//     };


//     return {
//         init: function() {
//             _barsBasicLightExample_<?php echo $ids;?>();
//         }
//     }
// }();


// document.addEventListener('DOMContentLoaded', function() {
//     EchartsBarsBasicLight_<?php echo $ids;?>.init();
// });
  </script>
                		
 <?php 
             
            }// close of else
                    
        } //close of while
           
                          
      ?>
      <input type="hidden" id="txt_cust_ids" value="<?php echo $_GET['cust_id'];?>"/>
      <?php include('feedback_question_modal.php');?> 
 <script>
 var list_of_question_responses = $('#tbl_question_responses').DataTable();
  $('.btn_question_comments').click(function(){
      var id_ques = $(this).attr('id');
      var cust_code=$('#txt_cust_ids').val();
      $('#modal_question_comments').modal('show'); 
       load_quest_responses(id_ques,cust_code);
      
     // alert(id);
  });
    function load_quest_responses(id_ques,cust_code)
                 {
                     
                    list_of_question_responses.destroy();
                         
                     list_of_question_responses = $('#tbl_question_responses').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/customer/customer_controller.php',
                                 'data': {
                                    action: 'question_feedback',question_ids:id_ques,customer_code:cust_code
                                    
                                 }
                             },
                             "language": {
                                 "zeroRecords": "No records available",
                                 "infoEmpty": "No records available",
                              },
                           // "order": [[ 0, "desc" ]],
                           
            				"Paginate": true,
            				"bLengthChange": false,
            				"bFilter": false,
            				"bInfo": false,
            				"autoWidth": false,
            				
            			
                            "columns": [
                              
                                 
                                 { "data": "response_text" }
                                 
                       
                             ],
                             pageLength: 100,
            				 searching: true,
                             responsive: true,
                             
                             "aoColumnDefs": [
            					{ "bSortable": false, "aTargets": [0] }, 
            					
            				],
                            
            				
                             "initComplete": function( settings, json ) {
                                    
                               
             
                              },
                                "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                                // $("td:eq(1)", nRow).html(iDisplayIndex + 1);
                                // return nRow;
                              },
                              "drawCallback": function () {
                                   
                                }
                            
                     });  
                
                 }   
 </script> 	    
