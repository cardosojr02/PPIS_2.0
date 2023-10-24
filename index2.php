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
  <section class="vh-200" style="background: rgb(32,6,46); background: linear-gradient(90deg, rgba(32,6,46,1) 0%, rgba(64,234,252,1) 50%, rgba(24,1,36,1) 100%);">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col col-xl-10">
        <div class="card" style="border-radius: 1rem;">
          <div class="row g-0">
            <div class="col-md-6 col-lg-5 d-none d-md-block bg-image">
              
            </div>
            <div class="col-md-6 col-lg-7 d-flex align-items-center">
              <div class="card-body p-4 p-lg-5 text-black">

                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" >

                  <div class="d-flex align-items-center mb-3 pb-1">
                    <i class="fas fa-cubes fa-2x me-3" style="color: #ff6219;"></i>
                    <span class="h1 fw-bold mb-0">PPIS 2.0 - ITFIP</span>
                  </div>

                  <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 3px;">Inicio de sesión</h5>

                  <div class="form-outline mb-4">
                    <input type="text" name="usuario" id="usuario" class="form-control form-control-lg" required/>
                    <label class="form-label" for="usuario">Usuario</label>
                  </div>

                  <div class="form-outline mb-4">
                    <input type="password" name="password" id="password" class="form-control form-control-lg" require/>
                    <label class="form-label" for="password">Contraseña</label>
                  </div>
<?php
if($_POST){
		
		$usuario = $_POST['usuario'];
		$password = $_POST['password'];
		
		$sql = "SELECT id, password, nombre, apellido, tipo_usuario FROM usuarios WHERE usuario='$usuario'";
		//echo $sql;
		$resultado = $mysqli->query($sql);
		$num = $resultado->num_rows;
		
		if($num>0){
			$row = $resultado->fetch_assoc();
			$password_bd = $row['password'];
			
			$pass_c = sha1($password);
			
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

                  <div class="pt-1 mb-4">
                    <button class="btn btn-dark btn-lg btn-block" type="input">Login</button>
</div>



                  <a class="small text-muted" href="#!">Forgot password?</a></br>
                  <a href="#!" class="small text-muted">Terms of use.</a>
                  <a href="#!" class="small text-muted">Privacy policy</a>
                </form>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>



    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    
  </body>
</html>