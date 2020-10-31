<?php

//include_once 'config/db.php';

class Producto {
	
	private $idProducto;
	private $id_categoria;
	private $nombre;
	private $descripcion;
	private $precio;
	private $stock;
	private $oferta;
	private $imagen;

	private $db;
	
	public function __construct() {
		$this->db = Database::Connect();
	}

	//****** GETTERS & SETTERS *****************
	public function getIdProducto() {
		return $this->idProducto;
	}

	public function getId_categoria() {
		return $this->id_categoria;
	}

	public function getNombre() {
		return $this->nombre;
	}

	public function getDescripcion() {
		return $this->descripcion;
	}

	public function getPrecio() {
		return $this->precio;
	}

	public function getStock() {
		return $this->stock;
	}

	public function getOferta() {
		return $this->oferta;
	}

	public function getImagen() {
		return $this->imagen;
	}

	public function setIdProducto($idProducto) {
		$this->idProducto = $idProducto;
		return $this;
	}

	public function setId_categoria($id_categoria) {
		$this->id_categoria = $id_categoria;
		return $this;
	}

	public function setNombre($nombre) {
		$this->nombre = $this->db->real_escape_string($nombre);
		return $this;
	}

	public function setDescripcion($descripcion) {
		$this->descripcion = $this->db->real_escape_string($descripcion);
		return $this;
	}

	public function setPrecio($precio) {
		$this->precio = $this->db->real_escape_string($precio);
		return $this;
	}

	public function setStock($stock) {
		$this->stock = $this->db->real_escape_string($stock);
		return $this;
	}

	public function setOferta($oferta) {
		$this->oferta = $oferta;
		return $this;
	}

	public function setImagen($imagen) {
		$this->imagen = $imagen;
		return $this;
	}

	
	//******** METODOS ACCESO DB ********************
	//************* METODO OBTENER TODOS LOS PRODUCTOS ****************
	public function getAll() {
		
		$sql = " SELECT p.idProducto, p.id_categoria, p.nombre,p.descripcion, p.precio, 
						p.stock, p.oferta, p.imagen, (c.nombre) AS categoria 
						FROM productos p 
						INNER JOIN categorias c 
						ON p.id_categoria = c.idCategoria ";
		
		$productos = $this->db->query($sql);
		
		$chk_query = false;
		
		if ($productos) {
			$chk_query = true;
		}
		
		if($chk_query){
			
			$this->db->close();
			return $productos;
		}
		else{
			return false;
		}
		
	}
	
	//******** METODO OBTENER TODOS LOS PRODUCTOS DE UNA DETERMINADA CATEGORIA
	public function getAllByCategory() {
		
		$sql = " SELECT p.idProducto, p.id_categoria, p.nombre,p.descripcion, p.precio, 
						p.stock, p.oferta, p.imagen, (c.nombre) AS categoria 
						FROM productos p 
						INNER JOIN categorias c 
						ON p.id_categoria = c.idCategoria 
						WHERE p.id_categoria = {$this->getId_categoria()} ";
		
		$productos = $this->db->query($sql);
		
		$chk_query = false;
		
		if ($productos) {
			$chk_query = true;
		}
		
		if($chk_query){
			
			$this->db->close();
			return $productos;
		}
		else{
			return false;
		}
	}
	
	//**************** METODO OBTENER UN PRODUCTO DETERMINADO (idProducto) *****************
	public function getOne() {
		
		$sql = " SELECT * FROM productos WHERE idProducto = {$this->getIdProducto()} ";
		
		$producto = $this->db->query($sql);
		
		$chk_query = false;
		
		if ($producto) {
			$chk_query = true;
		}
		
		if($chk_query){
			
			$this->db->close();
			// devolvemos la fila deseada en un obj
			return $producto->fetch_object();
		}
		else{
			return false;
		}
		
	}
	
	//*************** METODO OBTENER LISTA PRODUCTOS RANDOM PARA PAG PRINCIPAL *******
	public function getRandom($limit) {
		
		$sql = "SELECT * FROM productos ORDER BY RAND() LIMIT $limit; ";
		$productos = $this->db->query($sql);
		
		$chk_query = false;
		
		if ($productos) {
			$chk_query = true;
		}
		
		if($chk_query){
			
			$this->db->close();
			return $productos;
		}
		else{
			return false;
		}
		
		
	}
	
	//***************** METODO ALMACENAR NUEVO PRODUCTO ***************
	public function save() {
		
		$sql = "INSERT INTO productos (id_categoria, nombre, descripcion, precio, stock, oferta, imagen) "
			. "VALUES ({$this->getId_categoria()}, '{$this->getNombre()}','{$this->getDescripcion()}','{$this->getPrecio()}','{$this->getStock()}','{$this->getOferta()}', '{$this->getImagen()}' ) ";
					 
		$save = $this->db->query($sql);
		
		//var_dump($this->db->error); die();
		
		$result = false;
		
		if ($save) {
			$result = true;
		}
		
		//var_dump($result);die();
		
		$this->db->close();
		return $result;
					 
	}
	
	//*********** METODO ELIMINAR PRODUCTO *************************
	public function eliminar() {
		
		$sql = "DELETE FROM productos WHERE idProducto = {$this->idProducto} ";
		$delete = $this->db->query($sql);
		//var_dump($this->db->error); die();
		
		$result = false;
		
		if ($delete) {
			$result = true;
		}
	
		// liberamos recursos memoria
		$this->db->close();
		
		//var_dump($result); die();
		return $result;
	}
	
	//*********** METODO EDITAR PRODUCTO *************************
	public function editar() {
		
		$sql = "UPDATE productos SET nombre='{$this->getNombre()}', descripcion='{$this->getDescripcion()}', precio={$this->getPrecio()}, stock={$this->getStock()}, id_categoria={$this->getId_categoria()}";
		
		//comprobamos que la imagen no llega vacia 
		if($this->getImagen() != null){
			$sql .= ", imagen='{$this->getImagen()}' ";
		}
		
		$sql .= "WHERE idProducto={$this->idProducto};"; //$sql .= "WHERE idProducto = {$this->getIdProducto()} "; similar
	
		//ejecutamos la query
		$save = $this->db->query($sql);
		
		//var_dump($this->db->error); die();
		
		$result = false;
		if ($save) {
			$result = true;
		}
		
		//var_dump($result);die();
		
		$this->db->close();
		return $result;
		
	}
	
}// end class Producto
