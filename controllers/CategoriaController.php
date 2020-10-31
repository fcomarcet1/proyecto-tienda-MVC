<?php

// Cargamos el modelo de categorias, y el de productos lo hemos cargado para el metodo ver(), 
// //el cual usamos para  al pulsar en el menu ver la categoria y sus productos asociados
include_once 'models/Categoria.php';
include_once 'models/Producto.php';

class CategoriaController {

	//******** METODO PARA CARGAR VISTA CATEGORIA/INDEX -> Listado de categorias *******
	public function index() {

		//echo 'Controlador Categorias, accion index';
		//validamos que es admin el usuario
		Utils::isAdmin();

		// creamos un nuevo objeto para acceder a sus metodos
		$categoria = new Categoria();

		// ejecutamos el metodo getAll() para obtener todos los registros
		$categorias = $categoria->getAll();

		//cargamos la vista en la cual ya tendremos diponible el objeto $categoria en la vista para poder
		// recorrerlo y obtener su attrs
		require_once 'views/categoria/index.php';

		return $categorias;
	}

	//******** METODO PARA CARGAR VISTA CATEGORIA/CREAR ->Form añadir nueva categoria *******
	public function crear() {

		//validamos que es admin el usuario
		Utils::isAdmin();

		//cargamos vista con form para añadir categoria
		require_once 'views/categoria/crear.php';
	}

	//******** METODO PARA CARGAR VISTA CATEGORIA/CREAR ->Form añadir nueva categoria *******
	public function save() {


		//validamos que es admin el usuario
		Utils::isAdmin();

		if (($_SERVER['REQUEST_METHOD'] === 'POST')) {
			if ((isset($_POST['submit_categorias'])) && (isset($_POST['nombre']))) {
				//var_dump($_POST, $_SESSION);
				//die();

				$nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : false;
				$errores = array();

				//validacion campo nombre
				if (empty($nombre)) {
					$nombre_validate = false;
					$errores['nombre'] = "El campo nombre no puede estar vacio.";
				}

				if (count($errores) == 0) {

					// instanciamos la clase para acceder a su metodo save()
					$categoria = new Categoria();
					$categoria->setNombre($nombre);

					//llamamos al metodo para realizar el insert
					$save = $categoria->save();

					if ($save) {
						//creamos var session
						$_SESSION['category_add'] = "complete";
						header("Location:" . base_url . "categoria/index");
					} 
					else {
						$_SESSION['category_add'] = "failed";
						header("Location:" . base_url . "categoria/crear");
					}
				} 
				else {
					//errores de campo
					$_SESSION['errores'] = $errores;
					header("Location:" . base_url . "categoria/crear");
				}
			} 
			else {
				$_SESSION['category_add'] = "failed";
				header("Location:" . base_url . "categoria/crear");
			}
		} 
		else {
			$_SESSION['category_add'] = "failed";
			header("Location:" . base_url . "categoria/crear");
			//no 'REQUEST_METHOD'] === 'POST
		}
		
		//header("Location:" . base_url . "categoria/crear");
	}
	
	//********** METODO VER CATEGORIA AL PULSAR MENU
	public function ver() {
		
		if (isset($_GET['idCategoria'])) {
			
			//var_dump($_GET);
			$idCategoria = $_GET['idCategoria'];
			
			// Obtener categoria
			$categorias = new Categoria();
			$categorias->setIdCategoria($idCategoria);
			$categoria = $categorias->getOne();
			
			//Obtener listado de productos de dicha categoria
			$producto = new Producto();
			$producto->setId_categoria($idCategoria);
			$productos = $producto->getAllByCategory();
				
			
		}
		
		require_once 'views/categoria/ver.php';
	}
	
	
	//********** METODO EDITAR CATEGORIA **************
	public function editar() {
		//validacion de que el usuario es admin
		Utils::isAdmin();

		//renderizar vista formulario añadir productos
		require_once 'views/categoria/editar.php';
	}
	
	//********** METODO ELIMINAR CATEGORIA **************
	public function eliminar() {
		
	}
	
	
}// end class categoriaController