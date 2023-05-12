<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Jugador;
use App\Models\User;
use App\Models\Club;
use App\Models\Titulacio;
use App\Models\Xarxa;

class JugadorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->only('store','update','destroy');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jugadors = User::role('jugador')->get();
        return response()->json([
            'success' => true,
            'data'    => $jugadors
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar dades del formulari
        $validatedData = $request->validate([
            'fa'            => 'required',
            'club'          => 'required',
            'foto'          => 'required|mimes:gif,jpeg,jpg,png|max:2048',
            'assoliments'   => 'array:descripcio,any',
        ]);

        $fa          = $request->get('fa');
        $club        = $request->get('club');
        $upload      = $request->file('foto');
        $assoliments = $request->get('assoliments');

        $foto = new Foto();
        $fotoOk = $foto->diskSave($upload);

        $usuari=User::find(Auth::id());
        $id_club=Club::find($club);

        if($usuari && $id_club){
            $usuari->removeRole('usuari');
            $usuari->assignRole('jugador');
            $usuari->foto_id = $foto->id;
            $usuari->save();
            foreach ($assoliments as $assoliment) {
                \Log::debug($assoliment->descripcio);
                Assoliment::create([
                    'descripcio'        => $assoliment->descripcio,
                    'any'               => $assoliment->any,
                    'user_id'           => Auth::id(),
                ]);
            }   
            Xarxa::create([
                'user_id'  => Auth::id(),
                'twitter'  => $twitter,
                'linkedin' => $linkedin,
            ]);

            
            // Patró PRG amb missatge d'èxit
            return response()->json([
                'success' => true,
                'data'    => $usuari
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
        $jugador=User::find($id);
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
        $jugador=User::find($id);
        if (!$jugador){
            return response()->json([
                'success' => false,
                'message' => "Jugador no trobat"
            ], 404);
        }
        else{
            $jugador->delete();
            return response()->json([
                'success' => true,
                'data'    => 'Jugador esborrat.'
            ], 200);
       
        }
    }
}
