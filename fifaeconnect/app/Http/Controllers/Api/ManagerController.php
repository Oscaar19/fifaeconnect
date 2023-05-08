<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Manager;
use App\Models\User;

class ManagerController extends Controller
{
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
            'usuari'        => 'required',
        ]);

        $usuari = $request->get('usuari');

        $id_usuari=User::where('id_usuari', '=',$usuari)->first();

        if($id_usuari){
            // Desar dades a BD
            $manager = Manager::create([
                'usuari'   => $usuari,
            ]);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}