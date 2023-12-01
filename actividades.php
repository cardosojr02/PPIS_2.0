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
        include "controladores/controlador_actividades.php";
        ?>
        
        <main>
        
    <div id="layoutSidenav_content">
        <div class="container-fluid">
            <h1 class="mt-4">Actividades</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="principal.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="configuracion.php">Configuración</a></li>
                <li class="breadcrumb-item active">Actividades</li>
            </ol>
            <div class="card mb-4">
                <div class="card-body">
                    En este apartado, se realiza la creación de actividades de PPIS 2.0. Es importante tener en cuenta la sensibilidad de la modificación de los datos en este proceso. Asegúrese de tomar las medidas adecuadas para proteger la información y garantizar la integridad de los datos de los actividades.
                    <br><br>Aquí se muestra una tabla con los actividades registrados en el sistema. Tenga en cuenta que cualquier cambio realizado afectará directamente la información de los actividades y puede tener un impacto en su acceso y permisos en el sistema.<br><br>
                    Utilice los botones de edición y eliminación con precaución. Antes de realizar cualquier modificación o eliminación de un periodo, asegúrese de verificar y confirmar la acción para evitar cualquier consecuencia no deseada.<br><br>
                    Recuerde seguir las políticas de seguridad establecidas y respetar la privacidad de los actividades al interactuar con sus datos.
                    Para obtener más información sobre el funcionamiento de la gestión de actividades en PPIS 2.0, consulte la documentación oficial del sistema.
                    Ante cualquier duda o inconveniente, comuníquese con el equipo de soporte técnico para recibir asistencia especializada.
                </div>
            </div>
            <div id="appMoviles">
                <div class="card mb-4">
                    <div class="card-header"><i class="fas fa-table mr-1"></i>Gestión de Actividades</div>
                    <div class="card-body">
                        <div class="col text-right">
                            <a href='?opcion=1'><button class="btn btn-info mb-2" title="Nuevo"><i class="fas fa-plus-circle fa-2x"></i></button></a>
                        </div>
                        <div class="table-responsive">
                        <table id="actividades" class="table table-hover" width="100%" cellspacing="0">
                            <thead>
                                <tr class="bg-info text-light">
                                    <th class="text-center">ID</th>
                                    <th class="text-center">Nombre</th>
                                    <th class="text-center">Periodo</th>
                                    <th class="text-center">Proceso</th>
                                    <th class="text-center">Subproceso</th>
                                    <th class="text-center">Subproceso Nivel 2 Padre</th>
                                    <th class="text-center">Fecha de Inicio</th>
                                    <th class="text-center">Fecha de Fin</th>
                                    <th class="text-center">Creación</th>
                                    <th class="text-center">Progreso</th>
                                    <th class="text-center">Estado</th>
                                    <th class="text-center">Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($data as $row) {
                                    echo "<tr>";
                                    echo "<td class='text-center'>{$row['id']}</td>";
                                    echo "<td class='text-center'><a href='detalle_actividad.php?id={$row['id']}'>{$row['nombre']}</a></td>";
                                    echo "<td class='text-center'>{$row['nombre_periodo']}</td>";
                                    echo "<td class='text-center'>{$row['nombre_proceso']}</td>";
                                    echo "<td class='text-center'>{$row['nombre_subproceso_nivel']}</td>";
                                    echo "<td class='text-center'>{$row['nombre_subproceso']}</td>";
                                    echo "<td class='text-center'>{$row['fecha_inicio']}</td>";
                                    echo "<td class='text-center'>{$row['fecha_fin']}</td>";
                                    echo "<td class='text-center'>{$row['fecha_sys']}</td>";
                                    echo "<td class='text-center'>{$row['progreso']}</td>";
                                    echo "<td class='text-center'>";
                                        if ($row['estado'] == 1) {
                                            echo "<button class='btn btn-success' disabled>Activo</button>";
                                        } elseif ($row['estado'] == 0) {
                                            echo "<button class='btn btn-danger' disabled>Inactivo</button>";
                                        }
                                        echo "</td>
                                        <td class='text-center'>
                                            <div class='btn-group' role='group'>
                                                <a href='?opcion=2&id={$row['id']}'>
                                                    <button class='btn btn-secondary mr-2' title='Editar'>
                                                        <i class='fas fa-pencil-alt'></i>
                                                    </button>
                                                </a>";

                                        if ($row['estado'] == 0) {
                                            echo "<a onclick='activar(event)' href='?opcion=4&id={$row['id']}&estado=1'>
                                            <button class='btn btn-warning mr-2' title='Activar usuario'>
                                                <i class='fas fa-lock-open'></i>
                                            </button>
                                        </a>";
                                        } else {
                                            echo "<a onclick='desactivar(event)' href='?opcion=4&id={$row['id']}&estado=0'>
                                            <button class='btn btn-warning mr-2' title='Desactivar usuario'>
                                                <i class='fas fa-lock'></i>
                                            </button>
                                        </a>";
                                        }

                                        echo "<a onclick='confirmacion(event)' href='?opcion=3&id={$row['id']}'>
                                        <button class='btn btn-danger mr-2' title='Eliminar'>
                                            <i class='fas fa-trash-alt'></i>
                                        </button>
                                    </a>
                                </div>
                            </td>
                            </tr>";
                                        echo "</td>";
                                        echo "</tr>";
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
<!-- Código custom -->
<script src="js/scripts.js"></script>
<script src="controladores/eliminar.js"></script>

<!-- JavaScript -->
<script src="jquery/jquery-3.3.1.min.js"></script>
<script src="popper/popper.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<!-- Agrega DataTables Buttons -->
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

<script>
    $(document).ready(function() {
        var table = $('#actividades').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
            },
            order: [[8, 'desc']], // Ordenar por la columna de fecha de creación en forma descendente
            dom: 'Bfrtip',
            buttons: [
    {
        extend: 'excelHtml5',
        text: '<i class="fas fa-file-excel"></i>&nbsp;&nbsp; Exportar a Excel',
        filename: 'actividades_ppis',
        title: 'ACTIVIDADES PPIS 2.0',
        exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10 ]
                }
        
    },
    {
        extend: 'print',
        text: '<i class="fas fa-print"></i>&nbsp;&nbsp; Imprimir',
        filename: 'actividades_ppis',
        title: 'ACTIVIDADES PPIS 2.0',
        exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10 ]
                }
        
    },
    {
        extend: 'copyHtml5',
        text: '<i class="fas fa-copy"></i>&nbsp;&nbsp; Copiar',
        filename: 'actividades_ppis',
        title: 'ACTIVIDADES PPIS 2.0',
        exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10 ]
                }
        
    },
    
    'colvis'
],
            
        });
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

