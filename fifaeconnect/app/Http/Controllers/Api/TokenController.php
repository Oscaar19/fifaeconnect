<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Log;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class TokenController extends Controller
{
    public function register(Request $request){

        // Validar dades del formulari
        $validatedData = $request->validate([
            'nom'        => 'required|string',
            'cognom'     => 'required|string',
            'email'      => 'required|string',
            'password'   => 'required|string',
        ]);

        Log::debug("He validado los datos");
        // Obtenir dades del formulari
        $nom         = $request->get('nom');
        $cognom      = $request->get('cognom');
        $email       = $request->get('email');
        $password    = $request->get('password');

        $user = User::create([
            'nom'      => $nom,
            'cognom'   => $cognom,
            'email'    => $email,
            'password' => Hash::make($password),
        ]);

        $user->assignRole('usuari');

        // Generate new token
        $token = $user->createToken("authToken")->plainTextToken;
        // Token response
        return response()->json([
            "success"   => true,
            "authToken" => $token,
            "tokenType" => "Bearer"
        ], 200);
    }

    public function user(Request $request)
    {
        $user = User::find($request->user()->id);
        
        return response()->json([
            "success" => true,
            "user"    => $user,
            "roles"   => $user->getRoleNames(),
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'     => 'required|email',
            'password'  => 'required',
        ]);
        if (Auth::attempt($credentials)) {
            // Get user
            $user = User::where([
                ["email", "=", $credentials["email"]]
            ])->firstOrFail();
            // Revoke all old tokens
            $user->tokens()->delete();
            // Generate new token
            $token = $user->createToken("authToken")->plainTextToken;
            // Token response
            return response()->json([
                "success"   => true,
                "authToken" => $token,
                "tokenType" => "Bearer"
            ], 200);
        } else {
            return response()->json([
                "success" => false,
                "message" => "Invalid login credentials"
            ], 401);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            "success" => true,
            "message" => "Any problem during logout"
        ]);
    }
}
