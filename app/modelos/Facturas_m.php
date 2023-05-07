<?php
class Facturas_m extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function crearFactura($datos)
    {
        //Leer último número de factura
        $datos['nfactura'] = $this->ultimoNFactura() + 1;

        // Recibimos los datos del formulario en un array
        // Obtenemos cadena con las columnas desde las claves del array asociativo
        $columnas = implode(",", array_keys($datos));
        // Campos de columnas
        $campos = array_map(
            function ($col) {
                return ":" . $col;
            },
            array_keys($datos)
        );
        $parametros = implode(",", $campos); // Parametros para enlazar
        $cadSQL = "INSERT INTO facturas ($columnas) VALUES ($parametros)";
        $this->consultar($cadSQL);   // Preparar sentencia
        for ($ind = 0; $ind < count($campos); $ind++) {    // Enlace de parametros
            $this->enlazar($campos[$ind], $datos[array_keys($datos)[$ind]]);
        }
        $this->ejecutar();
        $this->insertarLineas();
    }

    private function ultimoNFactura()
    {
        $cadSQL = "SELECT MAX(nfactura) as nfac from facturas";
        $this->consultar($cadSQL);
        return $this->fila()['nfac'];
    }

   private function insertarLineas(){
        //Leer todo el carrito
        $cadSQL="SELECT * FROM carrito where id_sesion=".session_id();
        $this->consultar($cadSQL);
        $carrito=$this->resultado();

        //bucle par cada linea del carrito
        foreach($carrito as $linea){
            
        }

   }
}
