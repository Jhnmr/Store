<?php include_once 'Views/template/header-admin.php'; ?>

<div class="card">
    <div class="card-body">
        <div class="d-flex align-items-center">
            <div>
                <h4 class="card-title mb-0">Lista de Pedidos</h4>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h5 class="card-title">Pedidos Completados</h5>
                        <h3 id="totalCompletados">0</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <h5 class="card-title">Pedidos Pendientes</h5>
                        <h3 id="totalPendientes">0</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <h5 class="card-title">Total Pedidos</h5>
                        <h3 id="totalPedidos">0</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-between mb-3">
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-outline-primary" onclick="filtrarPedidos('todos')">Todos</button>
                <button type="button" class="btn btn-outline-success" onclick="filtrarPedidos('completados')">Completados</button>
                <button type="button" class="btn btn-outline-warning" onclick="filtrarPedidos('pendientes')">Pendientes</button>
            </div>
            <div>
                <button class="btn btn-success" onclick="exportarExcel()">
                    <i class="fas fa-file-excel"></i> Exportar Excel
                </button>
                <button class="btn btn-danger" onclick="exportarPDF()">
                    <i class="fas fa-file-pdf"></i> Exportar PDF
                </button>
            </div>
        </div>
        <div class="table-responsive mt-4">
            <table class="table table-hover" id="tablaPedidos">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cliente</th>
                        <th>Total</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['pedidos'] as $pedido) { ?>
                        <tr>
                            <td><?php echo $pedido['id']; ?></td>
                            <td><?php echo $pedido['cliente']; ?></td>
                            <td>$<?php echo number_format($pedido['total'], 2); ?></td>
                            <td><?php echo $pedido['fecha']; ?></td>
                            <td>
                                <span class="badge bg-<?php echo $pedido['estado'] == 1 ? 'success' : 'warning'; ?>">
                                    <?php echo $pedido['estado'] == 1 ? 'Completado' : 'Pendiente'; ?>
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-info btn-sm" onclick="verPedido(<?php echo $pedido['id']; ?>)">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-warning btn-sm" onclick="cambiarEstado(<?php echo $pedido['id']; ?>)">
                                    <i class="fas fa-sync-alt"></i>
                                </button>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Detalle Pedido -->
<div class="modal fade" id="modalDetalle" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">Detalle del Pedido</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover" id="tablaDetalle">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Cantidad</th>
                                        <th>Precio</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-end"><strong>Total:</strong></td>
                                        <td id="totalPedido"></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<?php include_once 'Views/template/footer-admin.php'; ?>

<script src="<?php echo BASE_URL; ?>assets/js/modulos/pedidos.js"></script> 