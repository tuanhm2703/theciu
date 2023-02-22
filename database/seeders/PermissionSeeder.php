<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        Permission::firstOrCreate([
            'name' => 'view product',
            'guard_name' => 'web'
        ]);
        Permission::firstOrCreate([
            'name' => 'create product',
            'guard_name' => 'web'
        ]);
        Permission::firstOrCreate([
            'name' => 'edit product',
            'guard_name' => 'web'
        ]);
        Permission::firstOrCreate([
            'name' => 'delete product',
            'guard_name' => 'web'
        ]);

        Permission::firstOrCreate([
            'name' => 'view category',
            'guard_name' => 'web'
        ]);
        Permission::firstOrCreate([
            'name' => 'create category',
            'guard_name' => 'web'
        ]);
        Permission::firstOrCreate([
            'name' => 'edit category',
            'guard_name' => 'web'
        ]);
        Permission::firstOrCreate([
            'name' => 'delete category',
            'guard_name' => 'web'
        ]);

        Permission::firstOrCreate([
            'name' => 'view order',
            'guard_name' => 'web'
        ]);
        Permission::firstOrCreate([
            'name' => 'create order',
            'guard_name' => 'web'
        ]);
        Permission::firstOrCreate([
            'name' => 'edit order',
            'guard_name' => 'web'
        ]);
        Permission::firstOrCreate([
            'name' => 'delete order',
            'guard_name' => 'web'
        ]);

        Permission::firstOrCreate([
            'name' => 'view promotion',
            'guard_name' => 'web'
        ]);
        Permission::firstOrCreate([
            'name' => 'create promotion',
            'guard_name' => 'web'
        ]);
        Permission::firstOrCreate([
            'name' => 'edit promotion',
            'guard_name' => 'web'
        ]);
        Permission::firstOrCreate([
            'name' => 'delete promotion',
            'guard_name' => 'web'
        ]);

        Permission::firstOrCreate([
            'name' => 'view voucher',
            'guard_name' => 'web'
        ]);
        Permission::firstOrCreate([
            'name' => 'create voucher',
            'guard_name' => 'web'
        ]);
        Permission::firstOrCreate([
            'name' => 'edit voucher',
            'guard_name' => 'web'
        ]);
        Permission::firstOrCreate([
            'name' => 'delete voucher',
            'guard_name' => 'web'
        ]);

        Permission::firstOrCreate([
            'name' => 'view blog',
            'guard_name' => 'web'
        ]);
        Permission::firstOrCreate([
            'name' => 'create blog',
            'guard_name' => 'web'
        ]);
        Permission::firstOrCreate([
            'name' => 'edit blog',
            'guard_name' => 'web'
        ]);
        Permission::firstOrCreate([
            'name' => 'delete blog',
            'guard_name' => 'web'
        ]);

        Permission::firstOrCreate([
            'name' => 'view banner',
            'guard_name' => 'web'
        ]);
        Permission::firstOrCreate([
            'name' => 'create banner',
            'guard_name' => 'web'
        ]);
        Permission::firstOrCreate([
            'name' => 'edit banner',
            'guard_name' => 'web'
        ]);
        Permission::firstOrCreate([
            'name' => 'delete banner',
            'guard_name' => 'web'
        ]);

        Permission::firstOrCreate([
            'name' => 'view warehouse',
            'guard_name' => 'web'
        ]);
        Permission::firstOrCreate([
            'name' => 'create warehouse',
            'guard_name' => 'web'
        ]);
        Permission::firstOrCreate([
            'name' => 'edit warehouse',
            'guard_name' => 'web'
        ]);
        Permission::firstOrCreate([
            'name' => 'delete warehouse',
            'guard_name' => 'web'
        ]);

        Permission::firstOrCreate([
            'name' => 'view page',
            'guard_name' => 'web'
        ]);
        Permission::firstOrCreate([
            'name' => 'create page',
            'guard_name' => 'web'
        ]);
        Permission::firstOrCreate([
            'name' => 'edit page',
            'guard_name' => 'web'
        ]);
        Permission::firstOrCreate([
            'name' => 'delete page',
            'guard_name' => 'web'
        ]);
    }
}
