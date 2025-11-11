<?php
session_start();


require_once "../logica/conexion.php";
include "../controller/Solicitudes.php";



if(empty($_SESSION['idUsuario'])){

      header("Location: ../public/login.php");
    exit();

}


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitudes de Seguimiento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/estilosSeguimiento.css">
</head>
<body>
    
    <div class="container py-4">
        <div class="mb-4">
            <a href="perfilUsuario.php" class="btn-back">
                <i class="fas fa-arrow-left"></i> Volver al perfil
            </a>
        </div>

        <div class="page-header">
            <h3>
                <i class="fas fa-user-plus me-2"></i>
                Solicitudes de Seguimiento
                <span class="badge-count"><?php echo count($solicitudes); ?></span>
            </h3>
        </div>

        <div class="solicitudes-container">
            

            <?php if(!empty($solicitudes)){?>
          

                <?php foreach ($solicitudes as $valores) { ?>
            <div class="solicitud-card">
                <div class="row align-items-center g-3">
                    <div class="col-auto">
                        <div class="avatar-wrapper">
                            <img src="<?php echo "../public/resources/imagenesPerfil/default.png"; ?>" 
                                 alt="Avatar" class="avatar-solicitud">
                            <div class="avatar-badge">
                                <i class="fas fa-star text-white"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="user-info">
                            <h5><?php echo $valores['nombre'] ?> <?php echo $valores['apellido'] ?></h5>
                            <div class="user-interest">
                                <i class="fas fa-camera"></i>
                                <span>Fotografía de naturaleza</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-auto">
                        <div class="action-buttons">
                            <form method="POST" class="d-inline">
                                <input type="hidden" name="id_seguimiento" value="<?php echo $valores['id_usuario_seguidor'] ?>">
                                <input type="hidden" name="id_delSeguimiento" value="<?php echo $valores['id_seguimiento'] ?>">
                                <button type="submit" name="accion" value="aceptar" class="btn btn-aceptar">
                                    <i class="fas fa-check me-1"></i> Aceptar
                                </button>
                            </form>
                            <form method="POST" class="d-inline">
                                <input type="hidden" name="id_seguimiento" value="<?php echo $valores['id_usuario_seguidor'] ?>">
                                <input type="hidden" name="id_delSeguimiento" value="<?php echo $valores['id_seguimiento'] ?>">
                                <button type="submit" name="accion" value="rechazar" class="btn btn-rechazar">
                                    <i class="fas fa-times me-1"></i> Rechazar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <?php } ?>

            <?php }else{ ?>
            
            
        </div>

        
        
        <div class="empty-state">
            <i class="fas fa-inbox"></i>
            <p>No tienes solicitudes de seguimiento pendientes</p>
        </div>
       
            <?php } ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>