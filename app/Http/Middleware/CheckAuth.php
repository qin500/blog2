<?php

namespace App\Http\Middleware;

use App\Helpers\ResponseHelper;
use Closure;
use Illuminate\Http\Request;

class CheckAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\JsonResponse
     */
    public function handle(Request $request, Closure $next)
    {

        if(! auth()->check()){
            if($request->method() == "GET"){
                return  redirect(route('Auth::login') . "?redirect=" . urlencode($request->fullUrl()),302);
            }else{
                return  ResponseHelper::returnJSON("未登录",[],422);
            }

        }

        return $next($request);
    }
}
