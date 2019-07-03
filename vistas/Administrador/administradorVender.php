<?php
    $mysqli = new mysqli(SERVER,USER,PASS,DB);
?>
<div class="contenido-main">
                <div class="titulo-formulario">
                    <h2>Realizar <span>Venta</span></h2>
                </div>

                <form action="<?php echo SERVERURL;?>ajax/ventaAjax.php" method="POST" data-form="guardar" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
                    <div class="form-row"> 
                        <div class="form-group col-md-9">
                            <label class="titulo-label">Nombre del Cliente</label>
                            <input type="text" class="form-control" name="cliente" autofocus style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                        </div>
                        <div class="form-group col-md-3">
                            <label class="titulo-label">Fecha</label>
                            <input type="date" class="form-control" name="fecha" value="<?php echo date("Y-m-d");?>" required>
                        </div>
                    </div>

                    <label class="titulo-label">Productos</label>
                    <div class="form-row">
                        <div class="form-group col-md-10">
                            <select  class="form-control" name="producto-1">
                            <?php
                                echo '<option value="0">SELECCIONE UN PRODUCTO</option>';
                                $query = $mysqli -> query ("SELECT * FROM productos ORDER BY NOMBRE_PRODUCTO");
                                while ($valores = mysqli_fetch_array($query)) {
                                    echo '<option value="'.$valores['ID_PRODUCTO'].'">'.$valores['NOMBRE_PRODUCTO'].' / PRECIO: '.$valores['PRECIO_PRODUCTO'].' / STOCK: '.$valores['STOCK_PRODUCTO'].'</option>';
                                }
                            ?>
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <input type="number" class="form-control" name="unidades-1">
                        </div>
                        <!--<div class="form-group col-md-3">
                            <br>
                            <button type="button" class="btn boton-registrar btn-primary w-100">Agregar</button>
                        </div>-->
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-10">
                            <select  class="form-control" name="producto-2">
                            <?php
                                echo '<option value="0">SELECCIONE UN PRODUCTO</option>';
                                $query = $mysqli -> query ("SELECT * FROM productos ORDER BY NOMBRE_PRODUCTO");
                                while ($valores = mysqli_fetch_array($query)) {
                                    echo '<option value="'.$valores['ID_PRODUCTO'].'">'.$valores['NOMBRE_PRODUCTO'].' / PRECIO: '.$valores['PRECIO_PRODUCTO'].' / STOCK: '.$valores['STOCK_PRODUCTO'].'</option>';
                                }
                            ?>
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <input type="number" class="form-control" name="unidades-2">
                        </div>
                        <!--<div class="form-group col-md-3">
                            <br>
                            <button type="button" class="btn boton-registrar btn-primary w-100">Agregar</button>
                        </div>-->
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-10">
                            <select  class="form-control" name="producto-3">
                            <?php
                                echo '<option value="0">SELECCIONE UN PRODUCTO</option>';
                                $query = $mysqli -> query ("SELECT * FROM productos ORDER BY NOMBRE_PRODUCTO");
                                while ($valores = mysqli_fetch_array($query)) {
                                    echo '<option value="'.$valores['ID_PRODUCTO'].'">'.$valores['NOMBRE_PRODUCTO'].' / PRECIO: '.$valores['PRECIO_PRODUCTO'].' / STOCK: '.$valores['STOCK_PRODUCTO'].'</option>';
                                }
                            ?>
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <input type="number" class="form-control" name="unidades-3">
                        </div>
                        <!--<div class="form-group col-md-3">
                            <br>
                            <button type="button" class="btn boton-registrar btn-primary w-100">Agregar</button>
                        </div>-->
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-10">
                            <select  class="form-control" name="producto-4">
                            <?php
                                echo '<option value="0">SELECCIONE UN PRODUCTO</option>';
                                $query = $mysqli -> query ("SELECT * FROM productos ORDER BY NOMBRE_PRODUCTO");
                                while ($valores = mysqli_fetch_array($query)) {
                                    echo '<option value="'.$valores['ID_PRODUCTO'].'">'.$valores['NOMBRE_PRODUCTO'].' / PRECIO: '.$valores['PRECIO_PRODUCTO'].' / STOCK: '.$valores['STOCK_PRODUCTO'].'</option>';
                                }
                            ?>
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <input type="number" class="form-control" name="unidades-4">
                        </div>
                        <!--<div class="form-group col-md-3">
                            <br>
                            <button type="button" class="btn boton-registrar btn-primary w-100">Agregar</button>
                        </div>-->
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-10">
                            <select  class="form-control" name="producto-5">
                            <?php
                                echo '<option value="0">SELECCIONE UN PRODUCTO</option>';
                                $query = $mysqli -> query ("SELECT * FROM productos ORDER BY NOMBRE_PRODUCTO");
                                while ($valores = mysqli_fetch_array($query)) {
                                    echo '<option value="'.$valores['ID_PRODUCTO'].'">'.$valores['NOMBRE_PRODUCTO'].' / PRECIO: '.$valores['PRECIO_PRODUCTO'].' / STOCK: '.$valores['STOCK_PRODUCTO'].'</option>';
                                }
                            ?>
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <input type="number" class="form-control" name="unidades-5">
                        </div>
                        <!--<div class="form-group col-md-3">
                            <br>
                            <button type="button" class="btn boton-registrar btn-primary w-100">Agregar</button>
                        </div>-->
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-9">
                            
                        </div>
                        <div class="form-group col-md-3">
                            <label class="titulo-label">Pago</label>
                            <input type="number" step="0.01" class="form-control" name="adelanto" required> 
                        </div>
                    </div>

                    <!--<table class="table table-hover table-sm">
                        <thead class="table-secondary">
                            <tr>
                                <th scope="col" width="2%">No</th>
                                <th scope="col">Producto</th>
                                <th scope="col" width="2%">Unids.</th>
                                <th scope="col" width="4%">P.Unit.</th>
                                <th scope="col" width="4%">Importe</th>
                                <th scope="col" width="2%">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="align-middle">1</td>
                                <td class="align-middle">CAMISA MANGA LARGA T-L</td>
                                <td class="align-middle text-center">2</td>
                                <td class="align-middle text-right">50.00</td>
                                <td class="align-middle text-right">100.00</td>
                                <td>
                                    &nbsp;&nbsp;<a href="index.php?aksi=delete&nik='.$row['codigo'].'" title="Eliminar" onclick="return confirm(\'Esta seguro de borrar los datos '.$row['nombres'].'?\')" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td class="align-middle">2</td>
                                <td class="align-middle">PANTALÓN NEGRO T-L</td>
                                <td class="align-middle text-center">2</td>
                                <td class="align-middle text-right">45.00</td>
                                <td class="align-middle text-right">90.00</td>
                                <td>
                                  &nbsp;&nbsp;<a href="index.php?aksi=delete&nik='.$row['codigo'].'" title="Eliminar" onclick="return confirm(\'Esta seguro de borrar los datos '.$row['nombres'].'?\')" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></a>
                                </td>
                            </tr>

                            <tr>
                              <td colspan="4"><span class="float-right font-weight-bold">Total</span></td>
                              <td colspan="2"><input type="number" class="text-right" name="total" style="width: 70px; font-weight: bold;" value="190.00"></td>
                            </tr>

                            <tr>
                              <td colspan="4"><span class="float-right font-weight-bold">Adelanto</span></td>
                              <td colspan="2"><input type="number" class="text-right" name="adelanto" style="width: 70px; font-weight: bold;"></td>
                            </tr>
                        </tbody>
                    </table>-->



                    <div class="botones">
                        <button type="submit" class="btn boton-registrar btn-success col-xs-4">Vender</button>
                        <button type="reset" class="btn boton-limpiar btn-secondary col-xs-4">Limpiar</button>
                    </div>

                    <div class="RespuestaAjax"></div>

                </form>
</div>