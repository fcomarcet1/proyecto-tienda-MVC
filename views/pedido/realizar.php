<h1>Realizar Pedido.</h1>
<?php 

//var_dump($_SESSION['errores']);	
 ?> 

<?php if (isset($_SESSION['identity'])) : ?>
	<a href="<?= base_url ?>carrito/index">Volver al carrito</a>
	<br><br>
	<h3>Metodo de pago y datos del envio:</h3>
	<br>
	<form action="<?= base_url ?>pedido/add" method="POST">

		<label for="pago">Metodo de pago: *</label>
		<select name="pago">
			<option value="" selected>Seleccionar metodo de pago</option>
			<option value="paypal" >Paypal</option> 
			<option value="tarjeta" >Tarjeta de credito</option>
		</select>

		<label for="provincia">Provincia: *</label>
		<input type="text" name="provincia" title="" >
		<?php echo isset($_SESSION['errores']) ? Utils::mostrarError($_SESSION['errores'], 'provincia') : '' ?>
		
		<label for="localidad">Localidad: *</label>
		<input type="text" name="localidad" title="" >
		<?php echo isset($_SESSION['errores']) ? Utils::mostrarError($_SESSION['errores'], 'localidad') : '' ?>
		
		<label for="direccion">Direccion: *</label>
		<input type="text" name="direccion" title="" >
		<?php echo isset($_SESSION['errores']) ? Utils::mostrarError($_SESSION['errores'], 'direccion') : '' ?>
		
		<input type="submit" name="submit_pedido" value="Comprar" >
		<!-- Clean errors form -->
		<?php 
		if (isset($_SESSION['errores'])) {
			$nameSession  = "errores";
			Utils::deleteSession($nameSession);
		}
		 ?>
	</form>
<?php else : ?>
	<h3>Debes estar logueado para realizar el pedido.

		Si no tienes una cuenta debes registrarte aqui: <a href="<?= base_url ?>usuario/registro">Registrarse</a>
	</h3>
<?php endif; ?>
 


