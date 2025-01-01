<?php include_once 'Views/Template_Principal/header.php'; ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">
                    <h4>Crear Cuenta</h4>
                </div>
                <div class="card-body">
                    <form id="frmRegistro">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nombre">Nombre</label>
                                <input type="text" name="nombre" id="nombre" class="form-control" 
                                       pattern="[A-Za-zÁÉÍÓÚáéíóúñÑ\s]{3,}" 
                                       title="Solo letras, mínimo 3 caracteres"
                                       required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="apellidos">Apellidos</label>
                                <input type="text" name="apellidos" id="apellidos" class="form-control" 
                                       pattern="[A-Za-zÁÉÍÓÚáéíóúñÑ\s]{3,}"
                                       title="Solo letras, mínimo 3 caracteres"
                                       required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="correo">Correo Electrónico</label>
                            <input type="email" name="correo" id="correo" class="form-control" 
                                   title="Ingrese un correo válido"
                                   required>
                            <div class="invalid-feedback">
                                Por favor ingrese un correo válido
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="clave">Contraseña</label>
                            <div class="input-group">
                                <input type="password" name="clave" id="clave" class="form-control" 
                                       pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$"
                                       title="Mínimo 8 caracteres, al menos una letra y un número"
                                       required>
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <small class="text-muted">
                                La contraseña debe tener al menos 8 caracteres, una letra y un número
                            </small>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary" id="btnRegistro">
                                Crear Cuenta
                            </button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center">
                    ¿Ya tienes cuenta? <a href="<?php echo BASE_URL; ?>auth">Iniciar Sesión</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Al inicio del archivo, después del header -->
<script>
    const BASE_URL = '<?php echo BASE_URL; ?>';
</script>

<!-- Luego carga los demás scripts -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?php echo BASE_URL; ?>assets/js/modulos/registro.js"></script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script> 
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<!-- El resto de tu código HTML -->
<!--<//?php include_once 'Views/Template_Principal/footer.php'; ?>--> 