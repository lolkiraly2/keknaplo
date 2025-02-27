<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grouphike extends Model
{
    use HasFactory;
    protected $guarded = ['created_at', 'updated_at'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function Customroute(){
        return $this->belongsTo(CustomRoute::class);
    }

    public function participant(){
        return $this->Hasmany(GrouphikeParticipant::class);
    }

    public function comments(){
        return $this->Hasmany(GrouphikeComment::class);
    }
}
