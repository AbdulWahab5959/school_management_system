<?php
require_once('../includes/db.php');
require_once('includes/login_checks.php');

$records = [];

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['class_id'])) {
  $classId = $_GET['class_id'];

  try {
    $fetchSql = "SELECT student.id as student_id, student.name as student_name, class.fees as class_fees, class.name as class_name, fees.id , fees.status, fees.start_date, fees.end_date
                     FROM fees
                     JOIN student ON fees.student_id = student.id
                     JOIN class ON fees.class_id = class.id
                     WHERE fees.class_id = :class_id";
    $fetchStmt = $pdo->prepare($fetchSql);
    $fetchStmt->execute(['class_id' => $classId]);
    $records = $fetchStmt->fetchAll(PDO::FETCH_ASSOC);
  } catch (Exception $e) {
    echo "Error: " . $e->getMessage();
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php require_once('../includes/dashboard_header.php'); ?>
</head>

<body>
  <div class="wrapper">
    <?php require_once('includes/sidebar.inc.php'); ?>
    <div class="main-panel">
      <?php require_once('includes/navbar.inc.php'); ?>
      <div class="container">
        <div class="page-inner">
          <form id="feesForm" method="GET">
            <div class="row">
              <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                  <div class="card-body text-center">
                    <p class="card-category">Select Class</p>
                    <?php
                    $sql = "SELECT * FROM class";
                    $res = $pdo->query($sql);
                    ?>
                    <select name="class_id" id="class_id" class="form-control" required>
                      <option value="">-- Select Class --</option>
                      <?php while ($row = $res->fetch(PDO::FETCH_ASSOC)): ?>
                        <option value="<?php echo ($row['id']); ?>" <?php echo (isset($classId) && $classId == $row['id'] ? 'selected' : ''); ?>>
                          <?php echo ($row['name'] . ' ' . $row['section']); ?>
                        </option>
                      <?php endwhile; ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                  <div class="card-body text-center">
                    <p class="card-category">Display Class Fees</p>
                    <button type="submit" class="btn btn-success px-5">Display</button>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-md-3"> </div>
              <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                  <div class="card-body text-center">
                    <p class="card-category">Add Class Fees </p> <a href="insert_fees.php" class="btn btn-primary px-5">Add</a>
                  </div>
                </div>
              </div>
            </div>
          </form>
          <hr>
          <?php if (!empty($records)): ?>
            <table id="recordsTable" class="table table-responsive py-0 table-bordered">
              <thead>
                <tr>
                  <th>Fee ID</th>
                  <th>Student ID</th>
                  <th>Student Name</th>
                  <th>Class Name</th>
                  <th>Class Fees</th>
                  <th>Status</th>
                  <th>Start Date</th>
                  <th>End Date</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($records as $record): ?>
                  <tr>
                    <td><?php echo htmlspecialchars($record['id']); ?></td>
                    <td><?php echo htmlspecialchars($record['student_id']); ?></td>
                    <td><?php echo htmlspecialchars($record['student_name']); ?></td>
                    <td><?php echo htmlspecialchars($record['class_name']); ?></td>
                    <td><?php echo htmlspecialchars($record['class_fees']); ?></td>
                    <td> <span class="badge badge-info p-3 h4"><?php echo htmlspecialchars($record['status']); ?></span></td>
                    <td><?php echo htmlspecialchars($record['start_date']); ?></td>
                    <td><?php echo htmlspecialchars($record['end_date']); ?></td>
                    <td>
                      <button class="btn btn-secondary pdf-btn"
                      data-id="<?php echo $record['id']; ?>" 
                      data-student-id="<?php echo $record['student_id']; ?>"
                       data-student-name="<?php echo $record['student_name']; ?>" 
                       data-class-name="<?php echo $record['class_name']; ?>"
                         data-class-fee="<?php echo $record['class_fees']; ?>" 
                         data-start-date="<?php echo $record['start_date']; ?>"
                          data-end-date="<?php echo $record['end_date']; ?>">
                           PDF </button>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <?php require_once('../includes/dashboard_footer.php'); ?>
  </div>

  <script>
    $(document).ready(function() {
      if ($('#recordsTable').length) {
        $("#recordsTable").DataTable({
          pageLength: 5,
          dom: '<"d-flex justify-content-between"<"mr-2"l><"ml-2"B><"ml-2"f>>rtip',
          buttons: [{
              extend: 'csv',
              text: 'Export CSV',
              className: 'btn btn-primary'
            },
            {
              extend: 'excel',
              text: 'Export Excel',
              className: 'btn btn-success'
            },
            {
              extend: 'pdf',
              text: 'Export PDF',
              className: 'btn btn-danger'
            },
            {
              extend: 'print',
              text: 'Print',
              className: 'btn btn-info'
            }
          ]
        });
      }
      $(document).on('click', '.pdf-btn', function() {
                var feeData = {
                    id: $(this).data('id'),
                    student_id: $(this).data('student-id'),
                    student_name: $(this).data('student-name'),
                    class_name: $(this).data('class-name'),
                    class_section: $(this).data('class-section'),
                    class_fee: $(this).data('class_fees'),
                    start_date: $(this).data('start-date'),
                    end_date: $(this).data('end-date')
                };
                console.log(feeData);

                var form = $('<form action="fee_pdf.php" target="_blank"  method="post"></form>');
                $.each(feeData, function(key, value) {
                    form.append('<input type="hidden" name="' + key + '" value="' + value + '">');
                });
                $('body').append(form);
                form.submit();
            });
    });
  </script>
</body>

</html>