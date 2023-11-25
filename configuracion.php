<?php
// Iniciar la sesión (si aún no está iniciada)
session_start();

// Verificar si la sesión contiene la información del rol del usuario
if (isset($_SESSION['tipo_usuario'])) {
    $rolUsuario = $_SESSION['tipo_usuario'];

    // Verificar si el usuario tiene el rol adecuado
    $rolesPermitidos = [1, 7]; // Administrador y Superusuario

    if (in_array($rolUsuario, $rolesPermitidos)) {
        // El usuario tiene permiso, mostrar el contenido del módulo
        require_once "vistas/parte_superior.php";
        
        ?>



<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
            <h1 class="mt-4">Configuración</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="principal.php">Dashboard</a></li>
                <li class="breadcrumb-item active">Configuración</li>
            </ol>
            <div class="card mb-4">
                <div class="card-body">En esta sección, podrás realizar un seguimiento detallado de todos los procesos creados. Tendrás la capacidad de registrar procesos principales, subprocesos y subprocesos de nivel 2, así como actividades asociadas a ellos. Además, podrás asignar periodos, categorías y otras características relevantes a cada proceso. <br> <br>Este panel de control te permitirá gestionar eficientemente tus procesos y mantener un registro organizado de su estado y avance.</div>
            </div>
            <div class="card text-white bg-secondary mb-3">
                <div class="card-header text-center">
                    Proceso de Creación
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="text-center mb-3">
                                <button id="crearPeriodoBtn" class="btn btn-outline-light custom-btn">Crear Periodo</button>
                            </div>
                            <div class="text-center mb-3">
                                <button id="crearProcesoBtn" class="btn btn-outline-light custom-btn">Crear Proceso Principal</button>
                            </div>
                            <div class="text-center mb-3">
                                <button id="crearSubprocesoBtn" class="btn btn-outline-light custom-btn">Crear Subproceso</button>
                            </div>
                            <div class="text-center mb-3">
                                <button id="crearSubprocesoNivel2Btn" class="btn btn-outline-light custom-btn">Crear Subproceso Nivel 2</button>
                            </div>
                            <div class="text-center mb-3">
                                <button id="crearActividadBtn" class="btn btn-outline-light custom-btn">Crear Actividad</button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-center mb-3">
                                <button id="verPeriodosBtn" class="btn btn-outline-light custom-btn" onclick="window.location.href = 'periodos.php';">Ver Periodos</button>
                            </div>
                            <div class="text-center mb-3">
                                <button id="verProcesosBtn" class="btn btn-outline-light custom-btn" onclick="window.location.href = 'procesos.php';">Ver Procesos</button>
                            </div>
                            <div class="text-center mb-3">
                                <button id="verSubprocesosBtn" class="btn btn-outline-light custom-btn" onclick="window.location.href = 'subprocesos.php';">Ver Subprocesos</button>
                            </div>
                            <div class="text-center mb-3">
                                <button id="verSubprocesosNivel2Btn" class="btn btn-outline-light custom-btn" onclick="window.location.href = 'subprocesos_nvl2.php';">Ver Subprocesos Nivel 2</button>
                            </div>
                            <div class="text-center mb-3">
                                <button id="verActividadesBtn" class="btn btn-outline-light custom-btn" onclick="window.location.href = 'actividades.php';">Ver Actividades</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>



<script>
  $(document).ready(function() {
  // Botón para crear Periodo
$("#crearPeriodoBtn").click(function() {
  Swal.fire({
    title: 'Crear Periodo',
    html: `
      <form id="periodoForm">
        <div class="mb-3">
          <label for="nombrePeriodo">Nombre del Periodo:</label>
          <input type="text" class="form-control" id="nombrePeriodo" placeholder="Ingrese el nombre del periodo" required>
        </div>
        <div class="mb-3">
          <label for="fechaInicioPeriodo">Fecha de Inicio:</label>
          <input type="date" class="form-control" id="fechaInicioPeriodo" required>
        </div>
        <div class="mb-3">
          <label for="fechaFinPeriodo">Fecha de Fin:</label>
          <input type="date" class="form-control" id="fechaFinPeriodo" required>
        </div>
      </form>
    `,
    showCancelButton: true,
    confirmButtonText: 'Crear',
    cancelButtonText: 'Cancelar',
    preConfirm: function() {
      // Obtener los valores del formulario
      var nombrePeriodo = $("#nombrePeriodo").val();
      var fechaInicioPeriodo = $("#fechaInicioPeriodo").val();
      var fechaFinPeriodo = $("#fechaFinPeriodo").val();

       // Validar los campos del formulario
       if (!nombrePeriodo || !fechaInicioPeriodo || !fechaFinPeriodo) {
        Swal.showValidationMessage('Por favor, complete todos los campos');
        return false;
      }
      // Realizar la petición AJAX para enviar los datos al backend
      $.ajax({
        url: 'procesos/guardar_periodo.php',
        type: 'POST',
        data: {
          nombre: nombrePeriodo,
          fechaInicio: fechaInicioPeriodo,
          fechaFin: fechaFinPeriodo
        },
        success: function(response) {
            var jsonResponse = JSON.parse(response);
            console.log(jsonResponse);
            console.log("Success: " + jsonResponse.success);
            console.log("Message: " + jsonResponse.message);
            if (jsonResponse.success) {
            Swal.fire({
              title: 'Éxito',
              text: jsonResponse.message,
              icon: 'success',
              timer: 2000, // Tiempo en milisegundos
              timerProgressBar: true,
              didOpen: () => {
                Swal.showLoading();
                Swal.update({
                  title: 'Redireccionando...',
                  text: 'Serás redirigido al CRUD en 2 segundos.', // Mensaje adicional
                })
              },
              willClose: () => {
                // Redirigir a la página de CRUD después de crear un proceso
                window.location.href = 'periodos.php'; // Reemplaza con la ruta correcta
              }
            });
              
            } else {
              Swal.fire('Error', jsonResponse.message, 'error');
            }
          },
          error: function(xhr, status, error) {
            // Manejar los errores de la petición AJAX
            console.log("Error en la petición AJAX: " + error);
          }
      });
    }
  });
});

 // Botón para crear Proceso Principal
 $("#crearProcesoBtn").click(function() {
  // Llamada AJAX para obtener los periodos existentes
  $.ajax({
    url: 'procesos/obtener_periodos.php',
    type: 'GET',
    success: function(response) {
      var periodos = JSON.parse(response);

      var periodoOptions = '';
      for (var i = 0; i < periodos.length; i++) {
        periodoOptions += '<option value="' + periodos[i].id + '">' + periodos[i].nombre + '</option>';
      }

      Swal.fire({
        title: 'Crear Proceso Principal',
        html: `
          <form id="procesoForm">
            <div class="mb-3">
              <label for="nombreProceso">Nombre del Proceso:</label>
              <input type="text" class="form-control" id="nombreProceso" placeholder="Ingrese el nombre del proceso" required>
            </div>
            <div class="mb-3">
              <label for="descripcionProceso">Descripción del Proceso:</label>
              <textarea class="form-control" id="descripcionProceso" rows="3" placeholder="Ingrese la descripción del proceso" required></textarea>
            </div>
            <div class="mb-3">
              <label for="categoriaProceso">Categoría:</label>
              <input type="text" class="form-control" id="categoriaProceso" placeholder="Ingrese la categoría del proceso" required>
            </div>
            <div class="mb-3">
              <label for="periodoProceso">Periodo:</label>
              <select class="form-control" id="periodoProceso" required>
              ${periodoOptions}
              </select>
            </div>
          </form>
        `,
        showCancelButton: true,
        confirmButtonText: 'Crear',
        cancelButtonText: 'Cancelar',
        preConfirm: function() {
          var nombreProceso = $("#nombreProceso").val();
          var descripcionProceso = $("#descripcionProceso").val();
          var categoriaProceso = $("#categoriaProceso").val();
          var periodoProceso = $("#periodoProceso").val();

           // Validar los campos del formulario
           if (!nombreProceso || !descripcionProceso || !categoriaProceso || !periodoProceso) {
            Swal.showValidationMessage('Por favor, complete todos los campos');
            return false;
           }
          // Llamada AJAX para guardar el proceso principal en el backend
          $.ajax({
            url: 'procesos/guardar_proceso.php',
            type: 'POST',
            data: {
              nombreProceso: nombreProceso,
              descripcionProceso: descripcionProceso,
              categoriaProceso: categoriaProceso,
              periodoProceso: periodoProceso
            },
            success: function(response) {
              var jsonResponse = JSON.parse(response);
              console.log(jsonResponse);
              console.log("Success: " + jsonResponse.success);
              console.log("Message: " + jsonResponse.message);
              if (jsonResponse.success) {
                Swal.fire('Éxito', jsonResponse.message, 'success');
              } else {
                Swal.fire('Error', jsonResponse.message, 'error');
              }
            },
            error: function(xhr, status, error) {
              // Manejar los errores de la petición AJAX
              console.log("Error en la petición AJAX: " + error);
            }
          });
        }
      });
    },
    error: function(xhr, status, error) {
      // Manejar los errores de la petición AJAX para obtener los periodos
      console.log("Error en la petición AJAX para obtener los periodos: " + error);
    }
  });
});

  // Botón para crear Subproceso
$("#crearSubprocesoBtn").click(function() {
  // Obtener los procesos principales desde la base de datos mediante una llamada AJAX
  $.ajax({
    url: 'procesos/obtener_procesos_principales.php', // Ruta al archivo PHP que obtiene los procesos principales
    type: 'GET',
    success: function(response) {
      var procesosPrincipales = JSON.parse(response);

      // Construir el HTML del select con los procesos principales obtenidos
      var selectOptions = '';
      for (var i = 0; i < procesosPrincipales.length; i++) {
        selectOptions += '<option value="' + procesosPrincipales[i].id + '">' + procesosPrincipales[i].nombre + '</option>';
      }

      Swal.fire({
        title: 'Crear Subproceso',
        html: `
          <form id="subprocesoForm">
            <div class="mb-3">
              <label for="nombreSubproceso">Nombre del Subproceso:</label>
              <input type="text" class="form-control" id="nombreSubproceso" placeholder="Ingrese el nombre del subproceso">
            </div>
            <div class="mb-3">
              <label for="descripcionSubproceso">Descripción del Subproceso:</label>
              <textarea class="form-control" id="descripcionSubproceso" rows="3" placeholder="Ingrese la descripción del subproceso"></textarea>
            </div>
            <div class="mb-3">
              <label for="idProcesoPadre">Proceso Principal:</label>
              <select class="form-control" id="idProcesoPadre">
                <option value="">Seleccionar proceso principal</option>
                ${selectOptions}
              </select>
            </div>
          </form>
        `,
        showCancelButton: true,
        confirmButtonText: 'Crear',
        cancelButtonText: 'Cancelar',
        preConfirm: function() {
          var nombreSubproceso = $("#nombreSubproceso").val();
          var descripcionSubproceso = $("#descripcionSubproceso").val();
          var procesoPrincipal = $("#idProcesoPadre").val();

          // Validación para verificar que los campos no estén vacíos
          if (!nombreSubproceso || !descripcionSubproceso || !procesoPrincipal) {
            Swal.showValidationMessage('Por favor, complete todos los campos');
            return false;
          }

          // Llamada AJAX para guardar el subproceso en el backend
          $.ajax({
            url: 'procesos/guardar_subproceso.php', // Ruta al archivo PHP que procesa la creación del subproceso
            type: 'POST',
            data: {
              nombreSubproceso: nombreSubproceso,
              descripcionSubproceso: descripcionSubproceso,
              procesoPrincipal: procesoPrincipal
            },
            success: function(response) { 
              // Manejar la respuesta del servidor
              console.log(response);
              Swal.fire('Éxito', 'El subproceso se ha creado correctamente', 'success');
            },
            error: function(xhr, status, error) {
              // Manejar los errores de la petición AJAX
              console.log("Error en la petición AJAX: " + error);
              Swal.fire('Error', 'Ha ocurrido un error al crear el subproceso', 'error');
            }
          });
        }
      });
    },
    error: function(xhr, status, error) {
      // Manejar los errores de la petición AJAX
      console.log("Error en la petición AJAX: " + error);
      Swal.fire('Error', 'Ha ocurrido un error al obtener los procesos principales', 'error');
    }
  });
});

/// Botón para crear Subproceso Nivel 2
$("#crearSubprocesoNivel2Btn").click(function() {
  // Obtener los subprocesos desde la base de datos mediante una llamada AJAX
  $.ajax({
    url: 'procesos/obtener_subprocesos.php', // Ruta al archivo PHP que obtiene los subprocesos
    type: 'GET',
    dataType: 'json', // Especificar el tipo de datos esperados como JSON
    success: function(response) {
      var subprocesos = response;

      // Construir el HTML del select con los subprocesos obtenidos
      var selectOptions = '';
      for (var i = 0; i < subprocesos.length; i++) {
        selectOptions += '<option value="' + subprocesos[i].id + '">' + subprocesos[i].nombre + '</option>';
      }

      Swal.fire({
        title: 'Crear Subproceso Nivel 2',
        html: `
          <form id="subprocesoNivel2Form">
            <div class="mb-3">
              <label for="nombreSubprocesoNivel2">Nombre del Subproceso Nivel 2:</label>
              <input type="text" class="form-control" id="nombreSubprocesoNivel2" placeholder="Ingrese el nombre del subproceso nivel 2">
            </div>
            <div class="mb-3">
              <label for="subprocesoPadre">Subproceso Padre:</label>
              <select class="form-control" id="subprocesoPadre">
                <option value="">Seleccionar subproceso padre</option>
                ${selectOptions}
              </select>
            </div>
          </form>
        `,
        showCancelButton: true,
        confirmButtonText: 'Crear',
        cancelButtonText: 'Cancelar',
        preConfirm: function() {
          var nombreSubprocesoNivel2 = $("#nombreSubprocesoNivel2").val();
          var subprocesoPadre = $("#subprocesoPadre").val();
          // Validación para verificar que los campos no estén vacíos 
          if (!nombreSubprocesoNivel2 || !subprocesoPadre) {
            Swal.showValidationMessage('Por favor, complete todos los campos');
            return false;
            }
            
           
            


          // Llamada AJAX para guardar el subproceso nivel 2 en el backend
          $.ajax({
            url: 'procesos/guardar_subproceso_nivel2.php', // Ruta al archivo PHP que procesa la creación del subproceso nivel 2
            type: 'POST',
            data: {
              nombreSubprocesoNivel2: nombreSubprocesoNivel2,
              subprocesoPadre: subprocesoPadre
            },
            success: function(response) {
              // Manejar la respuesta del servidor
              console.log(response);
              Swal.fire('Éxito', 'El subproceso nivel 2 se ha creado correctamente', 'success');
            },
            error: function(xhr, status, error) {
              // Manejar los errores de la petición AJAX
              console.log("Error en la petición AJAX: " + error);
              Swal.fire('Error', 'Ha ocurrido un error al crear el subproceso nivel 2', 'error');
            }
          });
        }
      });
    },
    error: function(xhr, status, error) {
      // Manejar los errores de la petición AJAX
      console.log("Error en la petición AJAX: " + error);
      Swal.fire('Error', 'Ha ocurrido un error al obtener los subprocesos', 'error');
    }
  });
});

$("#crearActividadBtn").click(function() {
  // Obtener los subprocesos nivel 2 desde la base de datos mediante una llamada AJAX
  $.ajax({
    url: 'procesos/obtener_subprocesos_nivel2.php', // Ruta al archivo PHP que obtiene los subprocesos nivel 2
    type: 'GET',
    success: function(response) {
      var subprocesosNivel2 = response;

      // Construir el HTML del select con los subprocesos nivel 2 obtenidos
      var selectOptions = '';
      for (var i = 0; i < subprocesosNivel2.length; i++) {
        selectOptions += '<option value="' + subprocesosNivel2[i].id + '">' + subprocesosNivel2[i].nombre + '</option>';
      }

      // Obtener los usuarios desde la base de datos mediante una llamada AJAX
      $.ajax({
        url: 'procesos/obtener_usuarios.php', // Ruta al archivo PHP que obtiene los usuarios
        type: 'GET',
        dataType: 'json',
        success: function(response) {
          var usuarios = response;

         // Construir las opciones del select con los usuarios obtenidos
          var selectOptionsUsuarios = '';
          for (var i = 0; i < usuarios.length; i++) {
            selectOptionsUsuarios += '<option value="' + usuarios[i].id + '">' + usuarios[i].nombre + ' ' + usuarios[i].apellido + '</option>';
          }


          Swal.fire({
            title: 'Crear Actividad',
            html: `
              <form id="actividadForm">
                <div class="mb-3">
                  <label for="nombreActividad">Nombre de la Actividad:</label>
                  <input type="text" class="form-control" id="nombreActividad" name="nombreActividad" placeholder="Ingrese el nombre de la actividad">
                </div>
                <div class="mb-3">
                  <label for="descripcionActividad">Descripción de la Actividad:</label>
                  <textarea class="form-control" id="descripcionActividad" name="descripcionActividad" rows="3" placeholder="Ingrese la descripción de la actividad"></textarea>
                </div>
                <div class="mb-3">
                  <label for="docentesResponsables">Docentes Responsables:</label>
                  <select class="form-control" id="docentesResponsables" name="docentesResponsables">
                    <option value="">Seleccionar docente responsable</option>
                    ${selectOptionsUsuarios}
                  </select>
                </div>
                <div class="mb-3">
                  <label for="presupuestoActividad">Presupuesto de la Actividad:</label>
                  <input type="text" class="form-control" id="presupuestoActividad" name="presupuestoActividad" placeholder="Ingrese el presupuesto de la actividad">
                </div>
                <div class="mb-3">
                  <label for="fechaInicioActividad">Fecha de Inicio de la Actividad:</label>
                  <input type="date" class="form-control" id="fechaInicioActividad" name="fechaInicioActividad">
                </div>
                <div class="mb-3">
                  <label for="fechaFinActividad">Fecha de Fin de la Actividad:</label>
                  <input type="date" class="form-control" id="fechaFinActividad" name="fechaFinActividad">
                </div>
                <div class="mb-3">
                  <label for="estadoActividad">Estado de la Actividad:</label>
                  <select class="form-control" id="estadoActividad" name="estadoActividad">
                    <option value="">Seleccionar estado de la actividad</option>
                    <option value="Pendiente">Pendiente</option>
                    <option value="En Progreso">En Progreso</option>
                    <option value="Completada">Completada</option>
                  </select>
                </div>
                <div class="mb-3">
                  <label for="subprocesoNivel2">Subproceso Nivel 2:</label>
                  <select class="form-control" id="subprocesoNivel2" name="subprocesoNivel2">
                    <option value="">Seleccionar subproceso nivel 2</option>
                    ${selectOptions}
                  </select>
                </div>
              </form>
            `,
            showCancelButton: true,
            confirmButtonText: 'Crear',
            cancelButtonText: 'Cancelar',
            preConfirm: function() {
              var nombreActividad = $("#nombreActividad").val();
              var descripcionActividad = $("#descripcionActividad").val();
              var docentesResponsables = $("#docentesResponsables").val();
              var presupuestoActividad = $("#presupuestoActividad").val();
              var fechaInicioActividad = $("#fechaInicioActividad").val();
              var fechaFinActividad = $("#fechaFinActividad").val();
              var estadoActividad = $("#estadoActividad").val();
              var subprocesoNivel2 = $("#subprocesoNivel2").val();

              //Verificar que los campos no estén vacios
              if (nombreActividad == '' || descripcionActividad == '' || docentesResponsables == '' || presupuestoActividad == '' || fechaInicioActividad == '' || fechaFinActividad == '' || estadoActividad == '') {
                Swal.showValidationMessage('Por favor, complete todos los campos');
                return false;
                }
            
              // Llamada AJAX para guardar la actividad en el backend
              $.ajax({
                url: 'procesos/guardar_actividad.php', // Ruta al archivo PHP que procesa la creación de la actividad
                type: 'POST',
                data: {
                  nombreActividad: nombreActividad,
                  descripcionActividad: descripcionActividad,
                  docentesResponsables: docentesResponsables,
                  presupuestoActividad: presupuestoActividad,
                  fechaInicioActividad: fechaInicioActividad,
                  fechaFinActividad: fechaFinActividad,
                  estadoActividad: estadoActividad,
                  subprocesoNivel2: subprocesoNivel2
                },
                success: function(response) {
                  // Manejar la respuesta del servidor
                  console.log(response);
                  Swal.fire('Éxito', 'La actividad se ha creado correctamente', 'success');
                },
                error: function(xhr, status, error) {
                  // Manejar los errores de la petición AJAX
                  console.log("Error en la petición AJAX: " + error);
                  Swal.fire('Error', 'Ha ocurrido un error al crear la actividad', 'error');
                }
              });
            }
          });
        },
        error: function(xhr, status, error) {
          // Manejar los errores de la petición AJAX
          console.log("Error en la petición AJAX: " + error);
          Swal.fire('Error', 'Ha ocurrido un error al obtener los usuarios', 'error');
        }
      });
    },
    error: function(xhr, status, error) {
      // Manejar los errores de la petición AJAX
      console.log("Error en la petición AJAX: " + error);
      Swal.fire('Error', 'Ha ocurrido un error al obtener los subprocesos nivel 2', 'error');
    }
  });
});


});

</script>

<script src="jquery/jquery-3.3.1.min.js"></script>
<script src="popper/popper.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>

<!-- Código custom -->
<script src="js/scripts.js"></script>
</body>
</html>
<?php
    } else {
        header("Location: 401.html");
    }
} else {
    // La sesión no contiene la información del rol, redirigir o mostrar un mensaje de error
    header("Location: 401.html");
}

?>
