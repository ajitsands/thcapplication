(function($) {
    // Inject spinning animation CSS for upload loading indicator
    if (typeof $ !== 'undefined') {
        $(function() {
            if (!$('#fileupload-spinner-style').length) {
                $('head').append(
                    '<style id="fileupload-spinner-style">' +
                    '@keyframes fileupload_spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }' +
                    '.fileupload-spinner { display: inline-block; animation: fileupload_spin 0.8s linear infinite; vertical-align: middle; margin-right: 4px; }' +
                    '</style>'
                );
            }
        });
    }

    var namespace = {
        Upload: function(file, fileElement) {
            this.file = file;
            this.fileElement = fileElement ? $(fileElement) : null;
        }
    };
    
    window.ns = namespace;
    ns.Upload.prototype.getType = function() {
        return this.file ? this.file.type : '';
    };
    ns.Upload.prototype.getSize = function() {
        return this.file ? this.file.size : 0;
    };
    ns.Upload.prototype.getName = function() {
        return this.file ? this.file.name : '';
    };

    ns.Upload.prototype.doUpload = function(upload_path, filename) {
        var that = this;
        var formData = new FormData();

        formData.append("file", this.file, this.getName());
        formData.append("upload_file", true);

        // Find associated file input
        var $input = this.fileElement;
        if (!$input || !$input.length) {
            $input = $('input[type="file"]').filter(function() {
                return this.files && this.files.length > 0 && this.files[0] === that.file;
            });
        }

        // Find Uniform action button or standard button
        var $actionBtn = null;
        if ($input && $input.length) {
            $actionBtn = $input.closest('.uniform-uploader').find('.action');
            if (!$actionBtn.length) {
                $actionBtn = $input.siblings('.action');
            }
        }

        var origHtml = 'Choose File';
        if ($actionBtn && $actionBtn.length) {
            origHtml = $actionBtn.data('orig-html');
            if (!origHtml) {
                origHtml = $actionBtn.html() || 'Choose File';
                $actionBtn.data('orig-html', origHtml);
            }
            // Set loading icon on the Choose File button
            $actionBtn.html('<i class="icon-spinner2 fileupload-spinner"></i> Uploading...');
            $actionBtn.css({ 'pointer-events': 'none', 'opacity': '0.85' });
        }

        // Display immediate image preview if this is an image file
        if (this.file && this.file.type && this.file.type.indexOf('image') !== -1 && window.URL && window.URL.createObjectURL) {
            try {
                var blobUrl = URL.createObjectURL(this.file);
                var previewHtml = "<img style='width:38px;height:38px;object-fit:cover;border-radius:4px;border:1px solid #00bcd4;box-shadow:0 1px 3px rgba(0,0,0,0.12);' src='" + blobUrl + "'>";
                
                if ($("#building_img_preview").length) {
                    $("#building_img_preview").show().html(previewHtml);
                }
                if ($("#img_assets_preview").length) {
                    $("#img_assets_preview").show().html(previewHtml);
                }
                if ($("#img_preview").length) {
                    $("#img_preview").show().html(previewHtml);
                }
            } catch(e) {}
        }

        return $.ajax({
            type: "POST",
            url: upload_path,
            xhr: function () {
                var myXhr = $.ajaxSettings.xhr();
                if (myXhr.upload) {
                    myXhr.upload.addEventListener('progress', that.progressHandling, false);
                }
                return myXhr;
            },
            success: function (data) {
                if ($actionBtn && $actionBtn.length) {
                    $actionBtn.html('<i class="icon-checkmark3 text-success mr-1"></i> Uploaded');
                    setTimeout(function() {
                        var resetHtml = $actionBtn.data('orig-html') || 'Choose File';
                        $actionBtn.html(resetHtml).css({ 'pointer-events': '', 'opacity': '' });
                    }, 1500);
                }

                var cleanFile = filename ? $.trim(filename) : '';
                if (cleanFile) {
                    // Update preview with server url if element empty
                    if ($("#img_preview").length && $("#img_preview").find("img").length === 0) {
                        $("#img_preview").show().html("<img style='width:38px;height:38px;object-fit:cover;border-radius:4px;border:1px solid #c2daeb;' src='../httpdocs/images/employee_image/" + cleanFile + "' onerror=\"this.onerror=null;this.src='../httpdocs/images/employee_image/default.jpg';\">");
                    }
                    if ($("#building_img_preview").length && $("#building_img_preview").find("img").length === 0) {
                        $("#building_img_preview").show().html("<img style='width:38px;height:38px;object-fit:cover;border-radius:4px;border:1px solid #c2daeb;' src='../httpdocs/images/building_image/" + cleanFile + "' onerror=\"this.onerror=null;this.src='../httpdocs/images/building_image/default.jpg';\">");
                    }
                    if ($("#img_assets_preview").length && $("#img_assets_preview").find("img").length === 0) {
                        $("#img_assets_preview").show().html("<img style='width:38px;height:38px;object-fit:cover;border-radius:4px;border:1px solid #c2daeb;' src='../httpdocs/images/amc_attachements/" + cleanFile + "' onerror=\"this.onerror=null;this.src='../httpdocs/images/building_image/default.jpg';\">");
                    }
                }
                return 'success';
            },
            error: function (error) {
                if ($actionBtn && $actionBtn.length) {
                    $actionBtn.html('<i class="icon-cross2 text-danger mr-1"></i> Failed');
                    setTimeout(function() {
                        var resetHtml = $actionBtn.data('orig-html') || 'Choose File';
                        $actionBtn.html(resetHtml).css({ 'pointer-events': '', 'opacity': '' });
                    }, 2000);
                }
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
        if (event.lengthComputable && total > 0) {
            percent = Math.ceil(position / total * 100);
        }
        $(progress_bar_id + " .progress-bar").css("width", percent + "%");
        $(progress_bar_id + " .status").text(percent + "%");
    };
})(this.jQuery);
