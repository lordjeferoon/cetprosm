<?php 
    require_once 'controladores/administradorControlador.php';
    $insAdmin = new administradorControlador();

    $codigo=$lc->encryption($_SESSION['codigo_cuenta_csm']);
    $datos=$insAdmin->datos_administrador_controlador($codigo);
    $datos=$datos->fetch();

    $cod = $datos['CODIGO_CUENTA_ADMIN'];
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
                                            <td width="50%">APELLIDOS: </td><td><?php echo $datos['APELLIDOS_ADMIN']; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%">NOMBRES: </td><td> <?php echo $datos['NOMBRES_ADMIN']; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%">DNI: </td><td><?php echo $datos['DNI_ADMIN']; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%">FECHA NACIMIENTO: </td><td><?php echo $datos['FECHA_NACIMIENTO_ADMIN']; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%">SEXO: </td><td><?php if($datos['SEXO_ADMIN']=="M"){ echo "MASCULINO";}else{ echo "FEMENINO";} ?></td>
                                        </tr>
                                    </table>
                                </fieldset>
                            </div>
                            <div class="form-group col-md-2">
                                
                            </div>
                            <div class="form-group col-md-4 text-center">
                                <img src="<?php echo SERVERURL; ?>vistas/img/<?php echo $_SESSION['foto_csm']; ?>" alt="Foto de usuario" style="width: 270px;">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-7">
                                <fieldset>
                                    <legend>DATOS DOMICILIARIOS</legend>
                                    <table class="table table-hover table-sm">                       
                                        <tr>
                                            <td width="43%">DIRECCIÓN: </td><td> <?php echo $datos['DIRECCION_ADMIN']; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="43%">DISTRITO: </td><td><?php echo $datos['DISTRITO_ADMIN']; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="43%">REFERENCIA: </td><td><?php echo $datos['REFERENCIA_ADMIN']; ?></td>
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
                                                <td width="40%">TELÉFONO: </td><td><?php echo $datos['TELEFONO_ADMIN']; ?></td>
                                            </tr>
                                            <tr>
                                                <td width="40%">CORREO: </td><td><?php echo $datos['CORREO_ADMIN']; ?></td>
                                            </tr>
                                        </table>
                                        <a href="<?php echo SERVERURL;?>administradorAdminModificar/<?php echo $lc->encryption($_SESSION['codigo_cuenta_csm']); ?>/" class="btn boton-registrar btn-success w-100">Editar Información
                                        </a>
                                </fieldset>
                            </div>
                        </div>


                        <input type="hidden" name="codigo-editar" value="<?php echo $cuenta['CODIGO']; ?>">

                </form>
</div>