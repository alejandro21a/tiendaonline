<main>

    <div class="row mt-4">
        <div class="col-lg-6 mx-auto">
            <h3 class="text-center">ELIGE EL METODO DE PAGO</h3>
            <div class="d-grid gap-2">
                <button type="button" id="btnVisa" data-bs-target="#pagoModal" data-bs-toggle="modal" class="btn"><img class="img-fluid" width="100" src="<?= BASE_URL ?>app/assets/img/visa.png"></button>
            </div>

            <div class="d-grid gap-2">
                <button type="button" id="btnMasterCard" data-bs-target="#pagoModal" data-bs-toggle="modal" class="btn"><img class="img-fluid" width="100" src="<?= BASE_URL ?>app/assets/img/mastercard.png"></button>
            </div>

            <div class="text-center" id="btnPayPal">

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 mx-auto">
            <h3>El importe a pagar es <?= $importe; ?></h3>
        </div>
    </div>
</main>

<div class="modal fade" id="pagoModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pago por Tarjeta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="frmPagoTarjeta" action="#" method="post">

                    <div class="row mb-3">
                        <label for="nombre" class="col-sm-2 col-form-label">Nombre</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="nombre" maxlength="50" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="numero" class="col-sm-2 col-form-label">Número</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="numero" maxlength="16" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="cvv" class="col-sm-2 col-form-label">CVV</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" name="cvv" maxlength="50" required>
                        </div>

                        <label for="validez" class="col-sm-2 col-form-label">Validez</label>
                        <div class="col-sm-3">
                            <input type="datem" class="form-control" name="validez" maxlength="50" placeholder="02/23" pattern="[0-9]{2}/[0-9]{2}" required>
                        </div>


                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-success">Confirmar</button>
                    </div>


                </form>
            </div>



        </div>
    </div>
</div>

<script>
    $("#frmPagoTarjeta").on("submit", function(evento) {
        evento.preventDefault();

        location.href = base_url + "Pago_c/confirmacionPago/12345/Pepito";
    });
</script>