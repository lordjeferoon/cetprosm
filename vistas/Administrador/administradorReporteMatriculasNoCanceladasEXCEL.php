<?php 
	require_once 'Classes/PHPExcel.php';
	$objPHPExcel = new PHPExcel();

	$mysqli = new mysqli('localhost','cetprosmp_user','#Hostinca2019','cetprosmp_cetprosmpBD');
	
	if(mysqli_connect_errno()){
		echo 'Conexion Fallida : ', mysqli_connect_error();
		exit();
	}
	//Consulta
	$sql = "SELECT * FROM matriculas WHERE ESTADO_PAGO='No cancelado' ORDER BY FECHA ASC";
	$resultado = $mysqli->query($sql);
	$fila = 7; //Establecemos en que fila inciara a imprimir los datos
	$totalEspecialidad=0;
	$totalIngreso=0;

	$name=$_POST['reporte_name'];
	$objPHPExcel->getActiveSheet()->setCellValue('B2',$name);
	$objPHPExcel->getActiveSheet()->mergeCells('B2:G2');
	$objPHPExcel->getActiveSheet()->getStyle("B2")->getFont()->setBold(true);
	$sheet = $objPHPExcel->getActiveSheet();
	$style = array(
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        )
    );
    $styleArray = array(
    'font'  => array(
        'bold'  => true,
        'color' => array('rgb' => 'FF0000'),
        'size'  => 15,
        'name'  => 'Verdana'
    ));
    $estilo = array( 
	  'borders' => array(
	    'outline' => array(
	      'style' => PHPExcel_Style_Border::BORDER_THIN
	    )
	  )
	);

    $sheet->getStyle("B2")->applyFromArray($style);
    $sheet->getStyle("B2")->applyFromArray($styleArray);

    $nombreEspecialidad=$_POST['nombre-especialidad'];
    $objPHPExcel->getActiveSheet()->setCellValue('B3',"ESPECIALIDAD: ".$nombreEspecialidad);
	$objPHPExcel->getActiveSheet()->mergeCells('B3:G3');
	$objPHPExcel->getActiveSheet()->getStyle("B3")->getFont()->setBold(true);
	$sheet = $objPHPExcel->getActiveSheet();
    $sheet->getStyle("B3")->applyFromArray($style);

	$objPHPExcel->setActiveSheetIndex(0);
	$objPHPExcel->getActiveSheet()->setTitle('Hoja 1');

	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(14);
	$objPHPExcel->getActiveSheet()->setCellValue('B6', 'MATRICULA');
	$objPHPExcel->getActiveSheet()->getStyle("B6")->getFont()->setBold(true);

	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(11);
	$objPHPExcel->getActiveSheet()->setCellValue('C6', 'FECHA');
	$objPHPExcel->getActiveSheet()->getStyle("C6")->getFont()->setBold(true); 

	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
	$objPHPExcel->getActiveSheet()->setCellValue('D6', 'APELLIDOS Y NOMBRES');
	$objPHPExcel->getActiveSheet()->getStyle("D6")->getFont()->setBold(true);

	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(7);
	$objPHPExcel->getActiveSheet()->setCellValue('E6', 'TOTAL');
	$objPHPExcel->getActiveSheet()->getStyle("E6")->getFont()->setBold(true);

	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
	$objPHPExcel->getActiveSheet()->setCellValue('F6', 'ADELANTO');
	$objPHPExcel->getActiveSheet()->getStyle("F6")->getFont()->setBold(true); 

	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(7);
	$objPHPExcel->getActiveSheet()->setCellValue('G6', 'DEUDA');
	$objPHPExcel->getActiveSheet()->getStyle("G6")->getFont()->setBold(true); 

	$objPHPExcel->getActiveSheet()->getStyle('B6:G6')->applyFromArray($estilo);

	while($rows = $resultado->fetch_assoc()){

		$codigoMatricula=$rows['CODIGO_MATRICULA'];
		$sql3 = "SELECT * FROM matricula_detalle WHERE CODIGO_MATRICULA='".$codigoMatricula."'";
		$detalles = $mysqli->query($sql3);
		$encontrado="falso";
		while ($detalle = $detalles->fetch_assoc()) {
			
			$idAsignacion=$detalle['ID_ASIGNACION'];
			$sql3 = "SELECT * FROM asignaciones WHERE ID_ASIGNACION=$idAsignacion";
			$asignaciones = $mysqli->query($sql3);
			$idModulo;
			while($asignacion = $asignaciones->fetch_assoc()){
				$idModulo=$asignacion['ID_MODULO'];
			}

			$sql4 = "SELECT * FROM modulos WHERE ID_MODULO=$idModulo";
			$modulos = $mysqli->query($sql4);
			$idEspecialidad;
			while($modulo = $modulos->fetch_assoc()){
				$idEspecialidad=$modulo['ID_ESPECIALIDAD'];
			}
			
			if($$_POST['especialidad']==0){
                $encontrado="verdadero";
            }
            else{
                if($idEspecialidad==$_POST['especialidad']){
                    $encontrado="verdadero";
                }   
            }
		}

		if($encontrado=="verdadero"){
			$codigo=$rows['ID_ALUMNO'];
			$sql2 = "SELECT * FROM alumnos WHERE ID_ALUMNO=$codigo";
			$alumnos = $mysqli->query($sql2);
			$nombre="";
			while($alumno = $alumnos->fetch_assoc()){
				$nombre=$alumno['APELLIDOS_ALUMNO'].", ".$alumno['NOMBRES_ALUMNO'];
			}

			$total=$rows['TOTAL'];
			$adelanto=$rows['ADELANTO'];
			$resta=$total-$adelanto;
			$totalIngreso=$totalIngreso+$adelanto;
			$totalEspecialidad=$totalEspecialidad+$resta;

			$objPHPExcel->getActiveSheet()->setCellValue('B'.$fila, $rows['CODIGO_MATRICULA']);
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$fila, $rows['FECHA']);
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$fila, $nombre);
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$fila, $total);
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$fila, $adelanto);
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$fila, $resta);
		
			$fila++; //Sumamos 1 para pasar a la siguiente fila
		}
	}

	$fil = $fila-1;
	$objPHPExcel->getActiveSheet()->getStyle('B6:G'.$fil)->applyFromArray($estilo);

	$fila=$fila+2;
	//$objPHPExcel->getActiveSheet()->mergeCells('E3'.$fila.':'.$fila.'G3');
	$objPHPExcel->getActiveSheet()->setCellValue('E'.$fila,"TOTAL INGRESOS: ");
	$objPHPExcel->getActiveSheet()->getStyle("E".$fila)->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->setCellValue('G'.$fila,$totalIngreso);

	$fila++;
	//$objPHPExcel->getActiveSheet()->mergeCells('E3'.$fila.':'.$fila.'G3');
	$objPHPExcel->getActiveSheet()->setCellValue('E'.$fila,"TOTAL DEUDAS: ");
	$objPHPExcel->getActiveSheet()->getStyle("E".$fila)->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->setCellValue('G'.$fila,$totalEspecialidad);

	$fil = $fila-1;
	$objPHPExcel->getActiveSheet()->getStyle('E'.$fil.':G'.$fila)->applyFromArray($estilo);

	header('Content-Disposition: attachment;filename="Reporte de matriculas no canceladas de '.$nombreEspecialidad.'.xlsx"');
	header('Cache-Control: max-age=0');
	 
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save('php://output');
?>