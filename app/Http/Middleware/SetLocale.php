<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use Illuminate\Http\Request;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
         
        $language = $request->language;
        
        $supportedLanguages = ['en', 'fr' ];
        if (in_array($language, $supportedLanguages)) {
            app()->setLocale($language);
        } else {
            app()->setLocale('en'); // Fallback to default language if the provided language is not supported
        }
 
        return $next($request);
    }
}
