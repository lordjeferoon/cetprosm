<?php
	if ($peticionAjax) {
		require_once "../core/mainModel.php";
	}
	else{
		require_once "core/mainModel.php";
	}

	class administradorModelo extends mainModel
	{
		
		protected function agregar_administrador_modelo($datos){
			$sql = mainModel::conectar()->prepare("INSERT INTO administradores (APELLIDOS_ADMIN, NOMBRES_ADMIN, DNI_ADMIN, FECHA_NACIMIENTO_ADMIN, SEXO_ADMIN, TELEFONO_ADMIN, CORREO_ADMIN, DIRECCION_ADMIN, DISTRITO_ADMIN, REFERENCIA_ADMIN, CODIGO_CUENTA_ADMIN) VALUES (:Apellidos, :Nombres, :Dni, :FechaNac, :Sexo, :Telefono, :Correo, :Direccion, :Distrito, :Referencia, :Codigo)");

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

		protected function eliminar_administrador_modelo($codigo){
			$sql = mainModel::conectar()->prepare("DELETE FROM administradores WHERE CODIGO_CUENTA_ADMIN=:Codigo");

			$sql->bindParam(":Codigo",$codigo);
			$sql->execute();
			return $sql;
		}

		protected function datos_administrador_modelo($codigo){
			$sql = mainModel::conectar()->prepare("SELECT * FROM administradores WHERE CODIGO_CUENTA_ADMIN=:Codigo");
			$sql->bindParam(":Codigo",$codigo);
			$sql->execute();
			return $sql;
		}

		protected function actualizar_administrador_modelo($datos){
			$sql = mainModel::conectar()->prepare("UPDATE administradores SET APELLIDOS_ADMIN=:Apellidos, NOMBRES_ADMIN=:Nombres, DNI_ADMIN=:Dni, FECHA_NACIMIENTO_ADMIN=:FechaNac, SEXO_ADMIN=:Sexo, TELEFONO_ADMIN=:Telefono, CORREO_ADMIN=:Correo, DIRECCION_ADMIN=:Direccion, DISTRITO_ADMIN=:Distrito, REFERENCIA_ADMIN=:Referencia WHERE CODIGO_CUENTA_ADMIN=:Codigo");

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