<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assoliment extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'assoliments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'descripcio',
        'any',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
