<?php
    if(isset($_POST['especialidades'])){
        $especialidad=$_POST['especialidades'];  
    }
?>
<div class="contenido-main">
                <div class="titulo-formulario">
                    <h2>Reporte de <span>Alumnos matriculados</span></h2>
                </div>

                <form action="<?php echo SERVERURL;?>administradorReporteAlumnosEspecialidad/" method="POST">
                    <div class="form-row"> 
                        <div class="form-group col-md-9">
                            <label class="titulo-label">Especialidad</label>                            
                            <select  class="form-control" name="especialidades">
                                <?php
                                    $mysqli = new mysqli(SERVER,USER,PASS,DB);
                                    $query = $mysqli -> query ("SELECT * FROM especialidades WHERE ESTADO_ESPECIALIDAD='Activo' ORDER BY NOMBRE_ESPECIALIDAD");
                                    echo '<option value="0">SELECCIONE UNA ESPECIALIDAD</option>';
                                    while ($valores = mysqli_fetch_array($query)) {
                                        echo '<option value="'.$valores['ID_ESPECIALIDAD'].'">'.$valores['NOMBRE_ESPECIALIDAD'].'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label></label>
                            <button type="submit" class="btn boton-registrar btn-primary w-100">Ver reporte</button>
                        </div>
                    </div>
                </form>
                <br>
                
                <?php
                    if(isset($_POST['especialidades'])){
                        if($especialidad!=0){
                           require_once 'controladores/matriculaControlador.php';
                            $ins = new matriculaControlador();
                            $pagina = explode("/", $_GET['views']);
                            echo $ins->paginador_alumnos_matriculados_especialidad_controlador($_SESSION["privilegio_csm"],$_SESSION["codigo_cuenta_csm"],$especialidad); 
                        }
                    }
                ?>
</div>