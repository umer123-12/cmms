<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PreventiveMaintenance extends Model
{
     protected $fillable = [
        'equipment_id',
        'title',
        'type',
        'interval_days',
        'interval_usage',
        'last_maintenance_date',
        'next_due_date',
        'starts_at',
        'ends_at'
    ];
    public function equipment()
{
    return $this->belongsTo(Equipment::class); // Make sure Equipment model exists
}
}
