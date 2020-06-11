<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // User::truncate();

        $farmer = User::create([
            'name' => 'Farmer User',
            'email' => 'farmer@farmer.com',
            'username' => 'Farmer',
            'user_type' => 'farmer',
            'password' => Hash::make('password'),
        ]);

        $buyer = User::create([
            'name' => 'Buyer User',
            'email' => 'buyer@buyer.com',
            'username' => 'Buyer',
            'user_type' => 'buyer',
            'password' => Hash::make('password'),
        ]);
    }
}
