<?php

//Incorpora el archivo externo 1 sola vez
//Si detecta un error, se detiene
require_once '../models/Empleado.php';

//1. Recibirá peticiones (GET -POST - REQUEST)
//2. Realizará el proceso (MODELO - CLASE)
//3. Devolver un resultado (JSON)

//KEY = VALUE

if(isset($_POST['operacion'])){

  //Instanciar la clase
  $empleado = new Empleado();

  if($_POST['operacion'] == 'search'){
   $respuesta = $empleado->search(["nrodocumento" => $_POST['nrodocumento']]);
   sleep(3);
   echo json_encode(($respuesta));
  }

  //Nuevo proceso
  if($_POST['operacion'] == 'add'){
    //Almacenar los datos recibiendo de la vista en un arreglo
    $datosRecibidos = [
      "idsede"               => $_POST["idsede"],
      "apellidos"            => $_POST["apellidos"],
      "nombres"              => $_POST["nombres"],
      "nrodocumento"         => $_POST["nrodocumento"],
      "fechanac"                 => $_POST["fechanac"],
      "telefono"         => $_POST["telefono"]
    ];


    //Enviamos el arreglo como parámetro del método add
    $idobtenido =  $empleado->add($datosRecibidos);
    echo json_encode($idobtenido);
  }
}