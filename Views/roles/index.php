<?php include_once 'Views/template/header-admin.php'; ?>

<div class="card">
    <div class="card-body">
        <div class="d-flex align-items-center mb-4">
            <h4 class="card-title">Gestión de Roles</h4>
            <button class="btn btn-primary btn-sm ms-auto" type="button" onclick="abrirModal()">
                <i class="fas fa-plus"></i> Nuevo
            </button>
        </div>
        
        <div class="table-responsive">
            <table class="table table-striped table-hover" id="tblRoles">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['roles'] as $rol) { ?>
                        <tr>
                            <td><?php echo $rol['id']; ?></td>
                            <td><?php echo $rol['nombre']; ?></td>
                            <td>
                                <?php if ($rol['id'] > 2) { ?>
                                    <button class="btn btn-danger btn-sm" type="button" 
                                            onclick="eliminarRol(<?php echo $rol['id']; ?>)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Rol -->
<div class="modal fade" id="modalRol" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nuevo Rol</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="frmRol">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nombre">Nombre del Rol</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Registrar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include_once 'Views/template/footer-admin.php'; ?>

<script src="<?php echo BASE_URL; ?>assets/js/modulos/roles.js"></script> 