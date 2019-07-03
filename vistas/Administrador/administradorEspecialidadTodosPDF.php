<?php 
    error_reporting(0);
    $mysqli = new mysqli('localhost','cetprosmp_user','#Hostinca2019','cetprosmp_cetprosmpBD');

    //require_once('conexion/conexion.php');  
    //$usuario = 'SELECT * FROM usuarios ORDER BY id DESC';   
    //$usuarios=$mysqli->query($usuario);
    $especialidades = 'SELECT * FROM especialidades ORDER BY NOMBRE_ESPECIALIDAD ASC';   
    $especialidades=$mysqli->query($especialidades);
    
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
        $pdf->SetFont('Helvetica', ''  , 10);
        $pdf->addPage();

        $content = '';
    
        $content .= '
                    <img src="vistas/img/logoInfo.jpg"></img>

                    <h1 style="text-align:center;">'.$_POST['reporte_name'].'</h1><div></div>
        
                    <table border="1" cellpadding="5">
                        <thead>
                            <tr bgcolor="#DCDCDC">
                                <th width="5%">N.</th>
                                <th width="65%">ESPECIALIDAD</th>
                                <th width="15%">PRECIO</th>
                                <th width="15%">ESTADO</th>
                            </tr>
                        </thead>
        ';
    
        $i=1;
        while ($especialidad=$especialidades->fetch_assoc()) { 
            $estado=$especialidad['ESTADO_ESPECIALIDAD'];
            if($estado=='Activo'){  $color= '#5cb85c'; }else{ $color= '#A9A9A9'; }
                $content .= '
                    <tr>
                        <td width="5%">'.$i.'</td>
                        <td width="65%">'.$especialidad['NOMBRE_ESPECIALIDAD'].'</td>
                        <td width="15%">S/. '.$especialidad['PRECIO_ESPECIALIDAD'].'</td>
                        <td width="15%">'.$estado.'</td>
                    </tr>
                ';
            $i++; 
        }
         
    
        $content .= '</table>';
    
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