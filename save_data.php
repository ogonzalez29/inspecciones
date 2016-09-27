<?php

include ('info.php'); //Database connection

$errors_array = array_filter($errors);

 if (isset($_POST['submit'])) {

 	//Header information of print_cc.php 
 	$day = $_POST['day'];
 	$month = $_POST['month'];
 	$year = $_POST['year'];
 	$firstname1 = mysql_real_escape_string(htmlspecialchars($_POST['firstname1']));
 	$lastname1 = mysql_real_escape_string(htmlspecialchars($_POST['lastname1']));
 	$firstname = mysql_real_escape_string(htmlspecialchars($_POST['firstname']));
 	$lastname = mysql_real_escape_string(htmlspecialchars($_POST['lastname']));
 	$idnumber = mysql_real_escape_string(htmlspecialchars($_POST['idnumber']));
 	$phone = mysql_real_escape_string(htmlspecialchars($_POST['phone']));
 	$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
 	@$make = $_POST['cat'];
 	@$line = $_POST['subcat'];
 	$model = mysql_real_escape_string(htmlspecialchars($_POST['model']));
 	$license = mysql_real_escape_string(htmlspecialchars($_POST['license']));
 	$mileage = mysql_real_escape_string(htmlspecialchars($_POST['mileage']));
 	
 	//Sanitize names and lastnames to store in database properly
 	$firstname1 = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($firstname1))));
 	$lastname1 = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($lastname1))));
 	$firstname = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($firstname))));
	$lastname = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($lastname))));

 	require('lists.php');
 	
 	foreach ($names as $mat => $name) {
 		if ($mat == 1) {
 			//Matrix 1 information of print_i.php (Alumbrado exterior)
		 	for ($i=1; $i <= count($list[1]) ; $i++) {
		 		@$$matrixNames[$mat][$i] = $_POST['matrix_1'][$i];
			}
 		}
		 	
 		if ($mat == 2) {
 			//Matrix 2 information of print_i.php (Emisiones audibles)
		 	for ($j=1; $j <= count($list[2]) ; $j++) {
		 		@$$matrixNames[$mat][$j] = $_POST['matrix_2'][$j];
			}
 		}
		
 		if ($mat == 3) {
 			//Matrix 3 information of print_i.php (Suspensión)
		  	for ($k=1; $k <= count($list[3]) ; $k++) {
		 		@$$matrixNames[$mat][$k] = $_POST['matrix_3'][$k];
			}
 		}
			
 		if ($mat == 4) {
 			//Matrix 4 information of print_i.php (Estabilidad y dirección)
		  	for ($l=1; $l <= count($list[4]) ; $l++) {
		 		@$$matrixNames[$mat][$l] = $_POST['matrix_4'][$l];
			}
 		}

 		if ($mat == 5) {
 			//Matrix 5 information of print_i.php (Compartimiento motor)
		  	for ($m=1; $m <= count($list[5]) ; $m++) {
		 		@$$matrixNames[$mat][$m] = $_POST['matrix_5'][$m];
			}
 		}

 		if ($mat == 6) {
 			//Matrix 6 information of print_i.php (Frenos)
		  	for ($n=1; $n <= count($list[6]) ; $n++) {
		 		@$$matrixNames[$mat][$n] = $_POST['matrix_6'][$n];
			}
 		}

 		if ($mat == 7) {
 			//Matrix 7 information of print_i.php (Accesorios y equipamento)
		   	for ($o=1; $o <= count($list[7]) ; $o++) {
		 		@$$matrixNames[$mat][$o] = $_POST['matrix_7'][$o];
			}
 		}

 		if ($mat == 8) {
 			//Matrix 8 information of print_i.php (Documentos del vehículo)
		   	for ($p=1; $p <= count($list[8]) ; $p++) {
		 		@$$matrixNames[$mat][$p] = $_POST['matrix_8'][$p];
			}
 		}
		
 		if ($mat == 9) {
 			//Matrix 9 information of print_i.php (Desgaste de las llantas (%))
		   	for ($q=1; $q <= count($list[9]) ; $q++) {
		 		@$$matrixNames[$mat][$q] = $_POST['matrix_9'][$q];
			}
 		}

 		if ($mat == 10) {
 			//Matrix 10 information of print_i.php (Presión de llantas (psi))
		   	for ($r=1; $r <= count($list[10]) ; $r++) {
		 		@$$matrixNames[$mat][$r] = $_POST['matrix_10'][$r];
			}
 		}

 		if ($mat == 11) {
 			//Matrix 10 information of print_i.php (Presión de llantas (psi))
		   	for ($s=1; $s <= count($list[10]) ; $s++) {
		 		@$$matrixNames[$mat][$s] = $_POST['matrix_11'][$s];
			}
 		}
	}

	//Footer information of print_cc.php
	$comment1 = $_POST['comment1'];
	$comment2 = $_POST['comment2'];
	$comment3 = $_POST['comment3'];
	$comment4 = $_POST['comment4'];
	$comment5 = $_POST['comment5'];

	//Comments sanitizing for storing in database properly
	//1. Make everything lowercase and then make the first letter if the entire string capitalized
	$comment1 = ucfirst(strtolower($comment1));
	$comment2 = ucfirst(strtolower($comment2));
	$comment3 = ucfirst(strtolower($comment3));
	$comment4 = ucfirst(strtolower($comment4));
	$comment5 = ucfirst(strtolower($comment5));

	//2. Run the function to capitalize every letter after a full-stop (period).
	$comment1 = preg_replace_callback('/[.!?].*?\w/', create_function('$matches', 'return strtoupper($matches[0]);'), $comment1);
	$comment2 = preg_replace_callback('/[.!?].*?\w/', create_function('$matches', 'return strtoupper($matches[0]);'), $comment2);
	$comment3 = preg_replace_callback('/[.!?].*?\w/', create_function('$matches', 'return strtoupper($matches[0]);'), $comment3);
	$comment4 = preg_replace_callback('/[.!?].*?\w/', create_function('$matches', 'return strtoupper($matches[0]);'), $comment4);
	$comment5 = preg_replace_callback('/[.!?].*?\w/', create_function('$matches', 'return strtoupper($matches[0]);'), $comment5);

	//Signature information of print_cc.php
	$signature = filter_input(INPUT_POST, 'output', FILTER_UNSAFE_RAW);

	// Create some other pieces of information about the user
    //  to confirm the legitimacy of their signature
    $sig_hash = sha1($signature);
    $created = time();
    $ip = $_SERVER['REMOTE_ADDR'];

	if (!empty($errors_array)) {
		echo "<form method=post action='index.php'>";
	}
	else{
		mysql_query("INSERT document3 SET day='$day', 
										 month='$month', 
										 year='$year',
										 firstname1='$firstname1', 
										 lastname1='$lastname1',
										 firstname='$firstname', 
										 lastname='$lastname',
										 idnumber='$idnumber',
										 phone='$phone',
										 email='$email',  
										 make='$make',
										 type='$line',
										 model='$model', 
										 license='$license',
										 mileage='$mileage',
										 m1_el1='$m1_el1',
										 m1_el2='$m1_el2',	 
										 m1_el3='$m1_el3',
										 m1_el4='$m1_el4',
										 m1_el5='$m1_el5',
										 m1_el6='$m1_el6',
										 m1_el7='$m1_el7',
										 m1_el8='$m1_el8',
										 m1_el9='$m1_el9',
										 m1_el10='$m1_el10',
										 m1_el11='$m1_el11',
										 m1_el12='$m1_el12',
										 m2_el1='$m2_el1',
										 m2_el2='$m2_el2',	 
										 m3_el1='$m3_el1',
										 m3_el2='$m3_el2',	 
										 m3_el3='$m3_el3',
										 m3_el4='$m3_el4',
										 m4_el1='$m4_el1',
										 m4_el2='$m4_el2',	 
										 m4_el3='$m4_el3',
										 m4_el4='$m4_el4',
										 m4_el5='$m4_el5',
										 m4_el6='$m4_el6',
										 m4_el7='$m4_el7',
										 m4_el8='$m4_el8',
										 m4_el9='$m4_el9',
										 m4_el10='$m4_el10',
										 m5_el1='$m5_el1',
										 m5_el2='$m5_el2',	 
										 m5_el3='$m5_el3',
										 m5_el4='$m5_el4',
										 m5_el5='$m5_el5',
										 m5_el6='$m5_el6',
										 m6_el1='$m6_el1',
										 m6_el2='$m6_el2',	 
										 m6_el3='$m6_el3',
										 m6_el4='$m6_el4',
										 m6_el5='$m6_el5',
										 m7_el1='$m7_el1',
										 m7_el2='$m7_el2',	 
										 m7_el3='$m7_el3',
										 m7_el4='$m7_el4',
										 m8_el1='$m8_el1',
										 m8_el2='$m8_el2',
										 m9_el1='$m9_el1',
										 m9_el2='$m9_el2',
										 m9_el3='$m9_el3',
										 m9_el4='$m9_el4',
										 m9_el5='$m9_el5',
										 m10_el1='$m10_el1',
										 m10_el2='$m10_el2',
										 m10_el3='$m10_el3',
										 m10_el4='$m10_el4',
										 m10_el5='$m10_el5',
										 m11_el1='$m11_el1',
										 m11_el2='$m11_el2',
										 m11_el3='$m11_el3',
										 comment1='$comment1',
										 comment2='$comment2',
										 comment3='$comment3',
										 comment4='$comment4',
										 comment5='$comment5',
										 signature= '$signature',
										 sig_hash= '$sig_hash',
										 ip= '$ip',
										 created= '$created'
										 ")
 		or die(mysql_error());
		
		header("location: print_i.php");
	}
}
// var_dump($errors_array);
?>