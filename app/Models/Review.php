<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'customer_id',
        'rating',
        'comment',
        'is_verified_purchase',
        'reviewed_at'
    ];

    protected $casts = [
        'is_verified_purchase' => 'boolean',
        'reviewed_at' => 'datetime',
    ];

    // Relaciones
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}