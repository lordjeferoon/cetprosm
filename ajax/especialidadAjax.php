<?php 
	$peticionAjax=true;
	require_once "../core/configGeneral.php";
	if(isset($_POST['nombre1']) || isset($_POST['codigo-especialidad']) || isset($_POST['nombre1-2'])){
		require_once "../controladores/especialidadControlador.php";
		$insEspecialidad = new especialidadControlador();

		if (isset($_POST['nombre1']) && isset($_POST['nombre2'])) {
			echo $insEspecialidad->agregar_especialidad_controlador();
		}

		if(isset($_POST['codigo-especialidad']) && isset($_POST['privilegio-admin'])){
			echo $insEspecialidad->eliminar_especialidad_controlador();
		}

		if (isset($_POST['nombre1-2']) && isset($_POST['nombre2-2'])) {
			echo $insEspecialidad->actualizar_especialidad_controlador($_POST['codigo-editar']);
		}
	}
	else{
		session_start();
		session_destroy();
		echo'<script> window.location.href="'.SERVERURL.'login/" </script>';
	}
?>