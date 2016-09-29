<?php
//Verify if session started, else redirect to login.php
session_start();
if (!$_SESSION['logged']) {
	header("Location: login.php");
	exit;
}
echo "Bienvenido, ".$_SESSION['username'];
echo "<br><br>";
// echo session_id();
// echo "<br><br>";
echo "<a href=login.php>Cerrar Sesión</a>";

//Control session timeout to logout after 30 minutes of last login
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
    // last request was more than 30 minutes ago
    session_unset();     // unset $_SESSION variable for the run-time 
    session_destroy();   // destroy session data in storage
}
$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp

//Change session ID periodically to avoid attacks on sessions
if (!isset($_SESSION['CREATED'])) {
    $_SESSION['CREATED'] = time();
} else if (time() - $_SESSION['CREATED'] > 10) {
    // session started more than 10 minutes ago
    session_regenerate_id(true);    // change session ID for the current session and invalidate old session ID
    $_SESSION['CREATED'] = time();  // update creation time
}
// var_dump($_SESSION['LAST_ACTIVITY']);
// var_dump($_SESSION['CREATED']);

//
require 'connect_db.php'; //Database connection
require 'data_check.php'; //Input field data check file
require_once 'save_data.php'; //Save input to database
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta http-equiv="cache-control" content="no-cache"> <!-- tells browser not to cache -->
	<meta http-equiv="expires" content="0"> <!-- says that the cache expires 'now' -->
	<meta http-equiv="pragma" content="no-cache"> <!-- says not to use cached stuff, if there is any -->
	<title>Inspección Visual Mecánica y Colisión</title>
	<link rel="stylesheet" type="text/css" href="css/style.css" media="all">
	<link rel="stylesheet" type="text/css" href="css/view.mobile.css" media="all"/>
	<link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
	<script type="text/javascript" src="js/view.js"></script>
	<script type="text/javascript" src="js/calendar.js"></script>
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/jquery.effects.core.js"></script>
	<!--[if lt IE 9]><script src="js/signaturepad/flashcanvas.js"></script><![endif]-->
	<script type="text/javascript" src="js/signaturepad/jquery.signaturepad.min.js"></script>
	<script type="text/javascript" src="js/signaturepad/json2.min.js"></script>
	<script type="text/javascript" src="js/checklength.js"></script>
		<script type="text/javascript" src="js/jquery.mockjax.js"></script>
    <script type="text/javascript" src="js/jquery.autocomplete.js"></script>
    <script type="text/javascript" src="js/names.js"></script>
    <script type="text/javascript" src="js/suggestions.js"></script>
	<script type="text/javascript"> // Drop-down dependent menus script
		function AjaxFunction()
		{
		var httpxml;
		try
		  {
		  // Firefox, Opera 8.0+, Safari
		  httpxml=new XMLHttpRequest();
		  }
		catch (e)
		  {
		  // Internet Explorer
				  try
		   			 		{
		   				 httpxml=new ActiveXObject("Msxml2.XMLHTTP");
		    				}
		  			catch (e)
		    				{
		    			try
		      		{
		      		httpxml=new ActiveXObject("Microsoft.XMLHTTP");
		     		 }
		    			catch (e)
		      		{
		      		alert("Your browser does not support AJAX!");
		      		return false;
		      		}
		    		}
		  	}
			function stateck() 
			    {
			    if(httpxml.readyState==4)
			      {
			//alert(httpxml.responseText);
			var myarray = JSON.parse(httpxml.responseText);
			// Remove the options from 2nd dropdown list 
			for(j=document.testform.subcat.options.length-1;j>=0;j--)
			{
				document.testform.subcat.remove(j);
			}


			for (i=0;i<myarray.data.length;i++)
			{
				var optn = document.createElement("OPTION");
				optn.text = myarray.data[i].subcategory;
				optn.value = myarray.data[i].subcategory;  // You can change this to subcategory 
				document.testform.subcat.options.add(optn);

			} 
			      }
			    } // end of function stateck
			var url="dd.php";
			var cat_id=document.getElementById('s1').value;
			url=url+"?category="+cat_id;
			url=url+"&sid="+Math.random();
			httpxml.onreadystatechange=stateck;
			//alert(url);
			httpxml.open("GET",url,true);
			httpxml.send(null);
			  }
	</script>
</head>
<body id="main_body" >
	<img id="top" src="img/top.png" alt="">
	<div id="form_container">
		<h1><a>Inspección Visual Mecánica y Colisión</a></h1>
			<form name="testform" id="form_1134337" class="appnitro" method="post" action="">
			<div class="header-image">
				<a href="http://servitalleres.com" target="_blank"><img src="img/logo.png"></a>
			</div>
			<div class="form_description">
				<h2>Inspección Visual Mecánica y Colisión</h2>
				<p>Revisión de 50 puntos de Inspección Visual Mecánica y Colisión</p>
			</div>						
			<ul >
			<li id="li_2">
				<div class="reset">
					<a href="index.php">Dar click para iniciar un certificado de inspección</a>
					<!-- <span class="error">* Favor oprimir para comenzar</span> -->
				</div>
				<div class="search">
					<a href="search.php">Dar click para buscar un certificado de inspección</a>
				</div>
			</li>
		<li id="li_6" >
		<label class="description" for="element_6">Fecha </label>
		<span>
			<input id="element_6_1" name="month" class="element text" size="2" maxlength="2" value="<?php echo $month;?>" type="text"> /
			<label for="element_6_1">MM</label>
			<span><?php echo $dateErr;?></span>
		</span>
		<span>
			<input id="element_6_2" name="day" class="element text" size="2" maxlength="2" value="<?php echo $day;?>" type="text"> /
			<label for="element_6_2">DD</label>
		</span>
		<span>
	 		<input id="element_6_3" name="year" class="element text" size="4" maxlength="4" value="<?php echo $year;?>" type="text">
			<label for="element_6_3">AAAA</label>
		</span>
	
		<span id="calendar_6">
			<img id="cal_img_6" class="datepicker" src="img/calendar.gif" alt="Pick a date.">	
		</span>
		<script type="text/javascript">
			Calendar.setup({
			inputField	 : "element_6_3",
			baseField    : "element_6",
			displayArea  : "calendar_6",
			button		 : "cal_img_6",
			ifFormat	 : "%B %e, %Y",
			onSelect	 : selectDate
			});
		</script>
		</li>
		<li id="li_2" >
		<label class="description" for="element_7">Asesor de servicio </label>
		<span>
			<input onKeyPress=check_length_6(this.form); onKeyDown=check_length_6(this.form); id="element_7_1" name= "firstname1" class="element text" maxlength="255" size="15" value="<?php echo $firstname1;?>"/>
			<label>Nombre</label>
			<input size=1 value=9 name=text_num_6 style="display:none; float:right; text-align:right;">
			<span><?php echo $nameErr1;?></span>
		</span>
		<span>
			<input onKeyPress=check_length_7(this.form); onKeyDown=check_length_7(this.form); id="element_7_2" name= "lastname1" class="element text" maxlength="255" size="15" value="<?php echo $lastname1;?>"/>
			<label>Apellido</label>
			<input size=1 value=11 name=text_num_7 style="display:none; float:right; text-align:right;">
			<span><?php echo $last_nameErr1;?></span>
		</span> 
		</li>
		<li class="section_break">
		<p></p>
		</li>	
		<li id="li_2" >
		<label class="description" for="element_2">Cliente </label>
		<span>
			<input onKeyPress=check_length_8(this.form); onKeyDown=check_length_8(this.form); id="element_2_1" name= "firstname" class="element text" maxlength="255" size="15" value="<?php echo $firstname;?>"/>
			<label>Nombre(s)</label>
			<input size=1 value=12 name=text_num_8 style="display:none; float:right; text-align:right;">
			<span><?php echo $nameErr;?></span>
		</span>
		<span>
			<input onKeyPress=check_length_9(this.form); onKeyDown=check_length_9(this.form); id="element_2_2" name= "lastname" class="element text" maxlength="255" size="15" value="<?php echo $lastname;?>"/>
			<label>Apellido</label>
			<input size=1 value=11 name=text_num_9 style="display:none; float:right; text-align:right;">
			<span><?php echo $last_nameErr;?></span>
		</span> 
		</li>
		<li id="li_8" >
			<label class="description" for="element_4">Cédula </label>
			<div>
				<input id="element_8" name="idnumber" class="element text medium" type="text" maxlength="255" value="<?php echo $idnumber;?>"/> 
				<span><?php echo $idErr;?></span>
			</div> 
		</li>
		<li id="li_10" >
			<label class="description" for="element_4">Teléfono </label>
			<div>
				<input id="element_10" name="phone" class="element text medium" type="text" maxlength="255" value="<?php echo $phone;?>"/> 
				<span><?php echo $phoneErr;?></span>
			</div> 
		</li>
		<li id="li_9" >
			<label class="description" for="element_9">Correo electrónico </label>
			<div>
				<input onKeyPress=check_length_10(this.form); onKeyDown=check_length_10(this.form); id="element_9" name="email" class="element text medium" type="text" maxlength="255" value="<?php echo $email;?>"/>
				<input size=1 value=33 name=text_num_10 style="display:none; float:right; text-align:right;"> 
				<span><?php echo $emailErr;?></span>
			</div> 
		</li>	
		<li id="li_15" >
			<label class="description" for="element_15">Marca </label>
		<div>
		 	<?php
			echo "<select class='element select medium' name=cat id='s1' onchange=AjaxFunction();><option value=''></option>";

			$sql="select * from category "; // Query to collect data from table 

			foreach ($dbo->query($sql) as $row) {
			echo "<option value=$row[category]>$row[category]</option>";
			}	
			?>
			</select>
			<span><?php echo $makeErr;?></span>
		</div> 
		</li>		
		<li id="li_16" >
			<label class="description" for="element_16">Línea </label>
		<div>
			<select class='element select medium' name=subcat id='s2'>
			</select>
			<span><?php echo $lineErr;?></span>
		</div> 
		</li>		<li id="li_4" >
		<label class="description" for="element_4">Modelo </label>
		<div>
			<input id="element_4" name="model" class="element text medium" type="text" maxlength="255" value="<?php echo $model;?>"/> 
			<span><?php echo $modelErr;?></span>
		</div> 
		</li>		<li id="li_5" >
		<label class="description" for="element_5">Placas </label>
		<div>
			<input id="element_5" name="license" class="element text medium" type="text" maxlength="255" value="<?php echo $license;?>"/> 
			<span><?php echo $licenseErr;?></span>
		</div> 
		</li>		<li id="li_12" >
		<label class="description" for="element_12">Kilometraje </label>
		<div>
			<input id="element_12" name="mileage" class="element text medium" type="text" maxlength="255" value="<?php echo $mileage;?>"/> 
			<span><?php echo $mileageErr;?></span>
		</div> 
		</li>		
		<li class="section_break">
		<p></p>
		</li>
		<?php
		require('lists.php');
		foreach ($names as $mat => $name) {
			if ($mat < 9) {	
				echo "<li class=matrix>
				<table>
					<caption>
							$name 
					</caption>
				   <thead>
				    	<tr>
				        	<th style=width:40% scope=col><span style=display:none>$name</span></th>
				            <th id=mc_3_2 style=width:15% scope=col>B</th>
				            <th id=mc_3_3 style=width:15% scope=col>R</th>
							<th id=mc_3_4 style=width:15% scope=col>M</th>
							<th id=mc_3_5 style=width:15% scope=col>N/A</th>
				        </tr>
				    </thead>
				    <tbody>";
				    for ($i=1; $i <= count($list[$mat]) ; $i++) {
				    	$element = $list[$mat][$i]; 
				    	echo "<tr class=alt> 
				    		<td class=first_col>$element</td>";
				    	for ($j=1; $j < 5; $j++) { 
			            	echo "<td><label style= display:none for=element_3_$j>$loptions[$j]</label><input id=element$j name=$elNames[$mat][$i] type=radio value=$j /></td>";
				    	}
				    	echo "</tr>";
				   	}
			}
			elseif ($mat == 9) {	
				echo "<li class=matrix>
				<table>
					<caption>
							$name 
					</caption>
				   <thead>
				    	<tr>
				        	<th style=width:40% scope=col><span style=display:none>$name</span></th>
				            <th id=mc_3_2 style=width:15% scope=col>25</th>
				            <th id=mc_3_3 style=width:15% scope=col>50</th>
							<th id=mc_3_4 style=width:15% scope=col>75</th>
							<th id=mc_3_5 style=width:15% scope=col>100</th>
				        </tr>
				    </thead>
				    <tbody>";
				    for ($i=1; $i <= count($list[$mat]) ; $i++) {
				    	$element = $list[$mat][$i]; 
				    	echo "<tr class=alt> 
				    		<td class=first_col>$element</td>";
				    	for ($j=1; $j < 5; $j++) { 
			            	echo "<td><label style= display:none for=element_3_$j>$loptions1[$j]</label><input id=element$j name=$elNames[$mat][$i] type=radio value=$j /></td>";
				    	}
				    	echo "</tr>";
				   	}
			}
			elseif ($mat == 10) { 
				echo "<li class=matrix>
				<table>
					<caption>
							$name 
					</caption>
				   <thead>
				    	<tr>
				        	<th style=width:40% scope=col><span style=display:none>$name</span></th>
				            <th id=mc_3_2 style=width:15% scope=col>30</th>
				            <th id=mc_3_3 style=width:15% scope=col>32</th>
							<th id=mc_3_4 style=width:15% scope=col>34</th>
							<th id=mc_3_5 style=width:15% scope=col>36</th>
				        </tr>
				    </thead>
				    <tbody>";
				    for ($i=1; $i <= count($list[$mat]) ; $i++) {
				    	$element = $list[$mat][$i]; 
				    	echo "<tr class=alt> 
				    		<td class=first_col>$element</td>";
				    	for ($j=1; $j < 5; $j++) { 
			            	echo "<td><label style= display:none for=element_3_$j>$loptions2[$j]</label><input id=element$j name=$elNames[$mat][$i] type=radio value=$j /></td>";
				    	}
				    	echo "</tr>";
				   	}
			}
			else {
				echo "<li class=matrix>
				<table>
					<caption>
							$name 
					</caption>
				   <thead>
				    	<tr>
				        	<th style=width:40% scope=col><span style=display:none>$name</span></th>
				            <th id=mc_3_2 style=width:15% scope=col>B</th>
				            <th id=mc_3_3 style=width:15% scope=col>R</th>
							<th id=mc_3_4 style=width:15% scope=col>M</th>
							<th id=mc_3_5 style=width:15% scope=col>N/A</th>
				        </tr>
				    </thead>
				    <tbody>";
				    for ($i=1; $i <= count($list[$mat]) ; $i++) {
				    	$element = $list[$mat][$i]; 
				    	echo "<tr class=alt> 
				    		<td class=first_col>$element</td>";
				    	for ($j=1; $j < 5; $j++) { 
			            	echo "<td><label style= display:none for=element_3_$j>$loptions[$j]</label><input id=element$j name=$elNames[$mat][$i] type=radio value=$j /></td>";
				    	}
				    	echo "</tr>";
				   	}
			}	
				?>    
			    </tbody>
			</table>
			<div>
				<span><?php echo $errorNames[$mat];?></span>
			</div>
		<?php
		}
		?>		
		<li class="section_break">
		<p></p>
		</li>
			<h3 style="font-weight:bold">Semáforo</h3>
		<p></p>
		<br>
		<?php
			foreach ($lcomments as $com => $name) {
			echo "<li>
				<label class=description for=element_2$mat>$name</label>
				<div>
					<textarea onKeyPress=check_length_$com(this.form); onKeyDown=check_length_$com(this.form); id=element_2$com name=$comNames[$com] class=textarea>$comVariables[$com]</textarea> 
					<br>
					<div class=count-chars>
						<input size=1 value=400 name=text_num_$com style=float:right>
					</div>
					<span>$errorNames1[$com]</span>
				</div>";
			}
			?>		
		<li class="section_break">
			<p></p>
		</li>				
		<li id="li_7"  >
		<label class="description" for="output">Firma del asesor de servicio: </label>
		<div id="mf_sigpad_7">
			<div class="mf_sig_wrapper medium">
	          <canvas class="mf_canvas_pad" width="309" height="130"></canvas>
	          <input type="hidden" name="output" id="output" class="output">
	        </div>
	        <span><?php echo $signatureErr;?></span> 
	        <a class="mf_sigpad_clear element_7_clear" href="#">Borrar</a>
	        <script type="text/javascript">
				$(function(){
					var sigpad_options_7 = {
		               drawOnly : true,
		               displayOnly: false,
		               clear: '.element_7_clear',
		               bgColour: '#fff',
		               penColour: '#000',
		               output: '#output',
		               lineTop: 95,
		               lineMargin: 10,
		               validateFields: false
		        	};
		        	var sigpad_data_7 = [];
		      		$('#mf_sigpad_7').signaturePad(sigpad_options_7);
				});
			</script> 
		</div> 
		</li>
		<li class="buttons">
			    <input type="hidden" name="form_id" value="1134337" />
			    
				<input id="saveForm" class="button_text" type="submit" name="submit" value="Enviar" />
		</li>
		</ul>
		<br>	
		</form>	
		<div id="footer">
			Copyright &copy; 2016 <a href="http://www.servitalleres.com" target="_blank">Servitalleres</a>
		</div>
	</div>
	<img id="bottom" src="img/bottom.png" alt="">
	<script type="text/javascript" src="js/scrolltotop.js"></script>
	<a href="#" class="scrollToTop"></a>
	<script type="text/javascript" src="js/refresh.js"></script>
	</body>
</html>
