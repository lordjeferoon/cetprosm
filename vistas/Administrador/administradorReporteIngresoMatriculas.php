<?php
    if(isset($_POST['especialidad']) && isset($_POST['fechai']) && isset($_POST['fechaf'])){
        $especialidad=$_POST['especialidad'];
        $fechai=$_POST['fechai']; 
        $fechaf=$_POST['fechaf'];
    }
?>
<div class="contenido-main">
                <div class="titulo-formulario">
                    <h2>Reporte de <span>Ingresos de Matrículas</span></h2>
                </div>

                <form action="<?php echo SERVERURL;?>administradorReporteIngresoMatriculas/" method="POST">
                    <div class="form-row"> 
                        <div class="form-group col-md-3">
                            <label class="titulo-label">Especialidad</label>                            
                            <select  class="form-control" name="especialidad">
                                <?php
                                    $mysqli = new mysqli(SERVER,USER,PASS,DB);
                                    $query = $mysqli -> query ("SELECT * FROM especialidades WHERE ESTADO_ESPECIALIDAD='Activo' ORDER BY NOMBRE_ESPECIALIDAD");
                                    echo '<option value="0">TODO</option>';
                                    while ($valores = mysqli_fetch_array($query)) {
                                        echo '<option value="'.$valores['ID_ESPECIALIDAD'].'">'.$valores['NOMBRE_ESPECIALIDAD'].'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="titulo-label">Fecha Inicio</label>
                            <input type="date" class="form-control" name="fechai" value="<?php echo date("Y-m-d");?>" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="titulo-label">Fecha Fin</label>
                            <input type="date" class="form-control" name="fechaf" value="<?php echo date("Y-m-d");?>" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label></label>
                            <button type="submit" class="btn boton-registrar btn-primary w-100">Ver reporte</button>
                        </div>
                    </div>
                </form>
                <br>
                
                <?php
                    if(isset($_POST['especialidad']) && isset($_POST['fechai']) && isset($_POST['fechaf'])){
                        $nombre="";
                        if($especialidad==0){
                            echo '<br><div align="center" class="font-weight-bold">REPORTE DE INGRESOS POR MAT´RÍCULAS DEL '.$fechai.' AL '.$fechaf.'</div><br>';
                        }
                        else{
                            $mysqli = new mysqli(SERVER,USER,PASS,DB);
                            $query = $mysqli -> query ("SELECT * FROM especialidades WHERE ID_ESPECIALIDAD=$especialidad");
                            while ($valores = mysqli_fetch_array($query)) {
                                echo '<br><div align="center" class="font-weight-bold">REPORTE DE INGRESOS POR MATRICULAS DEL '.$fechai.' AL '.$fechaf.'</div>
                                    <div align="center" class="font-weight-bold">ESPECIALIDAD: '.$valores['NOMBRE_ESPECIALIDAD'].'</div><br>
                                ';
                                $nombre=$valores['NOMBRE_ESPECIALIDAD'];
                            }
                        }    
                            
                        
                        require_once 'controladores/matriculaControlador.php';
                        $ins = new matriculaControlador();
                        
                        $pagina = explode("/", $_GET['views']);
                        echo $ins->paginador_ingreso_matriculas_controlador($_SESSION["privilegio_csm"],$_SESSION["codigo_cuenta_csm"],$especialidad,$fechai,$fechaf);

                        echo '
                            <div class="form-row"> 
                                <div class="form-group col-md-8">
                                </div>
                                <div class="form-group col-md-2">
                                    <form action="'.SERVERURL.'administradorReporteIngresoMatriculasEXCEL" method="post" target="_blank">
                                        <input type="hidden" name="fechai" value="'.$fechai.'">
                                        <input type="hidden" name="fechaf" value="'.$fechaf.'">
                                        <input type="hidden" name="especialidad" value="'.$especialidad.'">
                                        <input type="hidden" name="nombre-especialidad" value="'.$nombre.'">
                                        <input type="hidden" name="reporte-name" value="REPORTE DE INGRESOS POR MATRÍCULAS">
                                        <button type="submit" class="btn boton-registrar btn-success w-100"><i class="fas fa-file-excel"></i> Excel</button>
                                    </form>
                                </div>

                                <div class="form-group col-md-2">
                                    <form action="'.SERVERURL.'administradorReporteIngresoMatriculasPDF" method="post" target="_blank">
                                        <input type="hidden" name="fechai" value="'.$fechai.'">
                                        <input type="hidden" name="fechaf" value="'.$fechaf.'">
                                        <input type="hidden" name="especialidad" value="'.$especialidad.'">
                                        <input type="hidden" name="nombre-especialidad" value="'.$nombre.'">
                                        <input type="hidden" name="reporte_name" value="REPORTE DE INGRESOS POR MATRÍCULAS ">
                                        <button type="submit" name="create_pdf" class="btn boton-registrar btn-success w-100"><i class="fas fa-file-pdf"></i> PDF</button>
                                    </form>
                                </div>
                            </div>
                        ';
                    }

                ?>
</div>