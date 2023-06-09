<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\Jugador;
use App\Models\User;
use App\Models\Club;
use App\Models\Assoliment;
use App\Models\Xarxa;
use App\Models\Foto;

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
            'twitter'         => 'string',
            'linkedin'        => 'string',
            'foto'            => 'required|mimes:gif,jpeg,jpg,png|max:2048',
            'fa'              => 'boolean',
            'club_id'         => 'nullable',
            'assoliments'     => 'required',
        ]);

        Log::debug("He validado los datos");


        $assolimentsStr = $request->get('assoliments');
        $assoliments = json_decode($assolimentsStr,true);


        $upload      = $request->file('foto');
        $twitter     = $request->get('twitter');
        $linkedin    = $request->get('linkedin');
        $club_id     = $request->get('club_id');
        $fa          = $request->get('fa');

        $foto = new Foto();
        $fotoOk = $foto->diskSave($upload);

        $usuari=User::find(Auth::id());

        if($usuari && $fotoOk){
            $usuari->removeRole('usuari');
            $usuari->assignRole('jugador');
            $usuari->foto_id = $foto->id;
            $usuari->club_id = $club_id;
            $usuari->fa      = $fa;
            $usuari->save();
            foreach ($assoliments as $assoliment) {
                Assoliment::create([
                    'descripcio'        => $assoliment["descripcio"],
                    'any'               => $assoliment["any"],
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
        $foto=Foto::where('id', '=', $jugador->foto_id)->first();
        $assoliments=Assoliment::where('user_id', '=', $jugador->id)->get();
        $xarxes=Xarxa::where('user_id', '=', $jugador->id)->first();
        
        if (!$jugador){
            return response()->json([
                'success' => false,
                'message' => "Jugador not found"
            ], 404);
        }
        else{
            return response()->json([
                'success'           => true,
                'jugador'           => $jugador,
                'foto'              => $foto,
                'assoliments'       => $assoliments,
                'xarxes'            => $xarxes,
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

    public function jugadorsFA()
    {
        $jugadors=User::role('jugador')->where('fa', '=', true)->get();
        return response()->json([
            'success' => true,
            'data'    => $jugadors
        ], 200);
    }
}
