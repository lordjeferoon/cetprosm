<?php
    if(isset($_POST['modulo']) && isset($_POST['grupo'])){
        $modulo=$_POST['modulo'];
        $grupo=$_POST['grupo'];    
    }
?>
<div class="contenido-main">
                <div class="titulo-formulario">
                    <h2>Reporte de <span>Alumnos matriculados</span></h2>
                </div>

                <form action="<?php echo SERVERURL;?>administradorReporteAlumnosMatriculados/" method="POST">
                    <div class="form-row"> 
                        <div class="form-group col-md-8">
                            <label class="titulo-label">Modulo</label>                            
                            <select  class="form-control" name="modulo">
                                <?php
                                    $mysqli = new mysqli(SERVER,USER,PASS,DB);
                                    $query = $mysqli -> query ("SELECT * FROM modulos WHERE ESTADO_MODULO='Activo' ORDER BY NOMBRE_MODULO");
                                    echo '<option value="0">SELECCIONE UN MODULO</option>';
                                    while ($valores = mysqli_fetch_array($query)) {
                                        echo '<option value="'.$valores['ID_MODULO'].'">'.$valores['NOMBRE_MODULO'].'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-1">
                            <label class="titulo-label">Grupo</label>
                            <input type="number" min="1" max="3" class="form-control" name="grupo">
                        </div>
                        
                        <div class="form-group col-md-3">
                            <label></label>
                            <button type="submit" class="btn boton-registrar btn-primary w-100">Ver reporte</button>
                        </div>
                    </div>
                </form>
                <br>
                
                <?php
                    if(isset($_POST['modulo']) && isset($_POST['grupo'])){
                        require_once 'controladores/matriculaControlador.php';
                        $ins = new matriculaControlador();
                        $pagina = explode("/", $_GET['views']);
                        echo $ins->paginador_alumnos_matriculados_controlador($_SESSION["privilegio_csm"],$_SESSION["codigo_cuenta_csm"],$modulo,$grupo);
                    }
                ?>
</div>