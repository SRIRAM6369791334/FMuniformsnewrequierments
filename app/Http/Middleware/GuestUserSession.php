<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class GuestUserSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Only manage guest session if NOT logged in
        if (!Auth::check()) {
            if (!session()->has('guest_user_id')) {
                // Generate a unique guest ID using UUID
                $guestId = 'guest_' . Str::uuid()->toString();
                session(['guest_user_id' => $guestId]);
                
                \Log::info('New Guest Session Initialized', [
                    'guest_id' => $guestId,
                    'url' => $request->fullUrl(),
                    'ip' => $request->ip()
                ]);
            }
        } else {
            // If logged in, we can optionally clear the guest_user_id 
            // but usually it's better to keep it until the session ends 
            // or explicitly cleared after cart transfer.
        }

        return $next($request);
    }
}
