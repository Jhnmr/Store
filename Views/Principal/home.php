<?php include_once 'Views/Template_Principal/header.php'; ?>

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
                            <h1 class="h1">Bienvenido a nuestra Tienda</h1>
                            <p>
                                Encuentra los mejores productos al mejor precio.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Banner Hero -->

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
        <!-- Aquí irán las categorías dinámicas -->
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
            <!-- Aquí irán los productos destacados -->
        </div>
    </div>
</section>
<!-- End Featured Product -->

<?php include_once 'Views/Template_Principal/footer.php'; ?> 