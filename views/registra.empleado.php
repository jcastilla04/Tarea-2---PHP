<!doctype html>
<html lang="es">
  <head>
    <title>Registro de Empleados</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous"/>
  </head>
  <body>
    <div class="container">
      <div class="alert alert-info mt-3">
          <h5>Registro de Empleados</h5>
            <span>Complete la informacion requerida</span>
        </div>
        <div class="card-body">
          <form action="" id="buscar" autocomplete="off">
            
          
          <label for="sede">Sede de empleado: </label>
                <select name="sede" id="sede" class="form-select" required>
                <option value="">Seleccione</option>
                </select>

              <div class="mb-3">
              <label for="nrodocumento" class="form-label">Nro Documento: </label>
                <input type="text" id="nrodocumento" class="form-control" maxlength="8" minlength="8" required>
              </div>

              <div class="mb-3">
                <label for="apellidos" class="form-label">Apellido Empleado: </label>
                <input type="text" id="apellidos" class="form-control" required>
              </div>

              <div class="mb-3">
                <label for="nombres" class="form-label">Nombres Empleado: </label>
                <input type="text" id="nombres" class="form-control" required>
              </div>

              <div class="row">
                <div class="col-md-4 mb-2">
                  <label for="fechanac" class="form-label">Fecha Nacimiento: </label>
                  <input type="date" id="fechanac" class="form-control text-end" required>
                </div>

                <div class="col-md-4 mb-2">
                  <label for="telefono" class="form-label">Telefono: </label>
                  <input type="text" id="telefono" class="form-control text-end" maxlength="9" minlength="9" required>
                </div>

                <div class="mb4 text-end">
                  <button class="btn btn-primary" id="guardar" type="submit">Guardar Datos</button>
                  <button class="btn btn-secondary" type="reset">Cancelar</button>
                  <button class="btn btn-secondary" type="button" onclick="window.location.href='../views/paginaprincipal.php'">Volver</button>
            <button class="btn btn-primary" type="button" onclick="window.location.href = window.location.href;">
              Recargar Página
            </button>
              </div>
            </form>
    </div>

  <script>
    document.addEventListener("DOMContentLoaded", () =>{
        function $(id) {return document.querySelector(id)}

        //Funcion autojecutada que trae datos de marca(backend)
        //y las agrega como <option> a la lista (select) marca

        (function (){
          fetch(`../controllers/Sede.controller.php?operacion=listar`)
          .then(respuesta => respuesta.json())
          .then(datos => {
            datos.forEach(element => {
              const tagOption = document.createElement("option")
              tagOption.value = element.idsede
              tagOption.innerHTML = element.sede
              $("#sede").appendChild(tagOption)
            });
          })
          .catch(e =>{
            console.error(e)
        })
      })();

        $("#buscar").addEventListener("submit", (event) =>{
          //Evitamos el envio por ACTION
           event.preventDefault();

           //Enviaré por AJAX (fetch)
           if(confirm("¿Desea registrar este empleado?")){

            const parametro = new FormData()
            parametro.append("operacion","add")  //¡IMPORTANTE!
            //A partir de este punto las variables que requiere el SPU
            parametro.append("idsede", $("#sede").value)
            parametro.append("apellidos", $("#apellidos").value)
            parametro.append("nombres", $("#nombres").value)
            parametro.append("nrodocumento", $("#nrodocumento").value)
            parametro.append("fechanac", $("#fechanac").value)
            parametro.append("telefono", $("#telefono").value)


              fetch(`../controllers/Empleado.controller.php`,{
                method: "POST",
              body: parametro
              })
              .then(respuesta => respuesta.json())
              .then(datos=>{
                const id = parseInt(datos.idempleado)
                if(datos.idempleado > 0){
                  $("#buscar").reset()
                  alert(`Empleado registrado con ID: ${datos.idempleado}`)
                }
                console.log(datos) //""
                alert("Proceso terminado correctamente")
              })
              .catch(e =>{
                console.error(e)
              })
           }
        })
      })
  </script>
  </body>
</html>
