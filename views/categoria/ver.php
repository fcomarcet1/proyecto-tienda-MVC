<?php 
// listado productos por categoria
if (isset($categoria) && is_object($categoria)) : ?>
	<h1><?= $categoria->nombre ?></h1>
	<?php if ($productos->num_rows == 0): ?>
		<h2>No hay productos actualmente</h2>
	<?php else: ?>
		<?php while ($product = $productos->fetch_object()): ?>
			<div class="product">
				<a href="<?= base_url ?>producto/ver&idProducto=<?= $product->idProducto ?>">
			<?php if ((isset($product->imagen)) && ($product->imagen != null)): ?>
						<img src="<?= base_url ?>uploads/images/<?= $product->imagen ?>" alt="camiseta azul">
					<?php else: ?>
						<img src="<?= base_url ?>assets/img/camiseta.png" alt="camiseta azul">
					<?php endif; ?>
					<h2><?= $product->nombre ?></h2>
				</a>
				<p>Precio:<?= $product->precio ?></p>
				<a class="button" href="<?=base_url?>carrito/add&idProducto=<?=$product->idProducto?>">Añadir al Carrito</a>
			</div>
		<?php endwhile; ?>	
	<?php endif; ?>
<?php else: ?>
	<h1>No existe la Categoria</h1>
<?php endif; ?>





