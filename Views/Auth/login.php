<?php include_once 'Views/Template_Principal/header.php'; ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">
                    <h4>Iniciar Sesión</h4>
                </div>
                <div class="card-body">
                    <form id="frmLogin">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="clave" class="form-label">Contraseña</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="clave" name="clave" required>
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <i class="fas fa-eye-slash"></i>
                                </button>
                            </div>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
                        </div>
                    </form>
                    <div class="mt-3 text-center">
                        <p>¿No tienes una cuenta? <a href="<?php echo BASE_URL; ?>auth/register">Regístrate</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<script>
    const BASE_URL = '<?php echo BASE_URL; ?>';
    
    // Toggle password visibility
    document.getElementById('togglePassword').addEventListener('click', function() {
        const passwordInput = document.getElementById('clave');
        const icon = this.querySelector('i');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        }
    });

    // Form submission
    $(document).ready(function() {
        $('#frmLogin').submit(function(e) {
            e.preventDefault();
            const email = $('#email').val();
            const clave = $('#clave').val();
            
            // Agregar indicador de carga
            Swal.fire({
                title: 'Cargando...',
                didOpen: () => {
                    Swal.showLoading()
                }
            });
            
            $.ajax({
                url: BASE_URL + 'auth/validar',
                type: 'POST',
                data: {
                    email: email,
                    clave: clave
                },
                success: function(response) {
                    try {
                        const res = JSON.parse(response);
                        if (res.icono == 'success') {
                            window.location = BASE_URL + 'admin';
                        } else {
                            Swal.fire({
                                icon: res.icono,
                                title: res.titulo,
                                text: res.mensaje
                            });
                        }
                    } catch (error) {
                        console.error('Error parsing response:', response);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Ocurrió un error en el proceso de inicio de sesión'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Ajax error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error de conexión con el servidor'
                    });
                }
            });
        });
    });
</script>