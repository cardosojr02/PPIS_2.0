<?php
 require_once "vistas/parte_superior.php"; 


$rolUsuario = $_SESSION['tipo_usuario'] ?? 0;

// Definir las consultas SQL basadas en el rol del usuario
if ($rolUsuario == 1 || $rolUsuario == 7) {
    // Administrador (1) o superusuario (7) pueden ver todas las actividades
        $sqlMasDeUnMes = "SELECT *, DATEDIFF(fecha_fin, NOW()) AS dias_restantes
                        FROM actividades
                        WHERE fecha_fin > DATE_ADD(NOW(), INTERVAL 1 MONTH)";

        $sqlMenosDeUnMes = "SELECT *, DATEDIFF(fecha_fin, NOW()) AS dias_restantes
        FROM actividades
        WHERE fecha_fin <= DATE_ADD(NOW(), INTERVAL 1 MONTH) AND fecha_fin > NOW()";

        $sqlVencidas = "SELECT *, DATEDIFF(NOW(), fecha_fin) AS dias_vencidas
        FROM actividades
        WHERE fecha_fin <= NOW()";

} else {
    // Otros usuarios solo pueden ver las actividades a las que son asignados como docentes responsables
   // Consultas SQL modificadas con DATEDIFF
        $sqlMasDeUnMes = "SELECT a.*, DATEDIFF(a.fecha_fin, NOW()) AS dias_restantes
        FROM actividades a
        INNER JOIN actividades_usuarios au ON a.id = au.id_actividad
        WHERE au.id_usuario = :id AND a.fecha_fin > DATE_ADD(NOW(), INTERVAL 1 MONTH)";

        $sqlMenosDeUnMes = "SELECT a.*, DATEDIFF(a.fecha_fin, NOW()) AS dias_restantes
        FROM actividades a
        INNER JOIN actividades_usuarios au ON a.id = au.id_actividad
        WHERE au.id_usuario = :id AND a.fecha_fin <= DATE_ADD(NOW(), INTERVAL 1 MONTH) AND a.fecha_fin > NOW()";

        $sqlVencidas = "SELECT a.*, DATEDIFF(NOW(), a.fecha_fin) AS dias_vencidas
        FROM actividades a
        INNER JOIN actividades_usuarios au ON a.id = au.id_actividad
        WHERE au.id_usuario = :id AND a.fecha_fin <= NOW()";

}

// Ejecutar las consultas y obtener los resultados
// Asegúrate de tener la variable $conexion definida y disponible en este punto
$stmtMasDeUnMes = $conexion->prepare($sqlMasDeUnMes);
$stmtMenosDeUnMes = $conexion->prepare($sqlMenosDeUnMes);
$stmtVencidas = $conexion->prepare($sqlVencidas);

// Bind de parámetros si es necesario (solo en el caso de roles no admin/superusuario)
if ($rolUsuario != 1 && $rolUsuario != 7) {
    $stmtMasDeUnMes->bindParam(':id', $_SESSION['id'], PDO::PARAM_INT);
    $stmtMenosDeUnMes->bindParam(':id', $_SESSION['id'], PDO::PARAM_INT);
    $stmtVencidas->bindParam(':id', $_SESSION['id'], PDO::PARAM_INT);
}

// Ejecutar consultas
$stmtMasDeUnMes->execute();
$stmtMenosDeUnMes->execute();
$stmtVencidas->execute();

// Obtener el número de registros de cada consulta
$contarMasDeUnMes = $stmtMasDeUnMes->rowCount();
$contarMenosDeUnMes = $stmtMenosDeUnMes->rowCount();
$contarVencidas = $stmtVencidas->rowCount();
?>



<style>
    .verde { background-color: #28a745; color: white; padding: 10px; }
    .amarillo { background-color: #ffc107; color: white; padding: 10px; }
    .rojo { background-color: #dc3545; color: white; padding: 10px; }

    /* Estilo de texto original para los enlaces */
    .actividad-link {
        color: inherit;
        text-decoration: none;
        }
</style>

<main>
    <div id="layoutSidenav_content">
        <div class="container-fluid">
            <h1 class="mt-4">Semáforo</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="principal.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="configuracion.php">Configuración</a></li>
                <li class="breadcrumb-item active">Semáforo</li>
            </ol>

            <div class="card mb-4">
                <div class="card-body">
                <p><strong>Bienvenido al Módulo del Semáforo - Gestión de Actividades.</strong></p>
                <p>Este módulo proporciona una visualización rápida del estado de las actividades a través de un semáforo.</p>
                <p>A continuación, encontrarás información detallada sobre las actividades que están próximas a vencer o que ya han vencido, organizadas por categorías de tiempo.</p>
                <p>Recuerda que el color del semáforo indica la urgencia de atención:</p>
                <ul>
                    <div>
                    <li><span class="verde"></span>  Actividades que vencen en más de un mes.</li>
                    </div>
                    <p></p>
                    <div>
                    <li><span class="amarillo"></span>  Actividades que vencen en menos de un mes.</li>
                    </div>
                    <p></p>
                    <div>
                    <li><span class="rojo"></span>  Actividades vencidas.</li>
                    </div>
                </ul>
                </div>
            </div>

            <div id="appProcesos">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table mr-1"></i>Gestión de Semáforo
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <h2 class="verde">Actividades que vencen en más de un mes: <?php echo $contarMasDeUnMes; ?></h2>
                                <div class="verde">
                                    <?php while ($row = $stmtMasDeUnMes->fetch(PDO::FETCH_ASSOC)): ?>
                                        <p>
                                            <a href="detalle_actividad.php?id=<?php echo $row['id']; ?>"class="actividad-link">
                                                <?php echo "<p>{$row['nombre']} - {$row['fecha_fin']} - Días restantes: {$row['dias_restantes']}</p>"; ?>
                                            </a>
                                        </p>
                                    <?php endwhile; ?>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <h2 class="amarillo">Actividades que vencen en menos de un mes: <?php echo $contarMenosDeUnMes; ?></h2>
                                <div class="amarillo">
                                    <?php while ($row = $stmtMenosDeUnMes->fetch(PDO::FETCH_ASSOC)): ?>
                                        <p>
                                            <a href="detalle_actividad.php?id=<?php echo $row['id']; ?>"class="actividad-link">
                                                <?php echo "<p>{$row['nombre']} - {$row['fecha_fin']} - Días restantes: {$row['dias_restantes']}</p>"; ?>
                                            </a>
                                        </p>
                                    <?php endwhile; ?>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <h2 class="rojo">Actividades vencidas: <?php echo $contarVencidas; ?></h2>
                                <div class="rojo">
                                    <?php while ($row = $stmtVencidas->fetch(PDO::FETCH_ASSOC)): ?>
                                        <p>
                                            <a href="detalle_actividad.php?id=<?php echo $row['id']; ?>"class="actividad-link">
                                                <?php echo "<p>{$row['nombre']} - {$row['fecha_fin']} - Días vencidas: {$row['dias_vencidas']}</p>"; ?>
                                            </a>
                                        </p>
                                    <?php endwhile; ?>
                                </div>
                            </div>
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
    var table = new DataTable('#procesos', {
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json',
        },
    });
</script>

    