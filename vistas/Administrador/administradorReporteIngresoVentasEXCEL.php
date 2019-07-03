<?php 
	require_once 'Classes/PHPExcel.php';
	$objPHPExcel = new PHPExcel();

	$mysqli = new mysqli('localhost','cetprosmp_user','#Hostinca2019','cetprosmp_cetprosmpBD');
	
	if(mysqli_connect_errno()){
		echo 'Conexion Fallida : ', mysqli_connect_error();
		exit();
	}
	//Consulta
	$categoria = $_POST['categoria'];
	$fechai = $_POST['fecha-inicio'];
	$fechaf = $_POST['fecha-fin'];
	//$sql = "SELECT * FROM ventas WHERE FECHA BETWEEN '".$fechai."'" AND "'".$fechaf."'";
	$sql = "SELECT * FROM ventas WHERE FECHA BETWEEN '$fechai' AND '$fechaf' ORDER BY FECHA";
	$resultado = $mysqli->query($sql);
	$fila = 7; //Establecemos en que fila inciara a imprimir los datos
	$totalIngreso=0;

	$fechasInicio = explode("-",$fechai);
	$fechaNuevai=$fechasInicio[2]."/".$fechasInicio[1]."/".$fechasInicio[0];

	$fechasFin = explode("-",$fechaf);
	$fechaNuevaf=$fechasFin[2]."/".$fechasFin[1]."/".$fechasFin[0];

	$name=$_POST['reporte-name'];
	$objPHPExcel->getActiveSheet()->setCellValue('B2',$name);
	$objPHPExcel->getActiveSheet()->mergeCells('B2:E2');
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

    if($categoria==0){
		$objPHPExcel->getActiveSheet()->setCellValue('B3',"DEL   ".$fechaNuevai."   AL   ".$fechaNuevaf);
    }
    elseif($categoria==1){
    	$objPHPExcel->getActiveSheet()->setCellValue('B3',"BAZAR CBI - DEL   ".$fechaNuevai."   AL   ".$fechaNuevaf);
    }
    elseif($categoria==2){
    	$objPHPExcel->getActiveSheet()->setCellValue('B3',"BAZAR CETPRO - DEL   ".$fechaNuevai."   AL   ".$fechaf);
    }
    else{
    	$objPHPExcel->getActiveSheet()->setCellValue('B3',"COSMETOLOGÍA - DEL   ".$fechaNuevai."   AL   ".$fechaNuevaf);
    }

    
	$objPHPExcel->getActiveSheet()->mergeCells('B3:E3');
	$objPHPExcel->getActiveSheet()->getStyle("B3")->getFont()->setBold(true);
	$sheet = $objPHPExcel->getActiveSheet();
    $sheet->getStyle("B3")->applyFromArray($style);

	$objPHPExcel->setActiveSheetIndex(0);
	$objPHPExcel->getActiveSheet()->setTitle('Hoja 1');

	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(14);
	$objPHPExcel->getActiveSheet()->setCellValue('B6', 'CODIGO');
	$objPHPExcel->getActiveSheet()->getStyle("B6")->getFont()->setBold(true);

	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(11);
	$objPHPExcel->getActiveSheet()->setCellValue('C6', 'FECHA');
	$objPHPExcel->getActiveSheet()->getStyle("C6")->getFont()->setBold(true); 

	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(50);
	$objPHPExcel->getActiveSheet()->setCellValue('D6', 'NOMBRES Y APELLIDOS DEL CLIENTE');
	$objPHPExcel->getActiveSheet()->getStyle("D6")->getFont()->setBold(true);

	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
	$objPHPExcel->getActiveSheet()->setCellValue('E6', 'TOTAL');
	$objPHPExcel->getActiveSheet()->getStyle("E6")->getFont()->setBold(true);
	$sheet = $objPHPExcel->getActiveSheet();
    $sheet->getStyle("E6")->applyFromArray($style);


	$objPHPExcel->getActiveSheet()->getStyle('B6:E6')->applyFromArray($estilo);


	while($rows = $resultado->fetch_assoc()){

		$codigoVenta=$rows['CODIGO_VENTA'];
		$sql3 = "SELECT * FROM venta_detalle WHERE CODIGO_VENTA='".$codigoVenta."'";
		$detalles = $mysqli->query($sql3);
		$encontrado="falso";
		while ($detalle = $detalles->fetch_assoc()) {
			
			$idProducto=$detalle['ID_PRODUCTO'];
			$sql5 = "SELECT * FROM productos WHERE ID_PRODUCTO=$idProducto";
			$productos = $mysqli->query($sql5);
			$idCategoria;
			while($producto = $productos->fetch_assoc()){
				$idCategoria=$producto['ID_CATEGORIA'];
			}

			if($categoria==0){
				$encontrado="verdadero";
			}
			else{
				if($categoria==$idCategoria){
					$encontrado="verdadero";
				}
			}
		}

		if($encontrado=="verdadero"){

			$total=$rows['TOTAL'];
			$adelanto=$rows['ADELANTO'];
			$resta=$total-$adelanto;
			$totalIngreso=$totalIngreso+$total;

			$fechas=explode("-",$rows['FECHA']);
			$fecha=$fechas[2]."/".$fechas[1]."/".$fechas[0];

			$objPHPExcel->getActiveSheet()->setCellValue('B'.$fila, $rows['CODIGO_VENTA']);
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$fila, $fecha);
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$fila, $rows['CLIENTE']);
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$fila, $total);
		
			$fila++; //Sumamos 1 para pasar a la siguiente fila
		}
	}

	$fil = $fila-1;
	$objPHPExcel->getActiveSheet()->getStyle('B6:E'.$fil)->applyFromArray($estilo);

	$fila=$fila+2;
	$objPHPExcel->getActiveSheet()->setCellValue('D'.$fila,"TOTAL DE INGRESOS: ");
	$objPHPExcel->getActiveSheet()->getStyle("D".$fila)->getFont()->setBold(true);
	$sheet = $objPHPExcel->getActiveSheet();
    $sheet->getStyle("D".$fila)->applyFromArray($style);
	$objPHPExcel->getActiveSheet()->setCellValue('E'.$fila,$totalIngreso);

	$objPHPExcel->getActiveSheet()->getStyle('D'.$fila.':E'.$fila)->applyFromArray($estilo);

	header('Content-Disposition: attachment;filename="Reporte de ingresos por ventas del '.$fechaNuevai.' al '.$fechaNuevaf.'.xlsx"');
	header('Cache-Control: max-age=0');
	 
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save('php://output');
?>