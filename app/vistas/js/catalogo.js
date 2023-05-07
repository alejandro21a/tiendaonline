// LLamar a traer catalogo inicial
let opciones = { fam: "", desp: 0, hasp: 999999, busq: "" };
traerCatalogo(opciones);
// Traernos los datos del catalogo mediante AJAX
function traerCatalogo(opciones) {
  $.post(base_url + "articulos_c/genCatalogo", opciones, function (datos) {
    visualizar_catalogo(JSON.parse(datos));
  });
}

function visualizar_catalogo(catalogo) {
  let cadena = "<div class='row'>";
  // instanciar clase intl
  let fnum = new Intl.NumberFormat("es-ES", {
    style: "currency",
    currency: "EUR",
  });
  for (articulo of catalogo) {
    cadena += `
      <div class="card col-lg-4">
        <img src="${base_url + articulo.camino}" class="card-img-top" alt="...">
        <div data-referencia='${articulo.referencia}' data-precio='${
      articulo.precioVenta
    }' class="card-body">
          <h5 class="card-title">${articulo.descripCorta}</h5>
          <h3 class="card-text">${fnum.format(articulo.precioVenta)}</h3>
          <button type="button" class="btn btn-primary btnComprar">Comprar</button>
          <a href="#" class="btn btn-secondary">Detalle</a>
        </div>
    </div>`;
  }
  cadena += "</div>";
  $("#fichas").html(cadena);
  /****************************************
   * Boton Comprar
   ****************************************/

  $(".btnComprar").on("click", function (evento) {
    // Introducirá el producto en el carrito y se verá reflejado en el badget del mismo.
    let referencia = $(this).parent().data("referencia");
    let precio = $(this).parent().data("precio");
    // Hacer llamada AJAX al metodo insertarArticulo_ajax
    $.post(
      base_url + "carrito_c/insertarArticulo_ajax",
      {
        referencia: referencia,
        precio: precio,
      },
      function (datos) {
        //console.log(datos);
        // Actualizar el budge del carrito
        $("#cartCant").html(datos);
        guardarCarritoLocal();
      }
    );
  });
}
//#region Eventos Filtros

// Interceptar click en lista de familias
$("#familias").on("click", "li", function (evento) {
  // Desactivar elemento activo
  $("#familias li.active").removeClass("active");
  // Activamos el nuevo
  $(this).addClass("active");
  filtrarCatalogo();
});

$("#desdePrecio").on("change", function (evento) {
  filtrarCatalogo();
});
$("#hastaPrecio").on("change", function (evento) {
  filtrarCatalogo();
});
$("#busqueda").on("change", function (evento) {
  filtrarCatalogo();
});
function filtrarCatalogo() {
  // Filtrar catalogo
  opciones = {
    fam: $("#familias li.active").data("id"),
    desp: $("#desdePrecio").val(),
    hasp: $("#hastaPrecio").val(),
    busq: $("#busqueda").val(),
  };
  traerCatalogo(opciones);
}
$("#btnReset").on("click", function (evento) {
  $("#desdePrecio").val("0");
  $("#hastaPrecio").val("999999");
  $("#busqueda").val("");
  $("#familias li").eq(0).trigger("click");
});
//#endregion
