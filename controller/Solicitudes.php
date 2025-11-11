<?php

 $conexionDB=new Conexion();

 $idUsuario=$_SESSION['idUsuario'];

 $sql="SELECT usuario.nombre, usuario.apellido, seguimiento.estado,seguimiento.id_usuario_seguido,seguimiento.id_usuario_seguidor,seguimiento.id_seguimiento FROM seguimiento INNER JOIN usuario ON seguimiento.id_usuario_seguidor=usuario.id_usuario WHERE seguimiento.id_usuario_seguido='$idUsuario' AND seguimiento.estado=1";

 $solicitudes=$conexionDB->ejecutarConsulta($sql);


 if(isset($_POST['accion'])){

    $solicitud=$_POST['accion'];
    $idSeguidor=$_POST['id_seguimiento'];
    $idSeguimiento=$_POST['id_delSeguimiento'];

    switch ($solicitud){
        case "aceptar":
                $sql="UPDATE seguimiento SET estado=2 WHERE id_usuario_seguido='$idUsuario' AND id_usuario_seguidor='$idSeguidor'";
                $conexionDB->ejecutarInstruccion($sql);
                header("Location: ../public/solicitudes.php");


            break;
        case "rechazar":

            $sql="DELETE FROM seguimiento WHERE id_usuario_seguidor='$idSeguidor' AND id_usuario_seguido='$idUsuario' AND id_seguimiento='$idSeguimiento'";
            $conexionDB->ejecutarInstruccion($sql);
             header("Location: ../public/solicitudes.php");

            break;
    }

 }


 $conexionDB->cerrar_conexion();

?>