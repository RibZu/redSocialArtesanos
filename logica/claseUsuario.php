<?php

class Usuario{
    
    public function __construct( // properties promotion, evitar duplicar codigo
        private  $nombre,
        private ?string $apellido="",
        private  $gmail,
        private $contraseña,
        private ?string $intereses="",
        private ?string $antecedentes=""

    ){

    }

    public function __get($valor){
            return $this->$valor;

    }

    public function __set($campo,$valor){
            return $this->$campo=$valor;

    }

    


}

?>