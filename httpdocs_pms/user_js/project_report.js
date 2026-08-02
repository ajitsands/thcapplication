$(document).ready(function(){
  
   $(":input:not(:hidden)").each(function (i) { $(this).attr('tabindex', i + 1); });
    $("#h5_project_title").html('All Projects');
     $("#div_preview").hide();
     var pjt_id;
    var today = new Date();
    var dd = String(today. getDate()). padStart(2, '0');
    var mm = String(today. getMonth() + 1). padStart(2, '0'); //January is 0!
    var yyyy = today. getFullYear();
    var curdate=yyyy+'-'+mm+'-'+dd;
   project_list_table = $('#list_of_project_entries').DataTable( {} );
   //load_data_to_grid_project_details_list(0,curdate,curdate,0,0,0,0,0,0);
   load_project_combo();
    function load_project_combo()
     {
      
         $.ajax({
		type: "POST",
		url: "projects/combo_report_projects.php",
		 }).done(function(data){
		     
			
			$("#div_project_select_report").html(data);
			$("#select_project_project").select2();
		    
		 });
     }
      function load_combo()
     {
      
         $.ajax({
		type: "POST",
		url: "projects/combo_projects.php",
		 }).done(function(data){
		     
			
			$("#div_project_select").html(data);
			$("#select_project").select2();
		    
		 });
     }
     function load_project_combo_edit(pjt_id)
     {
      
         $.ajax({
		type: "POST",
		url: "projects/combo_projects_edit.php",
		data:{project_ids:pjt_id},
		 }).done(function(data){
		     
			
			$("#div_project_select_edit").html(data);
			$("#select_project_edit").select2();
		    
		 });
     }
     var v_pjt_id,v_date,v_todate,v_location,v_place,v_parts,v_category,v_priority,v_emp;
      $("#btn_project_view").click(function(){
          var v_project_id=$("#select_project_project option:selected").val();
          var v_project_name=$("#select_project_project option:selected").text();
          var v_date=$("#txt_date").val();
           var v_todate=$("#txt_todate").val();
           
           var diff = Date.parse(v_todate) - Date.parse(v_date);
           var days = diff/1000/60/60/24;
           
           var v_location=$("#select_location option:selected").val();
           var v_place=$("#select_place option:selected").val();
           var v_parts=$("#select_parts option:selected").val();
           var v_category=$("#select_category option:selected").val();
           var v_priority=$("#select_priority option:selected").val();
           var v_emp=$("#select_technician option:selected").val();
           if(v_project_id=='select')
           {
                swal("Warning","Please select the project ....", "warning");
                       
                        return false;
           }
           else
           {
           if(days<0)
           {
                swal("Warning","Please select the valid date range ....", "warning");
                       
                        return false;
           }
           else
           {
               load_data_to_grid_project_details_list(v_project_id,v_date,v_todate,v_location,v_place,v_parts,v_category,v_priority,v_emp);
           }
           }
      });
       $("#btn_project_export").click(function(){
           var v_project_id=$("#select_project_project option:selected").val();
          var v_project_name=$("#select_project_project option:selected").text();
          var v_date=$("#txt_date").val();
           var v_todate=$("#txt_todate").val();
           
           var diff = Date.parse(v_todate) - Date.parse(v_date);
           var days = diff/1000/60/60/24;
           
           var v_location=$("#select_location option:selected").val();
           var v_place=$("#select_place option:selected").val();
           var v_parts=$("#select_parts option:selected").val();
           var v_category=$("#select_category option:selected").val();
           var v_priority=$("#select_priority option:selected").val();
           var v_emp=$("#select_technician option:selected").val();
           if(v_project_id=='select')
           {
                swal("Warning","Please select the project ....", "warning");
                       
                        return false;
           }
           else
           {
               
           
               if(days<0)
               {
                    swal("Warning","Please select the valid date range ....", "warning");
                           
                            return false;
               }
               else
               {
                   window.open("snag_list.php?v_project_id="+v_project_id+"&v_project_name="+v_project_name+"&v_date="+v_date+"&v_todate="+v_todate+"&v_location="+v_location+"&v_place="+v_place+"&v_parts="+v_parts+"&v_category="+v_category+"&v_priority="+v_priority+"&v_emp="+v_emp,"_blank");
               }
            }
         
      });
     
   function load_data_to_grid_project_details_list(v_pjt_id,v_date,v_todate,v_location,v_place,v_parts,v_category,v_priority,v_emp)
                 {
                     
                    project_list_table.destroy();
                         
                     project_list_table = $('#list_of_project_entries').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/project/project_report_controller.php',
                                 'data': {
                                    action: 'list_entries',v_project_id:v_pjt_id,v_date:v_date,v_todate:v_todate,v_location:v_location,v_place:v_place,v_parts:v_parts,v_category:v_category,v_priority:v_priority,v_emp:v_emp
                                 }
                             },
                             "language": {
                                 "zeroRecords": "No records available",
                                 "infoEmpty": "No records available",
                              },
                           // "order": [[ 0, "desc" ]],
                           
            				"Paginate": true,
            				"bLengthChange": true,
            				"bFilter": true,
            				"bInfo": true,
            				"autoWidth": false,
            				
            			
                            "columns": [
                                
                                 
                                 { "data": null},
                                   { "data": "project_entries_id",
                                      render: function ( data, type, rows, meta ) {
                                          str_active_status_edit = '<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown" style="color:info">	<i class="icon-menu9"></i>	</a>	<div class="dropdown-menu dropdown-menu-right">	<a href="#" class="dropdown-item" name="view_img" style="color:green"><i class="icon-image5"></i> View Pic</a><a href="#" class="dropdown-item" name="edit_entries" style="color:orange"><i class="icon-database-edit2"></i> Edit</a><a href="#" class="dropdown-item" name="delete_entries" style="color:red"><i class="icon-database-remove"></i> Delete</a></div></div></div>';
                                          return str_active_status_edit;
                                          
                                      }   
                                 },
                                 { "data": "project_name"},
                                 { "data": "description" },
                                 { "data": "location" },
                                 { "data": "place" },
                                 { "data": "parts" },
                                 { "data": "category" },
                                 { "data": "comments" },
                                 { "data": "priority",
                                      render: function ( data, type, rows, meta ) {
                                          if(data=='Minor')
                                          {
                                          str_active_status='<span class="badge badge-warning">'+data+'</span>'
                                          }
                                         
                                          else
                                          {
                                          str_active_status='<span class="badge badge-danger">'+data+'</span>'   
                                          }
                                     	return str_active_status;
            
            							 },
                                 },
                                 { "data": "inserted_name" },
                                 
                                  { "data": "pic_name",
                                      render: function ( data, type, rows, meta ) {
                                          if(data=='default.jpg')
                                          {
                                             return '<img src="../httpdocs/images/pms_uploads/'+data+'"  height="80px" width="80px"/>';
             
                                          }
                                          else
                                          {
                                              return '<img src="../httpdocs/images/pms_uploads/'+data+'" class="" height="100" width="100" />';
            
                                          }
                                         
            							 },
                                 },
                                
                              
                       
                             ],
                             pageLength: 50,
            				 searching: true,
                             responsive: true,
                             
                             "aoColumnDefs": [
            				//	{ "bSortable": false, "aTargets": [ 1,2] }, 
            					
            				],
                            
            				
                             "initComplete": function( settings, json ) {
                                    
                               
             
                              },
                                "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                                 $("td:eq(0)", nRow).html(iDisplayIndex + 1);
                                 return nRow;
                              },
                              "drawCallback": function () {
                                   
                                }
                            
                     });  
                
                 } 
var row_index;
                $('#list_of_project_entries tbody').on('click', 'a', function(){
                        var $row = $(this).closest('tr');
                        var data = project_list_table.row($row).data();
                        $("#list_of_project_entries tbody tr").removeClass('selected');
                        $(this).closest('tr').addClass('selected');
                         row_index=$(this).closest('tr').index();
                        var pic_name1  = "../httpdocs/images/pms_uploads/"+data.pic_name;
                        
                         if($(this).attr("name")=='view_img')
                         {
                            $('#imagepreview').attr('src', pic_name1); 
                            $('#imagemodal').modal('show');
               
            			 }
            			  if($(this).attr("name")=='edit_entries')
                         {
                           load_project_combo_edit(data.project_id);
                           $('#select_priority_edit').val(data.priority).change();
                            $('#preview_edit').attr('src', pic_name1);
                            $("#hidden_image_show_edit").val(data.pic_name);
                            $("#hidden_image_show_edit_old").val(data.pic_name);
                            $("#txt_category_edit").val(data.category).change();
                            $("#txt_comments_edit").val(data.comments);
                            $("#txt_part_edit").val(data.parts);
                            $("#txt_place_edit").val(data.place);
                            $("#txt_location_edit").val(data.location);
                            $("#txt_description_edit").val(data.description);
                            $("#hidden_project_entries_id_edit").val(data.project_entries_id);
                            
                            $('#editmodal').modal('show');
                            
               
            			 }
            			 if($(this).attr("name")=='delete_entries')
                         {
                             if (confirm("Are you sure to delete the entry?")) {
                                   delete_entry(data.project_entries_id,data.project_id);
                                }
                                return false;
                         }
            		
            			 
            			 
            			 
                        
        });

    function delete_entry(entry_id,pjt_ids)
    {   
        $.post("../controller/project/project_report_controller.php",{action:'delete_entries',v_project_entries_id:entry_id}
                , function(result,status)
                {
                  
                result = $.trim(result);
                if(result=='No')
                {
                    swal("Warning","Sorry you do not have the priviledge to delete the entry. Please contact administrator...", "warning");
                       
                        return false;
                }
                else
                {
                     var v_date=$("#txt_date").val();
                     var v_todate=$("#txt_todate").val();
                     var v_location=$("#select_location option:selected").val();
                     var v_place=$("#select_place option:selected").val();
                     var v_parts=$("#select_parts option:selected").val();
                     var v_category=$("#select_category option:selected").val();
                     var v_priority=$("#select_priority option:selected").val();
                     var v_emp=$("#select_technician option:selected").val();
                    load_data_to_grid_project_details_list(pjt_ids,v_date,v_todate,v_location,v_place,v_parts,v_category,v_priority,v_emp);
                }
               
                
                
        });
    }
      $('#div_project_select_report').on('change', '#select_project_project', function(){
      
          var v_project_id=$("#select_project_project option:selected").val();
          var v_project_name=$("#select_project_project option:selected").text();
          $("#h5_project_title").html(v_project_name);
           var v_date=$("#txt_date").val();
            var v_todate=$("#txt_todate").val();
            var v_location=$("#select_location option:selected").val();
             var v_place=$("#select_place option:selected").val();
             var v_parts=$("#select_parts option:selected").val();
             var v_category=$("#select_category option:selected").val();
             var v_priority=$("#select_priority option:selected").val();
             var v_emp=$("#select_technician option:selected").val();
            if(v_project_id=='select')
                {
                    swal("Warning","Please select the project ....", "warning");
                       
                        return false;
                }
                else
                {
                    load_data_to_grid_project_details_list(v_project_id,v_date,v_todate,v_location,v_place,v_parts,v_category,v_priority,v_emp);
                }
          
           
      });
    $('#txt_date').change(function() { 
         var v_project_id=$("#select_project_project option:selected").val();
          var v_project_name=$("#select_project_project option:selected").text();
          $("#h5_project_title").html(v_project_name);
          var v_date=$("#txt_date").val();
           var v_todate=$("#txt_todate").val();
           var v_location=$("#select_location option:selected").val();
         var v_place=$("#select_place option:selected").val();
         var v_parts=$("#select_parts option:selected").val();
         var v_category=$("#select_category option:selected").val();
         var v_priority=$("#select_priority option:selected").val();
         var v_emp=$("#select_technician option:selected").val();
           if(v_project_id=='select')
                {
                    swal("Warning","Please select the project ....", "warning");
                       
                        return false;
                }
                else
                {
               
          load_data_to_grid_project_details_list(v_project_id,v_date,v_todate,v_location,v_place,v_parts,v_category,v_priority,v_emp);
                }
    });
    $('#txt_todate').change(function() { 
         var v_project_id=$("#select_project_project option:selected").val();
          var v_project_name=$("#select_project_project option:selected").text();
          $("#h5_project_title").html(v_project_name);
          var v_date=$("#txt_date").val();
           var v_todate=$("#txt_todate").val();
           var v_location=$("#select_location option:selected").val();
         var v_place=$("#select_place option:selected").val();
         var v_parts=$("#select_parts option:selected").val();
         var v_category=$("#select_category option:selected").val();
         var v_priority=$("#select_priority option:selected").val();
         var v_emp=$("#select_technician option:selected").val();
          if(v_project_id=='select')
                {
                    swal("Warning","Please select the project ....", "warning");
                       
                        return false;
                }
                else
                {
          load_data_to_grid_project_details_list(v_project_id,v_date,v_todate,v_location,v_place,v_parts,v_category,v_priority,v_emp);
                }
    });
     
    $(".img_remove").click(function(){
        $("#div_preview").hide();
        $('#session_image').val("");
        $("#file_card").remove();
          $("#parent_file_card").prepend('<div id="file_card"><span class="form-text text-muted font-weight-bold" style="color:black;"><font color="black">Pic</font></span><input type="file" class="form-input-styled"  id="session_image" name="session_image" accept="image/*" onchange="readURL(this);"/></div>');
        
      });
      $(".img_remove_edit").click(function(){
        $("#div_preview_edit").hide();
        $('#session_image_edit').val("");
        $('#hidden_image_show_edit').val("");
        $("#file_card_edit").remove();
          $("#parent_file_card_edit").prepend('<div id="file_card_edit"><span class="form-text text-muted font-weight-bold" style="color:black;"><font color="black">Pic</font></span><input type="file" class="form-input-styled"  id="session_image_edit" name="session_image_edit" accept="image/*" onchange="readURLedit(this);"/></div>');
        
      });
      var v_session_image,v_session_image_edit;   
        
        $("#btn_project_add").click(function(){
            var v_project_id=$("#select_project option:selected").val();
            var v_project_name=$("#select_project option:selected").text();
            var v_priority=$("#select_priority option:selected").val();
            var v_category=$("#txt_category").val();
            var v_comments=$("#txt_comments").val();
            var v_parts=$("#txt_part").val();
            var v_place=$("#txt_place").val();
            var v_location=$("#txt_location").val();
            var v_description=$("#txt_description").val();
             var v_add_date=$("#txt_add_date").val();
            var v_date=$("#txt_date").val();
            var v_todate=$("#txt_todate").val();
            if( v_project_id=='0' ||v_add_date=='' || v_project_id=='select')
             {
                 swal("Warning","Please select the project ....", "warning");
                       
                        return false;
             }
             else
             {
                 
                 v_session_image = $("#session_image").val();
                      
                randomNum = Math.ceil(Math.random() * 999999);
                if(v_session_image==="")
                    {
                        v_session_image="default.jpg";
                    }
                else
                {
                    var doc_file_obj = $("#session_image")[0].files[0];
                    var upload = new ns.Upload(doc_file_obj);
                    doc_file1= doc_file_obj.name;
                    upload.doUpload("../httpdocs/user_upload/pms_pic_image_upload_resize.php?random_no="+randomNum);
                    v_session_image=$.trim(randomNum+'_'+doc_file1);
                }  
                
                 $.post("../controller/project/project_report_controller.php",{action:'add_entries',v_project_id:v_project_id,v_project_name:v_project_name,v_priority:v_priority,v_category:v_category,v_comments:v_comments,v_parts:v_parts,v_place:v_place,v_location:v_location,v_description:v_description,v_session_image:v_session_image,v_date:v_add_date}
                                , function(result,status)
                                {
                                  
                                result = $.trim(result);
                               
                                if(result=="")
                                {
                                   
                                    swal("Error", result, "error");
                                   
                                    clear_text();
                                }
                                else 
                                {
                                    var v_location=$("#select_location option:selected").val();
                                     var v_place=$("#select_place option:selected").val();
                                     var v_parts=$("#select_parts option:selected").val();
                                     var v_category=$("#select_category option:selected").val();
                                     var v_priority=$("#select_priority option:selected").val();
                                     var v_emp=$("#select_technician option:selected").val();
                                     load_data_to_grid_project_details_list(v_project_id,v_date,v_todate,v_location,v_place,v_parts,v_category,v_priority,v_emp);
                                     clear_text();
                                     $('#addmodal').modal('hide');
                                }
                                
                                 
                            
                        });
             }
            
        });
         $("#btn_project_edit").click(function(){
           var v_project_id=$("#select_project_edit option:selected").val();
            var v_project_name=$("#select_project_edit option:selected").text();
            var v_priority=$("#select_priority_edit option:selected").val();
            var v_category=$("#txt_category_edit").val();
            var v_comments=$("#txt_comments_edit").val();
            var v_parts=$("#txt_part_edit").val();
            var v_place=$("#txt_place_edit").val();
            var v_location=$("#txt_location_edit").val();
            var v_description=$("#txt_description_edit").val();
            var v_session_image=$("#hidden_image_show_edit").val();
            var v_image_old=$("#hidden_image_show_edit_old").val();
            
            var v_project_entries_id=$("#hidden_project_entries_id_edit").val();
            if(v_session_image==="" || v_session_image=="default.jpg")
            {
                v_session_image="default.jpg";
            }
            if(v_session_image!=v_image_old)
            {
             var doc_file_obj = $("#session_image_edit")[0].files[0];
             var upload = new ns.Upload(doc_file_obj);
             upload.doUpload("../httpdocs/user_upload/pms_pic_image_upload_edit.php?random_no="+v_session_image);
            }
             
            $.post("../controller/project/project_add_entries_contoller.php",{action:'edit_entries',v_project_id:v_project_id,v_project_name:v_project_name,v_priority:v_priority,v_category:v_category,v_comments:v_comments,v_parts:v_parts,v_place:v_place,v_location:v_location,v_description:v_description,v_session_image:v_session_image,v_project_entries_id:v_project_entries_id}
                                , function(result,status)
                                {
                                  
                                result = $.trim(result);
                                project_list_table
                                  .rows({ selected: true })
                                  .every(function (row_index, tableLoop, rowLoop) {
                                    project_list_table.cell(row_index,3).data(v_description);
                                    project_list_table.cell(row_index, 4).data(v_location);
                                  })
                                  .draw();
                        //         var $row = $(this).closest('tr');
                        // var data = project_list_table.row($row).data();
                        // alert(row_index);
                        // data[0].parts = 'sam';
                        // data[0].location = 'gregory';
                        
                       
                               var v_date=$("#txt_date").val();
                               var v_todate=$("#txt_todate").val();
                               var v_location=$("#select_location option:selected").val();
                                 var v_place=$("#select_place option:selected").val();
                                 var v_parts=$("#select_parts option:selected").val();
                                 var v_category=$("#select_category option:selected").val();
                                 var v_priority=$("#select_priority option:selected").val();
                                 var v_emp=$("#select_technician option:selected").val();
                                 
                               load_data_to_grid_project_details_list(v_project_id,v_date,v_todate,v_location,v_place,v_parts,v_category,v_priority,v_emp);
                                    $('#editmodal').modal('hide');
                                
                                 
                            
                        });
            
        });
         
function clear_text()
{
  $("#txt_category").val('NA').change();
   $("#select_priority").val('Minor').change();
  $("#txt_comments").val('');
  $("#txt_part").val('');
  $("#txt_place").val('');
  $("#txt_location").val('');
  $("#txt_description").val('');
   $("#div_preview").hide();
  $('#session_image').val("");
    $("#file_card").remove();
      $("#parent_file_card").prepend('<div id="file_card"><span class="form-text text-muted font-weight-bold" style="color:black;"><font color="black">Pic</font></span><input type="file" class="form-input-styled"  id="session_image" name="session_image" accept="image/*" onchange="readURL(this);"/></div>');
}
$("#btn_project_new").click(function(){
        location.reload();
});
$("#btn_project_add_entries").click(function(){
          clear_text();
          load_combo();
         $('#addmodal').modal('show');
});

// $(".button_img_download").on("click", function () {
//     var base_url = window.location.origin;
//     alert(base_url);
//     var imagePath = base_url+"httpdocs/images/pms_uploads";
//     var fileName = "647856_cq5dam.L.1600.0.jpeg";
//     saveAs(imagePath, fileName); 
//     });
});