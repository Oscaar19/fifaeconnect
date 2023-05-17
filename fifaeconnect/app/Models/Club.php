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

    protected $fillable = [
        'nom',
        'foto_id',
    ];

    public function fotoFK()
    {
        return $this->belongsTo(Foto::class,'foto_id');
    }

    public function managerFK()
    {
        return $this->belongsTo(Manager::class,'manager');
    }
}
