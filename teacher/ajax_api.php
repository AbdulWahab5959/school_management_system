<?php
require_once('../includes/db.php');

if (isset($_POST['date'])) {
    $teacher_id = $_POST['teacher_id'];
    $class_id = $_POST['class_id'];
    $date = $_POST['date'];
    $attendance_records = $_POST['attendance'];
    $created_at = date('Y-m-d H:i:s');
    $updated_at = date('Y-m-d H:i:s');
    $checkdate = date('Y-m-d');
    if($date==$checkdate) {

    if (!empty($attendance_records)) {
        $s = "SELECT student.id 
              FROM student 
              INNER JOIN class ON student.class_id = class.id 
              WHERE class.teacher_id = :teacher_id";
        $sth = $pdo->prepare($s);
        $sth->execute([':teacher_id' => $teacher_id]);
        $allStudents = $sth->fetchAll(PDO::FETCH_ASSOC);
    
        $AttendanceMarked = count($allStudents) === count($attendance_records);
    
        if (!$AttendanceMarked) {
          echo json_encode(['status' => 'error' , "message" => 'Please mark attendance for all students.']);
        } else {
          $sql = "SELECT * FROM attendance WHERE class_id = ? AND date = ?";
          $stmt = $pdo->prepare($sql);
          $stmt->execute([$class_id, $date]);
          $attendance = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
          if ($attendance) {
            echo json_encode(['status' => 'error', "message" => 'Attendance Already Completed.']);
        } else {
            
            foreach ($attendance_records as $student_id => $status) {
                $sql = "INSERT INTO attendance (class_id, teacher_id, student_id, date, status, created_at, updated_at)
                VALUES (:class_id, :teacher_id, :student_id, :date, :status, :created_at, :updated_at)";
        $stmt = $pdo->prepare($sql);
        $params = [
            ':class_id' => $class_id,
            ':teacher_id' => $teacher_id,
            ':student_id' => $student_id,
            ':date' => $date,
            ':status' => $status,
            ':created_at' => $created_at,
            ':updated_at' => $updated_at
        ];
        $stmt->execute($params);
    }
    echo json_encode(['status' => 'success' , "message" => ' Attendance  completed']);
}
}
}
else {
    echo json_encode(['status' => 'error', "message" => ' Attendance checks not completed']);
}
}
else {
    echo json_encode(['status' => 'error', "message" => ' Only Today Attendance Can Be Sunmitted']);
}
        }
?>
