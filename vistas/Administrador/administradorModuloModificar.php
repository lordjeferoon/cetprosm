<?php 
    require_once 'controladores/moduloControlador.php';
    $insModulo = new moduloControlador();

    $url = explode("/", $_GET['views']);
    $datos=$insModulo->datos_modulo_controlador($url[1]);
    $datos=$datos->fetch();
?>
<div class="contenido-main">
                <div class="titulo-formulario">
                    <h2>Actualizar <span>Módulo</span></h2>
                </div>

                <form action="<?php echo SERVERURL;?>ajax/moduloAjax.php" method="POST" data-form="actualizar" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
 
                    <div class="form-group">
                        <label class="titulo-label">Nombre del Módulo</label>
                        <input type="text" class="form-control" name="nombre-2" required autofocus style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" value="<?php echo $datos['NOMBRE_MODULO']; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label class="titulo-label">Especialidad</label>                            
                        <select  class="form-control" name="especialidad-2">
                            <?php
                                $mysqli = new mysqli(SERVER,USER,PASS,DB);
                                $query = $mysqli -> query ("SELECT * FROM especialidades WHERE ESTADO_ESPECIALIDAD='Activo' ORDER BY NOMBRE_ESPECIALIDAD");
                                while ($valores = mysqli_fetch_array($query)) {
                                    if($datos['ID_ESPECIALIDAD']==$valores['ID_ESPECIALIDAD']){
                                        echo '<option value="'.$valores['ID_ESPECIALIDAD'].'" selected>'.$valores['NOMBRE_ESPECIALIDAD'].'</option>';
                                    }
                                    else{
                                        echo '<option value="'.$valores['ID_ESPECIALIDAD'].'">'.$valores['NOMBRE_ESPECIALIDAD'].'</option>';
                                    }
                                    
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
                        <?php 
                                if ($datos['ESTADO_MODULO']=="Activo") {
                                    echo '<div class="form-group col-md-6">
                                            <label class="titulo-label">Estado</label>                            
                                            <select  class="form-control" name="estado-2">
                                                <option value="Activo" selected>ACTIVO</option>
                                                <option value="Inactivo">INACTIVO</option>
                                            </select> 
                                            </div>';
                                }
                                else{
                                    echo '<div class="form-group col-md-6">
                                            <label class="titulo-label">estado</label>                            
                                            <select  class="form-control" name="estado-2">
                                                <option value="Activo">ACTIVO</option>
                                                <option value="Inactivo" selected>INACTIVO</option>
                                            </select> 
                                            </div>';
                                }
                        ?>          
                        <div class="form-group col-md-6">
                            <label class="titulo-label">Precio</label>
                            <input type="number" step="0.01" class="form-control" name="precio-2" required value="<?php echo $datos['PRECIO_MODULO']; ?>">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="titulo-label">Duración en meses</label>
                            <input type="text" class="form-control" name="meses-2" required style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" value="<?php echo $datos['DURACION_MESES']; ?>">
                        </div>          
                        <div class="form-group col-md-6">
                            <label class="titulo-label">Duración en horas</label>
                            <input type="tect" class="form-control" name="horas-2" required style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" value="<?php echo $datos['DURACION_HORAS']; ?>">
                        </div>
                    </div>
                    <br>

                    <input type="hidden" name="codigo-editar" value="<?php echo $datos['ID_MODULO']; ?>">

                    <div class="botones">
                        <button type="submit" class="btn boton-registrar btn-success col-xs-4">Actualizar</button>
                    </div>

                    <br>

                    <div class="RespuestaAjax"></div>

                </form>
</div>
