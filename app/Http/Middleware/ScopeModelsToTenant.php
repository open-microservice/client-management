<?php

namespace App\Http\Middleware;

use App\Models\Client;
use App\TenantScope;
use Closure;
use Illuminate\Database\Eloquent\Model;

class ScopeModelsToTenant
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
        if ($request->query('tenant')) {
            Client::addGlobalScope(new TenantScope($request->query('tenant')));
        }

        return $next($request);
    }
}
