<?php 
	$peticionAjax=true;
	require_once "../core/configGeneral.php";
	if(isset($_POST['cliente'])){
		require_once "../controladores/ventaControlador.php";
		$insVenta = new ventaControlador();

		if (isset($_POST['cliente']) && isset($_POST['producto-1']) && isset($_POST['producto-2']) && isset($_POST['producto-3']) && isset($_POST['producto-4']) && isset($_POST['adelanto'])) {
			 
			echo $insVenta->agregar_venta_controlador();
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