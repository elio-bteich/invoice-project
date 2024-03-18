<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'description',
        'price',
    ];

    public function invoice_items() {
        return $this->hasMany(InvoiceItem::class, 'item_id');
    }

    public function invoices() {
        return $this->belongsToMany(Invoice::class, 'invoice_items', 'item_id', 'invoice_id');
    }
}
