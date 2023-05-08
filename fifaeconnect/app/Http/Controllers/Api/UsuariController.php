<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;

use App\Models\Foto;
use App\Models\User;

class UsuariController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'success' => true,
            'data'    => User::all()
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
            'cognom'     => 'required|string',
            'email'      => 'required|string',
            'password'   => 'required|string',
            'fa'         => 'boolean',
            'foto'       => 'required|mimes:gif,jpeg,jpg,png,mp4|max:2048',
        ]);

        Log::debug("He validado los datos");
        // Obtenir dades del formulari
        $nom         = $request->get('nom');
        $cognom      = $request->get('cognom');
        $email       = $request->get('email');
        $password    = $request->get('password');
        $fa          = $request->get('fa');
        $upload      = $request->file('foto');

        $foto = new Foto();
        $fotoOk = $foto->diskSave($upload);
        Log::debug("He creado la foto en su tabla");

        if ($fotoOk) {
            // Desar dades a BD
            $usuari = User::create([
                'nom'      => $nom,
                'cognom'   => $cognom,
                'email'    => $email,
                'password' => $password,
                'fa'       => $fa,
                'foto'     => $foto->id_foto,
            ]);
            // Patró PRG amb missatge d'èxit
            return response()->json([
                'success' => true,
                'data'    => $usuari
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
        $user=User::where('id_usuari', '=',$id)->first();
        if (!$user){
            return response()->json([
                'success' => false,
                'message' => "User not found"
            ], 404);
        }
        else{
            return response()->json([
                'success' => true,
                'data'    => $user
            ], 200);
       
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $user=User::where('id_usuari', '=',$id)->first();

        if ($user){
            // Validar dades del formulari
            $validatedData = $request->validate([
                'nom'        => 'required|string',
                'cognom'     => 'string',
                'email'      => 'required|string',
                'password'   => 'required|string',
                'fa'         => 'boolean',
                'foto'       => 'required|mimes:gif,jpeg,jpg,png,mp4|max:2048',
            ]);
            
            // Obtenir dades del formulari
            $nom         = $request->get('nom');
            $cognom      = $request->get('cognom');
            $email       = $request->get('email');
            $password    = $request->get('password');
            $fa          = $request->get('fa');
            $upload      = $request->file('foto');            

            // Desar fitxer al disc i inserir dades a BD
            $foto = new Foto();
            $fotoOk = $foto->diskSave($upload);

            if ($fotoOk) {
                // Desar dades a BD
                $user->nom = $nom;
                $user->cognom = $cognom;
                $user->email = $email;
                $user->password = $password;
                $user->fa = $fa;
                $user->foto = $foto->id_foto;
                $user->save();
                // Patró PRG amb missatge d'èxit
                return response()->json([
                    'success' => true,
                    'data'    => $user
                ], 201); 
            }
            else{
                return response()->json([
                    'success'  => false,
                    'message' => 'Error desant'
                ], 500);
            }               
        } else {
            return response()->json([
                'success' => false,
                'message' => "Usuari no trobat"
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
    public function destroy(string $id)
    {
        $user=User::where('id_usuari', '=',$id)->first();
        if (!$user){
            return response()->json([
                'success' => false,
                'message' => "Usuari no trobat"
            ], 404);
        }
        else{
            $user->delete();
            $user->fotoFK->diskDelete();
            return response()->json([
                'success' => true,
                'data'    => 'Usuari esborrat.'
            ], 200);
       
        }
    }
}
