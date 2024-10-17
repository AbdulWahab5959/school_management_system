<?php

require_once('../includes/db.php');


// Login check
if(!isset($_SESSION['login']))
{
  echo "<script>window.location.replace('login.php')</script>";
}
else if ($_SESSION['login_type'] != 'admin'){
  echo "<script>window.location.replace('login.php')</script>";
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
          <div
            class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
              <h3 class="fw-bold mb-3">Dashboard</h3>
              <h6 class="op-7 mb-2">Admin Dashboard</h6>
            </div>
            <div class="ms-md-auto py-2 py-md-0">
                <a href="#" class="btn btn-primary btn-round">Add Customer</a>
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
                        <i class="fas fa-users"></i>
                      </div>
                    </div>
                    <div class="col col-stats ms-3 ms-sm-0">
                      <div class="numbers">
                        <p class="card-category">Visitors</p>
                        <h4 class="card-title">1,294</h4>
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
                        <i class="fas fa-user-check"></i>
                      </div>
                    </div>
                    <div class="col col-stats ms-3 ms-sm-0">
                      <div class="numbers">
                        <p class="card-category">Subscribers</p>
                        <h4 class="card-title">1303</h4>
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
                        <i class="fas fa-luggage-cart"></i>
                      </div>
                    </div>
                    <div class="col col-stats ms-3 ms-sm-0">
                      <div class="numbers">
                        <p class="card-category">Sales</p>
                        <h4 class="card-title">$ 1,345</h4>
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
                        <p class="card-category">Order</p>
                        <h4 class="card-title">576</h4>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="page-header">
            <h3 class="fw-bold mb-3">Teacher Tables </h3>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body">
                  <!-- Modal -->
                  
                  <div class="table-responsive">
                    <table
                      id="add-row"
                      class="display table table-striped table-hover">
                      <thead>
                        <tr>
                          <th>User_ID</th>
                          <th>Name</th>
                          <th>Email</th>
                          <th style="width: 10%">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>Tiger Nixon</td>
                          <td>System Architect</td>
                          <td>Edinburgh</td>
                          <td>
                            <div class="form-button-action">
                              <button
                                type="button"
                                data-bs-toggle="tooltip"
                                title=""
                                class="btn btn-link btn-primary btn-lg"
                                data-original-title="Edit Task">
                                <i class="fa fa-edit"></i>
                              </button>
                              <button
                                type="button"
                                data-bs-toggle="tooltip"
                                title=""
                                class="btn btn-link btn-danger"
                                data-original-title="Remove">
                                <i class="fa fa-times"></i>
                              </button>
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td>Garrett Winters</td>
                          <td>Accountant</td>
                          <td>Tokyo</td>
                          <td>
                            <div class="form-button-action">
                              <button
                                type="button"
                                data-bs-toggle="tooltip"
                                title=""
                                class="btn btn-link btn-primary btn-lg"
                                data-original-title="Edit Task">
                                <i class="fa fa-edit"></i>
                              </button>
                              <button
                                type="button"
                                data-bs-toggle="tooltip"
                                title=""
                                class="btn btn-link btn-danger"
                                data-original-title="Remove">
                                <i class="fa fa-times"></i>
                              </button>
                            </div>
                          </td>
                        </tr>
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
        <script>
          $(document).ready(function() {
            // Add Row
            $("#add-row").DataTable({
              pageLength: 5,
            });

            var action =
              '<td> <div class="form-button-action"> <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"> <i class="fa fa-edit"></i> </button> <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove"> <i class="fa fa-times"></i> </button> </div> </td>';

            $("#addRowButton").click(function() {
              $("#add-row")
                .dataTable()
                .fnAddData([
                  $("#addName").val(),
                  $("#addPosition").val(),
                  $("#addOffice").val(),
                  action,
                ]);
              $("#addRowModal").modal("hide");
            });
          });
        </script>
</body>

</html>