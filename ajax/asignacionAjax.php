<?php 
	$peticionAjax=true;
	require_once "../core/configGeneral.php";
	if(isset($_POST['vacantes']) || isset($_POST['asistencia1']) || isset($_POST['nota1'])){
		require_once "../controladores/asignacionControlador.php";
		$insAsignacion = new asignacionControlador();

		if (isset($_POST['vacantes']) && isset($_POST['docente']) && isset($_POST['modulo']) && isset($_POST['turno']) && isset($_POST['frecuencia']) && isset($_POST['fecha-inicio']) && isset($_POST['fecha-fin']) && isset($_POST['hora-fin']) && isset($_POST['hora-fin'])) {
			echo $insAsignacion->agregar_asignacion_controlador();
		}

		if (isset($_POST['asistencia1'])) {
			echo $insAsignacion->agregar_asistencia_controlador();
		}

		if (isset($_POST['nota1'])) {
			echo $insAsignacion->agregar_nota_controlador();
		}

		/*if(isset($_POST['codigo-admin']) && isset($_POST['privilegio-admin'])){
			echo $insAdmin->eliminar_administrador_controlador();
		}

		if (isset($_POST['apellidos-2']) && isset($_POST['nombres-2']) && isset($_POST['dni-2']) && isset($_POST['sexo-2']) && isset($_POST['fecha-nacimiento-2']) && isset($_POST['numero-2'])) {
			echo $insAdmin->actualizar_administrador_controlador($_POST['codigo-editar']);
		}*/
	}
	else{
		session_start();
		session_destroy();
		echo'<script> window.location.href="'.SERVERURL.'login/" </script>';
	}
?>