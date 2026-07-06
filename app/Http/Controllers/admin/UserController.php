<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller {
    public function index() {
        $users = User::where('role', 'employee')->latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function create() {
        return view('admin.users.create');
    }

    public function store(Request $request) {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'phone'    => 'nullable|string|max:20',
            'password' => 'required|min:8|confirmed',
        ]);
        User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'phone'     => $request->phone,
            'password'  => bcrypt($request->password),
            'role'      => 'employee',
            'is_active' => true,
        ]);
        return redirect()->route('admin.users.index')->with('success', 'Employé créé.');
    }

    public function edit(User $user) {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user) {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'phone'    => 'nullable|string|max:20',
            'password' => 'nullable|min:8|confirmed',
        ]);
        $user->update(['name' => $request->name, 'email' => $request->email, 'phone' => $request->phone]);
        if ($request->filled('password')) {
            $user->update(['password' => bcrypt($request->password)]);
        }
        return redirect()->route('admin.users.index')->with('success', 'Employé mis à jour.');
    }

    public function destroy(User $user) {
        if ($user->isAdmin()) abort(403, 'Impossible de supprimer un admin.');
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Employé supprimé.');
    }

    public function toggle(User $user) {
        $user->update(['is_active' => !$user->is_active]);
        $statut = $user->is_active ? 'activé' : 'désactivé';
        return back()->with('success', "Compte $statut avec succès.");
    }
}