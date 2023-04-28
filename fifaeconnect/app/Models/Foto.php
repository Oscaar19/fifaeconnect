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

    public function diskSave(UploadedFile $upload)
    {
        $fotoName = $upload->getClientOriginalName();
        $fotoSize = $upload->getSize();
        Log::debug("Storing file '{$fotoName}' ($fotoSize)...");
        
        // Store file at disk
        $uploadName = time() . '_' . $fotoName;
        $fotoPath = $upload->storeAs(
            'uploads',      // Path
            $uploadName ,   // Filename
            'public'        // Disk
        );
        
        $stored = Storage::disk('public')->exists($fotoPath);

        if ($stored) {
            Log::debug("Disk storage OK");
            $fullPath = Storage::disk('public')->path($fotoPath);
            Log::debug("File saved at {$fullPath}");
            // Update model properties
            $this->fotoPath = $fotoPath;
            $this->fotoSize = $fotoSize;
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
        Log::debug("Deleting file '{$this->id}'...");
        Storage::disk('public')->delete($this->fotopath);
        Log::debug("Disk storage OK");
        $this->delete();
        Log::debug("DB storage OK");
        return true;
    }
}
