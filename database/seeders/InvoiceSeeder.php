<?php

namespace Database\Seeders;

use App\Models\Invoice;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Invoice::create([
            'customer_id' => 1,
            'payment_type_id' => 1,
            'generator' => 'g1',
            'currency' => 'USD',
            'total' => '254.00',
            'date' => Carbon::createFromFormat('d-m-Y', '19-2-2003')
        ]);
    }
}
