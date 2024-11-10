<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StampComment extends Model
{
    use HasFactory;
    protected $guarded = ['created_at', 'updated_at'];

 
    public function GetName($id){
        return User::find($id)->name;
    }
}
