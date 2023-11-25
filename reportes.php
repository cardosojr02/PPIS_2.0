<?php
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
        
        ?>
        <div id="layoutSidenav_content">
            <div class="container-fluid">
                <div class="container mt-5">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header bg-info text-white text-center">
                                    <h3 class="mb-0">Generar Reportes</h3>
                                </div>
                                <div class="card-body">
                                    <form action="generar_reporte.php" method="post">
                                        <div class="form-group text-center">
                                            
                                            <div>
                                                <h5>Reporte de Usuarios</h5>
                                                <!-- Botón para generar reporte de usuarios activos/inactivos -->
                                                <button class="btn btn-outline-info mb-2 mr-2" onclick="generarReporteUsuarios()">Usuarios Activos/Inactivos</button>
                                                <!-- Botón para generar resumen de actividades por usuario -->
                                                <button class="btn btn-outline-info mb-2 mr-2" onclick="generarResumenActividades()">Resumen de Actividades por Usuario</button>
                                                </div>

                                                <!-- Sección para reporte de procesos y subprocesos -->
                                                <div>
                                                <h5>Reporte de Procesos y Subprocesos</h5>
                                                <!-- Botón para generar estado y avance de procesos -->
                                                <button class="btn btn-outline-info mb-2 mr-2" onclick="generarEstadoProcesos()">Estado y Avance de Procesos</button>
                                                <!-- Botón para generar detalles de subprocesos -->
                                                <button class="btn btn-outline-info mb-2 mr-2" onclick="generarDetallesSubprocesos()">Detalles de Subprocesos</button>
                                                </div>

                                                <!-- Sección para reporte de actividades -->
                                                <div>
                                                <h5>Reporte de Actividades</h5>
                                                <!-- Botón para generar historial de avances por actividad -->
                                                <button class="btn btn-outline-info mb-2 mr-2" onclick="generarHistorialAvances()">Historial de Avances por Actividad</button>
                                                <!-- Botón para generar resumen de actividades en un periodo específico -->
                                                <button class="btn btn-outline-info mb-2 mr-2" onclick="generarResumenActividadesPeriodo()">Resumen de Actividades en Periodo</button>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Puedes agregar más campos para ajustar los parámetros específicos de cada reporte -->

                                        <button type="submit" class="btn btn-info"><i class="fas fa-file-alt"></i> Generar Reporte</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
        <script src="jquery/jquery-3.3.1.min.js"></script>
        <script src="popper/popper.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
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
