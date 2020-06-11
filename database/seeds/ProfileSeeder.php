<?php

use App\User;
use App\Profile;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Profile::truncate();

        $farmer = User::where('user_type', 'farmer')->first();

        $farmer->profile()->create([
            'profile_image' => 'profile/IYDxzSpV9MSVf0Um3lfd2j4Iq7JINy6doOIvJozD.jpeg',
            'shipping_address' => 'Flat B2, New Haven Estate, Abuja',
            'billing_address' => '9A, Rabat Street, Wuse Zone 6',
            'phone_number' => '08172284483',
        ]);

        $buyer = User::where('user_type', 'buyer')->first();

        $buyer->profile()->create([
            'profile_image' => 'profile/IYDxzSpV9MSVf0Um3lfd2j4Iq7JINy6doOIvJozD.jpeg',
            'shipping_address' => 'Flat B2, New Haven Estate, Abuja',
            'billing_address' => '9A, Rabat Street, Wuse Zone 6',
            'phone_number' => '08079812422',
        ]);
    }
}
