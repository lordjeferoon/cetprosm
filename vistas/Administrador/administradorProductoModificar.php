<?php 
    require_once 'controladores/productoControlador.php';
    $insProducto = new productoControlador();

    $url = explode("/", $_GET['views']);
    $datos=$insProducto->datos_producto_controlador($url[1]);
    $datos=$datos->fetch();
?>
<div class="contenido-main">
                <div class="titulo-formulario">
                    <h2>Actualizar <span>Producto</span></h2>
                </div>

                <form action="<?php echo SERVERURL;?>ajax/productoAjax.php" method="POST" data-form="actualizar" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
                    <div class="form-group">
                        <label class="titulo-label">Nombre del Producto</label>
                        <input type="text" class="form-control" name="nombre-2" required autofocus style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" value="<?php echo $datos['NOMBRE_PRODUCTO']; ?>">
                    </div>

                    <div class="form-group">
                        <label class="titulo-label">Descripción del Producto</label>
                        <input type="text" class="form-control" name="descripcion-2" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" value="<?php echo $datos['DESCRIPCION_PRODUCTO']; ?>">
                    </div>

                    <div class="form-group">
                        <label class="titulo-label">Categoría</label>                            
                        <select  class="form-control" name="categoria-2">
                            <?php
                                $mysqli = new mysqli(SERVER,USER,PASS,DB);
                                $query = $mysqli -> query ("SELECT * FROM categorias WHERE ESTADO_CATEGORIA='Activo' ORDER BY NOMBRE_CATEGORIA");
                                while ($valores = mysqli_fetch_array($query)) {
                                    if($datos['ID_CATEGORIA']==$valores['ID_CATEGORIA']){
                                        echo '<option value="'.$valores['ID_CATEGORIA'].'" selected>'.$valores['NOMBRE_CATEGORIA'].'</option>';
                                    }
                                    else{
                                        echo '<option value="'.$valores['ID_CATEGORIA'].'">'.$valores['NOMBRE_CATEGORIA'].'</option>';
                                    }
                                }
                            ?>
                        </select>
                    </div>


                    <div class="form-row">
                        <?php 
                                if ($datos['ESTADO_PRODUCTO']=="Activo") {
                                    echo '<div class="form-group col-md-4">
                                            <label class="titulo-label">Estado</label>                            
                                            <select  class="form-control" name="estado-2">
                                                <option value="Activo" selected>ACTIVO</option>
                                                <option value="Inactivo">INACTIVO</option>
                                            </select> 
                                            </div>';
                                }
                                else{
                                    echo '<div class="form-group col-md-4">
                                            <label class="titulo-label">Estado</label>                            
                                            <select  class="form-control" name="estado-2">
                                                <option value="Activo">ACTIVO</option>
                                                <option value="Inactivo" selected>INACTIVO</option>
                                            </select> 
                                            </div>';
                                }
                        ?>  
                        <div class="form-group col-md-4">
                            <label class="titulo-label">Precio</label>
                            <input type="number" step="0.01" class="form-control" name="precio-2" required value="<?php echo $datos['PRECIO_PRODUCTO']; ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label class="titulo-label">Unidades</label>
                            <input type="number" class="form-control" name="unidades-2" value="<?php echo $datos['STOCK_PRODUCTO']; ?>">
                        </div>
                        
                    </div>
                    <br>

                    <input type="hidden" name="codigo-editar" value="<?php echo $datos['ID_PRODUCTO']; ?>">

                    <div class="botones">
                        <button type="submit" class="btn boton-registrar btn-success col-xs-4">Actualizar</button>
                    </div>
                    <br>

                    <div class="RespuestaAjax"></div>

                </form>
</div>
