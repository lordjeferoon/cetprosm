<?php 
	require_once 'Classes/PHPExcel.php';
	$objPHPExcel = new PHPExcel();

	$mysqli = new mysqli('localhost','cetprosmp_user','#Hostinca2019','cetprosmp_cetprosmpBD');
	
	if(mysqli_connect_errno()){
		echo 'Conexion Fallida : ', mysqli_connect_error();
		exit();
	}
	//Consulta
	
    $nombreEspecialidad=$_POST['nombre-especialidad'];
    $especialidad=$_POST['especialidad'];
    //$nivel=$_POST['nivel'];

	//$sql = "SELECT * FROM ventas WHERE FECHA BETWEEN '".$fechai."'" AND "'".$fechaf."'";
	$sql = "
		SELECT DISTINCT a.ID_ALUMNO, a.APELLIDOS_ALUMNO, a.NOMBRES_ALUMNO, a.SEXO_ALUMNO, a.FECHA_NACIMIENTO_ALUMNO, a.CODIGO_CUENTA_ALUMNO, a.CONDICION_ALUMNO, m.CODIGO_MATRICULA FROM alumnos a 
        JOIN matriculas m ON m.ID_ALUMNO = a.ID_ALUMNO 
        JOIN matricula_detalle d ON d.CODIGO_MATRICULA = m.CODIGO_MATRICULA 
        JOIN asignaciones s ON s.ID_ASIGNACION = d.ID_ASIGNACION 
        JOIN modulos o ON o.ID_MODULO = s.ID_MODULO 
        WHERE o.ID_ESPECIALIDAD=$especialidad ORDER BY a.APELLIDOS_ALUMNO
	";

	$resultado = $mysqli->query($sql);
	$fila = 7; //Establecemos en que fila inciara a imprimir los datos
	
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
	$objPHPExcel->getActiveSheet()->setCellValue('C3', 'ESPECIALIDAD: ');
	$objPHPExcel->getActiveSheet()->getStyle("C3")->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->setCellValue('D3',$nombreEspecialidad);


	//Cabeceras de tabla
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(5);
	$objPHPExcel->getActiveSheet()->setCellValue('B6', 'N°');
	$objPHPExcel->getActiveSheet()->getStyle("B6")->getFont()->setBold(true);
	$sheet->getStyle("B6")->applyFromArray($style);

	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(17);
	$objPHPExcel->getActiveSheet()->setCellValue('C6', 'CÓDIGO NÓMINA');
	$objPHPExcel->getActiveSheet()->getStyle("C6")->getFont()->setBold(true);
	$sheet->getStyle("C6")->applyFromArray($style);

	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(50);
	$objPHPExcel->getActiveSheet()->setCellValue('D6', 'APELLIDOS Y NOMBRES');
	$objPHPExcel->getActiveSheet()->getStyle("D6")->getFont()->setBold(true);

	$objPHPExcel->getActiveSheet()->getStyle('B6:D6')->applyFromArray($estilo);

	$contador=1;
	while($rows = $resultado->fetch_assoc()){

		$objPHPExcel->getActiveSheet()->setCellValue('B'.$fila, $contador);
		$sheet->getStyle("B".$fila)->applyFromArray($style);

		/*if($nivel=="B"){
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$fila, $rows['CODIGO_NOMINAB']);
			$sheet->getStyle("C".$fila)->applyFromArray($style);
		}
		else{
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$fila, $rows['CODIGO_NOMINAI']);
			$sheet->getStyle("C".$fila)->applyFromArray($style);
		}*/
			
		$objPHPExcel->getActiveSheet()->setCellValue('D'.$fila, $rows['APELLIDOS_ALUMNO'].", ".$rows['NOMBRES_ALUMNO']);
			
		$fila++; //Sumamos 1 para pasar a la siguiente fila
		$contador++;
	}

	$fil = $fila-1;
	$objPHPExcel->getActiveSheet()->getStyle('B6:D'.$fil)->applyFromArray($estilo);

	header('Content-Disposition: attachment;filename="Reporte de alumnos matriculados en '.$nombreEspecialidad.'.xlsx"');
	header('Cache-Control: max-age=0');
	 
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save('php://output');
?>