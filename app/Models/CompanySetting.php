<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanySetting extends Model {
    protected $fillable = [
        'company_name', 'slogan', 'address', 'city',
        'country', 'phone', 'phone2', 'email', 'website',
        'rccm', 'ifu', 'logo', 'stamp', 'currency', 'invoice_footer'
    ];

    public static function getSettings() {
        return self::firstOrCreate(['id' => 1], [
            'company_name' => 'Mon Entreprise',
            'currency'     => 'FCFA',
        ]);
    }
}