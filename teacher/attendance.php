<?php
require_once('../includes/db.php');
require_once('includes/login_check.php');

                  $teacher_id = $_SESSION['teacher_id'];
                  $sql = "SELECT class.id as id , class.name as class_name,  teacher.name AS teacher_name 
                  FROM class
                  LEFT JOIN teacher 
                  ON class.teacher_id = teacher.id
                  WHERE class.status=1 AND class.teacher_id=$teacher_id ";
                  $stmt = $pdo->prepare($sql);
                  $stmt->execute();
                  $class = $stmt->fetch(PDO::FETCH_ASSOC);

                  if ($class) {
                      $class_id = $class['id'];
                      $class_name = $class['class_name'];
                  }
                  $sql = "SELECT * FROM  teacher WHERE id = $teacher_id";
                  $stmt = $pdo->prepare($sql);
                  $stmt->execute();
                  $teacher = $stmt->fetch( );

                  if ($teacher) {
                      $teacher_name = $teacher['name'];
                  }
                  
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php require_once('../includes/dashboard_header.php') ?>


</head>
<style>
  .modal-length-custom{
    max-width: 50% !important; 
  }
</style>


<body>
  <div class="wrapper">
    <!-- Sidebar -->
    <?php require_once('includes/sidebar.inc.php') ?>
    <!-- End Sidebar -->
    <div class="main-panel">
      <!-- Dashboard started -->
      <div class="container">
    <div class="page-inner">
        <!-- <div id="content" class="p-4 p-md-5"> -->
            <h2>Class Attendance</h2>
            <hr>
            
            <!-- Add New Time Slot Modal -->
            <div class="modal fade" tabindex="-1" id="AddTimeSlotModal">
                <div class="modal-dialog modal-length-custom">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Class Attendance</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <?php
                        $current_date = date('Y-m-d');
                        $s = "SELECT student.*, class.id AS class_id, class.name AS class_name,
                        class.section AS class_section, class.teacher_id AS class_teacher_id 
                        FROM class 
                        INNER JOIN student ON student.class_id = class.id 
                        WHERE class.teacher_id = :teacher_id";
                        $sth = $pdo->prepare($s);
                        $sth->execute([':teacher_id' => $teacher_id]);
                        $allRows = $sth->fetchAll();
                        ?>
                        <form id="Attendance" method="post">
                            <div class="modal-body">
                                <input type="text" id="selected_date" class="form-control" name="date" readonly>
                                <input type="hidden" name="class_id" value="<?php echo  $class_id; ?>">
                                <input type="hidden" name="teacher_id" value="<?php echo  $teacher_id; ?>">
                                <label for="class_name">Class Name:</label>
                                <input type="text" class="form-control" name="class_name" value="<?php echo  $class_name; ?>" readonly>
                                <label for="teacher_name">Teacher Name:</label>
                                <input type="text" class="form-control" name="teacher_name" value="<?php echo  $teacher_name; ?>" readonly>

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
                                            <?php
                                            foreach ($allRows as $Row) {
                                                echo "<tr>";
                                                echo "<td>" . $Row['id'] . "</td>";
                                                echo "<td>" . $Row['name'] . "</td>";
                                                echo "<td>
                                                <input type='radio' name='attendance[" . $Row['id'] . "]' value='Present'> Present
                                                <input type='radio' name='attendance[" . $Row['id'] . "]' value='Absent'> Absent
                                                <input type='radio' name='attendance[" . $Row['id'] . "]' value='Leave'> Leave
                                                </td>";
                                                echo "</tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button name="AddSlot" class="btn btn-primary">Submit Attendance</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="bg-light">
                <button class="btn btn-outline-dark ms-3 mb-3 mt-3" id="switchToMonthButton" style="display: none;">Monthly View</button>
                <button class="btn btn-outline-primary ms-3 mb-3 mt-3" id="addNewTimeSlotbtn" style="display: none;">Add Today Attendance</button>
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

  