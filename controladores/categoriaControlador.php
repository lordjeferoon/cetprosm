<?php
	if ($peticionAjax) {
		require_once "../modelos/categoriaModelo.php";
	}
	else{
		require_once "modelos/categoriaModelo.php";
	}
  
	class categoriaControlador extends categoriaModelo
	{
		public function agregar_categoria_controlador()
		{
			$nombre1 = mainModel::limpiar_cadena($_POST['nombre1']);
			$nombre2 = mainModel::limpiar_cadena($_POST['nombre2']);
			$estado = $_POST['estado'];

			if($nombre1!=$nombre2){
				$alerta = [
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrio un error inesperado",
					"Texto"=>"Los nombres no coinciden, intente nuevamente",
					"Tipo"=>"error"
				];
			}
			else{
				$consulta1 = mainModel::ejecutar_consulta_simple("SELECT NOMBRE_CATEGORIA FROM categorias WHERE NOMBRE_CATEGORIA='$nombre1'");
				if(($consulta1->rowCount())>=1){
					$alerta = [
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrio un error inesperado",
					"Texto"=>"El Nombre ingresado ya se encuentra registrado en el sistema",
					"Tipo"=>"error"
					];
				}
				else{
					$datosCategoria=[
						"Nombre"=>$nombre1,
						"Estado"=>$estado
					];

					$guardarCategoria=categoriaModelo::agregar_categoria_modelo($datosCategoria);
					if(($guardarCategoria->rowCount())>=1){
						$alerta = [
							"Alerta"=>"limpiar",
							"Titulo"=>"Categoría registrada",
							"Texto"=>"La categoría ha sido registrada en el sistema.",
							"Tipo"=>"success"
						];
					}
					else{
						$alerta = [
							"Alerta"=>"simple",
							"Titulo"=>"Ocurrio un error inesperado",
							"Texto"=>"No hemos podido registrar la categoría en el sistema.",
							"Tipo"=>"error"
						];
					}
				}
			}
			return mainModel::sweet_alert($alerta);
		}

		public function paginador_categoria_controlador($pagina, $numRegistros, $privilegio, $codigoAdmin)
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
				SELECT SQL_CALC_FOUND_ROWS * FROM categorias ORDER BY NOMBRE_CATEGORIA ASC LIMIT $inicio,$numRegistros
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
                            <th>Categoría</th>
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
                        <td class="align-middle">'.$row['NOMBRE_CATEGORIA'].'</td>';

                        if($row['ESTADO_CATEGORIA']=="Activo"){
                        	$tabla.='<td class="align-middle"><span class="badge badge-success">&nbsp;'.$row['ESTADO_CATEGORIA'].'&nbsp;</span></td>';
                        }
                        else{
                        	$tabla.='<td class="align-middle"><span class="badge badge-secondary">'.$row['ESTADO_CATEGORIA'].'</span></td>';
                        }

                        if($privilegio==2){
                        	$tabla.='                   
                        		<td>
                            		<a href="'.SERVERURL.'administradorCategoriaModificar/'.mainModel::encryption($row['ID_CATEGORIA']).'/" title="Editar datos" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                        		</td>
                        	';
                        }

                        if($privilegio==1){
                        	$tabla.='                   
                        		<td>
                            		<form  style="display:inline">
                                        <a href="'.SERVERURL.'administradorCategoriaModificar/'.mainModel::encryption($row['ID_CATEGORIA']).'/" title="Editar datos" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                                    </form>
                                    <form  action="'.SERVERURL.'ajax/categoriaAjax.php" method="POST" data-form="borrar" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data" style="display:inline">

                                        <input type="hidden" name="codigo-categoria" value="'.mainModel::encryption($row['ID_CATEGORIA']).'">

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
 								<a href="'.SERVERURL.'administradorCategoriaTodos/">

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
            		$tabla.='<li><a href="'.SERVERURL.'administradorCategoriaTodos/'.($pagina-1).'/"><i class="far fa-arrow-alt-circle-left"></i></a></li>';
            	}

            	for ($i=1; $i<=$numPaginas; $i++) { 
            		if($pagina==$i){
            			$tabla.='<li class="active"><a href="'.SERVERURL.'administradorCategoriaTodos/'.$i.'/">'.$i.'</a></li>';
            		}
            		else{
            			$tabla.='<li><a href="'.SERVERURL.'administradorCategoriaTodos/'.$i.'/">'.$i.'</a></li>';
            		}
            	}

				if($pagina==$numPaginas){
            		$tabla.='<li><a><i class="far fa-arrow-alt-circle-right"></i></a></li>';
            	}
            	else{
            		$tabla.='<li class="disabled"><a href="'.SERVERURL.'administradorCategoriaTodos/'.($pagina+1).'/"><i class="far fa-arrow-alt-circle-right"></i></a></li>';
            	}
            	$tabla.='</ul></nav></div>';
            }
			return $tabla;
		}

        public function eliminar_categoria_controlador(){
            $codigo=mainModel::decryption($_POST['codigo-categoria']);
            $privilegio=mainModel::decryption($_POST['privilegio-admin']);

            $codigo=mainModel::limpiar_cadena($codigo);
            $privilegio=mainModel::limpiar_cadena($privilegio);

            if($privilegio==1){
                $a=mainModel::ejecutar_consulta_simple("DELETE FROM productos WHERE ID_CATEGORIA=$codigo");
                if($a->rowCount()>=1){
                    $eliminarCategoria = categoriaModelo::eliminar_categoria_modelo($codigo);
                    if($eliminarCategoria->rowCount()==1){
                        $alerta = [
                            "Alerta"=>"recargar",
                            "Titulo"=>"Categoría eliminada",
                            "Texto"=>"La categoría fue eliminada con éxito del sistema",
                            "Tipo"=>"success"
                        ];
                    }
                    else{
                        $alerta = [
                            "Alerta"=>"simple",
                            "Titulo"=>"Ocurrió un error inesperado",
                            "Texto"=>"No se pudo eliminar la categoría del sistema",
                            "Tipo"=>"error"
                        ];
                    }
                }
                else{
                    $alerta = [
                        "Alerta"=>"simple",
                        "Titulo"=>"Ocurrió un error inesperado",
                        "Texto"=>"No se pudo eliminar la categoría del sistema",
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

        public function datos_categoria_controlador($codigo1){
            $codigo = mainModel::decryption($codigo1);
            return categoriaModelo::datos_categoria_modelo($codigo);
        }

        public function actualizar_categoria_controlador($codigo)
        {
            $nombre1 = mainModel::limpiar_cadena($_POST['nombre1-2']);
            $nombre2 = mainModel::limpiar_cadena($_POST['nombre2-2']);
            $estado = $_POST['estado-2'];

            if($nombre1!=$nombre2){
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un error inesperado",
                    "Texto"=>"Las nombres no coinciden, intente nuevamente",
                    "Tipo"=>"error"
                ];
            }
            else{
                $consulta1 = mainModel::ejecutar_consulta_simple("SELECT NOMBRE_CATEGORIA FROM categorias WHERE NOMBRE_CATEGORIA='$nombre1' AND ID_CATEGORIA!=$codigo");
                if(($consulta1->rowCount())>=1){
                    $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un error inesperado",
                    "Texto"=>"El Nombre ingresado ya se encuentra registrado en el sistema",
                    "Tipo"=>"error"
                    ];
                }
                else{
                    $datosCategoria=[
                        "Nombre"=>$nombre1,
                        "Estado"=>$estado,
                        "Id"=>$codigo
                    ];

                    $actualizarCategoria=categoriaModelo::actualizar_categoria_modelo($datosCategoria);
                    if(($actualizarCategoria->rowCount())>=1){
                        $alerta = [
                            "Alerta"=>"recargar",
                            "Titulo"=>"Categoría Actualizada",
                            "Texto"=>"Los datos de la categoría han sido actualizados en el sistema.",
                            "Tipo"=>"success"
                        ];
                    }
                    else{
                        $alerta = [
                            "Alerta"=>"simple",
                            "Titulo"=>"Ocurrio un error inesperado",
                            "Texto"=>"No hemos podido actualizar los datos de la categoría en el sistema.",
                            "Tipo"=>"error"
                        ];
                    }
                }
            }
            return mainModel::sweet_alert($alerta);
        }
	}
?>