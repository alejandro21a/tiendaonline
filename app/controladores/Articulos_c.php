<?php
class Articulos_c extends Controller
{
    private $articulos_m; // Modelo articulos

    public function __construct()
    {
        // Instanciamos el modelo articulos en la propiedad
        $this->articulos_m = $this->load_model("Articulos_m");
    }

    public function index()
    {
    }

    public function genCatalogo()
    {
        // Este metodo es llamado por AJAX
        // Recibimos una serie de parametros para filtrar la busqueda
        $datos = $this->articulos_m->leerCatalogo($_POST);
        echo json_encode($datos);
    }
    public function catalogo()
    {
        // Cargar modelo familias para filtro
        $familias_m = $this->load_model("Familias_m");
        $datos['familias'] = $familias_m->leerTodas();

        // Visualizar la pagina de catalogo
        $contenido = "catalogo_v";
        $this->load_view("plantilla/cabecera");
        $this->load_view("plantilla/menu");
        $this->load_view($contenido, $datos);
        $this->load_view("plantilla/pie");
    }

    //lo que se manda por uri es un array de parámetros
    public function mantarti($busq = "")
    {
        if (!empty($busq)) {
            $datos['buscado'] = $busq[0];
        }
        // Cargar modelo familias para filtro
        $familias_m = $this->load_model("Familias_m");
        $datos['familias'] = $familias_m->leerTodas();

        //obtener total de registros
        $totalRegistros = $this->articulos_m->totalRegistros($busq[0]);
        $limite_reg_por_pag = 6;
        $url = "Articulos_c/mantarti/";

        $comienzo = isset($busq[1]) ? $busq[1] : 0;

        $paginador = new Paginador($totalRegistros, $comienzo, $limite_reg_por_pag, $url);
        //renderizar las páginas
        $datos['paginas'] = $paginador->crearLinks(10, "pagination pagination-sm");

        $datos['articulos'] = $this->articulos_m->leerConFiltro($comienzo, $limite_reg_por_pag, $busq[0]);
        // Visualizar la pagina de catalogo
        $contenido = "mantarti_v";
        $this->load_view("plantilla/cabecera");
        $this->load_view("plantilla/menu");
        $this->load_view($contenido, $datos);
        $this->load_view("plantilla/pie");
    }

    public function insertar()
    {
        //insertar artículos
        $this->articulos_m->insertar($_REQUEST);
        // header("location:" . $_SERVER['HTTP_REFERER']);  //PARA VOLVER AL SITIO DEL QUE PARTIMOS
        //print_r($_FILES)//vemos cómo recibimos los datos (desordenados)

        //**** VAMOS A ORDENARLOS PARA QUE CADA ÍNDICE SEA UN ELEMENTO ****//
        if (!empty($_FILES['imagenes'])) {

            $files = array();
            foreach ($_FILES['imagenes'] as $clave => $fichero) {
                foreach ($fichero as $indice => $valor) {
                    if (!array_key_exists($indice, $files)) {
                        $files[$indice] = array();
                    }
                    $files[$indice][$clave] = $valor;
                }
            }
            // print_r($files); vemos el array ordenado
            $seq = 0; //contador para poner imagen principal
            $articulos_imagenes_m = $this->load_model(("Articulos_imagenes_m"));
            $mensajes = [];
            foreach ($files as $file) {
                $subida = new Uploader();
                $camino = ROOT . "app/assets/fotosArticulos"; //camino absoluto al que subir el archivo
                $subida->setDir($camino);  //poner directorio de subida
                $subida->setExtensions(array('jpg', 'jpeg', 'png', 'gif')); //elegir extensiones permitidas
                $subida->setMaxSize(5); //tamaño máximo en mb

                if ($subida->uploadFile($file)) {
                    //guardar registro en imagenes_articulos
                    $datos = array(
                        "referencia" => $_REQUEST['referencia'],
                        "camino" => "/app/assets/fotosArticulos" . $subida->getUploadName(),
                        "principal" => $seq == 0 ? 1 : 0
                    );
                    $seq += 1;

                    //insertar la imagen
                    $articulos_imagenes_m->insertar($datos);
                } else {
                    $mensajes[] = "El archivo " . $file['name'] . " no se puede subir, " . $subida->getMessage();
                }
            }
        }

        if (count($mensajes) > 0) {
            $_SESSION['mensajes'] = $mensajes;
        }
        header("location:" . $_SERVER['HTTP_REFERER']);
    }

    public function borrar($referencia)
    {
        $this->articulos_m->borrar(urldecode(($referencia[0])));
        header("location:" . $_SERVER['HTTP_REFERER']);
    }

    public function leerArticuloAjax()
    {
        //este método recibe la referencia de un artículo y devuelve un json con el articulo completo

        echo json_encode($this->articulos_m->leerArticulo($_POST['referencia']));
    }

    public function modificar()
    {
        $this->articulos_m->modificar($_REQUEST);
        header("location:" . $_SERVER['HTTP_REFERER']);
    }
}
