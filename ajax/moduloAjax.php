<?php 
	$peticionAjax=true;
	require_once "../core/configGeneral.php";
	if(isset($_POST['nombre']) || isset($_POST['codigo-modulo']) || isset($_POST['nombre-2'])){
		require_once "../controladores/moduloControlador.php";
		$insModulo = new moduloControlador();

		if (isset($_POST['nombre']) && isset($_POST['precio']) && isset($_POST['meses']) && isset($_POST['horas'])) {
			echo $insModulo->agregar_modulo_controlador();
		}

		if(isset($_POST['codigo-modulo']) && isset($_POST['privilegio-admin'])){
			echo $insModulo->eliminar_modulo_controlador();
		}

		if (isset($_POST['nombre-2']) && isset($_POST['precio-2']) && isset($_POST['meses-2']) && isset($_POST['horas-2'])) {
			echo $insModulo->actualizar_modulo_controlador($_POST['codigo-editar']);
		}
	}
	else{
		session_start();
		session_destroy();
		echo'<script> window.location.href="'.SERVERURL.'login/" </script>';
	}
?>