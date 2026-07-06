<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\LoginHistory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller {
    public function create(): View {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse {
        $request->authenticate();
        $request->session()->regenerate();

        $user = Auth::user();

        if (!$user->is_active) {
            Auth::logout();
            return back()->withErrors([
                'email' => 'Votre compte est désactivé. Contactez l\'administrateur.',
            ]);
        }

        // Enregistrer la connexion
        $agent = $request->userAgent();
        $device = 'Ordinateur';
        if (str_contains(strtolower($agent), 'mobile')) $device = 'Mobile';
        elseif (str_contains(strtolower($agent), 'tablet')) $device = 'Tablette';

        LoginHistory::create([
            'user_id'      => $user->id,
            'ip_address'   => $request->ip(),
            'user_agent'   => $agent,
            'device'       => $device,
            'logged_in_at' => now(),
        ]);

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('employee.dashboard');
    }

    public function destroy(Request $request): RedirectResponse {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}