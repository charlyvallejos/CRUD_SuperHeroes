<?php
    ini_set('display_errors', 0);
    require_once('modulos/controladorEditoriales.php');
    require_once('modulos/controladorSA.php');
    
    //$controladorEditoriales = new controladorEditoriales();
    function listaEditoriales()
    {         
        $controladorEditoriales = new controladorEditoriales();
        $editoriales = $controladorEditoriales->listar();
        
        if($editoriales->num_rows > 0)
        {
            $comboBox = "<select id='editorial' name='slc_editorial' required>";
                $comboBox .= "<option value=''>- - -</option>";
                while($row = mysqli_fetch_array($editoriales))
                {
                    $comboBox .= sprintf("<option value='%d'>%s</option>",$row['id_editorial'], $row['editorial']);
                }
            $comboBox .= "</select>";
            
            $editoriales->free();            
        }
        
        $controladorEditoriales = NULL;
        return ($comboBox);
    }
    
    function listaEditorialesActual($editorial)
    {         
        $controladorEditoriales = new controladorEditoriales();
        $editoriales = $controladorEditoriales->listar();
        
        if($editoriales->num_rows > 0)
        {
            $comboBox = "<select id='editorial' name='slc_editorial' required>";
                $comboBox .= "<option value=''>- - -</option>";
                while($row = mysqli_fetch_array($editoriales))
                {
                    $selected = ($row['id_editorial'] == $editorial) ? "selected " : "";
                    $comboBox .= sprintf("<option value='%d' $selected >%s</option>",$row['id_editorial'], $row['editorial']);
                }
            $comboBox .= "</select>";
            
            $editoriales->free();            
        }
        
        $controladorEditoriales = NULL;
        return ($comboBox);
    }
    
    function altaHeroe()
    {
        $form = "<form id='alta-heroe' class='formulario' data-insertar>";
            $form .= "<fieldset>";
                $form .= "<legend>Alta de Super Héroe:</legend>";
                $form .= "<div>";
                    $form .= "<label for='nombre'>Nombre: </label>";
                    $form .= "<input type='text' id='nombre' name='txt_nombre' required />";
                $form .= "</div>"; 
                $form .= "<div>";
                    $form .= "<label for='imagen'>Imagen: </label>";
                    $form .= "<input type='text' id='imagen' name='txt_imagen' required />";
                $form .= "</div>";
                $form .= "<div>";
                    $form .= "<label for='descripcion'>Descripcion: </label>";
                    $form .= "<textarea id='descripcion' name='txa_descripcion' required ></textarea>";
                $form .= "</div>";
                $form .= "<div>";
                    $form .= "<label for='editorial'>Editorial: </label>";
                    $form .= listaEditoriales();
                $form .= "</div>";
                $form .= "<div>";
                    $form .= "<input type='submit' id='btn-insertar' name='btn_insertar' value='Insertar' />";
                    $form .= "<input type='hidden' id='transaccion' name='transaccion' value='insertar' />";
                $form .= "</div>";
            $form .= "</fieldset>";
        $form .= "</form>";
        
        return printf($form);
    }
    
    function editarHeroe($datos)
    {
        $datos = mysqli_fetch_array($datos);
        $form = "<form id='editar-heroe' class='formulario' data-editar>";
            $form .= "<fieldset>";
                $form .= "<legend>Alta de Super Héroe:</legend>";
                $form .= "<div>";
                    $form .= "<label for='nombre'>Nombre: </label>";
                    $form .= "<input type='text' id='nombre' name='txt_nombre' value ='".$datos['nombre']."' required />";
                $form .= "</div>"; 
                $form .= "<div>";
                    $form .= "<label for='imagen'>Imagen: </label>";
                    $form .= "<input type='text' id='imagen' name='txt_imagen' value='".$datos['imagen']."'required />";
                $form .= "</div>";
                $form .= "<div>";
                    $form .= "<label for='descripcion'>Descripcion: </label>";
                    $form .= "<textarea id='descripcion' name='txa_descripcion' required >".$datos['descripcion']."</textarea>";
                $form .= "</div>";
                $form .= "<div>";
                    $form .= "<label for='editorial'>Editorial: </label>";
                    $form .= listaEditorialesActual($datos['editorial']);
                $form .= "</div>";
                $form .= "<div>";
                    $form .= "<input type='submit' id='btn-modificar' name='btn_modificar' value='Modificar' />";
                    $form .= "<input type='hidden' id='transaccion' name='transaccion' value='modificar' />";
                    $form .= "<input type='hidden' id='idHeroe' name='idHeroe' value='".$datos['id_heroe']."' />";
                $form .= "</div>";
            $form .= "</fieldset>";
        $form .= "</form>";
        
        //$datos->free();
        return printf($form);
    }
    
    function mostrarHeroe()
    {
        $controladorEditoriales = new controladorEditoriales();
        $editoriales = $controladorEditoriales->listar();
    
        $editorialesArray = array();
        while($dato = mysqli_fetch_array($editoriales))
        {
            $editorialesArray[$dato['id_editorial']] = $dato['editorial'];
        }

        $controladorSA = new controladorSA();
        $superamigos = $controladorSA->listar();

        $totalRegistros = $superamigos->num_rows;
        if($totalRegistros == 0)
        {
            $respuesta = "<div class='error'>NO HAY REGISTRO DE SUPER HEROES</div>";
        }
        else
        {
            //PAGINACION
            $numxPag = 2;
            $pagina = false;

            if(isset($_GET['pag']))
            {
                $pagina = $_GET['pag'];
            }

            if(!$pagina)
            {
                $pagina = 1;
                $inicio = 0;
            }
            else
            {
                $inicio = ($pagina - 1) * $numxPag;
            }

            $totalPaginas = ceil($totalRegistros / $numxPag);

            $superamigos = $controladorSA->listarLimitado($inicio, $numxPag);

            $paginacion = "<div class='paginacion'>";
                $paginacion .= "<p>";
                    $paginacion .= "Número de resultados: <b>$totalRegistros</b>.";
                    $paginacion .= "Mostrando <b>$numxPag</b> resultados por página.";
                    $paginacion .= "Página <b>$pagina</b> de <b>$totalPaginas</b>.";
                $paginacion .= "</p>";

                if ($totalPaginas > 1)
                {
                    $paginacion .= "<p>";
                        $paginacion .= ($pagina != 1) ? "<a href='?pag=".($pagina-1)."'>&laquo</a>" :"";
                        for($i; $i <= $totalPaginas;$i++)
                        {
                            $actual = "<span class='actual'>$pagina</span>";
                            $enlace = "<a href='?pag=$i'>$i</a>";
                            $paginacion .= ($i == $pagina) ? $actual : $enlace;
                        }
                        $paginacion .= ($pagina != $totalPaginas) ? "<a href='?pag=".($pagina+1)."'>&raquo</a>" : "";
                    $paginacion .= "</p>";
                }
            $paginacion .= "</div>";
            //FIN DE PAGINACION
            //TABLA
            $tabla = "<table id='tabla-heroes' class='tabla' data-mostrar>";
                $tabla .= "<thead>";
                    $tabla .= "<tr>";
                        $tabla .= "<th>Id Heroe</th>";
                        $tabla .= "<th>Nombre</th>";
                        $tabla .= "<th>Imagen</th>";
                        $tabla .= "<th>Descripcion</th>";
                        $tabla .= "<th>Editorial</th>";
                        $tabla .= "<th></th>";
                        $tabla .= "<th></th>";
                    $tabla .= "</tr>";
                $tabla .= "</thead>";
                $tabla .= "<tbody>";
                while($row = mysqli_fetch_array($superamigos)){            
                    $tabla .= "<tr>";
                        $tabla .= "<td>".$row['id_heroe']."</td>";
                        $tabla .= "<td><h2>".$row['nombre']."</h2></td>";
                        $tabla .= "<td><img src='./img/".$row['imagen']."'/></td>";
                        $tabla .= "<td>".$row['descripcion']."</td>";
                        $tabla .= "<td><h3>".$editorialesArray[$row['editorial']]."</h3></td>";
                        $tabla .= "<td><a href='#' class='editar' data-id=".$row['id_heroe'].">Editar</a></td>";
                        $tabla .= "<td><a href='#' class='eliminar' data-id=".$row['id_heroe'].">Eliminar</a></td>";
                    $tabla .= "</tr>"; 
                }
                $superamigos->free();
                $tabla .= "</tbody>";            
            $tabla .= "</table>";                
            //FIN DE TABLA

            $respuesta = $tabla.$paginacion;
        }
        
        $superamigos->free();
        
        $controladorEditoriales = null;
        $controladorSA = null;
        return printf($respuesta);
    }

?>

