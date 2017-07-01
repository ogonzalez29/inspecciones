<?php
//Verify if session started, else redirect to login.php
// ob_start();
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

//get last results from database if recently submitted
$result3 = mysql_query("SELECT * FROM document3 ORDER BY id DESC LIMIT 1")
	or die(mysql_error());

while ($row3 = mysql_fetch_array($result3)) {
	$doc3 = $row3['id'];
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
  	<?php 
  		$doc3 = $doc3+3000;
  	?>
<body id="report">
<div id="overlay">
  <div id="text">Generando archivo pdf<br>
	<form style="display:inline-block" name="send" id="send" action="send_email.php" method="post">
  		<th width='60' align='center'>
	  		<input type="submit" name="emailSend" value="Enviar por correo">
	  		<input type="hidden" name="doc3" value="<?php echo $doc3;?>" >
		</th>
  	</form>
  	<button onclick= "search()">Buscar certificado de inspección</button>
  	<button onclick= "home()">Ir al inicio</button>
  </div>
</div>
<?php
include('print_i.php');
?>
</body>
</html>
