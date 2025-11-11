<?php
session_start();
require_once("../logica/conexion.php"); 

if(empty($_SESSION['idUsuario'])){
    header("Location: login.php");
    exit();
}

$conexion = new Conexion();
$id_usuario = $_SESSION['idUsuario'];

$directorio_servidor = "../public/resources/imagenesPerfil/";
$directorio_base_datos = "../public/resources/imagenesPerfil/"; 

$html_fotos_almacenadas = "";

if (!is_dir($directorio_servidor)) {
    mkdir($directorio_servidor, 0755, true); 
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['accion']) && $_POST['accion'] == 'subir') {
        
        if (isset($_FILES['nueva_foto']) && $_FILES['nueva_foto']['error'] == 0) {
            
            $archivo = $_FILES['nueva_foto'];
            $archivo_nombre_temporal = $archivo['tmp_name'];
            $archivo_extension = strtolower(pathinfo($archivo['name'], PATHINFO_EXTENSION));
            $nuevo_nombre_archivo = uniqid('perfil-', true) . '.' . $archivo_extension;
            
            $destino_servidor = $directorio_servidor . $nuevo_nombre_archivo;
            $destino_base_datos = $directorio_base_datos . $nuevo_nombre_archivo;
            
            if (move_uploaded_file($archivo_nombre_temporal, $destino_servidor)) {
                $fecha_actual = date("Y-m-d H:i:s"); 
                
                $sql_insert = "INSERT INTO img_perfil (url_img, fecha, id_usuario) 
                                VALUES ('{$destino_base_datos}', '{$fecha_actual}', {$id_usuario})";
                
                $id_nueva_imagen = $conexion->ejecutarInstruccion($sql_insert);
                
                if (is_numeric($id_nueva_imagen) && $id_nueva_imagen > 0) {
                    
                    $sql_update = "UPDATE usuario 
                                    SET img_perfil_actual = {$id_nueva_imagen} 
                                    WHERE id_usuario = {$id_usuario}";
                    
                    $conexion->ejecutarInstruccion($sql_update);
                }
            }
        }
    }

    $conexion->cerrar_conexion();
    header("Location: perfilUsuario.php");
    exit();
}

$sql_fotos = "SELECT url_img 
              FROM img_perfil 
              WHERE id_usuario = {$id_usuario} 
              ORDER BY fecha ASC";

$lista_fotos = $conexion->ejecutarConsulta($sql_fotos);

if ($lista_fotos && count($lista_fotos) > 0) {
    foreach ($lista_fotos as $foto) {
        $url_para_html = htmlspecialchars($foto['url_img']);
        
        $html_fotos_almacenadas .= '<div class="col-md-3 col-6 mb-3">';
        $html_fotos_almacenadas .= '<img src="' . $url_para_html . '" class="img-fluid" style="border-radius: 0.25rem;">';
        $html_fotos_almacenadas .= '</div>';
    }
} else {
    $html_fotos_almacenadas = "<p>No tienes fotos de perfil almacenadas.</p>";
}

$conexion->cerrar_conexion();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Foto de Perfil</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/estilosUsuarios.css">
</head>
<body>

    <div class="container-fluid px-4 profile-section py-5">
        <div class="profile-card p-4">
            <h1 class="h3 mb-4 text-center">Gestionar Fotos de Perfil</h1>
            
            <div class="mb-3">
                <a href="perfilUsuario.php" class="btn btn-action btn-info  btn-primary-custom">
                    <i class="fas fa-arrow-left"></i> Volver al Perfil
                </a>
            </div>

            <h2 class="h5">Subir Nueva Foto</h2>
            <form method="POST" action="gestionar_perfil.php" enctype="multipart/form-data">
                <input type="hidden" name="accion" value="subir">
                <div class="mb-3">
                    <input type="file" name="nueva_foto" class="form-control" accept="image/*" required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-action btn-primary-custom">
                        <i class="fas fa-upload"></i> Subir Foto
                    </button>
                </div>
            </form>

            <hr class="my-4">

            <h2 class="h4 mb-3">Historial de Fotos</h2>
            <div class="row">
                <?php print $html_fotos_almacenadas; ?>
            </div>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>