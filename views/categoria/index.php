<h1>Gestionar Categorias.</h1>
<!-- tenemos disponible el objeto $categorias con los datos de la query -->

<?php if (isset($_SESSION['category_add']) && $_SESSION['category_add'] = "complete ") : ?>
		<strong class="alert_green">Categoria añadida correctamente.</strong>
<?php elseif (isset($_SESSION['category_add']) && $_SESSION['category_add'] = "failed "): ?>
	<strong class="alert_red">No se añadio la categoria. Por favor vuelve a intentarlo.</strong>
<?php endif; ?>

<?php
// limpiamos mensajes de categorias(ok-error)
$nameSession = 'category_add';
Utils::deleteSession($nameSession)
?>			

<!--AÑADIR CATEGORIAS-->
<a class="button button-small" href="<?= base_url ?>categoria/crear">Crear Categoria</a>


<?php
// Validamos si el objeto $categorias esta vacio
if (!empty($categorias) && is_object($categorias)):
	?>
	<table>
		<tr>
			<th>#Id</th>
			<th>Nombre</th>
			<th>Accion</th>
		</tr>
		<?php while ($cat = $categorias->fetch_object()): ?>
			<tr>
				<td><?= $cat->idCategoria ?></td>
				<td><?= $cat->nombre ?></td>
				<td><a href="<?=base_url?>categoria/editar&idCategoria=<?=$cat->idCategoria?>">Editar</a> - <a href="">Eliminar</a></td>
			</tr>	
		<?php endwhile; ?>
	</table>

<?php else: ?>
	<h2>No existen categorias actualmente.</h2>
<?php endif; ?>