<?php
    class enrutador{
        public function cargarVista($vista){
            switch ($vista)
            {
                case 'ver':
                    require_once('./vistas/'.$vista.'.php');
                    break;
            }
        }
        
        public function validarGET($var){
            if(empty($var))
            {
                require_once('./vistas/inicio.php');
                return false;
            }
            else
            {
                return true;
            }
        }
    }

?>
