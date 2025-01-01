<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'class_id',
        'parent_id',
    ];

    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    public function class()
    {
        return $this->belongsTo(SchoolClass::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
