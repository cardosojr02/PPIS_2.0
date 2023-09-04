<?php require_once "vistas/parte_superior.php"?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
            <h1 class="mt-4">Cambio de Contraseña</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Cambio de Contraseña</li>
            </ol>

            <!-- Agrega el formulario con estilos de Bootstrap -->
            <form id="cambiopassForm" class="mt-4">
                <div class="form-group">
                    <label for="pass">Nueva Contraseña:</label>
                    <input type="password" class="form-control" id="pass" required>
                </div>

                <div class="form-group">
                    <label for="confirmpass">Confirmar Contraseña:</label>
                    <input type="password" class="form-control" id="confirmpass" required>
                </div>

                <button type="submit" class="btn btn-primary">Cambiar Contraseña</button>
            </form>
        </div>
    </main>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.min.js"></script>
<script>
    // Agrega el evento submit al formulario
    $('#cambiopassForm').submit(function(event) {
        event.preventDefault();

        const pass = $('#pass').val();
        const confirmpass = $('#confirmpass').val();

        if (pass === '' || confirmpass === '') {
            Swal.fire('Error', 'Por favor, complete todos los campos', 'error');
            return;
        }

        if (pass !== confirmpass) {
            Swal.fire('Error', 'Las contraseñas no coinciden', 'error');
            return;
        }

        // Envía la solicitud de cambio de contraseña al servidor
        $.ajax({
            url: 'servidor/cambiar_password.php',
            type: 'POST',
            dataType: 'json',
            data: {
                pass: pass
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire('Contraseña cambiada', 'Su contraseña ha sido cambiada exitosamente', 'success')
                        .then(() => {
                            // Redirecciona al usuario a otra página después de cambiar la contraseña
                            window.location.href = 'principal.php';
                        });
                } else {
                    Swal.fire('Error', response.message, 'error');
                }
            },
            error: function() {
                Swal.fire('Error', 'Ocurrió un error al procesar la solicitud', 'error');
            }
        });
    });
</script>
<?php require_once "vistas/parte_inferior.php"?>    