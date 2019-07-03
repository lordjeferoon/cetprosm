<?php 
    error_reporting(0);
    $mysqli = new mysqli('localhost','cetprosmp_user','#Hostinca2019','cetprosmp_cetprosmpBD');

    //require_once('conexion/conexion.php');  
    //$usuario = 'SELECT * FROM usuarios ORDER BY id DESC';   
    //$usuarios=$mysqli->query($usuario);

    if(isset($_POST['create_pdf'])){
        require_once('tcpdf/tcpdf.php');
    
        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
    
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Miguel Caro');
        $pdf->SetTitle($_POST['reporte_name']);
    
        $pdf->setPrintHeader(false); 
        $pdf->setPrintFooter(false);
        $pdf->SetMargins(20, 30, 20, false); 
        $pdf->SetAutoPageBreak(true, 20); 
        $pdf->SetFont('Helvetica', ''  , 8);
        $pdf->addPage();

        $idAsignacion=$_POST['asignacion'];
        $modulo=$_POST['modulo'];
        $grupo=$_POST['grupo'];

        $nombreModulo=$_POST['nombre-modulo'];
        $nombreEspecialidad=$_POST['nombre-especialidad'];
        $apellidosDocente=$_POST['apellidos-docente'];
        $nombresDocente=$_POST['nombres-docente'];
        $nombreFrecuencia=$_POST['nombre-frecuencia'];
        $hora=$_POST['hora'];
        $turno=$_POST['turno'];

        $tabla = '
            <img src="vistas/img/logoInfo.jpg"></img>
                    
            <h1 style="text-align:center;">'.$_POST['reporte_name'].'</h1><div></div>

            <br><table style="font-size: 25px; width: 70%;">
                <tr>
                    <td width="25%"><strong>MÓDULO</strong></td>
                    <td width="75%">:'.$nombreModulo.'</td>
                </tr>
                <tr>
                    <td width="25%"><strong>ESPECIALIDAD</strong></td>
                    <td width="75%">:'.$nombreEspecialidad.'</td>
                </tr>
                <tr>
                    <td width="25%"><strong>DOCENTE</strong></td>
                    <td width="75%">:'.$apellidosDocente.', '.$nombresDocente.'</td>
                </tr>
        ';

        $tabla.='
                <tr>
                    <td width="25%"><strong>FRECUENCIA</strong></td>
                    <td width="75%">:'.$nombreFrecuencia.'</td>
                </tr>
                <tr>
                    <td width="25%"><strong>HORARIO</strong></td>
                    <td width="75%">:'.$hora.'</td>
                </tr>
                <tr>
                    <td width="25%"><strong>TURNO</strong></td>
                    <td width="75%">:'.$turno.'</td>
                </tr>
            </table><div></div><div></div>
        ';

        $tabla.='

            <br>
            <table border="1" cellpadding="5">
                <thead>
                    <tr bgcolor="#DCDCDC">
                        <th width="4%">N.</th>
                        <th width="35%">APELLIDOS Y NOMBRES</th>'
        ;
        $width=39;

        $detallesMatricula = "SELECT * FROM matricula_detalle WHERE ID_ASIGNACION=$idAsignacion";   
        $detallesMatricula=$mysqli->query($detallesMatricula);

        $notas = "SELECT * FROM notas WHERE ID_ASIGNACION=$idAsignacion";   
        $notas=$mysqli->query($notas);

        $contadorNotas=0;
        $k=1;
        $contadorDetalles=0;
        foreach ($notas as $nota){
            
            $idNota=$nota['ID_NOTA'];
            $notasDetalle = "SELECT * FROM nota_detalle WHERE ID_NOTA=$idNota ORDER BY FECHA ASC";   
            $notasDetalle=$mysqli->query($notasDetalle);

            foreach ($notasDetalle as $notaDetalle){
                if($k==1){
                    $tabla.='
                        <th width="4%"></th>
                    ';
                    $width=$width+4;
                    $contadorDetalles++;
                }
            }
            $k++;
            $contadorNotas++;
        }
        if($contadorNotas==0 || $contadorDetalles==0){
            $num=100-$width;
            $tabla.='
                <th width="'.$num.'%"></th>
            ';
        }
        else{
            $num=100-$width-4;
            $tabla.='
                <th width="'.$num.'%"></th>
                <th width="4%">F</th>
            ';
        }
                            
        $tabla.='
            </tr>
            </thead>
            <tbody>'
        ;

        $contador=1;

        foreach ($detallesMatricula as $detalleMatricula) {
            $codMatricula=$detalleMatricula['CODIGO_MATRICULA'];
            $anioActual=date('Y');

            $matriculas = "SELECT * FROM matriculas WHERE CODIGO_MATRICULA='".$codMatricula."'";   
            $matriculas=$mysqli->query($matriculas);

            foreach ($matriculas as $matricula) {

                if($matricula['ANIO']==$anioActual){
                    $idAlumno=$matricula['ID_ALUMNO'];

                    $alumnos = "SELECT * FROM alumnos WHERE ID_ALUMNO=$idAlumno";   
                    $alumnos=$mysqli->query($alumnos);

                    foreach ($alumnos as $alumno){
                        $tabla.='
                            <tr>
                                <td width="4%">'.$contador.'</td>
                                <td width="35%">'.$alumno['APELLIDOS_ALUMNO'].', '.$alumno['NOMBRES_ALUMNO'].'</td>
                        ';  

                        $notas = "SELECT * FROM notas WHERE ID_ASIGNACION=$idAsignacion AND ID_ALUMNO=$idAlumno";   
                        $notas=$mysqli->query($notas);

                        $width=39;
                        $promedio=0;
                        $suma=0;
                        $i=0;
                        foreach ($notas as $nota) {

                            $idNota=$nota['ID_NOTA'];
                            $detalles = "SELECT * FROM nota_detalle WHERE ID_NOTA=$idNota ORDER BY FECHA ASC";   
                            $detalles=$mysqli->query($detalles);

                            foreach ($detalles as $detalle) {
                                if($detalle['NOTA']<10){
                                    $aux="0".$detalle['NOTA'];
                                    $tabla.='
                                        <td width="4%">'.$aux.'</td>
                                    ';
                                }
                                else{
                                    $tabla.='
                                        <td width="4%">'.$detalle['NOTA'].'</td>
                                    ';
                                }
                                $width=$width+4;
                                $suma=$suma+$detalle['NOTA'];
                                $i++; 
                            } 

                            $width=96-$width;
                            $promedio=$suma/$i;
                        }
                        if($i==0){
                            $tabla.='
                                    <td width="61%" align="center">NO HAY NOTAS REGISTRADAS</td>
                                </tr>
                            ';
                        }
                        else{
                            $tabla.='
                                    <td width="'.$width.'%"></td>
                                    <td width="4%">'.$promedio.'</td>
                                </tr>
                            ';
                        } 
                    }
                }
            }
            $contador++;
        }
        if(($contador-1)==0){
            $tabla.='
                <tr>
                    <td width="100%" align="center">NO HAY REGISTROS PARA MOSTRAR</td>
                </tr>
            ';
        }

        $tabla.='</tbody>
            </table>
        ';
    
        $pdf->writeHTML($tabla, true, 0, true, 0);

        $pdf->lastPage();
        ob_end_clean();
        $pdf->output('Reporte.pdf', 'I');
    }
?> 