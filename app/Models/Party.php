<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Party extends Model
{
    use HasFactory;

    protected $fillable = ['PartyIDs', 'Name', 'ChildParty', 'PartnerRoleCodes', 'VendorShortName', 'VendorAbbreviation'];

    protected $casts = [
        'PartyIDs' => 'json',
        'ChildParty' => 'json',
        'PartnerRoleCodes' => 'json',
    ];
}
