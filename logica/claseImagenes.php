<?php

require_once "../logica/conexion.php";

class ContenidoImagen{


    private $conexionDB;

    public function __construct(){
       $this->conexionDB=new Conexion();
    }

    public function getCantidadImagenesAlbum($idUsuario){
        /*consulta de imagenes de albumnes */

        $sqlAlbum="SELECT imagen.id_album,album.titulo,imagen.url_imagen, COUNT(imagen.id_imagen) AS cantidadImagenes FROM album INNER JOIN imagen ON album.id_album=imagen.id_album WHERE album.id_usuario='$idUsuario'  GROUP BY  album.id_album, album.titulo";

        $imagenesAlbum=$this->conexionDB->ejecutarConsulta($sqlAlbum);

        return $imagenesAlbum;

    }

    public function getTotalImagenes($idUsuario){

        
        /* cantidad de imagenes en total de la persona */

        $sqlImagenes="SELECT  COUNT(imagen.id_imagen) AS cantidadImagenes FROM imagen WHERE imagen.id_usuario='$idUsuario'";

        $imagenesTotal=$this->conexionDB->ejecutarConsulta($sqlImagenes); /* aca se hace la consulta */

        return $imagenesTotal;

    }

    public function getImagenesAlbum($idAlbum, $idUsuario, $estado = null) {

        // Si es el propio usuario
        if ($idUsuario == $_SESSION['idUsuario']) {
            $sql = "SELECT imagen.id_imagen, imagen.url_imagen, imagen.titulo, usuario.nombre, usuario.id_usuario
                    FROM imagen 
                    INNER JOIN album ON imagen.id_album = album.id_album
                    INNER JOIN usuario ON album.id_usuario = usuario.id_usuario
                    WHERE imagen.id_album='$idAlbum' AND album.id_usuario='$idUsuario'";
            $albumContenido = $this->conexionDB->ejecutarConsulta($sql);
            return $albumContenido;
        }

        // Si el estado es "aceptado" (se puede ver)
        if ($estado == "aceptado") {
            $sql = "SELECT imagen.id_imagen, imagen.url_imagen, imagen.titulo, usuario.nombre, usuario.id_usuario
                    FROM imagen 
                    INNER JOIN album ON imagen.id_album = album.id_album
                    INNER JOIN usuario ON album.id_usuario = usuario.id_usuario
                    WHERE imagen.id_album='$idAlbum'";
            $albumContenido = $this->conexionDB->ejecutarConsulta($sql);
            return $albumContenido;
        }

        // Si no es aceptado (privacidad)
        $sql = "SELECT imagen.id_imagen, imagen.url_imagen, imagen.titulo, usuario.nombre, usuario.id_usuario
                FROM imagen 
                INNER JOIN album ON imagen.id_album = album.id_album
                INNER JOIN usuario ON album.id_usuario = usuario.id_usuario
                WHERE imagen.id_album='$idAlbum' AND imagen.privacidad=1";
        $albumContenido = $this->conexionDB->ejecutarConsulta($sql);
        return $albumContenido;
    }

   

    public function getAlbumUsuarioLikeado($idUsuario){

        $sql="SELECT usuario.id_usuario, usuario.nombre, usuario.apellido,imagen.url_imagen, COUNT(imagen.id_imagen) AS cantidadImagenes 
        FROM likes INNER JOIN imagen ON likes.id_imagen=imagen.id_imagen INNER JOIN usuario ON imagen.id_usuario=usuario.id_usuario
        INNER JOIN seguimiento ON seguimiento.id_usuario_seguido=imagen.id_usuario AND seguimiento.id_usuario_seguidor=likes.id_usuario
        WHERE likes.id_usuario='$idUsuario' GROUP BY usuario.id_usuario,usuario.nombre, usuario.apellido";

        $resultado=$this->conexionDB->ejecutarConsulta($sql);

        return $resultado;

    }

    public function getImagenesLikesUsuario($idUsuario,$idUsuarioSeguido){

        $sql="SELECT  imagen.id_imagen, imagen.url_imagen, imagen.titulo, usuario.nombre, usuario.id_usuario 
        FROM likes INNER JOIN usuario ON likes.id_usuario=usuario.id_usuario INNER JOIN imagen ON likes.id_imagen=imagen.id_imagen 
        WHERE likes.id_usuario='$idUsuario' AND imagen.id_usuario='$idUsuarioSeguido'";

        $resultado=$this->conexionDB->ejecutarConsulta($sql);

        return $resultado;


    }

    public function getImagenesEstado($idUsuario, $estado = null) {

        /* trae todas las imagaenes para mostrar dependiendo el estado, en caso de querer mostrar las imaganes del perfil propio a estado lo inicializa como NULL */

        if ($idUsuario == $_SESSION['idUsuario']) {
            $sql = "SELECT imagen.id_imagen, imagen.url_imagen, imagen.titulo, usuario.nombre, usuario.id_usuario 
                    FROM imagen 
                    INNER JOIN usuario ON imagen.id_usuario = usuario.id_usuario 
                    WHERE imagen.id_usuario='$idUsuario'";

            $datos = $this->conexionDB->ejecutarConsulta($sql);
            return $datos;
        }

        if ($estado == "aceptado") {
            $sql = "SELECT imagen.id_imagen, imagen.url_imagen, imagen.titulo, usuario.nombre, usuario.id_usuario 
                    FROM imagen 
                    INNER JOIN usuario ON imagen.id_usuario = usuario.id_usuario 
                    WHERE imagen.id_usuario='$idUsuario'";

            $datos = $this->conexionDB->ejecutarConsulta($sql);
            return $datos;

        } else {
            $sql = "SELECT imagen.id_imagen, imagen.url_imagen, imagen.titulo, usuario.nombre, usuario.id_usuario 
                    FROM imagen 
                    INNER JOIN usuario ON imagen.id_usuario = usuario.id_usuario 
                    WHERE imagen.id_usuario='$idUsuario' AND imagen.privacidad=1";

            $datos = $this->conexionDB->ejecutarConsulta($sql);
            return $datos;
        }

    }

    function obtenerImagenes($id_usuario, $cant = null) {
        if ($cant) {
            $sql = "SELECT imagen.id_imagen, imagen.url_imagen, usuario.id_usuario, usuario.nombre, imagen.titulo, imagen.privacidad, COUNT(likes.id_like) AS cantidad_likes
                    FROM imagen
                    JOIN usuario ON imagen.id_usuario = usuario.id_usuario
                    LEFT JOIN seguimiento 
                        ON seguimiento.id_usuario_seguido = usuario.id_usuario
                        AND seguimiento.id_usuario_seguidor = $id_usuario
                    LEFT JOIN likes ON likes.id_imagen = imagen.id_imagen
                    WHERE (imagen.privacidad = 1 
                    OR (imagen.privacidad = 2 AND seguimiento.id_usuario_seguidor IS NOT NULL))
                    AND imagen.id_usuario != $id_usuario
                    GROUP BY imagen.id_imagen, imagen.url_imagen, usuario.id_usuario, usuario.nombre, imagen.titulo, imagen.privacidad
                    ORDER BY cantidad_likes DESC
                    LIMIT $cant";
        } else {
            $sql = "SELECT imagen.id_imagen, imagen.url_imagen, usuario.id_usuario, usuario.nombre, imagen.titulo, imagen.privacidad, COUNT(likes.id_like) AS cantidad_likes
                    FROM imagen
                    JOIN usuario ON imagen.id_usuario = usuario.id_usuario
                    LEFT JOIN seguimiento 
                        ON seguimiento.id_usuario_seguido = usuario.id_usuario
                        AND seguimiento.id_usuario_seguidor = $id_usuario
                    LEFT JOIN likes ON likes.id_imagen = imagen.id_imagen
                    WHERE (imagen.privacidad = 1 
                    OR (imagen.privacidad = 2 AND seguimiento.id_usuario_seguidor IS NOT NULL))
                    AND imagen.id_usuario != $id_usuario
                    GROUP BY imagen.id_imagen, imagen.url_imagen, usuario.id_usuario, usuario.nombre, imagen.titulo, imagen.privacidad
                    ORDER BY cantidad_likes DESC";
        }

        $imagenes = $this->conexionDB->ejecutarConsulta($sql);
        return $imagenes;
    }



    function mostrarGaleria($imagenes) {
        $id_usuario = $_SESSION['idUsuario'];
        $numCols = 4;
        $cols = array_fill(0, $numCols, '');
        
        foreach ($imagenes as $index => $img) {
            $colIndex = $index % $numCols;
            $id_imagen = $img['id_imagen'];

            // Consulta si el usuario ya dio like
            $sql_like = "SELECT 1 FROM likes WHERE id_usuario = $id_usuario AND id_imagen = $id_imagen";
            $resultado = $this->conexionDB->ejecutarConsulta($sql_like);

            $yaDioLike = count($resultado) > 0;
            if ($yaDioLike) {
                $icono = "favorite";
            } else {
                $icono = "favorite_border";
            }


            $cols[$colIndex] .= "
                <div class='img-card'>
                    <img src='" . $img['url_imagen'] . "' 
                        alt='" . $img['titulo'] . "' 
                        class='masonry-img'
                        data-autor-id='" . $img['id_usuario'] . "'
                        data-autor-nombre='" . $img['nombre'] . "'
                        data-autor-perfil='" . $this->obtenerFotoPerfil($img['id_usuario']) . "'>
                    <div class='img-overlay'>
                        <div class='img-title'>" . $img['titulo'] . "</div>
                        <div class='actions'>
                            <button class='Btn like' data-id='" . $img['id_imagen'] . "'>
                                <i class='material-icons'>{$icono}</i>
                            </button>
                        </div>
                    </div>
                </div>";
        }

        echo "<div id='masonry'>";
        foreach ($cols as $col) echo "<div class='column'>$col</div>";
        echo "</div>";
    }

    function obtenerFotoPerfil($id_usuario) {
        //obtiene la imagen del usuario de $id_usuario
        $sql = "SELECT url_img 
                FROM img_perfil 
                WHERE id_imagen_perfil = (
                    SELECT img_perfil_actual 
                    FROM usuario 
                    WHERE id_usuario = $id_usuario
                )";
        $rows=$this->conexionDB->ejecutarConsulta($sql);
        if (!empty($rows)) {
            return $rows[0]['url_img']; 
        } else {
            return "resources/imagenesPerfil/default.png"; // imagen por defecto
        }
    }

     public function __destruct(){
        
    }
}









?>