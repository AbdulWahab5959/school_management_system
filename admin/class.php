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
            <div class="ms-md-auto py-2 py-md-0">
                <a href="register_class.php" class="btn btn-primary btn-round">Add class</a>
            </div>
          </div>

                
         
          <div class="page-header">
            <h3 class="fw-bold mb-3">Active Class Tables </h3>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body">
                <?php
                  $s = "SELECT class.*, teacher.id AS teacher_id, teacher.name AS teacher_name 
                  FROM class
                  LEFT JOIN teacher 
                  ON class.teacher_id = teacher.id
                  WHERE class.status=1";           

                  // $s = "SELECT * FROM class where status='1'";
                  $sth = $pdo->prepare($s, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                  $sth->execute();
                  ?>

                  <div class="table-responsive">
                      <table id="add-row" class="display table table-striped table-hover">
                          <thead class="text-center">
                              <tr>
                                  <th>ID</th>
                                  <th>Name</th>
                                  <th>Class Teacher</th>
                                  <th>Section</th>
                                  <th>fFees</th>
                                  <th style="width: 20%">Action</th>
                              </tr>
                          </thead>
                          <tbody class="text-center">
                              <?php
                              $allRows = $sth->fetchAll();
                              foreach ($allRows as $Row) {
                                  echo "<tr>";
                                  echo "<td>" . $Row['id'] . "</td>";
                                  echo "<td>" . $Row['name'] . "</td>";
                                  echo "<td>" . ($Row['teacher_name'] ? $Row['teacher_name'] : "Teacher not assigned") . "</td>";
                                  echo "<td>" . $Row['section'] . "</td>";
                                  echo "<td>" . $Row['fees'] . "</td>";
                                  echo '<td>
                                  <div class="form-button-action">
                                      <button
                                          type="button"
                                          class="btn btn-link btn-primary btn-lg edit"
                                          data-id="' . $Row['id'] . '"
                                          title="Edit class">
                                          <i class="fa fa-edit"></i>
                                      </button>
                                      <button
                                          type="button"
                                          class="btn btn-link btn-danger delete"
                                          data-id="' . $Row['id'] . '"
                                          title="Remove class">
                                          <i class="fa fa-times"></i>
                                      </button>
                                      <button
                                          type="button"
                                          class="btn btn-link btn-warning disable"
                                          data-id="' . $Row['id'] . '"
                                          title="disable class">
                                          <i class="fa fa-lock" aria-hidden="true"></i>
                                      </button>
                                  </div>
                                </td>';
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
          <div class="page-header">
            <h3 class="fw-bold mb-3">Disable Class Tables </h3>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body">
                <?php
                  $s="SELECT * FROM class where status=0";
                  $sth = $pdo->prepare($s);
                  $sth->execute();
                  ?>
                  <div class="table-responsive">
                      <table id="add-row" class="display table table-striped table-hover">
                          <thead class="text-center">
                              <tr>
                                  <th>ID</th>
                                  <th>Name</th>
                                  <th>Section</th>
                                  <th>fFees</th>
                                  <th style="width: 20%">Action</th>
                              </tr>
                          </thead>
                          <tbody class="text-center">
                              <?php
                              $allRows = $sth->fetchAll();
                              foreach ($allRows as $Row) {
                                  echo "<tr>";
                                  echo "<td>" . $Row['id'] . "</td>";
                                  echo "<td>" . $Row['name'] . "</td>";
                                  echo "<td>" . $Row['section'] . "</td>";
                                  echo "<td>" . $Row['fees'] . "</td>";
                                  echo '<td>
                                  <div class="form-button-action">
                                      <button
                                          type="button"
                                          class="btn btn-link btn-danger delete"
                                          data-id="' . $Row['id'] . '"
                                          title="Remove class">
                                          <i class="fa fa-times"></i>
                                      </button>
                                  <button
                                          type="button"
                                          class="btn btn-link btn-success active"
                                          data-id="' . $Row['id'] . '"
                                          title="active class">
                                          <i class="fa fa-unlock" aria-hidden="true"></i>
                                      </button>
                                  </div>
                                </td>';
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

        $(document).on('click', '.edit', function() {
          var id = $(this).data('id');
          window.location.href = 'class_edit.php?id=' + id;
        });

        $(document).on('click', '.delete', function() {
          var id = $(this).data('id');
          Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.href = 'class_delete.php?id=' + id;
            }
          });
        });

        $(document).on('click', '.disable', function() {
          var id = $(this).data('id');
          Swal.fire({
            title: 'Are you sure?',
            text: "You want to disable this class!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, disable it!'
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.href = 'class_disable.php?id=' + id;
            }
          });
        });

        $(document).on('click', '.active', function() {
          var id = $(this).data('id');
          Swal.fire({
            title: 'Are you sure?',
            text: "You want to activate this class!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, activate it!'
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.href = 'class_active.php?id=' + id;
            }
          });
        });

      });
    </script>

</script>
</body>

</html>