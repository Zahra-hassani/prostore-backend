<?php

namespace App\Http\Controllers;

use App\Models\User;
use Hash;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate([
            'email' => 'required|string|min:3',
            'password'=> 'required|string|min:5'
        ]);
        $users = User::all();
        foreach ($users as $user) {
            if ($user->email == $request->email && Hash::check($request->password, $user->password)) {
                return response()->json([
                    'message' => "The credentials you added matches to this user ".$user->name
                ]);
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' =>'required|string|min:3',
            'password' =>'required|string|min:5'
        ]);

        $user = User::where('email', $request->email)->first();
        if($user && Hash::check($request->password, $user->password)) {
            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json([
                'data' => $token
            ]);
        }
        else{
            return response()->json([
                'message' => 'Something went wrong'
            ]);
        }
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
