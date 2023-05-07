// Vaciar Carrito
// Llamar al metodo vaciarCarrito del controlador mediante AJAX
$("#btnVaciar").on("click", function (evento) {
  Swal.fire({
    title: "Estas seguro?",
    text: "Lo borrado no se puede recuperar!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, Borralo!",
  }).then((result) => {
    if (result.isConfirmed) {
      /* Swal.fire("Deleted!", "Your file has been deleted.", "success"); */
      // Hacer la llamada ajax
      $.post(base_url + "carrito_c/vaciar", "", function (dev) {
        location.reload();
      });
    }
  });
});
// Boton Borrar Linea
$(".btnBorrar").on("click", function (evento) {
  let id = $(this).parents("tr").data("id");

  Swal.fire({
    title: "Estas seguro?",
    text: "Lo borrado no se puede recuperar!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, Borralo!",
  }).then((result) => {
    if (result.isConfirmed) {
      // Hacer la llamada ajax
      $.post(base_url + "carrito_c/borrarLinea", { id: id }, function (dev) {
        // Referescar carrito
        location.reload();
      });
    }
  });
});
// Recalcular carrito cuando se cambie la cantidad de alguna linea
$("input.cantidad").on("click", function (evento) {
  let cant = this.value;
  let id = $(this).parents("tr").data("id");
  // Modificar la linea del carrito afectada
  $.post(
    base_url + "carrito_c/modCantidad",
    { id: id, cant: cant },
    function (dev) {
      location.reload();
    }
  );
});
