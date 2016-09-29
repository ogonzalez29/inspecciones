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
		<title>Inspección Visual Mecánica y Colisión</title>
		<link rel="stylesheet" type="text/css" href="css/view1.css"/>
		<script type="text/javascript" src="http://d3js.org/d3.v3.min.js"></script>
		<script type="text/javascript" src="js/jquery.min.js"></script>
		<script type="text/javascript" src="js/signaturepad/jquery.signaturepad.min.js"></script>
		<script type="text/javascript" src="js/signaturepad/json2.min.js"></script>
	</head>
	<body>
	<?php
		//set search variable to find results from database
		@$search3 = $_SESSION['cons3'];
		@$doc3 = $_POST['doc3']-3000;

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
		//loop through results of database query, displaying them in the format
		while ($row3 = mysql_fetch_array($result3)) {
	?>
	<div class="grid">
		<div class="row">
			<div class="col-12">
				<div style="padding: 5px 2px 2px 2px;" class="col-12">
					<img src="img/logo.png" alt="logo servitalleres"/>
					<div style="float:right; color:red;" class="col-1_1">
						<h2 style="text-align:right;"><?php echo 'N. '. ($row3['id']+3000)?></h2>
					</div>
				</div>
				<div style="text-align: center;" class="col-12">
					<h1>INSPECCIÓN VISUAL DE MECÁNICA Y COLISIÓN</h1>
				</div>
			</div>
		</div>
		<div class="row-9">
			<div class="col-12">
				<div class="col-08">
					<h3 style="font-weight: bold">Fecha:</h3>
				</div>
				<div class="col-1_1">
					<h3 style="border-bottom:1px solid black"><?php echo $row3['day']. '/'. $row3['month']. '/'. $row3['year']?></h3>
				</div>
				<div class="col-2_3">
					<h3 style="font-weight: bold">Asesor de Servicio:</h3>
				</div>
				<div class="col-2_3">
					<h3 style="border-bottom:1px solid black"><?php echo $row3['firstname1']. ' '. $row3['lastname1']?></h3>
				</div>
			</div>
		</div>
		<div class="row-1">
			<div class="col-12">
				<div class="col-08">
					<h3 style="font-weight: bold;">Cliente:</h3>
				</div>
				<div class="col-2">
					<h3 style="border-bottom:1px solid black"><?php echo $row3['firstname']. ' '. $row3['lastname']?></h3>
				</div>
				<div class="col-08">
					<h3 style="font-weight: bold;">Cédula:</h3>
				</div>
				<div class="col-1_4">
					<h3 style="border-bottom:1px solid black"><?php echo number_format($row3['idnumber'],0,",",".")?></h3>
				</div>
				<div class="col-09">
					<h3 style="font-weight: bold;">Teléfono:</h3>
				</div>
				<div class="col-1_5">
					<h3 style="border-bottom:1px solid black"><?php echo $row3['phone']?></h3>
				</div>
				<div class="col-07">
					<h3 style="font-weight: bold;">Email:</h3>
				</div>
				<div class="col-3_1">
					<h3 style="border-bottom:1px solid black"><?php echo $row3['email']?></h3>
				</div>
			</div>
		</div>
		<div class="row-2">
			<div class="col-12">
				<div class="col-07">
					<h3 style="font-weight: bold;">Marca:</h3>
				</div>
				<div class="col-1_6">
					<h3 style="border-bottom:1px solid black"><?php echo $row3['make']?></h3>
				</div>
				<div class="col-08">
					<h3 style="font-weight: bold;">Linea:</h3>
				</div>
				<div class="col-1_5">
					<h3 style="border-bottom:1px solid black"><?php echo $row3['type']?></h3>
				</div>
				<div class="col-09">
					<h3 style="font-weight: bold;">Modelo:</h3>
				</div>
				<div class="col-07">
					<h3 style="border-bottom:1px solid black"><?php echo $row3['model']?></h3>
				</div>
				<div class="col-08">
					<h3 style="font-weight: bold;">Placa:</h3>
				</div>
				<div class="col-08">
					<h3 style="border-bottom:1px solid black"><?php echo $row3['license']?></h3>
				</div>
				<div class ="col-1_5">
					<h3 style="font-weight: bold;">Kilometraje:</h3>
				</div>
				<div class ="col-08">
					<h3 style="border-bottom:1px solid black"><?php echo number_format($row3['mileage'],0,",",".")?></h3>
				</div>	
			</div>
		</div>
		<div class="row-3">
			<div style="text-align: center;" class="col-12">
				<h2>PUNTOS DE INSPECCIÓN</h2>
			</div>
		</div>
		<div class="row-4">
			<div class="col-12">
				<div style="float:left;" class="col-6">
					<?php
						require ('lists.php');
						$k=0;
						foreach ($names as $mat => $name) {
							if ($mat <= 5) {
								echo "<table>
									<thead>
										<tr style=height:21px>
											<th style=width:55% scope=col><span>$name</span></th>
								            <th  style=width:10% scope=col>B</th>
											<th  style=width:10% scope=col>R</th>
											<th  style=width:10% scope=col>M</th>
											<th  style=width:10% scope=col>N/A</th>
										</tr>
									</thead>
									<tbody>";
									for ($i=1; $i <= count($list[$mat]) ; $i++) {
								    	$concept = $list[$mat][$i];
								    	$matrix = $matrixNames[$mat][$i];
								    	echo "<tr class=alt> 
								    		<td class=first_col>$concept</td>";
								    	for ($j=1; $j < 5; $j++) {
								    		if(isset($row3[$matrix]) && $row3[$matrix]==$j){
								    			$check[$j] = "checked";
								    		}
								    		else {
								    			$check[$j] = "";
								    		} 
							            	echo "<td><label style= display:none for=element_3_$j>$loptions[$j]</label><input id=element$j name=$elNames[$mat][$i] type=radio value=$j $check[$j]/></td>";
								    	}
								    	echo "</tr>";
					   					$k++;
					   					if ($mat==5 && $k==30) {
									   	 	break;
									    }
				   					}
				   			}
						}
						?>
							</tbody>
					</table>
				</div>
				<div style="float:right;" class="col-6">
					<?php
						require ('lists.php');
						foreach ($names as $mat => $name) {
							if ($mat == 5) {
								echo "<table>
									<thead>
										<tr style=height:21px>
											<th style=width:55% scope=col><span style=display:none>$name</span></th>
								            <th  style=width:10% scope=col>B</th>
											<th  style=width:10% scope=col>R</th>
											<th  style=width:10% scope=col>M</th>
											<th  style=width:10% scope=col>N/A</th>
										</tr>
									</thead>
									<tbody>";
									for ($i=3; $i <= count($list[$mat]) ; $i++) {
								    	$concept = $list[$mat][$i];
								    	$matrix = $matrixNames[$mat][$i];
								    	echo "<tr class=alt> 
								    		<td class=first_col>$concept</td>";
								    	for ($j=1; $j < 5; $j++) {
								    		if(isset($row3[$matrix]) && $row3[$matrix]==$j){
								    			$check[$j] = "checked";
								    		}
								    		else {
								    			$check[$j] = "";
								    		} 
							            	echo "<td><label style= display:none for=element_3_$j>$loptions[$j]</label><input id=element$j name=$elNames[$mat][$i] type=radio value=$j $check[$j]/></td>";
								    	}
								    	echo "</tr>";
				   					}
				   			}
				   			if ($mat > 5) {
								echo "<table>
									<thead>
										<tr style=height:21px>
											<th style=width:55% scope=col><span>$name</span></th>
								            <th  style=width:10% scope=col>B</th>
											<th  style=width:10% scope=col>R</th>
											<th  style=width:10% scope=col>M</th>
											<th  style=width:10% scope=col>N/A</th>
										</tr>
									</thead>
									<tbody>";
									for ($i=1; $i <= count($list[$mat]) ; $i++) {
								    	$concept = $list[$mat][$i];
								    	$matrix = $matrixNames[$mat][$i];
								    	echo "<tr class=alt>
								    		<td class=first_col>$concept</td>";
								    	for ($j=1; $j < 5; $j++) {
								    		if(isset($row3[$matrix]) && $row3[$matrix]==$j){
								    			$check[$j] = "checked";
								    		}
								    		else {
								    			$check[$j] = "";
								    		} 
							            	echo "<td><label style= display:none for=element_3_$j>$loptions[$j]</label><input id=element$j name=$elNames[$mat][$i] type=radio value=$j $check[$j]/></td>";
								    	}
								    	echo "</tr>";
				   					}
							}
						}
						?>
							</tbody>
					</table>
				</div>
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
							<text x="40%" y="50%" text-anchor="middle" stroke="#1A1A1A" stroke-width="0.5px" dy=".3em"><?php echo $lcomments[1];?></text>
						</svg>
						<svg>
							<circle cx="40%" cy="50%" r="50" stroke="yellow" stroke-width="3" fill="yellow" />
							<text x="40%" y="50%" text-anchor="middle" stroke="#1A1A1A" stroke-width="0.5px" dy=".3em"><?php echo $lcomments[2];?></text>
						</svg>
						<svg>
							<circle cx="40%" cy="50%" r="50" stroke="green" stroke-width="3" fill="green" />
							<text x="40%" y="50%" text-anchor="middle" stroke="#1A1A1A" stroke-width="0.5px" dy=".3em"><?php echo $lcomments[3];?></text>
						</svg>
						<h2 style="padding-right: 30px;"><?php echo $lcomments[4].':';?></h2>
						<h2 style="padding-right: 30px; padding-top: 100px"><?php echo $lcomments[5].':';?></h2>

					</div>
				</div>
				<div style="float:right;" class="col-9">
					<div style="text-align:center" class="col-12">
						<h2>Comentarios</h2>
						<?php
						require('lists.php');
						foreach ($lcomments as $com => $value) {
							$comment= $comNames[$com];
							$comments= $row3[$comment];
							echo "<div style='border-bottom:1px solid black' class=col-12>
								<div id=comments class=col-12>
									<h3>$comments</h3>
								</div>
								</div>";		
						}
						?>
					</div>
				</div>
			</div>
		</div>
		<div class="footer">
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
			        	var sigpad_data_7 = <?php echo $row3['signature']?>;
			      		$('#mf_sigpad_7').signaturePad(sigpad_options_7).regenerate(sigpad_data_7);
					});
				</script>
			</div>
			<div class="col-12">
				<h3>Firma y sello del taller</h3>
			</div>
		</div>
		<div class="row-8">
			<div style="text-align: center;" class="col-12">
				<h2 style="margin-bottom:0px;">IMPORTANTE:</h2>
			</div>
						<div style="text-align: center;" class="col-12">
				<h3>Los controles realizados son únicamente sobre los elementos visibles del vehículo y no implican desmontaje alguno, por lo tanto el taller no asume responsabilidad en caso de la no detección de una falla no aparente.</h3>
			</div>
		</div>
		<?php
		}
		file_put_contents('printi.html', ob_get_contents());
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
	<?php $doc4 = $doc3;?>
		<form method="post" action="print_pdf.php">
			<th width='60' align='center'>
				<input type="submit" name="pdf" value="Imprimir en PDF">
				<input type="hidden" name="doc4" value="<?php echo $doc4;?>" >
			</th>
		</form>
	</div>	 
</body>
</html>