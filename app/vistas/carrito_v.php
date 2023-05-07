<?php
$fmt = new NumberFormatter('es_ES', NumberFormatter::CURRENCY);
?>
<style>
    table {
        table-layout: fixed;
    }
</style>
<main>
    <div class="row">
        <?php if (count($items) > 0) : ?>
            <div class="col-lg-10 mx-auto">
                <table class="table table-sm table-striped caption-top">
                    <thead>
                        <!-- <th>Referencia</th>
                    <th>Descripción</th>
                    <th>Imagen</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Importe</th>
                    <th>Acción</th> -->
                        <? $columnas = ['Referencia' => [20, "text-start"], 'Descripción' => [40, "text-start"], 'Imagen' => [10, "text-center"], 'Cant.' => [10, "text-end"], 'Precio' => [10, "text-end"], 'Importe' => [10, "text-end"], "Cmd" => [5, "text-center"]];
                        foreach ($columnas as $col => $ancho) : ?>
                            <th width="<? echo $ancho[0]; ?>%" class="<? echo $ancho[1]; ?>"><? echo $col; ?></th>
                        <? endforeach; ?>
                    </thead>
                    <tbody style="vertical-align:middle;">
                        <?php
                        $importeCarrito = 0;
                        foreach ($items as $item) :
                            $importeCarrito += $item['importe'];
                        ?>
                            <tr data-id="<?= $item['id']; ?>">
                                <td><?= $item['referencia']; ?></td>
                                <td><?= $item['descripCorta']; ?></td>
                                <td><img class="img-fluid" width="80" src="<?= BASE_URL . $item['camino']; ?>" alt=""></td>
                                <td><input style="width:90px;" class="form-control text-center cantidad" type="number" min="1" value="<?= $item['cantidad']; ?>"></td>
                                <td class="text-end"><?= $fmt->formatCurrency($item['precio'], "EUR"); ?></td>
                                <td class="text-end"><?= $fmt->formatCurrency($item['importe'], "EUR"); ?></td>
                                <td class="text-center"><button class="btnBorrar"><i class="bi bi-trash"></i></button></td>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td class="text-center fw-bold fs-5" colspan="5">Total Carrito</td>
                            <td class="text-right fw-bold fs-5"><?= $fmt->formatCurrency($importeCarrito, "EUR"); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="row justify-content-center my-3">
                <div class="col-lg-3">
                    <div class="d-grid">
                        <a href="<?= BASE_URL ?>Pago_c/index" id="btnComprar" class="btn btn-success">Efectuar Compra</a>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="d-grid">
                        <button type="button" id="btnVaciar" class="btn btn-warning">Vaciar Carrito</button>
                    </div>
                </div>
            </div>
        <?php else : ?>
            <div class="col-lg-8 mx-auto text-center my-5">
                <h3>El carrito está vacio</h3>
            </div>
        <?php endif; ?>
    </div>
</main>
<script src="<?= BASE_URL; ?>app/vistas/js/carrito.js"></script>