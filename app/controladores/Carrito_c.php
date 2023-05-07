<?php
class Carrito_c extends Controller
{
    private $carrito_m;
    public function __construct()
    {
        $this->carrito_m = $this->load_model("Carrito_m");
    }
    public function index()
    {
        $datos['items'] = $this->carrito_m->leerTodo(session_id());
        $contenido = "carrito_v";
        $this->load_view("plantilla/cabecera");
        $this->load_view("plantilla/menu");
        $this->load_view($contenido, $datos);
        $this->load_view("plantilla/pie");
    }
    public function insertarArticulo_ajax()
    {
        // Recogemos los parametros referencia y precio para montar el array que enviaremos al metodo insertarArticulo del modelo
        $datos = [
            "referencia" => $_REQUEST['referencia'],
            "cantidad" => 1,
            "precio" => $_REQUEST['precio'],
            "importe" => $_REQUEST['precio'],
            "id_sesion" => session_id()
        ];
        // Comprobar que el articulo no exista en el carrito
        $articulo = $this->carrito_m->leerArticulo($datos['referencia'], $datos['id_sesion']);
        if ($articulo) {
            // Modificar la cantidad del articulo en el carrito
            // En el array $articulo tenemos lo que esta en el carrito
            $articulo['cantidad'] += 1;
            $articulo['importe'] += $articulo['precio'];
            $this->carrito_m->modificarArticulo($articulo);
        } else {
            // insertar el articulo en el carrito
            $this->carrito_m->insertarArticulo($datos);
        }
        // Devolver el numero de articulos en el carrito
        echo $this->carrito_m->articulosEnCarrito(session_id())['cantidad'];
    }

    public function articulosEnCarrito()
    {
        echo $this->carrito_m->articulosEnCarrito(session_id())['cantidad'];
    }
    public function leerTodo()
    {
        $articulos = $this->carrito_m->leerTodo(session_id());
        echo json_encode($articulos);
    }
    public function actualizarSesion()
    {
        echo $this->carrito_m->actualizarSesion($_REQUEST['sesionAnt']);
    }
    public function vaciar()
    {
        echo $this->carrito_m->vaciar(session_id());
    }
    public function borrarLinea()
    {
        echo $this->carrito_m->borrarLinea($_REQUEST['id']);
    }
    public function modCantidad()
    {
        // Primero leemos la fila del carrito
        $fila = $this->carrito_m->leerArticulo_id($_REQUEST['id']);
        // recalculamos campos de la fila afectados
        $fila['cantidad'] = $_REQUEST['cant'];
        $fila['importe'] = $fila['precio'] * $fila['cantidad'];
        // Actualizamos fila
        echo $this->carrito_m->modificarArticulo($fila);
    }
}
