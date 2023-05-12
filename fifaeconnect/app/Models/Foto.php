<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class Foto extends Model
{
    use HasFactory;

    protected $fillable = [
        'ruta',
        'tamany',
    ];

    public function club()
    {
        return $this->hasOne(Club::class);
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function diskSave(UploadedFile $upload)
    {
        $fotoName = $upload->getClientOriginalName();
        $tamany = $upload->getSize();
        Log::debug("Storing file '{$fotoName}' ($tamany)...");
        
        // Store file at disk
        $uploadName = time() . '_' . $fotoName;
        $ruta = $upload->storeAs(
            'uploads',      // Path
            $uploadName ,   // Filename
            'public'        // Disk
        );
        
        $stored = Storage::disk('public')->exists($ruta);

        if ($stored) {
            Log::debug("Disk storage OK");
            $fullPath = Storage::disk('public')->path($ruta);
            Log::debug("File saved at {$fullPath}");
            // Update model properties
            $this->ruta = $ruta;
            $this->tamany = $tamany;
            $this->save();
            Log::debug("DB storage OK");
            return true;
        } else {
            Log::debug("Disk storage FAILS");
            return false;
        }
    }

    public function diskDelete()
    {
        Log::debug("Deleting foto '{$this->id}'...");
        Storage::disk('public')->delete($this->ruta);
        Log::debug("Disk storage OK");
        $this->delete();
        Log::debug("DB storage OK");
        return true;
    }
}
