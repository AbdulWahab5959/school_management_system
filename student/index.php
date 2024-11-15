<?php
require_once('../includes/db.php');
require_once('includes/login_check.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  require_once('../includes/dashboard_header.php')
  ?>
</head>

<body>
  <div class="wrapper">
    <!-- Sidebar -->
    <?php
    require_once('includes/sidebar.inc.php')
    ?>
    <!-- End Sidebar -->

    <div class="main-panel">
      <?php
      require_once('includes/navbar.inc.php')
      ?>
      <!-- Dashboard started -->
      <?php
      $student_id = $_SESSION['student_id'];
      $sql = "SELECT student.name, class.name AS class_name, teacher.name AS teacher_name, teacher.email AS teacher_email 
                      FROM student 
                      JOIN class ON student.class_id = class.id 
                      JOIN teacher ON class.teacher_id = teacher.id 
                      WHERE student.id = ?";
      $stmt = $pdo->prepare($sql);
      $stmt->execute([$student_id]);
      $student = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($student) {
        $name = $student['name'];
        $class_name = $student['class_name'];
        $teacher_name = $student['teacher_name'];
        $teacher_email = $student['teacher_email'];
      }
      ?>
      <div class="container">
        <div class="page-inner">
          <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div class="card card-stats card-round ms-3">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col-icon">
                    <div
                      class="icon-big text-center icon-primary bubble-shadow-small">
                      <i class="fas fa-chalkboard"></i>
                    </div>
                  </div>
                  <div class="col col-stats ms-3 ms-sm-0">
                    <div class="numbers">
                      <p class="card-category">Student Class</p>
                      <h4 class="card-title"> <?php echo $class_name; ?></h4>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="card card-stats card-round ms-3">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col-icon">
                    <div
                      class="icon-big text-center icon-primary bubble-shadow-small">
                      <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                  </div>
                  <div class="col col-stats ms-3 ms-sm-0">
                    <div class="numbers">
                      <p class="card-category">Class Teacher</p>
                      <h4 class="card-title"> <?php echo $teacher_name; ?></h4>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- <div class="card card-stats card-round ms-3">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col-icon">
                    <div
                      class="icon-big text-center icon-primary bubble-shadow-small">
                      <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                  </div>
                  <div class="col col-stats ms-3 ms-sm-0">
                    <div class="numbers">
                      <p class="card-category">Teacher</p>
                      <h4 class="card-title"> <?php echo $teacher_email; ?></h4>
                    </div>
                  </div>
                </div>
              </div>
            </div> -->
          </div>
          
          <div class="page-header">
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php
  require_once('../includes/dashboard_footer.php')
  ?>

</body>

</html>