<?php
require_once('../includes/db.php');
require_once('includes/login_check.php');

require_once('../tcpdf/tcpdf.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $student_id = $_POST['student_id'];
    $student_name = $_POST['student_name'];
    $class_name = $_POST['class_name'];
    $class_section = $_POST['class_section'];
    $class_fee = $_POST['class_fee'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $school_name = 'IMS Education System';
    $address = 'G-11 D-Chowk Islamabad';
    $phone_number = 'Phone Number: 0311234567';
    $generator_fund = 100;
    $library_fund = 200;
    $fund_amount = $generator_fund + $library_fund;
    $total_amount = $class_fee + $generator_fund + $library_fund;

    // Create new PDF document
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Your Name');
    $pdf->SetTitle('Fee Challan');
    $pdf->SetSubject('Fee Challan');
    $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

    $pdf->AddPage();

    // Set font
    $pdf->SetFont('helvetica', '', 10);

    $html_bank_copy = "
<style>
    table {
        width: 100%;
        border-collapse: collapse;
    }
    .challan-copy {
        border: 1px solid black;
    }
    th, td {
        border: 1px solid black;
        text-align: left;
        height: 15px;
    }
    p {   
        text-align: center;
    }
    h3, h2 {   
        text-align: center;
        margin: 0px;
        padding: 0px;
    }
    span {
        text-align: center !important;
    }
    .bold {
        font-weight: bold;
        width: 100%;
    }
    .highlight {
        color: red;
    }
</style>

<table style='width: 100%;'>
    <tr>
        <td class='challan-copy'>
            <span>
                <h3>Bank Copy</h3>
                <h4>$school_name</h4><br> 
                $address<br>  
                $phone_number<br>
            </span> 
            <table>
                <tr><td class='bold' style='width: 70%;'>Challan Form No:</td><td style='width: 30%;'><b>$id</b></td></tr>
                <tr><td class='bold'>Due Date:</td><td><b>$start_date</b></td></tr>
                <tr><td class='bold'>Last Date:</td><td><b>$end_date</b></td></tr>
                <tr><td class='bold'>Student Reg No:</td><td><b>$student_id</b></td></tr>
                <tr><td class='bold'>Student Name:</td><td><b>$student_name</b></td></tr>
                <tr><td class='bold'>Class:</td><td><b>$class_name $class_section</b></td></tr>
            </table>
            <table>
                <tr><td>Monthly fee</td><td class='center'><b>$class_fee</b></td></tr>
                <tr><td>Generator Fund + Library Fund</td><td class='center'><b> $fund_amount</b></td></tr>
                <tr><td><b>Total Amount:</b></td><td class='center'><b>$total_amount</b></td></tr>
            </table>
        </td>
    </tr>
</table>
";

    $html_student_copy = str_replace("Bank Copy", "Student Copy", $html_bank_copy);
    $html_school_copy = str_replace("Bank Copy", "School Copy", $html_bank_copy);

    // Style for dotted line
    $style = array('width' => 0.6, 'dash' => '3,3', 'color' => array(0, 0, 0));
    $pdf->SetLineStyle($style);

    // Output the HTML content for each copy
    $pdf->writeHTML($html_bank_copy, true, false, true, false, '');
    $pdf->Ln(3);
    $pdf->Line(0, $pdf->GetY() - 1.5, 220, $pdf->GetY() - 1.5);
    $pdf->Ln(3);
    $pdf->writeHTML($html_student_copy, true, false, true, false, '');
    $pdf->Ln(3);
    $pdf->Line(0, $pdf->GetY() - 1.5, 220, $pdf->GetY() - 1.5);
    $pdf->Ln(3);
    $pdf->writeHTML($html_school_copy, true, false, true, false, '');

    $pdf->Output('FeeChallan.pdf', 'I');
}
?>
