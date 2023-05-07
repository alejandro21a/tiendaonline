<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="<?= BASE_URL; ?>app/assets/libs/bootstrap/css/bootstrap.min.css" />
    <script src="<?= BASE_URL; ?>app/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= BASE_URL; ?>app/assets/libs/jquery-3.6.3.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.1/dist/sweetalert2.all.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.1/dist/sweetalert2.min.css" rel="stylesheet">
    <title>Tienda Online</title>
</head>

<body>
    <script>
        const base_url = '<?= BASE_URL; ?>'
    </script>
    <div id="wrapper" class="container">
        <header class="row align-items-center text-center">
            <div id="logo" class="col-lg-2">
                <a href="<?= BASE_URL; ?>/inicio_c/index"><img class="img-fluid" width="100" src="<?= BASE_URL; ?>app/assets/img/logoElectro.jpg" alt="" /></a>
            </div>
            <div id="brand" class="col-lg-6">
                <h1 class="display-3">ELECTROAGORA</h1>
            </div>
            <div id="interaccion" class="col-lg-4">
                <div class="row align-items-center">
                    <div class="col-lg-4">
                        <a href="<?= BASE_URL; ?>carrito_c/index" class="btn position-relative">
                            <img class="img-fluid" width="70" src="<?= BASE_URL; ?>app/assets/img/carrito.png" alt="" />
                            <span id="cartCant" class="position-absolute top-50 start-80 translate-middle badge rounded-pill bg-danger">0
                            </span>
                        </a>
                    </div>
                    <?php if (isset($_SESSION['sesion'])) {
                        $textoBoton = "Logout";
                        $metodoBoton = "logout";
                        $nombre = "Bienvenido " . $_SESSION['sesion']['usuario'];
                    } else {
                        $textoBoton = "Login";
                        $metodoBoton = "login";
                        $nombre = "";
                    }
                    ?>
                    <div class="col-lg-5">
                        <a href="<?= BASE_URL; ?>usuarios_c/<?= $metodoBoton; ?>" class="btn btn-primary"><?= $textoBoton; ?></a>
                        <span> <?= $nombre; ?></span>
                    </div>
                    <?php if (isset($_SESSION['sesion'])) : ?>
                        <div class="col-lg-3">
                            <a href="<?= BASE_URL; ?>usuarios_c/perfil" class="btn btn-primary">Perfil</a>
                        </div>
                    <?php else : ?>
                        <div class="col-lg-3">
                            <a href="<?= BASE_URL; ?>usuarios_c/registro" class="btn btn-primary">Registro</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </header>