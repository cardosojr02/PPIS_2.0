<?php require_once "vistas/parte_superior.php"?>
<style>
  /* Estilos adicionales si los necesitas */
  /* Puedes personalizar estos estilos según tu preferencia */
  .feature-card {
    margin-bottom: 30px;
  }
  .feature-card .card {
    transition: transform 0.3s ease-in-out;
  }
  .feature-card .card:hover {
    transform: scale(1.05);
  }
  .feature-box {
    text-align: center;
  }
  .feature-box i {
    font-size: 4rem;
    margin-bottom: 20px;
  }
  /* Estilos del footer mejorado */
  .footer {
    background-color: #333;
    color: #fff;
    padding: 20px 0;
  }
  .footer-links ul {
    list-style: none;
    padding-left: 0;
  }
  .footer-links ul li {
    margin-bottom: 10px;
  }
  .footer-social {
    margin-top: 20px;
  }
  .footer-social a {
    display: inline-block;
    width: 40px;
    height: 40px;
    background-color: #fff;
    color: #333;
    text-align: center;
    line-height: 40px;
    margin-right: 10px;
    border-radius: 50%;
  }
</style>

<div id="layoutSidenav_content">
  <main>
    <div class="container-fluid">
      <h1 class="mt-4">¡Descubre las Funcionalidades!</h1>
      <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Inicio</li>
      </ol>

      <!-- Sección adicional de iconos y descripciones -->
      <div class="row">
        <div class="col-md-4">
          <div class="feature-box">
            <i class="fas fa-graduation-cap"></i>
            <h3>Autoevaluación</h3>
            <p>Gestiona procesos de autoevaluación de manera eficiente.</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="feature-box">
            <i class="fas fa-certificate"></i>
            <h3>Acreditación</h3>
            <p>Facilita el proceso de acreditación de instituciones educativas.</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="feature-box">
            <i class="fas fa-users"></i>
            <h3>Usuarios</h3>
            <p>Gestiona roles y permisos de usuarios de manera sencilla.</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="feature-box">
            <i class="fas fa-chart-bar"></i>
            <h3>Análisis de Datos</h3>
            <p>Genera informes y análisis detallados para la toma de decisiones estratégicas.</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="feature-box">
            <i class="fas fa-calendar-check"></i>
            <h3>Planificación</h3>
            <p>Planifica actividades y procesos académicos de manera eficaz.</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="feature-box">
            <i class="fas fa-comments"></i>
            <h3>Comunicación</h3>
            <p>Facilita la comunicación y colaboración entre los miembros del equipo.</p>
          </div>
        </div>
      </div>
      
      <!-- Sección de presentación con tarjetas -->
      <div class="row">
        <div class="col-md-4">
          <div class="feature-card">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Automatización de Procesos</h5>
                <p class="card-text">Simplifica y optimiza la gestión de procedimientos académicos.</p>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="feature-card">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Seguimiento Eficiente</h5>
                <p class="card-text">Realiza un seguimiento detallado de los procesos de autoevaluación.</p>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="feature-card">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Colaboración y Gestión de Datos</h5>
                <p class="card-text">Facilita la colaboración y gestión de datos entre usuarios.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
     

    <!-- Footer mejorado -->
    <footer class="footer">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          
          <p><b>PPIS 2.0</b> es un software desarrollado como proyecto de grado para gestionar los procesos y procedimientos en el ITFIP.</p>
          <p><b>Dirección:</b> Calle 18 Carrera 1ª Barrio/Arkabal Espinal, Tolima - Colombia</p>
          <p><b>Teléfono:</b> +57 3118336963</p>
          <p><b>Email:</b> info@ppis.com</p>
        </div>
        <div class="col-md-6">
          <div class="footer-links">
            <h5>Enlaces</h5>
            <ul>
              
              <li><a href="#">Acerca de</a></li>
              <li><a href="#">Contacto</a></li>
            </ul>
          </div>
          <div class="footer-social">
            <h5>Redes Sociales</h5>
            <a href="https://www.facebook.com/profile.php?id=61552019813290"><i class="fab fa-facebook-f"></i></a>
            <a href="https://instagram.com/ppis002"><i class="fab fa-instagram"></i></a>
          </div>
        </div>
      </div>
    </div>
  </footer>

  <!-- Scripts -->
  <script src="https://kit.fontawesome.com/your-fontawesome-kit.js" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
  <script src="js/scripts.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.15.2/axios.js"></script>
  <script src="https://cdn.userway.org/widget.js" data-account="H99znDKrMI"></script>
  
</div>
