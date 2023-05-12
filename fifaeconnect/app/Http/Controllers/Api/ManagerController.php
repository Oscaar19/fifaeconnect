<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\Titulacio;
use App\Models\Xarxa;
use App\Models\Foto;

class ManagerController extends Controller
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
        $managers = User::role('manager')->get();
        return response()->json([
            'success' => true,
            'data'    => $managers
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
            'titulacions'     => 'required',
        ]);

        Log::debug("He validado los datos");


        $titulacionsStr = $request->get('titulacions');
        $titulacions = json_decode($titulacionsStr,true);


        $upload      = $request->file('foto');
        $twitter     = $request->get('twitter');
        $linkedin    = $request->get('linkedin');

        $foto = new Foto();
        $fotoOk = $foto->diskSave($upload);

        $usuari=User::find(Auth::id());

        if($usuari && $fotoOk){
            $usuari->removeRole('usuari');
            $usuari->assignRole('manager');
            $usuari->foto_id = $foto->id;
            $usuari->save();
            foreach ($titulacions as $titulacio) {
                Titulacio::create([
                    'user_id'           => Auth::id(),
                    'descripcio'        => $titulacio["descripcio"],
                    'any_finalitzacio'  => $titulacio["any_finalitzacio"],
                ]);
            }   
            \Log::debug("He creado las titulaciones");
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
        $manager=User::find($id);
        if (!$manager){
            return response()->json([
                'success' => false,
                'message' => "Manager not found"
            ], 404);
        }
        else{
            return response()->json([
                'success' => true,
                'data'    => $manager
            ], 200);
       
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $manager=User::find($id);

        if ($manager){
            // Validar dades del formulari
            $validatedData = $request->validate([
                'twitter'         => 'string',
                'linkedin'        => 'string',
                'foto'            => 'required|mimes:gif,jpeg,jpg,png|max:2048',
                'titulacions'     => 'array:descripcio,any_finalitzacio',
            ]);

            Log::debug("He validado los datos");


            $titulacions = $request->get('titulacions');
            $upload      = $request->file('foto');
            $twitter     = $request->get('twitter');
            $linkedin    = $request->get('linkedin');     
            
            $foto=Foto::find($manager->foto_id);
            $fileOk = $foto->diskSave($upload);
            
            if($fotoOk){
                $xarxes = DB::table('xarxes')->where('user_id', $manager->id)->get();
                $xarxes->twitter = $twitter;
                $xarxes->linkedin = $linkedin;
                $xarxes->save();

                foreach ($titulacions as $titulacio) {
                    \Log::debug($titulacio->descripcio);
                    Titulacio::create([
                        'user_id'           => Auth::id(),
                        'descripcio'        => $titulacio->descripcio,
                        'any_finalitzacio'  => $titulacio->any_finalitzacio,
                    ]);
                }  
                // Patró PRG amb missatge d'èxit
                return response()->json([
                    'success' => true,
                    'data'    => $manager
                ], 201);

            }             
        } else {
            return response()->json([
                'success' => false,
                'message' => "Manager no trobat"
            ], 404);
           
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $manager=Manager::where('id_manager', '=',$id)->first();
        if (!$manager){
            return response()->json([
                'success' => false,
                'message' => "Manager no trobat"
            ], 404);
        }
        else{
            $manager->delete();
            return response()->json([
                'success' => true,
                'data'    => 'Manager esborrat.'
            ], 200);
       
        }
    }
}
