<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manager extends Model
{
    use CrudTrait;
    use HasFactory;

    public $timestamps = false;

    public function getKeyName(){
        return "id_manager";
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'usuari',
    ];

    public function club()
    {
        return $this->hasOne(Club::class);
    }

}
