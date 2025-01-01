let tblPedidos;

document.addEventListener('DOMContentLoaded', function() {
    tblPedidos = $('#tblPedidos').DataTable({
        ajax: {
            url: BASE_URL + 'pedidos/listar',
            dataSrc: ''
        },
        columns: [
            { data: 'id' },
            { data: 'fecha' },
            { data: 'total' },
            { data: 'estado' },
            { data: 'acciones' }
        ],
        language: {
                url: BASE_URL + 'assets/js/spanish.json'
        },
        order: [[0, 'desc']]
    });
});

function verPedido(idPedido) {
    const url = BASE_URL + 'pedidos/ver/' + idPedido;
    window.location = url;
}

function cambiarEstado(idPedido, estado) {
    Swal.fire({
        title: '¿Está seguro?',
        text: "¿Desea cambiar el estado del pedido?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, cambiar',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            const formData = new FormData();
            formData.append('id', idPedido);
            formData.append('estado', estado);
            
            fetch(BASE_URL + 'pedidos/cambiarEstado', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.type === 'success') {
                    tblPedidos.ajax.reload();
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
    });
} 