<?php
session_start();



require_once "../logica/conexion.php";
include "../controller/solicitarSeguimiento.php";
include "../controller/controladorImagenes.php";
include "../controller/DatosUsuarios.php";
$galeria = new ContenidoImagen();


if(empty($_GET['idUsuarios'])){
    header("Location:index.php");
}else{
    $idUsuariosPerfiles = $_GET['idUsuarios'];
}


if (empty($_SESSION['idUsuario'])) {
    header("Location: ../public/login.php");
    exit();
}else{
    $id_usuario = $_SESSION['idUsuario'];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Fotógrafo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/galeria.css">
    <link rel="stylesheet" href="../assets/estilosUsuarios.css">
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
                        <a href="Explore.php" class="">
                            <img src="resources/icon/explore.svg" alt="">
                            <span>explorar</span>
                        </a>
                    </li>
                    
                </ul>
            </nav>
        </div>

<main>
    <div class="container-fluid px-4 profile-section">
        <div class="profile-card">
            <div class="row">
                <div class="col-12 text-center">

                    <?php foreach ($datosUsuario as $info) { ?>

                    <?php if(empty($info['url_img'])){ ?>

                    <img src="<?php echo "../public/resources/imagenesPerfil/default.png"; ?>" 
                         alt="Profile" class="profile-avatar">
                    <?php }else{ ?>

                     <img src="<?php echo $info['url_img']; ?>" 
                         alt="Profile" class="profile-avatar">
                    <?php } ?>
                    
                    <h2 class="mt-3 mb-0">
                        <?php echo $info['nombre'];?>
                        <?php echo $info['apellido']; ?>
                       
                    </h2>
                    
                    <p class="text-muted">
                       <i class="fa fa-tag" aria-hidden="true"></i>
                       <?php if(empty($info['interes'])){?>
                            <?php echo "No ha indicado sus intereses" ?>
                        <?php }else{ ?>
                            <?php echo $info['interes']; ?>
                        <?php } ?>
                    </p>
                    
                    <p class="mt-3 mb-0">
                        <?php if(empty($info['antecedentes'])){?>
                            <?php echo "No ha indicado sus antecedentes" ?>
                        <?php }else{ ?>
                            <?php echo $info['antecedentes']; ?>
                        <?php } ?>
    
                    </p>

                    <?php } ?>

                    <div class="stats-container">
                        <div class="stat-item">
                            <span class="stat-value"><?php echo $usuarioSeguidores[0]['cantidadSeguidores']; ?></span>
                            <span class="stat-label">Seguidores</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-value"><?php echo $usuarioSeguidos[0]['cantidadSeguidos']; ?></span>
                            <span class="stat-label">Siguiendo</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-value"><?php echo $usuarioLikes[0]['cantidadLikes']; ?></span>
                            <span class="stat-label">Me Gusta</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-value"><?php echo $imagenesTotal[0]['cantidadImagenes']; ?></span>
                            <span class="stat-label">Fotografías</span>
                        </div>
                    </div>

                            
                    <form method="post">
                        <?php if ($seguidor == false) { ?>
                            <div class="d-flex gap-3 justify-content-center flex-wrap mt-4">
                                <button name="accionBoton" value="seguirBoton" class="btn btn-action btn-primary-custom">
                                    <i class="fas fa-user-plus"></i> Seguir
                                </button>
                            </div>  

                        <?php } elseif ($estado == "aceptado") { ?>
                            <div class="d-flex gap-3 justify-content-center flex-wrap mt-4">
                                <button class="btn btn-action btn-primary-custom" disabled>
                                    <i class="fa-solid fa-user"></i> Siguiendo
                                </button>
                            </div>

                        <?php } elseif ($estado == "pendiente") { ?>
                            <div class="d-flex gap-3 justify-content-center flex-wrap mt-4">
                                <button name="accionBoton" value="cancelarBoton" class="btn btn-action btn-primary-custom">
                                    <i class="fa-solid fa-user"></i> Cancelar solicitud
                                </button>
                            </div>
                        <?php } ?>
                    </form>
                </div>
            </div>
        </div>

        <ul class="nav nav-tabs nav-tabs-custom" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link <?php echo !isset($_GET['album']) ? 'active' : ''; ?>" 
                        data-bs-toggle="tab" data-bs-target="#photos" type="button">
                    <i class="fas fa-images"></i> Fotografías
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link <?php echo isset($_GET['album']) ? 'active' : ''; ?>" 
                        data-bs-toggle="tab" data-bs-target="#albums" type="button">
                    <i class="fas fa-folder"></i> Álbumes
                </button>
            </li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane fade mt-5 <?php echo !isset($_GET['album']) ? 'show active' : ''; ?>" id="photos" role="tabpanel">
                <?php $galeria->mostrarGaleria($galeria->getImagenesEstado($idUsuariosPerfiles, $estado)); ?>
            </div>

            <div class="tab-pane fade <?php echo isset($_GET['album']) ? 'show active' : ''; ?>" id="albums" role="tabpanel">
                <div class="row g-4 mt-3">
                    
                    <?php if (isset($_GET['album'])) { ?>
                        <div class="mb-4">
                            <a href="perfilUsuarios.php?idUsuarios=<?php echo $idUsuariosPerfiles; ?>" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Volver
                            </a>
                        </div>

                        <div>
                            <?php
                                $galeria->mostrarGaleria(
                                    $galeria->getImagenesAlbum($_GET['album'], $idUsuariosPerfiles, $estado)
                                );
                            ?>
                        </div>

                    <?php } else { ?>
                        <?php foreach ($imagenesAlbum as $valor) { 
                            $portada = isset($valor['url_portada'])
                                ? $valor['url_portada']
                                : (isset($valor['url_imagen']) ? $valor['url_imagen'] : 'resources/imagenesPerfil/default.png');
                        ?>
                            <div class="col-12 col-sm-6 col-md-4">
                                <a href="perfilUsuarios.php?idUsuarios=<?php echo $idUsuariosPerfiles; ?>&album=<?php echo $valor['id_album']; ?>" 
                                   class="text-decoration-none text-dark">
                                    <div class="card border-0 shadow-sm h-100">
                                        <img src="<?php echo $portada; ?>" style="height: 200px; object-fit: cover;" 
                                             class="card-img-top" alt="Portada del álbum">
                                        <div class="card-body">
                                            <h5 class="card-title"><?php echo $valor['titulo']; ?></h5>
                                            <p class="text-muted mb-0"><i class="fas fa-images"></i> <?php echo $valor['cantidadImagenes']; ?></p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

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
</main>
        <footer>
        <p>&copy; <?php echo date("Y"); ?> Red Social Artesanos </p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/main.js"></script>
    <script src="../assets/nav.js"></script>
</body>
</html>
