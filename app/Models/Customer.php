<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'birth_date',
        'is_premium',
    ];

    protected $dates=['birth_date', 'created_at', 'updated_at'];

    protected $casts = [
        'is_premium' => 'boolean',
    ];

    // Agregar al modelo Customer
public function reviews()
{
    return $this->hasMany(Review::class);
}
}
