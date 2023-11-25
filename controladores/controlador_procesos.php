<?php
require_once('./conexion.php');

try {
    $consulta = "SELECT p.*, pe.nombre AS nombre_periodo
    FROM procesos AS p
    LEFT JOIN periodos AS pe ON p.id_periodo = pe.id;";
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
            // Actualiza el estado del proceso en la base de datos
            $consulta = "UPDATE procesos SET estado = :estado WHERE id = :id";
            $stmt = $conexion->prepare($consulta);
            $stmt->bindParam(':estado', $estado, PDO::PARAM_INT);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                // Si la actualización es exitosa, muestra una notificación
                print '<script>
                    Swal.fire({
                        title: "Estado Actualizado",
                        text: "¡Estado del proceso ' . $id . ' actualizado!",
                        icon: "success",
                        allowOutsideClick: false,
                        showCancelButton: false,
                        allowEscapeKey: false,
                        allowEnterKey: false,
                        confirmButtonText: "OK"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "procesos.php"; // Redirige a la página de procesos
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
            $sql_delete = "DELETE FROM procesos WHERE id = :id";
            $stmt = $conexion->prepare($sql_delete);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                print '<script>
                Swal.fire({
                    title: "Proceso Eliminado",
                    text: "Proceso ' . $id . ' Eliminado correctamente",
                    icon: "success",
                    allowOutsideClick: false,
                    showCancelButton: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    confirmButtonText: "OK"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "procesos.php";
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

        // Realiza una consulta para obtener los detalles del proceso
        $consulta_proceso = "SELECT * FROM procesos WHERE id = :id";
        $stmt = $conexion->prepare($consulta_proceso);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $proceso = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($proceso) {
            $id = $proceso['id'];
            $nombre = $proceso['nombre'];
            $descripcion = $proceso['descripcion'];
            $categoria = $proceso['categoria'];
            $id_periodo = $proceso['id_periodo']; // Campo para el periodo padre
            ?>

            <script>
                Swal.fire({
                    title: 'Actualizar Proceso',
                    html: `
                        <form action="#" method="POST" class="text-left m-3">
                            <div class="form-group">
                                <label for="nombre">Nombre</label>
                                <input type="text" name="nombre" value="<?php echo $nombre ?>" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="descripcion">Descripción</label>
                                <textarea name="descripcion" class="form-control" rows="4" required><?php echo $descripcion ?></textarea>
                            </div>
                            <div class="form-group">
                            <label for="categoria">Categoría</label>
                            <select name="categoria" class="form-control" required>
                                <option value="Urgente" <?php echo ($categoria == 'Urgente') ? 'selected' : ''; ?>>Urgente</option>
                                <option value="Importante" <?php echo ($categoria == 'Importante') ? 'selected' : ''; ?>>Importante</option>
                                <option value="Baja urgencia" <?php echo ($categoria == 'Baja urgencia') ? 'selected' : ''; ?>>Baja urgencia</option>
                            </select>
                        </div>
                            <div class="form-group">
                                <label for="id_periodo">Periodo Padre</label>
                                <select name="id_periodo" class="form-control">
                                    <?php
                                    $consulta_periodos = "SELECT id, nombre FROM periodos"; // Ajusta el nombre de la tabla y los campos según tu estructura
                                    $stmt_periodos = $conexion->prepare($consulta_periodos);
                                    $stmt_periodos->execute();
                                    $periodos = $stmt_periodos->fetchAll(PDO::FETCH_ASSOC);
    
                                    foreach ($periodos as $periodo) {
                                        $selected = ($periodo['id'] == $id_periodo) ? 'selected' : '';
                                        echo '<option value="' . $periodo['id'] . '" ' . $selected . '>' . $periodo['nombre'] . '</option>';
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
        $consulta_periodos = "SELECT id, nombre FROM periodos WHERE estado = 1";
        $stmt_periodos = $conexion->prepare($consulta_periodos);
        $stmt_periodos->execute();
        $periodos = $stmt_periodos->fetchAll(PDO::FETCH_ASSOC);
        

        ?>
        <script>
            Swal.fire({
                title: 'Nuevo Proceso',
                html: `
                    <form action="#" method="POST" class="text-left m-3">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" name="nombre" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <textarea name="descripcion" class="form-control" rows="4" required></textarea>
                        </div>
                        <div class="form-group">
                        <label for="categoria">Categoría</label>
                        <select name="categoria" class="form-control" required>
                            <option value="Urgente">Urgente</option>
                            <option value="Importante">Importante</option>
                            <option value="Baja urgencia">Baja urgencia</option>
                        </select>
                        </div>
                        <div class="form-group">
                            <label for="id_periodo">Periodo Padre</label>
                            <select name="id_periodo" class="form-control">
                                <?php
                                foreach ($periodos as $periodo) {
                                    echo '<option value="' . $periodo['id'] . '">' . $periodo['nombre'] . '</option>';
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
    $descripcion = $_POST['descripcion'];
    $categoria = $_POST['categoria'];
    $id_periodo = $_POST['id_periodo'];
    $estado = 1;

    $insert_proceso = "INSERT INTO procesos (nombre, descripcion, categoria, id_periodo, estado, fecha_sys) 
                      VALUES (:nombre, :descripcion, :categoria, :id_periodo, :estado, NOW())";

    try {
        $stmt = $conexion->prepare($insert_proceso);

        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
        $stmt->bindParam(':categoria', $categoria, PDO::PARAM_STR);
        $stmt->bindParam(':id_periodo', $id_periodo, PDO::PARAM_INT);
        $stmt->bindParam(':estado', $estado, PDO::PARAM_INT);

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
                        window.location.href = 'procesos.php'; // Redirige a la página de procesos
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
        window.location.href = 'procesos.php';
    }, 3000);
</script>";
}

/* Actualizar formulario de editar */

if (isset($_POST['btnActualizar'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $categoria = $_POST['categoria'];
    $id_periodo = $_POST['id_periodo'];

    $update_proceso = "UPDATE procesos SET nombre = :nombre, descripcion = :descripcion, categoria = :categoria, id_periodo = :id_periodo WHERE id = :id";

    try {
        $stmt = $conexion->prepare($update_proceso);

        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
        $stmt->bindParam(':categoria', $categoria, PDO::PARAM_STR);
        $stmt->bindParam(':id_periodo', $id_periodo, PDO::PARAM_INT);
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
                        window.location.href = 'procesos.php';
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
            window.location.href = 'procesos.php';
        }, 3000);
    </script>";
}

?>
