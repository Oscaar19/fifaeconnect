<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Xarxa extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function getKeyName(){
        return "id_xarxa";
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'twitter',
        'linkedin',
    ];

    public function userFK()
    {
        return $this->belongsTo(User::class,'id_usuari');
    }
}
