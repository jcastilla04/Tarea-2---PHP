<?php
//1. Acceso al archivo
require 'Conexion.php';

//2. Heredar sus atributos y datos
class Empleado extends Conexion{

  //Este objeto almacenará la conexion y se la facilitará a todos los métodos
  private $pdo;

  //3. Almacenar la conexion en el objeto
  public function __CONSTRUCT(){
    $this->pdo = parent::getConexion();
  }

  //$data es un arreglo asociativo que contiene los valores
  //requeridos por el SPU paa registro de empleados
  public function add($data = []){
    try{
      $consulta = $this->pdo->prepare("CALL spu_empleados_registrar(?,?,?,?,?,?)");
      $consulta->execute(
        array(
          $data['idsede'],
          $data['apellidos'],
          $data['nombres'],
          $data['nrodocumento'],
          $data['fechanac'],
          $data['telefono'],
        )
      );
      //Actualizacion, ahora retornamos el "idvehiculo"
      return $consulta->fetch(PDO::FETCH_ASSOC);
    }
  catch(Exception $e){
    die($e->getMessage());
  }
}

  public function search($data = []){
    try{
      //El SPU requiere el número de placa
      $consulta = $this->pdo->prepare("CALL spu_empleados_buscar(?)");
      $consulta->execute(
        array($data['nrodocumento'])
      );

      //Devolver el registro encontrado
      //fetch()     : retorna la primera coincidencia (1)
      //fetchAll()  : retorna todas las coincidencias (n)
      //FETCH_ASSOC : define el resultado como un objeto

      return $consulta->fetch(PDO::FETCH_ASSOC);
    }
    catch(Exception $e){
      die($e->getMessage());
    }
  }
}