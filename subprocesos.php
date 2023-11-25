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
        include "controladores/controlador_subprocesos.php";
        ?>

<main>
    <div id="layoutSidenav_content">
        <div class="container-fluid">
            <h1 class="mt-4">Subprocesos</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="principal.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="configuracion.php">Configuración</a></li>
                <li class="breadcrumb-item active">Subprocesos</li>
            </ol>
            <div class="card mb-4">
                <div class="card-body">
                En este apartado, se realiza la creación de subprocesos de PPIS 2.0. Es importante tener en cuenta la sensibilidad de la modificación de los datos en este proceso. Asegúrese de tomar las medidas adecuadas para proteger la información y garantizar la integridad de los datos de los subprocesos.
                    <br><br>Aquí se muestra una tabla con los subprocesos registrados en el sistema. Tenga en cuenta que cualquier cambio realizado afectará directamente la información de los subprocesos y puede tener un impacto en su acceso y permisos en el sistema.<br><br>
                    Utilice los botones de edición y eliminación con precaución. Antes de realizar cualquier modificación o eliminación de un periodo, asegúrese de verificar y confirmar la acción para evitar cualquier consecuencia no deseada.<br><br>
                    Recuerde seguir las políticas de seguridad establecidas y respetar la privacidad de los subprocesos al interactuar con sus datos.
                    Para obtener más información sobre el funcionamiento de la gestión de subprocesos en PPIS 2.0, consulte la documentación oficial del sistema.
                    Ante cualquier duda o inconveniente, comuníquese con el equipo de soporte técnico para recibir asistencia especializada.
                </div>
            </div>
            <div id="appMoviles">
                <div class="card mb-4">
                    <div class="card-header"><i class="fas fa-table mr-1"></i>Gestión de Subprocesos</div>
                    <div class="card-body">
                        
                        <div class="text-right">
                            <a href='?opcion=1'><button class="btn btn-info mb-2" title="Nuevo"><i class="fas fa-plus-circle fa-2x"></i></button></a>
                        </div>
                        <div class="table-responsive">
                            <table id="subprocesos" class="table-bordered table-hover" width="100%" cellspacing="0">
                                <thead>
                                    <tr class="bg-info text-light">
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Descripcion</th>
                                        <th>Fecha de Creación</th>
                                        <th>Proceso Padre</th>
                                        <th>Estado</th>
                                        <th>Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    foreach ($data as $row) {
                                        echo "<tr>
                                            <td>{$row['subproceso_id']}</td>
                                            <td>{$row['subproceso_nombre']}</td>
                                            <td>{$row['subproceso_descripcion']}</td>
                                            <td>{$row['subproceso_fecha']}</td>
                                            <td>{$row['proceso_nombre']}</td> <!-- Muestra el nombre del proceso padre -->
                                            <td>";

                                        if ($row['subproceso_estado'] == 1) {
                                            echo "<button class='btn btn-success'disabled>Activo</button>";
                                        } elseif ($row['subproceso_estado'] == 0) {
                                            echo "<button class='btn btn-danger'disabled>Inactivo</button>";
                                        }

                                        echo "</td>
                                            <td>
                                                <div class='btn-group' role='group'>
                                                    <a href='?opcion=2&id={$row['subproceso_id']}'>
                                                        <button class='btn btn-secondary mr-2' title='Editar'>
                                                            <i class='fas fa-pencil-alt'></i>
                                                        </button>
                                                    </a>";

                                        if ($row['subproceso_estado'] == 0) {
                                            echo "<a onclick='activar(event)' href='?opcion=4&id={$row['subproceso_id']}&estado=1'>
                                                <button class='btn btn-warning mr-2' title='Activar usuario'>
                                                    <i class='fas fa-lock-open'></i>
                                                </button>
                                            </a>";
                                        } else {
                                            echo "<a onclick='desactivar(event)' href='?opcion=4&id={$row['subproceso_id']}&estado=0'>
                                                <button class='btn btn-warning mr-2' title='Desactivar usuario'>
                                                    <i class='fas fa-lock'></i>
                                                </button>
                                            </a>";
                                        }

                                        echo "<a onclick='confirmacion(event)' href='?opcion=3&id={$row['subproceso_id']}'>
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
<!-- Js configuracion -->
<script>
var table = new DataTable('#subprocesos', {
    language: {
        url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json',
    },
});
</script>
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