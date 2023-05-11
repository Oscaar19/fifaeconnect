<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

class Role extends Model
{
    use HasFactory;
    use CrudTrait;

    protected $table = 'roles';
    protected $timestamps = false;
    
    protected $fillable = [
        'id',
        'nom',
    ];

    const USUARI = 'usuari';
    const COACH = 'coach';
    const MANAGER = 'manager';
    const JUGADOR = 'jugador';

    public function usuaris(){
        return $this->hasMany(Usuari::class,'id_usuari');
    }
}
