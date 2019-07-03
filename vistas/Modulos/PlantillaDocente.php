<a id="show-sidebar" class="btn btn-sm btn-dark" href="#">
            <i class="fas fa-bars"></i>
        </a>

        <nav id="sidebar" class="sidebar-wrapper" style="background-color: #163590">
            <div class="sidebar-content">

                <div class="sidebar-brand">
                    <a href="#"></a>
                    <div id="close-sidebar">
                        <i class="fas fa-times float-left"></i>
                    </div>
                </div>

                <div class="sidebar-header">
                    <div class="user-pic">
                        <img class="img-responsive img-rounded" src="<?php echo SERVERURL; ?>vistas/img/<?php echo $_SESSION['foto_csm']; ?>" alt="User picture">
                    </div>
                    <div class="user-info">
                        <span class="user-name"><?php echo $_SESSION['nombre_csm']; ?>
                            <strong><?php echo $_SESSION['apellido_csm']; ?></strong>
                        </span>
                        <span class="user-role"><?php echo $_SESSION['tipo_csm']; ?></span>
                        <span class="user-status">
                            <i class="fa fa-circle"></i>
                            <span>En línea</span>
                        </span>
                    </div>
                </div>
                <!-- sidebar-header  -->


                <div class="sidebar-menu">
                    <ul>
                        <li class="header-menu">
                            <span>General</span>
                        </li>
                        <!--<li>
                            <a href="profesor_index.php">
                                <i class="fa fa-folder"></i>
                                <span>Inicio</span>
                            </a>
                        </li>-->
                        <li class="sidebar-dropdown">
                            <a href="#">
                                <i class="fa fa-user"></i>
                                <span>Perfil de Usuario</span>
                            </a>
                            <div class="sidebar-submenu">
                                <ul>
                                    <li>
                                        <a href="<?php echo SERVERURL; ?>docentePerfil">Mi perfil </a>
                                    </li>                                  
                                    <li>
                                        <a href="<?php echo SERVERURL; ?>docenteActualizarContrasena">Actualizar Contraseña</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <a href="<?php echo SERVERURL; ?>docenteMisCursos/">
                                <i class="fa fa-user"></i></i>
                                <span>Mis Cursos</span>
                            </a>
                        </li>
                        <li class="header-menu">
                            <span>Operaciones</span>
                        </li>
                        <li>
                            <a href="<?php echo SERVERURL; ?>docenteSeleccionarAsistencia/">
                                <i class="fa fa-folder"></i>
                                <span>Registrar Asistencia</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo SERVERURL; ?>docenteSeleccionarNota/">
                                <i class="fa fa-folder"></i>
                                <span>Registrar Notas</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo SERVERURL; ?>docenteSeleccionarNomina/">
                                <i class="fa fa-folder"></i>
                                <span>Descargar Nómina</span>
                            </a>
                        </li>
                        <!--<li class="sidebar-dropdown">
                            <a href="#">
                                <i class="fas fa-chart-pie"></i>
                                <span>Generar Reportes</span>
                            </a>
                            <div class="sidebar-submenu">
                                <ul>
                                    <li>
                                        <a href="profesor_reporte_matricula.php">Reporte de Asistencias</a>
                                    </li>
                                    <li>
                                        <a href="profesor_reporte_evaluaciones.php">Reporte de Evaluaciones</a>
                                    </li>
                                </ul>
                            </div>
                        </li>-->
                        <li>
                            <a href="<?php echo SERVERURL; ?>logout">
                                <i class="fas fa-sign-out-alt"></i>
                                <span>Cerrar Sesión</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- sidebar-menu  -->
            </div>
            <!-- sidebar-content  -->            
        </nav>
        <!-- sidebar-wrapper -->