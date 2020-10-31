<?php

class Categoria{
	
	private $idCategoria;
	private $nombre;
	private $db;
	
	public function __construct() {
		$this->db = Database::Connect();
	}

	//********** GETTERS & SETTERS *************
	public function getIdCategoria() {
		return $this->idCategoria;
	}

	public function getNombre() {
		return $this->nombre;
	}

	public function setIdCategoria($idCategoria) {
		$this->idCategoria = $idCategoria;
	}

	public function setNombre($nombre) {
		$this->nombre = $this->db->real_escape_string($nombre);
	}
	
	//********** METODO OBTENER TODAS LAS CATEGORIAS ************
	public function getAll() {
		
		/* 
		 * Si se ha de recuperar una gran cantidad de datos se emplea MYSQLI_USE_RESULT 
		 * Por defecto, se usa la constante MYSQLI_STORE_RESULT.
		 * Si se usa MYSQLI_USE_RESULT todas la llamadas posteriores retornarán con un 
		 * error Commands out of sync a menos que se llame a mysqli_free_result() [$this->db->free();]
		 * 	 
		 */
		
		$sql = "SELECT * FROM categorias ORDER BY idCategoria";
		$categorias = $this->db->query($sql);
		
		// devolvemos un objeto con los valores de la query
		
		//$categorias->close(); si liberamos los valores no los tenemos en el controller ni en la view
		$this->db->close();
		
		return $categorias;		
		
	}
	
	//********** METODO OBTENER CATEGORIA ************
	public function getOne() {
		
		$sql = " SELECT * FROM categorias WHERE idCategoria = {$this->getIdCategoria()} ";
		$categoria = $this->db->query($sql);
		
		$chk_query = false;
		
		if ($categoria) {
			$chk_query = true;
		}
		
		if($chk_query){
			
			$this->db->close();
			// devolvemos la fila deseada en un obj
			return $categoria->fetch_object();
		}
		else{
			return false;
		}
		
	}
	
	//********** METODO GUARDAR NUEVAS CATEGORIAS ************
	public function save() {
		
		$sql = "INSERT INTO categorias VALUES(null,'{$this->getNombre()}')";
		$save = $this->db->query($sql);
		
		//validamos la query
		$result = false;
		
		if ($save) {
			$result = true;
		}
		
		$this->db->close();
		
		return $result;
	}
	
	
	
}// end class Categoria

