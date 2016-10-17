<?php

namespace DrawMyCV\core ;

class Autoloader{

	/**
	 * Enregistre notre autoloader
	 */
	static function register(){
		spl_autoload_register(array(__CLASS__, 'autoload'));
	}

	/**
	 * Inclue le fichier correspondant à notre classe
	 * @param $class string Le nom de la classe à charger
	 */
	static function autoload($class){
		$class = str_replace('DrawMyCV\\app\\', '', $class);
		require '../app/' . $class . '.php';
	}

}
