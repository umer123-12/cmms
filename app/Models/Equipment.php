<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;


class Equipment extends Model implements HasMedia
{
    use InteractsWithMedia;
     protected $fillable = [
        'name',
        'type',
        'manufacturer',
        'serial_number',
        'purchase_date',
        'value',
        'location',
        'status',
        'warranty_expiry',
    ];
}
