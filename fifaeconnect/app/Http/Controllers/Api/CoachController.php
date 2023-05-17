<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\Experiencia;
use App\Models\Xarxa;
use App\Models\Foto;

class CoachController extends Controller
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
        $coaches = User::role('coach')->get();
        return response()->json([
            'success' => true,
            'data'    => $coaches
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
            'club_id'         => 'string',
            'experiencies'    => 'required',
        ]);

        Log::debug("He validado los datos");


        $experienciesStr = $request->get('experiencies');
        $experiencies = json_decode($experienciesStr,true);


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
            $usuari->assignRole('coach');
            $usuari->foto_id = $foto->id;
            $usuari->club_id = $club_id;
            $usuari->fa      = $fa;
            $usuari->save();
            foreach ($experiencies as $experiencia) {
                Experiencia::create([
                    'user_id'           => Auth::id(),
                    'descripcio'        => $experiencia["descripcio"],
                ]);
            }   
            \Log::debug("He creado las experiencias");
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
                'message' => "Error."
            ], 404);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $coach=User::find($id);
        $foto=Foto::where('id', '=', $coach->foto_id)->first();
        $experiencies=Experiencia::where('user_id', '=', $coach->id)->get();
        $xarxes=Xarxa::where('user_id', '=', $coach->id)->first();
        
        if (!$coach){
            return response()->json([
                'success' => false,
                'message' => "Coach not found"
            ], 404);
        }
        else{
            return response()->json([
                'success'           => true,
                'coach'             => $coach,
                'foto'              => $foto,
                'experiencies'      => $experiencies,
                'xarxes'            => $xarxes,
            ], 200);
       
        }
    }

    public function coachesFA()
    {
        $coaches=User::role('coach')->where('fa', '=', true)->get();
        return response()->json([
            'success' => true,
            'data'    => $coaches
        ], 200);
    }
}
