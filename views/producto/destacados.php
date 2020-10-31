<h1>Ultimas Novedades</h1>
<?php //var_dump(isset($productos), is_object($productos)); ?>
<?php 
if(isset($productos) && is_object($productos)): 
	while($product = $productos->fetch_object()): ?>
		<div class="product">
			<a href="<?=base_url?>producto/ver&idProducto=<?=$product->idProducto?>">
				<?php if( (isset($product->imagen)) && ($product->imagen != null) ): ?>
					<img src="<?=base_url?>uploads/images/<?=$product->imagen?>" alt="camiseta azul">
				<?php else: ?>
					<img src="<?=base_url?>assets/img/camiseta.png" alt="camiseta azul">
				<?php endif; ?>
				<h2><?= $product->nombre ?></h2>
			</a>
			<p>Precio:<?= $product->precio ?></p>
			<a class="button" href="<?=base_url?>carrito/add&idProducto=<?=$product->idProducto?> ">Comprar</a>
		</div>
	<?php endwhile; ?>	
<?php else: ?>
	<h2>No hay productos actualmente</h2>
<?php endif; ?>
<!-- Finaliza Seccion de contenido -->