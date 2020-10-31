<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="stylesheet" type="text/css" href="assets/css/styles.css">
	</head>

	<body>
		<div class="container">
			<!-- Empieza Header -->
			<header id="header">
				<div id="logo">
					<img src="assets/img/camiseta.png" alt="Camiseta logo">
					<a href="index.php">Tienda de camisetas</a>
				</div>
			</header>
			<!-- Finaliza Header -->

			<!-- Empieza Menu -->
			<nav id="menu">
				<ul>
					<li><a href="#">Inicio</a></li>
					<li><a href="#">Categoria 1</a></li>
					<li><a href="#">Categoria 2</a></li>
					<li><a href="#">Categoria 3</a></li>
					<li><a href="#">Categoria 4</a></li>
				</ul>
			</nav>
			<!-- Finaliza Menu -->

			<div id="content">
				<!-- Empieza barra lateral -->
				<aside id="aside">
					<div id="login" class="block-aside">
						<h3>Entrar a la web</h3>
						<form action="#" method="POST">
							<label for="email">Email:</label>
							<input type="email" name="email" id="email">

							<label for="password_login">Contraseña:</label>
							<input type="password" name="password" id ="password_login">

							<input type="submit" name="submit_login" value="Acceder">
						</form>
						<ul>
							<li><a href="#">Mis pedidos.</a></li>
							<li><a href="#">Gestionar pedidos.</a></li>
							<li><a href="#">Mis categorias.</a></li>
						</ul>	
					</div>
				</aside>
				<!-- Finaliza barra lateral -->

				<!-- Empieza Seccion de contenido -->
				<div id="principal">

					<h1>Productos destacados</h1>
					<div class="product">
						<img src="assets/img/camiseta.png" alt="camiseta azul">
						<h2>Camiseta Azul Manga corta</h2>
						<p>20 Euros</p>
						<a class="button" href="">Comprar</a>
					</div>	

					<div class="product">
						<img src="assets/img/camiseta.png" alt="camiseta azul">
						<h2>Camiseta Azul Manga corta</h2>
						<p>20 Euros</p>
						<a class="button" href="">Comprar</a>
					</div>	

					<div class="product">
						<img src="assets/img/camiseta.png" alt="camiseta azul">
						<h2>Camiseta Azul Manga corta</h2>
						<p>20 Euros</p>
						<a class="button" href="">Comprar</a>
					</div>
				</div>
				<!-- Finaliza Seccion de contenido -->

			</div><!-- Finaliza div content -->	


			<!-- Empieza pie de pagina -->
			<footer id="footer">
				<p>Desarrollado por Francisco Marcet prieto &COPY;  <?= date('Y') ?> </p>
			</footer>
			<!-- Finaliza pie de pagina -->

		</div>
	</body>
</html>
