$(document).ready(function() {
    
    var currentSettings = null;

    // Load initial settings
    loadSettings();

    function loadSettings() {
        $.ajax({
            url: '../controller/janitor/settings_controller.php',
            type: 'POST',
            data: { action: 'get_settings' },
            dataType: 'json',
            success: function(res) {
                if (res && res.status === 'success' && res.data) {
                    currentSettings = res.data;
                    renderViewMode(res.data);
                } else {
                    showAlert('danger', res.message || 'Failed to load settings.');
                }
            },
            error: function(err) {
                showAlert('danger', 'Network or server error while fetching Janitor Settings.');
            }
        });
    }

    function renderViewMode(data) {
        var radius = parseFloat(data.min_radius_meters) || 200;
        var lateTime = parseInt(data.late_time_minutes) || 15;
        var bypass = (data.allow_gps_bypass || 'NO').toUpperCase();
        var updatedAt = data.updated_at ? formatDate(data.updated_at) : 'N/A';
        var updatedBy = data.updated_by || 'System';

        $('#lbl_view_radius').html(radius + ' <span class="font-size-sm font-weight-normal text-muted">meters</span>');
        $('#lbl_view_late_time').html(lateTime + ' <span class="font-size-sm font-weight-normal text-muted">minutes</span>');
        
        if (bypass === 'YES') {
            $('#lbl_view_bypass').html('<span class="badge badge-success px-2 py-1">Allowed (Testing)</span>');
        } else {
            $('#lbl_view_bypass').html('<span class="badge badge-secondary px-2 py-1">Strict (No Bypass)</span>');
        }

        $('#lbl_view_updated').text(updatedAt);
        $('#lbl_view_updated_by').text(updatedBy);

        // Prepopulate edit inputs
        $('#input_min_radius_meters').val(radius);
        $('#input_late_time_minutes').val(lateTime);
        $('#input_allow_gps_bypass').val(bypass);
    }

    function formatDate(dateStr) {
        if (!dateStr) return '';
        var dt = new Date(dateStr);
        if (isNaN(dt.getTime())) return dateStr;
        return dt.toLocaleDateString('en-GB', { 
            day: '2-digit', 
            month: 'short', 
            year: 'numeric' 
        }) + ' ' + dt.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: true });
    }

    // Toggle to Edit Mode
    $('#btn_toggle_edit').on('click', function() {
        $('#view_mode_container').slideUp(200);
        $('#edit_mode_container').slideDown(200);
        $('#btn_toggle_edit').hide();
    });

    // Cancel Edit Mode
    $('#btn_cancel_edit').on('click', function() {
        if (currentSettings) {
            renderViewMode(currentSettings);
        }
        $('#edit_mode_container').slideUp(200);
        $('#view_mode_container').slideDown(200);
        $('#btn_toggle_edit').show();
    });

    // Submit Settings Form
    $('#form_janitor_settings').on('submit', function(e) {
        e.preventDefault();

        var radius = parseFloat($('#input_min_radius_meters').val());
        var lateMinutes = parseInt($('#input_late_time_minutes').val());
        var bypass = $('#input_allow_gps_bypass').val();

        if (isNaN(radius) || radius <= 0) {
            swal("Invalid Input", "Minimum radius must be a positive number greater than 0.", "error");
            return;
        }

        if (isNaN(lateMinutes) || lateMinutes < 0) {
            swal("Invalid Input", "Late time minutes cannot be negative.", "error");
            return;
        }

        var $saveBtn = $('#btn_save_settings');
        var originalBtnHtml = $saveBtn.html();
        $saveBtn.prop('disabled', true).html('<i class="icon-spinner2 spinner mr-1"></i> Saving...');

        $.ajax({
            url: '../controller/janitor/settings_controller.php',
            type: 'POST',
            data: {
                action: 'save_settings',
                min_radius_meters: radius,
                late_time_minutes: lateMinutes,
                allow_gps_bypass: bypass
            },
            dataType: 'json',
            success: function(res) {
                $saveBtn.prop('disabled', false).html(originalBtnHtml);
                if (res && res.status === 'success') {
                    swal("Success!", res.message || "Janitor settings updated successfully.", "success");
                    if (res.data) {
                        currentSettings = res.data;
                        renderViewMode(res.data);
                    } else {
                        loadSettings();
                    }
                    $('#edit_mode_container').slideUp(200);
                    $('#view_mode_container').slideDown(200);
                    $('#btn_toggle_edit').show();
                } else {
                    swal("Error", res.message || "Could not save settings.", "error");
                }
            },
            error: function(xhr, status, error) {
                $saveBtn.prop('disabled', false).html(originalBtnHtml);
                swal("Request Failed", "Failed to communicate with server. Please try again.", "error");
            }
        });
    });

    function showAlert(type, message) {
        var html = '<div class="alert alert-' + type + ' alert-dismissible">' +
                   '<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>' +
                   message + '</div>';
        $('#alert_placeholder').html(html);
    }
});
