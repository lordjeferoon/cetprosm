<?php 
    error_reporting(0);
    $mysqli = new mysqli('localhost','cetprosmp_user','#Hostinca2019','cetprosmp_cetprosmpBD');

    //require_once('conexion/conexion.php');  
    //$usuario = 'SELECT * FROM usuarios ORDER BY id DESC';   
    //$usuarios=$mysqli->query($usuario);
    $modulos = 'SELECT * FROM modulos ORDER BY NOMBRE_MODULO ASC, ID_ESPECIALIDAD ASC';   
    $modulos=$mysqli->query($modulos);
    
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

        $content = '';
    
        $content .= '
                    <img src="vistas/img/logoInfo.jpg"></img>
                    
                    <h1 style="text-align:center;">'.$_POST['reporte_name'].'</h1><div></div>
        
                    <table border="1" cellpadding="5">
                        <thead>
                            <tr bgcolor="#DCDCDC">
                                <th width="4%">N.</th>
                                <th width="27%">MODULO</th>
                                <th width="27%">ESPECIALIDAD</th>
                                <th width="22%">DURACION</th>
                                <th width="10%">PRECIO</th>
                                <th width="10%">ESTADO</th>
                            </tr>
                        </thead>
        ';
    
        $i=1;
        while ($modulo=$modulos->fetch_assoc()) { 

            $codigo=$modulo['ID_ESPECIALIDAD'];
            $especialidades = "SELECT * FROM especialidades WHERE ID_ESPECIALIDAD=$codigo"; 
            $especialidades=$mysqli->query($especialidades);

            while ($especialidad=$especialidades->fetch_assoc()) {

                //if($estado=='Activo'){  $color= '#5cb85c'; }else{ $color= '#A9A9A9'; }

                    $duracion=$modulo['DURACION_MESES'].'<br>'.$modulo['DURACION_HORAS'];
                    $content .= '
                        <tr>
                            <td width="4%">'.$i.'</td>
                            <td width="27%">'.$modulo['NOMBRE_MODULO'].'</td>
                            <td width="27%">'.$especialidad['NOMBRE_ESPECIALIDAD'].'</td>
                            <td width="22%">'.$duracion.'</td>
                            <td width="10%">'.$modulo['PRECIO_MODULO'].'</td>
                            <td width="10%">'.$modulo['ESTADO_MODULO'].'</td>
                        </tr>
                    ';
            }
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