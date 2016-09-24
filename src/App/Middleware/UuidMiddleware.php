<?php
namespace App\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

class UuidMiddleware
{
    public function __invoke(ServerRequestInterface $request, 
        ResponseInterface $response, 
        callable $next = null)
    {
        $response = $next($request, $response);
    
        $uuid = '';
    
        try {
        
            // Generate a version 4 (random) UUID object
            $uuid = Uuid::uuid4();
        
        } catch (UnsatisfiedDependencyException $e) {
        
            // Some dependency was not met. Either the method cannot be called on a
            // 32-bit system, or it can, but it relies on Moontoast\Math to be present.
            echo 'Caught exception: ' . $e->getMessage() . "\n";
        
        }
        
        return $response->withHeader('X-Request-Uuid', $uuid->toString());
    }
}
