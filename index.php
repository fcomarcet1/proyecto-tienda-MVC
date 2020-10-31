<?php

session_start();

require_once 'autoload.php'; //cargamos el autoload para cargar automaticamente los controladores
require_once 'config/db.php';
require_once 'config/parameters.php';
require_once 'helpers/utils.php'; // libreria de funciones varias 
require_once 'includes/lib/utils.php'; 
require_once 'views/layout/header.php';
require_once 'views/layout/sidebar.php';



//DECLARACION DE VARIABLES DINAMICAMENTE EN FUNCION DEL $_GET 
if(!isset ($_GET['controller']) && !isset($_GET['action'])){ 
	
	$nameController = controller_default ; //define("controller_default", "ProductoController") asi nos lleva a pagina principal; 

} 
elseif (isset($_GET['controller'])) {//existe controlador
    
    //como todos los controladores acaban en Controller lo concatenamos
	$nameController = $_GET['controller'] . 'Controller';
	
} 
else {//no existe ni controlador ni accion
	
	Utils::pageError404(); //llamada al metodo que carga la vista de la pagina error 404
}

//CARGAR CONTROLADOR DINAMICAMENTE EN FUNCION $_GET 
if ((isset($nameController)) && (class_exists($nameController))) {

	// creamos nuevo objeto controlador
	$controlador = new $nameController();
	
	//cargar automaticamente metodos o acciones en funcion de parametros $_GET 
	if ((isset($_GET['action'])) && (method_exists($controlador, $_GET['action']))) {

		$action = $_GET['action'];
		$controlador->$action(); //llamamos al metodo que recibimos por url
	}
	elseif (!isset ($_GET['controller']) && !isset($_GET['action'])) {//redireccion a index si no llega controller ni action
	
        $action_default = action_default;
        $controlador->$action_default(); //define("action_default", "index"); 

	} 
	else {
		Utils::pageError404();
	}
} 
else {
	Utils::pageError404();
}

require_once 'views/layout/footer.php';