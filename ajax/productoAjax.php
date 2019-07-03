<?php 
	$peticionAjax=true;
	require_once "../core/configGeneral.php";
	if(isset($_POST['nombre']) || isset($_POST['codigo-producto']) || isset($_POST['nombre-2'])){
		require_once "../controladores/productoControlador.php";
		$insProducto = new productoControlador();

		if (isset($_POST['nombre']) && isset($_POST['descripcion']) && isset($_POST['precio'])) {
			echo $insProducto->agregar_producto_controlador();
		}

		if(isset($_POST['codigo-producto']) && isset($_POST['privilegio-admin'])){
			echo $insProducto->eliminar_producto_controlador();
		}

		if (isset($_POST['nombre-2']) && isset($_POST['descripcion-2']) && isset($_POST['precio-2'])) {
			echo $insProducto->actualizar_producto_controlador($_POST['codigo-editar']);
		}
	}
	else{
		session_start();
		session_destroy();
		echo'<script> window.location.href="'.SERVERURL.'login/" </script>';
	}
?>