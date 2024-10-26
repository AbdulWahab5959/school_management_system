<?php
require_once('../includes/db.php');
require_once('includes/login_check.php');

$user_id =$_SESSION['teacher_id'] ;
$sql = "SELECT * FROM class WHERE teacher_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$user_id]);
$class = $stmt->fetch(PDO::FETCH_ASSOC);

if ($class) {
    $class_id = $class['id'];
} else {
    $error[] = "Error: class not found.";
}

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
      <div class="container">
        <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div class="card card-stats card-round ms-3">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col-icon">
                    <div
                      class="icon-big text-center icon-primary bubble-shadow-small">
                      <i class="fas fa-users"></i>
                    </div>
                  </div>
                  <div class="col col-stats ms-3 ms-sm-0">
                    <div class="numbers">
                      <p class="card-category">Active Students</p>
                      <?php
                      $sql = "SELECT COUNT(*) FROM student WHERE status=1 AND class_id=$class_id ";
                      $res = $pdo->query($sql);
                      $count = $res->fetchColumn();
                      ?>
                      <h4 class="card-title"> <?php echo $count; ?></h4>
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
                      <i class="fas fa-users"></i>
                    </div>
                  </div>
                  <div class="col col-stats ms-3 ms-sm-0">
                    <div class="numbers">
                      <p class="card-category">Disable Students</p>
                      <?php
                      $sql = "SELECT COUNT(*) FROM student WHERE status=0 AND class_id=$class_id ";
                      $res = $pdo->query($sql);
                      $count = $res->fetchColumn();
                      ?>
                      <h4 class="card-title"> <?php echo $count; ?></h4>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="page-header">
            <h3 class="fw-bold mb-3"> Active Student Tables </h3>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body">
                  <?php

                     $s = "SELECT student.*, class.id AS class_id, class.name AS class_name,
                    class.section AS class_section, class.teacher_id AS class_teacher_id
                    FROM class
                    INNER JOIN student ON student.class_id = class.id
                    WHERE student.class_id IS NOT NULL AND class.teacher_id= '$user_id' ";
                    $sth = $pdo->prepare($s, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                    $sth->execute();
                                    ?>
                 
                 <div class="table-responsive">
                    <table id="add-row" class="display table table-striped table-hover">
                      <thead class="text-center">
                        <tr>
                          <th>ID</th>
                          <th>Name</th>
                          <th>Email</th>
                          <th>Class</th>
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
                          echo "<td>" . $Row['class_name'] ." ".$Row['class_section']. "</td>";
                          echo "</tr>";
                        }
                        ?>
                      </tbody>

                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php
    require_once('../includes/dashboard_footer.php')
    ?>
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