<div class="contenido-main">
                <div class="titulo-formulario">
                    <h2>Registrar <span>Módulo</span></h2>
                </div>

                <form action="<?php echo SERVERURL;?>ajax/moduloAjax.php" method="POST" data-form="guardar" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
 
                    <div class="form-group">
                        <label class="titulo-label">Nombre del Módulo</label>
                        <input type="text" class="form-control" name="nombre" required autofocus style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                    </div>
                    
                    <div class="form-group">
                        <label class="titulo-label">Especialidad</label>                            
                        <select  class="form-control" name="especialidad">
                            <?php
                                $mysqli = new mysqli(SERVER,USER,PASS,DB);
                                $query = $mysqli -> query ("SELECT * FROM especialidades WHERE ESTADO_ESPECIALIDAD='Activo' ORDER BY NOMBRE_ESPECIALIDAD ");
                                while ($valores = mysqli_fetch_array($query)) {
                                    echo '<option value="'.$valores['ID_ESPECIALIDAD'].'">'.$valores['NOMBRE_ESPECIALIDAD'].'</option>';
                                }
                            ?>
                        </select>
                    </div>

                    <!--<div class="form-row">
                        <div class="form-group col-md-4">
                            <label class="titulo-label">Fecha de inicio</label>
                            <input type="date" class="form-control" name="fecha-inicio" placeholder="DD/MM/AAAA" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="titulo-label">Fecha de fin</label>
                            <input type="date" class="form-control" name="fecha-fin" placeholder="DD/MM/AAAA" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="titulo-label">Duración en horas</label>
                            <input type="number" class="form-control" name="duración" placeholder="Ej. 300" required>
                        </div>
                    </div>-->

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
                            <input type="number" step="0.01" class="form-control" name="precio" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="titulo-label">Duración en meses</label>
                            <input type="text" class="form-control" name="meses" required style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" placeholder="ej. 2 meses y medio">
                        </div>          
                        <div class="form-group col-md-6">
                            <label class="titulo-label">Duración en horas</label>
                            <input type="tect" class="form-control" name="horas" required style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" placeholder="ej. 300 horas">
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
