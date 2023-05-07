<?php
class Familias_m extends Model
{
    public function __construct()
    {
        // Llamada al constructor del padre para conectar a la BBDD
        parent::__construct();
    }

    public function leerTodas()
    {
        // Este metodo lee todas las familias y las devuelve
        $cadSQL = "SELECT * FROM familias ORDER BY 2";
        $this->consultar($cadSQL);
        return $this->resultado();
    }
}
