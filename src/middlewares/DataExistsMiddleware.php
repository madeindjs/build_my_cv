<?php

namespace BuildMyCV\middlewares;

use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;


/**
 * This is a middleware to check if data.json file exists, if not redirect him
 * to informations interface to update him informations
 */
class DataExistsMiddleware {
    
    public function __invoke(Request $request, Response $response, callable $next) {
        if(file_exists( \BuildMyCV\classes\User::JSON_URL )){
            return $next($request, $response);
        }else{
            return $response->withStatus(302)->withHeader('Location', '/admin/informations');
        }
    }
}
