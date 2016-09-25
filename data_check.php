<?php
//// define variables array and set to empty values
global $dateErr;
global $orderErr;
global $nameErr;
global $last_nameErr;
global $nameErr1;
global $last_nameErr1;
global $makeErr;
global $lineErr;
global $modelErr;
global $mileageErr;
global $licenseErr;
global $matrix1Err;
global $matrix2Err;
global $matrix3Err;
global $matrix4Err;
global $matrix5Err;
global $matrix6Err;
global $matrix7Err;
global $nextMileageErr;
global $signatureErr;
global $comment1Err;
global $comment2Err;
global $comment3Err;
global $comment4Err;
global $searchErr;

$errors = array('$dateErr' => "",
                '$orderErr' => "", 
                '$nameErr' => "", 
                '$last_nameErr' => "", 
                '$nameErr1' => "", 
                '$last_nameErr1' => "",
                '$makeErr' => "",
                '$lineErr' => "", 
                '$modelErr' => "", 
                '$mileageErr' => "",
                '$licenseErr' => "",
                '$matrix1Err' => "",
                '$matrix2Err' => "",
                '$matrix3Err' => "",
                '$matrix4Err' => "",
                '$matrix5Err' => "",
                '$matrix6Err' => "",
                '$matrix7Err' => "",
                '$nextMileageErr' =>"",
                '$signatureErr' =>"",
                '$comment1Err' =>"",
                '$comment2Err' =>"",
                'comment3Err' =>"",
                'comment4Err'=>"");

// $orderErr = $nameErr = $last_nameErr = $emailErr = $genderErr = $websiteErr = "";
$month = $day = $year = $firstname = $lastname = $make = $model = $license = $mileage = $ordernumber = $firstname1 = $lastname1 =  $comment1 = $comment2 = $comment3 = $comment4 = $nextMileage= $signature="";

//search input text field and error in search.php file
$search ="";
$searchErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if(empty($_POST["month"]) || empty($_POST["day"]) || empty($_POST["year"])){
    $dateErr = "* Fecha requerida";
  }

  $errors = array($dateErr);

  if (empty($_POST["ordernumber"])) {
    $orderErr = "* Orden de reparación requerida";
  } else {
    $ordernumber = test_input($_POST["ordernumber"]);
    // check if order only contains numbers and no whitespaces
    if (!preg_match("/^[0-9 ]*$/",$ordernumber)) {
      $orderErr = "* Solo números sin espacios permitidos"; 
    }
    // check if order value already exists in database to avoid duplicate
    else {
      require_once('duplicate_query.php');
      }
    }

  array_push($errors, $orderErr);

  if (empty($_POST["firstname1"])) {
    $nameErr1 = "* Nombre requerido";
  } else {
    $firstname1 = test_input($_POST["firstname1"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Záéíóúñ]*$/",$firstname1)) {
      $nameErr1 = "* Solo letras sin espacios en blanco permitidos"; 
    }
  }

  array_push($errors, $nameErr1);

  if (empty($_POST["lastname1"])) {
    $last_nameErr1 = "* Apellido requerido";
  } else {
    $lastname1 = test_input($_POST["lastname1"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Záéíóúñ]*$/",$lastname1)) {
      $last_nameErr1 = "* Solo letras sin espacios en blanco permitidos"; 
    }
  }

  array_push($errors, $last_nameErr1);

  if (empty($_POST["firstname"])) {
    $nameErr = "* Nombre requerido";
  } else {
    $firstname = test_input($_POST["firstname"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Záéíóúñ ]*$/",$firstname)) {
      $nameErr = "* Solo letras y espacios en blanco permitidos"; 
    }
  }

  array_push($errors, $nameErr);

  if (empty($_POST["lastname"])) {
    $last_nameErr = "* Apellido requerido";
  } else {
    $lastname = test_input($_POST["lastname"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Záéíóúñ ]*$/",$lastname)) {
      $last_nameErr = "* Solo letras y espacios en blanco permitidos"; 
    }
  }

  array_push($errors, $last_nameErr);

  if (@$_POST['cat'] == "") {
    $makeErr = "* Marca del vehículo requerida";
  }

  array_push($errors, $makeErr);

    if (empty($_POST['subcat'])){
    $lineErr = "* Línea del vehículo requerida";
  }

  array_push($errors, $lineErr);

  if (empty($_POST["model"])) {
    $modelErr = "* Modelo del vehículo requerido";
  } else {
    $model = test_input($_POST["model"]);
    // check if order only contains numbers and no whitespaces
    if (!preg_match("/^[0-9 ]*$/",$model)) {
      $modelErr = "* Solo números sin espacios permitidos"; 
    }
  }

  array_push($errors, $modelErr);


  if (empty($_POST["license"])) {
      $licenseErr = "* Placa del vehículo requerida";
    } else {
      $license = test_input($_POST["license"]);
      // check if order only contains numbers and no whitespaces
      if (!preg_match("/^[0-9A-Z ]*$/",$license)) {
        $licenseErr = "* Solo letras en mayúscula y números sin espacios permitidos"; 
      }
    }

    array_push($errors, $licenseErr);

  if (empty($_POST["mileage"])) {
      $mileageErr = "* Kilometraje del vehículo requerido";
    } else {
      $mileage = test_input($_POST["mileage"]);
      // check if mileage only contains numbers and no whitespaces
      if (!preg_match("/^[0-9 ]*$/",$mileage)) {
        $mileageErr = "* Solo números sin espacios permitidos"; 
      }
      // check if mileage value already exists in database for the same license to avoid duplicate
      else {
        require_once('duplicate1_query.php');
      }
    }

    array_push($errors, $mileageErr);

  //Check if all items have an option selected (change number as needed)
  if (!isset($_POST['matrix_1'])) {
    $matrix1Err = "* Se debe seleccionar una opción por ítem";
  } elseif (count($_POST['matrix_1'])<17){
    $matrix1Err = "* Se debe seleccionar una opción por ítem";
  }

  array_push($errors, $matrix1Err);

  //Check if all items have an option selected (change number as needed)
  if (!isset($_POST['matrix_2'])) {
    $matrix2Err = "* Se debe seleccionar una opción por ítem";
  } elseif (count($_POST['matrix_2'])<6){
    $matrix2Err = "* Se debe seleccionar una opción por ítem";
  }

  array_push($errors, $matrix2Err);

  if (!isset($_POST['matrix_3'])) {
    $matrix3Err = "* Se debe seleccionar una opción por ítem";
  } elseif (count($_POST['matrix_3'])<3){
    $matrix3Err = "* Se debe seleccionar una opción por ítem";
  }

  array_push($errors, $matrix3Err);

  if (!isset($_POST['matrix_4'])) {
    $matrix4Err = "* Se debe seleccionar una opción por ítem";
  } elseif (count($_POST['matrix_4'])<4){
    $matrix4Err = "* Se debe seleccionar una opción por ítem";
  }

  array_push($errors, $matrix4Err);

  if (!isset($_POST['matrix_5'])) {
    $matrix5Err = "* Se debe seleccionar una opción por ítem";
  } elseif (count($_POST['matrix_5'])<4){
    $matrix5Err = "* Se debe seleccionar una opción por ítem";
  }

  array_push($errors, $matrix5Err);

  if (!isset($_POST['matrix_6'])) {
    $matrix6Err = "* Se debe seleccionar una opción por ítem";
  } elseif (count($_POST['matrix_6'])<9){
    $matrix6Err = "* Se debe seleccionar una opción por ítem";
  }

  array_push($errors, $matrix6Err);

  if (!isset($_POST['matrix_7'])) {
    $matrix7Err = "* Se debe seleccionar una opción por ítem";
  } elseif (count($_POST['matrix_7'])<7){
    $matrix7Err = "* Se debe seleccionar una opción por ítem";
  }

  array_push($errors, $matrix7Err);

  if (empty($_POST["comment1"])) {
      $comment1 = "";
    } else {
      $comment1 = test_input($_POST["comment1"]);
      // check if comment1 only contains numbers, letters and whitespaces
      if (!preg_match("/^[0-9a-zA-Záéíóúñ,.;:$() ]*$/",$comment1)) {
        $comment1Err = "* Solo números, letras y espacios permitidos"; 
      }
    }

     array_push($errors, $comment1Err);

  if (empty($_POST["comment2"])) {
      $comment2 = "";
    } else {
      $comment2 = test_input($_POST["comment2"]);
      // check if comment1 only contains numbers, letters and whitespaces
      if (!preg_match("/^[0-9a-zA-Záéíóúñ,.;:$() ]*$/",$comment2)) {
        $comment2Err = "* Solo números, letras y espacios permitidos"; 
      }
    }

    array_push($errors, $comment2Err);

  if (empty($_POST["comment3"])) {
      $comment3 = "";
    } else {
      $comment3 = test_input($_POST["comment3"]);
      // check if comment1 only contains numbers, letters and whitespaces
      if (!preg_match("/^[0-9a-zA-Záéíóúñ,.;:$() ]*$/",$comment3)) {
        $comment3Err = "* Solo números, letras y espacios permitidos"; 
      }
    }

    array_push($errors, $comment3Err);

  if (empty($_POST["comment4"])) {
      $comment4 = "";
    } else {
      $comment4 = test_input($_POST["comment4"]);
      // check if comment1 only contains numbers, letters and whitespaces
      if (!preg_match("/^[0-9a-zA-Záéíóúñ,.;:$() ]*$/",$comment4)) {
        $comment4Err = "* Solo números, letras y espacios permitidos"; 
      }
    }

    array_push($errors, $comment4Err);

  if (empty($_POST["nextMileage"])) {
      $nextMileageErr = "* Próximo kilometraje requerido";
    } elseif ($_POST["nextMileage"]<$_POST["mileage"]) {
      $nextMileageErr = "* El valor debe ser superior al kilometraje actual";
    } else {
      $nextMileage = test_input($_POST["nextMileage"]);
      // check if order only contains numbers and no whitespaces
      if (!preg_match("/^[0-9]*$/",$nextMileage)) {
        $nextMileageErr = "* Solo números sin espacios permitidos"; 
      }
    }

  array_push($errors, $nextMileageErr);

  if (!json_decode(@$_POST["output"])){
      $signatureErr = "* Firma del asesor requerida";
    }

  array_push($errors, $signatureErr);

  // if (empty($_POST["email"])) {
  //   $emailErr = "Email is required";
  // } else {
  //   $email = test_input($_POST["email"]);
  //   // check if e-mail address is well-formed
  //   if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  //     $emailErr = "Invalid email format"; 
  //   }
  // }

  //Data check for search.php file

  if (empty($_POST['cons'])){
    $searchErr = "* Ingrese un criterio de búsqueda";
  } else{
    $search = test_input($_POST['cons']);
    // check if search value only contains numbers, letters or whitespaces
    if(!preg_match("/^[0-9a-zA-Záéíóúñ ]*$/", $search)){
      $searchErr = "* Solo números, letras y espacios permitidos";
    }
  }
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>