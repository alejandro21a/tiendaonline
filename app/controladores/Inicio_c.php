<?php
class Inicio_c extends Controller
{
    public function __construct()
    {
    }
    public function index()
    {

        // Instanciar modelo
        $articulos_m = $this->load_model("Articulos_m");
        // Obtenemos los datos del metodo articulos_carousel y los guardamos en un indice del array datos
        $datos['articulos'] = $articulos_m->articulos_carousel();

        // Visualizar la pagina de aterrizaje
        $contenido = "landing_v";
        $this->load_view("plantilla/cabecerasinheader");
        $this->load_view($contenido, $datos);
        $this->load_view("plantilla/pie");
    }
    public function menuActivo_Ajax()
    {
        $_SESSION['menuActivo'] = $_REQUEST['menuActivo'];
    }
}
