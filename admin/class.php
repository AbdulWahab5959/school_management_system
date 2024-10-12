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
                <a href="register_class.php" class="btn btn-primary btn-round">Add class</a>
            </div>
          </div>

                
          <div class="page-header">
            <h3 class="fw-bold mb-3">Class Tables </h3>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body">
                <?php

                  $s = "SELECT * FROM class";
                  $sth = $pdo->prepare($s, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
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
                                          title="Disable class">
                                          <i class="fa fa-ban"></i>
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
    

    // Edit class
    $(document).on('click', '.edit', function() {
      var id = $(this).data('id');
      window.location.href = 'class_edit.php?id=' + id; 
    });
    // delete class
    $(document).on('click', '.delete', function() {
      var id = $(this).data('id');
      window.location.href = 'class_delete.php?id=' + id; 
    });


  });
</script>
</body>

</html>