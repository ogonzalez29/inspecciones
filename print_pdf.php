<?php
//Verify if session started, else redirect to login.php
session_start();
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
	// 'margin-top' => 20, //Change margin values to proper display. It depends on server
	// 'margin-bottom' => 30, //Change margin values to proper display. It depends on server
	));

$pdf->addPage('localhost/control-calidad/printcc.html');
//webserver
// $pdf->addPage('/home/servital/public_html/control-calidad/printcc.html');

// On some systems you may have to set the path to the wkhtmltopdf executable
$pdf->binary = 'C:\Archivos de programa\wkhtmltopdf\bin\wkhtmltopdf.exe';
//webserver
// $pdf->binary = '/home/servital/wkhtmltox/bin/wkhtmltopdf';

@$search = $_SESSION['cons'];
@$doc1 = $_POST['doc1'];

//get last results from database if recently submitted
$result = mysql_query("SELECT * FROM document ORDER BY id DESC LIMIT 1")
	or die(mysql_error());

if (!empty($search)) {
	$result = mysql_query("SELECT * FROM document WHERE id = '$doc1'")
		or die(mysql_error());

	//If there's no information in database from search query
	if (mysql_num_rows($result) == 0) {
		die('No hay información con ese criterio de búsqueda');
	}
}	

//loop through results of database query, displaying them in the format
while ($row = mysql_fetch_array($result)) {

	$doc1 = $row['id']+1000;
	$license = $row['license'];
	$day = $row['day'];
	$month = $row['month'];
	$year = $row['year']-2000;

	if (!$pdf->send($doc1.'_'.$license.'_'.$day.$month.$year.'.pdf')) {
	    echo $pdf->getError();
	}
}
?>