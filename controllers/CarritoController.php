<?php
// Cargamos modelo Producto para poder usar sus metodos
require_once 'models/Producto.php';


class CarritoController {
	
	//************ METODO MOSTRAR CARRITO(listado productos antes de finalizar la compra) **********
	public function index() {
		//echo "Controlador Carrito accion index";

		//comprobamos que  $_SESSION['carrito'] existe y no esta vacia
		//var_dump($_SESSION['carrito']);
		if (isset($_SESSION['carrito']) && sizeof($_SESSION['carrito']) >= 1) {
			
			$carrito = $_SESSION['carrito'];
		}
		else{
			
			$carrito = array();
			
		}
		
		// ya tenemos disponible la var $carrito para recorrerla en la vista
		require_once 'views/carrito/index.php';
		
	}
	
	//*************** METODO AÑADIR ELEMENTO AL CARRITO ***********
	public function add() {
		
		// validar que que llega idProducto por $_GET
		if (isset($_GET['idProducto'])) {
			
			
			$idProducto = $_GET['idProducto'];
			
		}
		else{
			header("Location:".base_url);
		}
		
		
		/*
		 * Vamos a evaluar las 2 opciones:
		 * 
		 *	1) EXISTE $_SESSION['carrito'] .
		 *		- Si existe vamos a recorrer con un foreach $_SESSION['carrito'] y en el caso que el producto
		 *		  ya exista incrementamos las unidades en 1, y por tanto $counter sera != 0.
		 * 
		 *  2) NO EXISTE $_SESSION['carrito'] o lo que es lo mismo !isset($counter) OR $counter = 0,
		 *		- crearemos el objeto y se lo pasamos en forma de array a la session
 		 */
		
		// EXISTE $_SESSION['carrito'] 
		if (isset($_SESSION['carrito'])) {
			
			$counter = 0;
			// recorremos el carrito
			foreach ($_SESSION['carrito'] as $indice => $elemento) {
				
				// comprobamos si el producto ya esta en el carrito
				if ($elemento['idProducto'] == $idProducto) {
					// incrementamos en 1 las unidades
					$_SESSION['carrito'][$indice]['unidades'] ++;
					$counter ++;
				}
			}
			
			
		}
		// NO EXISTE $_SESSION['carrito']
		if(!isset($counter) || $counter == 0){
			
		
			// conseguir producto
			$product = new Producto();
			$product->setIdProducto($idProducto);
			$producto = $product->getOne();
			
			//var_dump($producto); die();
			
			//añadir al carrito
			if (isset($producto) && is_object($producto)) {
				
				// añadimos a la sesion los datos del producto en un array, ademas del producto entero
				// por si es necesario obtener algun dato de el.
				$_SESSION['carrito'][] = array(

										"idProducto" => $producto->idProducto,
										"precio" => $producto->precio,
										"unidades" => 1,
										"producto" => $producto
									);
			}
		}
		
		//var_dump($_SESSION['carrito']); die();
		header("Location:".base_url."carrito/index");
		
	}
	
	//*************** (+) ELEMENTO AL CARRITO ***********************
	public function up() {
		
		if (isset($_GET['index'])) {
			
			$index = $_GET['index'];
			$_SESSION['carrito'][$index]['unidades']++ ;
		}
		
		header("Location:".base_url."carrito/index");
		
	}
	
	//*************** (-) ELEMENTO AL CARRITO ***********************
	public function down() {
		
		if (isset($_GET['index']) ) {
			
			$index = $_GET['index'];
			$num_items = $_SESSION['carrito'][$index]['unidades'];
			
			// validamos que no puedan ser valores 0 o negativos.
			if ($num_items <= 1) {
				
				$num_items = $_SESSION['carrito'][$index]['unidades'] = 1;
				//header("Location:".base_url."carrito/index");
			}
			else{
				$_SESSION['carrito'][$index]['unidades']-- ;
				//header("Location:".base_url."carrito/index");
			}			
		}
			
		header("Location:".base_url."carrito/index");
	}
	
	//************ METODO ELIMINAR UN ELEMENTO DEL CARRITO **********
	public function delete() {
		if (isset($_GET['index'])) {
			
			$indice = $_GET['index'];
			unset($_SESSION['carrito'][$indice]);
		}
		header("Location:".base_url."carrito/index");
	}
	
	//************* METODO ELIMINAR CARRITO ENTERO **********
	public function deleteAll() {
		
		if (isset($_SESSION['carrito'])) {	
			unset($_SESSION['carrito']);
		}
		
		header("Location:".base_url."carrito/index");
	}
	
	public function cleanCarrito() {
		
		if (isset($_SESSION['carrito'])) {	
			
			unset($_SESSION['carrito']);
			//var_dump($_SESSION); die();
			
		}
		header("Location:".base_url);
		
	}

	
}
