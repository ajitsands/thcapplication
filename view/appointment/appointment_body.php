<style>
    .modern-date {
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 16px;
        width: 100%;
        box-sizing: border-box;
        background-color: #f8f9fa;
        color: #495057;
    }
    .modern-date:focus {
        border-color: #80bdff;
        outline: none;
        box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
    }
    .form-control, .modern-date, textarea {
        margin-bottom: 15px;
    }
    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        padding: 10px 20px;
        border-radius: 4px;
    }
    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #004085;
    }
    .card {
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #e9ecef;
    }
    /* Select2 custom styles */
    .select2-container--default .select2-selection--single {
        border: 1px solid #ccc;
        border-radius: 4px;
        height: 45px !important;
        /*padding: 6px 12px;*/
        background-color: #f8f9fa;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #495057;
        line-height: 40px;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 50px;
    }
    .select2-container--default .select2-selection--single:focus {
        border-color: #80bdff;
        box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
    }
    /* Flatpickr custom styles */
    .flatpickr-calendar {
        font-family: Arial, sans-serif;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }
    .flatpickr-day.selected, .flatpickr-day.selected:hover {
        background: #007bff;
        border-color: #007bff;
    }
    .flatpickr-day.today {
        border-color: #80bdff;
    }
    /* Ensure same height for columns */
    .equal-height-row {
        display: flex;
        flex-wrap: wrap;
    }
    .equal-height-row > div {
        display: flex;
        flex-direction: column;
    }
    .equal-height-row .form-group {
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    .equal-height-row .form-group select,
    .equal-height-row .form-group input {
        flex: 1;
    }
    /* Calendar icon wrapper */
    .date-picker-wrapper {
        position: relative;
    }
    .date-picker-wrapper .calendar-icon {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        color: #495057;
        pointer-events: none;
    }
</style>

<!-- Add Select2 and Flatpickr CDNs -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.css">
<!-- Add Font Awesome for calendar icon -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.2/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.js"></script>

<div class="card">
    <div class="card-header">
        <h5 class="card-title">Schedule Appointment</h5>
    </div>
    <div class="card-body">
        <div class="row equal-height-row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="select_employee">Employee <span style="color:red;">*</span></label>
                    <select class="form-control" id="select_employee">
                        <option value="">Select Employee</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="appointment_date">Appointment Date <span style="color:red;">*</span></label>
                    <div class="date-picker-wrapper">
                        <input type="text" class="modern-date" id="appointment_date">
                        <i class="fas fa-calendar-alt calendar-icon"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="description">Description <span style="color:red;">*</span></label>
                    <textarea class="form-control" id="description" rows="3" placeholder="Enter description"></textarea>
                </div>
                <button type="button" id="btn_schedule_appointment" class="btn btn-primary">Schedule Appointment</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Initialize Select2 for searchable dropdown
    $('#select_employee').select2({
        placeholder: "Select Employee",
        allowClear: true,
        width: '100%'
    });

    // Initialize Flatpickr for modern datepicker
    flatpickr("#appointment_date", {
        dateFormat: "Y-m-d",
        enableTime: false,
        theme: "light",
        allowInput: true,
        // Removed minDate to allow previous dates
    });
});
</script>