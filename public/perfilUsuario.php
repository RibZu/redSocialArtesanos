<?php
session_start();

require_once "../logica/conexion.php";
include "../controller/GaleriaUsuario.php";
include "../controller/DatosPerfil.php";
if(empty($_SESSION['idUsuario'])){

      header("Location: ../public/login.php");
    exit();

}
$id_usuario = $_SESSION['idUsuario'];
$galeria = new ContenidoImagen();
if(isset($_POST['cerrar'])){ //cierra la session
    include "../logica/cerrar_session.php";
}



?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
                        <a href="perfilUsuario.php" class="selected">
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
                <form method="POST" >
                         <button type="submit" name="cerrar" class="btn btn-action btn-secondary" data-bs-toggle="modal" data-bs-target="#crearAlbumModal">
                            <i></i> Cerrar Sesion
                        </button>
                </form>
                 
                
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

                    <div class="d-flex gap-3 justify-content-center flex-wrap mt-4">
                        <a href="Perfil.php">
                            <button class="btn btn-action btn-primary-custom" data-bs-toggle="modal" data-bs-target="#subirFotoModal">
                                <i class="fas fa-upload"></i> Completar Perfil
                            </button>
                        </a>
                     
                        <a href="CrearAlbum.php">
                             <button class="btn btn-action btn-secondary" data-bs-toggle="modal" data-bs-target="#crearAlbumModal">
                            <i class="fas fa-folder-plus"></i> Crear Álbum
                        </button>
                        </a>
                       

                        <a href="../public/solicitudes.php">
                         <button class="btn btn-action btn-success" >
                            <i class="fas fa-user-plus"></i> Solicitudes
                        </button>
                        </a>
                        
                       
                    </div>

                  
                    
                </div>
            </div>
        </div>

        <ul class="nav nav-tabs nav-tabs-custom" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link <?php echo (!isset($_GET['album']) && !isset($_GET['albumLikes'])) ? 'active' : ''; ?>" data-bs-toggle="tab" data-bs-target="#photos" type="button">
                    <i class="fas fa-images"></i> Fotografías
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link <?php echo (isset($_GET['album']) || isset($_GET['albumLikes'])) ? 'active' : ''; ?>" data-bs-toggle="tab" data-bs-target="#albums" type="button">
                    <i class="fas fa-folder"></i> Álbumes
                </button>
            </li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane fade mt-5 <?php echo (!isset($_GET['album']) && !isset($_GET['albumLikes'])) ? 'show active' : ''; ?>" id="photos" role="tabpanel">
                <div class="gallery-wrapper">
                    <div class="photo-grid">

                        <?php foreach($datos as $fila){ ?>
                        <div class="photo-item large">
                            <img src="<?php echo $fila['url_imagen']; ?>" alt="<?php echo $fila['titulo']; ?>">
                            <div class="photo-overlay">
                                <h3 class="photo-title"><?php echo $fila['titulo']; ?></h3>
                            </div>
                        </div>
                        <?php } ?>

                    </div>
                </div>
            </div>

            <?php  ?>

            <div class="tab-pane fade <?php echo (isset($_GET['album']) || isset($_GET['albumLikes'])) ? 'show active' : ''; ?>" id="albums" role="tabpanel">
                <div class="row g-4 mt-3 ">


                <?php if(isset($_GET['albumLikes'])){ ?>

                        <div class="mb-4">
                            <a href="perfilUsuario.php" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Volver
                            </a>
                        </div>

                        <div class="tab-pane fade show active" id="photos" role="tabpanel">
                            <div class="gallery-wrapper">
                                <div class="photo-grid">

                                    <?php foreach($AlbumImagenesLikesUsuario as $imagenes){ ?>
                                    <div class="photo-item large">
                                        <img src="<?php echo $imagenes['url_imagen']; ?>" alt="<?php echo $imagenes['titulo']; ?>">
                                        <div class="photo-overlay">
                                            <h3 class="photo-title"><?php echo $imagenes['titulo']; ?></h3>
                                        </div>
                                    </div>
                                    <?php } ?>

                                </div>
                            </div>
                        </div>
                    
                    <?php }elseif(isset($_GET['album'])){ ?>

                        <div class="mb-4">
                            <a href="perfilUsuario.php" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Volver
                            </a>
                        </div>

                        <div class="tab-pane fade show active" id="photos" role="tabpanel">
                            <div class="gallery-wrapper">
                                <div class="photo-grid">

                                    <?php foreach($albumContenido as $imagenes){ ?>
                                    <div class="photo-item large">
                                        <img src="<?php echo $imagenes['url_imagen']; ?>" alt="<?php echo $imagenes['titulo']; ?>">
                                        <div class="photo-overlay">
                                            <h3 class="photo-title"><?php echo $imagenes['titulo']; ?></h3>
                                        </div>
                                    </div>
                                    <?php } ?>

                                </div>
                            </div>
                        </div>
                    
                    <?php }else{ ?>

                    <?php foreach($imagenesAlbum as $valor){ ?>
                        
                            <div class="col-12 col-sm-6 col-md-4">
                                <a href="perfilUsuario.php?album=<?php echo $valor['id_album']; ?>" class="text-decoration-none text-dark">
                                    <div class="card border-0 shadow-sm h-100">
                                        <img src="<?php echo $valor['url_imagen']; ?>" style="height: 200px; object-fit: cover;" class="card-img-top" alt="Album">
                                        <div class="card-body">
                                            <h5 class="card-title"><?php echo $valor['titulo'] ?></h5>
                                            <p class="text-muted mb-0"><i class="fas fa-images"></i> <?php echo $valor['cantidadImagenes'] ?></p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        
                    <?php } ?>
                    <?php if(!empty($albumUsuarioLikeado)){ ?>

                    <?php foreach ($albumUsuarioLikeado as $valor) { ?>

                        <div class="col-12 col-sm-6 col-md-4">
                                <a href="perfilUsuario.php?albumLikes=<?php echo $valor['id_usuario']; ?>" class="text-decoration-none text-dark">
                                    <div class="card border-0 shadow-sm h-100">
                                        <img src="<?php echo $valor['url_imagen']; ?>" style="height: 200px; object-fit: cover;" class="card-img-top" alt="Album">
                                        <div class="card-body">
                                            <h5 class="card-title"><?php echo "".$valor['nombre']." ".$valor['apellido']; ?></h5>
                                            <p class="text-muted mb-0"><i class="fas fa-images"></i> <?php echo $valor['cantidadImagenes'] ?></p>
                                        </div>
                                    </div>
                                </a>
                            </div>

                    <?php  } ?>

                    <?php } ?>

                    <?php } ?>
                    
                </div>
            </div>
        </div>
    </div>
</main>
    <footer>
        <p>&copy; <?php echo date("Y"); ?> Red Social Artesanos </p>
    </footer>
    <script src="../assets/nav.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
</body>
</html>