<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Debugbar;

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
            'nom'       => 'required|string',
            'foto'      => 'required|mimes:gif,jpeg,jpg,png,mp4|max:2048',
            'manager'   => 'required',
        ]);

        Log::debug("He validado los datos");
        // Obtenir dades del formulari
        $nom        = $request->get('nom');
        $manager    = $request->get('manager');
        $upload     = $request->file('foto');

        $foto = new Foto();
        $fotoOk = $foto->diskSave($upload);

        if ($fotoOk) {
            // Desar dades a BD
            $club = Club::create([
                'nom'        => $nom,
                'foto'       => $foto->id_foto,
                'manager'    => $manager,
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
    public function show($id)
    {
        $club=Club::where('id_club', '=',$id)->first();
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
    public function update(Request $request,$id)
    {
        
        $club=Club::where('id_club', '=',$id)->first();

        if ($club){
            // Validar dades del formulari
            $validatedData = $request->validate([
                'nom'        => 'required|string',
                'foto'      => 'required|mimes:gif,jpeg,jpg,png,mp4|max:2048',
                'manager'   => 'required',
            ]);
            
            // Obtenir dades del formulari
            $nom        = $request->get('nom');
            $manager    = $request->get('manager');
            $upload     = $request->file('foto');            

            // Desar fitxer al disc i inserir dades a BD
            $foto=Foto::where('id_foto', '=',$club->foto)->first();
            
            $fotoOk = $foto->diskSave($upload);

            if ($fotoOk) {
                // Desar dades a BD
                $club->nom = $nom;
                $club->manager = $manager;
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

    public function update_workaround(Request $request, $id)
    {
        return $this->update($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $club=Club::where('id_club', '=',$id)->first();
        if (!$club){
            return response()->json([
                'success' => false,
                'message' => "Club no trobat"
            ], 404);
        }
        else{
            $club->delete();
            $club->fotoFK->diskDelete();
            return response()->json([
                'success' => true,
                'data'    => 'Club esborrat.'
            ], 200);
       
        }
    }
}
