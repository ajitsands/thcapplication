$(document).ready(function(){
  
 
                     var v_btn_team_add = $( '#btn_team_add' ).ladda();
                     var v_btn_team_edit = $( '#btn_team_edit' ).ladda();
                     var v_btn_team_new = $( '#btn_team_new' ).ladda();
                    
                     $("#btn_team_edit").hide();
                     $("#btn_team_new").hide();
                     team_list_table = $('#list_of_team_members').DataTable( {} );
                    // $('#list_of_team_members').removeClass( 'display' ).addClass('table table-striped table-bordered');                    
                  var v_technicain_id=[];
                  var v_technicain_name=[];
              load_data_to_grid_team();
            //   $('#select_technicians').on('select2:select', function (e) {
                
            //      var data = e.params.data;
                  
               
            //      expertise_id= data.id;
            //      v_technicain_name= $('#select_technicians option:selected') .toArray().map(item => item.text);
            //      v_technicain_id = $('#select_technicians option:selected') .toArray().map(item => item.value);
            //      console.log(v_technicain_id);
            //      console.log(v_technicain_name);
                 
                
               
            //     });  
            
            
              $("#select_technicians option:selected").each(function () {
              var $this = $(this);
              if ($this.length) {
                var selText = $this.text();
                console.log(selText);
              }
            });
     
             // Insert team details....
 
                 v_btn_team_add.click(function(){
                    
                     v_btn_team_add.ladda( 'start' );
                        var v_team_name=$("#txt_team_name").val();
                        var v_team_leader_id_code=$("#select_team_leader option:selected").val();
                        var v_team_leader_name=$("#select_team_leader option:selected").text();
                        var v_team_leader_id_code = v_team_leader_id_code.split("-");
                        var v_team_leader_id=v_team_leader_id_code[0];
                        var v_team_leader_code=v_team_leader_id_code[1];
                        
                        var selected = $("#select_technician option:selected");
                       
                          var v_tech_name = [];
                          var v_tech_id=[];
                          
                            selected.each(function () {
                                v_tech_name += $(this).text() + "^" ;
                                v_tech_id +=$(this).val()+ "^";
                            });
                            
                           
                            
                         
                         
                 
                  
                     if($.trim(v_team_name)==""||$.trim(v_team_leader_id)=="select"||$.trim(v_team_leader_code)=="")
                    
                    {
                        swal("Warning","Please provide all the information ....", "warning");
                        v_btn_team_add.ladda( 'stop' );
                        return false;
                    }
                   
                    else
                    {         
                         $.post("../controller/team/team_details_controller.php",{action:'add_team_members',v_team_name:v_team_name,v_team_leader_id:v_team_leader_id,v_team_leader_code:v_team_leader_code,v_team_leader_name:v_team_leader_name,v_tech_name:v_tech_name,v_tech_id:v_tech_id }
                                , function(result,status)
                                {
                                   
                                result = $.trim(result);
                               
                                if(result.charAt(0)=='U')
                                {
                                    v_btn_team_add.ladda( 'stop' );
                                    swal("Error", result, "error");
                                   
                                   
                                }
                                else 
                                {
                                     v_btn_team_add.ladda( 'stop' );
                                     swal("Success", "Team member added successfully..", "success");
                                     
                                    //load_data_to_grid_expertise();
                                   // clear_text();
                                }
                                
                                 
                            
                        });
                        
                       
                        
                     }
                  
                 });
                 
                 
                 
                  function load_data_to_grid_team()
                 {
                     team_list_table.destroy();
                         
                     team_list_table = $('#list_of_team_members').DataTable( {
                            
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/team/team_details_controller.php',
                                 'data': {
                                    action: 'list_of_team',
                                   
                                 }
                             },
                             "language": {
                                 "zeroRecords": "No records available",
                                 "infoEmpty": "No records available",
                              },
                             "order": [[ 0, "desc" ]],
            				"bPaginate": true,
            				"bLengthChange": false,
            				"bFilter": false,
            				"bInfo": false,
            				"autoWidth": false,
                             "columns": [
                                
                                 { "data": "team_id","visible":false},
                                 
                                 { "data": "employee_name" },
                                 { "data": "employee_type_id","visible":false},
                                 { "data": "employee_type_name"},
                                 { "data": "expertise_name"},
                                 { "data": "team_name"}
                                 
                               
                             ],
                             pageLength: 25,
            				 searching: false,
                             responsive: true,
                             
                             "initComplete": function( settings, json ) {
             
                              },
                              "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                                //  $("td:eq(0)", nRow).html(iDisplayIndex + 1);
                                //  return nRow;
                             } ,
                             columnDefs: [
                             {
                                 "targets": [0,5],
                                 "visible": false
                             }
                                 
                             ],
				 
				 
                            "order": [
                              [5, 'asc']
                            ],
                            "displayLength": 25,
                            "drawCallback": function (settings) {
                              var api = this.api();
                              var rows = api.rows({
                                page: 'current'
                              }).nodes();
                              var last = null;
                        
                              api.column(5, {
                                page: 'current'
                              }).data().each(function (group, i) {
                                if (last !== group) {
                                  $(rows).eq(i).before(
                                    '<tr class="group" style="background-color:#2a3140;font-size: 15px;color:white;font-weight: bold; "><td colspan="4">' + group + '</td></tr>'
                                  );
                        
                                  last = group;
                                }
                              });
                            },
             
                             
                             
                         });
                 
                }
     
            
        
        
 

});