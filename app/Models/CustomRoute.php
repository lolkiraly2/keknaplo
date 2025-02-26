<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomRoute extends Model
{
    use HasFactory;
    protected $guarded = ['created_at', 'updated_at'];
    protected $table = 'customroutes';

    public function user(){
        return $this->belongsTo(User::class);
    }
}
