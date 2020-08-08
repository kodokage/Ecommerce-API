<?php

namespace App\Http\Middleware;

use Closure;
use App\Http\Controllers\Api\ApiController;
class Seller extends ApiController
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth()->check() && $request->user()->category == 'seller' && $request->user()->status == TRUE) {
            return $next($request);
        }
        return $this->sendError('Unauthorized: Only approved sellers can access this route');
    }
}
