let tblUsuarios;

document.addEventListener('DOMContentLoaded', function() {
    tblUsuarios = $('#tblUsuarios').DataTable({
        ajax: {
            url: BASE_URL + 'usuarios/listar',
            dataSrc: ''
        },
        columns: [
            { data: 'id' },
            { data: 'nombres' },
            { data: 'email' },
            { data: 'rol' },
            { data: 'acciones' }
        ],
        language: {
            url: BASE_URL + 'assets/js/spanish.json'
        },
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
});

function nuevoUsuario() {
    document.getElementById('frmUsuario').reset();
    document.getElementById('id').value = '';
    document.getElementById('titleModal').textContent = 'Nuevo Usuario';
    $('#modalUsuario').modal('show');
}

function guardarUsuario(e) {
    e.preventDefault();
    const form = document.getElementById('frmUsuario');
    
    if (!validarFormulario(form)) {
        alertas('Todos los campos son obligatorios', 'warning');
        return;
    }
    
    const formData = new FormData(form);
    
    fetch(BASE_URL + 'usuarios/guardar', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.type === 'success') {
            $('#modalUsuario').modal('hide');
            tblUsuarios.ajax.reload();
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