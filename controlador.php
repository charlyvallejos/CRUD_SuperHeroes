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
            //alert($resultado);
            return printf($respuesta);
        }
        else if ($transaccion == 'baja')
        {
            $controladorSA = new controladorSA();
            $resultado = $controladorSA->eliminar($_POST['idHeroe']);
            
            if($resultado)
            {
                $respuesta = "<div class='exito' data-recargar>Se eliminó con éxito el Superhéroe Id: <b>".$_POST['idHeroe']."</b></div>";
            }
            else
            {
                $respuesta = "<div class='error'>Error al eliminar el Superhéroe Id: <b>".$_POST['idHeroe']."</b></div>";
            }
            
            return printf($respuesta);
        }
        else if($transaccion == 'editar')
        {
            $controladorSA = new controladorSA();
            $resultado= $controladorSA->busqueda($_POST['idHeroe']);
            
            editarHeroe($resultado);
        }
        else if($transaccion == 'modificar')
        {
            $controladorSA = new controladorSA();
            $resultado = $controladorSA->editar($_POST['idHeroe'], $_POST['txt_nombre'], $_POST['txt_imagen'], $_POST['txa_descripcion'], $_POST['slc_editorial']);
            if($resultado)
            {
                $respuesta = "<div class='exito' data-recargar>Se modificó con éxito el Superhéroe: <b>".$_POST['txt_nombre']."</b></div>";
            }
            else
            {
                $respuesta = "<div class='error'>Error al modificar el Superhéroe: <b>".$_POST['txt_nombre']."</b></div>";
            }
            return printf($respuesta);
        }
                            
    }
    
    ejecutarTransaccion($transaccion);

?>