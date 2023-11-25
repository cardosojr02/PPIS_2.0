<?php
// Incluir el archivo de conexión a la base de datos
require 'conexion.php';

// Obtener el saldo actual desde la base de datos
$query = "SELECT saldo FROM saldo_actual ORDER BY fecha_actualizacion DESC LIMIT 1";
$result = mysqli_query($conn, $query);

if ($result) {
  $row = mysqli_fetch_assoc($result);
  $saldo_actual = $row['saldo'];
} else {
  // Manejo de errores en caso de fallo en la consulta
  $error = mysqli_error($conn);
  echo "Error en la consulta: " . $error;
}

// Cerrar la conexión a la base de datos
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Gestión Financiera</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <style>
    /* Estilos adicionales si los necesitas */
    body {
      font-family: "Montserrat", sans-serif; /* Cambio de tipo de fuente a Montserrat */
      margin: 0;
      padding: 0;
      background-color: #AEFF7C;
    }

    .form-section {
      padding-top: 50px;
    }

    .sidebar {
      position: fixed;
      top: 0;
      bottom: 0;
      left: 0;
      z-index: 100;
      padding: 20px;
      background-color: #728C62; /* Cambia el color a tu gris corporativo */
      overflow-x: hidden;
      width: 200px;
      transition: all 0.3s;
    }

    .content {
      margin-left: 200px;
      padding: 20px;
      transition: all 0.3s;
      background-image: "img/fondocerdo.png";
    }

    .card {
      background-color: #f8f9fa; /* Color de fondo de la tarjeta */
      border: none; /* Quita el borde de la tarjeta */
      margin-bottom: 20px; /* Espaciado inferior entre tarjetas */
    }

    .card-header {
      background-color: #e9ecef; /* Color de fondo del encabezado de la tarjeta */
      border-bottom: none; /* Quita el borde inferior del encabezado de la tarjeta */
    }

    .card-body {
      padding: 15px; /* Espaciado interno del cuerpo de la tarjeta */
    }

    .nav-link i {
      margin-right: 5px;
    }

    .saldo-actual {
      background-color: #f8f9fa; /* Color de fondo del rectángulo del saldo actual */
      border: 1px solid #ced4da; /* Borde del rectángulo del saldo actual */
      border-radius: 5px; /* Bordes redondeados del rectángulo del saldo actual */
      padding: 10px; /* Espaciado interno del rectángulo del saldo actual */
      text-align: right; /* Alineación a la derecha del saldo actual */
      font-size: 18px; /* Tamaño de fuente del saldo actual */
      font-weight: bold; /* Negrita del saldo actual */
      margin-bottom: 20px; /* Espaciado inferior del saldo actual */
    }
    .footer {
      position: fixed;
      left: 35px;
      bottom: 0;
      width: 100%;
      background-color: #f8f9fa;
      color: #6c757d;
      font-size: 12px;
      padding: 10px 0;
      
    }

    .footer p, .footer ul {
      margin-bottom: 0;
    }

    .footer ul li {
      display: inline;
      margin-right: 10px;
    }

    .footer a {
      color: #6c757d;
    }

  </style>
</head>
<body>
  <div class="container-fluid">
  
  <div class="row">
  <div class="col-2 sidebar" id="sidebar">
    <h4 class="mb-4 text-center" style="font-size: 24px; color: white;">OINK OINK</h4>
    <ul class="nav flex-column">
      <li class="nav-item">
        <a class="nav-link" href="#ingresos" style="color: white;">
          <i class="fas fa-money-bill"></i>
          <span class="ml-2">Ingresos</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#gastos" style="color: white;">
          <i class="fas fa-money-bill-alt"></i>
          <span class="ml-2">Gastos</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#ahorros" style="color: white;">
          <i class="fas fa-piggy-bank"></i>
          <span class="ml-2">Ahorros</span>
        </a>
      </li>
    </ul>
  </div>
</div>


      <div class="col-10 content" id="content">
        <h1>Gestión Financiera</h1>
        <div id="saldo-container">
          <div class="saldo-actual">
            Saldo actual: <span id="saldo"><?php echo $saldo_actual; ?></span>
          </div>
        </div>
        <!-- Agregar aquí el código PHP para mostrar las transacciones (Ingresos y Gastos) -->
        <?php
          // Incluir el archivo de conexión a la base de datos
          require 'conexion.php';

          // Obtener los ingresos desde la base de datos
          $queryIngresos = "SELECT * FROM ingresos ORDER BY fecha DESC";
          $resultIngresos = mysqli_query($conn, $queryIngresos);

          // Obtener los gastos desde la base de datos
          $queryGastos = "SELECT * FROM gastos ORDER BY fecha DESC";
          $resultGastos = mysqli_query($conn, $queryGastos);

          // Mostrar las transacciones (Ingresos y Gastos) en una tabla
          echo "<h2>Transacciones</h2>";
          echo "<table border='1'>";
          echo "<tr>";
          echo "<th>ID</th>";
          echo "<th>Tipo</th>";
          echo "<th>Monto</th>";
          echo "<th>Fecha</th>";
          echo "<th>Descripción</th>";
          echo "</tr>";

          while ($row = mysqli_fetch_assoc($resultIngresos)) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>Ingreso</td>";
            echo "<td>" . $row['monto'] . "</td>";
            echo "<td>" . $row['fecha'] . "</td>";
            echo "<td>" . $row['descripcion'] . "</td>";
            echo "</tr>";
          }

          while ($row = mysqli_fetch_assoc($resultGastos)) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>Gasto</td>";
            echo "<td>" . $row['monto'] . "</td>";
            echo "<td>" . $row['fecha'] . "</td>";
            echo "<td>" . $row['descripcion'] . "</td>";
            echo "</tr>";
          }

          echo "</table>";

          // Cerrar la conexión a la base de datos
          mysqli_close($conn);
        ?>

        <section id="ingresos" class="form-section">
          <div class="card">
            <div class="card-header">
              <h5 class="mb-0">Ingresos</h5>
            </div>
            <div class="card-body">
              <!-- Contenido de la sección de ingresos -->
              <section id="ingresos"class="form-section">
                <h2>
                  <i class="fas fa-money-bill"></i>
                  Ingresos
                </h2>
                <form id="formIngresos">
                  <div class="form-group">
                    <label for="montoIngreso">Monto:</label>
                    <input type="number" class="form-control" id="montoIngreso" name="montoIngreso" step="0.01" required>
                  </div>
                  <div class="form-group">
                    <label for="fechaIngreso">Fecha:</label>
                    <input type="date" class="form-control" id="fechaIngreso" name="fechaIngreso" required>
                  </div>
                  <div class="form-group">
                    <label for="descripcionIngreso">Descripción:</label>
                    <input type="text" class="form-control" id="descripcionIngreso" name="descripcionIngreso" required>
                  </div>
                  <button type="submit" class="btn btn-primary">Guardar Ingreso</button>
                </form>
              </section>
              <!-- Aquí puedes añadir tus formularios o cualquier otro contenido -->
            </div>
          </div>
        </section>
        <section id="gastos" class="form-section">
          <div class="card">
            <div class="card-header">
              <h5 class="mb-0">Gastos</h5>
            </div>
            <div class="card-body">
              <!-- Contenido de la sección de gastos -->
              <section id="gastos"class="form-section">
                <h2>
                  <i class="fas fa-money-bill-alt"></i>
                  Gastos
                </h2>
                <form id="formGastos" action="guardar_gasto.php" method="POST">
                  <div class="form-group">
                    <label for="montoGasto">Monto:</label>
                    <input type="number" class="form-control" id="montoGasto" name="montoGasto" step="0.01" required>
                  </div>
                  <div class="form-group">
                    <label for="fechaGasto">Fecha:</label>
                    <input type="date" class="form-control" id="fechaGasto" name="fechaGasto" required>
                  </div>
                  <div class="form-group">
                    <label for="descripcionGasto">Descripción:</label>
                    <input type="text" class="form-control" id="descripcionGasto" name="descripcionGasto" required>
                  </div>
                  <button type="submit" class="btn btn-primary">Guardar Gasto</button>
                </form>
              </section>
              <!-- Aquí puedes añadir tus formularios o cualquier otro contenido -->
            </div>
          </div>
        </section>
        <section id="ahorros" class="form-section">
          <div class="card">
            <div class="card-header">
              <h5 class="mb-0">Ahorros</h5>
            </div>
            <div class="card-body">
              <!-- Contenido de la sección de ahorros -->
              <section id="ahorros"class="form-section">
                <h2>
                  <i class="fas fa-piggy-bank"></i>
                  Ahorros
                </h2>
                <form id="formAhorros">
                  <div class="form-group">
                    <label for="montoAhorro">Monto:</label>
                    <input type="number" class="form-control" id="montoAhorro" name="montoAhorro" step="0.01" required>
                  </div>
                  <div class="form-group">
                    <label for="fechaAhorro">Fecha:</label>
                    <input type="date" class="form-control" id="fechaAhorro" name="fechaAhorro" required>
                  </div>
                  <div class="form-group">
                    <label for="descripcionAhorro">Descripción:</label>
                    <input type="text" class="form-control" id="descripcionAhorro" name="descripcionAhorro" required>
                  </div>
                  <button type="submit" class="btn btn-primary">Guardar Ahorro</button>
                </form>
              </section>
              <!-- Aquí puedes añadir tus formularios o cualquier otro contenido -->
              <footer class="footer">
      <div class="container text-center">
        <div class="row">
          <div class="col-md-6">
            <p>&copy; 2023 Oink-Oink. Todos los derechos reservados.</p>
          </div>
          <div class="col-md-6">
            <p class="text-md-right">Diseñado por Junior Cardoso</p>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <ul class="list-inline">
              <li class="list-inline-item"><a href="#">Política de Privacidad</a></li>
              <li class="list-inline-item"><a href="#">Términos de Uso</a></li>
            </ul>
          </div>
          <div class="col-md-6">
            <p class="text-md-right">Todos los derechos reservados. &copy; 2023</p>
          </div>
        </div>
      </div>
    </footer>
            </div>
          </div>
        </section>
      </div>

    </div>   
  </div>
  
</body>
</html>


  <script>
    $(document).ready(function() {
      // Código JavaScript si lo necesitas
      function confirmarRestablecer() {
    return confirm("¿Estás seguro de que deseas eliminar todas las transacciones? Esta acción no se puede deshacer.");
  
  }
      // Manejar el evento de envío del formulario de Ingresos
      $('#formIngresos').submit(function(event) {
        event.preventDefault(); // Evitar el envío del formulario por defecto

        // Obtener los valores del formulario de ingresos
        var monto = $('#montoIngreso').val();
        var fecha = $('#fechaIngreso').val();
        var descripcion = $('#descripcionIngreso').val();

        // Crear el objeto de datos a enviar al servidor
        var data = {
          monto: monto,
          fecha: fecha,
          descripcion: descripcion
        };

        // Realizar la petición AJAX para guardar los datos de ingresos
        $.ajax({
          url: 'guardar_ingreso.php', // Ruta del archivo PHP que procesará la petición
          type: 'POST',
          data: data,
          success: function(response) {
            // Procesar la respuesta del servidor si es necesario
            console.log(response);
            // Restablecer los valores del formulario de ingresos
            $('#montoIngreso').val('');
            $('#fechaIngreso').val('');
            $('#descripcionIngreso').val('');
          },
          error: function(xhr, status, error) {
            // Manejar los errores de la petición AJAX si es necesario
            console.error(error);
          }
        });
      });

      // Manejar el evento de envío del formulario de Gastos
      $('#formGastos').submit(function(event) {
        event.preventDefault(); // Evitar el envío del formulario por defecto

        // Obtener los valores del formulario de gastos
        var monto = $('#montoGasto').val();
        var fecha = $('#fechaGasto').val();
        var descripcion = $('#descripcionGasto').val();

        // Crear el objeto de datos a enviar al servidor
        var data = {
          monto: monto,
          fecha: fecha,
          descripcion: descripcion
        };

        // Realizar la petición AJAX para guardar los datos de gastos
        $.ajax({
          url: 'guardar_gasto.php', // Ruta del archivo PHP que procesará la petición
          type: 'POST',
          data: data,
          success: function(response) {
            // Procesar la respuesta del servidor si es necesario
            console.log(response);
            // Restablecer los valores del formulario de gastos
            $('#montoGasto').val('');
            $('#fechaGasto').val('');
            $('#descripcionGasto').val('');
          },
          error: function(xhr, status, error) {
            // Manejar los errores de la petición AJAX si es necesario
            console.error(error);
          }
        });
      });

      // Manejar el evento de envío del formulario de Ahorros
      $('#formAhorros').submit(function(event) {
        event.preventDefault(); // Evitar el envío del formulario por defecto

        // Obtener los valores del formulario de ahorros
        var monto = $('#montoAhorro').val();
        var fecha = $('#fechaAhorro').val();
        var descripcion = $('#descripcionAhorro').val();

        // Crear el objeto de datos a enviar al servidor
        var data = {
          monto: monto,
          fecha: fecha,
          descripcion: descripcion
        };

        // Realizar la petición AJAX para guardar los datos de ahorros
        $.ajax({
          url: 'guardar_ahorro.php', // Ruta del archivo PHP que procesará la petición
          type: 'POST',
          data: data,
          success: function(response) {
            // Procesar la respuesta del servidor si es necesario
            console.log(response);
            // Restablecer los valores del formulario de ahorros
            $('#montoAhorro').val('');
            $('#fechaAhorro').val('');
            $('#descripcionAhorro').val('');
          },
          error: function(xhr, status, error) {
            // Manejar los errores de la petición AJAX si es necesario
            console.error(error);
          }
        });
      });
      // Función para obtener el saldo actualizado
  // Función para actualizar el saldo actual mediante AJAX
  function actualizarSaldo() {
      $.ajax({
        url: 'obtener_saldo_actual.php', // Ruta del archivo PHP para obtener el saldo actualizado
        type: 'GET',
        success: function(response) {
          // Actualizar el valor del saldo en el contenedor
          $('#saldo').text(response);
        },
        error: function(xhr, status, error) {
          console.error(error);
        }
      });
    }

    // Actualizar el saldo cada 5 segundos
    setInterval(actualizarSaldo, 5000);
  });
      

    

  </script>
</body>
</html>
