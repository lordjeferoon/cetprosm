<?php
	@session_start(['name'=>'CSM']);
	$horaActual=date("h:i:s a");
	$codigo=$_SESSION['codigo_bitacora_csm'];

	$mysqli = new mysqli(SERVER,USER,PASS,DB);
    $query = $mysqli -> query ("UPDATE bitacora SET HORA_FIN='$horaActual' WHERE CODIGO_BITACORA='$codigo'");

	session_destroy();
	echo'<script> window.location.href="'.SERVERURL.'"</script>';
?>