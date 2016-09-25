<?php
//Verify if session started, else redirect to login.php
ob_start();
session_start();
if (!$_SESSION['logged']) {
	header("Location: login.php");
	exit;
}
//Connect to the database
include ('info.php');
// require ('search.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<title>Certificado de Control Calidad</title>
		<link rel="stylesheet" type="text/css" href="css/view1.css"/>
		<script type="text/javascript" src="http://d3js.org/d3.v3.min.js"></script>
		<script type="text/javascript" src="js/jquery.min.js"></script>
		<script type="text/javascript" src="js/signaturepad/jquery.signaturepad.min.js"></script>
		<script type="text/javascript" src="js/signaturepad/json2.min.js"></script>
	</head>
	<body>
	<?php
		//set search variable to find results from database
		@$search = $_SESSION['cons'];
		@$doc = $_POST['doc']-1000;

		//get last results from database if recently submitted
		$result = mysql_query("SELECT * FROM document ORDER BY id DESC LIMIT 1")
			or die(mysql_error());

		if (!empty($search)) {
			$result = mysql_query("SELECT * FROM document WHERE id = '$doc'")
				or die(mysql_error());

			//If there's no information in database from search query
			if (mysql_num_rows($result) == 0) {
				die('No hay información con ese criterio de búsqueda');
			}
		}
		//loop through results of database query, displaying them in the format
		while ($row = mysql_fetch_array($result)) {
	?>
	<div class="grid">
		<div class="row">
			<div class="col-12">
				<div style="padding: 5px 2px 2px 2px;" class="col-12">
					<img src="img/logo.png" alt="logo servitalleres"/>
					<div style="float:right; color:red;" class="col-1_1">
						<h2 style="text-align:right;"><?php echo 'N. '. ($row['id']+1000)?></h2>
					</div>
				</div>
				<div style="text-align: center;" class="col-12">
					<h1>CERTIFICADO DE CONTROL CALIDAD</h1>
				</div>
			</div>
		</div>
		<div class="row-1">
			<div class="col-12">
				<div class="col-08">
					<h3 style="font-weight: bold;">Cliente:</h3>	
				</div>
				<div class="col-3">
					<h3><?php echo $row['firstname']. ' '. $row['lastname']?></h3>
				</div>
				<div class="col-07">
					<h3 style="font-weight: bold;">Marca:</h3>
				</div>
				<div class="col-1_6">
					<h3><?php echo $row['make']?></h3>
				</div>
				<div class="col-06">
					<h3 style="font-weight: bold;">Linea:</h3>
				</div>
				<div class="col-1_5">
					<h3><?php echo $row['type']?></h3>
				</div>
				<div style="border-left: 1px solid white;" class="col-09">
					<h3 style="font-weight: bold;">Modelo:</h3>
				</div>
				<div style="border-left: 1px solid black; border-right: 1px solid black;"class="col-06">
					<h3><?php echo $row['model']?></h3>
				</div>
				<div class="col-06">
					<h3 style="font-weight: bold;">Placa:</h3>
				</div>
				<div class="col-09">
					<h3><?php echo $row['license']?></h3>
				</div>
			</div>
		</div>
		<div class="row-2">
			<div class="col-12">
				<div style="border-left: 1px solid white;" class ="col-1_2">
					<h3 style="font-weight: bold;">Kilometraje:</h3>
				</div>
				<div style="border-left: 1px solid black; border-right: 1px solid black;" class ="col-08">
					<h3><?php echo number_format($row['mileage'],0,",",".")?></h3>
				</div>	
				<div class="col-2_3">
					<h3 style="font-weight: bold;">Orden de reparación:</h3>
				</div>
				<div style="border-left: 1px solid black; border-right: 1px solid black;" class="col-06">
					<h3><?php echo $row['ordernumber']?></h3>
				</div>
				<div class="col-2_2">
					<h3 style="font-weight: bold;">Asesor de servicio:</h3>	
				</div>
				<div style="border-left: 1px solid black; border-right: 1px solid black;" class="col-2_3">
					<h3><?php echo $row['firstname1']. ' '. $row['lastname1']?></h3>
				</div>
				<div class="col-07">
					<h3 style="font-weight: bold;">Fecha:</h3>	
				</div>
				<div style="border-left: 1px solid black;" class="col-1_1">
					<h3><?php echo $row['day']. '/'. $row['month']. '/'. $row['year']?></h3>
				</div>
			</div>
		</div>
		<div class="row-3">
			<div style="text-align: center;" class="col-12">
				<h2>PUNTOS DE CONTROL</h2>
			</div>
		</div>
		<div class="row-4">
			<div class="col-12">
				<div style="float:left;" class="col-6">
					<table>
						<caption>
								Instrumentos y equipamento: 
						</caption>
						   <thead>
						    	<tr>
						        	<th style="width: 45%" scope="col"><span style="display: none">Instrumentos y equipamento:</span></th>
						            <th  style="width: 15%" scope="col">B</th>
									<th  style="width: 15%" scope="col">M</th>
									<th  style="width: 15%" scope="col">N/A</th>
						        </tr>
						    </thead>
						    <tbody>
						    	<tr class="alt">
						        	<td class="first_col">Indicadores y luces de bordo</td>
						            <td><label style="display: none" >B</label><input name="matrix_1[1]" type="radio" value="1"  <?php if(isset($row['m1_el1']) && $row['m1_el1']=="1") echo "checked";?>></td>
									<td><label style="display: none" >M</label><input name="matrix_1[1]" type="radio" value="2"  <?php if(isset($row['m1_el1']) && $row['m1_el1']=="2") echo "checked";?>/></td>
									<td><label style="display: none" >N/A</label><input name="matrix_1[1]" type="radio" value="3" <?php if(isset($row['m1_el1']) && $row['m1_el1']=="3") echo "checked";?>/></td>
						        </tr>
						        <tr class="alt">
						        	<td class="first_col">Reloj a la hora</td>
						            <td><label style="display: none" >B</label><input  name="matrix_1[2]" type="radio" value="1"  <?php if(isset($row['m1_el2']) && $row['m1_el2']=="1") echo "checked";?>/></td>
									<td><label style="display: none" >M</label><input  name="matrix_1[2]" type="radio" value="2"  <?php if(isset($row['m1_el2']) && $row['m1_el2']=="2") echo "checked";?>/></td>
									<td><label style="display: none" >N/A</label><input  name="matrix_1[2]" type="radio" value="3"  <?php if(isset($row['m1_el2']) && $row['m1_el2']=="3") echo "checked";?>/></td>
						        </tr>
						        <tr class="alt" >
						        	<td class="first_col">Cocuyos</td>
						            <td><label style="display: none" >B</label><input  name="matrix_1[3]" type="radio" value="1"  <?php if(isset($row['m1_el3']) && $row['m1_el3']=="1") echo "checked";?>/></td>
									<td><label style="display: none" >M</label><input  name="matrix_1[3]" type="radio" value="2"  <?php if(isset($row['m1_el3']) && $row['m1_el3']=="2") echo "checked";?>/></td>
									<td><label style="display: none" >N/A</label><input  name="matrix_1[3]" type="radio" value="3"  <?php if(isset($row['m1_el3']) && $row['m1_el3']=="3") echo "checked";?>/></td>
						        </tr>
						        <tr class="alt" >
						        	<td class="first_col">Encendido radio (código)</td>
						            <td><label style="display: none" >B</label><input  name="matrix_1[4]" type="radio" value="1"  <?php if(isset($row['m1_el4']) && $row['m1_el4']=="1") echo "checked";?>/></td>
									<td><label style="display: none" >M</label><input  name="matrix_1[4]" type="radio" value="2"  <?php if(isset($row['m1_el4']) && $row['m1_el4']=="2") echo "checked";?>/></td>
									<td><label style="display: none" >N/A</label><input  name="matrix_1[4]" type="radio" value="3"  <?php if(isset($row['m1_el4']) && $row['m1_el4']=="3") echo "checked";?>/></td>
						        </tr>
						        <tr class="alt" >
						        	<td class="first_col">Ventilación, calefacción, A/A</td>
						            <td><label style="display: none" >B</label><input  name="matrix_1[5]" type="radio" value="1"  <?php if(isset($row['m1_el5']) && $row['m1_el5']=="1") echo "checked";?>/></td>
									<td><label style="display: none" >M</label><input  name="matrix_1[5]" type="radio" value="2"  <?php if(isset($row['m1_el5']) && $row['m1_el5']=="2") echo "checked";?>/></td>
									<td><label style="display: none" >N/A</label><input  name="matrix_1[5]" type="radio" value="3"  <?php if(isset($row['m1_el5']) && $row['m1_el5']=="3") echo "checked";?>/></td>
						        </tr>
						        <tr class="alt" >
						        	<td class="first_col">Accionamiento y sonido pito</td>
						            <td><label style="display: none" >B</label><input  name="matrix_1[6]" type="radio" value="1"  <?php if(isset($row['m1_el6']) && $row['m1_el6']=="1") echo "checked";?>/></td>
									<td><label style="display: none" >M</label><input  name="matrix_1[6]" type="radio" value="2"  <?php if(isset($row['m1_el6']) && $row['m1_el6']=="2") echo "checked";?>/></td>
									<td><label style="display: none" >N/A</label><input  name="matrix_1[6]" type="radio" value="3"  <?php if(isset($row['m1_el6']) && $row['m1_el6']=="3") echo "checked";?>/></td>
						        </tr>
						        <tr class="alt" >
						        	<td class="first_col">Limpiabrisas (eficacia)</td>
						            <td><label style="display: none" >B</label><input  name="matrix_1[7]" type="radio" value="1"  <?php if(isset($row['m1_el7']) && $row['m1_el7']=="1") echo "checked";?>/></td>
									<td><label style="display: none" >M</label><input  name="matrix_1[7]" type="radio" value="2"  <?php if(isset($row['m1_el7']) && $row['m1_el7']=="2") echo "checked";?>/></td>
									<td><label style="display: none" >N/A</label><input  name="matrix_1[7]" type="radio" value="3"  <?php if(isset($row['m1_el7']) && $row['m1_el7']=="3") echo "checked";?>/></td>
						        </tr>
						        <tr class="alt" >
						        	<td class="first_col">Activación alarma</td>
						            <td><label style="display: none" >B</label><input  name="matrix_1[8]" type="radio" value="1"  <?php if(isset($row['m1_el8']) && $row['m1_el8']=="1") echo "checked";?>/></td>
									<td><label style="display: none" >M</label><input  name="matrix_1[8]" type="radio" value="2"  <?php if(isset($row['m1_el8']) && $row['m1_el8']=="2") echo "checked";?>/></td>
									<td><label style="display: none" >N/A</label><input  name="matrix_1[8]" type="radio" value="3"  <?php if(isset($row['m1_el8']) && $row['m1_el8']=="3") echo "checked";?>/></td>
						        </tr>
						        <tr class="alt" >
						        	<td class="first_col">Espejos retrovisores</td>
						            <td><label style="display: none" >B</label><input  name="matrix_1[9]" type="radio" value="1"  <?php if(isset($row['m1_el9']) && $row['m1_el9']=="1") echo "checked";?>/></td>
									<td><label style="display: none" >M</label><input  name="matrix_1[9]" type="radio" value="2"  <?php if(isset($row['m1_el9']) && $row['m1_el9']=="2") echo "checked";?>/></td>
									<td><label style="display: none" >N/A</label><input  name="matrix_1[9]" type="radio" value="3"  <?php if(isset($row['m1_el9']) && $row['m1_el9']=="3") echo "checked";?>/></td>
						        </tr>
						        <tr class="alt" >
						        	<td class="first_col">Elevavidrios (programación)</td>
						            <td><label style="display: none" >B</label><input  name="matrix_1[10]" type="radio" value="1"  <?php if(isset($row['m1_el10']) && $row['m1_el10']=="1") echo "checked";?>/></td>
									<td><label style="display: none" >M</label><input  name="matrix_1[10]" type="radio" value="2"  <?php if(isset($row['m1_el10']) && $row['m1_el10']=="2") echo "checked";?>/></td>
									<td><label style="display: none" >N/A</label><input  name="matrix_1[10]" type="radio" value="3"  <?php if(isset($row['m1_el10']) && $row['m1_el10']=="3") echo "checked";?>/></td>
						        </tr>
						        <tr class="alt" >
						        	<td class="first_col">Bloqueo central (programación)</td>
						            <td><label style="display: none" >B</label><input  name="matrix_1[11]" type="radio" value="1"  <?php if(isset($row['m1_el11']) && $row['m1_el11']=="1") echo "checked";?>/></td>
									<td><label style="display: none" >M</label><input  name="matrix_1[11]" type="radio" value="2"  <?php if(isset($row['m1_el11']) && $row['m1_el11']=="2") echo "checked";?>/></td>
									<td><label style="display: none" >N/A</label><input  name="matrix_1[11]" type="radio" value="3"  <?php if(isset($row['m1_el11']) && $row['m1_el11']=="3") echo "checked";?>/></td>
						        </tr>
						        <tr class="alt" >
						        	<td class="first_col">Sonido de parlantes</td>
						            <td><label style="display: none" >B</label><input  name="matrix_1[12]" type="radio" value="1"  <?php if(isset($row['m1_el12']) && $row['m1_el12']=="1") echo "checked";?>/></td>
									<td><label style="display: none" >M</label><input  name="matrix_1[12]" type="radio" value="2"  <?php if(isset($row['m1_el12']) && $row['m1_el12']=="2") echo "checked";?>/></td>
									<td><label style="display: none" >N/A</label><input  name="matrix_1[12]" type="radio" value="3"  <?php if(isset($row['m1_el12']) && $row['m1_el12']=="3") echo "checked";?>/></td>
						        </tr>
						        <tr class="alt" >
						        	<td class="first_col">Activación sensor reverso</td>
						            <td><label style="display: none" >B</label><input  name="matrix_1[13]" type="radio" value="1"  <?php if(isset($row['m1_el13']) && $row['m1_el13']=="1") echo "checked";?>/></td>
									<td><label style="display: none" >M</label><input  name="matrix_1[13]" type="radio" value="2"  <?php if(isset($row['m1_el13']) && $row['m1_el13']=="2") echo "checked";?>/></td>
									<td><label style="display: none" >N/A</label><input  name="matrix_1[13]" type="radio" value="3"  <?php if(isset($row['m1_el13']) && $row['m1_el13']=="3") echo "checked";?>/></td>
						        </tr>
						        <tr class="alt" >
						        	<td class="first_col">Presencia copa de seguridad</td>
						            <td><label style="display: none" >B</label><input  name="matrix_1[14]" type="radio" value="1"  <?php if(isset($row['m1_el14']) && $row['m1_el14']=="1") echo "checked";?>/></td>
									<td><label style="display: none" >M</label><input  name="matrix_1[14]" type="radio" value="2"  <?php if(isset($row['m1_el14']) && $row['m1_el14']=="2") echo "checked";?>/></td>
									<td><label style="display: none" >N/A</label><input  name="matrix_1[14]" type="radio" value="3"  <?php if(isset($row['m1_el14']) && $row['m1_el14']=="3") echo "checked";?>/></td>
						        </tr>
						        <tr class="alt" >
						        	<td class="first_col">Presencia documentos vehículo</td>
						            <td><label style="display: none" >B</label><input  name="matrix_1[15]" type="radio" value="1"  <?php if(isset($row['m1_el15']) && $row['m1_el15']=="1") echo "checked";?>/></td>
									<td><label style="display: none" >M</label><input  name="matrix_1[15]" type="radio" value="2"  <?php if(isset($row['m1_el15']) && $row['m1_el15']=="2") echo "checked";?>/></td>
									<td><label style="display: none" >N/A</label><input  name="matrix_1[15]" type="radio" value="3"  <?php if(isset($row['m1_el15']) && $row['m1_el15']=="3") echo "checked";?>/></td>
						        </tr>
						        <tr class="alt" >
						        	<td class="first_col">Carga y vencimiento extinguidor</td>
						            <td><label style="display: none" >B</label><input  name="matrix_1[16]" type="radio" value="1"  <?php if(isset($row['m1_el16']) && $row['m1_el16']=="1") echo "checked";?>/></td>
									<td><label style="display: none" >M</label><input  name="matrix_1[16]" type="radio" value="2"  <?php if(isset($row['m1_el16']) && $row['m1_el16']=="2") echo "checked";?>/></td>
									<td><label style="display: none" >N/A</label><input  name="matrix_1[16]" type="radio" value="3"  <?php if(isset($row['m1_el16']) && $row['m1_el16']=="3") echo "checked";?>/></td>
						        </tr>
						        <tr class="alt" >
						        	<td class="first_col">Programación cambio de aceite</td>
						            <td><label style="display: none" >B</label><input  name="matrix_1[17]" type="radio" value="1"  <?php if(isset($row['m1_el17']) && $row['m1_el17']=="1") echo "checked";?>/></td>
									<td><label style="display: none" >M</label><input  name="matrix_1[17]" type="radio" value="2"  <?php if(isset($row['m1_el17']) && $row['m1_el17']=="2") echo "checked";?>/></td>
									<td><label style="display: none" >N/A</label><input  name="matrix_1[17]" type="radio" value="3"  <?php if(isset($row['m1_el17']) && $row['m1_el17']=="3") echo "checked";?>/></td>
						        </tr>
						    </tbody>
						</table>
						<table>
						<caption>
								Alumbrado exterior: 
						</caption>
						   <thead>
						    	<tr>
						        	<th style="width: 45%" scope="col"><span style="display: none">Alumbrado exterior:</span></th>
						            <th  style="width: 15%" scope="col">B</th>
									<th  style="width: 15%" scope="col">M</th>
									<th  style="width: 15%" scope="col">N/A</th>
						        </tr>
						    </thead>
						    <tbody>
						    	<tr class="alt" >
						        	<td class="first_col">Luz baja, media y alta</td>
						            <td><label style="display: none" >B</label><input  name="matrix_2[1]" type="radio" value="1"  <?php if(isset($row['m2_el1']) && $row['m2_el1']=="1") echo "checked";?>/></td>
									<td><label style="display: none" >M</label><input  name="matrix_2[1]" type="radio" value="2"  <?php if(isset($row['m2_el1']) && $row['m2_el1']=="2") echo "checked";?>/></td>
									<td><label style="display: none" >N/A</label><input  name="matrix_2[1]" type="radio" value="3"  <?php if(isset($row['m2_el1']) && $row['m2_el1']=="3") echo "checked";?>/></td>
						        </tr>
						        <tr class="alt" >
						        	<td class="first_col">Direccionales, repetidores</td>
						            <td><label style="display: none" >B</label><input  name="matrix_2[2]" type="radio" value="1"  <?php if(isset($row['m2_el2']) && $row['m2_el2']=="1") echo "checked";?>/></td>
									<td><label style="display: none" >M</label><input  name="matrix_2[2]" type="radio" value="2"  <?php if(isset($row['m2_el2']) && $row['m2_el2']=="2") echo "checked";?>/></td>
									<td><label style="display: none" >N/A</label><input  name="matrix_2[2]" type="radio" value="3"  <?php if(isset($row['m2_el2']) && $row['m2_el2']=="3") echo "checked";?>/></td>
						        </tr>
						        <tr class="alt" >
						        	<td class="first_col">Stops</td>
						            <td><label style="display: none" >B</label><input  name="matrix_2[3]" type="radio" value="1"  <?php if(isset($row['m2_el3']) && $row['m2_el3']=="1") echo "checked";?>/></td>
									<td><label style="display: none" >M</label><input  name="matrix_2[3]" type="radio" value="2"  <?php if(isset($row['m2_el3']) && $row['m2_el3']=="2") echo "checked";?>/></td>
									<td><label style="display: none" >N/A</label><input  name="matrix_2[3]" type="radio" value="3"  <?php if(isset($row['m2_el3']) && $row['m2_el3']=="3") echo "checked";?>/></td>
						        </tr>
						        <tr class="alt" >
						        	<td class="first_col">Reversa</td>
						            <td><label style="display: none" >B</label><input  name="matrix_2[4]" type="radio" value="1"  <?php if(isset($row['m2_el4']) && $row['m2_el4']=="1") echo "checked";?>/></td>
									<td><label style="display: none" >M</label><input  name="matrix_2[4]" type="radio" value="2"  <?php if(isset($row['m2_el4']) && $row['m2_el4']=="2") echo "checked";?>/></td>
									<td><label style="display: none" >N/A</label><input  name="matrix_2[4]" type="radio" value="3"  <?php if(isset($row['m2_el4']) && $row['m2_el4']=="3") echo "checked";?>/></td>
						        </tr>
						        <tr class="alt" >
						        	<td class="first_col">Guantera, luz techo, baúl</td>
						            <td><label style="display: none" >B</label><input  name="matrix_2[5]" type="radio" value="1"  <?php if(isset($row['m2_el5']) && $row['m2_el5']=="1") echo "checked";?>/></td>
									<td><label style="display: none" >M</label><input  name="matrix_2[5]" type="radio" value="2"  <?php if(isset($row['m2_el5']) && $row['m2_el5']=="2") echo "checked";?>/></td>
									<td><label style="display: none" >N/A</label><input  name="matrix_2[5]" type="radio" value="3"  <?php if(isset($row['m2_el5']) && $row['m2_el5']=="3") echo "checked";?>/></td>
						        </tr><tr class="alt" >
						        	<td class="first_col">Exploradoras y antiniebla</td>
						            <td><label style="display: none" >B</label><input  name="matrix_2[6]" type="radio" value="1"  <?php if(isset($row['m2_el6']) && $row['m2_el6']=="1") echo "checked";?>/></td>
									<td><label style="display: none" >M</label><input  name="matrix_2[6]" type="radio" value="2"  <?php if(isset($row['m2_el6']) && $row['m2_el6']=="2") echo "checked";?>/></td>
									<td><label style="display: none" >N/A</label><input  name="matrix_2[6]" type="radio" value="3"  <?php if(isset($row['m2_el6']) && $row['m2_el6']=="3") echo "checked";?>/></td>
						        </tr>
						    </tbody>
					</table>
					<table>
					<caption>
							Presentación del vehículo: 
					</caption>
					   <thead>
					    	<tr>
					        	<th style="width: 45%" scope="col"><span style="display: none">Presentación del vehículo:</span></th>
					            <th  style="width: 15%" scope="col">B</th>
								<th  style="width: 15%" scope="col">M</th>
								<th  style="width: 15%" scope="col">N/A</th>
					        </tr>
					    </thead>
					    <tbody>
					    	<tr class="alt" >
					        	<td class="first_col">Limpieza carteras, cinturones</td>
					            <td><label style="display: none" >B</label><input  name="matrix_3[1]" type="radio" value="1"  <?php if(isset($row['m3_el1']) && $row['m3_el1']=="1") echo "checked";?>/></td>
								<td><label style="display: none" >M</label><input  name="matrix_3[1]" type="radio" value="2"  <?php if(isset($row['m3_el1']) && $row['m3_el1']=="2") echo "checked";?>/></td>
								<td><label style="display: none" >N/A</label><input  name="matrix_3[1]" type="radio" value="3"  <?php if(isset($row['m3_el1']) && $row['m3_el1']=="3") echo "checked";?>/></td>
					        </tr>
					        <tr class="alt" >
					        	<td class="first_col">Limpieza millaré y guarnecidos</td>
					            <td><label style="display: none" >B</label><input  name="matrix_3[2]" type="radio" value="1"  <?php if(isset($row['m3_el2']) && $row['m3_el2']=="1") echo "checked";?>/></td>
								<td><label style="display: none" >M</label><input  name="matrix_3[2]" type="radio" value="2"  <?php if(isset($row['m3_el2']) && $row['m3_el2']=="2") echo "checked";?>/></td>
								<td><label style="display: none" >N/A</label><input  name="matrix_3[2]" type="radio" value="3"  <?php if(isset($row['m3_el2']) && $row['m3_el2']=="3") echo "checked";?>/></td>
					        </tr>
					        <tr class="alt" >
					        	<td class="first_col">Limpieza exterior (chapas, etc)</td>
					            <td><label style="display: none" >B</label><input  name="matrix_3[3]" type="radio" value="1"  <?php if(isset($row['m3_el3']) && $row['m3_el3']=="1") echo "checked";?>/></td>
								<td><label style="display: none" >M</label><input  name="matrix_3[3]" type="radio" value="2"  <?php if(isset($row['m3_el3']) && $row['m3_el3']=="2") echo "checked";?>/></td>
								<td><label style="display: none" >N/A</label><input  name="matrix_3[3]" type="radio" value="3"  <?php if(isset($row['m3_el3']) && $row['m3_el3']=="3") echo "checked";?>/></td>
					        </tr>
					    </tbody>
					</table>											
				</div>
				<div style="float:right;" class="col-6">
					<table>
						<caption>
								Desgaste de las llantas (%): 
						</caption>
						   <thead>
						    	<tr>
						        	<th style="width: 30%" scope="col"><span style="display: none">Desgaste de las llantas (%):</span></th>
						            <th  style="width: 15%" scope="col">25</th>
									<th  style="width: 15%" scope="col">50</th>
									<th  style="width: 15%" scope="col">75</th>
									<th id="mc_3_4" style="width: 15%" scope="col">100</th>
						        </tr>
						    </thead>
						    <tbody>
						    	<tr class="alt" >
						        	<td class="first_col">Delantera izquierda</td>
						            <td><label style="display: none" >25</label><input  name="matrix_4[1]" type="radio" value="1"  <?php if(isset($row['m4_el1']) && $row['m4_el1']=="1") echo "checked";?>/></td>
									<td><label style="display: none" >50</label><input  name="matrix_4[1]" type="radio" value="2"  <?php if(isset($row['m4_el1']) && $row['m4_el1']=="2") echo "checked";?>/></td>
									<td><label style="display: none" >75</label><input  name="matrix_4[1]" type="radio" value="3"  <?php if(isset($row['m4_el1']) && $row['m4_el1']=="3") echo "checked";?>/></td>
									<td><label style="display: none" >100</label><input  name="matrix_4[1]" type="radio" value="4"  <?php if(isset($row['m4_el1']) && $row['m4_el1']=="4") echo "checked";?>/></td>
						        </tr>
						        <tr class="alt" >
						        	<td class="first_col">Delantera derecha</td>
						            <td><label style="display: none" >25</label><input  name="matrix_4[2]" type="radio" value="1"  <?php if(isset($row['m4_el2']) && $row['m4_el2']=="1") echo "checked";?>/></td>
									<td><label style="display: none" >50</label><input  name="matrix_4[2]" type="radio" value="2"  <?php if(isset($row['m4_el2']) && $row['m4_el2']=="2") echo "checked";?>/></td>
									<td><label style="display: none" >75</label><input  name="matrix_4[2]" type="radio" value="3"  <?php if(isset($row['m4_el2']) && $row['m4_el2']=="3") echo "checked";?>/></td>
									<td><label style="display: none" >100</label><input  name="matrix_4[2]" type="radio" value="4"  <?php if(isset($row['m4_el2']) && $row['m4_el2']=="4") echo "checked";?>/></td>
						        </tr>
						        <tr class="alt" >
						        	<td class="first_col">Trasera izquierda</td>
						            <td><label style="display: none" >25</label><input  name="matrix_4[3]" type="radio" value="1"  <?php if(isset($row['m4_el3']) && $row['m4_el3']=="1") echo "checked";?>/></td>
									<td><label style="display: none" >50</label><input  name="matrix_4[3]" type="radio" value="2"  <?php if(isset($row['m4_el3']) && $row['m4_el3']=="2") echo "checked";?>/></td>
									<td><label style="display: none" >75</label><input  name="matrix_4[3]" type="radio" value="3"  <?php if(isset($row['m4_el3']) && $row['m4_el3']=="3") echo "checked";?>/></td>
									<td><label style="display: none" >100</label><input  name="matrix_4[3]" type="radio" value="4"  <?php if(isset($row['m4_el3']) && $row['m4_el3']=="4") echo "checked";?>/></td>
						        </tr>
						        <tr class="alt" >
						        	<td class="first_col">Trasera derecha</td>
						            <td><label style="display: none" >25</label><input  name="matrix_4[4]" type="radio" value="1"  <?php if(isset($row['m4_el4']) && $row['m4_el4']=="1") echo "checked";?>/></td>
									<td><label style="display: none" >50</label><input  name="matrix_4[4]" type="radio" value="2"  <?php if(isset($row['m4_el4']) && $row['m4_el4']=="2") echo "checked";?>/></td>
									<td><label style="display: none" >75</label><input  name="matrix_4[4]" type="radio" value="3"  <?php if(isset($row['m4_el4']) && $row['m4_el4']=="3") echo "checked";?>/></td>
									<td><label style="display: none" >100</label><input  name="matrix_4[4]" type="radio" value="4"  <?php if(isset($row['m4_el4']) && $row['m4_el4']=="4") echo "checked";?>/></td>
						        </tr>
						    </tbody>
					</table>
					<table>
						<caption>
								Presión de las llantas (psi): 
						</caption>
						   <thead>
						    	<tr>
						        	<th style="width: 30%" scope="col"><span style="display: none">Presión de las llantas (psi):</span></th>
						            <th  style="width: 15%" scope="col">30</th>
									<th  style="width: 15%" scope="col">32</th>
									<th  style="width: 15%" scope="col">34</th>
									<th id="mc_3_4" style="width: 15%" scope="col">36</th>
						        </tr>
						    </thead>
						    <tbody>
						    	<tr class="alt" >
						        	<td class="first_col">Delantera izquierda</td>
						            <td><label style="display: none" >30</label><input  name="matrix_5[1]" type="radio" value="1"  <?php if(isset($row['m5_el1']) && $row['m5_el1']=="1") echo "checked";?>/></td>
									<td><label style="display: none" >32</label><input  name="matrix_5[1]" type="radio" value="2"  <?php if(isset($row['m5_el1']) && $row['m5_el1']=="2") echo "checked";?>/></td>
									<td><label style="display: none" >34</label><input  name="matrix_5[1]" type="radio" value="3"  <?php if(isset($row['m5_el1']) && $row['m5_el1']=="3") echo "checked";?>/></td>
									<td><label style="display: none" >36</label><input  name="matrix_5[1]" type="radio" value="4"  <?php if(isset($row['m5_el1']) && $row['m5_el1']=="4") echo "checked";?>/></td>
						        </tr>
						        <tr class="alt" >
						        	<td class="first_col">Delantera derecha</td>
						            <td><label style="display: none" >30</label><input  name="matrix_5[2]" type="radio" value="1"  <?php if(isset($row['m5_el2']) && $row['m5_el2']=="1") echo "checked";?>/></td>
									<td><label style="display: none" >32</label><input  name="matrix_5[2]" type="radio" value="2"  <?php if(isset($row['m5_el2']) && $row['m5_el2']=="2") echo "checked";?>/></td>
									<td><label style="display: none" >34</label><input  name="matrix_5[2]" type="radio" value="3"  <?php if(isset($row['m5_el2']) && $row['m5_el2']=="3") echo "checked";?>/></td>
									<td><label style="display: none" >36</label><input  name="matrix_5[2]" type="radio" value="4"  <?php if(isset($row['m5_el2']) && $row['m5_el2']=="4") echo "checked";?>/></td>
						        </tr>
						        <tr class="alt" >
						        	<td class="first_col">Trasera izquierda</td>
						            <td><label style="display: none" >30</label><input  name="matrix_5[3]" type="radio" value="1"  <?php if(isset($row['m5_el3']) && $row['m5_el3']=="1") echo "checked";?>/></td>
									<td><label style="display: none" >32</label><input  name="matrix_5[3]" type="radio" value="2"  <?php if(isset($row['m5_el3']) && $row['m5_el3']=="2") echo "checked";?>/></td>
									<td><label style="display: none" >34</label><input  name="matrix_5[3]" type="radio" value="3"  <?php if(isset($row['m5_el3']) && $row['m5_el3']=="3") echo "checked";?>/></td>
									<td><label style="display: none" >36</label><input  name="matrix_5[3]" type="radio" value="4"  <?php if(isset($row['m5_el3']) && $row['m5_el3']=="4") echo "checked";?>/></td>
						        </tr>
						        <tr class="alt" >
						        	<td class="first_col">Trasera derecha</td>
						            <td><label style="display: none" >30</label><input  name="matrix_5[4]" type="radio" value="1"  <?php if(isset($row['m5_el4']) && $row['m5_el4']=="1") echo "checked";?>/></td>
									<td><label style="display: none" >32</label><input  name="matrix_5[4]" type="radio" value="2"  <?php if(isset($row['m5_el4']) && $row['m5_el4']=="2") echo "checked";?>/></td>
									<td><label style="display: none" >34</label><input  name="matrix_5[4]" type="radio" value="3"  <?php if(isset($row['m5_el4']) && $row['m5_el4']=="3") echo "checked";?>/></td>
									<td><label style="display: none" >36</label><input  name="matrix_5[4]" type="radio" value="4"  <?php if(isset($row['m5_el4']) && $row['m5_el4']=="4") echo "checked";?>/></td>
						        </tr>
						    </tbody>
					</table>
					<table>
					<caption>
							Control debajo del capot: 
					</caption>
					   <thead>
					    	<tr>
					        	<th style="width: 55%" scope="col"><span style="display: none">Control debajo del capot:</span></th>
					            <th  style="width: 12%" scope="col">B</th>
								<th  style="width: 12%" scope="col">M</th>
								<th  style="width: 12%" scope="col">N/A</th>
					        </tr>
					    </thead>
					    <tbody>
					    	<tr class="alt" >
					        	<td class="first_col">Nivel aceite motor y ajuste filtro</td>
					            <td><label style="display: none" >B</label><input  name="matrix_6[1]" type="radio" value="1"  <?php if(isset($row['m6_el1']) && $row['m6_el1']=="1") echo "checked";?>/></td>
								<td><label style="display: none" >M</label><input  name="matrix_6[1]" type="radio" value="2"  <?php if(isset($row['m6_el1']) && $row['m6_el1']=="2") echo "checked";?>/></td>
								<td><label style="display: none" >N/A</label><input  name="matrix_6[1]" type="radio" value="3"  <?php if(isset($row['m6_el1']) && $row['m6_el1']=="3") echo "checked";?>/></td>
					        </tr>
					        <tr class="alt" >
					        	<td class="first_col">Nivel líquido de frenos</td>
					            <td><label style="display: none" >B</label><input  name="matrix_6[2]" type="radio" value="1"  <?php if(isset($row['m6_el2']) && $row['m6_el2']=="1") echo "checked";?>/></td>
								<td><label style="display: none" >M</label><input  name="matrix_6[2]" type="radio" value="2"  <?php if(isset($row['m6_el2']) && $row['m6_el2']=="2") echo "checked";?>/></td>
								<td><label style="display: none" >N/A</label><input  name="matrix_6[2]" type="radio" value="3"  <?php if(isset($row['m6_el2']) && $row['m6_el2']=="3") echo "checked";?>/></td>
					        </tr>
					        <tr class="alt" >
					        	<td class="first_col">Nivel líquido refrigerante</td>
					            <td><label style="display: none" >B</label><input  name="matrix_6[3]" type="radio" value="1"  <?php if(isset($row['m6_el3']) && $row['m6_el3']=="1") echo "checked";?>/></td>
								<td><label style="display: none" >M</label><input  name="matrix_6[3]" type="radio" value="2"  <?php if(isset($row['m6_el3']) && $row['m6_el3']=="2") echo "checked";?>/></td>
								<td><label style="display: none" >N/A</label><input  name="matrix_6[3]" type="radio" value="3"  <?php if(isset($row['m6_el3']) && $row['m6_el3']=="3") echo "checked";?>/></td>
					        </tr>
					        <tr class="alt" >
					        	<td class="first_col">Nivel aceite de caja</td>
					            <td><label style="display: none" >B</label><input  name="matrix_6[4]" type="radio" value="1"  <?php if(isset($row['m6_el4']) && $row['m6_el4']=="1") echo "checked";?>/></td>
								<td><label style="display: none" >M</label><input  name="matrix_6[4]" type="radio" value="2"  <?php if(isset($row['m6_el4']) && $row['m6_el4']=="2") echo "checked";?>/></td>
								<td><label style="display: none" >N/A</label><input  name="matrix_6[4]" type="radio" value="3"  <?php if(isset($row['m6_el4']) && $row['m6_el4']=="3") echo "checked";?>/></td>
					        </tr>
					        <tr class="alt" >
					        	<td class="first_col">Nivel hidráulico de dirección</td>
					            <td><label style="display: none" >B</label><input  name="matrix_6[5]" type="radio" value="1"  <?php if(isset($row['m6_el5']) && $row['m6_el5']=="1") echo "checked";?>/></td>
								<td><label style="display: none" >M</label><input  name="matrix_6[5]" type="radio" value="2"  <?php if(isset($row['m6_el5']) && $row['m6_el5']=="2") echo "checked";?>/></td>
								<td><label style="display: none" >N/A</label><input  name="matrix_6[5]" type="radio" value="3"  <?php if(isset($row['m6_el5']) && $row['m6_el5']=="3") echo "checked";?>/></td>
					        </tr>
					        <tr class="alt" >
					        	<td class="first_col">Agua limpiabrisas del. y tras</td>
					            <td><label style="display: none" >B</label><input  name="matrix_6[6]" type="radio" value="1"  <?php if(isset($row['m6_el6']) && $row['m6_el6']=="1") echo "checked";?>/></td>
								<td><label style="display: none" >M</label><input  name="matrix_6[6]" type="radio" value="2"  <?php if(isset($row['m6_el6']) && $row['m6_el6']=="2") echo "checked";?>/></td>
								<td><label style="display: none" >N/A</label><input  name="matrix_6[6]" type="radio" value="3"  <?php if(isset($row['m6_el6']) && $row['m6_el6']=="3") echo "checked";?>/></td>
					        </tr>
					        <tr class="alt" >
					        	<td class="first_col">Fijación y ajuste bornes batería</td>
					            <td><label style="display: none" >B</label><input  name="matrix_6[7]" type="radio" value="1"  <?php if(isset($row['m6_el7']) && $row['m6_el7']=="1") echo "checked";?>/></td>
								<td><label style="display: none" >M</label><input  name="matrix_6[7]" type="radio" value="2"  <?php if(isset($row['m6_el7']) && $row['m6_el7']=="2") echo "checked";?>/></td>
								<td><label style="display: none" >N/A</label><input  name="matrix_6[7]" type="radio" value="3"  <?php if(isset($row['m6_el7']) && $row['m6_el7']=="3") echo "checked";?>/></td>
					        </tr>
					        <tr class="alt" >
					        	<td class="first_col">Presencia de tapas, obturadores</td>
					            <td><label style="display: none" >B</label><input  name="matrix_6[8]" type="radio" value="1"  <?php if(isset($row['m6_el8']) && $row['m6_el8']=="1") echo "checked";?>/></td>
								<td><label style="display: none" >M</label><input  name="matrix_6[8]" type="radio" value="2"  <?php if(isset($row['m6_el8']) && $row['m6_el8']=="2") echo "checked";?>/></td>
								<td><label style="display: none" >N/A</label><input  name="matrix_6[8]" type="radio" value="3"  <?php if(isset($row['m6_el8']) && $row['m6_el8']=="3") echo "checked";?>/></td>
					        </tr>
					        <tr class="alt" >
					        	<td class="first_col">Presencia del protector motor</td>
					            <td><label style="display: none" >B</label><input  name="matrix_6[9]" type="radio" value="1"  <?php if(isset($row['m6_el9']) && $row['m6_el9']=="1") echo "checked";?>/></td>
								<td><label style="display: none" >M</label><input  name="matrix_6[9]" type="radio" value="2"  <?php if(isset($row['m6_el9']) && $row['m6_el9']=="2") echo "checked";?>/></td>
								<td><label style="display: none" >N/A</label><input  name="matrix_6[9]" type="radio" value="3"  <?php if(isset($row['m6_el9']) && $row['m6_el9']=="3") echo "checked";?>/></td>
					        </tr>
					    </tbody>
					</table>
					<table>
					<caption style="height:20px;">
							Prueba de ruta: 
					</caption>
					   <thead>
					    	<tr>
					        	<th style="width: 55%" scope="col"><span style="display: none">Prueba de ruta:</span></th>
					            <th  style="width: 12%" scope="col">B</th>
								<th  style="width: 12%" scope="col">M</th>
								<th  style="width: 12%" scope="col">N/A</th>
					        </tr>
					    </thead>
					    <tbody>
					    	<tr class="alt" >
					        	<td class="first_col">Centrado del timón</td>
					            <td><label style="display: none" >B</label><input  name="matrix_7[1]" type="radio" value="1"  <?php if(isset($row['m7_el1']) && $row['m7_el1']=="1") echo "checked";?>/></td>
								<td><label style="display: none" >M</label><input  name="matrix_7[1]" type="radio" value="2"  <?php if(isset($row['m7_el1']) && $row['m7_el1']=="2") echo "checked";?>/></td>
								<td><label style="display: none" >N/A</label><input  name="matrix_7[1]" type="radio" value="3"  <?php if(isset($row['m7_el1']) && $row['m7_el1']=="3") echo "checked";?>/></td>
						    </tr>
					    	<tr class="alt" >
					        	<td class="first_col">Cambio de marchas neutro y andando</td>
					            <td><label style="display: none" >B</label><input  name="matrix_7[2]" type="radio" value="1"  <?php if(isset($row['m7_el2']) && $row['m7_el2']=="1") echo "checked";?>/></td>
								<td><label style="display: none" >M</label><input  name="matrix_7[2]" type="radio" value="2"  <?php if(isset($row['m7_el2']) && $row['m7_el2']=="2") echo "checked";?>/></td>
								<td><label style="display: none" >N/A</label><input  name="matrix_7[2]" type="radio" value="3"  <?php if(isset($row['m7_el2']) && $row['m7_el2']=="3") echo "checked";?>/></td>
					        </tr>
					        <tr class="alt" >
					        	<td class="first_col">Rendimiento y aceleración</td>
					            <td><label style="display: none" >B</label><input  name="matrix_7[3]" type="radio" value="1"  <?php if(isset($row['m7_el3']) && $row['m7_el3']=="1") echo "checked";?>/></td>
								<td><label style="display: none" >M</label><input  name="matrix_7[3]" type="radio" value="2"  <?php if(isset($row['m7_el3']) && $row['m7_el3']=="2") echo "checked";?>/></td>
								<td><label style="display: none" >N/A</label><input  name="matrix_7[3]" type="radio" value="3"  <?php if(isset($row['m7_el3']) && $row['m7_el3']=="3") echo "checked";?>/></td>
					        </tr>
					        <tr class="alt" >
					        	<td class="first_col">Temperatura de motor</td>
					            <td><label style="display: none" >B</label><input  name="matrix_7[4]" type="radio" value="1"  <?php if(isset($row['m7_el4']) && $row['m7_el4']=="1") echo "checked";?>/></td>
								<td><label style="display: none" >M</label><input  name="matrix_7[4]" type="radio" value="2"  <?php if(isset($row['m7_el4']) && $row['m7_el4']=="2") echo "checked";?>/></td>
								<td><label style="display: none" >N/A</label><input  name="matrix_7[4]" type="radio" value="3"  <?php if(isset($row['m7_el4']) && $row['m7_el4']=="3") echo "checked";?>/></td>
					        </tr>
					        <tr class="alt" >
					        	<td class="first_col">Encendido en frío y caliente</td>
					            <td><label style="display: none" >B</label><input  name="matrix_7[5]" type="radio" value="1"  <?php if(isset($row['m7_el5']) && $row['m7_el5']=="1") echo "checked";?>/></td>
								<td><label style="display: none" >M</label><input  name="matrix_7[5]" type="radio" value="2"  <?php if(isset($row['m7_el5']) && $row['m7_el5']=="2") echo "checked";?>/></td>
								<td><label style="display: none" >N/A</label><input  name="matrix_7[5]" type="radio" value="3"  <?php if(isset($row['m7_el5']) && $row['m7_el5']=="3") echo "checked";?>/></td>
					        </tr>
					        <tr class="alt" >
					        	<td class="first_col">Efectividad y estabilidad frenado</td>
					            <td><label style="display: none" >B</label><input  name="matrix_7[6]" type="radio" value="1"  <?php if(isset($row['m7_el6']) && $row['m7_el6']=="1") echo "checked";?>/></td>
								<td><label style="display: none" >M</label><input  name="matrix_7[6]" type="radio" value="2"  <?php if(isset($row['m7_el6']) && $row['m7_el6']=="2") echo "checked";?>/></td>
								<td><label style="display: none" >N/A</label><input  name="matrix_7[6]" type="radio" value="3"  <?php if(isset($row['m7_el6']) && $row['m7_el6']=="3") echo "checked";?>/></td>
					        </tr>
					        <tr class="alt" >
					        	<td class="first_col">Especificación ruidos susp. y dirección</td>
					            <td><label style="display: none" >B</label><input  name="matrix_7[7]" type="radio" value="1"  <?php if(isset($row['m7_el7']) && $row['m7_el7']=="1") echo "checked";?>/></td>
								<td><label style="display: none" >M</label><input  name="matrix_7[7]" type="radio" value="2"  <?php if(isset($row['m7_el7']) && $row['m7_el7']=="2") echo "checked";?>/></td>
								<td><label style="display: none" >N/A</label><input  name="matrix_7[7]" type="radio" value="3"  <?php if(isset($row['m7_el7']) && $row['m7_el7']=="3") echo "checked";?>/></td>
					        </tr>
					    </tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="row-8">
			<div style="text-align: center;" class="col-12">
				<h2 style="margin-bottom:0px;">IMPORTANTE:</h2>
			</div>
		</div>
		<div style=" border-top:1px solid white;" class="row-5">
			<div style="text-align: center;" class="col-12">
				<h3>Los controles realizados son únicamente sobre los elementos visibles del vehículo y no implican desmontaje alguno, por lo tanto el taller no asume responsabilidad en caso de la no detección de una falla no aparente.</h3>
			</div>
		</div>
		<div class="row-6">
			<div style="text-align: center;" class="col-12">
				<h3>Llamamos la atención sobre los siguientes trabajos pendientes de realizar:</h3>
			</div>
		</div>
		<div class ="row-7">
			<div class="col-12">
				<div style="float:left;" class="col-3">
					<div class="col-12">
						<h2 style="padding-right: 38px;">Semáforo</h2>
						<svg>
							<circle cx="40%" cy="50%" r="50" stroke="red" stroke-width="3" fill="red" />
							<text x="40%" y="50%" text-anchor="middle" stroke="#1A1A1A" stroke-width="0.5px" dy=".3em">Inmediato</text>
						</svg>
						<svg>
							<circle cx="40%" cy="50%" r="50" stroke="yellow" stroke-width="3" fill="yellow" />
							<text x="40%" y="50%" text-anchor="middle" stroke="#1A1A1A" stroke-width="0.5px" dy=".3em">De ser posible</text>
						</svg>
						<svg>
							<circle cx="40%" cy="50%" r="50" stroke="green" stroke-width="3" fill="green" />
							<text x="40%" y="50%" text-anchor="middle" stroke="#1A1A1A" stroke-width="0.5px" dy=".3em">A prever</text>
						</svg>
						<h2 style="padding-right: 30px;">Observaciones:</h2>

					</div>
				</div>
				<div style="float:right;" class="col-9">
					<div style="text-align:center" class="col-12">
						<h2>Comentarios</h2>
						<div style="border-bottom: 1px solid black;" class="col-12">
							<h3><?php echo $row['comment1']?></h3>
						</div>
						<div style="border-bottom: 1px solid black;" class="col-12">
							<h3><?php echo $row['comment2']?></h3>
						</div>
						<div style="border-bottom: 1px solid black;" class="col-12">
							<h3><?php echo $row['comment3']?></h3>
						</div>
						<div class="col-12">
							<h3><?php echo $row['comment4']?></h3>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="footer">
			<div class="col-12">
				<div class="col-6">
					<div class="col-12">
						<h2>Conformidad factura / trabajos:</h2>
					</div>
					<div style="border-top: 1px solid black; border-bottom: 1px solid black; display:inline-block;" class="col-12">
						<div style="display:inline-block; width:100%;" id="mf_sigpad_7">
							<div class="mf_sig_wrapper medium">
					          <canvas class="mf_canvas_pad" width="309" height="129"></canvas>
					          <input type="hidden" name="output" id="output" class="output"/>
					        </div>
					        <script type="text/javascript">
								$(function(){
									var sigpad_options_7 = {
						               drawOnly : false,
						               displayOnly: true,
						               clear: '.element_7_clear',
						               bgColour: '#fff',
						               penColour: '#000',
						               output: '#output',
						               lineTop: 95,
						               lineMargin: 10,
						               validateFields: false
						        	};
						        	var sigpad_data_7 = <?php echo $row['signature']?>;
						      		$('#mf_sigpad_7').signaturePad(sigpad_options_7).regenerate(sigpad_data_7);
								});
							</script>
						</div>
					</div>
					<div class="col-12">
						<h3>Firma y sello del taller</h3>
					</div>
				</div>
				<div style="float:right;" class="col-6">
					
						<div style="border-right:1px solid black; float:left;" class="col-8">
							<h2>Próximo mantenimiento a los:</h2>
						</div>
						<div style="float:right;" class="col-4">
							<h2><?php echo number_format($row['nextMileage'],0,",","."). ' '. "kms"?></h2>
						</div>
					
					<div style="border-top: 1px solid black; display: inline-block;" class="col-12">
						<h1 style="margin-top: 3px; height: 133px;"></h1>
					</div>
					<div class="col-12">
						<h3>Firma del cliente</h3>
					</div>
				</div>
			</div>
		</div>
		<?php
		}
		file_put_contents('printcc.html', ob_get_contents());
		?>
		<!--	
		<br><br>
		<a href=index.php>Reiniciar otro certificado</a>

		<br><br> -->

		<!-- <div id="footer">
					Copyright &copy; 2016 <a href="http://www.servitalleres.com" target="_blank">Servitalleres</a>
		</div> -->
		<!-- <div class="mockup-overlay">
			<img src="img/certificado_control_calidad.png">
		</div> -->
	</div>
	<div style="margin: 10px 10px;">
	<?php $doc1 = $doc;?>
		<form method="post" action="print_pdf.php">
			<th width='60' align='center'>
				<input type="submit" name="pdf" value="Imprimir en PDF">
				<input type="hidden" name="doc1" value="<?php echo $doc1;?>" >
			</th>
		</form>
	</div>	 
</body>
</html>