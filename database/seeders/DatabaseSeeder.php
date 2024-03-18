<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $seeders = [
            PaymentTypeSeeeder::class,
            CustomerSeeder::class,
            ItemSeeder::class,
            InvoiceSeeder::class,
            InvoiceItemSeeder::class
        ];
        foreach ($seeders as $seeder) {
            $this->call( $seeder);
        }
    }
}
