<?php

include "../logica/claseImagenes.php";



$claseImagen=new ContenidoImagen();

$idPerfilUsuarios=$_GET['idUsuarios'];

$imagenesAlbum=$claseImagen->getCantidadImagenesAlbum($idPerfilUsuarios);

$imagenesTotal=$claseImagen->getTotalImagenes($idPerfilUsuarios);



if(isset($_GET['album'])){
    $idAlbum=(int)$_GET['album'];

    $albumContenido=$claseImagen->getImagenesAlbum($idAlbum,$idPerfilUsuarios,$estado);

}



$datos=$claseImagen->getImagenesEstado($idPerfilUsuarios,$estado);


unset($claseImagen);


?>