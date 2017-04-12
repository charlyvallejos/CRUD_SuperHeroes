<?php

    $controladorEditoriales = new editorial();
    $editoriales = $controladorEditoriales->listar();
    
    $editorialesArray = array();
    while($dato = mysqli_fetch_array($editoriales))
    {
        $editorialesArray[$dato['id_editorial']] = $dato['editorial'];
    }
    
    $controladorSA = new superAmigo();
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
        $tabla = "<table id='tabla-heroes' class='tabla'>";
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
    
    printf($respuesta);
    
?>

