<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Responsive sidebar template with sliding effect and dropdown menu based on bootstrap 3">
        <title>Cetpro San Martín de Porres - Chosica</title>
        <link rel="stylesheet" type="text/css" href="<?php echo SERVERURL; ?>vistas/css/sweetalert2.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo SERVERURL; ?>vistas/css/estilos-propios.css">
        <link rel="stylesheet" href="<?php echo SERVERURL; ?>vistas/css/main.css">
    
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
            crossorigin="anonymous">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    
        <link rel="stylesheet" href="//malihu.github.io/custom-scrollbar/jquery.mCustomScrollbar.min.css">
    
        <link rel="stylesheet" href="<?php echo SERVERURL; ?>vistas/css/custom.css">
        <link rel="stylesheet" href="<?php echo SERVERURL; ?>vistas/css/custom-themes.css">
        <link rel="shortcut icon"  href="<?php echo SERVERURL; ?>vistas/img/cetpro_img_logo.png">
        
    </head>
    <body>
        <div class="limiter">
        	
        	<div class="limiter">
        		<div class="container-login100">
        			<div class="wrap-login100">
        				<div class="login100-pic" data-tilt>
        					<img src="<?php echo SERVERURL; ?>vistas/img/cetpro_img_logo.png" alt="SMP">
        				</div>
        				<div>
        					<span class="login100-form-title" style="padding-top: 25px;">
        						Sistema Web Cetpro SMP
        					</span>
        					<form class="login100-form" style="margin: 0 auto;" action="" method="POST" data-form="guardar" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
        						
        						<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
        							<input class="input100" type="text" name="usuario" placeholder="Usuario" autocomplete="off" required>
        							<span class="focus-input100"></span>
        							<span class="symbol-input100">
        								<i class="fas fa-user" aria-hidden="true"></i>
        							</span>
        						</div>
        
        						<div class="wrap-input100 validate-input" data-validate = "Password is required">
        							<input class="input100" type="password" name="contrasena" placeholder="Contrase&ntilde;a" autocomplete="off" required>
        							<span class="focus-input100"></span>
        							<span class="symbol-input100">
        								<i class="fas fa-unlock-alt" aria-hidden="true"></i>
        							</span>
        						</div>
        						
        						<div class="container-login100-form-btn">
        							<button class="login100-form-btn" type="submit">
        								Iniciar Sesi&oacute;n
        							</button>
        						</div>
        						<div class="RespuestaAjax"></div>
        					</form>
        				</div>
        			</div>
        		</div>
        	</div>
        </div>
        <?php 
        	if (isset($_POST['usuario']) && isset($_POST['contrasena'])) {
        		require_once "controladores/loginControlador.php";
        		$login = new loginControlador();
        		echo $login->iniciar_sesion_controlador();
        	}
        ?>
        <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
        <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
            crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
            crossorigin="anonymous"></script>
        <script src="//malihu.github.io/custom-scrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
        <script src="<?php echo SERVERURL; ?>vistas/js/custom.js"></script>
        <script src="<?php echo SERVERURL; ?>vistas/js/main.js"></script>
        <script src="<?php echo SERVERURL; ?>vistas/js/sweetalert2.all.min.js"></script>
        <script src="<?php echo SERVERURL; ?>vistas/js/sweetalert2.min.js"></script>
    </body>
</html>
