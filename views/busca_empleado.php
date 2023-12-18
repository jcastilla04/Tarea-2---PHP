<!doctype html>
<html lang="en">
  <head>
    <title>Buscador</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous"/>
  </head>
  <body>
    <div class="container">
      <div class="card mt-2">
        <div class="card-header bg-primary">
          <span class="text-light">Buscador de empleados</span>
        </div>

        <div class="card-body">
          <form action="" id="BuscarE" autocomplete="off">
            <div class="input-group mb-3">
              <input type="text" class="form-control text-center" id="nrodocumento" maxlength="8" placeholder="Ingrese el dni del usuario">
              <button class="btn btn-success" type="button" id="BuscarE2">Buscar Empleado</button>
            </div>
            <small id="status">No hay busquedas activas</small>
            <div class="mb-3">
              <label for="apellidos" class="form-label">Apellido Empleado:</label>
              <input type="text" id="apellidos" class="form-control" readonly>
            </div>

            <div class="mb-3">
              <label for="nombres" class="form-label">Nombres Empleado:</label>
              <input type="text" id="nombres" class="form-control" readonly>
            </div>

            <div class="mb-3">
              <label for="fechanac" class="form-label">Fecha Nacimiento Empleado:</label>
              <input type="text" id="fechanac" class="form-control" readonly>
            </div>

            <div class="mb-3">
              <label for="telefono" class="form-label">Telefono Empleado:</label>
              <input type="text" id="telefono" class="form-control" readonly>
            </div>

            <div class="mb-3">
            <button class="btn btn-secondary" type="reset" onclick="window.location.href = '../views/paginaprincipal.php'">Volver</button>
            </div>

            <div class="col-md-4 mb-3">
            <button class="btn btn-primary" type="button" onclick="window.location.href = window.location.href;">
              Recargar Página
            </button>
          </div>
        </form>
      </div>
        </div>
      </div>

      <script>
          document.addEventListener("DOMContentLoaded", () => {

  //Funcion para referenciar componentes
  function $(id){ return document.querySelector(id)}


  function buscarNDocument(){
          const nrodocumento = $("#nrodocumento").value

          if(nrodocumento != ""){
            const parametros = new FormData()
            parametros.append("operacion", "search")
            parametros.append("nrodocumento", nrodocumento)

            $("#status").innerHTML = "Buscando por favor espere..."

            fetch(`../controllers/Empleado.controller.php`, {
              method: "POST",
              body: parametros
            })
              .then(respuesta => respuesta.json())
              .then(datos => {
                if(!datos){
                  $("#status").innerHTML = "No se encontró el registro"
                  $("#BuscarE").reset()
                  $("#nrodocumento").focus()
                }else{
                  $("#status").innerHTML = "Empleado encontrado"
                  $("#apellidos").value = datos.apellidos
                  $("#nombres").value = datos.nombres
                  $("#fechanac").value = datos.fechanac
                  $("#telefono").value = datos.telefono
                }
              })
              .catch(e =>{
                console.error(e);
              })
          }
        }


      //EVENTOS
      //E1 : Al pulsar el ENTER ubicado en la caja 
      $("#nrodocumento").addEventListener("keypress", (event) =>{
        if(event.keyCode == 13){
          buscarNDocument();
        }
      }) 

      //E2: El pulsar click sobre el boton
      $("#BuscarE").addEventListener("click", buscarNDocument)


    })
      </script>
  </body>
</html>
