/***********************  FILTRAR ARTÍCULOS  *************************/
$("#textoBuscado").on("change",function(evento){
    refrescarVista();
});

$("#btnBuscar").on("click",function(evento){
    refrescarVista();
});

function refrescarVista(){
    let buscado=$("#textoBuscado").val();
    location.href=base_url+"articulos_c/mantarti/"+buscado;

}


/********     EVENTO BORRAR ARTÍCULO       ********/
$(".btnBorrar").on("click",function(evento){

    Swal.fire({
        title: '¿Estás seguro?',
        text: "Esta acción es irreversible",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, borrar'
      }).then((result) => {
        if (result.isConfirmed) {

        //BORRAR ARTÍCULO
        let referencia=$(this).parents("tr").children("td").eq(0).html();
        location.href=base_url+"Articulos_c/borrar/"+encodeURI(referencia);
        console.log(referencia);
          Swal.fire(
            '¡Eliminado!',
            'Your file has been deleted.',
            'success'
          )
        }
      })

});

//*******       MODIFICAR ARTÍCULO         *******//
$(".btnModificar").on("click",function(evento){
  //obtener referencia del artículo
  let referencia=$(this).parents("tr").children("td").eq(0).html();

  //leer mediante ajax el registro del artículo
  $.post(base_url+"Articulos_c/leerArticuloAjax",{'referencia':referencia},function(datos){

    //cargar todos los valores de los campos del formulario con los datos recibidos
    //bucle por todos los campos del formulario
    let articulo=JSON.parse(datos);
    for(let indice in articulo){
      if(indice=="oferta"){
      $("#oferta").attr("checked",articulo[indice]==1 ? true:false);
      }else{
        document.formArticulos[indice].value=articulo[indice];
      }
     
    }

    document.formArticulos.action=base_url+"Articulos_c/modificar";
    $("#tituloArticulosModal").html("Modificar Artículo");
    document.formArticulos.referencia.disabled=true;

    const miModal= new bootstrap.Modal('#articulosModal');
    miModal.show();
  });

});

$("#btnNuevo").on("click",function(evento){
  document.formArticulos.reset();
  document.formArticulos.referencia.disabled=false;
});

$("#articulosModal").on("shown.bs.modal",function(evento){
  document.formArticulos.referencia.focus();
});