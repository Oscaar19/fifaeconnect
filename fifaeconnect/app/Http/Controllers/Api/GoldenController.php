<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GoldenController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->only('index');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $goldens = DB::table('goldens')->where('id_valorador', Auth::id())->get();

        return response()->json([
            'success' => true,
            'data'    => $goldens
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
