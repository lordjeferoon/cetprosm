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
        $pdf->SetFont('Helvetica', ''  , 9);
        $pdf->addPage();

        $modulo=$_POST['modulo'];
        $grupo=$_POST['grupo'];
        $nombreModulo=$_POST['nombre-modulo'];
        $nombreEspecialidad=$_POST['nombre-especialidad'];
        $apellidosDocente=$_POST['apellidos-docente'];
        $nombresDocente=$_POST['nombres-docente'];
        $nombreFrecuencia=$_POST['nombre-frecuencia'];
        $hora=$_POST['hora'];
        $turno=$_POST['turno'];
        $idAsignacion=$_POST['asignacion'];

        $content = '
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

        $content.='
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
    
        $content .= '
                    <br>
                    <table border="1" cellpadding="5">
                        <thead>
                            <tr bgcolor="#DCDCDC">
                                <th width="5%">N.</th>
                                <th width="20%">CÓDIGO</th>
                                <th width="75%">APELLIDOS Y NOMBRES</th>
                            </tr>
                        </thead>
                        <tbody>
        ';
        //echo $asignacion;
        $detalles = "SELECT a.ID_ALUMNO, a.APELLIDOS_ALUMNO, a.NOMBRES_ALUMNO, a.SEXO_ALUMNO, a.FECHA_NACIMIENTO_ALUMNO, a.CODIGO_CUENTA_ALUMNO, a.CONDICION_ALUMNO, m.CODIGO_MATRICULA, d.ID_ASIGNACION 
            FROM alumnos a JOIN matriculas m ON m.ID_ALUMNO = a.ID_ALUMNO 
            JOIN matricula_detalle d ON d.CODIGO_MATRICULA = m.CODIGO_MATRICULA 
            WHERE d.ID_ASIGNACION=$idAsignacion ORDER BY a.APELLIDOS_ALUMNO";   
        $detalles=$mysqli->query($detalles);
    
        $i=1;
        while($detalle=$detalles->fetch_assoc()){ 

            $anio=date('Y');
            $codigo=$detalle['CODIGO_MATRICULA'];
            $matriculas = "SELECT * FROM matriculas WHERE CODIGO_MATRICULA='".$codigo."'"; 
            $matriculas=$mysqli->query($matriculas);

            while ($matricula=$matriculas->fetch_assoc()) {

                $idAlumno=$matricula['ID_ALUMNO'];
                $alumnos = "SELECT * FROM alumnos WHERE ID_ALUMNO=$idAlumno"; 
                $alumnos=$mysqli->query($alumnos);

                while($alumno=$alumnos->fetch_assoc()){
                    $content .= '
                        <tr>
                            <td width="5%">'.$i.'</td>
                            <td width="20%">'.$alumno['CODIGO_CUENTA_ALUMNO'].'</td>
                            <td width="75%">'.$alumno['APELLIDOS_ALUMNO'].', '.$alumno['NOMBRES_ALUMNO'].'</td>
                        </tr>
                    ';
                }
            }
            $i++;
        }
    
        $content .= '</tbody></table>';
    
        /*$content .= '
                <div class="row padding">
                    <div class="col-md-12" style="text-align:center;">
                        <span>Pdf Creator </span><a href="http://www.redecodifica.com">By Miguel Angel</a>
                    </div>
                </div>
        
        ';*/
    
        $pdf->writeHTML($content, true, 0, true, 0);

        $pdf->lastPage();
        ob_end_clean();
        $pdf->output('Reporte.pdf', 'I');
    }
?> 