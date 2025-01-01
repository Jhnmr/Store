const base_url = 'http://localhost/Tienda/';

function alertas(msg, icono) {
    Swal.fire({
        icon: icono,
        title: msg,
        showConfirmButton: false,
        timer: 2000
    });
}

// Función para formatear moneda
function formatearMoneda(monto) {
    return new Intl.NumberFormat('es-PE', {
        style: 'currency',
        currency: 'PEN'
    }).format(monto);
}

// Función para validar formularios
function validarFormulario(formulario) {
    let valid = true;
    const inputs = formulario.querySelectorAll('input[required], select[required], textarea[required]');
    
    inputs.forEach(input => {
        if (!input.value) {
            input.classList.add('is-invalid');
            valid = false;
        } else {
            input.classList.remove('is-invalid');
        }
    });
    
    return valid;
}

// Función para previsualizar imagen
function previewImage(input, previewId) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById(previewId).src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
}