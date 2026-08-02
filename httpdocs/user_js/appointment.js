$(document).ready(function() {
    const baseUrl = window.location.origin;

    // Fetch employee data for dropdown
    $.ajax({
        url: "../controller/appointment/appointment_controller.php",
        type: 'POST',
        data: { action: 'fetch_employees' },
        dataType: 'json',
        success: function(response) {
            if (response.success && response.data) {
                var $select = $('#select_employee');
                $select.empty();
                $select.append('<option value="">Select Employee</option>');
                $.each(response.data, function(index, employee) {
                    $select.append('<option value="' + employee.employee_id + '">' + employee.employee_name + '</option>');
                });
            } else {
                swal("Error", "Failed to load employees", "error");
            }
        },
        error: function(xhr, status, error) {
            swal("Error", "Failed to load employees: " + error, "error");
        }
    });

    // Handle schedule appointment button click
    $('#btn_schedule_appointment').click(function() {
        var employee_id = $('#select_employee').val();
        var employee_name = $('#select_employee option:selected').text();
        var appointment_date = $('#appointment_date').val();
        var description = $('#description').val();

        if (!employee_id || !appointment_date || !description) {
            swal("Warning", "Please fill all required fields", "warning");
            return false;
        }

        $.ajax({
            url: "../controller/appointment/appointment_controller.php",
            type: 'POST',
            data: {
                action: 'schedule_appointment',
                employee_id: employee_id,
                employee_name: employee_name,
                date: appointment_date,
                description: description
            },
            success: function(result) {
                result = $.trim(result);
                if (result === "Success") {
                    swal("Success", "Appointment scheduled successfully", "success");
                    // Clear form
                    $('#select_employee').val('');
                    $('#appointment_date').val('');
                    $('#description').val('');
                } else {
                    swal("Error", result || "Failed to schedule appointment", "error");
                }
            },
            error: function(xhr, status, error) {
                swal("Error", "Failed to schedule appointment: " + error, "error");
            }
        });
    });
});