<?php
	if ($peticionAjax) {
		require_once "../core/mainModel.php";
	}
	else{
		require_once "core/mainModel.php";
	}

	class categoriaModelo extends mainModel
	{
		
		protected function agregar_categoria_modelo($datos){
			$sql = mainModel::conectar()->prepare("INSERT INTO categorias (NOMBRE_CATEGORIA, ESTADO_CATEGORIA) VALUES (:Nombre, :Estado)");

			$sql->bindParam(":Nombre",$datos['Nombre']);
			$sql->bindParam(":Estado",$datos['Estado']);

			$sql->execute();
			return $sql;

		}

		protected function eliminar_categoria_modelo($codigo){
			$sql = mainModel::conectar()->prepare("DELETE FROM categorias WHERE ID_CATEGORIA=:Codigo");

			$sql->bindParam(":Codigo",$codigo);
			$sql->execute();
			return $sql;
		}

		protected function datos_categoria_modelo($codigo){
			$sql = mainModel::conectar()->prepare("SELECT * FROM categorias WHERE ID_CATEGORIA=:Codigo");
			$sql->bindParam(":Codigo",$codigo);
			$sql->execute();
			return $sql;
		}

		   protected function actualizar_categoria_modelo($datos){
			$sql = mainModel::conectar()->prepare("UPDATE categorias SET NOMBRE_CATEGORIA=:Nombre, ESTADO_CATEGORIA=:Estado WHERE ID_CATEGORIA=:Id");

			$sql->bindParam(":Nombre",$datos['Nombre']);
			$sql->bindParam(":Estado",$datos['Estado']);
			$sql->bindParam(":Id",$datos['Id']);

			$sql->execute();
			return $sql;
		}

	}

?>