<div class="contenido-main">
                <div class="titulo-formulario">
                    <h2>Listado de <span>Profesores</span></h2>
                </div>

                <form action="<?php echo SERVERURL;?>administradorProfesorTodosPDF" method="post" target="_blank">
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <!--<label class="titulo-label">Seleccione un filtro:</label>
                            <select  class="form-control" name="filtro">
                                <option value="todos" selected>Todos</option>
                                <option value="activos">Activos</option>
                                <option value="inactivos">Inactivos</option>
                            </select>-->
                        </div>
                        <div class="form-group col-md-6">

                        </div>
                        <div class="form-group col-md-3">
                            <br>
                            <input type="hidden" name="reporte_name" value="Reporte de Docentes">
                            <button type="submit" name="create_pdf" class="btn boton-registrar btn-success w-100">Exportar a PDF</button>
                        </div>
                    </div>
                </form>
                    <br>
                    <?php 
                        require_once 'controladores/docenteControlador.php';
                        $ins = new docenteControlador();
                    ?>

                    <?php  
                        $pagina = explode("/", $_GET['views']);
                        echo $ins->paginador_docente_controlador($pagina[1],10,$_SESSION["privilegio_csm"],$_SESSION["codigo_cuenta_csm"]);
                    ?>

                </form>
</div>