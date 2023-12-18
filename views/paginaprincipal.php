<!doctype html>
<html lang="es">
  <head>
    <title>Formulario principal</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous"/>
  </head>

  <body>
    <!--Creando mi formulario-->
      <form action="" class="container">
        <h2>Bienvenidos al Proyecto JJCM</h2>
        <div class="row">
          <div class="col-md-4 mb-3">
            <button class="btn btn-primary" type="button" onclick="window.location.href='../views/busca_empleado.php'">
              Buscar
            </button>
          </div>
          <div class="col-md-4 mb-3">
            <button class="btn btn-primary" type="button" onclick="window.location.href='../views/registra.empleado.php'">
              Registrar
            </button>
          </div>
          <div class="col-md-4 mb-3">
            <button class="btn btn-primary" type="button" onclick="window.location.href = window.location.href;">
              Recargar Página
            </button>
          </div>
        </div>
      </form>

      <table class="table">
        <thead>
          <tr>
            <th scope="col">Sede</th>
            <th scope="col">Apellidos</th>
            <th scope="col">Nombres</th>
            <th scope="col">Nro. Documento</th>
            <th scope="col">Fecha Nacimiento</th>
            <th scope="col">Nro. Telefono</th>
          </tr>
        </thead>
        <tbody>
          <?php
          require_once '../models/listar.php';
          ?>
        </tbody>
      </table>

    <!--Creando mi tabla donde me mostrará mis registros-->
</body>
</html>
