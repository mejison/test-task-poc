<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductRelationship extends Model
{
    use HasFactory;

    protected $fillable = ['MPN', 'PrefixNumber', 'StockNumberButted', 'Relationship'];
    
    protected $casts = [
        'Relationship' => 'json'
    ];
}
