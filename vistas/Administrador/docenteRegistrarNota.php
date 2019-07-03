<div class="contenido-main">
    <div class="titulo-formulario">
        <h2>Registrar <span>Notas</span></h2>
    </div>

    <form action="<?php echo SERVERURL;?>ajax/asignacionAjax.php" method="POST" data-form="guardar" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
                    
        <br>

        <?php 
            require_once 'controladores/asignacionControlador.php';
            $ins = new asignacionControlador();
        ?>

        <div class="form-row"> 
            <div class="form-group col-md-3">
                <label class="titulo-label">Capacidad Terminal</label>
                <input type="number" class="form-control" name="unidad" min="1" max="8" required>
            </div>
        </div>

        <br>

        <?php  
            $pagina = explode("/", $_GET['views']);
            echo $ins->formulario_nota_controlador($pagina[1],$_SESSION["codigo_cuenta_csm"]);
        ?>

        <br>
        <br>
        <div class="botones">
            <button type="submit" class="btn boton-registrar btn-success col-xs-4">Guardar</button>
        </div>
        

        <div class="RespuestaAjax"></div>
                    
    </form>
</div>