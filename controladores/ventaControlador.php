<?php
    if ($peticionAjax) {
        require_once "../modelos/ventaModelo.php";
    }
    else{
        require_once "modelos/ventaModelo.php";
    }
  
    class ventaControlador extends ventaModelo
    {
        public function agregar_venta_controlador(){
            $cliente=$_POST['cliente'];
            $producto1=$_POST['producto-1'];
            $producto2=$_POST['producto-2'];
            $producto3=$_POST['producto-3'];
            $producto4=$_POST['producto-4'];
            $producto5=$_POST['producto-5'];

            $adelanto=$_POST['adelanto'];
            $total=0;
            $fecha=$_POST['fecha'];

            $unidades1=0;
            $unidades2=0;
            $unidades3=0;
            $unidades4=0;
            $unidades5=0;

            $unidadesNueva1=0;
            $unidadesNueva2=0;
            $unidadesNueva3=0;
            $unidadesNueva4=0;
            $unidadesNueva5=0;

            if(!empty($_POST['unidades-1'])){
                $unidades1=$_POST['unidades-1'];
            }
            if(!empty($_POST['unidades-2'])){
                $unidades2=$_POST['unidades-2'];
            }
            if(!empty($_POST['unidades-3'])){
                $unidades3=$_POST['unidades-3'];
            }
            if(!empty($_POST['unidades-4'])){
                $unidades4=$_POST['unidades-4'];
            }
            if(!empty($_POST['unidades-5'])){
                $unidades4=$_POST['unidades-5'];
            }

            $productos = array();

            if($producto1!=0){
                array_push($productos,$producto1);
            }
            if($producto2!=0){
                array_push($productos,$producto2);
            }
            if($producto3!=0){
                array_push($productos,$producto3);
            }
            if($producto4!=0){
                array_push($productos,$producto4);
            }
            if($producto5!=0){
                array_push($productos,$producto5);
            }

            $iguales="false";
            for($i=0;$i<sizeof($productos);$i++){
                for($j=0;$j<sizeof($productos);$j++){
                    if($i!=$j){
                        if($productos[$i]==$productos[$j]){
                            $iguales="true";
                        }
                    }
                }
            }

            /*$modIguales="false";
            for($i=0;$i<sizeof($modulos);$i++){
                for($j=0;$j<sizeof($modulos);$j++){
                    if($i!=$j){
                        if($modulos[$i]==$modulos[$j]){
                            $modIguales="true";
                        }
                    }
                }
            }*/

            if($cliente==""){
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un error inesperado",
                    "Texto"=>"No ha ingresado un cliente para la venta",
                    "Tipo"=>"error"
                ];
            }
            else{
                if($producto1==0 && $producto2==0 && $producto3==0 && $producto4==0 && $producto5==0){
                    $alerta = [
                        "Alerta"=>"simple",
                        "Titulo"=>"Ocurrio un error inesperado",
                        "Texto"=>"No ha seleccionado productos para la venta",
                        "Tipo"=>"error"
                    ];
                }
                else{

                    $error="false";
                        
                    if($producto1!=0){
                        if($unidades1<=0){
                            $error = "true";
                        }
                    }
                    if($producto2!=0){
                        if($unidades2<=0){
                            $error = "true";
                        }
                    }
                    if($producto3!=0){
                        if($unidades3<=0){
                            $error = "true";
                        }
                    }
                    if($producto4!=0){
                        if($unidades4<=0){
                            $error = "true";
                        }
                    }
                    if($producto5!=0){
                        if($unidades5<=0){
                            $error = "true";
                        }
                    }

                    if($error=="true"){
                        $alerta = [
                            "Alerta"=>"simple",
                            "Titulo"=>"Ocurrio un error inesperado",
                            "Texto"=>"Algunas de las cantidades ingresadas no son correctas",
                            "Tipo"=>"error"
                        ];
                    }
                    else{
                        $error="false";
                        $precio1=0;
                        $precio2=0;
                        $precio3=0;
                        $precio4=0;
                        $precio5=0;

                        if($producto1!=0){
                            $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM productos WHERE ID_PRODUCTO=$producto1");
                            $prod=$consulta->fetch();
                            $stock=$prod['STOCK_PRODUCTO'];
                            $total=$total+$prod['PRECIO_PRODUCTO']*$unidades1;
                            $precio1=$prod['PRECIO_PRODUCTO'];
                            if($unidades1>$stock){
                                $error="true";
                            }
                            else{
                                $unidadesNueva1=$stock-$unidades1;
                            }
                        }
                        if($producto2!=0){
                            $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM productos WHERE ID_PRODUCTO=$producto2");
                            $prod=$consulta->fetch();
                            $stock=$prod['STOCK_PRODUCTO'];
                            $total=$total+$prod['PRECIO_PRODUCTO']*$unidades2;
                            $precio2=$prod['PRECIO_PRODUCTO'];
                            if($unidades2>$stock){
                                $error="true";
                            }
                            else{
                                $unidadesNueva2=$stock-$unidades2;
                            }
                        }
                        if($producto3!=0){
                            $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM productos WHERE ID_PRODUCTO=$producto3");
                            $prod=$consulta->fetch();
                            $stock=$prod['STOCK_PRODUCTO'];
                            $total=$total+$prod['PRECIO_PRODUCTO']*$unidades3;
                            $precio3=$prod['PRECIO_PRODUCTO'];
                            if($unidades3>$stock){
                                $error="true";
                            }
                            else{
                                $unidadesNueva3=$stock-$unidades3;
                            }
                        }
                        if($producto4!=0){
                            $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM productos WHERE ID_PRODUCTO=$producto4");
                            $prod=$consulta->fetch();
                            $stock=$prod['STOCK_PRODUCTO'];
                            $total=$total+$prod['PRECIO_PRODUCTO']*$unidades4;
                            $precio4=$prod['PRECIO_PRODUCTO'];
                            if($unidades4>$stock){
                                $error="true";
                            }
                            else{
                                $unidadesNueva4=$stock-$unidades4;
                            }
                        }
                        if($producto5!=0){
                            $consulta = mainModel::ejecutar_consulta_simple("SELECT * FROM productos WHERE ID_PRODUCTO=$producto5");
                            $prod=$consulta->fetch();
                            $stock=$prod['STOCK_PRODUCTO'];
                            $total=$total+$prod['PRECIO_PRODUCTO']*$unidades5;
                            $precio5=$prod['PRECIO_PRODUCTO'];
                            if($unidades5>$stock){
                                $error="true";
                            }
                            else{
                                $unidadesNueva5=$stock-$unidades5;
                            }
                        }

                        if($error=="true"){
                            $alerta = [
                                "Alerta"=>"simple",
                                "Titulo"=>"Ocurrio un error inesperado",
                                "Texto"=>"Algunas de las cantidades superan el stock del producto",
                                "Tipo"=>"error"
                            ];
                        }
                        else{
                            if($adelanto<=0){
                                 $alerta = [
                                    "Alerta"=>"simple",
                                    "Titulo"=>"Ocurrio un error inesperado",
                                    "Texto"=>"Ingrese un valor apropiado para el adelanto",
                                    "Tipo"=>"error"
                                ];

                            }
                            else{
                                if($adelanto>$total){
                                    $alerta = [
                                        "Alerta"=>"simple",
                                        "Titulo"=>"Ocurrio un error inesperado",
                                        "Texto"=>"El valor del adelanto es mayor al total",
                                        "Tipo"=>"error"
                                    ];

                                }
                                else{
                                    if($adelanto<$total){
                                        $alerta = [
                                            "Alerta"=>"simple",
                                            "Titulo"=>"Ocurrio un error inesperado",
                                            "Texto"=>"El valor del adelanto es menor al total",
                                            "Tipo"=>"error"
                                        ];
                                    }
                                    else{

                                        $consulta1=mainModel::ejecutar_consulta_simple("SELECT ID_VENTA FROM ventas");
                                        $numero = ($consulta1->rowCount())+1;
                                        $codigoVenta = mainModel::generar_codigo_aleatorio("VEN",5,$numero);

                                        if($adelanto==$total){
                                            $pagado="Cancelado";
                                        }
                                        else{
                                            $pagado="No Cancelado";
                                        }

                                        session_start(['name'=>'CSM']);
                                        $datosVenta=[
                                            "Codigo"=>$codigoVenta,
                                            "EstadoPago"=>$pagado,
                                            "Total"=>$total,
                                            "Adelanto"=>$adelanto,
                                            "Fecha"=>$fecha,
                                            "Cliente"=>$cliente,
                                            "Producto1"=>$producto1,
                                            "Producto2"=>$producto2,
                                            "Producto3"=>$producto3,
                                            "Producto4"=>$producto4,
                                            "Producto5"=>$producto5,
                                            "Unidades1"=>$unidades1,
                                            "Unidades2"=>$unidades2,
                                            "Unidades3"=>$unidades3,
                                            "Unidades4"=>$unidades4,
                                            "Unidades5"=>$unidades5,
                                            "Precio1"=>$precio1,
                                            "Precio2"=>$precio2,
                                            "Precio3"=>$precio3,
                                            "Precio4"=>$precio4,
                                            "Precio5"=>$precio5,
                                            "Nueva1"=>$unidadesNueva1,
                                            "Nueva2"=>$unidadesNueva2,
                                            "Nueva3"=>$unidadesNueva3,
                                            "Nueva4"=>$unidadesNueva4,
                                            "Nueva5"=>$unidadesNueva5,
                                            "Operador"=>$_SESSION['codigo_cuenta_csm']
                                        ];

                                        $guardarVenta=ventaModelo::agregar_venta_modelo($datosVenta);

                                        if($guardarVenta->rowCount()>=1){
                                            $alerta = [
                                                "Alerta"=>"recargar",
                                                "Titulo"=>"Venta realizada",
                                                "Texto"=>"La venta se realizó con éxito en el sistema.",
                                                "Tipo"=>"success"
                                            ];
                                        }
                                        else{
                                            $alerta = [
                                                "Alerta"=>"simple",
                                                "Titulo"=>"Ocurrio un error inesperado",
                                                "Texto"=>"No hemos podido realizar la venta correspondiente.",
                                                "Tipo"=>"error"
                                            ];
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            return mainModel::sweet_alert($alerta);
        }
        
        public function paginador_ingreso_ventas_controlador($privilegio, $codigoAdmin, $categoria, $fecha1, $fecha2){
            $privilegio=mainModel::limpiar_cadena($privilegio);
            $codigoAdmin=mainModel::limpiar_cadena($codigoAdmin);
            $categoria=mainModel::limpiar_cadena($categoria);
            $fechai=mainModel::limpiar_cadena($fecha1);
            $fechaf=mainModel::limpiar_cadena($fecha2);
            
            $tabla="";
            $anoActual=date("Y");

            $mysqli = new mysqli(SERVER,USER,PASS,DB);
            $conexion = mainModel::conectar();
            
            if($categoria=="0"){
                $ventas = $conexion->prepare("
                SELECT SQL_CALC_FOUND_ROWS * FROM ventas WHERE FECHA BETWEEN '$fechai' AND '$fechaf' ORDER BY FECHA"); 
            }
            else{
                $ventas = $conexion->prepare("
                SELECT SQL_CALC_FOUND_ROWS * FROM ventas WHERE FECHA BETWEEN '$fechai' AND '$fechaf' ORDER BY FECHA");   
            }
            $ventas->execute();
            $ventas = $ventas->fetchAll();
            
            $total = $conexion->query("SELECT FOUND_ROWS()");
            $total = (int) $total->fetchColumn();
            
            $contador=1;
            $tabla='
                <table class="table table-hover table-sm">
                    <thead class="table-secondary">
                        <tr>
                            <th width="4%">No</th>
                            <th width="7%">Codigo</th>
                            <th width="12%">Fecha</th>
                            <th>Cliente</th>
                            <th width="7%">Total</th>
                            <th width="7%">Estado</th>
                            <th width="6%">Acciones</th>
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
                    foreach($ventas as $venta){
                        $resta=$venta['TOTAL']-$venta['ADELANTO'];

                        $codigoVenta = $venta['CODIGO_VENTA'];
                        $detalles = $conexion->prepare("
                            SELECT * FROM venta_detalle WHERE CODIGO_VENTA='$codigoVenta'"
                        );   
                        $detalles->execute();
                        $detalles = $detalles->fetchAll();

                        $encontrado="falso";
                        foreach ($detalles as $detalle) {
                            
                            $idProducto = $detalle['ID_PRODUCTO'];
                            $producto = $conexion->prepare("
                                SELECT * FROM productos WHERE ID_PRODUCTO=$idProducto"
                            );   
                            $producto->execute();
                            $producto = $producto->fetch();

                            if($categoria==0){
                                $encontrado="verdadero";
                            }
                            else{
                                if($categoria==$producto['ID_CATEGORIA']){
                                    $encontrado="verdadero";
                                }
                            }
                        }

                        if($encontrado=="verdadero"){
                            
                            if($resta<=0){
                                $resta=0;
                            }
                
                            $fechas=explode("-",$venta['FECHA']);
                            $fecha=$fechas[2]."/".$fechas[1]."/".$fechas[0];

                            $montoTotal=$montoTotal+$venta['TOTAL'];
                            $tabla.='
                                <tr>
                                    <td class="align-middle">'.$contador.'</td>
                                    <td class="align-middle">'.$venta['CODIGO_VENTA'].'</td>
                                    <td class="align-middle">'.$fecha.'</td>
                                    <td class="align-middle">'.$venta['CLIENTE'].'</td>
                                    <td class="align-middle text-center">'.$venta['TOTAL'].'</td>
                            ';
                            
                            if($venta['ESTADO_PAGO']=="Cancelado"){
                                $tabla.='
                                    <td class="text-success font-weight-bold align-middle">'.$venta['ESTADO_PAGO'].'</td>
                                ';
                            }
                            else{
                                $tabla.='
                                    <td class="text-danger font-weight-bold align-middle">'.$venta['ESTADO'].'</td>
                                ';
                            }
                            
                            $tabla.='
                                    <td class="align-middle text-center">
                                        <form style="display:inline">
                                            <a href="'.SERVERURL.'administradorVentaReporte/'.$venta['CODIGO_VENTA'].'" title="Ver" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                                        </form>
                                    </td>
                                </tr>
                            ';
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
            ';
            
            
            return $tabla;
        }
    }
?>