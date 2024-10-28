var calendar;

function initializeCalendar(slots) {
  var calendarEl = document.getElementById("calendar");
  events: slots,
    (calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: "dayGridMonth",

      dateClick: function (info) {
        var clickedDate = info.date;
        var day = new Date(clickedDate).getUTCDay();
        if([6].includes(day)){
            Swal.fire({
                title: "Info!",
                text: "Sunday not allowed",
                icon: "info",
                confirmButtonText: "OK",
              });
        }
      else{
          
          var year = clickedDate.getFullYear().toString();
          var month = (clickedDate.getMonth() + 1).toString().padStart(2, "0");
          var day = clickedDate.getDate().toString().padStart(2, "0");
        
          var formattedDate = year + "-" + month + "-" + day;
        
          let today = new Date();
          let todayFormatted = today.getFullYear().toString() + "-" +
                               (today.getMonth() + 1).toString().padStart(2, "0") + "-" +
                               today.getDate().toString().padStart(2, "0");
        
          if (formattedDate === todayFormatted) {
            $("#show_selected_date").html(formattedDate);
            $("#selected_date").val(formattedDate);
        
            $("#switchToMonthButton").css("display", "inline-block");
            $("#addNewTimeSlotbtn").css("display", "inline-block");
        
            calendar.changeView("timeGridDay", clickedDate);
          } else {
              Swal.fire({
                title: "Info!",
                text: "Please select today’s date",
                icon: "info",
                confirmButtonText: "OK",
              });
          }
        }
      },
      

      eventClick: function (info) {
        var selected_id = info.event.id;
        var selected_title = info.event.title;
        var selected_start = info.event.start;
        var selected_end = info.event.end;
        var selected_backgroundColor = info.event.backgroundColor;
        var selected_textColor = info.event.textColor;

        var year = selected_start.getFullYear().toString();
        var month = (selected_start.getMonth() + 1).toString().padStart(2, "0");
        var day = selected_start.getDate().toString().padStart(2, "0");
        var formattedDate = year + "-" + month + "-" + day;

        var date = new Date(selected_start);
        var hours = date.getHours().toString().padStart(2, "0");
        var minutes = date.getMinutes().toString().padStart(2, "0");
        selected_start = hours + ":" + minutes;

        date = new Date(selected_end);
        hours = date.getHours().toString().padStart(2, "0");
        minutes = date.getMinutes().toString().padStart(2, "0");
        selected_end = hours + ":" + minutes;

        $("#show_selected_timeslot").text(
          formattedDate + " | " + selected_start
        );
        $("#edit_TimeSlotID").val(selected_id);
        $("#delete-slot-btn").data("id", selected_id);
        $("#edit_slot_title").val(selected_title);
        $("#edit_slot_start").val(selected_start);
        $("#edit_slot_end").val(selected_end);
        $("#edit_background_clr").val(selected_backgroundColor);
        $("#edit_text_clr").val(selected_textColor);
        $("#edit_date").val(formattedDate);

      },
    }));

  calendar.render();
}

$(document).ready(function () {
        let today = new Date();
        let options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        let currentDate = today.toLocaleDateString('en-US', options);


  var switchToMonthButton = document.getElementById("switchToMonthButton");
  switchToMonthButton.addEventListener("click", function () {
    calendar.changeView("dayGridMonth");
    $("#switchToMonthButton").css("display", "none");
    $("#addNewTimeSlotbtn").css("display", "none");
  });

  $(document).on("click", "#addNewTimeSlotbtn", function () {
    $("#AddTimeSlotModal").modal("show");
  });

  loadCalendar();

  function loadCalendar() {
    $.ajax({
      url: "ajax_api.php", 
      method: "POST",
      data: {
        action: "loadCalendar",
      },
      success: function (response) {

        // Initialize calendar with event data
        initializeCalendar(response);
      },
      error: function (error) {
        // Handle errors from the AJAX request
        console.error("Error:", error);
      },
    });
  }

  $(document).on("submit", "#Attendance", function (event) {
    event.preventDefault(); 

    var formData = $(this).serialize();

    $.ajax({
      url: "ajax_api.php",
      type: "POST",
      data: formData,
      success: function (response) {
        $("#AddTimeSlotModal").modal("hide");
        loadCalendar();
        var jsonResponse = JSON.parse(response);
        // Show SweetAlert based on the response status
        if (jsonResponse.status === "success") {
          Swal.fire({
            title: "Success!",
            text: jsonResponse.message,
            icon: "success",
            confirmButtonText: "OK",
          });
        } else if (jsonResponse.status === "error") {
          Swal.fire({
            title: "Error!",
            text: jsonResponse.message,
            icon: "error",
            confirmButtonText: "OK",
          });
        }
      },
      error: function (error) {
        var jsonResponse = JSON.parse(response);

        console.error("Error sending form data");
        console.error(error);

        Swal.fire({
          title: "Error!",
          text: "Form Data Sending Error",
          icon: "error",
          confirmButtonText: "OK",
        });
      },
    });
  });
});
