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
        $pdf->SetTitle($_POST['reporte-name']);
    
        $pdf->setPrintHeader(false); 
        $pdf->setPrintFooter(false);
        $pdf->SetMargins(20, 30, 20, false); 
        $pdf->SetAutoPageBreak(true, 20); 
        $pdf->SetFont('Helvetica', ''  , 9);
        $pdf->addPage();

        $categoria = $_POST['categoria'];
        $fechai = $_POST['fecha-inicio'];
        $fechaf = $_POST['fecha-fin'];
        $totalIngreso=0;
        $totalDeuda=0;

        $fechasInicio = explode("-",$fechai);
        $fechaNuevai=$fechasInicio[2]."/".$fechasInicio[1]."/".$fechasInicio[0];

        $fechasFin = explode("-",$fechaf);
        $fechaNuevaf=$fechasFin[2]."/".$fechasFin[1]."/".$fechasFin[0];

        $ventas = "SELECT * FROM ventas WHERE FECHA BETWEEN '$fechai' AND '$fechaf' ORDER BY FECHA";   
        $ventas=$mysqli->query($ventas);

        $content = '';
    
        $content .= '
                    <img src="vistas/img/logoInfo.jpg"></img>
                    
                    <h1 style="text-align:center;">'.$_POST['reporte-name'].'</h1>
                    <h2 style="text-align:center;">DEL  '.$fechaNuevai.'  AL  '.$fechaNuevaf.'</h2>
        ';

        if($categoria==5){
            $content.='
                <h3 style="text-align:center;">CATEGORÍA: BAZAR CBI </h3>  
            ';
        }
        if($categoria==4){
            $content.='
                <h3 style="text-align:center;">CATEGORÍA: BAZAR CETPRO </h3>  
            ';
        }
        if($categoria==6){
            $content.='
                <h3 style="text-align:center;">CATEGORÍA: BAZAR COSMETOLOGÍA </h3>  
            ';
        }
        if($categoria==7){
            $content.='
                <h3 style="text-align:center;">CATEGORÍA: ALQUILER DE AULAS </h3>  
            ';
        }

        $content.='<div></div><div></div>
        
                    <table border="1" cellpadding="5">
                        <thead>
                            <tr bgcolor="#DCDCDC">
                                <th width="5%">N.</th>
                                <th width="15%">FECHA</th>
                                <th width="55%">NOMBRES Y APELLIDOS</th>
                                <th width="10%">TOTAL</th>
                                <th width="15%">ESTADO</th>
                            </tr>
                        </thead>
                        <tbody>
        ';
    
        $i=1;
        while ($venta = $ventas->fetch_assoc()) { 

            $codigoVenta=$venta['CODIGO_VENTA'];
            $detalles = "SELECT * FROM venta_detalle WHERE CODIGO_VENTA='$codigoVenta'"; 
            $detalles = $mysqli->query($detalles);

            $encontrado="falso";
            while ($detalle=$detalles->fetch_assoc()) {

                $idProducto = $detalle['ID_PRODUCTO'];
                $productos = "SELECT * FROM productos WHERE ID_PRODUCTO=$idProducto"; 
                $productos=$mysqli->query($productos);

                $idCategoria;
                while ($producto = $productos->fetch_assoc()) {
                    $idCategoria=$producto['ID_CATEGORIA'];  
                }

                if($categoria == 0){
                    $encontrado="verdadero";
                }
                else{
                    if($categoria==$idCategoria){
                        $encontrado="verdadero";
                    }
                }
            }

            if($encontrado=="verdadero"){

                $total=$venta['TOTAL'];
                $adelanto=$venta['ADELANTO'];
                $resta=$total-$adelanto;
                $totalIngreso=$totalIngreso+$adelanto;
                $totalDeuda=$totalDeuda+$resta;
                
                $fechas=explode("-",$venta['FECHA']);
                $fecha=$fechas[2]."/".$fechas[1]."/".$fechas[0];

                $content .= '
                    <tr>
                        <td width="5%">'.$i.'</td>
                        <td width="15%">'.$fecha.'</td>
                        <td width="55%">'.$venta['CLIENTE'].'</td>
                        <td width="10%" style="text-align:right;">'.$total.'</td>
                        <td width="15%">'.$venta['ESTADO_PAGO'].'</td>
                    </tr>
                ';

                $i++;

            }
        }
    
        $content .= '</tbody></table><div></div><div></div>';

        $content.='
            <h3 style="text-align:right;">TOTAL INGRESOS:  S/. '.$totalIngreso.'</h3>  
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