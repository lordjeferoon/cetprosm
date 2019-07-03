 <?php
    $mysqli = new mysqli(SERVER,USER,PASS,DB);

    if(isset($_POST['codigo'])){
        $id=$_POST['codigo'];
    }else{
        $pagina = explode("/", $_GET['views']);
        $id=$pagina[1];
    }

    $consulta=$mysqli->query("SELECT * FROM matriculas WHERE CODIGO_MATRICULA='$id'");
    $matricula = $consulta->fetch_assoc();

    if(isset($matricula['ID_ALUMNO'])){
        $idAlumno=$matricula['ID_ALUMNO'];
        $consulta1=$mysqli->query("SELECT * FROM alumnos WHERE ID_ALUMNO=$idAlumno");
        $alumno = $consulta1->fetch_assoc();

        $cod=$matricula['CODIGO_MATRICULA'];
        $consulta2=$mysqli->query("SELECT * FROM matricula_detalle WHERE CODIGO_MATRICULA='$cod'");

?>
<div class="contenido-main">
                <div class="titulo-formulario">
                    <h2><span>Reporte de</span> Matrícula</h2>
                </div>

                <form action="<?php echo SERVERURL;?>administradorMatriculaPDF" method="post" target="_blank">
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <br><br>
                            <label class="titulo-label">Estado:</label>
                            <?php 
                                if($matricula['ESTADO_PAGO']=="Cancelado"){
                                    echo '<label class="titulo-label text-success">'.$matricula['ESTADO_PAGO'].'</label>';
                                }
                                else{
                                    echo '<label class="titulo-label text-danger">'.$matricula['ESTADO_PAGO'].'</label>';
                                }
                            ?>
                        </div>
                        <div class="form-group col-md-5">
                            
                        </div>
                        <div class="form-group col-md-3">
                            <br>
                            <input type="hidden" name="reporte_name" value="Reporte de Matricula">
                            <input type="hidden" name="codigo" value="<?php echo $id; ?>">
                            <button type="submit" name="create_pdf" class="btn boton-registrar btn-success w-100">Exportar a PDF</button>
                        </div>
                    </div>
                </form>

                <form action="<?php echo SERVERURL;?>ajax/matriculaAjax.php" method="POST" data-form="actualizar" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">

                    <div class="form-row">
                        <div class="form-group col-md-9">
                            <label class="titulo-label">Alumno</label>
                            <input type="text" class="form-control" name="alumno" required style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" value="<?php if(isset($alumno)){echo $alumno['APELLIDOS_ALUMNO'].', '.$alumno['NOMBRES_ALUMNO']; } ?>">
                        </div>
                        <!--<div class="form-group col-md-3">
                            <label class="titulo-label">Código de Matrícula:</label>
                            <input type="text" class="form-control" name="codigo-matricula">          
                        </div>-->
                        <div class="form-group col-md-3">
                            <label class="titulo-label">Fecha</label>
                            <input type="date" class="form-control" name="fecha" value="<?php echo $matricula['FECHA'];?>" required>
                        </div>
                    </div>
                    <br>

                    <table class="table table-hover table-sm">
                        <thead class="table-secondary">
                            <tr>
                                <th scope="col">Módulo</th>
                                <th scope="col" width="2%">Grupo</th>
                                <th scope="col" width="25%">Frecuencia</th>
                                <th scope="col" width="12%">Hora</th>
                                <th scope="col" width="2%">Turno</th>
                                <th scope="col" width="3%">Precio</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                while($detalle = $consulta2->fetch_assoc()) {
                                    $idAsignacion = $detalle['ID_ASIGNACION'];
                                    $consulta3=$mysqli->query("SELECT * FROM asignaciones WHERE ID_ASIGNACION=$idAsignacion");
                                    $asignacion = $consulta3->fetch_assoc();

                                    $idModulo = $asignacion['ID_MODULO'];
                                    $consulta4=$mysqli->query("SELECT * FROM modulos WHERE ID_MODULO=$idModulo");
                                    $modulo = $consulta4->fetch_assoc();

                                    $idFrecuencia = $asignacion['ID_FRECUENCIA'];
                                    $consulta5=$mysqli->query("SELECT * FROM frecuencias WHERE ID_FRECUENCIA=$idFrecuencia");
                                    $frecuencia = $consulta5->fetch_assoc();

                                    $hi=$asignacion['HORA_INICIO'];
                                    $hf=$asignacion['HORA_FIN'];
                                    $hi=substr($hi,0,5);
                                    $hf=substr($hf,0,5);
                                    $hora=$hi."-".$hf;

                                    echo '
                                        <tr>
                                            <td class="align-middle">'.$modulo['NOMBRE_MODULO'].'</td>
                                            <td class="align-middle">'.$asignacion['GRUPO'].'</td>
                                            <td class="align-middle">'.$frecuencia['NOMBRE_FRECUENCIA'].'</td>
                                            <td class="align-middle">'.$hora.'</td>
                                            <td class="align-middle">'.$asignacion['TURNO'].'</td>
                                            <td class="align-middle">'.$modulo['PRECIO_MODULO'].'</td>
                                        </tr>
                                    ';
                                }
                            ?>
                        </tbody>
                    </table>
                    <br>

                    <input type="hidden" name="codigo" value="<?php echo $id; ?>">

                    <?php  
                        if($matricula['ESTADO_PAGO']!="Cancelado"){
                            $resta=$matricula['TOTAL']-$matricula['ADELANTO'];
                            echo '<div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label class="titulo-label">Resta: S/. '.$resta.'</label> 
                                    </div>
                                    <div class="form-group col-md-5"> 
                                    </div>
                                    <div class="form-group col-md-3 row"> 
                                        <label class="titulo-label">Adelanto</label>
                                        <input type="number" step="0.01" class="form-control" name="adelanto" required> 
                                    </div>
                                </div>
                                
                                <div class="botones">
                                    <button type="submit" class="btn boton-registrar btn-success col-xs-4">Actualizar Saldo</button>
                                </div>';
                        }
                    ?>

                    <div class="RespuestaAjax"></div>
                </form>
</div>
<?php 
    }
    else{
       echo '<div class="contenido-main">
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <div>
                    <div>
                        <p class="text-center"><i class="far fa-times-circle fa-7x" style="color: #192F72;"></i></p>
                        <h3 class="text-center" style="color: #192F72;">REPORTE DE MATRÍCULA NO ENCONTRADO</h3>
                    </div>
                </div>
            </div>
        '; 
    }
?>