<?php

/** PARA ENVIAR CORREO ELECTRONICO POR MEDIO LOCAL */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'Libraries/phpmailer/Exception.php';
require 'Libraries/phpmailer/PHPMailer.php';
require 'Libraries/phpmailer/SMTP.php';
/** FIN   PARA ENVIAR CORREO ELECTRONICO POR MEDIO LOCAL */

//Retorla la url del proyecto
function base_url()
{
    return BASE_URL;
}
//Retorla la url de Assets
function media()
{
    return BASE_URL . "/Assets";
}
/* CSS Y JS DE PAGINA DASHBOARD */
function headerAdmin($data = "")
{
    $view_header = "Views/Template/header_admin.php";
    require_once($view_header);
}
function footerAdmin($data = "")
{
    $view_footer = "Views/Template/footer_admin.php";
    require_once($view_footer);
}

//Muestra información formateada
function dep($data)
{
    $format  = print_r('<pre>');
    $format .= print_r($data);
    $format .= print_r('</pre>');
    return $format;
}
function getModal(string $nameModal, $data)
{
    $view_modal = "Views/Template/Modals/{$nameModal}.php";
    require_once $view_modal;
}
/* corresponde de la ruta URl */
function getFile(string $url, $data)
{
    ob_start(); // almacenando en buffer el archivo para utilizar
    require_once("Views/{$url}.php");
    /* levanta el archivo para utilizar las variables */
    $file = ob_get_clean();
    return $file;
}
//Envio de correos
function sendEmail($data, $template)
{
    $asunto = $data['asunto'];
    $emailDestino = $data['email'];
    $empresa = NOMBRE_REMITENTE;
    $remitente = EMAIL_REMITENTE;
    $emailCopia = !empty($data['emailCopia']) ? $data['emailCopia'] : "";

    //ENVIO DE CORREO
    $de = "MIME-Version: 1.0\r\n";
    $de .= "Content-type: text/html; charset=UTF-8\r\n";
    $de .= "From: {$empresa} <{$remitente}>\r\n";
    $de .= "Bcc: $emailCopia\r\n"; // enviando copia si tiene 
    ob_start(); // levantando el archivo que se requiere
    require_once("Views/Template/Email/" . $template . ".php");
    $mensaje = ob_get_clean();
    $send = mail($emailDestino, $asunto, $mensaje, $de);
    return $send;
}
/**  ENVIAR CORREO POR MEDIO LOCALHOST */
function sendMailLocal($data, $template)
{
    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    ob_start();
    require_once("Views/Template/Email/" . $template . ".php");
    $mensaje = ob_get_clean();

    try {
        //Server settings
        $mail->SMTPDebug = 1;                      //1 para debugear  0no se ve el proceso
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'williamsroc5quispe20@gmail.com';                     //SMTP username
        $mail->Password   = 'elmerkunquispe';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('williamsroc5quispe20@gmail.com', 'Servidor Local');
        $mail->addAddress($data['email']);     //Add a recipient
        if (!empty($data['emailCopia'])) {
            $mail->addBCC($data['emailCopia']);
        }

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $data['asunto'];
        $mail->Body    =  $mensaje;

        $mail->send();
        echo 'Mensaje Enviado';
    } catch (Exception $e) {
        echo "Error en el envio del mensaje: {$mail->ErrorInfo}";
    }
}

/*permiso del modulo numero entero */


function getPermisos(int $idmodulo)
{
    require_once("Models/PermisosModel.php");
    //$objPermisos = new PermisosModel();
    if (!empty($_SESSION['userData'])) {
        $idrol = $_SESSION['userData']['idrol'];
        $arrPermisos = $objPermisos->permisosModulo($idrol);
        $permisos = '';
        $permisosMod = '';
        if (count($arrPermisos) > 0) {
            $permisos = $arrPermisos;
            $permisosMod = isset($arrPermisos[$idmodulo]) ? $arrPermisos[$idmodulo] : "";
        }
        $_SESSION['permisos'] = $permisos;
        $_SESSION['permisosMod'] = $permisosMod;
    }
}



function sessionUser(int $idpersona)
{
    require_once("Models/LoginModel.php");
    //$objLogin = new LoginModel();
    $request = $objLogin->sessionLogin($idpersona);
    return $request;
}
/*carga la imagen del archivo guardado */
function uploadImage(array $data, string $name)
{
    $url_temp = $data['tmp_name'];
    $destino    = 'Assets/images/uploads/' . $name;
    $move = move_uploaded_file($url_temp, $destino);
    return $move;
}
/*elimian la imagen del archivo */
function deleteFile(string $name)
{
    unlink('Assets/images/uploads/' . $name);
}

//Elimina exceso de espacios entre palabras
function strClean($strCadena)
{
    $string = preg_replace(['/\s+/', '/^\s|\s$/'], [' ', ''], $strCadena);
    $string = trim($string); //Elimina espacios en blanco al inicio y al final
    $string = stripslashes($string); // Elimina las \ invertidas
    $string = str_ireplace("<script>", "", $string);
    $string = str_ireplace("</script>", "", $string);
    $string = str_ireplace("<script src>", "", $string);
    $string = str_ireplace("<script type=>", "", $string);
    $string = str_ireplace("SELECT * FROM", "", $string);
    $string = str_ireplace("DELETE FROM", "", $string);
    $string = str_ireplace("INSERT INTO", "", $string);
    $string = str_ireplace("SELECT COUNT(*) FROM", "", $string);
    $string = str_ireplace("DROP TABLE", "", $string);
    $string = str_ireplace("OR '1'='1", "", $string);
    $string = str_ireplace('OR "1"="1"', "", $string);
    $string = str_ireplace('OR ´1´=´1´', "", $string);
    $string = str_ireplace("is NULL; --", "", $string);
    $string = str_ireplace("is NULL; --", "", $string);
    $string = str_ireplace("LIKE '", "", $string);
    $string = str_ireplace('LIKE "', "", $string);
    $string = str_ireplace("LIKE ´", "", $string);
    $string = str_ireplace("OR 'a'='a", "", $string);
    $string = str_ireplace('OR "a"="a', "", $string);
    $string = str_ireplace("OR ´a´=´a", "", $string);
    $string = str_ireplace("OR ´a´=´a", "", $string);
    $string = str_ireplace("--", "", $string);
    $string = str_ireplace("^", "", $string);
    $string = str_ireplace("[", "", $string);
    $string = str_ireplace("]", "", $string);
    $string = str_ireplace("==", "", $string);
    return $string;
}
/*eliminar tildes */
function clear_cadena(string $cadena)
{
    //Reemplazamos la A y a
    $cadena = str_replace(
        array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
        array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'),
        $cadena
    );

    //Reemplazamos la E y e
    $cadena = str_replace(
        array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
        array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'),
        $cadena
    );

    //Reemplazamos la I y i
    $cadena = str_replace(
        array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
        array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'),
        $cadena
    );

    //Reemplazamos la O y o
    $cadena = str_replace(
        array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
        array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'),
        $cadena
    );

    //Reemplazamos la U y u
    $cadena = str_replace(
        array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
        array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'),
        $cadena
    );

    //Reemplazamos la N, n, C y c
    $cadena = str_replace(
        array('Ñ', 'ñ', 'Ç', 'ç', ',', '.', ';', ':'),
        array('N', 'n', 'C', 'c', '', '', '', ''),
        $cadena
    );
    return $cadena;
}
//Genera una contraseña de 10 caracteres
function passGenerator($length = 10)
{
    $pass = "";
    $longitudPass = $length;
    $cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
    $longitudCadena = strlen($cadena);

    for ($i = 1; $i <= $longitudPass; $i++) {
        $pos = rand(0, $longitudCadena - 1);
        $pass .= substr($cadena, $pos, 1);
    }
    return $pass;
}
//Genera un token
function token()
{
    $r1 = bin2hex(random_bytes(10));
    $r2 = bin2hex(random_bytes(10));
    $r3 = bin2hex(random_bytes(10));
    $r4 = bin2hex(random_bytes(10));
    $token = $r1 . '-' . $r2 . '-' . $r3 . '-' . $r4;
    return $token;
}
//Formato para valores monetarios
function formatMoney($cantidad)
{
    $cantidad = number_format($cantidad, 2, SPD, SPM);
    return $cantidad;
}



/*  peteciones GET de para toda Apis */
function CurlConnectionGet(string $ruta, string $contentType = null, string $token)
{
    $content_type = $contentType != null ? $contentType : "application/x-www-form-unlencoded";
    if ($token != null) {
        $arrHeader = array(
            'Content-Type:' . $content_type,
            'Authorization: Bearer ' . $token
        );
    } else {
        $arrHeader = array(
            'Content-Type:' . $content_type
        );
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $ruta); // QUE URL nos vamos a CONECTAR
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); //obtener informacion
    curl_setopt($ch, CURLOPT_HTTPHEADER, $arrHeader); // enviando a postman los headers 
    $result = curl_exec($ch);
    $err = curl_error($ch);
    curl_close($ch);
    if ($err) {
        $request = "CURL Error #:" . $err;
    } else {
        /* Estructurado en array u Objeto  */
        $request = json_decode($result);
    }
    return $request;
}

/*  peteciones POST de para toda Apis */
function CurlConnectionPost(string $ruta, string $contentType = null, string $token)
{
    $content_type = $contentType != null ? $contentType : "application/x-www-form-unlencoded";
    if ($token != null) {
        $arrHeader = array(
            'Content-Type:' . $content_type,
            'Authorization: Bearer ' . $token
        );
    } else {
        $arrHeader = array(
            'Content-Type:' . $content_type
        );
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $ruta); // QUE URL nos vamos a CONECTAR
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); //obtener informacion
    curl_setopt($ch, CURLOPT_HTTPHEADER, $arrHeader); // enviando a postman los headers 
    $result = curl_exec($ch);
    $err = curl_error($ch);
    curl_close($ch);
    if ($err) {
        $request = "CURL Error #:" . $err;
    } else {
        /* Estructurado en array u Objeto  */
        $request = json_decode($result);
    }
    return $request;
}

function Meses()
{
    $meses = array(
        "Enero",
        "Febrero",
        "Marzo",
        "Abril",
        "Mayo",
        "Junio",
        "Julio",
        "Agosto",
        "Septiembre",
        "Octubre",
        "Noviembre",
        "Diciembre"
    );
    return $meses;
}

/** MOSTRAR  CATEGORAIS EN EL FOOTER */
function getCatFooter()
{
    require_once("Models/CategoriasModel.php");
    //$objCategoria = new CategoriasModel();
    $request = $objCategoria->getCategoriasFooter();
    return $request;
}

/** ACTUALIZAR DATOS DE LA PAGINA */
function getInfoPage(int $idPagina)
{
    require_once("Libraries/Core/Mysql.php");
    $con = new Mysql();
    $sql = "SELECT * from post where idpost = $idPagina";
    $request = $con->select($sql);
    return $request;
}

// LLAMANDO DATOS DEL MODELO  POST
function getPageRout(string $ruta)
{
    require_once("Libraries/Core/Mysql.php");
    $con = new Mysql();
    $sql = "SELECT * from post where ruta = '{$ruta}' and status !=0 ";
    $request = $con->select($sql);
    if (!empty($request)) {
        $request['portada'] = $request['portada'] != "" ? media() . "/images/uploads/" . $request['portada'] : "";
    }
    return $request;
}

/** FUNCION  PARA  MOSTRAR PAGINAS DE CONTACTO Y OTROS */
function viewPage(int $idPagina)
{
    require_once("Libraries/Core/Mysql.php");
    $con = new Mysql();
    $sql = "SELECT * from post where idpost = {$idPagina} ";
    $request = $con->select($sql);

    if ($request['status'] == 2 and isset($_SESSION['permisosMod']) and $_SESSION['permisosMod']['u'] == true or $request['status'] == 1) {
        return true;
    } else {
        return false;
    }
}
