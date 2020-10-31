<h1>Registrate:</h1>

<?php
//var_dump($_SESSION);
//
// Mensajes Registro OK-Fail
if ((isset($_SESSION['register'])) && ($_SESSION['register'] == 'complete')) :?>
	<strong class="alert_green">Registro completado correctamente.</strong> 
<?php elseif ((isset($_SESSION['register'])) && ($_SESSION['register'] == 'failed')) : ?>
	<strong class="alert_red">Error en el registro.Por favor ingresa tus datos.</strong> 
<?php endif; ?>

<?php
// limpiamos mensajes de registro(ok-error)
$nameSession = 'register';
Utils::deleteSession($nameSession) 
?>
<form action="<?= base_url ?>usuario/save" method="POST">

	<label for="nombre">Nombre:</label>
	<input type="text" name="nombre" id="nombre" maxlength="32" title="El nombre solo puede contener letras May/minusculas. e.g. Frank" required >	
	<?php echo isset($_SESSION['errores']) ? Utils::mostrarError($_SESSION['errores'], 'nombre') : '' ?>

	<label for="apellidos">Apellidos:</label>
	<input type="text" name="apellidos" id="apellidos"  title="Los apellidos solo pueden contener letras May/minusculas. e.g. Perez Lopez" required>	
	<?php echo isset($_SESSION['errores']) ? Utils::mostrarError($_SESSION['errores'], 'apellidos') : '' ?>

	<label for="email">Email:</label>
	<input type="email" name="email" id="email" title="xyz@something.com" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+.[a-z]{2,4}$" required > 
	<?php echo isset($_SESSION['errores']) ? Utils::mostrarError($_SESSION['errores'], 'email') : '' ?>

	<label for="password">Contraseña:</label>
	<input type="password" name="password" id ="password" placeholder="Introduce tu contraseña" required >
	<?php echo isset($_SESSION['errores']) ? Utils::mostrarError($_SESSION['errores'], 'password') : '' ?>
	<!--
	<label for="password_register2">Repite tu contraseña:</label>
	<input type="password" name="password_repeat" id ="password_register2" placeholder="Vuelve a introducir tu contraseña" required="">
	-->
	<input type="submit" name="submit_register" value="Registrarse">
	
	<?php 
	// limpiamos errores del form
	$session = 'errores';
	Utils::deleteSession($session)   
	?>		
</form>


