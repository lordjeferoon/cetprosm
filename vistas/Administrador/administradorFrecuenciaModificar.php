<?php 
    require_once 'controladores/frecuenciaControlador.php';
    $insFrecuencia = new frecuenciaControlador();

    $url = explode("/", $_GET['views']);
    $datos=$insFrecuencia->datos_frecuencia_controlador($url[1]);
    $datos=$datos->fetch();
?>
<div class="contenido-main">
                <div class="titulo-formulario">
                    <h2>Actualizar <span>Frecuencia</span></h2>
                </div>

                <form name="f1" action="<?php echo SERVERURL;?>ajax/frecuenciaAjax.php" method="POST" data-form="actualizar" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
 
                    <div class="form-group">
                        <label class="titulo-label">Escriba la Frecuencia</label>
                        <input type="text" class="form-control" name="nombre1-2"  required autofocus style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" value="<?php echo $datos['NOMBRE_FRECUENCIA']; ?>">
                    </div>

                    <div class="form-group">
                        <label class="titulo-label">Repita la Frecuencia</label>
                        <input type="text" class="form-control" name="nombre2-2"  required style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" value="<?php echo $datos['NOMBRE_FRECUENCIA']; ?>">
                    </div>

                    <?php 
                                if ($datos['ESTADO_FRECUENCIA']=="Activo") {
                                    echo '<div class="form-group">
                                            <label class="titulo-label">Estado</label>                            
                                            <select  class="form-control" name="estado-2">
                                                <option value="Activo" selected>ACTIVO</option>
                                                <option value="Inactivo">INACTIVO</option>
                                            </select> 
                                            </div>';
                                }
                                else{
                                    echo '<div class="form-group">
                                            <label class="titulo-label">Estado</label>                            
                                            <select  class="form-control" name="estado-2">
                                                <option value="Activo">ACTIVO</option>
                                                <option value="Inactivo" selected>INACTIVO</option>
                                            </select> 
                                            </div>';
                                }
                    ?>

                    <input type="hidden" name="codigo-editar" value="<?php echo $datos['ID_FRECUENCIA']; ?>">       
                    <br>
                        
                    <div class="botones">
                        <button type="submit" class="btn boton-registrar btn-success col-xs-4">Actualizar</button>
                    </div>
                    <br>

                    <div class="RespuestaAjax"></div>

                </form>
</div>
