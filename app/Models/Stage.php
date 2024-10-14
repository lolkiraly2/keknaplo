<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    use HasFactory;
    protected $guarded = ['created_at', 'updated_at'];

    public function stamps(){
        return $this->hasMany(Stamp::class);
    }

    public function cpoints(){
        return $this->hasMany(Cpoint::class);
    }

    public function hike(){
        return $this->belongsTo(Hike::class);
    }
}
