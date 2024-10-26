<?php
require_once('../includes/db.php');
require_once('includes/login_check.php');

$user_id =$_SESSION['teacher_id'] ;

if (isset($_POST['submit_attendance'])) {
  $teacher_id = $_POST['teacher_id'];
  $date = date('Y-m-d');
  $attendance_records = $_POST['attendance'];
  $created_at = date('Y-m-d H:i:s');
  $updated_at = date('Y-m-d H:i:s');
  
  if (!empty($attendance_records)) {
    $s = "SELECT student.id 
          FROM student 
          INNER JOIN class ON student.class_id = class.id 
          WHERE class.teacher_id = :teacher_id";
    $sth = $pdo->prepare($s);
    $sth->execute([':teacher_id' => $teacher_id]);
    $allStudents = $sth->fetchAll(PDO::FETCH_ASSOC);

    $AttendanceMarked = count($allStudents) === count($attendance_records);

    if (!$AttendanceMarked) {
      $error[] = "Error: Please mark attendance for all students.";
    } else {
      $sql = "SELECT * FROM attendance WHERE teacher_id = ? AND date = ?";
      $stmt = $pdo->prepare($sql);
      $stmt->execute([$teacher_id, $date]);
      $attendance = $stmt->fetchAll(PDO::FETCH_ASSOC);

      if ($attendance) {
        $error[] = "Error: Attendance Already Completed.";
      } else {
        foreach ($attendance_records as $student_id => $status) {
          $sql = "INSERT INTO attendance (teacher_id, student_id, date, status, created_at, updated_at) 
                  VALUES (:teacher_id, :student_id, :date, :status, :created_at, :updated_at)";
          $stmt = $pdo->prepare($sql);
          $params = [
            ':teacher_id' => $teacher_id,
            ':student_id' => $student_id,
            ':date' => $date,
            ':status' => $status,
            ':created_at' => $created_at,
            ':updated_at' => $updated_at
          ];
          $stmt->execute($params);
        }
        header("Location: attendance.php");
        exit();
      }
    }
  } else {
    $error[] = "Error: Attendance checks not completed.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
  
  <head>
    <?php require_once('../includes/dashboard_header.php') ?>
    
    <!-- Include FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.0/main.css" rel="stylesheet">

    <!-- Include FullCalendar core JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.0/main.js"></script>

    <!-- jQuery UI files for datetime format -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js" defer></script>

  </head>
    <style>
        .unavailable-date {
            background-color: red;
            color: white;
        }
    </style>
  
  <body>
  <div class="wrapper">
    <!-- Sidebar -->
    <?php require_once('includes/sidebar.inc.php') ?>
    <!-- End Sidebar -->
    <div class="main-panel">
      <?php require_once('includes/navbar.inc.php') ?>
      <!-- Dashboard started -->
      <div class="container">
        <div class="page-inner">
          <div id="content" class="p-4 p-md-5">
            <h2>Time Management</h2>
            <hr>
            <!-- Main Container Start -->
              <!-- Edit time slot modal start -->
    <div class="modal fade" tabindex="-1" id="editTimeSlotModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Time Slot</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="EditTimeSlotForm" method="post">
                    <input type="hidden" name="editTimeSlotFormSubmit" value="editTimeSlotFormSubmit">
                    <input type="hidden" name="editTimeSlotID" id="edit_TimeSlotID">
                    <div class="modal-body">
                        <p>Date: <span class="badge bg-dark" id="show_selected_timeslot"></span></p>
                        <label for="edit_date">Date:</label>
                        <input type="text" id="edit_date" class="form-control" name="date" readonly>
                        <label for="edit_slot_title">Time Slot Name:</label>
                        <input type="text" class="form-control" id="edit_slot_title" name="slot_title" placeholder="Title">
                        <table class="table">
                            <tr>
                                <td width="50%">
                                    <label for="start_hour">Start (24-hour format):</label>
                                </td>
                                <td>
                                    <input type="number" class="form-control half-width" placeholder="hour" name="start_hour" min="0" max="23" step="1">
                                    <input type="number" class="form-control half-width" placeholder="minutes" name="start_minute" min="0" max="59" step="1">
                                </td>
                            </tr>
                            <tr>
                                <td width="50%">
                                    <label for="end_hour">End (24-hour format):</label>
                                </td>
                                <td>
                                    <input type="number" class="form-control half-width" placeholder="hour" name="end_hour" min="0" max="23" step="1">
                                    <input type="number" class="form-control half-width" placeholder="minutes" name="end_minute" min="0" max="59" step="1">
                                </td>
                            </tr>
                        </table>
                        <table class="table mt-3">
                            <tr>
                                <td>
                                    <label for="edit_background_clr">Background Color:</label>
                                </td>
                                <td>
                                    <input type="color" id="edit_background_clr" name="background_clr" value="#2c3e50">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="edit_text_clr">Text Color:</label>
                                </td>
                                <td>
                                    <input type="color" id="edit_text_clr" name="text_clr" value="#f8f9fa">
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <div>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="delete-slot-btn">Delete</button>
                        </div>
                        <div>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button name="EditSlot" class="btn btn-primary">Save Changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Edit time slot modal end -->

    <!-- Add new time slot modal start -->
    <div class="modal fade" tabindex="-1" id="AddTimeSlotModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Time Slot</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="AddNewSlotForm" method="post">
                    <input type="hidden" name="addNewSlotFormSubmit" value="addNewSlotFormSubmit">
                    <div class="modal-body">
                        <p>Date: <span class="badge bg-dark" id="show_selected_date"></span></p>
                        <input type="text" id="selected_date" class="form-control" name="date" readonly>
                        <label for="slot_title">Time Slot Name:</label>
                        <input type="text" class="form-control" name="slot_title" placeholder="Title">
                        <table class="table">
                            <tr>
                                <td width="50%">
                                    <label for="start_hour">Start (24-hour format):</label>
                                </td>
                                <td>
                                    <input type="number" class="form-control half-width" placeholder="hour" name="start_hour" min="0" max="23" step="1">
                                    <input type="number" class="form-control half-width" placeholder="minutes" name="start_minute" min="0" max="59" step="1">
                                </td>
                            </tr>
                            <tr>
                                <td width="50%">
                                    <label for="end_hour">End (24-hour format):</label>
                                </td>
                                <td>
                                    <input type="number" class="form-control half-width" placeholder="hour" name="end_hour" min="0" max="23" step="1">
                                    <input type="number" class="form-control half-width" placeholder="minutes" name="end_minute" min="0" max="59" step="1">
                                </td>
                            </tr>
                        </table>
                        <table class="table mt-3">
                            <tr>
                                <td>
                                    <label for="background_clr">Background Color:</label>
                                </td>
                                <td>
                                    <input type="color" name="background_clr" value="#2c3e50">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="text_clr">Text Color:</label>
                                </td>
                                <td>
                                    <input type="color" name="text_clr" value="#f8f9fa">
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <div>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button name="AddSlot" class="btn btn-primary">Add Time Slot</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
            <div class="height-100 bg-light">
                <button class="btn btn-outline-dark ms-3 mb-3 mt-3" id="switchToMonthButton" style="display: none;">Monthly View</button>
                <button class="btn btn-outline-primary ms-3 mb-3 mt-3" id="addNewTimeSlotbtn" style="display: none;">Add New Time Slot</button>
                <main class="ms-5">
                    <div id="calendar"></div>
                </main>
            </div>
            <!-- Main Container End -->
        </div>

        </div>
      </div>
    </div>
    <?php require_once('../includes/dashboard_footer.php') ?>



</body>
<script>
   $(document).ready(function() {
        $('#add-row').DataTable({
          pageLength: 5,
    dom: 'Bfrtip', // Include buttons in the table
    buttons: [
      {
        extend: 'csv',
        text: 'Export CSV',
        className: 'btn btn-primary' // Add Bootstrap class for color
      },
      {
        extend: 'excel',
        text: 'Export Excel',
        className: 'btn btn-success' // Add Bootstrap class for color
      },
      {
        extend: 'pdf',
        text: 'Export PDF',
        className: 'btn btn-danger' // Add Bootstrap class for color
      },
      {
        extend: 'print',
        text: 'Print',
        className: 'btn btn-info' // Add Bootstrap class for color
      }
    ]
        });
      });
</script>
</html>