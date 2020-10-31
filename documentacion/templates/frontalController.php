<?php

//cargamos el autoload para cargar automaticamente los controladores
require_once 'autoload.php'; 

if(isset($_GET['controller'])){
	
	//como todos los controladores acaban en *Controller lo concatenamos
	$nameController = $_GET['controller'].'Controller';
} 
else {
	
	echo 'La pagina que buscas no existe1';
	exit();
}

//cargar automaticamente controladores en funcion de parametros $_GET 
if ((isset($nameController)) && (class_exists($nameController))) {

	$controlador = new $nameController();

	//cargar automaticamente metodos o acciones en funcion de parametros $_GET 
	if ((isset($_GET['action'])) && (method_exists($controlador, $_GET['action']))) {

		$action = $_GET['action'];
		$controlador->$action();
	} 
	else {
		echo 'La pagina que buscas no existe2';
	}
} 
else {
	echo 'La pagina que buscas no existe3';
}
