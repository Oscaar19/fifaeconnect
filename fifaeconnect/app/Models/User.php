<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use \Backpack\CRUD\app\Models\Traits\CrudTrait;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,CrudTrait,HasRoles;

    public $timestamps = false;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nom',
        'cognom',
        'email',
        'password',
        'foto_id',
        'fa',
        'club_id',
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function fotoFK()
    {
        return $this->belongsTo(Foto::class,'foto_id');
    }

    public function club()
    {
        return $this->belongsTo(Foto::class,'club_id');
    }
    
    public function titulacions()
    {
        return $this->hasMany(Titulacio::class);
    }
}
