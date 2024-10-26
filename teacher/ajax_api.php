<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function get_available_dates($conn){
    $availableDates = array();
    // Step 1: Select distinct IDs from the "slots" table
    // $sql = "SELECT DISTINCT date_id FROM slots WHERE `booking_status`=0";
    $sql = "SELECT DISTINCT date_id FROM slots";
    $result = $conn->query($sql);

    if ($result) {
        // Step 2: Fetch the distinct IDs
        while ($row = $result->fetch_assoc()) {
            $id = $row['date_id'];
    
            // Step 3: Retrieve relevant records from the "dates" table for each ID
            $datesSql = "SELECT * FROM dates WHERE id = ? AND `date` >= CURDATE()";
            $datesStmt = $conn->prepare($datesSql);
            
            if ($datesStmt) {
                // Bind the ID parameter
                $datesStmt->bind_param("i", $id);
                
                // Execute the query
                $datesStmt->execute();
                
                // Fetch and process the results for this ID
                $datesResult = $datesStmt->get_result();
                
                while ($datesRow = $datesResult->fetch_assoc()) {
                    // Process each row from the "dates" table
                    // You can access the data using $datesRow['column_name']
                    // Example: $date = $datesRow['date'];
                    array_push($availableDates,$datesRow['date']);
                }
                
                // Close the "dates" statement
                $datesStmt->close();
            } 
            // else {
            //     echo "Error preparing dates statement: " . $conn;
            // }
        }
    }
    return $availableDates;
}

// Define the conversation flow
$appointment_services = [
    'Blutabnahme',
    'Befundbesprechung',
    'Gynäkologische Untersuchung',
    'Gynäko - Onkologische Nachsorge',
    'Schwangerschaftsbetreuung',
    'Zytologie',
    'HPV Impfung'
  ];
  
$serviceDurations = [
    'Blutabnahme' => 30,
    'Befundbesprechung' => 30,
    'Gynäkologische Untersuchung' => 30,
    'Gynäko - Onkologische Nachsorge' => 30,
    'Schwangerschaftsbetreuung' => 45,
    'Zytologie' => 30,
    'HPV Impfung' => 15,
  ];

require_once('../db.php');
// Check if it's an AJAX request
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    // This is an AJAX request

    if (isset($_POST['edit_load_user_appointment'])) {
        $query =    "SELECT * FROM `time_slot_bookings` WHERE id={$_POST['appointment_id']}";
        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $query_user_data =    "SELECT * FROM `users` WHERE id={$row['user_id']}";
            $result_user_data = $conn->query($query_user_data);
            if ($result_user_data->num_rows > 0) {
                $row_user_data = $result_user_data->fetch_assoc();
                $fname            = $row_user_data['fname'];
                $lname            = $row_user_data['lname'];
                $telephone        = $row_user_data['telephone'];
                $email            = $row_user_data['email'];
                $service          = $row['service'];
                $date             = $row['date'];
                $slot_id          = $row['slot_id'];
                $slot_start       = $row['slot_start'];
                $slot_end         = $row['slot_end'];
                $form = "
                    <form method='post' action='appointments.php'>
                        <input type='hidden' name='appointment_id' value='{$row['id']}'>
                        <input type='hidden' class='form-control' name='date' id='add-form-date'>
                        <div class='modal-body'>
                            <h5>Client Details:</h5>
                            <hr>
                            <div class='row'>
                                <div class='col-sm-6'>
                                <label>First Name:</label>
                                <input type='text' class='form-control' name='fname' value='{$fname}' readonly>
                                </div>
                                <div class='col-sm-6'>
                                <label>Last Name:</label>
                                <input type='text' class='form-control' name='lname' value='{$lname}'  readonly>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-sm-6'>
                                <label>Telefon:</label>
                                <input type='text' class='form-control' name='telephone' value='{$telephone}'  readonly>
                                </div>
                                <div class='col-sm-6'>
                                <label>Email:</label>
                                <input type='email' class='form-control' name='email' value='{$email}'  readonly>
                                </div>
                            </div>
                            <h5 class='mt-3'>Appointment Details:</h5>
                            <hr>
                            <div class='row'>
                                <div class='col'>
                                    <label>Datum:</label>
                                    <input type='text' class='form-control datepicker' name='date' id='edit-form-date' value={$date}>
                                    <input type='hidden' class='form-control' name='slot_id' id='edit_slot_id'>
                                </div>
                                <div class='col'>
                                    <label>Dienstleistung:</label>
                                    <select class='form-select service-listener' name='service'>
                                        <option value='$appointment_services[0]'>$appointment_services[0]</option>
                                        <option value='$appointment_services[1]'>$appointment_services[1]</option>
                                        <option value='$appointment_services[2]'>$appointment_services[2]</option>
                                        <option value='$appointment_services[3]'>$appointment_services[3]</option>
                                        <option value='$appointment_services[4]'>$appointment_services[4]</option>
                                        <option value='$appointment_services[5]'>$appointment_services[5]</option>
                                        <option value='$appointment_services[6]'>$appointment_services[6]</option>
                                    </select>
                                </div>
                                <div class='col'>
                                    <label>Time Slot: <strong style='font-size:smaller'>({$slot_start} to {$slot_end})</strong></label>
                                    <select class='form-select' name='timeslot' id='edit-timeslot'>
                                </select> 
                                </div>
                            </div>
                        </div>
                        <!-- Modal footer -->
                        <div class='modal-footer justify-content-between'>
                            <div>
                            </div>
                            <div>
                                <button type='button' name class='btn btn-secondary' data-bs-dismiss='modal'>Schließen</button>
                                <button name='EditAppointment' class='btn btn-primary' type='submit'>Änderungen speichern</button>
                            </div>
                        </div>
                    </form>";
            }

        }
        $response = ["success" => true, "response" => $form];
        $return_data = $response;
    }else if (isset($_POST['edit_load_manual_appointment'])) {
        $query =    "SELECT * FROM `time_slot_bookings` WHERE id={$_POST['appointment_id']}";

        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $manual_data      = unserialize($row['manual_data']);
            $fname            = $manual_data['fname'];
            $lname            = $manual_data['lname'];
            $telephone        = $manual_data['telephone'];
            $email            = $manual_data['email'];
            $note             = $manual_data['note'];
            $slot_title       = $manual_data['slot_title'];
            $service          = $row['service'];
            $date             = $row['date'];
            $slot_id          = $row['slot_id'];
            $slot_start       = $row['slot_start'];
            $slot_end         = $row['slot_end'];
                $form = "
                    <form method='post' action='manual-apppointment.php'>
                        <input type='hidden' name='appointment_id' value='{$row['id']}'>
                        <div class='modal-body'>
                            <h5>Client Details:</h5>
                            <hr>
                            <div class='row'>
                                <div class='col-sm-6'>
                                <label>First Name:</label>
                                <input type='text' class='form-control' name='fname' value='{$fname}'>
                                </div>
                                <div class='col-sm-6'>
                                <label>Last Name:</label>
                                <input type='text' class='form-control' name='lname' value='{$lname}'>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-sm-6'>
                                <label>Telefon:</label>
                                <input type='text' class='form-control' name='telephone' value='{$telephone}'>
                                </div>
                                <div class='col-sm-6'>
                                <label>Email:</label>
                                <input type='email' class='form-control' name='email' value='{$email}'>
                                </div>
                            </div>
                            <label>Note:</label>
                            <textarea name='note' class='form-control' id='note' rows='2'>{$note}</textarea>
                            <h5 class='mt-3'>Appointment Details:</h5>
                            <hr>
                            <label>Zeitfenster Name:</label>
                            <input type='text' class='form-control' name='slot_title' placeholder='Title' value='{$slot_title}'>
                            <div class='row'>
                                <div class='col'>
                                    <label>Datum:</label>
                                    <input type='text' class='form-control datepicker' name='date' id='edit-form-date' value={$date}>
                                    <input type='hidden' class='form-control' name='slot_id' id='edit_slot_id'>
                                </div>
                                <div class='col'>
                                    <label>Dienstleistung:</label>
                                    <select class='form-select service-listener' name='service'>
                                        <option value='$appointment_services[0]'>$appointment_services[0]</option>
                                        <option value='$appointment_services[1]'>$appointment_services[1]</option>
                                        <option value='$appointment_services[2]'>$appointment_services[2]</option>
                                        <option value='$appointment_services[3]'>$appointment_services[3]</option>
                                        <option value='$appointment_services[4]'>$appointment_services[4]</option>
                                        <option value='$appointment_services[5]'>$appointment_services[5]</option>
                                        <option value='$appointment_services[6]'>$appointment_services[6]</option>
                                    </select>
                                </div>
                                <div class='col'>
                                    <label>Time Slot: <strong style='font-size:smaller'>({$slot_start} to {$slot_end})</strong></label>
                                    <select class='form-select' name='timeslot' id='edit-timeslot'>
                                </select> 
                                </div>
                            </div>
                        </div>
                        <!-- Modal footer -->
                        <div class='modal-footer justify-content-between'>
                            <div>
                            </div>
                            <div>
                                <button type='button' name class='btn btn-secondary' data-bs-dismiss='modal'>Schließen</button>
                                <button name='EditAppointment' class='btn btn-primary' type='submit'>Änderungen speichern</button>
                            </div>
                        </div>
                    </form>";
        }
        $response = ["success" => true, "response" => $form];
        $return_data = $response;
    } else if (isset($_POST['delete_user_appointment'])) {
        $appointment_id = $_POST['appointment_id'];
        $delete_Query = "DELETE FROM `time_slot_bookings` WHERE id={$appointment_id}";

        if ($conn->query($delete_Query) === TRUE) {
            $response = ['success' => true, "message" => "Appointment Deleted"];
        } else {
            $errormsg = "Error deleting record: " . $conn->error;
            $response = ['success' => false, "message" => $errormsg];
        }
        $return_data = $response;
    } else if (isset($_POST['delete_manual_appointment'])) {
        $appointment_id = $_POST['appointment_id'];
        $delete_Query = "DELETE FROM `time_slot_bookings` WHERE id={$appointment_id}";

        if ($conn->query($delete_Query) === TRUE) {
            $response = ['success' => true, "message" => "Appointment Deleted"];
        } else {
            $errormsg = "Error deleting record: " . $conn->error;
            $response = ['success' => false, "message" => $errormsg];
        }
        $return_data = $response;
    } else if (isset($_POST['view_manual_appointment'])) {
        $appointment_id = $_POST['appointment_id'];

        $query =    "SELECT * FROM `time_slot_bookings` WHERE id={$appointment_id}";

        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $manual_data      = unserialize($row['manual_data']);
                $fname            = $manual_data['fname'];
                $lname            = $manual_data['lname'];
                $telephone        = $manual_data['telephone'];
                $email            = $manual_data['email'];
                $note             = $manual_data['note'];
                $slot_title       = $manual_data['slot_title'];
                $service          = $row['service'];
                $date             = $row['date'];
                $slot_start       = $row['slot_start'];
                $slot_end         = $row['slot_end'];


                $table_responsive = "<table class='table table-bordered'>
                <tr>
                    <th>Name:</th>
                    <td>{$fname} {$lname} </td>
                </tr>
                <tr>
                    <th>Datum:</th>
                    <td>{$date} </td>
                </tr>
                <tr>
                    <th>Appointment time:</th>
                    <td>{$slot_start} bis {$slot_end} </td>
                </tr>
                <tr>
                    <th>Dienstleistung:</th>
                    <td>{$service} </td>
                </tr>
                <tr>
                    <th>Telefon:</th>
                    <td>{$telephone} </td>
                </tr>
                <tr>
                    <th>Email:</th>
                    <td>{$email} </td>
                </tr>
                <tr>
                    <th colspan='2' class='text-center'>Note</th>
                </tr>
                <tr>
                    <td colspan='2'>{$note} </td>
                </tr>
                </table>";
            }
            $response = ["success" => true, "response" => $table_responsive];
        } else {
            // User with this email already exists
            $response = ["success" => false, "response" => "<div class='alert alert-danger'><strong>Error!</strong> Some problem occured while fetching apppointment data.</div>" . $query];
        }

        $return_data = $response;
    } else if (isset($_POST['appointment_id'])) {
        $appointment_id = $_POST['appointment_id'];

        // $query = "
        //             SELECT 
        //                     u.fname AS user_fname,
        //                     u.lname AS user_lname,
        //                     u.telephone AS user_telephone,
        //                     u.email,
        //                     u.street_name,
        //                     u.house_no,
        //                     u.zip_code,
        //                     u.city_name,
        //                     a.id,
        //                     a.service,
        //                     a.date
        //             FROM 
        //                     users AS u
        //             INNER JOIN 
        //                     appointments AS a
        //             ON 
        //                     u.id = a.user_id
        //             WHERE 
        //                     a.id = {$appointment_id};
        //         ";
        $query =    "SELECT `time_slot_bookings`.`service`,
                            `time_slot_bookings`.`date`,
                            `time_slot_bookings`.`slot_id`,
                            `time_slot_bookings`.`slot_start`,
                            `time_slot_bookings`.`slot_end`,
                            `time_slot_bookings`.`user_id`,
                            `time_slot_bookings`.`id`,
                            `users`.`fname`,
                            `users`.`lname`,
                            `users`.`telephone`,
                            `users`.`street_name`,
                            `users`.`house_no`,
                            `users`.`zip_code`,
                            `users`.`city_name`,
                            `users`.`email`,
                            `slots`.`time_start`,
                            `slots`.`time_end`,
                            `slots`.`slot_title`
                    FROM `time_slot_bookings`,`users`,`slots`
                    WHERE `users`.`id`=`time_slot_bookings`.`user_id` 
                    AND `slots`.`id`=`time_slot_bookings`.`slot_id`
                    AND `time_slot_bookings`.`id` = {$appointment_id}";

        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $time_start = date('H:i', strtotime($row['slot_start']));
                $time_end = date('H:i', strtotime($row['slot_end']));
                // $time_start = date('h:i A', strtotime($row['slot_start']));
                // $time_end = date('h:i A', strtotime($row['slot_end']));
                $table_responsive = "<table class='table table-bordered'>
                <tr>
                    <th>Name:</th>
                    <td>{$row['fname']} {$row['lname']} </td>
                </tr>
                <tr>
                    <th>Datum:</th>
                    <td>{$row['date']} </td>
                </tr>
                <tr>
                    <th>Appointment time:</th>
                    <td>{$time_start} to {$time_end} </td>
                </tr>
                <tr>
                    <th>Dienstleistung:</th>
                    <td>{$row['service']} </td>
                </tr>
                <tr>
                    <th>Telefon:</th>
                    <td>{$row['telephone']} </td>
                </tr>
                <tr>
                    <th>Email:</th>
                    <td>{$row['email']} </td>
                </tr>
                <tr>
                    <th>Street Name:</th>
                    <td>{$row['street_name']} </td>
                </tr>
                <tr>
                    <th>House no:</th>
                    <td>{$row['house_no']} </td>
                </tr>
                <tr>
                    <th>Zip code:</th>
                    <td>{$row['zip_code']} </td>
                </tr>
                <tr>
                    <th>City Name:</th>
                    <td>{$row['city_name']} </td>
                </tr>
                </table>";
            }
            $response = ["success" => true, "response" => $table_responsive];
        } else {
            // User with this email already exists
            $response = ["success" => false, "response" => "<div class='alert alert-danger'><strong>Error!</strong> Some problem occured while fetching apppointment data.</div>" . $query];
        }

        $return_data = $response;
    } else if (isset($_POST["action"]) && $_POST["action"] === "loadCalendar") {
        $response = array();
        // Check if the date exists in the database
        $timeslot_Query = "SELECT * FROM slots WHERE 1";

        $timeslot_result = $conn->query($timeslot_Query);

        if ($timeslot_result->num_rows > 0) {
            while ($timeslot_row = $timeslot_result->fetch_assoc()) {

                $slot_arr = [];

                $time_start                    = $timeslot_row['time_start'];
                $time_end                      = $timeslot_row['time_end'];

                $slot_arr['id']                = $timeslot_row['id'];
                $slot_arr['title']             = $timeslot_row['slot_title'];
                $slot_arr['backgroundColor']   = $timeslot_row['slot_background_clr'];
                $slot_arr['textColor']         = $timeslot_row['slot_text_clr'];

                $date_id = $timeslot_row['date_id'];

                $date_Query = "SELECT * FROM dates WHERE id={$date_id}";
                $date_result = $conn->query($date_Query);
                if ($date_result->num_rows > 0) {
                    $date_row = $date_result->fetch_assoc();
                    $date = $date_row['date'];
                }

                $slot_arr['start']         = $date . "T" . $time_start;
                $slot_arr['end']           = $date . "T" . $time_end;

                $response[] = $slot_arr;
            }
        }

        $return_data = $response;
    } else if (isset($_POST["action"]) && $_POST["action"] === "DeleteTimeSlot") {

        $delete_id = $_POST['slot_id'];
        // Check if the date exists in the database
        $delete_Query = "DELETE FROM `slots` WHERE id={$delete_id}";

        if ($conn->query($delete_Query) === TRUE) {
            $response = ['success' => true, "message" => "Zeitfenster gelöscht"];
        } else {
            $errormsg = "Error deleting record: " . $conn->error;
            $response = ['success' => false, "message" => $errormsg];
        }
        $return_data = $response;
    } else if (isset($_POST["addNewSlotFormSubmit"]) && $_POST["addNewSlotFormSubmit"] === "addNewSlotFormSubmit") {
        // $response = [];
        // $response = $_POST;

        $date           = $_POST['date'];

        // echo "date:".$date."<br>";


        $slot_title     = $_POST['slot_title'];
        $start_hour     = is_numeric($_POST['start_hour'])?$_POST['start_hour']:0;
        $start_minute   = is_numeric($_POST['start_minute'])?$_POST['start_minute']:0;
        $slot_start     = $start_hour . ":" . $start_minute;
        
        $end_hour       = is_numeric($_POST['end_hour'])?$_POST['end_hour']:0;
        $end_minute     = is_numeric($_POST['end_minute'])?$_POST['end_minute']:0;
        $slot_end       = $end_hour . ":" . $end_minute;

        $background_clr = $_POST['background_clr'];
        $text_clr       = $_POST['text_clr'];

        // Check if the date exists in the database
        $date_Query = "SELECT * FROM dates WHERE `date`='{$date}'";

        $date_result = $conn->query($date_Query);

        if ($date_result->num_rows > 0) {
            $date_row = $date_result->fetch_assoc();

            $dateID =  $date_row['id'];
            $insertQuery = "INSERT INTO slots (`time_start`, `time_end`, `slot_title`, `slot_background_clr`, `slot_text_clr`, `date_id`) 
            VALUES (?, ?, ?, ?, ?, ?)";
            $insertStmt = $conn->prepare($insertQuery);
            $insertStmt->bind_param("sssssi", $slot_start, $slot_end, $slot_title, $background_clr, $text_clr, $dateID);
            $insertStmt->execute();
            $insertStmt->close();

            // $response = [];
            $response = ['success' => true, "message" => "New Time slot added"];
        } else {
            // Date doesn't exist, insert new record
            $insertQuery = "INSERT INTO dates (date) VALUES (?)";
            $insertStmt = $conn->prepare($insertQuery);
            $insertStmt->bind_param("s", $date);
            $insertStmt->execute();
            $insertStmt->close();

            $dateID = $conn->insert_id;

            $insertQuery = "INSERT INTO slots (`time_start`, `time_end`, `slot_title`, `slot_background_clr`, `slot_text_clr`, `date_id`) 
                            VALUES (?, ?, ?, ?, ?, ?)";
            $insertStmt = $conn->prepare($insertQuery);
            $insertStmt->bind_param("sssssi", $slot_start, $slot_end, $slot_title, $background_clr, $text_clr, $dateID);
            $insertStmt->execute();
            $insertStmt->close();

            $response = ['success' => true, "message" => "New date inserted and time slot added"];
        }

        $return_data = $response;
    } else if (isset($_POST["editTimeSlotFormSubmit"]) && $_POST["editTimeSlotFormSubmit"] === "editTimeSlotFormSubmit") {
        // $response = [];
        // $response = $_POST;

        $editTimeSlotID = $_POST['editTimeSlotID'];
        $date           = $_POST['date'];
        $slot_title     = $_POST['slot_title'];
        
        $start_hour     = is_numeric($_POST['start_hour'])?$_POST['start_hour']:0;
        $start_minute   = is_numeric($_POST['start_minute'])?$_POST['start_minute']:0;
        $slot_start     = $start_hour . ":" . $start_minute;
        
        $end_hour       = is_numeric($_POST['end_hour'])?$_POST['end_hour']:0;
        $end_minute     = is_numeric($_POST['end_minute'])?$_POST['end_minute']:0;
        $slot_end       = $end_hour . ":" . $end_minute;

        $background_clr = $_POST['background_clr'];
        $text_clr       = $_POST['text_clr'];

        $updateQuery = "UPDATE slots SET 
                                `time_start`= ?,
                                `time_end`= ?,
                                `slot_title`= ?,
                                `slot_background_clr`= ?,
                                `slot_text_clr`= ?
                            WHERE id = ?";

        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bind_param("sssssi", $slot_start, $slot_end, $slot_title, $background_clr, $text_clr, $editTimeSlotID);
        $updateResult = $updateStmt->execute();
        if ($updateResult === TRUE) {
            // Update was successful
            $response = ['success' => true, "message" => "Time slot edited successfully!"];
        } else {
            // Update failed
            $error_update = "Error: " . $conn->error;
            $response = ['success' => false, "message" => $error_update];
        }


        $updateStmt->close();
        $return_data = $response;
    } else if (isset($_POST["load_time_slots"])) {
        $appointment_date   = $_POST['date']==''?$_POST['editDate']:$_POST['date'];
        $form_type         = $_POST['date']==''?'edit':'add';
        $serviceType        = $_POST['service'];
        $serviceDuration    = $serviceDurations[$serviceType];
        $dates_sql = "SELECT * FROM dates WHERE `date` = ?";
        $stmt = $conn->prepare($dates_sql);
        $stmt->bind_param("s", $appointment_date);
        $stmt->execute();
        $dates_result = $stmt->get_result();

        $bookedSlots = array();
        if ($dates_result->num_rows === 1) {
            $dates_row = $dates_result->fetch_assoc();
            $date_id = $dates_row['id'];
            $slots_sql = "SELECT * FROM slots WHERE `date_id` = ?";
            $stmt = $conn->prepare($slots_sql);
            $stmt->bind_param("i", $date_id);
            $stmt->execute();
            $slots_result = $stmt->get_result();
            $slots_row = $slots_result->fetch_assoc();
    
            $slot_id   = $slots_row['id'];
            $startTime = $slots_row['time_start'];
            $endTime   = $slots_row['time_end'];
            // $slots_sql = "SELECT * FROM time_slot_bookings WHERE `slot_id` = ?";
            $slots_sql = "SELECT * FROM time_slot_bookings WHERE `date` = ?";
            $stmt = $conn->prepare($slots_sql);
            // $stmt->bind_param("i", $slot_id);
            $stmt->bind_param("s", $appointment_date);
            $stmt->execute();
            $slots_result = $stmt->get_result();
            if ($slots_result->num_rows > 0) {
                while($slots_row = $slots_result->fetch_assoc()){
                    $booking_id  = $slots_row['id'];
                    $slot_start  = $slots_row['slot_start'];
                    $slot_end    = $slots_row['slot_end'];
                    $slot_end    = strtotime($slot_end);
                    $slot_end    = date('H:i', $slot_end);
                    $slot_start  = strtotime($slot_start);
                    $slot_start  = date('H:i', $slot_start);
                    $bookedSlots[$slot_start] = $slot_end;
                }
            }
    
            // echo "<pre>";
            // print_r($bookedSlots);
            // echo "</pre>";

            // echo "<br>serviceDuration:".$serviceDuration;
            // echo "<br>endTime:".$endTime;

            $_options = "";
            $currentTime    = strtotime($startTime);
            while ($currentTime <= strtotime($endTime)) {
                $slotStart = date('H:i', $currentTime);
                // echo "<br>slotStart:".$slotStart;
                $slotEnd = date('H:i', $currentTime + $serviceDuration * 60);
                // echo "<br>slotEnd:".$slotEnd;

                /* 
                 Breaking the loop here if endTime goes beyong the main slot's end time
                 e.g : Main slot (02:00 to 15:00) then Loop breaks to prevent making slots of 15:05,15:10,15:15 etc
                */
                if(strtotime($slotEnd)>strtotime($endTime))
                {
                    // print "endTime : ".strtotime($endTime)." | slotStart : ".strtotime($slotStart)." | slotEnd : ".strtotime($slotEnd)."<br>";
                    // print "endTime : ".$endTime." | slotStart : ".$slotStart." | slotEnd : ".$slotEnd."<br>";
                    break;
                }

                $continue_flag = 0;
                foreach ($bookedSlots as $start => $end) {
                    $fo_booked_start = strtotime($start);
                    $fo_booked_end   = strtotime($end);
                    $fo_slot_start   = strtotime($slotStart);
                    $fo_slot_end     = strtotime($slotEnd);
                    if($fo_slot_start > $fo_booked_start && $fo_slot_start < $fo_booked_end)
                    {
                        $continue_flag = 1;
                    }
                    elseif($fo_slot_end > $fo_booked_start && $fo_slot_end < $fo_booked_end)
                    {
                        $continue_flag = 1;
                    } elseif ($fo_slot_start <= $fo_booked_start && $fo_slot_end >= $fo_booked_end)
                    {
                        $continue_flag = 1;
                    }
                }
                if($continue_flag == 1)
                {
                    $continue_flag == 0;
                    // $currentTime += $serviceDuration * 60;
                    $currentTime += 5 * 60;
                    continue;
                }
                if (!isset($bookedSlots[$slotStart])) {
                    if($endTime == $slotStart.":00")
                    {
                        break;
                    }
                    $_options .= "<option value='{$slotStart} to {$slotEnd}'>{$slotStart} to {$slotEnd}</option>";
                    // $currentTime += $serviceDuration * 60;
                    $currentTime += 5 * 60;
                }
                else{
                    $slotStart = $bookedSlots[$slotStart];
                    $currentTime = strtotime($slotStart);
                }
            }
        $slots = "<select name='edited_slot' class='form-select mt-3'>
                    {$_options}
                    </select>";
        }
        $response = ["success" => true , "response" => $slots , "slot_id" => $slot_id, "form_type" => $form_type];
        $return_data = $response;

    } else if (isset($_POST["load_dates"])) {
        $availableDates = get_available_dates($conn);
        $return_data = ["availableDates" => $availableDates];
    } else if ($_POST["action"] === "getUnavailableDates") {
        $unavailableDates = array();

        // Query to select unavailable dates
        $query = "SELECT date FROM dates_availability WHERE availability = 0";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Store each unavailable date in the array
                $unavailableDates[] = $row["date"];
            }
        }

        $return_data = $unavailableDates;
    }
} else {
    // Not an AJAX request
    $response = array(
        'status' => 'error',
        'response' => 'Not an AJAX request'
    );

    $return_data = $response;
}


header('Content-Type: application/json');
echo json_encode($return_data);

// Close the database connection
$conn->close();
