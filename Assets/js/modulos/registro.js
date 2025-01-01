document.getElementById('frmRegistro').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const nombre = document.getElementById('nombre').value;
    const apellidos = document.getElementById('apellidos').value;
    const correo = document.getElementById('correo').value;
    const clave = document.getElementById('clave').value;
    // Validaciones
    if (nombre.length < 3 || apellidos.length < 3) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Nombres y apellidos deben tener al menos 3 caracteres'
        });
        return;
    }

    if (!correo.match(/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/)) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Por favor ingrese un correo válido'
        });
        return;
    }

    if (!clave.match(/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/)) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'La contraseña debe tener al menos 8 caracteres, una letra y un número'
        });
        return;
    }
    
    const btnRegistro = document.getElementById('btnRegistro');
    btnRegistro.disabled = true;
    btnRegistro.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Procesando...';

    const formData = new FormData(this);
    
    fetch(BASE_URL + 'auth/registro', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Error en la petición');
        }
        return response.json();
    })
    .then(data => {
        btnRegistro.disabled = false;
        btnRegistro.innerHTML = 'Crear Cuenta';
        
        if (data.type === 'success') {
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: data.msg,
                timer: 1500,
                showConfirmButton: false
            }).then(() => {
                window.location = BASE_URL + 'auth';
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
        btnRegistro.disabled = false;
        btnRegistro.innerHTML = 'Crear Cuenta';
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Error al procesar la solicitud'
        });
    });
});

// Toggle password visibility
document.getElementById('togglePassword').addEventListener('click', function() {
    const password = document.getElementById('clave');
    const icon = this.querySelector('i');
    
    if (password.type === 'password') {
        password.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        password.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}); 