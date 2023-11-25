<?php
require_once('./conexion.php');

try {
    $consulta = "SELECT * FROM periodos";
    $resultado = $conexion->prepare($consulta);
    $resultado->execute();
    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo $e->getMessage();
}

/* Acciones */

if (isset($_GET['opcion'])) {
    $action = $_GET['opcion'];

    if ($action == '4' && isset($_GET['id']) && isset($_GET['estado'])) {
        $estado = $_GET['estado'];
        $id = $_GET['id'];
    
        try {
            // Actualiza el estado del periodo en la base de datos
            $consulta = "UPDATE periodos SET estado = $estado WHERE id = $id";
    
            if ($conexion->query($consulta)) {
                // Si la actualización es exitosa, muestra una notificación
                print '<script>
                    Swal.fire({
                        title: "Estado Actualizado",
                        text: "¡Estado del periodo ' . $id . ' actualizado!",
                        icon: "success",
                        allowOutsideClick: false,
                        showCancelButton: false,
                        allowEscapeKey: false,
                        allowEnterKey: false,
                        confirmButtonText: "OK"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "periodos.php"; // Redirige a la página de periodos
                        }
                    });
                </script>';
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
    if ($action == '3' && isset($_GET['id'])) {
        $id = $_GET['id'];

        try {
            $sql_delete = "DELETE FROM periodos WHERE id='$id'";
            if ($conexion->query($sql_delete)) {
                print '<script>
                Swal.fire({
                    title: "Periodo Eliminado",
                    text: "Periodo ' . $id . ' Eliminado correctamente",
                    icon: "success",
                    allowOutsideClick: false,
                    showCancelButton: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    confirmButtonText: "OK"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "periodos.php";
                    }
                });
            </script>';
            } else {
                print "<script>
                Swal.fire(
                    'Error!',
                    'Ocurrió un error.',
                    'error'
                )
                </script>";
            }
        } catch (Exception $e) {
            print "<script>
            Swal.fire(
                'Error!',
                'Ocurrió un error: " . $e->getMessage() . "',
                'error'
            )
            </script>";
        }
    }

    if ($action == '2' && isset($_GET['id'])) {
        $id = $_GET['id'];

        // Realiza una consulta para obtener los detalles del periodo
        $consulta_periodo = "SELECT * FROM periodos WHERE id = :id";
        $stmt = $conexion->prepare($consulta_periodo);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $periodo = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($periodo) {
            $id = $periodo['id'];
            $nombre = $periodo['nombre'];
            $fecha_inicio = $periodo['fecha_inicio'];
            $fecha_fin = $periodo['fecha_fin'];
            ?>

            <script>
                Swal.fire({
                    title: 'Actualizar Periodo',
                    html: `
                        <form action="#" method="POST" class="text-left m-3">
                            <div class="form-group">
                                <label for="nombre">Nombre</label>
                                <input type="text" name="nombre" value="<?php echo $nombre ?>" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="fecha_inicio">Fecha de Inicio</label>
                                <input type="date" name="fecha_inicio" value="<?php echo $fecha_inicio ?>" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="fecha_fin">Fecha de Fin</label>
                                <input type="date" name="fecha_fin" value="<?php echo $fecha_fin ?>" class="form-control" required>
                            </div>
                            <input type="hidden" name="id" value="<?php echo $id ?>">
                            <input type="submit" name="btnActualizar" class="btn btn-outline-secondary btn-lg btn-block mt-4">
                        </form>
                    `,
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    showCancelButton: false,
                    showCloseButton: true,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                });
            </script>
            <?php
        }
    }
    if ($action == '1') {
        ?>
    
        <script>
            Swal.fire({
                title: 'Nuevo Periodo',
                html: `
                    <form action="#" method="POST" class="text-left m-3">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" name="nombre" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="fecha_inicio">Fecha de Inicio</label>
                            <input type="date" name="fecha_inicio" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="fecha_fin">Fecha de Fin</label>
                            <input type="date" name="fecha_fin" class="form-control" required>
                        </div>
                        <input type="submit" name="btnRegistrar" class="btn btn-outline-secondary btn-lg btn-block mt-4">
                    </form>
                `,
                showConfirmButton: false,
                allowOutsideClick: false,
                showCancelButton: false,
                showCloseButton: true,
                allowEscapeKey: false,
                allowEnterKey: false,
            });
        </script>
        <?php
    }
}

/* Enviar formulario de registro */

if (isset($_POST['btnRegistrar'])) {
    $nombre = $_POST['nombre'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];

    $insert_periodo = "INSERT INTO periodos (nombre, fecha_inicio, fecha_fin, fecha_sys) VALUES (:nombre, :fecha_inicio, :fecha_fin, NOW())";

    try {
        $stmt = $conexion->prepare($insert_periodo);

        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':fecha_inicio', $fecha_inicio, PDO::PARAM_STR);
        $stmt->bindParam(':fecha_fin', $fecha_fin, PDO::PARAM_STR);

        if ($stmt->execute()) {
            echo "<script>
            let timerInterval;
            Swal.fire({
                title: '¡Registrando!',
                text: 'Espere un momento...',
                icon: 'success',
                timer: 3000, // Tiempo en milisegundos (2 segundos)
                timerProgressBar: true, // Muestra una barra de progreso
                showConfirmButton: false,
                onBeforeOpen: () => {
                    Swal.showLoading();
                    timerInterval = setInterval(() => {
                        const content = Swal.getContent();
                        if (content) {
                            const b = content.querySelector('b');
                            if (b) {
                                b.textContent = (Swal.getTimerLeft() / 1000).toFixed(0);
                            }
                        }
                    }, 1000);
                },
                onClose: () => {
                    clearInterval(timerInterval);
                    window.location.href = 'periodos.php'; 
                }
            });
        </script>";
        }
        } catch (PDOException $e) {
        print "<script>
        Swal.fire(
        'Error!',
        'Ocurrió un error: " . $e->getMessage() . "',
        'error'
        )
        </script>";
        }
    
        echo "<script>
        setTimeout(function() {
            window.location.href = 'periodos.php';
        }, 3000);
    </script>";
    
    }

/* Actualizar formulario de editar */

if (isset($_POST['btnActualizar'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];

    $update_periodo = "UPDATE periodos SET nombre = :nombre, fecha_inicio = :fecha_inicio, fecha_fin = :fecha_fin WHERE id = :id";

    try {
        $stmt = $conexion->prepare($update_periodo);

        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':fecha_inicio', $fecha_inicio, PDO::PARAM_STR);
        $stmt->bindParam(':fecha_fin', $fecha_fin, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "<script>
    let timerInterval;
    Swal.fire({
        title: '¡Actualizando!',
        text: 'Espere un momento...',
        icon: 'success',
        timer: 3000, // Tiempo en milisegundos (2 segundos)
        timerProgressBar: true, // Muestra una barra de progreso
        showConfirmButton: false,
        onBeforeOpen: () => {
            Swal.showLoading();
            timerInterval = setInterval(() => {
                const content = Swal.getContent();
                if (content) {
                    const b = content.querySelector('b');
                    if (b) {
                        b.textContent = (Swal.getTimerLeft() / 1000).toFixed(0);
                    }
                }
            }, 1000);
        },
        onClose: () => {
            clearInterval(timerInterval);
            window.location.href = 'periodos.php'; 
        }
    });
</script>";
        }
    } catch (PDOException $e) {
        print "<script>
            Swal.fire(
            'Error!',
            'Ocurrió un error: " . $e->getMessage() . "',
            'error'
            )
        </script>";
    }
    echo "<script>
    setTimeout(function() {
        window.location.href = 'periodos.php';
    }, 3000);
</script>";
    
}
?>
