<?php
namespace App\Http\Middleware\API\V1;

class SetDefaultValues
{
    public function __construct()
    {
        
    }

    public function handle($request, \Closure $next)
    {
        return $next($request);
    }
}
