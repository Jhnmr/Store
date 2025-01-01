document.addEventListener('DOMContentLoaded', function() {
    actualizarEstadisticas();
});

async function actualizarEstadisticas() {
    try {
        const response = await fetch(BASE_URL + 'admin/estadisticas');
        if (!response.ok) throw new Error('Error en la petición');
        
        const data = await response.json();
        
        // Actualizar contadores
        document.getElementById('totalPedidos').textContent = data.pedidos || '0';
        document.getElementById('totalProductos').textContent = data.productos || '0';
        document.getElementById('totalUsuarios').textContent = data.usuarios || '0';
        document.getElementById('totalCategorias').textContent = data.categorias || '0';
    } catch (error) {
        console.error('Error al cargar estadísticas:', error);
    }
} 