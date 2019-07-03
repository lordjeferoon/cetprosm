<?php 
    require_once 'controladores/docenteControlador.php';
    $insDocente = new DocenteControlador();

    $codigo=$lc->encryption($_SESSION['codigo_cuenta_csm']);
    $datos=$insDocente->datos_docente_controlador($codigo);
    $datos=$datos->fetch();

    $cod = $datos['CODIGO_CUENTA_DOCENTE'];
    $mysqli = new mysqli(SERVER,USER,PASS,DB);
    $query = $mysqli -> query ("SELECT * FROM cuentas WHERE CODIGO='$cod'");
    $cuenta =mysqli_fetch_array($query); 
?>

<div class="contenido-main">
                <div class="titulo-formulario">
                    <h2>Mi <span>Perfil</span></h2>
                </div>
                    
                <form>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <br>
                                <fieldset>
                                    <legend>DATOS PERSONALES</legend>
                                    <table class="table table-hover table-sm">
                                        <tr>
                                            <td width="50%">USUARIO: </td><td><?php echo $cuenta['USUARIO']; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%">APELLIDOS: </td><td><?php echo $datos['APELLIDOS_DOCENTE']; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%">NOMBRES: </td><td> <?php echo $datos['NOMBRES_DOCENTE']; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%">DNI: </td><td><?php echo $datos['DNI_DOCENTE']; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%">FECHA NACIMIENTO: </td><td><?php echo $datos['FECHA_NACIMIENTO_DOCENTE']; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%">SEXO: </td><td><?php if($datos['SEXO_DOCENTE']=="M"){ echo "MASCULINO";}else{ echo "FEMENINO";} ?></td>
                                        </tr>
                                    </table>
                                </fieldset>
                            </div>
                            <div class="form-group col-md-2">
                                
                            </div>
                            <div class="form-group col-md-4 align-self-end">
                                <img src="<?php echo SERVERURL; ?>vistas/img/<?php echo $_SESSION['foto_csm']; ?>" alt="Foto de usuario" style="width: 250px;">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-7">
                                <fieldset>
                                    <legend>DATOS DOMICILIARIOS</legend>
                                    <table class="table table-hover table-sm">                       
                                        <tr>
                                            <td width="43%">DIRECCIÓN: </td><td> <?php echo $datos['DIRECCION_DOCENTE']; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="43%">DISTRITO: </td><td><?php echo $datos['DISTRITO_DOCENTE']; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="43%">REFERENCIA: </td><td><?php echo $datos['REFERENCIA_DOCENTE']; ?></td>
                                        </tr>
                                    </table>
                                </fieldset>
                            </div>
                            <div class="form-group col-md-1">
                                
                            </div>
                            <div class="form-group col-md-4">
                                <fieldset>
                                    <legend>DATOS DE CONTACTO</legend>
                                        <table class="table table-hover table-sm">
                                            <tr>
                                                <td width="40%">TELÉFONO: </td><td><?php echo $datos['TELEFONO_DOCENTE']; ?></td>
                                            </tr>
                                            <tr>
                                                <td width="40%">CORREO: </td><td><?php echo $datos['CORREO_DOCENTE']; ?></td>
                                            </tr>
                                        </table>
                                        <a href="docenteDocenteModificar/<?php echo $lc->encryption($cod); ?>/" class="btn boton-registrar btn-success w-100">Editar Información
                                        </a>
                                </fieldset>
                            </div>
                        </div>


                        <input type="hidden" name="codigo-editar" value="<?php echo $cuenta['CODIGO']; ?>">

                        <!--<div class="form-row">
                            <br>
                            <?php 
                                //if($_SESSION['privilegio_csm']==1):
                            ?>

                            <div class="form-check-inline col-md-4">
                                <label class="form-check-label titulo-label" for="radio1">
                                <?php 
                                    //if($cuenta['PRIVILEGIO']==1){
                                       // echo '';
                                    //}
                                ?>
                                <input type="radio" class="form-check-input" id="radio1" name="optradio-2" value="<?php //echo $lc->encryption(1); ?>">Acceso Total
                                </label>
                            </div>


                            <?php 
                                //endif;
                                //if($_SESSION['privilegio_csm']<=2):
                            ?>
                            <div class="form-check-inline col-md-4">
                                <label class="form-check-label titulo-label" for="radio2">
                                <input type="radio" class="form-check-input" id="radio2" name="optradio-2" value="<?php //echo $lc->encryption(2); ?>">Sólo Registro Y Actualización
                                </label>
                            </div>

                            <?php 
                                //endif;
                            ?>

                            <div class="form-check-inline col-md-3">
                                <label class="form-check-label titulo-label" for="radio3">
                                <input type="radio" class="form-check-input" id="radio3" name="optradio-2" value="<?php //echo $lc->encryption(3); ?>">Sólo Registro
                                </label>
                            </div>

                        </div>-->
                </form>
</div>