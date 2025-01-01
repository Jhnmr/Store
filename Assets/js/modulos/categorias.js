let tblCategorias;

document.addEventListener('DOMContentLoaded', function() {
    tblCategorias = $('#tblCategorias').DataTable({
        ajax: {
            url: BASE_URL + 'categorias/listar',
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

function nuevaCategoria() {
    document.getElementById('frmCategoria').reset();
    document.getElementById('id').value = '';
    document.getElementById('titleModal').textContent = 'Nueva Categoría';
    $('#modalCategoria').modal('show');
}

function guardarCategoria(e) {
    e.preventDefault();
    const form = document.getElementById('frmCategoria');
    
    if (!validarFormulario(form)) {
        alertas('Todos los campos son obligatorios', 'warning');
        return;
    }
    
    const formData = new FormData(form);
    
    fetch(BASE_URL + 'categorias/guardar', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.type === 'success') {
            $('#modalCategoria').modal('hide');
            tblCategorias.ajax.reload();
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