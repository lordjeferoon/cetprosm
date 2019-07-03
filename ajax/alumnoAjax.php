<?php 
	$peticionAjax=true;
	require_once "../core/configGeneral.php";
	if(isset($_POST['dni']) || isset($_POST['codigo-alumno']) || isset($_POST['dni-2']) || isset($_POST['codigo-cambio'])){
		require_once "../controladores/alumnoControlador.php";
		$insAlumno = new alumnoControlador();

		if (isset($_POST['apellidos']) && isset($_POST['nombres']) && isset($_POST['dni']) && isset($_POST['sexo']) && isset($_POST['fecha-nacimiento']) && isset($_POST['numero'])) {
			echo $insAlumno->agregar_alumno_controlador();
		}

		if(isset($_POST['codigo-alumno']) && isset($_POST['privilegio-admin'])){
			echo $insAlumno->eliminar_alumno_controlador();
		}

		if(isset($_POST['codigo-cambio']) && isset($_POST['privilegio-admin'])){
			echo $insAlumno->cambiar_estado_controlador();
		}

		if (isset($_POST['apellidos-2']) && isset($_POST['nombres-2']) && isset($_POST['dni-2']) && isset($_POST['sexo-2']) && isset($_POST['fecha-nacimiento-2']) && isset($_POST['numero-2'])) {
			echo $insAlumno->actualizar_alumno_controlador($_POST['codigo-editar']);
		}
	}
	else{
		session_start();
		session_destroy();
		echo'<script> window.location.href="'.SERVERURL.'login/" </script>';
	}
?>