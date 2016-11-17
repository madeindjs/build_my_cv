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
 * GET CV.
 * 
 * We try to build the user with the data.json file. If file does not exist,
 * we redirect user to the admin interface and we ask them to complete data
 */
$app->get('/', function (Request $request, Response $response) {
    try{
        $user = \BuildMyCV\classes\User::get_instance() ;
        return $this->view->render( $response,  "cv.phtml", 
            ["title" => $user->complete_name(),"user" => $user]);
    } catch (\Exception $ex) {
        return $response->withStatus(302)->withHeader('Location', '/admin');
    }
});




$app->group('/admin', function(){
    
    /**
    * GET /admin
    * 
    * We check if admin is logged. If not, we redirect him to the signin route
    */
   $this->get ('', function (Request $request, Response $response) {
       $session = \BuildMyCV\classes\Session::get_instance() ;
       if($session->is_logged()){
           return $this->view->render($response, "admin.phtml", ["title" => "admin"]);
       }else{
           return $response->withStatus(302)->withHeader('Location', '/admin/signin');
       }
   });
    
    /**
    * GET /admin/informations
    * 
    * We check if admin is logged. If not, we redirect him to the signin route
    */
   $this->get ('/informations', function (Request $request, Response $response) {
       $session = \BuildMyCV\classes\Session::get_instance() ;
       if($session->is_logged()){
           return $this->view->render($response, "admin_informations.phtml", ["title" => "admin"]);
       }else{
           return $response->withStatus(302)->withHeader('Location', '/admin/signin');
       }
   });
    
    /**
     * POST /admin/informations
     * 
     * We get JSON fil sent by AJAX call and we update the data.json file
     */
    $this->post('/informations', function (Request $request, Response $response) {
        $session = \BuildMyCV\classes\Session::get_instance() ;
        if($session->is_logged()){
            $post_data = $request->getParsedBody();
            $json_data = json_encode($post_data, JSON_PRETTY_PRINT);
            if(file_put_contents(WWW.'data.json', $json_data )){
                echo 'Your informations was successfully updtaded';
                return $response->withStatus(200);
            }else{
                echo 'Something goes wrong (data file could not be writted)';
                return $response->withStatus(500);
            }
        }else{
            echo 'You are not logged as admininstrator';
            return $response->withStatus(403);
        }
        // TODO: check if user is logged

    });

    /**
     * GET /admin/signin
     * 
     * Show a form and ask the password to create a new session
     */
    $this->get ('/signin', function (Request $request, Response $response) {
        return $this->view->render( $response, "admin_signin.phtml", ["title" => "Login to edit your CV"] );
    });

    /**
     * POST /admin/signin
     * 
     * Check password sent & redirect user to the admin interface if success
     */
    $this->post('/signin', function (Request $request, Response $response) {
        $session = \BuildMyCV\classes\Session::get_instance() ;
        $post_data = $request->getParsedBody();

        if($session->login($post_data['password'])){
            return $response->withStatus(302)->withHeader('Location', '/admin');
        }else{
            return $this->view->render( $response,  "admin_signin.phtml",  
                    ["flash" => "password wrong (see readme file for the default password)" ] );
        }
    });

    /**
     * GET /admin/signout
     * 
     * Destroy the session and redirect to the signin route
     */
    $this->get ('/signout', function (Request $request, Response $response) {
        session_destroy();
        return $response->withStatus(302)->withHeader('Location', '/admin/signin');
    });   
 
});





$app->run();