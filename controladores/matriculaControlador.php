<?php
	if ($peticionAjax) {
		require_once "../modelos/matriculaModelo.php";
	}
	else{
		require_once "modelos/matriculaModelo.php";
	}
  
	class matriculaControlador extends matriculaModelo
	{
		public function agregar_matricula_controlador()
		{
			$alumno=$_POST['alumno'];
            $asignacion1=$_POST['asignacion-1'];
            $asignacion2=$_POST['asignacion-2'];
            $asignacion3=$_POST['asignacion-3'];
            $asignacion4=$_POST['asignacion-4'];
            $asignacion5=$_POST['asignacion-5'];
            $asignacion6=$_POST['asignacion-6'];
            $anio=date("Y");
            $adelanto=$_POST['adelanto'];
            $total=0;
            $fecha=$_POST['fecha'];
            $pagante=$_POST['pagante'];

            $numeros = array();
            $modulos = array();
            $vacantes = array();

            $vacantes1=0;
            $vacantes2=0;
            $vacantes3=0;
            $vacantes4=0;
            $vacantes5=0;
            $vacantes6=0;


            if($asignacion1!=0){
                array_push($numeros,$asignacion1);
                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asignaciones WHERE ID_ASIGNACION=$asignacion1");
                $asignacion=$consulta->fetch();
                array_push($modulos,$asignacion['ID_MODULO']);
                array_push($vacantes,$asignacion['VACANTES']);
                $vacantes1=$asignacion['VACANTES'];

            }
            if($asignacion2!=0){
                array_push($numeros,$asignacion2);
                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asignaciones WHERE ID_ASIGNACION=$asignacion2");
                $asignacion=$consulta->fetch();
                array_push($modulos,$asignacion['ID_MODULO']);
                array_push($vacantes,$asignacion['VACANTES']);
                $vacantes2=$asignacion['VACANTES'];
            }
            if($asignacion3!=0){
                array_push($numeros,$asignacion3);
                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asignaciones WHERE ID_ASIGNACION=$asignacion3");
                $asignacion=$consulta->fetch();
                array_push($modulos,$asignacion['ID_MODULO']);
                array_push($vacantes,$asignacion['VACANTES']);
                $vacantes3=$asignacion['VACANTES'];
            }
            if($asignacion4!=0){
                array_push($numeros,$asignacion4);
                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asignaciones WHERE ID_ASIGNACION=$asignacion4");
                $asignacion=$consulta->fetch();
                array_push($modulos,$asignacion['ID_MODULO']);
                array_push($vacantes,$asignacion['VACANTES']);
                $vacantes4=$asignacion['VACANTES'];
            }
            if($asignacion5!=0){
                array_push($numeros,$asignacion5);
                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asignaciones WHERE ID_ASIGNACION=$asignacion5");
                $asignacion=$consulta->fetch();
                array_push($modulos,$asignacion['ID_MODULO']);
                array_push($vacantes,$asignacion['VACANTES']);
                $vacantes5=$asignacion['VACANTES'];
            }
            if($asignacion6!=0){
                array_push($numeros,$asignacion6);
                $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asignaciones WHERE ID_ASIGNACION=$asignacion6");
                $asignacion=$consulta->fetch();
                array_push($modulos,$asignacion['ID_MODULO']);
                array_push($vacantes,$asignacion['VACANTES']);
                $vacantes6=$asignacion['VACANTES'];
            }

            $iguales="false";
            for($i=0;$i<sizeof($numeros);$i++){
                for($j=0;$j<sizeof($numeros);$j++){
                    if($i!=$j){
                        if($numeros[$i]==$numeros[$j]){
                            $iguales="true";
                        }
                    }
                }
            }

            $modIguales="false";
            for($i=0;$i<sizeof($modulos);$i++){
                for($j=0;$j<sizeof($modulos);$j++){
                    if($i!=$j){
                        if($modulos[$i]==$modulos[$j]){
                            $modIguales="true";
                        }
                    }
                }
            }

            $vac="true";
            for($i=0;$i<sizeof($vacantes);$i++){
                if($vacantes[$i]==0){
                    $vac="false";
                }
            }
            

            if($alumno==0){
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un error inesperado",
                    "Texto"=>"No ha seleccionado un alumno para esta matrícula",
                    "Tipo"=>"error"
                ];
            }
            else{

                if($asignacion1==0 && $asignacion2==0 && $asignacion3==0 && $asignacion4==0 && $asignacion5==0 && $asignacion6==0)
                {
                    $alerta = [
                        "Alerta"=>"simple",
                        "Titulo"=>"Ocurrio un error inesperado",
                        "Texto"=>"No ha seleccionado módulos para la matrícula",
                        "Tipo"=>"error"
                    ]; 
                }
                else{

                    if($iguales=="true"){
                        $alerta = [
                            "Alerta"=>"simple",
                            "Titulo"=>"Ocurrio un error inesperado",
                            "Texto"=>"Alguno de los grupos seleccionados se repiten",
                            "Tipo"=>"error"
                        ]; 
                    }
                    else{
                        if($modIguales=="true"){
                            $alerta = [
                                "Alerta"=>"simple",
                                "Titulo"=>"Ocurrio un error inesperado",
                                "Texto"=>"Alguno de los módulos seleccionados se repiten",
                                "Tipo"=>"error"
                            ];
                        }
                        else{
                            if($vac=="false"){
                                $alerta = [
                                    "Alerta"=>"simple",
                                    "Titulo"=>"Ocurrio un error inesperado",
                                    "Texto"=>"Alguno de los módulos seleccionados no cuenta con vacantes",
                                    "Tipo"=>"error"
                                ];
                            }
                            else{

                                if($asignacion1!=0){
                                    $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asignaciones WHERE ID_ASIGNACION=$asignacion1");
                                    $asignacion=$consulta->fetch();
                                    $mod = $asignacion['ID_MODULO'];
                                    $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM modulos WHERE ID_MODULO=$mod");
                                    $modul=$consulta->fetch();
                                    $total=$total+$modul['PRECIO_MODULO'];
                                }
                                if($asignacion2!=0){
                                    $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asignaciones WHERE ID_ASIGNACION=$asignacion2");
                                    $asignacion=$consulta->fetch();
                                    $mod = $asignacion['ID_MODULO'];
                                    $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM modulos WHERE ID_MODULO=$mod");
                                    $modul=$consulta->fetch();
                                    $total=$total+$modul['PRECIO_MODULO'];
                                }
                                if($asignacion3!=0){
                                    $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asignaciones WHERE ID_ASIGNACION=$asignacion3");
                                    $asignacion=$consulta->fetch();
                                    $mod = $asignacion['ID_MODULO'];
                                    $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM modulos WHERE ID_MODULO=$mod");
                                    $modul=$consulta->fetch();
                                    $total=$total+$modul['PRECIO_MODULO'];
                                }
                                if($asignacion4!=0){
                                    $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asignaciones WHERE ID_ASIGNACION=$asignacion4");
                                    $asignacion=$consulta->fetch();
                                    $mod = $asignacion['ID_MODULO'];
                                    $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM modulos WHERE ID_MODULO=$mod");
                                    $modul=$consulta->fetch();
                                    $total=$total+$modul['PRECIO_MODULO'];
                                }
                                if($asignacion5!=0){
                                    $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asignaciones WHERE ID_ASIGNACION=$asignacion5");
                                    $asignacion=$consulta->fetch();
                                    $mod = $asignacion['ID_MODULO'];
                                    $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM modulos WHERE ID_MODULO=$mod");
                                    $modul=$consulta->fetch();
                                    $total=$total+$modul['PRECIO_MODULO'];
                                }
                                if($asignacion6!=0){
                                    $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM asignaciones WHERE ID_ASIGNACION=$asignacion6");
                                    $asignacion=$consulta->fetch();
                                    $mod = $asignacion['ID_MODULO'];
                                    $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM modulos WHERE ID_MODULO=$mod");
                                    $modul=$consulta->fetch();
                                    $total=$total+$modul['PRECIO_MODULO'];
                                }

                                $consulta1=mainModel::ejecutar_consulta_simple("SELECT * FROM matriculas WHERE ESTADO_MATRICULA='Activo' AND ANIO=$anio AND ID_ALUMNO=$alumno");
                                        $matricula = $consulta1->fetchAll();
                                        $procede="true";
                                        foreach ($matricula as $valor) {
                                            $mat=$valor['CODIGO_MATRICULA'];
                                            $consulta1=mainModel::ejecutar_consulta_simple("SELECT * FROM matricula_detalle WHERE CODIGO_MATRICULA='$mat'");
                                            $asignaciones=$consulta1->fetchAll();
                                            foreach ($asignaciones as $row) {
                                                if($asignacion1!=0){
                                                    $consulta2=mainModel::ejecutar_consulta_simple("SELECT * FROM asignaciones WHERE ID_ASIGNACION=$asignacion1");
                                                    $asig1 = $consulta2->fetch();

                                                    $cod=$row['ID_ASIGNACION'];
                                                    $consulta3=mainModel::ejecutar_consulta_simple("SELECT * FROM asignaciones WHERE ID_ASIGNACION=$cod");
                                                    $asig2 = $consulta3->fetch();

                                                    if($asig1['ID_MODULO']==$asig2['ID_MODULO']){
                                                        $procede="false";
                                                    }
                                                }
                                                if($asignacion2!=0){
                                                    $consulta2=mainModel::ejecutar_consulta_simple("SELECT * FROM asignaciones WHERE ID_ASIGNACION=$asignacion2");
                                                    $asig1 = $consulta2->fetch();

                                                    $cod=$row['ID_ASIGNACION'];
                                                    $consulta3=mainModel::ejecutar_consulta_simple("SELECT * FROM asignaciones WHERE ID_ASIGNACION=$cod");
                                                    $asig2 = $consulta3->fetch();
                                                    if($asig1['ID_MODULO']==$asig2['ID_MODULO']){
                                                        $procede="false";
                                                    }
                                                }
                                                if($asignacion3!=0){
                                                    $consulta2=mainModel::ejecutar_consulta_simple("SELECT * FROM asignaciones WHERE ID_ASIGNACION=$asignacion3");
                                                    $asig1 = $consulta2->fetch();

                                                    $cod=$row['ID_ASIGNACION'];
                                                    $consulta3=mainModel::ejecutar_consulta_simple("SELECT * FROM asignaciones WHERE ID_ASIGNACION=$cod");
                                                    $asig2 = $consulta3->fetch();
                                                    if($asig1['ID_MODULO']==$asig2['ID_MODULO']){
                                                        $procede="false";
                                                    }
                                                }
                                                if($asignacion4!=0){
                                                    $consulta2=mainModel::ejecutar_consulta_simple("SELECT * FROM asignaciones WHERE ID_ASIGNACION=$asignacion4");
                                                    $asig1 = $consulta2->fetch();

                                                    $cod=$row['ID_ASIGNACION'];
                                                    $consulta3=mainModel::ejecutar_consulta_simple("SELECT * FROM asignaciones WHERE ID_ASIGNACION=$cod");
                                                    $asig2 = $consulta3->fetch();
                                                    if($asig1['ID_MODULO']==$asig2['ID_MODULO']){
                                                        $procede="false";
                                                    }
                                                }
                                                if($asignacion5!=0){
                                                    $consulta2=mainModel::ejecutar_consulta_simple("SELECT * FROM asignaciones WHERE ID_ASIGNACION=$asignacion5");
                                                    $asig1 = $consulta2->fetch();

                                                    $cod=$row['ID_ASIGNACION'];
                                                    $consulta3=mainModel::ejecutar_consulta_simple("SELECT * FROM asignaciones WHERE ID_ASIGNACION=$cod");
                                                    $asig2 = $consulta3->fetch();
                                                    if($asig1['ID_MODULO']==$asig2['ID_MODULO']){
                                                        $procede="false";
                                                    }
                                                }
                                                if($asignacion6!=0){
                                                    $consulta2=mainModel::ejecutar_consulta_simple("SELECT * FROM asignaciones WHERE ID_ASIGNACION=$asignacion6");
                                                    $asig1 = $consulta2->fetch();

                                                    $cod=$row['ID_ASIGNACION'];
                                                    $consulta3=mainModel::ejecutar_consulta_simple("SELECT * FROM asignaciones WHERE ID_ASIGNACION=$cod");
                                                    $asig2 = $consulta3->fetch();
                                                    if($asig1['ID_MODULO']==$asig2['ID_MODULO']){
                                                        $procede="false";
                                                    }
                                                }
                                                /*if($row['ID_ASIGNACION']==$asignacion1 || $row['ID_ASIGNACION']==$asignacion2 || $row['ID_ASIGNACION']==$asignacion3 || $row['ID_ASIGNACION']==$asignacion4){
                                                    $procede="false";
                                                }*/
                                            }
                                        }

                                        $consulta1=mainModel::ejecutar_consulta_simple("SELECT ID_MATRICULA FROM matriculas");
                                        $numero = ($consulta1->rowCount())+124;
                                        $codigoMatricula = mainModel::generar_codigo_aleatorio("MAT",5,$numero);

                                        if($pagante==1){
                                            if($adelanto>=$total){
                                                $pagado="Cancelado";
                                            }
                                            else{
                                                $pagado="No Cancelado";
                                            }  
                                        }
                                        else{
                                            $total=0;
                                            $pagado = "Cancelado";
                                        }
                                        

                                        $vacantes1--;
                                        $vacantes2--;
                                        $vacantes3--;
                                        $vacantes4--;
                                        $vacantes5--;
                                        $vacantes6--;

                                        session_start(['name'=>'CSM']);
                                        $codOperador=$_SESSION['codigo_cuenta_csm'];
                                        if($procede=="true"){
                                            $datosMatricula=[
                                                "Codigo"=>$codigoMatricula,
                                                "EstadoMatricula"=>"Activo",
                                                "EstadoPago"=>$pagado,
                                                "Total"=>$total,
                                                "Adelanto"=>$adelanto,
                                                "Fecha"=>$fecha,
                                                 "Anio"=>$anio,
                                                "Alumno"=>$alumno,
                                                "Asignacion1"=>$asignacion1,
                                                "Asignacion2"=>$asignacion2,
                                                "Asignacion3"=>$asignacion3,
                                                "Asignacion4"=>$asignacion4,
                                                "Asignacion5"=>$asignacion5,
                                                "Asignacion6"=>$asignacion6,
                                                "Vacantes1"=>$vacantes1,
                                                "Vacantes2"=>$vacantes2,
                                                "Vacantes3"=>$vacantes3,
                                                "Vacantes4"=>$vacantes4,
                                                "Vacantes5"=>$vacantes5,
                                                "Vacantes6"=>$vacantes6,
                                                "Operador"=>$codOperador
                                            ];

                                            $guardarMatricula=matriculaModelo::agregar_matricula_modelo($datosMatricula);
                                            if(($guardarMatricula->rowCount())>=1){
                                                $alerta = [
                                                    "Alerta"=>"recargar",
                                                    "Titulo"=>"Matrícula realizada",
                                                    "Texto"=>"La matrícula se realizó con éxito en el sistema.",
                                                    "Tipo"=>"success"
                                                ];
                                                
                                                //echo '<script> window.open("'.SERVERURL.'administradorMatriculaPDF/"'.$codigoMatricula.',"_blank"); </script>';

                                            }
                                            else{
                                                $alerta = [
                                                    "Alerta"=>"simple",
                                                    "Titulo"=>"Ocurrio un error inesperado",
                                                    "Texto"=>"No hemos podido realizar la matrícula correspondiente.",
                                                    "Tipo"=>"error"
                                                ];
                                            } 
                                        }
                                        else{
                                            $alerta = [
                                                "Alerta"=>"simple",
                                                "Titulo"=>"Ocurrio un error inesperado",
                                                "Texto"=>"Este alumno ya se encuentra matriculado en uno de los módulos selecionados",
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

        //Esta funcione permite encontrar todas las matriculas de un alumno
        public function paginador_matriculas_alumno_controlador($privilegio, $codigoAdmin, $buscar){
            $cadena=$buscar;
            $tabla='';

            $tabla.='
                <table class="table table-hover table-sm table-responsive">
                    <thead class="table-secondary">
                        <tr>
                            <th width="4%">No</th>
                            <th width="6%">Codigo</th>
                            <th width="11%">Fecha</th>
                            <th >Alumno</th>
                            <th width="4%">Total</th>
                            <th width="4%">Deuda</th>
                            <th width="5%" align="center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>'
            ;

            $conexion = mainModel::conectar();
            $alumnos = $conexion->prepare("
                SELECT * FROM alumnos WHERE APELLIDOS_ALUMNO='$buscar' OR NOMBRES_ALUMNO='$buscar' OR DNI_ALUMNO='$buscar'
            ");
            $alumnos->execute();
            $alumnos = $alumnos->fetchAll();

            $numAlumnos=0;
            $numMatriculas=0;
            $contador = 1;
            foreach ($alumnos as $alumno){
                $numAlumnos++;
                $idAlumno = $alumno['ID_ALUMNO'];

                $matriculas = $conexion->prepare("
                    SELECT * FROM matriculas WHERE ID_ALUMNO=$idAlumno
                ");
                $matriculas->execute();
                $matriculas = $matriculas->fetchAll();

                foreach ($matriculas as $matricula) {
                    $numMatriculas++;

                    $resta=$matricula['TOTAL']-$matricula['ADELANTO'];
                    $codigoMatricula=$matricula['CODIGO_MATRICULA'];
                    $consulta1 = mainModel::ejecutar_consulta_simple("SELECT * FROM matricula_detalle WHERE CODIGO_MATRICULA='$codigoMatricula'");
                    $detalles=$consulta1->fetchAll();

                    $tabla.='<tr>
                            <td class="align-middle">'.$contador.'</td>
                            <td class="align-middle">'.$matricula['CODIGO_MATRICULA'].'</td>
                            <td class="align-middle">'.$matricula['FECHA'].'</td>
                            <td class="align-middle">'.$alumno['APELLIDOS_ALUMNO'].' '.$alumno['NOMBRES_ALUMNO'].'</td>
                            <td class="align-middle">'.$matricula['TOTAL'].'</td>
                            <td class="align-middle">'.$resta.'</td>
                            <td class="align-middle text-center">
                                <form style="display:inline">
                                    <a href="'.SERVERURL.'administradorMatriculaReporte/'.$matricula['CODIGO_MATRICULA'].'" title="Ver / Actualizar Saldo" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                                </form>
                            </td>
                        </tr>
                    ';

                    $contador++;
                }
            }

            if($numAlumnos>0 && $numMatriculas==0){
                $tabla.='
                    <tr><td colspan="7" align="center">No se encontraron matrículas para este Alumno</td></tr>
                ';
            }
            if($numAlumnos==0){
                $tabla.='
                    <tr><td colspan="7" align="center">Alumno no encontrado</td></tr>
                ';
            }

            $tabla.='
                    </tbody>
                </table>
            ';
            return $tabla;
        }

        public function paginador_matriculas_nocanceladas_controlador($privilegio, $codigoAdmin, $especialidad1){
            $privilegio=mainModel::limpiar_cadena($privilegio);
            $codigoAdmin=mainModel::limpiar_cadena($codigoAdmin);
            $tabla="";
            $anoActual=date("Y");
            $especialidad=$especialidad1;

            $totalDeuda=0;

            $mysqli = new mysqli(SERVER,USER,PASS,DB);
            $conexion = mainModel::conectar();

            $datos = $conexion->prepare("
                SELECT SQL_CALC_FOUND_ROWS * FROM matriculas WHERE ESTADO_PAGO='No cancelado' ORDER BY FECHA ASC
            ");
            $datos->execute();
            $datos = $datos->fetchAll();

            $total = $conexion->query("SELECT FOUND_ROWS()");
            $total = (int) $total->fetchColumn();

            $tabla.='
                <table class="table table-hover table-sm table-responsive">
                    <thead class="table-secondary">
                        <tr>
                            <th width="4%">No</th>
                            <th width="11%">Fecha</th>
                            <th >Alumno</th>
                            <th width="4%">Total</th>
                            <th width="4%">Adelanto</th>
                            <th width="4%">Deuda</th>
                            <th width="5%">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>'
            ;

            if($total>=1){
                $contador = 1;
                foreach ($datos as $row) {
                    $codigo=$row['ID_ALUMNO'];
                    $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM alumnos WHERE ID_ALUMNO=$codigo");
                    $alu=$consulta->fetch();
                    $resta=$row['TOTAL']-$row['ADELANTO'];

                    if($resta>0){
                        $codigoMatricula=$row['CODIGO_MATRICULA'];
                        $consulta1 = mainModel::ejecutar_consulta_simple("SELECT * FROM matricula_detalle WHERE CODIGO_MATRICULA='$codigoMatricula'");
                        $detalles=$consulta1->fetchAll();

                        $encontrado="falso";
                        foreach ($detalles as $detalle) {
                            
                            $idAsignacion=$detalle['ID_ASIGNACION'];
                            $consulta2 = mainModel::ejecutar_consulta_simple("SELECT * FROM asignaciones WHERE ID_ASIGNACION=$idAsignacion");
                            $asignacion=$consulta2->fetch();

                            $idModulo=$asignacion['ID_MODULO'];
                            $consulta3 = mainModel::ejecutar_consulta_simple("SELECT * FROM modulos WHERE ID_MODULO=$idModulo");
                            $modulo=$consulta3->fetch();
                            
                            if($especialidad==0){
                                $encontrado="verdadero";
                            }
                            else{
                                if($modulo['ID_ESPECIALIDAD']==$especialidad){
                                    $encontrado="verdadero";
                                }   
                            }

                        }

                        if($encontrado=="verdadero"){
                            $totalDeuda=$totalDeuda+$resta;
                            $tabla.='
                            <tr>
                                <td class="align-middle">'.$contador.'</td>
                                <td class="align-middle">'.$row['FECHA'].'</td>
                                <td class="align-middle">'.$alu['APELLIDOS_ALUMNO'].' '.$alu['NOMBRES_ALUMNO'].'</td>
                                <td class="align-middle">'.$row['TOTAL'].'</td>
                                <td class="align-middle">'.$row['ADELANTO'].'</td>
                                <td class="align-middle">'.$resta.'</td>
                                <td class="align-middle text-center">
                                    <form style="display:inline">
                                        <a href="'.SERVERURL.'administradorMatriculaReporte/'.$row['CODIGO_MATRICULA'].'" title="Ver / Actualizar Saldo" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                                    </form>
                                    <!--<form style="display:inline">
                                        <button type="button" class="btn btn-danger btn-sm" title="Ver" data-toggle="modal" data-target="#myModal'.$contador.'"><i class="far fa-eye"></i></button>
                                        
                                        <div class="modal fade" id="myModal'.$contador.'">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                              
                                                    
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Código de matrícula: '.$row['CODIGO_MATRICULA'].'</h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>
                                                
                                                    
                                                    <div class="modal-body">
                                                        
                                                        <div class="form-row">
                                                            <div class="form-group col-md-4">
                                                                <br><br>
                                                                <label class="titulo-label">Estado:</label>';
                                                                
                                                                    if($row['ESTADO_PAGO']=="Cancelado"){
                                                                        $tabla.= '<label class="titulo-label text-success">'.$row['ESTADO_PAGO'].'</label>';
                                                                    }
                                                                    else{
                                                                        $tabla.= '<label class="titulo-label text-danger">'.$row['ESTADO_PAGO'].'</label>';
                                                                    }
                                                                
                                                            $tabla.='</div>
                                                        </div>


                                                        <div class="form-row">
                                                            <div class="form-group col-md-9">
                                                                <label class="titulo-label">Alumno</label>
                                                                <input type="text" class="form-control" name="alumno" required style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" value="'.$alu['APELLIDOS_ALUMNO'].', '.$alu['NOMBRES_ALUMNO'].'">
                                                            </div>
                                                            <div class="form-group col-md-3">
                                                                <label class="titulo-label">Código de Matrícula:</label>
                                                                <input type="text" class="form-control" name="codigo-matricula">          
                                                            </div>
                                                            <div class="form-group col-md-3">
                                                                <label class="titulo-label">Fecha</label>
                                                                <input type="date" class="form-control" name="fecha" value="'.$row['FECHA'].'" required>
                                                            </div>
                                                        </div>
                                                        <br>

                                                        <table class="table table-hover table-sm">
                                                            <thead class="table-secondary">
                                                                <tr>
                                                                    <th scope="col">Módulo</th>
                                                                    <th scope="col" width="2%">Grupo</th>
                                                                    <th scope="col" width="25%">Frecuencia</th>
                                                                    <th scope="col" width="12%">Hora</th>
                                                                    <th scope="col" width="2%">Turno</th>
                                                                    <th scope="col" width="3%">Precio</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>';

                                                                    $cod=$row['CODIGO_MATRICULA'];
                                                                    $consulta2=$mysqli->query("SELECT * FROM matricula_detalle WHERE CODIGO_MATRICULA='$cod'");
                                                                    while($detalle = $consulta2->fetch_assoc()) {
                                                                        $idAsignacion = $detalle['ID_ASIGNACION'];
                                                                        $consulta3=$mysqli->query("SELECT * FROM asignaciones WHERE ID_ASIGNACION=$idAsignacion");
                                                                        $asignacion = $consulta3->fetch_assoc();

                                                                        $idModulo = $asignacion['ID_MODULO'];
                                                                        $consulta4=$mysqli->query("SELECT * FROM modulos WHERE ID_MODULO=$idModulo");
                                                                        $modulo = $consulta4->fetch_assoc();

                                                                        $idFrecuencia = $asignacion['ID_FRECUENCIA'];
                                                                        $consulta5=$mysqli->query("SELECT * FROM frecuencias WHERE ID_FRECUENCIA=$idFrecuencia");
                                                                        $frecuencia = $consulta5->fetch_assoc();

                                                                        $hi=$asignacion['HORA_INICIO'];
                                                                        $hf=$asignacion['HORA_FIN'];
                                                                        $hi=substr($hi,0,5);
                                                                        $hf=substr($hf,0,5);
                                                                        $hora=$hi."-".$hf;
                                                                        $tabla.= '
                                                                            <tr>
                                                                                <td class="align-middle">'.$modulo['NOMBRE_MODULO'].'</td>
                                                                                <td class="align-middle">'.$asignacion['GRUPO'].'</td>
                                                                                <td class="align-middle">'.$frecuencia['NOMBRE_FRECUENCIA'].'</td>
                                                                                <td class="align-middle">'.$hora.'</td>
                                                                                <td class="align-middle">'.$asignacion['TURNO'].'</td>
                                                                                <td class="align-middle">'.$modulo['PRECIO_MODULO'].'</td>
                                                                            </tr>
                                                                        ';
                                                                    }
                                                                
                                                            $tabla.='</tbody>
                                                        </table>
                                                        <br>';

                                                         
                                                            if($row['ESTADO_PAGO']!="Cancelado"){
                                                                $resta=$row['TOTAL']-$row['ADELANTO'];
                                                                $tabla.= '<div class="form-row">
                                                                        <div class="form-group col-md-4">
                                                                            <label class="titulo-label">Adelanto: '.$row['ADELANTO'].'</label> 
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-row">
                                                                        <div class="form-group col-md-4">
                                                                            <label class="titulo-label">Resta: '.$resta.'</label> 
                                                                        </div>
                                                                    </div>';
                                                            }

                                                    $tabla.='</div>
                                                
                                                     Modal footer
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>-->
                                </td>';

                            $tabla.='
                            </tr>
                            ';

                            $contador++;
                        }
                    }
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

            $tabla.='
                <br>
                <div align="right" class="font-weight-bold">TOTAL DEUDAS: S/. '.$totalDeuda.'</div><br>   
            ';

            return $tabla;
        }

        public function paginador_alumnos_matriculados_controlador($privilegio, $codigoAdmin, $modulo, $grupo){
            $privilegio=mainModel::limpiar_cadena($privilegio);
            $codigoAdmin=mainModel::limpiar_cadena($codigoAdmin);
            $modulo=mainModel::limpiar_cadena($modulo);
            $grupo=mainModel::limpiar_cadena($grupo);
            $tabla="";
            $anoActual=date("Y");

            $mysqli = new mysqli(SERVER,USER,PASS,DB);
            $conexion = mainModel::conectar();


            $moduloEncontrado="false";
            $grupoEncontrado="false";
            $idDocente;
            $asignacionEncontrada;
            $todasAsignaciones = $conexion->prepare("
                SELECT * FROM asignaciones WHERE ESTADO='Activo'
            ");
            $todasAsignaciones->execute();
            $todasAsignaciones = $todasAsignaciones->fetchAll(); 

            foreach ($todasAsignaciones as $filaAsignacion) {
                if($filaAsignacion['ID_MODULO']==$modulo){
                    $moduloEncontrado="true";
                    if($filaAsignacion['GRUPO']==$grupo){
                        $grupoEncontrado="true";
                        $asignacionEncontrada=$filaAsignacion;
                    }
                }
            }

            if($moduloEncontrado=="false"){
            
                return "<br><br><div align='center'><h4>No se ha realizado una asignación de docente a este módulo.</h4></div>";
            }
            else{
                if($grupoEncontrado=="false"){
                    return "<br><br><div align='center'><h4>No existe grupo ".$grupo." para este módulo.</h4></div>";
                }
                else{
                    $idDocente=$asignacionEncontrada['ID_DOCENTE'];
                    $idFrecuencia=$asignacionEncontrada['ID_FRECUENCIA'];

                    $datosDocente = $conexion->prepare("
                        SELECT * FROM docentes WHERE ID_DOCENTE=$idDocente
                    ");
                    $datosDocente->execute();
                    $datosDocente = $datosDocente->fetch();

                    $datosFrecuencia = $conexion->prepare("
                        SELECT * FROM frecuencias WHERE ID_FRECUENCIA=$idFrecuencia
                    ");
                    $datosFrecuencia->execute();
                    $datosFrecuencia = $datosFrecuencia->fetch();

                    $datosModulo = $conexion->prepare("
                        SELECT * FROM modulos WHERE ID_MODULO=$modulo
                    ");
                    $datosModulo->execute();
                    $datosModulo = $datosModulo->fetch();

                    $idEspecialidad = $datosModulo['ID_ESPECIALIDAD'];
                    $datosEspecialidad = $conexion->prepare("
                        SELECT * FROM especialidades WHERE ID_ESPECIALIDAD=$idEspecialidad
                    ");
                    $datosEspecialidad->execute();
                    $datosEspecialidad = $datosEspecialidad->fetch();

                    $idAsignacion=$asignacionEncontrada['ID_ASIGNACION'];
                    $datos = $conexion->prepare("
                        SELECT a.ID_ALUMNO, a.APELLIDOS_ALUMNO, a.NOMBRES_ALUMNO, a.SEXO_ALUMNO, a.FECHA_NACIMIENTO_ALUMNO, a.CODIGO_CUENTA_ALUMNO, a.CONDICION_ALUMNO, a.CODIGO_NOMINAB, a.CODIGO_NOMINAI, m.CODIGO_MATRICULA, d.ID_ASIGNACION 
                            FROM alumnos a JOIN matriculas m ON m.ID_ALUMNO = a.ID_ALUMNO 
                            JOIN matricula_detalle d ON d.CODIGO_MATRICULA = m.CODIGO_MATRICULA 
                            WHERE d.ID_ASIGNACION=$idAsignacion ORDER BY a.APELLIDOS_ALUMNO
                        ");
                    $datos->execute();
                    $datos = $datos->fetchAll();

                    $total = $conexion->query("SELECT FOUND_ROWS()");
                    $total = (int) $total->fetchColumn();

                    //session_start(['name'=>'CSM']);
                    
                    $turno="";
                    if($asignacionEncontrada['TURNO']="M"){
                        $turno="MAÑANA";
                    }
                    else{
                        $turno="TARDE";
                    }

                    $hi=$asignacionEncontrada['HORA_INICIO'];
                    $hf=$asignacionEncontrada['HORA_FIN'];
                    $hi=substr($hi,0,5);
                    $hf=substr($hf,0,5);
                    $hora=$hi.'-'.$hf;

                    $tabla.='
                        <br><table style="margin: 0px auto; width: 785px; font-size: 13px;">
                                <tr>
                                    <td width="15%"><strong>MÓDULO</strong></td>
                                    <td width="55%">:'.$datosModulo['NOMBRE_MODULO'].'</td>
                                    <td width="30%"></td>
                                </tr>
                                <tr>
                                    <td width="15%"><strong>ESPECIALIDAD</strong></td>
                                    <td width="55%">:'.$datosEspecialidad['NOMBRE_ESPECIALIDAD'].'</td>
                                    <td width="30%" rowspan="4">
                                        <div class="form-row"> 
                                            <div class="form-group col-md-6">
                                                <form action="'.SERVERURL.'administradorReporteAlumnosMatriculadosEXCEL" method="post" target="_blank">
                                                    <input type="hidden" name="reporte_name" value="RELACIÓN DE ALUMNOS">
                                                    <input type="hidden" name="modulo" value="'.$modulo.'">
                                                    <input type="hidden" name="grupo" value="'.$grupo.'">
                                                    <input type="hidden" name="nombre-modulo" value="'.$datosModulo['NOMBRE_MODULO'].'">
                                                    <input type="hidden" name="nombre-especialidad" value="'.$datosEspecialidad['NOMBRE_ESPECIALIDAD'].'">
                                                    <input type="hidden" name="apellidos-docente" value="'.$datosDocente['APELLIDOS_DOCENTE'].'">
                                                    <input type="hidden" name="nombres-docente" value="'.$datosDocente['NOMBRES_DOCENTE'].'">
                                                    <input type="hidden" name="nombre-frecuencia" value="'.$datosFrecuencia['NOMBRE_FRECUENCIA'].'">
                                                    <input type="hidden" name="hora" value="'.$hora.'">
                                                    <input type="hidden" name="turno" value="'.$turno.'">
                                                    <input type="hidden" name="asignacion" value="'.$asignacionEncontrada['ID_ASIGNACION'].'">
                                                    <input type="hidden" name="nivel" value="'.$datosModulo['NIVEL_MODULO'].'">
                                                    <button type="submit" class="btn boton-registrar btn-success w-100" name="create_pdf"><i class="fas fa-file-excel"></i> Excel</button>
                                                </form>
                                            </div>
            
                                            <div class="form-group col-md-6">
                                                <form action="'.SERVERURL.'administradorReporteAlumnosMatriculadosPDF" method="post" target="_blank">
                                                    <input type="hidden" name="reporte_name" value="RELACIÓN DE ALUMNOS">
                                                    <input type="hidden" name="modulo" value="'.$modulo.'">
                                                    <input type="hidden" name="grupo" value="'.$grupo.'">
                                                    <input type="hidden" name="nombre-modulo" value="'.$datosModulo['NOMBRE_MODULO'].'">
                                                    <input type="hidden" name="nombre-especialidad" value="'.$datosEspecialidad['NOMBRE_ESPECIALIDAD'].'">
                                                    <input type="hidden" name="apellidos-docente" value="'.$datosDocente['APELLIDOS_DOCENTE'].'">
                                                    <input type="hidden" name="nombres-docente" value="'.$datosDocente['NOMBRES_DOCENTE'].'">
                                                    <input type="hidden" name="nombre-frecuencia" value="'.$datosFrecuencia['NOMBRE_FRECUENCIA'].'">
                                                    <input type="hidden" name="hora" value="'.$hora.'">
                                                    <input type="hidden" name="turno" value="'.$turno.'">
                                                    <input type="hidden" name="asignacion" value="'.$asignacionEncontrada['ID_ASIGNACION'].'">
                                                    <input type="hidden" name="nivel" value="'.$datosModulo['NIVEL_MODULO'].'">
                                                    <button type="submit" class="btn boton-registrar btn-success w-100" name="create_pdf"><i class="fas fa-file-pdf"></i> PDF</button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="15%"><strong>DOCENTE</strong></td>
                                    <td width="55%">:'.$datosDocente['APELLIDOS_DOCENTE'].', '.$datosDocente['NOMBRES_DOCENTE'].'</td>
                                </tr>';


                    $tabla.='
                            <tr>
                                <td width="15%"><strong>FRECUENCIA</strong></td>
                                <td width="55%">:'.$datosFrecuencia['NOMBRE_FRECUENCIA'].'</td>
                            </tr>
                            <tr>
                                <td width="15%"><strong>HORARIO</strong></td>
                                <td width="55%">:'.$hora.'</td>
                            </tr>
                            <tr>
                                <td width="15%"><strong>TURNO</strong></td>
                                <td width="55%">:'.$turno.'</td>
                                <td width="30%"></td>
                            </tr>
                        </table>


                        <br>
                        <table class="table table-hover table-sm">
                            <thead class="table-secondary">
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="17%">Código</th>
                                    <th>Apellidos y Nombres</th>
                                </tr>
                            </thead>
                            <tbody>'
                    ;
                    

                    if($total>=1){
                        $contador = 1;
                        foreach ($datos as $row) {
                            
                            $tabla.='
                                    <tr>
                                        <td class="align-middle">'.$contador.'</td>
                            ';
                            
                            if($datosModulo['NIVEL_MODULO']=="B"){
                                $tabla.='<td class="align-middle">'.$row['CODIGO_NOMINAB'].'</td> ';
                            }
                            else{
                                $tabla.='<td class="align-middle">'.$row['CODIGO_NOMINAI'].'</td>';
                            }
                            
                            $tabla.='        
                                        <td class="align-middle">'.$row['APELLIDOS_ALUMNO'].', '.$row['NOMBRES_ALUMNO'].'</td>
                                    </tr>
                            ';

                            $contador++;

                            /*$mat=$row['CODIGO_MATRICULA'];
                            $detalle = $conexion->prepare("
                                SELECT * FROM matricula_detalle WHERE CODIGO_MATRICULA='$mat'
                            ");
                            $detalle->execute();
                            $detalle = $detalle->fetchAll();

                            foreach ($detalle as $matDetalle) {

                                $idAsig=$matDetalle['ID_ASIGNACION'];
                                $asigN = $conexion->prepare("
                                    SELECT * FROM asignaciones WHERE ID_ASIGNACION=$idAsig
                                ");
                                $asigN->execute();
                                $asigN = $asigN->fetch();

                                if($asigN['ID_MODULO']==$modulo && $asigN['GRUPO']==$grupo){
                                    $codigo=$row['ID_ALUMNO'];
                                    $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM alumnos WHERE ID_ALUMNO=$codigo");
                                    $alu=$consulta->fetch();

                                    //$data=explode(" ",$alu['APELLIDOS_ALUMNO']);
                                    
                                }
                            }*/
                        }
                    }
                    else{
                        $tabla.='
                            <tr>
                                <td colspan="4" align="center">No hay registros para mostrar</td>
                            </tr>
                        ';      
                    }

                    $tabla.='</tbody>
                            </table>';

                    return $tabla;
                }    
            } 
        }
        
        public function paginador_alumnos_matriculados_especialidad_controlador($privilegio, $codigoAdmin, $especialidad1){
            $privilegio=mainModel::limpiar_cadena($privilegio);
            $codigoAdmin=mainModel::limpiar_cadena($codigoAdmin);
            $especialidad=mainModel::limpiar_cadena($especialidad1);
            $tabla="";
            $anoActual=date("Y");

            $mysqli = new mysqli(SERVER,USER,PASS,DB);
            $conexion = mainModel::conectar();

            $idDocente;
            $asignacionEncontrada="falso";
            $todasAsignaciones = $conexion->prepare("
                SELECT * FROM asignaciones WHERE ESTADO='Activo'
            ");
            $todasAsignaciones->execute();
            $todasAsignaciones = $todasAsignaciones->fetchAll(); 
            $idDocente=0;

            foreach ($todasAsignaciones as $filaAsignacion) {
                $idModulo=$filaAsignacion['ID_MODULO']; 
                $modulo = $conexion->prepare("
                    SELECT * FROM modulos WHERE ESTADO='Activo' AND ID_MODULO=$idModulo
                ");
                $modulo->execute();
                $modulo = $modulo->fetch(); 

                if($modulo['ID_ESPECIALIDAD']==$especialidad){
                    $asignacionEncontrada="verdadero";
                    $idDocente=$filaAsignacion['ID_DOCENTE'];
                } 
            }

            if($asignacionEncontrada=="false"){
            
                return "<br><br><div align='center'><h4>No se ha hecho asignaciones a algún módulo de esta especialidad.</h4></div>";
            }
            else{
                    $datosDocente = $conexion->prepare("
                        SELECT * FROM docentes WHERE ID_DOCENTE=$idDocente
                    ");
                    $datosDocente->execute();
                    $datosDocente = $datosDocente->fetch();

                    $datosEspecialidad = $conexion->prepare("
                        SELECT * FROM especialidades WHERE ID_ESPECIALIDAD=$especialidad
                    ");
                    $datosEspecialidad->execute();
                    $datosEspecialidad = $datosEspecialidad->fetch();

                    $datos = $conexion->prepare("
                        SELECT DISTINCT a.ID_ALUMNO, a.APELLIDOS_ALUMNO, a.NOMBRES_ALUMNO, a.SEXO_ALUMNO, a.FECHA_NACIMIENTO_ALUMNO, a.CODIGO_CUENTA_ALUMNO, a.CONDICION_ALUMNO, m.CODIGO_MATRICULA FROM alumnos a 
                        JOIN matriculas m ON m.ID_ALUMNO = a.ID_ALUMNO 
                        JOIN matricula_detalle d ON d.CODIGO_MATRICULA = m.CODIGO_MATRICULA 
                        JOIN asignaciones s ON s.ID_ASIGNACION = d.ID_ASIGNACION 
                        JOIN modulos o ON o.ID_MODULO = s.ID_MODULO 
                        WHERE o.ID_ESPECIALIDAD=$especialidad ORDER BY a.APELLIDOS_ALUMNO
                        ");
                    $datos->execute();
                    $datos = $datos->fetchAll();

                    $total = $conexion->query("SELECT FOUND_ROWS()");
                    $total = (int) $total->fetchColumn();

                    //session_start(['name'=>'CSM']);

                    $tabla.='
                        <br><table style="margin: 0px auto; width: 785px; font-size: 13px;">
                                <tr>
                                    <td width="12%"><strong>ESPECIALIDAD</strong></td>
                                    <td width="55%">:'.$datosEspecialidad['NOMBRE_ESPECIALIDAD'].'</td>
                                    <td width="33%">
                                        <div class="form-row"> 
                                            <div class="form-group col-md-6">
                                                <form action="'.SERVERURL.'administradorReporteAlumnosEspecialidadEXCEL" method="post" target="_blank">
                                                    <input type="hidden" name="reporte_name" value="RELACIÓN DE ALUMNOS">
                                                    <input type="hidden" name="nombre-especialidad" value="'.$datosEspecialidad['NOMBRE_ESPECIALIDAD'].'">
                                                    <input type="hidden" name="especialidad" value="'.$especialidad.'">
                                                    <button type="submit" class="btn boton-registrar btn-success w-100" name="create_pdf"><i class="fas fa-file-excel"></i> Excel</button>
                                                </form>
                                            </div>
            
                                            <div class="form-group col-md-6">
                                                <form action="'.SERVERURL.'administradorReporteAlumnosEspecialidadPDF" method="post" target="_blank">
                                                    <input type="hidden" name="reporte_name" value="RELACIÓN DE ALUMNOS">
                                                    <input type="hidden" name="nombre-especialidad" value="'.$datosEspecialidad['NOMBRE_ESPECIALIDAD'].'">
                                                    <input type="hidden" name="especialidad" value="'.$especialidad.'">
                                                    <button type="submit" class="btn boton-registrar btn-success w-100" name="create_pdf"><i class="fas fa-file-pdf"></i> PDF</button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                    ';


                    $tabla.='
                        </table>


                        <br>
                        <table class="table table-hover table-sm">
                            <thead class="table-secondary">
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="15%">Código</th>
                                    <th width="25%">Apellidos</th>
                                    <th width="55%">Nombres</th>
                                </tr>
                            </thead>
                            <tbody>'
                    ;

                    if($total>=1){
                        $contador = 1;
                        foreach ($datos as $row) {

                            $tabla.='
                                    <tr>
                                        <td class="align-middle">'.$contador.'</td>
                                        <td class="align-middle">'.$row['CODIGO_CUENTA_ALUMNO'].'</td>
                                        <td class="align-middle">'.$row['APELLIDOS_ALUMNO'].'</td>
                                        <td class="align-middle">'.$row['NOMBRES_ALUMNO'].'</td>
                                        ';

                                    $tabla.='
                                    </tr>
                                    ';
                                    $contador++;
                        }
                    }
                    else{
                        $tabla.='
                            <tr>
                                <td colspan="4" align="center">No hay registros para mostrar</td>
                            </tr>
                        ';      
                    }

                    $tabla.='</tbody>
                            </table>';

                    return $tabla;   
            } 
        }

        public function actualizar_saldo_controlador(){
            $id=$_POST['codigo'];
            $adelantoNuevo=$_POST['adelanto'];

            //echo $id;
            $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM matriculas WHERE CODIGO_MATRICULA=$id");
            $matricula=$consulta->fetch();
            $total=$matricula['TOTAL'];
            $adelanto=$matricula['ADELANTO'];
            $resta=$matricula['TOTAL']-$matricula['ADELANTO'];

            $estadoPago="";

            if($adelantoNuevo<=0){
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un error inesperado",
                    "Texto"=>"El valor ingresa no es válido",
                    "Tipo"=>"error"
                ];
            }
            else{
                if($adelantoNuevo>$resta){
                    $alerta = [
                        "Alerta"=>"simple",
                        "Titulo"=>"Ocurrio un error inesperado",
                        "Texto"=>"El valor ingresado supera la cantida de la deuda",
                        "Tipo"=>"error"
                    ];
                }
                else{
                    if($adelantoNuevo==$resta){
                        $estadoPago="Cancelado";
                    }
                    else{
                        $estadoPago="No Cancelado";
                    }

                    $nuevo=$adelantoNuevo+$matricula['ADELANTO'];
                    $datosMatricula=[
                        "Codigo"=>$id,
                        "Nuevo"=>$nuevo,
                        "Pagado"=>$estadoPago
                    ];

                    $actualizarMatricula=matriculaModelo::actualizar_saldo_modelo($datosMatricula);
                    if(($actualizarMatricula->rowCount())==1){
                        $alerta = [
                            "Alerta"=>"recargar",
                            "Titulo"=>"Matrícula actualizada",
                            "Texto"=>"El saldo se actualizó con éxito en el sistema.",
                            "Tipo"=>"success"
                        ];
                    }
                    else{
                        $alerta = [
                            "Alerta"=>"simple",
                            "Titulo"=>"Ocurrio un error inesperado",
                            "Texto"=>"No hemos podido realizar la actualización correspondiente.",
                            "Tipo"=>"error"
                        ];
                    } 
                }
            }

            return mainModel::sweet_alert($alerta);
        }
        
        public function paginador_ingreso_matriculas_controlador($privilegio, $codigoAdmin, $asig1, $fecha1, $fecha2){
            $privilegio=mainModel::limpiar_cadena($privilegio);
            $codigoAdmin=mainModel::limpiar_cadena($codigoAdmin);
            $especialidad=mainModel::limpiar_cadena($asig1);
            $fechai=mainModel::limpiar_cadena($fecha1);
            $fechaf=mainModel::limpiar_cadena($fecha2);
            
            $tabla="";
            $anoActual=date("Y");

            $mysqli = new mysqli(SERVER,USER,PASS,DB);
            $conexion = mainModel::conectar();
            
            $matriculas = $conexion->prepare("
                SELECT SQL_CALC_FOUND_ROWS * FROM matriculas WHERE FECHA BETWEEN '$fechai' AND '$fechaf' ORDER BY FECHA ASC"
            );
            $matriculas->execute();
            $matriculas = $matriculas->fetchAll();
            
            $total = $conexion->query("SELECT FOUND_ROWS()");
            $total = (int) $total->fetchColumn();
            
            $contador=1;
            $tabla='
                <table class="table table-hover table-sm">
                    <thead class="table-secondary">
                        <tr>
                            <th width="5%">No</th>
                            <th width="10%">Fecha</th>
                            <th>Apellidos y Nombres</th>
                            <th width="7%">Total</th>
                            <th width="7%">Adelanto</th>
                            <th width="7%">Deuda</th>
                            <th width="14%">Estado</th>
                            <th width="3%">Accion</th>
                        </tr>
                    </thead>
                    <tbody> 
            ';
            
            $montoTotal=0;
            $montoDeuda=0;
            
            if($fechaf<$fechai){
                $tabla.='
                    <tr><td align="center" colspan="8">La fecha final es menor a la inicial</td></tr>
                ';   
            }
            else{
                if($total==0){
                    $tabla.='
                        <tr><td align="center" colspan="8">No hay registros para mostrar</td></tr>
                    ';
                }
                else{
                    foreach($matriculas as $matricula){
                        $resta=$matricula['TOTAL']-$matricula['ADELANTO'];

                        $codigoMatricula = $matricula['CODIGO_MATRICULA'];
                        $detalles = $conexion->prepare("
                            SELECT * FROM matricula_detalle WHERE CODIGO_MATRICULA='$codigoMatricula'"
                        );   
                        $detalles->execute();
                        $detalles = $detalles->fetchAll();

                        $encontrado="falso";
                        foreach ($detalles as $detalle) {
                            
                            $idAsignacion = $detalle['ID_ASIGNACION'];
                            $asignacion = $conexion->prepare("
                                SELECT * FROM asignaciones WHERE ID_ASIGNACION=$idAsignacion"
                            );   
                            $asignacion->execute();
                            $asignacion = $asignacion->fetch();

                            $idModulo = $asignacion['ID_MODULO'];
                            $modulo = $conexion->prepare("
                                SELECT * FROM modulos WHERE ID_MODULO=$idModulo"
                            );   
                            $modulo->execute();
                            $modulo = $modulo->fetch();

                            if($especialidad==0){
                                $encontrado="verdadero";
                            }
                            else{
                                if($especialidad==$modulo['ID_ESPECIALIDAD']){
                                    $encontrado="verdadero";
                                }
                            }
                        }

                        if($encontrado=="verdadero"){

                            $idAlumno = $matricula['ID_ALUMNO'];
                            $alumno = $conexion->prepare("
                                SELECT * FROM alumnos WHERE ID_ALUMNO=$idAlumno"
                            );   
                            $alumno->execute();
                            $alumno = $alumno->fetch();
                            
                            if($resta<=0){
                                $resta=0;
                            }
                            
                            $montoTotal=$montoTotal+$matricula['ADELANTO'];
                            $montoDeuda=$montoDeuda+$resta;
                            
                            $fechas=explode("-",$matricula['FECHA']);
                            $fecha=$fechas[2]."/".$fechas[1]."/".$fechas[0];

                            $tabla.='
                                <tr>
                                    <td class="align-middle">'.$contador.'</td>
                                    <td class="align-middle">'.$fecha.'</td>
                                    <td class="align-middle">'.$alumno['APELLIDOS_ALUMNO'].', '.$alumno['NOMBRES_ALUMNO'].'</td>
                                    <td class="align-middle text-center">'.$matricula['TOTAL'].'</td>
                                    <td class="align-middle text-center">'.$matricula['ADELANTO'].'</td>
                                    <td class="align-middle text-center">'.$resta.'</td>
                            ';
                            
                            if($matricula['ESTADO_PAGO']=="Cancelado"){
                                $tabla.='
                                    <td class="text-success font-weight-bold align-middle">'.$matricula['ESTADO_PAGO'].'</td>
                                ';
                            }
                            else{
                                $tabla.='
                                    <td class="text-danger font-weight-bold align-middle">'.$matricula['ESTADO_PAGO'].'</td>
                                ';
                            }
                            
                            $tabla.='
                                    <td class="align-middle text-center">
                                        <form style="display:inline">
                                            <a href="'.SERVERURL.'administradorMatriculaReporte/'.$matricula['CODIGO_MATRICULA'].'" title="Ver" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                                        </form>
                                    </td>
                                </tr>
                            ';

                            $contador++;
                        }
                        
                    }
                }

            }
            
            $tabla.='
                    </tbody>
                </table>
            ';

            $tabla.='
                <br><div align="right" class="font-weight-bold">TOTAL INGRESOS: S/. '.$montoTotal.'</div>
                <div align="right" class="font-weight-bold">TOTAL DEUDAS: S/. '.$montoDeuda.'</div><br>
            ';
            
            return $tabla;
        }

    }
?>
