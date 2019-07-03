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

        $nombreEspecialidad=$_POST['nombre-especialidad'];
        $especialidad=$_POST['especialidad'];
        //$nivel=$_POST['nivel'];

        $content = '
            <img src="vistas/img/logoInfo.jpg"></img>
                    
            <h1 style="text-align:center;">'.$_POST['reporte_name'].'</h1>
            <p style="text-align:center; font-size: 32px;"><strong>ESPECIALIDAD: </strong>'.$nombreEspecialidad.'</p><div></div>
        ';

        $content.='
            </table><div></div><div></div>
        ';
    
        $content .= '
                    <br>
                    <table border="1" cellpadding="5">
                        <thead>
                            <tr bgcolor="#DCDCDC">
                                <th width="5%">N.</th>
                                <th width="25%">CÓDIGO</th>
                                <th width="70%">APELLIDOS Y NOMBRES</th>
                            </tr>
                        </thead>
                        <tbody>
        ';

        $matriculas="
            SELECT DISTINCT a.ID_ALUMNO, a.APELLIDOS_ALUMNO, a.NOMBRES_ALUMNO, a.SEXO_ALUMNO, a.FECHA_NACIMIENTO_ALUMNO, a.CODIGO_CUENTA_ALUMNO, a.CONDICION_ALUMNO, m.CODIGO_MATRICULA FROM alumnos a 
            JOIN matriculas m ON m.ID_ALUMNO = a.ID_ALUMNO 
            JOIN matricula_detalle d ON d.CODIGO_MATRICULA = m.CODIGO_MATRICULA 
            JOIN asignaciones s ON s.ID_ASIGNACION = d.ID_ASIGNACION 
            JOIN modulos o ON o.ID_MODULO = s.ID_MODULO 
            WHERE o.ID_ESPECIALIDAD=$especialidad ORDER BY a.APELLIDOS_ALUMNO
        ";
        $matriculas=$mysqli->query($matriculas);


        $i=1;
        while ($matricula=$matriculas->fetch_assoc()) {
            
            $content .= '
                    <tr>
                        <td width="5%">'.$i.'</td>
                        <td width="25%"></td>
                ';

                /*if($nivel=="B"){
                    $content.='
                        <td width="25%">'.$matricula['CODIGO_NOMINAB'].'</td>  
                    ';
                }
                else{
                    $content.='
                        <td width="25%">'.$matricula['CODIGO_NOMINAI'].'</td>  
                    ';
                }*/

                $content.='
                        <td width="70%">'.$matricula['APELLIDOS_ALUMNO'].', '.$matricula['NOMBRES_ALUMNO'].'</td>
                    </tr>
                ';

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