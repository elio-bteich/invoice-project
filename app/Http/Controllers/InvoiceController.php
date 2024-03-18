<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\PaymentType;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function show() {
        $invoice_no = count(Invoice::all()) + 1;
        $payment_types = PaymentType::all();
        return view('invoice', compact('invoice_no', 'payment_types'));
    }
}
