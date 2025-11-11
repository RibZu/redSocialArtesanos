<?php



    $conexionDB=new Conexion();

    $seguidor=false;
    $estado="vacio";

    $idUsuarioSolicitaSeguir=$_SESSION['idUsuario'];
    
   $idUsuarioParaSeguir=$_GET['idUsuarios'];
    
    $sqlVerSeguimento="SELECT seguimiento.estado,seguimiento.id_usuario_seguido, seguimiento.id_usuario_seguidor FROM seguimiento  WHERE id_usuario_seguidor='$idUsuarioSolicitaSeguir' AND id_usuario_seguido='$idUsuarioParaSeguir'";

    $verSeguidor=$conexionDB->ejecutarConsulta($sqlVerSeguimento);

    $sql="SELECT id_usuario FROM usuario WHERE id_usuario='$idUsuarioParaSeguir'"; /*  */


    $datos=$conexionDB->ejecutarConsulta($sql);



    if(!empty($verSeguidor)){

        if($datos[0]['id_usuario']==$verSeguidor[0]['id_usuario_seguido']){
            $seguidor=true;

            $estado= match ((int)$verSeguidor[0]['estado']) { /* el match es como un switch() depende lo que me ingrese va a tomar un valor la variable */
                1 => "pendiente",
                2 => "aceptado",
                3 => "rechazado"
            };

            

        }

}

if(isset($_POST['accionBoton'])){

    $accion=$_POST['accionBoton'];
    $idUsuarioSeguido=$datos[0]['id_usuario'];
    $idUsuarioSolicitaSeguir=$_SESSION['idUsuario'];

    switch($accion){
         case "seguirBoton":$sql="INSERT INTO seguimiento (id_usuario_seguido, id_usuario_seguidor,estado) VALUES ('$idUsuarioSeguido','$idUsuarioSolicitaSeguir','1')";
                            $conexionDB->ejecutarInstruccion($sql);
                            $seguidor=true;
                            $estado="pendiente";
                            break;
        case "cancelarBoton":$sql="DELETE FROM seguimiento WHERE seguimiento.id_usuario_seguidor='$idUsuarioSolicitaSeguir' AND seguimiento.id_usuario_seguido='$idUsuarioSeguido'";
                             $conexionDB->ejecutarInstruccion($sql);
                             $seguidor=false;
                            $estado="vacio";
                             break;
    }

   

}




$conexionDB->cerrar_conexion();

?>