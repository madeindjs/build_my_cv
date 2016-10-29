<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once '../../vendor/autoload.php';

//Setup Autoloader
spl_autoload_register(function ($classname) {
    $class = str_replace('BuildMyCV\\classes\\', '', $classname);
    require ("../classes/" . $class . ".php");
});

// create Application
$app = new \Slim\App;
$container = $app->getContainer();
$container['view'] = new \Slim\Views\PhpRenderer('../templates/');

/**
 * Get the root to render 
 */
$app->get('/', function (Request $request, Response $response) {
    $response = $this->view->render(
        $response, 
        "cv.phtml", 
        ["user" => \BuildMyCV\classes\User::getInstance() 
    ]);
    return $response;
});
$app->run();