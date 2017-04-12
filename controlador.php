<?php
    require('vistas/vistas.php');
    //require('modulos/controladorSA.php');
    $transaccion = $_POST['transaccion'];
    
    function ejecutarTransaccion($transaccion)
    {
        if ($transaccion == 'alta')
        {
            altaHeroe();
            //return printf('hola mundo');
        }
        else if ($transaccion == 'insertar')
        {
            $controladorSA = new controladorSA();
            $resultado = $controladorSA->insertar($_POST['txt_nombre'], $_POST['txt_imagen'], $_POST['txa_descripcion'], $_POST['slc_editorial']);
            if($resultado)
            {
                $respuesta = "<div class='exito' data-recargar>Se insertó con éxito el Superhéroe: <b>".$_POST['txt_nombre']."</b></div>";
            }
            else
            {
                $respuesta = "<div class='error'>Error al insertar el Superhéroe: <b>".$_POST['txt_nombre']."</b></div>";
            }
            
            return printf($respuesta);
        }
        else if ($transaccion == 'baja')
        {
            
        }
                            
    }
    
    ejecutarTransaccion($transaccion);

?>