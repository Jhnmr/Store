<?php include_once 'Views/Template_Principal/header.php'; ?>

<!-- Start Content -->
<div class="container py-5">
    <div class="row">
        <!-- Sidebar con categorías -->
        <div class="col-lg-3">
            <h1 class="h2 pb-4">Categorías</h1>
            <ul class="list-unstyled">
                <?php foreach ($data['categorias'] as $categoria) { ?>
                    <li class="pb-3">
                        <a class="text-decoration-none text-dark" href="<?php echo BASE_URL . 'shop/categoria/' . $categoria['id']; ?>">
                            <?php echo $categoria['nombre']; ?>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </div>

        <!-- Productos -->
        <div class="col-lg-9">
            <div class="row">
                <?php 
                if (!empty($data['productos'])) {
                    foreach ($data['productos'] as $producto) { 
                ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <a href="<?php echo BASE_URL . 'shop/producto/' . $producto['id']; ?>">
                                <?php if (!empty($producto['imagen'])) { ?>
                                    <img src="<?php echo BASE_URL . 'assets/img/productos/' . $producto['imagen']; ?>" 
                                         class="card-img-top" alt="<?php echo $producto['nombre']; ?>">
                                <?php } else { ?>
                                    <img src="<?php echo BASE_URL . 'assets/img/productos/default.jpg'; ?>" 
                                         class="card-img-top" alt="<?php echo $producto['nombre']; ?>">
                                <?php } ?>
                            </a>
                            <div class="card-body">
                                <ul class="list-unstyled d-flex justify-content-between">
                                    <li class="text-muted text-right">$<?php echo number_format($producto['precio'], 2); ?></li>
                                </ul>
                                <a href="<?php echo BASE_URL . 'shop/producto/' . $producto['id']; ?>" 
                                   class="h2 text-decoration-none text-dark">
                                    <?php echo $producto['nombre']; ?>
                                </a>
                                <p class="card-text">
                                    <?php echo substr($producto['descripcion'], 0, 70) . '...'; ?>
                                </p>
                                <p class="text-muted">Categoría: <?php echo $producto['categoria']; ?></p>
                                
                                <?php if ($producto['stock'] > 0) { ?>
                                    <button class="btn btn-success" 
                                            onclick="agregarCarrito(<?php echo $producto['id']; ?>)">
                                        Agregar al Carrito
                                    </button>
                                <?php } else { ?>
                                    <button class="btn btn-secondary" disabled>
                                        Agotado
                                    </button>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php 
                    }
                } else {
                    echo '<div class="col-12"><p class="text-center">No hay productos disponibles</p></div>';
                }
                ?>
            </div>
        </div>
    </div>
</div>
<!-- End Content -->

<?php include_once 'Views/Template_Principal/footer.php'; ?>
</body>

</html>