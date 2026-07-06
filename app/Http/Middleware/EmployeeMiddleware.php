<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EmployeeMiddleware {
    public function handle(Request $request, Closure $next) {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        if (!in_array(auth()->user()->role, ['admin', 'employee'])) {
            abort(403);
        }
        if (!auth()->user()->is_active) {
            auth()->logout();
            return redirect()->route('login')->withErrors([
                'email' => 'Votre compte a été désactivé.'
            ]);
        }
        return $next($request);
    }
}