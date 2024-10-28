<?php
require_once('../includes/db.php');
require_once('includes/login_check.php');
$s = "SELECT 
                        attendance.id,
                        student.id AS student_id,
                        student.name AS student_name,
                        class.id AS class_id,
                        class.name AS class_name,
                        teacher.id AS teacher_id,
                        teacher.name AS teacher_name
                    FROM 
                        attendance
                    JOIN 
                        student ON attendance.student_id = student.id
                    JOIN 
                        class ON attendance.class_id = class.id
                    JOIN 
                        teacher ON attendance.teacher_id = teacher.id;
                    ";
                  $sth = $pdo->prepare($s);
                  $sth->execute([':teacher_id' => $user_id, ':current_date' => $current_date]);
                  ?>
if(isset($_GET["id"])){
    $id = $_GET['id'];
}

if (isset($_POST['submit_attendance'])) {
    $id = $_POST['student_id'];
    $date = date('Y-m-d H:i:s');
    $status = $_POST['attendance'][$id];
    $created_at = $date;
    $updated_at = $date;

    $sql = "UPDATE attendance 
            SET
                status = :status, 
                created_at = :created_at, 
                updated_at = :updated_at 
                WHERE student_id = :student_id";
    $stmt = $pdo->prepare($sql);
    $params = [
        ':status' => $status,
        ':created_at' => $created_at,
        ':updated_at' => $updated_at,
        ':student_id' => $id,
    ];

    if ($stmt->execute($params)) {
        header("Location: attendance.php");
        exit();
    } else {
        echo "Error updating attendance.";
    }
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
              <?php 
              if(isset($error) && count($error) > 0)
              {
                foreach($error as $error_msg)
                {
                  echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">'.
                    $error_msg.
                  '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'.
                  '</div>';
                }
              }
            ?>
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
                        WHERE class.teacher_id = :teacher_id AND student.id = :student_id";
                  $sth = $pdo->prepare($s);
                  $sth->execute([':teacher_id' => $user_id, ':current_date' => $current_date, ':student_id' => $id]);
                  ?>
                  <div class="table-responsive">
                    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                      <input type="hidden" name="student_id" value="<?php echo $id; ?>">
                      <table id="add-row" class="display table table-striped table-hover">
                        <thead class="text-center">
                          <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Class</th>
                            <th>Attendance</th>
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
                            echo "</tr>";
                          }
                          ?>
                        </tbody>
                      </table>
                      <div class="d-flex justify-content-center align-items-center">
                          <input type="submit" class="btn btn-success btn-round justify-content-center" name="submit_attendance" value="Submit Attendance">
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
