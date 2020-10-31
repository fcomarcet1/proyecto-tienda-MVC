<?php

// cargamos modelo pedido
require_once 'models/Pedido.php';

class PedidoController {

	//********** METODO CARGA VISTA DEL FORM DATOS DEL PEDIDO ***********
	public function realizar() {

		//echo 'Controlador Pedidos, accion index';
		require_once 'views/pedido/realizar.php';
	}

	//************ METODO AÑADIR NUEVO PEDIDO ****************
	public function add() {

		// comprobamos si esta logueado
		$is_logged = Utils::isLogged();

		if ($is_logged) {
			if (($_SERVER['REQUEST_METHOD'] === 'POST') && isset($_POST['submit_pedido'])) {
				//var_dump($_POST);

				$provincia = isset($_POST['provincia']) ? trim($_POST['provincia']) : false;
				$localidad = isset($_POST['localidad']) ? trim($_POST['localidad']) : false;
				$direccion = isset($_POST['direccion']) ? trim($_POST['direccion']) : false;

				$patron_texto = "/^[a-zA-ZáéíóúÁÉÍÓÚäëïöüÄËÏÖÜàèìòùÀÈÌÒÙ\s]+$/";
				$patron_texto2 = "/^[0-9a-zA-ZáéíóúÁÉÍÓÚäëïöüÄËÏÖÜàèìòùÀÈÌÒÙº\s]+$/";
				$errores = array();

				//VALIDACION DE CAMPOS.
				//PROVINCIA.
				if (empty($provincia)) {

					$provincia_validate = false;
					$errores['provincia'] = "El campo provincia no puede estar vacio.";
				} else {
					// Comprobar mediante una expresión regular, que sólo contiene letras y espacios:
					if (preg_match($patron_texto, $provincia)) {

						$provincia_validate = true;
					} else {
						$errores['provincia'] = "El campo provincia sólo puede contener letras y espacios.";
					}
				}

				//Localidad
				if (empty($localidad)) {

					$localidad_validate = false;
					$errores['localidad'] = "El campo localidad no puede estar vacio.";
				} else {
					// Comprobar mediante una expresión regular, que sólo contiene letras y espacios:
					if (preg_match($patron_texto, $localidad)) {

						$localidad_validate = true;
					} else {
						$errores['localidad'] = "El campo localidad sólo puede contener letras y espacios.";
					}
				}

				//Direccion
				if (empty($direccion)) {

					$direccion_validate = false;
					$errores['direccion'] = "El campo direccion no puede estar vacio.";
				} else {
					// Comprobar mediante una expresión regular, que sólo contiene letras y espacios:
					if (preg_match($patron_texto2, $direccion)) {

						$direccion_validate = true;
					} else {
						$errores['direccion'] = "El campo direccion sólo puede contener letras y espacios.";
					}
				}

				//var_dump($errores); die();
				//
				//Validacion de errores
				if (count($errores) == 0) {

					//var_dump($_SESSION['identity']->idUsuario); die;
					$id_usuario = $_SESSION['identity']->idUsuario;

					$stats = Utils::statsCarrito();
					$coste = $stats['total'];

					$pedido = new Pedido();
					$pedido->setId_usuario($id_usuario);
					$pedido->setProvincia($provincia);
					$pedido->setLocalidad($localidad);
					$pedido->setDireccion($direccion);
					$pedido->setCoste($coste);

					// guardar pedido en tabla pedidos
					$save = $pedido->save();


					//guardar linea-pedido 
					$save_linea_pedido = $pedido->save_linea();

					if ($save && $save_linea_pedido) {

						$_SESSION['pedido_add'] = "complete";

						// limpiamos stats carrito para no mostrarlo una vez es OK el pedido
						//Utils::deleteSession($_SESSION['carrito']);

						header("Location:" . base_url . "pedido/confirmado");
					} 
					else {
						$_SESSION['pedido_add'] = "failed";
						// mostrar error en form pedido
						//header("Location:" . base_url . "pedido/realizar");
					}

					// en cualquier caso vamos a redirigir a confirmado y alli mostrar si esta Ok o hay error
					header("Location:" . base_url . "pedido/confirmado");
				} 
				else {
					// existen errores de campo
					$_SESSION['errores'] = $errores;
					header("Location:" . base_url . "pedido/realizar");
				}
			} 
			else {
				// no se recibieron datos del formulario pedido.
				$_SESSION['pedido_add'] = "failed";
				// enviar error a carrito index FALTA
				header("Location:" . base_url . "carrito/index");
			}
		} 
		else {
			// si no esta logueado redirigir al index principal de la tienda
			header("Location:" . base_url);
		}
	}

	//********* METODO CARGA VISTA PEDIDO CONFIRMADO ***********
	public function confirmado() {

		// comprobamos si esta logueado
		Utils::isLogged();

		// necesitamos obtener el id_usuario, el cual lo podemos obtener de la sesion
		$identity = $_SESSION['identity'];
		
		$pedido = new Pedido();
		$pedido->setId_usuario($identity->idUsuario);
		$pedido = $pedido->getOneByCustomer();

		//obtener productos del pedido
		$lista_pedido = new Pedido();

		$idpedido = $pedido->idPedido;
		
		$lista_pedido->setIdPedido($idpedido);

		$productos = $lista_pedido->getProductsBypedido(); // devuelve un array 
//		$nameSession = "carrito";
//		Utils::deleteSession($nameSession);
		//var_dump($productos); die();
		require_once 'views/pedido/confirmado.php';
	}

	//********** METODO VER MIS PEDIDOS ******************
	public function mis_pedidos() {

		// comprobamos si esta logueado
		$is_logged = Utils::isLogged();

		$id_usuario = $_SESSION['identity']->idUsuario;

		//obtener pedidos del usuario
		$pedidos = new Pedido();
		$pedidos->setId_usuario($id_usuario);

		$mis_pedidos = $pedidos->getAllByCustomer();

		//var_dump($mis_pedidos); die();

		require_once 'views/pedido/mis_pedidos.php';
	}

	//*********** METODO VER DETALLE PEDIDO *********
	public function detalle() {

		// comprobamos si esta logueado
		$is_logged = Utils::isLogged();

		if (isset($_GET['idPedido'])) {
			
			$idPedido = $_GET['idPedido'];
			$idUsuario = $_SESSION['identity']->idUsuario;
			
			//Obtener datos del pedido (idUsuario)
			$pedido = new Pedido();
			$pedido->setIdPedido($idPedido);
			$pedido = $pedido->getOne();

			//obtener productos del pedido (idPedido)
			$lista_pedido = new Pedido();
			$lista_pedido->setIdPedido($idPedido);
			
			$productos = $lista_pedido->getProductsBypedido(); // devuelve un array 
			
		} else {
			header("Location:" . base_url . "pedido/mis_pedidos");
		}

		require_once 'views/pedido/detalle.php';
	}

	public function estado(){
		
		Utils::isAdmin();
		
		if(isset($_POST['idPedido']) && isset($_POST['estado'])){
			// Recoger datos form
			$idpedido = $_POST['idPedido'];
			$estado = $_POST['estado'];
			
			// Upadate del pedido
			$pedido = new Pedido();
			$pedido->setIdPedido($idpedido);
			$pedido->setEstado($estado);
			$pedido->editar();
			
			header("Location:".base_url.'pedido/detalle&idPedido='.$idpedido);
		}
		else{
			header("Location:".base_url);
		}
	}
	
	
		//*********** METODO GESTIONAR PEDIDOS *************
	public function gestion() {
		
		// acceso solo para administradores
		Utils::isAdmin();
		
		$gestion = true;
		
		//obtener pedidos del usuario
		$pedidos = new Pedido();
		$mis_pedidos = $pedidos->getAll();
		
		require_once 'views/pedido/mis_pedidos.php';
	}
}
