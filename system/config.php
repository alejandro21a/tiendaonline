<?php
//////////////////////// CONFIGURACIONES ///////////////////////
define('URI', $_SERVER['REQUEST_URI']);
const DEFAULT_CONTROLLER = 'Inicio_c';
const DEFAULT_METHOD = 'index';
const CORE = "system/core/";
const PATH_CONTROLLERS = "app/controladores/";
const PATH_VIEWS = "app/vistas/";
const PATH_MODELS = "app/modelos/";

//////////Cambiar los siguientes para cada proyecto ///////////
define('ROOT', $_SERVER['DOCUMENT_ROOT'] . "/tiendaonline/");
define("BASE_URL", "http://localhost/tiendaonline/");
////////////BBDD/////////////////
const DB_HOST = "localhost";
const DB_USER = "root";
const DB_PASS = "";
const DB_NAME = "tiendaonline";

define("PayPalClientId", "Acwc6zQgT3tWg5dP7fZXXZZc9LpuYJEqj2ZON2CvsU0bwwI15MIiuKSP075MOiR1bG3rQ1ZIHJNqrDCM");
define("PayPalENV", "sandbox");
