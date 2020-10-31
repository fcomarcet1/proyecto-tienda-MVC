<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="stylesheet" type="text/css" href="<?=base_url?>assets/css/styles.css">
		<link type="text/css" rel="stylesheet" href="<?=base_url?>assets/css/page_error.css" />
		<script type="text/javascript" src="<?=base_url?>assets/js/confirmation.js"></script>
	</head>

	<body>
		<div class="container">
			<!-- Empieza Header -->
			<header id="header">
				<div id="logo">
					<img src="<?=base_url?>assets/img/camiseta.png" alt="Camiseta logo">
					<a href="<?=base_url?>producto/index">Tienda de camisetas</a>
				</div>
			</header>
			<!-- Finaliza Header -->

			<!-- Empieza Menu -->
			<?php 
			$categorias = Utils::showCategorias() //devuelve un array de objetos con los datos de la BD ?>
			<nav id="menu">
				<ul>
					<li><a href="<?=base_url?>">Inicio</a></li>
					<?php while($cat = $categorias->fetch_object()):?>
						<li>
							<a href="<?=base_url?>categoria/ver&idCategoria=<?=$cat->idCategoria?>"><?= $cat->nombre?></a>
						</li>
					<?php endwhile;?>
					
				</ul>
			</nav>
			<!-- Finaliza Menu -->
			<div id="content">
