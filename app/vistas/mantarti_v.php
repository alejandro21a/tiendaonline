<main>
    <div class="row mt-3">

        <div class="col-lg-4">
            <h3>Mantenimiento de Artículos</h3>
        </div>

        <div class="col-lg-2">
            <div class="d-grid gap-2">
                <button data-bs-toggle="modal" data-bs-target="#articulosModal" type="button" id="btnNuevo" class="btn btn-success">Nuevo</button>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="input-group mb-3">
                <input id="textoBuscado" type="search" class="form-control" placeholder="Buscar por..." aria-label="filtro de busqueda" aria-describedby="btnBuscar" value="<?= isset($buscado) ? $buscado : "" ?>">
                <button class="btn btn-outline-secondary" type="button" id="btnBuscar">Buscar</button>
            </div>
        </div>

        <?php if (!empty($_SESSION['mensajes'])) : ?>
            <div class="row" id="mensajes">

                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php foreach ($_SESSION['mensajes'] as $mensaje) : ?>
                        <strong>Error al insertar!</strong> <?php echo $mensaje ?>
                    <?php endforeach;
                    unset($_SESSION['mensajes']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>

                </div>

            </div>
        <?php endif; ?>
        <div class="row">
      
            <table class="table table-sm table-striped">
                <thead>
                    <th>Referencia</th>
                    <th>Descripción</th>
                    <th>Familia</th>
                    <th>Imagen</th>
                    <th class="text-end">Stock</th>
                    <th class="text-center">Cmd</th>
                </thead>
                <tbody>
                    <?php
                    if (count($articulos) > 0) {
                        foreach ($articulos as $arti) {
                    ?>
                            <tr style="vertical-align:middle">
                                <td><?= $arti['referencia'] ?></td>
                                <td><?= $arti['descripCorta'] ?></td>
                                <td><?= $arti['descfam'] ?></td>
                                <td><img class="img-fluid" width="60" src="<?= BASE_URL . $arti['camino']; ?>" alt=""></td>
                                <td class="text-end"><?= $arti['stock'] ?></td>
                                <td class="text-center">
                                    <button class="btn btnModificar"><i class="bi bi-pencil-square"></i></button>
                                    <button class="btn btnBorrar"><i class="bi bi-trash3-fill"></i></button>
                                </td>
                            </tr>

                    <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
            <div class="col-8 mx-auto">
                <?= $paginas; ?>
            </div>
        </div>

        <!-- Modal para alta y modificación de artículos-->
        <div class="modal fade" id="articulosModal" tabindex="-1" aria-labelledby="Alta y modificación de artículos" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="tituloArticulosModal">Alta artículos</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <form name="formArticulos" action="<?= BASE_URL; ?>Articulos_c/insertar" method="post" enctype="multipart/form-data">

                            <div class="row mb-3">
                                <label for="referencia" class="col-sm-2 col-form-label">Referencia</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="referencia" maxlength="20" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="descripCorta" class="col-sm-2 col-form-label">Descripción Corta</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="descripCorta" rows="2" cols="30" required></textarea>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="descripLarga" class="col-sm-2 col-form-label">Características</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="descripLarga" rows="4" cols="30" required></textarea>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="precioCoste" class="col-sm-2 col-form-label">Precio Coste</label>
                                <div class="col-sm-2">
                                    <input type="number" class="form-control" name="precioCoste" maxlength="20" min="0" step="0.1" required>
                                </div>

                                <label for="precioVenta" class="col-sm-2 col-form-label">Precio Venta</label>
                                <div class="col-sm-2">
                                    <input type="number" class="form-control" name="precioVenta" maxlength="20" min="0" step="0.1" required>
                                </div>

                                <label for="familia" class="col-sm-1 col-form-label">Familia</label>
                                <div class="col-sm-3">
                                    <select class="form-control" name="familia">
                                        <?php
                                        foreach ($familias as $fami) :
                                        ?>
                                            <option value="<?= $fami['id']; ?>"><?= $fami['descripcion']; ?></option>
                                        <?php endforeach; ?>

                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">


                                <label for="porceniva" class="col-sm-2 col-form-label">%IVA</label>
                                <div class="col-sm-2">
                                    <input type="number" class="form-control" name="porceniva" maxlength="20" min="0" step="0.1" required>
                                </div>

                                <label for="stock" class="col-sm-2 col-form-label">Stock</label>
                                <div class="col-sm-2">
                                    <input type="number" class="form-control" name="stock" maxlength="20" min="0" required>
                                </div>

                                <label for="oferta" class="col-sm-1 col-check-label">Oferta</label>
                                <div class="col-sm-3">
                                    <input type="hidden" name="oferta" value="0">
                                    <input type="checkbox" id="oferta" class="form-check-input" name="oferta" value="1">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="imagenes" class="col-sm-2 col-form-label">Imágenes</label>
                                <div class="col-sm-10">
                                    <input type="file" name="imagenes[]" multiple class="form-control">
                                </div>
                            </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-success">Guardar</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
</main>

<script src="<?= BASE_URL ?>app/vistas/js/mantarti.js"></script>