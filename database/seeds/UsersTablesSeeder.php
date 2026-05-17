<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\User;

class UsersTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Akun dibuat melalui Admin Panel (C++ Desktop App)
        // User::create([
        //     'name'              =>  'Admin',
        //     'email'             =>  'lppm@machung.ac.id',
        //     'password'          =>  Hash::make('admlppm99'),
        //     'remember_token'    =>  Str::random(10),
        // ]);
    }
}
