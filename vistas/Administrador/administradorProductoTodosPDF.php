<?php 
    error_reporting(0);
    $mysqli = new mysqli('localhost','cetprosmp_user','#Hostinca2019','cetprosmp_cetprosmpBD');

    //require_once('conexion/conexion.php');  
    //$usuario = 'SELECT * FROM usuarios ORDER BY id DESC';   
    //$usuarios=$mysqli->query($usuario);
    $productos = 'SELECT * FROM productos ORDER BY NOMBRE_PRODUCTO ASC, ID_CATEGORIA ASC';   
    $productos=$mysqli->query($productos);
    
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
                                <th width="41%">PRODUCTO</th>
                                <th width="25%">CATEGORIA</th>
                                <th width="10%">PRECIO</th>
                                <th width="10%">STOCK</th>
                                <th width="10%">ESTADO</th>
                            </tr>
                        </thead>
        ';
    
        $i=1;
        while ($producto=$productos->fetch_assoc()) { 

            $codigo=$producto['ID_CATEGORIA'];
            $categorias = "SELECT * FROM categorias WHERE ID_CATEGORIA=$codigo"; 
            $categorias=$mysqli->query($categorias);

            while ($categoria=$categorias->fetch_assoc()) {

                //if($estado=='Activo'){  $color= '#5cb85c'; }else{ $color= '#A9A9A9'; }
                    $content .= '
                        <tr>
                            <td width="4%">'.$i.'</td>
                            <td width="41%">'.$producto['NOMBRE_PRODUCTO'].'</td>
                            <td width="25%">'.$categoria['NOMBRE_CATEGORIA'].'</td>
                            <td width="10%">'.$producto['PRECIO_PRODUCTO'].'</td>
                            <td width="10%">'.$producto['STOCK_PRODUCTO'].'</td>
                            <td width="10%">'.$producto['ESTADO_PRODUCTO'].'</td>
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