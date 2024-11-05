var calendar;

function initializeCalendar(attendance) {
  var calendarEl = document.getElementById("calendar");
  calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: "dayGridMonth",
    editable: true,
    selectable: true,
    events: attendance,

    dateClick: function (info) {
      var clickedDate = info.date;
      var day = clickedDate.getUTCDay();

      if (day === 6) {
        Swal.fire({
          title: "Info!",
          text: "Sunday not allowed",
          icon: "info",
          confirmButtonText: "OK",
        });
      } else {
        var year = clickedDate.getFullYear().toString();
        var month = (clickedDate.getMonth() + 1).toString().padStart(2, "0");
        var day = clickedDate.getDate().toString().padStart(2, "0");
        var formattedDate = `${year}-${month}-${day}`;

        let today = new Date();
        let todayFormatted = `${today.getFullYear()}-${(today.getMonth() + 1).toString().padStart(2, "0")}-${today.getDate().toString().padStart(2, "0")}`;

        if (formattedDate === todayFormatted) {
          $("#Attendance").modal("show");
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

    dayCellDidMount: function (info) {
      var day = info.date.getUTCDay();
      if (day === 6) { 
        info.el.style.text = "Sunday";
        info.el.style.backgroundColor = "#ada8a8";
        info.el.style.color = "white";
      }
    },
  });

  calendar.render();
}

function loadAttendanceRecord() {
  var class_id = document.getElementById("class_id").value;
  $.ajax({
    url: "ajax_api.php",
    method: "GET",
    data: { class_id: class_id },
    success: function (response) {
      var events = JSON.parse(response);
      events.forEach((event) => {
        calendar.addEvent({
          title: "Marked",
          start: event.start_time,
          display: "background",
          backgroundColor: "black",
          textColor: "white",
        });
      });
    },
    error: function (error) {
      console.error("Error:", error);
    },
  });
}

function loadCalendar() {
  $.ajax({
    url: "ajax_api.php",
    method: "POST",
    data: { action: "loadCalendar" },
    success: function (response) {
      initializeCalendar(response);
      loadAttendanceRecord();
    },
    error: function (error) {
      console.error("Error:", error);
    },
  });
}

$(document).ready(function () {
  $(document).on("click", "#addNewTimeSlotbtn", function () {
    $("#Attendance").modal("show");
  });

  loadCalendar();

  $(document).on("submit", "#Attendance", function (event) {
    event.preventDefault();
    var formData = $(this).serialize();

    $.ajax({
      url: "ajax_api.php",
      type: "POST",
      data: formData,
      success: function (response) {
        $("#Attendance").modal("hide");
        loadCalendar();
        var jsonResponse = JSON.parse(response);
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
        console.error("Error:", error);
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
