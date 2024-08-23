<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PermissionsSeeder::class,
        ]);

        if(App::isProduction()) {
            User::create([
                'name' => 'Lucas Admin',
                'email' => 'lucaslemodev@gmail.com',
                'email_verified_at' => now(),
                'password' => '$2y$12$ZYXd2eaSNO5HuZGghTX.9efF6HSW/AgmEtyzpk5HUCqSO5rdfXpoK',
                'type' => 'administrator',
                'cpf' => '06952649310',
                'active' => true,
            ]);
        }

        if(!App::isProduction()) {
            $this->call([
                UserSeeder::class,
                SynchronizationSeeder::class,
                // CustomerSeeder::class,
                // OrderSeeder::class,
                // InvoiceSeeder::class,
                // LinkDatabaseSeeder::class,
            ]);
        }
    }
}
