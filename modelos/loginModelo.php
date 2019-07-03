<?php 
	if ($peticionAjax) {
		require_once "../core/mainModel.php";
	}
	else{
		require_once "core/mainModel.php";
	}

	class loginModelo extends mainModel{

		protected function iniciar_sesion_modelo($datos){
			$sql = mainModel::conectar()->prepare("SELECT * FROM cuentas WHERE USUARIO=:Usuario AND CONTRASENA=:Contrasena AND ESTADO='Activo'");

			$sql->bindParam(':Usuario',$datos['Usuario']);
			$sql->bindParam(':Contrasena',$datos['Contrasena']);
			$sql->execute();
			return $sql;
		}

		protected function cerrar_sesion_modelo($datos){
			if($datos['Usuario']!=""){
				$actualizarBitacora=mainModel::actualizarBitacora($datos['Codigo'],$datos['Hora']);
				if($actualizarBitacora->rowCount()==1){
					session_unset();
					session_destroy();
					$respuesta="true";
				}
				else{
					$respuesta="false";
				}
			}
			else{
				$respuesta="false";
			}
			return $respuesta;
		}
	}
?>