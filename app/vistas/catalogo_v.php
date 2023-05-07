<main>
    <div id="filtro" class="row d-flex my-2 border py-2">

        <label for="desdePrecio" class="col-lg-2 col-form-label">Desde Precio</label>
        <div class="col-lg-2">
            <input type="number" class="form-control" id="desdePrecio" value="0">
        </div>
        <label for="hastaPrecio" class="col-lg-2 col-form-label">Hasta Precio</label>
        <div class="col-lg-2">
            <input type="number" class="form-control" id="hastaPrecio" value="999999">
        </div>
        <div class="col-lg-3">
            <input type="search" class="form-control" id="busqueda" placeholder="Buscar">
        </div>
        <div class="col-lg-1">
            <button type="button" id="btnReset" class="btn btn-success">Reset</button>
        </div>
    </div>
    <div id="contenido" class="row">
        <div class="col-lg-2">
            <ul id="familias" class="list-group">
                <li data-id="" class="list-group-item active">TODAS</li>
                <? foreach ($familias as $fami) : ?>
                    <li data-id='<?= $fami['id']; ?>' class="list-group-item"><?= $fami['descripcion']; ?></li>
                <? endforeach; ?>
            </ul>
        </div>
        <div id="fichas" class="col-lg-10">

        </div>
    </div>
</main>
<script src="<?= BASE_URL; ?>app/vistas/js/catalogo.js"></script>