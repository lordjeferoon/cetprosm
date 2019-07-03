<?php
	if ($peticionAjax) {
		require_once "../core/mainModel.php";
	}
	else{
		require_once "core/mainModel.php";
	}

	class docenteModelo extends mainModel
	{
		
		protected function agregar_docente_modelo($datos){
			$sql = mainModel::conectar()->prepare("INSERT INTO docentes (APELLIDOS_DOCENTE, NOMBRES_DOCENTE, DNI_DOCENTE, FECHA_NACIMIENTO_DOCENTE, SEXO_DOCENTE, TELEFONO_DOCENTE, CORREO_DOCENTE, DIRECCION_DOCENTE, DISTRITO_DOCENTE, REFERENCIA_DOCENTE, CODIGO_CUENTA_DOCENTE) VALUES (:Apellidos, :Nombres, :Dni, :FechaNac, :Sexo, :Telefono, :Correo, :Direccion, :Distrito, :Referencia, :Codigo)");

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

			$sql->execute();
			return $sql;

		}

		protected function eliminar_docente_modelo($codigo){
			$sql = mainModel::conectar()->prepare("DELETE FROM docentes WHERE CODIGO_CUENTA_DOCENTE=:Codigo");

			$sql->bindParam(":Codigo",$codigo);
			$sql->execute();
			return $sql;
		}

		protected function datos_docente_modelo($codigo){
			$sql = mainModel::conectar()->prepare("SELECT * FROM docentes WHERE CODIGO_CUENTA_DOCENTE=:Codigo");
			$sql->bindParam(":Codigo",$codigo);
			$sql->execute();
			return $sql;
		}

		protected function actualizar_docente_modelo($datos){
			$sql = mainModel::conectar()->prepare("UPDATE docentes SET APELLIDOS_DOCENTE=:Apellidos, NOMBRES_DOCENTE=:Nombres, DNI_DOCENTE=:Dni, FECHA_NACIMIENTO_DOCENTE=:FechaNac, SEXO_DOCENTE=:Sexo, TELEFONO_DOCENTE=:Telefono, CORREO_DOCENTE=:Correo, DIRECCION_DOCENTE=:Direccion, DISTRITO_DOCENTE=:Distrito, REFERENCIA_DOCENTE=:Referencia WHERE CODIGO_CUENTA_DOCENTE=:Codigo");

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

			$sql->execute();
			return $sql;
		}

	}

?>