<?php
	if ($peticionAjax) {
		require_once "../modelos/frecuenciaModelo.php";
	}
	else{
		require_once "modelos/frecuenciaModelo.php";
	}
  
	class frecuenciaControlador extends frecuenciaModelo
	{
		public function agregar_frecuencia_controlador()
		{
			$nombre1 = mainModel::limpiar_cadena($_POST['nombre1']);
			$nombre2 = mainModel::limpiar_cadena($_POST['nombre2']);
			$estado = $_POST['estado'];

			if($nombre1!=$nombre2){
				$alerta = [
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrio un error inesperado",
					"Texto"=>"Las frecuencias no coinciden, intente nuevamente",
					"Tipo"=>"error"
				];
			}
			else{
				$consulta1 = mainModel::ejecutar_consulta_simple("SELECT NOMBRE_FRECUENCIA FROM frecuencias WHERE NOMBRE_FRECUENCIA='$nombre1'");
				if(($consulta1->rowCount())>=1){
					$alerta = [
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrio un error inesperado",
					"Texto"=>"La frecuencia ingresada ya se encuentra registrada en el sistema",
					"Tipo"=>"error"
					];
				}
				else{
					$datosFrecuencia=[
						"Nombre"=>$nombre1,
						"Estado"=>$estado
					];

					$guardarFrecuencia=frecuenciaModelo::agregar_frecuencia_modelo($datosFrecuencia);
					if(($guardarFrecuencia->rowCount())>=1){
						$alerta = [
							"Alerta"=>"limpiar",
							"Titulo"=>"Frecuencia registrada",
							"Texto"=>"La frecuencia ha sido registrada en el sistema.",
							"Tipo"=>"success"
						];
					}
					else{
						$alerta = [
							"Alerta"=>"simple",
							"Titulo"=>"Ocurrio un error inesperado",
							"Texto"=>"No hemos podido registrar la frecuencia en el sistema.",
							"Tipo"=>"error"
						];
					}
				}
			}
			return mainModel::sweet_alert($alerta);
		}

		public function paginador_frecuencia_controlador($pagina, $numRegistros, $privilegio, $codigoAdmin)
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
				SELECT SQL_CALC_FOUND_ROWS * FROM frecuencias ORDER BY NOMBRE_FRECUENCIA ASC LIMIT $inicio,$numRegistros
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
                            <th width="5%">No</th>
                            <th>Frecuencia</th>
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
                        <td class="align-middle">'.$row['NOMBRE_FRECUENCIA'].'</td>';

                        if($row['ESTADO_FRECUENCIA']=="Activo"){
                        	$tabla.='<td class="align-middle"><span class="badge badge-success">&nbsp;'.$row['ESTADO_FRECUENCIA'].'&nbsp;</span></td>';
                        }
                        else{
                        	$tabla.='<td class="align-middle"><span class="badge badge-secondary">'.$row['ESTADO_FRECUENCIA'].'</span></td>';
                        }

                        if($privilegio==2){
                        	$tabla.='                   
                        		<td>
                            		<a href="'.SERVERURL.'administradorFrecuenciaModificar/'.mainModel::encryption($row['ID_FRECUENCIA']).'/" title="Editar datos" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                        		</td>
                        	';
                        }

                        if($privilegio==1){
                        	$tabla.='                   
                        		<td>
                            		<form  style="display:inline">
                                        <a href="'.SERVERURL.'administradorFrecuenciaModificar/'.mainModel::encryption($row['ID_FRECUENCIA']).'/" title="Editar datos" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                                    </form>
                                    <form  action="'.SERVERURL.'ajax/frecuenciaAjax.php" method="POST" data-form="borrar" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data" style="display:inline">

                                        <input type="hidden" name="codigo-frecuencia" value="'.mainModel::encryption($row['ID_FRECUENCIA']).'">

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
 							<td colspan="4" align="center">
 								<a href="'.SERVERURL.'administradorFrecuenciaTodos/">

 								</a>
 							</td>
                    	</tr>
            		';
            	}
            	else{
            		$tabla.='
            			<tr>
 							<td colspan="4" align="center">No hay registros para mostrar</td>
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
            		$tabla.='<li><a href="'.SERVERURL.'administradorFrecuenciaTodos/'.($pagina-1).'/"><i class="far fa-arrow-alt-circle-left"></i></a></li>';
            	}

            	for ($i=1; $i<=$numPaginas; $i++) { 
            		if($pagina==$i){
            			$tabla.='<li class="active"><a href="'.SERVERURL.'administradorFrecuenciaTodos/'.$i.'/">'.$i.'</a></li>';
            		}
            		else{
            			$tabla.='<li><a href="'.SERVERURL.'administradorFrecuenciaTodos/'.$i.'/">'.$i.'</a></li>';
            		}
            	}

				if($pagina==$numPaginas){
            		$tabla.='<li><a><i class="far fa-arrow-alt-circle-right"></i></a></li>';
            	}
            	else{
            		$tabla.='<li class="disabled"><a href="'.SERVERURL.'administradorFrecuenciaTodos/'.($pagina+1).'/"><i class="far fa-arrow-alt-circle-right"></i></a></li>';
            	}
            	$tabla.='</ul></nav></div>';
            }
			return $tabla;
		}

        public function eliminar_frecuencia_controlador(){
            $codigo=mainModel::decryption($_POST['codigo-frecuencia']);
            $privilegio=mainModel::decryption($_POST['privilegio-admin']);

            $codigo=mainModel::limpiar_cadena($codigo);
            $privilegio=mainModel::limpiar_cadena($privilegio);

            if($privilegio==1){
                $eliminarFrecuencia = frecuenciaModelo::eliminar_frecuencia_modelo($codigo);
                if($eliminarFrecuencia->rowCount()==1){
                    $alerta = [
                        "Alerta"=>"recargar",
                        "Titulo"=>"Frecuencia eliminada",
                        "Texto"=>"La frecuencia fue eliminada con éxito del sistema",
                        "Tipo"=>"success"
                    ];
                }
                else{
                    $alerta = [
                        "Alerta"=>"simple",
                        "Titulo"=>"Ocurrió un error inesperado",
                        "Texto"=>"No se pudo eliminar la frecuencia del sistema",
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

        public function datos_frecuencia_controlador($codigo1){
            $codigo = mainModel::decryption($codigo1);
            return frecuenciaModelo::datos_frecuencia_modelo($codigo);
        }

        public function actualizar_frecuencia_controlador($codigo)
        {
            $nombre1 = mainModel::limpiar_cadena($_POST['nombre1-2']);
            $nombre2 = mainModel::limpiar_cadena($_POST['nombre2-2']);
            $estado = $_POST['estado-2'];

            if($nombre1!=$nombre2){
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un error inesperado",
                    "Texto"=>"Las frecuencias no coinciden, intente nuevamente",
                    "Tipo"=>"error"
                ];
            }
            else{
                $consulta1 = mainModel::ejecutar_consulta_simple("SELECT NOMBRE_FRECUENCIA FROM frecuencias WHERE NOMBRE_FRECUENCIA='$nombre1' AND ID_FRECUENCIA!=$codigo");
                if(($consulta1->rowCount())>=1){
                    $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un error inesperado",
                    "Texto"=>"La frecuencia ingresada ya se encuentra registrada en el sistema",
                    "Tipo"=>"error"
                    ];
                }
                else{
                    $datosFrecuencia=[
                        "Nombre"=>$nombre1,
                        "Estado"=>$estado,
                        "Id"=>$codigo
                    ];

                    $actualizarFrecuencia=frecuenciaModelo::actualizar_frecuencia_modelo($datosFrecuencia);
                    if(($actualizarFrecuencia->rowCount())>=1){
                        $alerta = [
                            "Alerta"=>"recargar",
                            "Titulo"=>"Frecuencia actualizada",
                            "Texto"=>"La frecuencia ha sido actualizada en el sistema.",
                            "Tipo"=>"success"
                        ];
                    }
                    else{
                        $alerta = [
                            "Alerta"=>"simple",
                            "Titulo"=>"Ocurrio un error inesperado",
                            "Texto"=>"No hemos podido actualizar la frecuencia en el sistema.",
                            "Tipo"=>"error"
                        ];
                    }
                }
            }
            return mainModel::sweet_alert($alerta);
        }
	}
?>