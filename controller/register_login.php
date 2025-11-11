<?php
session_start();

include "../logica/conexion.php";
include "../logica/claseUsuario.php";


if (isset($_POST['enviarRegistro'])) {
    $conexionBD = new Conexion();

    $nombre =  trim($_POST['nombre']);
    $gmail = trim($_POST['gmail']);
    $contraseña = trim($_POST['contraseña']);

    $errores=[];


    if(empty($nombre)){
        $errores['nombre']="debe ingresar el nombre del usuario";
    }
    if(empty($contraseña)){
        $errores['contraseña']="debe ingresar la contraseña";
    }
    if(empty($gmail)){
        $errores['gmail']="debe ingresar el mail";
    }
   
    if (!preg_match("/^[A-Za-zÀ-ÿÑñ]+(?:\s[A-Za-zÀ-ÿÑñ]+)*$/", $nombre)) {
        $errores['nombre'] = "Ingrese bien los datos del nombre";
    }else{
        $_SESSION['datos_correctos']['nombre']=$nombre;
    }

     if (!filter_var($gmail, FILTER_VALIDATE_EMAIL)) {
        $errores['gmail'] = "Ingrese bien los datos del mail";
    }else{
         $_SESSION['datos_correctos']['gmail']=$gmail;
    }

    if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/", $contraseña)) {
        $errores['contraseña'] = "La contraseña debe tener al menos 8 caracteres, una letra mayúscula y un número";
    }

    if(!empty($errores)){
         $_SESSION['errores_registro'] = $errores;
        $_SESSION['mostrar_formulario'] = 'registro';

    }else{

         $nombre = mysqli_real_escape_string($conexionBD->getConexion(),$nombre);
    $gmail =  mysqli_real_escape_string($conexionBD->getConexion(),$gmail);
    $contraseña = password_hash($contraseña, PASSWORD_DEFAULT);

    $check_de_mail = $conexionBD->ejecutarConsulta("SELECT `email` FROM `usuario` WHERE email='$gmail'");

    if ($check_de_mail && count($check_de_mail) > 0) {
        $_SESSION['error_mail'] = "Este email ya ha sido registrado";
        $_SESSION['mostrar_formulario'] = 'registro';
          $_SESSION['datos_correctos']['nombre'] = $nombre;
        
    
      
    } else {
        $usuario = new Usuario($nombre, "", $gmail, $contraseña, "", "");
        $sql = "INSERT INTO `usuario`(`nombre`, `email`, `contraseña`) VALUES ('$usuario->nombre','$usuario->gmail','$usuario->contraseña')";
        $conexionBD->ejecutarInstruccion($sql);

        $_SESSION['exito_registro'] = "Te registraste correctamente";
        $_SESSION['mostrar_formulario'] = 'registro'; 
          unset($_SESSION['datos_correctos']);

        $conexionBD->cerrar_conexion();

       
       
    }

}
}


if (isset($_POST['enviarLogin'])) {
    $conexionBD = new Conexion();

    $gmail =  trim($_POST['gmailLogin']);
    $contraseña =  trim($_POST['contraseñaLogin']);

    $erroresLogin=[];

    if(empty($gmail)){
        $erroresLogin['gmail']="Debe ingresar el mail";
    }

    if(empty($contraseña)){
        $erroresLogin['contraseña']="debe ingresar la contraseña";
    }

    if (!filter_var($gmail, FILTER_VALIDATE_EMAIL)) {
        $erroresLogin['gmail'] = "Correo inválido";
    }

     if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/", $contraseña)) {
        $erroresLogin['contraseña'] = "La contraseña debe tener al menos 8 caracteres, una letra mayúscula y un número";
    }
   
    if(!empty($erroresLogin)){
         $_SESSION['errores_login'] = $erroresLogin;
        $_SESSION['mostrar_formulario'] = 'login';

    }else{

        $gmail =  mysqli_real_escape_string($conexionBD->getConexion(),$gmail);
    $contraseña =  mysqli_real_escape_string($conexionBD->getConexion(),$contraseña);

    $sql = "SELECT * FROM `usuario` WHERE email='$gmail'";
    $datos = $conexionBD->ejecutarConsulta($sql); 

    if ($datos && count($datos) > 0) {
        $fila = $datos[0];

        if($fila['email']==$gmail){

            
        if (password_verify($contraseña, $fila['contraseña'])) {
           
            $_SESSION['idUsuario']=$fila['id_usuario'];
            header("Location: ../public/index.php");
            exit();

    
          
           
        } else {
            $_SESSION['error_login'] = "Email o contraseña incorrectos";
            $_SESSION['mostrar_formulario'] = 'login';
           
            
        }
            
        }else{
             $_SESSION['error_login'] = "Email o contraseña incorrectos";
            $_SESSION['mostrar_formulario'] = 'login';
        }


    



    } else {
        $_SESSION['error_sesion'] = "No se ha registrado todavía";
        $_SESSION['mostrar_formulario'] = 'login';
        
       
    }

    $conexionBD->cerrar_conexion();

}
}


