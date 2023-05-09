<?php require_once "parte_superior.php"?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">Administrador de usuarios</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Panel Administrador</li>
						</ol>
                        <header>
        <h2 class="text-center text-dark"><span class="badge badge-primary">LISTA DE USUARIOS PPIS 2.0</span></h2>
    </header>    
    
     <div id="appMoviles">               
        <div class="container">                
            <div class="row">       
                <div class="col">        
                    <button @click="btnAlta" class="btn btn-primary" title="Nuevo"><i class="fas fa-plus-circle fa-2x"></i></button>
                </div>
               <!--<div class="col text-right">                        
                    <h5>Stock Total: <span class="badge badge-success">{{totalStock}}</span></h5>
                </div>-->
            </div>                
            <div class="row mt-6">
                <div class="col-lg-12">                    
                    <table class="table table-striped">
                        <thead>
                            <tr class="bg-primary text-light">
                                <th>ID</th>                                    
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Email</th> 
                                <th>Rol</th>   
                                <th>Acciones</th>
                            </tr>    
                        </thead>
                        <tbody>
                            <tr v-for="(usuarios,indice) of usuarios">                                
                                <td>{{usuarios.id}}</td>                                
                                <td>{{usuarios.nombre}}</td>
                                <td>{{usuarios.apellido}}</td>
                                <td>{{usuarios.email}}</td>
                                <td>{{usuarios.tipo_usuario}}</td>
                                <td>
                                <div class="btn-group" role="group">
                                    <button class="btn btn-secondary" title="Editar" @click="btnEditar(usuarios.id, usuarios.nombre, usuarios.apellido, usuarios.email, usuarios.tipo_usuario)"><i class="fas fa-pencil-alt"></i></button>    
                                    <button class="btn btn-danger" title="Eliminar" @click="btnBorrar(usuarios.id)"><i class="fas fa-trash-alt"></i></button>      
								</div>
                                </td>
                            </tr>    
                        </tbody>
                    </table>                    
                </div>
            </div>
        </div>        
    </div>        
    <!-- jQuery, Popper.js, Bootstrap JS -->
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
    <script src="main.js"></script> 
                    
						</div>
				</div>
				</main>
<?php require_once "parte_inferior.php"?>
               