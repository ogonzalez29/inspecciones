<?php
//Verify if session started, else redirect to login.php
ob_start();
if(!isset($_SESSION)) { 
    session_start(); 
} 
if (!$_SESSION['logged']) {
	header("Location: login.php");
	exit;
}
//Connect to the database
include ('info.php');

//Search for the number of document in db
@$doc3 = $_POST['doc3']-3000;
@$search3 = $_SESSION['cons3'];

//get last results from database if recently submitted
$result3 = mysql_query("SELECT * FROM document3 ORDER BY id DESC LIMIT 1")
	or die(mysql_error());

if (!empty($search3)) {
	$result3 = mysql_query("SELECT * FROM document3 WHERE id = '$doc3'")
		or die(mysql_error());

	//If there's no information in database from search query
	if (mysql_num_rows($result3) == 0) {
		die('No hay información con ese criterio de búsqueda');
	}
}	

while ($row3 = mysql_fetch_array($result3)) {
	$doc3 = $row3['id'];
	require('print_i.php');
}
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript">
		function search(){
			window.location.replace("search.php");
		}
	</script>
	<script type="text/javascript">
		function home(){
			window.location.replace("index.php");
		}
	</script>
</head>
<body id="report">
<div id="overlay">
  <div id="text">Generado Certificado de Inspección No. <?php echo ("$doc3")+3000;?><br>
  	<?php 
  		$doc3 = $doc3+3000;
  		$doc4 = $doc3 -3000;
  	?>
  	<form style="display:inline-block" name="fpdf" id= "fpdf" method="post" action="print_pdf.php">
			<th width='60' align='center'>
				<input type="submit" name="pdf" value="Imprimir en pdf">
				<input type="hidden" name="doc3" value="<?php echo $doc3;?>" >
				<input type="hidden" name="doc4" value="<?php echo $doc4;?>" >
			</th>
	</form>
  	<form style="display:inline-block" name="send" id="send" action="send_email.php" method="post">
  		<th width='60' align='center'>
	  		<input type="submit" name="emailSend" value="Enviar por correo">
	  		<input type="hidden" name="doc3" value="<?php echo $doc3;?>" >
			<input type="hidden" name="doc4" value="<?php echo $doc4;?>" >
		</th>
  	</form>
  	<button onclick= "search()">Buscar otro certificado</button>
  	<button onclick= "home()">Ir al inicio</button>
  </div>
</div>
</body>
</html>
