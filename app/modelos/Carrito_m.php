<?php
class Carrito_m extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function articulosEnCarrito($ses)
    {
        $cadSQL = "SELECT sum(cantidad) as cantidad FROM carrito WHERE id_sesion='$ses'";
        $this->consultar($cadSQL);
        return $this->fila();
    }

    public function leerTodo($ses)
    {

        $cadSQL = "SELECT carrito.*,descripCorta,camino FROM carrito LEFT JOIN articulos_imagenes ON carrito.referencia=articulos_imagenes.referencia INNER JOIN articulos ON carrito.referencia=articulos.referencia WHERE id_sesion='$ses' and principal=1";
        $this->consultar($cadSQL);
        return $this->resultado();
    }

    public function leerArticulo($ref, $ses)
    {
        $cadSQL = "SELECT * FROM carrito WHERE id_sesion='$ses' and referencia='$ref'";
        $this->consultar($cadSQL);
        return $this->fila();
    }

    public function leerArticulo_id($id)
    {
        $cadSQL = "SELECT * FROM carrito WHERE id=$id";
        $this->consultar($cadSQL);
        return $this->fila();
    }

    public function insertarArticulo($datos)
    {
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
        $cadSQL = "INSERT INTO carrito ($columnas) VALUES ($parametros)";
        $this->consultar($cadSQL);   // Preparar sentencia
        for ($ind = 0; $ind < count($campos); $ind++) {    // Enlace de parametros
            $this->enlazar($campos[$ind], $datos[array_keys($datos)[$ind]]);
        }
        return $this->ejecutar();
    }


    public function modificarArticulo($datos)
    {
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
        $cadSQL = "UPDATE carrito SET ";
        // Poner todos los campos y parametros
        for ($ind = 0; $ind < count($campos); $ind++) {
            $cadSQL .= array_keys($datos)[$ind] . "=" . $campos[$ind] . ",";
        }
        $cadSQL = substr($cadSQL, 0, strlen($cadSQL) - 1); // quitar la ultima coma
        $cadSQL .= " WHERE id='$datos[id]'"; // Añadir el WHERE
        $this->consultar($cadSQL);   // Preparar sentencia
        for ($ind = 0; $ind < count($campos); $ind++) {    // Enlace de parametros
            $this->enlazar($campos[$ind], $datos[array_keys($datos)[$ind]]);
        }
        return $this->ejecutar();
    }
    public function borrarLinea($id)
    {
        $cadSQL = "DELETE FROM carrito WHERE id=$id";
        $this->consultar($cadSQL);
        return $this->ejecutar();
    }
    public function vaciar($ses)
    {
        $cadSQL = "DELETE FROM carrito WHERE id_sesion='$ses'";
        $this->consultar($cadSQL);
        return $this->ejecutar();
    }
    public function actualizarSesion($sesionAnt)
    {
        $cadSQL = "UPDATE carrito SET id_sesion='" . session_id() . "' WHERE id_sesion='" . $sesionAnt . "'";
        $this->consultar($cadSQL);
        return $this->ejecutar();
    }

    public function importeCarrito($ses){
        $cadSQL="SELECT sum(importe) as importe from carrito where id_sesion='$ses'";
        $this->consultar($cadSQL);
        return $this->fila()['importe'];

    }
}
