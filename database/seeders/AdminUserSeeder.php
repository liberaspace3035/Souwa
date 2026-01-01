<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::firstOrCreate(
            ['email' => 'admin@souwa.com'],
            [
                'name' => '管理者',
                'password' => \Hash::make('password'),
                'role' => 'admin',
            ]
        );

        $this->command->info('管理者アカウントを作成しました。');
        $this->command->info('Email: admin@souwa.com');
        $this->command->info('Password: password');
    }
}
