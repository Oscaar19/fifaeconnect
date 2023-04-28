<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'id_foto',
    ];

    public function user()
    {
        return $this->hasMany(User::class);
    }

    public function file()
    {
        return $this->belongsTo(File::class);
    }
}
