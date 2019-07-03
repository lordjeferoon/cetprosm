<?php 
    require_once 'controladores/administradorControlador.php';
    $insAdmin = new administradorControlador();

    $datos=$insAdmin->datos_administrador_controlador($lc->encryption($_SESSION['codigo_cuenta_csm']));
    $datos=$datos->fetch();
?>

<div class="contenido-main">
                <div class="titulo-formulario">
                    <h2>Actualizar <span>Contraseña</span></h2>
                </div>

                <br><br>

                <form action="<?php echo SERVERURL;?>ajax/administradorAjax.php" method="POST" data-form="actualizar" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
                    
                        <div class="form-row">
                            <!--<div class="form-group col-md-4">
                                
                            </div>-->
                            <div class="form-group col-md-4">
                                <label class="titulo-label">Usuario</label>                            
                                <input type="text" class="form-control" name="usuario-3" required style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" readonly="" value="<?php echo $_SESSION['usuario_csm']; ?>">
                            </div>

                            <div class="form-group col-md-4">
                                <label class="titulo-label">Nueva Contraseña</label>                            
                                <input type="password" class="form-control" name="contraseña1-21" required>
                            </div>
                            
                            <div class="form-group col-md-4">
                                <label class="titulo-label">Repita la Contraseña</label>                       
                                <input type="password" class="form-control" name="contraseña2-21" required">
                            </div>
                        </div>

                        <input type="hidden" name="codigo-editar" value="<?php echo $_SESSION['codigo_cuenta_csm']; ?>">

                        
                    
                    <br>
                    <br>

                    <div class="botones">
                        <button type="submit" class="btn boton-registrar btn-success col-xs-4">Actualizar</button>
                    </div>
                    <br>

                    <div class="RespuestaAjax"></div>
                    
                </form>
</div>