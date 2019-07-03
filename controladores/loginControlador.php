<?php 
	if ($peticionAjax) {
		require_once "../modelos/loginModelo.php";
	}
	else{
		require_once "modelos/loginModelo.php";
	}

	class loginControlador extends loginModelo{

		public function iniciar_sesion_controlador(){
			$usuario=mainModel::limpiar_cadena($_POST['usuario']);
			$contrasena=mainModel::limpiar_cadena($_POST['contrasena']);

			$contrasena=mainModel::encryption($contrasena);

			$datosLogin = [
				"Usuario"=>$usuario,
				"Contrasena"=>$contrasena
			];

			$datosCuenta=loginModelo::iniciar_sesion_modelo($datosLogin);

			if($datosCuenta->rowCount()==1){
				$row=$datosCuenta->fetch();

				$fechaActual=date("d-m-Y");
				$anoActual=date("Y");
				$horaActual=date("h:i:s a");

				$consulta1=mainModel::ejecutar_consulta_simple("SELECT id FROM bitacora");
				$numero = ($consulta1->rowCount())+1;
				$codigoBitacora = mainModel::generar_codigo_aleatorio("BIT",5,$numero);

				$datosBitacora=[
					"CodigoBitacora"=>$codigoBitacora,
					"Fecha"=>$fechaActual,
					"HoraInicio"=>$horaActual,
					"HoraFin"=>"Sin registro",
					"Tipo"=>$row['TIPO'],
					"Anio"=>$anoActual,
					"CuentaCodigo"=>$row['CODIGO']
				];
				//echo $codigoBitacora." ".$fechaActual." ".$horaActual." "."Sin registro"." ".$row['TIPO']." ".$anoActual." ".$row['CODIGO'];
				$insertarBitacora=mainModel::guardar_bitacora($datosBitacora);
				
				if($insertarBitacora->rowCount()>=1){
					session_start(['name'=>'CSM']);
					//session_start();
					$_SESSION['usuario_csm']=$row['USUARIO'];
					$_SESSION['tipo_csm']=$row['TIPO'];
					$_SESSION['privilegio_csm']=$row['PRIVILEGIO'];
					$_SESSION['foto_csm']=$row['FOTO'];
					$_SESSION['token_csm']=md5(uniqid(mt_rand(),true));
					$_SESSION['codigo_cuenta_csm']=$row['CODIGO'];
					$_SESSION['codigo_bitacora_csm']=$codigoBitacora;
					$_SESSION['contrasena_csm']=$row['CONTRASENA'];

					$codigo=$row['CODIGO'];

					$nombres="";
					$apellidos="";
					if($row['TIPO']=="Administrador"){
						$consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM administradores WHERE CODIGO_CUENTA_ADMIN='$codigo'");
            			$administrador=$consulta->fetch();
	            		$nombres = $administrador['NOMBRES_ADMIN'];
	            		$apellidos = $administrador['APELLIDOS_ADMIN'];
					}
					else{
						$consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM docentes WHERE CODIGO_CUENTA_DOCENTE='$codigo'");
            			$docente=$consulta->fetch();
	            		$nombres = $docente['NOMBRES_DOCENTE'];
	            		$apellidos = $docente['APELLIDOS_DOCENTE'];
					}
					$nom = explode(" ", $nombres);
	            	$ape = explode(" ", $apellidos);
	            	$_SESSION['nombre_csm']=ucfirst(strtolower($nom[0]));
	            	$_SESSION['apellido_csm']=ucfirst(strtolower($ape[0]));
            		

					// echo $_SESSION['usuario_csm']." ".$_SESSION['tipo_csm']." ".$_SESSION['privilegio_csm']." ".$_SESSION['foto_csm']." ".$_SESSION['token_csm']." ".$_SESSION['codigo_cuenta_csm']." ".$_SESSION['codigo_bitacora_csm'];

					if($row['TIPO']=="Administrador"){
						$url = SERVERURL."administradorPerfil/";
					}
					elseif ($row['TIPO']=="Docente") {
						$url = SERVERURL."docentePerfil/";
					}
					else{
						$url = SERVERURL."alumnoIndex/";
					}

					return $urlLocation='<script> window.location.href="'.$url.'" </script>';
				}
				else{
					$alerta = [
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrio un error inesperado",
					"Texto"=>"No se pudo iniciar la sesión, por favor, intente nuevamente",
					"Tipo"=>"error"
					];
					return mainModel::sweet_alert($alerta);
				}
			}
			else{
				$alerta = [
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrio un error inesperado",
					"Texto"=>"El nombre de usuario y/o contraseña no son correctos o su cuenta puede estar deshabilitada",
					"Tipo"=>"error"
				];
				return mainModel::sweet_alert($alerta);
			}
		}

		/*public function forzar_cierre_sesion_controlador(){
			session_destroy();
			return $urlLocation='<script> window.location.href="'.SERVERURL.'" </script>';
		}*/

		public function cerrar_sesion_controlador(){
			session_start(['name'=>'CSM']);
			//session_start();
			//$token=mainModel::decryption($_GET['Token']);
			$hora=date("h:i:s a");
			$datos=[
				"Usuario"=>$_SESSION['usuario_csm'],
				"Token_S"=>$_SESSION['token_csm'],
				//"Token"=>$token,
				"Codigo"=>$_SESSION['codigo_bitacora_csm'],
				"Hora"=>$hora
			];
			return loginModelo::cerrar_sesion_modelo($datos);
		}
	}
?>