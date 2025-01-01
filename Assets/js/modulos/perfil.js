const frmPerfil = document.getElementById('frmPerfil');

frmPerfil.addEventListener('submit', function(e) {
    e.preventDefault();
    
    if (!validarFormulario(this)) {
        alertas('Todos los campos son obligatorios', 'warning');
        return;
    }
    
    const formData = new FormData(this);
    
    fetch(BASE_URL + 'perfil/actualizar', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        alertas(data.msg, data.type);
        if (data.type === 'success') {
            setTimeout(() => {
                window.location.reload();
            }, 1500);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alertas('Error en el servidor', 'error');
    });
});

function eliminarCuenta() {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Esta acción no se puede deshacer",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar cuenta',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(BASE_URL + 'perfil/eliminar', {
                method: 'POST'
            })
            .then(response => response.json())
            .then(data => {
                if (data.type === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: data.msg,
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        window.location = BASE_URL;
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.msg
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Ocurrió un error al procesar la solicitud'
                });
            });
        }
    });
} 