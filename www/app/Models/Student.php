<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Room;

class Student extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'room_id',
    ];

    public function room(){
        $this->belongsTo(Room::class);
    }
}



