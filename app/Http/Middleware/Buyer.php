<?php

namespace App\Http\Middleware;
use App\Http\Controllers\Api\ApiController;
use Closure;

class Buyer extends ApiController
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
        if (auth()->check() && $request->user()->category == 'buyer' && $request->user()->status == TRUE && $request->user()->status == TRUE) {
            return $next($request);
        }
        return $this->sendError('Unauthorized: Only approved buyers can access this route'); //redirect('/');
    }
}
