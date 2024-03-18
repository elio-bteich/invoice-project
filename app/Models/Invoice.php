<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'payment_type_id',
        'generator',
        'currency',
        'total',
        'date',
    ];

    public function payment_type() {
        return $this->belongsTo(PaymentType::class);
    }

    public function customer() {
        return $this->belongsTo(Customer::class);
    }

    public function invoice_items() {
        return $this->hasMany(InvoiceItem::class, 'invoice_id');
    }

    public function items() {
        return $this->belongsToMany(Item::class, 'invoice_items', 'invoice_id', 'item_id');
    }
}
