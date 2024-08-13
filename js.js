// Populate events dropdown
$(document).ready(function() {
    $.ajax({
        url: 'get_events.php',
        method: 'GET',
        dataType: 'json',
        success: function(eventNames) {
            var dropdown = $('#event');
            dropdown.empty();
            dropdown.append('<option value="" disabled selected>Please select an event</option>');
            $.each(eventNames, function(key, event) {
                dropdown.append('<option value="' + event.id + '">' + event.event_name + '</option>');
            });
        }
    });
});

// Registration form submission
function register(event) {
    event.preventDefault();
    $.ajax({
        url: 'register.php',
        method: 'POST',
        data: $('#registrationFormElement').serialize(),
        success: function(response) {
            alert(response);
            resetForms();
        }
    });
}

// Search attendance details
function searchAttendance() {
    $.ajax({
        url: 'search_attendance.php',
        method: 'POST',
        data: { uniqueCode: $('#uniqueCode').val() },
        dataType: 'json',
        success: function(details) {
            if (details) {
                $('#attName').val(details.name);
                $('#attEmail').val(details.email);
                $('#attEvent').val(details.event_name);
                $('#attendanceDetails').removeClass('hidden');
                alert('Meeting details found! Please submit Attendance');
            } else {
                alert('No attendance record found for the provided unique code.');
                resetForms();
            }
        }
    });
}

// Submit attendance form
function markAttendance(event) {
    event.preventDefault();
    $.ajax({
        url: 'save_attendance.php',
        method: 'POST',
        data: $('#attendanceFormElement').serialize(),
        success: function(response) {
            alert(response);
            resetForms();
        }
    });
}
