<?php

include ('info.php'); //Database connection

$errors_array = array_filter($errors);

 if (isset($_POST['submit'])) {

 	//Header information of print_cc.php 
 	$day = $_POST['day'];
 	$month = $_POST['month'];
 	$year = $_POST['year'];
 	$ordernumber = mysql_real_escape_string(htmlspecialchars($_POST['ordernumber']));
 	$firstname1 = mysql_real_escape_string(htmlspecialchars($_POST['firstname1']));
 	$lastname1 = mysql_real_escape_string(htmlspecialchars($_POST['lastname1']));
 	$firstname = mysql_real_escape_string(htmlspecialchars($_POST['firstname']));
 	$lastname = mysql_real_escape_string(htmlspecialchars($_POST['lastname']));
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

 	//Matrix 1 information of print_cc.php (instrumentos y equipamento)
 	@$m1_el1 = $_POST['matrix_1'][1];
 	@$m1_el2 = $_POST['matrix_1'][2];
	@$m1_el3 = $_POST['matrix_1'][3];
	@$m1_el4 = $_POST['matrix_1'][4];
	@$m1_el5 = $_POST['matrix_1'][5];
	@$m1_el6 = $_POST['matrix_1'][6];
	@$m1_el7 = $_POST['matrix_1'][7];
	@$m1_el8 = $_POST['matrix_1'][8];
	@$m1_el9 = $_POST['matrix_1'][9];
	@$m1_el10 = $_POST['matrix_1'][10];
	@$m1_el11 = $_POST['matrix_1'][11];
	@$m1_el12 = $_POST['matrix_1'][12];
	@$m1_el13 = $_POST['matrix_1'][13];
	@$m1_el14 = $_POST['matrix_1'][14];
	@$m1_el15 = $_POST['matrix_1'][15];
	@$m1_el16 = $_POST['matrix_1'][16];
	@$m1_el17 = $_POST['matrix_1'][17];

	//Matrix 2 information of print_cc.php (alumbrado exterior)
 	@$m2_el1 = $_POST['matrix_2'][1];
 	@$m2_el2 = $_POST['matrix_2'][2];
	@$m2_el3 = $_POST['matrix_2'][3];
	@$m2_el4 = $_POST['matrix_2'][4];
	@$m2_el5 = $_POST['matrix_2'][5];
	@$m2_el6 = $_POST['matrix_2'][6];

	//Matrix 3 information of print_cc.php (presentación del vehículo)
 	@$m3_el1 = $_POST['matrix_3'][1];
 	@$m3_el2 = $_POST['matrix_3'][2];
	@$m3_el3 = $_POST['matrix_3'][3];

	//Matrix 4 information of print_cc.php (desgaste de las llantas)
 	@$m4_el1 = $_POST['matrix_4'][1];
 	@$m4_el2 = $_POST['matrix_4'][2];
	@$m4_el3 = $_POST['matrix_4'][3];
	@$m4_el4 = $_POST['matrix_4'][4];

	//Matrix 5 information of print_cc.php (presión de las llantas)
 	@$m5_el1 = $_POST['matrix_5'][1];
 	@$m5_el2 = $_POST['matrix_5'][2];
	@$m5_el3 = $_POST['matrix_5'][3];
	@$m5_el4 = $_POST['matrix_5'][4];

	//Matrix 6 information of print_cc.php (control debajo del capot)
 	@$m6_el1 = $_POST['matrix_6'][1];
 	@$m6_el2 = $_POST['matrix_6'][2];
	@$m6_el3 = $_POST['matrix_6'][3];
	@$m6_el4 = $_POST['matrix_6'][4];
	@$m6_el5 = $_POST['matrix_6'][5];
	@$m6_el6 = $_POST['matrix_6'][6];
	@$m6_el7 = $_POST['matrix_6'][7];
	@$m6_el8 = $_POST['matrix_6'][8];
	@$m6_el9 = $_POST['matrix_6'][9];

	//Matrix 7 information of print_cc.php (prueba de ruta)
 	@$m7_el1 = $_POST['matrix_7'][1];
 	@$m7_el2 = $_POST['matrix_7'][2];
	@$m7_el3 = $_POST['matrix_7'][3];
	@$m7_el4 = $_POST['matrix_7'][4];
	@$m7_el5 = $_POST['matrix_7'][5];
	@$m7_el6 = $_POST['matrix_7'][6];
	@$m7_el7 = $_POST['matrix_7'][7];

	//Footer information of print_cc.php
	$comment1 = $_POST['comment1'];
	$comment2 = $_POST['comment2'];
	$comment3 = $_POST['comment3'];
	$comment4 = $_POST['comment4'];
	$nextMileage = mysql_real_escape_string(htmlspecialchars($_POST['nextMileage']));

	//Comments sanitizing for storing in database properly
	//1. Make everything lowercase and then make the first letter if the entire string capitalized
	$comment1 = ucfirst(strtolower($comment1));
	$comment2 = ucfirst(strtolower($comment2));
	$comment3 = ucfirst(strtolower($comment3));
	$comment4 = ucfirst(strtolower($comment4));

	//2. Run the function to capitalize every letter after a full-stop (period).
	$comment1 = preg_replace_callback('/[.!?].*?\w/', create_function('$matches', 'return strtoupper($matches[0]);'), $comment1);
	$comment2 = preg_replace_callback('/[.!?].*?\w/', create_function('$matches', 'return strtoupper($matches[0]);'), $comment2);
	$comment3 = preg_replace_callback('/[.!?].*?\w/', create_function('$matches', 'return strtoupper($matches[0]);'), $comment3);
	$comment4 = preg_replace_callback('/[.!?].*?\w/', create_function('$matches', 'return strtoupper($matches[0]);'), $comment4);

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
		mysql_query("INSERT document SET day='$day', 
										 month='$month', 
										 year='$year',
										 ordernumber='$ordernumber',
										 firstname1='$firstname1', 
										 lastname1='$lastname1',
										 firstname='$firstname', 
										 lastname='$lastname',  
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
										 m1_el13='$m1_el13',
										 m1_el14='$m1_el14',
										 m1_el15='$m1_el15',
										 m1_el16='$m1_el16',
										 m1_el17='$m1_el17',
										 m2_el1='$m2_el1',
										 m2_el2='$m2_el2',	 
										 m2_el3='$m2_el3',
										 m2_el4='$m2_el4',
										 m2_el5='$m2_el5',
										 m2_el6='$m2_el6',
										 m3_el1='$m3_el1',
										 m3_el2='$m3_el2',	 
										 m3_el3='$m3_el3',
										 m4_el1='$m4_el1',
										 m4_el2='$m4_el2',	 
										 m4_el3='$m4_el3',
										 m4_el4='$m4_el4',
										 m5_el1='$m5_el1',
										 m5_el2='$m5_el2',	 
										 m5_el3='$m5_el3',
										 m5_el4='$m5_el4',
										 m6_el1='$m6_el1',
										 m6_el2='$m6_el2',	 
										 m6_el3='$m6_el3',
										 m6_el4='$m6_el4',
										 m6_el5='$m6_el5',
										 m6_el6='$m6_el6',
										 m6_el7='$m6_el7',
										 m6_el8='$m6_el8',
										 m6_el9='$m6_el9',
										 m7_el1='$m7_el1',
										 m7_el2='$m7_el2',	 
										 m7_el3='$m7_el3',
										 m7_el4='$m7_el4',
										 m7_el5='$m7_el5',
										 m7_el6='$m7_el6',
										 m7_el7='$m7_el7',
										 comment1='$comment1',
										 comment2='$comment2',
										 comment3='$comment3',
										 comment4='$comment4',
										 nextMileage='$nextMileage',
										 signature= '$signature',
										 sig_hash= '$sig_hash',
										 ip= '$ip',
										 created= '$created'
										 ")
 		or die(mysql_error());
		
		header("location: print_cc.php");
	}
}
// var_dump($errors_array);
?>