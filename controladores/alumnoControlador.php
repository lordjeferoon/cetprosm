<?php
	if ($peticionAjax) {
		require_once "../modelos/alumnoModelo.php";
	}
	else{
		require_once "modelos/alumnoModelo.php";
	}
  
	class alumnoControlador extends alumnoModelo
	{
		public function agregar_alumno_controlador()
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
			$nomina1 = mainModel::limpiar_cadena($_POST['nomina1']);
			$nomina2 = mainModel::limpiar_cadena($_POST['nomina2']);
			$condicion = mainModel::limpiar_cadena($_POST['condicion']);


			if($sexo=="M"){
				$foto="adminHombre.jpg";
			}
			else{
				$foto="adminMujer.jpg";
			}
			
			
				$consulta1 = mainModel::ejecutar_consulta_simple("SELECT DNI_ALUMNO FROM alumnos WHERE DNI_ALUMNO='$dni'");
				if(($consulta1->rowCount())>=1){
					$alerta = [
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrio un error inesperado",
					"Texto"=>"El DNI ingresado ya se encuentra registrado en el sistema",
					"Tipo"=>"error"
					];
				}
				else{
					/*$consulta2 = mainModel::ejecutar_consulta_simple("SELECT CORREO_ALUMNO FROM ALUMNOS WHERE CORREO_ALUMNO='$email'");
					if(($consulta2->rowCount())>=1){
						$alerta = [
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrio un error inesperado",
						"Texto"=>"El CORREO ingresado ya se encuentra registrado en el sistema",
						"Tipo"=>"error"
						];
					}
					else{*/
						
						
							$consulta4 = mainModel::ejecutar_consulta_simple("SELECT ID_ALUMNO FROM alumnos");

							$contador = ($consulta4->rowCount())+1;
							$codigo = mainModel::generar_codigo_aleatorio("ALU",5,$contador);
							$clave = mainModel::encryption($contraseña1);

							
								$datosAlumno=[
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
									"Codigo"=>$codigo,
									"Nomina1"=>$nomina1,
									"Nomina2"=>$nomina2,
									"Condicion"=>$condicion
								];

								$guardarAlumno=alumnoModelo::agregar_alumno_modelo($datosAlumno);
								if(($guardarAlumno->rowCount())>=1){
									$alerta = [
									"Alerta"=>"limpiar",
									"Titulo"=>"Alumno registrado",
									"Texto"=>"El alumno ha sido registrado en el sistema.",
									"Tipo"=>"success"
									];
								}
								else{
									$alerta = [
									"Alerta"=>"simple",
									"Titulo"=>"Ocurrio un error inesperado",
									"Texto"=>"No hemos podido registrar el alumno en el sistema.",
									"Tipo"=>"error"
									];
								}
							
							
						
					//}
				}
			
			return mainModel::sweet_alert($alerta);
		}

		public function paginador_alumno_controlador($pagina, $numRegistros, $privilegio, $codigoAdmin)
		{
			$pagina=mainModel::limpiar_cadena($pagina);
			$numRegistros=mainModel::limpiar_cadena($numRegistros);
			$privilegio=mainModel::limpiar_cadena($privilegio);
			$codigoAdmin=mainModel::limpiar_cadena($codigoAdmin);
			$tabla="";

			$pagina = (isset($pagina) && $pagina>0) ? (int) $pagina : 1;
			$inicio = ($pagina>0) ? (($pagina*$numRegistros)-$numRegistros) : 0;

			$conexion = mainModel::conectar();

			$datos = $conexion->prepare("
				SELECT SQL_CALC_FOUND_ROWS * FROM alumnos ORDER BY APELLIDOS_ALUMNO ASC LIMIT $inicio,$numRegistros
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
                            <th width="3%">Dni</th>
                            <th width="25%">Apellidos</th>
                            <th >Nombres</th>
                            <th width="2%">Sexo</th>';

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

            		$tabla.='
            		<tr>
                        <td class="align-middle">'.$contador.'</td>
                        <td class="align-middle">'.$row['DNI_ALUMNO'].'</td>
                        <td class="align-middle">'.$row['APELLIDOS_ALUMNO'].'</td>
                        <td class="align-middle">'.$row['NOMBRES_ALUMNO'].'</td>
                        <td class="align-middle">'.$row['SEXO_ALUMNO'].'</td>';

                        if($privilegio==2){
                        	$tabla.='                   
                        		<td>
                            		<a href="'.SERVERURL.'administradorAlumnoModificar/'.mainModel::encryption($row['CODIGO_CUENTA_ALUMNO']).'/" title="Editar datos" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                        		</td>
                        	';
                        }

                        if($privilegio==1){
                        	$tabla.='                   
                        		<td>
                            		<form  style="display:inline">
                        				<a href="'.SERVERURL.'administradorAlumnoModificar/'.mainModel::encryption($row['CODIGO_CUENTA_ALUMNO']).'/" title="Editar datos" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                        			</form>
                        			<form  action="'.SERVERURL.'ajax/alumnoAjax.php" method="POST" data-form="borrar" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data" style="display:inline">

                        				<input type="hidden" name="codigo-alumno" value="'.mainModel::encryption($row['CODIGO_CUENTA_ALUMNO']).'">

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
 							<td colspan="7" align="center">
 								<a href="'.SERVERURL.'administradorAlumnoTodos/">

 								</a>
 							</td>
                    	</tr>
            		';
            	}
            	else{
            		$tabla.='
            			<tr>
 							<td colspan="7" align="center">No hay registros para mostrar</td>
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
            		$tabla.='<li><a href="'.SERVERURL.'administradorAlumnoTodos/'.($pagina-1).'/"><i class="far fa-arrow-alt-circle-left"></i></a></li>';
            	}

            	for ($i=1; $i<=$numPaginas; $i++) { 
            		if($pagina==$i){
            			$tabla.='<li class="active"><a href="'.SERVERURL.'administradorAlumnoTodos/'.$i.'/">'.$i.'</a></li>';
            		}
            		else{
            			$tabla.='<li><a href="'.SERVERURL.'administradorAlumnoTodos/'.$i.'/">'.$i.'</a></li>';
            		}
            	}

				if($pagina==$numPaginas){
            		$tabla.='<li><a><i class="far fa-arrow-alt-circle-right"></i></a></li>';
            	}
            	else{
            		$tabla.='<li class="disabled"><a href="'.SERVERURL.'administradorAlumnoTodos/'.($pagina+1).'/"><i class="far fa-arrow-alt-circle-right"></i></a></li>';
            	}
            	$tabla.='</ul></nav></div>';
            }
			return $tabla;
		}

		public function eliminar_alumno_controlador(){
			$codigo=mainModel::decryption($_POST['codigo-alumno']);
			$privilegio=mainModel::decryption($_POST['privilegio-admin']);

			$codigo=mainModel::limpiar_cadena($codigo);
			$privilegio=mainModel::limpiar_cadena($privilegio);

			if($privilegio==1){
					$eliminarAlumno = alumnoModelo::eliminar_alumno_modelo($codigo);
					if($eliminarAlumno->rowCount()==1){
						$alerta = [
							"Alerta"=>"recargar",
							"Titulo"=>"Alumno eliminado",
							"Texto"=>"El alumno fue eliminado con éxito del sistema",
							"Tipo"=>"success"
						];
					}
					else{
						$alerta = [
							"Alerta"=>"simple",
							"Titulo"=>"Ocurrió un error inesperado",
							"Texto"=>"No se pudo eliminar al alumno del sistema",
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

		public function datos_alumno_controlador($codigo1){
			$codigo = mainModel::decryption($codigo1);
			return alumnoModelo::datos_alumno_modelo($codigo);
		}

		public function actualizar_alumno_controlador($codigo1)
		{
			$apellidos = mainModel::limpiar_cadena($_POST['apellidos-2']);
			$nombres = mainModel::limpiar_cadena($_POST['nombres-2']);
			$dni = mainModel::limpiar_cadena($_POST['dni-2']);
			$fechaNac = mainModel::limpiar_cadena($_POST['fecha-nacimiento-2']);
			$sexo = mainModel::limpiar_cadena($_POST['sexo-2']);
			$numero = mainModel::limpiar_cadena($_POST['numero-2']);
			$email = mainModel::limpiar_cadena($_POST['email-2']);
			$direccion = mainModel::limpiar_cadena($_POST['direccion-2']);
			$distrito = mainModel::limpiar_cadena($_POST['distrito-2']);
			$referencia = mainModel::limpiar_cadena($_POST['referencia-2']);
			$nomina1 = mainModel::limpiar_cadena($_POST['nomina12']);
			$nomina2 = mainModel::limpiar_cadena($_POST['nomina22']);
			$condicion = mainModel::limpiar_cadena($_POST['condicion-2']);
			
			$codigo=$codigo1;
			
			$datosAlumno=[
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
				"Codigo"=>$codigo,
				"Nomina1"=>$nomina1,
				"Nomina2"=>$nomina2,
				"Condicion"=>$condicion
			];

			$actualizarAlumno=alumnoModelo::actualizar_alumno_modelo($datosAlumno);
			if(($actualizarAlumno->rowCount())==1){
				$alerta = [
					"Alerta"=>"recargar",
				    "Titulo"=>"Alumno actualizado ",
					"Texto"=>"Los datos del alumno han sido actulizados en el sistema.",
					"Tipo"=>"success"
				];
			}
			else{
				$alerta = [
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrio un error inesperado",
					"Texto"=>"No hemos podido actualizar los datos del alumno en el sistema. 1",
					"Tipo"=>"error"
				];
			}
				
			return mainModel::sweet_alert($alerta);
		}

		public function cambiar_estado_controlador(){
			$codigoCambiado = mainModel::decryption($_POST['codigo-cambio']);
			$privilegioAdmin = mainModel::decryption($_POST['privilegio-admin']);

			$nuevoEstado = "";

			if($privilegioAdmin>2){
				$alerta = [
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrio un error inesperado",
					"Texto"=>"Su privilegio no le permite realizar esta operación.",
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