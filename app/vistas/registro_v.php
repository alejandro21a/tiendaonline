<main>
    <div class="row mt-3">
        <div class="col-6 mx-auto">
            <form name="frmRegistro" action="<?= BASE_URL; ?>usuarios_c/insertar" method="post" novalidate>
                <fieldset>
                    <div class="form-floating mb-3">
                        <input type="text" name="apenom" id="apenom" class="form-control" autofocus required maxlength="50">
                        <label for="apenom">Apellidos y Nombre</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" name="direccion" id="direccion" class="form-control" required maxlength="50">
                        <label for="direccion">Dirección</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" name="poblacion" id="poblacion" class="form-control" required maxlength="25">
                        <label for="poblacion">Población</label>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-6">
                            <div class="form-floating">
                                <input type="text" name="codpostal" id="codpostal" class="form-control" required maxlength="5">
                                <label for="codpostal">C.Postal</label>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-floating">
                                <input type="text" name="provincia" id="provincia" class="form-control" required maxlength="15">
                                <label for="provincia">Provincia</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-6">
                            <div class="form-floating">
                                <input type="text" name="dni" id="dni" class="form-control" required maxlength="9">
                                <label for="dni">Dni</label>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-floating">
                                <input type="email" name="email" id="email" class="form-control" required maxlength="50">
                                <label for="email">Email</label>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-lg-6">
                            <div class="form-floating">
                                <input type="text" name="usuario" id="usuario" class="form-control" required maxlength="20">
                                <label for="usuario">Usuario</label>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-floating input-group">
                                <input type="password" name="password" id="password" class="form-control" required maxlength="20">
                                <button type="button" id="btnVerPass" class="input-group-text">Ver</button>
                                <label for="password">Password</label>
                            </div>
                        </div>
                    </div>
                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-primary">Enviar</button>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</main>
<script>
    // Producir validacion
    $(document.frmRegistro).on("submit", function(evento) {
        evento.preventDefault();
        // Ver validación
        if (!this.checkValidity()) {
            this.classList.add("was-validated");
        } else {
            if ($(".no-valido").length == 0) this.submit();
        }
    });
    // Ver password
    $("#btnVerPass").on("click", function(evento) {
        if ($(document.frmRegistro.password).attr("type") == "password") {
            $(document.frmRegistro.password).attr("type", "text");
        } else {
            $(document.frmRegistro.password).attr("type", "password");
        }
    })
    // Verificar no existencia de usuario y email
    $(document.frmRegistro.usuario).on("blur", function(evento) {
        if (this.value.length > 0) {
            comprobarUsuEmail("usuario", this.value);
        }
    })
    $(document.frmRegistro.email).on("blur", function(evento) {
        if (this.value.length > 0) {
            comprobarUsuEmail("email", this.value);
        }
    })

    function comprobarUsuEmail(campo, valor) {
        let datos = new Object();
        datos[campo] = valor;
        $.post(base_url + "usuarios_c/existeUsuario", datos, function(dev) {
            if (dev == '1') {
                //alert(campo + " ya existe");
                document.frmRegistro[campo].classList.add("is-invalid");
                document.frmRegistro[campo].classList.add("no-valido");
            } else {
                document.frmRegistro[campo].classList.remove("is-invalid");
                document.frmRegistro[campo].classList.remove("no-valido");
            }
            return dev;
        })
    }
</script>