let tblProductos;

document.addEventListener('DOMContentLoaded', function() {
    tblProductos = $('#tblProductos').DataTable({
        ajax: {
            url: BASE_URL + 'productos/listar',
            dataSrc: ''
        },
        columns: [
            { data: 'id' },
            { 
                data: 'imagen',
                render: function(data) {
                    return `<img src="${BASE_URL + data}" height="50">`;
                }
            },
            { data: 'nombre' },
            { data: 'precio' },
            { data: 'cantidad' },
            { data: 'categoria' },
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

function nuevoProducto() {
    document.getElementById('frmProducto').reset();
    document.getElementById('id').value = '';
    document.getElementById('titleModal').textContent = 'Nuevo Producto';
    document.getElementById('preview').src = BASE_URL + 'assets/img/default.png';
    $('#modalProducto').modal('show');
}

function previewImagen(e) {
    const url = e.target.files[0];
    const urlTmp = URL.createObjectURL(url);
    document.getElementById('preview').src = urlTmp;
}

function guardarProducto(e) {
    e.preventDefault();
    const form = document.getElementById('frmProducto');
    
    if (!validarFormulario(form)) {
        alertas('Todos los campos son obligatorios', 'warning');
        return;
    }
    
    const formData = new FormData(form);
    
    fetch(BASE_URL + 'productos/guardar', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.type === 'success') {
            $('#modalProducto').modal('hide');
            tblProductos.ajax.reload();
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