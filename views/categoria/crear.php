<h1>Añadir nueva categoria</h1>


<?php 
//var_dump($_SESSION);

if( (isset($_SESSION['category_add'])) && ($_SESSION['category_add'] == 'complete' ) ):?>
	<strong class="alert_green">Categoria añadida correctamente.</strong>
<?php elseif((isset($_SESSION['category_add'])) && ($_SESSION['category_add'] == 'failed' )) : ?>
	<strong class="alert_red">Error al añadir nueva categoria.Vuelve a intentarlo</strong>
<?php endif; ?>
	
<?php
// limpiamos mensajes de categorias(ok-error)
$nameSession = 'category_add';
Utils::deleteSession($nameSession) 
?>	

<form action="<?=base_url?>categoria/save" method="POST">
	
	<label for="nombre">Nombre</label>
	<input type="text" name="nombre">
	<?php echo isset($_SESSION['errores']) ? Utils::mostrarError($_SESSION['errores'], 'nombre') : '' ?>
	
	<input type="submit" name="submit_categorias" value="Guardar">
	
	<?php 
	// limpiamos errores del form
	$session = 'errores';
	Utils::deleteSession($session)   
	?>	
	
</form>
