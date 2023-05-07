<?php
class Usuarios_m extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function autenticar($usu, $pass)
    {
        $cadSQL = "SELECT * FROM usuarios WHERE (usuario=:usu or email=:usu)";
        $this->consultar($cadSQL);
        $this->enlazar(":usu", $usu);
        $fila = $this->fila();
        if ($fila) {
            // Comprobar el password
            if (!password_verify($pass, $fila['password'])) {
                return null;
            }
        }
        return $fila;
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
        $cadSQL = "INSERT INTO usuarios ($columnas) VALUES ($parametros)";
        $this->consultar($cadSQL);   // Preparar sentencia
        for ($ind = 0; $ind < count($campos); $ind++) {    // Enlace de parametros
            $this->enlazar($campos[$ind], $datos[array_keys($datos)[$ind]]);
        }
        return $this->ejecutar();
    }
    public function activarCuenta($token)
    {
        // Activar la cuenta cuyo token sea el recibido como parametro
        $cadSQL = "UPDATE usuarios SET activo=1 WHERE token=:token";
        $this->consultar($cadSQL);
        $this->enlazar(":token", $token);
        return $this->ejecutar();
    }
    public function existeUsuario($datos)
    {
        $clave = array_keys($datos)[0];
        $valor = array_values($datos)[0];
        $cadSQL = "SELECT count(*) as existe FROM usuarios WHERE $clave  = '$valor'";
        //error_log($cadSQL);
        $this->consultar($cadSQL);
        return $this->fila()['existe'];
    }
}
