<?php
    require('clases/editorial.php');
    class controladorEditoriales{
        //Atributos
        protected $editorial;
        
        //Metodos
        public function __construct() {
            $this->editorial = new editorial();
        }
        
        public function listar(){
            $resultado = $this->editorial->listar();
            return $resultado;
        }
        
        
    }

?>

