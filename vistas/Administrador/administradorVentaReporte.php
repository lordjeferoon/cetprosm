 <?php
    $mysqli = new mysqli(SERVER,USER,PASS,DB);

    if(isset($_POST['codigo'])){
        $id=$_POST['codigo'];
    }else{
        $pagina = explode("/", $_GET['views']);
        $id=$pagina[1];
    }

    $consulta=$mysqli->query("SELECT * FROM ventas WHERE CODIGO_VENTA='$id'");
    $matricula = $consulta->fetch_assoc();

    if(isset($matricula['CODIGO_VENTA'])){
        $cod=$matricula['CODIGO_VENTA'];
        $consulta2=$mysqli->query("SELECT * FROM venta_detalle WHERE CODIGO_VENTA='$cod'");
?>
<div class="contenido-main">
                <div class="titulo-formulario">
                    <h2><span>Reporte de</span> Venta</h2>
                </div>

                <form action="<?php echo SERVERURL;?>administradorVentaPDF" method="post" target="_blank">
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <br><br>
                            <label class="titulo-label">Estado:</label>
                            <?php 
                                if($matricula['ESTADO_PAGO']=="Cancelado"){
                                    echo '<label class="titulo-label text-success">'.$matricula['ESTADO_PAGO'].'</label>';
                                }
                                else{
                                    echo '<label class="titulo-label text-danger">'.$matricula['ESTADO_PAGO'].'</label>';
                                }
                            ?>
                        </div>
                        <div class="form-group col-md-5">
                            
                        </div>
                        <div class="form-group col-md-3">
                            <br>
                            <input type="hidden" name="reporte_name" value="Reporte de Venta">
                            <input type="hidden" name="codigo" value="<?php echo $id; ?>">
                            <button type="submit" name="create_pdf" class="btn boton-registrar btn-success w-100">Exportar a PDF</button>
                        </div>
                    </div>
                </form>

                <form action="<?php echo SERVERURL;?>ajax/ventaAjax.php" method="POST" data-form="actualizar" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">

                    <div class="form-row">
                        <div class="form-group col-md-9">
                            <label class="titulo-label">Cliente</label>
                            <input type="text" class="form-control" name="alumno" required style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" value="<?php echo $matricula['CLIENTE']; ?>">
                        </div>
                        <!--<div class="form-group col-md-3">
                            <label class="titulo-label">Código de Matrícula:</label>
                            <input type="text" class="form-control" name="codigo-matricula">          
                        </div>-->
                        <div class="form-group col-md-3">
                            <label class="titulo-label">Fecha</label>
                            <input type="date" class="form-control" name="fecha" value="<?php echo $matricula['FECHA'];?>" required>
                        </div>
                    </div>
                    <br>

                    <table class="table table-hover table-sm">
                        <thead class="table-secondary">
                            <tr>
                                <th scope="col" width="5%">N.</th>
                                <th scope="col" width="50%">Producto</th>
                                <th scope="col" width="15%">Precio Unitario</th>
                                <th scope="col" width="15%">Unidades</th>
                                <th scope="col" width="15%">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $i=1;
                                while($detalle = $consulta2->fetch_assoc()) {
                                    $idAsignacion = $detalle['ID_PRODUCTO'];
                                    $consulta3=$mysqli->query("SELECT * FROM productos WHERE ID_PRODUCTO=$idAsignacion");
                                    $asignacion = $consulta3->fetch_assoc();

                                    $total=$asignacion['PRECIO_PRODUCTO']*$asignacion['PRECIO_PRODUCTO'];

                                    echo '
                                        <tr>
                                            <td class="align-middle">'.$i.'</td>
                                            <td class="align-middle">'.$asignacion['NOMBRE_PRODUCTO'].'</td>
                                            <td class="align-middle">'.$asignacion['PRECIO_PRODUCTO'].'</td>
                                            <td class="align-middle">'.$detalle['UNIDADES'].'</td>
                                            <td class="align-middle">'.$total.'</td>
                                        </tr>
                                    ';
                                    $i++;
                                }
                            ?>
                        </tbody>
                    </table>
                    <br>

                    <input type="hidden" name="codigo" value="<?php echo $id; ?>">

                    <?php  
                        if($matricula['ESTADO_PAGO']!="Cancelado"){
                            $resta=$matricula['TOTAL']-$matricula['ADELANTO'];
                            echo '<div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label class="titulo-label">Resta: S/. '.$resta.'</label> 
                                    </div>
                                    <div class="form-group col-md-5"> 
                                    </div>
                                    <div class="form-group col-md-3 row"> 
                                        <label class="titulo-label">Adelanto</label>
                                        <input type="number" step="0.01" class="form-control" name="adelanto" required> 
                                    </div>
                                </div>
                                
                                <div class="botones">
                                    <button type="submit" class="btn boton-registrar btn-success col-xs-4">Actualizar Saldo</button>
                                </div>';
                        }
                    ?>

                    <div class="RespuestaAjax"></div>
                </form>
</div>
<?php 
    }
    else{
       echo '<div class="contenido-main">
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <div>
                    <div>
                        <p class="text-center"><i class="far fa-times-circle fa-7x" style="color: #192F72;"></i></p>
                        <h3 class="text-center" style="color: #192F72;">BOLETA DE VENTA NO ENCONTRADA</h3>
                    </div>
                </div>
            </div>
        '; 
    }
?>