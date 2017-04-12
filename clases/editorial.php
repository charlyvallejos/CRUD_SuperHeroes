<?php
    require_once('conexion.php');
    
    class editorial{
        protected $id_editorial;
        protected $editorial;
        
        protected $conn;
        
        public function __construct() {
            $this->conn = new conexion();
        }
        
        public function get($atributo){
            return $this->$atributo;
        }
        
        public function set($atributo, $valor){
            $this->$atributo = $valor;
        }
        
        public function listar(){
            $sql = "SELECT * FROM editorial";
            $resultado = $this->conn->query($sql);
            return $resultado;
        }
    }

?>
