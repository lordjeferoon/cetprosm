<?php
	if ($peticionAjax) {
		require_once "../modelos/asignacionModelo.php";
	}
	else{
		require_once "modelos/asignacionModelo.php";
	}
  
	class asignacionControlador extends asignacionModelo
	{
		public function agregar_asignacion_controlador()
		{
			$docente = $_POST['docente'];
			$modulo = $_POST['modulo'];
            $turno = $_POST['turno'];
            $frecuencia = $_POST['frecuencia'];
            $inicio = $_POST['fecha-inicio'];
            $fin = $_POST['fecha-fin'];
            $hi = $_POST['hora-inicio'];
            $hf = $_POST['hora-fin'];
			$estado = "Activo";
            $anio=date("Y");
            $vacantes = $_POST['vacantes'];

            if($docente==0 || $modulo==0 || $frecuencia==0){
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un error inesperado",
                    "Texto"=>"Alguno de los campos (docente, módulo o frecuencia) se encuentran vacios",
                    "Tipo"=>"error"
                ];
            }
            else{
                $consulta1=mainModel::ejecutar_consulta_simple("SELECT * FROM asignaciones WHERE ESTADO='Activo' AND ANIO=$anio AND ID_MODULO=$modulo");
                $grupo = ($consulta1->rowCount())+1;
                $asignacion = $consulta1->fetchAll();

                $matricula="true";
                foreach ($asignacion as $row) {
                    if($row['ID_DOCENTE']==$docente && $row['ID_FRECUENCIA']==$frecuencia && $row['TURNO']==$turno){
                        $matricula="false";
                    }
                }

                if($matricula=="true"){
                    $datosAsignacion=[
                        "Grupo"=>$grupo,
                        "Anio"=>$anio,
                        "Estado"=>$estado,
                        "Docente"=>$docente,
                        "Modulo"=>$modulo,
                        "Turno"=>$turno,
                        "Frecuencia"=>$frecuencia,
                        "Inicio"=>$inicio,
                        "Fin"=>$fin,
                        "Hi"=>$hi,
                        "Hf"=>$hf,
                        "Vacantes"=>$vacantes
                    ];

                    $guardarAsignacion=asignacionModelo::agregar_asignacion_modelo($datosAsignacion);
                    if(($guardarAsignacion->rowCount())>=1){
                        $alerta = [
                            "Alerta"=>"limpiar",
                            "Titulo"=>"Asignación realizada",
                            "Texto"=>"El docente ha sido asignado con éxito en el sistema.",
                            "Tipo"=>"success"
                        ];
                    }
                    else{
                        $alerta = [
                            "Alerta"=>"simple",
                            "Titulo"=>"Ocurrio un error inesperado",
                            "Texto"=>"No hemos podido realizar la asignacion correspondiente.",
                            "Tipo"=>"error"
                        ];
                    } 
                }
                else{
                    $alerta = [
                        "Alerta"=>"simple",
                        "Titulo"=>"Ocurrio un error inesperado",
                        "Texto"=>"Este docente ya se encuentra asignado a este módulo, en este turno y frecuencia",
                        "Tipo"=>"error"
                    ];
                }
            }

			return mainModel::sweet_alert($alerta);
		}

        public function formulario_nota_controlador($idAsignacion1,$codigo1){
            $idAsignacion=mainModel::decryption($idAsignacion1);
            $codigo=$codigo1;
            $anio=date('Y');

            $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM matricula_detalle WHERE ID_ASIGNACION=$idAsignacion");
            $detallesMatricula=$consulta->fetchAll();

            $tabla="";

            $tabla.='
                <table class="table table-hover table-sm">
                    <thead class="table-secondary">
                        <tr>
                            <th width="5%">No</th>
                            <th width="16%">Código</th>
                            <th>Apellidos y Nombres</th>
                            <th width="10%"></th>
            ';

            $consulta1 = mainModel::ejecutar_consulta_simple("SELECT * FROM notas WHERE ID_ASIGNACION=$idAsignacion");
            $contadorNotas=$consulta1->rowCount();

            if($contadorNotas>0){
                $notas=$consulta1->fetchAll();

                $k=1;
                foreach($notas as $nota){
                    if($k==1){
                        $idNota=$nota['ID_NOTA'];
                        $consulta2 = mainModel::ejecutar_consulta_simple("SELECT * FROM nota_detalle WHERE ID_NOTA=$idNota ORDER BY FECHA ASC");
                        $contadorDetalle=$consulta2->rowCount();

                        if($contadorDetalle>0){
                            $detalles=$consulta2->fetchAll();

                            $i=1;
                            foreach ($detalles as $detalle) {
                                /*$tabla.='
                                    <th width="2%">'.$i.'</th>
                                ';*/
                                $i++;
                            }
                            $tabla.='
                                    <th width="10%" align="center">Nota '.$i.'</th>
                                <tr>
                            ';

                        }
                        else{
                            $tabla.='
                                    <th width="10%" align="center">Nota 1</th>
                                </tr>
                            ';
                        }
                    }
                    $k++;
                } 
            }
            else{
                $tabla.='
                        <th width="10%" align="center">Nota 1</th>
                    </tr>
                ';
            }
            
                            
            $tabla.='
                </thead>
                <tbody>'
            ;
            
            $consulta2 = mainModel::ejecutar_consulta_simple("SELECT * FROM asignaciones WHERE ID_ASIGNACION=$idAsignacion");
            $asignacion=$consulta2->fetch();
            
            $idModulo = $asignacion['ID_MODULO'];
            $consulta2 = mainModel::ejecutar_consulta_simple("SELECT * FROM modulos WHERE ID_MODULO=$idModulo");
            $modulo=$consulta2->fetch();

            $contador=1;
            $consulta = mainModel::ejecutar_consulta_simple("SELECT a.ID_ALUMNO, a.APELLIDOS_ALUMNO, a.NOMBRES_ALUMNO, a.SEXO_ALUMNO, a.FECHA_NACIMIENTO_ALUMNO, a.CODIGO_CUENTA_ALUMNO, a.CODIGO_NOMINAB, a.CODIGO_NOMINAI,  a.CONDICION_ALUMNO, m.CODIGO_MATRICULA, d.ID_ASIGNACION 
                FROM alumnos a JOIN matriculas m ON m.ID_ALUMNO = a.ID_ALUMNO 
                JOIN matricula_detalle d ON d.CODIGO_MATRICULA = m.CODIGO_MATRICULA 
                WHERE d.ID_ASIGNACION=$idAsignacion ORDER BY a.APELLIDOS_ALUMNO");
            $detallesMatricula=$consulta->fetchAll();

            foreach ($detallesMatricula as $detalleMatricula) {
                /*$codMatricula=$detalleMatricula['CODIGO_MATRICULA'];
                $anioActual=date('Y');

                $consulta2 = mainModel::ejecutar_consulta_simple("SELECT * FROM MATRICULAS WHERE CODIGO_MATRICULA='$codMatricula'");
                $matricula=$consulta2->fetch();

                    $idAlumno=$matricula['ID_ALUMNO'];

                    $consulta3 = mainModel::ejecutar_consulta_simple("SELECT * FROM ALUMNOS WHERE ID_ALUMNO=$idAlumno");
                    $alumno=$consulta3->fetch();*/


                    $tabla.='
                        <tr>
                            <td class="align-middle">'.$contador.'</td>
                    ';
                    
                    if($modulo['NIVEL_MODULO']=="B"){
                        $tabla.='<td class="align-middle">'.$detalleMatricula['CODIGO_NOMINAB'].'</td>';
                    }
                    else{
                        $tabla.='<td class="align-middle">'.$detalleMatricula['CODIGO_NOMINAI'].'</td>';
                    }
                    
                    $tabla.='
                            <td class="align-middle">'.$detalleMatricula['APELLIDOS_ALUMNO'].', '.$detalleMatricula['NOMBRES_ALUMNO'].'</td>
                            <td></td>
                    ';

                    $idAlumno=$detalleMatricula['ID_ALUMNO'];

                    $consulta1 = mainModel::ejecutar_consulta_simple("SELECT * FROM notas WHERE ID_ASIGNACION=$idAsignacion AND ID_ALUMNO=$idAlumno");
                    $contadorNotas=$consulta1->rowCount();

                    if($contadorNotas>0){
                        $nota=$consulta1->fetch();
                        $i=0;
                        $idNota=$nota['ID_NOTA'];
                        $consulta4 = mainModel::ejecutar_consulta_simple("SELECT * FROM nota_detalle WHERE ID_NOTA=$idNota ORDER BY FECHA ASC");
                        $contadorDetalle=$consulta4->rowCount();

                        if($contadorDetalle>0){
                            $detalles=$consulta4->fetchAll();

                            $suma=0;
                            /*foreach ($detalles as $detalle) {
                                $tabla.='
                                    <td width="5%">'.$detalle['NOTA'].'</td>
                                ';
                                $suma=$suma+$detalle['NOTA'];
                                $i++;
                            }
                            $promedio=$suma/$i;*/
                            $tabla.='
                                    <td align="center"><input type="number" name="nota'.$contador.'" min="0" max="20" required style="width: 45px;"><input type="hidden" name="alumno'.$contador.'" value="'.$detalleMatricula['ID_ALUMNO'].'">
                                    </td>
                                </tr>
                            ';  
                        }
                        else{
                            $tabla.='
                                    <td align="center"><input type="number" name="nota'.$contador.'" min="0" max="20" required style="width: 45px;"><input type="hidden" name="alumno'.$contador.'" value="'.$detalleMatricula['ID_ALUMNO'].'">
                                    </td>
                                </tr>
                            ';   
                        }
                    }
                    else{
                        $tabla.='
                                <td align="center"><input type="number" name="nota'.$contador.'" min="0" max="20" required style="width: 45px;"><input type="hidden" name="alumno'.$contador.'" value="'.$detalleMatricula['ID_ALUMNO'].'">
                                </td>
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

        public function formulario_asistencia_controlador($idAsignacion1,$codigo1){
            $idAsignacion=mainModel::decryption($idAsignacion1);
            $codigo=$codigo1;
            $anio=date('Y');

            $consulta = mainModel::ejecutar_consulta_simple("SELECT a.ID_ALUMNO, a.APELLIDOS_ALUMNO, a.NOMBRES_ALUMNO, a.SEXO_ALUMNO, a.FECHA_NACIMIENTO_ALUMNO, a.CODIGO_CUENTA_ALUMNO, a.CODIGO_NOMINAB, a.CODIGO_NOMINAI,  a.CONDICION_ALUMNO, m.CODIGO_MATRICULA, d.ID_ASIGNACION 
                FROM alumnos a JOIN matriculas m ON m.ID_ALUMNO = a.ID_ALUMNO 
                JOIN matricula_detalle d ON d.CODIGO_MATRICULA = m.CODIGO_MATRICULA 
                WHERE d.ID_ASIGNACION=$idAsignacion ORDER BY a.APELLIDOS_ALUMNO");
            $detalles=$consulta->fetchAll();

            //$consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM MATRICULA_DETALLE WHERE ID_ASIGNACION=$idAsignacion");
            //$detalles=$consulta->fetchAll();

            $tabla="";

            $tabla.='
                <table class="table table-hover table-sm">
                    <thead class="table-secondary">
                        <tr>
                            <th width="5%">No</th>
                            <th width="16%">Código</th>
                            <th>Apellidos y Nombres</th>
                            <th width="5%"></th>
                            <th width="5%">A</th>
                            <th width="5%">T</th>
                            <th width="5%">F</th>
                        </tr>
                    </thead>
                    <tbody>'
            ;
            
            $consulta2 = mainModel::ejecutar_consulta_simple("SELECT * FROM asignaciones WHERE ID_ASIGNACION=$idAsignacion");
            $asignacion=$consulta2->fetch();
            
            $idModulo = $asignacion['ID_MODULO'];
            $consulta2 = mainModel::ejecutar_consulta_simple("SELECT * FROM modulos WHERE ID_MODULO=$idModulo");
            $modulo=$consulta2->fetch();

            $contador=1;
            foreach ($detalles as $detalle) {

                /*Obtenemos la matricula de cada uno de los detalles.
                $codMatricula = $detalle['CODIGO_MATRICULA'];
                $consulta2 = mainModel::ejecutar_consulta_simple("SELECT * FROM MATRICULAS WHERE CODIGO_MATRICULA='$codMatricula'");
                $matricula=$consulta2->fetch();

                //De la matricula, sacamos el ID_ALUMNO y buscamos sus datos en la tabla ALUMNOS.
                $idAlumno=$matricula['ID_ALUMNO'];
                $consulta3 = mainModel::ejecutar_consulta_simple("SELECT * FROM ALUMNOS WHERE ID_ALUMNO=$idAlumno");
                $alumno=$consulta3->fetch();*/

                $tabla.='
                    <tr>
                        <td class="align-middle">'.$contador.'</td>
                ';
                
                if($modulo['NIVEL_MODULO']=="B"){
                    $tabla.='<td class="align-middle">'.$detalle['CODIGO_NOMINAB'].'</td>';
                }
                else{
                    $tabla.='<td class="align-middle">'.$detalle['CODIGO_NOMINAI'].'</td>';
                }
                
                $tabla.='
                        <td class="align-middle">'.$detalle['APELLIDOS_ALUMNO'].', '.$detalle['NOMBRES_ALUMNO'].'</td>
                        <td><input type="hidden" name="alumno'.$contador.'" value="'.$detalle['ID_ALUMNO'].'"></td>
                        <td class="align-middle"><input type="radio" name="asistencia'.$contador.'" value="A" checked></td>
                        <td class="align-middle"><input type="radio" name="asistencia'.$contador.'" value="T"></td>
                        <td class="align-middle"><input type="radio" name="asistencia'.$contador.'" value="F"></td>
                    </tr>
                ';

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

        public function agregar_asistencia_controlador(){
            $asignacion=$_POST['asignacion'];
            $codigo=$_POST['codigo-cuenta-docente'];
            $fecha=$_POST['fecha'];

            $alumnos="falso";
            $asistencia1; $alumno1;
            $asistencia2; $alumno2;
            $asistencia3; $alumno3;
            $asistencia4; $alumno4;
            $asistencia5; $alumno5;
            $asistencia6; $alumno6;
            $asistencia7; $alumno7;
            $asistencia8; $alumno8;
            $asistencia9; $alumno9;
            $asistencia10; $alumno10;
            $asistencia11; $alumno11;
            $asistencia12; $alumno12;
            $asistencia13; $alumno13;
            $asistencia14; $alumno14;
            $asistencia15; $alumno15;
            $asistencia16; $alumno16;
            $asistencia17; $alumno17;
            $asistencia18; $alumno18;
            $asistencia19; $alumno19;
            $asistencia20; $alumno20;
            $asistencia21; $alumno21;
            $asistencia22; $alumno22;
            $asistencia23; $alumno23;
            $asistencia24; $alumno24;
            $asistencia25; $alumno25;
            $asistencia26; $alumno26;
            $asistencia27; $alumno27;
            $asistencia28; $alumno28;
            $asistencia29; $alumno29;
            $asistencia30; $alumno30;
            $asistencia31; $alumno31;
            $asistencia32; $alumno32;
            $asistencia33; $alumno33;
            $asistencia34; $alumno34;
            $asistencia35; $alumno35;
            $asistencia36; $alumno36;
            $asistencia37; $alumno37;
            $asistencia38; $alumno38;
            $asistencia39; $alumno39;
            $asistencia40; $alumno40;

            if(isset($_POST['asistencia1'])){
                $asistencia1=$_POST['asistencia1'];
                $alumno1=$_POST['alumno1'];
                $alumnos="verdadero";
            }
            else{
                $asistencia1="0";
                $alumno1="0";
            }

            if(isset($_POST['asistencia2'])){
                $asistencia2=$_POST['asistencia2'];
                $alumno2=$_POST['alumno2'];
            }
            else{
                $asistencia2="0";
                $alumno2="0";
            }

            if(isset($_POST['asistencia3'])){
                $asistencia3=$_POST['asistencia3'];
                $alumno3=$_POST['alumno3'];
            }
            else{
                $asistencia3="0";
                $alumno3="0";
            }
            
            if(isset($_POST['asistencia4'])){
                $asistencia4=$_POST['asistencia4'];
                $alumno4=$_POST['alumno4'];
            }
            else{
                $asistencia4="0";
                $alumno4="0";
            }

            if(isset($_POST['asistencia5'])){
                $asistencia5=$_POST['asistencia5'];
                $alumno5=$_POST['alumno5'];
            }
            else{
                $asistencia5="0";
                $alumno5="0";
            }

            if(isset($_POST['asistencia6'])){
                $asistencia6=$_POST['asistencia6'];
                $alumno6=$_POST['alumno6'];
            }
            else{
                $asistencia6="0";
                $alumno6="0";
            }

            if(isset($_POST['asistencia7'])){
                $asistencia7=$_POST['asistencia7'];
                $alumno7=$_POST['alumno7'];
            }
            else{
                $asistencia7="0";
                $alumno7="0";
            }

            if(isset($_POST['asistencia8'])){
                $asistencia8=$_POST['asistencia8'];
                $alumno8=$_POST['alumno8'];
            }
            else{
                $asistencia8="0";
                $alumno8="0";
            }

            if(isset($_POST['asistencia9'])){
                $asistencia9=$_POST['asistencia9'];
                $alumno9=$_POST['alumno9'];
            }
            else{
                $asistencia9="0";
                $alumno9="0";
            }

            if(isset($_POST['asistencia10'])){
                $asistencia10=$_POST['asistencia10'];
                $alumno10=$_POST['alumno10'];
            }
            else{
                $asistencia10="0";
                $alumno10="0";
            }

            if(isset($_POST['asistencia11'])){
                $asistencia11=$_POST['asistencia11'];
                $alumno11=$_POST['alumno11'];
            }
            else{
                $asistencia11="0";
                $alumno11="0";
            }

            if(isset($_POST['asistencia12'])){
                $asistencia12=$_POST['asistencia12'];
                $alumno12=$_POST['alumno12'];
            }
            else{
                $asistencia12="0";
                $alumno12="0";
            }

            if(isset($_POST['asistencia13'])){
                $asistencia13=$_POST['asistencia13'];
                $alumno13=$_POST['alumno13'];
            }
            else{
                $asistencia13="0";
                $alumno13="0";
            }

            if(isset($_POST['asistencia14'])){
                $asistencia14=$_POST['asistencia14'];
                $alumno14=$_POST['alumno14'];
            }
            else{
                $asistencia14="0";
                $alumno14="0";
            }

            if(isset($_POST['asistencia15'])){
                $asistencia15=$_POST['asistencia15'];
                $alumno15=$_POST['alumno15'];
            }
            else{
                $asistencia15="0";
                $alumno15="0";
            }

            if(isset($_POST['asistencia16'])){
                $asistencia16=$_POST['asistencia16'];
                $alumno16=$_POST['alumno16'];
            }
            else{
                $asistencia16="0";
                $alumno16="0";
            }

            if(isset($_POST['asistencia17'])){
                $asistencia17=$_POST['asistencia17'];
                $alumno17=$_POST['alumno17'];
            }
            else{
                $asistencia17="0";
                $alumno17="0";
            }

            if(isset($_POST['asistencia18'])){
                $asistencia18=$_POST['asistencia18'];
                $alumno18=$_POST['alumno18'];
            }
            else{
                $asistencia18="0";
                $alumno18="0";
            }

            if(isset($_POST['asistencia19'])){
                $asistencia19=$_POST['asistencia19'];
                $alumno19=$_POST['alumno19'];
            }
            else{
                $asistencia19="0";
                $alumno19="0";
            }

            if(isset($_POST['asistencia20'])){
                $asistencia20=$_POST['asistencia20'];
                $alumno20=$_POST['alumno20'];
            }
            else{
                $asistencia20="0";
                $alumno20="0";
            }

            if(isset($_POST['asistencia21'])){
                $asistencia21=$_POST['asistencia21'];
                $alumno21=$_POST['alumno21'];
            }
            else{
                $asistencia21="0";
                $alumno21="0";
            }

            if(isset($_POST['asistencia22'])){
                $asistencia22=$_POST['asistencia22'];
                $alumno22=$_POST['alumno22'];
            }
            else{
                $asistencia22="0";
                $alumno22="0";
            }

            if(isset($_POST['asistencia23'])){
                $asistencia23=$_POST['asistencia23'];
                $alumno23=$_POST['alumno23'];
            }
            else{
                $asistencia23="0";
                $alumno23="0";
            }

            if(isset($_POST['asistencia24'])){
                $asistencia24=$_POST['asistencia24'];
                $alumno24=$_POST['alumno24'];
            }
            else{
                $asistencia24="0";
                $alumno24="0";
            }

            if(isset($_POST['asistencia25'])){
                $asistencia25=$_POST['asistencia25'];
                $alumno25=$_POST['alumno25'];
            }
            else{
                $asistencia25="0";
                $alumno25="0";
            }

            if(isset($_POST['asistencia26'])){
                $asistencia26=$_POST['asistencia26'];
                $alumno26=$_POST['alumno26'];
            }
            else{
                $asistencia26="0";
                $alumno26="0";
            }

            if(isset($_POST['asistencia27'])){
                $asistencia27=$_POST['asistencia27'];
                $alumno27=$_POST['alumno27'];
            }
            else{
                $asistencia27="0";
                $alumno27="0";
            }

            if(isset($_POST['asistencia28'])){
                $asistencia28=$_POST['asistencia28'];
                $alumno28=$_POST['alumno28'];
            }
            else{
                $asistencia28="0";
                $alumno28="0";
            }

            if(isset($_POST['asistencia29'])){
                $asistencia29=$_POST['asistencia29'];
                $alumno29=$_POST['alumno29'];
            }
            else{
                $asistencia29="0";
                $alumno29="0";
            }

            if(isset($_POST['asistencia30'])){
                $asistencia30=$_POST['asistencia30'];
                $alumno30=$_POST['alumno30'];
            }
            else{
                $asistencia30="0";
                $alumno30="0";
            }

            if(isset($_POST['asistencia31'])){
                $asistencia31=$_POST['asistencia31'];
                $alumno31=$_POST['alumno31'];
            }
            else{
                $asistencia31="0";
                $alumno31="0";
            }

            if(isset($_POST['asistencia32'])){
                $asistencia32=$_POST['asistencia32'];
                $alumno32=$_POST['alumno32'];
            }
            else{
                $asistencia32="0";
                $alumno32="0";
            }

            if(isset($_POST['asistencia33'])){
                $asistencia33=$_POST['asistencia33'];
                $alumno33=$_POST['alumno33'];
            }
            else{
                $asistencia33="0";
                $alumno33="0";
            }

            if(isset($_POST['asistencia34'])){
                $asistencia34=$_POST['asistencia34'];
                $alumno34=$_POST['alumno34'];
            }
            else{
                $asistencia34="0";
                $alumno34="0";
            }

            if(isset($_POST['asistencia35'])){
                $asistencia35=$_POST['asistencia35'];
                $alumno35=$_POST['alumno35'];
            }
            else{
                $asistencia35="0";
                $alumno35="0";
            }

            if(isset($_POST['asistencia36'])){
                $asistencia36=$_POST['asistencia36'];
                $alumno36=$_POST['alumno36'];
            }
            else{
                $asistencia36="0";
                $alumno36="0";
            }

            if(isset($_POST['asistencia37'])){
                $asistencia37=$_POST['asistencia37'];
                $alumno37=$_POST['alumno37'];
            }
            else{
                $asistencia37="0";
                $alumno37="0";
            }

            if(isset($_POST['asistencia38'])){
                $asistencia38=$_POST['asistencia38'];
                $alumno38=$_POST['alumno38'];
            }
            else{
                $asistencia38="0";
                $alumno38="0";
            }

            if(isset($_POST['asistencia39'])){
                $asistencia39=$_POST['asistencia39'];
                $alumno39=$_POST['alumno39'];
            }
            else{
                $asistencia39="0";
                $alumno39="0";
            }

            if(isset($_POST['asistencia40'])){
                $asistencia40=$_POST['asistencia40'];
                $alumno40=$_POST['alumno40'];
            }
            else{
                $asistencia40="0";
                $alumno40="0";
            }

            if($alumnos=="falso"){
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un error inesperado",
                    "Texto"=>"No hay alumnos para registrar la asistencia",
                    "Tipo"=>"error"
                ];
            }
            else{
                $datosAsistencia=[
                    "Alumno1"=>$alumno1,
                    "Alumno2"=>$alumno2,
                    "Alumno3"=>$alumno3,
                    "Alumno4"=>$alumno4,
                    "Alumno5"=>$alumno5,
                    "Alumno6"=>$alumno6,
                    "Alumno7"=>$alumno7,
                    "Alumno8"=>$alumno8,
                    "Alumno9"=>$alumno9,
                    "Alumno10"=>$alumno10,
                    "Alumno11"=>$alumno11,
                    "Alumno12"=>$alumno12,
                    "Alumno13"=>$alumno13,
                    "Alumno14"=>$alumno14,
                    "Alumno15"=>$alumno15,
                    "Alumno16"=>$alumno16,
                    "Alumno17"=>$alumno17,
                    "Alumno18"=>$alumno18,
                    "Alumno19"=>$alumno19,
                    "Alumno20"=>$alumno20,
                    "Alumno21"=>$alumno21,
                    "Alumno22"=>$alumno22,
                    "Alumno23"=>$alumno23,
                    "Alumno24"=>$alumno24,
                    "Alumno25"=>$alumno25,
                    "Alumno26"=>$alumno26,
                    "Alumno27"=>$alumno27,
                    "Alumno28"=>$alumno28,
                    "Alumno29"=>$alumno29,
                    "Alumno30"=>$alumno30,
                    "Alumno31"=>$alumno31,
                    "Alumno32"=>$alumno32,
                    "Alumno33"=>$alumno33,
                    "Alumno34"=>$alumno34,
                    "Alumno35"=>$alumno35,
                    "Alumno36"=>$alumno36,
                    "Alumno37"=>$alumno37,
                    "Alumno38"=>$alumno38,
                    "Alumno39"=>$alumno39,
                    "Alumno40"=>$alumno40,
                    "Asistencia1"=>$asistencia1,
                    "Asistencia2"=>$asistencia2,
                    "Asistencia3"=>$asistencia3,
                    "Asistencia4"=>$asistencia4,
                    "Asistencia5"=>$asistencia5,
                    "Asistencia6"=>$asistencia6,
                    "Asistencia7"=>$asistencia7,
                    "Asistencia8"=>$asistencia8,
                    "Asistencia9"=>$asistencia9,
                    "Asistencia10"=>$asistencia10,
                    "Asistencia11"=>$asistencia11,
                    "Asistencia12"=>$asistencia12,
                    "Asistencia13"=>$asistencia13,
                    "Asistencia14"=>$asistencia14,
                    "Asistencia15"=>$asistencia15,
                    "Asistencia16"=>$asistencia16,
                    "Asistencia17"=>$asistencia17,
                    "Asistencia18"=>$asistencia18,
                    "Asistencia19"=>$asistencia19,
                    "Asistencia20"=>$asistencia20,
                    "Asistencia21"=>$asistencia21,
                    "Asistencia22"=>$asistencia22,
                    "Asistencia23"=>$asistencia23,
                    "Asistencia24"=>$asistencia24,
                    "Asistencia25"=>$asistencia25,
                    "Asistencia26"=>$asistencia26,
                    "Asistencia27"=>$asistencia27,
                    "Asistencia28"=>$asistencia28,
                    "Asistencia29"=>$asistencia29,
                    "Asistencia30"=>$asistencia30,
                    "Asistencia31"=>$asistencia31,
                    "Asistencia32"=>$asistencia32,
                    "Asistencia33"=>$asistencia33,
                    "Asistencia34"=>$asistencia34,
                    "Asistencia35"=>$asistencia35,
                    "Asistencia36"=>$asistencia36,
                    "Asistencia37"=>$asistencia37,
                    "Asistencia38"=>$asistencia38,
                    "Asistencia39"=>$asistencia39,
                    "Asistencia40"=>$asistencia40,
                    "Asignacion"=>$asignacion,
                    "Fecha"=>$fecha
                ];

                $guardarAsistencia=asignacionModelo::agregar_asistencia_modelo($datosAsistencia);
                if(($guardarAsistencia->rowCount())>=1){
                    $alerta = [
                        "Alerta"=>"recargar",
                        "Titulo"=>"Asistencia registrada",
                        "Texto"=>"La asistencia se guardó con éxito en el sistema.",
                        "Tipo"=>"success"
                    ];
                }
                else{
                    $alerta = [
                        "Alerta"=>"simple",
                        "Titulo"=>"Ocurrio un error inesperado",
                        "Texto"=>"No hemos podido guardar la asistencia correspondiente.",
                        "Tipo"=>"error"
                    ];
                }
            }

            return mainModel::sweet_alert($alerta);
        }

        public function agregar_nota_controlador(){
            $asignacion=$_POST['asignacion'];
            $codigo=$_POST['codigo-cuenta-docente'];
            $unidad=$_POST['unidad'];

            $alumnos="falso";
            $nota1; $alumno1;
            $nota2; $alumno2;
            $nota3; $alumno3;
            $nota4; $alumno4;
            $nota5; $alumno5;
            $nota6; $alumno6;
            $nota7; $alumno7;
            $nota8; $alumno8;
            $nota9; $alumno9;
            $nota10; $alumno10;
            $nota11; $alumno11;
            $nota12; $alumno12;
            $nota13; $alumno13;
            $nota14; $alumno14;
            $nota15; $alumno15;
            $nota16; $alumno16;
            $nota17; $alumno17;
            $nota18; $alumno18;
            $nota19; $alumno19;
            $nota20; $alumno20;
            $nota21; $alumno21;
            $nota22; $alumno22;
            $nota23; $alumno23;
            $nota24; $alumno24;
            $nota25; $alumno25;
            $nota26; $alumno26;
            $nota27; $alumno27;
            $nota28; $alumno28;
            $nota29; $alumno29;
            $nota30; $alumno30;
            $nota31; $alumno31;
            $nota32; $alumno32;
            $nota33; $alumno33;
            $nota34; $alumno34;
            $nota35; $alumno35;
            $nota36; $alumno36;
            $nota37; $alumno37;
            $nota38; $alumno38;
            $nota39; $alumno39;
            $nota40; $alumno40;

            if(isset($_POST['nota1'])){
                $nota1=$_POST['nota1'];
                $alumno1=$_POST['alumno1'];
                $alumnos="verdadero";
            }
            else{
                $nota1="0";
                $alumno1="0";
            }

            if(isset($_POST['nota2'])){
                $nota2=$_POST['nota2'];
                $alumno2=$_POST['alumno2'];
            }
            else{
                $nota2="0";
                $alumno2="0";
            }

            if(isset($_POST['nota3'])){
                $nota3=$_POST['nota3'];
                $alumno3=$_POST['alumno3'];
            }
            else{
                $nota3="0";
                $alumno3="0";
            }
            
            if(isset($_POST['nota4'])){
                $nota4=$_POST['nota4'];
                $alumno4=$_POST['alumno4'];
            }
            else{
                $nota4="0";
                $alumno4="0";
            }

            if(isset($_POST['nota5'])){
                $nota5=$_POST['nota5'];
                $alumno5=$_POST['alumno5'];
            }
            else{
                $nota5="0";
                $alumno5="0";
            }

            if(isset($_POST['nota6'])){
                $nota6=$_POST['nota6'];
                $alumno6=$_POST['alumno6'];
            }
            else{
                $nota6="0";
                $alumno6="0";
            }

            if(isset($_POST['nota7'])){
                $nota7=$_POST['nota7'];
                $alumno7=$_POST['alumno7'];
            }
            else{
                $nota7="0";
                $alumno7="0";
            }

            if(isset($_POST['nota8'])){
                $nota8=$_POST['nota8'];
                $alumno8=$_POST['alumno8'];
            }
            else{
                $nota8="0";
                $alumno8="0";
            }

            if(isset($_POST['nota9'])){
                $nota9=$_POST['nota9'];
                $alumno9=$_POST['alumno9'];
            }
            else{
                $nota9="0";
                $alumno9="0";
            }

            if(isset($_POST['nota10'])){
                $nota10=$_POST['nota10'];
                $alumno10=$_POST['alumno10'];
            }
            else{
                $nota10="0";
                $alumno10="0";
            }

            if(isset($_POST['nota11'])){
                $nota11=$_POST['nota11'];
                $alumno11=$_POST['alumno11'];
            }
            else{
                $nota11="0";
                $alumno11="0";
            }

            if(isset($_POST['nota12'])){
                $nota12=$_POST['nota12'];
                $alumno12=$_POST['alumno12'];
            }
            else{
                $nota12="0";
                $alumno12="0";
            }

            if(isset($_POST['nota13'])){
                $nota13=$_POST['nota13'];
                $alumno13=$_POST['alumno13'];
            }
            else{
                $nota13="0";
                $alumno13="0";
            }

            if(isset($_POST['nota14'])){
                $nota14=$_POST['nota14'];
                $alumno14=$_POST['alumno14'];
            }
            else{
                $nota14="0";
                $alumno14="0";
            }

            if(isset($_POST['nota15'])){
                $nota15=$_POST['nota15'];
                $alumno15=$_POST['alumno15'];
            }
            else{
                $nota15="0";
                $alumno15="0";
            }

            if(isset($_POST['nota16'])){
                $nota16=$_POST['nota16'];
                $alumno16=$_POST['alumno16'];
            }
            else{
                $nota16="0";
                $alumno16="0";
            }

            if(isset($_POST['nota17'])){
                $nota17=$_POST['nota17'];
                $alumno17=$_POST['alumno17'];
            }
            else{
                $nota17="0";
                $alumno17="0";
            }

            if(isset($_POST['nota18'])){
                $nota18=$_POST['nota18'];
                $alumno18=$_POST['alumno18'];
            }
            else{
                $nota18="0";
                $alumno18="0";
            }

            if(isset($_POST['nota19'])){
                $nota19=$_POST['nota19'];
                $alumno19=$_POST['alumno19'];
            }
            else{
                $nota19="0";
                $alumno19="0";
            }

            if(isset($_POST['nota20'])){
                $nota20=$_POST['nota20'];
                $alumno20=$_POST['alumno20'];
            }
            else{
                $nota20="0";
                $alumno20="0";
            }

            if(isset($_POST['nota21'])){
                $nota21=$_POST['nota21'];
                $alumno21=$_POST['alumno21'];
            }
            else{
                $nota21="0";
                $alumno21="0";
            }

            if(isset($_POST['nota22'])){
                $nota22=$_POST['nota22'];
                $alumno22=$_POST['alumno22'];
            }
            else{
                $nota22="0";
                $alumno22="0";
            }

            if(isset($_POST['nota23'])){
                $nota23=$_POST['nota23'];
                $alumno23=$_POST['alumno23'];
            }
            else{
                $nota23="0";
                $alumno23="0";
            }

            if(isset($_POST['nota24'])){
                $nota24=$_POST['nota24'];
                $alumno24=$_POST['alumno24'];
            }
            else{
                $nota24="0";
                $alumno24="0";
            }

            if(isset($_POST['nota25'])){
                $nota25=$_POST['nota25'];
                $alumno25=$_POST['alumno25'];
            }
            else{
                $nota25="0";
                $alumno25="0";
            }

            if(isset($_POST['nota26'])){
                $nota26=$_POST['nota26'];
                $alumno26=$_POST['alumno26'];
            }
            else{
                $nota26="0";
                $alumno26="0";
            }

            if(isset($_POST['nota27'])){
                $nota27=$_POST['nota27'];
                $alumno27=$_POST['alumno27'];
            }
            else{
                $nota27="0";
                $alumno27="0";
            }

            if(isset($_POST['nota28'])){
                $nota28=$_POST['nota28'];
                $alumno28=$_POST['alumno28'];
            }
            else{
                $nota28="0";
                $alumno28="0";
            }

            if(isset($_POST['nota29'])){
                $nota29=$_POST['nota29'];
                $alumno29=$_POST['alumno29'];
            }
            else{
                $nota29="0";
                $alumno29="0";
            }

            if(isset($_POST['nota30'])){
                $nota30=$_POST['nota30'];
                $alumno30=$_POST['alumno30'];
            }
            else{
                $nota30="0";
                $alumno30="0";
            }

            if(isset($_POST['nota31'])){
                $nota31=$_POST['nota31'];
                $alumno31=$_POST['alumno31'];
            }
            else{
                $nota31="0";
                $alumno31="0";
            }

            if(isset($_POST['nota32'])){
                $nota32=$_POST['nota32'];
                $alumno32=$_POST['alumno32'];
            }
            else{
                $nota32="0";
                $alumno32="0";
            }

            if(isset($_POST['nota33'])){
                $nota33=$_POST['nota33'];
                $alumno33=$_POST['alumno33'];
            }
            else{
                $nota33="0";
                $alumno33="0";
            }

            if(isset($_POST['nota34'])){
                $nota34=$_POST['nota34'];
                $alumno34=$_POST['alumno34'];
            }
            else{
                $nota34="0";
                $alumno34="0";
            }

            if(isset($_POST['nota35'])){
                $nota35=$_POST['nota35'];
                $alumno35=$_POST['alumno35'];
            }
            else{
                $nota35="0";
                $alumno35="0";
            }

            if(isset($_POST['nota36'])){
                $nota36=$_POST['nota36'];
                $alumno36=$_POST['alumno36'];
            }
            else{
                $nota36="0";
                $alumno36="0";
            }

            if(isset($_POST['nota37'])){
                $nota37=$_POST['nota37'];
                $alumno37=$_POST['alumno37'];
            }
            else{
                $nota37="0";
                $alumno37="0";
            }

            if(isset($_POST['nota38'])){
                $nota38=$_POST['nota38'];
                $alumno38=$_POST['alumno38'];
            }
            else{
                $nota38="0";
                $alumno38="0";
            }

            if(isset($_POST['nota39'])){
                $nota39=$_POST['nota39'];
                $alumno39=$_POST['alumno39'];
            }
            else{
                $nota39="0";
                $alumno39="0";
            }

            if(isset($_POST['nota40'])){
                $nota40=$_POST['nota40'];
                $alumno40=$_POST['alumno40'];
            }
            else{
                $nota40="0";
                $alumno40="0";
            }

            if($alumnos=="falso"){
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un error inesperado",
                    "Texto"=>"No hay alumnos para registrar la asistencia",
                    "Tipo"=>"error"
                ];
            }
            else{
                $datosAsistencia=[
                    "Alumno1"=>$alumno1,
                    "Alumno2"=>$alumno2,
                    "Alumno3"=>$alumno3,
                    "Alumno4"=>$alumno4,
                    "Alumno5"=>$alumno5,
                    "Alumno6"=>$alumno6,
                    "Alumno7"=>$alumno7,
                    "Alumno8"=>$alumno8,
                    "Alumno9"=>$alumno9,
                    "Alumno10"=>$alumno10,
                    "Alumno11"=>$alumno11,
                    "Alumno12"=>$alumno12,
                    "Alumno13"=>$alumno13,
                    "Alumno14"=>$alumno14,
                    "Alumno15"=>$alumno15,
                    "Alumno16"=>$alumno16,
                    "Alumno17"=>$alumno17,
                    "Alumno18"=>$alumno18,
                    "Alumno19"=>$alumno19,
                    "Alumno20"=>$alumno20,
                    "Alumno21"=>$alumno21,
                    "Alumno22"=>$alumno22,
                    "Alumno23"=>$alumno23,
                    "Alumno24"=>$alumno24,
                    "Alumno25"=>$alumno25,
                    "Alumno26"=>$alumno26,
                    "Alumno27"=>$alumno27,
                    "Alumno28"=>$alumno28,
                    "Alumno29"=>$alumno29,
                    "Alumno30"=>$alumno30,
                    "Alumno31"=>$alumno31,
                    "Alumno32"=>$alumno32,
                    "Alumno33"=>$alumno33,
                    "Alumno34"=>$alumno34,
                    "Alumno35"=>$alumno35,
                    "Alumno36"=>$alumno36,
                    "Alumno37"=>$alumno37,
                    "Alumno38"=>$alumno38,
                    "Alumno39"=>$alumno39,
                    "Alumno40"=>$alumno40,
                    "Asistencia1"=>$nota1,
                    "Asistencia2"=>$nota2,
                    "Asistencia3"=>$nota3,
                    "Asistencia4"=>$nota4,
                    "Asistencia5"=>$nota5,
                    "Asistencia6"=>$nota6,
                    "Asistencia7"=>$nota7,
                    "Asistencia8"=>$nota8,
                    "Asistencia9"=>$nota9,
                    "Asistencia10"=>$nota10,
                    "Asistencia11"=>$nota11,
                    "Asistencia12"=>$nota12,
                    "Asistencia13"=>$nota13,
                    "Asistencia14"=>$nota14,
                    "Asistencia15"=>$nota15,
                    "Asistencia16"=>$nota16,
                    "Asistencia17"=>$nota17,
                    "Asistencia18"=>$nota18,
                    "Asistencia19"=>$nota19,
                    "Asistencia20"=>$nota20,
                    "Asistencia21"=>$nota21,
                    "Asistencia22"=>$nota22,
                    "Asistencia23"=>$nota23,
                    "Asistencia24"=>$nota24,
                    "Asistencia25"=>$nota25,
                    "Asistencia26"=>$nota26,
                    "Asistencia27"=>$nota27,
                    "Asistencia28"=>$nota28,
                    "Asistencia29"=>$nota29,
                    "Asistencia30"=>$nota30,
                    "Asistencia31"=>$nota31,
                    "Asistencia32"=>$nota32,
                    "Asistencia33"=>$nota33,
                    "Asistencia34"=>$nota34,
                    "Asistencia35"=>$nota35,
                    "Asistencia36"=>$nota36,
                    "Asistencia37"=>$nota37,
                    "Asistencia38"=>$nota38,
                    "Asistencia39"=>$nota39,
                    "Asistencia40"=>$nota40,
                    "Asignacion"=>$asignacion,
                    "Unidad"=>$unidad
                ];

                $guardarAsistencia=asignacionModelo::agregar_nota_modelo($datosAsistencia);
                if(($guardarAsistencia->rowCount())>=1){
                    $alerta = [
                        "Alerta"=>"recargar",
                        "Titulo"=>"Notas registradas",
                        "Texto"=>"Las notas se guardaron con éxito en el sistema.",
                        "Tipo"=>"success"
                    ];
                }
                else{
                    $alerta = [
                        "Alerta"=>"simple",
                        "Titulo"=>"Ocurrio un error inesperado",
                        "Texto"=>"No hemos podido guardar las notas correspondientes.",
                        "Tipo"=>"error"
                    ];
                }
            }

            return mainModel::sweet_alert($alerta);
        }   
	}
?>