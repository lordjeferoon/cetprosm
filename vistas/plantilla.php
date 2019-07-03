<?php
	//session_start(['name'=>'CSM']);
    $peticionAjax=false;

    require_once "controladores/vistasControlador.php";

    $vt = new vistasControlador();
    $vista = $vt->obtener_vistas_controlador();

    if($vista == "login" || $vista == "404" || $vista == "administradorAdminTodosPDF" || $vista == "administradorProfesorTodosPDF" || $vista == "administradorEspecialidadTodosPDF" || $vista == "administradorFrecuenciaTodosPDF" || $vista == "administradorCategoriaTodosPDF" || $vista == "administradorAlumnoTodosPDF" || $vista == "administradorModuloTodosPDF" || $vista == "administradorProductoTodosPDF" || $vista == "administradorMatriculaPDF" || $vista == "administradorVentaPDF" || $vista == "administradorReporteAlumnosMatriculadosPDF" || $vista == "administradorReporteAlumnosMatriculadosEXCEL" || $vista == "administradorReporteIngresoVentasPDF" || $vista == "administradorReporteIngresoVentasEXCEL" || $vista == "administradorReporteIngresoMatriculasPDF" || $vista == "administradorReporteAlumnosEspecialidadPDF" || $vista == "administradorReporteAlumnosEspecialidadEXCEL" || $vista == "administradorReporteIngresoMatriculasEXCEL" || $vista == "administradorReporteMatriculasNoCanceladasPDF" || $vista == "administradorReporteMatriculasNoCanceladasEXCEL" || $vista == "docenteReporteAlumnosMatriculadosPDF" || $vista == "docenteReporteAlumnosMatriculadosNotasPDF" || $vista == "docenteReporteAlumnosMatriculadosAsistenciasPDF" || $vista == "docenteMisCursosPDF" || $vista == "docenteDescargarNomina"):
        if($vista == "login") {
            require_once "vistas/login.php";
        }
        elseif($vista=="administradorAdminTodosPDF"){
            require_once "vistas/Administrador/administradorAdminTodosPDF.php";
        }
        elseif($vista=="administradorProfesorTodosPDF"){
            require_once "vistas/Administrador/administradorProfesorTodosPDF.php";
        }
        elseif($vista=="administradorFrecuenciaTodosPDF"){
            require_once "vistas/Administrador/administradorFrecuenciaTodosPDF.php";
        }
        elseif($vista=="administradorEspecialidadTodosPDF"){
            require_once "vistas/Administrador/administradorEspecialidadTodosPDF.php";
        }
        elseif($vista=="administradorCategoriaTodosPDF"){
            require_once "vistas/Administrador/administradorCategoriaTodosPDF.php";
        }
        elseif($vista=="administradorAlumnoTodosPDF"){
            require_once "vistas/Administrador/administradorAlumnoTodosPDF.php";
        }
        elseif($vista=="administradorModuloTodosPDF"){
            require_once "vistas/Administrador/administradorModuloTodosPDF.php";
        }
        elseif($vista=="administradorProductoTodosPDF"){
            require_once "vistas/Administrador/administradorProductoTodosPDF.php";
        }
        elseif($vista=="administradorMatriculaPDF"){
            require_once "vistas/Administrador/administradorMatriculaPDF.php";
        }
        elseif($vista=="administradorVentaPDF"){
            require_once "vistas/Administrador/administradorVentaPDF.php";
        }
        elseif($vista=="administradorReporteAlumnosMatriculadosPDF"){
            require_once "vistas/Administrador/administradorReporteAlumnosMatriculadosPDF.php";
        }
        elseif($vista=="administradorReporteAlumnosMatriculadosEXCEL"){
            require_once "vistas/Administrador/administradorReporteAlumnosMatriculadosEXCEL.php";
        }
        elseif($vista=="administradorReporteAlumnosEspecialidadPDF"){
            require_once "vistas/Administrador/administradorReporteAlumnosEspecialidadPDF.php";
        }
        elseif($vista=="administradorReporteAlumnosEspecialidadEXCEL"){
            require_once "vistas/Administrador/administradorReporteAlumnosEspecialidadEXCEL.php";
        }
        elseif($vista=="administradorReporteMatriculasNoCanceladasEXCEL"){
            require_once "vistas/Administrador/administradorReporteMatriculasNoCanceladasEXCEL.php";
        }
        elseif($vista=="administradorReporteMatriculasNoCanceladasPDF"){
            require_once "vistas/Administrador/administradorReporteMatriculasNoCanceladasPDF.php";
        }
        elseif($vista=="administradorReporteIngresoVentasEXCEL"){
            require_once "vistas/Administrador/administradorReporteIngresoVentasEXCEL.php";
        }
        elseif($vista=="administradorReporteIngresoVentasPDF"){
            require_once "vistas/Administrador/administradorReporteIngresoVentasPDF.php";
        }
        elseif($vista=="administradorReporteIngresoMatriculasEXCEL"){
            require_once "vistas/Administrador/administradorReporteIngresoMatriculasEXCEL.php";
        }
        elseif($vista=="administradorReporteIngresoMatriculasPDF"){
            require_once "vistas/Administrador/administradorReporteIngresoMatriculasPDF.php";
        }
        elseif($vista=="docenteReporteAlumnosMatriculadosPDF"){
            require_once "vistas/Administrador/docenteReporteAlumnosMatriculadosPDF.php";
        }
        elseif($vista=="docenteReporteAlumnosMatriculadosNotasPDF"){
            require_once "vistas/Administrador/docenteReporteAlumnosMatriculadosNotasPDF.php";
        }
        elseif($vista=="docenteReporteAlumnosMatriculadosAsistenciasPDF"){
            require_once "vistas/Administrador/docenteReporteAlumnosMatriculadosAsistenciasPDF.php";
        }
        elseif($vista=="docenteMisCursosPDF"){
            require_once "vistas/Administrador/docenteMisCursosPDF.php";
        }
        elseif($vista=="docenteDescargarNomina"){
            require_once "vistas/Administrador/docenteDescargarNomina.php";
        }
        else{
            require_once "vistas/404.php";
        }
               
    else:
        
        session_start();
        require_once "controladores/loginControlador.php";
        $lc = new loginControlador();
        if(!isset($_SESSION["token_csm"]) || !isset($_SESSION["usuario_csm"])){
            //$lc->forzar_cierre_sesion_controlador();
            session_destroy();
            echo'<script> window.location.href="'.SERVERURL.'"</script>';
        }
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <?php include "Modulos/PlantillasCSS.php" ?>
</head>

<body>

    <div class="page-wrapper chiller-theme sidebar-bg bg1 toggled">
        
        <?php  
            if($_SESSION['tipo_csm']=="Administrador"){
                include "Modulos/PlantillaAdministrador.php";
            }
            if($_SESSION['tipo_csm']=="Docente"){
                include "Modulos/PlantillaDocente.php";
            }
        ?>

        <main class="page-content">

            <?php  include "Modulos/PlantillaTitulo.php" ?>
            <?php require_once $vista; ?>

        </main>
        <!-- page-content" -->

    </div>
	<?php 
        endif;
    ?> 
    <!--<script>
        $.material.init();
    </script>-->
    
	</body>
    <?php include "Modulos/PlantillasJS.php" ?>
    <?php include "vistas/modulos/logoutScript.php"; ?>
</html>

