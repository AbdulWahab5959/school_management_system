
var calendar;
// Function to initialize the calendar
function initializeCalendar(slots) {

    var calendarEl = document.getElementById('calendar');
    calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth', // Initial view can be month or any other as per your preference
        events: slots,
        // events: [
        //     // Your available time slot events data goes here
        //     {
        //         title: 'Ratti Slot',
        //         start: '2023-10-02T14:00:00',
        //         end: '2023-10-02T16:00:00',
        //         backgroundColor: '#f10707',
        //         textColor: '#20232a'
        //         // Add more properties or customize event rendering as needed
        //     },
        //     // {
        //     //     title: 'dujhi Slot',
        //     //     start: '2023-10-02T09:00:00',
        //     //     end: '2023-10-02T10:00:00',
        //     //     // Add more properties or customize event rendering as needed
        //     // }
        // ],
        eventTimeFormat: { // like '14:30:00'
            hour: '2-digit',
            minute: '2-digit',
            // second: '2-digit',
            meridiem: true,
            hour12:false
        },
        dateClick: function(info) {
            // Handle date click event
            var clickedDate = info.date;
            // Extract year, month, and day components
            var year = clickedDate.getFullYear().toString(); // Get the last 2 digits of the year
            var month = (clickedDate.getMonth() + 1).toString().padStart(2, '0'); // Add 1 to month because it's zero-based
            var day = clickedDate.getDate().toString().padStart(2, '0');

            var formattedDate = year + '-' + month + '-' + day; // E.g., "23-10-02"
            console.log(formattedDate);
            $("#show_selected_date").html(formattedDate);
            $("#selected_date").val(formattedDate);
            // Fetch available time slots for the clicked date
            // Populate the day view with available time slots for that date
            // Switch to day view
            $('#switchToMonthButton').css('display', 'inline-block');
            $('#addNewTimeSlotbtn').css('display', 'inline-block');
            calendar.changeView('timeGridDay', clickedDate);
        },
        eventClick: function(info) {
            // Handle event (time slot) click event
            var selected_id    = info.event.id;
            var selected_title = info.event.title;
            var selected_start = info.event.start;
            var selected_end   = info.event.end;
            var selected_backgroundColor = info.event.backgroundColor;
            var selected_textColor = info.event.textColor;            

            // Extract year, month, and day components
            var year  = selected_start.getFullYear().toString(); // Get the last 2 digits of the year
            var month = (selected_start.getMonth() + 1).toString().padStart(2, '0'); // Add 1 to month because it's zero-based
            var day   = selected_start.getDate().toString().padStart(2, '0');
            var formattedDate = year + '-' + month + '-' + day; // E.g., "23-10-02"
            
            var date = new Date(selected_start);
            var hours = date.getHours().toString().padStart(2, '0');
            var minutes = date.getMinutes().toString().padStart(2, '0');
            var selected_start = hours + ':' + minutes; // Format as "hh:mm"
            var date = new Date(selected_end);
            var hours = date.getHours().toString().padStart(2, '0');
            var minutes = date.getMinutes().toString().padStart(2, '0');
            var selected_end = hours + ':' + minutes; // Format as "hh:mm"
            
            // Show Bootstrap modal here


            $('#show_selected_timeslot').text(formattedDate + " | " + selected_start);


            $("#edit_TimeSlotID").val(selected_id);
            $("#delete-slot-btn").data('id',selected_id);
            $("#edit_slot_title").val(selected_title);
            $("#edit_slot_start").val(selected_start);
            $("#edit_slot_end").val(selected_end);
            $("#edit_background_clr").val(selected_backgroundColor);
            $("#edit_text_clr").val(selected_textColor);
            $("#edit_date").val(formattedDate);

            $('#editTimeSlotModal').modal('show'); // Assuming you have a Bootstrap modal with the id "editTimeSlotModal"
        },
        // Add more calendar configuration options here
    });
    calendar.render();
}

$(document).ready(function() {
    $(".dateTimeFormat").datepicker({
        dateFormat: 'yy-mm-dd'
    });

    // Add a button to switch back to month view
    var switchToMonthButton = document.getElementById('switchToMonthButton');
    switchToMonthButton.addEventListener('click', function() {
        calendar.changeView('dayGridMonth');
        $('#switchToMonthButton').css('display', 'none');
        $('#addNewTimeSlotbtn').css('display', 'none');
    });

    $(document).on('click', '#addNewTimeSlotbtn', function() {
        $('#AddTimeSlotModal').modal('show');
    });

    loadCalendar();

    // Fetch unavailable dates from the server and mark them as unavailable
    function loadCalendar() {
        $.ajax({
            url: 'ajax_api.php',
            method: 'POST',
            data: {
                action: 'loadCalendar',
            },
            success: function(response) {
                // console.log(response);
                console.log("Calendar Refreshed");
                // try {
                //     var eventData = JSON.parse(response);
                //     initializeCalendar(eventData);
                // } catch (error) {
                //     console.error('Error parsing JSON:', error);
                // }
                initializeCalendar(response);
            },
            error: function(error) {
                // Handle errors (e.g., show an error message)
                console.error('Error:', error);
            },
        });
    }
    $(document).on("submit", "#AddNewSlotForm", function(event) {
        event.preventDefault();

        var formData = $(this).serialize();
        $(this)[0].reset();
        // console.log(formData);

        $.ajax({
            url: "ajax_api.php",
            type: "POST",
            data: formData,
            success: function(response) {
                $("#AddTimeSlotModal").modal('hide');
                loadCalendar();
                console.log(response);
            },
            error: function(error) {
                console.error("Error sending form data");
                console.error(error);
            }
        });
    });
    $(document).on("submit", "#EditTimeSlotForm", function(event) {
        event.preventDefault();

        var formData = $(this).serialize();
        $(this)[0].reset();
        // console.log(formData);

        $.ajax({
            url: "ajax_api.php",
            type: "POST",
            data: formData,
            success: function(response) {
                $("#editTimeSlotModal").modal('hide');
                loadCalendar();
                console.log(response);
            },
            error: function(error) {
                console.error("Error sending form data");
                console.error(error);
            }
        });
    });
    $(document).on("click", "#delete-slot-btn", function(event) {
        var id = $("#delete-slot-btn").data('id');
        if(confirm("Are you sure you want to delete this time slot ?"))
        {
            console.log('Deleting time slot with id:'+id);
            $.ajax({
                url: "ajax_api.php",
                type: "POST",
                data: {
                    action:"DeleteTimeSlot",
                    slot_id:id
                },
                success: function(response) {
                    $("#editTimeSlotModal").modal('hide');
                    loadCalendar();
                    console.log(response);
                },
                error: function(error) {
                    console.error("Error sending form data");
                    console.error(error);
                }
            });
        }
        else{
            console.log('Deleting operation terminated');
        }

    });
});