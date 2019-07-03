<?php 
    error_reporting(0);
    $mysqli = new mysqli('localhost','cetprosmp_user','#Hostinca2019','cetprosmp_cetprosmpBD');

    //require_once('conexion/conexion.php');  
    //$usuario = 'SELECT * FROM usuarios ORDER BY id DESC';   
    //$usuarios=$mysqli->query($usuario);
    $docentes = 'SELECT * FROM docentes ORDER BY APELLIDOS_DOCENTE ASC';   
    $docentes=$mysqli->query($docentes);
    
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
                                <th width="11%">DNI</th>
                                <th width="24%">APELLIDOS</th>
                                <th width="24%">NOMBRES</th>
                                <th width="8%">SEXO</th>
                                <th width="18%">USUARIO</th>
                                <th width="11%">ESTADO</th>
                            </tr>
                        </thead>
        ';
    
        $i=1;
        while ($docente=$docentes->fetch_assoc()) { 

            $codigo=$docente['CODIGO_CUENTA_DOCENTE'];
            $cuentas = "SELECT * FROM cuentas WHERE CODIGO='$codigo'"; 
            $cuentas=$mysqli->query($cuentas);

            while ($cuenta=$cuentas->fetch_assoc()) {
                $usuario=$cuenta['USUARIO'];
                $estado=$cuenta['ESTADO'];
                
                    $content .= '
                        <tr>
                            <td width="4%">'.$i.'</td>
                            <td width="11%">'.$docente['DNI_DOCENTE'].'</td>
                            <td width="24%">'.$docente['APELLIDOS_DOCENTE'].'</td>
                            <td width="24%">'.$docente['NOMBRES_DOCENTE'].'</td>
                            <td width="8%">'.$docente['SEXO_DOCENTE'].'</td>
                            <td width="18%">'.$usuario.'</td>
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
        ob_end_clean();
        $pdf->output('Reporte.pdf', 'I');
    }
?> 