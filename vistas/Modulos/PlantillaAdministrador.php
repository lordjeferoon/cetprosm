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
                            <span>Administración</span>
                        </li>
                        <!--<li>
                            <a href="<?php //echo SERVERURL; ?>administradorIndex">
                                <i class="far fa-check-circle"></i>
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
                                        <a href="<?php echo SERVERURL; ?>administradorPerfil">Mi perfil </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo SERVERURL; ?>administradorAdminActualizarContrasena">Actualizar Contraseña</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="sidebar-dropdown">
                            <a href="#">
                                <i class="fa fa-graduation-cap"></i>
                                <span>Administradores</span>
                                <!-- <span class="badge badge-pill badge-danger">New </span> -->
                            </a>
                            <div class="sidebar-submenu">
                                <ul>
                                    <li>
                                        <a href="<?php echo SERVERURL; ?>administradorAdminRegistrar">Agregar</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo SERVERURL; ?>administradorAdminTodos/1">Listar a Todos</a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="sidebar-dropdown">
                            <a href="#">
                                <i class="fa fa-user-graduate"></i>
                                <span>Alumnos</span>
                                <!-- <span class="badge badge-pill badge-danger">New </span> -->
                            </a>
                            <div class="sidebar-submenu">
                                <ul>
                                    <li>
                                        <a href="<?php echo SERVERURL; ?>administradorAlumnoRegistrar">Agregar <!--<span class="badge badge-pill badge-success">Pro</span>--></a>
                                    </li>
                                    <li>
                                        <a href="<?php echo SERVERURL; ?>administradorAlumnoTodos/1">Listar a Todos</a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="sidebar-dropdown">
                            <a href="#">
                                <i class="fas fa-chalkboard-teacher"></i>
                                <span>Profesores</span>
                                <!--<span class="badge badge-pill badge-primary">3</span>-->
                            </a>
                            <div class="sidebar-submenu">
                                <ul>
                                    <li>
                                        <a href="<?php echo SERVERURL; ?>administradorProfesorRegistrar">Agregar</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo SERVERURL; ?>administradorProfesorTodos/1">Listar a Todos</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="sidebar-dropdown">
                            <a href="#">
                                <i class="fa fa-book"></i>
                                <span>Especialidades</span>
                            </a>
                            <div class="sidebar-submenu">
                                <ul>
                                    <li>
                                        <a href="<?php echo SERVERURL; ?>administradorEspecialidadRegistrar">Agregar</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo SERVERURL; ?>administradorEspecialidadTodos/1">Listar a Todos</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="sidebar-dropdown">
                            <a href="#">
                                <i class="fa fa-book"></i>
                                <span>Módulos</span>
                            </a>
                            <div class="sidebar-submenu">
                                <ul>
                                    <li>
                                        <a href="<?php echo SERVERURL; ?>administradorModuloRegistrar">Agregar</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo SERVERURL; ?>administradorModuloTodos/1">Listar a Todos</a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="sidebar-dropdown">
                            <a href="#">
                                <i class="fa fa-calendar-alt"></i>
                                <span>Frecuencias</span>
                            </a>
                            <div class="sidebar-submenu">
                                <ul>
                                    <li>
                                        <a href="<?php echo SERVERURL; ?>administradorFrecuenciaRegistrar">Agregar</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo SERVERURL; ?>administradorFrecuenciaTodos/1">Listar a Todos</a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="sidebar-dropdown">
                            <a href="#">
                                <i class="fab fa-cuttlefish"></i>
                                <span>Categorías</span>
                            </a>
                            <div class="sidebar-submenu">
                                <ul>
                                    <li>
                                        <a href="<?php echo SERVERURL; ?>administradorCategoriaRegistrar">Agregar</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo SERVERURL; ?>administradorCategoriaTodos/1">Listar a Todos</a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="sidebar-dropdown">
                            <a href="#">
                                <i class="fab fa-product-hunt"></i>
                                <span>Productos</span>
                            </a>
                            <div class="sidebar-submenu">
                                <ul>
                                    <li>
                                        <a href="<?php echo SERVERURL; ?>administradorProductoRegistrar">Agregar</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo SERVERURL; ?>administradorProductoTodos/1">Listar a Todos</a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="header-menu">
                            <span>Operaciones</span>
                        </li>

                        <li class="sidebar-dropdown">
                            <a href="#">
                                <i class="far fa-list-alt"></i>
                                <span>Matrículas</span>
                                <!-- <span class="badge badge-pill badge-danger">New </span> -->
                            </a>
                            <div class="sidebar-submenu">
                                <ul>
                                    <li>
                                        <a href="<?php echo SERVERURL; ?>administradorMatricular">Matricular <!--<span class="badge badge-pill badge-success">Pro</span>--></a>
                                    </li>
                                    <li>
                                        <a href="<?php echo SERVERURL; ?>administradorMatriculaBuscar">Buscar Matrícula</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <a href="<?php echo SERVERURL; ?>administradorAsignar">
                                <i class="fas fa-file-contract"></i>
                                <span>Asignar Docente</span>
                            </a>
                        </li>
                        <li class="sidebar-dropdown">
                            <a href="#">
                                <i class="fas fa-shopping-cart"></i>
                                <span>Ventas</span>
                                <!-- <span class="badge badge-pill badge-danger">New </span> -->
                            </a>
                            <div class="sidebar-submenu">
                                <ul>
                                    <li>
                                        <a href="<?php echo SERVERURL; ?>administradorVender">Realizar Venta <!--<span class="badge badge-pill badge-success">Pro</span>--></a>
                                    </li>
                                    <li>
                                        <a href="<?php echo SERVERURL; ?>administradorVentaBuscar">Buscar Boleta</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="sidebar-dropdown">
                            <a href="#">
                                <i class="fas fa-chart-pie"></i>
                                <span>Generar Reporte</span>
                            </a>
                            <div class="sidebar-submenu">
                                <ul>
                                    <li>
                                        <a href="<?php echo SERVERURL; ?>administradorReporteAlumnosEspecialidad">Alumnos por especialidad</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo SERVERURL; ?>administradorReporteAlumnosMatriculados">Alumnos por módulo</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo SERVERURL; ?>administradorReporteIngresoMatriculas">Ingresos por matriculas</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo SERVERURL; ?>administradorReporteIngresoVentas">Ingresos por ventas</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo SERVERURL; ?>administradorReporteMatriculasNoCanceladas">Matriculas no canceladas</a>
                                    </li>
                                    <!--<li>
                                        <a href="<?php echo SERVERURL; ?>administradorReporteCargaDocente/1">Carga docente</a>
                                    </li>-->
                                </ul>
                            </div>
                        </li>
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