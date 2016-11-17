<?php
session_start();

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use \BuildMyCV\classes\User as User;
use \BuildMyCV\classes\Session as Session;
use \BuildMyCV\middlewares\CheckSessionMiddleware as CheckSessionMiddleware ;
use \BuildMyCV\middlewares\DataExistsMiddleware as DataExistsMiddleware ;

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
    $user = User::get_instance() ;
    return $this->view->render(
        $response,  "cv.phtml", 
        ["title" => $user->complete_name(),"user" => $user]
    );
})->add(new DataExistsMiddleware );




$app->group('/admin', function(){
    
    /**
    * GET /admin
    * 
    * We check if admin is logged. If not, we redirect him to the signin route
    */
   $this->get ('', function (Request $request, Response $response) {
       return $this->view->render($response, "admin.phtml" );
   })->add(new CheckSessionMiddleware );
    
    /**
    * GET /admin/informations
    * 
    * We check if admin is logged. If not, we redirect him to the signin route
    */
   $this->get ('/informations', function (Request $request, Response $response) {
       return $this->view->render($response, "admin_informations.phtml" );
   })->add(new CheckSessionMiddleware );
    
    /**
     * POST /admin/informations
     * 
     * We get JSON fil sent by AJAX call and we update the data.json file
     */
    $this->post('/informations', function (Request $request, Response $response) {
        $post_data = $request->getParsedBody();
        $json_data = json_encode($post_data, JSON_PRETTY_PRINT);
        if(file_put_contents(WWW.'data.json', $json_data )){
            echo 'Your informations was successfully updtaded';
            return $response->withStatus(200);
        }else{
            echo 'Something goes wrong (data file could not be writted)';
            return $response->withStatus(500);
        }
    })->add(new CheckSessionMiddleware );
    
    
    /**
    * GET /admin/items
    * 
    * Get all items to edit them
    */
   $this->get ('/items', function (Request $request, Response $response) {
       $user = User::get_instance() ;
       return $this->view->render($response, "admin_items.phtml", ["user"=> $user] );
   })->add(new CheckSessionMiddleware )->add(new CheckSessionMiddleware );

    /**
     * GET /admin/signin
     * 
     * Show a form and ask the password to create a new session
     */
    $this->get ('/signin', function (Request $request, Response $response) {
        return $this->view->render( $response, "admin_signin.phtml" );
    });

    /**
     * POST /admin/signin
     * 
     * Check password sent & redirect user to the admin interface if success
     */
    $this->post('/signin', function (Request $request, Response $response) {
        $session = Session::get_instance() ;
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
    })->add(new CheckSessionMiddleware ); 
 
});





$app->run();