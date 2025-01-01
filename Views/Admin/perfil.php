<?php include_once 'Views/template/header-admin.php'; ?>

<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">Mi Perfil</h5>
            </div>
            <div class="card-body">
                <form id="formPerfil" autocomplete="off">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nombre">Nombre <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nombre" name="nombre" 
                                value="<?php echo $data['usuario']['nombre']; ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="correo">Correo <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="correo" name="correo" 
                                value="<?php echo $data['usuario']['correo']; ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="rol">Rol</label>
                            <input type="text" class="form-control" value="<?php echo $data['usuario']['rol']; ?>" 
                                readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="ultimo_login">Último acceso</label>
                            <input type="text" class="form-control" 
                                value="<?php echo $data['usuario']['ultimo_login']; ?>" readonly>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="clave">Nueva Contraseña</label>
                            <input type="password" class="form-control" id="clave" name="clave" 
                                placeholder="Dejar en blanco para mantener la actual">
                            <small class="text-muted">Mínimo 6 caracteres</small>
                        </div>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary" id="btnActualizar">
                            <i class="fas fa-save"></i> Actualizar Datos
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include_once 'Views/template/footer-admin.php'; ?>

<script src="<?php echo BASE_URL; ?>assets/js/modulos/perfil.js"></script> 