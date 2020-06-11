<?php

use App\User;
use App\Listing;
use Illuminate\Database\Seeder;

class ListingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Listing::truncate();

        $farmer = User::where('user_type', 'farmer')->first();

        $farmer->listings()->create([
            'produce' => 'Eggs',
            'location' => 'Jos',
            'buy_sell' => 'sell',
            'quantity' => 15,
            'unit' => 'crates',
            'unit_price' => 900,
            'filled' => false,
        ]);

        $farmer->listings()->create([
            'produce' => 'Yams',
            'location' => 'Zaki Biam',
            'buy_sell' => 'sell',
            'quantity' => 300,
            'unit' => 'tubers',
            'unit_price' => 300,
            'filled' => false,
        ]);

        $farmer->listings()->create([
            'produce' => 'Spinach',
            'location' => 'Kaduna',
            'buy_sell' => 'sell',
            'quantity' => 150,
            'unit' => 'kg',
            'unit_price' => 750,
            'filled' => false,
        ]);

        $buyer = User::where('user_type', 'buyer')->first();

        $buyer->listings()->create([
            'produce' => 'Eggs',
            'location' => 'Abuja',
            'buy_sell' => 'buy',
            'quantity' => 15,
            'unit' => 'crates',
            'unit_price' => 900,
            'filled' => false,
        ]);

        $buyer->listings()->create([
            'produce' => 'Yams',
            'location' => 'Abuja',
            'buy_sell' => 'buy',
            'quantity' => 300,
            'unit' => 'tubers',
            'unit_price' => 300,
            'filled' => false,
        ]);

        $buyer->listings()->create([
            'produce' => 'Spinach',
            'location' => 'Abuja',
            'buy_sell' => 'buy',
            'quantity' => 150,
            'unit' => 'kg',
            'unit_price' => 750,
            'filled' => false,
        ]);
    }
}
