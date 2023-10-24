var url = "bd/crud_periodos.php";

var appMoviles = new Vue({
  el: "#appMoviles",
  data: {
    periodos: [],
    id: "",
    nombre: "",
    fechaInicio: "",
    fechaFin: "",
    fecha_sys: "",
    term: ""
  },
  methods: {
    //BOTONES
    btnAlta: async function () {
      const { value: formValues, dismiss: dismissReason } = await Swal.fire({
        title: "CREAR PERIODO",
        html: `
          <form id="Form">
            <div class="mb-3">
              <label for="nombre">Nombre del Periodo:</label>
              <input type="text" class="form-control" id="nombre" placeholder="Ingrese el nombre del Periodo  " required>
            </div>
            <div class="mb-3">
              <label for="fechaInicio">Fecha de Inicio:</label>
              <input type="date" class="form-control" id="fechaInicio" required>
            </div>
            <div class="mb-3">
              <label for="fechaFin">Fecha de Fin:</label>
              <input type="date" class="form-control" id="fechaFin" required>
            </div>
          </form>`,
        focusConfirm: true,
        showCancelButton: true,
        confirmButtonText: "Guardar",
        confirmButtonColor: "#1cc88a",
        cancelButtonColor: "#3085d6"
      });

      if (formValues && dismissReason !== Swal.DismissReason.cancel) {
        const nombre = document.getElementById("nombre").value;
        const fechaInicio = document.getElementById("fechaInicio").value;
        const fechaFin = document.getElementById("fechaFin").value;

        // Validar que los campos no estén vacíos
        if (nombre === "" || fechaInicio === "" || fechaFin === "") {
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
        this.fechaInicio = fechaInicio;
        this.fechaFin = fechaFin;

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
    },
    btnEditar: async function (id, nombre, fechaInicio, fechaFin) {
      await Swal.fire({
        title: "EDITAR PERIODO",
        html: `<div class="form-group">
                <div class="row">
                  <label class="col-sm-3 col-form-label">Nombre</label>
                  <div class="col-sm-7">
                    <input id="nombre" value="${nombre}" type="text" class="form-control">
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-3 col-form-label">Fecha de Inicio</label>
                  <div class="col-sm-7">
                    <input id="fechaInicio" value="${fechaInicio}" type="date" class="form-control">
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-3 col-form-label">Fecha de Fin</label>
                  <div class="col-sm-7">
                    <input id="fechaFin" value="${fechaFin}" type="date" class="form-control">
                  </div>
                </div>
              </div>`,
        focusConfirm: false,
        showCancelButton: true
      }).then((result) => {
        if (result.value) {
          const nombre = document.getElementById("nombre").value;
          const fechaInicio = document.getElementById("fechaInicio").value;
          const fechaFin = document.getElementById("fechaFin").value;

          // Validar que los campos no estén vacíos
          if (nombre === "" || fechaInicio === "" || fechaFin === "") {
            Swal.fire("¡Error!", "Por favor, complete todos los campos.", "error");
          } else {
            this.editarMovil(id, nombre, fechaInicio, fechaFin);
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
          //y mostramos un msj sobre la eliminación  
          Swal.fire(
            '¡Eliminado!',
            'El registro ha sido borrado.',
            'Si el registro no se elimina,puede que exista un registro vinculado a este proceso, verifique en subprocesos.',
            'success'
          )
        }
      });
    },

    listarMoviles: function () {
      axios
        .post(url, { opcion: 4 })
        .then((response) => {
          this.periodos = response.data.filter((periodo) =>
            periodo.nombre.toLowerCase().includes(this.term.toLowerCase())
          );
        })
        .catch((error) => {
          console.error(error);
        });
    },
    // Procedimiento CREAR.
    validarNombreDuplicado: function (nombre) {
      return this.periodos.some((periodo) => periodo.nombre === nombre);
    },
    altaMovil: async function () {
      if (this.validarNombreDuplicado(this.nombre)) {
        Swal.fire({
          icon: "error",
          title: "Error",
          text: "El Periodo ya existe"
        });
        return;
      }

      try {
        const response = await axios.post(url, {
          opcion: 1,
          nombre: this.nombre,
          fechaInicio: this.fechaInicio,
          fechaFin: this.fechaFin
        });

        if (response.data === "existe") {
          Swal.fire({
            icon: "error",
            title: "Error",
            text: "El Periodo ya existe"
          });
        } else {
          this.listarMoviles();

          this.nombre = "";
          this.fechaInicio = "";
          this.fechaFin = "";

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
    editarMovil: function (id, nombre, fechaInicio, fechaFin) {
      axios.post(url, {
          opcion: 2,
          id: id,
          nombre: nombre,
          fechaInicio: fechaInicio,
          fechaFin: fechaFin
        })
        .then(response => {
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