<?php
include_once("Conexion.php");

$conexion = new mysqli("localhost", "root", "","SENATIDB", "3306");

$listar = $conexion->query("SELECT * FROM empleados INNER JOIN sedes ON empleados.idsede=sedes.idsede");
while($rows = $listar->fetch_array()){
  ?>
  <tr>
    <th><?php echo $rows['sede']?></th>
    <th><?php echo $rows['apellidos']?></th>
    <th><?php echo $rows['nombres']?></th>
    <th><?php echo $rows['nrodocumento']?></th>
    <th><?php echo $rows['fechanac']?></th>
    <th><?php echo $rows['telefono']?></th>
  </tr>
  <?php
}
?>