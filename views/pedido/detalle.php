<h1>Detalle Pedido</h1>
<?php if (isset($pedido)): ?>
	<?php if (isset($_SESSION['admin'])): ?>
		<h3>Cambiar estado del pedido</h3>
		<form action="<?= base_url ?>pedido/estado" method="POST">
			<input type="hidden" value="<?= $pedido->idPedido ?>" name="idPedido"/>
			<select name="estado">
				<option value="">Seleccionar estado del pedido</option>
				<option value="Confirm" <?= $pedido->estado == "Confirm" ? 'selected' : ''; ?>>Pendiente</option>
				<option value="Preparation" <?= $pedido->estado == "Preparation" ? 'selected' : ''; ?>>En preparación</option>
				<option value="Ready" <?= $pedido->estado == "Ready" ? 'selected' : ''; ?>>Preparado para enviar</option>
				<option value="Sended" <?= $pedido->estado == "Sended" ? 'selected' : ''; ?>>Enviado</option>
				<option value="Cancelled" <?= $pedido->estado == "Cancelled" ? 'selected' : ''; ?>>Cancelado</option>
			</select>
			<input type="submit" value="Cambiar estado" />
		</form>
		<br/>
	<?php endif; ?>

	<h3>Datos del pedido:</h3>
	<strong>Nº pedido:</strong><?=$pedido->idPedido?> <br/>
	<strong>Estado:</strong><?=Utils::showEstado($pedido->estado) ?> <br/>
	<strong>Fecha:</strong> <?=$pedido->fecha_reg ?><br/>
	<strong>Total a pagar:</strong> <?=$pedido->coste?> € <br/>
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
<?php endif; ?>	
