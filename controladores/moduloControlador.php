<?php
	if ($peticionAjax) {
		require_once "../modelos/moduloModelo.php";
	}
	else{
		require_once "modelos/moduloModelo.php";
	}
  
	class moduloControlador extends moduloModelo
	{
		public function agregar_modulo_controlador()
		{
			$nombre1 = mainModel::limpiar_cadena($_POST['nombre']);
			$estado = $_POST['estado'];
			$precio = $_POST['precio'];
            $meses = $_POST['meses'];
            $horas = $_POST['horas'];
			$especialidad = $_POST['especialidad'];

			if($especialidad!=""){
                $consulta1 = mainModel::ejecutar_consulta_simple("SELECT NOMBRE_MODULO FROM modulos WHERE NOMBRE_MODULO='$nombre1'");
                if(($consulta1->rowCount())>=1){
                    $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un error inesperado",
                    "Texto"=>"El Nombre ingresado ya se encuentra registrado en el sistema",
                    "Tipo"=>"error"
                    ];
                }
                else{
                    $datosModulo=[
                        "Nombre"=>$nombre1,
                        "Estado"=>$estado,
                        "Precio"=>$precio,
                        "Meses"=>$meses,
                        "Horas"=>$horas,
                        "Codigo"=>$especialidad
                    ];

                    $guardarModulo=moduloModelo::agregar_modulo_modelo($datosModulo);
                    if(($guardarModulo->rowCount())>=1){
                        $alerta = [
                            "Alerta"=>"limpiar",
                            "Titulo"=>"Módulo registrado",
                            "Texto"=>"El módulo ha sido registrado en el sistema.",
                            "Tipo"=>"success"
                        ];
                    }
                    else{
                        $alerta = [
                            "Alerta"=>"simple",
                            "Titulo"=>"Ocurrio un error inesperado",
                            "Texto"=>"No hemos podido registrar el módulo en el sistema.",
                            "Tipo"=>"error"
                        ];
                    }
                }
            }
            else{
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un error inesperado",
                    "Texto"=>"Debe registrar una especialidad para poder registrar uun módulo.",
                    "Tipo"=>"error"
                ];
            }

			return mainModel::sweet_alert($alerta);
		}

		public function paginador_modulo_controlador($pagina, $numRegistros, $privilegio, $codigoAdmin)
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
				SELECT SQL_CALC_FOUND_ROWS * FROM modulos ORDER BY ID_ESPECIALIDAD ASC, NOMBRE_MODULO ASC LIMIT $inicio,$numRegistros
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
                            <th>Módulo</th>
                            <th width="18%">D.Meses</th>
                            <th width="12%">D.Horas</th>
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

            		$codigo=$row['ID_ESPECIALIDAD'];
            		$consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM especialidades WHERE ID_ESPECIALIDAD='$codigo'");
            		$especialidad=$consulta->fetch();

            		$tabla.='
            		<tr>
                        <td class="align-middle">'.$contador.'</td>
                        <td class="align-middle">'.$row['NOMBRE_MODULO'].'</td>
                        <td class="align-middle">'.$row['DURACION_MESES'].'</td>
                        <td class="align-middle">'.$row['DURACION_HORAS'].'</td>
                        <td class="align-middle">'.$row['PRECIO_MODULO'].'</td>';

                        if($row['ESTADO_MODULO']=="Activo"){
                        	$tabla.='<td class="align-middle"><span class="badge badge-success">&nbsp;'.$row['ESTADO_MODULO'].'&nbsp;</span></td>';
                        }
                        else{
                        	$tabla.='<td class="align-middle"><span class="badge badge-secondary">'.$row['ESTADO_MODULO'].'</span></td>';
                        }

                        if($privilegio==2){
                        	$tabla.='                   
                        		<td>
                            		<a href="'.SERVERURL.'administradorModuloModificar/'.mainModel::encryption($row['ID_MODULO']).'/" title="Editar datos" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                        		</td>
                        	';
                        }

                        if($privilegio==1){
                        	$tabla.='                   
                        		<td>
                                    <form  style="display:inline">
                                        <a href="'.SERVERURL.'administradorModuloModificar/'.mainModel::encryption($row['ID_MODULO']).'/" title="Editar datos" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                                    </form>
                                    <form  action="'.SERVERURL.'ajax/moduloAjax.php" method="POST" data-form="borrar" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data" style="display:inline">

                                        <input type="hidden" name="codigo-modulo" value="'.mainModel::encryption($row['ID_MODULO']).'">

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
 							<td colspan="9" align="center">
 								<a href="'.SERVERURL.'administradorModuloTodos/">

 								</a>
 							</td>
                    	</tr>
            		';
            	}
            	else{
            		$tabla.='
            			<tr>
 							<td colspan="9" align="center">No hay registros para mostrar</td>
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
            		$tabla.='<li><a href="'.SERVERURL.'administradorModuloTodos/'.($pagina-1).'/"><i class="far fa-arrow-alt-circle-left"></i></a></li>';
            	}

            	for ($i=1; $i<=$numPaginas; $i++) { 
            		if($pagina==$i){
            			$tabla.='<li class="active"><a href="'.SERVERURL.'administradorModuloTodos/'.$i.'/">'.$i.'</a></li>';
            		}
            		else{
            			$tabla.='<li><a href="'.SERVERURL.'administradorModuloTodos/'.$i.'/">'.$i.'</a></li>';
            		}
            	}

				if($pagina==$numPaginas){
            		$tabla.='<li><a><i class="far fa-arrow-alt-circle-right"></i></a></li>';
            	}
            	else{
            		$tabla.='<li class="disabled"><a href="'.SERVERURL.'administradorModuloTodos/'.($pagina+1).'/"><i class="far fa-arrow-alt-circle-right"></i></a></li>';
            	}
            	$tabla.='</ul></nav></div>';
            }
			return $tabla;
		}

        public function eliminar_modulo_controlador(){
            $codigo=mainModel::decryption($_POST['codigo-modulo']);
            $privilegio=mainModel::decryption($_POST['privilegio-admin']);

            $codigo=mainModel::limpiar_cadena($codigo);
            $privilegio=mainModel::limpiar_cadena($privilegio);

            if($privilegio==1){
                $eliminarModulo = moduloModelo::eliminar_modulo_modelo($codigo);
                if($eliminarModulo->rowCount()==1){
                    $alerta = [
                        "Alerta"=>"recargar",
                        "Titulo"=>"Módulo eliminado",
                        "Texto"=>"El módulo fue eliminado con éxito del sistema",
                        "Tipo"=>"success"
                    ];
                }
                else{
                    $alerta = [
                        "Alerta"=>"simple",
                        "Titulo"=>"Ocurrió un error inesperado",
                        "Texto"=>"No se pudo eliminar el módulo del sistema",
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

        public function datos_modulo_controlador($codigo1){
            $codigo = mainModel::decryption($codigo1);
            return moduloModelo::datos_modulo_modelo($codigo);
        }

        public function actualizar_modulo_controlador($codigo)
        {
            $nombre1 = mainModel::limpiar_cadena($_POST['nombre-2']);
            $estado = $_POST['estado-2'];
            $precio = mainModel::limpiar_cadena($_POST['precio-2']);
            $meses =  mainModel::limpiar_cadena($_POST['meses-2']);
            $horas =  mainModel::limpiar_cadena($_POST['horas-2']);
            $especialidad = $_POST['especialidad-2'];

            if($especialidad!=""){
                $consulta1 = mainModel::ejecutar_consulta_simple("SELECT NOMBRE_MODULO FROM modulos WHERE NOMBRE_MODULO='$nombre1' AND ID_MODULO!=$codigo");
                if(($consulta1->rowCount())>=1){
                    $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un error inesperado",
                    "Texto"=>"El Nombre ingresado ya se encuentra registrado en el sistema",
                    "Tipo"=>"error"
                    ];
                }
                else{
                    $datosModulo=[
                        "Nombre"=>$nombre1,
                        "Estado"=>$estado,
                        "Precio"=>$precio,
                        "Meses"=>$meses,
                        "Horas"=>$horas,
                        "IdEspecialidad"=>$especialidad,
                        "Id"=>$codigo
                    ];

                    $actualizarModulo=moduloModelo::actualizar_modulo_modelo($datosModulo);
                    if(($actualizarModulo->rowCount())>=1){
                        $alerta = [
                            "Alerta"=>"recargar",
                            "Titulo"=>"Módulo actualizado",
                            "Texto"=>"El módulo ha sido actualizado en el sistema.",
                            "Tipo"=>"success"
                        ];
                    }
                    else{
                        $alerta = [
                            "Alerta"=>"simple",
                            "Titulo"=>"Ocurrio un error inesperado",
                            "Texto"=>"No hemos podido actualizar el módulo en el sistema.",
                            "Tipo"=>"error"
                        ];
                    }
                }
            }
            else{
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un error inesperado",
                    "Texto"=>"Debe registrar una especialidad para poder registrar uun módulo.",
                    "Tipo"=>"error"
                ];
            }

            return mainModel::sweet_alert($alerta);
        }
	}
?>