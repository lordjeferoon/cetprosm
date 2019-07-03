<?php 
    error_reporting(0);
    $mysqli = new mysqli('localhost','cetprosmp_user','#Hostinca2019','cetprosmp_cetprosmpBD');

    $alumnos = 'SELECT * FROM alumnos ORDER BY APELLIDOS_ALUMNO ASC';   
    $alumnos=$mysqli->query($alumnos);
    
    if(isset($_POST['create_pdf'])){
        require_once('tcpdf/tcpdf.php');
    
        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
    
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Miguel Caro');
        $pdf->SetTitle($_POST['reporte_name']);
    
        $pdf->setPrintHeader(false); 
        $pdf->setPrintFooter(false);
        $pdf->SetMargins(20, 20, 20, false); 
        $pdf->SetAutoPageBreak(true, 20); 
        $pdf->SetFont('Helvetica', ''  , 9);
        $pdf->addPage();

        $content = '';
    
        $content .= '
                    <img src="vistas/img/logoInfo.jpg"></img>
                    
                    <h1 style="text-align:center;">'.$_POST['reporte_name'].'</h1><div></div>
        
                    <table border="1" cellpadding="5">
                        <thead>
                            <tr bgcolor="#DCDCDC">
                                <th width="8%">N.</th>
                                <th width="15%">DNI</th>
                                <th width="34%">APELLIDOS</th>
                                <th width="35%">NOMBRES</th>
                                <th width="8%">SEXO</th>
                              </tr>
                            </thead>
        ';
    
        $i=1;
        while ($alumno=$alumnos->fetch_assoc()) { 

                if($estado=='Activo'){  $color= '#5cb85c'; }else{ $color= '#A9A9A9'; }
                    $content .= '
                        <tr>
                            <td width="8%">'.$i.'</td>
                            <td width="15%">'.$alumno['DNI_ALUMNO'].'</td>
                            <td width="34%">'.$alumno['APELLIDOS_ALUMNO'].'</td>
                            <td width="35%">'.$alumno['NOMBRES_ALUMNO'].'</td>
                            <td width="8%">'.$alumno['SEXO_ALUMNO'].'</td>
                        </tr>
                    ';
            $i++;
        }   
    
        $content .= '</table>';
    
        $pdf->writeHTML($content, true, 0, true, 0);

        $pdf->lastPage();
        ob_end_clean();
        $pdf->output('Reporte.pdf', 'I');
    }
?> 