<?php
namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller {
    public function index() {
        return view('employee.profile', ['user' => auth()->user()]);
    }

    public function update(Request $request) {
        $user = auth()->user();

        $request->validate([
            'name'     => 'required|string|max:255',
            'phone'    => 'nullable|string|max:20',
            'email'    => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|min:8|confirmed',
            'current_password' => $request->filled('password') ? 'required' : 'nullable',
        ]);

        if ($request->filled('password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Mot de passe actuel incorrect.']);
            }
            $user->update(['password' => bcrypt($request->password)]);
        }

        $user->update([
            'name'  => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
        ]);

        return back()->with('success', 'Profil mis à jour avec succès.');
    }
}