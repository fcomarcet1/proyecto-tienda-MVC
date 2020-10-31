<?php

include_once 'models/Producto.php';

class ProductoController {

	//************ METODO CARGAR VISTA PRODUCTOS DESTACADOS (index) ***********
	//metodo prueba al iniciar proyecto.
	public function index() {
		
		$producto = new Producto();
		$productos = $producto->getRandom(6);
		
		//renderizar vista productos destacados en el indice de productos
		require_once 'views/producto/destacados.php';
	}

	//************ METODO LISTADO PRODUCTOS PARA SU GESTION(Añadir, Borrar, Modificar) ***********
	public function gestion() {

		//validacion de que el usuario es admin
		Utils::isAdmin();

		//instanciamos un nuevo objeto para acceder a sus metodos
		$producto = new Producto();

		// accedemos al metodo getAll() que nos devuelve un objeto con la query de todos los productos
		$productos = $producto->getAll();

		//carga vista de listado de productos y ya puede usar el objeto almacenado en $productos
		require_once 'views/producto/gestion.php';

		return $productos;
	}

	//************ METODO CARGAR FORMULARIO DE INSERCION DE PRODUCTOS ***********
	public function crear() {

		//validacion de que el usuario es admin
		Utils::isAdmin();

		//renderizar vista formulario añadir productos
		require_once 'views/producto/crear.php';
	}

	//************* METODO GUARDAR Nuevo PRODUCTO / EDITAR *************************
	public function save() {

		//validacion de que el usuario es admin
		Utils::isAdmin();

		if (($_SERVER['REQUEST_METHOD'] === 'POST')) {
			
			if ((isset($_POST['submit_producto'])) && isset($_FILES['imagen'])) {

				//var_dump($_POST); die();
				$categoria = isset($_POST['categoria']) ? (int) ($_POST['categoria']) : false;
				$nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : false;
				$descripcion = isset($_POST['descripcion']) ? trim($_POST['descripcion']) : false;
				$precio = isset($_POST['precio']) ? trim($_POST['precio']) : false;
				$stock = isset($_POST['stock']) ? trim($_POST['stock']) : false;
				//$imagen = isset($_FILES['imagen']) ? ($_FILES['imagen']) : false;

				if (isset($_POST['oferta']) && $_POST['oferta'] == 'Yes') {
					$oferta = $_POST['oferta'];
				} 
				else {
					$oferta = 'No';
				}

				$errores = array();

				//var_dump(is_int($categoria)); die();
				//**************VALIDACION DE CAMPOS *****************
				//CATEGORIA
				if (empty($categoria)) {
					$errores['categoria'] = "Por favor selecciona una categoria.";
				}

				//NOMBRE
				if (empty($nombre)) {
					$nombre_validate = false;
					$errores['nombre'] = "El campo nombre no puede estar vacio.";
				} 
				elseif ((!empty($nombre)) && (is_numeric($nombre))) {
					$nombre_validate = false;
					$errores['nombre'] = "Formato de nombre no valido.No puede contener solamente numeros";
				} 
				else {
					$nombre_validate = true;
				}


				//DESCRIPCION
				if (empty($descripcion)) {
					$desc_validate = false;
					$errores['descripcion'] = "El campo descripcion no puede estar vacio.";
				} 
				elseif ((!empty($descripcion)) && (!preg_match("/[A-Za-z0-9]/", $descripcion))) {
					$desc_validate = true;
				}

				//PRECIO
				if (empty($precio)) {
					$precio_validate = false;
					$errores['precio'] = "El campo precio no puede estar vacio.";
				} 
				elseif ((!empty($precio)) && (!is_numeric($precio))) {
					$precio_validate = false;
					$errores['precio'] = "El campo precio no es valido.Introduce un valor numerico";
				} 
				else {
					$precio_validate = true;
				}

				//STOCK
				if (empty($stock)) {
					$stock_validate = false;
					$errores['stock'] = "El campo stock no puede estar vacio.";
				} 
				elseif ((!empty($stock)) && (!is_numeric($stock))) {

					$stock_validate = false;
					$errores['stock'] = "El campo stock no es valido.";
				} 
				else {
					$stock_validate = true;
				}

				//IMAGEN
				// Get image name
				$imagen = $_FILES['imagen']['name'];
				$file = $_FILES['imagen'];
				$mimetype = $file['type'];

				if (empty($_FILES['imagen'])) {
					$errores['imagen'] = 'inserta una imagen';
				}

				if (!empty($file)) {

					if ($mimetype == "image/jpg" || $mimetype == 'image/jpeg' ||
							$mimetype == 'image/png' || $mimetype == 'image/gif') {

						$chk_mime = true;
						//$errores['imagen'] = "Formato OK";
					} 
					else {
						$errores['imagen'] = "Formato no valido";
					}
				}

				if (empty($imagen)) {
					$errores['imagen'] = "Inserta una imagen por favor.";
				}

				//var_dump($errores,); die();

				if (count($errores) == 0) {

					$producto = new Producto();
					$producto->setId_categoria($categoria);
					$producto->setNombre($nombre);
					$producto->setDescripcion($descripcion);
					$producto->setPrecio($precio);
					$producto->setStock($stock);
					$producto->setOferta($oferta);

					//var_dump($producto->getNombre(), $producto->getDescripcion()); die();
					
					// Guardar la imagen
					if (isset($_FILES['imagen'])) {
						
						$file = $_FILES['imagen'];
						$filename = $file['name'];
						$mimetype = $file['type'];

						//comprobamos el formato
						if ($mimetype == "image/jpg" || $mimetype == 'image/jpeg' ||
								$mimetype == 'image/png' || $mimetype == 'image/gif') {

							if (!is_dir('uploads/images')) {
								mkdir('uploads/images', 0777, true);
							}

							$producto->setImagen($filename);
							move_uploaded_file($file['tmp_name'], 'uploads/images/' . $filename);
						}
					}

					// tras guardar la imagen procedemos a guardar los datos
					// en funcion si es editar o guardar ejecutamos un metodo u otro
					
					if ($_GET['idProducto']) {
					
						//editar producto existente
						$idProducto = $_GET['idProducto'];
					
						// No crear una nueva instancia o se setean a null los attr
						//$producto = new Producto();
						
						$producto->setIdProducto($idProducto);
						$save = $producto->editar();
						$chk_edit = true;
						
					} 
					else {
						//añadir nuevo producto
						$save = $producto->save();
						$chk_add = true;
					}

					// validamos que se han ejecutado los metodos correctamente
					if ($save) {
						
						//var_dump(isset($chk_add), isset($chk_edit)); die();
						
						if (isset($chk_add) && $chk_add)  {
							$_SESSION['producto_add'] = "complete ";
						}
						elseif(isset($chk_edit) && $chk_edit){
							$_SESSION['producto_edit'] = "complete ";
						}
						
						if (isset($chk_add) && $chk_add == false)  {
							$_SESSION['producto_add'] = "failed ";
						}
						elseif(isset($chk_edit) && $chk_edit == false){
							$_SESSION['producto_edit'] = "failed ";
						}
						
						header('Location:' . base_url . 'producto/gestion');
					} 
					else {
						$_SESSION['producto_add'] = "failed ";
						header('Location:' . base_url . 'producto/crear');
					}
				} 
				else {
					//existen errores en algun campo del form
					$_SESSION['errores'] = $errores;
					header('Location:' . base_url . 'producto/crear');
				}
			} 
			else {
				//echo " isset($_POST['submit_producto'] ";
				$_SESSION['producto_add'] = "failed";
				header("Location:" . base_url . "producto/crear");
			}
		} 
		else {
			//echo " error REQUEST_METHOD'] === 'POST') ";
			$_SESSION['producto_add'] = "failed ";
			header("Location :" . base_url . "producto/crear");
		}

		//header('Location:' . base_url . 'producto/gestion');
	}

	//*********** METODO ELIMINAR PRODUCTO *************************
	public function eliminar() {

		//validacion de que el usuario es admin
		Utils::isAdmin();

		if (isset($_GET['idProducto'])) {

			$idProducto = $_GET['idProducto'];

			//instanciamos un nuevo objeto producto
			$producto = new Producto();

			//asignamos el id del producto al objeto
			$producto->setIdProducto($idProducto);

			// ejecutamos metodo eliminar()
			$delete = $producto->eliminar();

			// si se ha eliminado OK creamos variables de sesion
			if ($delete) {
				$_SESSION['producto_delete'] = "complete";
			} else {
				$_SESSION['producto_delete'] = "failed";
			}
		} else {
			$_SESSION['producto_delete'] = "failed";
		}


		header('Location:' . base_url . 'producto/gestion');
	}

	//*********** METODO EDITAR PRODUCTO *************************
	public function editar() {

		//validacion de que el usuario es admin
		Utils::isAdmin();

		if (isset($_GET['idProducto'])) {

			//variable para llamar a form de edicion usando el mismos form que para add producto
			$edit = true;

			$idProducto = $_GET['idProducto'];

			//instanciamos un nuevo objeto y seteamos el id para usar el metodo getOne() del modelo
			$producto = new Producto();
			$producto->setIdProducto($idProducto);

			// llamamos al metodo getOne() para obtener dicho registro y poder usarlo en la vista
			// este nos devuelve un return $product->fetch_object() que es un obj totalmente ya utilizable
			$product = $producto->getOne();

			require_once 'views/producto/crear.php';
		} 
		else {
			// error no llega id redirigir 
			header("Location:" . base_url . "producto/gestion");
		}
	}

	public function ver() {
		
		if (isset($_GET['idProducto'])) {
			
			$idProducto = $_GET['idProducto'];
			
			$producto = new Producto();
			$producto->setIdProducto($idProducto);
			$product = $producto->getOne();	
			
		}
		
		require_once 'views/producto/ver.php';
	}
}

// end Class ProductoController