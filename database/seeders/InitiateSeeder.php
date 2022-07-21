<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\BarangModel;
use App\Models\SettingModel;
use App\Models\RoleModel;

use App\Models\MenuModel;
use App\Models\RoleHasMenuModel;

use App\Models\User;

use Carbon\Carbon;
use Hash;
use Illuminate\Support\Str;

class InitiateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SettingModel::insert([
            'st_key' => 'title',
            'st_value' => 'Gudang Barang',
            'st_type' => 'string',
            'created_at' => Carbon::now('Asia/Jakarta'),
        ]);

        BarangModel::insert([
            'barang_nama' => 'Le Minerale',
            'barang_total' => 0,
            'barang_keluar' => 0,
            'barang_reject' => 0,
            'created_at' => Carbon::now('Asia/Jakarta'),
        ]);

        $role = RoleModel::create([
            'role_name' => 'SUPERADMIN',
            'created_at' => Carbon::now('Asia/Jakarta'),
        ]);

        RoleModel::insert([
            [
                'role_name' => 'ADMIN',
                'created_at' => Carbon::now('Asia/Jakarta'),
            ],
            [
                'role_name' => 'STAFF',
                'created_at' => Carbon::now('Asia/Jakarta'),
            ]
        ]);

        $admin = RoleModel::where('role_name', 'ADMIN')->first();
        $staff = RoleModel::where('role_name', 'STAFF')->first();

        $dashboard = MenuModel::create([
            // 'menu_id' => Str::uuid(),
            'menu_url' => '/dashboard',
            'menu_title' => 'Dashboard',
            'menu_icon' => 'fas fa-fw fa-tachometer-alt',
            'menu_type' => 'link',
            'menu_parent' => 0,
            'menu_sort' => 1,
        ]);

        // Insert Bulk Initiate Menu Model
        MenuModel::insert([
            [
                'id' => 2,
                'menu_url' => '/dashboard/config',
                'menu_title' => 'Config',
                'menu_icon' => 'fas fa-fw fa-cogs',
                'menu_type' => 'header',
                'menu_parent' => 0,
                'menu_sort' => 2,
                'created_at' => '17/7/2022 19:36:09',
            ],
            [
                'id' => 3,
                'menu_url' => '/dashboard/config/menu',
                'menu_title' => 'Menu List',
                'menu_icon' => 'fas fa-fw fa-bars',
                'menu_type' => 'link',
                'menu_parent' => 2,
                'menu_sort' => 1,
                'created_at' => '17/7/2022 19:50:26',
            ],
            [
                'id' => 4,
                'menu_url' => '/dashboard/config/user',
                'menu_title' => 'User List',
                'menu_icon' => 'fas fa-fw fa-user-shield',
                'menu_type' => 'link',
                'menu_parent' => 2,
                'menu_sort' => 2,
                'created_at' => '17/7/2022 19:57:34',
            ],
            [
                'id' => 5,
                'menu_url' => '/dashboard/config/setting',
                'menu_title' => 'User List',
                'menu_icon' => 'fas fa-fw fa-cog',
                'menu_type' => 'link',
                'menu_parent' => 2,
                'menu_sort' => 2,
                'created_at' => '17/7/2022 19:57:34',
            ],
            [
                'id' => 6,
                'menu_url' => '/dashboard/logout',
                'menu_title' => 'Logout',
                'menu_icon' => 'fas fa-fw fa-sign-out-alt',
                'menu_type' => 'link',
                'menu_parent' => 0,
                'menu_sort' => 3,
                'created_at' => '17/7/2022 20:17:19',
            ],
        ]);

        RoleHasMenuModel::insert([
            [
                'menu_role_id' => $admin->id,
                'menu_menu_id' => $dashboard->id,
                'created_at' => Carbon::now('Asia/Jakarta'),
            ],
            [
                'menu_role_id' => $staff->id,
                'menu_menu_id' => $dashboard->id,
                'created_at' => Carbon::now('Asia/Jakarta'),
            ]
        ]);

        User::insert([
            'name' => 'superadmin',
            'email' => 'm.waziruddin@gmail.com',
            'username' => 'superadmin',
            'password' => Hash::make('085283480788'),
            'role' => $role->id,
            'created_at' => Carbon::now('Asia/Jakarta'),
        ]);
    }
}
