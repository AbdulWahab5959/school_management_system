<?php
require_once('../includes/db.php');
require_once('../tcpdf/tcpdf.php');

$school_name = 'IMS Education System';
$address = 'G-11 D-Chowk Islamabad';
$phone_number = 'Phone Number: 0311234567';

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
                <tr><td class='bold' style='width: 70%;'>Challan Form No:</td><td style='width: 30%;'><b>10</b></td></tr>
                <tr><td class='bold'>Due Date:</td><td><b>10-Nov-2020</b></td></tr>
                <tr><td class='bold'>Valid Till:</td><td><b>30-Nov-2020</b></td></tr>
                <tr><td class='bold'>Student Reg No:</td><td><b>00126631</b></td></tr>
                <tr><td class='bold'>Student Name:</td><td><b>Hadia Zahra</b></td></tr>
                <tr><td class='bold'>Class:</td><td><b>9th - Quaid</b></td></tr>
            </table>
            <table>
                <tr><td>Monthly fee</td><td class='center'><b>1000</b></td></tr>
                <tr><td>Generator Fund</td><td class='center'><b>100</b></td></tr>
                <tr><td><b>Total Amount:</b></td><td class='center'><b>1100</b></td></tr>
            </table>
        </td>
    </tr>
</table>
";

$html_student_copy = str_replace("Bank Copy", "Student Copy", $html_bank_copy);
$html_school_copy = str_replace("Bank Copy", "School Copy", $html_bank_copy);

$style = array('width' => 0.6, 'dash' => '3,3', 'color' => array(0, 0, 0));
$pdf->SetLineStyle($style);

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
?>
