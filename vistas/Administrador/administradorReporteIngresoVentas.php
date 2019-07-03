<?php
    if(isset($_POST['categoria']) && isset($_POST['fechai']) && isset($_POST['fechaf'])){
        $categoria=$_POST['categoria'];
        $fechai=$_POST['fechai']; 
        $fechaf=$_POST['fechaf'];
    }
?>
<div class="contenido-main">
                <div class="titulo-formulario">
                    <h2>Reporte de <span>Ingresos de Ventas</span></h2>
                </div>

                <form action="<?php echo SERVERURL;?>administradorReporteIngresoVentas/" method="POST">
                    <div class="form-row"> 
                        <div class="form-group col-md-3">
                            <label class="titulo-label">Categoría</label>                            
                            <select  class="form-control" name="categoria">
                                <?php
                                    $mysqli = new mysqli(SERVER,USER,PASS,DB);
                                    $query = $mysqli -> query ("SELECT * FROM categorias WHERE ESTADO_CATEGORIA='Activo' ORDER BY NOMBRE_CATEGORIA");
                                    echo '<option value="0">TODO</option>';
                                    while ($valores = mysqli_fetch_array($query)) {
                                        echo '<option value="'.$valores['ID_CATEGORIA'].'">'.$valores['NOMBRE_CATEGORIA'].'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="titulo-label">Fecha Inicio</label>
                            <input type="date" class="form-control" name="fechai" value="<?php echo date("Y-m-d");?>" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="titulo-label">Fecha Fin</label>
                            <input type="date" class="form-control" name="fechaf" value="<?php echo date("Y-m-d");?>" required>
                        </div>
                        
                        <div class="form-group col-md-3">
                            <label></label>
                            <button type="submit" class="btn boton-registrar btn-primary w-100">Ver reporte</button>
                        </div>
                    </div>
                </form>
                <br>
                
                <?php
                    if(isset($_POST['categoria']) && isset($_POST['fechai']) && isset($_POST['fechaf'])){

                        if($categoria=="0"){
                            echo '<br><div align="center" class="font-weight-bold">REPORTE DE INGRESOS POR VENTAS DEL '.$fechai.' AL '.$fechaf.'</div><br>';
                        }else{
                            $mysqli = new mysqli(SERVER,USER,PASS,DB);
                            $query = $mysqli -> query ("SELECT * FROM categorias WHERE ID_CATEGORIA=$categoria");
                            while ($valores = mysqli_fetch_array($query)) {
                                echo '<br><div align="center" class="font-weight-bold">REPORTE DE INGRESOS POR VENTAS DEL '.$fechai.' AL '.$fechaf.'</div>
                                    <div align="center" class="font-weight-bold">CATEGORIA: '.$valores['NOMBRE_CATEGORIA'].'</div><br>
                                ';
                            }
                        }
                        
                        require_once 'controladores/ventaControlador.php';
                        $ins = new ventaControlador();
                        
                        $pagina = explode("/", $_GET['views']);
                        echo $ins->paginador_ingreso_ventas_controlador($_SESSION["privilegio_csm"],$_SESSION["codigo_cuenta_csm"],$categoria,$fechai,$fechaf);

                        echo '
                            <div class="form-row"> 
                                <div class="form-group col-md-8">
                                </div>
                                <div class="form-group col-md-2">
                                    <form action="'.SERVERURL.'administradorReporteIngresoVentasEXCEL" method="post" target="_blank">
                                        <input type="hidden" name="categoria" value="'.$categoria.'">
                                        <input type="hidden" name="fecha-inicio" value="'.$fechai.'">
                                        <input type="hidden" name="fecha-fin" value="'.$fechaf.'">
                                        <input type="hidden" name="reporte-name" value="REPORTE DE INGRESOS POR VENTAS">
                                        <button type="submit" class="btn boton-registrar btn-success w-100"><i class="fas fa-file-excel"></i> Excel</button>
                                    </form>
                                </div>

                                <div class="form-group col-md-2">
                                    <form action="'.SERVERURL.'administradorReporteIngresoVentasPDF" method="post" target="_blank">
                                        <input type="hidden" name="categoria" value="'.$categoria.'">
                                        <input type="hidden" name="fecha-inicio" value="'.$fechai.'">
                                        <input type="hidden" name="fecha-fin" value="'.$fechaf.'">
                                        <input type="hidden" name="reporte-name" value="REPORTE DE INGRESOS POR VENTAS">
                                        <button type="submit" name="create_pdf" class="btn boton-registrar btn-success w-100"><i class="fas fa-file-pdf"></i> PDF</button>
                                    </form>
                                </div>
                            </div>
                        ';
                    }

                ?>
</div>