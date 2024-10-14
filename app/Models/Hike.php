<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hike extends Model
{
    use HasFactory;
    protected $guarded = ['created_at', 'updated_at'];

    public function stages(){
        return $this->hasMany(Stage::class);
    }

    public function stamps(){
        return  $this->hasManyThrough(Stamp::class,Stage::class);
    }
}
