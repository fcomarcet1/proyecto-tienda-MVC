<?php
//cargamos BD
//include_once '../config/db.php'; // con cargarla en el index.php ya sobraria

class Usuario {

	//establecemos propiedades o atributos.
	private $idUsuario;
	private $nombre;
	private $apellidos;
	private $email;
	private $password;
	private $role;
	private $image;
	private $db; 

	public function __construct() {
		$this->db = Database::Connect();
	}

	//metodos getter & setter.
	public function getId() {
		return $this->id;
	}

	public function getNombre() {
		return $this->nombre;
	}

	public function getApellidos() {
		return $this->apellidos;
	}

	public function getEmail() {
		return $this->email;
	}

	public function getPassword() {
		return $this->password;
	}

	public function getRol() {
		return $this->rol;
	}

	public function getImagen() {
		return $this->imagen;
	}

	public function setId($id) {
		$this->id = $id;
	}

	public function setNombre($nombre) {
		$this->nombre = $this->db->real_escape_string($nombre);
	}

	public function setApellidos($apellidos) {
		$this->apellidos = $this->db->real_escape_string($apellidos);
	}

	public function setEmail($email) {
		$this->email = $this->db->real_escape_string($email);
	}

	public function setPassword($password) {
		$this->password = password_hash($this->db->real_escape_string($password), PASSWORD_BCRYPT, ['cost' => 4]);
	}

	public function setRol($rol) {
		$this->rol = $rol;
	}

	public function setImagen($imagen) {
		$this->imagen = $imagen;
	}

	
	//metodos que consulten datos de la BD en base a los datos del objeto
	//NOTA simepre acceder con $this-> a los attr de la clase desde ella misma
	
	// *********METODO REGISTRO DE USUARIO**************************
	public function save() {

		// usamos el metodo get de la clase para obtener los 
		$sql = "INSERT INTO usuarios (idusuario,nombre, apellidos, email, password, imagen, rol) "
				. "VALUES ("
							. " null,"
							. "'{$this->getNombre()}', "
							. "'{$this->getApellidos()}', "
							. "'{$this->getEmail()}', "
							. "'{$this->getPassword()}', "
							. "'null', "
							. "'user' "
						. ")";

		$save = $this->db->query($sql);
		//var_dump($this->db->error);
		$result = false;

		if ($save) {
			$result = true;
		}
		return $result;
		
	}// end function save()
	
	
	// *********METODO LOGIN DE USUARIO**************************
	public function login($email, $password) {
		
		//comprobar que existe el usuario
		$result = false;
		
		$sql = "SELECT * FROM usuarios WHERE email = '$email' ";
		$login = $this->db->query($sql);
		
		if ( ($login) && ($login->num_rows == 1) ) {
			
			//obtenemos los datos de la consulta en un objeto para asi poder tomar los valores en la $_SESSIOM
			$usuario = $login->fetch_object();
			
			//verificamos contraseña entre el password que se recibe desde el controller $password y el 
			// de la BD $usuario->passwd obtenido de la query efectuada antes 
			$verify = password_verify($password, $usuario->password);
			
			
			if ($verify) {
				// si se cumple vamos a devolver el objeto del usuario obtenido de la consulta.
				$result = $usuario;
			}
			else{
				
				echo 'Password incorrecto';
				$_SESSION['error_login']= "Contraseña incorrecta";
				
			}	
		}
		else{
			//echo 'Email incorrecto';
			$_SESSION['error_login']= "Email incorrecto";
			$result = false;
		}
		
		$login->close();
		$this->db->close();
		
		
		return $result;
	} //end function login()
	
	
//	 public function __destruct() {
//		 unset($this);
//		 
//	 }
	
}// end class usuario
