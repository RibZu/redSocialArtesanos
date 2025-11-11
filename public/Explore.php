<?php
session_start();
if (!isset($_SESSION['idUsuario'])) {
    header("Location: login.php");
    exit();
}
include("../logica/claseImagenes.php"); //funciones
$id_usuario = $_SESSION['idUsuario'];
$galeria = new ContenidoImagen();
?>



<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>explorar</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="../assets/galeria.css">
        <link rel="stylesheet" href="../assets/nav.css">
        
        
    </head>

    <body>



        <header>
            <div class="left">
                <div class="menu-container">
                    <div class="menu" id="menu">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
                <div class="brand">
                    <img src="resources/icon/logo pagina.png" alt="logo" class="logo">
                    <span class="name"></span>
                </div>
            </div>
            <div class="right">
                <a href="solicitudes.php" class="icon-header">
                    <img src="resources/icon/noti.svg">
                </a>
                <img src="<?php echo $galeria->obtenerFotoPerfil($id_usuario); ?>" alt="Foto de perfil" class="user">


            </div>
        </header>
        <div class="sidebar" id="sidebar">
            <nav>
                <ul class="opciones">
                    <li>
                        <a href="Index.php" class="">
                            <img src="resources/icon/Home.svg" alt="">
                            <span>inicio</span>
                        </a>
                    </li>
                    <li>
                        <a href="CrearAlbum.php" class="">
                            <img src="resources/icon/New.svg" alt="">
                            <span>crear</span>
                        </a>
                    </li>
                    <li>
                        <a href="perfilUsuario.php" class="">
                            <img src="resources/icon/Profile.svg" alt="">
                            <span>perfil</span>
                        </a>
                    </li>
                    <li>
                        <a href="Explore.php" class="selected">
                            <img src="resources/icon/explore.svg" alt="">
                            <span>explorar</span>
                        </a>
                    </li>
                    
                </ul>
            </nav>
        </div>

        <main>
            <?php $galeria->mostrarGaleria($galeria->obtenerImagenes($id_usuario)); ?>
        </main>

    <!-- Modal -->
    <div id="Modal" class="Modal">
        <div class="Modal-content">
            <div class="Modal-left">
                <img src="" alt="Imagen ampliada" id="Modal-img">
            </div>
            <div class="Modal-right">
                <div class="autor-like">
                    <div class="img-title" id="Modal-titulo"></div>
                    <div class="acciones-Modal">
                        <img id="perfil-autor" src="" alt="Foto de perfil">
                        <div id="Modal-autor"><a href="" id="nombre-autor"></a></div>
                            <button class="like-Btn">
                                <i class="material-icons">favorite_border</i>
                            </button>
                    </div>
                </div>
                <div class="comentarios" id="Modal-comentarios"></div>
                <div class="add-comment">
                    <input type="text" id="nuevo-comentario" placeholder="Escribe un comentario...">
                    <button id="Btn-comentar">Enviar</button>
                </div>
            </div>
            <span class="cerrar">×</span>
        </div>
    </div>
    <footer>
        <p>&copy; <?php echo date("Y"); ?> Red Social Artesanos </p>
    </footer>
        <script src="../assets/nav.js"></script>
        <script src="../assets/main.js"></script>
    </body>
</html>