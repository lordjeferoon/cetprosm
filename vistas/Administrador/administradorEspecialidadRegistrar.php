<div class="contenido-main">
                <div class="titulo-formulario">
                    <h2>Registrar <span>Especialidad</span></h2>
                </div>

                <form action="<?php echo SERVERURL;?>ajax/especialidadAjax.php" method="POST" data-form="guardar" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
 
                    <div class="form-group">
                        <label class="titulo-label">Nombre de la Especialidad </label>
                        <input type="text" class="form-control" name="nombre1"  required autofocus style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                    </div>

                    <div class="form-group">
                        <label class="titulo-label">Repita el nombre de la Especialidad </label>
                        <input type="text" class="form-control" name="nombre2"  required style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="titulo-label">Estado</label>
                            <select  class="form-control" name="estado">
                                <option value="Activo" selected>ACTIVO</option>
                                <option value="Inactivo">INACTIVO</option>
                            </select>
                        </div>           
                        <div class="form-group col-md-6">
                            <label class="titulo-label">Precio</label>
                            <input type="number" step="0.01" class="form-control" name="precio">
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
