<?php 
	require_once 'Classes/PHPExcel.php';
	$objPHPExcel = new PHPExcel();

	$mysqli = new mysqli('localhost','cetprosmp_user','#Hostinca2019','cetprosmp_cetprosmpBD');
	
	if(mysqli_connect_errno()){
		echo 'Conexion Fallida : ', mysqli_connect_error();
		exit();
	}
	//Consulta
	
	$modulo=$_POST['modulo'];
    $grupo=$_POST['grupo'];
    $nombreModulo=$_POST['nombre-modulo'];
    $nombreEspecialidad=$_POST['nombre-especialidad'];
    $apellidosDocente=$_POST['apellidos-docente'];
    $nombresDocente=$_POST['nombres-docente'];
    $nombreFrecuencia=$_POST['nombre-frecuencia'];
    $hora=$_POST['hora'];
    $turno=$_POST['turno'];
    $idAsignacion=$_POST['asignacion'];
    $nivel=$_POST['nivel'];

	//$sql = "SELECT * FROM ventas WHERE FECHA BETWEEN '".$fechai."'" AND "'".$fechaf."'";
	$sql = "
		SELECT a.ID_ALUMNO, a.APELLIDOS_ALUMNO, a.CODIGO_NOMINAB, a.CODIGO_NOMINAI, a.NOMBRES_ALUMNO, a.SEXO_ALUMNO, a.FECHA_NACIMIENTO_ALUMNO, a.CODIGO_CUENTA_ALUMNO, a.CONDICION_ALUMNO, m.CODIGO_MATRICULA, d.ID_ASIGNACION 
        FROM alumnos a JOIN matriculas m ON m.ID_ALUMNO = a.ID_ALUMNO 
        JOIN matricula_detalle d ON d.CODIGO_MATRICULA = m.CODIGO_MATRICULA 
        WHERE d.ID_ASIGNACION=$idAsignacion ORDER BY a.APELLIDOS_ALUMNO
	";

	$resultado = $mysqli->query($sql);
	$fila = 14; //Establecemos en que fila inciara a imprimir los datos
	
	$name=$_POST['reporte_name'];
	$objPHPExcel->getActiveSheet()->setCellValue('B2',$name);
	$objPHPExcel->getActiveSheet()->mergeCells('B2:D2');
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

    $objPHPExcel->setActiveSheetIndex(0);
	$objPHPExcel->getActiveSheet()->setTitle('Hoja 1');

    //Datos del modulo y docente
    $objPHPExcel->getActiveSheet()->setCellValue('C5', 'MÓDULO');
	$objPHPExcel->getActiveSheet()->getStyle("C5")->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->setCellValue('D5',": ".$nombreModulo);

	$objPHPExcel->getActiveSheet()->setCellValue('C6', 'ESPECIALIDAD');
	$objPHPExcel->getActiveSheet()->getStyle("C6")->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->setCellValue('D6',": ".$nombreEspecialidad);

	$objPHPExcel->getActiveSheet()->setCellValue('C7', 'DOCENTE');
	$objPHPExcel->getActiveSheet()->getStyle("C7")->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->setCellValue('D7',": ".$apellidosDocente.", ".$nombresDocente);

	$objPHPExcel->getActiveSheet()->setCellValue('C8', 'FRECUENCIA');
	$objPHPExcel->getActiveSheet()->getStyle("C8")->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->setCellValue('D8',": ".$nombreFrecuencia);

	$objPHPExcel->getActiveSheet()->setCellValue('C9', 'HORARIO');
	$objPHPExcel->getActiveSheet()->getStyle("C9")->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->setCellValue('D9',": ".$hora);

	$objPHPExcel->getActiveSheet()->setCellValue('C10', 'TURNO');
	$objPHPExcel->getActiveSheet()->getStyle("C10")->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->setCellValue('D10',": ".$turno);


	//Cabeceras de tabla
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(5);
	$objPHPExcel->getActiveSheet()->setCellValue('B13', 'N');
	$objPHPExcel->getActiveSheet()->getStyle("B13")->getFont()->setBold(true);
	$sheet->getStyle("B13")->applyFromArray($style);

	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
	$objPHPExcel->getActiveSheet()->setCellValue('C13', 'CÓDIGO NÓMINA');
	$objPHPExcel->getActiveSheet()->getStyle("C13")->getFont()->setBold(true);
	$sheet->getStyle("C13")->applyFromArray($style);

	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(50);
	$objPHPExcel->getActiveSheet()->setCellValue('D13', 'APELLIDOS Y NOMBRES');
	$objPHPExcel->getActiveSheet()->getStyle("D13")->getFont()->setBold(true);

	$objPHPExcel->getActiveSheet()->getStyle('B13:D13')->applyFromArray($estilo);

	$contador=1;
	while($rows = $resultado->fetch_assoc()){

		$codigoMatricula=$rows['CODIGO_MATRICULA'];
		$sql3 = "SELECT * FROM matricula_detalle WHERE CODIGO_MATRICULA='".$codigoMatricula."'";
		$detalles = $mysqli->query($sql3);
		$encontrado="falso";

		while ($detalle = $detalles->fetch_assoc()) {
			
			$idAsignacion=$detalle['ID_ASIGNACION'];
			$sql5 = "SELECT * FROM asignaciones WHERE ID_ASIGNACION=$idAsignacion";
			$asignaciones = $mysqli->query($sql5);
			
			$gpo;
			$mod;
			while($asignacion = $asignaciones->fetch_assoc()){
				$gpo=$asignacion['GRUPO'];
				$mod=$asignacion['ID_MODULO'];
			}
		}
		if($mod=$modulo && $gpo==$grupo){
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$fila, $contador);
			$sheet->getStyle("B".$fila)->applyFromArray($style);

			if($nivel=="B"){
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$fila, $rows['CODIGO_NOMINAB']);
				$sheet->getStyle("C".$fila)->applyFromArray($style);
			}
			else{
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$fila, $rows['CODIGO_NOMINAI']);
				$sheet->getStyle("C".$fila)->applyFromArray($style);
			}
			
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$fila, $rows['APELLIDOS_ALUMNO'].", ".$rows['NOMBRES_ALUMNO']);
			
			$fila++; //Sumamos 1 para pasar a la siguiente fila
			$contador++;
		}	
	}

	$fil = $fila-1;
	$objPHPExcel->getActiveSheet()->getStyle('B13:D'.$fil)->applyFromArray($estilo);

	header('Content-Disposition: attachment;filename="Reporte de alumnos matriculados en '.$nombreModulo.'.xlsx"');
	header('Cache-Control: max-age=0');
	 
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save('php://output');
?>