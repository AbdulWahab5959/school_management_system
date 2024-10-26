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
      <div class="container">
        <div class="page-inner">
          <div
            class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
              <h3 class="fw-bold mb-3">Dashboard</h3>
              <h6 class="op-7 mb-2">Student Dashboard</h6>
            </div>
          </div>

          <div class="page-header">
            <h3 class="fw-bold mb-3 card-header">Student Data Tables </h3>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                
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