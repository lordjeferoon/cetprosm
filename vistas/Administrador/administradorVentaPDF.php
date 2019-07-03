<?php 
    error_reporting(0);
    $mysqli = new mysqli(SERVER,USER,PASS,DB);

    //require_once('conexion/conexion.php');  
    //$usuario = 'SELECT * FROM usuarios ORDER BY id DESC';   
    //$usuarios=$mysqli->query($usuario);
    
    
    //if(isset($_POST['create_pdf'])){
        require_once('tcpdf/tcpdf.php');
    
        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
    
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Miguel Caro');
        $pdf->SetTitle($_POST['reporte_name']);
    
        $pdf->setPrintHeader(false); 
        $pdf->setPrintFooter(false);
        $pdf->SetMargins(20, 30, 20, false); 
        $pdf->SetAutoPageBreak(true, 20); 
        $pdf->SetFont('Helvetica', ''  , 10);
        $pdf->addPage();

        $id=$_POST['codigo'];
        //$id="VEN000000002";
        $nombre="Reporte de Venta"; 
        $matriculas = "SELECT * FROM ventas WHERE CODIGO_VENTA='".$id."'";   
        $matriculas=$mysqli->query($matriculas);

        $content = '';
    
        $content .= '

                    <img src="vistas/img/logoInfo.jpg"></img>

                    <h1 style="text-align:center; font-size: 65px;">'.$nombre.'</h1><div></div><div></div>
        ';
    
        $i=1;
        while ($matricula=$matriculas->fetch_assoc()) { 

            $codigo=$matricula['CODIGO_VENTA'];
            $detalles = "SELECT * FROM venta_detalle WHERE CODIGO_VENTA='$codigo'"; 
            $detalles=$mysqli->query($detalles);

            $content .= '
                <h4 style="text-align:left;">CODIGO VENTA: <span style="font-weight: normal;"> '.$codigo.'</span></h4>
                <h4 style="text-align:left;">CLIENTE: <span style="font-weight: normal;"> '.$matricula['CLIENTE'].'</span></h4>
            ';

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
                            <th width="5%">N.</th>
                            <th width="50%">PORDUCTO</th>
                            <th width="15%">UNIDADES</th>
                            <th width="15%">P.UNITARIO</th>
                            <th width="15%">TOTAL</th>
                        </tr>
                    </thead>
            ';

            while ($detalle=$detalles->fetch_assoc()) {

                $content.='
                    <tr>
                        <td width="5%">'.$i.'</td>
                ';

                $idAsignacion=$detalle['ID_PRODUCTO'];
                $asignaciones = "SELECT * FROM productos WHERE ID_PRODUCTO=$idAsignacion"; 
                $asignaciones=$mysqli->query($asignaciones);

                while ($asignacion=$asignaciones->fetch_assoc()) {

                    $content.='
                        <td width="50%">'.$asignacion['NOMBRE_PRODUCTO'].'</td>
                    ';

                    $content.='
                        <td width="15%">'.$detalle['UNIDADES'].'</td>
                    ';

                    $content.='
                        <td width="15%">'.$asignacion['PRECIO_PRODUCTO'].'</td>
                    ';

                    $total=$detalle['UNIDADES']*$asignacion['PRECIO_PRODUCTO'];
                    $total=(double)$total;

                    $content.='
                        <td width="15%">'.$total.'</td>
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

        //}   
    
        $content.= '</table>';

        $content.='<div></div><div></div><div></div>';

        $content.='
            <h4 style="text-align:right;">TOTAL: <span style="font-weight: normal;">'.$total.'</span></h4>
        ';

        $content.='
            <h4 style="text-align:right;">PAGO: <span style="font-weight: normal;">'.$adelanto.'</span></h4>
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