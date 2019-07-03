<?php 
    error_reporting(0);
    $mysqli = new mysqli('localhost','cetprosmp_user','#Hostinca2019','cetprosmp_cetprosmpBD');

    $usuario = 'SELECT * FROM administradores WHERE ID_ADMIN!=1 ORDER BY ID_ADMIN ASC';   
    $usuarios=$mysqli->query($usuario);
    
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
                                <th width="12%">DNI</th>
                                <th width="27%">APELLIDOS</th>
                                <th width="30%">NOMBRES</th>
                                <th width="15%">USUARIO</th>
                                <th width="11%">ESTADO</th>
                              </tr>
                            </thead>
        ';
    
        $i=1;
        while ($user=$usuarios->fetch_assoc()) { 

            $codigo=$user['CODIGO_CUENTA_ADMIN'];
            $cuentas = "SELECT * FROM cuentas WHERE CODIGO='$codigo'"; 
            $cuentas=$mysqli->query($cuentas);

            while ($cuenta=$cuentas->fetch_assoc()) {
                $usuario=$cuenta['USUARIO'];
                $estado=$cuenta['ESTADO'];

                if($estado=='Activo'){  $color= '#5cb85c'; }else{ $color= '#A9A9A9'; }
                    $content .= '
                        <tr>
                            <td width="5%">'.$i.'</td>
                            <td width="12%">'.$user['DNI_ADMIN'].'</td>
                            <td width="27%">'.$user['APELLIDOS_ADMIN'].'</td>
                            <td width="30%">'.$user['NOMBRES_ADMIN'].'</td>
                            <td width="15%">'.$usuario.'</td>
                            <td width="11%">'.$estado.'</td>
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
        error_reporting(E_ALL & ~E_NOTICE);
        ini_set('display_errors', 0);
        ini_set('log_errors', 1);
        ob_end_clean();
        ob_end_clean();
        $pdf->output('Reporte.pdf', 'I');
    }
?> 