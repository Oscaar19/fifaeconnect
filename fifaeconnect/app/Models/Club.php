<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function getKeyName(){
        return "id_club";
    }

    protected $fillable = [
        'nom',
        'foto',
        'id_manager',
    ];

    public function user()
    {
        return $this->hasMany(User::class);
    }

    public function foto()
    {
        return $this->belongsTo(Foto::class);
    }
}
