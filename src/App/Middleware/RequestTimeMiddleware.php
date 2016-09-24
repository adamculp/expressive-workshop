<?php
namespace App\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class RequestTimeMiddleware
{
    public function __invoke(ServerRequestInterface $request, 
        ResponseInterface $response, 
        callable $next = null)
    {
        $response = $next($request, $response);
    
        $server = $request->getServerParams();
        
        if (!isset($server['REQUEST_TIME_FLOAT'])) {
            $server['REQUEST_TIME_FLOAT'] = microtime(true);
        }
        
        $time = (microtime(true) - $server['REQUEST_TIME_FLOAT']) * 1000;
        
        return $response->withHeader('X-Request-Time', sprintf('%2.3fms', $time));
    }
}
