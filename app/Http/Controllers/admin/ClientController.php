<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller {
    public function index() {
        $clients = Client::withCount('invoices')->latest()->paginate(15);
        return view('admin.clients.index', compact('clients'));
    }

    public function create() {
        return view('admin.clients.create');
    }

    public function store(Request $request) {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'nullable|email',
            'phone'   => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'country' => 'nullable|string|max:100',
        ]);
        Client::create($request->only('name', 'email', 'phone', 'address', 'country'));
        return redirect()->route('admin.clients.index')->with('success', 'Client créé.');
    }

    public function edit(Client $client) {
        return view('admin.clients.edit', compact('client'));
    }

    public function update(Request $request, Client $client) {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'nullable|email',
            'phone'   => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'country' => 'nullable|string|max:100',
        ]);
        $client->update($request->only('name', 'email', 'phone', 'address', 'country'));
        return redirect()->route('admin.clients.index')->with('success', 'Client mis à jour.');
    }

    public function destroy(Client $client) {
        $client->delete();
        return redirect()->route('admin.clients.index')->with('success', 'Client supprimé.');
    }
}