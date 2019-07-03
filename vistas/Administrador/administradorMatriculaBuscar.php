 <?php
    if(isset($_POST['cadena'])){
        $buscar = $_POST['cadena'];
    }
?>
<div class="contenido-main">
    <div class="titulo-formulario">
        <h2><span>Buscar </span>Matrícula</h2>
    </div>
    <form action="<?php echo SERVERURL;?>administradorMatriculaBuscar" method="POST">
        <div class="form-row">
            <div class="form-group col-md-7">
                <label class="titulo-label">Ingrese apellidos completos, nombres completos o DNI:</label>
                    <input type="text" name="cadena" class="form-control" required autofocus style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" autocomplete="off">
            </div>
            <div class="form-group col-md-2">

            </div>
            <div class="form-group col-md-3">
                <br>
                <button type="submit" class="btn boton-registrar btn-success w-100">Buscar</button>
            </div>
        </div>
    </form>

    <br>
    <br>

    <?php 
        if(isset($_POST['cadena'])){
            require_once 'controladores/matriculaControlador.php';
            $insMatricula= new matriculaControlador();
     
            $pagina = explode("/", $_GET['views']);
            echo $insMatricula->paginador_matriculas_alumno_controlador($_SESSION["privilegio_csm"],$_SESSION["codigo_cuenta_csm"], $buscar);
        }
    ?>
</div>