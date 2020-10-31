<?php

function pageError404() {
	$error = new ErrorController();
	$error->error404();
}


function mostrarError($errores, $campo) {
	$alerta = "";

	if ((isset($errores[$campo])) && (!empty($campo))) {

		$alerta = "<div class='alerta alerta-error'>" . $errores[$campo] . '</div>';
	}
	return $alerta;
}
