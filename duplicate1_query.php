<?php
include ('info.php');

if (isset($_POST['submit'])) {
	$license = $_POST['license'];
	$mileage = $_POST['mileage'];

	$query = mysql_query("SELECT * FROM document WHERE (license = '$license' AND mileage = '$mileage')")
	or die(mysql_error());

	if($query && mysql_num_rows($query) > 0) {
	     $mileageErr = "* Kilometraje ya registrado en un certificado para ese vehículo. Revisar";
	}
}
?>