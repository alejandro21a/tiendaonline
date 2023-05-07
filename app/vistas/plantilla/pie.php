<footer class="row justify-content-center text-center">
    <div class="col-6 text-white bg-dark py-2">Copyright DAW 2W</div>
</footer>
</div>
<script>
    // Script para colocar cantidad en el carrito
    $(document).ready(function() {
        // Recuperar Carrito en localStorage si existe
        if (localStorage.carrito) {
            // Si existe un carrito guardado cambiamos el session id antiguo por el nuevo
            $.post(base_url + "carrito_c/actualizarSesion", {
                "sesionAnt": localStorage.idSesionAntiguo
            }, function(datos) {
                $.post(base_url + "carrito_c/articulosEnCarrito", "", function(datos) {
                    $("#cartCant").html(datos);
                })
            });
        }
    })

    function guardarCarritoLocal() {
        if (parseInt($("#cartCant").html()) > 0) {
            $.post(base_url + "carrito_c/leerTodo", "", function(datos) {
                // Guardar en localStorage los datos que ya vienen en formato JSON
                localStorage.setItem("carrito", datos)
                localStorage.setItem("idSesionAntiguo", "<?= session_id(); ?>")
            })
        }
    }
</script>
</body>

</html>