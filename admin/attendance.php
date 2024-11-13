<?php
require_once('../includes/db.php');
require_once('includes/login_checks.php');


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['attendance'], $_POST['class_id'], $_POST['date'])) {
  $class_id = $_POST['class_id'];
  $date = $_POST['date'];
  $attendance_records = $_POST['attendance'];
  $updated_at = date('Y-m-d H:i:s');

  try {
    foreach ($attendance_records as $student_id => $status) {
      $sql = "UPDATE attendance 
                    SET status = :status, updated_at = :updated_at 
                    WHERE class_id = :class_id AND student_id = :student_id AND date = :date";
      $stmt = $pdo->prepare($sql);

      $params = [
        ':status' => $status,
        ':updated_at' => $updated_at,
        ':class_id' => $class_id,
        ':student_id' => $student_id,
        ':date' => $date
      ];

      if (!$stmt->execute($params)) {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update attendance for student ID: ' . $student_id]);
        exit;
      }
    }

    echo json_encode(['status' => 'success', 'message' => 'Attendance updated successfully for student ID: ' . $student_id]);
  } catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
  }
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  require_once('../includes/dashboard_header.php');
  ?>
</head>

<body>
  <div class="wrapper">
    <!-- Sidebar -->
    <?php
    require_once('includes/sidebar.inc.php');
    ?>
    <!-- End Sidebar -->

    <div class="main-panel">
      <?php
      require_once('includes/navbar.inc.php');
      ?>
      <!-- Dashboard started -->
      <div class="container">
        <div class="page-inner">
          <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
          </div>

          <!-- Start of form to submit class and date data -->
          <form action="" method="Get">
            <div class="row">
              <!-- Class Selection Card -->
              <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-icon">
                        <div class="icon-big text-center icon-primary bubble-shadow-small">
                          <i class="fas fa-chalkboard"></i>
                        </div>
                      </div>
                      <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                          <p class="card-category">Select Class</p>
                          <?php
                          // Query to fetch all classes
                          $sql = "SELECT * FROM class";
                          $res = $pdo->query($sql);
                          ?>

                          <!-- Dropdown to select a class -->
                          <select name="class" id="class" class="form-control" required>
                            <option value="">-- Select Class --</option>
                            <?php while ($row = $res->fetch(PDO::FETCH_ASSOC)): ?>
                              <option value="<?php echo ($row['id']); ?>">
                                <?php echo ($row['name'] . ' ' . $row['section']); ?>
                              </option>

                            <?php endwhile; ?>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Date Selection Card -->
              <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                          <p class="card-category">Select Date</p>
                          <input type="date" name="attendance_date" id="attendance_date" class="form-control" required />
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Submit Button Card -->
              <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                          <p class="card-category">Check Attendance</p>
                          <div class="mt-1 text-center">
                            <button type="submit" class="btn btn-primary" name="check_attendance">Submit</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </form>
          <!-- End of form -->

          <?php
          if (isset($_GET['check_attendance'])) {
            $selectedClass = $_GET['class'];
            $attendanceDate = $_GET['attendance_date'];

            $classQuery = "SELECT id, name, section FROM class WHERE id = :class_id";
            $classStmt = $pdo->prepare($classQuery);
            $classStmt->execute(['class_id' => $selectedClass]);
            $classInfo = $classStmt->fetch(PDO::FETCH_ASSOC);

            $attendanceQuery = "SELECT s.id,s.name, a.status, a.date 
                                FROM attendance a 
                                JOIN student s ON a.student_id = s.id 
                                WHERE a.class_id = :class_id AND a.date = :attendance_date";
            $stmt = $pdo->prepare($attendanceQuery);
            $stmt->execute(['class_id' => $selectedClass, 'attendance_date' => $attendanceDate]);
            $attendanceRecords = $stmt->fetchAll(PDO::FETCH_ASSOC);
          }
          ?>

          <?php if (isset($attendanceRecords) && !empty($attendanceRecords) && isset($classInfo)): ?>
            <div class="page-header">
              <h4>Attendance Records for <?php echo ($classInfo['name'] . ' ' . $classInfo['section']); ?> on <?php echo ($attendanceDate); ?></h4>
            </div>
            <table id="attendance-table" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Student Name</th>
                  <th>Status</th>
                  <th>Date</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($attendanceRecords as $record): ?>
                  <tr>
                    <td><?php echo ($record['id']); ?></td>
                    <td><?php echo ($record['name']); ?></td>
                    <td><?php echo ($record['status']); ?></td>
                    <td><?php echo ($record['date']); ?></td>
                    <td>
                      <button
                        type="button"
                        class="btn btn-link btn-primary btn-lg edit"
                        data-student-id="<?php echo ($record['id']); ?>"
                        data-student-name="<?php echo ($record['name']); ?>"
                        data-status="<?php echo ($record['status']); ?>"
                        data-date="<?php echo ($record['date']); ?>"
                        data-class-id="<?php echo ($classInfo['id']); ?>"
                        data-class-name="<?php echo htmlspecialchars($classInfo['name'] . ' ' . $classInfo['section']); ?>"
                        title="Edit attendance">
                        <i class="fa fa-edit"></i>
                      </button>
                    </td>


                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          <?php elseif (isset($_POST['check_attendance'])): ?>
            <div class="alert alert-warning">No attendance records found for the selected class and date.</div>
          <?php endif; ?>

        </div>
      </div>
    </div>
    <div class="modal fade" tabindex="-1" id="AttendanceModal">
      <div class="modal-dialog modal-length-custom">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Class Attendance</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form id="Attendance_form" method="post">
            <div class="modal-body">
              <input type="text" id="selected_date" class="form-control" name="date" readonly value="<?php echo ($record['date']); ?>">
              <input type="hidden" name="student_id" id="class_name">
              <input type="hidden" name="class_id" id="class_name">

              <label for="class_name">Class:</label>
              <input type="text" class="form-control" name="class_name" id="class_name" readonly>

              <!-- Student Info -->
              <div class="table-responsive mt-3">
                <table id="add-row" class="table table-striped table-hover">
                  <thead class="text-center">
                    <tr>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Attendance</th>
                    </tr>
                  </thead>
                  <tbody class="text-center">
                    <tr id="student-row">

                    </tr>
                  </tbody>

                </table>
              </div>
            </div>
            <div class="modal-footer">
              <?php if ($attendanceRecords): ?>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button name="UpdateAttendance" type="submit" class="btn btn-success">Save</button>
              <?php endif; ?>
            </div>
          </form>
        </div>
      </div>
    </div>
    <?php
    require_once('../includes/dashboard_footer.php');
    ?>
    <script>
      $(document).ready(function() {
        $("#attendance-table").DataTable({
          pageLength: 5,
          dom: '<"d-flex justify-content-between"<"mr-2"l><"ml-2"B><"ml-2"f>>rtip',
          buttons: [{
              extend: 'csv',
              text: 'Export CSV',
              className: 'btn btn-primary'
            },
            {
              extend: 'excel',
              text: 'Export Excel',
              className: 'btn btn-success'
            },
            {
              extend: 'pdf',
              text: 'Export PDF',
              className: 'btn btn-danger'
            },
            {
              extend: 'print',
              text: 'Print',
              className: 'btn btn-info'
            }
          ]
        });

        $(".edit").on("click", function() {
          var studentId = $(this).data("student-id");
          var studentName = $(this).data("student-name");
          var status = $(this).data("status");
          var date = $(this).data("date");
          var classId = $(this).data("class-id");
          var classInfo = $(this).data("class-name");

          $("#AttendanceModal #selected_date").val(date);
          $("#AttendanceModal input[name='student_id']").val(studentId);
          $("#AttendanceModal input[name='class_id']").val(classId);
          $("#AttendanceModal input[name='class_name']").val(classInfo);

          $("#student_id").text(studentId);
          $("#student_name").text(studentName);

                  var attendanceOptions = `
            <td>${studentId}</td>
            <td>${studentName}</td>
            <td>
              <input type="radio" name="attendance[${studentId}]" value="Present" ${status === 'Present' ? 'checked' : ''}> Present
              <input type="radio" name="attendance[${studentId}]" value="Absent" ${status === 'Absent' ? 'checked' : ''}> Absent
              <input type="radio" name="attendance[${studentId}]" value="Leave" ${status === 'Leave' ? 'checked' : ''}> Leave
            </td>
          `;

          $("#student-row").html(attendanceOptions);

          $("#AttendanceModal").modal("show");
        });


        $(document).on("submit", "#Attendance_form", function(event) {
          event.preventDefault();
          var formData = $(this).serialize();

          $.ajax({
            url: "attendance.php",
            type: "POST",
            data: formData,
            success: function(response) {
              console.log(response);
              var jsonResponse = JSON.parse(response);
              $("#AttendanceModal").modal("hide");
              if (jsonResponse.status === "success") {
                Swal.fire("Success", jsonResponse.message, "success");
              } else if (jsonResponse.status === "error") {
                Swal.fire("Error", jsonResponse.message, "error");
              }
            },
            error: function() {
              Swal.fire("Error", "Failed to update attendance.", "error");
            },
          });
        });
      });
    </script>


</body>

</html>