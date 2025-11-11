<?php
include("conexion.php");
session_start();

$id_usuario = $_SESSION['idUsuario'];

class Comentario {
    private $bd;

    public function __construct() {
        $this->bd = new Conexion();
    }

    // Obtener comentarios de una imagen
    public function obtenerComentarios($id_img) {
        $id_img = $id_img;
        $sql = "SELECT c.texto, u.nombre 
                FROM comentario c 
                JOIN usuario u ON c.id_usuario = u.id_usuario
                WHERE c.id_imagen = $id_img
                ORDER BY c.fecha ASC";
        $rows = $this->bd->ejecutarConsulta($sql);
        if ($rows) {
            return $rows;
        } else {
            return [];
        }
    }

    // Agregar comentario a una imagen
    public function agregarComentario($id_img, $id_usuario, $texto) {
        $id_img = $id_img;
        $texto = trim($texto);

        if ($texto === '') {
            return ['success' => false, 'error' => 'Texto vacío'];
        }


        $sql = "INSERT INTO comentario (texto, fecha, id_usuario, id_imagen)
                VALUES ('$texto', NOW(), $id_usuario, $id_img)";
        $insert = $this->bd->ejecutarInstruccion($sql);

        if (!$insert) {
            return ['success' => false, 'error' => 'No se pudo agregar el comentario'];
        }

        // Traer nombre del usuario
        $sqlUser = "SELECT nombre FROM usuario WHERE id_usuario = $id_usuario";
        $resUser = $this->bd->ejecutarConsulta($sqlUser);
        if (isset($resUser[0]['nombre'])) {
            $nombre = $resUser[0]['nombre'];
        } else {
            $nombre = 'Yo';
        }


        return ['success' => true, 'nombre' => $nombre, 'texto' => $texto];
    }

    public function __destruct() {
        $this->bd->cerrar_conexion();
    }
}

// AJAX
$comentarioObj = new Comentario();

try {
        if (isset($_POST['id_imagen'], $_POST['texto'])) {
        $id_img = $_POST['id_imagen'];
        $texto = $_POST['texto'];
        echo json_encode($comentarioObj->agregarComentario($id_img, $id_usuario, $texto));
        exit;
    }


    if (isset($_GET['id_imagen'])) {
        $id_img = $_GET['id_imagen'];
        echo json_encode($comentarioObj->obtenerComentarios($id_img));
        exit;
    }

    // Si no es GET ni POST válido
    echo json_encode(['success' => false, 'error' => 'Solicitud no válida']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>
