<?php

class Database {
	
	public static function Connect() {
		
		//cargamos fichero de configuracion
		include_once 'config_db.php';
		
		$db = new mysqli(HOST_DB, USER_DB, PASSWORD_DB, DATABASE_DB, PORT_DB);
		$db->set_charset("utf8");
		//$db->query("SET NAMES 'utf8' ");
		
		return $db;
		
		}
		
//		public static function Disconnect(){
//	
//			
//		}
}
