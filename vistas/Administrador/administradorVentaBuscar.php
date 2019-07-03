 <?php
    $mysqli = new mysqli(SERVER,USER,PASS,DB);
?>
<div class="contenido-main">
                <div class="titulo-formulario">
                    <h2><span>Buscar </span>Boleta de Venta</h2>
                </div>
                <form action="<?php echo SERVERURL;?>administradorVentaReporte" method="POST">
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label class="titulo-label">Código de Venta:</label>
                            <input type="text" name="codigo" class="form-control" required autofocus style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" autocomplete="off">
                        </div>
                        <div class="form-group col-md-6">

                        </div>
                        <div class="form-group col-md-3">
                            <br>
                            <button type="submit" class="btn boton-registrar btn-success w-100">Buscar</button>
                        </div>
                    </div>
                </form>
</div>