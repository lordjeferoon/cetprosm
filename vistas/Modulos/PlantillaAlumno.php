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
                        <img class="img-responsive img-rounded" src="<?php echo SERVERURL; ?>vistas/img/user.jpg" alt="User picture">
                    </div>
                    <div class="user-info">
                        <span class="user-name">Jorgito
                            <strong>Cárdenaz</strong>
                        </span>
                        <span class="user-role">Alumno</span>
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
                            <span>Panel General</span>
                        </li>
                        <li>
                            <a href="alumno_index.php">
                                <i class="fa fa-folder"></i>
                                <span>Inicio</span>
                            </a>
                        </li>
                        <li>
                            <a href="alumno_informacion.php">
                                <i class="fa fa-folder"></i>
                                <span>Mi información</span>
                            </a>
                        </li>

                        <li class="header-menu">
                            <span>Operaciones</span>
                        </li>
                        <li>
                            <a href="alumno_modificar_contraseña.php">
                                <i class="fa fa-folder"></i>
                                <span>Cambiar contraseña</span>
                            </a>
                        </li>
                        <li class="sidebar-dropdown">
                            <a href="#">
                                <i class="fa fa-folder"></i>
                                <span>Generar Reportes</span>
                            </a>
                            <div class="sidebar-submenu">
                                <ul>
                                    <li>
                                        <a href="alumno_reporte_matricula.php">Reporte de Matrícula</a>
                                    </li>
                                    <li>
                                        <a href="alumno_reporte_notas.php">Reporte de Evaluaciones</a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                    </ul>
                </div>
                <!-- sidebar-menu  -->
            </div>
            <!-- sidebar-content  -->            
        </nav>
        <!-- sidebar-wrapper -->