<?php
	if ($peticionAjax) {
		require_once "../core/mainModel.php";
	}
	else{
		require_once "core/mainModel.php";
	}

	class asignacionModelo extends mainModel
	{
		
	       protected function agregar_asignacion_modelo($datos){
			$sql = mainModel::conectar()->prepare("INSERT INTO asignaciones (GRUPO, ANIO, ESTADO, ID_DOCENTE, ID_MODULO, TURNO, ID_FRECUENCIA, FECHA_INICIO, FECHA_FIN, HORA_INICIO, HORA_FIN, VACANTES) VALUES (:Grupo, :Anio, :Estado, :Docente, :Modulo, :Turno, :Frecuencia, :Inicio, :Fin, :Hi, :Hf, :Vacantes)");

			$sql->bindParam(":Grupo",$datos['Grupo']);
			$sql->bindParam(":Anio",$datos['Anio']);
			$sql->bindParam(":Estado",$datos['Estado']);
			$sql->bindParam(":Docente",$datos['Docente']);
			$sql->bindParam(":Modulo",$datos['Modulo']);
			$sql->bindParam(":Turno",$datos['Turno']);
			$sql->bindParam(":Frecuencia",$datos['Frecuencia']);
			$sql->bindParam(":Inicio",$datos['Inicio']);
			$sql->bindParam(":Fin",$datos['Fin']);
			$sql->bindParam(":Hi",$datos['Hi']);
			$sql->bindParam(":Hf",$datos['Hf']);
			$sql->bindParam(":Vacantes",$datos['Vacantes']);

			$sql->execute();
			return $sql;

		}

		protected function agregar_asistencia_modelo($datos){
			$asignacion=$datos['Asignacion'];
			$fechaActual=$datos['Fecha'];

                        $sql = mainModel::conectar()->prepare("INSERT INTO asistencia_fecha (ID_ASIGNACION, FECHA) VALUES (:Asignacion, :Fecha)");
                        $sql->bindParam(":Asignacion",$asignacion);
                        $sql->bindParam(":Fecha",$fechaActual);
                        $sql->execute(); 

			if($datos['Alumno1']!="0"){
				$alumno=$datos['Alumno1'];

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asistencias WHERE ID_ASIGNACION=$asignacion AND ID_ALUMNO=$alumno");
                                $contadorAsistencias=$consulta->rowCount();

                                if($contadorAsistencias==0){
                                        $sql = mainModel::conectar()->prepare("INSERT INTO asistencias (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
                                        $sql->bindParam(":Asignacion",$asignacion);
                                        $sql->bindParam(":Alumno",$alumno);

                                        $sql->execute();     
                                }

				$consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asistencias WHERE ID_ALUMNO=$alumno AND ID_ASIGNACION=$asignacion");
                                $detalle=$consulta->fetch();
                                $idAsistencia=$detalle['ID_ASISTENCIA'];

                                $sql = mainModel::conectar()->prepare("INSERT INTO asistencia_detalle (ID_ASISTENCIA, ASISTENCIA, FECHA) VALUES (:Id, :Asistencia, :Fecha)");
                                $sql->bindParam(":Id",$idAsistencia);
                                $sql->bindParam(":Asistencia",$datos['Asistencia1']);
                                $sql->bindParam(":Fecha",$fechaActual);

                                $sql->execute();
			}

			if($datos['Alumno2']!="0"){
                                $alumno=$datos['Alumno2'];

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asistencias WHERE ID_ASIGNACION=$asignacion AND ID_ALUMNO=$alumno");
                                $contadorAsistencias=$consulta->rowCount();

                                if($contadorAsistencias==0){
                                        $sql = mainModel::conectar()->prepare("INSERT INTO asistencias (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
                                        $sql->bindParam(":Asignacion",$asignacion);
                                        $sql->bindParam(":Alumno",$alumno);

                                        $sql->execute();     
                                }

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asistencias WHERE ID_ALUMNO=$alumno AND ID_ASIGNACION=$asignacion");
                                $detalle=$consulta->fetch();
                                $idAsistencia=$detalle['ID_ASISTENCIA'];

                                $sql = mainModel::conectar()->prepare("INSERT INTO asistencia_detalle (ID_ASISTENCIA, ASISTENCIA, FECHA) VALUES (:Id, :Asistencia, :Fecha)");
                                $sql->bindParam(":Id",$idAsistencia);
                                $sql->bindParam(":Asistencia",$datos['Asistencia2']);
                                $sql->bindParam(":Fecha",$fechaActual);

                                $sql->execute();
                        }

			if($datos['Alumno3']!="0"){
                                $alumno=$datos['Alumno3'];

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asistencias WHERE ID_ASIGNACION=$asignacion AND ID_ALUMNO=$alumno");
                                $contadorAsistencias=$consulta->rowCount();

                                if($contadorAsistencias==0){
                                        $sql = mainModel::conectar()->prepare("INSERT INTO asistencias (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
                                        $sql->bindParam(":Asignacion",$asignacion);
                                        $sql->bindParam(":Alumno",$alumno);

                                        $sql->execute();     
                                }

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asistencias WHERE ID_ALUMNO=$alumno AND ID_ASIGNACION=$asignacion");
                                $detalle=$consulta->fetch();
                                $idAsistencia=$detalle['ID_ASISTENCIA'];

                                $sql = mainModel::conectar()->prepare("INSERT INTO asistencia_detalle (ID_ASISTENCIA, ASISTENCIA, FECHA) VALUES (:Id, :Asistencia, :Fecha)");
                                $sql->bindParam(":Id",$idAsistencia);
                                $sql->bindParam(":Asistencia",$datos['Asistencia3']);
                                $sql->bindParam(":Fecha",$fechaActual);

                                $sql->execute();
                        }

                	if($datos['Alumno4']!="0"){
                                $alumno=$datos['Alumno4'];

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asistencias WHERE ID_ASIGNACION=$asignacion AND ID_ALUMNO=$alumno");
                                $contadorAsistencias=$consulta->rowCount();

                                if($contadorAsistencias==0){
                                        $sql = mainModel::conectar()->prepare("INSERT INTO asistencias (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
                                        $sql->bindParam(":Asignacion",$asignacion);
                                        $sql->bindParam(":Alumno",$alumno);

                                        $sql->execute();     
                                }

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asistencias WHERE ID_ALUMNO=$alumno AND ID_ASIGNACION=$asignacion");
                                $detalle=$consulta->fetch();
                                $idAsistencia=$detalle['ID_ASISTENCIA'];

                                $sql = mainModel::conectar()->prepare("INSERT INTO asistencia_detalle (ID_ASISTENCIA, ASISTENCIA, FECHA) VALUES (:Id, :Asistencia, :Fecha)");
                                $sql->bindParam(":Id",$idAsistencia);
                                $sql->bindParam(":Asistencia",$datos['Asistencia4']);
                                $sql->bindParam(":Fecha",$fechaActual);

                                $sql->execute();
                        }

                	if($datos['Alumno5']!="0"){
                                $alumno=$datos['Alumno5'];

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asistencias WHERE ID_ASIGNACION=$asignacion AND ID_ALUMNO=$alumno");
                                $contadorAsistencias=$consulta->rowCount();

                                if($contadorAsistencias==0){
                                        $sql = mainModel::conectar()->prepare("INSERT INTO asistencias (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
                                        $sql->bindParam(":Asignacion",$asignacion);
                                        $sql->bindParam(":Alumno",$alumno);

                                        $sql->execute();     
                                }

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asistencias WHERE ID_ALUMNO=$alumno AND ID_ASIGNACION=$asignacion");
                                $detalle=$consulta->fetch();
                                $idAsistencia=$detalle['ID_ASISTENCIA'];

                                $sql = mainModel::conectar()->prepare("INSERT INTO asistencia_detalle (ID_ASISTENCIA, ASISTENCIA, FECHA) VALUES (:Id, :Asistencia, :Fecha)");
                                $sql->bindParam(":Id",$idAsistencia);
                                $sql->bindParam(":Asistencia",$datos['Asistencia5']);
                                $sql->bindParam(":Fecha",$fechaActual);

                                $sql->execute();
                        }

                        if($datos['Alumno6']!="0"){
                                $alumno=$datos['Alumno6'];

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asistencias WHERE ID_ASIGNACION=$asignacion AND ID_ALUMNO=$alumno");
                                $contadorAsistencias=$consulta->rowCount();

                                if($contadorAsistencias==0){
                                        $sql = mainModel::conectar()->prepare("INSERT INTO asistencias (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
                                        $sql->bindParam(":Asignacion",$asignacion);
                                        $sql->bindParam(":Alumno",$alumno);

                                        $sql->execute();     
                                }

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asistencias WHERE ID_ALUMNO=$alumno AND ID_ASIGNACION=$asignacion");
                                $detalle=$consulta->fetch();
                                $idAsistencia=$detalle['ID_ASISTENCIA'];

                                $sql = mainModel::conectar()->prepare("INSERT INTO asistencia_detalle (ID_ASISTENCIA, ASISTENCIA, FECHA) VALUES (:Id, :Asistencia, :Fecha)");
                                $sql->bindParam(":Id",$idAsistencia);
                                $sql->bindParam(":Asistencia",$datos['Asistencia6']);
                                $sql->bindParam(":Fecha",$fechaActual);

                                $sql->execute();
                        }

                	if($datos['Alumno7']!="0"){
                                $alumno=$datos['Alumno7'];

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asistencias WHERE ID_ASIGNACION=$asignacion AND ID_ALUMNO=$alumno");
                                $contadorAsistencias=$consulta->rowCount();

                                if($contadorAsistencias==0){
                                        $sql = mainModel::conectar()->prepare("INSERT INTO asistencias (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
                                        $sql->bindParam(":Asignacion",$asignacion);
                                        $sql->bindParam(":Alumno",$alumno);

                                        $sql->execute();     
                                }

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asistencias WHERE ID_ALUMNO=$alumno AND ID_ASIGNACION=$asignacion");
                                $detalle=$consulta->fetch();
                                $idAsistencia=$detalle['ID_ASISTENCIA'];

                                $sql = mainModel::conectar()->prepare("INSERT INTO asistencia_detalle (ID_ASISTENCIA, ASISTENCIA, FECHA) VALUES (:Id, :Asistencia, :Fecha)");
                                $sql->bindParam(":Id",$idAsistencia);
                                $sql->bindParam(":Asistencia",$datos['Asistencia7']);
                                $sql->bindParam(":Fecha",$fechaActual);

                                $sql->execute();
                        }

                	if($datos['Alumno8']!="0"){
                                $alumno=$datos['Alumno8'];

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asistencias WHERE ID_ASIGNACION=$asignacion AND ID_ALUMNO=$alumno");
                                $contadorAsistencias=$consulta->rowCount();

                                if($contadorAsistencias==0){
                                        $sql = mainModel::conectar()->prepare("INSERT INTO asistencias (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
                                        $sql->bindParam(":Asignacion",$asignacion);
                                        $sql->bindParam(":Alumno",$alumno);

                                        $sql->execute();     
                                }

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asistencias WHERE ID_ALUMNO=$alumno AND ID_ASIGNACION=$asignacion");
                                $detalle=$consulta->fetch();
                                $idAsistencia=$detalle['ID_ASISTENCIA'];

                                $sql = mainModel::conectar()->prepare("INSERT INTO asistencia_detalle (ID_ASISTENCIA, ASISTENCIA, FECHA) VALUES (:Id, :Asistencia, :Fecha)");
                                $sql->bindParam(":Id",$idAsistencia);
                                $sql->bindParam(":Asistencia",$datos['Asistencia8']);
                                $sql->bindParam(":Fecha",$fechaActual);

                                $sql->execute();
                        }

                	if($datos['Alumno9']!="0"){
                                $alumno=$datos['Alumno9'];

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asistencias WHERE ID_ASIGNACION=$asignacion AND ID_ALUMNO=$alumno");
                                $contadorAsistencias=$consulta->rowCount();

                                if($contadorAsistencias==0){
                                        $sql = mainModel::conectar()->prepare("INSERT INTO asistencias (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
                                        $sql->bindParam(":Asignacion",$asignacion);
                                        $sql->bindParam(":Alumno",$alumno);

                                        $sql->execute();     
                                }

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asistencias WHERE ID_ALUMNO=$alumno AND ID_ASIGNACION=$asignacion");
                                $detalle=$consulta->fetch();
                                $idAsistencia=$detalle['ID_ASISTENCIA'];

                                $sql = mainModel::conectar()->prepare("INSERT INTO asistencia_detalle (ID_ASISTENCIA, ASISTENCIA, FECHA) VALUES (:Id, :Asistencia, :Fecha)");
                                $sql->bindParam(":Id",$idAsistencia);
                                $sql->bindParam(":Asistencia",$datos['Asistencia9']);
                                $sql->bindParam(":Fecha",$fechaActual);

                                $sql->execute();
                        }

                	if($datos['Alumno10']!="0"){
                                $alumno=$datos['Alumno10'];

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asistencias WHERE ID_ASIGNACION=$asignacion AND ID_ALUMNO=$alumno");
                                $contadorAsistencias=$consulta->rowCount();

                                if($contadorAsistencias==0){
                                        $sql = mainModel::conectar()->prepare("INSERT INTO asistencias (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
                                        $sql->bindParam(":Asignacion",$asignacion);
                                        $sql->bindParam(":Alumno",$alumno);

                                        $sql->execute();     
                                }

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asistencias WHERE ID_ALUMNO=$alumno AND ID_ASIGNACION=$asignacion");
                                $detalle=$consulta->fetch();
                                $idAsistencia=$detalle['ID_ASISTENCIA'];

                                $sql = mainModel::conectar()->prepare("INSERT INTO asistencia_detalle (ID_ASISTENCIA, ASISTENCIA, FECHA) VALUES (:Id, :Asistencia, :Fecha)");
                                $sql->bindParam(":Id",$idAsistencia);
                                $sql->bindParam(":Asistencia",$datos['Asistencia10']);
                                $sql->bindParam(":Fecha",$fechaActual);

                                $sql->execute();
                        }

                	if($datos['Alumno11']!="0"){
                                $alumno=$datos['Alumno11'];

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asistencias WHERE ID_ASIGNACION=$asignacion AND ID_ALUMNO=$alumno");
                                $contadorAsistencias=$consulta->rowCount();

                                if($contadorAsistencias==0){
                                        $sql = mainModel::conectar()->prepare("INSERT INTO asistencias (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
                                        $sql->bindParam(":Asignacion",$asignacion);
                                        $sql->bindParam(":Alumno",$alumno);

                                        $sql->execute();     
                                }

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asistencias WHERE ID_ALUMNO=$alumno AND ID_ASIGNACION=$asignacion");
                                $detalle=$consulta->fetch();
                                $idAsistencia=$detalle['ID_ASISTENCIA'];

                                $sql = mainModel::conectar()->prepare("INSERT INTO asistencia_detalle (ID_ASISTENCIA, ASISTENCIA, FECHA) VALUES (:Id, :Asistencia, :Fecha)");
                                $sql->bindParam(":Id",$idAsistencia);
                                $sql->bindParam(":Asistencia",$datos['Asistencia11']);
                                $sql->bindParam(":Fecha",$fechaActual);

                                $sql->execute();
                        }

                	if($datos['Alumno12']!="0"){
                                $alumno=$datos['Alumno12'];

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asistencias WHERE ID_ASIGNACION=$asignacion AND ID_ALUMNO=$alumno");
                                $contadorAsistencias=$consulta->rowCount();

                                if($contadorAsistencias==0){
                                        $sql = mainModel::conectar()->prepare("INSERT INTO asistencias (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
                                        $sql->bindParam(":Asignacion",$asignacion);
                                        $sql->bindParam(":Alumno",$alumno);

                                        $sql->execute();     
                                }

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asistencias WHERE ID_ALUMNO=$alumno AND ID_ASIGNACION=$asignacion");
                                $detalle=$consulta->fetch();
                                $idAsistencia=$detalle['ID_ASISTENCIA'];

                                $sql = mainModel::conectar()->prepare("INSERT INTO asistencia_detalle (ID_ASISTENCIA, ASISTENCIA, FECHA) VALUES (:Id, :Asistencia, :Fecha)");
                                $sql->bindParam(":Id",$idAsistencia);
                                $sql->bindParam(":Asistencia",$datos['Asistencia12']);
                                $sql->bindParam(":Fecha",$fechaActual);

                                $sql->execute();
                        }

                	if($datos['Alumno13']!="0"){
                                $alumno=$datos['Alumno13'];

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asistencias WHERE ID_ASIGNACION=$asignacion AND ID_ALUMNO=$alumno");
                                $contadorAsistencias=$consulta->rowCount();

                                if($contadorAsistencias==0){
                                        $sql = mainModel::conectar()->prepare("INSERT INTO asistencias (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
                                        $sql->bindParam(":Asignacion",$asignacion);
                                        $sql->bindParam(":Alumno",$alumno);

                                        $sql->execute();     
                                }

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asistencias WHERE ID_ALUMNO=$alumno AND ID_ASIGNACION=$asignacion");
                                $detalle=$consulta->fetch();
                                $idAsistencia=$detalle['ID_ASISTENCIA'];

                                $sql = mainModel::conectar()->prepare("INSERT INTO asistencia_detalle (ID_ASISTENCIA, ASISTENCIA, FECHA) VALUES (:Id, :Asistencia, :Fecha)");
                                $sql->bindParam(":Id",$idAsistencia);
                                $sql->bindParam(":Asistencia",$datos['Asistencia13']);
                                $sql->bindParam(":Fecha",$fechaActual);

                                $sql->execute();
                        }

                	if($datos['Alumno14']!="0"){
                                $alumno=$datos['Alumno14'];

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asistencias WHERE ID_ASIGNACION=$asignacion AND ID_ALUMNO=$alumno");
                                $contadorAsistencias=$consulta->rowCount();

                                if($contadorAsistencias==0){
                                        $sql = mainModel::conectar()->prepare("INSERT INTO asistencias (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
                                        $sql->bindParam(":Asignacion",$asignacion);
                                        $sql->bindParam(":Alumno",$alumno);

                                        $sql->execute();     
                                }

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asistencias WHERE ID_ALUMNO=$alumno AND ID_ASIGNACION=$asignacion");
                                $detalle=$consulta->fetch();
                                $idAsistencia=$detalle['ID_ASISTENCIA'];

                                $sql = mainModel::conectar()->prepare("INSERT INTO asistencia_detalle (ID_ASISTENCIA, ASISTENCIA, FECHA) VALUES (:Id, :Asistencia, :Fecha)");
                                $sql->bindParam(":Id",$idAsistencia);
                                $sql->bindParam(":Asistencia",$datos['Asistencia14']);
                                $sql->bindParam(":Fecha",$fechaActual);

                                $sql->execute();
                        }

                	if($datos['Alumno15']!="0"){
                                $alumno=$datos['Alumno15'];

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asistencias WHERE ID_ASIGNACION=$asignacion AND ID_ALUMNO=$alumno");
                                $contadorAsistencias=$consulta->rowCount();

                                if($contadorAsistencias==0){
                                        $sql = mainModel::conectar()->prepare("INSERT INTO asistencias (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
                                        $sql->bindParam(":Asignacion",$asignacion);
                                        $sql->bindParam(":Alumno",$alumno);

                                        $sql->execute();     
                                }

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asistencias WHERE ID_ALUMNO=$alumno AND ID_ASIGNACION=$asignacion");
                                $detalle=$consulta->fetch();
                                $idAsistencia=$detalle['ID_ASISTENCIA'];

                                $sql = mainModel::conectar()->prepare("INSERT INTO asistencia_detalle (ID_ASISTENCIA, ASISTENCIA, FECHA) VALUES (:Id, :Asistencia, :Fecha)");
                                $sql->bindParam(":Id",$idAsistencia);
                                $sql->bindParam(":Asistencia",$datos['Asistencia15']);
                                $sql->bindParam(":Fecha",$fechaActual);

                                $sql->execute();
                        }

                	if($datos['Alumno16']!="0"){
                                $alumno=$datos['Alumno16'];

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asistencias WHERE ID_ASIGNACION=$asignacion AND ID_ALUMNO=$alumno");
                                $contadorAsistencias=$consulta->rowCount();

                                if($contadorAsistencias==0){
                                        $sql = mainModel::conectar()->prepare("INSERT INTO asistencias (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
                                        $sql->bindParam(":Asignacion",$asignacion);
                                        $sql->bindParam(":Alumno",$alumno);

                                        $sql->execute();     
                                }

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asistencias WHERE ID_ALUMNO=$alumno AND ID_ASIGNACION=$asignacion");
                                $detalle=$consulta->fetch();
                                $idAsistencia=$detalle['ID_ASISTENCIA'];

                                $sql = mainModel::conectar()->prepare("INSERT INTO asistencia_detalle (ID_ASISTENCIA, ASISTENCIA, FECHA) VALUES (:Id, :Asistencia, :Fecha)");
                                $sql->bindParam(":Id",$idAsistencia);
                                $sql->bindParam(":Asistencia",$datos['Asistencia16']);
                                $sql->bindParam(":Fecha",$fechaActual);

                                $sql->execute();
                        }

                	if($datos['Alumno17']!="0"){
                                $alumno=$datos['Alumno17'];

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asistencias WHERE ID_ASIGNACION=$asignacion AND ID_ALUMNO=$alumno");
                                $contadorAsistencias=$consulta->rowCount();

                                if($contadorAsistencias==0){
                                        $sql = mainModel::conectar()->prepare("INSERT INTO asistencias (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
                                        $sql->bindParam(":Asignacion",$asignacion);
                                        $sql->bindParam(":Alumno",$alumno);

                                        $sql->execute();     
                                }

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asistencias WHERE ID_ALUMNO=$alumno AND ID_ASIGNACION=$asignacion");
                                $detalle=$consulta->fetch();
                                $idAsistencia=$detalle['ID_ASISTENCIA'];

                                $sql = mainModel::conectar()->prepare("INSERT INTO asistencia_detalle (ID_ASISTENCIA, ASISTENCIA, FECHA) VALUES (:Id, :Asistencia, :Fecha)");
                                $sql->bindParam(":Id",$idAsistencia);
                                $sql->bindParam(":Asistencia",$datos['Asistencia17']);
                                $sql->bindParam(":Fecha",$fechaActual);

                                $sql->execute();
                        }

                	if($datos['Alumno18']!="0"){
                                $alumno=$datos['Alumno18'];

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asistencias WHERE ID_ASIGNACION=$asignacion AND ID_ALUMNO=$alumno");
                                $contadorAsistencias=$consulta->rowCount();

                                if($contadorAsistencias==0){
                                        $sql = mainModel::conectar()->prepare("INSERT INTO asistencias (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
                                        $sql->bindParam(":Asignacion",$asignacion);
                                        $sql->bindParam(":Alumno",$alumno);

                                        $sql->execute();     
                                }

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asistencias WHERE ID_ALUMNO=$alumno AND ID_ASIGNACION=$asignacion");
                                $detalle=$consulta->fetch();
                                $idAsistencia=$detalle['ID_ASISTENCIA'];

                                $sql = mainModel::conectar()->prepare("INSERT INTO asistencia_detalle (ID_ASISTENCIA, ASISTENCIA, FECHA) VALUES (:Id, :Asistencia, :Fecha)");
                                $sql->bindParam(":Id",$idAsistencia);
                                $sql->bindParam(":Asistencia",$datos['Asistencia18']);
                                $sql->bindParam(":Fecha",$fechaActual);

                                $sql->execute();
                        }

                	if($datos['Alumno19']!="0"){
                                $alumno=$datos['Alumno19'];

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asistencias WHERE ID_ASIGNACION=$asignacion AND ID_ALUMNO=$alumno");
                                $contadorAsistencias=$consulta->rowCount();

                                if($contadorAsistencias==0){
                                        $sql = mainModel::conectar()->prepare("INSERT INTO asistencias (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
                                        $sql->bindParam(":Asignacion",$asignacion);
                                        $sql->bindParam(":Alumno",$alumno);

                                        $sql->execute();     
                                }

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asistencias WHERE ID_ALUMNO=$alumno AND ID_ASIGNACION=$asignacion");
                                $detalle=$consulta->fetch();
                                $idAsistencia=$detalle['ID_ASISTENCIA'];

                                $sql = mainModel::conectar()->prepare("INSERT INTO asistencia_detalle (ID_ASISTENCIA, ASISTENCIA, FECHA) VALUES (:Id, :Asistencia, :Fecha)");
                                $sql->bindParam(":Id",$idAsistencia);
                                $sql->bindParam(":Asistencia",$datos['Asistencia19']);
                                $sql->bindParam(":Fecha",$fechaActual);

                                $sql->execute();
                        }

                	if($datos['Alumno20']!="0"){
                                $alumno=$datos['Alumno20'];

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asistencias WHERE ID_ASIGNACION=$asignacion AND ID_ALUMNO=$alumno");
                                $contadorAsistencias=$consulta->rowCount();

                                if($contadorAsistencias==0){
                                        $sql = mainModel::conectar()->prepare("INSERT INTO asistencias (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
                                        $sql->bindParam(":Asignacion",$asignacion);
                                        $sql->bindParam(":Alumno",$alumno);

                                        $sql->execute();     
                                }

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asistencias WHERE ID_ALUMNO=$alumno AND ID_ASIGNACION=$asignacion");
                                $detalle=$consulta->fetch();
                                $idAsistencia=$detalle['ID_ASISTENCIA'];

                                $sql = mainModel::conectar()->prepare("INSERT INTO asistencia_detalle (ID_ASISTENCIA, ASISTENCIA, FECHA) VALUES (:Id, :Asistencia, :Fecha)");
                                $sql->bindParam(":Id",$idAsistencia);
                                $sql->bindParam(":Asistencia",$datos['Asistencia20']);
                                $sql->bindParam(":Fecha",$fechaActual);

                                $sql->execute();
                        }

                	if($datos['Alumno21']!="0"){
                                $alumno=$datos['Alumno21'];

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asistencias WHERE ID_ASIGNACION=$asignacion AND ID_ALUMNO=$alumno");
                                $contadorAsistencias=$consulta->rowCount();

                                if($contadorAsistencias==0){
                                        $sql = mainModel::conectar()->prepare("INSERT INTO asistencias (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
                                        $sql->bindParam(":Asignacion",$asignacion);
                                        $sql->bindParam(":Alumno",$alumno);

                                        $sql->execute();     
                                }

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asistencias WHERE ID_ALUMNO=$alumno AND ID_ASIGNACION=$asignacion");
                                $detalle=$consulta->fetch();
                                $idAsistencia=$detalle['ID_ASISTENCIA'];

                                $sql = mainModel::conectar()->prepare("INSERT INTO asistencia_detalle (ID_ASISTENCIA, ASISTENCIA, FECHA) VALUES (:Id, :Asistencia, :Fecha)");
                                $sql->bindParam(":Id",$idAsistencia);
                                $sql->bindParam(":Asistencia",$datos['Asistencia21']);
                                $sql->bindParam(":Fecha",$fechaActual);

                                $sql->execute();
                        }

                	if($datos['Alumno22']!="0"){
                                $alumno=$datos['Alumno22'];

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asistencias WHERE ID_ASIGNACION=$asignacion AND ID_ALUMNO=$alumno");
                                $contadorAsistencias=$consulta->rowCount();

                                if($contadorAsistencias==0){
                                        $sql = mainModel::conectar()->prepare("INSERT INTO asistencias (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
                                        $sql->bindParam(":Asignacion",$asignacion);
                                        $sql->bindParam(":Alumno",$alumno);

                                        $sql->execute();     
                                }

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asistencias WHERE ID_ALUMNO=$alumno AND ID_ASIGNACION=$asignacion");
                                $detalle=$consulta->fetch();
                                $idAsistencia=$detalle['ID_ASISTENCIA'];

                                $sql = mainModel::conectar()->prepare("INSERT INTO asistencia_detalle (ID_ASISTENCIA, ASISTENCIA, FECHA) VALUES (:Id, :Asistencia, :Fecha)");
                                $sql->bindParam(":Id",$idAsistencia);
                                $sql->bindParam(":Asistencia",$datos['Asistencia22']);
                                $sql->bindParam(":Fecha",$fechaActual);

                                $sql->execute();
                        }

                	if($datos['Alumno23']!="0"){
                                $alumno=$datos['Alumno23'];

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asistencias WHERE ID_ASIGNACION=$asignacion AND ID_ALUMNO=$alumno");
                                $contadorAsistencias=$consulta->rowCount();

                                if($contadorAsistencias==0){
                                        $sql = mainModel::conectar()->prepare("INSERT INTO asistencias (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
                                        $sql->bindParam(":Asignacion",$asignacion);
                                        $sql->bindParam(":Alumno",$alumno);

                                        $sql->execute();     
                                }

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asistencias WHERE ID_ALUMNO=$alumno AND ID_ASIGNACION=$asignacion");
                                $detalle=$consulta->fetch();
                                $idAsistencia=$detalle['ID_ASISTENCIA'];

                                $sql = mainModel::conectar()->prepare("INSERT INTO asistencia_detalle (ID_ASISTENCIA, ASISTENCIA, FECHA) VALUES (:Id, :Asistencia, :Fecha)");
                                $sql->bindParam(":Id",$idAsistencia);
                                $sql->bindParam(":Asistencia",$datos['Asistencia23']);
                                $sql->bindParam(":Fecha",$fechaActual);

                                $sql->execute();
                        }

                	if($datos['Alumno24']!="0"){
                                $alumno=$datos['Alumno24'];

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asistencias WHERE ID_ASIGNACION=$asignacion AND ID_ALUMNO=$alumno");
                                $contadorAsistencias=$consulta->rowCount();

                                if($contadorAsistencias==0){
                                        $sql = mainModel::conectar()->prepare("INSERT INTO asistencias (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
                                        $sql->bindParam(":Asignacion",$asignacion);
                                        $sql->bindParam(":Alumno",$alumno);

                                        $sql->execute();     
                                }

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asistencias WHERE ID_ALUMNO=$alumno AND ID_ASIGNACION=$asignacion");
                                $detalle=$consulta->fetch();
                                $idAsistencia=$detalle['ID_ASISTENCIA'];

                                $sql = mainModel::conectar()->prepare("INSERT INTO asistencia_detalle (ID_ASISTENCIA, ASISTENCIA, FECHA) VALUES (:Id, :Asistencia, :Fecha)");
                                $sql->bindParam(":Id",$idAsistencia);
                                $sql->bindParam(":Asistencia",$datos['Asistencia24']);
                                $sql->bindParam(":Fecha",$fechaActual);

                                $sql->execute();
                        }

                	if($datos['Alumno25']!="0"){
                                $alumno=$datos['Alumno25'];

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asistencias WHERE ID_ASIGNACION=$asignacion AND ID_ALUMNO=$alumno");
                                $contadorAsistencias=$consulta->rowCount();

                                if($contadorAsistencias==0){
                                        $sql = mainModel::conectar()->prepare("INSERT INTO asistencias (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
                                        $sql->bindParam(":Asignacion",$asignacion);
                                        $sql->bindParam(":Alumno",$alumno);

                                        $sql->execute();     
                                }

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asistencias WHERE ID_ALUMNO=$alumno AND ID_ASIGNACION=$asignacion");
                                $detalle=$consulta->fetch();
                                $idAsistencia=$detalle['ID_ASISTENCIA'];

                                $sql = mainModel::conectar()->prepare("INSERT INTO asistencia_detalle (ID_ASISTENCIA, ASISTENCIA, FECHA) VALUES (:Id, :Asistencia, :Fecha)");
                                $sql->bindParam(":Id",$idAsistencia);
                                $sql->bindParam(":Asistencia",$datos['Asistencia25']);
                                $sql->bindParam(":Fecha",$fechaActual);

                                $sql->execute();
                        }

                	if($datos['Alumno26']!="0"){
                                $alumno=$datos['Alumno26'];

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asistencias WHERE ID_ASIGNACION=$asignacion AND ID_ALUMNO=$alumno");
                                $contadorAsistencias=$consulta->rowCount();

                                if($contadorAsistencias==0){
                                        $sql = mainModel::conectar()->prepare("INSERT INTO asistencias (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
                                        $sql->bindParam(":Asignacion",$asignacion);
                                        $sql->bindParam(":Alumno",$alumno);

                                        $sql->execute();     
                                }

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asistencias WHERE ID_ALUMNO=$alumno AND ID_ASIGNACION=$asignacion");
                                $detalle=$consulta->fetch();
                                $idAsistencia=$detalle['ID_ASISTENCIA'];

                                $sql = mainModel::conectar()->prepare("INSERT INTO asistencia_detalle (ID_ASISTENCIA, ASISTENCIA, FECHA) VALUES (:Id, :Asistencia, :Fecha)");
                                $sql->bindParam(":Id",$idAsistencia);
                                $sql->bindParam(":Asistencia",$datos['Asistencia26']);
                                $sql->bindParam(":Fecha",$fechaActual);

                                $sql->execute();
                        }

                	if($datos['Alumno27']!="0"){
                                $alumno=$datos['Alumno27'];

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asistencias WHERE ID_ASIGNACION=$asignacion AND ID_ALUMNO=$alumno");
                                $contadorAsistencias=$consulta->rowCount();

                                if($contadorAsistencias==0){
                                        $sql = mainModel::conectar()->prepare("INSERT INTO asistencias (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
                                        $sql->bindParam(":Asignacion",$asignacion);
                                        $sql->bindParam(":Alumno",$alumno);

                                        $sql->execute();     
                                }

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asistencias WHERE ID_ALUMNO=$alumno AND ID_ASIGNACION=$asignacion");
                                $detalle=$consulta->fetch();
                                $idAsistencia=$detalle['ID_ASISTENCIA'];

                                $sql = mainModel::conectar()->prepare("INSERT INTO asistencia_detalle (ID_ASISTENCIA, ASISTENCIA, FECHA) VALUES (:Id, :Asistencia, :Fecha)");
                                $sql->bindParam(":Id",$idAsistencia);
                                $sql->bindParam(":Asistencia",$datos['Asistencia27']);
                                $sql->bindParam(":Fecha",$fechaActual);

                                $sql->execute();
                        }

                	if($datos['Alumno28']!="0"){
                                $alumno=$datos['Alumno28'];

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asistencias WHERE ID_ASIGNACION=$asignacion AND ID_ALUMNO=$alumno");
                                $contadorAsistencias=$consulta->rowCount();

                                if($contadorAsistencias==0){
                                        $sql = mainModel::conectar()->prepare("INSERT INTO asistencias (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
                                        $sql->bindParam(":Asignacion",$asignacion);
                                        $sql->bindParam(":Alumno",$alumno);

                                        $sql->execute();     
                                }

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asistencias WHERE ID_ALUMNO=$alumno AND ID_ASIGNACION=$asignacion");
                                $detalle=$consulta->fetch();
                                $idAsistencia=$detalle['ID_ASISTENCIA'];

                                $sql = mainModel::conectar()->prepare("INSERT INTO asistencia_detalle (ID_ASISTENCIA, ASISTENCIA, FECHA) VALUES (:Id, :Asistencia, :Fecha)");
                                $sql->bindParam(":Id",$idAsistencia);
                                $sql->bindParam(":Asistencia",$datos['Asistencia28']);
                                $sql->bindParam(":Fecha",$fechaActual);

                                $sql->execute();
                        }

                	if($datos['Alumno29']!="0"){
                                $alumno=$datos['Alumno29'];

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asistencias WHERE ID_ASIGNACION=$asignacion AND ID_ALUMNO=$alumno");
                                $contadorAsistencias=$consulta->rowCount();

                                if($contadorAsistencias==0){
                                        $sql = mainModel::conectar()->prepare("INSERT INTO asistencias (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
                                        $sql->bindParam(":Asignacion",$asignacion);
                                        $sql->bindParam(":Alumno",$alumno);

                                        $sql->execute();     
                                }

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asistencias WHERE ID_ALUMNO=$alumno AND ID_ASIGNACION=$asignacion");
                                $detalle=$consulta->fetch();
                                $idAsistencia=$detalle['ID_ASISTENCIA'];

                                $sql = mainModel::conectar()->prepare("INSERT INTO asistencia_detalle (ID_ASISTENCIA, ASISTENCIA, FECHA) VALUES (:Id, :Asistencia, :Fecha)");
                                $sql->bindParam(":Id",$idAsistencia);
                                $sql->bindParam(":Asistencia",$datos['Asistencia29']);
                                $sql->bindParam(":Fecha",$fechaActual);

                                $sql->execute();
                        }

                	if($datos['Alumno30']!="0"){
                                $alumno=$datos['Alumno30'];

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asistencias WHERE ID_ASIGNACION=$asignacion AND ID_ALUMNO=$alumno");
                                $contadorAsistencias=$consulta->rowCount();

                                if($contadorAsistencias==0){
                                        $sql = mainModel::conectar()->prepare("INSERT INTO asistencias (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
                                        $sql->bindParam(":Asignacion",$asignacion);
                                        $sql->bindParam(":Alumno",$alumno);

                                        $sql->execute();     
                                }

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asistencias WHERE ID_ALUMNO=$alumno AND ID_ASIGNACION=$asignacion");
                                $detalle=$consulta->fetch();
                                $idAsistencia=$detalle['ID_ASISTENCIA'];

                                $sql = mainModel::conectar()->prepare("INSERT INTO asistencia_detalle (ID_ASISTENCIA, ASISTENCIA, FECHA) VALUES (:Id, :Asistencia, :Fecha)");
                                $sql->bindParam(":Id",$idAsistencia);
                                $sql->bindParam(":Asistencia",$datos['Asistencia30']);
                                $sql->bindParam(":Fecha",$fechaActual);

                                $sql->execute();
                        }

                	if($datos['Alumno31']!="0"){
                                $alumno=$datos['Alumno31'];

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asistencias WHERE ID_ASIGNACION=$asignacion AND ID_ALUMNO=$alumno");
                                $contadorAsistencias=$consulta->rowCount();

                                if($contadorAsistencias==0){
                                        $sql = mainModel::conectar()->prepare("INSERT INTO asistencias (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
                                        $sql->bindParam(":Asignacion",$asignacion);
                                        $sql->bindParam(":Alumno",$alumno);

                                        $sql->execute();     
                                }

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asistencias WHERE ID_ALUMNO=$alumno AND ID_ASIGNACION=$asignacion");
                                $detalle=$consulta->fetch();
                                $idAsistencia=$detalle['ID_ASISTENCIA'];

                                $sql = mainModel::conectar()->prepare("INSERT INTO asistencia_detalle (ID_ASISTENCIA, ASISTENCIA, FECHA) VALUES (:Id, :Asistencia, :Fecha)");
                                $sql->bindParam(":Id",$idAsistencia);
                                $sql->bindParam(":Asistencia",$datos['Asistencia31']);
                                $sql->bindParam(":Fecha",$fechaActual);

                                $sql->execute();
                        }

                	if($datos['Alumno32']!="0"){
                                $alumno=$datos['Alumno32'];

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asistencias WHERE ID_ASIGNACION=$asignacion AND ID_ALUMNO=$alumno");
                                $contadorAsistencias=$consulta->rowCount();

                                if($contadorAsistencias==0){
                                        $sql = mainModel::conectar()->prepare("INSERT INTO asistencias (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
                                        $sql->bindParam(":Asignacion",$asignacion);
                                        $sql->bindParam(":Alumno",$alumno);

                                        $sql->execute();     
                                }

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asistencias WHERE ID_ALUMNO=$alumno AND ID_ASIGNACION=$asignacion");
                                $detalle=$consulta->fetch();
                                $idAsistencia=$detalle['ID_ASISTENCIA'];

                                $sql = mainModel::conectar()->prepare("INSERT INTO asistencia_detalle (ID_ASISTENCIA, ASISTENCIA, FECHA) VALUES (:Id, :Asistencia, :Fecha)");
                                $sql->bindParam(":Id",$idAsistencia);
                                $sql->bindParam(":Asistencia",$datos['Asistencia32']);
                                $sql->bindParam(":Fecha",$fechaActual);

                                $sql->execute();
                        }

                	if($datos['Alumno33']!="0"){
                                $alumno=$datos['Alumno33'];

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asistencias WHERE ID_ASIGNACION=$asignacion AND ID_ALUMNO=$alumno");
                                $contadorAsistencias=$consulta->rowCount();

                                if($contadorAsistencias==0){
                                        $sql = mainModel::conectar()->prepare("INSERT INTO asistencias (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
                                        $sql->bindParam(":Asignacion",$asignacion);
                                        $sql->bindParam(":Alumno",$alumno);

                                        $sql->execute();     
                                }

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asistencias WHERE ID_ALUMNO=$alumno AND ID_ASIGNACION=$asignacion");
                                $detalle=$consulta->fetch();
                                $idAsistencia=$detalle['ID_ASISTENCIA'];

                                $sql = mainModel::conectar()->prepare("INSERT INTO asistencia_detalle (ID_ASISTENCIA, ASISTENCIA, FECHA) VALUES (:Id, :Asistencia, :Fecha)");
                                $sql->bindParam(":Id",$idAsistencia);
                                $sql->bindParam(":Asistencia",$datos['Asistencia33']);
                                $sql->bindParam(":Fecha",$fechaActual);

                                $sql->execute();
                        }

                	if($datos['Alumno34']!="0"){
                                $alumno=$datos['Alumno34'];

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asistencias WHERE ID_ASIGNACION=$asignacion AND ID_ALUMNO=$alumno");
                                $contadorAsistencias=$consulta->rowCount();

                                if($contadorAsistencias==0){
                                        $sql = mainModel::conectar()->prepare("INSERT INTO asistencias (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
                                        $sql->bindParam(":Asignacion",$asignacion);
                                        $sql->bindParam(":Alumno",$alumno);

                                        $sql->execute();     
                                }

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asistencias WHERE ID_ALUMNO=$alumno AND ID_ASIGNACION=$asignacion");
                                $detalle=$consulta->fetch();
                                $idAsistencia=$detalle['ID_ASISTENCIA'];

                                $sql = mainModel::conectar()->prepare("INSERT INTO asistencia_detalle (ID_ASISTENCIA, ASISTENCIA, FECHA) VALUES (:Id, :Asistencia, :Fecha)");
                                $sql->bindParam(":Id",$idAsistencia);
                                $sql->bindParam(":Asistencia",$datos['Asistencia34']);
                                $sql->bindParam(":Fecha",$fechaActual);

                                $sql->execute();
                        }

                	if($datos['Alumno35']!="0"){
                                $alumno=$datos['Alumno35'];

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asistencias WHERE ID_ASIGNACION=$asignacion AND ID_ALUMNO=$alumno");
                                $contadorAsistencias=$consulta->rowCount();

                                if($contadorAsistencias==0){
                                        $sql = mainModel::conectar()->prepare("INSERT INTO asistencias (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
                                        $sql->bindParam(":Asignacion",$asignacion);
                                        $sql->bindParam(":Alumno",$alumno);

                                        $sql->execute();     
                                }

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asistencias WHERE ID_ALUMNO=$alumno AND ID_ASIGNACION=$asignacion");
                                $detalle=$consulta->fetch();
                                $idAsistencia=$detalle['ID_ASISTENCIA'];

                                $sql = mainModel::conectar()->prepare("INSERT INTO asistencia_detalle (ID_ASISTENCIA, ASISTENCIA, FECHA) VALUES (:Id, :Asistencia, :Fecha)");
                                $sql->bindParam(":Id",$idAsistencia);
                                $sql->bindParam(":Asistencia",$datos['Asistencia35']);
                                $sql->bindParam(":Fecha",$fechaActual);

                                $sql->execute();
                        }

                	if($datos['Alumno36']!="0"){
                                $alumno=$datos['Alumno36'];

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asistencias WHERE ID_ASIGNACION=$asignacion AND ID_ALUMNO=$alumno");
                                $contadorAsistencias=$consulta->rowCount();

                                if($contadorAsistencias==0){
                                        $sql = mainModel::conectar()->prepare("INSERT INTO asistencias (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
                                        $sql->bindParam(":Asignacion",$asignacion);
                                        $sql->bindParam(":Alumno",$alumno);

                                        $sql->execute();     
                                }

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asistencias WHERE ID_ALUMNO=$alumno AND ID_ASIGNACION=$asignacion");
                                $detalle=$consulta->fetch();
                                $idAsistencia=$detalle['ID_ASISTENCIA'];

                                $sql = mainModel::conectar()->prepare("INSERT INTO asistencia_detalle (ID_ASISTENCIA, ASISTENCIA, FECHA) VALUES (:Id, :Asistencia, :Fecha)");
                                $sql->bindParam(":Id",$idAsistencia);
                                $sql->bindParam(":Asistencia",$datos['Asistencia36']);
                                $sql->bindParam(":Fecha",$fechaActual);

                                $sql->execute();
                        }

                	if($datos['Alumno37']!="0"){
                                $alumno=$datos['Alumno37'];

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asistencias WHERE ID_ASIGNACION=$asignacion AND ID_ALUMNO=$alumno");
                                $contadorAsistencias=$consulta->rowCount();

                                if($contadorAsistencias==0){
                                        $sql = mainModel::conectar()->prepare("INSERT INTO asistencias (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
                                        $sql->bindParam(":Asignacion",$asignacion);
                                        $sql->bindParam(":Alumno",$alumno);

                                        $sql->execute();     
                                }

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asistencias WHERE ID_ALUMNO=$alumno AND ID_ASIGNACION=$asignacion");
                                $detalle=$consulta->fetch();
                                $idAsistencia=$detalle['ID_ASISTENCIA'];

                                $sql = mainModel::conectar()->prepare("INSERT INTO asistencia_detalle (ID_ASISTENCIA, ASISTENCIA, FECHA) VALUES (:Id, :Asistencia, :Fecha)");
                                $sql->bindParam(":Id",$idAsistencia);
                                $sql->bindParam(":Asistencia",$datos['Asistencia37']);
                                $sql->bindParam(":Fecha",$fechaActual);

                                $sql->execute();
                        }

                	if($datos['Alumno38']!="0"){
                                $alumno=$datos['Alumno38'];

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asistencias WHERE ID_ASIGNACION=$asignacion AND ID_ALUMNO=$alumno");
                                $contadorAsistencias=$consulta->rowCount();

                                if($contadorAsistencias==0){
                                        $sql = mainModel::conectar()->prepare("INSERT INTO asistencias (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
                                        $sql->bindParam(":Asignacion",$asignacion);
                                        $sql->bindParam(":Alumno",$alumno);

                                        $sql->execute();     
                                }

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asistencias WHERE ID_ALUMNO=$alumno AND ID_ASIGNACION=$asignacion");
                                $detalle=$consulta->fetch();
                                $idAsistencia=$detalle['ID_ASISTENCIA'];

                                $sql = mainModel::conectar()->prepare("INSERT INTO asistencia_detalle (ID_ASISTENCIA, ASISTENCIA, FECHA) VALUES (:Id, :Asistencia, :Fecha)");
                                $sql->bindParam(":Id",$idAsistencia);
                                $sql->bindParam(":Asistencia",$datos['Asistencia38']);
                                $sql->bindParam(":Fecha",$fechaActual);

                                $sql->execute();
                        }

                	if($datos['Alumno39']!="0"){
                                $alumno=$datos['Alumno39'];

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asistencias WHERE ID_ASIGNACION=$asignacion AND ID_ALUMNO=$alumno");
                                $contadorAsistencias=$consulta->rowCount();

                                if($contadorAsistencias==0){
                                        $sql = mainModel::conectar()->prepare("INSERT INTO asistencias (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
                                        $sql->bindParam(":Asignacion",$asignacion);
                                        $sql->bindParam(":Alumno",$alumno);

                                        $sql->execute();     
                                }

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asistencias WHERE ID_ALUMNO=$alumno AND ID_ASIGNACION=$asignacion");
                                $detalle=$consulta->fetch();
                                $idAsistencia=$detalle['ID_ASISTENCIA'];

                                $sql = mainModel::conectar()->prepare("INSERT INTO asistencia_detalle (ID_ASISTENCIA, ASISTENCIA, FECHA) VALUES (:Id, :Asistencia, :Fecha)");
                                $sql->bindParam(":Id",$idAsistencia);
                                $sql->bindParam(":Asistencia",$datos['Asistencia39']);
                                $sql->bindParam(":Fecha",$fechaActual);

                                $sql->execute();
                        }

                	if($datos['Alumno40']!="0"){
                                $alumno=$datos['Alumno40'];

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asistencias WHERE ID_ASIGNACION=$asignacion AND ID_ALUMNO=$alumno");
                                $contadorAsistencias=$consulta->rowCount();

                                if($contadorAsistencias==0){
                                        $sql = mainModel::conectar()->prepare("INSERT INTO asistencias (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
                                        $sql->bindParam(":Asignacion",$asignacion);
                                        $sql->bindParam(":Alumno",$alumno);

                                        $sql->execute();     
                                }

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asistencias WHERE ID_ALUMNO=$alumno AND ID_ASIGNACION=$asignacion");
                                $detalle=$consulta->fetch();
                                $idAsistencia=$detalle['ID_ASISTENCIA'];

                                $sql = mainModel::conectar()->prepare("INSERT INTO asistencia_detalle (ID_ASISTENCIA, ASISTENCIA, FECHA) VALUES (:Id, :Asistencia, :Fecha)");
                                $sql->bindParam(":Id",$idAsistencia);
                                $sql->bindParam(":Asistencia",$datos['Asistencia40']);
                                $sql->bindParam(":Fecha",$fechaActual);

                                $sql->execute();
                        }

			return $sql;
		}

                protected function agregar_nota_modelo($datos){
                        $asignacion=$datos['Asignacion'];
                        $fechaActual=date("Y-m-d H:i:s");

                        if($datos['Alumno1']!="0"){
                                $alumno=$datos['Alumno1'];

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM notas WHERE ID_ASIGNACION=$asignacion AND ID_ALUMNO=$alumno");
                                $contadorNotas=$consulta->rowCount();

                                if($contadorNotas==0){
                                        $sql = mainModel::conectar()->prepare("INSERT INTO notas (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
                                        $sql->bindParam(":Asignacion",$asignacion);
                                        $sql->bindParam(":Alumno",$alumno);

                                        $sql->execute();     
                                }

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM notas WHERE ID_ALUMNO=$alumno AND ID_ASIGNACION=$asignacion");
                                $detalle=$consulta->fetch();
                                $idNota=$detalle['ID_NOTA'];

                                $sql = mainModel::conectar()->prepare("INSERT INTO nota_detalle (ID_NOTA, NOTA, UNIDAD_DIDACTICA, FECHA) VALUES (:Id, :Asistencia, :Unidad,  :Fecha)");
                                $sql->bindParam(":Id",$idNota);
                                $sql->bindParam(":Asistencia",$datos['Asistencia1']);
                                $sql->bindParam(":Unidad",$datos['Unidad']);
                                $sql->bindParam(":Fecha",$fechaActual);

                                $sql->execute();
                        }

                        if($datos['Alumno2']!="0"){
                                $alumno=$datos['Alumno2'];

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM notas WHERE ID_ASIGNACION=$asignacion AND ID_ALUMNO=$alumno");
                                $contadorNotas=$consulta->rowCount();

                                if($contadorNotas==0){
                                        $sql = mainModel::conectar()->prepare("INSERT INTO notas (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
                                        $sql->bindParam(":Asignacion",$asignacion);
                                        $sql->bindParam(":Alumno",$alumno);

                                        $sql->execute();     
                                }

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM notas WHERE ID_ALUMNO=$alumno AND ID_ASIGNACION=$asignacion");
                                $detalle=$consulta->fetch();
                                $idNota=$detalle['ID_NOTA'];

                                $sql = mainModel::conectar()->prepare("INSERT INTO nota_detalle (ID_NOTA, NOTA, UNIDAD_DIDACTICA, FECHA) VALUES (:Id, :Asistencia, :Unidad,  :Fecha)");
                                $sql->bindParam(":Id",$idNota);
                                $sql->bindParam(":Asistencia",$datos['Asistencia2']);
                                $sql->bindParam(":Unidad",$datos['Unidad']);
                                $sql->bindParam(":Fecha",$fechaActual);

                                $sql->execute();
                        }

                        if($datos['Alumno3']!="0"){
                                $alumno=$datos['Alumno3'];

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM notas WHERE ID_ASIGNACION=$asignacion AND ID_ALUMNO=$alumno");
                                $contadorNotas=$consulta->rowCount();

                                if($contadorNotas==0){
                                        $sql = mainModel::conectar()->prepare("INSERT INTO notas (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
                                        $sql->bindParam(":Asignacion",$asignacion);
                                        $sql->bindParam(":Alumno",$alumno);

                                        $sql->execute();     
                                }

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM notas WHERE ID_ALUMNO=$alumno AND ID_ASIGNACION=$asignacion");
                                $detalle=$consulta->fetch();
                                $idNota=$detalle['ID_NOTA'];

                                $sql = mainModel::conectar()->prepare("INSERT INTO nota_detalle (ID_NOTA, NOTA, UNIDAD_DIDACTICA, FECHA) VALUES (:Id, :Asistencia, :Unidad,  :Fecha)");
                                $sql->bindParam(":Id",$idNota);
                                $sql->bindParam(":Asistencia",$datos['Asistencia3']);
                                $sql->bindParam(":Unidad",$datos['Unidad']);
                                $sql->bindParam(":Fecha",$fechaActual);

                                $sql->execute();
                        }

                        if($datos['Alumno4']!="0"){
                                $alumno=$datos['Alumno4'];

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM notas WHERE ID_ASIGNACION=$asignacion AND ID_ALUMNO=$alumno");
                                $contadorNotas=$consulta->rowCount();

                                if($contadorNotas==0){
                                        $sql = mainModel::conectar()->prepare("INSERT INTO notas (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
                                        $sql->bindParam(":Asignacion",$asignacion);
                                        $sql->bindParam(":Alumno",$alumno);

                                        $sql->execute();     
                                }

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM notas WHERE ID_ALUMNO=$alumno AND ID_ASIGNACION=$asignacion");
                                $detalle=$consulta->fetch();
                                $idNota=$detalle['ID_NOTA'];

                                $sql = mainModel::conectar()->prepare("INSERT INTO nota_detalle (ID_NOTA, NOTA, UNIDAD_DIDACTICA, FECHA) VALUES (:Id, :Asistencia, :Unidad,  :Fecha)");
                                $sql->bindParam(":Id",$idNota);
                                $sql->bindParam(":Asistencia",$datos['Asistencia4']);
                                $sql->bindParam(":Unidad",$datos['Unidad']);
                                $sql->bindParam(":Fecha",$fechaActual);

                                $sql->execute();
                        }

                        if($datos['Alumno5']!="0"){
                                $alumno=$datos['Alumno5'];

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM notas WHERE ID_ASIGNACION=$asignacion AND ID_ALUMNO=$alumno");
                                $contadorNotas=$consulta->rowCount();

                                if($contadorNotas==0){
                                        $sql = mainModel::conectar()->prepare("INSERT INTO notas (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
                                        $sql->bindParam(":Asignacion",$asignacion);
                                        $sql->bindParam(":Alumno",$alumno);

                                        $sql->execute();     
                                }

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM notas WHERE ID_ALUMNO=$alumno AND ID_ASIGNACION=$asignacion");
                                $detalle=$consulta->fetch();
                                $idNota=$detalle['ID_NOTA'];

                                $sql = mainModel::conectar()->prepare("INSERT INTO nota_detalle (ID_NOTA, NOTA, UNIDAD_DIDACTICA, FECHA) VALUES (:Id, :Asistencia, :Unidad,  :Fecha)");
                                $sql->bindParam(":Id",$idNota);
                                $sql->bindParam(":Asistencia",$datos['Asistencia5']);
                                $sql->bindParam(":Unidad",$datos['Unidad']);
                                $sql->bindParam(":Fecha",$fechaActual);

                                $sql->execute();
                        }

                        if($datos['Alumno6']!="0"){
                                $alumno=$datos['Alumno6'];

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM notas WHERE ID_ASIGNACION=$asignacion AND ID_ALUMNO=$alumno");
                                $contadorNotas=$consulta->rowCount();

                                if($contadorNotas==0){
                                        $sql = mainModel::conectar()->prepare("INSERT INTO notas (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
                                        $sql->bindParam(":Asignacion",$asignacion);
                                        $sql->bindParam(":Alumno",$alumno);

                                        $sql->execute();     
                                }

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM notas WHERE ID_ALUMNO=$alumno AND ID_ASIGNACION=$asignacion");
                                $detalle=$consulta->fetch();
                                $idNota=$detalle['ID_NOTA'];

                                $sql = mainModel::conectar()->prepare("INSERT INTO nota_detalle (ID_NOTA, NOTA, UNIDAD_DIDACTICA, FECHA) VALUES (:Id, :Asistencia, :Unidad,  :Fecha)");
                                $sql->bindParam(":Id",$idNota);
                                $sql->bindParam(":Asistencia",$datos['Asistencia6']);
                                $sql->bindParam(":Unidad",$datos['Unidad']);
                                $sql->bindParam(":Fecha",$fechaActual);

                                $sql->execute();
                        }

                        if($datos['Alumno7']!="0"){
                                $alumno=$datos['Alumno7'];

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM notas WHERE ID_ASIGNACION=$asignacion AND ID_ALUMNO=$alumno");
                                $contadorNotas=$consulta->rowCount();

                                if($contadorNotas==0){
                                        $sql = mainModel::conectar()->prepare("INSERT INTO notas (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
                                        $sql->bindParam(":Asignacion",$asignacion);
                                        $sql->bindParam(":Alumno",$alumno);

                                        $sql->execute();     
                                }

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM notas WHERE ID_ALUMNO=$alumno AND ID_ASIGNACION=$asignacion");
                                $detalle=$consulta->fetch();
                                $idNota=$detalle['ID_NOTA'];

                                $sql = mainModel::conectar()->prepare("INSERT INTO nota_detalle (ID_NOTA, NOTA, UNIDAD_DIDACTICA, FECHA) VALUES (:Id, :Asistencia, :Unidad,  :Fecha)");
                                $sql->bindParam(":Id",$idNota);
                                $sql->bindParam(":Asistencia",$datos['Asistencia7']);
                                $sql->bindParam(":Unidad",$datos['Unidad']);
                                $sql->bindParam(":Fecha",$fechaActual);

                                $sql->execute();
                        }

                        if($datos['Alumno8']!="0"){
                                $alumno=$datos['Alumno8'];

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM notas WHERE ID_ASIGNACION=$asignacion AND ID_ALUMNO=$alumno");
                                $contadorNotas=$consulta->rowCount();

                                if($contadorNotas==0){
                                        $sql = mainModel::conectar()->prepare("INSERT INTO notas (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
                                        $sql->bindParam(":Asignacion",$asignacion);
                                        $sql->bindParam(":Alumno",$alumno);

                                        $sql->execute();     
                                }

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM notas WHERE ID_ALUMNO=$alumno AND ID_ASIGNACION=$asignacion");
                                $detalle=$consulta->fetch();
                                $idNota=$detalle['ID_NOTA'];

                                $sql = mainModel::conectar()->prepare("INSERT INTO nota_detalle (ID_NOTA, NOTA, UNIDAD_DIDACTICA, FECHA) VALUES (:Id, :Asistencia, :Unidad,  :Fecha)");
                                $sql->bindParam(":Id",$idNota);
                                $sql->bindParam(":Asistencia",$datos['Asistencia8']);
                                $sql->bindParam(":Unidad",$datos['Unidad']);
                                $sql->bindParam(":Fecha",$fechaActual);

                                $sql->execute();
                        }

                        if($datos['Alumno9']!="0"){
                                $alumno=$datos['Alumno9'];

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM notas WHERE ID_ASIGNACION=$asignacion AND ID_ALUMNO=$alumno");
                                $contadorNotas=$consulta->rowCount();

                                if($contadorNotas==0){
                                        $sql = mainModel::conectar()->prepare("INSERT INTO notas (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
                                        $sql->bindParam(":Asignacion",$asignacion);
                                        $sql->bindParam(":Alumno",$alumno);

                                        $sql->execute();     
                                }

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM notas WHERE ID_ALUMNO=$alumno AND ID_ASIGNACION=$asignacion");
                                $detalle=$consulta->fetch();
                                $idNota=$detalle['ID_NOTA'];

                                $sql = mainModel::conectar()->prepare("INSERT INTO nota_detalle (ID_NOTA, NOTA, UNIDAD_DIDACTICA, FECHA) VALUES (:Id, :Asistencia, :Unidad,  :Fecha)");
                                $sql->bindParam(":Id",$idNota);
                                $sql->bindParam(":Asistencia",$datos['Asistencia9']);
                                $sql->bindParam(":Unidad",$datos['Unidad']);
                                $sql->bindParam(":Fecha",$fechaActual);

                                $sql->execute();
                        }

                        if($datos['Alumno10']!="0"){
                                $alumno=$datos['Alumno10'];

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM notas WHERE ID_ASIGNACION=$asignacion AND ID_ALUMNO=$alumno");
                                $contadorNotas=$consulta->rowCount();

                                if($contadorNotas==0){
                                        $sql = mainModel::conectar()->prepare("INSERT INTO notas (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
                                        $sql->bindParam(":Asignacion",$asignacion);
                                        $sql->bindParam(":Alumno",$alumno);

                                        $sql->execute();     
                                }

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM notas WHERE ID_ALUMNO=$alumno AND ID_ASIGNACION=$asignacion");
                                $detalle=$consulta->fetch();
                                $idNota=$detalle['ID_NOTA'];

                                $sql = mainModel::conectar()->prepare("INSERT INTO nota_detalle (ID_NOTA, NOTA, UNIDAD_DIDACTICA, FECHA) VALUES (:Id, :Asistencia, :Unidad,  :Fecha)");
                                $sql->bindParam(":Id",$idNota);
                                $sql->bindParam(":Asistencia",$datos['Asistencia10']);
                                $sql->bindParam(":Unidad",$datos['Unidad']);
                                $sql->bindParam(":Fecha",$fechaActual);

                                $sql->execute();
                        }

                        if($datos['Alumno11']!="0"){
                                $alumno=$datos['Alumno11'];

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM notas WHERE ID_ASIGNACION=$asignacion AND ID_ALUMNO=$alumno");
                                $contadorNotas=$consulta->rowCount();

                                if($contadorNotas==0){
                                        $sql = mainModel::conectar()->prepare("INSERT INTO notas (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
                                        $sql->bindParam(":Asignacion",$asignacion);
                                        $sql->bindParam(":Alumno",$alumno);

                                        $sql->execute();     
                                }

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM notas WHERE ID_ALUMNO=$alumno AND ID_ASIGNACION=$asignacion");
                                $detalle=$consulta->fetch();
                                $idNota=$detalle['ID_NOTA'];

                                $sql = mainModel::conectar()->prepare("INSERT INTO nota_detalle (ID_NOTA, NOTA, UNIDAD_DIDACTICA, FECHA) VALUES (:Id, :Asistencia, :Unidad,  :Fecha)");
                                $sql->bindParam(":Id",$idNota);
                                $sql->bindParam(":Asistencia",$datos['Asistencia11']);
                                $sql->bindParam(":Unidad",$datos['Unidad']);
                                $sql->bindParam(":Fecha",$fechaActual);

                                $sql->execute();
                        }

                        if($datos['Alumno12']!="0"){
                                $alumno=$datos['Alumno12'];

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM notas WHERE ID_ASIGNACION=$asignacion AND ID_ALUMNO=$alumno");
                                $contadorNotas=$consulta->rowCount();

                                if($contadorNotas==0){
                                        $sql = mainModel::conectar()->prepare("INSERT INTO notas (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
                                        $sql->bindParam(":Asignacion",$asignacion);
                                        $sql->bindParam(":Alumno",$alumno);

                                        $sql->execute();     
                                }

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM notas WHERE ID_ALUMNO=$alumno AND ID_ASIGNACION=$asignacion");
                                $detalle=$consulta->fetch();
                                $idNota=$detalle['ID_NOTA'];

                                $sql = mainModel::conectar()->prepare("INSERT INTO nota_detalle (ID_NOTA, NOTA, UNIDAD_DIDACTICA, FECHA) VALUES (:Id, :Asistencia, :Unidad,  :Fecha)");
                                $sql->bindParam(":Id",$idNota);
                                $sql->bindParam(":Asistencia",$datos['Asistencia12']);
                                $sql->bindParam(":Unidad",$datos['Unidad']);
                                $sql->bindParam(":Fecha",$fechaActual);

                                $sql->execute();
                        }

                        if($datos['Alumno13']!="0"){
                                $alumno=$datos['Alumno13'];

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM notas WHERE ID_ASIGNACION=$asignacion AND ID_ALUMNO=$alumno");
                                $contadorNotas=$consulta->rowCount();

                                if($contadorNotas==0){
                                        $sql = mainModel::conectar()->prepare("INSERT INTO notas (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
                                        $sql->bindParam(":Asignacion",$asignacion);
                                        $sql->bindParam(":Alumno",$alumno);

                                        $sql->execute();     
                                }

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM notas WHERE ID_ALUMNO=$alumno AND ID_ASIGNACION=$asignacion");
                                $detalle=$consulta->fetch();
                                $idNota=$detalle['ID_NOTA'];

                                $sql = mainModel::conectar()->prepare("INSERT INTO nota_detalle (ID_NOTA, NOTA, UNIDAD_DIDACTICA, FECHA) VALUES (:Id, :Asistencia, :Unidad,  :Fecha)");
                                $sql->bindParam(":Id",$idNota);
                                $sql->bindParam(":Asistencia",$datos['Asistencia13']);
                                $sql->bindParam(":Unidad",$datos['Unidad']);
                                $sql->bindParam(":Fecha",$fechaActual);

                                $sql->execute();
                        }

                        if($datos['Alumno14']!="0"){
                                $alumno=$datos['Alumno14'];

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM notas WHERE ID_ASIGNACION=$asignacion AND ID_ALUMNO=$alumno");
                                $contadorNotas=$consulta->rowCount();

                                if($contadorNotas==0){
                                        $sql = mainModel::conectar()->prepare("INSERT INTO notas (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
                                        $sql->bindParam(":Asignacion",$asignacion);
                                        $sql->bindParam(":Alumno",$alumno);

                                        $sql->execute();     
                                }

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM notas WHERE ID_ALUMNO=$alumno AND ID_ASIGNACION=$asignacion");
                                $detalle=$consulta->fetch();
                                $idNota=$detalle['ID_NOTA'];

                                $sql = mainModel::conectar()->prepare("INSERT INTO nota_detalle (ID_NOTA, NOTA, UNIDAD_DIDACTICA, FECHA) VALUES (:Id, :Asistencia, :Unidad,  :Fecha)");
                                $sql->bindParam(":Id",$idNota);
                                $sql->bindParam(":Asistencia",$datos['Asistencia14']);
                                $sql->bindParam(":Unidad",$datos['Unidad']);
                                $sql->bindParam(":Fecha",$fechaActual);

                                $sql->execute();
                        }

                        if($datos['Alumno15']!="0"){
                                $alumno=$datos['Alumno15'];

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM notas WHERE ID_ASIGNACION=$asignacion AND ID_ALUMNO=$alumno");
                                $contadorNotas=$consulta->rowCount();

                                if($contadorNotas==0){
                                        $sql = mainModel::conectar()->prepare("INSERT INTO notas (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
                                        $sql->bindParam(":Asignacion",$asignacion);
                                        $sql->bindParam(":Alumno",$alumno);

                                        $sql->execute();     
                                }

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM notas WHERE ID_ALUMNO=$alumno AND ID_ASIGNACION=$asignacion");
                                $detalle=$consulta->fetch();
                                $idNota=$detalle['ID_NOTA'];

                                $sql = mainModel::conectar()->prepare("INSERT INTO nota_detalle (ID_NOTA, NOTA, UNIDAD_DIDACTICA, FECHA) VALUES (:Id, :Asistencia, :Unidad,  :Fecha)");
                                $sql->bindParam(":Id",$idNota);
                                $sql->bindParam(":Asistencia",$datos['Asistencia15']);
                                $sql->bindParam(":Unidad",$datos['Unidad']);
                                $sql->bindParam(":Fecha",$fechaActual);

                                $sql->execute();
                        }

                        if($datos['Alumno16']!="0"){
                                $alumno=$datos['Alumno16'];

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM notas WHERE ID_ASIGNACION=$asignacion AND ID_ALUMNO=$alumno");
                                $contadorNotas=$consulta->rowCount();

                                if($contadorNotas==0){
                                        $sql = mainModel::conectar()->prepare("INSERT INTO notas (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
                                        $sql->bindParam(":Asignacion",$asignacion);
                                        $sql->bindParam(":Alumno",$alumno);

                                        $sql->execute();     
                                }

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM notas WHERE ID_ALUMNO=$alumno AND ID_ASIGNACION=$asignacion");
                                $detalle=$consulta->fetch();
                                $idNota=$detalle['ID_NOTA'];

                                $sql = mainModel::conectar()->prepare("INSERT INTO nota_detalle (ID_NOTA, NOTA, UNIDAD_DIDACTICA, FECHA) VALUES (:Id, :Asistencia, :Unidad,  :Fecha)");
                                $sql->bindParam(":Id",$idNota);
                                $sql->bindParam(":Asistencia",$datos['Asistencia16']);
                                $sql->bindParam(":Unidad",$datos['Unidad']);
                                $sql->bindParam(":Fecha",$fechaActual);

                                $sql->execute();
                        }

                        if($datos['Alumno17']!="0"){
                                $alumno=$datos['Alumno17'];

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM notas WHERE ID_ASIGNACION=$asignacion AND ID_ALUMNO=$alumno");
                                $contadorNotas=$consulta->rowCount();

                                if($contadorNotas==0){
                                        $sql = mainModel::conectar()->prepare("INSERT INTO notas (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
                                        $sql->bindParam(":Asignacion",$asignacion);
                                        $sql->bindParam(":Alumno",$alumno);

                                        $sql->execute();     
                                }

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM notas WHERE ID_ALUMNO=$alumno AND ID_ASIGNACION=$asignacion");
                                $detalle=$consulta->fetch();
                                $idNota=$detalle['ID_NOTA'];

                                $sql = mainModel::conectar()->prepare("INSERT INTO nota_detalle (ID_NOTA, NOTA, UNIDAD_DIDACTICA, FECHA) VALUES (:Id, :Asistencia, :Unidad,  :Fecha)");
                                $sql->bindParam(":Id",$idNota);
                                $sql->bindParam(":Asistencia",$datos['Asistencia17']);
                                $sql->bindParam(":Unidad",$datos['Unidad']);
                                $sql->bindParam(":Fecha",$fechaActual);

                                $sql->execute();
                        }

                        if($datos['Alumno18']!="0"){
                                $alumno=$datos['Alumno18'];

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM notas WHERE ID_ASIGNACION=$asignacion AND ID_ALUMNO=$alumno");
                                $contadorNotas=$consulta->rowCount();

                                if($contadorNotas==0){
                                        $sql = mainModel::conectar()->prepare("INSERT INTO notas (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
                                        $sql->bindParam(":Asignacion",$asignacion);
                                        $sql->bindParam(":Alumno",$alumno);

                                        $sql->execute();     
                                }

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM notas WHERE ID_ALUMNO=$alumno AND ID_ASIGNACION=$asignacion");
                                $detalle=$consulta->fetch();
                                $idNota=$detalle['ID_NOTA'];

                                $sql = mainModel::conectar()->prepare("INSERT INTO nota_detalle (ID_NOTA, NOTA, UNIDAD_DIDACTICA, FECHA) VALUES (:Id, :Asistencia, :Unidad,  :Fecha)");
                                $sql->bindParam(":Id",$idNota);
                                $sql->bindParam(":Asistencia",$datos['Asistencia18']);
                                $sql->bindParam(":Unidad",$datos['Unidad']);
                                $sql->bindParam(":Fecha",$fechaActual);

                                $sql->execute();
                        }

                        if($datos['Alumno19']!="0"){
                                $alumno=$datos['Alumno19'];

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM notas WHERE ID_ASIGNACION=$asignacion AND ID_ALUMNO=$alumno");
                                $contadorNotas=$consulta->rowCount();

                                if($contadorNotas==0){
                                        $sql = mainModel::conectar()->prepare("INSERT INTO notas (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
                                        $sql->bindParam(":Asignacion",$asignacion);
                                        $sql->bindParam(":Alumno",$alumno);

                                        $sql->execute();     
                                }

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM notas WHERE ID_ALUMNO=$alumno AND ID_ASIGNACION=$asignacion");
                                $detalle=$consulta->fetch();
                                $idNota=$detalle['ID_NOTA'];

                                $sql = mainModel::conectar()->prepare("INSERT INTO nota_detalle (ID_NOTA, NOTA, UNIDAD_DIDACTICA, FECHA) VALUES (:Id, :Asistencia, :Unidad,  :Fecha)");
                                $sql->bindParam(":Id",$idNota);
                                $sql->bindParam(":Asistencia",$datos['Asistencia19']);
                                $sql->bindParam(":Unidad",$datos['Unidad']);
                                $sql->bindParam(":Fecha",$fechaActual);

                                $sql->execute();
                        }

                        if($datos['Alumno20']!="0"){
                                $alumno=$datos['Alumno20'];

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM notas WHERE ID_ASIGNACION=$asignacion AND ID_ALUMNO=$alumno");
                                $contadorNotas=$consulta->rowCount();

                                if($contadorNotas==0){
                                        $sql = mainModel::conectar()->prepare("INSERT INTO notas (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
                                        $sql->bindParam(":Asignacion",$asignacion);
                                        $sql->bindParam(":Alumno",$alumno);

                                        $sql->execute();     
                                }

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM notas WHERE ID_ALUMNO=$alumno AND ID_ASIGNACION=$asignacion");
                                $detalle=$consulta->fetch();
                                $idNota=$detalle['ID_NOTA'];

                                $sql = mainModel::conectar()->prepare("INSERT INTO nota_detalle (ID_NOTA, NOTA, UNIDAD_DIDACTICA, FECHA) VALUES (:Id, :Asistencia, :Unidad,  :Fecha)");
                                $sql->bindParam(":Id",$idNota);
                                $sql->bindParam(":Asistencia",$datos['Asistencia20']);
                                $sql->bindParam(":Unidad",$datos['Unidad']);
                                $sql->bindParam(":Fecha",$fechaActual);

                                $sql->execute();
                        }

                        if($datos['Alumno21']!="0"){
                                $alumno=$datos['Alumno21'];

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM notas WHERE ID_ASIGNACION=$asignacion AND ID_ALUMNO=$alumno");
                                $contadorNotas=$consulta->rowCount();

                                if($contadorNotas==0){
                                        $sql = mainModel::conectar()->prepare("INSERT INTO notas (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
                                        $sql->bindParam(":Asignacion",$asignacion);
                                        $sql->bindParam(":Alumno",$alumno);

                                        $sql->execute();     
                                }

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM notas WHERE ID_ALUMNO=$alumno AND ID_ASIGNACION=$asignacion");
                                $detalle=$consulta->fetch();
                                $idNota=$detalle['ID_NOTA'];

                                $sql = mainModel::conectar()->prepare("INSERT INTO nota_detalle (ID_NOTA, NOTA, UNIDAD_DIDACTICA, FECHA) VALUES (:Id, :Asistencia, :Unidad,  :Fecha)");
                                $sql->bindParam(":Id",$idNota);
                                $sql->bindParam(":Asistencia",$datos['Asistencia21']);
                                $sql->bindParam(":Unidad",$datos['Unidad']);
                                $sql->bindParam(":Fecha",$fechaActual);

                                $sql->execute();
                        }

                        if($datos['Alumno22']!="0"){
                                $alumno=$datos['Alumno22'];

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM notas WHERE ID_ASIGNACION=$asignacion AND ID_ALUMNO=$alumno");
                                $contadorNotas=$consulta->rowCount();

                                if($contadorNotas==0){
                                        $sql = mainModel::conectar()->prepare("INSERT INTO notas (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
                                        $sql->bindParam(":Asignacion",$asignacion);
                                        $sql->bindParam(":Alumno",$alumno);

                                        $sql->execute();     
                                }

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM notas WHERE ID_ALUMNO=$alumno AND ID_ASIGNACION=$asignacion");
                                $detalle=$consulta->fetch();
                                $idNota=$detalle['ID_NOTA'];

                                $sql = mainModel::conectar()->prepare("INSERT INTO nota_detalle (ID_NOTA, NOTA, UNIDAD_DIDACTICA, FECHA) VALUES (:Id, :Asistencia, :Unidad,  :Fecha)");
                                $sql->bindParam(":Id",$idNota);
                                $sql->bindParam(":Asistencia",$datos['Asistencia22']);
                                $sql->bindParam(":Unidad",$datos['Unidad']);
                                $sql->bindParam(":Fecha",$fechaActual);

                                $sql->execute();
                        }

                        if($datos['Alumno23']!="0"){
                                $alumno=$datos['Alumno23'];

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM notas WHERE ID_ASIGNACION=$asignacion AND ID_ALUMNO=$alumno");
                                $contadorNotas=$consulta->rowCount();

                                if($contadorNotas==0){
                                        $sql = mainModel::conectar()->prepare("INSERT INTO notas (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
                                        $sql->bindParam(":Asignacion",$asignacion);
                                        $sql->bindParam(":Alumno",$alumno);

                                        $sql->execute();     
                                }

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM notas WHERE ID_ALUMNO=$alumno AND ID_ASIGNACION=$asignacion");
                                $detalle=$consulta->fetch();
                                $idNota=$detalle['ID_NOTA'];

                                $sql = mainModel::conectar()->prepare("INSERT INTO nota_detalle (ID_NOTA, NOTA, UNIDAD_DIDACTICA, FECHA) VALUES (:Id, :Asistencia, :Unidad,  :Fecha)");
                                $sql->bindParam(":Id",$idNota);
                                $sql->bindParam(":Asistencia",$datos['Asistencia23']);
                                $sql->bindParam(":Unidad",$datos['Unidad']);
                                $sql->bindParam(":Fecha",$fechaActual);

                                $sql->execute();
                        }

                        if($datos['Alumno24']!="0"){
                                $alumno=$datos['Alumno24'];

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM notas WHERE ID_ASIGNACION=$asignacion AND ID_ALUMNO=$alumno");
                                $contadorNotas=$consulta->rowCount();

                                if($contadorNotas==0){
                                        $sql = mainModel::conectar()->prepare("INSERT INTO notas (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
                                        $sql->bindParam(":Asignacion",$asignacion);
                                        $sql->bindParam(":Alumno",$alumno);

                                        $sql->execute();     
                                }

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM notas WHERE ID_ALUMNO=$alumno AND ID_ASIGNACION=$asignacion");
                                $detalle=$consulta->fetch();
                                $idNota=$detalle['ID_NOTA'];

                                $sql = mainModel::conectar()->prepare("INSERT INTO nota_detalle (ID_NOTA, NOTA, UNIDAD_DIDACTICA, FECHA) VALUES (:Id, :Asistencia, :Unidad,  :Fecha)");
                                $sql->bindParam(":Id",$idNota);
                                $sql->bindParam(":Asistencia",$datos['Asistencia24']);
                                $sql->bindParam(":Unidad",$datos['Unidad']);
                                $sql->bindParam(":Fecha",$fechaActual);

                                $sql->execute();
                        }

                        if($datos['Alumno25']!="0"){
                                $alumno=$datos['Alumno25'];

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM notas WHERE ID_ASIGNACION=$asignacion AND ID_ALUMNO=$alumno");
                                $contadorNotas=$consulta->rowCount();

                                if($contadorNotas==0){
                                        $sql = mainModel::conectar()->prepare("INSERT INTO notas (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
                                        $sql->bindParam(":Asignacion",$asignacion);
                                        $sql->bindParam(":Alumno",$alumno);

                                        $sql->execute();     
                                }

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM notas WHERE ID_ALUMNO=$alumno AND ID_ASIGNACION=$asignacion");
                                $detalle=$consulta->fetch();
                                $idNota=$detalle['ID_NOTA'];

                                $sql = mainModel::conectar()->prepare("INSERT INTO nota_detalle (ID_NOTA, NOTA, UNIDAD_DIDACTICA, FECHA) VALUES (:Id, :Asistencia, :Unidad,  :Fecha)");
                                $sql->bindParam(":Id",$idNota);
                                $sql->bindParam(":Asistencia",$datos['Asistencia25']);
                                $sql->bindParam(":Unidad",$datos['Unidad']);
                                $sql->bindParam(":Fecha",$fechaActual);

                                $sql->execute();
                        }

                        if($datos['Alumno26']!="0"){
                                $alumno=$datos['Alumno26'];

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM notas WHERE ID_ASIGNACION=$asignacion AND ID_ALUMNO=$alumno");
                                $contadorNotas=$consulta->rowCount();

                                if($contadorNotas==0){
                                        $sql = mainModel::conectar()->prepare("INSERT INTO notas (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
                                        $sql->bindParam(":Asignacion",$asignacion);
                                        $sql->bindParam(":Alumno",$alumno);

                                        $sql->execute();     
                                }

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM notas WHERE ID_ALUMNO=$alumno AND ID_ASIGNACION=$asignacion");
                                $detalle=$consulta->fetch();
                                $idNota=$detalle['ID_NOTA'];

                                $sql = mainModel::conectar()->prepare("INSERT INTO nota_detalle (ID_NOTA, NOTA, UNIDAD_DIDACTICA, FECHA) VALUES (:Id, :Asistencia, :Unidad,  :Fecha)");
                                $sql->bindParam(":Id",$idNota);
                                $sql->bindParam(":Asistencia",$datos['Asistencia26']);
                                $sql->bindParam(":Unidad",$datos['Unidad']);
                                $sql->bindParam(":Fecha",$fechaActual);

                                $sql->execute();
                        }

                        if($datos['Alumno27']!="0"){
                                $alumno=$datos['Alumno27'];

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM notas WHERE ID_ASIGNACION=$asignacion AND ID_ALUMNO=$alumno");
                                $contadorNotas=$consulta->rowCount();

                                if($contadorNotas==0){
                                        $sql = mainModel::conectar()->prepare("INSERT INTO notas (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
                                        $sql->bindParam(":Asignacion",$asignacion);
                                        $sql->bindParam(":Alumno",$alumno);

                                        $sql->execute();     
                                }

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM notas WHERE ID_ALUMNO=$alumno AND ID_ASIGNACION=$asignacion");
                                $detalle=$consulta->fetch();
                                $idNota=$detalle['ID_NOTA'];

                                $sql = mainModel::conectar()->prepare("INSERT INTO nota_detalle (ID_NOTA, NOTA, UNIDAD_DIDACTICA, FECHA) VALUES (:Id, :Asistencia, :Unidad,  :Fecha)");
                                $sql->bindParam(":Id",$idNota);
                                $sql->bindParam(":Asistencia",$datos['Asistencia27']);
                                $sql->bindParam(":Unidad",$datos['Unidad']);
                                $sql->bindParam(":Fecha",$fechaActual);

                                $sql->execute();
                        }

                        if($datos['Alumno28']!="0"){
                                $alumno=$datos['Alumno28'];

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM notas WHERE ID_ASIGNACION=$asignacion AND ID_ALUMNO=$alumno");
                                $contadorNotas=$consulta->rowCount();

                                if($contadorNotas==0){
                                        $sql = mainModel::conectar()->prepare("INSERT INTO notas (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
                                        $sql->bindParam(":Asignacion",$asignacion);
                                        $sql->bindParam(":Alumno",$alumno);

                                        $sql->execute();     
                                }

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM notas WHERE ID_ALUMNO=$alumno AND ID_ASIGNACION=$asignacion");
                                $detalle=$consulta->fetch();
                                $idNota=$detalle['ID_NOTA'];

                                $sql = mainModel::conectar()->prepare("INSERT INTO nota_detalle (ID_NOTA, NOTA, UNIDAD_DIDACTICA, FECHA) VALUES (:Id, :Asistencia, :Unidad,  :Fecha)");
                                $sql->bindParam(":Id",$idNota);
                                $sql->bindParam(":Asistencia",$datos['Asistencia28']);
                                $sql->bindParam(":Unidad",$datos['Unidad']);
                                $sql->bindParam(":Fecha",$fechaActual);

                                $sql->execute();
                        }

                        if($datos['Alumno29']!="0"){
                                $alumno=$datos['Alumno29'];

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM notas WHERE ID_ASIGNACION=$asignacion AND ID_ALUMNO=$alumno");
                                $contadorNotas=$consulta->rowCount();

                                if($contadorNotas==0){
                                        $sql = mainModel::conectar()->prepare("INSERT INTO notas (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
                                        $sql->bindParam(":Asignacion",$asignacion);
                                        $sql->bindParam(":Alumno",$alumno);

                                        $sql->execute();     
                                }

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM notas WHERE ID_ALUMNO=$alumno AND ID_ASIGNACION=$asignacion");
                                $detalle=$consulta->fetch();
                                $idNota=$detalle['ID_NOTA'];

                                $sql = mainModel::conectar()->prepare("INSERT INTO nota_detalle (ID_NOTA, NOTA, UNIDAD_DIDACTICA, FECHA) VALUES (:Id, :Asistencia, :Unidad,  :Fecha)");
                                $sql->bindParam(":Id",$idNota);
                                $sql->bindParam(":Asistencia",$datos['Asistencia29']);
                                $sql->bindParam(":Unidad",$datos['Unidad']);
                                $sql->bindParam(":Fecha",$fechaActual);

                                $sql->execute();
                        }

                        if($datos['Alumno30']!="0"){
                                $alumno=$datos['Alumno30'];

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM notas WHERE ID_ASIGNACION=$asignacion AND ID_ALUMNO=$alumno");
                                $contadorNotas=$consulta->rowCount();

                                if($contadorNotas==0){
                                        $sql = mainModel::conectar()->prepare("INSERT INTO notas (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
                                        $sql->bindParam(":Asignacion",$asignacion);
                                        $sql->bindParam(":Alumno",$alumno);

                                        $sql->execute();     
                                }

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM notas WHERE ID_ALUMNO=$alumno AND ID_ASIGNACION=$asignacion");
                                $detalle=$consulta->fetch();
                                $idNota=$detalle['ID_NOTA'];

                                $sql = mainModel::conectar()->prepare("INSERT INTO nota_detalle (ID_NOTA, NOTA, UNIDAD_DIDACTICA, FECHA) VALUES (:Id, :Asistencia, :Unidad,  :Fecha)");
                                $sql->bindParam(":Id",$idNota);
                                $sql->bindParam(":Asistencia",$datos['Asistencia30']);
                                $sql->bindParam(":Unidad",$datos['Unidad']);
                                $sql->bindParam(":Fecha",$fechaActual);

                                $sql->execute();
                        }

                        if($datos['Alumno31']!="0"){
                                $alumno=$datos['Alumno31'];

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM notas WHERE ID_ASIGNACION=$asignacion AND ID_ALUMNO=$alumno");
                                $contadorNotas=$consulta->rowCount();

                                if($contadorNotas==0){
                                        $sql = mainModel::conectar()->prepare("INSERT INTO notas (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
                                        $sql->bindParam(":Asignacion",$asignacion);
                                        $sql->bindParam(":Alumno",$alumno);

                                        $sql->execute();     
                                }

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM notas WHERE ID_ALUMNO=$alumno AND ID_ASIGNACION=$asignacion");
                                $detalle=$consulta->fetch();
                                $idNota=$detalle['ID_NOTA'];

                                $sql = mainModel::conectar()->prepare("INSERT INTO nota_detalle (ID_NOTA, NOTA, UNIDAD_DIDACTICA, FECHA) VALUES (:Id, :Asistencia, :Unidad,  :Fecha)");
                                $sql->bindParam(":Id",$idNota);
                                $sql->bindParam(":Asistencia",$datos['Asistencia31']);
                                $sql->bindParam(":Unidad",$datos['Unidad']);
                                $sql->bindParam(":Fecha",$fechaActual);

                                $sql->execute();
                        }

                        if($datos['Alumno32']!="0"){
                                $alumno=$datos['Alumno32'];

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM notas WHERE ID_ASIGNACION=$asignacion AND ID_ALUMNO=$alumno");
                                $contadorNotas=$consulta->rowCount();

                                if($contadorNotas==0){
                                        $sql = mainModel::conectar()->prepare("INSERT INTO notas (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
                                        $sql->bindParam(":Asignacion",$asignacion);
                                        $sql->bindParam(":Alumno",$alumno);

                                        $sql->execute();     
                                }

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM notas WHERE ID_ALUMNO=$alumno AND ID_ASIGNACION=$asignacion");
                                $detalle=$consulta->fetch();
                                $idNota=$detalle['ID_NOTA'];

                                $sql = mainModel::conectar()->prepare("INSERT INTO nota_detalle (ID_NOTA, NOTA, UNIDAD_DIDACTICA, FECHA) VALUES (:Id, :Asistencia, :Unidad,  :Fecha)");
                                $sql->bindParam(":Id",$idNota);
                                $sql->bindParam(":Asistencia",$datos['Asistencia32']);
                                $sql->bindParam(":Unidad",$datos['Unidad']);
                                $sql->bindParam(":Fecha",$fechaActual);

                                $sql->execute();
                        }

                        if($datos['Alumno33']!="0"){
                                $alumno=$datos['Alumno33'];

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM notas WHERE ID_ASIGNACION=$asignacion AND ID_ALUMNO=$alumno");
                                $contadorNotas=$consulta->rowCount();

                                if($contadorNotas==0){
                                        $sql = mainModel::conectar()->prepare("INSERT INTO notas (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
                                        $sql->bindParam(":Asignacion",$asignacion);
                                        $sql->bindParam(":Alumno",$alumno);

                                        $sql->execute();     
                                }

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM notas WHERE ID_ALUMNO=$alumno AND ID_ASIGNACION=$asignacion");
                                $detalle=$consulta->fetch();
                                $idNota=$detalle['ID_NOTA'];

                                $sql = mainModel::conectar()->prepare("INSERT INTO nota_detalle (ID_NOTA, NOTA, UNIDAD_DIDACTICA, FECHA) VALUES (:Id, :Asistencia, :Unidad,  :Fecha)");
                                $sql->bindParam(":Id",$idNota);
                                $sql->bindParam(":Asistencia",$datos['Asistencia33']);
                                $sql->bindParam(":Unidad",$datos['Unidad']);
                                $sql->bindParam(":Fecha",$fechaActual);

                                $sql->execute();
                        }

                        if($datos['Alumno34']!="0"){
                                $alumno=$datos['Alumno34'];

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM notas WHERE ID_ASIGNACION=$asignacion AND ID_ALUMNO=$alumno");
                                $contadorNotas=$consulta->rowCount();

                                if($contadorNotas==0){
                                        $sql = mainModel::conectar()->prepare("INSERT INTO notas (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
                                        $sql->bindParam(":Asignacion",$asignacion);
                                        $sql->bindParam(":Alumno",$alumno);

                                        $sql->execute();     
                                }

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM notas WHERE ID_ALUMNO=$alumno AND ID_ASIGNACION=$asignacion");
                                $detalle=$consulta->fetch();
                                $idNota=$detalle['ID_NOTA'];

                                $sql = mainModel::conectar()->prepare("INSERT INTO nota_detalle (ID_NOTA, NOTA, UNIDAD_DIDACTICA, FECHA) VALUES (:Id, :Asistencia, :Unidad,  :Fecha)");
                                $sql->bindParam(":Id",$idNota);
                                $sql->bindParam(":Asistencia",$datos['Asistencia34']);
                                $sql->bindParam(":Unidad",$datos['Unidad']);
                                $sql->bindParam(":Fecha",$fechaActual);

                                $sql->execute();
                        }

                        if($datos['Alumno35']!="0"){
                                $alumno=$datos['Alumno35'];

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM notas WHERE ID_ASIGNACION=$asignacion AND ID_ALUMNO=$alumno");
                                $contadorNotas=$consulta->rowCount();

                                if($contadorNotas==0){
                                        $sql = mainModel::conectar()->prepare("INSERT INTO notas (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
                                        $sql->bindParam(":Asignacion",$asignacion);
                                        $sql->bindParam(":Alumno",$alumno);

                                        $sql->execute();     
                                }

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM notas WHERE ID_ALUMNO=$alumno AND ID_ASIGNACION=$asignacion");
                                $detalle=$consulta->fetch();
                                $idNota=$detalle['ID_NOTA'];

                                $sql = mainModel::conectar()->prepare("INSERT INTO nota_detalle (ID_NOTA, NOTA, UNIDAD_DIDACTICA, FECHA) VALUES (:Id, :Asistencia, :Unidad,  :Fecha)");
                                $sql->bindParam(":Id",$idNota);
                                $sql->bindParam(":Asistencia",$datos['Asistencia35']);
                                $sql->bindParam(":Unidad",$datos['Unidad']);
                                $sql->bindParam(":Fecha",$fechaActual);

                                $sql->execute();
                        }

                        if($datos['Alumno36']!="0"){
                                $alumno=$datos['Alumno36'];

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM notas WHERE ID_ASIGNACION=$asignacion AND ID_ALUMNO=$alumno");
                                $contadorNotas=$consulta->rowCount();

                                if($contadorNotas==0){
                                        $sql = mainModel::conectar()->prepare("INSERT INTO notas (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
                                        $sql->bindParam(":Asignacion",$asignacion);
                                        $sql->bindParam(":Alumno",$alumno);

                                        $sql->execute();     
                                }

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM notas WHERE ID_ALUMNO=$alumno AND ID_ASIGNACION=$asignacion");
                                $detalle=$consulta->fetch();
                                $idNota=$detalle['ID_NOTA'];

                                $sql = mainModel::conectar()->prepare("INSERT INTO nota_detalle (ID_NOTA, NOTA, UNIDAD_DIDACTICA, FECHA) VALUES (:Id, :Asistencia, :Unidad,  :Fecha)");
                                $sql->bindParam(":Id",$idNota);
                                $sql->bindParam(":Asistencia",$datos['Asistencia36']);
                                $sql->bindParam(":Unidad",$datos['Unidad']);
                                $sql->bindParam(":Fecha",$fechaActual);

                                $sql->execute();
                        }

                        if($datos['Alumno37']!="0"){
                                $alumno=$datos['Alumno37'];

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM notas WHERE ID_ASIGNACION=$asignacion AND ID_ALUMNO=$alumno");
                                $contadorNotas=$consulta->rowCount();

                                if($contadorNotas==0){
                                        $sql = mainModel::conectar()->prepare("INSERT INTO notas (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
                                        $sql->bindParam(":Asignacion",$asignacion);
                                        $sql->bindParam(":Alumno",$alumno);

                                        $sql->execute();     
                                }

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM notas WHERE ID_ALUMNO=$alumno AND ID_ASIGNACION=$asignacion");
                                $detalle=$consulta->fetch();
                                $idNota=$detalle['ID_NOTA'];

                                $sql = mainModel::conectar()->prepare("INSERT INTO nota_detalle (ID_NOTA, NOTA, UNIDAD_DIDACTICA, FECHA) VALUES (:Id, :Asistencia, :Unidad,  :Fecha)");
                                $sql->bindParam(":Id",$idNota);
                                $sql->bindParam(":Asistencia",$datos['Asistencia37']);
                                $sql->bindParam(":Unidad",$datos['Unidad']);
                                $sql->bindParam(":Fecha",$fechaActual);

                                $sql->execute();
                        }

                        if($datos['Alumno38']!="0"){
                                $alumno=$datos['Alumno38'];

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM notas WHERE ID_ASIGNACION=$asignacion AND ID_ALUMNO=$alumno");
                                $contadorNotas=$consulta->rowCount();

                                if($contadorNotas==0){
                                        $sql = mainModel::conectar()->prepare("INSERT INTO notas (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
                                        $sql->bindParam(":Asignacion",$asignacion);
                                        $sql->bindParam(":Alumno",$alumno);

                                        $sql->execute();     
                                }

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM notas WHERE ID_ALUMNO=$alumno AND ID_ASIGNACION=$asignacion");
                                $detalle=$consulta->fetch();
                                $idNota=$detalle['ID_NOTA'];

                                $sql = mainModel::conectar()->prepare("INSERT INTO nota_detalle (ID_NOTA, NOTA, UNIDAD_DIDACTICA, FECHA) VALUES (:Id, :Asistencia, :Unidad,  :Fecha)");
                                $sql->bindParam(":Id",$idNota);
                                $sql->bindParam(":Asistencia",$datos['Asistencia38']);
                                $sql->bindParam(":Unidad",$datos['Unidad']);
                                $sql->bindParam(":Fecha",$fechaActual);

                                $sql->execute();
                        }

                        if($datos['Alumno39']!="0"){
                                $alumno=$datos['Alumno39'];

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM notas WHERE ID_ASIGNACION=$asignacion AND ID_ALUMNO=$alumno");
                                $contadorNotas=$consulta->rowCount();

                                if($contadorNotas==0){
                                        $sql = mainModel::conectar()->prepare("INSERT INTO notas (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
                                        $sql->bindParam(":Asignacion",$asignacion);
                                        $sql->bindParam(":Alumno",$alumno);

                                        $sql->execute();     
                                }

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM notas WHERE ID_ALUMNO=$alumno AND ID_ASIGNACION=$asignacion");
                                $detalle=$consulta->fetch();
                                $idNota=$detalle['ID_NOTA'];

                                $sql = mainModel::conectar()->prepare("INSERT INTO nota_detalle (ID_NOTA, NOTA, UNIDAD_DIDACTICA, FECHA) VALUES (:Id, :Asistencia, :Unidad,  :Fecha)");
                                $sql->bindParam(":Id",$idNota);
                                $sql->bindParam(":Asistencia",$datos['Asistencia39']);
                                $sql->bindParam(":Unidad",$datos['Unidad']);
                                $sql->bindParam(":Fecha",$fechaActual);

                                $sql->execute();
                        }

                        if($datos['Alumno40']!="0"){
                                $alumno=$datos['Alumno40'];

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM notas WHERE ID_ASIGNACION=$asignacion AND ID_ALUMNO=$alumno");
                                $contadorNotas=$consulta->rowCount();

                                if($contadorNotas==0){
                                        $sql = mainModel::conectar()->prepare("INSERT INTO notas (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
                                        $sql->bindParam(":Asignacion",$asignacion);
                                        $sql->bindParam(":Alumno",$alumno);

                                        $sql->execute();     
                                }

                                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM notas WHERE ID_ALUMNO=$alumno AND ID_ASIGNACION=$asignacion");
                                $detalle=$consulta->fetch();
                                $idNota=$detalle['ID_NOTA'];

                                $sql = mainModel::conectar()->prepare("INSERT INTO nota_detalle (ID_NOTA, NOTA, UNIDAD_DIDACTICA, FECHA) VALUES (:Id, :Asistencia, :Unidad,  :Fecha)");
                                $sql->bindParam(":Id",$idNota);
                                $sql->bindParam(":Asistencia",$datos['Asistencia40']);
                                $sql->bindParam(":Unidad",$datos['Unidad']);
                                $sql->bindParam(":Fecha",$fechaActual);

                                $sql->execute();
                        }

                        
                        return $sql;
                }

	}

?>