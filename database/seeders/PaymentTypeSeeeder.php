<?php

namespace Database\Seeders;

use App\Models\PaymentType;
use Illuminate\Database\Seeder;

class PaymentTypeSeeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $payment_types = [
            ['description' => 'cash'],
            ['description' => 'check'],
            ['description' => 'credit'],
            ['description' => 'other'],
        ];
        foreach ($payment_types as $payment_type) {
            PaymentType::create($payment_type);
        }
    }
}
