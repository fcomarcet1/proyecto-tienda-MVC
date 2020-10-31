<?php
// Detalle producto
if (isset($product)) :?>
	<h1><?= $product->nombre ?></h1>
	<div id="detail-product">
		<div class="image">
			<?php if ((isset($product->imagen)) && ($product->imagen != null)): ?>
				<img src="<?= base_url ?>uploads/images/<?= $product->imagen ?>" alt="camiseta azul">
			<?php else: ?>
				<img src="<?= base_url ?>assets/img/camiseta.png" alt="camiseta azul">
			<?php endif; ?>
		</div>
		<div class="data">
			<h2><?= $product->nombre ?></h2>
			<p class="description">Descripcion:<?=  $product->descripcion ?></p>
			<p class="price">Precio: <?= $product->precio ?>€</p>
			<a class="button" href="<?=base_url?>carrito/add&idProducto=<?=$product->idProducto?>">Añadir al Carrito</a>
		</div>
	</div>
<?php else: ?>
	<h1> No existe el producto seleccionado</h1>
<?php endif; ?>