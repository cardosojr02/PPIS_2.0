<?php require_once "vistas/parte_superior.php"?>


<main>
    <div id="layoutSidenav_content">
        <div class="container-fluid">
            <h1 class="mt-4">Procesos</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="principal.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="configuracion.php">Configuración</a></li>
                <li class="breadcrumb-item active">Procesos</li>
            </ol>
            <div class="card mb-4">
                <div class="card-body">En este apartado, se realiza la creacion de procesos de PPIS 2.0. Es importante tener en cuenta la sensibilidad de la modificación de los datos en este proceso. Asegúrese de tomar las medidas adecuadas para proteger la información y garantizar la integridad de los datos de los procesos.
                    <br><br>Aquí se muestra una tabla con los procesos registrados en el sistema. Puede realizar modificaciones en los datos de los procesos, como nombre, fecha de inicio, fecha de finalización. Tenga en cuenta que cualquier cambio realizado afectará directamente la información de los procesos y puede tener un impacto en su acceso y permisos en el sistema.<br><br>
                    Utilice los botones de edición y eliminación con precaución. Antes de realizar cualquier modificación o eliminación de un periodo, asegúrese de verificar y confirmar la acción para evitar cualquier consecuencia no deseada.<br><br>
                    Recuerde seguir las políticas de seguridad establecidas y respetar la privacidad de los procesos al interactuar con sus datos.
                    Para obtener más información sobre el funcionamiento de la gestión de procesos en PPIS 2.0, consulte la documentación oficial del sistema.
                    Ante cualquier duda o inconveniente, comuníquese con el equipo de soporte técnico para recibir asistencia especializada.</div>
            </div>
            <div id="appProcesos">
                <div class="card mb-4">

                    <div class="card-header"><i class="fas fa-table mr-1"></i>Gestión de Procesos</div>

                    <div class="card-body">

                        <div class="row">
                            <!-- BARRA DE BUSQUEDA  -->
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="input-group">
                                        <input type="text" v-model="term" class="form-control" placeholder="Buscar Proceso">
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="fas fa-search"></i>
                                            </span>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                <div class="col text-right">
                                    <button @click="redirectToConfiguration" class="btn btn-primary" title="Nuevo">
                                        <i class="fas fa-plus-circle fa-2x"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered" width="100%" cellspacing="0">
                                    <thead>
                                        <tr class="bg-primary text-light">
                                            <th>ID</th>
                                            <th>Nombre</th>
                                            <th>Descripción</th>
                                            <th>Categoría</th>
                                            <th>Periodo</th>
                                            <th>Creación</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(procesos, indice) of procesos">
                                            <td>{{procesos.id}}</td>
                                            <td>{{procesos.nombre}}</td>
                                            <td>{{procesos.descripcion}}</td>
                                            <td>{{procesos.categoria}}</td>
                                            <td>{{procesos.nombre_periodo }}</td>
                                            <td>{{procesos.fecha_sys}}</td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <button class="btn btn-secondary" title="Editar" @click="btnEditar(procesos.id, procesos.nombre, procesos.descripcion, procesos.categoria)">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </button>
                                                    <button class="btn btn-danger" title="Eliminar" @click="btnBorrar(procesos.id)">
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
    <script src="app_procesos.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
