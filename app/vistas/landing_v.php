<main>
    <div class="row">
        <div class="col-12 text-center">
            <h1 class="display-2">ELECTROAGORA</h1>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">
            <div id="carouselOfertas" class="carousel carousel-dark slide">
                <div class="carousel-indicators">
                    <? foreach ($articulos as $clave => $arti) :
                        $activo = "";
                        if ($clave == 0) {
                            $activo = "active";
                        }
                    ?>
                        <button type="button" data-bs-target="#carouselOfertas" data-bs-slide-to="<?= $clave; ?>" class="<?= $activo; ?>" aria-current="true" aria-label="Slide 1"></button>
                    <? endforeach; ?>
                </div>
                <div class="carousel-inner">
                    <? foreach ($articulos as $clave => $arti) :
                        $activo = "";
                        if ($clave == 0) {
                            $activo = "active";
                        }
                    ?>
                        <div class="carousel-item <?= $activo; ?>" data-bs-interval="2000">
                            <img src="<?= BASE_URL . $arti['camino']; ?>" class="d-block w-100" alt="<?= $arti['descripCorta']; ?>">
                            <div class="carousel-caption d-none d-md-block">
                                <h5>Precio Oferta: <?= $arti['precioVenta']; ?></h5>
                                <p><?= $arti['descripCorta']; ?></p>
                            </div>
                        </div>
                    <? endforeach; ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselOfertas" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Anterior</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselOfertas" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Siguiente</span>
                </button>
            </div> <!-- Fin Carousel -->
        </div> <!-- Fin columna -->
    </div> <!-- Fin Fila -->
    <div class="row justify-content-center">
        <div class="col-8 col-md-6 col-lg-5 text-center">
            <div class="d-grid gap-2">
                <a href="<?= BASE_URL; ?>articulos_c/catalogo" class="btn btn-primary">Entra y compara precios</a>
            </div>
        </div>
    </div>
</main>