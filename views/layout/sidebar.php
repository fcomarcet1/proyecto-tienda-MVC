<aside id="aside">
	
	<div class="block_aside">
		<?php if(isset($_SESSION['carrito']) && count($_SESSION['carrito']) >= 1): ?>
		<h3>Mi carrito</h3>
		
		<ul>
			<?php $stats = Utils::statsCarrito() ?>
			<li>
				<a href="<?=base_url?>carrito/index">Productos (<?= $stats['count']?>)</a>
			</li>
			<li>
				<a href="<?=base_url?>carrito/index">Total:<?= $stats['total']?> €</a>
			</li>
			<li>
				<a href="<?=base_url?>carrito/index">Ver carrito</a>
			</li>
		</ul>
		<?php endif; ?>
		
	</div>
	
	<div id="login" class="block_aside">

		<!-- Si no existe la var sesion login mostramos form login y 
			sino los datos del user identificado 
		-->
		
		<?php
		//var_dump($_SESSION);
		// $_SESSION['identity'] = $identity(objeto)
		
		if(!isset($_SESSION['identity'])) : ?>
			<h3>Entrar a la web</h3>
		
			<?php if(isset($_SESSION['error_login'])): ?>
				<strong class="alert_red"><?php echo $_SESSION['error_login'] ?></strong> 
			<?php endif; ?>
				
			<form action="<?= base_url ?>usuario/login" method="POST">
				
				<label for="email">Email:</label>
				<input type="email" name="email" id="email">
				<?php echo isset($_SESSION['errores']) ? Utils::mostrarError($_SESSION['errores'], 'email') : '' ?>				<label for="password">Contraseña:</label>
				
				<input type="password" name="password" id ="password">
				<?php echo isset($_SESSION['errores']) ? Utils::mostrarError($_SESSION['errores'], 'password') : '' ?>	
				<input type="submit" name="submit_login" value="Acceder">
				
				<!-- clear errors form -->
				<?php 
				$nameSession1 = 'errores';
				$nameSession2 = 'error_login';
				Utils::deleteSession($nameSession1);
				Utils::deleteSession($nameSession2);
				?>
			</form>
		
		<!-- Mostrar credenciales usuario identificado -->
		<?php else: ?>
			<h3>Bienvenido: <?=$_SESSION['identity']->nombre?> <?=$_SESSION['identity']->apellidos?></h3>
		<?php endif;?>	
		
		<ul>
			<?php
			// visibilidad = admin
			if( (isset($_SESSION['admin'])) && ($_SESSION['admin'] == 'admin') ): ?>
				<li><a href="<?= base_url ?>">Mi perfil</a></li>
				<li><a href="<?= base_url ?>categoria/index">Gestionar categorias</a></li>
				<li><a href="<?= base_url ?>producto/gestion">Gestionar productos</a></li>
				<li><a href="<?= base_url ?>pedido/gestion">Gestionar pedidos</a></li>
			<?php endif; ?>
			
			<?php 
			// visibilidad = user
			if( isset($_SESSION['identity']) ): ?>
				<li><a href="<?= base_url ?>">Mi perfil</a></li>
				<li><a href="<?= base_url ?>pedido/mis_pedidos">Mis pedidos</a></li>
				<li><a href="<?= base_url ?>usuario/logout">Cerrar sesion</a></li>
			<?php else: ?>
				<li><a href="<?= base_url ?>usuario/registro">Registrarse.</a></li>
			<?php endif; ?>
		</ul>	
		
	</div>
</aside>
<!-- Finaliza barra lateral -->

<!-- Empieza Seccion de contenido -->
<div id="principal">