<?php
require_once('../includes/db.php');
require_once('../tcpdf/tcpdf.php');

// School details
$school_name = 'Excellent Education System (Demo)';
$address = 'G-11 Markaz Islamabad';
$phone_number = 'Phone Number: 03114443493';

// Create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Fee Challan');
$pdf->SetSubject('Fee Challan');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// Add a page
$pdf->AddPage();

// Set font
$pdf->SetFont('helvetica', '', 10);

$html = "
<style>
    table {
        width: 100%;
        border-collapse: collapse;
    }
    .challan-copy {
        border: 1px solid black;
        padding: 4px;
    }
    th, td {
        border: 1px solid black;
        padding: 5px;
        text-align: left;
    }
    p {   
        text-align: center;
    }
    .center {
        text-align: center !important;
    }
    .bold {
        font-weight: bold;
    }
    .highlight {
        color: red;
    }
</style>

<table>
    <tr>
        <td class='challan-copy'>
                 <p>  <b> Bank Copy </b> </p>
            <p class='center bold'>$school_name</p>
            <p class='center'>$address</p>
            <p class='center'>$phone_number</p>

            <table>
                <tr><td class='bold'>Challan Form No:</td><td> <b>10 </b></td></tr>
                <tr><td class='bold'>Due Date:</td><td> <b>10-Nov-2020</b></td></tr>
                <tr><td class='bold'>Valid Till:</td><td> <b>30-Nov-2020 </b></td></tr>
                <tr><td class='bold'>Student Reg No:</td><td> <b>00126631</b></td></tr>
                <tr><td class='bold'>Student Name:</td><td> <b>Hadia Zahra</b></td></tr>
                <tr><td class='bold'>Class:</td><td> <b>9th - Quaid</b></td></tr>
            </table>

            <table>
                <tr><th>Description</th><th class='center'> <b>Amount</b></th></tr>
                <tr><td>Monthly fee</td><td class='center'> <b>1000</b></td></tr>
                <tr><td>Generator Fund</td><td class='center'> <b>100</b></td></tr>
                <tr><td>Previous Fee</td><td class='center'> <b>0</b></td></tr>
                <tr><td class='bold'>Total Fee</td><td class='center bold'> <b>1100</b></td></tr>
                <tr><td>Discount/Scholarship</td><td class='center'> <b>100</b></td></tr>
                <tr><td>Fee Within Due Date (Till 10-Nov-2020)</td><td class='center'> <b>1000</b></td></tr>
                <tr><td class='highlight bold'>Fee After Due Date (From 11-Nov-2020)</td><td class='center highlight bold'> <b>1000 </b></td></tr>
                <tr><td><b> Total Amount:</b> </td><td class='center'><b>1000 </b></td></tr>
            </table>
        </td>
    </tr>
</table>
";

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('FeeChallan.pdf', 'I');
?>
