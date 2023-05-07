<?php

class Pago_c extends Controller
{

    public function __construct()
    {
    }

    public function index()
    {
        $contenido = "";
        if (!isset($_SESSION['sesion'])) {
            $contenido = "login_v";
        } else {
            $contenido = "pago_v";
            $carrito_m = $this->load_model("Carrito_m");
            $datos['importe'] = $carrito_m->importeCarrito(session_id());
        }


        $this->load_view("plantilla/cabecera");
        $this->load_view("plantilla/menu");
        $this->load_view($contenido, $datos);
        $this->load_view("plantilla/pie");
    }

    public function confirmacionPago($datos)
    {
        //cargar una vista con los datos del pago efectuados
        echo "ID del pago " . $datos[0];
        echo "ID del pagador " . $datos[1];

        //Crear la factura y borrar el carrito
    }
}
