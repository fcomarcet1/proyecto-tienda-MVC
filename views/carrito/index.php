<?php
//var_dump($chk_carrito);
//echo $chk_carrito;

/*
  $carrito es el array que recibimos desde el carritoController que contiene la var sesion carrito
  RECORRER ARRAY $carrito -> foreach
  foreach ($carrito as $index => $element) {

  //nº de unidades
  $unidades = $element['unidades'];

  //precio
  $precio =$element['precio'];

  //alamcenamos el obj producto en una var para asi acceder mas facil a sus attrs
  $producto = $element['producto'];
  //echo $producto; Error: Object of class stdClass could not be converted to string
  }

  echo "Nombre" . $producto->nombre . "<br>";
  echo "Nombre" . $producto->descripcion . "<br>";
  echo "Ud:". $unidades ."<br>";
  echo "Precio:" . $unidades ."<br>";
  echo "Total:" . $unidades * $precio . "(Iva no inc)";

 */
?>
<h1>Mi Carrito</h1>
<?php if (isset($_SESSION['carrito']) && count($_SESSION['carrito']) >= 1): ?>
<div class="button-carrito-gestion">
	<div class="button-carrito-gestion-left">
		<a class="button button-small" href="<?= base_url ?>">Seguir Comprando</a>
	</div>
	<div class="button-carrito-gestion-rigth-red">
		<a class="button button-small-red" href="<?=base_url?>carrito/deleteAll">Limpiar Carrito</a>
	</div>
</div>
<?php endif; ?>

<?php
//$chk_carrito = 'Tu carrito está vacio. Añade productos por favor';
// $carrito = $_SESSION['carrito']
if (isset($_SESSION['carrito']) && count($_SESSION['carrito']) >= 1):
	?>
	<table>
		<tr>
			<th>Imagen</th>
			<th>Nombre</th>
			<th>Precio</th>
			<th>Unidades</th>
			<th>Total Iva inc</th>
			<th>Acciones</th>
		</tr>
		<?php
		// recorremos el array $carrito 
		foreach ($carrito as $indice => $elemento) :

			//almacenamos el obj producto en una var para asi acceder mas facil a sus attrs
			$producto = $elemento['producto'];

			//nº de unidades
			$unidades = $elemento['unidades'];

			//precio
			$precio = $elemento['precio'];
			
			// el indice lo usaremos despues para eliminar un producto determinado del carrito
			// echo $indice
			?>
			<tr>
				<td>
					<?php if ($producto->imagen != null): ?>
						<img src="<?= base_url ?>uploads/images/<?= $producto->imagen ?>" class="img_carrito" />
						<?php else:
						?>
						<img src="<?= base_url ?>assets/img/camiseta.png" class="img_carrito" />
					<?php endif; ?>
				</td>
				<td>
					<a href="<?= base_url ?>producto/ver&idProducto=<?= $producto->idProducto ?>"><?= $producto->nombre ?></a>
				</td>
				<td>
					<?php echo $producto->precio . " €" ?>
				</td>
				<td> 
					
					<?php //$elemento['unidades] ?>
					<div class="unidades"><?=$unidades?></div>
					<div class="updown-unidades">
						<a href="<?=base_url?>carrito/up&index=<?=$indice?>" class="button">+</a>
						<a href="<?=base_url?>carrito/down&index=<?=$indice?>" class="button">-</a>
					</div>
					
				</td>
				<td>
					<?php echo ($producto->precio) * ($unidades) . " €" ?>
				</td>
				<td>
					
					<a class="button button-carrito button-red" href="<?=base_url?>carrito/delete&index=<?=$indice?>"  >
						Eliminar producto
					</a>
				</td>
			</tr>
		<?php endforeach; ?>
	</table>
	<div class="total-carrito">
		<?php $stats = Utils::statsCarrito() ?>
		<h3>Importe total: <?=$stats['total']?>€ (IVA inc)</h3>
		</br></br>
		<a class="button button-pedido" href="<?=base_url?>pedido/realizar">Realizar pedido</a>
	</div>
<?php else: ?>
	<h3 class="alert_red">
		Tu carrito está vacio. Por favor añade algun producto.
	</h3>
<?php endif; ?>




