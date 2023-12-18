<?php
require_once 'Conexion.php';
class Sede extends Conexion{

  private $pdo;

  public function __CONSTRUCT(){
    $this->pdo =  parent::getConexion();
  }

  //Devuelve la lista completa de marcas
  public function getAll(){
    try{
      $consulta = $this->pdo->prepare("CALL spu_sedes_listar()");
      $consulta->execute();
      return  $consulta->fetchAll(PDO::FETCH_ASSOC);
    }
    catch(Exception $e){
      die($e->getMessage());
    }
  }
}
