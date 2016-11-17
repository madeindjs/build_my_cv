<?php

define ('ROOT', dirname(dirname(dirname(__FILE__))));
define ('SRC', ROOT.'/src/');
define ('WWW', SRC.'/public/');

//Setup Autoloader
spl_autoload_register(function ($classname) {
    $class = str_replace('BuildMyCV', '', $classname);
    require (ROOT."/src/" . $class . ".php");
});
