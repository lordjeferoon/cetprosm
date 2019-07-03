<?php 
    if(isset($_POST['especialidades'])){
        $especialidad=$_POST['especialidades'];
    }
?>

<div class="contenido-main">
    <div class="titulo-formulario">
        <h2>Matriculas <span>No canceladas</span></h2>
    </div>

    <form action="<?php echo SERVERURL;?>administradorReporteMatriculasNoCanceladas/" method="POST">
        
        <div class="form-row"> 
            <div class="form-group col-md-9">
                <label class="titulo-label">Especialidad</label>                            
                <select  class="form-control" name="especialidades">
                    <?php
                        $mysqli = new mysqli(SERVER,USER,PASS,DB);
                        $query = $mysqli -> query ("SELECT * FROM especialidades WHERE ESTADO_ESPECIALIDAD='Activo' ORDER BY NOMBRE_ESPECIALIDAD");
                        echo '<option value="0">TODAS LAS ESPECIALIDADES</option>';
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

    <br><br>

    <?php 

        if(isset($_POST['especialidades'])){
            if($especialidad!=0){
                $nombreEspecialidad="";
                $query = $mysqli -> query ("SELECT * FROM especialidades WHERE ID_ESPECIALIDAD=$especialidad");
                while ($valores = mysqli_fetch_array($query)) {
                    echo '<div align="center" class="font-weight-bold">REPORTE DE MATRICULAS NO CANCELADAS PARA: '.$valores['NOMBRE_ESPECIALIDAD'].'</div>';
                    $nombreEspecialidad=$valores['NOMBRE_ESPECIALIDAD'];
                }
            }
            else{
                $nombreEspecialidad="TODAS LAS ESPECIALIDADES";
                echo '<div align="center" class="font-weight-bold">REPORTE DE MATRICULAS NO CANCELADAS PARA: '.$nombreEspecialidad.'</div>';
            }

                echo "<br>";

                require_once 'controladores/matriculaControlador.php';
                $insMatricula= new matriculaControlador();
         
                $pagina = explode("/", $_GET['views']);
                echo $insMatricula->paginador_matriculas_nocanceladas_controlador($_SESSION["privilegio_csm"],$_SESSION["codigo_cuenta_csm"], $especialidad);

                echo '
                    
                    <div class="form-row"> 
                        <div class="form-group col-md-8">
                        </div>
                        <div class="form-group col-md-2">
                            <form action="'.SERVERURL.'administradorReporteMatriculasNoCanceladasEXCEL" method="post" target="_blank">
                                <input type="hidden" name="especialidad" value="'.$especialidad.'">
                                <input type="hidden" name="nombre-especialidad" value="'.$nombreEspecialidad.'">
                                <input type="hidden" name="reporte_name" value="REPORTE DE MATRICULAS NO CANCELADAS">
                                <button type="submit" name="create_excel" class="btn boton-registrar btn-success w-100"><i class="fas fa-file-excel"></i> Excel</button>
                            </form>
                        </div>

                        <div class="form-group col-md-2">
                            <form action="'.SERVERURL.'administradorReporteMatriculasNoCanceladasPDF" method="post" target="_blank">
                                <input type="hidden" name="especialidad" value="'.$especialidad.'">
                                <input type="hidden" name="nombre-especialidad" value="'.$nombreEspecialidad.'">
                                <input type="hidden" name="reporte_name" value="REPORTE DE MATRICULAS NO CANCELADAS">
                                <button type="submit" name="create_pdf" class="btn boton-registrar btn-success w-100"><i class="fas fa-file-pdf"></i> PDF</button>
                            </form>
                        </div>
                    </div>

                ';
            
        }

    ?>

</div>