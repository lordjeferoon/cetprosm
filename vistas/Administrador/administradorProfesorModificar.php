<?php 
    require_once 'controladores/docenteControlador.php';
    $insDocente = new docenteControlador();

    $url = explode("/", $_GET['views']);
    $datos=$insDocente->datos_docente_controlador($url[1]);
    $datos=$datos->fetch();
?>
<div class="contenido-main">
                <div class="titulo-formulario">
                    <h2>Modificar <span>Profesor</span></h2>
                </div>

                <form action="<?php echo SERVERURL;?>ajax/docenteAjax.php" method="POST" data-form="actualizar" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
                    <fieldset>
                        <legend>Datos personales</legend>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="titulo-label">Apellidos</label>
                                <input type="text" class="form-control" name="apellidos-2" required autofocus style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" value="<?php echo $datos['APELLIDOS_DOCENTE']; ?>">
                            </div>
                            <div class="form-group col-md-6">
                                <label class="titulo-label">Nombres</label>
                                <input type="text" class="form-control" name="nombres-2" required style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" value="<?php echo $datos['NOMBRES_DOCENTE']; ?>">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label class="titulo-label">Dni</label>
                                <input type="number" class="form-control" name="dni-2" required value="<?php echo $datos['DNI_DOCENTE']; ?>">
                            </div>
                            <div class="form-group col-md-4">
                                <label class="titulo-label">Fecha de nacimiento</label>
                                <input type="date" class="form-control" name="fecha-nacimiento-2" required value="<?php echo $datos['FECHA_NACIMIENTO_DOCENTE']; ?>">
                            </div>
                              <?php 
                                if ($datos['SEXO_DOCENTE']=="M") {
                                    echo '<div class="form-group col-md-4">
                                            <label class="titulo-label">Sexo</label>                            
                                            <select  class="form-control" name="sexo-2">
                                                <option value="M" selected>MASCULINO</option>
                                                <option value="F">FEMENINO</option>
                                            </select> 
                                            </div>';
                                }
                                else{
                                    echo '<div class="form-group col-md-4">
                                            <label class="titulo-label">Sexo</label>                            
                                            <select  class="form-control" name="sexo-2">
                                                <option value="M">MASCULINO</option>
                                                <option value="F" selected>FEMENINO</option>
                                            </select> 
                                            </div>';
                                }
                            ?>
                        </div>
                    </fieldset>
                    <br>
                    <br>


                    <fieldset>
                        <legend>Datos Adicionales y de contacto</legend>
                        <div class="form-row">
                            <!--<?php

                                //require_once 'core/mainModel.php';
                                $cod = $datos['CODIGO_CUENTA_DOCENTE'];
                                $mysqli = new mysqli(SERVER,USER,PASS,DB);
                                $query = $mysqli -> query ("SELECT * FROM cuentas WHERE CODIGO='$cod'");
                                $cuenta=mysqli_fetch_array($query); 
                                if ($cuenta['ESTADO']=="Activo") {
                                    echo '<div class="form-group col-md-3">
                                            <label class="titulo-label">Estado</label>
                                            <select  class="form-control" name="estado-2">
                                                <option value="Activo" selected>ACTIVO</option>
                                                <option value="Inactivo">INACTIVO</option>
                                            </select>
                                        </div> ';
                                }
                                else{
                                    echo '<div class="form-group col-md-3">
                                            <label class="titulo-label">Estado</label>
                                            <select  class="form-control" name="estado-2">
                                                <option value="Activo">ACTIVO</option>
                                                <option value="Inactivo" selected>INACTIVO</option>
                                            </select>
                                        </div> ';
                                }
                            ?>-->                
                            <div class="form-group col-md-4">
                                <label class="titulo-label">Teléfono</label>
                                <input type="number" class="form-control" name="numero-2" required value="<?php echo $datos['TELEFONO_DOCENTE']; ?>">
                            </div>
                            <div class="form-group col-md-8">
                                <label class="titulo-label">Correo electrónico</label>                            
                                <input type="email" class="form-control" name="email-2" required value="<?php echo $datos['CORREO_DOCENTE']; ?>">
                            </div>
                        </div>
                    </fieldset>
                    <br>
                    <br>

                     <input type="hidden" name="codigo-editar" value="<?php echo $cuenta['CODIGO']; ?>">
                    
                    <fieldset >
                        <legend>Datos domiciliarios</legend>
                        <div class="form-group">
                            <label class="titulo-label">Dirección</label>
                            <input type="text" class="form-control" name="direccion-2" required style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" value="<?php echo $datos['DIRECCION_DOCENTE']; ?>">                       
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label class="titulo-label">Distrito</label>                            
                                <input type="text" class="form-control" name="distrito-2" required style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" value="<?php echo $datos['DISTRITO_DOCENTE']; ?>">
                            </div>
                            <div class="form-group col-md-8">
                                <label class="titulo-label">Referencia</label>                            
                                <input type="text" class="form-control" name="referencia-2" required style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" value="<?php echo $datos['REFERENCIA_DOCENTE']; ?>">
                            </div>
                        </div>
                    </fieldset>
                    <br>
                    <br>

                    <fieldset >
                        <legend>Datos de la cuenta</legend>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label class="titulo-label">Estado</label>                            
                                <input type="text" class="form-control" name="estado-2" required style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" readonly="" value="<?php echo $cuenta['ESTADO']; ?>">
                            </div>
                            <div class="form-group col-md-4">
                                <label class="titulo-label">Usuario</label>                            
                                <input type="text" class="form-control" name="usuario-2" required readonly="" value="<?php echo $cuenta['USUARIO']; ?>">
                            </div>
                            <div class="form-group col-md-4">
                                <label class="titulo-label">Contraseña</label>                       
                                <input type="text" class="form-control" name="contraseña-2" required readonly value="<?php echo $lc->decryption($cuenta['CONTRASENA']); ?>">
                            </div>
                        </div>
                    </fieldset>
                    <br>
                    <br>

                    <div class="botones">
                        <button type="submit" class="btn boton-registrar btn-success col-xs-4">Actualizar</button>
                    </div>
                    <br>

                    <div class="RespuestaAjax"></div>
                    
                </form>
</div>
