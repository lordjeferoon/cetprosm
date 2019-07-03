<?php
	if ($peticionAjax) {
		require_once "../modelos/administradorModelo.php";
	}
	else{
		require_once "modelos/administradorModelo.php";
	}
  
	class administradorControlador extends administradorModelo
	{
		public function agregar_administrador_controlador()
		{
			$apellidos = mainModel::limpiar_cadena($_POST['apellidos']);
			$nombres = mainModel::limpiar_cadena($_POST['nombres']);
			$dni = mainModel::limpiar_cadena($_POST['dni']);
			$fechaNac = mainModel::limpiar_cadena($_POST['fecha-nacimiento']);
			$sexo = mainModel::limpiar_cadena($_POST['sexo']);
			$estado = mainModel::limpiar_cadena($_POST['estado']);
			$numero = mainModel::limpiar_cadena($_POST['numero']);
			$email = mainModel::limpiar_cadena($_POST['email']);
			$direccion = mainModel::limpiar_cadena($_POST['direccion']);
			$distrito = mainModel::limpiar_cadena($_POST['distrito']);
			$referencia = mainModel::limpiar_cadena($_POST['referencia']);

			$usuario = mainModel::limpiar_cadena($_POST['usuario']);
			$contraseña1 = mainModel::limpiar_cadena($_POST['contraseña1']);
			$contraseña2 = mainModel::limpiar_cadena($_POST['contraseña2']);

			//$privilegio = mainModel::decryption($_POST['optradio']);
			//$privilegio = mainModel::limpiar_cadena($privilegio);
			$privilegio=1;

			if($sexo=="M"){
				$foto="adminHombre.jpg";
			}
			else{
				$foto="adminMujer.jpg";
			}

			if($privilegio<1 || $privilegio>3){
				$alerta = [
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrio un error inesperado",
					"Texto"=>"El nivel de privilegio a asignar es incorrecto",
					"Tipo"=>"error"
				];
			}
			else{
				if($contraseña1!=$contraseña2){
				$alerta = [
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrio un error inesperado",
					"Texto"=>"Las contraseñas no coinciden, intente nuevamente",
					"Tipo"=>"error"
				];
			}
			else{
				$consulta1 = mainModel::ejecutar_consulta_simple("SELECT DNI_ADMIN FROM administradores WHERE DNI_ADMIN='$dni'");
				if(($consulta1->rowCount())>=1){
					$alerta = [
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrio un error inesperado",
					"Texto"=>"El DNI ingresado ya se encuentra registrado en el sistema",
					"Tipo"=>"error"
					];
				}
				else{
					$consulta2 = mainModel::ejecutar_consulta_simple("SELECT CORREO_ADMIN FROM administradores WHERE CORREO_ADMIN='$email'");
					if(($consulta2->rowCount())>=1){
						$alerta = [
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrio un error inesperado",
						"Texto"=>"El CORREO ingresado ya se encuentra registrado en el sistema",
						"Tipo"=>"error"
						];
					}
					else{
						$consulta3 = mainModel::ejecutar_consulta_simple("SELECT USUARIO FROM cuentas WHERE USUARIO='$usuario'");
						if(($consulta3->rowCount())>=1){
							$alerta = [
							"Alerta"=>"simple",
							"Titulo"=>"Ocurrio un error inesperado",
							"Texto"=>"El NOMBRE DE USUARIO ingresado ya se encuentra registrado en el sistema",
							"Tipo"=>"error"
							];
						}
						else{
							$consulta4 = mainModel::ejecutar_consulta_simple("SELECT ID_ADMIN FROM administradores");

							$contador = ($consulta4->rowCount())+1;
							$codigo = mainModel::generar_codigo_aleatorio("ADM",5,$contador);
							$clave = mainModel::encryption($contraseña1);

							$datosCuenta=[
								"Codigo"=>$codigo,
								"Usuario"=>$usuario,
								"Contrasena"=>$clave,
								"Tipo"=>"Administrador",
								"Estado"=>$estado,
								"Privilegio"=>$privilegio,
								"Foto"=>$foto
							];

							$guardarCuenta=mainModel::agregar_cuenta($datosCuenta);

							if(($guardarCuenta->rowCount())>=1){
								$datosAdministrador=[
									"Apellidos"=>$apellidos,
									"Nombres"=>$nombres,
									"Dni"=>$dni,
									"FechaNac"=>$fechaNac,
									"Sexo"=>$sexo,
									"Telefono"=>$numero,
									"Correo"=>$email,
									"Direccion"=>$direccion,
									"Distrito"=>$distrito,
									"Referencia"=>$referencia,
									"Codigo"=>$codigo
								];

								$guardarAdmin=administradorModelo::agregar_administrador_modelo($datosAdministrador);
								if(($guardarAdmin->rowCount())>=1){
									$alerta = [
									"Alerta"=>"limpiar",
									"Titulo"=>"Administrador registrado",
									"Texto"=>"El administrador ha sido registrado en el sistema.",
									"Tipo"=>"success"
									];
								}
								else{
									mainModel::eliminar_cuenta($codigo);
									$alerta = [
									"Alerta"=>"simple",
									"Titulo"=>"Ocurrio un error inesperado",
									"Texto"=>"No hemos podido registrar el administrador en el sistema.",
									"Tipo"=>"error"
									];
								}
							}
							else{
								$alerta = [
								"Alerta"=>"simple",
								"Titulo"=>"Ocurrio un error inesperado",
								"Texto"=>"No hemos podido registrar el administrador en el sistema.",
								"Tipo"=>"error"
								];
							}
						}
					}
				}
			}
			}

			return mainModel::sweet_alert($alerta);
		}

		public function actualizar_administrador_controlador($codigo1)
		{
			$apellidos = mainModel::limpiar_cadena($_POST['apellidos-2']);
			$nombres = mainModel::limpiar_cadena($_POST['nombres-2']);
			$dni = mainModel::limpiar_cadena($_POST['dni-2']);
			$fechaNac = mainModel::limpiar_cadena($_POST['fecha-nacimiento-2']);
			$sexo = mainModel::limpiar_cadena($_POST['sexo-2']);
			//$estado = mainModel::limpiar_cadena($_POST['estado-2']);
			$numero = mainModel::limpiar_cadena($_POST['numero-2']);
			$email = mainModel::limpiar_cadena($_POST['email-2']);
			$direccion = mainModel::limpiar_cadena($_POST['direccion-2']);
			$distrito = mainModel::limpiar_cadena($_POST['distrito-2']);
			$referencia = mainModel::limpiar_cadena($_POST['referencia-2']);

			//$privilegio = mainModel::limpiar_cadena($_POST['optradio-2']);
			//$privilegio = mainModel::decryption($privilegio);
			$codigo=$codigo1;
			$privilegio=1;

			if($sexo=="M"){
				$foto="adminHombre.jpg";
			}
			else{
				$foto="adminMujer.jpg";
			}

			$consulta1 = mainModel::ejecutar_consulta_simple("SELECT DNI_ADMIN FROM administradores WHERE DNI_ADMIN='$dni' AND CODIGO_CUENTA_ADMIN<>'$codigo'");
				
				if(($consulta1->rowCount())>=1){
					$alerta = [
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrio un error inesperado",
					"Texto"=>"El DNI ingresado ya se encuentra registrado en el sistema",
					"Tipo"=>"error"
					];
				}
				else{
					$consulta2 = mainModel::ejecutar_consulta_simple("SELECT CORREO_ADMIN FROM administradores WHERE CORREO_ADMIN='$email' AND CODIGO_CUENTA_ADMIN<>'$codigo'");
					if(($consulta2->rowCount())>=1){
						$alerta = [
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrio un error inesperado",
						"Texto"=>"El CORREO ingresado ya se encuentra registrado en el sistema",
						"Tipo"=>"error"
						];
					}
					else{

							/*$datosCuenta=[
								"Estado"=>$estado,
								"Privilegio"=>$privilegio,
								"Foto"=>$foto,
								"Codigo"=>$codigo
							];

							$actualizarCuenta=mainModel::actualizar_cuenta($datosCuenta);*/

							//if(($actualizarCuenta->rowCount())>=1){
								
								$datosAdministrador=[
									"Apellidos"=>$apellidos,
									"Nombres"=>$nombres,
									"Dni"=>$dni,
									"FechaNac"=>$fechaNac,
									"Sexo"=>$sexo,
									"Telefono"=>$numero,
									"Correo"=>$email,
									"Direccion"=>$direccion,
									"Distrito"=>$distrito,
									"Referencia"=>$referencia,
									"Codigo"=>$codigo
								];

								$actualizarAdmin=administradorModelo::actualizar_administrador_modelo($datosAdministrador);

								if(($actualizarAdmin->rowCount())==1){
									$alerta = [
									"Alerta"=>"recargar",
									"Titulo"=>"Administrador actualizado ",
									"Texto"=>"Los datos del administrador han sido actulizados en el sistema.",
									"Tipo"=>"success"
									];
								}
								else{
									$alerta = [
									"Alerta"=>"simple",
									"Titulo"=>"Ocurrio un error inesperado",
									"Texto"=>"No se ha realizado ningún cambio en alguno de los campos.",
									"Tipo"=>"error"
									];
								}
							//}
							/*else{
								$alerta = [
								"Alerta"=>"simple",
								"Titulo"=>"Ocurrio un error inesperado",
								"Texto"=>"No hemos podido actualizar los datos del administrador en el sistema. 2",
								"Tipo"=>"error"
								];
							}*/
					}
				}
			return mainModel::sweet_alert($alerta);
		}


		//CONTROLADOR PARA PAGINA ADMINISTRADOR
		public function paginador_administrador_controlador($pagina, $numRegistros, $privilegio, $codigoAdmin){
			$pagina=mainModel::limpiar_cadena($pagina);
			$numRegistros=mainModel::limpiar_cadena($numRegistros);
			$privilegio=mainModel::limpiar_cadena($privilegio);
			$codigoAdmin=mainModel::limpiar_cadena($codigoAdmin);
			$tabla="";

			$pagina = (isset($pagina) && $pagina>0) ? (int) $pagina : 1;
			$inicio = ($pagina>0) ? (($pagina*$numRegistros)-$numRegistros) : 0;

			$conexion = mainModel::conectar();

			$datos = $conexion->prepare("
				SELECT SQL_CALC_FOUND_ROWS * FROM administradores WHERE CODIGO_CUENTA_ADMIN!='$codigoAdmin' AND ID_ADMIN!=1 ORDER BY APELLIDOS_ADMIN ASC LIMIT $inicio,$numRegistros
			");
			$datos->execute();
			$datos = $datos->fetchAll();

			$total = $conexion->query("SELECT FOUND_ROWS()");
			$total = (int) $total->fetchColumn();

			$numPaginas = ceil($total/$numRegistros);

			$tabla.='
				<table class="table table-hover table-sm table-responsive">
                    <thead class="table-secondary">
                        <tr>
                            <th width="3%">No</th>
                            <th width="28%">Apellidos</th>
                            <th >Nombres</th>
                            <th width="10%">Usuario</th>
                            <th width="13%">Estado</th>';

                            if($privilegio<=2 ){
                            	$tabla.='<th width="11%">Acciones</th>';
                            }
                            
               $tabla.='</tr>
                    </thead>
                    <tbody>'
            ;

            if($total>=1 && $pagina<=$numPaginas){
            	$contador = $inicio+1;
            	foreach ($datos as $row) {
            		$codigo=$row['CODIGO_CUENTA_ADMIN'];
            		$consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM cuentas WHERE CODIGO='$codigo'");
            		$cuenta=$consulta->fetch();
            		$tabla.='
            		<tr>
                        <td class="align-middle">'.$contador.'</td>
                        <td class="align-middle">'.$row['APELLIDOS_ADMIN'].'</td>
                        <td class="align-middle">'.$row['NOMBRES_ADMIN'].'</td>
                        <td class="align-middle">'.$cuenta['USUARIO'].'</td>';

                        if($cuenta['ESTADO']=="Activo"){
                        	$tabla.='<td class="align-middle">
                        		<span class="badge badge-success">&nbsp;'.$cuenta['ESTADO'].'&nbsp;</span>
                        		<form  action="'.SERVERURL.'ajax/administradorAjax.php" method="POST" data-form="actualizar" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data" style="display:inline">

                        				<input type="hidden" name="codigo-cambio" value="'.mainModel::encryption($row['CODIGO_CUENTA_ADMIN']).'">

                        				<input type="hidden" name="privilegio-cambio" value="'.mainModel::encryption($cuenta['PRIVILEGIO']).'">

                        				<input type="hidden" name="privilegio-admin" value="'.mainModel::encryption($privilegio).'">

                        				<button type="submit" class="btn btn-primary btn-sm" title="Cambiar Estado"><i class="fas fa-exchange-alt"></i></button>

                        				<div class="RespuestaAjax"></div>
                        		</form>
                        	</td>';
                        }
                        else{
                        	$tabla.='<td class="align-middle">
                        		<span class="badge badge-secondary">'.$cuenta['ESTADO'].'</span>
                        		<form  action="'.SERVERURL.'ajax/administradorAjax.php" method="POST" data-form="actualizar" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data" style="display:inline">

                        				<input type="hidden" name="codigo-cambio" value="'.mainModel::encryption($row['CODIGO_CUENTA_ADMIN']).'">

                        				<input type="hidden" name="privilegio-cambio" value="'.mainModel::encryption($cuenta['PRIVILEGIO']).'">

                        				<input type="hidden" name="privilegio-admin" value="'.mainModel::encryption($privilegio).'">

                        				<button type="submit" class="btn btn-primary btn-sm" title="Cambiar Estado"><i class="fas fa-exchange-alt"></i></button>

                        				<div class="RespuestaAjax"></div>
                        		</form>
                        	</td>';
                        }

                        if($privilegio==2){
                        	$tabla.='                   
                        		<td>
                            		<form>
                        				<a href="'.SERVERURL.'administradorAdminModificar/'.mainModel::encryption($row['CODIGO_CUENTA_ADMIN']).'/" title="Editar datos" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                        			</form>
                        		</td>
                        	';
                        }

                        if($privilegio==1){
                        	$tabla.='                   
                        		<td>
                        			<form  style="display:inline">
                        				<a href="'.SERVERURL.'administradorAdminModificar/'.mainModel::encryption($row['CODIGO_CUENTA_ADMIN']).'/" title="Editar datos" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                        			</form>
                        			<form  action="'.SERVERURL.'ajax/administradorAjax.php" method="POST" data-form="borrar" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data" style="display:inline">

                        				<input type="hidden" name="codigo-admin" value="'.mainModel::encryption($row['CODIGO_CUENTA_ADMIN']).'">

                        				<input type="hidden" name="privilegio-admin" value="'.mainModel::encryption($privilegio).'">

                        				<button type="submit" class="btn btn-danger btn-sm" title="Eliminar"><i class="fas fa-trash-alt"></i></button>

                        				<div class="RespuestaAjax"></div>
                        			</form>
                        		</td>
                        	';
                        }

                    $tabla.='
                    </tr>
            		';
            		$contador++;
            	}
            }
            else{
            	if($total>=1){
            		$tabla.='
            			<tr>
 							<td colspan="6" align="center">
 								<a href="'.SERVERURL.'administradorAdminTodos/">

 								</a>
 							</td>
                    	</tr>
            		';
            	}
            	else{
            		$tabla.='
            			<tr>
 							<td colspan="6" align="center">No hay registros para mostrar</td>
                    	</tr>
            		';
            	}
            }

            $tabla.='</tbody>
                    </table>';

            if($total>=1 && $pagina<=$numPaginas){
            	$tabla.='<br><div class="row justify-content-center align-items-center"><nav class="text-center"><ul class="pagination pagination-sm">';

            	if($pagina==1){
            		$tabla.='<li class="disabled"><a><i class="far fa-arrow-alt-circle-left"></i></a></li>';
            	}
            	else{
            		$tabla.='<li><a href="'.SERVERURL.'administradorAdminTodos/'.($pagina-1).'/"><i class="far fa-arrow-alt-circle-left"></i></a></li>';
            	}

            	for ($i=1; $i<=$numPaginas; $i++) { 
            		if($pagina==$i){
            			$tabla.='<li class="active"><a href="'.SERVERURL.'administradorAdminTodos/'.$i.'/">'.$i.'</a></li>';
            		}
            		else{
            			$tabla.='<li><a href="'.SERVERURL.'administradorAdminTodos/'.$i.'/">'.$i.'</a></li>';
            		}
            	}

				if($pagina==$numPaginas){
            		$tabla.='<li><a><i class="far fa-arrow-alt-circle-right"></i></a></li>';
            	}
            	else{
            		$tabla.='<li class="disabled"><a href="'.SERVERURL.'administradorAdminTodos/'.($pagina+1).'/"><i class="far fa-arrow-alt-circle-right"></i></a></li>';
            	}
            	$tabla.='</ul></nav></div>';
            }
			return $tabla;
		}

		public function eliminar_administrador_controlador(){
			$codigo=mainModel::decryption($_POST['codigo-admin']);
			$privilegio=mainModel::decryption($_POST['privilegio-admin']);

			$codigo=mainModel::limpiar_cadena($codigo);
			$privilegio=mainModel::limpiar_cadena($privilegio);

			if($privilegio==1){
				$query1 = mainModel::ejecutar_consulta_simple("SELECT ID_ADMIN FROM administradores WHERE CODIGO_CUENTA_ADMIN='$codigo'");
				$datosAdmin = $query1->fetch();
				if($datosAdmin['ID_ADMIN']!=1){
					mainModel::eliminar_bitacora($codigo);
					$b=mainModel::eliminar_cuenta($codigo);
					if($b->rowCount()>=1){
						$eliminarAdministrador = administradorModelo::eliminar_administrador_modelo($codigo);
						if($eliminarAdministrador->rowCount()==1){
							$alerta = [
								"Alerta"=>"recargar",
								"Titulo"=>"Administrador eliminado",
								"Texto"=>"El administrador fue eliminado con éxito del sistema",
								"Tipo"=>"success"
							];
						}
						else{
							$alerta = [
								"Alerta"=>"simple",
								"Titulo"=>"Ocurrió un error inesperado",
								"Texto"=>"No se puede eliminar el administrador del sistema",
								"Tipo"=>"error"
							];
						}
					}
					else{
						$alerta = [
							"Alerta"=>"simple",
							"Titulo"=>"Ocurrió un error inesperado",
							"Texto"=>"No pudo eliminar el administrador del sistema",
							"Tipo"=>"error"
						];
					}
				}
				else{
					$alerta = [
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrió un error inesperado",
						"Texto"=>"No puede eliminar el administrador principal del sistema",
						"Tipo"=>"error"
					];
				}
			}
			else{
				$alerta = [
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No tiene los permisos necesarios para esta operación",
					"Tipo"=>"error"
				];
			}

			return mainModel::sweet_alert($alerta);
		}

		public function datos_administrador_controlador($codigo1){
			$codigo = mainModel::decryption($codigo1);
			return administradorModelo::datos_administrador_modelo($codigo);
		}

		public function actualizar_contrasena_controlador(){
			$codigo = $_POST['codigo-editar'];
			$contraseña1=$_POST['contraseña1-21'];
			$contraseña2=$_POST['contraseña2-21'];

			if($contraseña1!=$contraseña2){
				$alerta = [
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"Las contraseñas no coinciden. Intente nuevamente.",
					"Tipo"=>"error"
				];
			}
			else{
				$actualizarContra = mainModel::actualizar_constrasena($codigo,$contraseña1);
				if($actualizarContra->rowCount()==1){
					$alerta = [
						"Alerta"=>"recargar",
						"Titulo"=>"Contraseña actualizada",
						"Texto"=>"Su contraseña ha sido actualizada en el sistema",
						"Tipo"=>"success"
					];
				}
				else{
					$alerta = [
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrió un error inesperado",
						"Texto"=>"No se pudo actualizar su contraseña en el sistema.",
						"Tipo"=>"error"
					];
				}
			}
			return mainModel::sweet_alert($alerta);
		}

		public function cambiar_estado_controlador(){
			$codigoCambiado = mainModel::decryption($_POST['codigo-cambio']);
			$privilegioAdmin = mainModel::decryption($_POST['privilegio-admin']);
			$privilegioCambiado = mainModel::decryption($_POST['privilegio-cambio']);

			$nuevoEstado = "";

			if($privilegioAdmin>$privilegioCambiado){
				$alerta = [
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrio un error inesperado",
					"Texto"=>"Su privilegio no le permite editar a este administrador.",
					"Tipo"=>"error"
				];
			}else{
				$consulta1 = mainModel::ejecutar_consulta_simple("SELECT * FROM cuentas WHERE CODIGO='$codigoCambiado'");
				if($consulta1->rowCount()==0){
					$alerta = [
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrio un error inesperado",
						"Texto"=>"No se pudo realizar la operación solicitada.",
						"Tipo"=>"error"
					];	
				}
				else{
					$cuenta = $consulta1->fetch();
					if($cuenta['ESTADO']=="Activo"){
						$nuevoEstado="Inactivo";
					}
					else{
						$nuevoEstado="Activo";
					}

					$datosCuenta=[
						"Estado"=>$nuevoEstado,
						"Codigo"=>$codigoCambiado
					];

					$actualizarCuenta=mainModel::cambiar_estado_modelo($datosCuenta);

					if(($actualizarCuenta->rowCount())==1){
						$alerta = [
							"Alerta"=>"recargar",
							"Titulo"=>"Estado actualizado",
							"Texto"=>"El estado del administrador ha sido actulizado en el sistema.",
							"Tipo"=>"success"
						];
					}
					else{
						$alerta = [
							"Alerta"=>"simple",
							"Titulo"=>"Ocurrio un error inesperado",
							"Texto"=>"No se pudo realizar la operación solicitada.",
							"Tipo"=>"error"
						];
					}
				}
			}
		
			return mainModel::sweet_alert($alerta);
		}

	}
?>