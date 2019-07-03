<div class="contenido-main">
                <div class="titulo-formulario">
                    <h2>Registrar <span>Frecuencia</span></h2>
                </div>

                <form name="f1" action="<?php echo SERVERURL;?>ajax/frecuenciaAjax.php" method="POST" data-form="guardar" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
 
                    <div class="form-group">
                        <label class="titulo-label">Escriba la Frecuencia</label>
                        <input type="text" class="form-control" name="nombre1"  required autofocus style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                    </div>

                    <div class="form-group">
                        <label class="titulo-label">Repita la Frecuencia</label>
                        <input type="text" class="form-control" name="nombre2"  required style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                    </div>

                    <div class="form-group">
                        <label class="titulo-label">Estado</label>
                        <select  class="form-control" name="estado">
                            <option value="Activo" selected>ACTIVO</option>
                            <option value="Inactivo">INACTIVO</option>
                        </select>
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
