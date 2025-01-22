<?php

// app/Models/Order.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // Define the fillable fields for mass-assignment
    protected $fillable = [
        'user_id', 
        'product_id', 
        'name', 
        'rec_address', 
        'phone', 
        'status'
    ];

    // Define relationships with User and Product models
    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    public function product()
    {
        return $this->hasOne('App\Models\Product', 'id', 'product_id');
    }
}

