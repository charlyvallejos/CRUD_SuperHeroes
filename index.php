<?php
    //require_once("./modulos/enrutador.php");
//    require_once('./modulos/controladorSA.php');
//    require_once('./modulos/controladorEditoriales.php');    
    require_once('vistas/vistas.php');
    ini_set('display_errors', 0);
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>CRUD Super Heroes</title>
        <link rel="stylesheet" type="text/css" href="css/estilos.css"/>
    </head>
    <body>
        <header id="cabecera">
            <h1>Super Héroes</h1>
            <div><img src="img/super-heroes.png" alt="Super Héroes" /></div>
            <a href="#" id="insertar">Agregar</a>
        </header>
        <section id="contenido">
            <div id="respuesta"></div>
            <div id="precarga"></div>
            <?php
//                $enrutador = new enrutador();
//                if($enrutador->validarGET($_GET['cargar']))
//                    $enrutador->cargarVista($_GET['cargar']);
                mostrarHeroe();
            ?>
        </section>
        <script src="./js/super-amigos.js"></script>
    </body>
</html>
