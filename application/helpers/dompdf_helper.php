<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH."third_party/Dompdf/autoload.inc.php");
// reference the Dompdf namespace
use Dompdf\Dompdf;
function pdf_create($html) 
{

// instantiate and use the dompdf class
$dompdf = new Dompdf();
$dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'landscape');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream();
}
function pdf_save_in_server($html,$pdf_name) 
{

// instantiate and use the dompdf class
$dompdf = new Dompdf();
$dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'landscape');

// Render the HTML as PDF
$dompdf->render();

$pdf = $dompdf->output();

$file_location = "/home/safety/public_html/Report_pdf/".$pdf_name.".pdf";
file_put_contents($file_location,$pdf);

// Output the generated PDF to Browser
$dompdf->stream();
}

function pdf_save_in_server_for_json($html,$pdf_name) 
{

// instantiate and use the dompdf class
$dompdf = new Dompdf();
$dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'landscape');

// Render the HTML as PDF
$dompdf->render();

$pdf = $dompdf->output();

$file_location = "/home/safety/public_html/uploads/pdf/".$pdf_name.".pdf";
file_put_contents($file_location,$pdf);

// Output the generated PDF to Browser
//$dompdf->stream();
}






?>
