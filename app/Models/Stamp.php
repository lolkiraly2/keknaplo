<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Stamp extends Model
{
    use HasFactory;
    protected $guarded = ['created_at', 'updated_at'];

    public function stage()
    {
        return $this->belongsTo(Stage::class);
    }

    protected static function boot()
    {
        parent::boot();

        // Order by name ASC
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('mtsz_id', 'asc');
        });
    }
}
