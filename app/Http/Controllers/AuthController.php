<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
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
        ],[
            "email.required" => "The email is required, please enter your email address",
            "email.string" => "Email must be a text",
            "password.min"=> "The password must be at least 5 characters"
        ]);

        $user = User::where('email', $request->email)->first();
        if($user && Hash::check($request->password, $user->password)) {
            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json([
                'data' => $token,
                "success" => true,
            ]);
        }
        else{
            return response()->json([
                'data' => 'Something went wrong',
                "success" => false,
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $token)
    {
        try{
        $user = User::where("remember_token", $token)->first();
        return response()->json([
            "data" => $user,
        ]);
        }
        catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage(),
                'success'=> false,
            ]);
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
