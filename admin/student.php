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
              <h6 class="op-7 mb-2">Admin Dashboard</h6>
            </div>
            <div class="ms-md-auto py-2 py-md-0">
              <a href="register_student.php" class="btn btn-primary btn-round">Add Students</a>
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
                  $s = "SELECT student.*, class.id AS class_id, class.name AS class_name, class.section AS class_section
                  FROM student
                  LEFT JOIN class ON student.class_id = class.id
                  WHERE student.status=1";
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
                          echo "<td>" . $Row['email'] . "</td>";
                          echo "<td>" . ($Row['class_name'] ? $Row['class_name'] . " " . $Row['class_section'] : "Class not assigned") . "</td>";
                          echo '<td>
                          <div class="form-button-action">
                              <button
                                  type="button"
                                  class="btn btn-link btn-primary btn-lg edit"
                                  data-id="' . $Row['id'] . '"
                                  title="Edit student">
                                  <i class="fa fa-edit"></i>
                              </button>
                              <button
                                  type="button"
                                  class="btn btn-link btn-danger delete"
                                  data-id="' . $Row['id'] . '"
                                  title="Remove student">
                                  <i class="fa fa-times"></i>
                              </button>
                              <button
                                  type="button"
                                  class="btn btn-link btn-success disable"
                                  data-id="' . $Row['id'] . '"
                                  title="Disable student">
                                  <i class="fa fa-unlock"></i>
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
            <h3 class="fw-bold mb-3"> Disable Student Tables </h3>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body">
                  <?php
                  $s = "SELECT * from student WHERE status=0";
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
                          echo "<td>" . $Row['email'] . "</td>";
                          echo '<td>
                          <div class="form-button-action">
                                <button
                                  type="button"
                                  class="btn btn-link btn-danger delete"
                                  data-id="' . $Row['id'] . '"
                                  title="Remove student">
                                  <i class="fa fa-times"></i>
                              </button>
                              <button
                                  type="button"
                                  class="btn btn-link btn-warning active"
                                  data-id="' . $Row['id'] . '"
                                  title="Active student">
                                  <i class="fa fa-lock"></i>
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
  $(document).ready(function () {
    $(document).on('click', '.edit', function () {
      var id = $(this).data('id');
      window.location.href = 'student_edit.php?id=' + id;
    });

    $(document).on('click', '.delete', function () {
      var id = $(this).data('id');
      Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to delete this student?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = 'student_delete.php?id=' + id;
        }
      });
    });

    $(document).on('click', '.disable', function () {
      var id = $(this).data('id');
      Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to disable this student?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, disable it!',
        cancelButtonText: 'Cancel'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = 'student_disable.php?id=' + id;
        }
      });
    });

    $(document).on('click', '.active', function () {
      var id = $(this).data('id');
      Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to activate this student?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, activate it!',
        cancelButtonText: 'Cancel'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = 'student_active.php?id=' + id;
        }
      });
    });
  });
</script>


</body>

</html>