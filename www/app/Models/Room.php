<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Student;

class Room extends Model
{
    protected $fillable = [
        'room_number',
        'floor',
        'capacity',
    ];

    public function students(){
        return $this->hasMany(Student::class);
    }
}
