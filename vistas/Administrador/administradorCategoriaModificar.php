<?php 
    require_once 'controladores/categoriaControlador.php';
    $insCategoria = new categoriaControlador();

    $url = explode("/", $_GET['views']);
    $datos=$insCategoria->datos_categoria_controlador($url[1]);
    $datos=$datos->fetch();
?>
<div class="contenido-main">
                <div class="titulo-formulario">
                    <h2>Actualizar <span>Categoría</span></h2>
                </div>

                <form action="<?php echo SERVERURL;?>ajax/categoriaAjax.php" method="POST" data-form="actualizar" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
 
                    <div class="form-group">
                        <label class="titulo-label">Nombre de la Categoría </label>
                        <input type="text" class="form-control" name="nombre1-2"  required autofocus style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" value="<?php echo $datos['NOMBRE_CATEGORIA']; ?>">
                    </div>

                    <div class="form-group">
                        <label class="titulo-label">Repita el nombre de la Categoría </label>
                        <input type="text" class="form-control" name="nombre2-2"  required style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" value="<?php echo $datos['NOMBRE_CATEGORIA']; ?>">
                    </div>

                    <?php 
                        if ($datos['ESTADO_CATEGORIA']=="Activo") {
                            echo    '<div class="form-group">
                                        <label class="titulo-label">Estado</label>                            
                                        <select  class="form-control" name="estado-2">
                                            <option value="Activo" selected>ACTIVO</option>
                                            <option value="Inactivo">INACTIVO</option>
                                        </select> 
                                    </div>';
                        }
                        else{
                            echo    '<div class="form-group">
                                        <label class="titulo-label">estado</label>                            
                                        <select  class="form-control" name="estado-2">
                                            <option value="Activo">ACTIVO</option>
                                            <option value="Inactivo" selected>INACTIVO</option>
                                        </select> 
                                    </div>';
                        }
                    ?>
                    <br>          
                    <input type="hidden" name="codigo-editar" value="<?php echo $datos['ID_CATEGORIA']; ?>">
                    <div class="botones">
                        <button type="submit" class="btn boton-registrar btn-success col-xs-4">Actualizar</button>
                    </div>
                    <br>

                    <div class="RespuestaAjax"></div>
                </form>
</div>
