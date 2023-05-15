<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Golden extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'goldens';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_valorador',
        'id_valorat',
    ];

}
