<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Limpa as tabelas de permissões
        DB::table('permissions')->delete();
        DB::table('roles')->delete();

        // Cria os papéis e permissões
        Role::create(['name' => 'Super Admin']);
        Role::create(['name' => 'Customer Default']);
        $roleCustomerAdmin = Role::create(['name' => 'Customer Admin']);
        $permissionCreateNewUserCustomerDefault = Permission::create(['name' => 'Can register a new user customer default']);

        // Atribui a permissão de criar novos usuários clientes padrão
        $roleCustomerAdmin->givePermissionTo($permissionCreateNewUserCustomerDefault);
    }
}
