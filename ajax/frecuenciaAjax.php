<?php 
	$peticionAjax=true;
	require_once "../core/configGeneral.php";
	if(isset($_POST['nombre1']) || isset($_POST['codigo-frecuencia']) || isset($_POST['nombre1-2'])){
		require_once "../controladores/frecuenciaControlador.php";
		$insFrecuencia = new frecuenciaControlador();

		if (isset($_POST['nombre1']) && isset($_POST['nombre2'])) {
			echo $insFrecuencia->agregar_frecuencia_controlador();
		}

		if(isset($_POST['codigo-frecuencia']) && isset($_POST['privilegio-admin'])){
			echo $insFrecuencia->eliminar_frecuencia_controlador();
		}

		if (isset($_POST['nombre1-2']) && isset($_POST['nombre2-2'])) {
			echo $insFrecuencia->actualizar_frecuencia_controlador($_POST['codigo-editar']);
		}
	}
	else{
		session_start();
		session_destroy();
		echo'<script> window.location.href="'.SERVERURL.'login/" </script>';
	}
?>