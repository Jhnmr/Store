    <!-- Start Footer -->
    <footer class="bg-dark" id="tempaltemo_footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4 pt-5">
                    <h2 class="h2 text-success border-bottom pb-3 border-light logo"><?php echo TITLE; ?></h2>
                    <ul class="list-unstyled text-light footer-link-list">
                        <li>
                            <i class="fas fa-map-marker-alt fa-fw"></i>
                            <?php echo DIRECCION; ?>
                        </li>
                        <li>
                            <i class="fa fa-phone fa-fw"></i>
                            <a class="text-decoration-none text-light" href="tel:<?php echo TELEFONO; ?>"><?php echo TELEFONO; ?></a>
                        </li>
                        <li>
                            <i class="fa fa-envelope fa-fw"></i>
                            <a class="text-decoration-none text-light" href="mailto:<?php echo EMAIL; ?>"><?php echo EMAIL; ?></a>
                        </li>
                    </ul>
                </div>

                <div class="col-md-4 pt-5">
                    <h2 class="h2 text-light border-bottom pb-3 border-light">Productos</h2>
                    <ul class="list-unstyled text-light footer-link-list">
                        <li><a class="text-decoration-none text-light" href="<?php echo BASE_URL; ?>Principal/shop">Luxury</a></li>
                        <li><a class="text-decoration-none text-light" href="<?php echo BASE_URL; ?>Principal/shop">Sport Wear</a></li>
                        <li><a class="text-decoration-none text-light" href="<?php echo BASE_URL; ?>Principal/shop">Men's Shoes</a></li>
                        <li><a class="text-decoration-none text-light" href="<?php echo BASE_URL; ?>Principal/shop">Women's Shoes</a></li>
                        <li><a class="text-decoration-none text-light" href="<?php echo BASE_URL; ?>Principal/shop">Popular Dress</a></li>
                        <li><a class="text-decoration-none text-light" href="<?php echo BASE_URL; ?>Principal/shop">Gym Accessories</a></li>
                        <li><a class="text-decoration-none text-light" href="<?php echo BASE_URL; ?>Principal/shop">Sport Shoes</a></li>
                    </ul>
                </div>

                <div class="col-md-4 pt-5">
                    <h2 class="h2 text-light border-bottom pb-3 border-light">Enlaces Rápidos</h2>
                    <ul class="list-unstyled text-light footer-link-list">
                        <li><a class="text-decoration-none text-light" href="<?php echo BASE_URL; ?>">Inicio</a></li>
                        <li><a class="text-decoration-none text-light" href="<?php echo BASE_URL; ?>Principal/about">Nosotros</a></li>
                        <li><a class="text-decoration-none text-light" href="<?php echo BASE_URL; ?>Principal/shop">Tienda</a></li>
                        <li><a class="text-decoration-none text-light" href="<?php echo BASE_URL; ?>Principal/contact">Contacto</a></li>
                    </ul>
                </div>
            </div>

            <div class="row text-light mb-4">
                <div class="col-12 mb-3">
                    <div class="w-100 my-3 border-top border-light"></div>
                </div>
                <div class="col-auto me-auto">
                    <ul class="list-inline text-left footer-icons">
                        <?php if(!empty(FACEBOOK)): ?>
                        <li class="list-inline-item border border-light rounded-circle text-center">
                            <a class="text-light text-decoration-none" target="_blank" href="<?php echo FACEBOOK; ?>">
                                <i class="fab fa-facebook-f fa-lg fa-fw"></i>
                            </a>
                        </li>
                        <?php endif; ?>
                        <?php if(!empty(INSTAGRAM)): ?>
                        <li class="list-inline-item border border-light rounded-circle text-center">
                            <a class="text-light text-decoration-none" target="_blank" href="<?php echo INSTAGRAM; ?>">
                                <i class="fab fa-instagram fa-lg fa-fw"></i>
                            </a>
                        </li>
                        <?php endif; ?>
                        <?php if(!empty(TWITTER)): ?>
                        <li class="list-inline-item border border-light rounded-circle text-center">
                            <a class="text-light text-decoration-none" target="_blank" href="<?php echo TWITTER; ?>">
                                <i class="fa-brands fa-x-twitter fa-lg fa-fw"></i>
                            </a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>
                <div class="col-auto">
                    <form id="subscribeForm" method="post" class="subscribe-form">
                        <label class="sr-only" for="subscribeEmail">Email</label>
                        <div class="input-group mb-2">
                            <input type="email" class="form-control bg-dark border-light" 
                                   id="subscribeEmail" name="email" 
                                   placeholder="Email" required>
                            <button type="submit" class="input-group-text btn-success text-light">
                                Suscribirse
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="w-100 bg-black py-3">
            <div class="container">
                <div class="row pt-2">
                    <div class="col-12">
                        <p class="text-left text-light">
                            Copyright &copy; <?php echo date('Y'); ?> <?php echo TITLE; ?> | 
                            Todos los derechos reservados
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- End Footer -->

    <!-- Start Script -->
    <script src="<?php echo BASE_URL; ?>assets/js/jquery-1.11.0.min.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/js/jquery-migrate-1.2.1.min.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/js/templatemo.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/js/custom.js"></script>
    <!-- End Script -->
</body>
</html>