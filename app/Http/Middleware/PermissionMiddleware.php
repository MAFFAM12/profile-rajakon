<?php

namespace App\Http\Middleware;

use Closure;
use Filament\Facades\Filament;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request):Response $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $guard = Filament::auth();

        // Ensure the user is authenticated
        if (!$guard->check()) {
            abort(403, 'Unauthorized');
        }

        $user = $guard->user();
        $usersRoles = $user->roles;

        // Eager load permissions to avoid N+1 query problem
        $permissions = $usersRoles->load('permissions')->pluck('permissions')->flatten();

        $requestPath = "/{$request->path()}";

        if ($requestPath !== "/admin/logout") {
            foreach ($permissions as $permission) {
                // Convert the http_path to a regex pattern
                $httpPathPattern = preg_quote($permission->http_path, '/'); // Escape special characters
    
                // Replace placeholders like {record} and {name} with a regex for dynamic values
                $httpPathPattern = str_replace(
                    ['\{record\}', '\{name\}'], // Placeholders to replace
                    ['[^\/]+', '[^\/]+'],       // Regex pattern for dynamic values
                    $httpPathPattern
                );
    
                $httpPathPattern = '/^' . $httpPathPattern . '$/'; // Wrap in regex delimiters
    
                // Check if the request path matches the http_path pattern
                if (preg_match($httpPathPattern, $requestPath)) {
                    return $next($request);
                }
            }
    
            abort(403, 'Forbidden');
        } else {
            return $next($request);
        }

    }
}