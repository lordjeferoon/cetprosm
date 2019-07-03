<?php 
	if ($peticionAjax) {
		require_once "../core/configApp.php";
	}
	else{
		require_once "core/configApp.php";
	}
	class mainModel
	{
		public function conectar(){
			$enlace=new PDO(SGBD,USER,PASS);
			return $enlace;
		}

		protected function ejecutar_consulta_simple($sql){
			$respuesta = self::conectar()->prepare($sql);
			$respuesta->execute();
			return $respuesta;
		}

		protected function agregar_cuenta($datos){
			$sql = self::conectar()->prepare("INSERT INTO cuentas (CODIGO, USUARIO, CONTRASENA, TIPO, ESTADO, PRIVILEGIO, FOTO) VALUES(:Codigo, :Usuario, :Contrasena, :Tipo, :Estado, :Privilegio, :Foto)");

			$sql->bindParam(":Codigo",$datos['Codigo']);
			$sql->bindParam(":Usuario",$datos['Usuario']);
			$sql->bindParam(":Contrasena",$datos['Contrasena']);
			$sql->bindParam(":Tipo",$datos['Tipo']);
			$sql->bindParam(":Estado",$datos['Estado']);
			$sql->bindParam(":Privilegio",$datos['Privilegio']);
			$sql->bindParam(":Foto",$datos['Foto']);

			$sql->execute();
			return $sql;
		}

		protected function actualizar_cuenta($datos){
			$sql = self::conectar()->prepare("UPDATE cuentas SET ESTADO=:Estado, PRIVILEGIO=:Privilegio, FOTO=:Foto WHERE CODIGO=:Codigo");

			$sql->bindParam(":Estado",$datos['Estado']);
			$sql->bindParam(":Privilegio",$datos['Privilegio']);
			$sql->bindParam(":Foto",$datos['Foto']);
			$sql->bindParam(":Codigo",$datos['Codigo']);

			$sql->execute();
			return $sql;
		}

		protected function cambiar_estado_modelo($datos){
			$sql = self::conectar()->prepare("UPDATE cuentas SET ESTADO=:Estado WHERE CODIGO=:Codigo");

			$sql->bindParam(":Estado",$datos['Estado']);
			$sql->bindParam(":Codigo",$datos['Codigo']);

			$sql->execute();

			return $sql;
		}

		protected function actualizar_constrasena($codigo,$contraseña){
			$sql = self::conectar()->prepare("UPDATE cuentas SET CONTRASENA=:Contrasena WHERE CODIGO=:Codigo");
			$c=self::encryption($contraseña);
			$sql->bindParam(":Contrasena",$c);
			$sql->bindParam(":Codigo",$codigo);

			$sql->execute();
			return $sql;
		}

			protected function actualizar_cuenta2($datos){
			$sql = self::conectar()->prepare("UPDATE cuentas SET ESTADO=:Estado, FOTO=:Foto WHERE CODIGO=:Codigo");

			$sql->bindParam(":Estado",$datos['Estado']);
			$sql->bindParam(":Foto",$datos['Foto']);
			$sql->bindParam(":Codigo",$datos['Codigo']);

			$sql->execute();
			return $sql;
		}

		protected function eliminar_cuenta($codigo){
			$sql = self::conectar()->prepare("DELETE FROM cuentas WHERE CODIGO=:Codigo");
			$sql->bindParam(":Codigo",$codigo);
			$sql->execute();
			return $sql;
		}

		protected function guardar_bitacora($datos){
			$sql = self::conectar()->prepare("INSERT INTO bitacora (CODIGO_BITACORA, FECHA, HORA_INICIO, HORA_FIN, TIPO, ANIO, CODIGO_CUENTA) VALUES (:CodigoBitacora, :Fecha, :HoraInicio, :HoraFin, :Tipo, :Anio, :CodigoCuenta)");

			//echo $datos['CodigoBitacora']." ".$datos['Fecha']." ".$datos['HoraInicio']." ".$datos['HoraFin']." ".$datos['Tipo']." ".$datos['Anio']." ".$datos['CuentaCodigo'];
			$sql->bindParam(":CodigoBitacora",$datos['CodigoBitacora']);
			$sql->bindParam(":Fecha",$datos['Fecha']);
			$sql->bindParam(":HoraInicio",$datos['HoraInicio']);
			$sql->bindParam(":HoraFin",$datos['HoraFin']);
			$sql->bindParam(":Tipo",$datos['Tipo']);
			$sql->bindParam(":Anio",$datos['Anio']);
			$sql->bindParam(":CodigoCuenta",$datos['CuentaCodigo']);

			$sql->execute();
			return $sql;
		}

		protected function actualizar_bitacora($codigo, $hora){
			$sql = self::conectar()->prepare("UPDATE  bitacora SET HORA_FIN=:HoraFin WHERE CODIGO_BITACORA=:CodigoBitacora");

			$sql->bindParam(":HoraFin",$hora);
			$sql->bindParam(":CodigoBitacora",$codigo);

			$sql->execute();
			return $sql;
		}

		protected function eliminar_bitacora($codigo){
			$sql = self::conectar()->prepare("DELETE FROM bitacora WHERE CODIGO_CUENTA=:CodigoCuenta");

			$sql->bindParam(":CodigoCuenta",$codigo);

			$sql->execute();
			return $sql;
		}

		public function encryption($string){
			$output=FALSE;
			$key=hash('sha256',SECRET_KEY);
			$iv=substr(hash('sha256',SECRET_IV), 0, 16);
			$output=openssl_encrypt($string, METHOD, $key, 0, $iv);
			$output=base64_encode($output);
			return $output;
		}

		public function decryption($string){
			$key=hash('sha256',SECRET_KEY);
			$iv=substr(hash('sha256',SECRET_IV), 0, 16);
			$output=openssl_decrypt(base64_decode($string), METHOD, $key, 0, $iv);
			return $output;
		}

		protected function generar_codigo_aleatorio($letra,$longitud,$num){

			$numero=$num;
			$n = 0;
			do{
				$numero = floor($numero / 10);
				$n = $n + 1;
			} while ($numero > 0);
			$max=9-$n;

			for($i=1; $i<=$max; $i++){
				$letra.="0";
			}

			return $letra.$num;
		}

		protected function limpiar_cadena($cadena){
			$cadena = trim($cadena);
			$cadena = stripslashes($cadena);
			$cadena = str_ireplace("<script>", "", $cadena);
			$cadena = str_ireplace("</script>", "", $cadena);
			$cadena = str_ireplace("<script src", "", $cadena);
			$cadena = str_ireplace("<script type=", "", $cadena);
			$cadena = str_ireplace("--", "", $cadena);
			$cadena = str_ireplace("[", "", $cadena);
			$cadena = str_ireplace("]", "", $cadena);
			$cadena = str_ireplace("==", "", $cadena);
			$cadena = str_ireplace("^", "", $cadena);
			$cadena = str_ireplace(";", "", $cadena);
			$cadena = str_ireplace("SELECT * FROM", "", $cadena);
			$cadena = str_ireplace("DELETE FROM", "", $cadena);
			$cadena = str_ireplace("INSERT INTO", "", $cadena);
			return $cadena;
		}

		protected function sweet_alert($datos){
			if($datos['Alerta']=="simple"){
				$alerta="
					<script>
						swal(
						  '".$datos['Titulo']."',
						  '".$datos['Texto']."',
						  '".$datos['Tipo']."'
						);
					</script>
				";
			}
			elseif ($datos['Alerta']=="recargar") {
				$alerta="
					<script>
						Swal({
							  title: '".$datos['Titulo']."',
							  text: '".$datos['Texto']."',
							  type: '".$datos['Tipo']."',
							  confirmButtonText: 'Aceptar'
							}).then((result) => {
							  if (result.value) {
							      location.reload();
							  }
							});
					</script>
				";
			}
			elseif ($datos['Alerta']=="limpiar"){
				$alerta="
					<script>
						Swal({
							  title: '".$datos['Titulo']."',
							  text: '".$datos['Texto']."',
							  type: '".$datos['Tipo']."',
							  confirmButtonText: 'Aceptar'
							}).then((result) => {
							  if (result.value) {
							      $('.FormularioAjax')[0].reset();
							  }
							});
					</script>
				";
			}
			return $alerta;
		}
	}
?>