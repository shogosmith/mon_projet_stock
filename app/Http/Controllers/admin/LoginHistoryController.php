<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LoginHistory;
use App\Models\User;
use Illuminate\Http\Request;

class LoginHistoryController extends Controller
{
    public function index(Request $request)
    {
        $query = LoginHistory::with('user')->latest('logged_in_at');

        if ($request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        $histories = $query->paginate(20)->withQueryString();
        $employees = User::where('role', 'employee')->get();

        return view('admin.login_histories.index', compact('histories', 'employees'));
    }

    /**
     * Supprime les connexions de plus de 30 jours.
     */
    public function clearOld()
    {
        LoginHistory::where('logged_in_at', '<', now()->subDays(30))->delete();

        return redirect()->route('admin.login_histories.index')
            ->with('success', 'Les anciennes connexions (+30 jours) ont été supprimées.');
    }

    /**
     * Vide tout l'historique des connexions.
     */
    public function clear()
    {
        LoginHistory::truncate();

        return redirect()->route('admin.login_histories.index')
            ->with('success', 'Tout l\'historique des connexions a été supprimé.');
    }
}