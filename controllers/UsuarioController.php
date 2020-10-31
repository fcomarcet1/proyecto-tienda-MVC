<?php

require_once 'models/Usuario.php';

class UsuarioController {

	//metodo prueba
	public function index() {
		echo 'Controlador Usuarios, accion index';
	}
	
	
	
	//******** METODO PARA CARGAR VISTA USUARIO/REGISTRO ->Form añadir nuevo usuario *******
	public function registro() {
		//cargamos vista formulario registro
		require_once 'views/usuario/registro.php';
	}

	
	
	//*************METODO GUARDAR USUARIO REGISTRADO*************************
	public function save() {

		//logica del registro 
		if (($_SERVER['REQUEST_METHOD'] === 'POST') && (isset($_POST['submit_register']))) {
			//var_dump($_POST);

			$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : false;
			$apellidos = isset($_POST['apellidos']) ? $_POST['apellidos'] : false;
			$email = isset($_POST['email']) ? $_POST['email'] : false;
			$password = isset($_POST['password']) ? $_POST['password'] : false;
//			$password_repeat = isset($_POST['password_repeat']) ? $_POST['password'] : false;
			$errores = array();

			// Validacion de campos
			// //PROVINCIA. MUY BUEnA OPCION
//				$patron_texto = "/^[a-zA-ZáéíóúÁÉÍÓÚäëïöüÄËÏÖÜàèìòùÀÈÌÒÙ\s]+$/";
//				if (empty($provincia)) {
//					
//					$provincia_validate = false;
//					$errores['provincia'] = "El campo provincia no puede estar vacio.";
//				} 
//				else{
//					// Comprobar mediante una expresión regular, que sólo contiene letras y espacios:
//					 if( preg_match($patron_texto, $provincia) ){
//						 
//							$provincia_validate = true;
//					 }	
//					 else{
//						 $errores['provincia'] = "El campo provincia sólo puede contener letras y espacios.";
//						 
//					 }
//				}
			// 
			// 
			//NOMBRE
			if (empty($nombre)) {
				$nombre_validate = false;
				$errores['nombre'] = "El campo nombre no puede estar vacio.";
			} elseif ((!empty($nombre)) && (!is_numeric($nombre)) && (!preg_match("/[0-9]/", $nombre))) {
				$nombre_validate = true;
			} else {
				$nombre_validate = false;
				$errores['nombre'] = "El campo nombre no es valido.";
			}

			//APELLIDOS
			if (empty($apellidos)) {

				$apellidos_validate = false;
				$errores['apellidos'] = "El campo apellidos no puede estar vacio.";
			} elseif ((!empty($apellidos)) && (!is_numeric($apellidos)) && (!preg_match("/[0-9]/", $apellidos))) {

				$apellidos_validate = true;
			} else {

				$apellidos_validate = false;
				$errores['apellidos'] = "El campo apellidos no es valido.";
			}

			//EMAIL
			if (empty($email)) {

				$email_validate = false;
				$errores['email'] = "El campo email vacio";
				//echo 'email vacio ERROR,'. '<br/>';
			}

			if ((!empty($email)) && (filter_var($email, FILTER_VALIDATE_EMAIL))) {

				$email_validate = true;
				//echo 'email OK'. '<br/>';
			} else {

				echo 'email ERROR,';
				$email_validate = false;
				$errores['email'] = "Introduce un email valido por favor.";
				//echo 'email con formato incorrectos ERROR,'. '<br/>';
				//var_dump($errores);
			}


			//PASSWORD
			if (empty($password)) {

				$password_validate = false;
				$errores['password'] = "El campo contraseña esta vacio";
				//echo 'passwd vacio ERROR'. '<br/>';
			} elseif (strlen($password) < 4) {

				$password_validate = false;
				$errores['password'] = "La contraseña debe contener como minimo 4 caracteres";
				//echo 'passwd vacio ERROR'. '<br/>';
			} else {
				$password_validate = true;
				//echo 'passwd OK'. '<br/>';
			}

			//Validacion de errores 
			if (count($errores) == 0) {

				//validamos que las variables no llegan en false

				$usuario = new Usuario();
				$usuario->setNombre($nombre);
				$usuario->setApellidos($apellidos);
				$usuario->setEmail($email);
				$usuario->setPassword($password); //seteado password con hash metodo del modelo
				//var_dump($usuario);
				//llamamos al metodo save() para realizar el insert
				$save = $usuario->save();

				//CREACION DE SESIONES
				if ($save) {
					$_SESSION['register'] = "complete";
				} else {
					$_SESSION['register'] = "failed";
				}
			}// end if errores == 0
			else { //si existen errores creamos la variable de sesion con los valores del array de errores
				$_SESSION['errores'] = $errores;
				header("Location:" . base_url . "usuario/registro");
			}
		}// end if ($_SERVER['REQUEST_METHOD'] === 'POST') && (isset($_POST['submit_register'] )
		else {
			$_SESSION['register'] = "failed";
		}

		header("Location:" . base_url . "usuario/registro");
		
	}//end public function save()
	
	

	//******** METODO PARA LOGIN DE USUARIO *******
	public function login() {

		if (($_SERVER['REQUEST_METHOD'] === 'POST') && (isset($_POST['submit_login']))) {
			if (isset($_POST['email']) && (isset($_POST['password']))) {

				$email = isset($_POST['email']) ? trim($_POST['email']) : false;
				$password = isset($_POST['password']) ? $_POST['password'] : false;

				$errores = array();

				// borramos el error antiguo de array $_SESSION['error_login']
				if (isset($_SESSION['error_login'])) {
					unset($_SESSION['error_login']);
				}

				// VALIDACION CAMPOS
				if (empty($email)) {
					$email_validate = false;
					$errores['email'] = " El campo email vacio";
				}

				$chk_email = filter_var($email, FILTER_VALIDATE_EMAIL);

				if (!empty($email) && $chk_email = false) {
					$errores['email'] = " Formato de email no valido";
				}

				//PASSWORD
				if (empty($password)) {
					$password_validate = false;
					$errores['password'] = "El campo contraseña esta vacio";
					//echo 'passwd vacio ERROR'. '<br/>';
				} else {
					$password_validate = true;
					//echo 'passwd OK'. '<br/>';
				}

				//var_dump($errores);die();

				if (count($errores) == 0) {

					$usuario = new Usuario();
					$identity = $usuario->login($email, $password);

					//una vez ejecutado el metodo login() este nos devuelve un objeto 
					// con los datos del user identificado.
					// validamos que $identity es un objeto y creamos las variables de sesion
					if (isset($identity) && is_object($identity)) {

						// le pasamos a la var $_SESSION el objeto 
						$_SESSION['identity'] = $identity;
						//var_dump($identity);die();
						//creampos otra var de sesion si tiene rol admin
						if ($_SESSION['identity']->rol == 'admin') {

							//$_SESSION['admin'] = true;
							$_SESSION['admin'] = 'admin';
						}
					} else {
						// error al crear var $_SESSION
						$_SESSION['error_login'] = 'Login fallido, por favor vuelve a intentarlo';
					}
				} else {
					//si existen errores creamos la variable de sesion con los valores del array de errores
					$_SESSION['errores'] = $errores;
				}
			} else {
				$_SESSION['error_login'] = 'Login fallido, por favor vuelve a intentarlo';
			}
		}//end $_SERVER['REQUEST_METHOD'] === 'POST') && (isset($_POST['submit_register']

		header('Location:' . base_url);
		
		
	}// end function login()
	
	
	
	//******** METODO PARA LOGOUT DE USUARIO *******
	public function logout() {

		if (isset($_SESSION['identity'])) {
			unset($_SESSION['identity']);
		}

		if (isset($_SESSION['admin'])) {
			unset($_SESSION['admin']);
		}

		header("Location: " . base_url);
		
		
	} // end function logout()
	
	
	
}// end class UsuarioController
