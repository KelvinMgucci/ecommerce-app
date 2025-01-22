<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    // Allow mass assignment for user_id and product_id
    protected $fillable = ['user_id', 'product_id'];

    // Relationship to the User model
    public function user(){
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    // Relationship to the Product model
    public function product(){
        return $this->hasOne('App\Models\Product', 'id', 'product_id');
    }
}


