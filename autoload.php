<?php

function app_autoloader_class($className) {
	require_once 'controllers/'.$className . '.php';
	
}

spl_autoload_register('app_autoloader_class');



