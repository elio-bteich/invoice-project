<?php

namespace Database\Seeders;

use App\Models\InvoiceItem;
use Illuminate\Database\Seeder;

class InvoiceItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        InvoiceItem::create([
            'invoice_id' => 1,
            'item_id' => 1,
            'quantity' => 2
        ]);
    }
}
