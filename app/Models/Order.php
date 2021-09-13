<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public function shipments() {
        return $this->hasMany(Shipment::class, 'id', 'shipment_id');
    }

    public function invoice() {
        return $this->hasOne(Invoice::class, 'id', 'order_id');
    }
}
