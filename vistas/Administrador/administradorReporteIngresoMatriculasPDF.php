<?php 
    //error_reporting(0);
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

        $especialidad = $_POST['especialidad'];
        $nombreEspecialidad = $_POST['nombre-especialidad'];
        $fechai = $_POST['fechai'];
        $fechaf = $_POST['fechaf'];
        $totalIngreso=0;
        $totalDeuda=0;

        $fechasInicio = explode("-",$fechai);
        $fechaNuevai=$fechasInicio[2]."/".$fechasInicio[1]."/".$fechasInicio[0];

        $fechasFin = explode("-",$fechaf);
        $fechaNuevaf=$fechasFin[2]."/".$fechasFin[1]."/".$fechasFin[0];

        $matriculas = "SELECT * FROM matriculas WHERE FECHA BETWEEN '$fechai' AND '$fechaf' ORDER BY FECHA";   
        $matriculas=$mysqli->query($matriculas);

        $content = '';
    
        $content .= '
                    <img src="vistas/img/logoInfo.jpg"></img>
                    
                    <h1 style="text-align:center;">'.$_POST['reporte_name'].'</h1>
                    <h2 style="text-align:center;">DEL  '.$fechaNuevai.'  AL  '.$fechaNuevaf.'</h2>
        ';

        if($especialidad!=0){
            $content.='
                <h3 style="text-align:center;">ESPECIALIDAD: '.$nombreEspecialidad.'</h3>  
            ';
        }

        $content.='<div></div><div></div>
        
                    <table border="1" cellpadding="5">
                        <thead>
                            <tr bgcolor="#DCDCDC">
                                <th width="5%">N.</th>
                                <th width="11%">FECHA</th>
                                <th width="42%">APELLIDO Y NOMBRES</th>
                                <th width="8%">TOTAL</th>
                                <th width="12%">ADELANTO</th>
                                <th width="8%">DEUDA</th>
                                <th width="14%">ESTADO</th>
                            </tr>
                        </thead>
                        <tbody>
        ';
    
        $i=1;
        while ($matricula = $matriculas->fetch_assoc()) { 

            $codigoMatricula=$matricula['CODIGO_MATRICULA'];
            $detalles = "SELECT * FROM matricula_detalle WHERE CODIGO_MATRICULA='$codigoMatricula'"; 
            $detalles = $mysqli->query($detalles);

            $encontrado="falso";
            while ($detalle=$detalles->fetch_assoc()) {

                $idAsignacion = $detalle['ID_ASIGNACION'];
                $asignaciones = "SELECT * FROM asignaciones WHERE ID_ASIGNACION=$idAsignacion"; 
                $asignaciones=$mysqli->query($asignaciones);

                $idModulo;
                while ($asignacion = $asignaciones->fetch_assoc()) {
                    $idModulo=$asignacion['ID_MODULO'];  
                }

                $modulos = "SELECT * FROM modulos WHERE ID_MODULO=$idModulo"; 
                $modulos=$mysqli->query($modulos);
                $idEspecialidad;
                while ($modulo = $modulos->fetch_assoc()) {
                    $idEspecialidad=$modulo['ID_ESPECIALIDAD'];
                }

                if($especialidad == 0){
                    $encontrado="verdadero";
                }
                else{
                    if($especialidad==$idEspecialidad){
                        $encontrado="verdadero";
                    }
                }
            }

            if($encontrado=="verdadero"){
                $idAlumno=$matricula['ID_ALUMNO'];
                $alumnos = "SELECT * FROM alumnos WHERE ID_ALUMNO=$idAlumno"; 
                $alumnos=$mysqli->query($alumnos);

                $nombre="";
                while ($alumno = $alumnos->fetch_assoc()) {
                    $nombre=$alumno['APELLIDOS_ALUMNO'].", ".$alumno['NOMBRES_ALUMNO'];
                }

                $total=$matricula['TOTAL'];
                $adelanto=$matricula['ADELANTO'];
                $resta=$total-$adelanto;
                $totalIngreso=$totalIngreso+$adelanto;
                $totalDeuda=$totalDeuda+$resta;
                
                if($resta<=0){
                    $resta=0;
                }
                
                $fechas=explode("-",$matricula['FECHA']);
                $fecha=$fechas[2]."/".$fechas[1]."/".$fechas[0];

                $content .= '
                    <tr>
                        <td width="5%">'.$i.'</td>
                        <td width="11%">'.$fecha.'</td>
                        <td width="42%">'.$nombre.'</td>
                        <td width="8%">'.$total.'</td>
                        <td width="12%">'.$adelanto.'</td>
                        <td width="8%">'.$resta.'</td>
                        <td width="14%">'.$matricula['ESTADO_PAGO'].'</td>
                    </tr>
                ';

                $i++;

            }
        }
    
        $content .= '</tbody></table><div></div><div></div>';

        $content.='
            <h3 style="text-align:right;">TOTAL INGRESOS:  S/. '.$totalIngreso.'</h3>  
        ';

        $content.='
            <h3 style="text-align:right;">TOTAL DEUDAS:  S/. '.$totalDeuda.'</h3>  
        ';
    
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