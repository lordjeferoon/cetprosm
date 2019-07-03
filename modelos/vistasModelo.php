<?php 
	class vistasModelo{

		protected function obtener_vistas_modelo($vistas){
			$listaBlanca = [
				"administradorAlumnoBuscar",
				"administradorAlumnoEliminar",
				"administradorAlumnoModificar",
				"administradorAlumnoRegistrar",
				"administradorAlumnoTodos",
				"administradorAsignar",
				"administradorAdminRegistrar",
				"administradorAdminModificar",
				"administradorAdminTodos",
				"administradorPerfil",
				"administradorAdminActualizarContrasena",
				"administradorEspecialidadEliminar",
				"administradorEspecialidadModificar",
				"administradorEspecialidadRegistrar",
				"administradorEspecialidadTodos",
				"administradorIndex",
				"administradorMatricular",
				"administradorMatriculaReporte",
				"administradorMatriculaBuscar",
				"administradorModuloBuscar",
				"administradorModuloEliminar",
				"administradorModuloModificar",
				"administradorModuloRegistrar",
				"administradorModuloTodos",
				"administradorProfesorBuscar",
				"administradorProfesorEliminar",
				"administradorProfesorModificar",
				"administradorProfesorRegistrar",
				"administradorProfesorTodos",
				"administradorFrecuenciaRegistrar",
				"administradorFrecuenciaModificar",
				"administradorFrecuenciaTodos",
				"administradorCategoriaRegistrar",
				"administradorCategoriaModificar",
				"administradorCategoriaTodos",
				"administradorProductoRegistrar",
				"administradorProductoModificar",
				"administradorProductoTodos",
				"administradorVender",
				"administradorVentaBuscar",
				"administradorVentaReporte",
				"administradorReporteIngresoVentas",
				"administradorReporteIngresoMatriculas",
				"administradorReporteMatriculasNoCanceladas",
				"administradorReporteCargaDocente",
				"administradorReporteAlumnosMatriculados",
				"administradorReporteAlumnosEspecialidad",
				"administradorReporteBuscarAlumnos",
				"docentePerfil",
				"docenteMisCursos",
				"docenteSeleccionarAsistencia",
				"docenteRegistrarAsistencia",
				"docenteSeleccionarNota",
				"docenteRegistrarNota",
				"docenteSeleccionarNomina",
				"docenteReporteAlumnosMatriculados",
				"docenteReporteAlumnosMatriculadosAsistencias",
				"docenteReporteAlumnosMatriculadosNotas",
				"docenteDocenteModificar",
				"docenteActualizarContrasena",
				"logout"
			];

			if(in_array($vistas,$listaBlanca)){
				if(is_file("vistas/Administrador/".$vistas.".php")){
					$contenido = "vistas/Administrador/".$vistas.".php";
				}
				else{
					$contenido = "login";
				}
			}
			elseif($vistas == "login"){
				$contenido = "login";
			}
			elseif ($vistas == "index") {
				$contenido = "login";
			}
			elseif ($vistas=="administradorAdminTodosPDF") {
				$contenido = "administradorAdminTodosPDF";
			}
			elseif ($vistas=="administradorProfesorTodosPDF") {
				$contenido = "administradorProfesorTodosPDF";
			}
			elseif ($vistas=="administradorEspecialidadTodosPDF") {
				$contenido = "administradorEspecialidadTodosPDF";
			}
			elseif ($vistas=="administradorFrecuenciaTodosPDF") {
				$contenido = "administradorFrecuenciaTodosPDF";
			}
			elseif ($vistas=="administradorCategoriaTodosPDF") {
				$contenido = "administradorCategoriaTodosPDF";
			}
			elseif ($vistas=="administradorAlumnoTodosPDF") {
				$contenido = "administradorAlumnoTodosPDF";
			}
			elseif ($vistas=="administradorModuloTodosPDF") {
				$contenido = "administradorModuloTodosPDF";
			}
			elseif ($vistas=="administradorProductoTodosPDF") {
				$contenido = "administradorProductoTodosPDF";
			}
			elseif ($vistas=="administradorMatriculaPDF") {
				$contenido = "administradorMatriculaPDF";
			}
			elseif ($vistas=="administradorVentaPDF") {
				$contenido = "administradorVentaPDF";
			}
			elseif ($vistas=="administradorReporteAlumnosMatriculadosPDF") {
				$contenido = "administradorReporteAlumnosMatriculadosPDF";
			}
			elseif ($vistas=="administradorReporteAlumnosMatriculadosEXCEL") {
				$contenido = "administradorReporteAlumnosMatriculadosEXCEL";
			}
			elseif ($vistas=="administradorReporteAlumnosEspecialidadPDF") {
				$contenido = "administradorReporteAlumnosEspecialidadPDF";
			}
			elseif ($vistas=="administradorReporteAlumnosEspecialidadEXCEL") {
				$contenido = "administradorReporteAlumnosEspecialidadEXCEL";
			}
			elseif ($vistas=="administradorReporteMatriculasNoCanceladasEXCEL") {
				$contenido = "administradorReporteMatriculasNoCanceladasEXCEL";
			}
			elseif ($vistas=="administradorReporteMatriculasNoCanceladasPDF") {
				$contenido = "administradorReporteMatriculasNoCanceladasPDF";
			}
			elseif ($vistas=="administradorReporteIngresoVentasEXCEL") {
				$contenido = "administradorReporteIngresoVentasEXCEL";
			}
			elseif ($vistas=="administradorReporteIngresoVentasPDF") {
				$contenido = "administradorReporteIngresoVentasPDF";
			}
			elseif ($vistas=="administradorReporteIngresoMatriculasEXCEL") {
				$contenido = "administradorReporteIngresoMatriculasEXCEL";
			}
			elseif ($vistas=="administradorReporteIngresoMatriculasPDF") {
				$contenido = "administradorReporteIngresoMatriculasPDF";
			}
			elseif ($vistas=="docenteReporteAlumnosMatriculadosPDF") {
				$contenido = "docenteReporteAlumnosMatriculadosPDF";
			}
			elseif ($vistas=="docenteReporteAlumnosMatriculadosNotasPDF") {
				$contenido = "docenteReporteAlumnosMatriculadosNotasPDF";
			}
			elseif ($vistas=="docenteReporteAlumnosMatriculadosAsistenciasPDF") {
				$contenido = "docenteReporteAlumnosMatriculadosAsistenciasPDF";
			}
			elseif ($vistas=="docenteMisCursosPDF") {
				$contenido = "docenteMisCursosPDF";
			}
			elseif ($vistas=="docenteDescargarNomina") {
				$contenido = "docenteDescargarNomina";
			}
			else{
				$contenido = "404";
			}

			return $contenido;
		}
	}
