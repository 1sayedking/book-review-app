<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
       // dd($request->user()); to see the information from db work or no

       if($request->user()->role != 'admin'){
        session()->flash('error', 'You are not authorized to access this section!');
        return redirect()->route('account.profile');

       }
        return $next($request);
    }
}
