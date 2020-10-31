<?php

class ErrorController {
	
	public function index() {
		echo "<h1>La pagina que buscas no existe</h1>";		
	}
	
	public function error404() {
		
		//cargamos vista error404
		require_once 'views/error/error404.php';
		
	}
	
	public function errorForm() {
		
		
		
	}
	
}