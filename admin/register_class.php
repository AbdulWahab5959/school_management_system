<?php

require_once('../includes/db.php');

if (isset($_POST['submit'])) {
    if (isset($_POST['name'],  $_POST['fees'], $_POST['section'] ) &&  !empty($_POST['name']) && !empty($_POST['fees'])  && !empty($_POST['section'])) {

        $name = trim($_POST['name']);
        $fees = trim($_POST['fees']);
        $strength = trim($_POST['strength']);
        $section = trim($_POST['section']);
        $teacher = trim($_POST['teacher']);
        $date = date('Y-m-d H:i:s');

                $sql = 'SELECT * FROM class WHERE  name Like :name and section Like :section';
                $stmt = $pdo->prepare($sql);
                $p = [
                    'name' => $name,
                    'section' => $section
                    ];
                $stmt->execute($p);

              
                if ($stmt->rowCount() == 0) {
                    $sql = "INSERT INTO class (name, section, strength,  teacher_id,   fees, created_at, updated_at) 
                            VALUES (:name,  :section, :strength, :teacher_id,  :fees, :created_at, :updated_at)";
                    try {
                        $handle = $pdo->prepare($sql);
                        $params = [
                            ':name' => $name,
                            ':section' => $section,
                            ':strength' => $strength,
                            ':teacher_id' => $teacher,
                            ':fees' => $fees,
                            ':created_at' => $date,
                            ':updated_at' => $date
                        ];

                        $handle->execute($params);
                        $success[] = 'Class has been registered successfully';
                    } catch (PDOException $e) {
                        $errors[] = $e->getMessage();
                    }
                } 
                else
                {
                    $errors[] = 'Class already registered';   
                }
            } 
          
            else {
                    if (!isset($_POST['name']) || empty($_POST['name'])) {
                        $errors[] = 'Name is required';
                    }
            
                    if (!isset($_POST['fees']) || empty($_POST['fees'])) {
                        $errors[] = 'fees is required';
                    }  
                }
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
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title text-center ">Register Class Form </div>
                                </div>
                                <div class="card-body">
                                    <div class="row mx-auto d-flex justify-content-center">
                                        <?php
                                        if (isset($success) && count($success) > 0) {
                                            foreach ($success as $success_msg) {
                                                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">' .
                                                    $success_msg .
                                                    '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' .
                                                    '</div>';
                                            }
                                        }

                                        if (isset($errors) && count($errors) > 0) {
                                            foreach ($errors as $error_msg) {
                                                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">' .
                                                    $error_msg .
                                                    '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' .
                                                    '</div>';
                                            }
                                        }
                                        ?>
                                        <div class="col-md-4 col-lg-6">
                                            <form method="POST" enctype='multipart/form-data' action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                                <div class="form-group">
                                                    <label for="name">Name</label>
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        id="name"
                                                        name="name"
                                                        required
                                                        placeholder="Enter Name" />
                                                </div>

                                                <div class="form-group">
                                                    <label for="fees">Fees</label>
                                                    <input
                                                        type="number"
                                                        class="form-control"
                                                        id="fees"
                                                        name="fees"
                                                        min="1000"
                                                        max="5000"
                                                        required
                                                        placeholder="Enter Fees Between 1000 to 5000 " />
                                                    
                                                </div>
                                                <div class="form-group">
                                                    <label for="strength">Strength</label>
                                                    <input
                                                        type="number"
                                                        class="form-control"
                                                        id="strength"
                                                        name="strength"
                                                        min="20"
                                                        max="30"
                                                        required
                                                        placeholder="Enter strength Between 20 to 30 " />
                                                    
                                                </div>
                                                <div class="form-group">
                                                <label for="section">Choose a Section</label>
                                                <select class="form-select" name="section" id="section">
                                                <option value="A">A</option>
                                                    <option value="B">B</option>
                                                    <option value="C">C</option>
                                                    <option value="D">D</option>
                                                </select>
                                                </div>
                                                <?php
                                                    $s = "SELECT teacher.id, teacher.name 
                                                    FROM teacher  
                                                    LEFT JOIN class  
                                                    ON teacher.id = class.teacher_id 
                                                    WHERE class.teacher_id IS NULL";
                                                $sth = $pdo->prepare($s, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                                                $sth->execute();
                                                ?>
                                                
                                                <div class="form-group">
                                                    <label for="teacher">Choose a Teacher</label>

                                                    <select name="teacher" class="form-select">
                                                        <?php
                                                        if ($sth->rowCount() > 0) {
                                                            while ($row = $sth->fetch()){ 
                                                                echo "<option value='" . $row["id"] . "'>" . $row["name"] . "</option>";
                                                            }
                                                            echo "<option> Empty Teacher </option>";

                                                        } else {
                                                            echo "<option>No teachers available</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="card-action">
                                                    <button class="btn btn-success" type="submit" name="submit">Submit</button>
                                                </div>
                                        </div>
                                        </form>
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

</body>

</html>