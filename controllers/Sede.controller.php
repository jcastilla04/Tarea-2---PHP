<?php

//Incorpora el archivo externo 1 sola vez
//Si detecta un error, se detiene
require_once '../models/Sede.php';

//1. Recibirá peticiones (GET -POST - REQUEST)
//2. Realizará el proceso (MODELO - CLASE)
//3. Devolver un resultado (JSON)

//KEY = VALUE

if(isset($_GET['operacion'])){

  //Instanciar la clase
  $sede = new Sede();

  if($_GET['operacion'] == 'listar'){
   $respuesta = $sede->getAll();
   echo json_encode(($respuesta));
  }

}