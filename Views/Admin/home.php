<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="<?php echo BASE_URL; ?>assets/css/admin.css" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .card-dashboard {
            transition: transform .2s;
        }
        .card-dashboard:hover {
            transform: translateY(-5px);
        }
        .stats-icon {
            font-size: 2rem;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>
<body>
<?php include_once 'Views/template/header-admin.php'; ?>


    <div class="container-fluid py-4">
        <!-- Tarjetas de Resumen -->
        <div class="row g-4 mb-4">
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card card-dashboard bg-primary text-white">
                    <div class="card-body d-flex align-items-center">
                        <div class="stats-icon bg-white text-primary">
                            <i class="fas fa-box"></i>
                        </div>
                        <div class="ms-3">
                            <h5 class="card-title mb-0">Total Productos</h5>
                            <h3 class="mb-0"><?php echo isset($productos['total']) ? $productos['total'] : 0; ?></h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card card-dashboard bg-success text-white">
                    <div class="card-body d-flex align-items-center">
                        <div class="stats-icon bg-white text-success">
                            <i class="fas fa-tags"></i>
                        </div>
                        <div class="ms-3">
                            <h5 class="card-title mb-0">Categorías</h5>
                            <h3 class="mb-0"><?php echo isset($total_categorias['total_categorias']) ? $total_categorias['total_categorias'] : 0; ?></h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card card-dashboard bg-warning text-white">
                    <div class="card-body d-flex align-items-center">
                        <div class="stats-icon bg-white text-warning">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <div class="ms-3">
                            <h5 class="card-title mb-0">Pedidos del Mes</h5>
                            <h3 class="mb-0"><?php echo isset($pedidos_mes['pedidos_mes']) ? $pedidos_mes['pedidos_mes'] : 0; ?></h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card card-dashboard bg-info text-white">
                    <div class="card-body d-flex align-items-center">
                        <div class="stats-icon bg-white text-info">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <div class="ms-3">
                            <h5 class="card-title mb-0">Ventas del Mes</h5>
                            <h3 class="mb-0">$<?php echo isset($ventas_mes['ventas_mes']) ? number_format($ventas_mes['ventas_mes'], 2) : '0.00'; ?></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gráficos -->
        <div class="row g-4">
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Ventas por Mes</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="ventasMensuales"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Productos por Categoría</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="productosPorCategoria"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de Últimos Pedidos -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Últimos Pedidos</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Cliente</th>
                                        <th>Fecha</th>
                                        <th>Total</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($ultimos_pedidos) && is_array($ultimos_pedidos)) : ?>
                                        <?php foreach($ultimos_pedidos as $pedido) : ?>
                                            <tr>
                                                <td><?php echo $pedido['id']; ?></td>
                                                <td><?php echo $pedido['cliente']; ?></td>
                                                <td><?php echo $pedido['fecha']; ?></td>
                                                <td>$<?php echo number_format($pedido['total'], 2); ?></td>
                                                <td>
                                                    <span class="badge bg-<?php echo $pedido['estado'] == 1 ? 'success' : 'warning'; ?>">
                                                        <?php echo $pedido['estado'] == 1 ? 'Completado' : 'Pendiente'; ?>
                                                    </span>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <tr>
                                            <td colspan="4">No hay pedidos disponibles</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alertas de Stock Bajo -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-warning text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-exclamation-triangle"></i> Alertas de Stock Bajo
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Categoría</th>
                                        <th>Stock Actual</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($productos_stock_bajo) && is_array($productos_stock_bajo)) : ?>
                                        <?php foreach($productos_stock_bajo as $producto) : ?>
                                            <tr>
                                                <td><?php echo $producto['nombre']; ?></td>
                                                <td><?php echo $producto['categoria']; ?></td>
                                                <td>
                                                    <span class="badge bg-danger">
                                                        <?php echo $producto['stock']; ?> unidades
                                                    </span>
                                                </td>
                                                <td>
                                                    <button class="btn btn-primary btn-sm" 
                                                            onclick="editarProducto(<?php echo $producto['id']; ?>)">
                                                        Actualizar Stock
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <tr>
                                            <td colspan="4">No hay productos de stock bajo</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filtros de Fecha -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h5 class="card-title mb-0">Filtrar Ventas por Fecha</h5>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex gap-2">
                                    <input type="date" class="form-control" id="fecha_inicio">
                                    <input type="date" class="form-control" id="fecha_fin">
                                    <button class="btn btn-primary" onclick="filtrarVentas()">
                                        Filtrar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Widget de Ventas del Día -->
        <div class="col-md-3">
            <div class="card border-success">
                <div class="card-body">
                    <h5 class="card-title">Ventas de Hoy</h5>
                    <div id="ventasHoy">
                        <h3>$<span id="totalVentasHoy">0.00</span></h3>
                        <p class="mb-0">Pedidos: <span id="totalPedidosHoy">0</span></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Productos Más Vendidos -->
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Clientes Frecuentes</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Cliente</th>
                                        <th>Pedidos</th>
                                        <th>Total Comprado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($clientes_frecuentes) && is_array($clientes_frecuentes)) : ?>
                                        <?php foreach($clientes_frecuentes as $cliente) : ?>
                                            <tr>
                                                <td><?php echo $cliente['nombre']; ?></td>
                                                <td><?php echo $cliente['total_pedidos']; ?></td>
                                                <td>$<?php echo number_format($cliente['total_compras'], 2); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <tr>
                                            <td colspan="4">No hay clientes frecuentes disponibles</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Después del filtro de fechas -->
        <div class="col-md-6 text-end">
            <a href="<?php echo BASE_URL; ?>admin/exportarExcel" class="btn btn-success me-2">
                <i class="fas fa-file-excel"></i> Exportar a Excel
            </a>
            <a href="<?php echo BASE_URL; ?>admin/exportarPDF" class="btn btn-danger">
                <i class="fas fa-file-pdf"></i> Exportar a PDF
            </a>
        </div>

        <!-- Después de los gráficos existentes -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Estadísticas Detalladas por Categoría</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover" id="tablaEstadisticas">
                                <thead>
                                    <tr>
                                        <th>Categoría</th>
                                        <th>Total Productos</th>
                                        <th>Unidades Vendidas</th>
                                        <th>Total Ventas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Después de las estadísticas detalladas -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">Resumen Mensual</h5>
                    </div>
                    <div class="card-body">
                        <div class="row" id="resumenMensual">
                            <!-- Se llenará con JavaScript -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Después del resumen mensual -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h5 class="card-title mb-0">Estadísticas Avanzadas</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <canvas id="graficoEstadisticas"></canvas>
                            </div>
                            <div class="col-md-4">
                                <div class="card border-info mb-3">
                                    <div class="card-body" id="resumenEstadisticas">
                                        <!-- Se llenará con JavaScript -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const BASE_URL = '<?php echo BASE_URL; ?>';

        // Función básica para actualizar estadísticas
        function actualizarEstadisticas() {
            console.log('Actualizando estadísticas...');
            fetch(BASE_URL + 'admin/estadisticas')
                .then(response => response.json())
                .then(data => {
                    console.log('Datos recibidos:', data);
                    if (data.success) {
                        document.getElementById('totalUsuarios').textContent = data.usuarios || 0;
                        document.getElementById('totalProductos').textContent = data.productos || 0;
                        document.getElementById('totalCategorias').textContent = data.categorias || 0;
                        document.getElementById('totalPedidos').textContent = data.pedidos || 0;
                    }
                })
                .catch(error => {
                    console.error('Error al actualizar estadísticas:', error);
                });
        }

        // Solo ejecutar actualizarEstadisticas cuando el DOM esté listo
        document.addEventListener('DOMContentLoaded', actualizarEstadisticas);
    </script>
</body>
</html> 