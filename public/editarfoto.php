<?php
session_start();
require_once("../logica/conexion.php"); 

if(empty($_SESSION['idUsuario'])){
    header("Location: login.php");
    exit();
}

$conexion = new Conexion();
$id_usuario = $_SESSION['idUsuario'];
$html_fotos = "";

if (isset($_POST['accion']) && $_POST['accion'] == 'guardar_cambios') {
    
    $titulos = $_POST['titulos']; 
    $privacidades = $_POST['privacidades']; 

    foreach ($titulos as $id_foto => $titulo) {
        $privacidad = (int)$privacidades[$id_foto];
        
        $sql = "UPDATE imagen 
                SET titulo = '{$titulo}', privacidad = {$privacidad} 
                WHERE id_imagen = {$id_foto} AND id_usuario = {$id_usuario}";
        
        $conexion->ejecutarInstruccion($sql);
    }
    
    $conexion->cerrar_conexion();
    
    header("Location: perfilUsuario.php");
    exit();
}

if (!isset($_GET['fotos_ids'])) {
    print "Error: No se especificaron fotos para editar.";
    $conexion->cerrar_conexion();
    exit();
}

$ids_recibidos = $_GET['fotos_ids']; 

$sql = "SELECT id_imagen, url_imagen, titulo, privacidad 
        FROM imagen 
        WHERE id_imagen IN ({$ids_recibidos}) AND id_usuario = {$id_usuario}";

$resultado = $conexion->ejecutarConsulta($sql);

if ($resultado && count($resultado) > 0) {
    foreach ($resultado as $foto) {
        
        $url_imagen_completa = htmlspecialchars($foto['url_imagen']);
   

        $titulo_foto = htmlspecialchars($foto['titulo']);
        $id_imagen = $foto['id_imagen'];

        $selected_publico = ($foto['privacidad'] == 1) ? 'selected' : '';
        $selected_privado = ($foto['privacidad'] == 2) ? 'selected' : '';

    
        $html_fotos .= '
        <div class="col-md-4 mb-3">
            <div class="card p-3">
                
                <img src="' . $url_imagen_completa . '" class="mb-2" style="width: 100%; height: 150px; object-fit: cover; border-radius: .25rem;">
                
                <div class="mb-2">
                    <label class="form-label form-label-sm">Título:</label>
                    <input type="text" class="form-control" 
                           name="titulos[' . $id_imagen . ']" 
                           value="' . $titulo_foto . '">
                </div>
                
                <div>
                    <label class="form-label form-label-sm">Visibilidad:</label>
                    <select class="form-select" name="privacidades[' . $id_imagen . ']">
                        <option value="1" ' . $selected_publico . '>Público</option>
                        <option value="2" ' . $selected_privado . '>Privado</option>
                    </select>
                </div>
            </div>
        </div>';
    }
} else {
    $html_fotos = "<p class='text-center'>No se encontraron fotos para editar.</p>";
}

$conexion->cerrar_conexion();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Títulos de Fotos</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/estilosUsuarios.css">

</head>
<body>
    <div class="container-fluid px-4 profile-section py-5">
        <div class="profile-card p-4">
            <h1 class="h3 mb-4 text-center">Editar Fotos del Álbum</h1>

            <form action="editarfoto.php" method="POST">
                <input type="hidden" name="accion" value="guardar_cambios">
                
                <div class="row">
                    <?php
                    print $html_fotos;
                    ?>
                </div>

                <div class="text-center mt-3 d-grid">
                    <button type="submit" class="btn btn-action btn-primary-custom">
                        <i class="fas fa-save"></i> Guardar Todos los Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>