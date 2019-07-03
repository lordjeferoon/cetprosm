<?php
	if ($peticionAjax) {
		require_once "../modelos/productoModelo.php";
	}
	else{
		require_once "modelos/productoModelo.php";
	}
  
	class productoControlador extends productoModelo
	{
		public function agregar_producto_controlador()
		{
			$nombre1 = mainModel::limpiar_cadena($_POST['nombre']);
			$descripcion = mainModel::limpiar_cadena($_POST['descripcion']);
			$estado = $_POST['estado'];
			$precio = $_POST['precio'];
			$stock = $_POST['unidades'];
			$categoria = $_POST['categoria'];

            if($categoria!=""){
                $consulta1 = mainModel::ejecutar_consulta_simple("SELECT NOMBRE_PRODUCTO FROM productos WHERE NOMBRE_PRODUCTO='$nombre1'");
                if(($consulta1->rowCount())>=1){
                    $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un error inesperado",
                    "Texto"=>"El Nombre ingresado ya se encuentra registrado en el sistema",
                    "Tipo"=>"error"
                    ];
                }
                else{
                    $datosProducto=[
                        "Nombre"=>$nombre1,
                        "Descripcion"=>$descripcion,
                        "Estado"=>$estado,
                        "Precio"=>$precio,
                        "Stock"=>$stock,
                        "Categoria"=>$categoria
                    ];

                    $guardarProducto=productoModelo::agregar_producto_modelo($datosProducto);
                    if(($guardarProducto->rowCount())>=1){
                        $alerta = [
                            "Alerta"=>"limpiar",
                            "Titulo"=>"Producto registrado",
                            "Texto"=>"El producto ha sido registrado en el sistema.",
                            "Tipo"=>"success"
                        ];
                    }
                    else{
                        $alerta = [
                            "Alerta"=>"simple",
                            "Titulo"=>"Ocurrio un error inesperado",
                            "Texto"=>"No hemos podido registrar el producto en el sistema.",
                            "Tipo"=>"error"
                        ];
                    }
                }
            }
            else{
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un error inesperado",
                    "Texto"=>"Debe registrar una categoría para poder registrar un producto.",
                    "Tipo"=>"error"
                ];
            }

			return mainModel::sweet_alert($alerta);
		}

		public function paginador_producto_controlador($pagina, $numRegistros, $privilegio, $codigoAdmin)
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
				SELECT SQL_CALC_FOUND_ROWS * FROM productos ORDER BY NOMBRE_PRODUCTO ASC LIMIT $inicio,$numRegistros
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
                            <th>Producto</th>
                            <th width="28%">Categoría</th>
                            <th width="3%">Precio</th>
                            <th width="3%">Stock</th>
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

            		$codigo=$row['ID_CATEGORIA'];
            		$consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM categorias WHERE ID_CATEGORIA=$codigo");
            		$categoria=$consulta->fetch();

            		$tabla.='
            		<tr>
                        <td class="align-middle">'.$contador.'</td>
                        <td class="align-middle">'.$row['NOMBRE_PRODUCTO'].'</td>
                        <td class="align-middle">'.$categoria['NOMBRE_CATEGORIA'].'</td>
                        <td class="align-middle">'.$row['PRECIO_PRODUCTO'].'</td>
                        <td class="align-middle">'.$row['STOCK_PRODUCTO'].'</td>';

                        if($row['ESTADO_PRODUCTO']=="Activo"){
                        	$tabla.='<td class="align-middle"><span class="badge badge-success">&nbsp;'.$row['ESTADO_PRODUCTO'].'&nbsp;</span></td>';
                        }
                        else{
                        	$tabla.='<td class="align-middle"><span class="badge badge-secondary">'.$row['ESTADO_PRODUCTO'].'</span></td>';
                        }

                        if($privilegio==2){
                        	$tabla.='                   
                        		<td>
                            		<a href="'.SERVERURL.'administradorProductoModificar/'.mainModel::encryption($row['ID_PRODUCTO']).'/" title="Editar datos" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                        		</td>
                        	';
                        }

                        if($privilegio==1){
                        	$tabla.='                   
                        		<td>
                                    <form  style="display:inline">
                                        <a href="'.SERVERURL.'administradorProductoModificar/'.mainModel::encryption($row['ID_PRODUCTO']).'/" title="Editar datos" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                                    </form>
                                    <form  action="'.SERVERURL.'ajax/productoAjax.php" method="POST" data-form="borrar" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data" style="display:inline">

                                        <input type="hidden" name="codigo-producto" value="'.mainModel::encryption($row['ID_PRODUCTO']).'">

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
 								<a href="'.SERVERURL.'administradorProductoTodos/">

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
            		$tabla.='<li><a href="'.SERVERURL.'administradorProductoTodos/'.($pagina-1).'/"><i class="far fa-arrow-alt-circle-left"></i></a></li>';
            	}

            	for ($i=1; $i<=$numPaginas; $i++) { 
            		if($pagina==$i){
            			$tabla.='<li class="active"><a href="'.SERVERURL.'administradorProductoTodos/'.$i.'/">'.$i.'</a></li>';
            		}
            		else{
            			$tabla.='<li><a href="'.SERVERURL.'administradorProductoTodos/'.$i.'/">'.$i.'</a></li>';
            		}
            	}

				if($pagina==$numPaginas){
            		$tabla.='<li><a><i class="far fa-arrow-alt-circle-right"></i></a></li>';
            	}
            	else{
            		$tabla.='<li class="disabled"><a href="'.SERVERURL.'administradorProductoTodos/'.($pagina+1).'/"><i class="far fa-arrow-alt-circle-right"></i></a></li>';
            	}
            	$tabla.='</ul></nav></div>';
            }
			return $tabla;
		}

        public function eliminar_producto_controlador(){
            $codigo=mainModel::decryption($_POST['codigo-producto']);
            $privilegio=mainModel::decryption($_POST['privilegio-admin']);

            $codigo=mainModel::limpiar_cadena($codigo);
            $privilegio=mainModel::limpiar_cadena($privilegio);

            if($privilegio==1){
                $eliminarProducto = productoModelo::eliminar_producto_modelo($codigo);
                if($eliminarProducto->rowCount()==1){
                    $alerta = [
                        "Alerta"=>"recargar",
                        "Titulo"=>"Producto eliminado",
                        "Texto"=>"El producto fue eliminado con éxito del sistema",
                        "Tipo"=>"success"
                    ];
                }
                else{
                    $alerta = [
                        "Alerta"=>"simple",
                        "Titulo"=>"Ocurrió un error inesperado",
                        "Texto"=>"No se pudo eliminar el producto del sistema",
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

        public function datos_producto_controlador($codigo1){
            $codigo = mainModel::decryption($codigo1);
            return productoModelo::datos_producto_modelo($codigo);
        }

        public function actualizar_producto_controlador($codigo)
        {
            $nombre1 = mainModel::limpiar_cadena($_POST['nombre-2']);
            $descripcion = mainModel::limpiar_cadena($_POST['descripcion-2']);
            $estado = $_POST['estado-2'];
            $precio = $_POST['precio-2'];
            $stock = $_POST['unidades-2'];
            $categoria = $_POST['categoria-2'];

            if($categoria!=""){
                $consulta1 = mainModel::ejecutar_consulta_simple("SELECT NOMBRE_PRODUCTO FROM productos WHERE NOMBRE_PRODUCTO='$nombre1' AND ID_PRODUCTO!=$codigo");
                if(($consulta1->rowCount())>=1){
                    $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un error inesperado",
                    "Texto"=>"El Nombre ingresado ya se encuentra registrado en el sistema",
                    "Tipo"=>"error"
                    ];
                }
                else{
                    $datosProducto=[
                        "Nombre"=>$nombre1,
                        "Descripcion"=>$descripcion,
                        "Estado"=>$estado,
                        "Precio"=>$precio,
                        "Stock"=>$stock,
                        "IdCategoria"=>$categoria,
                        "Id"=>$codigo
                    ];

                    $actualizarProducto=productoModelo::actualizar_producto_modelo($datosProducto);
                    if(($actualizarProducto->rowCount())>=1){
                        $alerta = [
                            "Alerta"=>"recargar",
                            "Titulo"=>"Producto actualizado",
                            "Texto"=>"El producto ha sido actualizado en el sistema.",
                            "Tipo"=>"success"
                        ];
                    }
                    else{
                        $alerta = [
                            "Alerta"=>"simple",
                            "Titulo"=>"Ocurrio un error inesperado",
                            "Texto"=>"No hemos podido actualizar el producto en el sistema.",
                            "Tipo"=>"error"
                        ];
                    }
                }
            }
            else{
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un error inesperado",
                    "Texto"=>"Debe registrar una categoría para poder registrar un producto.",
                    "Tipo"=>"error"
                ];
            }
                
            return mainModel::sweet_alert($alerta);
        }
	}
?>