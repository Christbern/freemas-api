<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                "name" => "Super Admin",
                "email" => "vicairemanfouo@gmail.com",
                "phone" => "+237699458312",
                "password" => "$2y$10$5lQATLlEJyzjgPovHFIJoOo.af3DbqrDps49zKtd/F5V3sX3W0KLm",
            ],
        ];

        foreach ($users as $key => $user) {
            $existUser = User::where('email', $user['email'])->orWhere('phone', $user['phone'])->exists();

            if(!$existUser){
                User::create($user);
            }
        }
    }
}
