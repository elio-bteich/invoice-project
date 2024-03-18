<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Item::create([
            'code' => 'ABCDE',
            'description' => 'Oil from Holland',
            'price' => 69
        ]);
    }
}
