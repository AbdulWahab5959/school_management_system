<?php
require_once('../includes/db.php');
require_once('includes/login_check.php');
$student_id = $_SESSION['student_id'];

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
        <?php
        require_once('includes/sidebar.inc.php')
        ?>

        <div class="main-panel">
            <?php
            require_once('includes/navbar.inc.php')
            ?>

            <div class="container">
                <div class="page-inner">

                    <div class="page-header">
                        <h3 class="fw-bold mb-3">Fees Details </h3>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <?php
                                    $s = "SELECT fees.*, class.name AS class_name, class.section AS class_section, student.name AS student_name, student.id AS student_id
                                            FROM fees
                                            INNER JOIN student ON fees.student_id = student.id
                                            INNER JOIN class ON student.class_id = class.id
                                            WHERE student.id = :student_id";
                                    $sth = $pdo->prepare($s);
                                    $sth->execute(['student_id' => $student_id]);
                                    $records = $sth->fetchAll(PDO::FETCH_ASSOC);

                                    ?>
                                    <div class="table-responsive">
                                        <table id="add-row" class="display table table-striped table-hover">
                                            <thead class="text-center">
                                                <tr>
                                                    <th>Fee ID</th>
                                                    <th>S.ID</th>
                                                    <th>S.Name</th>
                                                    <th>C.Name</th>
                                                    <th>Amount</th>
                                                    <th>Start_Date</th>
                                                    <th>End_Date</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody class="text-center">
                                                <?php foreach ($records as $Row): ?>
                                                    <tr>
                                                        <td><?php echo htmlspecialchars($Row['id']); ?></td>
                                                        <td><?php echo htmlspecialchars($Row['student_id']); ?></td>
                                                        <td><?php echo htmlspecialchars($Row['student_name']); ?></td>
                                                        <td><?php echo htmlspecialchars($Row['class_name'] . " " . $Row['class_section']); ?></td>
                                                        <td><?php echo htmlspecialchars($Row['class_fee']); ?></td>
                                                        <td><?php echo htmlspecialchars($Row['start_date']); ?></td>
                                                        <td><?php echo htmlspecialchars($Row['end_date']); ?></td>
                                                        <td>
                                                            <button class="btn btn-secondary pdf-btn"
                                                                data-id="<?php echo $Row['id']; ?>"
                                                                data-student-id="<?php echo $Row['student_id']; ?>"
                                                                data-student-name="<?php echo $Row['student_name']; ?>"
                                                                data-class-name="<?php echo $Row['class_name']; ?>"
                                                                data-class-section="<?php echo $Row['class_section']; ?>"
                                                                data-class-fee="<?php echo $Row['class_fee']; ?>"
                                                                data-start-date="<?php echo $Row['start_date']; ?>"
                                                                data-end-date="<?php echo $Row['end_date']; ?>">
                                                                PDF
                                                            </button>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>

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
    </div>
    <?php
    require_once('../includes/dashboard_footer.php')
    ?>
    <script>
        $(document).ready(function() {
            $(document).on('click', '.pdf-btn', function() {
                var feeData = {
                    id: $(this).data('id'),
                    student_id: $(this).data('student-id'),
                    student_name: $(this).data('student-name'),
                    class_name: $(this).data('class-name'),
                    class_section: $(this).data('class-section'),
                    class_fee: $(this).data('class-fee'),
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