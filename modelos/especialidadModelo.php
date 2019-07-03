<?php
	if ($peticionAjax) {
		require_once "../core/mainModel.php";
	}
	else{
		require_once "core/mainModel.php";
	}

	class especialidadModelo extends mainModel
	{
		
		protected function agregar_especialidad_modelo($datos){
			$sql = mainModel::conectar()->prepare("INSERT INTO especialidades (NOMBRE_ESPECIALIDAD, ESTADO_ESPECIALIDAD, PRECIO_ESPECIALIDAD) VALUES (:Nombre, :Estado, :Precio)");

			$sql->bindParam(":Nombre",$datos['Nombre']);
			$sql->bindParam(":Estado",$datos['Estado']);
			$sql->bindParam(":Precio",$datos['Precio']);

			$sql->execute();
			return $sql;

		}

		protected function eliminar_especialidad_modelo($codigo){
			$sql = mainModel::conectar()->prepare("DELETE FROM especialidades WHERE ID_ESPECIALIDAD=:Codigo");

			$sql->bindParam(":Codigo",$codigo);
			$sql->execute();
			return $sql;
		}

		protected function datos_especialidad_modelo($codigo){
			$sql = mainModel::conectar()->prepare("SELECT * FROM especialidades WHERE ID_ESPECIALIDAD=:Codigo");
			$sql->bindParam(":Codigo",$codigo);
			$sql->execute();
			return $sql;
		}

		   protected function actualizar_especialidad_modelo($datos){
			$sql = mainModel::conectar()->prepare("UPDATE especialidades SET NOMBRE_ESPECIALIDAD=:Nombre, ESTADO_ESPECIALIDAD=:Estado, PRECIO_ESPECIALIDAD=:Precio WHERE ID_ESPECIALIDAD=:Id");

			$sql->bindParam(":Nombre",$datos['Nombre']);
			$sql->bindParam(":Estado",$datos['Estado']);
			$sql->bindParam(":Precio",$datos['Precio']);
			$sql->bindParam(":Id",$datos['Id']);

			$sql->execute();
			return $sql;
		}

	}

?>