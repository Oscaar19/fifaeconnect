<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\Manager;
use App\Models\User;
use App\Models\Titulacio;
use App\Models\Xarxa;

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
        return response()->json([
            'success' => true,
            'data'    => Manager::all()
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar dades del formulari
        $validatedData = $request->validate([
            'titulacions'   => 'required|array',
            'xarxes'        => 'required',
        ]);

        Log::debug("He validado los datos");

        $titulacions = $request->get('titulacions');
        $xarxes = $request->get('xarxes');

        Log::debug($id_usuari);
        Log::debug($titulacions);
        Log::debug($xarxes);

        $id_usuari = $request->user()->id;
        $usuari=User::where('id_usuari', '=',$id_usuari)->first();

        if($usuari){
            // Desar dades a BD
            $manager = Manager::create([
                'usuari'   => $id_usuari,
            ]);
            $manager=Manager::where('usuari', '=',$id_usuari)->first();
            foreach ($titulacions as $titulacio) {
                Titulacio::create([
                    'manager_id'        => $manager->id_manager,
                    'descripcio'        => $titulacio->descripcio,
                    'any_finalitzacio'  => $titulacio->any_finalitzacio,
                ]);
            }   
            
            Xarxa::create([
                'twitter' => $xarxes->twitter,
                'linkedin' => $xarxes->linkedin,
            ]);

            $usuari->assignRole('manager');
            // Patró PRG amb missatge d'èxit
            return response()->json([
                'success' => true,
                'data'    => $manager
            ], 201);
        }else{
            return response()->json([
                'success' => false,
                'message' => "User not found"
            ], 404);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $manager=Manager::where('id_manager', '=',$id)->first();
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
        $manager=Manager::where('id_manager', '=',$id)->first();

        if ($manager){
            // Validar dades del formulari
            $validatedData = $request->validate([
                'usuari'     => 'required',
            ]);
            
            // Obtenir dades del formulari
            $usuari = $request->get('usuari');         

            $manager->usuari = $usuari;
            $manager->save();
            // Patró PRG amb missatge d'èxit
            return response()->json([
                'success' => true,
                'data'    => $manager
            ], 201);             
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
