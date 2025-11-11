<?php
session_start(); 

require_once("conexion.php");

if(empty($_SESSION['idUsuario'])){
    header("Location: ../public/login.php");
    exit();
}

$conexion = new Conexion(); 

$directorio_fisico = "../public/uploads/"; 
$directorio_url = "uploads/"; 

if(!is_dir($directorio_fisico)){
    mkdir($directorio_fisico, 0755, true);
}

if($_SERVER["REQUEST_METHOD"]==="POST"){
    
    $id_usuario = $_SESSION['idUsuario'];
    $titulo_album = trim($_POST['albumTitle']);
    $opcion_titulo = $_POST['opcionTitulo'];
    
    $sql_album = "INSERT INTO album(titulo, id_usuario) VALUES ('{$titulo_album}', '{$id_usuario}')";
    $album_id = $conexion->ejecutarInstruccion($sql_album);

    if ($album_id) { 
        $files = $_FILES['albumImages'];
        $file_contador = count($files['name']);
        
        $ids_fotos_nuevas = array(); 

        for($i = 0; $i < $file_contador; $i++){
            $file_nombre = $files['name'][$i];
            $file_temp_nombre = $files['tmp_name'][$i];
            $file_extension = strtolower(pathinfo($file_nombre, PATHINFO_EXTENSION));
            $nuevo_file_name = uniqid('img-', true) . '.' . $file_extension;
            
            $destination_fisico = $directorio_fisico . $nuevo_file_name;
            $destination_url = $directorio_url . $nuevo_file_name;

            $visibilidad = (int)$_POST["visibilidad"];
            
            $titulo = "";
            if ($opcion_titulo == "album") {
                $titulo = $titulo_album;
            } elseif ($opcion_titulo == "numerar") {
                $titulo = ($i + 1);
            } else {
                $titulo = "Foto " . ($i + 1); 
            }
            
            if (move_uploaded_file($file_temp_nombre, $destination_fisico)) {
                
                $sql_imagen = "INSERT INTO imagen(id_album, url_imagen, privacidad, id_usuario, titulo) 
                             VALUES ({$album_id}, '{$destination_url}', {$visibilidad}, {$id_usuario}, '{$titulo}')";
                
                $foto_id = $conexion->ejecutarInstruccion($sql_imagen); 
                
                if($foto_id){
                    $ids_fotos_nuevas[] = $foto_id;
                }
            }
        }
        
        $conexion->cerrar_conexion();

        if ($opcion_titulo == "editar" && count($ids_fotos_nuevas) > 0) {
            $ids_url = implode(",", $ids_fotos_nuevas);
            header("Location: ../public/editarfoto.php?fotos_ids=" . $ids_url);
            exit();
        } else {
            header("Location: ../public/perfilUsuario.php");
            exit();
        }

    } else {
        print("Error al crear album");
    }
}

$conexion->cerrar_conexion();
exit();
?>