<div class="contenido-main">
                <div class="titulo-formulario">
                    <h2>Registrar <span>Profesor</span></h2>
                </div>

                <form action="<?php echo SERVERURL;?>ajax/docenteAjax.php" method="POST" data-form="guardar" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
                    <fieldset>
                        <legend>Datos personales</legend>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="titulo-label">Apellidos</label>
                                <input type="text" class="form-control" name="apellidos" required autofocus style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                            </div>
                            <div class="form-group col-md-6">
                                <label class="titulo-label">Nombres</label>
                                <input type="text" class="form-control" name="nombres" required style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label class="titulo-label">Dni</label>
                                <input type="number" class="form-control" name="dni" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="titulo-label">Fecha de nacimiento</label>
                                <input type="date" class="form-control" name="fecha-nacimiento" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="titulo-label">Sexo</label>                            
                                <select  class="form-control" name="sexo">
                                    <option value="M" selected>MASCULINO</option>
                                    <option value="F">FEMENINO</option>
                                </select>
                            </div>
                        </div>
                    </fieldset>
                    <br>
                    <br>


                    <fieldset>
                        <legend>Datos Adicionales y de contacto</legend>
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label class="titulo-label">Estado</label>
                                <select  class="form-control" name="estado">
                                    <option value="Activo" selected>ACTIVO</option>
                                    <option value="Inactivo">INACTIVO</option>
                                </select>
                            </div>           
                            <div class="form-group col-md-3">
                                <label class="titulo-label">Teléfono</label>
                                <input type="number" class="form-control" name="numero" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="titulo-label">Correo electrónico</label>                            
                                <input type="email" class="form-control" name="email" required>
                            </div>
                        </div>
                    </fieldset>
                    <br>
                    <br>
                    
                    <fieldset >
                        <legend>Datos domiciliarios</legend>
                        <div class="form-group">
                            <label class="titulo-label">Dirección</label>
                            <input type="text" class="form-control" name="direccion" required style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">                       
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label class="titulo-label">Distrito</label>                            
                                <input type="text" class="form-control" name="distrito" required style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                            </div>
                            <div class="form-group col-md-8">
                                <label class="titulo-label">Referencia</label>                            
                                <input type="text" class="form-control" name="referencia" required style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                            </div>
                        </div>
                    </fieldset>
                    <br>
                    <br>

                    <fieldset >
                        <legend>Datos de la cuenta</legend>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label class="titulo-label">Usuario</label>                            
                                <input type="text" class="form-control" name="usuario" required style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                            </div>
                            <div class="form-group col-md-4">
                                <label class="titulo-label">Contraseña</label>                            
                                <input type="password" class="form-control" name="contraseña1" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="titulo-label">Repita la Contraseña</label>                            
                                <input type="password" class="form-control" name="contraseña2" required>
                            </div>
                        </div>
                    </fieldset>
                    <br>
                    <br>

                    <div class="botones">
                        <button type="submit" class="btn boton-registrar btn-success col-xs-4">Registrar</button>
                        <button type="reset" class="btn boton-limpiar btn-secondary col-xs-4">Limpiar</button>
                    </div>
                    <br>

                    <div class="RespuestaAjax"></div>
                    
                </form>
</div>