<?php

class Utils {

	//*******ELIMINA SESIONES DE REGISTRO Y MENSAJES DE ERROR/OK.********
	public static function deleteSession($nameSession) {

		$chk_deleteSession = null;
		if (isset($_SESSION[$nameSession])) {

			$_SESSION[$nameSession] = null;
			unset($_SESSION[$nameSession]);

			$chk_deleteSession = true;
		} 
		else {
			$chk_deleteSession = false;
		}

		return $chk_deleteSession;
	}

	//************MUESTRA PAGINA ERROR 404**************************
	public static function pageError404() {
		$error = new ErrorController();
		$error->error404();
	}

	//****************MOSTRAR ERRORES CAMPOS FORMULARIO ***************
	public static function mostrarError($errores, $campo) {
		$alerta = "";
		if ((isset($errores[$campo])) && (!empty($campo))) {
			$alerta = "<div class='alert_red'>" . $errores[$campo] . '</div>';
		}
		return $alerta;
	}

	//************** COMPROBAR SI EL USUARIO ES ADMIN *****************
	public static function isAdmin() {

		if (!isset($_SESSION['admin'])) {
			header("Location:" . base_url);
			exit();
		} 
		else {
			return true;
		}
	}

	//******************** COMPROBAR SI EL USUARIO ESTA LOGUEADO *******************
	public static function isLogged() {

		if (!isset($_SESSION['identity'])) {
			header("Location:" . base_url);
			exit();
		} 
		else {
			return true;
		}
	}

	//************** OBTENER TODAS LA CATEGORIAS
	//(para usar en While por ej $a = Utils::showCatrgorias()-> while *****************
	public static function showCategorias() {

		//cargamos modelo categorias
		include_once 'models/Categoria.php';

		$categoria = new Categoria();
		$categorias = $categoria->getAll();

		return $categorias;
	}

	//************** OBTENER TODOS LOS PRODUCTOS *****************
	public static function showProductos() {

		//cargamos modelo categorias
		include_once 'models/Producto.php';

		$producto = new Producto();
		$productos = $producto->getAll();

		return $productos;
	}

	//************* MOSTRAR ESTADISTICAS CARRITO EN SIDEBAR ***************
	public static function statsCarrito() {
		
		//comprobamos vamos a crear un array $stats en el caso de existir $_SESSION['carrito']
		// le vamos a asignar a los indices los valores deseados como el nº d productos y el total
		//inicializar array $stats
		
		$stats = array(
			'count' => 0,
			'total' => 0
		);

		if (isset($_SESSION['carrito'])) {

			foreach ($_SESSION['carrito'] as $producto) {
				// insertamos en el array el total
				// NOTA si usamos sol el = cuenta solo el ultimo elemento usamos +=
				//precio total
				$stats['total'] += $producto['precio'] * $producto['unidades'];
				//nº unidades total
				$stats['count'] += $producto['unidades'];
			}

			return $stats;
		}
	}

	public static function showEstado($estado) {

		if ($estado == "Confirm") {
			$status = "Pendiente";
		} 
		elseif ($estado == "Preparation") {
			$status = "En preparacion";
		} 
		elseif ($estado == "Ready") {
			$status = "Preparado para envio";
		} 
		elseif ($estado == "Sended") {
			$status = "Enviado";
		} 
		elseif ($estado == "Cancelled") {
			$status = "Cancelado";
		}

		return $status;
	}

}

//end class Utils
