<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'invoice_number',
        'invoice_date',
        'due_date',
        'user_id'
    ];

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }
}
