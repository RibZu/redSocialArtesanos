<?php

include "../logica/claseDatosUsuarios.php";

$idUsuario=$_SESSION['idUsuario'];


$datosUser=new DatosUser();

$datosUsuario=$datosUser->getDatosUsuario($idUsuario);

$usuarioSeguidores=$datosUser->getSeguidoresUsuario($idUsuario);

$usuarioSeguidos=$datosUser->getSeguidosUsuario($idUsuario);

$usuarioLikes=$datosUser->getLikesUsuario($idUsuario);

 unset($datosUser);
?>