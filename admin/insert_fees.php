<?php
require_once('../includes/db.php');
require_once('includes/login_checks.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['class_id'])) {
  $classId = $_GET['class_id'];
  $start_date = $_GET['start_date']; 
  $end_date = $_GET['end_date'];

  try {
    $sql = "SELECT id FROM student WHERE class_id = :class_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['class_id' => $classId]);
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $feeSql = "SELECT fees FROM class WHERE id = :id";
    $feeStmt = $pdo->prepare($feeSql);
    $feeStmt->execute(['id' => $classId]);
    $classFee = $feeStmt->fetchColumn();

    $insertSql = "INSERT INTO fees (status, student_id, class_id, class_fee, start_date, end_date, created_at, updated_at) 
                      VALUES ('Pending', :student_id, :class_id, :class_fee, :start_date, :end_date, NOW(), NOW())";
    $updateSql = "UPDATE fees SET start_date = :start_date, end_date = :end_date, updated_at = NOW() 
                      WHERE student_id = :student_id AND class_id = :class_id AND MONTH(start_date) = MONTH(:start_date)";

    $insertStmt = $pdo->prepare($insertSql);
    $updateStmt = $pdo->prepare($updateSql);


    $studentsToUpdate = [];
    $studentsToInsert = [];

    foreach ($students as $student) {

      $existingFeeSql = "SELECT id, start_date, end_date FROM fees 
                               WHERE student_id = :student_id AND class_id = :class_id AND MONTH(start_date) = MONTH(:start_date)";
      $existingFeeStmt = $pdo->prepare($existingFeeSql);
      $existingFeeStmt->execute(['student_id' => $student['id'], 'class_id' => $classId, 'start_date' => $start_date]);
      $existingFee = $existingFeeStmt->fetch(PDO::FETCH_ASSOC);

      if ($existingFee) {
        if ($existingFee['start_date'] !== $start_date || $existingFee['end_date'] !== $end_date) {
          $studentsToUpdate[] = $student['id'];
        }
      } else {
        $studentsToInsert[] = $student['id'];
      }
    }

    foreach ($studentsToUpdate as $studentId) {
      $updateStmt->execute([
        'student_id' => $studentId,
        'class_id' => $classId,
        'start_date' => $start_date,
        'end_date' => $end_date
      ]);
    }

    foreach ($studentsToInsert as $studentId) {
      $insertStmt->execute([
        'student_id' => $studentId,
        'class_id' => $classId,
        'class_fee' => $classFee,
        'start_date' => $start_date,
        'end_date' => $end_date
      ]);
    }

    echo json_encode([
      "status" => "success",
      "message" => " for class ID $classId.",
      "updated" => $studentsToUpdate,
      "inserted" => $studentsToInsert
    ]);
  } catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => "An error occurred: " . $e->getMessage()]);
  }
  exit();
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
          <form id="feesForm">
            <div class="row">
              <h3 class="text-center">Insert Class Fees Details</h3>
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
                        <option value="<?php echo ($row['id']); ?>">
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
                    <p class="card-category">Select Start Date</p>
                    <input type="date" name="start_date" id="start_date" class="form-control" required />
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                  <div class="card-body text-center">
                    <p class="card-category">Select Last Date</p>
                    <input type="date" name="end_date" id="end_date" class="form-control" required />
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                  <div class="card-body text-center">
                  <p class="card-category">Insert Class Fees </p>
                    <button type="submit" class="btn btn-primary px-5">Insert</button>
                  </div>
                </div>
              </div>
            </div>
          </form>
          <hr>
        </div>
      </div>
    </div>
    <?php require_once('../includes/dashboard_footer.php'); ?>
  </div>

  <script>
    $(document).ready(function() {
      $('#feesForm').on('submit', function(event) {
        event.preventDefault();

        var classId = $("#class_id").val();
        var startDate = $("#start_date").val();
        var endDate = $("#end_date").val();

        $.ajax({
          url: "insert_fees.php",
          method: "GET",
          data: {
            class_id: classId,
            start_date: startDate,
            end_date: endDate
          },
          success: function(response) {
            var data = JSON.parse(response);
            if (data.status === "success") {
              let message = "";

              if (data.inserted.length > 0) {
                message = `${data.inserted.length} records inserted ${data.message}`;
              }
              if (data.updated.length > 0) {
                message = `${data.updated.length} records updated ${data.message}`;
              }

              Swal.fire({
                title: "Success!",
                text: message,
                icon: "success",
                confirmButtonText: "OK"
              });
            } else {
              Swal.fire({
                title: "Error!",
                text: data.message,
                icon: "error",
                confirmButtonText: "OK"
              });
            }
          },

          error: function(xhr, status, error) {
            console.error("Error:", error);
            Swal.fire({
              title: "Error!",
              text: "Form data sending error",
              icon: "error",
              confirmButtonText: "OK"
            });
          }
        });

      });
    });
  </script>
</body>

</html>