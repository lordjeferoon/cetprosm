<?php
    $mysqli = new mysqli(SERVER,USER,PASS,DB);

    if(isset($_POST['alumno']) && isset($_POST['especialidad'])){
        $alumno=$_POST['alumno'];
        $especialidad=$_POST['especialidad'];
        $fecha=$_POST['fecha'];
    }
?>
<div class="contenido-main">
                <div class="titulo-formulario">
                    <h2>Realizar <span>Matrícula</span></h2>
                </div>

                <form action="<?php echo SERVERURL;?>administradorMatricular" method="POST">
                    <?php 
                        if(!isset($_POST['alumno']) && !isset($_POST['especialidad'])){
                    ?>
                        <div class="form-row"> 
                            <div class="form-group col-md-9">
                                <label class="titulo-label">Alumno</label>
                                <select  class="form-control" name="alumno">
                                <?php
                                    echo '<option value="0">SELECCIONE UN ALUMNO</option>';
                                    $query = $mysqli -> query ("SELECT * FROM alumnos ORDER BY APELLIDOS_ALUMNO");
                                    while ($valores = mysqli_fetch_array($query)) {
                                        echo '<option value="'.$valores['ID_ALUMNO'].'">'.$valores['APELLIDOS_ALUMNO'].', '.$valores['NOMBRES_ALUMNO'].'</option>';
                                    }
                                ?>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="titulo-label">Fecha</label>
                                <input type="date" class="form-control" name="fecha" value="<?php echo date("Y-m-d");?>" required>
                            </div>
                        </div>

                        <div class="form-row"> 
                            <div class="form-group col-md-9">
                                <label class="titulo-label">Especialidad</label>
                                <select  class="form-control" name="especialidad">
                                <?php
                                    echo '<option value="0">SELECCIONE UNA ESPECIALIDAD</option>';
                                    $query = $mysqli -> query ("SELECT * FROM especialidades WHERE ESTADO_ESPECIALIDAD='Activo' ORDER BY NOMBRE_ESPECIALIDAD");
                                    while ($valores2 = mysqli_fetch_array($query)) {
                                        echo '<option value="'.$valores2['ID_ESPECIALIDAD'].'">'.$valores2['NOMBRE_ESPECIALIDAD'].'</option>';
                                    }
                                ?>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <br>
                                <button style="width: 100%;" type="submit" class="btn boton-registrar btn-success">Cargar</button>
                            </div>
                        </div>

                        <?php
                            } 
                        ?>
                </form>

                <form action="<?php echo SERVERURL;?>ajax/matriculaAjax.php" method="POST" data-form="guardar" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">

                    <?php 
                        if(isset($_POST['alumno']) && isset($_POST['especialidad'])){
                            if($alumno!=0 && $especialidad!=0){

                                $query = $mysqli -> query ("SELECT * FROM alumnos WHERE ID_ALUMNO=$alumno");
                                $nombre="";
                                while ($valores = mysqli_fetch_array($query)) {
                                    $nombre=$nombre.$valores['APELLIDOS_ALUMNO'].", ".$valores['NOMBRES_ALUMNO'];
                                }

                    ?>

                                <div class="form-row">
                                    <div class="form-group col-md-9">
                                        <label class="titulo-label">Alumno</label>
                                        <input type="text" class="form-control" value="<?php echo $nombre; ?>"  readonly>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="titulo-label">Fecha</label>
                                        <input type="date" class="form-control" name="fecha" value="<?php echo $fecha?>" required>
                                    </div>
                                </div>
                                <br>
                                <input type="hidden" name="alumno" value="<?php echo $alumno?>">
                    <?php
                                $cad = '<div class="form-group">
                                <select  class="form-control" name="asignacion-1">
                                    <option value="0">SELECCIONE UN MÓDULO</option>';

                                $query = $mysqli -> query ("SELECT * FROM modulos WHERE ID_ESPECIALIDAD=$especialidad ORDER BY ID_ESPECIALIDAD");
                                while ($valores = mysqli_fetch_array($query)) {
                                    $val = $valores['ID_MODULO'];
                                    $query2 = $mysqli -> query ("SELECT * FROM asignaciones WHERE ID_MODULO=$val ORDER BY FECHA_INICIO");
                                    while($asignacion = mysqli_fetch_array($query2)){
                                        $cad.= '<option value="'.$asignacion['ID_ASIGNACION'].'">'.$valores['NOMBRE_MODULO'].'     /     GRUPO'.$asignacion['GRUPO'].'     /     VACANTES: '.$asignacion['VACANTES'].' / PRECIO: '.$valores['PRECIO_MODULO'].'</option>';
                                    }
                                }
                                $cad.='</select>
                                </div>';
                                echo $cad;

                                $cad = '<div class="form-group">
                                <select  class="form-control" name="asignacion-2">
                                    <option value="0">SELECCIONE UN MÓDULO</option>';

                                $query = $mysqli -> query ("SELECT * FROM modulos WHERE ID_ESPECIALIDAD=$especialidad ORDER BY ID_ESPECIALIDAD");
                                while ($valores = mysqli_fetch_array($query)) {
                                    $val = $valores['ID_MODULO'];
                                    $query2 = $mysqli -> query ("SELECT * FROM asignaciones WHERE ID_MODULO=$val ORDER BY FECHA_INICIO");
                                    while($asignacion = mysqli_fetch_array($query2)){
                                        $cad.= '<option value="'.$asignacion['ID_ASIGNACION'].'">'.$valores['NOMBRE_MODULO'].'     /     GRUPO'.$asignacion['GRUPO'].'     /     VACANTES: '.$asignacion['VACANTES'].' / PRECIO: '.$valores['PRECIO_MODULO'].'</option>';
                                    }
                                }
                                $cad.='</select>
                                </div>';
                                echo $cad;

                                $cad = '<div class="form-group">
                                <select  class="form-control" name="asignacion-3">
                                    <option value="0">SELECCIONE UN MÓDULO</option>';

                                $query = $mysqli -> query ("SELECT * FROM modulos WHERE ID_ESPECIALIDAD=$especialidad ORDER BY ID_ESPECIALIDAD");
                                while ($valores = mysqli_fetch_array($query)) {
                                    $val = $valores['ID_MODULO'];
                                    $query2 = $mysqli -> query ("SELECT * FROM asignaciones WHERE ID_MODULO=$val ORDER BY FECHA_INICIO");
                                    while($asignacion = mysqli_fetch_array($query2)){
                                        $cad.= '<option value="'.$asignacion['ID_ASIGNACION'].'">'.$valores['NOMBRE_MODULO'].'     /     GRUPO'.$asignacion['GRUPO'].'     /     VACANTES: '.$asignacion['VACANTES'].' / PRECIO: '.$valores['PRECIO_MODULO'].'</option>';
                                    }
                                }
                                $cad.='</select>
                                </div>';
                                echo $cad;

                                $cad = '<div class="form-group">
                                <select  class="form-control" name="asignacion-4">
                                    <option value="0">SELECCIONE UN MÓDULO</option>';

                                $query = $mysqli -> query ("SELECT * FROM modulos WHERE ID_ESPECIALIDAD=$especialidad ORDER BY ID_ESPECIALIDAD");
                                while ($valores = mysqli_fetch_array($query)) {
                                    $val = $valores['ID_MODULO'];
                                    $query2 = $mysqli -> query ("SELECT * FROM asignaciones WHERE ID_MODULO=$val ORDER BY FECHA_INICIO");
                                    while($asignacion = mysqli_fetch_array($query2)){
                                        $cad.= '<option value="'.$asignacion['ID_ASIGNACION'].'">'.$valores['NOMBRE_MODULO'].'     /     GRUPO'.$asignacion['GRUPO'].'     /     VACANTES: '.$asignacion['VACANTES'].' / PRECIO: '.$valores['PRECIO_MODULO'].'</option>';
                                    }
                                }
                                $cad.='</select>
                                </div>';
                                echo $cad;
                                
                                $cad = '<div class="form-group">
                                <select  class="form-control" name="asignacion-5">
                                    <option value="0">SELECCIONE UN MÓDULO</option>';

                                $query = $mysqli -> query ("SELECT * FROM modulos WHERE ID_ESPECIALIDAD=$especialidad ORDER BY ID_ESPECIALIDAD");
                                while ($valores = mysqli_fetch_array($query)) {
                                    $val = $valores['ID_MODULO'];
                                    $query2 = $mysqli -> query ("SELECT * FROM asignaciones WHERE ID_MODULO=$val ORDER BY FECHA_INICIO");
                                    while($asignacion = mysqli_fetch_array($query2)){
                                        $cad.= '<option value="'.$asignacion['ID_ASIGNACION'].'">'.$valores['NOMBRE_MODULO'].'     /     GRUPO'.$asignacion['GRUPO'].'     /     VACANTES: '.$asignacion['VACANTES'].' / PRECIO: '.$valores['PRECIO_MODULO'].'</option>';
                                    }
                                }
                                $cad.='</select>
                                </div>';
                                echo $cad;
                                
                                $cad = '<div class="form-group">
                                <select  class="form-control" name="asignacion-6">
                                    <option value="0">SELECCIONE UN MÓDULO</option>';

                                $query = $mysqli -> query ("SELECT * FROM modulos WHERE ID_ESPECIALIDAD=$especialidad ORDER BY ID_ESPECIALIDAD");
                                while ($valores = mysqli_fetch_array($query)) {
                                    $val = $valores['ID_MODULO'];
                                    $query2 = $mysqli -> query ("SELECT * FROM asignaciones WHERE ID_MODULO=$val ORDER BY FECHA_INICIO");
                                    while($asignacion = mysqli_fetch_array($query2)){
                                        $cad.= '<option value="'.$asignacion['ID_ASIGNACION'].'">'.$valores['NOMBRE_MODULO'].'     /     GRUPO'.$asignacion['GRUPO'].'     /     VACANTES: '.$asignacion['VACANTES'].' / PRECIO: '.$valores['PRECIO_MODULO'].'</option>';
                                    }
                                }
                                $cad.='</select>
                                </div>';
                                echo $cad;
                            }
                    ?>
                            <br>
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label class="titulo-label">Modalidad</label>
                                    <select  class="form-control" name="pagante" required>
                                        <option value="1">CON PAGO</option>
                                        <option value="2">SIN PAGO</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">

                                </div>
                                <div class="form-group col-md-3">
                                    <label class="titulo-label">Adelanto</label>
                                    <input type="number" step="0.01" class="form-control" name="adelanto" required min="0"> 
                                </div>
                            </div>
                            <br>
                        
                            <div class="botones">
                                <button type="submit" class="btn boton-registrar btn-success col-xs-4">Matricular</button>
                                <button type="reset" class="btn boton-limpiar btn-secondary col-xs-4">Limpiar</button>
                            </div> 

                            <div class="RespuestaAjax"></div>

                        </form>
                    <?php      
                        }
                    ?>

</div>




