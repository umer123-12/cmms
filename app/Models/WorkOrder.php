<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkOrder extends Model
{
    protected $fillable = ['title', 'description', 'status', 'assigned_to', 'equipment_id', 'labor_hours', 'material_cost'];
    public function equipment()
{
    return $this->belongsTo(Equipment::class);
}
public function users()
{
    return $this->belongsTo(User::class);
}
}
