<?php

namespace BuildMyCV\middlewares;

use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;


/**
 * This is a middleware to check if session is created and redirect user if not
 */
class CheckSessionMiddleware {
    
    public function __invoke(Request $request, Response $response, callable $next) {
        $session = \BuildMyCV\classes\Session::get_instance() ;
        if($session->is_logged()){
            return $next($request, $response);
        }else{
            return $response->withStatus(302)->withHeader('Location', '/admin/signin');
        };
    }
    
}
