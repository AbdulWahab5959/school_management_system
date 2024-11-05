<?php
require_once('../includes/db.php');
require_once('includes/login_check.php');

$teacher_id = $_SESSION['teacher_id'];
$date = date('Y-m-d');

$sql = "SELECT class.id AS id, class.name AS class_name, teacher.name AS teacher_name 
        FROM class
        LEFT JOIN teacher ON class.teacher_id = teacher.id
        WHERE class.status = 1 AND class.teacher_id = :teacher_id";
$stmt = $pdo->prepare($sql);
$stmt->execute([':teacher_id' => $teacher_id]);
$class = $stmt->fetch(PDO::FETCH_ASSOC);

$class_id = $class['id'] ?? null;
$class_name = $class['class_name'] ?? null;
$teacher_name = $class['teacher_name'] ?? null;

$sql = "SELECT * FROM attendance WHERE class_id = :class_id AND teacher_id = :teacher_id AND date = :date";
$stmt = $pdo->prepare($sql);
$stmt->execute([':class_id' => $class_id, ':teacher_id' => $teacher_id, ':date' => $date]);
$options = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <?php require_once('../includes/dashboard_header.php') ?>
</head>
<style>
  .modal-length-custom {
    max-width: 50% !important; 
  }
</style>

<body>
  <div class="wrapper">
    <!-- Sidebar -->
    <?php require_once('includes/sidebar.inc.php') ?>
    <!-- End Sidebar -->
    <div class="main-panel">
      <div class="container">
        <div class="page-inner">
          <input type="hidden" name="class_id" id="class_id" value="<?php echo $class_id; ?>">
          <div class="d-flex justify-content-between align-items-center">
          <h2>Class Attendance</h2>
          <button class="btn btn-outline-primary " id="editNewTimeSlotbtn" style="display: none;">Edit Today Attendance</button>
          <button class="btn btn-outline-primary" id="addNewTimeSlotbtn"> Add Today Attendance</button>
          </div>

          <hr>

          <!-- Attendance Modal -->
          <div class="modal fade" tabindex="-1" id="Attendance">
            <div class="modal-dialog modal-length-custom">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Class Attendance</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <?php
                // Fetch students of the class
                $sql = "SELECT student.* FROM class 
                        INNER JOIN student ON student.class_id = class.id 
                        WHERE class.teacher_id = :teacher_id";
                $sth = $pdo->prepare($sql);
                $sth->execute([':teacher_id' => $teacher_id]);
                $allRows = $sth->fetchAll(PDO::FETCH_ASSOC);
                ?>

                <form id="Attendance" method="post">
                  <div class="modal-body">
                    <input type="text" id="selected_date" class="form-control" name="date" readonly value="<?php echo $date; ?>">
                    <input type="hidden" name="class_id" value="<?php echo $class_id; ?>">
                    <input type="hidden" name="teacher_id" value="<?php echo $teacher_id; ?>">
                    <label for="class_name">Class Name:</label>
                    <input type="text" class="form-control" name="class_name" value="<?php echo $class_name; ?>" readonly>
                    <label for="teacher_name">Teacher Name:</label>
                    <input type="text" class="form-control" name="teacher_name" value="<?php echo $teacher_name; ?>" readonly>

                    <div class="table-responsive mt-3">
                      <table id="add-row" class="table table-striped table-hover">
                        <thead class="text-center">
                          <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Attendance</th>
                          </tr>
                        </thead>
                        <tbody class="text-center">
                          <?php foreach ($allRows as $Row): ?>
                            <?php
                              $student_id = $Row['id'];
                              $attendance_status = '';
                              foreach ($options as $option) {
                                  if ($option['student_id'] == $student_id) {
                                      $attendance_status = $option['status'];
                                      break;
                                  }
                              }
                            ?>
                            <tr>
                              <td><?php echo $Row['id']; ?></td>
                              <td><?php echo $Row['name']; ?></td>
                              <td>
                                <input type="radio" name="attendance[<?php echo $student_id; ?>]" value="Present" <?php echo ($attendance_status == 'Present') ? 'checked' : 'checked'; ?>> Present
                                <input type="radio" name="attendance[<?php echo $student_id; ?>]" value="Absent" <?php echo ($attendance_status == 'Absent') ? 'checked' : ''; ?>> Absent
                                <input type="radio" name="attendance[<?php echo $student_id; ?>]" value="Leave" <?php echo ($attendance_status == 'Leave') ? 'checked' : ''; ?>> Leave
                              </td>
                            </tr>
                          <?php endforeach; ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="modal-footer">
                  <?php if ($attendance_status): ?>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button name="AddSlot" class="btn btn-success">Save</button>
                  <?php else: ?>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button name="AddSlot" class="btn btn-primary">Submit Attendance</button>
                  <?php endif; ?>
                  </div>
                </form>
              </div>
            </div>
          </div>

          <div class="bg-light">
            <main class="ms-5 p-0">
              <div id="calendar"></div>
            </main>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php require_once('../includes/dashboard_footer.php') ?>
</body>
<script>
  $(document).ready(function() {
    $('#add-row').DataTable({
      pageLength: 5,
    });
  });
</script>
</html>
