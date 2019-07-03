<?php 
	$peticionAjax=true;
	require_once "../core/configGeneral.php";
	if(isset($_POST['alumno']) || isset($_POST['codigo'])){
		require_once "../controladores/matriculaControlador.php";
		$insMatricula = new matriculaControlador();

		if(isset($_POST['asignacion-1']) && isset($_POST['asignacion-2']) && isset($_POST['asignacion-3']) && isset($_POST['asignacion-4']) && isset($_POST['asignacion-5']) && isset($_POST['asignacion-6']) && isset($_POST['alumno']) && isset($_POST['adelanto'])) {
			echo $insMatricula->agregar_matricula_controlador();
		}

		if(isset($_POST['codigo'])) {
			echo $insMatricula->actualizar_saldo_controlador();
		}
	}
	else{
		session_start();
		session_destroy();
		echo'<script> window.location.href="'.SERVERURL.'login/" </script>';
	}
?>