<?php

//*********************** URL DINAMICA **********************
// vamos a crear una url dinamica para el form en funcion si es para crear un nuevo producto o editarlo
// $product es el objeto que nos devuelve el metodo getOne()->[return $product->fetch_object()], 
// que es un objeto totalmente utilizable con los datos del producto con una id determinada.

if (isset($edit) && isset($product) && is_object($product)):?>
	<h1>Editar producto:<?= $product->nombre ?> </h1>
	<p class='alert_red'>Campos Requeridos: *</p>
	<?php $action_url = base_url . "producto/save&idProducto=" . $product->idProducto ?>
<?php else: ?>
	<h1>Añadir nuevo producto</h1>
	<p class='alert_red'>Campos Requeridos: *</p>
	<?php $action_url = base_url . "producto/save" ?>
<?php endif; ?>


<?php if (isset($_SESSION['producto_add']) && $_SESSION['producto_add'] = "failed "): ?>
	<strong class="alert_red">No se añadio el producto. Por favor vuelve a intentarlo.</strong>
<?php endif; ?>	

<?php
//limpiamos mensaje error producto_add
Utils::deleteSession('producto_add')
?>		

<div class="form_container">

	<?php
	//usamos el metodo showCategorias() que nos crea un objeto $categorias con todas las categorias
	// asi recorrer el objeto y mostrar las categorias en menu de seleccion
	// OJO Almacenar el Utils::showCategorias() en una var sino no se puede usar en el while

	$categorias = Utils::showCategorias();
	//var_dump($categorias);
	?>

	<!--Categorias -->
	<!--  <select id="cars">
			<option value="audi" selected>Audi</option>
			<option value="volvo">Volvo</option>
		  </select>-->
    <form action="<?= $action_url ?>" method="POST" enctype="multipart/form-data">
		<!--Categoria -->
		<!--
			NOTA : error dificil de encontrar -> cerrar con ; 
			y ojo parentesis:  
					(isset($product) && is_object($product) && $cat->idCategoria) == $product->id_categoria ?.. -> ERROR
					(isset($product) && is_object($product) && $cat->idCategoria == $product->id_categoria) ?... -> OK
		-->
		<label for="nombre">Categoria:<span class="alert_red">*</span></label>
		<select name="categoria" id="categoria">
			<option value="">Elije tu Categoria</option>
			<?php while ($cat = $categorias->fetch_object()): ?>
				<option value="<?= $cat->idCategoria ?>" <?= (isset($product) && is_object($product) && $cat->idCategoria == $product->id_categoria) ? 'selected' : ''; ?> > 
					<?= $cat->idCategoria ?> - <?= $cat->nombre ?> 
				</option>
			<?php endwhile; ?>
		</select>
		<?php echo isset($_SESSION['errores']) ? Utils::mostrarError($_SESSION['errores'], 'categoria') : '' ?>

		<!--Nombre -->
		<?php /* var_dump(isset($product) && is_object($product)); */ ?>
		<label for="nombre">Nombre:<span class="alert_red">*</span></label>
		<input type="text" name="nombre" value="<?= isset($product) && is_object($product) ? $product->nombre : '' ?>" id="nombre" ></input>
		<?php echo isset($_SESSION['errores']) ? Utils::mostrarError($_SESSION['errores'], 'nombre') : '' ?>

		<!--Descripcion -->
		<label for="descripcion">Descripcion:<span class="alert_red">*</span></label>
		<textarea name="descripcion" rows="8" cols="16" /><?= isset($product) && is_object($product) ? $product->descripcion : '' ?></textarea>	
		<?php echo isset($_SESSION['errores']) ? Utils::mostrarError($_SESSION['errores'], 'descripcion') : '' ?>

		<!--Precio -->
		<label for="precio">Precio:<span class="alert_red">*</span></label>
		<input type="text" name="precio" value="<?= isset($product) && is_object($product) ? $product->precio : '' ?>" id="nombre" />
		<?php echo isset($_SESSION['errores']) ? Utils::mostrarError($_SESSION['errores'], 'precio') : '' ?>

		<!--Stock -->
		<label for="stock">Stock:<span class="alert_red">*</span></label>
		<input type="number" name="stock" value="<?= isset($product) && is_object($product) ? $product->stock : '' ?>" />
		<?php echo isset($_SESSION['errores']) ? Utils::mostrarError($_SESSION['errores'], 'stock') : '' ?>
		
		<!--Oferta -->
		<!-- Ej:
			<form action="/action_page.php">
  
				<input type="checkbox" name="vehicle1" value="Bike">
				<label for="vehicle1"> I have a bike</label><br>

				<input type="checkbox" name="vehicle2" value="Boat" checked>
				<label for="vehicle3"> I have a boat</label><br><br>
  
				<input type="submit" value="Submit">
			  </form>
		-->
		<label for="oferta">Oferta:</label>
		<!--	 <input type="checkbox" id="oferta" name="oferta" value="Yes" />  -->
		<?php
		// marcar o no la casilla en la edicion del producto
		if (isset($product) && is_object($product) && $product->oferta == 'Yes') : ?>
				<input type="checkbox" id="oferta" name="oferta" value="Yes" checked ></input>
		<?php 
		elseif(isset($product) && is_object($product) && $product->oferta == 'No') : ?>
				<input type="checkbox" id="oferta" name="oferta" value="No" ></input>
		<?php 
		else: ?> 
				<!-- checkbox add product -->
				<input type="checkbox" id="oferta" name="oferta" value="Yes" ></input>
		<?php 
		endif; ?>
				
				
		<!--Imagen -->
		<?php  //var_dump($product->imagen) ?>
		<label for="imagen">Imagen:<span class="alert_red">*</span></label>
		<input type="file" name="imagen" id="imagen" accept="image/png, image/jpeg, image/png, image/gif" />
		<?php 
		if (isset($product) && is_object($product) &&  !empty($product->imagen)) : ?>
		<br><br>
		<img src="<?=base_url?>uploads/images/<?=$product->imagen?>"  width="200px" height="200px" />
		<?php 
		endif; ?>
		<!-- Show errors -->
		<?php echo isset($_SESSION['errores']) ? Utils::mostrarError($_SESSION['errores'], 'imagen') : '' ?>
		
		<input type="submit" name="submit_producto" value="Guardar">
		
		<?php
		//limpiamos errores
		$nameSession = "errores";
		Utils::deleteSession($nameSession);
		?>

	</form>




</div>

