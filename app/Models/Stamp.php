<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stamp extends Model
{
    use HasFactory;
    protected $guarded = ['created_at', 'updated_at'];

    public function stage(){
        return $this->belongsTo(Stage::class);
    }
}
