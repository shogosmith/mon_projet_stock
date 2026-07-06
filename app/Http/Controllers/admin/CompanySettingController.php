<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CompanySetting;
use Illuminate\Http\Request;

class CompanySettingController extends Controller {
    public function index() {
        $settings = CompanySetting::getSettings();
        return view('admin.settings.company', compact('settings'));
    }

    public function update(Request $request) {
        $request->validate([
            'company_name'   => 'required|string|max:255',
            'slogan'         => 'nullable|string|max:255',
            'address'        => 'nullable|string',
            'city'           => 'nullable|string|max:100',
            'country'        => 'nullable|string|max:100',
            'phone'          => 'nullable|string|max:20',
            'phone2'         => 'nullable|string|max:20',
            'email'          => 'nullable|email',
            'website'        => 'nullable|string|max:255',
            'rccm'           => 'nullable|string|max:100',
            'ifu'            => 'nullable|string|max:100',
            'currency'       => 'nullable|string|max:10',
            'invoice_footer' => 'nullable|string',
            'logo'           => 'nullable|image|max:2048',
            'stamp'          => 'nullable|image|max:2048',
        ]);

        $settings = CompanySetting::getSettings();
        $data = $request->except(['logo', 'stamp', '_token', '_method']);

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('company', 'public');
        }
        if ($request->hasFile('stamp')) {
            $data['stamp'] = $request->file('stamp')->store('company', 'public');
        }

        $settings->update($data);

        return back()->with('success', 'Paramètres de l\'entreprise mis à jour.');
    }
}