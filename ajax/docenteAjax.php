<?php 
	$peticionAjax=true;
	require_once "../core/configGeneral.php";
	if(isset($_POST['dni']) || isset($_POST['codigo-docente'])  || isset($_POST['dni-2']) || isset($_POST['codigo-cambio'])){
		require_once "../controladores/docenteControlador.php";
		$insDocente = new docenteControlador();

		if (isset($_POST['apellidos']) && isset($_POST['nombres']) && isset($_POST['dni']) && isset($_POST['sexo']) && isset($_POST['fecha-nacimiento']) && isset($_POST['numero'])) {
			echo $insDocente->agregar_docente_controlador();
		}

		if(isset($_POST['codigo-docente']) && isset($_POST['privilegio-admin'])){
			echo $insDocente->eliminar_docente_controlador();
		}

		if(isset($_POST['codigo-cambio']) && isset($_POST['privilegio-admin'])){
			echo $insDocente->cambiar_estado_controlador();
		}

		if (isset($_POST['apellidos-2']) && isset($_POST['nombres-2']) && isset($_POST['dni-2']) && isset($_POST['sexo-2']) && isset($_POST['fecha-nacimiento-2']) && isset($_POST['numero-2'])) {
			echo $insDocente->actualizar_docente_controlador($_POST['codigo-editar']);
		}
	}
	else{
		session_start();
		session_destroy();
		echo'<script> window.location.href="'.SERVERURL.'login/" </script>';
	}
?>