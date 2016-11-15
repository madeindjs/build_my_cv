<?php
session_start();

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
 * CV
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
 * admin
 */
$app->get ('/admin', function (Request $request, Response $response) {
    $session = \BuildMyCV\classes\Session::get_instance() ;
    if($session->is_logged()){
        return $this->view->render($response, "admin.phtml", ["title" => "admin"]);
    }else{
        return $response->withStatus(302)->withHeader('Location', '/admin/signin');
    }
});
$app->get ('/admin/signin', function (Request $request, Response $response) {
    return $this->view->render( $response, "admin_signin.phtml", ["title" => "Login to edit your CV"] );
});
$app->post('/admin/signin', function (Request $request, Response $response) use ($app) {
    $session = \BuildMyCV\classes\Session::get_instance() ;
    $post_data = $request->getParsedBody();
    
    if($session->login($post_data['password'])){
        return $response->withStatus(302)->withHeader('Location', '/admin');
    }else{
        return $this->view->render( $response,  "admin_signin.phtml",  ["flash" => "password might be wrong" ] );
    }
});
$app->get ('/admin/signout', function (Request $request, Response $response) {
    session_destroy();
    return $response->withStatus(302)->withHeader('Location', '/admin/signin');
});



$app->run();