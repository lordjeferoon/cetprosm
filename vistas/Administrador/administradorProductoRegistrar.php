<div class="contenido-main">
                <div class="titulo-formulario">
                    <h2>Registrar <span>Producto</span></h2>
                </div>

                <form action="<?php echo SERVERURL;?>ajax/productoAjax.php" method="POST" data-form="guardar" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
                    <div class="form-group">
                        <label class="titulo-label">Nombre del Producto</label>
                        <input type="text" class="form-control" name="nombre" required autofocus style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                    </div>

                    <div class="form-group">
                        <label class="titulo-label">Descripción del Producto</label>
                        <input type="text" class="form-control" name="descripcion" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                    </div>

                    <div class="form-group">
                        <label class="titulo-label">Categoría</label>                            
                        <select  class="form-control" name="categoria">
                            <?php
                                $mysqli = new mysqli(SERVER,USER,PASS,DB);
                                $query = $mysqli -> query ("SELECT * FROM categorias WHERE ESTADO_CATEGORIA='Activo' ORDER BY NOMBRE_CATEGORIA");
                                while ($valores = mysqli_fetch_array($query)) {
                                    echo '<option value="'.$valores['ID_CATEGORIA'].'">'.$valores['NOMBRE_CATEGORIA'].'</option>';
                                }
                            ?>
                        </select>
                    </div>


                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label class="titulo-label">Estado</label>                            
                            <select  class="form-control" name="estado">
                                <option value="Activo" selected>ACTIVO</option>
                                <option value="Inactivo">INACTIVO</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="titulo-label">Precio</label>
                            <input type="number" step="0.01" class="form-control" name="precio" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="titulo-label">Unidades</label>
                            <input type="number" class="form-control" name="unidades">
                        </div>
                        
                    </div>
                    <br>


                    <div class="botones">
                        <button type="submit" class="btn boton-registrar btn-success col-xs-4">Registrar</button>
                        <button type="reset" class="btn boton-limpiar btn-secondary col-xs-4">Limpiar</button>
                    </div>
                    <br>

                    <div class="RespuestaAjax"></div>

                </form>
</div>
