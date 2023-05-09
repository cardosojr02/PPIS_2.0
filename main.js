var url = "bd/crud.php";

var appMoviles = new Vue({
  el: "#appMoviles",
  data: {
    usuarios: [],
    nombre: "",
    apellido: "",
    email: "",
    tipo_usuario: "",
    total: 0,
  },
  methods: {
    //BOTONES        
    btnAlta: async function () {
      const { value: formValues } = await Swal.fire({
        title: 'NUEVO',
        html:
          '<div class="row"><label class="col-sm-3 col-form-label">Nombre</label><div class="col-sm-7"><input id="nombre" type="text" class="form-control" required></div></div><div class="row"><label class="col-sm-3 col-form-label">Apellido</label><div class="col-sm-7"><input id="apellido" type="text" class="form-control" required></div></div><div class="row"><label class="col-sm-3 col-form-label">Email</label><div class="col-sm-7"><input id="email" type="email"  class="form-control" required></div><div class="row"><label class="col-sm-6 col-form-label">Rol</label><div class="col-sm-6 center"><input id="tipo_usuario" type="number"  value="1" class="form-control" required></div></div>',
        focusConfirm: false,
        showCancelButton: true,
        confirmButtonText: 'Guardar',
        confirmButtonColor: '#1cc88a',
        cancelButtonColor: '#3085d6',
        preConfirm: () => {
          const nombre = document.getElementById('nombre').value;
          const apellido = document.getElementById('apellido').value;
          const email = document.getElementById('email').value;
          const tipo_usuario = document.getElementById('tipo_usuario').value;

          // Validar que los campos no estén vacíos y que el valor de tipo_usuario esté dentro del rango permitido
          if (nombre === '' || apellido === '' || email === '' || tipo_usuario === '' || tipo_usuario < 1 || tipo_usuario > 2) {
            Swal.showValidationMessage(
              'Por favor, complete todos los campos, ingrese un correo electrónico válido y seleccione un rol válido.'
            );
          }

          // Validar que el email sea un correo electrónico válido
          const regexEmail = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
          if (!regexEmail.test(email)) {
            Swal.showValidationMessage(
              'Por favor, complete todos los campos, ingrese un correo electrónico válido y seleccione un rol válido.'
            );
          }

          // Retornar los valores si todo está correcto
          return { nombre, apellido, email, tipo_usuario };
        }
      });

      if (formValues) {
        this.nombre = formValues.nombre;
        this.apellido = formValues.apellido;
        this.email = formValues.email;
        this.tipo_usuario = formValues.tipo_usuario;

        this.altaMovil();

        const Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000
        });

        Toast.fire({
          type: 'success',
          title: '¡Usuario Agregado!'
        });
      }
    },


    btnEditar: async function (id, nombre, apellido, email, tipo_usuario) {
      await Swal.fire({
        title: 'EDITAR',
        html:
          '<div class="form-group"><div class="row"><label class="col-sm-3 col-form-label">Nombre</label><div class="col-sm-7"><input id="nombre" value="' + nombre + '" type="text" class="form-control"></div></div><div class="row"><label class="col-sm-3 col-form-label">Apellido</label><div class="col-sm-7"><input id="apellido" value="' + apellido + '" type="text" class="form-control"></div></div><div class="row"><label class="col-sm-3 col-form-label">Email</label><div class="col-sm-7"><input id="email" value="' + email + '" type="email"  class="form-control"></div></div></div><div class="row"><label class="col-sm-3 col-form-label">Rol</label><div class="col-sm-7"><input id="tipo_usuario" value="' + tipo_usuario + '" type="number" min="1" max="2" class="form-control"></div></div> ',
        focusConfirm: false,
        showCancelButton: true,
      }).then((result) => {
        if (result.value) {
          nombre = document.getElementById('nombre').value,
          apellido = document.getElementById('apellido').value,
          email = document.getElementById('email').value,
          tipo_usuario = document.getElementById('tipo_usuario').value;

          // Validar que el email sea un correo electrónico válido
      const regexEmail = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
      if (!regexEmail.test(email)) {
        Swal.fire(
          '¡Error!',
          'Por favor ingrese un correo electrónico válido.',
          'error'
        );
        return; // Detener la ejecución de la función
      }
    
          // Validar que los campos no estén vacíos y que el valor de tipo_usuario esté dentro del rango permitido
          if (nombre === '' || apellido === '' || email === '' || tipo_usuario === '' || tipo_usuario < 1 || tipo_usuario > 2) {
            Swal.fire(
              '¡Error!',
              'Por favor, complete todos los campos y seleccione un rol válido.',
              'error'
            )
          } else {
            this.editarMovil(id, nombre, apellido, email, tipo_usuario);
            Swal.fire(
              '¡Actualizado!',
              'El registro ha sido actualizado.',
              'success'
            )
          }
        }
      });
    
    

    },
    btnBorrar: function (id) {
      Swal.fire({
        title: '¿Está seguro de borrar el registro: ' + id + " ?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Borrar'
      }).then((result) => {
        if (result.value) {
          this.borrarMovil(id);
          //y mostramos un msj sobre la eliminación  
          Swal.fire(
            '¡Eliminado!',
            'El registro ha sido borrado.',
            'success'
          )
        }
      })
    },

    //PROCEDIMIENTOS para el CRUD     
    listarMoviles: function () {
      
      axios.post(url, { opcion: 4 }).then(response => {
        this.usuarios = response.data;
      });
    },
    // Procedimiento CREAR.
altaMovil: function() {
  if (!this.validarUsuario()) {
    return;
  }
  
  axios.post(url, { 
    opcion: 1, 
    nombre: this.nombre, 
    apellido: this.apellido, 
    email: this.email, 
    tipo_usuario: this.tipo_usuario 
  }).then(response => {
    this.listarMoviles();
  });

  this.nombre = "";
  this.apellido = "";
  this.email = "";
  this.tipo_usuario = "";
},

// Función para validar si el usuario ya existe.
validarUsuario: function() {
  if (this.nombre === "" || this.apellido === "" || this.email === "" || this.tipo_usuario === "") {
    Swal.fire({
      iconHtml: "error",
      title: "Error",
      text: "Debe completar todos los campos"
    });
    return false;
  }

  if (this.usuarios.every(usuario => usuario.email.toLowerCase() !== this.email.toLowerCase())) {
    return true;
  } else {
    Swal.fire({
      iconHtml: "error",
      title: "Error",
      text: "El usuario ya existe"
    });
    return false;
  }
}

    ,
    //Procedimiento EDITAR.
    editarMovil: function (id, nombre, apellido, email, tipo_usuario) {
      axios.post(url, { opcion: 2, id: id, nombre: nombre, apellido: apellido, email: email, tipo_usuario: tipo_usuario }).then(response => {
        this.listarMoviles();
      });
    },
    //Procedimiento BORRAR.
    borrarMovil: function (id) {
      axios.post(url, { opcion: 3, id: id }).then(response => {
        this.listarMoviles();
      });
    }
  },
  created: function () {
    this.listarMoviles();
  },
  computed: {
    totalStock() {
      this.total = 0;
      for (usuarios of this.usuarios) {
        this.total = this.total + parseInt(usuarios.nombre);
      }
      return this.total;
    }
  }
});