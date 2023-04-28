<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;

use App\Models\Foto;
use App\Models\Club;

class ClubController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'success' => true,
            'data'    => Club::all()
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // Validar dades del formulari
        $validatedData = $request->validate([
            'nom'        => 'required|string',
            'foto'      => 'required|mimes:gif,jpeg,jpg,png,mp4|max:2048',
        ]);

        // Obtenir dades del formulari
        $nom        = $request->get('nom');
        $upload      = $request->file('foto');

        $foto = new Foto();
        $fotoOk = $foto->diskSave($upload);

        if ($fotoOk) {
            // Desar dades a BD
            $club = Club::create([
                'nom'        => $nom,
                'file_id'     => $foto->id,
            ]);
            // Patró PRG amb missatge d'èxit
            return response()->json([
                'success' => true,
                'data'    => $club
            ], 201);
        } else {
            return response()->json([
                'success'  => false,
                'message' => 'Error durant la pujada de la foto.'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $club=Club::find($id);
        if (!$club){
            return response()->json([
                'success' => false,
                'message' => "Club not found"
            ], 404);
        }
        else{
            return response()->json([
                'success' => true,
                'data'    => $club
            ], 200);
       
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $club=Club::find($id);

        if ($club){
            // Validar dades del formulari
            $validatedData = $request->validate([
                'nom'        => 'required|string',
                'foto'      => 'required|mimes:gif,jpeg,jpg,png,mp4|max:2048',
            ]);
            
            // Obtenir dades del formulari
            $nom        = $request->get('nom');
            $upload      = $request->file('foto');            

            // Desar fitxer al disc i inserir dades a BD
            $foto=Foto::find($club->id_foto);
            $fotoOk = $foto->diskSave($upload);

            if ($fotoOk) {
                // Desar dades a BD
                $club-> nom = $nom;
                $club->save();
                // Patró PRG amb missatge d'èxit
                return response()->json([
                    'success' => true,
                    'data'    => $club
                ], 201); 
            }
            else{
                return response()->json([
                    'success'  => false,
                    'message' => 'Error desant el club'
                ], 500);
            }               
        } else {
            return response()->json([
                'success' => false,
                'message' => "Club no trobat"
            ], 404);
           
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $club=Club::find($id);
        if (!$club){
            return response()->json([
                'success' => false,
                'message' => "Club no trobat"
            ], 404);
        }
        else{
            $club->delete();
            return response()->json([
                'success' => true,
                'data'    => 'Club esborrat.'
            ], 200);
       
        }
    }
}
