<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;

class Common extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */

     protected function authenticate($request, array $guards)
     {
        $data =Auth::user();
        // dd($data);
        if($data->email_verification == 0 || empty($data->email_verification)){
            $this->unauthenticated($request, ['web']);
        }
     }


    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {            
            return route('user.login');
        }
    }
}
