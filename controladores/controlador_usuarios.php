<?php
require_once('./conexion.php');




try {
    $consulta = "SELECT us.*,rl.rol FROM usuarios as us,roles as rl WHERE us.tipo_usuario = rl.id";
    $resultado = $conexion->prepare($consulta);
    $resultado->execute();
    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo $e->getMessage();
}

/* Acciones */

if(isset($_GET['opcion'])){
    $action = $_GET['opcion'];
    if ($action == '4' && isset($_GET['id']) && isset($_GET['estado'])) {
        $estado=$_GET['estado'];
        $id=$_GET['id'];
        try {
                
            $consulta="UPDATE usuarios SET estado = $estado WHERE id= $id";
            if ($conexion->query($consulta)) {
                print '<script>
                Swal.fire({
                    title: "Estado Actualizado",
                    text: "¡Estado del usuario ' . $id . ' actualizado!",
                    icon: "success",
                    allowOutsideClick: false,
                    showCancelButton: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    confirmButtonText: "OK"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "usuarios.php";
                    }
                });
            </script>';
            }

        } catch (PDOExeption $e) {
            echo $e->getMessage();
        }
        }

    if ($action == '3' && isset($_GET['id'])) {
        $id = $_GET['id'];
    
        if ($id != 1) {
            try {
                $sql_delete = "DELETE FROM usuarios WHERE id='$id'";
                if ($conexion->query($sql_delete)) {
                    print '<script>
                    Swal.fire({
                        title: "Usuario Eliminado",
                        text: "Usuario ' . $id . ' Eliminado correctamente",
                        icon: "success",
                        allowOutsideClick: false,
                        showCancelButton: false,
                        allowEscapeKey: false,
                        allowEnterKey: false,
                        confirmButtonText: "OK"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "usuarios.php";
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
                if ($e->getCode() == "23000" && strpos($e->getMessage(), "FOREIGN KEY") !== false) {
                    print "<script>
                Swal.fire(
                    'Error',
                    'Usuario encargado de una actividad, no se puede eliminar.',
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
       print" <script>
            setTimeout(() => {
                window.history.replaceState(null, null, window.location.pathname);
            }, 0);
            </script>";
    }
    
    

    if($action == '2' && isset($_GET['id'])){
        $id = $_GET['id'];
    
        $consulta_usuario = "SELECT * FROM `usuarios` WHERE id = '$id'";
    
        foreach ($conexion->query($consulta_usuario) as $row) {
            $id = $row['id'];
            $nombre = $row['nombre'];
            $apellido = $row['apellido'];
            $email = $row['email'];
            $telefono = $row['telefono']; // Nuevo campo 'telefono'
            $documento = $row['documento'];
            $tipo_usuario = $row['tipo_usuario'];
            $usuario = $row['usuario']; // Nuevo campo 'usuario'
        ?>
    
        <script>
        Swal.fire({
            title: 'Actualizar Usuario',
            html: `
                <form action="#" method="POST" class="text-left m-3">
                    <div>
                        <div class="form-group">
                            <label for="">Nombres</label>
                            <input type="text" name="nombre" value="<?php echo $nombre ?>" class="form-control" placeholder="Escriba aquí el nombre del usuario" required>
                        </div>
                        <div class="form-group">
                            <label for="">Apellido</label>
                            <input type="text" name="apellido" value="<?php echo $apellido ?>" class="form-control" placeholder="Escriba aquí el apellido del usuario" required>
                        </div>
                        <div class="form-group">
                            <label for="">Correo</label>
                            <input type="email" name="email" value="<?php echo $email ?>" class="form-control" placeholder="Escriba aquí el correo del usuario" required>
                        </div>
                        <div class="form-group">
                            <label for="">Teléfono</label>
                            <input type="text" name="telefono" value="<?php echo $telefono ?>" class="form-control" placeholder="Escriba aquí el teléfono del usuario" required>
                        </div>
                        <div class="form-group">
                            <label for="">Número de documento</label>
                            <input type="number" name="documento" value="<?php echo $documento ?>" class="form-control" placeholder="Escriba aquí el documento del usuario" required>
                        </div>
                        <div class="form-group">
                            <label for="">Contraseña</label>
                            <input type="text" name="password" id="inputPassword" class="form-control" placeholder="Dejar en blanco para no cambiar la contraseña">
                        </div>
                        <div class="form-group">
                            <label for="tipo_usuario">Tipo de Usuario</label>
                            <select name="tipo_usuario" id="tipo_usuario" class="form-control">
                                <?php
                                // Obtén la lista de roles y selecciona el rol actual del usuario
                                $query = "SELECT * FROM roles";
                                $stmt = $conexion->prepare($query);
                                $stmt->execute();
                                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
                                foreach ($result as $rol) {
                                    $selected = ($rol['id'] == $tipo_usuario) ? 'selected' : '';
                                    echo "<option value='{$rol['id']}' $selected>{$rol['rol']}</option>";
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
    

    if($action == '1'){
        if ($_SESSION['tipo_usuario']==7) {
           // Realiza la consulta a la base de datos para obtener los roles
        $query = "SELECT * FROM roles";
        $stmt = $conexion->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Genera las opciones para el campo de selección
        $options = '';
        foreach ($result as $row) {
            $options .= '<option value="' . $row['id'] . '">' . $row['rol'] . '</option>';
        }
        ?>

        <script>
            Swal.fire({
                title: 'Registrar Usuario',
                html: `
                    <form action="#" method="POST" class="text-left m-3">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Escriba aquí el nombre del usuario" required>
                        </div>
                        <div class="form-group">
                            <label for="apellido">Apellido</label>
                            <input type="text" name="apellido" id="apellido" class="form-control" placeholder="Escriba aquí el apellido del usuario" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Correo</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Escriba aquí el correo del usuario" required>
                        </div>
                        <div class="form-group">
                            <label for="telefono">Teléfono</label>
                            <input type="text" name="telefono" id="telefono" class="form-control" placeholder="Escriba aquí el teléfono del usuario" required>
                        </div>
                        <div class="form-group">
                            <label for="documento">Número de documento</label>
                            <input type="number" name="documento" id="documento" class="form-control" placeholder="Escriba aquí el documento del usuario" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Contraseña (puede ser el mismo documento)</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Escriba aquí la contraseña del usuario" required>
                        </div>
                        <div class="form-group">
                            <label for="password2">Repita la contraseña</label>
                            <input type="password" name="password2" id="password2" class="form-control" placeholder="Repetir contraseña" required>
                        </div>
                        <div class="form-group">
                            <label for="tipo_usuario">Tipo de Usuario</label>
                            <select name="tipo_usuario" id="tipo_usuario" class="form-control">
                                <?php echo $options; ?>
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
    if ($_SESSION['tipo_usuario']==1) {
        // Realiza la consulta a la base de datos para obtener los roles
        $query = "SELECT * FROM `roles` WHERE rol <> 'Administrador' AND rol <> 'SuperUsuario'";
        $stmt = $conexion->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Genera las opciones para el campo de selección
        $options = '';
        foreach ($result as $row) {
            $options .= '<option value="' . $row['id'] . '">' . $row['rol'] . '</option>';
        }
        ?>

        <script>
            Swal.fire({
                title: 'Registrar Usuario',
                html: `
                    <form action="#" method="POST" class="text-left m-3">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Escriba aquí el nombre del usuario" required>
                        </div>
                        <div class="form-group">
                            <label for="apellido">Apellido</label>
                            <input type="text" name="apellido" id="apellido" class="form-control" placeholder="Escriba aquí el apellido del usuario" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Correo</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Escriba aquí el correo del usuario" required>
                        </div>
                        <div class="form-group">
                            <label for="telefono">Teléfono</label>
                            <input type="text" name="telefono" id="telefono" class="form-control" placeholder="Escriba aquí el teléfono del usuario" required>
                        </div>
                        <div class="form-group">
                            <label for="documento">Número de documento</label>
                            <input type="number" name="documento" id="documento" class="form-control" placeholder="Escriba aquí el documento del usuario" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Contraseña (puede ser el mismo documento)</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Escriba aquí la contraseña del usuario" required>
                        </div>
                        <div class="form-group">
                            <label for="password2">Repita la contraseña</label>
                            <input type="password" name="password2" id="password2" class="form-control" placeholder="Repetir contraseña" required>
                        </div>
                        <div class="form-group">
                            <label for="tipo_usuario">Tipo de Usuario</label>
                            <select name="tipo_usuario" id="tipo_usuario" class="form-control">
                                <?php echo $options; ?>
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
}

        
/* Enviar formulario de registro */

if (isset($_POST['btnRegistrar'])) {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono']; 
    $documento = $_POST['documento'];
    $p1 = $_POST['password'];
    $p2 = $_POST['password2'];
    $tipo_usuario = $_POST['tipo_usuario'];
    $usuario = $email; // Nuevo campo 'usuario', se asigna el valor de 'email'

    if ($p1 == $p2) {
        $hashed_password = password_hash($p1, PASSWORD_DEFAULT);

        $insert_usuario = "INSERT INTO `usuarios`(`nombre`, `apellido`, `email`, `telefono`, `documento`, `pass`, `tipo_usuario`, `usuario`, `fecha_sys`) VALUES (:nombre, :apellido, :email, :telefono, :documento, :pass, :tipo_usuario, :usuario, now())";

        try {
            $stmt = $conexion->prepare($insert_usuario);

            $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            $stmt->bindParam(':apellido', $apellido, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':telefono', $telefono, PDO::PARAM_STR); 
            $stmt->bindParam(':documento', $documento, PDO::PARAM_STR);
            $stmt->bindParam(':pass', $hashed_password, PDO::PARAM_STR);
            $stmt->bindParam(':tipo_usuario', $tipo_usuario, PDO::PARAM_INT);
            $stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR); 

            if ($stmt->execute()) {
                print "<script>
                    Swal.fire(
                    'Registrado!',
                    'Registrado Correctamente',
                    'success'
                    )
                </script>";
            }
        } catch (PDOException $e) {
            if ($e->getCode() == 23000 && strpos($e->getMessage(), "Duplicate entry") !== false) {
                print "<script>
                Swal.fire(
                    'Error!',
                    'Este usuario ya esta registrado en nuestro sistema. Verifica el correo o numero de documento',
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
    } else {
        print "<script>
            Swal.fire(
            'Error!',
            'Las contraseñas no coinciden.',
            'error'
            )
        </script>";
    }

    echo "<script>
        setTimeout(function() {
            window.location.href = 'usuarios.php';
        }, 3000);
    </script>";
}


/* Actualizar formulario de editar */

if(isset($_POST['btnActualizar'])){

    try {

        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $email = $_POST['email'];
        $telefono = $_POST['telefono'];
        $documento = $_POST['documento'];
        $tipo_usuario = $_POST['tipo_usuario'];
        $usuario = $email;

        // Verifica si el campo de contraseña está vacío o no
        if (!empty($_POST['password'])) {
            $password = $_POST['password'];
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Actualiza la contraseña solo si se proporciona una nueva contraseña
            $update_usuario = "UPDATE `usuarios` SET nombre = :nombre, apellido = :apellido, email = :email, telefono = :telefono, documento = :documento, pass = :pass, tipo_usuario = :tipo_usuario, usuario = :usuario WHERE id = :id";
        } else {
            // No se proporciona una nueva contraseña, solo actualiza los demás campos
            $update_usuario = "UPDATE `usuarios` SET nombre = :nombre, apellido = :apellido, email = :email, telefono = :telefono, documento = :documento, tipo_usuario = :tipo_usuario, usuario = :usuario WHERE id = :id";
        }

        $stmt = $conexion->prepare($update_usuario);
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':apellido', $apellido, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':telefono', $telefono, PDO::PARAM_STR);
        $stmt->bindParam(':documento', $documento, PDO::PARAM_STR);
        
        // Si se proporciona una nueva contraseña, también actualiza la contraseña
        if (!empty($_POST['password'])) {
            $stmt->bindParam(':pass', $hashed_password, PDO::PARAM_STR);
        }

        $stmt->bindParam(':tipo_usuario', $tipo_usuario, PDO::PARAM_INT);
        $stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if($stmt->execute()){
            print "<script>
                Swal.fire(
                'Actualizado!',
                'Actualizado Correctamente.',
                'success'
                )
            </script>";
        }

    } catch (PDOException $e) {

        print "<script>
            
                Swal.fire(
                'Error!',
                'Ocurrió un error.',
                'error'
                )
            
                </script>";
    }

    echo "<script>
        setTimeout(function() {
            window.location.href = 'usuarios.php';
        }, 3000);
    </script>";
}

function obtenerRolUsuario($id) {
    global $conexion;

    // Realiza una consulta SQL para obtener el rol del usuario con el ID proporcionado
    $consulta = "SELECT tipo_usuario FROM usuarios WHERE id = :id";
    $stmt = $conexion->prepare($consulta);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        return $result['tipo_usuario'];
    } else {
        return null;
    }
}
// Función para obtener los detalles de un usuario por su ID
function obtenerDetallesUsuario($id) {
    global $conexion;

    // Realiza una consulta SQL para obtener los detalles del usuario con el ID proporcionado
    $consulta = "SELECT * FROM usuarios WHERE id = :id";
    $stmt = $conexion->prepare($consulta);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result;
}

?>
