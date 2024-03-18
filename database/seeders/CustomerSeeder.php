<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Customer::create([
            'name' => 'Elio Bteich',
            'address' => 'Kfardebian',
            'mof' => '123123',
            'phone_number' => '76002589'
        ]);

        Customer::create([
            'name' => 'Elissa Khoury',
            'address' => 'Jounieh',
            'mof' => '213412',
            'phone_number' => '71542324'
        ]);

        Customer::create([
            'name' => 'Anthony Bteich',
            'address' => 'Zouk Mosbeh',
            'mof' => '233525',
            'phone_number' => '81601226'
        ]);

    }
}
