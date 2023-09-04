var url = "bd/crud_procesos.php";

var appProcesos = new Vue({
  el: "#appProcesos",
  data: {
    procesos: [],
    id: "",
    nombre: "",
    descripcion: "",
    categoria: "",
    id_periodo: "",
    fecha_sys: "",
    term: "",
    mensajeError: ""
  },
  methods: {
    //BOTONES
    redirectToConfiguration: function () {
      // Redirige al usuario a la página de configuración
      window.location.href = './configuracion.php'; 
  },
    /* btnAlta: async function () {
      try {
        const response = await axios.get('procesos/obtener_periodos.php');
        const periodos = response.data;
    
        let periodoOptions = '';
        for (let i = 0; i < periodos.length; i++) {
          periodoOptions += `<option value="${periodos[i].id}">${periodos[i].nombre}</option>`;
        }
    
        const { value: formValues, dismiss: dismissReason } = await Swal.fire({
          title: 'CREAR PROCESO',
          html: `
            <form id="Form">
              <div class="mb-3">
                <label for="nombre">Nombre del Periodo:</label>
                <input type="text" class="form-control" id="nombre" placeholder="Ingrese el nombre del Proceso" required>
              </div>
              <div class="mb-3">
                <label for="descripcion">Descripción:</label>
                <input type="text" class="form-control" id="descripcion" placeholder="Ingrese la descripción del Proceso" required>
              </div>
              <div class="mb-3">  
                <label for="categoria">Categoría:</label>
                <input type="text" class="form-control" id="categoria" placeholder="Ingrese la categoría del Proceso" required>
              </div>
              <div class="mb-3">
                <label for="id_periodo">Periodo:</label>
                <select class="form-control" id="id_periodo" required>
                  ${periodoOptions}
                </select>
              </div>
            </form>`,
          focusConfirm: true,
          showCancelButton: true,
          confirmButtonText: 'Guardar',
          confirmButtonColor: '#1cc88a',
          cancelButtonColor: '#3085d6'
        });
    
        if (formValues && dismissReason !== Swal.DismissReason.cancel) {
          const nombre = document.getElementById('nombre').value;
          const descripcion = document.getElementById('descripcion').value;
          const categoria = document.getElementById('categoria').value;
          const id_periodo = document.getElementById('id_periodo').value;
    
          // Validar que los campos no estén vacíos
          if (nombre === '' || descripcion === '' || categoria === '' || id_periodo === '') {
            Swal.showValidationMessage('Por favor, complete todos los campos');
            return;
          }
    
          if (formValues && dismissReason !== Swal.DismissReason.cancel) {
            const nombre = document.getElementById("nombre").value;
            const descripcion = document.getElementById("descripcion").value;
            const categoria = document.getElementById("categoria").value;
    
            // Validar que los campos no estén vacíos
            if (nombre === "" || descripcion === "" || categoria === "") {
              Swal.showValidationMessage("Por favor, complete todos los campos");
              return;
            }
    
            // Validar que el nombre no esté duplicado
            if (this.validarNombreDuplicado(nombre)) {
              Swal.fire({
                icon: "error",
                title: "Error",
                text: "El nombre ya existe"
              });
              return;
            }
    
            this.nombre = nombre;
            this.descripcion = descripcion;
            this.categoria = categoria;
    
            this.altaMovil();
    
            const Toast = Swal.mixin({
              toast: true,
              position: "top-end",
              showConfirmButton: false,
              timer: 3000
            });
    
            Toast.fire({
              icon: "success",
              title: "¡Periodo Agregado!"
            });
          } else {
            Swal.fire({
              icon: "warning",
              title: "Proceso Cancelado",
              text: "Se canceló el proceso de creación de nuevo usuario"
            });
          }
    
        } else {
          Swal.fire({
            icon: 'warning',
            title: 'Proceso Cancelado',
            text: 'Se canceló el proceso de creación de nuevo usuario'
          });
        }
      } catch (error) {
        console.error(error);
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Ocurrió un error al obtener los periodos'
        });
      }
    }, */
    
    btnEditar: async function (id, nombre, descripcion, categoria) {
      await Swal.fire({
        title: "EDITAR PROCESO",
        html: `<div class="form-group">
                <div class="row">
                  <label class="col-sm-3 col-form-label">Nombre</label>
                  <div class="col-sm-7">
                    <input id="nombre" value="${nombre}" type="text" class="form-control">
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-3 col-form-label">Descripción</label>
                  <div class="col-sm-7">
                    <input id="descripcion" value="${descripcion}" type="text" class="form-control">
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-3 col-form-label">Categoria</label>
                  <div class="col-sm-7">
                    <input id="categoria" value="${categoria}" type="text" class="form-control">
                  </div>
                </div>
              </div>`,
        focusConfirm: false,
        showCancelButton: true
      }).then((result) => {
        if (result.value) {
          const nombre = document.getElementById("nombre").value;
          const descripcion = document.getElementById("descripcion").value;
          const categoria = document.getElementById("categoria").value;

          // Validar que los campos no estén vacíos
          if (nombre === "" || descripcion === "" || categoria === "") {
            Swal.fire("¡Error!", "Por favor, complete todos los campos.", "error");
          } else {
            this.editarMovil(id, nombre, descripcion, categoria);
            Swal.fire("¡Actualizado!", "El registro ha sido actualizado.", "success");
          }
        }
      });
    },
    btnBorrar: function (id) {
      Swal.fire({
        title: `¿Está seguro de borrar el registro: ${id} ?`,
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Borrar"
      }).then((result) => {
        if (result.value) {
          this.borrarMovil(id);
        }
      });
    },
    

    listarMoviles: function () {
      // Obtener los periodos del servidor
      axios
        .get('procesos/obtener_periodos.php')
        .then((response) => {
          this.periodos = response.data;
        })
        .catch((error) => {
          console.error(error);
        });
      axios
        .post(url, { opcion: 4 })
        .then((response) => {
          this.procesos = response.data.filter((procesos) =>
            procesos.nombre.toLowerCase().includes(this.term.toLowerCase())
          );
        })
        .catch((error) => {
          console.error(error);
        });
    },
    // Procedimiento CREAR.
    validarNombreDuplicado: function (nombre) {
      return this.procesos.some((periodo) => periodo.nombre === nombre);
    },
    altaMovil: async function () {
      if (this.validarNombreDuplicado(this.nombre)) {
        Swal.fire({
          icon: "error",
          title: "Error",
          text: "El Proceso ya existe"
        });
        return;
      }

      try {
        const response = await axios.post(url, {
          opcion: 1,
          nombre: this.nombre,
          descripcion: this.descripcion,
          categoria: this.categoria
        });

        if (response.data === "existe") {
          Swal.fire({
            icon: "error",
            title: "Error",
            text: "El Proceso ya existe"
          });
        } else {
          this.listarMoviles();

          this.nombre = "";
          this.descripcion = "";
          this.categoria = "";

          Swal.fire({
            icon: "success",
            title: "¡Periodo Agregado!",
            showConfirmButton: false,
            timer: 3000
          });
        }
      } catch (error) {
        console.error(error);
      }
    },
    // Procedimiento EDITAR.
    editarMovil: function (id, nombre, descripcion, categoria) {
      axios.post(url, {
          opcion: 2,
          id: id,
          nombre: nombre,
          descripcion: descripcion,
          categoria: categoria
        })
        .then(response => {
          this.listarMoviles();
        });
    },
    
     //Procedimiento BORRAR.
     //SI EL REGISTRO NO SE ELIMINA ES PORQUE TIENE UN REGISTRO ASIGNADO EN OTRO CAMPO (ForeingKey).
     borrarMovil: function (id) {
      axios.post(url, { opcion: 3, id: id }).then((response) => {
        if (response.status === 200) {
          this.listarMoviles();
          this.mensajeError = ""; // Limpiar mensaje de error
          Swal.fire(
            '¡Eliminado!',
            'El registro ha sido borrado.',
            'success'
            
          );
        } else {
          this.mensajeError = response.data.mensaje;
        }
      }).catch((error) => {
        console.error(error);
      });
    }
  },
  
  created: function () {
    this.listarMoviles();
    
  },


  watch: {
    term: function () {
      this.listarMoviles();
    }
  },
  
  computed: {
    totalStock() {
      this.total = 0;
      for (s of this.s) {
        this.total = this.total + parseInt(s.nombre);
      }
      return this.total;
    }
  }
});
