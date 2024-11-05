<?php

require_once('../includes/db.php');

require_once('includes/login_checks.php');



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
              <h6 class="op-7 mb-2">Admin Dashboard</h6>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6 col-md-3">
              <div class="card card-stats card-round">
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
                        <p class="card-category">Class</p>
                        <?php 
                        $sql = "SELECT COUNT(*) FROM class ";
                        $res = $pdo->query($sql);
                        $count = $res->fetchColumn();
                        ?>
                        <h4 class="card-title"> <?php echo$count; ?></h4>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-6 col-md-3">
              <div class="card card-stats card-round">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col-icon">
                      <div
                        class="icon-big text-center icon-info bubble-shadow-small">
                        <i class="fas fa-chalkboard-teacher"></i>
                      </div>
                    </div>
                    <div class="col col-stats ms-3 ms-sm-0">
                      <div class="numbers">
                        <p class="card-category">Teachers</p>
                        <?php 
                        $sql = "SELECT COUNT(*) FROM teacher ";
                        $res = $pdo->query($sql);
                        $count = $res->fetchColumn();
                        ?>
                        <h4 class="card-title"> <?php echo $count ?></h4>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-6 col-md-3">
              <div class="card card-stats card-round">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col-icon">
                      <div
                        class="icon-big text-center icon-success bubble-shadow-small">
                        <i class="fas fas fa-users"></i>
                      </div>
                    </div>
                    <div class="col col-stats ms-3 ms-sm-0">
                      <div class="numbers">
                        <p class="card-category">Students</p>
                        <?php 
                        $sql = "SELECT COUNT(*) FROM student ";
                        $res = $pdo->query($sql);
                        $count = $res->fetchColumn();
                        ?>
                        <h4 class="card-title"> <?php echo $count ?></h4>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-6 col-md-3">
              <div class="card card-stats card-round">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col-icon">
                      <div
                        class="icon-big text-center icon-secondary bubble-shadow-small">
                        <i class="far fa-check-circle"></i>
                      </div>
                    </div>
                    <div class="col col-stats ms-3 ms-sm-0">
                      <div class="numbers">
                        <p class="card-category">Staff</p>
                        <?php 
                        $sql = "SELECT COUNT(*) FROM staff ";
                        $res = $pdo->query($sql);
                        $count = $res->fetchColumn();
                        ?>
                        <h4 class="card-title"> <?php echo $count ?></h4>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="page-header">
            <!-- page header  -->
          </div>
         <!-- dashboard data added here -->

        </div>
      </div>
    </div>
    <?php
    require_once('../includes/dashboard_footer.php')
    ?>
    <script>
      $(document).ready(function() {
        // Add Row
        $("#add-row").DataTable({
          pageLength: 5,
        });
      });
    </script>
</body>

</html>