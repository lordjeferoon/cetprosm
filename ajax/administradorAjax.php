<?php 
	//error_reporting(0);
	$peticionAjax=true;
	require_once "../core/configGeneral.php";
	if(isset($_POST['dni']) || isset($_POST['codigo-admin']) || isset($_POST['dni-2']) || isset($_POST['usuario-3']) || isset($_POST['codigo-cambio'])){
		require_once "../controladores/administradorControlador.php";
		$insAdmin = new administradorControlador();

		if (isset($_POST['apellidos']) && isset($_POST['nombres']) && isset($_POST['dni']) && isset($_POST['sexo']) && isset($_POST['fecha-nacimiento']) && isset($_POST['numero'])) {
			echo $insAdmin->agregar_administrador_controlador();
		}

		if(isset($_POST['codigo-admin']) && isset($_POST['privilegio-admin'])){
			echo $insAdmin->eliminar_administrador_controlador();
		}

		if(isset($_POST['codigo-cambio']) && isset($_POST['privilegio-admin']) && isset($_POST['privilegio-cambio'])){
			echo $insAdmin->cambiar_estado_controlador();
		}

		if (isset($_POST['apellidos-2']) && isset($_POST['nombres-2']) && isset($_POST['dni-2']) && isset($_POST['sexo-2']) && isset($_POST['fecha-nacimiento-2']) && isset($_POST['numero-2'])) {
			echo $insAdmin->actualizar_administrador_controlador($_POST['codigo-editar']);
		}

		if(isset($_POST['usuario-3'])){
			echo $insAdmin->actualizar_contrasena_controlador();
		}
	}
	else{
		session_start();
		session_destroy();
		echo'<script> window.location.href="'.SERVERURL.'login/" </script>';
	}
?>