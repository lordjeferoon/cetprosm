<?php
	if ($peticionAjax) {
		require_once "../core/mainModel.php";
	}
	else{
		require_once "core/mainModel.php";
	}

	class frecuenciaModelo extends mainModel
	{
		
		protected function agregar_frecuencia_modelo($datos){
			$sql = mainModel::conectar()->prepare("INSERT INTO frecuencias (NOMBRE_FRECUENCIA, ESTADO_FRECUENCIA) VALUES (:Nombre, :Estado)");

			$sql->bindParam(":Nombre",$datos['Nombre']);
			$sql->bindParam(":Estado",$datos['Estado']);

			$sql->execute();
			return $sql;

		}

		protected function eliminar_frecuencia_modelo($codigo){
			$sql = mainModel::conectar()->prepare("DELETE FROM frecuencias WHERE ID_FRECUENCIA=:Codigo");

			$sql->bindParam(":Codigo",$codigo);
			$sql->execute();
			return $sql;
		}

		protected function datos_frecuencia_modelo($codigo){
			$sql = mainModel::conectar()->prepare("SELECT * FROM frecuencias WHERE ID_FRECUENCIA=:Codigo");
			$sql->bindParam(":Codigo",$codigo);
			$sql->execute();
			return $sql;
		}

		   protected function actualizar_frecuencia_modelo($datos){
			$sql = mainModel::conectar()->prepare("UPDATE frecuencias SET NOMBRE_FRECUENCIA=:Nombre, ESTADO_FRECUENCIA=:Estado WHERE ID_FRECUENCIA=:Id");

			$sql->bindParam(":Nombre",$datos['Nombre']);
			$sql->bindParam(":Estado",$datos['Estado']);
			$sql->bindParam(":Id",$datos['Id']);

			$sql->execute();
			return $sql;
		}

	}

?>