<?php

use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\Base;

 include_once 'Views/Template_Principal/header.php'; ?>

<!-- Start Banner Hero -->
<div id="template-mo-zay-hero-carousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <div class="container">
                <div class="row p-5">
                    <div class="mx-auto col-md-8 col-lg-6 order-lg-last">
                        <img class="img-fluid" src="<?php echo BASE_URL; ?>assets/img/banner_img_01.jpg" alt="">
                    </div>
                    <div class="col-lg-6 mb-0 d-flex align-items-center">
                        <div class="text-align-left align-self-center">
                            <h1 class="h1 text-success"><b>Tienda</b> Online</h1>
                            <h3 class="h2">Los mejores productos para ti</h3>
                            <p>
                                Descubre nuestra amplia selección de productos de alta calidad. 
                                Ofertas especiales y envíos a todo el país.
                            </p>
                            <a href="<?php echo BASE_URL; ?>principal/shop" class="btn btn-success">Comprar Ahora</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="carousel-item">
            <div class="container">
                <div class="row p-5">
                    <div class="mx-auto col-md-8 col-lg-6 order-lg-last">
                        <img class="img-fluid" src="<?php echo BASE_URL; ?>assets/img/banner_img_02.jpg" alt="">
                    </div>
                    <div class="col-lg-6 mb-0 d-flex align-items-center">
                        <div class="text-align-left">
                            <h1 class="h1">Ofertas Especiales</h1>
                            <h3 class="h2">Hasta 50% de descuento</h3>
                            <p>
                                Aprovecha nuestras ofertas especiales en productos seleccionados.
                                ¡No te pierdas estas increíbles promociones!
                            </p>
                            <a href="<?php echo BASE_URL; ?>principal/shop" class="btn btn-success">Ver Ofertas</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="carousel-item">
            <div class="container">
                <div class="row p-5">
                    <div class="mx-auto col-md-8 col-lg-6 order-lg-last">
                        <img class="img-fluid" src="<?php echo BASE_URL; ?>assets/img/banner_img_03.jpg" alt="">
                    </div>
                    <div class="col-lg-6 mb-0 d-flex align-items-center">
                        <div class="text-align-left">
                            <h1 class="h1">Nuevos Productos</h1>
                            <h3 class="h2">Colección 2024</h3>
                            <p>
                                Descubre las últimas novedades en nuestra tienda.
                                Productos exclusivos y de alta calidad.
                            </p>
                            <a href="<?php echo BASE_URL; ?>principal/shop" class="btn btn-success">Ver Novedades</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Nuevos controles del carrusel - solo flechas -->
    <button class="carousel-control-prev custom-carousel-control" type="button" data-bs-target="#template-mo-zay-hero-carousel" data-bs-slide="prev">
        <i class="fas fa-angle-left"></i>
    </button>
    <button class="carousel-control-next custom-carousel-control" type="button" data-bs-target="#template-mo-zay-hero-carousel" data-bs-slide="next">
        <i class="fas fa-angle-right"></i>
    </button>
</div>

<style>
/* Estilos actualizados */
.carousel-item {
    background-color: #efefef;  /* Nuevo color de fondo */
}

.carousel-item img {
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
}

.carousel-item img:hover {
    transform: scale(1.02);
}

/* Nuevos estilos para los botones de control - solo flechas */
.custom-carousel-control {
    width: auto;
    background: none;
    border: none;
    opacity: 0.7;
    transition: all 0.3s ease;
}

.custom-carousel-control i {
    color: #333;
    font-size: 40px;
    text-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.custom-carousel-control:hover {
    opacity: 1;
    background: none;
}

.custom-carousel-control:hover i {
    color: #4CAF50;
}

.carousel-control-prev {
    left: 15px;
}

.carousel-control-next {
    right: 15px;
}

.btn-success {
    padding: 10px 30px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-success:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(76, 175, 80, 0.3);
}

.h1 {
    font-weight: 700;
    color: #2c3e50;
}

.h2 {
    color: #4CAF50;
}

.carousel-item p {
    color: #666;
    font-size: 1.1rem;
    line-height: 1.6;
}

/* Animación para los botones */
@keyframes pulse {
    0% { transform: translateY(-50%) scale(1); }
    50% { transform: translateY(-50%) scale(1.05); }
    100% { transform: translateY(-50%) scale(1); }
}

.custom-carousel-control:hover {
    animation: pulse 1s infinite;
}
</style>

<!-- Start Categories -->
<section class="container py-5">
    <div class="row text-center pt-3">
        <div class="col-lg-6 m-auto">
            <h1 class="h1">Categorías</h1>
            <p>
                Explora nuestras categorías principales
            </p>
        </div>
    </div>
    <div class="row">
        <?php foreach ($data['categorias'] as $categoria) { ?>
            <div class="col-12 col-md-4 p-5 mt-3">
                <a href="<?php echo BASE_URL . 'shop/categoria/' . $categoria['id']; ?>">
                    <img src="<?php echo BASE_URL . 'assets/img/categorias/' . $categoria['imagen']; ?>" 
                         class="rounded-circle img-fluid border">
                </a>
                <h5 class="text-center mt-3 mb-3"><?php echo $categoria['nombre']; ?></h5>
                <p class="text-center">
                    <a href="<?php echo BASE_URL . 'shop/categoria/' . $categoria['id']; ?>" 
                       class="btn btn-success">Ver Productos</a>
                </p>
            </div>
        <?php } ?>
    </div>
</section>
<!-- End Categories -->

<!-- Start Featured Product -->
<section class="bg-light">
    <div class="container py-5">
        <div class="row text-center py-3">
            <div class="col-lg-6 m-auto">
                <h1 class="h1">Productos Destacados</h1>
                <p>
                    Los productos más populares de nuestra tienda
                </p>
            </div>
        </div>
        <div class="row">
            <?php 
            if (!empty($data['productos_destacados'])) {
                foreach ($data['productos_destacados'] as $producto) { 
                    ?>
                    <div class="col-12 col-md-4 mb-4">
                        <div class="card h-100">
                            <a href="<?php echo BASE_URL . 'shop/producto/' . $producto['id']; ?>">
                                <img src="<?php echo BASE_URL . 'assets/img/productos/' . $producto['imagen']; ?>" 
                                     class="card-img-top" alt="<?php echo $producto['nombre']; ?>">
                            </a>
                            <div class="card-body">
                                <ul class="list-unstyled d-flex justify-content-between">
                                    <li class="text-muted text-right">$<?php echo number_format($producto['precio'], 2); ?></li>
                                </ul>
                                <a href="<?php echo BASE_URL . 'shop/producto/' . $producto['id']; ?>" 
                                   class="h2 text-decoration-none text-dark"><?php echo $producto['nombre']; ?></a>
                                <p class="card-text">
                                    <?php echo substr($producto['descripcion'], 0, 100) . '...'; ?>
                                </p>
                                <button class="btn btn-success" 
                                        onclick="agregarCarrito(<?php echo $producto['id']; ?>)">
                                    Agregar al Carrito
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo '<div class="col-12 text-center">No hay productos destacados disponibles</div>';
            }
            ?>
        </div>
    </div>
</section>
<!-- End Featured Product -->

<?php include_once 'Views/Template_Principal/footer.php'; ?> 