<?php
require_once('../includes/db.php');

if (isset($_POST['submit_attendance'])) {
  $teacher_id = $_POST['teacher_id'];
  $date = date('Y-m-d H:i:s');
  $attendance_records = $_POST['attendance'];
  $created_at = $date;
  $updated_at = $date;

  foreach ($attendance_records as $student_id => $status) {
    $sql = "INSERT INTO attendance (teacher_id, student_id, date, status, created_at, updated_at) VALUES (:teacher_id, :student_id, :date, :status, :created_at, :updated_at)";
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
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php require_once('../includes/dashboard_header.php') ?>
</head>

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
          <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
              <h3 class="fw-bold mb-3">Dashboard</h3>
              <h6 class="op-7 mb-2">Teacher Dashboard</h6>
            </div>
          </div>
          <div class="page-header">
            <h3 class="fw-bold mb-3">Active Student Tables</h3>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body">
                  <?php
                  $current_date = date('Y-m-d');
                  $s = "SELECT student.*, class.id AS class_id, class.name AS class_name, class.section AS class_section, class.teacher_id AS class_teacher_id 
                        FROM class 
                        INNER JOIN student ON student.class_id = class.id 
                        LEFT JOIN attendance ON student.id = attendance.student_id AND attendance.date = :current_date
                        WHERE class.teacher_id = :teacher_id";
                  $sth = $pdo->prepare($s);
                  $sth->execute([':teacher_id' => $user_id, ':current_date' => $current_date]);
                  ?>
                  <div class="table-responsive">
                    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                      <input type="hidden" name="teacher_id" value="<?php echo $user_id; ?>">
                      <table id="add-row" class="display table table-striped table-hover">
                        <thead class="text-center">
                          <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Class</th>
                            <th>Attendance</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody class="text-center">
                          <?php
                          $allRows = $sth->fetchAll();
                          foreach ($allRows as $Row) {
                            echo "<tr>";
                            echo "<td>" . $Row['id'] . "</td>";
                            echo "<td>" . $Row['name'] . "</td>";
                            echo "<td>" . $Row['email'] . "</td>";
                            echo "<td>" . $Row['class_name'] . " " . $Row['class_section'] . "</td>";
                            echo "<td>
                              <input type='radio' name='attendance[" . $Row['id'] . "]' value='present'> Present
                              <input type='radio' name='attendance[" . $Row['id'] . "]' value='absent'> Absent
                            </td>";
                            echo "<td>
                                     <a href='edit_attendance.php?id=" . $Row['id'] . "' class='btn btn-link btn-primary'>
                                     <i class='fa fa-edit'></i>
                                    </a>
                                  </td>";

                            echo "</tr>";
                          }
                          ?>
                        </tbody>
                      </table>
                      <div class="d-flex justify-content-center align-items-center">
                        <input type="submit" class="btn attendance btn-success btn-round justify-content-center" name="submit_attendance" value="Submit Attendance">
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php require_once('../includes/dashboard_footer.php') ?>
</body>

</html>