<?php require_once "vistas/parte_superior.php"?>


    
    <main>
    <div id="layoutSidenav_content">
        <div class="container-fluid">
            <h1 class="mt-4">Usuarios</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="principal.php">Dashboard</a></li>
                <li class="breadcrumb-item active">Usuarios</li>
            </ol>
            <div class="card mb-4">
                <div class="card-body">En este apartado, se realiza la gestión de usuarios de PPIS 2.0. Es importante tener en cuenta la sensibilidad de la modificación de los datos en este proceso. Asegúrese de tomar las medidas adecuadas para proteger la información y garantizar la integridad de los datos de los usuarios.
                <br><br>Aquí se muestra una tabla con los usuarios registrados en el sistema. Puede realizar modificaciones en los datos de los usuarios, como nombre, apellido, correo electrónico, rol, entre otros. Tenga en cuenta que cualquier cambio realizado afectará directamente la información de los usuarios y puede tener un impacto en su acceso y permisos en el sistema.<br><br>
                Utilice los botones de edición y eliminación con precaución. Antes de realizar cualquier modificación o eliminación de un usuario, asegúrese de verificar y confirmar la acción para evitar cualquier consecuencia no deseada.<br><br>
                Recuerde seguir las políticas de seguridad establecidas y respetar la privacidad de los usuarios al interactuar con sus datos.
                Para obtener más información sobre el funcionamiento de la gestión de usuarios en PPIS 2.0, consulte la documentación oficial del sistema.
                Ante cualquier duda o inconveniente, comuníquese con el equipo de soporte técnico para recibir asistencia especializada.</div>
            </div>
            <div id="appMoviles">
                <div class="card mb-4">
                    
                    <div class="card-header"><i class="fas fa-table mr-1"></i>Gestión de Usuarios</div>
                    
                    <div class="card-body">
                                    
                    <div class="row">
                    <!-- BARRA DE BUSQUEDA  -->
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="input-group">
                                <input type="text" v-model="term" class="form-control" placeholder="Buscar usuario">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                    <i class="fas fa-search"></i>
                                    </span>
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="col text-right">        
                            <button @click="btnAlta" class="btn btn-primary" title="Nuevo"><i class="fas fa-plus-circle fa-2x"></i></button>
                        </div>
                    </div>                
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr class="bg-primary text-light">
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Apellido</th>
                                        <th>Email</th>
                                        <th>Documento</th>
                                        <th>Telefono</th>
                                        <th>Rol</th>
                                        <th>Usuario</th>
                                        <th>Password</th>
                                        <th>Creación</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(usuarios, indice) of usuarios">
                                        <td>{{usuarios.id}}</td>
                                        <td>{{usuarios.nombre}}</td>
                                        <td>{{usuarios.apellido}}</td>
                                        <td>{{usuarios.email}}</td>
                                        <td>{{usuarios.documento}}</td>
                                        <td>{{usuarios.telefono}}</td>
                                        <td>{{usuarios.tipo_usuario}}</td>
                                        <td>{{usuarios.usuario}}</td>
                                        <td>{{usuarios.pass}}</td>
                                        <td>{{usuarios.fecha_sys}}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button class="btn btn-secondary" title="Editar" @click="btnEditar(usuarios.id, usuarios.nombre, usuarios.apellido, usuarios.email, usuarios.tipo_usuario)">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </button>
                                                <button class="btn btn-danger" title="Eliminar" @click="btnBorrar(usuarios.id)">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </main>


    <script src="jquery/jquery-3.3.1.min.js"></script>
    <script src="popper/popper.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>         
    <!--Vue.JS -->    
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>                 
    <!--Axios -->      
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.15.2/axios.js"></script>    
    <!--Sweet Alert 2 -->        
    <script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>      
    <!--Código custom -->
    <script src="js/scripts.js"></script>          
    <script src="main.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
   
    
                 
</html>


                