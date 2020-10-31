<h1>Resumen de tu pedido</h1>
<?php
//var_dump($productos);
//var_dump($_SESSION); 
if (isset($_SESSION['pedido_add']) && $_SESSION['pedido_add'] == "complete") :?>
	<h2 class="alert_green">Tu pedido se ha confirmado.</h2>
	<!-- clean Session carrito -->
	<?php //Utils::deleteSession('carrito')?>
	<br>
	<p>
		Tu pedido ha sido guardado con exito, una vez que realices la transferencia
		bancaria a la cuenta 7382947289239ADD con el coste del pedido, será procesado y enviado.
	</p>
	<br>
	<?php if (isset($pedido)): ?>
	
		<h3>Datos del pedido:</h3>
		<strong>Nº pedido:</strong><?= $pedido->idPedido ?> <br/>
		<strong>Estado:</strong><?= $pedido->estado ?> <br/>
		<strong>Fecha:</strong> <?= $pedido->fecha_reg ?><br/>
		<strong>Total a pagar:</strong> <?= $pedido->coste ?> € <br/>
		<br/>

		<h3>Direccion de envio:</h3>
		<strong>Provincia: </strong><?= $pedido->provincia ?> <br/>
		<strong>Localidad: </strong><?= $pedido->localidad ?> <br/>
		<strong>Direccion: </strong><?= $pedido->direccion ?> <br/>
		<br/>
		<strong>ARTICULOS:</strong>
		<table>
			<tr>
				<th>Imagen</th>
				<th>Nombre</th>
				<th>Precio</th>
				<th>Unidades</th>
			</tr>
			<?php while ($producto = $productos->fetch_object()): ?>
				<tr>
					<td>
						<?php if ($producto->imagen != null): ?>
							<img src="<?= base_url ?>uploads/images/<?= $producto->imagen ?>" class="img_carrito" />
						<?php else: ?>
							<img src="<?= base_url ?>assets/img/camiseta.png" class="img_carrito" />
						<?php endif; ?>
					</td>
					<td><?= $producto->nombre ?></td>
					<td><?= $producto->precio ?></td>
					<td><?= $producto->unidades ?></td>
				</tr>
			<?php endwhile; ?>
		</table>
		<br>
		<a class="button button-small" href="<?=base_url?>carrito/cleanCarrito">Aceptar</a>
	<?php endif; ?>	

<?php elseif (isset($_SESSION['pedido_add']) && $_SESSION['pedido_add'] == "failed"): ?>
	<h2> Tu pedido NO ha podido procesarse</h2>
<?php endif; ?>
