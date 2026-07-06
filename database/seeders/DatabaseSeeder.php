<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Supplier;

class DatabaseSeeder extends Seeder {
    public function run(): void {

        // Compte Admin (toi)
        User::create([
            'name'      => 'Admin Principal',
            'email'     => 'admin@stock.com',
            'password'  => bcrypt('Admin@1234'),
            'role'      => 'admin',
            'is_active' => true,
        ]);

        // Compte Employé test
        User::create([
            'name'      => 'Employé Test',
            'email'     => 'employe@stock.com',
            'password'  => bcrypt('Employe@1234'),
            'role'      => 'employee',
            'is_active' => true,
        ]);

        // Catégories de base
        $categories = [
            'Électronique',
            'Vêtements',
            'Alimentation',
            'Fournitures de bureau',
            'Outillage',
            'Mobilier',
        ];

        foreach ($categories as $cat) {
            Category::create(['name' => $cat]);
        }

        // Fournisseur de base
        Supplier::create([
            'name'    => 'Fournisseur Principal',
            'email'   => 'contact@fournisseur.com',
            'phone'   => '+229 00000000',
            'address' => 'Cotonou',
            'country' => 'Bénin',
        ]);
    }
}