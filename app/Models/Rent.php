<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rent extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'car_id', 'customer_name', 'car_model', 'rent_price', 'rent_duration', 'rent_start', 'rent_end'];

}
