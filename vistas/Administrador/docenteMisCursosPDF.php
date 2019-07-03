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

        $codigoAdmin=$_POST['codigo-docente'];

        $tabla = '
            <img src="vistas/img/logoInfo.jpg"></img>
                    
            <h1 style="text-align:center;">'.$_POST['reporte_name'].'</h1><div></div>
        ';

        $tabla.='

            <br>
            <table border="1" cellpadding="5">
                <thead>
                    <tr bgcolor="#DCDCDC">
                        <th width="5%">N.</th>
                        <th width="49%">MÓDULO</th>
                        <th width="10%">GRUPO</th>
                        <th width="18%">FRECUENCIA</th>
                        <th width="18%">HORARIO</th>
                    </tr>
                </thead>
                <tbody>'
        ;

        $anio=date('Y');
        $docentes = "SELECT * FROM docentes WHERE CODIGO_CUENTA_DOCENTE='".$codigoAdmin."'";   
        $docentes=$mysqli->query($docentes);

        foreach ($docentes as $docente) {
            $idDocente=$docente['ID_DOCENTE'];  
            $asignaciones = "SELECT * FROM asignaciones WHERE ID_DOCENTE=$idDocente AND ANIO=$anio ORDER BY ID_MODULO ASC, GRUPO ASC";   
            $asignaciones=$mysqli->query($asignaciones);

            $contador=0;
            foreach ($asignaciones as $row) {

                $idModulo=$row['ID_MODULO'];
                $modulos = "SELECT * FROM modulos WHERE ID_MODULO=$idModulo";   
                $modulos=$mysqli->query($modulos);
                $modulo = "";
                foreach ($modulos as $valor) {
                    $modulo=$valor['NOMBRE_MODULO'];
                }


                $idFrecuencia=$row['ID_FRECUENCIA'];
                $frecuencias = "SELECT * FROM frecuencias WHERE ID_FRECUENCIA=$idFrecuencia";   
                $frecuencias=$mysqli->query($frecuencias);
                $frecuencia = "";
                foreach ($frecuencias as $valor) {
                    $frecuencia=$valor['NOMBRE_FRECUENCIA'];
                }

                $hora="";
                $hi=$row['HORA_INICIO'];
                $hf=$row['HORA_FIN'];
                $hi=substr($hi,0,5);
                $hf=substr($hf,0,5);
                if($row['TURNO']=="M"){
                    $hora.=$hi.'-'.$hf.'AM';
                }
                else{
                    $hora.=$hi.'-'.$hf.'PM';
                }

                $tabla.='
                    <tr>
                        <td width="5%">'.($contador+1).'</td>
                        <td width="49%">'.$modulo.'</td>
                        <td width="10%">'.$row['GRUPO'].'</td>
                        <td width="18%">'.$frecuencia.'</td>
                        <td width="18%">'.$hora.'</td>
                ';

                $tabla.='
                    </tr>
                ';
                $contador++;
            }
            if($contador==0){
                $tabla.='
                    <tr>
                        <td colspan="5" align="center">No hay registros para mostrar</td>
                    </tr>
                ';
            }
        }

        $tabla.='</tbody>
            </table>
        ';
    
        $pdf->writeHTML($tabla, true, 0, true, 0);

        $pdf->lastPage();
        ob_end_clean();
        $pdf->output('Reporte.pdf', 'I');
    }
?> 