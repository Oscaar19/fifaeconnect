<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Jugador;
use App\Models\User;
use App\Models\Club;

class JugadorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'success' => true,
            'data'    => Jugador::all()
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar dades del formulari
        $validatedData = $request->validate([
            'usuari'        => 'required',
            'club_actual'   => 'required',
        ]);

        $usuari = $request->get('usuari');
        $club   = $request->get('club_actual');

        $id_usuari=User::where('id_usuari', '=',$usuari)->first();
        $id_club=Club::where('id_club', '=',$club)->first();

        if($id_usuari && $id_club){
            // Desar dades a BD
            $jugador = Jugador::create([
                'usuari'      => $usuari,
                'club_actual' => $club,
            ]);
            // Patró PRG amb missatge d'èxit
            return response()->json([
                'success' => true,
                'data'    => $jugador
            ], 201);
        }else{
            return response()->json([
                'success' => false,
                'message' => "User or Club not found"
            ], 404);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $jugador=Jugador::where('id_jugador', '=',$id)->first();
        if (!$jugador){
            return response()->json([
                'success' => false,
                'message' => "Jugador not found"
            ], 404);
        }
        else{
            return response()->json([
                'success' => true,
                'data'    => $jugador
            ], 200);
       
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    public function update_workaround(Request $request, $id)
    {
        return $this->update($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
