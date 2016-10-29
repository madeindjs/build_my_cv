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
$app->get('/activity/{name}', function(Request $request, Response $response, $args){
    $activity_name = $args['name'];
    $user = \BuildMyCV\classes\User::getInstance() ;
    
    // find activity
    if($activity = $user->get_activity_by_name($activity_name)){
        
        return $this->view->render(
            $response, 
            "activity.phtml", 
            [
                "title" => $activity->name,
                "activity" => $activity,
                "user" => $user
            ]
        );
        
    }else{
        return $this->view->render(
            $response, 
            "404.phtml"
        )->withStatus(404);
    }

    
});


$app->run();