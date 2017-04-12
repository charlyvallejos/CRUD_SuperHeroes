<?php

    require_once('clases/superamigo.php');
    
    class controladorSA{
        //Atributos
        protected $superamigo;
        
        //Metodos
        public function __construct() {
            $this->superamigo = new superAmigo();
        }
        
        public function listar(){
            $resultado = $this->superamigo->listar();
            return $resultado;
        }
        
        public function listarLimitado($inicio, $fin){
            $resultado = $this->superamigo->listarLimitado($inicio, $fin);
            return $resultado;
        }
        
        public function insertar($nombre, $imagen, $descripcion, $editorial){
            $this->superamigo->set('nombre', $nombre);
            $this->superamigo->set('imagen', $imagen);
            $this->superamigo->set('descripcion', $descripcion);
            $this->superamigo->set('editorial', $editorial);
            
            $resultado = $this->superamigo->insertar();
            return $resultado;
        }
        
        public function eliminar($id_heroe){
            $this->superamigo->set('id_heroe', $id_heroe);
            
            $resultado = $this->superamigo->eliminar();
            return $resultado;
        }
    }


?>

