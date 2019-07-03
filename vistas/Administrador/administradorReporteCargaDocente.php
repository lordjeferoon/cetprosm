 <?php
    $mysqli = new mysqli(SERVER,USER,PASS,DB);
?>
<div class="contenido-main">
                <div class="titulo-formulario">
                    <h2><span>Reporte de </span>Carga Docente</h2>
                </div>
                <form action="<?php echo SERVERURL;?>administradorReporteAlumnosMatriculados" method="POST">
                    <div class="form-row">
                        <div class="form-group col-md-5">
 
                        </div>
                        <div class="form-group col-md-5">

                        </div>
                        <div class="form-group col-md-2">
                            <br>
                            <!--<button type="submit" class="btn boton-registrar btn-success w-100">Exportar a PDF</button>-->
                        </div>
                    </div>
                    <?php 
                        require_once 'controladores/especialidadControlador.php';
                        $insEsp = new especialidadControlador();
                    ?>

                    <?php  
                        $pagina = explode("/", $_GET['views']);
                        echo $insEsp->carga_docente_controlador($pagina[1],1,$_SESSION["privilegio_csm"],$_SESSION["codigo_cuenta_csm"]);
                    ?>
                </form>
</div>