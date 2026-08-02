$(document).ready(function(){
  var v_item_img;
           
                $('#session_image').change(function (e) {
         
                 
                v_item_img = $("#session_image").val();
                var  randomNum = Math.ceil(Math.random() * 999999);
                    if(v_item_img=="")
                {
                    v_item_img="default.jpg";
                }
                else
                {
                    var doc_file_obj = $("#session_image")[0].files[0];
                    var upload = new ns.Upload(doc_file_obj);
                    var doc_file1= doc_file_obj.name;
                    v_item_img=$.trim(randomNum+'_'+doc_file1);
					//alert(v_item_img);
                    var success = upload.doUpload("../../httpdocs/user_upload/x_image_upload.php?random_no="+randomNum,v_item_img);

                }  
        });   
               
           
        
                  

});