<div class="contenido-main">
                <div class="titulo-formulario">
                    <h2>Seleccionar Módulo <span>para descargar nómina</span> </h2>
                </div>

                <br><br>
                
                <br>
                <?php 
                    require_once 'controladores/docenteControlador.php';
                    $ins = new docenteControlador();
                ?>

                <?php  
                    $pagina = explode("/", $_GET['views']);
                    echo $ins->paginador_docente_seleccionar_nomina_controlador($pagina[1],10,$_SESSION["privilegio_csm"],$_SESSION["codigo_cuenta_csm"]);
                ?> 
</div>