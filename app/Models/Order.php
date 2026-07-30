<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'service_type',
        'weight',
        'total_price',
        'order_status',
        'order_date',
        'payment_proof',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
