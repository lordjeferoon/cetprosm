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

        $id=$_POST['codigo'];
        $matriculas = "SELECT * FROM matriculas WHERE CODIGO_MATRICULA='".$id."'";   
        $matriculas=$mysqli->query($matriculas);

        $content = '';
    
        $content .= '

                    <img src="vistas/img/logoInfo.jpg"></img>

                    <h1 style="text-align:center; font-size: 65px;">'.$_POST['reporte_name'].'</h1><div></div><div></div>
        ';
    
        $i=1;
        while ($matricula=$matriculas->fetch_assoc()) {

            $codAlum=$matricula['ID_ALUMNO'];
            $alumnos = "SELECT * FROM alumnos WHERE ID_ALUMNO='$codAlum'"; 
            $alumnos=$mysqli->query($alumnos); 

            $codigo=$matricula['CODIGO_MATRICULA'];
            $detalles = "SELECT * FROM matricula_detalle WHERE CODIGO_MATRICULA='$codigo'"; 
            $detalles=$mysqli->query($detalles);

            $content .= '
                <h4 style="text-align:left;">CODIGO MATRICULA: <span style="font-weight: normal;"> '.$codigo.'</span></h4>
            ';

            while ($alumno=$alumnos->fetch_assoc()) {
                $content .= '
                    <h4 style="text-align:left;">ALUMNO: <span style="font-weight: normal;">'.$alumno['APELLIDOS_ALUMNO'].', '.$alumno['NOMBRES_ALUMNO'].'</span></h4>
                ';
            }

            $content .= '
                <h4 style="text-align:left;">ESTADO: <span style="font-weight: normal;"> '.$matricula['ESTADO_PAGO'].'</span></h4>
            ';

            $content .= '
                <h4 style="text-align:left;">FECHA: <span style="font-weight: normal;">'.$matricula['FECHA'].'</span></h4><div></div><div></div>
            ';

            $content.='
                <table border="1" cellpadding="5">
                    <thead>
                        <tr bgcolor="#DCDCDC">
                            <th width="4%">N.</th>
                            <th width="38%">MÓDULO</th>
                            <th width="9%">GRUPO</th>
                            <th width="17%">FRECUENCIA</th>
                            <th width="13%">HORA</th>
                            <th width="9%">TURNO</th>
                            <th width="10%">PRECIO</th>
                        </tr>
                    </thead>
            ';

            while ($detalle=$detalles->fetch_assoc()) {

                $content.='
                    <tr>
                        <td width="4%">'.$i.'</td>
                ';

                $idAsignacion=$detalle['ID_ASIGNACION'];
                $asignaciones = "SELECT * FROM asignaciones WHERE ID_ASIGNACION=$idAsignacion"; 
                $asignaciones=$mysqli->query($asignaciones);

                while ($asignacion=$asignaciones->fetch_assoc()) {

                    $idModulo=$asignacion['ID_MODULO'];
                    $modulos = "SELECT * FROM modulos WHERE ID_MODULO=$idModulo"; 
                    $modulos=$mysqli->query($modulos);

                    $precio=0;

                    while ($modulo=$modulos->fetch_assoc()){
                        $content.='
                            <td width="38%">'.$modulo['NOMBRE_MODULO'].'</td>
                        ';

                        $precio=$modulo['PRECIO_MODULO'];
                    }

                    $content.='
                        <td width="9%">'.$asignacion['GRUPO'].'</td>
                    ';

                    $idFrecuencia=$asignacion['ID_FRECUENCIA'];
                    $frecuencias = "SELECT * FROM frecuencias WHERE ID_FRECUENCIA=$idFrecuencia"; 
                    $frecuencias=$mysqli->query($frecuencias);

                    while ($frecuencia=$frecuencias->fetch_assoc()){
                        $content.='
                            <td width="17%">'.$frecuencia['NOMBRE_FRECUENCIA'].'</td>
                        ';
                    }

                    $hi=$asignacion['HORA_INICIO'];
                    $hf=$asignacion['HORA_FIN'];
                    $hi=substr($hi,0,5);
                    $hf=substr($hf,0,5);
                    $hora=$hi."-".$hf;

                    $content.='
                        <td width="13%">'.$hora.'</td>
                        <td width="9%">'.$asignacion['TURNO'].'</td>
                    ';

                    $content.='
                        <td width="10%">'.$precio.'</td>
                    ';

                }

                $content .= '
                    </tr>
                ';
            
                $i=$i+1;
            }
            $total=$matricula['TOTAL'];
            $adelanto=$matricula['ADELANTO'];
            $resta=$total-$adelanto;

        }   
    
        $content.= '</table>';

        $content.='<div></div><div></div><div></div>';

        $content.='
            <h4 style="text-align:right;">TOTAL: <span style="font-weight: normal;">'.$total.'</span></h4>
        ';

        $content.='
            <h4 style="text-align:right;">ADELANTO: <span style="font-weight: normal;">'.$adelanto.'</span></h4>
        ';
    
        if($resta!=0){
            $content.='
            <h4 style="text-align:right;">RESTA: <span style="font-weight: normal;">'.$resta.'</span></h4>
        ';
        }
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
    }else{
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

        $pagina = explode("/", $_GET['views']);
        $id=$pagina[1];
        $matriculas = "SELECT * FROM matriculas WHERE CODIGO_MATRICULA='".$id."'";   
        $matriculas=$mysqli->query($matriculas);

        $content = '';
    
        $content .= '

                    <img src="vistas/img/logoInfo.jpg"></img>

                    <h1 style="text-align:center; font-size: 65px;">'.$_POST['reporte_name'].'</h1><div></div><div></div>
        ';
    
        $i=1;
        while ($matricula=$matriculas->fetch_assoc()) {

            $codAlum=$matricula['ID_ALUMNO'];
            $alumnos = "SELECT * FROM alumnos WHERE ID_ALUMNO='$codAlum'"; 
            $alumnos=$mysqli->query($alumnos); 

            $codigo=$matricula['CODIGO_MATRICULA'];
            $detalles = "SELECT * FROM matricula_detalle WHERE CODIGO_MATRICULA='$codigo'"; 
            $detalles=$mysqli->query($detalles);

            $content .= '
                <h4 style="text-align:left;">CODIGO MATRICULA: <span style="font-weight: normal;"> '.$codigo.'</span></h4>
            ';

            while ($alumno=$alumnos->fetch_assoc()) {
                $content .= '
                    <h4 style="text-align:left;">ALUMNO: <span style="font-weight: normal;">'.$alumno['APELLIDOS_ALUMNO'].', '.$alumno['NOMBRES_ALUMNO'].'</span></h4>
                ';
            }

            $content .= '
                <h4 style="text-align:left;">ESTADO: <span style="font-weight: normal;"> '.$matricula['ESTADO_PAGO'].'</span></h4>
            ';

            $content .= '
                <h4 style="text-align:left;">FECHA: <span style="font-weight: normal;">'.$matricula['FECHA'].'</span></h4><div></div><div></div>
            ';

            $content.='
                <table border="1" cellpadding="5">
                    <thead>
                        <tr bgcolor="#DCDCDC">
                            <th width="4%">N.</th>
                            <th width="38%">MÓDULO</th>
                            <th width="9%">GRUPO</th>
                            <th width="17%">FRECUENCIA</th>
                            <th width="13%">HORA</th>
                            <th width="9%">TURNO</th>
                            <th width="10%">PRECIO</th>
                        </tr>
                    </thead>
            ';

            while ($detalle=$detalles->fetch_assoc()) {

                $content.='
                    <tr>
                        <td width="4%">'.$i.'</td>
                ';

                $idAsignacion=$detalle['ID_ASIGNACION'];
                $asignaciones = "SELECT * FROM asignaciones WHERE ID_ASIGNACION=$idAsignacion"; 
                $asignaciones=$mysqli->query($asignaciones);

                while ($asignacion=$asignaciones->fetch_assoc()) {

                    $idModulo=$asignacion['ID_MODULO'];
                    $modulos = "SELECT * FROM modulos WHERE ID_MODULO=$idModulo"; 
                    $modulos=$mysqli->query($modulos);

                    $precio=0;

                    while ($modulo=$modulos->fetch_assoc()){
                        $content.='
                            <td width="38%">'.$modulo['NOMBRE_MODULO'].'</td>
                        ';

                        $precio=$modulo['PRECIO_MODULO'];
                    }

                    $content.='
                        <td width="9%">'.$asignacion['GRUPO'].'</td>
                    ';

                    $idFrecuencia=$asignacion['ID_FRECUENCIA'];
                    $frecuencias = "SELECT * FROM frecuencias WHERE ID_FRECUENCIA=$idFrecuencia"; 
                    $frecuencias=$mysqli->query($frecuencias);

                    while ($frecuencia=$frecuencias->fetch_assoc()){
                        $content.='
                            <td width="17%">'.$frecuencia['NOMBRE_FRECUENCIA'].'</td>
                        ';
                    }

                    $hi=$asignacion['HORA_INICIO'];
                    $hf=$asignacion['HORA_FIN'];
                    $hi=substr($hi,0,5);
                    $hf=substr($hf,0,5);
                    $hora=$hi."-".$hf;

                    $content.='
                        <td width="13%">'.$hora.'</td>
                        <td width="9%">'.$asignacion['TURNO'].'</td>
                    ';

                    $content.='
                        <td width="10%">'.$precio.'</td>
                    ';

                }

                $content .= '
                    </tr>
                ';
            
                $i=$i+1;
            }
            $total=$matricula['TOTAL'];
            $adelanto=$matricula['ADELANTO'];
            $resta=$total-$adelanto;

        }   
    
        $content.= '</table>';

        $content.='<div></div><div></div><div></div>';

        $content.='
            <h4 style="text-align:right;">TOTAL: <span style="font-weight: normal;">'.$total.'</span></h4>
        ';

        $content.='
            <h4 style="text-align:right;">ADELANTO: <span style="font-weight: normal;">'.$adelanto.'</span></h4>
        ';
    
        if($resta!=0){
            $content.='
            <h4 style="text-align:right;">RESTA: <span style="font-weight: normal;">'.$resta.'</span></h4>
        ';
        }
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