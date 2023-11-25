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
        require_once "conexion.php";
        include "controladores/controlador_subprocesos_nvl2.php";
        ?>


<main>
    <div id="layoutSidenav_content">
        <div class="container-fluid">
            <h1 class="mt-4">Subprocesos Nivel 2</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="principal.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="configuracion.php">Configuración</a></li>
                <li class="breadcrumb-item active">Subprocesos Nivel 2</li>
            </ol>
            <div class="card mb-4">
                <div class="card-body">
                    En este apartado, se realiza la gestión de subprocesos de nivel 2 en PPIS 2.0. Asegúrese de seguir las políticas de seguridad y proteger la integridad de los datos de los subprocesos.
                    <br><br>A continuación, se muestra una tabla con los subprocesos de nivel 2 registrados en el sistema. Puede realizar modificaciones en los datos de los subprocesos, como nombre, estado y proceso al que pertenecen. Tenga en cuenta las implicaciones de cualquier cambio en los subprocesos.
                    <br><br>Utilice los botones de edición y eliminación con precaución. Antes de realizar cualquier modificación o eliminación de un subproceso_nvl2, asegúrese de verificar y confirmar la acción para evitar consecuencias no deseadas.
                    <br><br>Para obtener más información sobre la gestión de subprocesos de nivel 2 en PPIS 2.0, consulte la documentación oficial del sistema. Si tiene alguna pregunta o necesita asistencia, comuníquese con el equipo de soporte técnico.
                </div>
            </div>
            <div id="appSubprocesosNivel2">
                <div class="card mb-4">
                    <div class="card-header"><i class="fas fa-table mr-1"></i>Gestión de Subprocesos de Nivel 2</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <!-- BARRA DE BÚSQUEDA -->
                                <div class="input-group">
                                    <input type="text" v-model="term" class="form-control" placeholder="Buscar Subproceso">
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="fas fa-search"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <a href='?opcion=1'><button class="btn btn-info mb-2" title="Nuevo"><i class="fas fa-plus-circle fa-2x"></i></button></a>
                        </div>
                        <div class="table-responsive">
                            <table id="subprocesosNivel2" class="table-bordered table-hover" width="100%" cellspacing="0">
                                <thead>
                                    <tr class="bg-info text-light">
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Subproceso Padre</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Aquí puedes iterar sobre los datos de los subprocesos de nivel 2 y mostrarlos en la tabla
                                    foreach ($data as $subproceso_nvl2) {
                                        echo "<tr>
                                            <td>{$subproceso_nvl2['id']}</td>
                                            <td>{$subproceso_nvl2['nombre']}</td>
                                            <td>{$subproceso_nvl2['nombre_proceso']}</td>
                                            <td>";
                                
                                        if ($subproceso_nvl2['estado'] == 1) {
                                            echo "<button class='btn btn-success' disabled>Activo</button>";
                                        } elseif ($subproceso_nvl2['estado'] == 0) {
                                            echo "<button class='btn btn-danger' disabled>Inactivo</button>";
                                        }
                                
                                        echo "</td>
                                            <td>
                                                <div class='btn-group' role='group'>
                                                    <a href='?opcion=2&id={$subproceso_nvl2['id']}'>
                                                        <button class='btn btn-secondary mr-2' title='Editar'>
                                                            <i class='fas fa-pencil-alt'></i>
                                                        </button>
                                                    </a>";
                                
                                        if ($subproceso_nvl2['estado'] == 0) {
                                            echo "<a onclick='activar(event)' href='?opcion=4&id={$subproceso_nvl2['id']}&estado=1'>
                                                <button class='btn btn-warning mr-2' title='Activar subproceso_nvl2'>
                                                    <i class='fas fa-lock-open'></i>
                                                </button>
                                            </a>";
                                        } else {
                                            echo "<a onclick='desactivar(event)' href='?opcion=4&id={$subproceso_nvl2['id']}&estado=0'>
                                                <button class='btn btn-warning mr-2' title='Desactivar subproceso_nvl2'>
                                                    <i class='fas fa-lock'></i>
                                                </button>
                                            </a>";
                                        }
                                
                                        echo "<a onclick='confirmacion(event)' href='?opcion=3&id={$subproceso_nvl2['id']}'>
                                            <button class='btn btn-danger mr-2' title='Eliminar'>
                                                <i class='fas fa-trash-alt'></i>
                                            </button>
                                        </a>
                                    </div>
                                </td>
                                </tr>";
                                }
                                ?>
                                
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="jquery/jquery-3.3.1.min.js"></script>
<script src="popper/popper.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- Vue.JS -->
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<!-- Axios -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.15.2/axios.js"></script>
<!-- Sweet Alert 2 -->
<!-- Código custom -->
<script src="js/scripts.js"></script>
<script src="controladores/eliminar.js"></script>
<!-- JQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- Datatables -->
<script src="//cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
    // Configuración de DataTable similar a la que tienes en tu código actual
    var table = new DataTable('#subprocesosNivel2', {
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json',
        },
    });
</script>

<?php
    } else {
        header("Location: 401.html");
    }
} else {
    // La sesión no contiene la información del rol, redirigir o mostrar un mensaje de error
    header("Location: 401.html");
}



?>