<?php

//remove white spaces and escape html to prevent xss
function validate($input) {
	$input = trim($input);
	$input = stripslashes($input);
	$input = htmlspecialchars($input);

	return $input;
}

function validaPostal($cadena) {
	
	//Comrpobamos que realmente se ha añadido el formato correcto
	if (preg_match('/^[0-9]{5}$/i', $cadena))
	//La instruccion se cumple
		return true;
	else
	//Contiene caracteres no validos
		return false;
}
