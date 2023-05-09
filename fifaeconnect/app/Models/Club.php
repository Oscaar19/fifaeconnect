<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    use CrudTrait;
    use HasFactory;

    public $timestamps = false;

    public function getKeyName(){
        return "id_club";
    }

    protected $fillable = [
        'nom',
        'foto',
        'manager',
    ];

    public function user()
    {
        return $this->hasMany(User::class);
    }

    public function fotoFK()
    {
        return $this->belongsTo(Foto::class,'foto');
    }

    public function managerFK()
    {
        return $this->belongsTo(Manager::class,'manager');
    }
}
