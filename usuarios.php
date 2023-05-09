<?php require_once "vistas/parte_superior.php"?>
<!-- Bootstrap CSS -->    
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- FontAwesom CSS -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">        
    <!--Sweet Alert 2 -->
    <link rel="stylesheet" href="plugins/sweetalert2/sweetalert2.min.css">        
    <!--CSS custom -->  
    <link rel="stylesheet" href="main.css">

            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">Administracion de Usuarios</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Panel Administrador</li>
						</ol>
                        <header>
        <h2 class="text-center text-dark"><span class="badge badge">LISTA DE USUARIOS PPIS 2.0</span></h2>
    </header>    
    
     <div id="appMoviles">               
        <div class="container">                
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
                <div class="col">        
                    <button @click="btnAlta" class="btn btn-primary" title="Nuevo"><i class="fas fa-plus-circle fa-2x"></i></button>
                </div>
               <!--<div class="col text-right">                        
                    <h5>Stock Total: <span class="badge badge-success">{{totalStock}}</span></h5>
                </div>-->
            </div>                
            <div class="row mt-6">
                <div class="col-lg-12">                    
                    <table class="table table-striped table-hover">
                        <thead>
                            
                            <tr class="bg-primary text-light">
                                <th>ID</th>                                    
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Email</th> 
                                <th>Rol</th>
                                <th>Usuario</th>
                                <th>Password</th>   
                                <th>Creación</th>   
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
                                <td>{{usuarios.usuario}}</td>
                                <td>{{usuarios.pass}}</td>
                                <td>{{usuarios.fecha_sys}}</td>
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
    <script src="main.js"></script>
    
   
                  
</html>


                