<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageWa extends Model
{
    use HasFactory;

    public function msgHasJawaban(){
        return $this->hasMany(MessageHasJawaban::class, "message_id", "id");
    }
}
