<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Default password for all test users
        $password = Hash::make('password');

        // Array of all roles with their display names and emails
        $roles = [
            [
                'name' => 'Admin',
                'email' => 'admin@esurat.local',
                'role' => 'admin',
            ],
            [
                'name' => 'Kepala Sekolah',
                'email' => 'kepala@esurat.local',
                'role' => 'kepala_sekolah',
            ],
            [
                'name' => 'Wakasek Kurikulum',
                'email' => 'wakasek.kurikulum@esurat.local',
                'role' => 'wakasek_kurikulum',
            ],
            [
                'name' => 'Wakasek Sarana Prasarana',
                'email' => 'wakasek.sarana@esurat.local',
                'role' => 'wakasek_sarana_prasarana',
            ],
            [
                'name' => 'Wakasek Kesiswaan',
                'email' => 'wakasek.kesiswaan@esurat.local',
                'role' => 'wakasek_kesiswaan',
            ],
            [
                'name' => 'Wakasek Humas',
                'email' => 'wakasek.humas@esurat.local',
                'role' => 'wakasek_humas',
            ],
            [
                'name' => 'Tata Usaha',
                'email' => 'tu@esurat.local',
                'role' => 'tu',
            ],
            [
                'name' => 'Kepala Tata Usaha',
                'email' => 'ka.tu@esurat.local',
                'role' => 'ka_tu',
            ],
            [
                'name' => 'Kaprog DKV',
                'email' => 'kaprog.dkv@esurat.local',
                'role' => 'kaprog_dkv',
            ],
            [
                'name' => 'Kaprog PPLG',
                'email' => 'kaprog.pplg@esurat.local',
                'role' => 'kaprog_pplg',
            ],
            [
                'name' => 'Kaprog TJKT',
                'email' => 'kaprog.tjkt@esurat.local',
                'role' => 'kaprog_tjkt',
            ],
            [
                'name' => 'Kaprog Bisnis Daring',
                'email' => 'kaprog.bd@esurat.local',
                'role' => 'kaprog_bd',
            ],
            [
                'name' => 'Guru',
                'email' => 'guru@esurat.local',
                'role' => 'guru',
            ],
            [
                'name' => 'Pembina Ekstra',
                'email' => 'pembina@esurat.local',
                'role' => 'pembina_ekstra',
            ],
            [
                'name' => 'Bursa Kerja Khusus',
                'email' => 'bkk@esurat.local',
                'role' => 'bkk',
            ],
            [
                'name' => 'User Biasa',
                'email' => 'user@esurat.local',
                'role' => 'staff',
            ],
        ];

        // Create user for each role
        foreach ($roles as $roleData) {
            User::create([
                'name' => $roleData['name'],
                'email' => $roleData['email'],
                'password' => $password,
                'role' => $roleData['role'],
            ]);
        }
    }
}
