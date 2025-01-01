let tblRoles;

document.addEventListener('DOMContentLoaded', function() {
    tblRoles = $('#tblRoles').DataTable({
        ajax: {
            url: BASE_URL + 'roles/listar',
            dataSrc: ''
        },
        columns: [
            { data: 'id' },
            { data: 'nombre' },
            { data: 'acciones' }
        ],
        language: {
            url: BASE_URL + 'assets/js/spanish.json'
        }
    });
});

function nuevoRol() {
    document.getElementById('frmRol').reset();
    document.getElementById('id').value = '';
    document.getElementById('titleModal').textContent = 'Nuevo Rol';
    $('#modalRol').modal('show');
}

function guardarRol(e) {
    e.preventDefault();
    const form = document.getElementById('frmRol');
    
    if (!validarFormulario(form)) {
        alertas('Todos los campos son obligatorios', 'warning');
        return;
    }
    
    const formData = new FormData(form);
    
    fetch(BASE_URL + 'roles/guardar', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.type === 'success') {
            $('#modalRol').modal('hide');
            tblRoles.ajax.reload();
            alertas(data.msg, data.type);
        } else {
            alertas(data.msg, data.type);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alertas('Error en el servidor', 'error');
    });
} 