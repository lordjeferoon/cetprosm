<?php 
    require_once 'controladores/alumnoControlador.php';
    $insAlumno = new alumnoControlador();

    $url = explode("/", $_GET['views']);
    $datos=$insAlumno->datos_alumno_controlador($url[1]);
    $datos=$datos->fetch();
?>
<div class="contenido-main">
                <div class="titulo-formulario">
                    <h2>Actualizar <span>Alumno</span></h2>
                </div>

                <form action="<?php echo SERVERURL;?>ajax/alumnoAjax.php" method="POST" data-form="actualizar" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
                    <fieldset>
                        <legend>Códigos de Nómina</legend>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="titulo-label">Código Básico</label>
                                <input type="text" class="form-control" name="nomina12" value="<?php echo $datos['CODIGO_NOMINAB']; ?>" autofocus style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                            </div>
                            <div class="form-group col-md-6">
                                <label class="titulo-label">Código Medio</label>
                                <input type="text" class="form-control" name="nomina22" value="<?php echo $datos['CODIGO_NOMINAI']; ?>" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                            </div>
                        </div>
                    </fieldset>
                    <br><br>
                    
                    <fieldset>
                        <legend>Datos personales</legend>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="titulo-label">Apellidos</label>
                                <input type="text" class="form-control" name="apellidos-2" required style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" value="<?php echo $datos['APELLIDOS_ALUMNO']; ?>">
                            </div>
                            <div class="form-group col-md-6">
                                <label class="titulo-label">Nombres</label>
                                <input type="text" class="form-control" name="nombres-2" required style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" value="<?php echo $datos['NOMBRES_ALUMNO']; ?>">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label class="titulo-label">Dni</label>
                                <input type="number" class="form-control" name="dni-2" required value="<?php echo $datos['DNI_ALUMNO']; ?>">
                            </div>
                            <div class="form-group col-md-3">
                                <label class="titulo-label">Fecha de nacimiento</label>
                                <input type="date" class="form-control" name="fecha-nacimiento-2" required value="<?php echo $datos['FECHA_NACIMIENTO_ALUMNO']; ?>">
                            </div>
                            <?php 
                                if ($datos['SEXO_ALUMNO']=="M") {
                                    echo '<div class="form-group col-md-3">
                                            <label class="titulo-label">Sexo</label>                            
                                            <select  class="form-control" name="sexo-2">
                                                <option value="M" selected>MASCULINO</option>
                                                <option value="F">FEMENINO</option>
                                            </select> 
                                            </div>';
                                }
                                else{
                                    echo '<div class="form-group col-md-3">
                                            <label class="titulo-label">Sexo</label>                            
                                            <select  class="form-control" name="sexo-2">
                                                <option value="M">MASCULINO</option>
                                                <option value="F" selected>FEMENINO</option>
                                            </select> 
                                            </div>';
                                }
                            ?>
                            <?php 
                                if ($datos['CONDICION_ALUMNO']=="G") {
                                    echo '<div class="form-group col-md-3">
                                            <label class="titulo-label">Cóndicion</label>                            
                                            <select  class="form-control" name="condicion-2">
                                                <option value="G" selected>GRATUITO</option>
                                                <option value="P">PAGANTE</option>
                                                <option value="B">BECARIO</option>
                                            </select> 
                                            </div>';
                                }
                                elseif($datos['CONDICION_ALUMNO']=="P"){
                                    echo '<div class="form-group col-md-3">
                                            <label class="titulo-label">Cóndicion</label>                            
                                            <select  class="form-control" name="condicion-2">
                                                <option value="G">GRATUITO</option>
                                                <option value="P" selected>PAGANTE</option>
                                                <option value="B">BECARIO</option>
                                            </select> 
                                        </div>';
                                }
                                else{
                                    echo '<div class="form-group col-md-3">
                                            <label class="titulo-label">Cóndicion</label>                            
                                            <select  class="form-control" name="condicion-2">
                                                <option value="G">GRATUITO</option>
                                                <option value="P">PAGANTE</option>
                                                <option value="B" selected>BECARIO</option>
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
                
                            <div class="form-group col-md-4">
                                <label class="titulo-label">Teléfono</label>
                                <input type="number" class="form-control" name="numero-2" placeholder="Ej. 99999999" required value="<?php echo $datos['TELEFONO_ALUMNO']; ?>">
                            </div>
                            <div class="form-group col-md-8">
                                <label class="titulo-label">Correo electrónico</label>                            
                                <input type="email" class="form-control" name="email-2" placeholder="Ej. nombre@dominio.com" value="<?php echo $datos['CORREO_ALUMNO']; ?>">
                            </div>
                        </div>
                    </fieldset>
                    <br>
                    <br>
                    
                    <fieldset >
                        <legend>Datos domiciliarios</legend>
                        <div class="form-group">
                            <label class="titulo-label">Dirección</label>
                            <input type="text" class="form-control" name="direccion-2" required style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" value="<?php echo $datos['DIRECCION_ALUMNO']; ?>">                        
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label class="titulo-label">Distrito</label>                            
                                <input type="text" class="form-control" name="distrito-2" required style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" value="<?php echo $datos['DISTRITO_ALUMNO']; ?>">
                            </div>
                            <div class="form-group col-md-8">
                                <label class="titulo-label">Referencias</label>                            
                                <input type="text" class="form-control" name="referencia-2" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" value="<?php echo $datos['REFERENCIA_ALUMNO']; ?>">
                            </div>
                        </div>
                    </fieldset>
                     <input type="hidden" name="codigo-editar" value="<?php echo $datos['CODIGO_CUENTA_ALUMNO']; ?>">

                     <br>
                     <br>

                    <div class="botones">
                        <button type="submit" class="btn boton-registrar btn-success col-xs-4">Actualizar</button>
                       
                    </div>
                    <br>

                    <div class="RespuestaAjax"></div>
                    
                </form>
</div>