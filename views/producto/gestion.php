<h1>Gestionar Productos.</h1>

<!--AÑADIR Productos-->
<a class="button button-small" href="<?= base_url ?>producto/crear">Añadir Producto</a>

<?php
//var_dump($_SESSION); 
if (isset($_SESSION['producto_add']) && $_SESSION['producto_add'] = "complete " ) : ?>
	<strong class="alert_green">Producto añadido correctamente.</strong>
<?php elseif(isset($_SESSION['producto_add']) && $_SESSION['producto_add'] = "failed "): ?>
		<strong class="alert_red">No se añadio el producto. Por favor vuelve a intentarlo.</strong>
<?php endif; ?>	
		
<?php 
//limpiamos mensajes
if(isset($_SESSION['producto_add'])):
	$nameSession = "producto_add";
	Utils::deleteSession($nameSession);
endif; ?> 

			
<!--MSG delete Productos-->
<?php if (isset($_SESSION['producto_delete']) && $_SESSION['producto_delete'] = "complete " ) : ?>
	<strong class="alert_green">Producto eliminado correctamente.</strong>
<?php elseif(isset($_SESSION['producto_delete']) && $_SESSION['producto_delete'] = "failed "): ?>
		<strong class="alert_red">No se eliminó el producto. Por favor vuelve a intentarlo.</strong>
<?php endif; ?>	
		
<?php 
//limpiamos mensajes
if(isset($_SESSION['producto_delete']) ):
	$nameSession = "producto_delete";
	Utils::deleteSession($nameSession);
endif; ?>		

<!-- MSG EDIT product -->
<?php if (isset($_SESSION['producto_edit']) && $_SESSION['producto_edit'] = "complete " ) : ?>
	<strong class="alert_green">Producto editado correctamente.</strong>
<?php elseif(isset($_SESSION['producto_edit']) && $_SESSION['producto_edit'] = "failed "): ?>
		<strong class="alert_red">No se editó el producto. Por favor vuelve a intentarlo.</strong>
<?php endif; ?>	
<?php 
//limpiamos mensajes
if(isset($_SESSION['producto_edit']) ):
	$nameSession = "producto_edit";
	Utils::deleteSession($nameSession);
endif; ?>			
		
<?php
//tenemos disponible el objeto $categorias con los datos de la query

// Validamos si el objeto $productos esta vacio
if (!empty($productos) && is_object($productos)):?>
	<table>
		<tr>
			<th>#Id</th>
			<th>Categoria</th>
			<th>Nombre</th>
			<th>Precio</th>
			<th>Stock</th>
			<th>Oferta</th>
			<th>Acciones</th>
		</tr>
		<?php while ($product = $productos->fetch_object()): ?>
			<tr>
				<td><?= $product->idProducto ?></td>
				<td><?= $product->categoria ?></td>
				<td><?= $product->nombre ?></td>
				<td><?= $product->precio ?></td>
				<td><?= $product->stock ?></td>
				<td><?= $product->oferta ?></td>
				<td>
					<a href="<?=base_url?>producto/editar&idProducto=<?=$product->idProducto?>" class="button button-gestion" >Editar</a>
					<a href="<?=base_url?>producto/eliminar&idProducto=<?=$product->idProducto?>" 
					   onclick="return Confirmation()" class="button button-gestion button-red" >Eliminar</a>
				</td>
				
			</tr>	
		<?php endwhile; ?>
	</table>

<?php else: ?>
	<h2> No existen productos actualmente</h2>
<?php endif; ?>
