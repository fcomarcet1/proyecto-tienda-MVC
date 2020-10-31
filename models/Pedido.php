<?php

//include_once 'config/db.php';

class Pedido {
	
	private $idPedido;
	private $id_usuario;
	private $localidad;
	private $provincia;
	private $direccion;
	private $coste;
	private $estado;
	private $fecha_reg;

	private $db;
	
	
	public function __construct() {
		$this->db = Database::Connect();
	}

	//****** GETTERS & SETTERS *****************
	public function getIdPedido() {
		return $this->idPedido;
	}

	public function getId_usuario() {
		return $this->id_usuario;
	}

	public function getLocalidad() {
		return $this->localidad;
	}

	public function getProvincia() {
		return $this->provincia;
	}

	public function getDireccion() {
		return $this->direccion;
	}

	public function getCoste() {
		return $this->coste;
	}

	public function getEstado() {
		return $this->estado;
	}

	public function getFecha_reg() {
		return $this->fecha_reg;
	}

	public function setIdPedido($idPedido) {
		$this->idPedido = $idPedido;
		return $this;
	}

	public function setId_usuario($id_usuario) {
		$this->id_usuario = $id_usuario;
		return $this;
	}

	public function setLocalidad($localidad) {
		$this->localidad = $this->db->real_escape_string($localidad);
		return $this;
	}

	public function setProvincia($provincia) {
		$this->provincia =$this->db->real_escape_string( $provincia);
		return $this;
	}

	public function setDireccion($direccion) {
		$this->direccion =$this->db->real_escape_string( $direccion);
		return $this;
	}

	public function setCoste($coste) {
		$this->coste = $coste;
		return $this;
	}

	public function setEstado($estado) {
		$this->estado = $estado;
		return $this;
	}

	public function setFecha_reg($fecha_reg) {
		$this->fecha_reg = $fecha_reg;
		return $this;
	}

	
	
	//******** METODOS ACCESO DB ********************
	//************* METODO OBTENER TODOS  LOS PEDIDOS ****************
	public function getAll() {
		
		$sql = "SELECT * FROM pedidos ORDER BY idPedido DESC";
		
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
	
	
	//******** METODO OBTENER TODOS LOS PEDIDOS DE UN DETERMINADO CLIENTE
	public function getAllByCustomer() {
		
		$sql = "SELECT * FROM pedidos "
			 . "WHERE id_usuario = {$this->getId_usuario()} "
			 . "ORDER BY idPedido DESC";
		
		$pedidos = $this->db->query($sql);
		

		
		$chk_query = false;
		
		if ($pedidos) {
			$chk_query = true;
		}
		
		if($chk_query){
			
			$this->db->close();
			return $pedidos;
		}
		else{
			return false;
		}
		
		
	}
	
	
	//**************** METODO OBTENER UN PEDIDO DETERMINADO (id_user) *****************
	public function getOne(){
		
		$sql = "SELECT * FROM pedidos WHERE idPedido = {$this->getIdPedido()}";
		$producto = $this->db->query($sql);
		
		//print_r($producto); die();
		return $producto->fetch_object();
	}
	
	//**************** METODO OBTENER UN PEDIDO DETERMINADO(ULTIMO PEDIDO) (id_user) *****************
	public function getOneByCustomer() {
		
	
		$sql = " SELECT * FROM pedidos "
				. "WHERE id_usuario = {$this->getId_usuario()} "
				. "ORDER BY idPedido DESC "
				. "LIMIT 1 ";
		
		$pedido = $this->db->query($sql);
		
		$chk_query = false;
		
		if ($pedido) {
			
			$chk_query = true;
		}
		
		if($chk_query){
			
			$this->db->close();
			
			// devolvemos la fila deseada en un obj
			//print_r($pedido->fetch_object()); die();
			return $pedido->fetch_object();
		}
		else{
			return false;
		}
		
	}
	
	
	//**************** METODO OBTENER TODOS LOS PRODUCTOS DE UN PEDIDO
	public function getProductsBypedido() {
		
		$sql = "SELECT po.nombre, po.precio,po.imagen, "
				. "pe.idPedido, pe.coste, pe.estado, pe.localidad, pe.provincia, pe.direccion, lp.unidades "
				. "FROM productos po "
				. "INNER JOIN lineas_pedidos lp ON lp.id_producto = po.idProducto "
				. "INNER JOIN pedidos pe ON lp.id_pedido = pe.idPedido "
				. "WHERE pe.idPedido = {$this->getIdPedido()}";
		
		$productos_pedido = $this->db->query($sql);
	
		//var_dump($this->db->error); die();
		return $productos_pedido;
	}
	
	//***************** METODO ALMACENAR NUEVO PEDIDO ***************
	public function save() {
		
		$sql = "INSERT INTO pedidos (id_usuario, localidad,	provincia, direccion, coste, estado)  "
			. "VALUES ( {$this->getId_usuario()}, '{$this->getLocalidad()}','{$this->getProvincia()}','{$this->getDireccion()}',{$this->getCoste()},'Confirm' ) ";
					 
		$save = $this->db->query($sql);
		
		//var_dump($this->db->error); die();
		
		$result = false;
		
		if ($save) {
			$result = true;
		}
		
		//var_dump($save); die();
		//$this->db->close(); // no cerrar consulta para obtener en save_lineas el ultimo id
		return $result;
					 
	}
	
	
	//************ METODO ALMACENAR NUEVA LINEA PEDIDO
	public function save_linea() {
		
		// obtenemos el id ultimo registro insertado
		$sql = "SELECT idPedido FROM pedidos ORDER BY idPedido DESC LIMIT 1 ";
		$query = $this->db->query($sql);
		
		// devolvemos un objeto y obtenemos su id
		$id_pedido = $query->fetch_object()->idPedido;
		
		// vamos a recorrer el carrito y por cada producto insertarlo en lineas-pedido
		// ya que necesitamos obtener las unidades y el id de cada producto
		foreach($_SESSION['carrito'] as $elemento){
			$producto = $elemento['producto'];
			
			$insert = "INSERT INTO lineas_pedidos VALUES(NULL, {$id_pedido}, {$producto->idProducto}, {$elemento['unidades']})";
			$save = $this->db->query($insert);
			
//			var_dump($producto);
//			var_dump($insert);
//			echo $this->db->error;
//			die();
		}
		
		$result = false;
		
		if($save){
			$result = true;
		}
		
		return $result;
	}
	
	//*********** METODO ELIMINAR PEDIDO *************************
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
	
	
	//*********** METODO EDITAR PEDIDO *************************
	public function editar(){
		
		$sql = "UPDATE pedidos SET estado='{$this->getEstado()}' ";
		$sql .= " WHERE idPedido={$this->getIdPedido()};";
		
		$save = $this->db->query($sql);
		
		$result = false;
		if($save){
			$result = true;
		}
		return $result;
	}
	
}// end class Producto


