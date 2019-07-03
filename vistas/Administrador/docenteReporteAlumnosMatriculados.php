<?php
    $pagina = explode("/", $_GET['views']);
    $modulo=$lc->decryption($pagina[2]);
    $grupo=$lc->decryption($pagina[3]);
?>
<div class="contenido-main">
    <div class="titulo-formulario">
        <h2>Reporte de <span>Alumnos matriculados</span></h2>
    </div>
 
    <?php 
        require_once 'controladores/matriculaControlador.php';
        $ins = new matriculaControlador();
    ?>

    <?php  
        $pagina = explode("/", $_GET['views']);
        echo $ins->paginador_alumnos_matriculados_controlador($_SESSION["privilegio_csm"],$_SESSION["codigo_cuenta_csm"],$modulo,$grupo);
    ?>
                    
</div>