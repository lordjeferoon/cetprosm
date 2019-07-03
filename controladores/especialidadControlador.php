<?php
	if ($peticionAjax) {
		require_once "../modelos/especialidadModelo.php";
	}
	else{
		require_once "modelos/especialidadModelo.php";
	}
  
	class especialidadControlador extends especialidadModelo
	{
		public function agregar_especialidad_controlador()
		{
			$nombre1 = mainModel::limpiar_cadena($_POST['nombre1']);
			$nombre2 = mainModel::limpiar_cadena($_POST['nombre2']);
			$estado = $_POST['estado'];
			$precio = mainModel::limpiar_cadena($_POST['precio']);

			if($nombre1!=$nombre2){
				$alerta = [
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrio un error inesperado",
					"Texto"=>"Las nombres no coinciden, intente nuevamente",
					"Tipo"=>"error"
				];
			}
			else{
				$consulta1 = mainModel::ejecutar_consulta_simple("SELECT NOMBRE_ESPECIALIDAD FROM especialidades WHERE NOMBRE_ESPECIALIDAD='$nombre1'");
				if(($consulta1->rowCount())>=1){
					$alerta = [
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrio un error inesperado",
					"Texto"=>"El Nombre ingresado ya se encuentra registrado en el sistema",
					"Tipo"=>"error"
					];
				}
				else{
					$datosEspecialidad=[
						"Nombre"=>$nombre1,
						"Estado"=>$estado,
						"Precio"=>$precio
					];

					$guardarEspecialidad=especialidadModelo::agregar_especialidad_modelo($datosEspecialidad);
					if(($guardarEspecialidad->rowCount())>=1){
						$alerta = [
							"Alerta"=>"limpiar",
							"Titulo"=>"Especialidad registrada",
							"Texto"=>"La especialidad ha sido registrada en el sistema.",
							"Tipo"=>"success"
						];
					}
					else{
						$alerta = [
							"Alerta"=>"simple",
							"Titulo"=>"Ocurrio un error inesperado",
							"Texto"=>"No hemos podido registrar la especialidad en el sistema.",
							"Tipo"=>"error"
						];
					}
				}
			}
			return mainModel::sweet_alert($alerta);
		}

		public function paginador_especialidad_controlador($pagina, $numRegistros, $privilegio, $codigoAdmin)
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
				SELECT SQL_CALC_FOUND_ROWS * FROM especialidades ORDER BY NOMBRE_ESPECIALIDAD ASC LIMIT $inicio,$numRegistros
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
                            <th>Especialidad</th>
                            <th width="3%">Precio</th>
                            <th width="4%">Estado</th>';

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
                        <td class="align-middle">'.$row['NOMBRE_ESPECIALIDAD'].'</td>
                        <td class="align-middle">'.$row['PRECIO_ESPECIALIDAD'].'</td>';

                        if($row['ESTADO_ESPECIALIDAD']=="Activo"){
                        	$tabla.='<td class="align-middle"><span class="badge badge-success">&nbsp;'.$row['ESTADO_ESPECIALIDAD'].'&nbsp;</span></td>';
                        }
                        else{
                        	$tabla.='<td class="align-middle"><span class="badge badge-secondary">'.$row['ESTADO_ESPECIALIDAD'].'</span></td>';
                        }

                        if($privilegio==2){
                        	$tabla.='                   
                        		<td>
                            		<a href="'.SERVERURL.'administradorEspecialidadModificar/'.mainModel::encryption($row['ID_ESPECIALIDAD']).'/" title="Editar datos" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                        		</td>
                        	';
                        }

                        if($privilegio==1){
                        	$tabla.='                   
                        		<td>
                            		<form  style="display:inline">
                        				<a href="'.SERVERURL.'administradorEspecialidadModificar/'.mainModel::encryption($row['ID_ESPECIALIDAD']).'/" title="Editar datos" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                        			</form>
                        			<form  action="'.SERVERURL.'ajax/especialidadAjax.php" method="POST" data-form="borrar" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data" style="display:inline">

                        				<input type="hidden" name="codigo-especialidad" value="'.mainModel::encryption($row['ID_ESPECIALIDAD']).'">

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
 								<a href="'.SERVERURL.'administradorEspecialidadTodos/">

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
            		$tabla.='<li><a href="'.SERVERURL.'administradorEspecialidadTodos/'.($pagina-1).'/"><i class="far fa-arrow-alt-circle-left"></i></a></li>';
            	}

            	for ($i=1; $i<=$numPaginas; $i++) { 
            		if($pagina==$i){
            			$tabla.='<li class="active"><a href="'.SERVERURL.'administradorEspecialidadTodos/'.$i.'/">'.$i.'</a></li>';
            		}
            		else{
            			$tabla.='<li><a href="'.SERVERURL.'administradorEspecialidadTodos/'.$i.'/">'.$i.'</a></li>';
            		}
            	}

				if($pagina==$numPaginas){
            		$tabla.='<li><a><i class="far fa-arrow-alt-circle-right"></i></a></li>';
            	}
            	else{
            		$tabla.='<li class="disabled"><a href="'.SERVERURL.'administradorEspecialidadTodos/'.($pagina+1).'/"><i class="far fa-arrow-alt-circle-right"></i></a></li>';
            	}
            	$tabla.='</ul></nav></div>';
            }
			return $tabla;
		}

		public function carga_docente_controlador($pagina, $numRegistros, $privilegio, $codigoAdmin)
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
				SELECT SQL_CALC_FOUND_ROWS * FROM especialidades WHERE ESTADO_ESPECIALIDAD='Activo' ORDER BY NOMBRE_ESPECIALIDAD ASC LIMIT $inicio,$numRegistros
			");
			$datos->execute();
			$datos = $datos->fetchAll();

			$total = $conexion->query("SELECT FOUND_ROWS()");
			$total = (int) $total->fetchColumn();

			$numPaginas = ceil($total/$numRegistros);

            if($total>=1 && $pagina<=$numPaginas){
            	$contador = $inicio+1;
            	foreach ($datos as $row) {

            		$tabla.='<div class="text-center">
                    			<h4>'.$row['NOMBRE_ESPECIALIDAD'].'</h2>
                			</div>';

            		$tabla.='
						<table class="table table-hover table-sm table-responsive">
		                    <thead class="table-secondary">
		                        <tr>
		                            <th width="1%">No</th>
		                            <th>Módulo</th>
		                            <th width="25%">Docente</th>
		                            <th width="10%">Frecuencia</th>
		                            <th width="14%">Horario</th>
		                            <th width="11%">Inicio/Fin</th>
		                            <th width="16%">Duracion</th>
		                         </tr>
		                    </thead>
		                    <tbody>'
		            ;
		            $codEspecialidad=$row['ID_ESPECIALIDAD'];
		            $mod = $conexion->prepare("
						SELECT * FROM MODULOS WHERE ID_ESPECIALIDAD=$codEspecialidad
					");
					$mod->execute();
					$mod = $mod->fetchAll();
					$total2 = $conexion->query("SELECT FOUND_ROWS()");
					$total2 = (int) $total2->fetchColumn();
					if($total2==0){
						$tabla.='
	            			<tr>
	 							<td colspan="7" align="center">No hay registros para mostrar</td>
	                    	</tr>
	            		';
					}
					else{
						$indice=1;
						foreach ($mod as $modulo) {

							$codModulo=$modulo['ID_MODULO'];
							$asig = $conexion->prepare("
								SELECT * FROM asignaciones WHERE ID_MODULO=$codModulo ORDER BY GRUPO
							");
							$asig->execute();
							$asig = $asig->fetchAll();
							$total3 = $conexion->query("SELECT FOUND_ROWS()");
							$total3 = (int) $total3->fetchColumn();

							$tabla.='
								<tr>
									<td class="align-middle">'.$indice.'</td>
									<td class="align-middle">'.$modulo['NOMBRE_MODULO'].'</td>
							';

							if($total3==0){
								$tabla.='
									<td class="align-middle" colspan="4" align="center">NO ASIGNADOS</td>
								';
							}
							else{
								$contenido='';
								$contenido2='';
								$hora='';
								foreach ($asig as $asignacion) {
									$codDocente=$asignacion['ID_DOCENTE'];
									$docente = $conexion->prepare("
										SELECT * FROM docentes WHERE ID_DOCENTE=$codDocente
									");
									$docente->execute();
									$docente = $docente->fetch();
									$contenido.='
										G'.$asignacion['GRUPO'].' '.$docente['APELLIDOS_DOCENTE'].'<br>  
									';


									$codFre=$asignacion['ID_FRECUENCIA'];
									$frecuencia = $conexion->prepare("
										SELECT * FROM frecuencias WHERE ID_FRECUENCIA=$codFre
									");
									$frecuencia->execute();
									$frecuencia = $frecuencia->fetch();
									$contenido2.='
										'.$frecuencia['NOMBRE_FRECUENCIA'].'<br>  
									';


									$hi=$asignacion['HORA_INICIO'];
									$hf=$asignacion['HORA_FIN'];
									$hi=substr($hi,0,5);
									$hf=substr($hf,0,5);
									//echo $inicio.' '.$final;
									if($asignacion['TURNO']=="M"){
										$hora.=$hi.'-'.$hf.'AM <br>';
									}
									else{
										$hora.=$hi.'-'.$hf.'PM <br>';
									}
								}

								$tabla.='
									<td class="align-middle">'.$contenido.'</td>
								';

								$tabla.='
									<td class="align-middle">'.$contenido2.'</td>
								';

								$tabla.='
									<td class="align-middle">'.$hora.'</td>
								';

								$fecha=$asignacion['FECHA_INICIO'].' <br> '.$asignacion['FECHA_FIN'] ;
								$tabla.='
									<td class="align-middle">'.$fecha.'</td>
								';
							}

							$duracion=$modulo['DURACION_MESES'].' <br> '.$modulo['DURACION_HORAS'];
							$tabla.='
									<td class="align-middle">'.$duracion.'</td>
								</tr>
							';
							$indice++;
						}
					}
            		$contador++;
            	}
            }
            else{
            	if($total>=1){
            		$tabla.='
            			<tr>
 							<td colspan="7" align="center">
 								<a href="'.SERVERURL.'administradorReporteCargaDocente/">

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
            		$tabla.='<li><a href="'.SERVERURL.'administradorReporteCargaDocente/'.($pagina-1).'/"><i class="far fa-arrow-alt-circle-left"></i></a></li>';
            	}

            	for ($i=1; $i<=$numPaginas; $i++) { 
            		if($pagina==$i){
            			$tabla.='<li class="active"><a href="'.SERVERURL.'administradorReporteCargaDocente/'.$i.'/">'.$i.'</a></li>';
            		}
            		else{
            			$tabla.='<li><a href="'.SERVERURL.'administradorReporteCargaDocente/'.$i.'/">'.$i.'</a></li>';
            		}
            	}

				if($pagina==$numPaginas){
            		$tabla.='<li><a><i class="far fa-arrow-alt-circle-right"></i></a></li>';
            	}
            	else{
            		$tabla.='<li class="disabled"><a href="'.SERVERURL.'administradorReporteCargaDocente/'.($pagina+1).'/"><i class="far fa-arrow-alt-circle-right"></i></a></li>';
            	}
            	$tabla.='</ul></nav></div>';
            }
			return $tabla;
		}

		public function eliminar_especialidad_controlador(){
			$codigo=mainModel::decryption($_POST['codigo-especialidad']);
			$privilegio=mainModel::decryption($_POST['privilegio-admin']);

			$codigo=mainModel::limpiar_cadena($codigo);
			$privilegio=mainModel::limpiar_cadena($privilegio);

			if($privilegio==1){
				$a=mainModel::ejecutar_consulta_simple("DELETE FROM modulos WHERE ID_ESPECIALIDAD=$codigo");
				if($a->rowCount()>=1){
					$eliminarEspecialidad = especialidadModelo::eliminar_especialidad_modelo($codigo);
					if($eliminarEspecialidad->rowCount()==1){
						$alerta = [
							"Alerta"=>"recargar",
							"Titulo"=>"Especialidad eliminada",
							"Texto"=>"La especialidad fue eliminada con éxito del sistema",
							"Tipo"=>"success"
						];
					}
					else{
						$alerta = [
							"Alerta"=>"simple",
							"Titulo"=>"Ocurrió un error inesperado",
							"Texto"=>"No se pudo eliminar la especialidad del sistema",
							"Tipo"=>"error"
						];
					}
				}
				else{
					$alerta = [
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrió un error inesperado",
						"Texto"=>"No se pudo eliminar la especialidad del sistema",
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

		public function datos_especialidad_controlador($codigo1){
			$codigo = mainModel::decryption($codigo1);
			return especialidadModelo::datos_especialidad_modelo($codigo);
		}

		public function actualizar_especialidad_controlador($codigo)
		{
			$nombre1 = mainModel::limpiar_cadena($_POST['nombre1-2']);
			$nombre2 = mainModel::limpiar_cadena($_POST['nombre2-2']);
			$estado = $_POST['estado-2'];
			$precio = mainModel::limpiar_cadena($_POST['precio-2']);

			if($nombre1!=$nombre2){
				$alerta = [
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrio un error inesperado",
					"Texto"=>"Las nombres no coinciden, intente nuevamente",
					"Tipo"=>"error"
				];
			}
			else{
				$consulta1 = mainModel::ejecutar_consulta_simple("SELECT NOMBRE_ESPECIALIDAD FROM especialidades WHERE NOMBRE_ESPECIALIDAD='$nombre1' AND ID_ESPECIALIDAD!=$codigo");
				if(($consulta1->rowCount())>=1){
					$alerta = [
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrio un error inesperado",
					"Texto"=>"El Nombre ingresado ya se encuentra registrado en el sistema",
					"Tipo"=>"error"
					];
				}
				else{
					$datosEspecialidad=[
						"Nombre"=>$nombre1,
						"Estado"=>$estado,
						"Precio"=>$precio,
						"Id"=>$codigo
					];

					$actualizarEspecialidad=especialidadModelo::actualizar_especialidad_modelo($datosEspecialidad);
					if(($actualizarEspecialidad->rowCount())>=1){
						$alerta = [
							"Alerta"=>"recargar",
							"Titulo"=>"Especialidad Actualizada",
							"Texto"=>"Los datos de la especialidad han sido actualizados en el sistema.",
							"Tipo"=>"success"
						];
					}
					else{
						$alerta = [
							"Alerta"=>"simple",
							"Titulo"=>"Ocurrio un error inesperado",
							"Texto"=>"No hemos podido actualizar los datos de la especialidad en el sistema.",
							"Tipo"=>"error"
						];
					}
				}
			}
			return mainModel::sweet_alert($alerta);
		}
	}
?>