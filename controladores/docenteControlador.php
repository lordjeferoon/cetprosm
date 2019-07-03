<?php
	if ($peticionAjax) {
		require_once "../modelos/docenteModelo.php";
	}
	else{
		require_once "modelos/docenteModelo.php";
	}
  
	class docenteControlador extends docenteModelo
	{
		public function agregar_docente_controlador()
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

			if($sexo=="M"){
				$foto="adminHombre.jpg";
			}
			else{
				$foto="adminMujer.jpg";
			}

			if($contraseña1!=$contraseña2){
				$alerta = [
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrio un error inesperado",
					"Texto"=>"Las contraseñas no coinciden, intente nuevamente",
					"Tipo"=>"error"
				];
			}
			else{
				$consulta1 = mainModel::ejecutar_consulta_simple("SELECT DNI_DOCENTE FROM docentes WHERE DNI_DOCENTE='$dni'");
				if(($consulta1->rowCount())>=1){
					$alerta = [
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrio un error inesperado",
					"Texto"=>"El DNI ingresado ya se encuentra registrado en el sistema",
					"Tipo"=>"error"
					];
				}
				else{
					$consulta2 = mainModel::ejecutar_consulta_simple("SELECT CORREO_DOCENTE FROM docentes WHERE CORREO_DOCENTE='$email'");
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
							$consulta4 = mainModel::ejecutar_consulta_simple("SELECT ID_DOCENTE FROM docentes");

							$contador = ($consulta4->rowCount())+1;
							$codigo = mainModel::generar_codigo_aleatorio("DOC",5,$contador);
							$clave = mainModel::encryption($contraseña1);

							$datosCuenta=[
								"Codigo"=>$codigo,
								"Usuario"=>$usuario,
								"Contrasena"=>$clave,
								"Tipo"=>"Docente",
								"Estado"=>$estado,
								"Privilegio"=>2,
								"Foto"=>$foto
							];

							$guardarCuenta=mainModel::agregar_cuenta($datosCuenta);

							if(($guardarCuenta->rowCount())>=1){
								$datosDocente=[
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

								$guardarDocente=docenteModelo::agregar_docente_modelo($datosDocente);
								if(($guardarDocente->rowCount())>=1){
									$alerta = [
									"Alerta"=>"limpiar",
									"Titulo"=>"Docente registrado",
									"Texto"=>"El docente ha sido registrado en el sistema.",
									"Tipo"=>"success"
									];
								}
								else{
									mainModel::eliminar_cuenta($codigo);
									$alerta = [
									"Alerta"=>"simple",
									"Titulo"=>"Ocurrio un error inesperado",
									"Texto"=>"No hemos podido registrar al profesor en el sistema.",
									"Tipo"=>"error"
									];
								}
							}
							else{
								$alerta = [
								"Alerta"=>"simple",
								"Titulo"=>"Ocurrio un error inesperado",
								"Texto"=>"No hemos podido registrar al profesor en el sistema.",
								"Tipo"=>"error"
								];
							}
						}
					}
				}
			}
			return mainModel::sweet_alert($alerta);
		}

		public function paginador_docente_controlador($pagina, $numRegistros, $privilegio, $codigoAdmin)
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
				SELECT SQL_CALC_FOUND_ROWS * FROM docentes ORDER BY APELLIDOS_DOCENTE ASC LIMIT $inicio,$numRegistros
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
                            <th width="2%">Sexo</th>
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

            		$codigo=$row['CODIGO_CUENTA_DOCENTE'];
            		$consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM cuentas WHERE CODIGO='$codigo'");
            		$cuenta=$consulta->fetch();

            		$tabla.='
            		<tr>
                        <td class="align-middle">'.$contador.'</td>
                        <td class="align-middle">'.$row['DNI_DOCENTE'].'</td>
                        <td class="align-middle">'.$row['APELLIDOS_DOCENTE'].'</td>
                        <td class="align-middle">'.$row['NOMBRES_DOCENTE'].'</td>
                        <td class="align-middle">'.$row['SEXO_DOCENTE'].'</td>';

                        if($cuenta['ESTADO']=="Activo"){
                        	$tabla.='<td class="align-middle">
                        		<span class="badge badge-success">&nbsp;'.$cuenta['ESTADO'].'&nbsp;</span>
                        		<form  action="'.SERVERURL.'ajax/docenteAjax.php" method="POST" data-form="actualizar" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data" style="display:inline">

                        				<input type="hidden" name="codigo-cambio" value="'.mainModel::encryption($row['CODIGO_CUENTA_DOCENTE']).'">

                        				<input type="hidden" name="privilegio-admin" value="'.mainModel::encryption($privilegio).'">

                        				<button type="submit" class="btn btn-primary btn-sm" title="Cambiar Estado"><i class="fas fa-exchange-alt"></i></button>

                        				<div class="RespuestaAjax"></div>
                        		</form>
                        	</td>';
                        }
                        else{
                        	$tabla.='<td class="align-middle">
                        		<span class="badge badge-secondary">'.$cuenta['ESTADO'].'</span>
                        		<form  action="'.SERVERURL.'ajax/docenteAjax.php" method="POST" data-form="actualizar" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data" style="display:inline">

                        				<input type="hidden" name="codigo-cambio" value="'.mainModel::encryption($row['CODIGO_CUENTA_DOCENTE']).'">

                        				<input type="hidden" name="privilegio-admin" value="'.mainModel::encryption($privilegio).'">

                        				<button type="submit" class="btn btn-primary btn-sm" title="Cambiar Estado"><i class="fas fa-exchange-alt"></i></button>

                        				<div class="RespuestaAjax"></div>
                        		</form>
                        	</td>';
                        }

                        if($privilegio==2){
                        	$tabla.='                   
                        		<td>
                            		<a href="'.SERVERURL.'administradorProfesorModificar/'.mainModel::encryption($row['CODIGO_CUENTA_DOCENTE']).'/" title="Editar datos" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                        		</td>
                        	';
                        }

                        if($privilegio==1){
                        	$tabla.='                   
                        		<td>
                            		<form  style="display:inline">
                        				<a href="'.SERVERURL.'administradorProfesorModificar/'.mainModel::encryption($row['CODIGO_CUENTA_DOCENTE']).'/" title="Editar datos" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                        			</form>
                        			<form  action="'.SERVERURL.'ajax/docenteAjax.php" method="POST" data-form="borrar" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data" style="display:inline">

                        				<input type="hidden" name="codigo-docente" value="'.mainModel::encryption($row['CODIGO_CUENTA_DOCENTE']).'">

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
 								<a href="'.SERVERURL.'administradorProfesorTodos/">

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
            		$tabla.='<li><a href="'.SERVERURL.'administradorProfesorTodos/'.($pagina-1).'/"><i class="far fa-arrow-alt-circle-left"></i></a></li>';
            	}

            	for ($i=1; $i<=$numPaginas; $i++) { 
            		if($pagina==$i){
            			$tabla.='<li class="active"><a href="'.SERVERURL.'administradorProfesorTodos/'.$i.'/">'.$i.'</a></li>';
            		}
            		else{
            			$tabla.='<li><a href="'.SERVERURL.'administradorProfesorTodos/'.$i.'/">'.$i.'</a></li>';
            		}
            	}

				if($pagina==$numPaginas){
            		$tabla.='<li><a><i class="far fa-arrow-alt-circle-right"></i></a></li>';
            	}
            	else{
            		$tabla.='<li class="disabled"><a href="'.SERVERURL.'administradorProfesorTodos/'.($pagina+1).'/"><i class="far fa-arrow-alt-circle-right"></i></a></li>';
            	}
            	$tabla.='</ul></nav></div>';
            }
			return $tabla;
		}

		public function paginador_docente_cursos_controlador($privilegio, $codigoAdmin)
		{
			$privilegio=mainModel::limpiar_cadena($privilegio);
			$codigoAdmin=mainModel::limpiar_cadena($codigoAdmin);
			$tabla="";

			$conexion = mainModel::conectar();

            $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM docentes WHERE CODIGO_CUENTA_DOCENTE='$codigoAdmin'");
            $docente=$consulta->fetch();
            $idDocente=$docente['ID_DOCENTE'];
            $anio=date('Y');

			$datos = $conexion->prepare("
				SELECT SQL_CALC_FOUND_ROWS * FROM asignaciones WHERE ID_DOCENTE=$idDocente AND ANIO=$anio ORDER BY ID_MODULO ASC, GRUPO ASC
			");
			$datos->execute();
			$datos = $datos->fetchAll();

			$total = $conexion->query("SELECT FOUND_ROWS()");
			$total = (int) $total->fetchColumn();

			$tabla.='
				<table class="table table-hover table-sm table-responsive">
                    <thead class="table-secondary">
                        <tr>
                            <th width="5%">No</th>
                            <th>Módulo</th>
                            <th width="5%">Grupo</th>
                            <th width="15%">Frecuencia</th>
                            <th width="15%">Horario</th>
                            <th width="16%">Acciones</th>';

                            /*if($privilegio<=2 ){
                            	$tabla.='<th width="11%">Acciones</th>';
                            }*/
                            
               $tabla.='</tr>
                    </thead>
                    <tbody>'
            ;

            if($total>=1){
            	$contador =1;
            	foreach ($datos as $row) {

            		$idModulo=$row['ID_MODULO'];
            		$consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM modulos WHERE ID_MODULO=$idModulo");
            		$modulo=$consulta->fetch();

            		$idFrecuencia=$row['ID_FRECUENCIA'];
            		$consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM frecuencias WHERE ID_FRECUENCIA=$idFrecuencia");
            		$frecuencia=$consulta->fetch();

            		$hora="";
            		$hi=$row['HORA_INICIO'];
					$hf=$row['HORA_FIN'];
					$hi=substr($hi,0,5);
					$hf=substr($hf,0,5);
					if($row['TURNO']=="M"){
						$hora.=$hi.'-'.$hf.'AM';
					}
					else{
						$hora.=$hi.'-'.$hf.'PM';
					}

            		$tabla.='
            		<tr>
                        <td class="align-middle">'.$contador.'</td>
                        <td class="align-middle">'.$modulo['NOMBRE_MODULO'].'</td>
                        <td class="align-middle">'.$row['GRUPO'].'</td>
                        <td class="align-middle">'.$frecuencia['NOMBRE_FRECUENCIA'].'</td>
                        <td class="align-middle">'.$hora.'</td>
                        <td class="align-middle">
                        	<a href="'.SERVERURL.'docenteReporteAlumnosMatriculados/'.mainModel::encryption($idDocente).'/'.mainModel::encryption($modulo['ID_MODULO']).'/'.mainModel::encryption($row['GRUPO']).'/" title="Ver lista de alumnos" class="btn btn-primary btn-sm">
                        		<i class="fas fa-user-graduate"></i>
                        	</a>
                        	<a href="'.SERVERURL.'docenteReporteAlumnosMatriculadosNotas/'.mainModel::encryption($row['ID_ASIGNACION']).'/'.mainModel::encryption($modulo['ID_MODULO']).'/'.mainModel::encryption($row['GRUPO']).'/" title="Ver notas" class="btn btn-primary btn-sm">
                        		<i class="fas fa-sort-numeric-up"></i>
                        	</a>
                        	<a href="'.SERVERURL.'docenteReporteAlumnosMatriculadosAsistencias/'.mainModel::encryption($row['ID_ASIGNACION']).'/'.mainModel::encryption($modulo['ID_MODULO']).'/'.mainModel::encryption($row['GRUPO']).'/" title="Ver asistencias" class="btn btn-primary btn-sm">
                        		<i class="fas fa-check-circle"></i>
                        	</a>
                        </td>';

                        /*
						<a href="'.SERVERURL.'docenteReporteAlumnosMatriculadosAsistencias/'.mainModel::encryption($row['ID_ASIGNACION']).'/'.mainModel::encryption($modulo['ID_MODULO']).'/'.mainModel::encryption($row['GRUPO']).'/" title="Ver asistencias" class="btn btn-primary btn-sm">
                        		<i class="fas fa-check-circle"></i>
                        </a>
                        */

                        /*if($cuenta['ESTADO']=="Activo"){
                        	$tabla.='<td class="align-middle">
                        		<span class="badge badge-success">&nbsp;'.$cuenta['ESTADO'].'&nbsp;</span>
                        		<form  action="'.SERVERURL.'ajax/docenteAjax.php" method="POST" data-form="actualizar" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data" style="display:inline">

                        				<input type="hidden" name="codigo-cambio" value="'.mainModel::encryption($row['CODIGO_CUENTA_DOCENTE']).'">

                        				<input type="hidden" name="privilegio-admin" value="'.mainModel::encryption($privilegio).'">

                        				<button type="submit" class="btn btn-primary btn-sm" title="Cambiar Estado"><i class="fas fa-exchange-alt"></i></button>

                        				<div class="RespuestaAjax"></div>
                        		</form>
                        	</td>';
                        }
                        else{
                        	$tabla.='<td class="align-middle">
                        		<span class="badge badge-secondary">'.$cuenta['ESTADO'].'</span>
                        		<form  action="'.SERVERURL.'ajax/docenteAjax.php" method="POST" data-form="actualizar" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data" style="display:inline">

                        				<input type="hidden" name="codigo-cambio" value="'.mainModel::encryption($row['CODIGO_CUENTA_DOCENTE']).'">

                        				<input type="hidden" name="privilegio-admin" value="'.mainModel::encryption($privilegio).'">

                        				<button type="submit" class="btn btn-primary btn-sm" title="Cambiar Estado"><i class="fas fa-exchange-alt"></i></button>

                        				<div class="RespuestaAjax"></div>
                        		</form>
                        	</td>';
                        }*/

                        /*if($privilegio==2){
                        	$tabla.='                   
                        		<td>
                            		<a href="'.SERVERURL.'administradorProfesorModificar/'.mainModel::encryption($row['CODIGO_CUENTA_DOCENTE']).'/" title="Editar datos" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                        		</td>
                        	';
                        }

                        if($privilegio==1){
                        	$tabla.='                   
                        		<td>
                            		<form  style="display:inline">
                        				<a href="'.SERVERURL.'administradorProfesorModificar/'.mainModel::encryption($row['CODIGO_CUENTA_DOCENTE']).'/" title="Editar datos" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                        			</form>
                        			<form  action="'.SERVERURL.'ajax/docenteAjax.php" method="POST" data-form="borrar" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data" style="display:inline">

                        				<input type="hidden" name="codigo-docente" value="'.mainModel::encryption($row['CODIGO_CUENTA_DOCENTE']).'">

                        				<input type="hidden" name="privilegio-admin" value="'.mainModel::encryption($privilegio).'">

                        				<button type="submit" class="btn btn-danger btn-sm" title="Eliminar"><i class="fas fa-trash-alt"></i></button>

                        				<div class="RespuestaAjax"></div>
                        			</form>
                        		</td>
                        	';
                        }*/

                    $tabla.='
                    </tr>
            		';
            		$contador++;
            	}
            }
            else{
            	$tabla.='
            		<tr>
 						<td colspan="7" align="center">No hay registros para mostrar</td>
                   	</tr>
            	';
            }

            $tabla.='</tbody>
                    </table>';

			return $tabla;
		} 

		public function paginador_docente_seleccionar_asistencia_controlador($pagina, $numRegistros, $privilegio, $codigoAdmin)
		{
			$pagina=mainModel::limpiar_cadena($pagina);
			$numRegistros=mainModel::limpiar_cadena($numRegistros);
			$privilegio=mainModel::limpiar_cadena($privilegio);
			$codigoAdmin=mainModel::limpiar_cadena($codigoAdmin);
			$tabla="";

			$pagina = (isset($pagina) && $pagina>0) ? (int) $pagina : 1;
			$inicio = ($pagina>0) ? (($pagina*$numRegistros)-$numRegistros) : 0;

			$conexion = mainModel::conectar();

            $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM docentes WHERE CODIGO_CUENTA_DOCENTE='$codigoAdmin'");
            $docente=$consulta->fetch();
            $idDocente=$docente['ID_DOCENTE'];
            $anio=date('Y');

			$datos = $conexion->prepare("
				SELECT SQL_CALC_FOUND_ROWS * FROM asignaciones WHERE ID_DOCENTE=$idDocente AND ANIO=$anio ORDER BY ID_MODULO ASC, GRUPO ASC LIMIT $inicio,$numRegistros
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
                            <th>Módulo</th>
                            <th width="5%">Grupo</th>
                            <th width="15%">Frecuencia</th>
                            <th width="15%">Horario</th>
                            <th width="5%">Acción</th>';

                            /*if($privilegio<=2 ){
                            	$tabla.='<th width="11%">Acciones</th>';
                            }*/
                            
               $tabla.='</tr>
                    </thead>
                    <tbody>'
            ;

            if($total>=1 && $pagina<=$numPaginas){
            	$contador = $inicio+1;
            	foreach($datos as $row){

            		$idModulo=$row['ID_MODULO'];
            		$consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM modulos WHERE ID_MODULO=$idModulo");
            		$modulo=$consulta->fetch();

            		$idFrecuencia=$row['ID_FRECUENCIA'];
            		$consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM frecuencias WHERE ID_FRECUENCIA=$idFrecuencia");
            		$frecuencia=$consulta->fetch();

            		$hora="";
            		$hi=$row['HORA_INICIO'];
					$hf=$row['HORA_FIN'];
					$hi=substr($hi,0,5);
					$hf=substr($hf,0,5);
					if($row['TURNO']=="M"){
						$hora.=$hi.'-'.$hf.'AM';
					}
					else{
						$hora.=$hi.'-'.$hf.'PM';
					}
 
 					$grupo=$row['GRUPO'];
            		$tabla.='
            		<tr>
                        <td class="align-middle">'.$contador.'</td>
                        <td class="align-middle">'.$modulo['NOMBRE_MODULO'].'</td>
                        <td class="align-middle">'.$grupo.'</td>
                        <td class="align-middle">'.$frecuencia['NOMBRE_FRECUENCIA'].'</td>
                        <td class="align-middle">'.$hora.'</td>';

                    $fechaActual=date('Y-m-d');
                    $fechaInicio=$row['FECHA_INICIO'];
                    $fechaFin=$row['FECHA_FIN'];
                    if($fechaActual>=$fechaInicio && $fechaActual<=$fechaFin){
                        $tabla.='<td class="align-middle"><a href="'.SERVERURL.'docenteRegistrarAsistencia/'.mainModel::encryption($row['ID_ASIGNACION']).'/" title="Registrar asistencia" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a></td>';
                    }
                    else{
                      	$tabla.='<td class="align-middle"><a href="'.SERVERURL.'docenteRegistrarAsistencia/'.mainModel::encryption($row['ID_ASIGNACION']).'/" title="Registrar asistencia" class="btn btn-secondary btn-sm" style="pointer-events: none;"><i class="fas fa-edit"></i></a></td>';
                    }
                        
                        /*if($cuenta['ESTADO']=="Activo"){
                        	$tabla.='<td class="align-middle">
                        		<span class="badge badge-success">&nbsp;'.$cuenta['ESTADO'].'&nbsp;</span>
                        		<form  action="'.SERVERURL.'ajax/docenteAjax.php" method="POST" data-form="actualizar" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data" style="display:inline">

                        				<input type="hidden" name="codigo-cambio" value="'.mainModel::encryption($row['CODIGO_CUENTA_DOCENTE']).'">

                        				<input type="hidden" name="privilegio-admin" value="'.mainModel::encryption($privilegio).'">

                        				<button type="submit" class="btn btn-primary btn-sm" title="Cambiar Estado"><i class="fas fa-exchange-alt"></i></button>

                        				<div class="RespuestaAjax"></div>
                        		</form>
                        	</td>';
                        }
                        else{
                        	$tabla.='<td class="align-middle">
                        		<span class="badge badge-secondary">'.$cuenta['ESTADO'].'</span>
                        		<form  action="'.SERVERURL.'ajax/docenteAjax.php" method="POST" data-form="actualizar" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data" style="display:inline">

                        				<input type="hidden" name="codigo-cambio" value="'.mainModel::encryption($row['CODIGO_CUENTA_DOCENTE']).'">

                        				<input type="hidden" name="privilegio-admin" value="'.mainModel::encryption($privilegio).'">

                        				<button type="submit" class="btn btn-primary btn-sm" title="Cambiar Estado"><i class="fas fa-exchange-alt"></i></button>

                        				<div class="RespuestaAjax"></div>
                        		</form>
                        	</td>';
                        }*/

                        /*if($privilegio==2){
                        	$tabla.='                   
                        		<td>
                            		<a href="'.SERVERURL.'administradorProfesorModificar/'.mainModel::encryption($row['CODIGO_CUENTA_DOCENTE']).'/" title="Editar datos" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                        		</td>
                        	';
                        }

                        if($privilegio==1){
                        	$tabla.='                   
                        		<td>
                            		<form  style="display:inline">
                        				<a href="'.SERVERURL.'administradorProfesorModificar/'.mainModel::encryption($row['CODIGO_CUENTA_DOCENTE']).'/" title="Editar datos" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                        			</form>
                        			<form  action="'.SERVERURL.'ajax/docenteAjax.php" method="POST" data-form="borrar" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data" style="display:inline">

                        				<input type="hidden" name="codigo-docente" value="'.mainModel::encryption($row['CODIGO_CUENTA_DOCENTE']).'">

                        				<input type="hidden" name="privilegio-admin" value="'.mainModel::encryption($privilegio).'">

                        				<button type="submit" class="btn btn-danger btn-sm" title="Eliminar"><i class="fas fa-trash-alt"></i></button>

                        				<div class="RespuestaAjax"></div>
                        			</form>
                        		</td>
                        	';
                        }*/

                    $tabla.='
                    </tr>
            		';
            		$contador++;
            	}
            }
            else{
            	
            		$tabla.='
            			<tr>
 							<td colspan="7" align="center">No hay registros para mostrar</td>
                    	</tr>
            		';
            	
            }

            $tabla.='</tbody>
                    </table>';


			return $tabla;
		}

		public function paginador_docente_seleccionar_nota_controlador($pagina, $numRegistros, $privilegio, $codigoAdmin)
		{
			$pagina=mainModel::limpiar_cadena($pagina);
			$numRegistros=mainModel::limpiar_cadena($numRegistros);
			$privilegio=mainModel::limpiar_cadena($privilegio);
			$codigoAdmin=mainModel::limpiar_cadena($codigoAdmin);
			$tabla="";

			$pagina = (isset($pagina) && $pagina>0) ? (int) $pagina : 1;
			$inicio = ($pagina>0) ? (($pagina*$numRegistros)-$numRegistros) : 0;

			$conexion = mainModel::conectar();

            $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM docentes WHERE CODIGO_CUENTA_DOCENTE='$codigoAdmin'");
            $docente=$consulta->fetch();
            $idDocente=$docente['ID_DOCENTE'];
            $anio=date('Y');

			$datos = $conexion->prepare("
				SELECT SQL_CALC_FOUND_ROWS * FROM asignaciones WHERE ID_DOCENTE=$idDocente AND ANIO=$anio ORDER BY ID_MODULO ASC, GRUPO ASC LIMIT $inicio,$numRegistros
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
                            <th>Módulo</th>
                            <th width="5%">Grupo</th>
                            <th width="15%">Frecuencia</th>
                            <th width="15%">Horario</th>
                            <th width="5%">Acción</th>';

                            /*if($privilegio<=2 ){
                            	$tabla.='<th width="11%">Acciones</th>';
                            }*/
                            
               $tabla.='</tr>
                    </thead>
                    <tbody>'
            ;

            if($total>=1 && $pagina<=$numPaginas){
            	$contador = $inicio+1;
            	foreach($datos as $row){

            		$idModulo=$row['ID_MODULO'];
            		$consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM modulos WHERE ID_MODULO=$idModulo");
            		$modulo=$consulta->fetch();

            		$idFrecuencia=$row['ID_FRECUENCIA'];
            		$consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM frecuencias WHERE ID_FRECUENCIA=$idFrecuencia");
            		$frecuencia=$consulta->fetch();

            		$hora="";
            		$hi=$row['HORA_INICIO'];
					$hf=$row['HORA_FIN'];
					$hi=substr($hi,0,5);
					$hf=substr($hf,0,5);
					if($row['TURNO']=="M"){
						$hora.=$hi.'-'.$hf.'AM';
					}
					else{
						$hora.=$hi.'-'.$hf.'PM';
					}
 
 					$grupo=$row['GRUPO'];
            		$tabla.='
            		<tr>
                        <td class="align-middle">'.$contador.'</td>
                        <td class="align-middle">'.$modulo['NOMBRE_MODULO'].'</td>
                        <td class="align-middle">'.$grupo.'</td>
                        <td class="align-middle">'.$frecuencia['NOMBRE_FRECUENCIA'].'</td>
                        <td class="align-middle">'.$hora.'</td>';

                    $fechaActual=date('Y-m-d');
                    $fechaInicio=$row['FECHA_INICIO'];
                    $fechaFin=$row['FECHA_FIN'];
                    if($fechaActual>=$fechaInicio && $fechaActual<=$fechaFin){
                        $tabla.='<td class="align-middle"><a href="'.SERVERURL.'docenteRegistrarNota/'.mainModel::encryption($row['ID_ASIGNACION']).'/" title="Registrar notas" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a></td>';
                    }
                    else{
                      	$tabla.='<td class="align-middle"><a href="'.SERVERURL.'docenteRegistrarNota/'.mainModel::encryption($row['ID_ASIGNACION']).'/" title="Registrar notas" class="btn btn-secondary btn-sm" style="pointer-events: none;"><i class="fas fa-edit"></i></a></td>';
                    }
                        
                        /*if($cuenta['ESTADO']=="Activo"){
                        	$tabla.='<td class="align-middle">
                        		<span class="badge badge-success">&nbsp;'.$cuenta['ESTADO'].'&nbsp;</span>
                        		<form  action="'.SERVERURL.'ajax/docenteAjax.php" method="POST" data-form="actualizar" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data" style="display:inline">

                        				<input type="hidden" name="codigo-cambio" value="'.mainModel::encryption($row['CODIGO_CUENTA_DOCENTE']).'">

                        				<input type="hidden" name="privilegio-admin" value="'.mainModel::encryption($privilegio).'">

                        				<button type="submit" class="btn btn-primary btn-sm" title="Cambiar Estado"><i class="fas fa-exchange-alt"></i></button>

                        				<div class="RespuestaAjax"></div>
                        		</form>
                        	</td>';
                        }
                        else{
                        	$tabla.='<td class="align-middle">
                        		<span class="badge badge-secondary">'.$cuenta['ESTADO'].'</span>
                        		<form  action="'.SERVERURL.'ajax/docenteAjax.php" method="POST" data-form="actualizar" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data" style="display:inline">

                        				<input type="hidden" name="codigo-cambio" value="'.mainModel::encryption($row['CODIGO_CUENTA_DOCENTE']).'">

                        				<input type="hidden" name="privilegio-admin" value="'.mainModel::encryption($privilegio).'">

                        				<button type="submit" class="btn btn-primary btn-sm" title="Cambiar Estado"><i class="fas fa-exchange-alt"></i></button>

                        				<div class="RespuestaAjax"></div>
                        		</form>
                        	</td>';
                        }*/

                        /*if($privilegio==2){
                        	$tabla.='                   
                        		<td>
                            		<a href="'.SERVERURL.'administradorProfesorModificar/'.mainModel::encryption($row['CODIGO_CUENTA_DOCENTE']).'/" title="Editar datos" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                        		</td>
                        	';
                        }

                        if($privilegio==1){
                        	$tabla.='                   
                        		<td>
                            		<form  style="display:inline">
                        				<a href="'.SERVERURL.'administradorProfesorModificar/'.mainModel::encryption($row['CODIGO_CUENTA_DOCENTE']).'/" title="Editar datos" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                        			</form>
                        			<form  action="'.SERVERURL.'ajax/docenteAjax.php" method="POST" data-form="borrar" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data" style="display:inline">

                        				<input type="hidden" name="codigo-docente" value="'.mainModel::encryption($row['CODIGO_CUENTA_DOCENTE']).'">

                        				<input type="hidden" name="privilegio-admin" value="'.mainModel::encryption($privilegio).'">

                        				<button type="submit" class="btn btn-danger btn-sm" title="Eliminar"><i class="fas fa-trash-alt"></i></button>

                        				<div class="RespuestaAjax"></div>
                        			</form>
                        		</td>
                        	';
                        }*/

                    $tabla.='
                    </tr>
            		';
            		$contador++;
            	}
            }
            else{
            	
            		$tabla.='
            			<tr>
 							<td colspan="7" align="center">No hay registros para mostrar</td>
                    	</tr>
            		';
            	
            }

            $tabla.='</tbody>
                    </table>';


			return $tabla;
		}

		public function paginador_docente_seleccionar_nomina_controlador($pagina, $numRegistros, $privilegio, $codigoAdmin)
		{
			$pagina=mainModel::limpiar_cadena($pagina);
			$numRegistros=mainModel::limpiar_cadena($numRegistros);
			$privilegio=mainModel::limpiar_cadena($privilegio);
			$codigoAdmin=mainModel::limpiar_cadena($codigoAdmin);
			$tabla="";

			$pagina = (isset($pagina) && $pagina>0) ? (int) $pagina : 1;
			$inicio = ($pagina>0) ? (($pagina*$numRegistros)-$numRegistros) : 0;

			$conexion = mainModel::conectar();

            $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM docentes WHERE CODIGO_CUENTA_DOCENTE='$codigoAdmin'");
            $docente=$consulta->fetch();
            $idDocente=$docente['ID_DOCENTE'];
            $anio=date('Y');

			$datos = $conexion->prepare("
				SELECT SQL_CALC_FOUND_ROWS * FROM asignaciones WHERE ID_DOCENTE=$idDocente AND ANIO=$anio ORDER BY ID_MODULO ASC, GRUPO ASC LIMIT $inicio,$numRegistros
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
                            <th>Módulo</th>
                            <th width="5%">Grupo</th>
                            <th width="15%">Frecuencia</th>
                            <th width="15%">Horario</th>
                            <th width="5%">Acción</th>';

                            /*if($privilegio<=2 ){
                            	$tabla.='<th width="11%">Acciones</th>';
                            }*/
                            
               $tabla.='</tr>
                    </thead>
                    <tbody>'
            ;

            if($total>=1 && $pagina<=$numPaginas){
            	$contador = $inicio+1;
            	foreach($datos as $row){

            		$idModulo=$row['ID_MODULO'];
            		$consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM modulos WHERE ID_MODULO=$idModulo");
            		$modulo=$consulta->fetch();

            		$idFrecuencia=$row['ID_FRECUENCIA'];
            		$consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM frecuencias WHERE ID_FRECUENCIA=$idFrecuencia");
            		$frecuencia=$consulta->fetch();

            		$hora="";
            		$hi=$row['HORA_INICIO'];
					$hf=$row['HORA_FIN'];
					$hi=substr($hi,0,5);
					$hf=substr($hf,0,5);
					if($row['TURNO']=="M"){
						$hora.=$hi.'-'.$hf.'AM';
					}
					else{
						$hora.=$hi.'-'.$hf.'PM';
					}
 
 					$grupo=$row['GRUPO'];
            		$tabla.='
            		<tr>
                        <td class="align-middle">'.$contador.'</td>
                        <td class="align-middle">'.$modulo['NOMBRE_MODULO'].'</td>
                        <td class="align-middle">'.$grupo.'</td>
                        <td class="align-middle">'.$frecuencia['NOMBRE_FRECUENCIA'].'</td>
                        <td class="align-middle">'.$hora.'</td>';

                    $fechaActual=date('Y-m-d');
                    $fechaInicio=$row['FECHA_INICIO'];
                    $fechaFin=$row['FECHA_FIN'];
                    $tabla.='
                    	<td align="center">
                    		<form action="'.SERVERURL.'docenteDescargarNomina/" method="post" target="_blank">
                            	<input type="hidden" name="asignacion" value="'.$row['ID_ASIGNACION'].'">
                            	<button type="submit" name="create_pdf" title="Descargar Nomina" class="btn btn-primary btn-sm"><i class="fas fa-file-download"></i></button>
                			</form>
                		</tr>';

                    /*if($fechaActual>=$fechaInicio && $fechaActual<=$fechaFin){
                        $tabla.='<td class="align-middle"><a href="'.SERVERURL.'docenteDescargarNomina/'.mainModel::encryption($row['ID_ASIGNACION']).'/" title="Registrar notas" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a></td>';
                    }
                    else{
                      	$tabla.='<td class="align-middle"><a href="'.SERVERURL.'docenteDescargarNomina/'.mainModel::encryption($row['ID_ASIGNACION']).'/" title="Registrar notas" class="btn btn-secondary btn-sm" style="pointer-events: none;"><i class="fas fa-edit"></i></a></td>';
                    }*/
                        
                        /*if($cuenta['ESTADO']=="Activo"){
                        	$tabla.='<td class="align-middle">
                        		<span class="badge badge-success">&nbsp;'.$cuenta['ESTADO'].'&nbsp;</span>
                        		<form  action="'.SERVERURL.'ajax/docenteAjax.php" method="POST" data-form="actualizar" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data" style="display:inline">

                        				<input type="hidden" name="codigo-cambio" value="'.mainModel::encryption($row['CODIGO_CUENTA_DOCENTE']).'">

                        				<input type="hidden" name="privilegio-admin" value="'.mainModel::encryption($privilegio).'">

                        				<button type="submit" class="btn btn-primary btn-sm" title="Cambiar Estado"><i class="fas fa-exchange-alt"></i></button>

                        				<div class="RespuestaAjax"></div>
                        		</form>
                        	</td>';
                        }
                        else{
                        	$tabla.='<td class="align-middle">
                        		<span class="badge badge-secondary">'.$cuenta['ESTADO'].'</span>
                        		<form  action="'.SERVERURL.'ajax/docenteAjax.php" method="POST" data-form="actualizar" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data" style="display:inline">

                        				<input type="hidden" name="codigo-cambio" value="'.mainModel::encryption($row['CODIGO_CUENTA_DOCENTE']).'">

                        				<input type="hidden" name="privilegio-admin" value="'.mainModel::encryption($privilegio).'">

                        				<button type="submit" class="btn btn-primary btn-sm" title="Cambiar Estado"><i class="fas fa-exchange-alt"></i></button>

                        				<div class="RespuestaAjax"></div>
                        		</form>
                        	</td>';
                        }*/

                        /*if($privilegio==2){
                        	$tabla.='                   
                        		<td>
                            		<a href="'.SERVERURL.'administradorProfesorModificar/'.mainModel::encryption($row['CODIGO_CUENTA_DOCENTE']).'/" title="Editar datos" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                        		</td>
                        	';
                        }

                        if($privilegio==1){
                        	$tabla.='                   
                        		<td>
                            		<form  style="display:inline">
                        				<a href="'.SERVERURL.'administradorProfesorModificar/'.mainModel::encryption($row['CODIGO_CUENTA_DOCENTE']).'/" title="Editar datos" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                        			</form>
                        			<form  action="'.SERVERURL.'ajax/docenteAjax.php" method="POST" data-form="borrar" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data" style="display:inline">

                        				<input type="hidden" name="codigo-docente" value="'.mainModel::encryption($row['CODIGO_CUENTA_DOCENTE']).'">

                        				<input type="hidden" name="privilegio-admin" value="'.mainModel::encryption($privilegio).'">

                        				<button type="submit" class="btn btn-danger btn-sm" title="Eliminar"><i class="fas fa-trash-alt"></i></button>

                        				<div class="RespuestaAjax"></div>
                        			</form>
                        		</td>
                        	';
                        }*/

                    $tabla.='
                    </tr>
            		';
            		$contador++;
            	}
            }
            else{
            	
            		$tabla.='
            			<tr>
 							<td colspan="7" align="center">No hay registros para mostrar</td>
                    	</tr>
            		';
            }

            $tabla.='</tbody>
                    </table>';

   
			return $tabla;
		}

		public function paginador_alumnos_notas_controlador($privilegio, $codigo1, $asignacion1, $modulo1, $grupo1){


            $idAsignacion=$asignacion1;
            $modulo=$modulo1;
            $grupo=$grupo1;
            $codigo=$codigo1;
            $anio=date('Y');

            $consulta = mainModel::ejecutar_consulta_simple("SELECT a.ID_ALUMNO, a.APELLIDOS_ALUMNO, a.NOMBRES_ALUMNO, a.SEXO_ALUMNO, a.FECHA_NACIMIENTO_ALUMNO, a.CODIGO_CUENTA_ALUMNO, a.CONDICION_ALUMNO, m.CODIGO_MATRICULA, d.ID_ASIGNACION 
                FROM alumnos a JOIN matriculas m ON m.ID_ALUMNO = a.ID_ALUMNO 
                JOIN matricula_detalle d ON d.CODIGO_MATRICULA = m.CODIGO_MATRICULA 
                WHERE d.ID_ASIGNACION=$idAsignacion ORDER BY a.APELLIDOS_ALUMNO");
            $detallesMatricula=$consulta->fetchAll();

            $tabla="";

            $tabla.='
                <table class="table table-hover table-sm table-bordered">
                    <thead class="table-secondary">
                        <tr>
                            <th width="2%">No</th>
                            <th width="26%">Apellidos y Nombres</th>
                            <th width="9%" class="text-center">C.T.1</th>
                            <th width="9%" class="text-center">C.T.2</th>
                            <th width="9%" class="text-center">C.T.3</th>
                            <th width="9%" class="text-center">C.T.4</th>
                            <th width="9%" class="text-center">C.T.5</th>
                            <th width="9%" class="text-center">C.T.6</th>
                            <th width="9%" class="text-center">C.T.7</th>
                            <th width="9%" class="text-center">C.T.8</th>
                        </tr>
            ';

            /*$consulta1 = mainModel::ejecutar_consulta_simple("SELECT * FROM NOTAS WHERE ID_ASIGNACION=$idAsignacion");
            $contadorNotas=$consulta1->rowCount();

            if($contadorNotas>0){
                $notas=$consulta1->fetchAll();

                $k=1;
                foreach($notas as $nota){
                    if($k==1){
                        $idNota=$nota['ID_NOTA'];
                        $consulta2 = mainModel::ejecutar_consulta_simple("SELECT * FROM NOTA_DETALLE WHERE ID_NOTA=$idNota ORDER BY FECHA ASC");
                        $contadorDetalle=$consulta2->rowCount();

                        if($contadorDetalle>0){
                            $detalles=$consulta2->fetchAll();

                            $i=1;
                            foreach ($detalles as $detalle) {
                                $tabla.='
                                    <th width="2%">N'.$i.'</th>
                                ';
                                $i++;
                            }
                            $tabla.='
                                    <th></th>
                                    <th width="2%">NF</th>
                                <tr>
                            ';

                        }
                        else{
                            $tabla.='
                                    <th></th>
                                </tr>
                            ';
                        }
                    }
                    $k++;
                } 
            }
            else{
                $tabla.='
                        <th></th>
                    </tr>
                ';
            }*/
            
                            
            $tabla.='
                </thead>
                <tbody>'
            ;

            $contador=1;

            foreach ($detallesMatricula as $detalleMatricula) {
                /*$codMatricula=$detalleMatricula['CODIGO_MATRICULA'];
                $anioActual=date('Y');

                $consulta2 = mainModel::ejecutar_consulta_simple("SELECT * FROM MATRICULAS WHERE CODIGO_MATRICULA='$codMatricula'");
                $matricula=$consulta2->fetch();

                
                    $idAlumno=$matricula['ID_ALUMNO'];

                    $consulta3 = mainModel::ejecutar_consulta_simple("SELECT * FROM ALUMNOS WHERE ID_ALUMNO=$idAlumno");
                    $alumno=$consulta3->fetch();*/

                    $nombres=explode(" ",$detalleMatricula['NOMBRES_ALUMNO']);

                    $tabla.='
                        <tr>
                            <td class="align-middle" style="font-size: 12px;">'.$contador.'</td>
                            <td class="align-middle" style="font-size: 12px;">'.$detalleMatricula['APELLIDOS_ALUMNO'].', '.$nombres[0].'</td>
                    ';

                    $idAlumno=$detalleMatricula['ID_ALUMNO'];
                    $consulta1 = mainModel::ejecutar_consulta_simple("SELECT * FROM notas WHERE ID_ASIGNACION=$idAsignacion AND ID_ALUMNO=$idAlumno");
                    $contadorNotas=$consulta1->rowCount();

                    if($contadorNotas>0){
                        $nota=$consulta1->fetch();

                        $idNota=$nota['ID_NOTA'];
                        $consulta4 = mainModel::ejecutar_consulta_simple("SELECT * FROM nota_detalle WHERE ID_NOTA=$idNota ORDER BY FECHA ASC");
                        $contadorDetalle=$consulta4->rowCount();

                        if($contadorDetalle>0){
                            $detalles=$consulta4->fetchAll();

                            $colocar="";
                            $UD1="";
                            $UD2="";
                            $UD3="";
                            $UD4="";
                            $UD5="";
                            $UD6="";
                            $UD7="";
                            $UD8="";
                            foreach ($detalles as $detalle) {
                            	
                            	if($detalle['UNIDAD_DIDACTICA']==1){
                            		if($UD1==""){
                            		    if($detalle['NOTA']<10){
                            		        $UD1=$UD1."0".$detalle['NOTA'];
                            		    }
                            			else{
                            			    $UD1=$UD1.$detalle['NOTA'];
                            			}
                            		}
                            		else{
                            		    if($detalle['NOTA']<10){
                            		        $UD1=$UD1."-0".$detalle['NOTA'];
                            		    }
                            			else{
                            			    $UD1=$UD1."-".$detalle['NOTA'];
                            			}
                            			
                            		}
                            	}

                            	if($detalle['UNIDAD_DIDACTICA']==2){
                            		if($UD2==""){
                            		    if($detalle['NOTA']<10){
                            		        $UD2=$UD2."0".$detalle['NOTA'];
                            		    }
                            			else{
                            			    $UD2=$UD2.$detalle['NOTA'];
                            			}
                            		}
                            		else{
                            		    if($detalle['NOTA']<10){
                            		        $UD2=$UD2."-0".$detalle['NOTA'];
                            		    }
                            			else{
                            			    $UD2=$UD2."-".$detalle['NOTA'];
                            			}
                            		}
                            	}

                            	if($detalle['UNIDAD_DIDACTICA']==3){
                            		if($UD3==""){
                            		    if($detalle['NOTA']<10){
                            		        $UD3=$UD3."0".$detalle['NOTA'];
                            		    }
                            			else{
                            			    $UD3=$UD3.$detalle['NOTA'];
                            			}
                            		}
                            		else{
                            		    if($detalle['NOTA']<10){
                            		        $UD3=$UD3."-0".$detalle['NOTA'];
                            		    }
                            			else{
                            			    $UD3=$UD3."-".$detalle['NOTA'];
                            			}
                            		}
                            	}

                            	if($detalle['UNIDAD_DIDACTICA']==4){
                            		if($UD4==""){
                            		    if($detalle['NOTA']<10){
                            		        $UD4=$UD4."0".$detalle['NOTA'];
                            		    }
                            			else{
                            			    $UD4=$UD4.$detalle['NOTA'];
                            			}
                            		}
                            		else{
                            		    if($detalle['NOTA']<10){
                            		        $UD4=$UD4."-0".$detalle['NOTA'];
                            		    }
                            			else{
                            			    $UD4=$UD4."-".$detalle['NOTA'];
                            			}
                            		}
                            	}

                            	if($detalle['UNIDAD_DIDACTICA']==5){
                            		if($UD5==""){
                            		    if($detalle['NOTA']<10){
                            		        $UD5=$UD5."0".$detalle['NOTA'];
                            		    }
                            			else{
                            			    $UD5=$UD5.$detalle['NOTA'];
                            			}
                            		}
                            		else{
                            		    if($detalle['NOTA']<10){
                            		        $UD5=$UD5."-0".$detalle['NOTA'];
                            		    }
                            			else{
                            			    $UD5=$UD5."-".$detalle['NOTA'];
                            			}
                            		}
                            	}

                            	if($detalle['UNIDAD_DIDACTICA']==6){
                            		if($UD6==""){
                            		    if($detalle['NOTA']<10){
                            		        $UD6=$UD6."0".$detalle['NOTA'];
                            		    }
                            			else{
                            			    $UD6=$UD6.$detalle['NOTA'];
                            			}
                            		}
                            		else{
                            		    if($detalle['NOTA']<10){
                            		        $UD6=$UD6."-0".$detalle['NOTA'];
                            		    }
                            			else{
                            			    $UD6=$UD6."-".$detalle['NOTA'];
                            			}
                            		}
                            	}

                            	if($detalle['UNIDAD_DIDACTICA']==7){
                            		if($UD7==""){
                            		    if($detalle['NOTA']<10){
                            		        $UD7=$UD7."0".$detalle['NOTA'];
                            		    }
                            			else{
                            			    $UD7=$UD7.$detalle['NOTA'];
                            			}
                            		}
                            		else{
                            		    if($detalle['NOTA']<10){
                            		        $UD7=$UD7."-0".$detalle['NOTA'];
                            		    }
                            			else{
                            			    $UD7=$UD7."-".$detalle['NOTA'];
                            			}
                            		}
                            	}

                            	if($detalle['UNIDAD_DIDACTICA']==8){
                            		if($UD8==""){
                            		    if($detalle['NOTA']<10){
                            		        $UD8=$UD8."0".$detalle['NOTA'];
                            		    }
                            			else{
                            			    $UD8=$UD8.$detalle['NOTA'];
                            			}
                            		}
                            		else{
                            		    if($detalle['NOTA']<10){
                            		        $UD8=$UD8."-0".$detalle['NOTA'];
                            		    }
                            			else{
                            			    $UD8=$UD8."-".$detalle['NOTA'];
                            			}
                            		}
                            	}
                            }

                            $tabla.='
                            	<td align="center" class="align-middle" style="font-size: 12px;">'.$UD1.'</td>
                            	<td align="center" class="align-middle" style="font-size: 12px;">'.$UD2.'</td>
                            	<td align="center" class="align-middle" style="font-size: 12px;">'.$UD3.'</td>
                            	<td align="center" class="align-middle" style="font-size: 12px;">'.$UD4.'</td>
                            	<td align="center" class="align-middle" style="font-size: 12px;">'.$UD5.'</td>
                            	<td align="center" class="align-middle" style="font-size: 12px;">'.$UD6.'</td>
                            	<td align="center" class="align-middle" style="font-size: 12px;">'.$UD7.'</td>
                            	<td align="center" class="align-middle" style="font-size: 12px;">'.$UD8.'</td>
                            ';


                            $tabla.='
                                </tr>
                            ';  
                        }
                        else{
                            $tabla.='
                                </tr>
                            ';   
                        }
                    }
                    else{
                        $tabla.='
                            </tr>
                        ';
                    }
                

                $contador++;
            }

            $tabla.='
                </tbody>
                </table>
                <input type="hidden" name="asignacion" value="'.$idAsignacion.'">
                <input type="hidden" name="codigo-cuenta-docente" value="'.$codigo.'">
            ';

            return $tabla;
		}

		public function paginador_alumnos_asistencias_controlador($privilegio, $codigo1, $asignacion1, $modulo1, $grupo1){


            $idAsignacion=$asignacion1;
            $modulo=$modulo1;
            $grupo=$grupo1;
            $codigo=$codigo1;
            $anio=date('Y');

            $consulta = mainModel::ejecutar_consulta_simple("
            	SELECT a.ID_ALUMNO, a.APELLIDOS_ALUMNO, a.NOMBRES_ALUMNO, a.SEXO_ALUMNO, a.FECHA_NACIMIENTO_ALUMNO, a.CODIGO_CUENTA_ALUMNO, a.CONDICION_ALUMNO, m.CODIGO_MATRICULA, d.ID_ASIGNACION 
                FROM alumnos a JOIN matriculas m ON m.ID_ALUMNO = a.ID_ALUMNO 
                JOIN matricula_detalle d ON d.CODIGO_MATRICULA = m.CODIGO_MATRICULA 
                WHERE d.ID_ASIGNACION=$idAsignacion ORDER BY a.APELLIDOS_ALUMNO
            ");
            $matriculas=$consulta->fetchAll();

            $consulta = mainModel::ejecutar_consulta_simple("
            	SELECT * FROM asistencia_fecha WHERE ID_ASIGNACION=$idAsignacion ORDER BY FECHA
            ");
            $fechas=$consulta->fetchAll();


            $tabla="";

            $tabla.='
                <table class="table table-hover table-sm">
                    <thead class="table-secondary">
                        <tr>
                            <th width="3%">No</th>
                            <th>Apellidos y nombres</th>
                            <th width=12%">Asistencias</th>
                            <th width=12%">Tardanzas</th>
                            <th width=12%">Faltas</th>
                        </tr>
                    </thead>
                    <tbody>
            ';

            $contador=1;
            foreach ($matriculas as $matricula) {
            	$tabla.='
            		<tr>
	            		<td>'.$contador.'</td>
	            		<td>'.$matricula['APELLIDOS_ALUMNO'].', '.$matricula['NOMBRES_ALUMNO'].'</td>
	            ';

	            $total=0;
	            $asistio=0;
	            $tardo=0;
	            $falto=0;

	            $idAlumno=$matricula['ID_ALUMNO'];
	            $consulta = mainModel::ejecutar_consulta_simple("
	            	SELECT * FROM asistencias WHERE ID_ASIGNACION=$idAsignacion AND ID_ALUMNO=$idAlumno
	            ");
	            $asistencia=$consulta->fetch();

	            $idAsistencia = $asistencia['ID_ASISTENCIA'];
	            $consulta = mainModel::ejecutar_consulta_simple("
	            	SELECT * FROM asistencia_detalle WHERE ID_ASISTENCIA=$idAsistencia ORDER BY FECHA
	            ");
	            $detalles=$consulta->fetchAll();

	            foreach ($detalles as $key => $detalle) {
	            	
	            	$encontrado="falso";
	            	$f = $detalle['FECHA'];

	            	foreach ($fechas as $fecha) {
	            		
	            		if($f == $fecha['FECHA']){
	            			$encontrado="verdadero";
	            		}
	            	}

	            	if($encontrado=="verdadero"){
	            		$total++;

	            		if($detalle['ASISTENCIA']=="A"){
	            			$asistio++;
	            		}
	            		if($detalle['ASISTENCIA']=="T"){
	            			$tardo++;
	            		}
	            		if($detalle['ASISTENCIA']=="F"){
	            			$falto++;
	            		}
	            	}
	            }

	            if($total!=0){
	            	$pAsistio=round($asistio/$total * 100,2);
		            $pTardo=round($tardo / $total * 100,2);
		            $pFalto=round($falto / $total * 100,2);
		            $tabla.='
		            		<td>'.$asistio.' &nbsp;&nbsp;  ('.$pAsistio.'%)</td>
		            		<td>'.$tardo.'  &nbsp;&nbsp; ('.$pTardo.'%)</td>
		            ';

		            if($pFalto>30){
		            	$tabla.='
			            		<td class="bg-warning">'.$falto.'  &nbsp;&nbsp; ('.$pFalto.'%)</td>
			            	</tr>
		            	';
			            }
		            else{
		            	$tabla.='
			            		<td>'.$falto.'  &nbsp;&nbsp; ('.$pFalto.'%)</td>
			            	</tr>
		            	';
		            }


	            }
	            else{
	            	$tabla.='
		            		<td>0  &nbsp;&nbsp; (0%)</td>
		            		<td>0  &nbsp;&nbsp; (0%)</td>
		            		<td>0  &nbsp;&nbsp; (0%)</td>
		            	</tr>
	            	';
	            }
	            
            	$contador++;
            }

            $tabla.='
                </tbody>
                </table>
                <input type="hidden" name="asignacion" value="'.$idAsignacion.'">
                <input type="hidden" name="codigo-cuenta-docente" value="'.$codigo.'">
            ';

            return $tabla;
		}

		public function eliminar_docente_controlador(){
			$codigo=mainModel::decryption($_POST['codigo-docente']);
			$privilegio=mainModel::decryption($_POST['privilegio-admin']);

			$codigo=mainModel::limpiar_cadena($codigo);
			$privilegio=mainModel::limpiar_cadena($privilegio);

			if($privilegio==1){
				mainModel::eliminar_bitacora($codigo);
				$b=mainModel::eliminar_cuenta($codigo);
				if($b->rowCount()>=1){
					$eliminarDocente = docenteModelo::eliminar_docente_modelo($codigo);
					if($eliminarDocente->rowCount()==1){
						$alerta = [
							"Alerta"=>"recargar",
							"Titulo"=>"Docente eliminado",
							"Texto"=>"El docente fue eliminado con éxito del sistema",
							"Tipo"=>"success"
						];
					}
					else{
						$alerta = [
							"Alerta"=>"simple",
							"Titulo"=>"Ocurrió un error inesperado",
							"Texto"=>"No se pudo eliminar al docente del sistema",
							"Tipo"=>"error"
						];
					}
				}
				else{
					$alerta = [
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrió un error inesperado",
						"Texto"=>"No pudo eliminar al docente del sistema",
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

		public function datos_docente_controlador($codigo1){
			$codigo = mainModel::decryption($codigo1);
			return docenteModelo::datos_docente_modelo($codigo);
		}

		public function actualizar_docente_controlador($codigo)
		{
			$apellidos = mainModel::limpiar_cadena($_POST['apellidos-2']);
			$nombres = mainModel::limpiar_cadena($_POST['nombres-2']);
			$dni = mainModel::limpiar_cadena($_POST['dni-2']);
			$fechaNac = mainModel::limpiar_cadena($_POST['fecha-nacimiento-2']);
			$sexo = mainModel::limpiar_cadena($_POST['sexo-2']);
			$estado = mainModel::limpiar_cadena($_POST['estado-2']);
			$numero = mainModel::limpiar_cadena($_POST['numero-2']);
			$email = mainModel::limpiar_cadena($_POST['email-2']);
			$direccion = mainModel::limpiar_cadena($_POST['direccion-2']);
			$distrito = mainModel::limpiar_cadena($_POST['distrito-2']);
			$referencia = mainModel::limpiar_cadena($_POST['referencia-2']);

			
			if($sexo=="M"){
				$foto="adminHombre.jpg";
			}
			else{
				$foto="adminMujer.jpg";
			}

			
				$consulta1 = mainModel::ejecutar_consulta_simple("SELECT DNI_DOCENTE FROM docentes WHERE DNI_DOCENTE='$dni' AND CODIGO_CUENTA_DOCENTE!='$codigo'");
				if(($consulta1->rowCount())>=1){
					$alerta = [
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrio un error inesperado",
					"Texto"=>"El DNI ingresado ya se encuentra registrado en el sistema",
					"Tipo"=>"error"
					];
				}
				else{
					$consulta2 = mainModel::ejecutar_consulta_simple("SELECT CORREO_DOCENTE FROM docentes WHERE CORREO_DOCENTE='$email' AND CODIGO_CUENTA_DOCENTE!='$codigo'");
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
								"Foto"=>$foto,
								"Codigo"=>$codigo
							];

							$actualizarCuenta=mainModel::actualizar_cuenta2($datosCuenta);*/

							//if(($actualizarCuenta->rowCount())>=1){
								$datosDocente=[
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

								$actualizarDocente=docenteModelo::actualizar_docente_modelo($datosDocente);
								if(($actualizarDocente->rowCount())==1){
									$alerta = [
									"Alerta"=>"recargar",
									"Titulo"=>"Docente actualizado ",
									"Texto"=>"Los datos del docente han sido actulizados en el sistema.",
									"Tipo"=>"success"
									];
								}
								else{
									$alerta = [
									"Alerta"=>"simple",
									"Titulo"=>"Ocurrio un error inesperado",
									"Texto"=>"No hemos podido actualizar los datos del docente en el sistema. 1",
									"Tipo"=>"error"
									];
								}
							//}
							/*else{
								$alerta = [
								"Alerta"=>"simple",
								"Titulo"=>"Ocurrio un error inesperado",
								"Texto"=>"No hemos podido actualizar los datos del docente en el sistema. 2",
								"Tipo"=>"error"
								];
							}*/
					}
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