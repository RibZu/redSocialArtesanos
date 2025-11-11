<?php
/* aca se van a traer todos los datos del perfil del usuario nombre,apellido, antecedentes...etc */
require_once "../logica/conexion.php";
 class DatosUser{

    private $conexionDB;

    public function __construct(){

        $this->conexionDB=new Conexion();

    }

    public function getDatosUsuario($idUsuario){

        $sql="SELECT img_perfil.url_img,usuario.nombre, usuario.apellido, usuario.interes,usuario.antecedentes FROM usuario LEFT JOIN img_perfil ON usuario.img_perfil_actual=img_perfil.id_imagen_perfil WHERE usuario.id_usuario='$idUsuario'";

        $datosUsuario=$this->conexionDB->ejecutarConsulta($sql);

        return $datosUsuario;

    }

    public function getSeguidoresUsuario($idUsuario){

        $sql="SELECT COUNT(id_usuario_seguidor) AS cantidadSeguidores FROM seguimiento WHERE id_usuario_seguido='$idUsuario' AND estado=2";

        $resultado=$this->conexionDB->ejecutarConsulta($sql);

        return $resultado;
    }

    public function getSeguidosUsuario($idUsuario){

        $sql="SELECT COUNT(id_usuario_seguido) AS cantidadSeguidos FROM seguimiento WHERE id_usuario_seguidor='$idUsuario' AND estado=2";
        $resultado=$this->conexionDB->ejecutarConsulta($sql);

        return $resultado;

    }

    public function getLikesUsuario($idUsuario){

       $sql="SELECT COUNT(likes.id_imagen) as cantidadLikes FROM likes INNER JOIN imagen ON likes.id_imagen=imagen.id_imagen WHERE imagen.id_usuario='$idUsuario'";

       $resultado=$this->conexionDB->ejecutarConsulta($sql);

       return $resultado;

    }
    
    public function __destruct(){
        
    }
}









?>