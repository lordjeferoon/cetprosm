<?php
	if ($peticionAjax) {
		require_once "../core/mainModel.php";
	}
	else{
		require_once "core/mainModel.php";
	}

	class moduloModelo extends mainModel
	{
		
		protected function agregar_modulo_modelo($datos){
			$sql = mainModel::conectar()->prepare("INSERT INTO modulos (NOMBRE_MODULO, ESTADO_MODULO, PRECIO_MODULO, DURACION_MESES, DURACION_HORAS, ID_ESPECIALIDAD) VALUES (:Nombre, :Estado, :Precio, :Meses, :Horas, :Codigo)");

			$sql->bindParam(":Nombre",$datos['Nombre']);
			$sql->bindParam(":Estado",$datos['Estado']);
			$sql->bindParam(":Precio",$datos['Precio']);
			$sql->bindParam(":Meses",$datos['Meses']);
			$sql->bindParam(":Horas",$datos['Horas']);
			$sql->bindParam(":Codigo",$datos['Codigo']);

			$sql->execute();
			return $sql;

		}

		protected function eliminar_modulo_modelo($codigo){
			$sql = mainModel::conectar()->prepare("DELETE FROM modulos WHERE ID_MODULO=:Codigo");

			$sql->bindParam(":Codigo",$codigo);
			$sql->execute();
			return $sql;
		}

		protected function datos_modulo_modelo($codigo){
			$sql = mainModel::conectar()->prepare("SELECT * FROM modulos WHERE ID_MODULO=:Codigo");
			$sql->bindParam(":Codigo",$codigo);
			$sql->execute();
			return $sql;
		}

		   protected function actualizar_modulo_modelo($datos){
			$sql = mainModel::conectar()->prepare("UPDATE modulos SET NOMBRE_MODULO=:Nombre, ESTADO_MODULO=:Estado, PRECIO_MODULO=:Precio, DURACION_MESES=:Meses, DURACION_HORAS=:Horas, ID_ESPECIALIDAD=:IdEspecialidad WHERE ID_MODULO=:Id");

			$sql->bindParam(":Nombre",$datos['Nombre']);
			$sql->bindParam(":Estado",$datos['Estado']);
			$sql->bindParam(":Precio",$datos['Precio']);
			$sql->bindParam(":Meses",$datos['Meses']);
			$sql->bindParam(":Horas",$datos['Horas']);
			$sql->bindParam(":IdEspecialidad",$datos['IdEspecialidad']);
			$sql->bindParam(":Id",$datos['Id']);

			$sql->execute();
			return $sql;
		}


	}

?>