<?php
	//Agregamos la libreria para leer
	require 'Classes/PHPExcel/IOFactory.php';
	$mysqli = new mysqli('localhost','cetprosmp_user','#Hostinca2019','cetprosmp_cetprosmpBD');

	if(mysqli_connect_errno()){
		echo 'Conexion Fallida : ', mysqli_connect_error();
		exit();
	}
	
	// Creamos un objeto PHPExcel
	$objPHPExcel = new PHPExcel();
	$objReader = PHPExcel_IOFactory::createReader('Excel2007');
	$objPHPExcel = $objReader->load('vistas/Administrador/Nomina.xlsx');
	// Indicamos que se pare en la hoja uno del libro
	$objPHPExcel->setActiveSheetIndex(0);

	$anio=date('Y');
	$objPHPExcel->getActiveSheet()->setCellValue('A2','NÓMINA DE MATRÍCULA '.$anio);

	$objPHPExcel->setActiveSheetIndex(10);
	$objPHPExcel->getActiveSheet()->setCellValue('A2','ACTA DE EVALUACIÓN / EDUCACIÓN TÉCNICO - PRODUCTIVA '.$anio);

	$objPHPExcel->setActiveSheetIndex(0);
	$idAsignacion=$_POST['asignacion'];
	$sql = 'SELECT * FROM asignaciones WHERE ID_ASIGNACION='.$idAsignacion;
	$asignaciones = $mysqli->query($sql);
	$level="";
	$nombreMod="";
	$finicio="";
	while($asignacion = $asignaciones->fetch_assoc()){
		
		$idModulo=$asignacion['ID_MODULO'];
		$sql = 'SELECT * FROM modulos WHERE ID_MODULO='.$idModulo;
		$modulos = $mysqli->query($sql);

		while($modulo = $modulos->fetch_assoc()){
			$objPHPExcel->getActiveSheet()->setCellValue('F13', $modulo['NOMBRE_MODULO']);
			$nombreMod=$modulo['NOMBRE_MODULO'];

			$objPHPExcel->setActiveSheetIndex(9);
			$objPHPExcel->getActiveSheet()->setCellValue('AF20', $modulo['DURACION_HORAS']);

            $objPHPExcel->setActiveSheetIndex(0);
			if($modulo['NIVEL_MODULO']=="B"){
				$objPHPExcel->getActiveSheet()->setCellValue('AG13','BÁSICO');
				$level="B";
			}
			else{
				$objPHPExcel->getActiveSheet()->setCellValue('AG13','MEDIO');
				$level="M";
			}

			$idEspecialidad=$modulo['ID_ESPECIALIDAD'];
			$sql = 'SELECT * FROM especialidades WHERE ID_ESPECIALIDAD='.$idEspecialidad;
			$especialidades = $mysqli->query($sql);

			while($especialidad = $especialidades->fetch_assoc()){
				$objPHPExcel->getActiveSheet()->setCellValue('Q12', $especialidad['NOMBRE_ESPECIALIDAD']);
			}
		}

		$idDocente = $asignacion['ID_DOCENTE'];
		$sql = 'SELECT * FROM docentes WHERE ID_DOCENTE='.$idDocente;
		$docentes = $mysqli->query($sql);

		while ($docente = $docentes->fetch_assoc()) {
			$objPHPExcel->setActiveSheetIndex(1);
			$objPHPExcel->getActiveSheet()->setCellValue('AP56',$docente['NOMBRES_DOCENTE'].', '.$docente['APELLIDOS_DOCENTE']);	
		}

		$objPHPExcel->setActiveSheetIndex(0);
		$originalDate = $asignacion['FECHA_INICIO'];
		$finicio = $asignacion['FECHA_INICIO'];
		$newDate = date("d/m/Y", strtotime($originalDate));
		$objPHPExcel->getActiveSheet()->setCellValue('G14', $newDate);
		$originalDate = $asignacion['FECHA_FIN'];
		$newDate = date("d/m/Y", strtotime($originalDate));
		$objPHPExcel->getActiveSheet()->setCellValue('R14', $newDate);
		if($asignacion['TURNO']=="M"){
			$objPHPExcel->getActiveSheet()->setCellValue('AA14',"MAÑANA");
		}
		if($asignacion['TURNO']=="T"){
			$objPHPExcel->getActiveSheet()->setCellValue('AA14',"TARDE");
		}
		
		$objPHPExcel->getActiveSheet()->setCellValue('AI14',$asignacion['GRUPO']);
	}


	$sql = 'SELECT a.ID_ALUMNO, a.APELLIDOS_ALUMNO, a.NOMBRES_ALUMNO, a.SEXO_ALUMNO, a.FECHA_NACIMIENTO_ALUMNO, a.CODIGO_CUENTA_ALUMNO, a.CONDICION_ALUMNO, a.CODIGO_NOMINAB, a.CODIGO_NOMINAI, m.CODIGO_MATRICULA, d.ID_ASIGNACION 
		FROM alumnos a JOIN matriculas m ON m.ID_ALUMNO = a.ID_ALUMNO 
		JOIN matricula_detalle d ON d.CODIGO_MATRICULA = m.CODIGO_MATRICULA 
		WHERE d.ID_ASIGNACION='.$idAsignacion.' ORDER BY a.APELLIDOS_ALUMNO';
	$resultado = $mysqli->query($sql);
	$fila = 16;
	

	$hombres=0;
	$mujeres=0;
	$filaUD1=7;
	$filaUD2=8;
	$filaUD3=8;
	$filaUD4=8;
	$filaUD5=8;
	$filaUD6=8;
	$filaUD7=8;
	$filaUD8=8;
	while($rows = $resultado->fetch_assoc()){

		if($rows['CODIGO_NOMINAB']!="" || $rows['CODIGO_NOMINAI']!=""){
		    $objPHPExcel->setActiveSheetIndex(0);
    		$nombres = explode(" ", $rows['NOMBRES_ALUMNO']);
    		$nombreAlumno="";
    		$longitud = count($nombres);
    		//Recorro todos los elementos
    		for($i=0; $i<$longitud; $i++)
          	{
          		$nombreAlumno=$nombreAlumno." ".ucfirst(strtolower($nombres[$i]));
          	}
    
          	$fecha=$rows['FECHA_NACIMIENTO_ALUMNO'];
          	$dia=date("d");
    		$mes=date("m");
    		$ano=date("Y");
    		$dianaz=date("d",strtotime($rows['FECHA_NACIMIENTO_ALUMNO']));
    		$mesnaz=date("m",strtotime($rows['FECHA_NACIMIENTO_ALUMNO']));
    		$anonaz=date("Y",strtotime($rows['FECHA_NACIMIENTO_ALUMNO']));
    		//si el mes es el mismo pero el día inferior aun no ha cumplido años, le quitaremos un año al actual
    		if (($mesnaz == $mes) && ($dianaz > $dia)) {
    		$ano=($ano-1); }
    		//si el mes es superior al actual tampoco habrá cumplido años, por eso le quitamos un año al actual
    		if ($mesnaz > $mes) {
    		$ano=($ano-1);}
    		 //ya no habría mas condiciones, ahora simplemente restamos los años y mostramos el resultado como su edad
    		$edad=($ano-$anonaz);
    
    		$objPHPExcel->getActiveSheet()->setCellValue('H'.$fila, $rows['APELLIDOS_ALUMNO'].', '.$nombreAlumno);
    		if($rows['SEXO_ALUMNO']=="M"){
    			$objPHPExcel->getActiveSheet()->setCellValue('AD'.$fila,'H');
    		}
    		else{
    			$objPHPExcel->getActiveSheet()->setCellValue('AD'.$fila,'M');
    		}
    		$objPHPExcel->getActiveSheet()->setCellValue('AG'.$fila, $edad);
    		$objPHPExcel->getActiveSheet()->setCellValue('AH'.$fila, $rows['CONDICION_ALUMNO']);
    
    		if($level=="B"){
    		    $objPHPExcel->getActiveSheet()->setCellValue('B'.$fila, $rows['CODIGO_NOMINAB']);
    		}
    		else{
    		    $objPHPExcel->getActiveSheet()->setCellValue('B'.$fila, $rows['CODIGO_NOMINAI']);
    		}
          	
    
          	$idAlumno=$rows['ID_ALUMNO'];
    	    $sql = 'SELECT ID_NOTA FROM notas WHERE ID_ASIGNACION='.$idAsignacion.' AND ID_ALUMNO='.$idAlumno.'';
    		$notas = $mysqli->query($sql);
    
    		while($nota = $notas->fetch_assoc()){
    
    			$idNota=$nota['ID_NOTA'];
    			$sql = 'SELECT NOTA,UNIDAD_DIDACTICA FROM nota_detalle WHERE ID_NOTA='.$idNota.' ORDER BY FECHA';
    			$detalles = $mysqli->query($sql);
    
    			$contadorUD1=0;
    			$contadorUD2=0;
    			$contadorUD3=0;
    			$contadorUD4=0;
    			$contadorUD5=0;
    			$contadorUD6=0;
    			$contadorUD7=0;
    			$contadorUD8=0;
    			while($detalle = $detalles->fetch_assoc()){
    
    				if($detalle['UNIDAD_DIDACTICA']==1){
    					$contadorUD1++;
    
    					if($contadorUD1<=4 && $contadorUD1>=1){
    						$objPHPExcel->setActiveSheetIndex(3);
    						if($contadorUD1==1){
    							$objPHPExcel->getActiveSheet()->setCellValue('J'.$filaUD1, $detalle['NOTA']);
    						}
    						if($contadorUD1==2){
    							$objPHPExcel->getActiveSheet()->setCellValue('L'.$filaUD1, $detalle['NOTA']);
    						}
    						if($contadorUD1==3){
    							$objPHPExcel->getActiveSheet()->setCellValue('N'.$filaUD1, $detalle['NOTA']);
    						}
    						if($contadorUD1==4){
    							$objPHPExcel->getActiveSheet()->setCellValue('P'.$filaUD1, $detalle['NOTA']);
    						}
    					}
    				}
    				
    				if($detalle['UNIDAD_DIDACTICA']==2){
    					$contadorUD2++;
    
    					if($contadorUD2<=4 && $contadorUD2>=1){
    						$objPHPExcel->setActiveSheetIndex(5);
    						if($contadorUD2==1){
    							$objPHPExcel->getActiveSheet()->setCellValue('AH'.$filaUD2, $detalle['NOTA']);
    						}
    						if($contadorUD2==2){
    							$objPHPExcel->getActiveSheet()->setCellValue('AJ'.$filaUD2, $detalle['NOTA']);
    						}
    						if($contadorUD2==3){
    							$objPHPExcel->getActiveSheet()->setCellValue('AL'.$filaUD2, $detalle['NOTA']);
    						}
    						if($contadorUD2==4){
    							$objPHPExcel->getActiveSheet()->setCellValue('AN'.$filaUD2, $detalle['NOTA']);
    						}
    					}
    				}
    
    				if($detalle['UNIDAD_DIDACTICA']==3){
    					$contadorUD3++;
    
    					if($contadorUD3<=4 && $contadorUD3>=1){
    						$objPHPExcel->setActiveSheetIndex(6);
    						if($contadorUD3==1){
    							$objPHPExcel->getActiveSheet()->setCellValue('J'.$filaUD3, $detalle['NOTA']);
    						}
    						if($contadorUD3==2){
    							$objPHPExcel->getActiveSheet()->setCellValue('L'.$filaUD3, $detalle['NOTA']);
    						}
    						if($contadorUD3==3){
    							$objPHPExcel->getActiveSheet()->setCellValue('N'.$filaUD3, $detalle['NOTA']);
    						}
    						if($contadorUD3==4){
    							$objPHPExcel->getActiveSheet()->setCellValue('P'.$filaUD3, $detalle['NOTA']);
    						}
    					}
    				}
    				
    				if($detalle['UNIDAD_DIDACTICA']==4){
    					$contadorUD4++;
    
    					if($contadorUD4<=4 && $contadorUD4>=1){
    						$objPHPExcel->setActiveSheetIndex(7);
    						if($contadorUD4==1){
    							$objPHPExcel->getActiveSheet()->setCellValue('AO'.$filaUD4, $detalle['NOTA']);
    						}
    						if($contadorUD4==2){
    							$objPHPExcel->getActiveSheet()->setCellValue('AQ'.$filaUD4, $detalle['NOTA']);
    						}
    						if($contadorUD4==3){
    							$objPHPExcel->getActiveSheet()->setCellValue('AS'.$filaUD4, $detalle['NOTA']);
    						}
    						if($contadorUD4==4){
    							$objPHPExcel->getActiveSheet()->setCellValue('AU'.$filaUD4, $detalle['NOTA']);
    						}
    					}
    				}
    				
    				if($detalle['UNIDAD_DIDACTICA']==5){
    					$contadorUD5++;
    
    					if($contadorUD5<=4 && $contadorUD5>=1){
    						$objPHPExcel->setActiveSheetIndex(8);
    						if($contadorUD5==1){
    							$objPHPExcel->getActiveSheet()->setCellValue('J'.$filaUD5, $detalle['NOTA']);
    						}
    						if($contadorUD5==2){
    							$objPHPExcel->getActiveSheet()->setCellValue('L'.$filaUD5, $detalle['NOTA']);
    						}
    						if($contadorUD5==3){
    							$objPHPExcel->getActiveSheet()->setCellValue('N'.$filaUD5, $detalle['NOTA']);
    						}
    						if($contadorUD5==4){
    							$objPHPExcel->getActiveSheet()->setCellValue('P'.$filaUD5, $detalle['NOTA']);
    						}
    					}
    				}
    
    				if($detalle['UNIDAD_DIDACTICA']==6){
    					$contadorUD6++;
    
    					if($contadorUD6<=4 && $contadorUD6>=1){
    						$objPHPExcel->setActiveSheetIndex(8);
    						if($contadorUD6==1){
    							$objPHPExcel->getActiveSheet()->setCellValue('AV'.$filaUD6, $detalle['NOTA']);
    						}
    						if($contadorUD6==2){
    							$objPHPExcel->getActiveSheet()->setCellValue('AX'.$filaUD6, $detalle['NOTA']);
    						}
    						if($contadorUD6==3){
    							$objPHPExcel->getActiveSheet()->setCellValue('AZ'.$filaUD6, $detalle['NOTA']);
    						}
    						if($contadorUD6==4){
    							$objPHPExcel->getActiveSheet()->setCellValue('BB'.$filaUD6, $detalle['NOTA']);
    						}
    					}
    				}
    				
    				if($detalle['UNIDAD_DIDACTICA']==7){
    					$contadorUD7++;
    
    					if($contadorUD7<=4 && $contadorUD7>=1){
    						$objPHPExcel->setActiveSheetIndex(7);
    						if($contadorUD7==1){
    							$objPHPExcel->getActiveSheet()->setCellValue('C'.$filaUD7, $detalle['NOTA']);
    						}
    						if($contadorUD7==2){
    							$objPHPExcel->getActiveSheet()->setCellValue('E'.$filaUD7, $detalle['NOTA']);
    						}
    						if($contadorUD7==3){
    							$objPHPExcel->getActiveSheet()->setCellValue('G'.$filaUD7, $detalle['NOTA']);
    						}
    						if($contadorUD7==4){
    							$objPHPExcel->getActiveSheet()->setCellValue('I'.$filaUD7, $detalle['NOTA']);
    						}
    					}
    				}
    				
    				if($detalle['UNIDAD_DIDACTICA']==8){
    					$contadorUD8++;
    
    					if($contadorUD8<=4 && $contadorUD8>=1){
    						$objPHPExcel->setActiveSheetIndex(6);
    						if($contadorUD8==1){
    							$objPHPExcel->getActiveSheet()->setCellValue('AV'.$filaUD8, $detalle['NOTA']);
    						}
    						if($contadorUD8==2){
    							$objPHPExcel->getActiveSheet()->setCellValue('AX'.$filaUD8, $detalle['NOTA']);
    						}
    						if($contadorUD8==3){
    							$objPHPExcel->getActiveSheet()->setCellValue('AZ'.$filaUD8, $detalle['NOTA']);
    						}
    						if($contadorUD8==4){
    							$objPHPExcel->getActiveSheet()->setCellValue('BB'.$filaUD8, $detalle['NOTA']);
    						}
    					}
    				}
    			}
    		}
    		
    		$fila++; //Sumamos 1 para pasar a la siguiente fila
    		$filaUD1=$filaUD1+2;
    		$filaUD2=$filaUD2+2;
    		$filaUD3=$filaUD3+2;
    		$filaUD4=$filaUD4+2;
    		$filaUD5=$filaUD5+2;
    		$filaUD6=$filaUD6+2;
    		$filaUD7=$filaUD7+2;
    		$filaUD8=$filaUD8+2;
		}
	}

	$objPHPExcel->setActiveSheetIndex(0);

	//colocar fecha en el archivo
	$objPHPExcel->setActiveSheetIndex(0);
	$fecha=$finicio;
	$numeros=explode("-",$fecha);
	$mes="";
	$entrada="";
	if($numeros[1]=="01"){
		$mes="Enero";
	}
	if($numeros[1]=="02"){
		$mes="Febrero";
	}
	if($numeros[1]=="03"){
		$mes="Marzo";
	}
	if($numeros[1]=="04"){
		$mes="Abril";
	}
	if($numeros[1]=="05"){
		$mes="Mayo";
	}
	if($numeros[1]=="06"){
		$mes="Junio";
	}
	if($numeros[1]=="07"){
		$mes="Julio";
	}
	if($numeros[1]=="08"){
		$mes="Agosto";
	}
	if($numeros[1]=="09"){
		$mes="Septiembre";
	}
	if($numeros[1]=="10"){
		$mes="Octubre";
	}
	if($numeros[1]=="11"){
		$mes="Noviembre";
	}
	if($numeros[1]=="12"){
		$mes="Diciembre";
	}
	$entrada=$numeros[2]." de ".$mes." del ".$numeros[0];
	$objPHPExcel->getActiveSheet()->setCellValue('B52',$entrada);
	
	$objPHPExcel->setActiveSheetIndex(10);
	$objPHPExcel->getActiveSheet()->setCellValue('B47','Chosica '.$entrada);
	
	//Guardamos los cambios
	$fecha=date('Y-m-d');
	header('Content-Disposition: attachment;filename="ACTA Y NÓMINA DE '.$nombreMod.'  '.$anio.'.xlsx"');
	header('Cache-Control: max-age=0');
	 
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save('php://output');

	//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	//$objWriter->save("Archivo_salida.xlsx");
?>