<?php
session_start();
include("conexion.php");

$id_usuario = $_SESSION['idUsuario'];
$id_imagen  = $_POST['id_imagen'];

if (!$id_usuario || !$id_imagen) {
    echo json_encode(['success' => false, 'error' => 'Datos inválidos']);
    exit;
}

// Clase Like para manejar los likes
class Like {
    private $bd;

    public function __construct() {
        $this->bd = new Conexion();
    }

    public function toggleLike($id_usuario, $id_imagen) {
        // Verificar si ya existe
        $sqlCheck = "SELECT id_like FROM likes WHERE id_usuario = $id_usuario AND id_imagen = $id_imagen";
        $res = $this->bd->ejecutarConsulta($sqlCheck);

        if (count($res) > 0) {
            // Ya dio like → eliminar
            $sqlDel = "DELETE FROM likes WHERE id_usuario = $id_usuario AND id_imagen = $id_imagen";
            $this->bd->ejecutarInstruccion($sqlDel);
            return ['success' => true, 'action' => 'unliked'];
        } else {
            // No dio like → agregar
            $sqlIns = "INSERT INTO likes (fecha, id_usuario, id_imagen) VALUES (NOW(), $id_usuario, $id_imagen)";
            $this->bd->ejecutarInstruccion($sqlIns);
            return ['success' => true, 'action' => 'liked'];
        }
    }

    public function __destruct() {
        $this->bd->cerrar_conexion();
    }
}

// Ejecutar toggle
$likeObj = new Like();
echo json_encode($likeObj->toggleLike($id_usuario, $id_imagen));
