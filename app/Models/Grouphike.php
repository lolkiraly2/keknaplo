<?php

namespace App\Models;

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public function participants(){
        return $this->Hasmany(GrouphikeParticipant::class);
    }

    public function comments(){
        return $this->Hasmany(GrouphikeComment::class);
    }

    public function setPasswordAttribute($value)
    {
        if($value != null){
            $this->attributes['password'] = Hash::make($value);
        }  
    }
}
