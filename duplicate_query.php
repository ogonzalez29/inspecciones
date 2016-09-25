<?php
include ('info.php');

if (isset($_POST['submit'])) {
	$order = $_POST["ordernumber"];

	$query = mysql_query("SELECT * FROM document WHERE ordernumber = '$order'")
	or die(mysql_error());

	if($query && mysql_num_rows($query) > 0) {
	     $orderErr = "* Orden ya tiene asociado un certificado de control. Revisar";
	}
}
?>