<?php
session_start(); 

include '../logica/conexion.php'; 

if(!$_SESSION['idUsuario']){
    header("Location:login.php");
    exit();
}

$conexion = new Conexion(); 
 
$id_usuario_actual = $_SESSION['idUsuario'];

$mensaje = ""; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    extract($_POST); 

    $sql_update = "UPDATE usuario SET 
                    nombre = '$nombre', 
                    apellido = '$apellido', 
                    email = '$email', 
                    interes = '$interes', 
                    antecedentes = '$antecedentes'";

    if (!empty($nueva_contraseña)) { 
        $hash_contraseña = password_hash($nueva_contraseña, PASSWORD_DEFAULT);
        $sql_update .= ", contraseña = '$hash_contraseña'"; 
    }

    $sql_update .= " WHERE id_usuario = $id_usuario"; 

    $resultado_update = $conexion->ejecutarInstruccion($sql_update);

    if ($resultado_update) { 
        $mensaje = '<p style="color:green; font-weight:bold;">¡Perfil actualizado con éxito!</p>';
    } else {
        $mensaje = '<p style="color:red; font-weight:bold;">Error al actualizar el perfil.</p>';
    }
}

$sql_select = "SELECT id_usuario, nombre, apellido, email, interes, antecedentes FROM usuario WHERE id_usuario = $id_usuario_actual";

$datos_usuario = $conexion->ejecutarConsulta($sql_select); 

$usuario = null;
if (!empty($datos_usuario)) { 
    $usuario = $datos_usuario[0]; 
} else {
    die("Error: Usuario no encontrado."); 
}

$conexion->cerrar_conexion(); 

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/estilosUsuarios.css">
</head>
<body>

    <div class="container-fluid px-4 profile-section min-vh-100 d-flex align-items-center py-5">
        <div class="profile-card p-4 w-100" style="max-width: 30rem; margin: auto;">
            
            <h1 class="h3 mb-3 text-center">Mi Perfil</h1>
            <p class="text-center text-muted">Aquí puedes ver y actualizar tus datos personales.</p>
            
            <div class="text-center mb-3">
                <?php echo $mensaje; ?>
            </div>

            <form action="perfil.php" method="POST"> 
            
                <input type="hidden" name="id_usuario" value="<?php echo htmlspecialchars($usuario['id_usuario']); ?>">

                <div class="mb-3"> 
                    <label for="nombre" class="form-label">Nombre:</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($usuario['nombre'] ?? ''); ?>">
                </div>

                <div class="mb-3">
                    <label for="apellido" class="form-label">Apellido:</label>
                    <input type="text" class="form-control" id="apellido" name="apellido" value="<?php echo htmlspecialchars($usuario['apellido'] ?? ''); ?>">
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($usuario['email'] ?? ''); ?>">
                </div>

                <div class="mb-3">
                    <label for="interes" class="form-label">Intereses:</label>
                    <textarea class="form-control" id="interes" name="interes"><?php echo htmlspecialchars($usuario['interes'] ?? ''); ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="antecedentes" class="form-label">Antecedentes:</label>
                    <textarea class="form-control" id="antecedentes" name="antecedentes"><?php echo htmlspecialchars($usuario['antecedentes'] ?? ''); ?></textarea>
                </div>
                
                <hr class="my-4">

                <div class="mb-3">
                    <label for="nueva_contraseña" class="form-label">Nueva Contraseña:</label>
                    <input type="password" class="form-control" id="nueva_contraseña" name="nueva_contraseña" placeholder="Dejar en blanco para no cambiar">
                </div>

                <div class="d-grid gap-2 mt-4">
                    <button type="submit" class="btn btn-action btn-primary-custom">
                        <i class="fas fa-save"></i> Actualizar Perfil
                    </button> 
                    <a href="gestionar_perfil.php" class="btn btn-action btn-secondary">
                        <i class="fas fa-camera"></i> Editar foto de usuario
                    </a>
                    <a href="PerfilUsuario.php" class="btn btn-action btn-primary-custom">
                        <i class="fas fa-arrow-left"></i> Volver a Perfil
                    </a>
                </div>
                
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>