<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatalogItem extends Model
{
    use HasFactory;

    protected $fillable = ['catalog_id', 'Item', 'UOMCode', 'ItemPrice', 'Note'];

    protected $casts = [
        'Item' => 'json',
        'ItemPrice' => 'json',
        'Note' => 'json'
    ];
}
