<?php

    require_once('conexion.php'); 
    
    class superAmigo{
        //Atributos
        protected $id_heroe;
        protected $nombre;
        protected $imagen;
        protected $descripcion;
        protected $editorial;
        
        protected $conn;                                
        
        //Metodos
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
            $sql = "SELECT * FROM Heroes";
            $resultado = $this->conn->query($sql);            
            return $resultado;
        }
        
        public function listarLimitado($inicio, $fin){
            $sql = "SELECT * FROM Heroes LIMIT $inicio, $fin";
            $resultado = $this->conn->query($sql);           
            return $resultado;
        }
        
        public function insertar(){
            $sql = "INSERT INTO Heroes(nombre,imagen,descripcion,editorial) VALUES('$this->nombre','$this->imagen',"
                    . "'$this->descripcion',$this->editorial)";
            if($this->conn->query($sql))
                return true;
            else
                return false;
        }
        
    }

?>

