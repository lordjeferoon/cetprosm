<?php 
    require_once 'controladores/especialidadControlador.php';
    $insEspecialidad = new especialidadControlador();

    $url = explode("/", $_GET['views']);
    $datos=$insEspecialidad->datos_especialidad_controlador($url[1]);
    $datos=$datos->fetch();
?>
<div class="contenido-main">
                <div class="titulo-formulario">
                    <h2>Actualizar <span>Especialidad</span></h2>
                </div>

                <form action="<?php echo SERVERURL;?>ajax/especialidadAjax.php" method="POST" data-form="actualizar" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
 
                    <div class="form-group">
                        <label class="titulo-label">Nombre de la Especialidad </label>
                        <input type="text" class="form-control" name="nombre1-2"  required autofocus style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" value="<?php echo $datos['NOMBRE_ESPECIALIDAD']; ?>">
                    </div>

                    <div class="form-group">
                        <label class="titulo-label">Repita el nombre de la Especialidad </label>
                        <input type="text" class="form-control" name="nombre2-2"  required style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" value="<?php echo $datos['NOMBRE_ESPECIALIDAD']; ?>">
                    </div>

                    <div class="form-row">
                         <?php 
                                if ($datos['ESTADO_ESPECIALIDAD']=="Activo") {
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
                            <input type="number" step="0.01" class="form-control" name="precio-2" value="<?php echo $datos['PRECIO_ESPECIALIDAD']; ?>">
                        </div>
                    </div>
                    <br>

                    <input type="hidden" name="codigo-editar" value="<?php echo $datos['ID_ESPECIALIDAD']; ?>">
                        
                    <div class="botones">
                        <button type="submit" class="btn boton-registrar btn-success col-xs-4">Actualizar</button>
                    </div>
                    <br>

                    <div class="RespuestaAjax"></div>
                </form>
</div>
