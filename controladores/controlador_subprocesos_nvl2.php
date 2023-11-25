<?php
require_once('./conexion.php');

try {
    $consulta = "SELECT s.*, p.nombre AS nombre_proceso
    FROM subprocesos_nivel2 AS s
    LEFT JOIN subprocesos AS p ON s.id_subproceso = p.id;";
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
            // Actualiza el estado del subproceso en la base de datos
            $consulta = "UPDATE subprocesos_nivel2 SET estado = :estado WHERE id = :id";
            $stmt = $conexion->prepare($consulta);
            $stmt->bindParam(':estado', $estado, PDO::PARAM_INT);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                // Si la actualización es exitosa, muestra una notificación
                print '<script>
                    Swal.fire({
                        title: "Estado Actualizado",
                        text: "¡Estado del subproceso nivel 2 ' . $id . ' actualizado!",
                        icon: "success",
                        allowOutsideClick: false,
                        showCancelButton: false,
                        allowEscapeKey: false,
                        allowEnterKey: false,
                        confirmButtonText: "OK"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "subprocesos_nvl2.php"; // Redirige a la página de subprocesos de nivel 2
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
            $sql_delete = "DELETE FROM subprocesos_nivel2 WHERE id = :id";
            $stmt = $conexion->prepare($sql_delete);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                print '<script>
                    Swal.fire({
                        title: "Subproceso Eliminado",
                        text: "Subproceso nivel 2 ' . $id . ' Eliminado correctamente",
                        icon: "success",
                        allowOutsideClick: false,
                        showCancelButton: false,
                        allowEscapeKey: false,
                        allowEnterKey: false,
                        confirmButtonText: "OK"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "subprocesos_nvl2.php"; // Corregir aquí
                        }
                    });
                </script>';
            }
        } catch (Exception $e) {
            if ($e->getCode() == "23000" && strpos($e->getMessage(), "FOREIGN KEY") !== false) {
                print "<script>
            Swal.fire(
                'Error',
                'Este Subproceso nivel 2 tiene actividades asignadas, no se puede eliminar.',
                'error'
            )
            </script>";
            } else {
                print "<script>
            Swal.fire(
                'Error!',
                'Ocurrió un error: " . $e->getMessage() . "',
                'error'
            )
            </script>";
            }  
        }
        
        
    }

    if ($action == '2' && isset($_GET['id'])) {
        $id = $_GET['id'];

        // Realiza una consulta para obtener los detalles del subproceso
        $consulta_subproceso_nivel2 = "SELECT * FROM subprocesos_nivel2 WHERE id = :id";
        $stmt = $conexion->prepare($consulta_subproceso_nivel2);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $subproceso_nivel2 = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($subproceso_nivel2) {
            $id = $subproceso_nivel2['id'];
            $nombre = $subproceso_nivel2['nombre'];
            $estado = $subproceso_nivel2['estado'];
            $id_subproceso = $subproceso_nivel2['id_subproceso'];
            ?>

            <script>
                Swal.fire({
                    title: 'Actualizar Subproceso de Nivel 2',
                    html: `
                        <form action="#" method="POST" class="text-left m-3">
                            <div class="form-group">
                                <label for="nombre">Nombre</label>
                                <input type="text" name="nombre" value="<?php echo $nombre ?>" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="estado">Estado</label>
                                <select name="estado" class="form-control">
                                    <option value="1" <?php if ($estado == 1) echo 'selected'; ?>>Activo</option>
                                    <option value="0" <?php if ($estado == 0) echo 'selected'; ?>>Inactivo</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="id_subproceso">Subproceso Padre</label>
                                <select name="id_subproceso" class="form-control">
                                    <?php
                                    $consulta_subprocesos = "SELECT id, nombre FROM subprocesos"; // Ajusta el nombre de la tabla y los campos según tu estructura
                                    $stmt_subprocesos = $conexion->prepare($consulta_subprocesos);
                                    $stmt_subprocesos->execute();
                                    $subprocesos = $stmt_subprocesos->fetchAll(PDO::FETCH_ASSOC);
    
                                    foreach ($subprocesos as $subproceso) {
                                        $selected = ($subproceso['id'] == $id_subproceso) ? 'selected' : '';
                                        echo '<option value="' . $subproceso['id'] . '" ' . $selected . '>' . $subproceso['nombre'] . '</option>';
                                    }
                                    ?>
                                </select>
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
        $consulta_subprocesos = "SELECT id, nombre FROM subprocesos WHERE estado = 1";
        $stmt_subprocesos = $conexion->prepare($consulta_subprocesos);
        $stmt_subprocesos->execute();
        $subprocesos = $stmt_subprocesos->fetchAll(PDO::FETCH_ASSOC);

        ?>
        <script>
            Swal.fire({
                title: 'Nuevo Subproceso de Nivel 2',
                html: `
                    <form action="#" method="POST" class="text-left m-3">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" name="nombre" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="estado">Estado</label>
                            <select name="estado" class="form-control">
                                <option value="1" selected>Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="id_subproceso">Subproceso Padre</label>
                            <select name="id_subproceso" class="form-control">
                                <?php
                                foreach ($subprocesos as $subproceso) {
                                    echo '<option value="' . $subproceso['id'] . '">' . $subproceso['nombre'] . '</option>';
                                }
                                ?>
                            </select>
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
    $estado = $_POST['estado'];
    $id_subproceso = $_POST['id_subproceso'];

    $insert_subproceso_nivel2 = "INSERT INTO subprocesos_nivel2 (nombre, estado, id_subproceso, fecha_sys) 
                      VALUES (:nombre, :estado, :id_subproceso, NOW())";

    try {
        $stmt = $conexion->prepare($insert_subproceso_nivel2);

        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':estado', $estado, PDO::PARAM_INT);
        $stmt->bindParam(':id_subproceso', $id_subproceso, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "<script>
                let timerInterval;
                Swal.fire({
                    title: '¡Registrando!',
                    text: 'Espere un momento...',
                    icon: 'success',
                    timer: 3000, // Tiempo en milisegundos (3 segundos)
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
                        window.location.href = 'subprocesos_nvl2.php'; // Redirige a la página de subprocesos de nivel 2
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
        window.location.href = 'subprocesos_nvl2.php';
    }, 3000);
</script>";
}

/* Actualizar formulario de editar */

if (isset($_POST['btnActualizar'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $estado = $_POST['estado'];
    $id_subproceso = $_POST['id_subproceso'];

    $update_subproceso_nivel2 = "UPDATE subprocesos_nivel2 SET nombre = :nombre, estado = :estado, id_subproceso = :id_subproceso WHERE id = :id";

    try {
        $stmt = $conexion->prepare($update_subproceso_nivel2);

        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':estado', $estado, PDO::PARAM_INT);
        $stmt->bindParam(':id_subproceso', $id_subproceso, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "<script>
                let timerInterval;
                Swal.fire({
                    title: '¡Actualizando!',
                    text: 'Espere un momento...',
                    icon: 'success',
                    timer: 3000, // Tiempo en milisegundos (3 segundos)
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
                        window.location.href = 'subprocesos_nvl2.php';
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
            window.location.href = 'subprocesos_nvl2.php';
        }, 3000);
    </script>";
}
?>
