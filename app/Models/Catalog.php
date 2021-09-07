<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catalog extends Model
{
    use HasFactory;

    protected $fillable = ['Name', 'DocumentID', 'ClassificationScheme'];

    protected $casts = [
        'ClassificationScheme' => 'json',
    ];

    public function items() {
        return $this->hasMany(CatalogItem::class, 'catalog_id', 'id');
    }
}
