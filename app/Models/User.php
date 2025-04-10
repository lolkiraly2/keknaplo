<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function stampComments(){
        return $this->Hasmany(StampComment::class);
    }

    public function cpoints(){
        return $this->Hasmany(Cpoint::class);
    }

    public function croutes(){
        return $this->Hasmany(CustomRoute::class);
    }

    public function mygrouphikes(){
        return $this->Hasmany(Grouphike::class);
    }

    public function joinedhikes(){
        return $this->Hasmany(GrouphikeParticipant::class);
    }

    public function bluehikes(){
        return $this->Hasmany(BlueHike::class);
    }
}
