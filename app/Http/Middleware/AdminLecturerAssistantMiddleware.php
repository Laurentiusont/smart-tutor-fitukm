<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class AdminLecturerAssistantMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $session = new Session();
        $role_guid = $session->get('role_guid');
        if ($role_guid == '120014de-1d48-4947-b801-afe701bb19b8' || $role_guid == '4eab4f52-e377-4032-8ff3-bd8d58fe5aa0' || $role_guid == 'c6a51300-8153-4f31-933c-dc7cd0fb7d6f') {
            return $next($request);
        }

        abort(403, 'Unauthorized action.');
    }
}
