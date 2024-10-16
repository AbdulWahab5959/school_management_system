<?php
require_once('../includes/db.php');
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
          <div
            class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
              <h3 class="fw-bold mb-3">Dashboard</h3>
              <h6 class="op-7 mb-2">Teacher Dashboard</h6>
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

</html>