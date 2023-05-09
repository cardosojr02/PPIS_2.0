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

    <title>PPIS 2.0</title>

  </head>

  <body>
  <div class="container-fluid ps-md-0">
  <div class="row g-0">
    <div class="d-none d-md-flex col-md-4 col-lg-6 bg-image"></div>
    <div class="col-md-8 col-lg-6">
      <div class="login d-flex align-items-center py-5">
        <div class="container">
          <div class="row">
            <div class="col-md-9 col-lg-8 mx-auto">
              <h3 class="login-heading mb-4">Inicio de Sesión</h3>

              <!-- FORMULARIO -->
              <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <div class="form-floating mb-3">
                  <input type="text" class="form-control" name="usuario" id="usuario" placeholder="Usuario" Required>
                  <label for="usuario">Usuario</label>
                </div>
                <div class="form-floating mb-3">
                  <input type="pass" class="form-control" name="pass" id="pass" placeholder="Password" Required>
                  <label for="pass">Password</label>
                </div>
                <div class="d-grid">
                  <button class="btn btn-lg btn-primary btn-login text-uppercase fw-bold mb-2" type="submit">Entrar</button>

                  <?php
if($_POST){
		
		$usuario = $_POST['usuario'];
		$pass = $_POST['pass'];
		
		$sql = "SELECT id, pass, nombre, apellido, tipo_usuario FROM usuarios WHERE usuario='$usuario'";
		//echo $sql;
		$resultado = $mysqli->query($sql);
		$num = $resultado->num_rows;
		
		if($num>0){
			$row = $resultado->fetch_assoc();
			$password_bd = $row['pass'];
			
			$pass_c = sha1($pass);
			
			if($password_bd == $pass_c){
				
				$_SESSION['id'] = $row['id'];
				$_SESSION['nombre'] = $row['nombre'];
        $_SESSION['apellido'] = $row['apellido'];
				$_SESSION['tipo_usuario'] = $row['tipo_usuario'];
				
				header("Location: principal.php");
				
			} else {
			
        echo "<div style='color:red'>Contraseña invalida </div>";
			
			}
			
			
			} else {
		echo "<div style='color:red'>Usuario invalido </div>";
		}
		
		
		
	}
?>
                  <div class="text-center">
                    <a class="small" href="registro.php">Registrate aqui!</a>
                  </div>
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