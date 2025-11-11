<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../libs/vendor/autoload.php';
include "../logica/conexion.php";

$conexionBD = new Conexion();

// ==================== PASO 1: ENVIAR CÓDIGO ====================
if(isset($_POST['enviarCodigo'])){

    $email =  $_POST['emailRecuperar'];

    $errores_mail_recuperacion=[];

    if(empty($email)){
        $errores_mail_recuperacion['email']="debe ingresar el mail";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores_mail_recuperacion['email'] = "Ingrese bien los datos del mail";
    }
    
    if(!empty($errores_mail_recuperacion)){
        $_SESSION['error_mail']=$errores_mail_recuperacion;
        
    }else{
        
         $email =  mysqli_real_escape_string($conexionBD->getConexion(),$_POST['emailRecuperar']);

    // Verificar que el email existe en la base de datos
    $sql = "SELECT * FROM `usuario` WHERE email='$email'";
    $datos = $conexionBD->ejecutarConsulta($sql);

    if ($datos && count($datos) > 0) {
        $fila = $datos[0];
        
        // Generar código de 6 dígitos
        $codigo = sprintf("%06d", rand(0, 999999));
        
        // Guardar código en sesión con tiempo de expiración
        $_SESSION['codigo_recuperacion'] = $codigo;
        $_SESSION['email_recuperacion'] = $email;
        $_SESSION['codigo_expiracion'] = time() + (15 * 60); // Expira en 15 minutos
        
        $mail = new PHPMailer(true);
        
        try {
            //Server settings
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'retrofariaslucero@gmail.com';
            $mail->Password   = 'dujz eekp xlqw qmik';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;
            $mail->CharSet    = 'UTF-8';

            //Recipients
            $mail->setFrom('retrofariaslucero@gmail.com', 'Red Social Artesanos');
            $mail->addAddress($email);

            //Content
            $mail->isHTML(true);
            $mail->Subject = 'Código de Recuperación de Contraseña';
            
            $mail->Body = "
            <!DOCTYPE html>
            <html lang='es'>
            <head>
                <meta charset='UTF-8'>
                <meta name='publicport' content='width=device-width, initial-scale=1.0'>
                <style>
                    body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6; color: #333; background-color: #f4f4f4; margin: 0; padding: 0; }
                    .container { max-width: 600px; margin: 20px auto; background-color: white; border-radius: 10px; overflow: hidden; box-shadow: 0 0 20px rgba(0,0,0,0.1); }
                    .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 30px 20px; text-align: center; }
                    .header h1 { margin: 0; font-size: 24px; font-weight: 600; }
                    .content { padding: 40px 30px; }
                    .content h2 { color: #333; font-size: 20px; margin-bottom: 20px; }
                    .code-container { text-align: center; margin: 30px 0; }
                    .code { display: inline-block; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; font-size: 32px; font-weight: bold; padding: 20px 40px; border-radius: 10px; letter-spacing: 8px; }
                    .info { background-color: #f8f9fa; border-left: 4px solid #667eea; padding: 15px; margin: 20px 0; border-radius: 5px; }
                    .warning { background-color: #fff3cd; border-left: 4px solid #ffc107; padding: 15px; margin: 20px 0; border-radius: 5px; }
                    .footer { text-align: center; padding: 20px; background-color: #f8f9fa; font-size: 12px; color: #666; }
                    .footer p { margin: 5px 0; }
                </style>
            </head>
            <body>
                <div class='container'>
                    <div class='header'>
                        <h1>🔐 Recuperación de Contraseña</h1>
                    </div>
                    <div class='content'>
                        <h2>¡Hola!</h2>
                        <p>Hemos recibido una solicitud para restablecer la contraseña de tu cuenta en <strong>Red Social Artesanos</strong>.</p>
                        
                        <p>Tu código de verificación es:</p>
                        
                        <div class='code-container'>
                            <div class='code'>{$codigo}</div>
                        </div>
                        
                        <div class='info'>
                            <strong>📝 Instrucciones:</strong>
                            <ul style='margin: 10px 0; padding-left: 20px;'>
                                <li>Ingresa este código en la página de recuperación</li>
                                <li>El código es válido por <strong>15 minutos</strong></li>
                                <li>Es sensible a mayúsculas y minúsculas</li>
                            </ul>
                        </div>
                        
                        <div class='warning'>
                            <strong>⚠️ Importante:</strong> Si no solicitaste este cambio, ignora este correo. Tu contraseña permanecerá sin cambios y tu cuenta está segura.
                        </div>
                        
                        <p style='margin-top: 30px; color: #666; font-size: 14px;'>
                            Por tu seguridad, nunca compartas este código con nadie.
                        </p>
                    </div>
                    <div class='footer'>
                        <p><strong>Red Social Artesanos</strong></p>
                        <p>Este es un correo automático, por favor no respondas a este mensaje.</p>
                        <p>&copy; " . date('Y') . " Red Social Artesanos. Todos los derechos reservados.</p>
                    </div>
                </div>
            </body>
            </html>
            ";
            
            $mail->AltBody = "
            Recuperación de Contraseña - Red Social Artesanos
            
            Hola,
            
            Hemos recibido una solicitud para restablecer tu contraseña.
            
            Tu código de verificación es: {$codigo}
            
            Este código es válido por 15 minutos.
            
            Si no solicitaste este cambio, ignora este correo.
            
            ---
            Red Social Artesanos
            © " . date('Y') . " - Todos los derechos reservados
            ";

            $mail->send();
            
            $_SESSION['paso_recuperacion'] = 'verificar';
            header("Location: ../public/recuperarContraseña.php");
            exit();
            
        } catch (Exception $e) {
            $_SESSION['error_email'] = "Error al enviar el correo: {$mail->ErrorInfo}";
    $_SESSION['paso_recuperacion'] = 'solicitar';
    header("Location: ../public/recuperarContraseña.php");
    exit();
        }
        
    } else {
        $_SESSION['error_email'] = "El correo no está registrado en nuestro sistema.";
        $_SESSION['paso_recuperacion'] = 'solicitar';
        header("Location: ../public/recuperarContraseña.php");
        exit();
        }
    }

}


// ==================== PASO 2: VERIFICAR CÓDIGO ====================
if(isset($_POST['verificarCodigo'])){


    
    
    $codigoIngresado = $_POST['codigoVerificacion'];

    $error_cod=[];

    if(empty($codigoIngresado)){
        $error_cod['error_codigo_sinI']="Debe ingresar el codigo";
    }

    if(!empty($error_cod)){
        $_SESSION['errorCodigo']=$error_cod;
    }else{
        
        $codigoIngresado = mysqli_real_escape_string($conexionBD->getConexion(),$_POST['codigoVerificacion']);

    // Verificar que existe sesión de código
    if(!isset($_SESSION['codigo_recuperacion'])){
        $_SESSION['error_codigo'] = "Sesión expirada. Solicita un nuevo código.";
        $_SESSION['paso_recuperacion'] = 'solicitar';
        header("Location: ../public/recuperarContraseña.php");
        exit();
    }
    
    // Verificar si el código ha expirado
    if(time() > $_SESSION['codigo_expiracion']){
        $_SESSION['error_codigo'] = "El código ha expirado. Solicita uno nuevo.";
        $_SESSION['paso_recuperacion'] = 'solicitar';
        unset($_SESSION['codigo_recuperacion']);
        unset($_SESSION['codigo_expiracion']);
        header("Location: ../public/recuperarContraseña.php");
        exit();
    }
    
    // Verificar si el código es correcto
    if($codigoIngresado === $_SESSION['codigo_recuperacion']){
        $_SESSION['paso_recuperacion'] = 'nueva_contraseña';
        $_SESSION['codigo_verificado'] = true;
        unset($_SESSION['codigo_recuperacion']); // Eliminar código usado
        header("Location: ../public/recuperarContraseña.php");
        exit();
    } else {
        $_SESSION['error_codigo'] = "Código incorrecto. Verifica e intenta nuevamente.";
        $_SESSION['paso_recuperacion'] = 'verificar';
        header("Location: ../public/recuperarContraseña.php");
        exit();
    }

}
}

// ==================== PASO 3: CAMBIAR CONTRASEÑA ====================
if(isset($_POST['cambiarContraseña'])){
    
    // Verificar que el código fue verificado
    if(!isset($_SESSION['codigo_verificado']) || !$_SESSION['codigo_verificado']){
        $_SESSION['error_password'] = "Acceso no autorizado. Debes verificar el código primero.";
        $_SESSION['paso_recuperacion'] = 'solicitar';
        header("Location: ../public/recuperarContraseña.php");
        exit();
    }
    
    $nuevaContraseña = $_POST['nuevaContraseña'];
    $confirmarContraseña = $_POST['confirmarContraseña'];
    $email = $_SESSION['email_recuperacion'];

    $errores_contraseña=[];

    if(empty($nuevaContraseña) || empty($confirmarContraseña)){
        $errores_contraseña['contraseña_incorrecta']="Debe ingresar las contraseñas";
    }

     if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/", $nuevaContraseña)) {
        $errores_contraseña['contraseña_incorrecta']="La contraseña debe tener al menos 8 caracteres, una letra mayúscula y un número";
    }
    

    if(!empty($errores_contraseña)){

        $_SESSION['erroresC']=$errores_contraseña;

    }else{

        $nuevaContraseña =mysqli_real_escape_string($conexionBD->getConexion(),$_POST['nuevaContraseña']);
        $confirmarContraseña = mysqli_real_escape_string($conexionBD->getConexion(),$_POST['confirmarContraseña']);
    

    // Validar que las contraseñas coincidan
    if($nuevaContraseña !== $confirmarContraseña){
        $_SESSION['error_password'] = "Las contraseñas no coinciden.";
        $_SESSION['paso_recuperacion'] = 'nueva_contraseña';
        header("Location: ../public/recuperarContraseña.php");
        exit();
    }
    
    // Validar longitud mínima
    if(strlen($nuevaContraseña) < 8){
        $_SESSION['error_password'] = "La contraseña debe tener al menos 8 caracteres.";
        $_SESSION['paso_recuperacion'] = 'nueva_contraseña';
        header("Location: ../public/recuperarContraseña.php");
        exit();
    }
    
    // Encriptar la contraseña
    $contraseñaHash = password_hash($nuevaContraseña, PASSWORD_DEFAULT);
    
    // Actualizar en la base de datos
    $sql = "UPDATE `usuario` SET `contraseña`='$contraseñaHash' WHERE `email`='$email'";
    $resultado = $conexionBD->ejecutarInstruccion($sql);
    
    if($resultado){
        // Limpiar todas las sesiones de recuperación
        unset($_SESSION['codigo_verificado']);
        unset($_SESSION['email_recuperacion']);
        unset($_SESSION['codigo_expiracion']);
        
        $_SESSION['exito_recuperacion'] = "¡Contraseña actualizada exitosamente! Ya puedes iniciar sesión.";
        $_SESSION['paso_recuperacion'] = 'nueva_contraseña';
        
        // Redirigir al login después de 3 segundos (puedes usar JavaScript para esto)
        header("Location: ../public/login.php");
        exit();
    } else {
        $_SESSION['error_password'] = "Error al actualizar la contraseña. Intenta nuevamente.";
        $_SESSION['paso_recuperacion'] = 'nueva_contraseña';
        header("Location: ../public/recuperarContraseña.php");
        exit();
    }

}

}

$conexionBD->cerrar_conexion();

// Si no hay ninguna acción, redirigir al inicio
header("Location: ../public/recuperarContraseña.php");
exit();
?>