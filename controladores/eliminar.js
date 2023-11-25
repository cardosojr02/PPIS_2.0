function confirmacion(e) {
    e.preventDefault();

	var url = e.currentTarget.getAttribute('href');

    Swal.fire({
        title: '¿Estás seguro?',
        text: "¡Este proceso es irreversible!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, eliminar!',
        cancelButtonText: 'No, cancelar!'
      }).then((result) => {
        if (result.isConfirmed) {
		  window.location.href = url;
        }
      })
}

function activar(e) {
  e.preventDefault();

var url = e.currentTarget.getAttribute('href');

  Swal.fire({
      title: '¿Estás seguro?',
      text: "¡Estas apunto de activar este registro!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si, activar!',
      cancelButtonText: 'No, cancelar!'
    }).then((result) => {
      if (result.isConfirmed) {
    window.location.href = url;
      }
    })
}

function desactivar(e) {
  e.preventDefault();

var url = e.currentTarget.getAttribute('href');

  Swal.fire({
      title: '¿Estás seguro?',
      text: "¡Estas apunto de desactivar este registro!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si, desactivar!',
      cancelButtonText: 'No, cancelar!'
    }).then((result) => {
      if (result.isConfirmed) {
    window.location.href = url;
      }
    })
}