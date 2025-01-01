<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'class_id',
    ];

    public function class()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function fees()
    {
        return $this->hasMany(Fee::class);
    }
}
