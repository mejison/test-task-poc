<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = ['ItemMasterHeader', 'ItemLocation', 'GlobalItem', 'ItemList', 'WarrantyInfo', 'HUBSupplier', 'ContentQualityClassCode'];
    
    protected $casts = [
        'ItemMasterHeader' => 'json',
        'ItemLocation' => 'json',
        'GlobalItem' => 'json',
        'ItemList' => 'json',
        'WarrantyInfo' => 'json',
    ];
}
