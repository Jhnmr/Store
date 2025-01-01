<?php include_once 'Views/template/header-admin.php'; ?>

<body>


    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h3 class="m-0">Categorias</h3>
                <button class="btn btn-light" type="button" onclick="modalCategoria()">
                    <i class="fas fa-plus"></i> Nueva Categoría
                </button>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover align-middle m-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th class="d-none d-md-table-cell">Descripción</th>
                                <th>Imagen</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['categorias'] as $categoria) { ?>
                                <tr>
                                    <td><?php echo $categoria['id']; ?></td>
                                    <td><?php echo $categoria['nombre']; ?></td>
                                    <td class="d-none d-md-table-cell description-cell" title="<?php echo $categoria['descripcion']; ?>">
                                        <?php echo $categoria['descripcion']; ?>
                                    </td>
                                    <td>
                                        <?php if (!empty($categoria['imagen'])) { ?>
                                            <img src="<?php echo BASE_URL . 'assets/img/categorias/' . $categoria['imagen']; ?>" 
                                                alt="<?php echo $categoria['nombre']; ?>" 
                                                class="img-thumbnail">
                                        <?php } ?>
                                    </td>
                                    <td class="action-buttons">
                                        <button class="btn btn-primary btn-sm" type="button" 
                                                onclick="editarCategoria(<?php echo $categoria['id']; ?>)"
                                                title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm" type="button" 
                                                onclick="eliminarCategoria(<?php echo $categoria['id']; ?>)"
                                                title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Categoría -->
    <div id="modalCategoria" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalTitle">Nueva Categoría</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formCategoria" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="hidden" id="id" name="id">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="imagen" class="form-label">Imagen</label>
                            <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary" id="btnAccion">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>

    <script src="<?php echo BASE_URL; ?>assets/js/admin.js"></script>
</body>
</html> 