<?php

define ('ROOT', dirname(dirname(dirname(__FILE__))));
define ('SRC', 'ROOT'.'/src/');

//Setup Autoloader
spl_autoload_register(function ($classname) {
    $class = str_replace('BuildMyCV\\classes\\', '', $classname);
    require (ROOT."/src/classes/" . $class . ".php");
});
