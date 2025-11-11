<?php

include "../logica/claseImagenes.php";
$claseImagen=new ContenidoImagen();

$idUsuario=$_SESSION['idUsuario'];

$imagenesAlbum=$claseImagen->getCantidadImagenesAlbum($idUsuario);

$albumUsuarioLikeado=$claseImagen->getAlbumUsuarioLikeado($idUsuario);

$imagenesTotal=$claseImagen->getTotalImagenes($idUsuario);



if(isset($_GET['album'])){
    $idAlbum=(int)$_GET['album'];

    $albumContenido=$claseImagen->getImagenesAlbum($idAlbum,$idUsuario);

}

if(isset($_GET['albumLikes'])){
    $idUsuarioAlbum=(int)$_GET['albumLikes'];

    $AlbumImagenesLikesUsuario=$claseImagen->getImagenesLikesUsuario($idUsuario,$idUsuarioAlbum);

}



$datos=$claseImagen->getImagenesEstado($idUsuario);



unset($claseImagen);

?>