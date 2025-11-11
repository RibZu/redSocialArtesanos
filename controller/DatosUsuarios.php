<?php

include "../logica/claseDatosUsuarios.php";

$datosUser=new DatosUser();

$idPerfilUsuarios=$_GET['idUsuarios'];

 $datosUsuario=$datosUser->getDatosUsuario($idPerfilUsuarios);

 $usuarioSeguidores=$datosUser->getSeguidoresUsuario($idPerfilUsuarios);

$usuarioSeguidos=$datosUser->getSeguidosUsuario($idPerfilUsuarios);

$usuarioLikes=$datosUser->getLikesUsuario($idPerfilUsuarios);



 unset($datosUser);
?>