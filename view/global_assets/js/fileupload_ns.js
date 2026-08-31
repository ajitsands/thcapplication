(function($) {
    
    var namespace,retval;
    
    namespace = {
        Upload : function(file) {
             this.file = file;
        }
		
    };
	
    window.ns = namespace;
	ns.Upload.prototype.getType = function(file) {
		return this.file.type;
	};
	ns.Upload.prototype.getSize = function(file) {
		return this.file.size;
	};
	ns.Upload.prototype.getName = function(file) {
		return this.file.name;
	};
	ns.Upload.prototype.doUpload = function (upload_path,filename) {
		var that = this;
		var formData = new FormData();

		// add assoc key values, this will be posts values
		formData.append("file", this.file, this.getName());
		formData.append("upload_file", true);

		$.ajax({
			type: "POST",
			url: upload_path,
			xhr: function () {
				var myXhr = $.ajaxSettings.xhr();
				if (myXhr.upload) {
					myXhr.upload.addEventListener('progress', that.progressHandling, false);
				}
				
				//alert(myXhr.result);
				return myXhr;
			},
			success: function (data) {
				// your callback here
				if ($("#img_preview").find("img").length === 0) {
					$("#img_preview").show().html("<img style='width:36px;height:36px;object-fit:cover;border-radius:4px;border:1px solid #c2daeb;' src='../httpdocs/images/employee_image/" + $.trim(filename) + "'>");
				}
				$("#building_img_preview").show().html("<img style='width:36px;height:36px;object-fit:cover;border-radius:4px;border:1px solid #c2daeb;' src='../httpdocs/images/building_image/" + $.trim(filename) + "'>");
				
				return 'success';
			},
			error: function (error) {
				// handle error
				//alert('Error : '+error);
				retval='error';
				return 'Error'; 
			},
			async: true,
			data: formData,
			cache: false,
			contentType: false,
			processData: false,
			timeout: 60000
		});
        
	};

	ns.Upload.prototype.progressHandling = function (event) {
		var percent = 0;
		var position = event.loaded || event.position;
		var total = event.total;
		var progress_bar_id = "#progress-wrp";
		if (event.lengthComputable) {
			percent = Math.ceil(position / total * 100);
		}
		// update progressbars classes so it fits your code
		$(progress_bar_id + " .progress-bar").css("width", +percent + "%");
		$(progress_bar_id + " .status").text(percent + "%");
	};
    
})(this.jQuery);



