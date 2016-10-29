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
 * GET /
 */
$app->get('/', function (Request $request, Response $response) {
    $user = \BuildMyCV\classes\User::getInstance() ;
    return $this->view->render(
        $response, 
        "cv.phtml", 
        [
            "title" => $user->complete_name(),
            "user" => $user
        ]
    );
});


/**
 * GET /project/{name}
 */
$app->get('/project/{name}', function(Request $request, Response $response, $args){
    $project_name = $args['name'];
    return $this->view->render(
        $response, 
        "project.phtml", 
        ["project_name" => $project_name ]
    );
});


$app->run();