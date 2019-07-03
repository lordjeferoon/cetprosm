<?php 
	$peticionAjax=true;
	require_once "../core/configGeneral.php";
	if(isset($_POST['nombre1']) || isset($_POST['codigo-categoria']) || isset($_POST['nombre1-2'])){
		require_once "../controladores/categoriaControlador.php";
		$insCategoria = new categoriaControlador();

		if (isset($_POST['nombre1']) && isset($_POST['nombre2'])) {
			echo $insCategoria->agregar_categoria_controlador();
		}

		if(isset($_POST['codigo-categoria']) && isset($_POST['privilegio-admin'])){
			echo $insCategoria->eliminar_categoria_controlador();
		}

		if (isset($_POST['nombre1-2']) && isset($_POST['nombre2-2'])) {
			echo $insCategoria->actualizar_categoria_controlador($_POST['codigo-editar']);
		}
	}
	else{
		session_start();
		session_destroy();
		echo'<script> window.location.href="'.SERVERURL.'login/" </script>';
	}
?>