<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_name', 
        'address1',
        'address2', 
        'city',
        'state',
        'country', 
        'latitude',
        'longitude',
        'phone_no1',
        'phone_no2',
        'zip',
        'start_validity',
        'end_validity',
        'status'
    ];

    protected $appends = [
        'totalUser'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'id', 'client_id');
    }

    public function getTotalUserAttribute() {
        $hasUser = $this->user();
        return [
            'all' =>  $hasUser ?  $this->user()->count() : 0,
            'active' =>  $hasUser ?  $this->user()->where('status', 'Active')->count() : 0,
            'inactive' =>  $hasUser ?  $this->user()->where('status', 'Inactive')->count() : 0,
        ];
    }
}