<?php if (isset($gestion)): ?>
	<h1>Gestion de pedidos</h1>
<?php else: ?>
	<h1>Mis pedidos</h1>
<?php endif; ?>
<?php
//var_dump(($mis_pedidos->num_rows), is_object($mis_pedidos));
if (isset($mis_pedidos) && is_object($mis_pedidos) && $mis_pedidos->num_rows >= 1):?> 
	<table>
		<tr>
			<th>Nº pedido</th>
			<th>Precio Total</th>
			<th>Fecha</th>
			<th>Estado</th>
			<th>Acciones</th>
		</tr>
		<?php // recorremos el array $mis_pedidos ?>
		<?php while ($pedidos = $mis_pedidos->fetch_object()) : ?>
			<tr>
				<td>
					<a href=""> <?=$pedidos->idPedido?></a>
				</td>
				<td>
					<?= $pedidos->coste ?> €
				</td>
				<td>
					<?= $pedidos->fecha_reg ?>
				</td>
				<td>
					<?= Utils::showEstado($pedidos->estado) ?> 
				</td>
				<td>
					<a href="<?= base_url ?>pedido/detalle&idPedido=<?=$pedidos->idPedido?>">Ver detalle</a>
				</td>
			</tr>
		<?php endwhile; ?>
	</table>
<?php elseif (!isset($pedidos) || !is_object($mis_pedidos) || $mis_pedidos->num_rows == 0): ?>
	<h2>No tienes ningun pedido realizado actualmente.</h2>	
<?php endif; ?>