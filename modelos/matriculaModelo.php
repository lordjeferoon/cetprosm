<?php
	if ($peticionAjax) {
		require_once "../core/mainModel.php";
	}
	else{
		require_once "core/mainModel.php";
	}

	class matriculaModelo extends mainModel
	{
		
		protected function agregar_matricula_modelo($datos){

			$sql = mainModel::conectar()->prepare("INSERT INTO matriculas (CODIGO_MATRICULA, ESTADO_MATRICULA, ESTADO_PAGO, TOTAL, ADELANTO, FECHA, ANIO, ID_ALUMNO, CODIGO_OPERADOR) VALUES (:Codigo, :EstadoMatricula, :EstadoPago, :Total, :Adelanto, :Fecha, :Anio, :Alumno, :Operador)");

			$sql->bindParam(":Codigo",$datos['Codigo']);
			$sql->bindParam(":EstadoMatricula",$datos['EstadoMatricula']);
			$sql->bindParam(":EstadoPago",$datos['EstadoPago']);
			$sql->bindParam(":Total",$datos['Total']);
			$sql->bindParam(":Adelanto",$datos['Adelanto']);
			$sql->bindParam(":Fecha",$datos['Fecha']);
			$sql->bindParam(":Anio",$datos['Anio']);
			$sql->bindParam(":Alumno",$datos['Alumno']);
			$sql->bindParam(":Operador",$datos['Operador']);
			$sql->execute();


			if($datos['Asignacion1']!=0){
				$sql = mainModel::conectar()->prepare("INSERT INTO matricula_detalle (CODIGO_MATRICULA, ID_ASIGNACION) VALUES (:Codigo, :Asignacion)");
				$sql->bindParam(":Codigo",$datos['Codigo']);
				$sql->bindParam(":Asignacion",$datos['Asignacion1']);
				$sql->execute();

				$sql = mainModel::conectar()->prepare("INSERT INTO notas (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
				$sql->bindParam(":Asignacion",$datos['Asignacion1']);
				$sql->bindParam(":Alumno",$datos['Alumno']);
				$sql->execute();

				$sql = mainModel::conectar()->prepare("INSERT INTO asistencias (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
				$sql->bindParam(":Asignacion",$datos['Asignacion1']);
				$sql->bindParam(":Alumno",$datos['Alumno']);
				$sql->execute();

				$sql = mainModel::conectar()->prepare("UPDATE asignaciones SET VACANTES=:Vacantes WHERE ID_ASIGNACION=:Asignacion");
				$sql->bindParam(":Vacantes",$datos['Vacantes1']);
				$sql->bindParam(":Asignacion",$datos['Asignacion1']);
				$sql->execute();	
			}

			if($datos['Asignacion2']!=0){
				$sql = mainModel::conectar()->prepare("INSERT INTO matricula_detalle (CODIGO_MATRICULA, ID_ASIGNACION) VALUES (:Codigo, :Asignacion)");
				$sql->bindParam(":Codigo",$datos['Codigo']);
				$sql->bindParam(":Asignacion",$datos['Asignacion2']);
				$sql->execute();

				$sql = mainModel::conectar()->prepare("INSERT INTO notas (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
				$sql->bindParam(":Asignacion",$datos['Asignacion2']);
				$sql->bindParam(":Alumno",$datos['Alumno']);
				$sql->execute();

				$sql = mainModel::conectar()->prepare("INSERT INTO asistencias (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
				$sql->bindParam(":Asignacion",$datos['Asignacion2']);
				$sql->bindParam(":Alumno",$datos['Alumno']);
				$sql->execute();

				$sql = mainModel::conectar()->prepare("UPDATE asignaciones SET VACANTES=:Vacantes WHERE ID_ASIGNACION=:Asignacion");
				$sql->bindParam(":Vacantes",$datos['Vacantes2']);
				$sql->bindParam(":Asignacion",$datos['Asignacion2']);
				$sql->execute();
			}

			if($datos['Asignacion3']!=0){
				$sql = mainModel::conectar()->prepare("INSERT INTO matricula_detalle (CODIGO_MATRICULA, ID_ASIGNACION) VALUES (:Codigo, :Asignacion)");
				$sql->bindParam(":Codigo",$datos['Codigo']);
				$sql->bindParam(":Asignacion",$datos['Asignacion3']);
				$sql->execute();

				$sql = mainModel::conectar()->prepare("INSERT INTO notas (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
				$sql->bindParam(":Asignacion",$datos['Asignacion3']);
				$sql->bindParam(":Alumno",$datos['Alumno']);
				$sql->execute();

				$sql = mainModel::conectar()->prepare("INSERT INTO asistencias (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
				$sql->bindParam(":Asignacion",$datos['Asignacion3']);
				$sql->bindParam(":Alumno",$datos['Alumno']);
				$sql->execute();

				$sql = mainModel::conectar()->prepare("UPDATE asignaciones SET VACANTES=:Vacantes WHERE ID_ASIGNACION=:Asignacion");
				$sql->bindParam(":Vacantes",$datos['Vacantes3']);
				$sql->bindParam(":Asignacion",$datos['Asignacion3']);
				$sql->execute();
			}

			if($datos['Asignacion4']!=0){
				$sql = mainModel::conectar()->prepare("INSERT INTO matricula_detalle (CODIGO_MATRICULA, ID_ASIGNACION) VALUES (:Codigo, :Asignacion)");
				$sql->bindParam(":Codigo",$datos['Codigo']);
				$sql->bindParam(":Asignacion",$datos['Asignacion4']);
				$sql->execute();

				$sql = mainModel::conectar()->prepare("INSERT INTO notas (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
				$sql->bindParam(":Asignacion",$datos['Asignacion4']);
				$sql->bindParam(":Alumno",$datos['Alumno']);
				$sql->execute();

				$sql = mainModel::conectar()->prepare("INSERT INTO asistencias (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
				$sql->bindParam(":Asignacion",$datos['Asignacion4']);
				$sql->bindParam(":Alumno",$datos['Alumno']);
				$sql->execute();

				$sql = mainModel::conectar()->prepare("UPDATE asignaciones SET VACANTES=:Vacantes WHERE ID_ASIGNACION=:Asignacion");
				$sql->bindParam(":Vacantes",$datos['Vacantes4']);
				$sql->bindParam(":Asignacion",$datos['Asignacion4']);
				$sql->execute();
			}
			
			if($datos['Asignacion5']!=0){
				$sql = mainModel::conectar()->prepare("INSERT INTO matricula_detalle (CODIGO_MATRICULA, ID_ASIGNACION) VALUES (:Codigo, :Asignacion)");
				$sql->bindParam(":Codigo",$datos['Codigo']);
				$sql->bindParam(":Asignacion",$datos['Asignacion5']);
				$sql->execute();

				$sql = mainModel::conectar()->prepare("INSERT INTO notas (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
				$sql->bindParam(":Asignacion",$datos['Asignacion5']);
				$sql->bindParam(":Alumno",$datos['Alumno']);
				$sql->execute();

				$sql = mainModel::conectar()->prepare("INSERT INTO asistencias (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
				$sql->bindParam(":Asignacion",$datos['Asignacion5']);
				$sql->bindParam(":Alumno",$datos['Alumno']);
				$sql->execute();

				$sql = mainModel::conectar()->prepare("UPDATE asignaciones SET VACANTES=:Vacantes WHERE ID_ASIGNACION=:Asignacion");
				$sql->bindParam(":Vacantes",$datos['Vacantes5']);
				$sql->bindParam(":Asignacion",$datos['Asignacion5']);
				$sql->execute();
			}
			
			if($datos['Asignacion6']!=0){
				$sql = mainModel::conectar()->prepare("INSERT INTO matricula_detalle (CODIGO_MATRICULA, ID_ASIGNACION) VALUES (:Codigo, :Asignacion)");
				$sql->bindParam(":Codigo",$datos['Codigo']);
				$sql->bindParam(":Asignacion",$datos['Asignacion6']);
				$sql->execute();

				$sql = mainModel::conectar()->prepare("INSERT INTO notas (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
				$sql->bindParam(":Asignacion",$datos['Asignacion6']);
				$sql->bindParam(":Alumno",$datos['Alumno']);
				$sql->execute();

				$sql = mainModel::conectar()->prepare("INSERT INTO asistencias (ID_ASIGNACION, ID_ALUMNO) VALUES (:Asignacion, :Alumno)");
				$sql->bindParam(":Asignacion",$datos['Asignacion6']);
				$sql->bindParam(":Alumno",$datos['Alumno']);
				$sql->execute();

				$sql = mainModel::conectar()->prepare("UPDATE asignaciones SET VACANTES=:Vacantes WHERE ID_ASIGNACION=:Asignacion");
				$sql->bindParam(":Vacantes",$datos['Vacantes6']);
				$sql->bindParam(":Asignacion",$datos['Asignacion6']);
				$sql->execute();
			}

			return $sql;
		}

		protected function actualizar_saldo_modelo($datos){

			$sql = mainModel::conectar()->prepare("UPDATE matriculas SET ESTADO_PAGO=:Estado, ADELANTO=:Adelanto WHERE ID_MATRICULA=:Codigo");

			$sql->bindParam(":Codigo",$datos['Codigo']);
			$sql->bindParam(":Adelanto",$datos['Nuevo']);
			$sql->bindParam(":Estado",$datos['Pagado']);
			
			$sql->execute();

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