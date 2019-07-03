<?php
	if ($peticionAjax) {
		require_once "../core/mainModel.php";
	}
	else{
		require_once "core/mainModel.php";
	}

	class alumnoModelo extends mainModel
	{
		
		protected function agregar_alumno_modelo($datos){
			$sql = mainModel::conectar()->prepare("INSERT INTO alumnos (APELLIDOS_ALUMNO, NOMBRES_ALUMNO, DNI_ALUMNO, FECHA_NACIMIENTO_ALUMNO, SEXO_ALUMNO, TELEFONO_ALUMNO, CORREO_ALUMNO, DIRECCION_ALUMNO, DISTRITO_ALUMNO, REFERENCIA_ALUMNO, CODIGO_CUENTA_ALUMNO, CODIGO_NOMINAB, CODIGO_NOMINAI, CONDICION_ALUMNO) VALUES (:Apellidos, :Nombres, :Dni, :FechaNac, :Sexo, :Telefono, :Correo, :Direccion, :Distrito, :Referencia, :Codigo, :NominaB, :NominaI, :Condicion)");

			$sql->bindParam(":Apellidos",$datos['Apellidos']);
			$sql->bindParam(":Nombres",$datos['Nombres']);
			$sql->bindParam(":Dni",$datos['Dni']);
			$sql->bindParam(":FechaNac",$datos['FechaNac']);
			$sql->bindParam(":Sexo",$datos['Sexo']);
			$sql->bindParam(":Telefono",$datos['Telefono']);
			$sql->bindParam(":Correo",$datos['Correo']);
			$sql->bindParam(":Direccion",$datos['Direccion']);
			$sql->bindParam(":Distrito",$datos['Distrito']);
			$sql->bindParam(":Referencia",$datos['Referencia']);
			$sql->bindParam(":Codigo",$datos['Codigo']);
			$sql->bindParam(":NominaB",$datos['Nomina1']);
			$sql->bindParam(":NominaI",$datos['Nomina2']);
			$sql->bindParam(":Condicion",$datos['Condicion']);

			$sql->execute();
			return $sql;

		}

		protected function eliminar_alumno_modelo($codigo){
			$sql = mainModel::conectar()->prepare("DELETE FROM alumnos WHERE CODIGO_CUENTA_ALUMNO=:Codigo");

			$sql->bindParam(":Codigo",$codigo);
			$sql->execute();
			return $sql;
		}

		protected function datos_alumno_modelo($codigo){
			$sql = mainModel::conectar()->prepare("SELECT * FROM alumnos WHERE CODIGO_CUENTA_ALUMNO=:Codigo");
			$sql->bindParam(":Codigo",$codigo);
			$sql->execute();
			return $sql;
		}

        protected function actualizar_alumno_modelo($datos){
			$sql = mainModel::conectar()->prepare("UPDATE alumnos SET APELLIDOS_ALUMNO=:Apellidos, NOMBRES_ALUMNO=:Nombres, DNI_ALUMNO=:Dni, FECHA_NACIMIENTO_ALUMNO=:FechaNac, SEXO_ALUMNO=:Sexo, TELEFONO_ALUMNO=:Telefono, CORREO_ALUMNO=:Correo, DIRECCION_ALUMNO=:Direccion, DISTRITO_ALUMNO=:Distrito, REFERENCIA_ALUMNO=:Referencia, CODIGO_NOMINAB=:NominaB, CODIGO_NOMINAI=:NominaI, CONDICION_ALUMNO=:Condicion WHERE CODIGO_CUENTA_ALUMNO=:Codigo");

			$sql->bindParam(":Apellidos",$datos['Apellidos']);
			$sql->bindParam(":Nombres",$datos['Nombres']);
			$sql->bindParam(":Dni",$datos['Dni']);
			$sql->bindParam(":FechaNac",$datos['FechaNac']);
			$sql->bindParam(":Sexo",$datos['Sexo']);
			$sql->bindParam(":Telefono",$datos['Telefono']);
			$sql->bindParam(":Correo",$datos['Correo']);
			$sql->bindParam(":Direccion",$datos['Direccion']);
			$sql->bindParam(":Distrito",$datos['Distrito']);
			$sql->bindParam(":Referencia",$datos['Referencia']);
			$sql->bindParam(":NominaB",$datos['Nomina1']);
			$sql->bindParam(":NominaI",$datos['Nomina2']);
			$sql->bindParam(":Condicion",$datos['Condicion']);
			$sql->bindParam(":Codigo",$datos['Codigo']);

			$sql->execute();
			return $sql;
		}

	}

?>