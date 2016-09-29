<?php
include ('info.php');

if (isset($_POST['submit'])) {
	$license = $_POST['license'];
	$mileage = $_POST['mileage'];

	$query3 = mysql_query("SELECT * FROM document3 WHERE (license = '$license' AND mileage = '$mileage')")
	or die(mysql_error());

	if($query3 && mysql_num_rows($query3) > 0) {
	     $mileageErr = "* Kilometraje ya registrado en un certificado para ese vehículo. Revisar";
	}
}
?>