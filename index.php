<?php

require "conexion.php";

session_start();

if(isset($_SESSION['id'])){
  header("Location: principal.php");
}

?>

<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="public/css/login.css">
  <!-- CSS de Bootstrap 5 -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.7.2/dist/css/bootstrap.min.css">

<!-- JavaScript de Bootstrap 5 (Requiere jQuery) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.7.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- CSS de Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">



  <title>PPIS 2.0</title>

</head>

<body>
<div class="container-fluid ps-md-0">
<div class="row g-0">
  <div class="d-none d-md-flex col-md-4 col-lg-6 bg-image"></div>
  <div class="col-md-8 col-lg-6">
    <div class="login d-flex align-items-center py-5">
      <div class="container">
      <div class="col-md-9 col-lg-8 mx-auto mb-5 pb-5 ">
                  <i class="fas fa-cubes fa-2x me-3" style="color: #ff6219;"></i>
                  <span class="h1 fw-bold mb-0">PPIS 2.0 - ITFIP</span>
                </div>
        <div class="row">
          <div class="col-md-9 col-lg-8 mx-auto">
            <h3 class="login-heading mb-4">Inicio de Sesión</h3>

<!-- FORMULARIO -->
<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<div class="form-floating mb-3">
  <input type="text" class="form-control" name="usuario" id="usuario" placeholder="Usuario" required>
  <label for="usuario">Usuario</label>
</div>
<div class="form-floating mb-3 position-relative">
<input type="password" class="form-control" name="pass" id="pass" placeholder="Contraseña" required>
<label for="pass">Contraseña</label>
<span class="position-absolute top-50 translate-middle-y end-0 me-3">
  <i id="togglePassword" class="bi bi-eye-slash"></i>
</span>
</div>
<div class="d-grid">
  <button class="btn btn-primary btn-lg text-uppercase fw-bold mb-2" type="submit">Entrar</button>
</div>
</form>
<script>
const togglePassword = document.querySelector('#togglePassword');
const password = document.querySelector('#pass');

togglePassword.addEventListener('click', function () {
const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
password.setAttribute('type', type);
this.querySelector('i').classList.toggle('bi-eye');
this.querySelector('i').classList.toggle('bi-eye-slash');
});

</script>
<?php
if ($_POST) {
  $usuario = $_POST['usuario'];
  $pass = $_POST['pass'];

  // Incluir el archivo de conexión
  require_once('conexion.php');

  try {
      // Realizar la conexión a la base de datos
      $conn = Conexion::Conectar();

      // Preparar la consulta SQL para obtener el usuario
      $stmt = $conn->prepare("SELECT id, pass, nombre, apellido, tipo_usuario FROM usuarios WHERE usuario = :usuario");
      $stmt->bindParam(':usuario', $usuario);
      $stmt->execute();

      $num = $stmt->rowCount();

      if ($num > 0) {
          $row = $stmt->fetch(PDO::FETCH_ASSOC);
          $password_bd = $row['pass'];

          // Utilizar password_verify para comparar las contraseñas
          if (password_verify($pass, $password_bd)) {
              $_SESSION['id'] = $row['id'];
              $_SESSION['nombre'] = $row['nombre'];
              $_SESSION['apellido'] = $row['apellido'];
              $_SESSION['tipo_usuario'] = $row['tipo_usuario'];

              header("Location: principal.php");
          } else {
              echo "<div style='color:red'>Contraseña inválida</div>";
          }
      } else {
          echo "<div style='color:red'>Usuario inválido</div>";
      }
  } catch(PDOException $e) {
      echo "Error al obtener el usuario: " . $e->getMessage();
  }
}
?>


                
              </div>

            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>

  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  
</body>
</html>
