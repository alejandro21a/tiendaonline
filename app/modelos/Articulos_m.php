<?php
class Articulos_m extends Model
{
    public function __construct()
    {
        // Llamada al constructor del padre para conectar a la BBDD
        parent::__construct();
    }

    public function articulos_carousel()
    {
        $cadSQL = "select articulos.*,articulos_imagenes.camino FROM articulos inner join articulos_imagenes on articulos.referencia = articulos_imagenes.referencia WHERE articulos.oferta=1 and articulos_imagenes.principal=1";
        // llamamos al metodo consultar que lo que hace es preparar la sentencia
        $this->consultar($cadSQL);
        // En esta consulta no enlazamos parametros porque no tiene
        // con lo que llamamos a el metodo resultado
        return $this->resultado();
    }
    public function leerCatalogo()
    {
        $cadSQL = "select articulos.*,familias.descripcion as descfam,articulos_imagenes.camino FROM articulos inner JOIN articulos_imagenes on articulos.referencia=articulos_imagenes.referencia INNER JOIN familias on articulos.familia = familias.id WHERE articulos_imagenes.principal=1 and (articulos.precioVenta between :desp and :hasp) and (descripCorta like :busq or descripLarga like :busq)";
        if (!empty($_POST['fam'])) {
            $cadSQL .= " and articulos.familia = :fam";
        }
        $this->consultar($cadSQL);
        // Enlazar parametros
        if (!empty($_POST['fam'])) $this->enlazar(":fam", $_POST['fam']);
        $this->enlazar(":desp", $_POST['desp']);
        $this->enlazar(":hasp", $_POST['hasp']);
        $this->enlazar(":busq", "%$_POST[busq]%");

        return $this->resultado();
    }

    public function totalRegistros($busq)
    {
        $cadSQL = "select COUNT(*) as totalR FROM articulos LEFT JOIN articulos_imagenes on articulos.referencia=articulos_imagenes.referencia INNER JOIN familias on articulos.familia = familias.id WHERE (articulos_imagenes.principal=1 or articulos_imagenes.principal is null) and (articulos.referencia like :busq or descripCorta like :busq or descripLarga like :busq) ";

        $this->consultar($cadSQL);
        // Enlazar parametros
        $this->enlazar(":busq", "%$busq%");

        //retornar el número total de registros
        return $this->fila()['totalR'];
    }

    public function leerArticulo($ref)
    {
        $cadSQL = "SELECT * FROM articulos WHERE  referencia='$ref'";
        $this->consultar($cadSQL);
        return $this->fila();
    }

    public function leerConFiltro($comienzo, $registros, $busq)
    {
        $cadSQL = "select articulos.*,familias.descripcion as descfam,articulos_imagenes.camino FROM articulos LEFT JOIN articulos_imagenes on articulos.referencia=articulos_imagenes.referencia INNER JOIN familias on articulos.familia = familias.id WHERE (articulos_imagenes.principal=1 or articulos_imagenes.principal is null) and (articulos.referencia like :busq or descripCorta like :busq or descripLarga like :busq) lIMIT $comienzo,$registros";

        $this->consultar($cadSQL);
        // Enlazar parametros
        $this->enlazar(":busq", "%$busq%");

        return $this->resultado();
    }

    public function insertar($datos)
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
        $cadSQL = "INSERT INTO articulos ($columnas) VALUES ($parametros)";
        $this->consultar($cadSQL);   // Preparar sentencia
        for ($ind = 0; $ind < count($campos); $ind++) {    // Enlace de parametros
            $this->enlazar($campos[$ind], $datos[array_keys($datos)[$ind]]);
        }
        return $this->ejecutar();
    }


    public function modificar($datos)
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
        $cadSQL = "UPDATE articulos SET ";
        // Poner todos los campos y parametros
        for ($ind = 0; $ind < count($campos); $ind++) {
            $cadSQL .= array_keys($datos)[$ind] . "=" . $campos[$ind] . ",";
        }
        $cadSQL = substr($cadSQL, 0, strlen($cadSQL) - 1); // quitar la ultima coma
        $cadSQL .= " WHERE referencia='$datos[referencia]'"; // Añadir el WHERE
        $this->consultar($cadSQL);   // Preparar sentencia
        for ($ind = 0; $ind < count($campos); $ind++) {    // Enlace de parametros
            $this->enlazar($campos[$ind], $datos[array_keys($datos)[$ind]]);
        }
        return $this->ejecutar();
    }

    public function borrar($referencia)
    {
        //como no viene de un formulario, no enlazamos parámetros ni nada (no riesgo inyección sql)
        $cadSQL = "DELETE FROM articulos WHERE referencia='$referencia'";
        $this->consultar($cadSQL);
        return $this->ejecutar();
    }
}
