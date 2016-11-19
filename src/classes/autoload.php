<?php

define ('ROOT', dirname(dirname(dirname(__FILE__))));
define('DS', DIRECTORY_SEPARATOR);
define ('SRC', ROOT.DS.'src'.DS );
define ('WWW', SRC.DS.'public'.DS);
define ('UPLOADS', WWW.DS.'img'.DS);

//Setup Autoloader
spl_autoload_register(function ($classname) {
    $classname = str_replace('BuildMyCV', '', $classname);
    $classname = str_replace('\\', DS, $classname);
    require (ROOT.DS.'src'.DS.$classname.".php");
});
