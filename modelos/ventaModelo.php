<?php
	if ($peticionAjax) {
		require_once "../core/mainModel.php";
	}
	else{
		require_once "core/mainModel.php";
	}

	class ventaModelo extends mainModel
	{
		
		protected function agregar_venta_modelo($datos){

			$sql = mainModel::conectar()->prepare("INSERT INTO ventas (CODIGO_VENTA, ESTADO_PAGO, TOTAL, ADELANTO, FECHA, CLIENTE, CODIGO_OPERADOR) VALUES (:Codigo, :EstadoPago, :Total, :Adelanto, :Fecha, :Cliente, :Operador)");

				$sql->bindParam(":Codigo",$datos['Codigo']);
				$sql->bindParam(":EstadoPago",$datos['EstadoPago']);
				$sql->bindParam(":Total",$datos['Total']);
				$sql->bindParam(":Adelanto",$datos['Adelanto']);
				$sql->bindParam(":Fecha",$datos['Fecha']);
				$sql->bindParam(":Cliente",$datos['Cliente']);
				$sql->bindParam(":Operador",$datos['Operador']);
				$sql->execute();


			if($datos['Producto1']!=0){
				$sql = mainModel::conectar()->prepare("INSERT INTO venta_detalle (CODIGO_VENTA, ID_PRODUCTO, PRECIO_PRODUCTO, UNIDADES) VALUES (:Codigo, :IdProducto, :Precio, :Unidades)");
				$sql->bindParam(":Codigo",$datos['Codigo']);
				$sql->bindParam(":IdProducto",$datos['Producto1']);
				$sql->bindParam(":Precio",$datos['Precio1']);
				$sql->bindParam(":Unidades",$datos['Unidades1']);
				$sql->execute();

				$p=$datos['Producto1'];
				$sql = mainModel::conectar()->prepare("UPDATE productos SET STOCK_PRODUCTO=:Stock WHERE ID_PRODUCTO=$p");
				$sql->bindParam(":Stock",$datos['Nueva1']);	
				$sql->execute();
			}

			if($datos['Producto2']!=0){
				$sql = mainModel::conectar()->prepare("INSERT INTO venta_detalle (CODIGO_VENTA, ID_PRODUCTO, PRECIO_PRODUCTO, UNIDADES) VALUES (:Codigo, :IdProducto, :Precio, :Unidades)");
				$sql->bindParam(":Codigo",$datos['Codigo']);
				$sql->bindParam(":IdProducto",$datos['Producto2']);
				$sql->bindParam(":Precio",$datos['Precio2']);
				$sql->bindParam(":Unidades",$datos['Unidades2']);
				$sql->execute();	

				$p=$datos['Producto2'];
				$sql = mainModel::conectar()->prepare("UPDATE productos SET STOCK_PRODUCTO=:Stock WHERE ID_PRODUCTO=$p");
				$sql->bindParam(":Stock",$datos['Nueva2']);	
				$sql->execute();
			}

			if($datos['Producto3']!=0){
				$sql = mainModel::conectar()->prepare("INSERT INTO venta_detalle (CODIGO_VENTA, ID_PRODUCTO, PRECIO_PRODUCTO, UNIDADES) VALUES (:Codigo, :IdProducto, :Precio, :Unidades)");
				$sql->bindParam(":Codigo",$datos['Codigo']);
				$sql->bindParam(":IdProducto",$datos['Producto3']);
				$sql->bindParam(":Precio",$datos['Precio3']);
				$sql->bindParam(":Unidades",$datos['Unidades3']);
				$sql->execute();

				$p=$datos['Producto3'];
				$sql = mainModel::conectar()->prepare("UPDATE productos SET STOCK_PRODUCTO=:Stock WHERE ID_PRODUCTO=$p");
				$sql->bindParam(":Stock",$datos['Nueva3']);	
				$sql->execute();	
			}

			if($datos['Producto4']!=0){
				$sql = mainModel::conectar()->prepare("INSERT INTO venta_detalle (CODIGO_VENTA, ID_PRODUCTO, PRECIO_PRODUCTO, UNIDADES) VALUES (:Codigo, :IdProducto, :Precio, :Unidades)");
				$sql->bindParam(":Codigo",$datos['Codigo']);
				$sql->bindParam(":IdProducto",$datos['Producto4']);
				$sql->bindParam(":Precio",$datos['Precio4']);
				$sql->bindParam(":Unidades",$datos['Unidades4']);
				$sql->execute();

				$p=$datos['Producto4'];
				$sql = mainModel::conectar()->prepare("UPDATE productos SET STOCK_PRODUCTO=:Stock WHERE ID_PRODUCTO=$p");
				$sql->bindParam(":Stock",$datos['Nueva4']);	
				$sql->execute();	
			}

			if($datos['Producto5']!=0){
				$sql = mainModel::conectar()->prepare("INSERT INTO venta_detalle (CODIGO_VENTA, ID_PRODUCTO, PRECIO_PRODUCTO, UNIDADES) VALUES (:Codigo, :IdProducto, :Precio, :Unidades)");
				$sql->bindParam(":Codigo",$datos['Codigo']);
				$sql->bindParam(":IdProducto",$datos['Producto5']);
				$sql->bindParam(":Precio",$datos['Precio5']);
				$sql->bindParam(":Unidades",$datos['Unidades5']);
				$sql->execute();

				$p=$datos['Producto5'];
				$sql = mainModel::conectar()->prepare("UPDATE productos SET STOCK_PRODUCTO=:Stock WHERE ID_PRODUCTO=$p");
				$sql->bindParam(":Stock",$datos['Nueva5']);	
				$sql->execute();	
			}
			return $sql;
		}

		/*protected function eliminar_asignacion_modelo($codigo){
			$sql = mainModel::conectar()->prepare("DELETE FROM PRODUCTOS WHERE ID_PRODUCTO=:Codigo");

			$sql->bindParam(":Codigo",$codigo);
			$sql->execute();
			return $sql;
		}

		protected function datos_producto_modelo($codigo){
			$sql = mainModel::conectar()->prepare("SELECT * FROM PRODUCTOS WHERE ID_PRODUCTO=:Codigo");
			$sql->bindParam(":Codigo",$codigo);
			$sql->execute();
			return $sql;
		}

		   protected function actualizar_producto_modelo($datos){
			$sql = mainModel::conectar()->prepare("UPDATE PRODUCTOS SET NOMBRE_PRODUCTO=:Nombre, DESCRIPCION_PRODUCTO=:Descripcion, ESTADO_PRODUCTO=:Estado, PRECIO_PRODUCTO=:Precio, STOCK_PRODUCTO=:Stock, ID_CATEGORIA=:IdCategoria WHERE ID_PRODUCTO=:Id");

			$sql->bindParam(":Nombre",$datos['Nombre']);
			$sql->bindParam(":Descripcion",$datos['Descripcion']);
			$sql->bindParam(":Estado",$datos['Estado']);
			$sql->bindParam(":Precio",$datos['Precio']);
			$sql->bindParam(":Stock",$datos['Stock']);
			$sql->bindParam(":IdCategoria",$datos['IdCategoria']);
			$sql->bindParam(":Id",$datos['Id']);

			$sql->execute();
			return $sql;
		}*/

	}

?>