<?php
//Verify if session started, else redirect to login.php
if(!isset($_SESSION)) { 
    session_start(); 
} 
if (!$_SESSION['logged']) {
	header("Location: login.php");
	exit;
}
//Connect to the database
include ('info.php');
// include ('print_cc.php');

//Include the autoloader
require '../phpwkhtmltopdf/vendor/autoload.php';
//webserver
// require '../../phpwkhtmltopdf/vendor/autoload.php';

use mikehaertl\wkhtmlto\Pdf;

// You can pass a filename, a HTML string, an URL or an options array to the constructor
$pdf = new Pdf(array(
	'page-size' => 'Letter',
	'margin-top'    => 10,
    'margin-right'  => 0,
    'margin-bottom' => 10,
    'margin-left'   => 0,
	));

$pdf->addPage('localhost/inspecciones/printi.html');
//webserver
// $pdf->addPage('/home/servital/public_html/control-calidad/printcc.html');

// On some systems you may have to set the path to the wkhtmltopdf executable
$pdf->binary = 'C:\Program Files\wkhtmltopdf\bin\wkhtmltopdf.exe';
//webserver
// $pdf->binary = '/home/servital/wkhtmltox/bin/wkhtmltopdf';

@$search3 = $_SESSION['cons3'];
@$doc4 = $_POST['doc4'];

//get last results from database if recently submitted
$result3 = mysql_query("SELECT * FROM document3 ORDER BY id DESC LIMIT 1")
	or die(mysql_error());

if (!empty($search3)) {
	$result3 = mysql_query("SELECT * FROM document3 WHERE id = '$doc4'")
		or die(mysql_error());

	//If there's no information in database from search query
	if (mysql_num_rows($result3) == 0) {
		die('No hay información con ese criterio de búsqueda');
	}
}	

//loop through results of database query, displaying them in the format
while ($row3 = mysql_fetch_array($result3)) {

	$doc4 = $row3['id']+3000;
	$license = $row3['license'];
	$day = $row3['day'];
	$month = $row3['month'];
	$year = $row3['year']-2000;

	if (!$pdf->send($doc4.'_'.$license.'_'.$day.$month.$year.'.pdf')) {
	    echo $pdf->getError();
	}

	$pdf->saveAs('C:/Temp/'.$doc4.'_'.$license.'_'.$day.$month.$year.'.pdf');
}
?>