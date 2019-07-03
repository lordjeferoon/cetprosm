<?php
	if ($peticionAjax) {
		require_once "../core/mainModel.php";
	}
	else{
		require_once "core/mainModel.php";
	}

	class productoModelo extends mainModel
	{
		
		protected function agregar_producto_modelo($datos){
			$sql = mainModel::conectar()->prepare("INSERT INTO productos (NOMBRE_PRODUCTO, DESCRIPCION_PRODUCTO, ESTADO_PRODUCTO, PRECIO_PRODUCTO, STOCK_PRODUCTO, ID_CATEGORIA) VALUES (:Nombre, :Descripcion, :Estado, :Precio, :Stock, :Categoria)");

			$sql->bindParam(":Nombre",$datos['Nombre']);
			$sql->bindParam(":Descripcion",$datos['Descripcion']);
			$sql->bindParam(":Estado",$datos['Estado']);
			$sql->bindParam(":Precio",$datos['Precio']);
			$sql->bindParam(":Stock",$datos['Stock']);
			$sql->bindParam(":Categoria",$datos['Categoria']);

			$sql->execute();
			return $sql;

		}

		protected function eliminar_producto_modelo($codigo){
			$sql = mainModel::conectar()->prepare("DELETE FROM productos WHERE ID_PRODUCTO=:Codigo");

			$sql->bindParam(":Codigo",$codigo);
			$sql->execute();
			return $sql;
		}

		protected function datos_producto_modelo($codigo){
			$sql = mainModel::conectar()->prepare("SELECT * FROM productos WHERE ID_PRODUCTO=:Codigo");
			$sql->bindParam(":Codigo",$codigo);
			$sql->execute();
			return $sql;
		}

		   protected function actualizar_producto_modelo($datos){
			$sql = mainModel::conectar()->prepare("UPDATE productos SET NOMBRE_PRODUCTO=:Nombre, DESCRIPCION_PRODUCTO=:Descripcion, ESTADO_PRODUCTO=:Estado, PRECIO_PRODUCTO=:Precio, STOCK_PRODUCTO=:Stock, ID_CATEGORIA=:IdCategoria WHERE ID_PRODUCTO=:Id");

			$sql->bindParam(":Nombre",$datos['Nombre']);
			$sql->bindParam(":Descripcion",$datos['Descripcion']);
			$sql->bindParam(":Estado",$datos['Estado']);
			$sql->bindParam(":Precio",$datos['Precio']);
			$sql->bindParam(":Stock",$datos['Stock']);
			$sql->bindParam(":IdCategoria",$datos['IdCategoria']);
			$sql->bindParam(":Id",$datos['Id']);

			$sql->execute();
			return $sql;
		}

	}

?>