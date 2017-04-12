<?php
    require_once('config.php');
    class conexion extends mysqli{
        public function __construct(){
            parent::__construct(SERVER,USER,PASS,DB);
            $this->query("SET NAMES UTF8");
            $this->connect_errno ? die("Error de conexión") : $x = "Conexión establecida";
            //echo $x;
            unset($x);            
        }
    }
?>

