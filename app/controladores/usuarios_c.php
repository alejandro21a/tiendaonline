<?php
// Cargar clases del PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require ROOT . 'app/assets/libs/PHPMailer/src/Exception.php';
require ROOT . 'app/assets/libs/PHPMailer/src/PHPMailer.php';
require ROOT . 'app/assets/libs/PHPMailer/src/SMTP.php';

class Usuarios_c extends Controller
{
    private $usuarios_m; // Propiedad para instanciar el modelo

    public function __construct()
    {
        $this->usuarios_m = $this->load_model("Usuarios_m");
    }
    public function index()
    {
    }
    public function login()
    {
        // Metodo que presenta la vista del Login
        $contenido = "login_v";
        $this->load_view("plantilla/cabecera");
        $this->load_view("plantilla/menu");
        $this->load_view($contenido);
        $this->load_view("plantilla/pie");
    }
    public function logout()
    {
        // Destruimos la sesion
        unset($_SESSION['sesion']);
        header("location:" . BASE_URL . "articulos_c/catalogo");
    }
    public function autenticar()
    {
        // recibimos usuario y password y lo envamos al metodo autenticar del modelo
        $fila = $this->usuarios_m->autenticar($_REQUEST['usuario'], $_REQUEST['password']);
        if ($fila) {
            $_SESSION['sesion'] = [
                'usuario' => $fila['usuario'],
                'email' => $fila['email'],
                'role' => $fila['role']
            ];
            header("location:" . BASE_URL . "articulos_c/catalogo");
        } else {
            // Si el usuario no existe, retornar al login y dar mensaje de error
            $_SESSION['mensajeError'] = "No existe el usuario o password";
            header("location:" . BASE_URL . "usuarios_c/login");
        }
    }
    public function registro()
    {
        $contenido = "registro_v";
        $this->load_view("plantilla/cabecera");
        $this->load_view("plantilla/menu");
        $this->load_view($contenido);
        $this->load_view("plantilla/pie");
    }
    public function insertar()
    {
        // Este metodo inserta un registro de usuario
        // Encriptamos  la clave con password_hash
        $_REQUEST['password'] = password_hash($_REQUEST['password'], PASSWORD_DEFAULT);
        $_REQUEST['role'] = "U";
        $_REQUEST['token'] = md5($_REQUEST['usuario']);
        // Enviamos los datos al metodo insertar del modelo
        $retorno = $this->usuarios_m->insertar($_REQUEST);
        // Enviar correo al usuario con link para activar cuenta
        $this->enviarCorreo($_REQUEST['email'], $_REQUEST['apenom'], $_REQUEST['token']);
    }

    public function activarCuenta($par)
    {
        $this->usuarios_m->activarCuenta($par[0]);
        echo "Su cuenta ha sido activada, pulse <a href='" . BASE_URL . "usuarios_c/login'>aqui</a> para continuar";
    }
    public function existeUsuario()
    {
        // Devuelve si existe un usuario o no mediante una llamada AJAX
        echo $this->usuarios_m->existeUsuario($_REQUEST);
    }

    private function enviarCorreo($dest, $nombre, $token)
    {

        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_OFF;            //Enable verbose debug output
            $mail->isSMTP();                                           //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                 //Enable SMTP authentication
            $mail->Username   = 'jmlabagora@gmail.com';                //SMTP username
            $mail->Password   = 'rgllvuahuxselgtr';                    //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;           //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('jmlabagora@gmail.com', 'TiendaOnline');
            $mail->addAddress($dest, $nombre);     //Add a recipien
            //$mail->addReplyTo('info@example.com', 'Information');
            //$mail->addCC('cc@example.com');
            //$mail->addBCC('bcc@example.com');

            //Attachments
            //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Registro en tiendaOnline';
            $mail->Body    = '
            <h3>Enhorabuena, te has registrado en nuestra tienda</h3>
            <p>Antes de poder operar en ella, deberás activar tu cuenta mediante el siguiente enlace:</p>
            <p><a href="' . BASE_URL . 'usuarios_c/activarCuenta/' . $token . '">Haga click aqui</a></p>
            ';
            //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            //echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
