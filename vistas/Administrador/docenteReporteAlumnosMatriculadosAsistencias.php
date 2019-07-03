<?php
    $conexion = mainModel::conectar();
    
    $pagina = explode("/", $_GET['views']);
    $asignacion=$lc->decryption($pagina[1]);
    $modulo=$lc->decryption($pagina[2]);
    $grupo=$lc->decryption($pagina[3]);

    $Asignacion = $conexion->prepare("
        SELECT * FROM asignaciones WHERE ID_ASIGNACION=$asignacion
    ");
    $Asignacion->execute();
    $Asignacion = $Asignacion->fetch();

    $docente=$Asignacion['ID_DOCENTE'];
    $Docente = $conexion->prepare("
        SELECT * FROM docentes WHERE ID_DOCENTE=$docente
    ");
    $Docente->execute();
    $Docente = $Docente->fetch();

    $frecuencia=$Asignacion['ID_FRECUENCIA'];
    $Frecuencia = $conexion->prepare("
        SELECT * FROM frecuencias WHERE ID_FRECUENCIA=$frecuencia
    ");
    $Frecuencia->execute();
    $Frecuencia = $Frecuencia->fetch();

    $Modulo = $conexion->prepare("
        SELECT * FROM modulos WHERE ID_MODULO=$modulo
    ");
    $Modulo->execute();
    $Modulo = $Modulo->fetch();

    $especialidad = $Modulo['ID_ESPECIALIDAD'];
    $Especialidad = $conexion->prepare("
        SELECT * FROM especialidades WHERE ID_ESPECIALIDAD=$especialidad
    ");
    $Especialidad->execute();
    $Especialidad = $Especialidad->fetch();

    $turno="";
    if($Asignacion['TURNO']="M"){
        $turno="MAÑANA";
    }
    else{
        $turno="TARDE";
    }

    $hi=$Asignacion['HORA_INICIO'];
    $hf=$Asignacion['HORA_FIN'];
    $hi=substr($hi,0,5);
    $hf=substr($hf,0,5);
    $hora=$hi.'-'.$hf;$pagina = explode("/", $_GET['views']);
    $asignacion=$lc->decryption($pagina[1]);
    $modulo=$lc->decryption($pagina[2]);
    $grupo=$lc->decryption($pagina[3]);
?>
<div class="contenido-main">
                <div class="titulo-formulario">
                    <h2>Alumnos Matriculados <span>- Asistencias</span></h2>
                </div>

                <!--<form action="<?php echo SERVERURL;?>docenteReporteAlumnosMatriculadosAsistenciasPDF" method="post" target="_blank">
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            
                        </div>
                        <div class="form-group col-md-6">

                        </div>
                        <div class="form-group col-md-3">
                            <br>
                            <input type="hidden" name="nombre-modulo" value="<?php echo $Modulo['NOMBRE_MODULO']; ?>">
                            <input type="hidden" name="nombre-especialidad" value="<?php echo $Especialidad['NOMBRE_ESPECIALIDAD']; ?>">
                            <input type="hidden" name="apellidos-docente" value="<?php echo $Docente['APELLIDOS_DOCENTE']; ?>">
                            <input type="hidden" name="nombres-docente" value="<?php echo $Docente['NOMBRES_DOCENTE']; ?>">
                            <input type="hidden" name="nombre-frecuencia" value="<?php echo $Frecuencia['NOMBRE_FRECUENCIA']; ?>">
                            <input type="hidden" name="hora" value="<?php echo $hora; ?>">
                            <input type="hidden" name="turno" value="<?php echo $turno; ?>">

                            <input type="hidden" name="asignacion" value="<?php echo $asignacion; ?>">
                            <input type="hidden" name="modulo" value="<?php echo $modulo; ?>">
                            <input type="hidden" name="grupo" value="<?php echo $grupo; ?>">
                            <input type="hidden" name="reporte_name" value="Reporte de Asistencias">
                            <button type="submit" name="create_pdf" class="btn boton-registrar btn-success w-100" disabled="">Exportar a PDF</button>
                        </div>
                    </div>
                </form>-->
                    <br>
                    <?php 
                        require_once 'controladores/docenteControlador.php';
                        $ins = new docenteControlador();
                    ?>

                    <?php      
                        echo $ins->paginador_alumnos_asistencias_controlador($_SESSION["privilegio_csm"],$_SESSION["codigo_cuenta_csm"], $asignacion, $modulo, $grupo);
                    ?>

                </form>
</div>