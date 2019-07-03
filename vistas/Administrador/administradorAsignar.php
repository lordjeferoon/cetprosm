<div class="contenido-main">
                <div class="titulo-formulario">
                    <h2>Asignar <span>Docente</span></h2>
                </div>

                <form action="<?php echo SERVERURL;?>ajax/asignacionAjax.php" method="POST" data-form="guardar" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">

                    <div class="form-group">
                        <label class="titulo-label">Profesor</label>
                        <select  class="form-control" name="docente">
                            <option value="0">SELECCIONE UN DOCENTE</option>
                            <?php
                                $mysqli = new mysqli(SERVER,USER,PASS,DB);
                                $query = $mysqli -> query ("SELECT * FROM docentes ORDER BY APELLIDOS_DOCENTE");
                                while ($valores = mysqli_fetch_array($query)) {
                                    echo '<option value="'.$valores['ID_DOCENTE'].'">'.$valores['APELLIDOS_DOCENTE'].', '.$valores['NOMBRES_DOCENTE'].'</option>';
                                }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="titulo-label">Módulo</label>
                        <select  class="form-control" name="modulo">
                            <option value="0">SELECCIONE UN MÓDULO</option>
                            <?php
                                $mysqli = new mysqli(SERVER,USER,PASS,DB);
                                $query = $mysqli -> query ("SELECT * FROM modulos WHERE ESTADO_MODULO='Activo' ORDER BY ID_ESPECIALIDAD");
                                while ($valores = mysqli_fetch_array($query)) {
                                    echo '<option value="'.$valores['ID_MODULO'].'">'.$valores['NOMBRE_MODULO'].'</option>';
                                }
                            ?>
                        </select>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="titulo-label">Turno</label>
                            <select  class="form-control" name="turno">
                                <option value="M" selected>MAÑANA</option>
                                <option value="T">TARDE</option>
                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <label class="titulo-label">Frecuencia</label>
                            <select  class="form-control" name="frecuencia">
                                <option value="0">SELECCIONE UNA FRECUENCIA</option>
                                <?php
                                    $mysqli = new mysqli(SERVER,USER,PASS,DB);
                                    $query = $mysqli -> query ("SELECT * FROM frecuencias WHERE ESTADO_FRECUENCIA='Activo' ORDER BY NOMBRE_FRECUENCIA");
                                    while ($valores = mysqli_fetch_array($query)) {
                                        echo '<option value="'.$valores['ID_FRECUENCIA'].'">'.$valores['NOMBRE_FRECUENCIA'].'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label class="titulo-label">Fecha de inicio</label>
                            <input type="date" class="form-control" name="fecha-inicio" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="titulo-label">Fecha de fin</label>
                            <input type="date" class="form-control" name="fecha-fin" required>
                        </div>
                        <div class="form-group col-md-2">
                            <label class="titulo-label">Hora Inicio</label>
                            <input type="text" class="form-control" name="hora-inicio" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" required placeholder="10:00 AM">
                        </div>
                        <div class="form-group col-md-2">
                            <label class="titulo-label">Hora Fin</label>
                            <input type="text" class="form-control" name="hora-fin" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" required placeholder="10:00 AM">
                        </div>
                        <div class="form-group col-md-2">
                            <label class="titulo-label">Vacantes</label>
                            <input type="number" class="form-control" name="vacantes" required>
                        </div>
                    </div>
                    <br>

                    <div class="botones">
                        <button type="submit" class="btn boton-registrar btn-success col-xs-4">Asignar</button>
                        <button type="reset" class="btn boton-limpiar btn-secondary col-xs-4">Limpiar</button>
                    </div>

                    <div class="RespuestaAjax"></div>

                </form>
</div>
