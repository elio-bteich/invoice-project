<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'item_id',
        'quantity',
    ];

    public function item() {
        return $this->belongsTo(Item::class, 'item_id');
    }

    public function invoice() {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }
}
