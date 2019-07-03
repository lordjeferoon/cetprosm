<script>
	$(document).ready(function(){
		$('.btn-exit').on('click', function(e){
			e.preventDefault();
			var Token=$(this).attr('href');
			swal({
				title: '¿Estás seguro?',
				text: "La sesión será cerrada y deberás iniciarla nuevamente",
				type: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#03A9F4',
				cancelButtonColor: '#F44336',
				confirmButtonText: 'Sí, cerrar',
				cancelButtonText: 'No, cancelar'
			}).then((result) => {
				if (result.value) {
					$.ajax({
						url: '<?php echo SERVERURL; ?>ajax/loginAjax.php?Token='+Token,
						success: function(data){
							if(data=="true"){
								window.location.href="<?php echo SERVERURL; ?>";
							}
							else{
								swal(
									"Ocurrió un error inesperado",
									"No se pudo cerrar la sesión",
									"error"
								);
							}
						}
					});		  
				}
			});
		});
	});
</script>