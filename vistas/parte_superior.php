<?php
	
	session_start();
	
	if(!isset($_SESSION['id'])){
		header("Location: index.php");
	}
	
	$nombre = $_SESSION['nombre'];
    $apellido = $_SESSION['apellido'];
	$tipo_usuario = $_SESSION['tipo_usuario'];
	
	
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>PPIS 2.0</title>
        <link href="css/styles.css" rel="stylesheet" />
        <link href="main.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />

        <!-- FontAwesom CSS -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">        
       
		<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
	</head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" href="principal.php">PPIS 2.0</a><button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
            <!-- Navbar-->
            <ul class="navbar-nav ml-auto mr-0 mr-md-3 my-2 my-md-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $nombre . " ".  $apellido; ?><i class="fas fa-user fa-fw"></i></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="#">Configuración</a>
                        <div class="dropdown-divider"></div>    
                        <a class="dropdown-item" href="servidor/logout.php">Salir</a>
					</div>
				</li>
			</ul>
		</nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <a class="nav-link" href="principal.php"
							><div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard</a>
							
								<!-- VISTA PRIVILEGIADA -->
							<?php if($tipo_usuario == 1) { ?>
										
							<?php } ?>
							
							<div class="sb-sidenav-menu-heading">Administracion de usuarios</div>
							<a class="nav-link" href="usuarios.php">
							<div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>Usuarios</a>
                            
                            
                            <div class="sb-sidenav-menu-heading">Procesos</div>
                            <!-- VISTA ADMINISTRADOR -->
							<?php if($tipo_usuario == 1) { ?>
                            <a class="nav-link" href="configuracion.php"
							><div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>Configuración</a>
                            <?php } ?>
                            <!-- VISTA DOCENTE -->
                            <?php if($tipo_usuario == 2) { ?>
                                <a class="nav-link" href="#"
							><div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>Mis Tareas</a>
                            <?php } ?>
                            <a class="nav-link" href="#"
							><div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>Semaforo</a>
							
                            <div class="sb-sidenav-menu-heading">Administracion de Procesos</div>
                            <!-- VISTA ADMINISTRADOR -->
							<?php if($tipo_usuario == 1) { ?>
                            <a class="nav-link" href="#"
							><div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>CRUD de Procesos</a>
                            <?php } ?>
                            
							
					</div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logeado como:</div>
                        <?php
                        if ($_SESSION["tipo_usuario"]==1) {
                            echo "<b>[Administrador]</b><br> ";
                        }else {
                            echo "<b>[Docente]</b><br> ";
                        }
                        
                        echo $_SESSION["nombre"] . " ".  $_SESSION["apellido"];
                        ?>
                         
					</div>
                    <div class="sb-sidenav-footer">
                        <div class=" align-items-center justify-content-between small">
                            <div class="text-muted">Copyright 2023 &copy; PPIS 2.0 - ITFIP</div>
                            <div>
                                <a href="#"> Politicas de Privacidad</a>
                                &middot;
                                <a href="#">Terminos &amp; Condiciones</a>
							</div>
						</div>
					</div>
				</nav>
			</div>