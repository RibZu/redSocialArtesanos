<?php

class Conexion{

    private $servidor="localhost";
    private $usuario="root";
    private $contraseña=""; // ver contraseña
    private $base_datos="redsocialartesanos";
    private $conexion;

    public function __construct(){
        try{
            $this->conexion=mysqli_connect($this->servidor,$this->usuario,$this->contraseña,$this->base_datos); // conexion a la base de datos

            if (!$this->conexion) {
                throw new Exception("Error al intentar conectarse: " . mysqli_connect_error());
            }
         
        }catch(Exception $e){
            echo "ERROR DE CONEXION". $e->getMessage(); //hubo un error de conexion
        }
    }

    public function getConexion() {
        return $this->conexion;
    }

 public function ejecutarInstruccion($instruccion) {
    try {
        $resultado = mysqli_query($this->conexion, $instruccion);

        if ($resultado === false) {
            $error_mysql = mysqli_error($this->conexion);
            throw new Exception("Error en la instruccion SQL: " . $error_mysql);
        } else {
            $id = mysqli_insert_id($this->conexion);
            
            if ($id > 0) {
                return $id; 
            } else {
                return true; 
            }
        }
    } catch (Exception $e) {
        echo $e->getMessage(); 
        return false;
    }
}

    public function ejecutarConsulta($instruccion){
      
        try {
            $sentencia=mysqli_query($this->conexion,$instruccion);
            
            if($sentencia){
                $datos=[];
                while($fila=mysqli_fetch_assoc($sentencia)){ //por cada fila traigo un arreglo asociativo 
                     $datos[]=$fila;
                }
            return $datos;
        }else{
            $error_mysql=mysqli_error($this->conexion);
            throw new Exception("Error en la consulta SQL". $error_mysql);
            
        }
        } catch (Exception $e) {
            echo $e->getMessage();
             return [];
        }
       
    }

    public function cerrar_conexion(){
        $this->conexion->close();
     
    }

}


?>