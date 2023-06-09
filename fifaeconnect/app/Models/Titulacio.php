<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Titulacio extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'titulacions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'descripcio',
        'any_finalitzacio',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
