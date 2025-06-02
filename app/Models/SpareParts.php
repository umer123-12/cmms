<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpareParts extends Model
{
    protected $fillable = ['name', 'part_number', 'stock', 'min_stock_level', 'equipment_id'];

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }
}
