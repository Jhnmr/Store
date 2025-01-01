<?php include_once 'Views/Template_Principal/header.php'; ?>

<!-- Start Contact -->
<div class="container py-5">
    <!-- Encabezado -->
    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold">Contáctanos</h1>
        <p class="lead text-muted">Estamos aquí para ayudarte</p>
    </div>

    <div class="row">
        <!-- Información de Contacto -->
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h3 class="h5 mb-4">Información de Contacto</h3>
                    <div class="d-flex mb-3">
                        <div class="flex-shrink-0">
                            <i class="fas fa-map-marker-alt text-primary fa-2x me-3"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1">Dirección</h6>
                            <p class="mb-0">123 Calle Principal, Ciudad</p>
                        </div>
                    </div>
                    <div class="d-flex mb-3">
                        <div class="flex-shrink-0">
                            <i class="fas fa-phone-alt text-primary fa-2x me-3"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1">Teléfono</h6>
                            <p class="mb-0">+1234567890</p>
                        </div>
                    </div>
                    <div class="d-flex mb-3">
                        <div class="flex-shrink-0">
                            <i class="fas fa-envelope text-primary fa-2x me-3"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1">Email</h6>
                            <p class="mb-0">info@tutienda.com</p>
                        </div>
                    </div>
                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-clock text-primary fa-2x me-3"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1">Horario</h6>
                            <p class="mb-0">Lun - Vie: 9:00 AM - 6:00 PM</p>
                            <p class="mb-0">Sáb: 9:00 AM - 1:00 PM</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Formulario de Contacto -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form id="contactForm" method="post" class="needs-validation" novalidate>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                                <div class="invalid-feedback">
                                    Por favor ingresa tu nombre
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                                <div class="invalid-feedback">
                                    Por favor ingresa un email válido
                                </div>
                            </div>
                            <div class="col-12">
                                <label for="asunto" class="form-label">Asunto</label>
                                <input type="text" class="form-control" id="asunto" name="asunto" required>
                                <div class="invalid-feedback">
                                    Por favor ingresa el asunto
                                </div>
                            </div>
                            <div class="col-12">
                                <label for="mensaje" class="form-label">Mensaje</label>
                                <textarea class="form-control" id="mensaje" name="mensaje" rows="5" required></textarea>
                                <div class="invalid-feedback">
                                    Por favor ingresa tu mensaje
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-lg w-100">
                                    Enviar Mensaje
                                    <i class="fas fa-paper-plane ms-2"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Mapa Estático -->
    <div class="mt-5">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="ratio ratio-16x9">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3976.8539627517207!2d-74.07370548573423!3d4.627275243504327!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e3f9a2e545a44b1%3A0x4b65c17d4a4938f4!2sCentro%20Comercial%20Gran%20Estaci%C3%B3n!5e0!3m2!1ses!2sco!4v1625178241234!5m2!1ses!2sco"
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Estilos adicionales -->
<style>
    .card {
        transition: transform 0.3s ease;
    }
    .card:hover {
        transform: translateY(-5px);
    }
    .text-primary {
        color: #4CAF50 !important;
    }
    .btn-primary {
        background-color: #4CAF50;
        border-color: #4CAF50;
    }
    .btn-primary:hover {
        background-color: #45a049;
        border-color: #45a049;
    }
    .form-control:focus {
        border-color: #4CAF50;
        box-shadow: 0 0 0 0.25rem rgba(76, 175, 80, 0.25);
    }
</style>

<script>
    // Validación del formulario
    document.getElementById('contactForm').addEventListener('submit', function(event) {
        if (!this.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }
        this.classList.add('was-validated');
    });
</script>

<?php include_once 'Views/Template_Principal/footer.php'; ?>

</body>

</html>