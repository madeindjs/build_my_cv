<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once '../classes/autoload.php';
require_once ROOT.'/vendor/autoload.php';

$config = [
    'settings' => [
        'displayErrorDetails' => true,
    ],
];

// create Application
$app = new \Slim\App($config);
$container = $app->getContainer();
$container['view'] = new \Slim\Views\PhpRenderer('../templates/');

/**
 * GET /
 */
$app->get('/', function (Request $request, Response $response) {
    $user = \BuildMyCV\classes\User::get_instance() ;
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
 * GET /
 */
$app->get('/admin', function (Request $request, Response $response) {
    return $this->view->render(
        $response, 
        "admin.phtml", 
        [
            "title" => "admin",
            "session" => \BuildMyCV\classes\Session::get_instance()
        ]
    );
});

$app->post('/admin', function (Request $request, Response $response) use ($app) {
    $session = \BuildMyCV\classes\Session::get_instance() ;
    $post_data = $request->getParsedBody();
    
    
    if($post_data['password'] != null && $session->login($post_data['password'])){
        return $this->view->render( $response,  "admin.phtml",  ["title" => "admin" , "session" => $session] );
    }else{
        return $this->view->render( $response,  "admin.phtml",  ["title" => "admin" , "session" => $session , "flash" => "password might be wrong" ] );
    }
    
    
});

$app->run();